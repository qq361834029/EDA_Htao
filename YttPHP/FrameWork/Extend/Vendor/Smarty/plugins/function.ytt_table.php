<?php

/**
 * 简单列表显示
 *
 * @param array $params
 * tr_attr tbody tr属性 "class"=>["state"=>["1"=>"class_1","2"=>"class_2"]] class为数组时，依据字段state的值设定class即:state=1时class=class_1，state=2时 class=class_2    字段state可自行设定
 * show 显示列表
 * 		type:显示类型   默认为empty
 * 		value:显示值
 * 		title:显示标题
 * 		width:显示宽度
 *		show：是否显示仅当show===false不显示
 * 		attr:显示控件的其他属性	["属性"=>"属性值"]
 * 		link:需要连接  只针对empty类型 ["show"=>"是否显示仅当show===false不显示","file_url"=>"绝对地址，存在时使时使用该地址","url"=>"链接地址","link_id"=>"单个字段或者参数数组('color_name(参数)'=>'color_name(对应的参数值)')","title"=>"链接语言", "explode"=>",链接分行显示","show_title"=>'no_invoice当no_invoice>0时显示新增的链接']
 * 			 如果没有url地址 默认为查看 取link_id(数组取第一个值)解析为模块名称_id  link_id=>"orders_id" 解析后的URL：Orders/view/id/orders_id
 * 		span:加入span ["属性"=>"属性值"]
 * 		hidden:加入隐藏域 [ ["id"=>"h1",name="h1",value="h1"],["id"=>"h2","name"=>"h2","value"=>"h2"]... ]
 * 		td:td属性  class属性和tr 类似 class为数组时根据 字段设定样式
 * 		autoshow:显示autoshow  ["module"=>"autoshow执行的module","field"=>"ID","type"=>"type","show"=>"是否显示仅当show===false不显示"]
 * 		font_class:文本样式 只针对empty类型有效 "font_class"=>["state"=>["1"=>"class_1","2"=>"class_2"]]
 * 		flow_type:需要根据配置显示的流程类型 目前只有 storage_format  
 * operate 是否加入操作列 true-是   false-否 默认：true
 * expand  是否需要展开  true-需要  false-不需要  默认：false  设置true时 需要设置expandAction值
 * expandAction 展开是AJAX执行的action
 * sort    排序  ["排序字段"=>["sort_by"=>0,...]
 * 		sort_by:  0-升序  1-降序
 * 		
 * from  数据源
 * flow	 所属模块 默认为空
 * function 默认为initTable  可自行调用Ytt_Table的函数
 * listType basic:基本信息  flow:流程信息 默认:basic  区别：基本信息操作列- 编辑 作废，流程信息操作列- 编辑 删除
 * @return string
 */
function smarty_function_ytt_table($params){
	$ytt_table	= new SmartyYttTable();
	$function	= $ytt_table->function;
	return $ytt_table->$function($params);
}



class SmartyYttTable extends Smarty {
	
	// table 属性
	public $table_attr	= 'id="index" class="list" border=1';
	// tr 属性
	public $tr_attr		= array();
	//显示内容
	public $show		= array();
	//显示本页合计
	public $page_total		= array();
	//显示总合计
	public $all_total		= array();
//	public $table_type;
	//是否展开
	public $expand		= false;
	//是否显示序号
	public $serial		= false;
	//展开action
	public $expandAction;
	//是否显示操作列
	public $operate		= true;
	//操作列显示内容
	public $operate_show=array();
	//扩展操作列显示内容
	public $expand_operate_show=array();
	//数据源
	public $from;
	//初始化函数
	public $function	= 'initTable';
	//表格使用类型  basic-基本信息  flow--流程信息
	public $listType	= 'basic';
	//模块
	public $module_name	= MODULE_NAME;
	//配置使用模块
	public $flow		= '';
	//排序
	public $sort;
	//排序图标
	public $sortImg = 'Images/Default/sortImg.png';
	//输出内容
	public $output		= '';
	//thead标题 有值时 取
	public $thead;
	
	public $module_access;
	
	public $cols_num;
	//编辑窗口是否新标签打开
    public $addTab;
    /**
	 * 列表显示
	 *
	 * @param array $params
	 * @return string
	 */
	public function initTable($params){
		$this->setAttribute($params);
		$this->pushOutput('<table '.$this->table_attr.'>');
		$this->getThead();
		$this->getTbody();
		$this->getTfoot();
		$this->pushOutput('</table>');
		return $this->output;	
	}
	/**
	 * 设置表格属性
	 *
	 * @param array $params
	 */
	public function setAttribute($params){
		foreach($params as $_key=>$_value){
			$this->$_key	= $_value;
		}
	}

	/**
	 * 获取列表显示标题
	 *
	 */
	public function getThead(){
		$show	= $this->show;
		$thead	= $this->thead;
		$rowspan= empty($thead)?1:count($thead);
		$this->pushOutput('<thead>');
		$this->pushOutput('<tr>');
		//列表需要展开
		$i=0;
		if($this->expand==true){
			$this->pushOutput('<th style="width:60px;" rowspan="'.$rowspan.'" class="operate">&nbsp;</th>');
			$i++;
		}
		if($this->listType != 'total' && ((C('YTT_TABLE_SERIAL') && $this->serial !== false) || $this->serial == true)){
			$this->pushOutput('<th class="">' . L('serial_no'). '</th>');
			$i++;
		}	
		if(empty($thead)){
			foreach($show as $columns){
				$return = $this->checkFlow($columns);
				if($return==false) continue;
				$this->pushOutput('<th width="'.$columns['width'].'">'.$this->getthField($columns).'</th>');
				$i++;
			}
		}else{
			//自定义表标题
			foreach($thead as $_key=>$value){
				$str	= '<tr>';
				$i		= 0;
				foreach($value as $key=>$val){
					$return	= $this->checkFlow($val);
					if($return==false) continue;
					$str	.= '<th ';
					foreach($val as $k=>$v){
						$str	.= $k.'="'.$v.'" ';
					}
					$str	.= '>'.$val['field'].'</th>';
					$i++;
				}
				if($_key==0&&$this->operate==true){
					$str	.= '<th style="width:120px;" rowspan="'.$rowspan.'">'.L('operation').'</th>';
					$i++;
				}
				
				$str	.= '</tr>';
				$this->pushOutput($str);
			}
		}
		//是否需要加入操作列
		if($this->operate==true&&empty($thead)){
			$this->pushOutput('<th style="width:120px;" class="operate" rowspan="'.$rowspan.'">'.L('operation').'</th>');
			$i++;
		}
		$this->cols_num	= $i;
		$this->pushOutput('</tr></thead>');
	}
	/**
	 * 检验流程配置 是否输出
	 *
	 * @param array $info
	 * @return bool
	 */
	public function checkFlow($info){
		$return	= true;
		if (isset($info['show']) && $info['show'] == false){//设置为不显示 added by jp 20140115
			return false;
		}
		$config	= C($this->flow);
		if(!empty($info['type'])){
			if(!empty($info['flow'])){
				$config	= C($info['flow']);
			}
			switch($info['type']){
				//产品类别
				case 'product_class_level':
					if($config['product_class_level']==0){
						$return = false;
					}
					break;
				//是否启用多种客户类型
				case 'multi_client':
					if(C('multi_client')==0){
						$return	= false;
					}
					break;
				//产品数量规格
				case 'flow_storage_format':
					if($config['storage_format']==1){
						$return = false;
					}
					break;
				//盈亏管理 总箱数
				case 'flow_loss_quantity':
					if(C('stocktake.storage_format')==1){
						$return = false;
					}
				//是否多公司
				case 'flow_show_many_basic':
					if(C('show_many_basic')==2){
						$return	= false;
					}
					break;
				//颜色
				case 'product_color':
					if($config['product_color']==2){
						$return	= false;
					}
					break;
				//尺码
				case 'product_size':
					if($config['product_size']==2){
						$return = false;
					}
					break;
				//颜色
				case 'flow_color':
					if($config['color']==2){
						$return	= false;
					}
					break;
				//尺码
				case 'flow_size':
					if($config['size']==2){
						$return = false;
					}
					break;
				//是否多仓库
				case 'flow_multi_storage':
					if(C('multi_storage')==2){
						$return = false;
					}
					break;
				//是否显示发票
				case 'flow_show_invoice':
					if($config['show_invoice']==2){
						$return	= false;
					}
					break;
				//退货列表 是否显示发票号
				case 'flow_return_show_invoice':
					if($config['show_invoice']==2||C('invoice.invoice_return_show')==2){
						$return	= false;
					}
					break;
				//发票 产品列表是否显示 产品号
				case 'flow_invoice_product':
					if(C('invoice.product')==2){
						$return	= false;
					}
					break;
				//发票 产品列表是否显示成分
				case 'flow_invoice_ingredient':
					if(C('invoice.ingredient')==2){
						$return	= false;
					}
					break;
				//产品详细信息--库存调整数量
				case 'stat_adjust_quantity':
					$rights		 = RBAC::getModuleAccessList(USER_ID,'StatProduct');
					$all_rights  = array_keys($rights['STATPRODUCT']);
					if(!in_array('PRODUCTADJUST',$all_rights)){
						$return	= false;
					}
					break;
				//产品详细信息--入库数量
				case 'stat_instock_quantity':
					$rights		 = RBAC::getModuleAccessList(USER_ID,'StatProduct');
					$all_rights  = array_keys($rights['STATPRODUCT']);
					if(!in_array('PRODUCTINSTOCK',$all_rights)){
						$return	= false;
					}
					break;
				//产品详细信息--销售
				case 'stat_sale_quantity':
					$rights		 = RBAC::getModuleAccessList(USER_ID,'StatProduct');
					$all_rights  = array_keys($rights['STATPRODUCT']);
					if(!in_array('PRODUCTSALE',$all_rights)){
						$return	= false;
					}
					break;
				//产品详细信息--发货  没有权限 或者没有后续流程 不显示发货
				case 'stat_delivery_quantity':
					$rights		 = RBAC::getModuleAccessList(USER_ID,'StatProduct');
					$all_rights  = array_keys($rights['STATPRODUCT']);
					if(!in_array('PRODUCTSALE',$all_rights)||C('sale.relation_sale_follow_up')==2){
						$return	= false;
					}
					break;
				//产品详细信息--退货
				case 'stat_return_quantity':
					$rights		 = RBAC::getModuleAccessList(USER_ID,'StatProduct');
					$all_rights  = array_keys($rights['STATPRODUCT']);
					if(!in_array('PRODUCTSALE',$all_rights)){
						$return	= false;
					}
					break;
				//产品详细信息--库存颜色
				case 'flow_storage_color':
					if(!C('storage_color')){
						$return	= false;
					}
					break;
				//产品详细信息--库存尺码
				case 'flow_storage_size':
					if(!C('storage_size')){
						$return	= false;
					}
					break;
				//产品详细信息--在途库存
				case 'flow_onload_storage':
					if(C('loadContainer.sale_storage')==2){
						$return	= false;
					}
					break;
				//产品详细页--库存尾箱
				case 'stat_storage_mantissa':
					if(C('storage_mantissa')==0){
						$return	= false;
					}
					break;
				//厂家币种
				case 'flow_factory_currency':
					$currency	= explode(',',C('factory_currency'));
					if(count($currency)==1){
						$return	= false;
					}
					break;
				//客户币种
				case 'flow_client_currency':
					$currency	= explode(',',C('client_currency'));
					if(count($currency)==1){
						$return	= false;
					}
					break;
				//物流公司币种
				case 'flow_logistics_currency':
					$currency	= explode(',',C('logistics_currency'));
					if(count($currency)==1){
						$return	= false;
					}
					break;
				default:
					break;
			}
		}
		return $return;
	}

	/**
	 * 获取标题显示信息
	 *
	 * @param array $info
	 */
	public function getthField($info){
		$field	= $info['value'];
		if(!array_key_exists($field,$this->sort)){
			switch ($info['type']) {
				case 'simple_product_info':
					$title	= explode(LANG_SET == 'de' ? ',' : '、', $info['title'], 3);
					$output	= '<table class="list_th_table" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%">' . $title[0] . '</td>
									<td width="60%">' . $title[1] . '</td>
									<td width="20%">' . $title[2] . '</td>
								</tr>
							   </table>';
					break;
				case 'return_product_detail_info':
					$title	= explode(LANG_SET == 'de' ? ',' : '、', $info['title'], 4);
					$output	= '<table class="list_th_table" cellspacing="0" cellpadding="0">
								<tr>
									<td width="10%">' . $title[0] . '</td>
									<td width="30%">' . $title[1] . '</td>
									<td width="30%">' . $title[2] . '</td>
									<td width="10%">' . $title[3] . '</td>
								</tr>
							   </table>';
					break;				
                case 'return_storage_product_detail_info':
					$title	= explode(LANG_SET == 'de' ? ',' : '、', $info['title'], 5);
					$output	= '<table class="list_th_table" cellspacing="0" cellpadding="0">
								<tr>
									<td width="15%">' . $title[0] . '</td>
									<td width="20%">' . $title[1] . '</td>
									<td width="15%">' . $title[2] . '</td>
									<td width="20%">' . $title[3] . '</td>
                                    <td width="20%">' . $title[4] . '</td>
								</tr>
							   </table>';
                    break;
                    case 'question_sale_order':
                        $title	= explode('、', $info['title']);
                        $output	= '<table class="list_th_table" cellspacing="0" cellpadding="0">
								<tr><td style="line-height:110%">
									' . $title[0] . '
                                        <br>
									' . $title[1] . '
                                        <br>
									' . $title[2] . '
								</td></tr>
							   </table>';
					break;				
				default :
					$output	= $info['title'];
					break;
			}
		}else{
			$sort	= $this->sort[$field];
//			$title	= $sort['sort_by']==1?L('order_by').$info['title'].' 降序排序':L('order_by').$info['title'].' 升序排序';
			//升序处理
			if($sort['sort_by']==1&&!isset($_REQUEST['_sort'])){
				$_REQUEST['_sort']=1;
			}

			$sort_by= $_REQUEST['_sort']==1?0:1;
			$img	= $sort_by==1?PUBLIC_PATH.'Images/Default/sortImg_drop.png':PUBLIC_PATH.'Images/Default/sortImg.png';
//			$url	= U('/'.MODULE_NAME.'/'.$sort['sort_action'].'/_order/'.$field.'/_sort/'.$sort_by);
			$script	= "$.sortBy('".$field."',".$sort_by.")";
				
			$output	= '<a title="'.$sortlang.'" href="javascript:'.$script.'"';
			$output.= '<span>'.$info['title'].'</span>';
		
			$output.= '<eq class="operate" name="order" value="'.$field.'">';
			
			$output.= '<img src="'.$img.'" class="operate" width="9" height="21" border="1" align="absmiddle" />';
			$output.= '</eq>';			
		}
		return $output;
	}

	/**
	 * 获取表格明细内容
	 *
	 */
	public function getTbody(){
		$this->pushOutput('<tbody>');
		if(empty($this->from)){
			$this->pushOutput('<tr><td colspan="'.$this->cols_num.'">'.L('no_record_for_search').'</td></tr>');
		}else{
			foreach($this->from as $key=>$value){
				$this->getTbodyTr($key+1,$value);
				$this->getTbodyExpand($value,$key+1);
				$this->getTbodySerial($value,$key+1);
				foreach($this->show as $row=>$cols){
					$return = $this->checkFlow($cols);
					if($return==false) continue;
					$td			= $this->getTbodyTd($cols,$value);
					$span		= $this->getTbodySpan($cols['span'],$value);
					$hidden		= $this->getTbodyHidden($cols['hidden'],$value);
					$autoshow	= $this->getAutoShow($cols['autoshow'],$value);
					$field		= $this->getTdField($cols,$value);
                    $editCell   = $this->getEditCell($cols,$value);
					$this->pushOutput($td);
					$this->pushOutput($hidden);
					if(!empty($span)) $this->pushOutput($span);
					$this->pushOutput($field.$autoshow);
                    $this->pushOutput($editCell);
					if(!empty($span)) $this->pushOutput('</span>');
					$this->pushOutput('</td>');
				}
				if($this->operate==true){
					$this->pushOutput('<td class="operate">');
					$this->getOperate($value);
					$this->pushOutput('</td>');
				}
				$this->pushOutput('</tr>');
			}
		}
		$this->pushOutput('</tbody>');
	}
	/**
	 * 获取表格内容tr属性
	 *
	 * @param int $index
	 */
	public function getTbodyTr($index,$list){
		$tr_attr	= $this->tr_attr;
		$id			= $this->getTrId($list);
		$this->pushOutput('<tr id="'.$id.$index.'" name="'.$tr_attr['name'].'_'.$index.'" ');
		if($this->expand==true) $this->pushOutput('expand="1" ');
		unset($tr_attr['id']);
		unset($tr_attr['name']);
		if(is_array($tr_attr['class'])){
			$tr_attr['class']	= $this->getClass($tr_attr['class'],$list);
		}
		foreach($tr_attr as $attr=>$attr_value){
			$this->pushOutput(' '.$attr.'="'.$attr_value.'"');
		}
		$this->pushOutput('>');
	}
	
	public function getClass($info,$list){
//		$field	= key($info);
//		$class	= $info[$field];
//		$output	= $class[$list[$field]];
        foreach($info as $key=>$value){//added yyh20150515
            $output	.= ' '.$value[$list[$key]];
        }
		return $output;
	}
	
	/**
	 * 获取表格内容tr id属性
	 *
	 * @return string
	 */
	public function getTrId($list){
		$tr_attr	= $this->tr_attr;
		$id			= empty($tr_attr['id'])?'index_':$tr_attr['id'].'_';
		$id			.=$list['id'].'_';
		return $id;
	}
	/**
	 * 表格展开
	 *
	 * @param array $list
	 * @param int $index
	 */
	public function getTbodyExpand($list,$index){
		if($this->expand==true){
			$this->pushOutput('<td class="operate" align="center" id="expand" expand="1" width="100">');
			$id	= $this->getTrId($list).$index;
			$this->pushOutput('<a onclick="$.showExpand(\''.$this->expandAction.'\',\''.$id.'\',\''.$list['id'].'\')" href="javascript:void(0)">');
			$this->pushOutput('<span class="icon icon-pattern-plus"></span>');
			$this->pushOutput('</a></td>');
		}
	}
	/**
	 * 表格序号
	 *
	 * @param array $list
	 * @param int $index
	 */
	public function getTbodySerial($list,$index){
		if($this->listType != 'total' && ((C('YTT_TABLE_SERIAL') && $this->serial !== false) || $this->serial == true)){
			$view       = Think::instance('View');
			$pageInfo = $view->get('pageInfo');
			$this->pushOutput('<td class="t_right">' . ($pageInfo['firstRow']+$index) . '</td>');
		}
	}
	/**
	 * 获取td属性
	 *
	 * @param array $info
	 * @return string
	 */
	public function getTbodyTd($info=array(),$list){
		$width	= $info['width'];
		$field	= $info['value'];
		$info	= $info['td'];
		$option	= S('dd_config_format_table');
		if(is_array($info['class'])){
			$info['class']=$this->getClass($info['class'],$list);
		}
		if(!empty($option[$field])){
			$info['class']	.= $option[$field];
		}elseif(substr($field,0,4)=='dml_'){
			$info['class']	.= ' t_right';
		}elseif(substr($field,0,4)=='fmd_'||substr($field,-3,3)=='_no'){
			$info['class']	.= ' t_center';
		}
		$output		= '<td width="'.$width.'" ';
		foreach($info as $key=>$value){
			$output	.= $key.'="'.$value.'" ';
		}
		$output		.= '>';
		return $output;
	}
	/**
	 * 获取span
	 *
	 * @param array $info
	 *  show:根据字段值判断是否添加span
	 * @return string
	 */
	public function getTbodySpan($info=array(),$list=array()){
		if(empty($info)){
			return ;
		}
		$output		= '<span ';
		$link_id	= $info['link_id'];
		$show		= $info['show'];
        $is_show_field  = $info['is_show_field'];
        $is_show    = $list[$is_show_field];
		unset($info['link_id']);
		unset($info['show']);
		if((in_array(ACTION_NAME,$show)||empty($show)) && ($is_show || !isset($info['is_show_field']))){
			foreach($info as $key=>$value){
				if($key=='url'){
					$value	= U('/'.smarty_function_getUrl($value,$link_id,$list));
				}
				$output	.= $key.'="'.$value.'" ';
			}
			$output		.= '>';
			return $output;
		}else{
			return ;
		}
	}
	/**
	 * 获取hidden
	 *
	 * @param array $info
	 * @param array $list
	 * @return string
	 */
	public function getTbodyHidden($info=array(),$list){
		foreach($info as $value){
			$field		 = $value['value'];
			$output		.= '<input type="hidden" value="'.$list[$field].'"';
			unset($value['value']);
			foreach((array)$value as $attr=>$attr_value){
				$output	.= $attr.'="'.$attr_value.'"';
			}
			$output		.= ' />';
		}
		return $output;
	}
	
	public function getTdField($info,$list){
		$field		= $info['value'];
		$font_class	= $this->getClass($info['font_class'],$list);
		//value_field'=>['field'=>[1=>'dml_cube', 2=> 'dml_weight'],'type'=>'字段名称,值对应field下标']
		$output		= isset($list[$info['value_field']['field'][$list[$info['value_field']['type']]]]) ? $list[$info['value_field']['field'][$list[$info['value_field']['type']]]] : $list[$field];
		if(!empty($font_class)){
			$output	= '<label class="'.$font_class.'">'.$output.'</label>';
		}
		//加入链接
		$output	= $this->getLink($info,$list,$output);
		//加入表单操作
		$output	= $this->getInput($info,$list,$output);
		return $output;
	}
    
    public function getEditCell($info,$list){
        if(empty($info['editCell']) || ($_SESSION["LOGIN_USER"]["role_type"] == C('SELLER_ROLE_TYPE') && !in_array($list['sale_order_state'], C('EDIT_ORDER_NO_STATE')))){
            return $output;
        }  else {
            $output     = '<input type="text" name="velue" value="'.$list[$info['value']].'" style="display:none" >';
            $output     .= '<span class="icon icon-list-edit" onclick="editCell(this,'.$list['id'].',\''.$info['value'].'\')" style="float: right"></span>';
            return $output;
        }
    }

    /**
	 * 获取链接
	 *
	 * @param array $info
	 * @param array $list
	 * @param string $output
	 * @return string
	 */
	public function getLink($info,$list,$output){
		$eval	= '';
		$link	= $info['link'];
		if (empty($link) && !empty($list['link'][$info['value']]) && is_array($list['link'][$info['value']])) {
			$link	= $list['link'][$info['value']];
		}
		if (isset($link['link_type'])) {//added by jp 20140523 根据link_type字段的值显示不同的链接属性
			$link_type	= $link['link_type'];
			$fields	= array('url', 'title', 'onclick', 'explode', 'eval', 'file_url', 'show');
			foreach ($fields as $field) {
				is_array($link[$field]) && $link[$field]	= $link[$field][$list[$link_type]];
			}
			unset($link['link_type']);
		}			
		if(!empty($link)){
			foreach((array)$link as $_key=>$_val){
				switch($_key){
					case 'url':
						$$_key	= $_val;break;
					case 'link_id':
						$link_id	= $_val;break;
					case 'title':
						$$_key	= $_val;break;
					case 'onclick':
						$$_key	= $_val;break;
					case 'explode':
						$$_key	= $_val;break;
					case 'eval':
						$$_key	= $_val;break;
					case 'file_url':
						$$_key	= $_val;break;		
					case 'show':
						$$_key	= $_val;break;					
					default:
						isset($link_type) && is_array($_val) && $_val	= $_val[$_key][$list[$link_type]];//added by jp 20140523
						$extra	.= $_key.'="'.$_val.'" ';
				}
			}
			if ($show === false){//不显示链接
				return $output;
			}
			if(!empty($file_url)){
				$url	= isset($list[$file_url])?$list[$file_url]:$file_url;
				$output	= '<a href="'.$url.'" target="_blank">'.$output.'</a>';
				return $output;
			}			
			if(!empty($eval)){
				$url	= isset($list[$eval])?$list[$eval]:$eval;
				$output	= '<a href="javascript:;" onclick="addTab(\''.$url.'\',\''.$title.'\',1)">'.$output.'</a>';
				return $output;
			}
			//取链接中的 id
			$id		= is_array($link_id)?reset($link_id):$link_id;
			if(!empty($explode)){
				//td中显示的值 字符串转成数组
				$value	= @explode($explode,$list[$info['value']]);
				//链接id对应的值
				$id_arr	= @explode($explode,$list[$id]);
				unset($output);
				foreach((array)$id_arr as $k=>$v){
					if(empty($v)) continue;
					$k>0 && $output .= '<br>';
					$list[$id]	= $v;
					$url_new	= smarty_function_getUrl($url,$link_id,$list);
					
					$output		.= $this->getUrl($url_new,$list,$value[$k]);
				}
				if($list[$link['show_title']]>0){
					$url	= smarty_function_getUrl($url,$link_id,$list);
					$url_arr= @explode('/',$url);
					$module	= $url_arr[0];
					//设定链接地址参数
					$link_param=array();
					if(!is_array($link_id)){
						!empty($list[$link_id]) && $link_param[$link_id]	= $list[$link_id];
					}else {
						$link_param	= $link_id;
					}
					$link_param['id']	= $list['id'];
					$url	= smarty_function_getUrl($module.'/add',$link_param,$list);
					!empty($output) && $output .= '<br>';
					$output	.= '<a onclick="addTab(\''.U('/'.$url).'\',\''.title('add',$module).'\',1);'.$onclick.'" href="javascript:;" '.$extra.' class="invoice_button">'.$link['title'].'</a>';
				}
			}else{
				$url	= smarty_function_getUrl($url,$link_id,$list);
				$output = $this->getUrl($url,$list,$output,$link['url']);
			}
		}
		return $output;
	}

	/**
	 * 获取JS
	 *
	 * @param array $info
	 * @param array $list
	 * @param string $output
	 * @return string
	 */
	public function getInput($info,$list,$output){
		$input	= $info['input'];
		if(!empty($input)){
			foreach((array)$input as $_key=>$_val){
				switch($_key){
					case 'event':
						$$_key	= $_val;break;
					case 'fn':
						$$_key	= $_val;break;
					case 'param':
						$param_array = null;
						foreach((array)$_val as $p_val){
							if($list[$p_val]){
								$param_array[] = $list[$p_val];
							}else{
								$param_array[] = $p_val;
							}
						}
						$param = implode(',',$param_array);
						break;
					default:
						$extra	.= $_key.'="'.$_val.'" ';
				}
			}
			//如果有JS函数且没有指定触发函数则默认是onchange
			if(is_null($event) && $fn){
				$js = 'onchange="'.$fn.'('.$param.')" ';
			}else{
				$js = $evnet.'="'.$fn.'('.$param.')" ';
			}
			$output	= '<input '.$js.$extra.' value='.$output.'>';
		}
		return $output;
	}


	/**
	 * 判断Url是否为内部链接
	 *
	 * @param unknown_type $url
	 * @param unknown_type $list
	 * @param unknown_type $output
	 * @return unknown
	 */
	public function getUrl($url,$list,$output,$url_out=null){
		if(empty($url)){
			return $output;
		}
		$url_type	= stripos('_'.$url,'http');
		if($url_type>0){
			$url	= $list[$url_out];
			if(empty($url))  return $output;
			$output	= '<a href="'.$url.'" target="_blank">'.$output.'</a>';
		}else{
			$url	= ltrim($url,'/');
			$url_arr= @explode('/',$url);
			$module	= $url_arr[0];
			$action = $url_arr[1];
			$output	= '<a onclick="addTab(\''.U('/'.$url).'\',\''.title($action,$module).'\',1); '.$onclick.'" href="javascript:;" '.$extra.'>'.$output.'</a>';
		}
		return $output;
	}
    /**
	 * 显示操作列
	 *
	 * @param unknown_type $list
	 */
	public function getOperate($list){
		$module_name	= $this->module_name;
		if(empty($this->module_access)){
			if($module_name!=MODULE_NAME){
				$_SESSION['_MODULE_ACCESS_'] = RBAC::getModuleAccessList(USER_ID,$module_name);
			}
			$this->module_access		 = $_SESSION['_MODULE_ACCESS_'];
		}
		if(empty($this->operate_show)){
			if(ACTION_NAME=='getDistrictList'){
				$edit_title	 = L('update').L('city');
				$del_title	 = L('city').L('delete');
				$restore_title   = L('city').L('restore');
                                $editstate_title = L('update');
			}else{
				$edit_title	 = title('edit',$module_name);
				$del_title	 = title('delete',$module_name);
				$restore_title   = title('restore',$module_name);
                                $editstate_title = title('edit',$module_name).L('state');
			}
			if($module_name =='Factory') {//added by jp 20140122 查看卖家员工列表
				$this->pushOutput('<span class="icon icon-list-view" url="'.U('/SellerStaff/index/company_id/'.$list['id']).'" title="'.title('viewEmployee').'" onclick="addTab(\''.U('/SellerStaff/index/company_id/'.$list['id']).'\',\''.title('viewEmployee').'\')"></span>'); 
				//启用
				if($list['is_enable']==1){
					$this->pushOutput('<span class="icon icon-add-plus" url="'.U('/Factory/setEnable/id/'.$list['id'].'/to_hide/1').'" 
					title="'.L('enable').'"   onclick="$.cancel(this)"></span>'); 
				}else{
					$this->pushOutput('<span class="icon icon-del-plus" url="'.U('/Factory/setEnable/id/'.$list['id'].'/to_hide/2').'" 
					title="'.L('unenable').'" onclick="$.cancel(this)"></span>'); 
				}
			}		
			if($module_name =='SellerStaff') {
				//启用
				if($list['is_enable']==1){
					$this->pushOutput('<span class="icon icon-add-plus" url="'.U('/SellerStaff/setEnable/id/'.$list['id'].'/to_hide/1').'" 
					title="'.L('enable').'"   onclick="$.cancel(this)"></span>'); 
				}else{
					$this->pushOutput('<span class="icon icon-del-plus" url="'.U('/SellerStaff/setEnable/id/'.$list['id'].'/to_hide/2').'" 
					title="'.L('unenable').'" onclick="$.cancel(this)"></span>'); 
				}
			}					
			if($module_name =='Message') {//added by lml   20160114  查看详细信息
				$this->pushOutput('<span class="icon icon-list-view" url="'.U('/Message/view/id/'.$list['id']).'" title="'.title('view').'" onclick="addTab(\''.U('/Message/view/id/'.$list['id']).'\',\''.title('view').'\')"></span>');
			}
			if($module_name =='Recharge') {		
				$this->pushOutput('<span class="icon icon-list-view" url="'.U('/'.$module_name.'./view/id/'.$list['id']).'" title="'.title('view').'" onclick="addTab(\''.U('/'.$module_name.'/view/id/'.$list['id']).'\',\''.title('view').'\')"></span>'); 
			}
			if($module_name =='Client') {//added by jp 20140122 查看买家订单列表
				$this->pushOutput('<span class="icon icon-pattern-batchversion" url="'.U('/SaleOrder/index/client_id/'.$list['id']).'" title="'.title('viewOrder').'" onclick="addTab(\''.U('/SaleOrder/index/client_id/'.$list['id']).'\',\''.title('viewOrder').'\')"></span>'); 
			}
			if($module_name =='ComplexOrder') {//added by jp 20140122 查看复合订单处理列表
				$this->pushOutput('<span class="icon icon-list-view" url="'.U('/ComplexOrder/view/id/'.$list['id']).'" title="'.title('viewComplexOrder').'" onclick="addTab(\''.U('/ComplexOrder/view/id/'.$list['id']).'\',\''.title('viewComplexOrder').'\')"></span>'); 
				//继续发货
				$this->pushOutput('<span class="icon icon-add-plus" url="'.U('/SaleOrder/outStock/id/'.$list['id'].'/verifyType/1').'" 
					title="'.L('verify_delivery').'" onclick="$.edit(this)"></span>'); 	
				//删除发货
				$this->pushOutput('<span class="icon icon-del-plus" url="'.U('/ComplexOrder/setState/id/'.$list['id'].'/state/1').'" 
					title="'.L('delete_delivery').'" onclick="$.cancel(this)"></span>'); 
			}	
			if($module_name =='SaleOrder') {//added by jp 20140122 查看卖家订单
				$this->pushOutput('<span class="icon icon-list-view" url="'.U('/SaleOrder/view/id/'.$list['id']).'" title="'.title('viewOrder').'" onclick="addTab(\''.U('/SaleOrder/view/id/'.$list['id']).'\',\''.title('viewOrder').'\')"></span>'); 
				//合并订单
				if($list['is_combine']==1){
					$this->pushOutput('<span class="icon icon-add-plus">'.
									  '<input type="checkbox" value="'.$list['id'].'" name="sale_order_id[]" title="'.L('order_combin').'" id="sale_order_id">'.
									  '</span>');
				//取消合并
				}elseif($list['del_combine']){
					$this->pushOutput('<span class="icon icon-del-plus" url="'.U('/Public/delCombine/sale_order_no/'.$list['sale_order_no']).'" title="'.L('delcombin').'" onclick="$.cancel(this)"></span>');
				}
			}
			if($module_name =='ReturnSaleOrder') {//added by jp 20140122 查看卖家订单
				$this->pushOutput('<span class="icon icon-list-view" url="'.U('/ReturnSaleOrder/view/id/'.$list['id']).'" title="'.title('viewReturnOrder').'" onclick="addTab(\''.U('/ReturnSaleOrder/view/id/'.$list['id']).'\',\''.title('viewReturnOrder').'\')"></span>'); 
			}
            if($module_name =='ReturnSaleOrderStorage') {//added by yyh 20141223 查看退货单入库
				$this->pushOutput('<span class="icon icon-list-view" url="'.U('/ReturnSaleOrderStorage/view/id/'.$list['id']).'" title="'.title('viewReturnOrder').'" onclick="addTab(\''.U('/ReturnSaleOrderStorage/view/id/'.$list['id']).'\',\''.title('viewReturnOrder').'\')"></span>');
				//处理操作      add by lxt 2015.09.06
				!$list['is_deal'] && $this->pushOutput('<span class="icon icon-list-addInvoice" url="'.U('/ReturnSaleOrderStorage/deal/id/'.$list['id']).'" title="'.L('deal').'" onclick="addTab(\''.U('/ReturnSaleOrderStorage/deal/id/'.$list['id']).'\',\''.L('deal').'\')"></span>'); 
                //删除处理操作
                $list['is_deal'] && $this->pushOutput('<span class="icon icon-cancel" url="'.U('/ReturnSaleOrderStorage/deleteDeal/id/'.$list['id']).'" title="'.L('delete_deal').'" onclick="$.cancel(this)"></span>');
            }
            if($module_name =='QuestionOrder') {//added by yyh 20150424 查看退货单入库
				$this->pushOutput('<span class="icon icon-list-view" url="'.U('/QuestionOrder/view/id/'.$list['id']).'" title="'.L('view').title().'" onclick="addTab(\''.U('/QuestionOrder/view/id/'.$list['id']).'\',\''.L('view').title().'\')"></span>'); 
			}
			if(isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['UPDATE'])&&($list['is_update']==1||!isset($list['is_update']))) {

				//转账费用类别不显示修改       
				if(!($module_name =='PayClass' && $list['id']==1) && !$list['is_deal']){ //edit by yyh 20141022 订单列表不显示默认编辑
                    if($this->addTab){
                        $onclick    = 'addTab(\'' . U('/' . $module_name . '/edit/id/' . $list['id']) . '\',\'' . $edit_title . '\')';
                    }else{
                        $onclick    = '$.edit(this)';
                    }
					//更换图标
					if($module_name =='Recharge'){
						if($list['confirm_state'] == 0 && isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['CONFIRM'])&&($list['is_confirm']==1||!isset($list['is_confirm']))&&($_SESSION[C('ADMIN_AUTH_KEY')] === true || ($_SESSION["LOGIN_USER"]["role_id"] == C('FINANCIAL_MANAGER_ROLE_ID')))){
							$class_icon = "icon icon-list-hand";
						}
					}else{
						$class_icon = "icon icon-list-edit";
					}
					$this->pushOutput('<span class="'.$class_icon.'" url="'.U('/'.$module_name.'/edit/id/'.$list['id']).'" title="'.$edit_title.'" onclick="'.$onclick.'"></span>');
				}
			}
            if (isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['EDITSTATE']) && ($list['is_editstate'] == 1 || !isset($list['is_editstate']))) {//added by yyh 20140827  编辑发货状态
				if(!($module_name=='Instock'&&$_SESSION["LOGIN_USER"]["role_type"]==C('SELLER_ROLE_TYPE'))){//卖家类型用户不显示编辑发货状态按钮
					$this->pushOutput('<span class="icon icon-list-hand" title="' . $editstate_title . '" onclick="$.quicklyEditState(\'' . $module_name . '\', ' . $list['id'] . ', ' . $list['instock_type'] . ')"></span>');
				}
			}
			if($module_name =='WarehouseLocation') {//added by jp 20140122 导出库位表
				$this->pushOutput('<span class="icon icon-list-export" title="'.title('exportLocationList').'" onclick="javascript:ExportMytable(\'Location\',' . $list['id'] . ',\'WarehouseLocation\');"></span>'); 
			}				
			if($module_name =='TrackOrder'&& ACTION_NAME == 'index'&&$list['is_first']=='0') {//added by jp 20140122 导出库位表
				$this->pushOutput('<span class="icon icon-list-import" url="'.U('/TrackOrder/import/id/'.$list['id'].'/type/'.$list['is_dhl']).'" 
				title="'.L('import').'" onclick="$.cancel(this,\'TrackOrderImport\')"></span>'); 		
			}
            if($module_name =='TrackOrder'&& ACTION_NAME == 'exportSaleOrderList') {//added by yyh 20141022 下载订单导出列表
				$this->pushOutput('<span class="icon icon-list-export" url="'.U('/TrackOrder/import/id/'.$list['id'].'/type/'.$list['is_dhl']).'" 
				title="'.L('export').'" onclick="$.exportCsv(this,\'TrackOrder\')"></span>'); 		
			}
			if(isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['RESETPASSWD'])) {
				$this->pushOutput('<span class="icon icon-list-reset" url="'.U('/'.$module_name.'/resetPasswd/id/'.$list['id']).'" title="'.title('resetPasswd').'" onclick="addTab(\''.U('/'.$module_name.'/resetPasswd/id/'.$list['id']).'\',\''.title('resetPasswd').'\')"></span>'); 
			}
			//Ebay授权
			if(isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['GETEBAYTOKEN'])) {
				$this->pushOutput('<span class="icon icon-list-reset" url="'.U('/'.$module_name.'/getEbayToken/id/'.$list['id']).'" title="'.title('getEbayToken').'" onclick="addTab(\''.U('/'.$module_name.'/getEbayToken/id/'.$list['id']).'\',\''.title('getEbayToken').'\')"></span>'); 
				//验证
				$this->pushOutput('<span class="icon icon-list-addInvoice" url="'.U('/Public/getTokenStatus/id/'.$list['id'].'/user_id/'.$list['user_id']).'" title="'.L('getTokenStatus').'" onclick="$.edit(this)"></span>'); 
			}
			if (isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['REGENERATEFILE'])) {//added by jp 20140425 拣货导出重新生成导出文件
				$this->pushOutput('<span class="icon icon-restore" url="'.U('/'.$module_name.'/regenerateFile/id/'.$list['id']).'" title="'.title('regeneratefile',$module_name).'" onclick="$.restore(this)"></span>');
			}
			//dre(($module_name =='Message' && $list['is_announced']==1));
            if((isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['DELETE']))&&($list['is_del']==1||!isset($list['is_del']))) {
				if($list['to_hide']==2&&$this->listType=='basic'&&!($module_name =='User' && $list['user_type']==2)){//卖家类型用户不显示还原
					if($module_name=='SellerStaff'){
						$logo_class = 'icon icon-list-del';
					}else{
						$logo_class = 'icon icon-restore';
					}
					$this->pushOutput('<span class="'.$logo_class.'" url="'.U('/'.$module_name.'/delete/id/'.$list['id'].'/restore/1').'" title="'.$restore_title.'" onclick="$.restore(this)"></span>');
				}elseif(($this->listType=='basic'&&$list['to_hide']==1)||$this->listType=='flow'){					
					//转账费用类别,卖家所属角色不显示删除               
					if(!($module_name=='Role'&&in_array($list['id'],explode(',',C('SELLER_BELONG_ROLE_ID'))))&&!($module_name =='PayClass' && $list['id']==1)&&!($module_name =='User' && $list['user_type']==2) && !$list['is_deal']){//卖家类型用户不显示删除					
					     if(MODULE_NAME == 'Recharge' && $list['confirm_state'] == 1 || ($module_name=='TrackOrder'&&ACTION_NAME!='exportSaleOrderList') ||($module_name=='TrackOrder'&&ACTION_NAME=='exportSaleOrderList'&&!($_SESSION[C('ADMIN_AUTH_KEY')] === true || ($_SESSION["LOGIN_USER"]["role_id"] == C('OVERSEAS_MANAGER_ROLE_ID'))))){
							$class = "";
						 }else{
							$class = "icon icon-list-del";
						 }
						$this->pushOutput('<span class="'.$class.'" url="'.U('/'.$module_name.'/delete/id/'.$list['id']).'" title="'.$del_title.'" onclick="$.cancel(this)"></span>');
					}
				}
                if(MODULE_NAME  == 'SaleOrder'){
                    $this->pushOutput('<span class="icon icon-pattern-nocheck" value="'.$list['id'].'" title="'.$del_title.'" onclick="$.ButtenCheck(this)"></span>');
                }
			}
            if(MODULE_NAME  == 'SaleOrder' && $list['is_insure']==1 && $list['is_out'] && getUser('role_type') != C('SELLER_ROLE_TYPE') && $list['sale_order_state']==C('SHIPPED')){
                $this->pushOutput('<span class="icon icon-stat-profit" value="'.$list['id'].'" title="'.L('insure_price').'" onclick="$.setInsurePrice('.$list['id'].')"></span>');
            }
            if(MODULE_NAME  == 'PackBox' && ($list['is_del']==1||!isset($list['is_del']))){
                $this->pushOutput('<span class="icon '.  a2bc($list['is_check'], 'icon-pattern-check', 'icon-pattern-nocheck').'" value="'.$list['id'].'" title="'.L('outStock').'" onclick="$.ButtenCheck(this);recordCheckId(this) "></span>');
            }
            
            if(MODULE_NAME  == 'OutBatch' && $list['is_review_weight'] == 0){
                $this->pushOutput('<span class="icon icon-list-addInvoice" url="'.U('/'.$module_name.'/edit/id/'.$list['id'].'/review_weight/true').'" title="'.L('review_weight').'" onclick="$.edit(this)"></span>');
            }
            if(MODULE_NAME  == 'OutBatch' && $list['is_review_weight'] == 1 && $list['is_send'] == 1){
                $this->pushOutput('<span class="icon icon-list-email" title="'.L('sent_email').'" onclick="$.sentEmail('.$list['id'].');" ></span>');
            }
			if(MODULE_NAME  == 'Message' && $list['is_announced'] == 2 && getUser('role_type') == C('ADMIN_ROLE_TYPE') ){
                $this->pushOutput('<span class="icon icon-list-email" title="'.L('message_announced').'"  onclick="$.messageAnnounced('.$list['id'].');" ></span>');
            }
            if(MODULE_NAME  == 'OutBatch' && $list['is_review_weight'] > 0 && $list['is_associate_with'] == 0){
                $class  = $list['is_customs_clearance']==0 ? 'icon-list-audit' : 'icon-list-view';
                $title  = $list['is_customs_clearance']==0 ? L('customs_clearance') : L('view_customs_clearance');
                $this->pushOutput('<span class="icon '.$class.'" url="'.U('/'.$module_name.'/edit/id/'.$list['id'].'/customs_clearance/true').'" title="'.$title.'" onclick="$.edit(this)"></span>');
            }
            
            if(MODULE_NAME  == 'OutBatch' && $list['is_customs_clearance'] > 0){
                $class  = $list['is_associate_with']==0 ? 'icon-list-hand' : 'icon-list-returnhand';
                $title  = $list['is_associate_with']==0 ? L('associate_with') : L('view_associate_with');
                $this->pushOutput('<span class="icon '.$class.'" value="'.$list['id'].'" url="'.U('/'.$module_name.'/edit/id/'.$list['id'].'/associate_with/true').'" title="'.$title.'" onclick="$.edit(this)"></span>');
            }
            
            if($module_name=='SaleOrder' && ((($_SESSION[C('ADMIN_AUTH_KEY')]||$_SESSION["LOGIN_USER"]["role_type"] == C('WAREHOUSE_ROLE_TYPE')) && in_array($list['sale_order_state'],C('ADMIN_EDIT_ADDRESS_SALE_ORDER_STATE'))) || (in_array($list['sale_order_state'],C('EDIT_ADDRESS_SALE_ORDER_STATE'))&&$_SESSION["LOGIN_USER"]["role_type"]==C('SELLER_ROLE_TYPE')))){//add by yyh 20141120 编辑订单地址
                $this->pushOutput('<span class="icon icon-list-addInvoice" onclick="$.quicklyEditAddress(\'' . $module_name . '\', ' . $list['id'] . ')"  title="'.L('edit_address').'" ></span>');
			}
            if($module_name=='ReturnSaleOrder' && in_array($list['return_sale_order_state'],C('STORAGE_RETURN_SALE_ORDER_STATE')) && ($_SESSION[C('ADMIN_AUTH_KEY')] || $_SESSION["LOGIN_USER"]["role_type"] == C('WAREHOUSE_ROLE_TYPE')) && $list['can_storage']){//add by yyh 20141219 退货入库
                $this->pushOutput('<span class="icon icon-list-audit-record" onclick="addTab(\''.U('/ReturnSaleOrderStorage/add/id/'.$list['id']).'\',\''.title('storage').'\')"  title="'.L('module_returnsaleorderstorage').'" ></span>');
			}
			switch (C('PRINT_BARCODE_MODULE.' . $module_name)) {
				case 1:
					$printWidth		= '75mm';
					$printHeight	= '25mm';
					switch ($module_name) {
						case 'Product':
							break;
						case 'SaleOrder':
							$printWidth		= '100mm';
							$printHeight	= '65mm';							
							break;
						case 'PackBox':
							$printWidth		= '88mm';
							$printHeight	= '99mm';							
							break;
						case 'OutBatch':
							$printWidth		= '88mm';
							$printHeight	= '99mm';							
							break;
						//add by lxt 2015.09.11
						case 'ReturnSaleOrder':
						    $printWidth   =   '80mm';
						    $printHeight  =   '90mm';
						    break;
					}
                    if($module_name=='SaleOrder'){
                        $this->pushOutput('<span class="icon icon-list-print" title="'.title('viewBarcode').'" onclick="$.printSaleOrderAddition('.$list['id'].');"></span>');
						$this->pushOutput('<span class="icon icon-list-print" title="'.L('print_waybill').'" onclick="$.printWaybill('.$list['id'].');"></span>');
                    }elseif($module_name  == 'PackBox') {//装箱打印
                        $this->pushOutput('<span class="icon icon-list-print" title="'.title('viewBarcode').'" onclick="$.printPackBoxAddition('.$list['id'].');"></span>');
                    }elseif($module_name  == 'OutBatch') {//出库批次打印 added by yyh 20150906
                        $this->pushOutput('<span class="icon icon-list-print" title="'.title('viewBarcode').'" onclick="$.printOutBatchAddition('.$list['id'].');"></span>');
                    }elseif ($module_name=='ReturnSaleOrder'){
                        $this->pushOutput('<span class="icon icon-list-print" title="'.title('viewBarcode').'" onclick="$.printReturnLogisticsNo('.$list['id'].');"></span>');
                    }elseif($module_name=='Product'){
                        $this->pushOutput('<span class="icon icon-list-print" title="'.title('viewBarcode').'" onclick="$.printProductBarcode('.$list['id'].')"></span>');
                    }else{
                        $this->pushOutput('<span class="icon icon-list-print" title="'.title('viewBarcode').'" onclick="printBarcode(\'' . BARCODE_PATH . $module_name . '/' . $list['id'] . '.' . C('BARCODE_PC_TYPE') . '?' . time() . '\', \'' . $printWidth . '\', \'' . $printHeight . '\')"></span>');
                    }
                    break;
				case 2:
					$this->pushOutput('<span class="icon icon-list-print" title="'.title('viewBarcode').'" onclick="$.quicklyShowBarcode(\'' . $module_name . '\', ' . $list['id'] . ')"></span>'); 
					break;
			}
			//跟原来的EXPORT_BARCODE_MODULE一样，为了防止有的模块不需要这个功能       edit by lxt 2015.10.21
            if(in_array($module_name, C('PRINGT_BARCODE_MODULE')) && ($_SESSION[C('ADMIN_AUTH_KEY')] || $_SESSION["LOGIN_USER"]["role_type"] == C('WAREHOUSE_ROLE_TYPE'))){//added by yyh 20141011
                $this->pushOutput('<span class="icon icon-list-hand" title="'.title('print_barcode').'" onclick="$.quicklyPrintBarcode(\'' . $module_name . '\', ' . $list['id'] . ')"></span>');
            }
			if(in_array($module_name, C('EXPORT_BARCODE_MODULE'))) {//added by jp 20140227
				$this->pushOutput('<span class="icon icon-list-export" title="'.title('exportBarcode').'" onclick="$.quicklyExportBarcode(\'' . $module_name . '\', ' . $list['id'] . ')"></span>'); 		
			}	
            if(in_array($module_name,C('QUICK_EXPORT_BARCODE_MODULE'))){//added by yyh 20141031
                $this->pushOutput('<span class="icon icon-list-export" title="'.title('exportBarcode').'" onclick="$.exportInstockBarcode(\'' . $module_name . '\', ' . $list['id'] . ')"></span>');
            }
			if (isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['BACKSHELVES'])) {//added by jp 20140611 拣货导入重新上架，直接根据未分配数量扣减可销售库存
				$this->pushOutput('<span class="icon icon-list-returnhand" url="'.U('/'.$module_name.'/backShelves/id/'.$list['id']).'" title="'.L('backshelvesed').'" onclick="$.cancel(this)"></span>');
			}	
            if ($module_name == 'Factory' && ACTION_NAME == 'index') {//added by yyh 20141028是否启用API
                if (!empty($list['auth_token'])) {
                    $this->pushOutput('<span class="icon icon-pattern-batchversion" url="' . U('/' . $module_name . '/updateApi/id/' . $list['id']) . '" title="' . L('update_api_token') . '" onclick="$.cancel(this)"></span>');
                    if ($list['auth_status'] == 0) {
                        $this->pushOutput('<span class="icon icon-pattern-nocheck" url="' . U('/' . $module_name . '/updateApi/id/' . $list['id'] . '/state/1') . '" title="' . L('start_api') . '" onclick="$.restore(this)"></span>');
                    } else {
                        $this->pushOutput('<span class="icon icon-pattern-check" url="' . U('/' . $module_name . '/updateApi/id/' . $list['id'] . '/state/0') . '" title="' . L('stop_api') . '" onclick="$.cancel(this)"></span>');
                    }
                }
            }
            if($module_name =='Instock' && ACTION_NAME == 'index'){//added yyh 20141104
                $this->pushOutput('<span class="icon icon-shortcut-down" title="' . L('export_instock_detail') . '" onclick="javascript:ExportMytable(\'instockDetail\',' . $list['id'] . ',\'instock\');"></span>');
            }
            if(($module_name =='Instock' && ($_SESSION[C('ADMIN_AUTH_KEY')] || $_SESSION["LOGIN_USER"]["role_type"] == C('WAREHOUSE_ROLE_TYPE'))) && in_array($list['instock_type'], C('CAN_STORAGE'))){//added yyh 20141111 发货单入库
                $this->pushOutput('<span class="icon icon-list-audit-record" title="'.L('instock_storage').'" onclick="addTab(\''.U('/InstockStorage/add/id/'.$list['id']).'\',\''.title('storage').'\')"></span>');
            }
			if(isset($_SESSION['_MODULE_ACCESS_'][strtoupper($module_name)]['CONFIRM'])&&($list['is_confirm']==1||!isset($list['is_confirm']))) {
				$confirm_title	= title('confirm', $module_name);
				if($list['confirm_state'] == 1 && ($module_name =='Recharge') && ($_SESSION[C('ADMIN_AUTH_KEY')] === true || ($_SESSION["LOGIN_USER"]["role_id"] == C('FINANCIAL_MANAGER_ROLE_ID')))){
					$confirm_title	= L('recall') . $confirm_title;
					$logo_class		= 'icon icon-list-returnhand';
					$confirm_state	= 0;
				}else{
//					$logo_class		= 'icon icon-list-hand';
//					$confirm_state	= 1;
				}				
				$this->pushOutput('<span class="'.$logo_class.'" url="'.U('/'.$module_name.'/confirm/id/'.$list['id'].'/confirm_state/' . $confirm_state.'/money/'.$list['money']).'" title="'.$confirm_title.'" onclick="$.cancel(this)"></span>');
			}
			$operate_show	= array();
		}else{
			$operate_show	= $this->operate_show;
		}
		$operate_show	= array_merge($operate_show, (array)$this->expand_operate_show);
		//自定义操作列
		foreach($operate_show as $key=>$value){
			if (isset($value['link_type'])) {//added by jp 20140512 根据link_type字段的值显示不同的操作方法
				$fields	= array('module_name', 'role', 'class', 'link_id', 'url', 'title', 'onclick', 'show');
				foreach ($fields as $field) {
					is_array($value[$field]) && $value[$field]	= $value[$field][$list[$value['link_type']]];
				}
			}
			$module_name=empty($value['module_name'])?$module_name:$value['module_name'];
			$right	= RBAC::getModuleAccessList(USER_ID,$module_name);
			$role	= strtoupper($value['role']);
			$class	= $value['class'];
			$link_id= empty($value['link_id'])?'id':$value['link_id'];
			$url	= smarty_function_getUrl($value['url'] ? $value['url'] : $module_name . '/' . $value['role'],$link_id,$list);
			if(!empty($value['title'])){
				$title	 = $value['title'];
			}else{
				$actions = explode('/',$url);
				$title	 = title($actions[1],$module_name);
			}
			$onclick = empty($value['onclick'])?'$.edit(this)':$value['onclick'];
			if(isset($right[strtoupper($module_name)][$role]) && ((!isset($value['show_field']) && (!isset($value['show']) || $value['show'] == true)) || (isset($value['show_field']) && $list[$value['show_field']] == 1))) {
				$this->pushOutput('<span class="'.$class.'" url="'.U('/'.$url).'" title="'.$title.'" onclick="'.$onclick.'"></span>');
			}
		}
	}
	
	public function getAutoShow($info,$list){
		if(empty($info) || $info['show'] === false){
			return ;
		}
		$output		= '<a id="auto_show_img" tabindex="-1" onclick="$.autoShow(this,\''.$info['module'].'\',\''.$info['type'].'\')" pid="' . $list[$info['field']] . '" href="javascript:;"><img src="'.__PUBLIC__.'/Images/Default/atshow_ico.gif"></a>';
		return $output;
	}
	
	public function getTfoot(){
		$show	= $this->show;
		//列表需要展开
		$i=0;
		if($this->all_total || $this->page_total){
			$this->pushOutput('<tfoot>');
			$totals	= array('page_total', 'all_total');
			foreach ($totals as $total) {
				if($this->$total){
					foreach($this->$total as $key=>$value){
						$this->pushOutput('<tr>');
						if($this->listType != 'total' && ((C('YTT_TABLE_SERIAL') && $this->serial !== false) || $this->serial == true)){
							$this->pushOutput('<td>&nbsp;</td>');
						}
						if($this->expand==true){
							$this->pushOutput('<td>&nbsp;</td>');
						}
						foreach($show as $cols){
							$return = $this->checkFlow($cols);
							if($return==false) continue;
							$td			= $this->getTbodyTd($cols,$value);
							$field		= $this->getTfootTdField($cols,$value,$total);
							$this->pushOutput($td);
							$this->pushOutput($field);
							$this->pushOutput('</td>');
							$i++;
						}
						//是否需要加入操作列
						if($this->operate==true&&empty($thead)){
							$this->pushOutput('<td style="width:100px;" class="operate" rowspan="'.$rowspan.'"></td>');
							$i++;
						}
						$this->pushOutput('</tr>');
					}
					$this->cols_num	= $i;
				}			
			}
			$this->pushOutput('</tfoot>');
		}
	}

	/**
	 * 获取合计显示信息
	 *
	 * @param array $info
	 */
	public function getTfootTdField($info,$list,$total_type = 'total'){
		$field = $info['total_title'];
		if($info['total_title']){
			if($info['total_title'] == 'title'){
				$output		= $total_type == 'page_total' ? L('page_total') : L('total');
			}else{
				$output		= $list[$field];
			}
		}
		return $output;
	}

	/**
	 * 输出内容
	 *
	 * @param string $str
	 * @return string
	 */
	public function pushOutput($str){
		$this->output	.= $str;
		return $this->output;
	}
}
?>