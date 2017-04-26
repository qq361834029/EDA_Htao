<?php

/**
 * Smarty扩展函数
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category    扩展
 * @package		Smarty
 * @author      何剑波
 * @version		2.1,2013-07-22
 */

require_once(SMARTY_PLUGINS_DIR . 'shared.escape_special_chars.php');

/**
* State状态
* @param array $info
* @see 函数 acr 
* @return string
*/
function smarty_function_State($info){
	extract($info);
	$val	=	$to_hide==2 ?'checked':'';
	return '<li><label>'.L('state').'：</label>
	<input class="search_num" type="radio" name="query[to_hide]" checked  value="1" >'.L('use').'
	<input class="search_num" type="radio" name="query[to_hide]" '.$val.' value="2" >'.L('cancel').'
	</li>';
}

/**
 * select下拉框
 * @param array $info
 *  - string value 选中值
 *  - array	 data 数据源
 *  - string initvalue 初始值
 *  - bool empty_value 设置默认为空 或者 0 
 *  - bool empty   是否有空选项
 *  - bool no_default 是否有默认
 *  - bool realonly 是否为只读
 *  - string table 数据源 table
 *  - string key 数据源 字段索引
 *  - string field 数据源 字段
 *  - string order 数据源 排序
 *  - string where 数据源 搜索条件
 * @return string
 */
function smarty_function_select($info){

	foreach($info as $_key=>$_val){
		switch($_key){
			case 'value': 	
				$$_key 	= $_val;break;
			case 'data': 	
				$$_key	= $_val;break;
			case 'initvalue': 
				$$_key	= $_val;break;
			case 'empty_value':
				$$_key	= $_val;break;
			case 'empty':
				$$_key	= $_val;break;
			case 'no_default':
				$$_key	= $_val;break;
			case 'readonly':
				$$_key	= $_val;break;
			case 'table':	
				$$_key	= $_val;break;
			case 'key':	
				$$_key	= $_val;break;
			case 'field':	
				$$_key	= $_val;break;
			case 'order':
				$$_key	= $_val;break;
			case 'where':
				$$_key	= $_val;break;
			case 'filter'://added by jp 20140126
				$$_key	= $_val;break;
			case 'allow'://added by jp 20141030
				$$_key	= $_val;break;			
			default:
				$extra	.=' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';break;
		}
	}
	if (empty($value) && !empty($initvalue)) {$value = $initvalue;}
	if ($empty_value) {$value = $initvalue;}
	$empty_value =$empty_value==false?'':0;//设置默认未空 或者 0
	!is_array($filter) && $filter	= $filter ? explode(',', $filter) : array();
	!is_array($allow) && $allow	= $allow ? explode(',', $allow) : array();
	$html = '<select '.$extra.' >';
	if (!$no_default) {
		if (!$empty) {
			!$readonly && $html .= '<option value="-2">'.L('all').'</option>';
		}else { 
                !$readonly && $html .= '<option value="'.$empty_value.'">'.L('please_choose').'</option>';	
		}
	}
	if ($table && $key && $field) {		
		if ($order) {
			$data = M($table)->field($key.','.$field)->where($where)->order($order)->select();
		} else {
			$data = M($table)->field($key.','.$field)->where($where)->select();
		}		
		foreach ($data as $row){
			if (in_array($row[$key], $filter) || (!empty($allow) && !in_array($row[$key], $allow))) {//added by jp 20140126
				continue;
			}
			$row[$key]==$value && $selected = 'selected';
			$html .= '<option value="'.smarty_function_escape_special_chars($row[$key]).'" '.$selected.'>'.smarty_function_escape_special_chars($row[$field]).'</option>';
			$selected = '';
		}
		$html .= '</select>';
		return $html;
	}
	if ($data) {  
		foreach ($data as $key=>$caption){
			if (in_array($key, $filter) || (!empty($allow) && !in_array($key, $allow))) {//added by jp 20140126
				continue;
			}			
			($key==$value && isset($value)) && $selected = 'selected';
			if ($readonly && $key!=$value) {
				continue;
			}
			$html .= '<option value="'.smarty_function_escape_special_chars($key).'" '.$selected.'>'.smarty_function_escape_special_chars($caption).'</option>';
			$selected = '';
		}
		$html .= '</select>';
		return $html;
	}
	return '';
}


/**
 * 生成radio选择框，存在数据源（data）直接遍历，否则取表，操作未增加
 * @param array 数据源
 * - string value 选中值
 * - string initvalue 初始选中值
 * - string onclick  js onclick事件
 * - array data 数据源
 * - string name 控件名称
 * - string id 控件id
 * - string caption 控件说明
 * @return string
 */
function smarty_function_radio($info){
	extract($info,true);
	$html = ''; 
	if (($value=='') && !empty($initvalue)) {$value = $initvalue;}
	if ($data) {
		$onclick && $onclick = 'onclick="'.$onclick.'"';
		foreach ($data as $key=>$caption){
			$key==$value && $checked = 'checked';
			$html .= '<input type="radio" name="'.$name.'" id="'.$id.'" value="'.$key.'" '.$onclick.' '.$checked.'>'.$caption;
			$checked = '';
		}
		return $html;
	}
}

/**
 * 生成checkbox选择框，存在数据源（data）直接遍历，否则取表，操作未增加
 * @param array 数据源
 * - array	data 数据源
 * - string table 数据源table
 * - string key 数据源字段索引
 * - string filed 数据源 字段
 * - string value 选中值 (多个用 ， 隔开)
 * - string name 控件名称
 * - string id 控件id
 * - string onclick js onclick事件
 * @return string
 */
function smarty_function_checkbox($info){
	extract($info,true);
	$html = '';
	if ($table && $key && $field) {
		$data = M($table)->field($key.','.$field)->where($where)->select();
	}
	if (is_array($data) && count($data) > 0) {
		if ($value) {
			if (!is_array($value) && strpos($value,',')) {
				$ary = @explode(',',$value);
			}else {
				$ary[] = $value;
			}
		}
		if ($table==='properties' && C('BARCODE')) {
			$temp		= S('barcode');
			$barcode	= $temp['barcode'];
			$barlength	= true;
		}
		$input_attr	= ' type="checkbox" name="'.$name.'" id="'.$id.'" ';
		if ($onclick) {
			$input_attr	.= ' onclick="'.$onclick.'" ';
		}
		foreach ($data as $sub=>$row){
			if ($table && $key && $field) {
				$item_value		= $row[$key];
				$item_caption	= $row[$field];
			} else {
				$item_value		= $sub;
				$item_caption	= $row;
			}
			$checked		= in_array($item_value,$ary) ? 'checked' : '';
			// 属性值时需要输出条码长度
			if ($barlength === true) {
				$length			= intval($barcode[$item_value]);
				$barcode_length = $length > 0 ? ' barlength="'.$length.'"' : '';
			}
			$html .= '<input value="'.$item_value.'" ' . $input_attr . $checked . $barcode_length . ' />&nbsp;'.$item_caption.'&nbsp;&nbsp;';
		}
		return $html;		
	}
	return '';
} 
/**
 * 显示上传图片
 *
 * @param array $info
 * - array from 数据源
 * - string extension 扩展名称 (预留2.03 pdf格式)
 * @return string
 */
function smarty_function_showFiles($info) {
	extract($info);
	$html = '';
    foreach ((array)$from as $row) {
		$file_name 	= 'small_'.$row['file_url'];
		$url = getUploadPath($row['relation_type']).$file_name;
		$info = pathinfo($url);
        $width  = $info['extension']=='pdf' ? '' : 'width:130px;';
		$html .= '<div style="float:left;'.$width.'overflow:hidden;margin-bottom:10px;" id="file_upload_'.$row['id'].'">';
		!empty($delete) && $html .= '<div style="width:130px;"><a href="javascript:;" onclick="javascript:$.deleteUpload('.$row['id'].')">
										<img src="'.PUBLIC_PATH.'Images/Default/close_gray.png"></a>
									</div>';
		if ($info['extension']=='pdf') {
			$html .= '<a href="'.U('/Ajax/downPdf/id/'.$row['id']).'" target="_blank">'.$row['cpation_name'].'</a>';
		}else {
			
			$html .= '<a href="'.U('/Ajax/showimg',array('id'=>$row['id'])).'" target="_blank"><img src="'.U('Ajax/img',array('id'=>$row['id'])).'"></a>';;
		}
		$html .= '</div>';
    }
	return $html;
} 
/**
 * 币种选择框
 * @param array $params
 *  - string type:嵌套html标签 tr,li,dt
 *  - string title:标题
 *  - string require:是否必填
 *  - bool view:是否为查看
 *  - string id:控件id
 * @return string
 */
function smarty_function_currency($params,&$smarty){
	$view=false;
	foreach($params as $_key=>$_val){
		switch($_key){
			case 'type':
				$$_key	= $_val;break;
			case 'title':
				$$_key	= $_val;break;
			case 'require':
				$$_key	= '__*__';break;
			case 'view':
				$$_key	= $_val;break;
			case 'id':
				$info[$_key]=$_val;
				$extra_id	= $_val;break;
			default:
				$info[$_key]=$_val;
				break;
		}
	}
	$currenty_cache	= $smarty->getVariable('currency_data')->value;
	if($currenty_cache['data']==$info['data']){
		$tmp	= $currenty_cache['info'];
	}else{
		$tmp	= M('currency')->where('to_hide=1 and id in ('.(empty($info['data'])?'0':$info['data']).')')->select();
		$smarty->assign('currency_data',array('data'=>$info['data'],'info'=>$tmp));
	}
	foreach($tmp as $row){
		$data[$row['id']]=$row['currency_no'];
	}
	!isset($info['empty']) && $info['empty'] = true;
	if(count($data)==1) {
		$info['value'] = key($data);
	}
	$info['no_default'] = false; 
	$info['combobox'] = true; 
	$info['data'] = $data;
	if(count($data)==1){
		return '<input type="hidden" name="'.$info['name'].'" value="'.key($data).'" id="'.$extra_id.'">';
	}
	$select	= $view==false?smarty_function_select($info):$data[$info['value']].'<input type="hidden" id="currency_id" name="'.$info['name'].'" value="'.$info['value'].'">';
	$require = $view==true?'':$require;
	if(!empty($type)){
		if($type=='tr'){
			$output = '<tr><td>'.$title.'：</td><td class="t_left">'.$select.$require.'</td></tr>';
		}else{
			if($type=='li'&&ACTION_SENT_EMAIL==1){
				$style=' style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;"';
			}
			$output	= '<'.$type.$style.'>'.$title.'：'.$select.$require.'</'.$type.'>';
		}
		return $output;
	}else{
		return $select;
	}
} 

/**
 * 上传图片
 * @param array $info
 * - int type 类型
 *   -- 1 产品
 *   -- 2 打版
 *   -- 3 销售
 *   -- 4 Excel
 * - string rdata 返回值类型 默认为 json
 * - string tocken 附件标识
 * - int string 关联id
 * - string allowTypes 上传附件类型 默认为：'jpg','gif','bmp','png','jpeg' 
 * @return string
 */
function smarty_function_upload($info){
	foreach($info as $_key=>$_val){
		switch($_key){
			case 'tocken':
				$$_key	= $_val;break;
			case 'type':
				$$_key	= $_val;break;
			case 'sid':
				$$_key	= $_val;break;
			case 'rdata':
				$$_key	= $_val;break;
			case 'onchange':
				break;
			case 'allowTypes':
				$$_key	= $_val;break;
			case 'multi':
				$$_key	= $_val;break;			
			default:
				$extra	.=$_key.'="'.$_val.'"';break;
		}
	}
	$name_type	= 'type';
	$name_rdata	= 'rdata';
	$name_allowTypes	= 'allowTypes';
	if ($multi === true){//多文件上传，解决同一表单多类型文件上传不了的bug
		$upload_control_name_suffix	= '_' . md5(time().getRands());
		$name_type	.= $upload_control_name_suffix;
		$name_rdata	.= $upload_control_name_suffix;
		$name_allowTypes	.= $upload_control_name_suffix;		
		$extra	.= 'upload_control_name_suffix="' . $upload_control_name_suffix . '"';
	}
	$rdata		= empty($rdata)?'json':$rdata;
	$output		= '<input type="hidden" name="ajax" value="1">';
	$output		.= '<input type="hidden" name="tocken" value="'.$tocken.'">';
	$output		.= '<input type="hidden" name="' . $name_type . '" value="'.$type.'">';
	$output		.= '<input type="hidden" name="sid" value="'.$sid.'">';
	$output		.= '<input type="hidden" name="' . $name_rdata . '" value="'.$rdata.'">';
	$output		.= '<input type="hidden" name="' . $name_allowTypes . '" value="'.$allowTypes.'">';
	$output		.= '<input type="file" name="file_upload" id="file_upload" onchange="$.uploadFile(this);" '.$extra.' value="" ><span id="upload_response'.$upload_control_name_suffix.'"></span>';
    $output		.= '<div id="file_uploadQueue'.$upload_control_name_suffix.'" class="uploadifyQueue"></div>';
	return $output;
}

/**
 * 审核
 * @param unknown_type $params
 */
function smarty_function_auditor($params){
	
}

/**
 * 审核
 * @param unknown_type $params
 */
function smarty_function_auditStateView($params){
	
}


/**
 * 明细输出默认仓库
 * @param string $w_name 单仓库时 隐藏域的控件名称
 * @param object $smarty
 * @param bool $repeat
 */
function smarty_function_getDefaultWarehouse($w_name,&$smarty,&$repeat){
	if($repeat==true){
		return ;
	}
	$default = $smarty->getVariable('default_warehouse')->value;
	if(empty($default)){
		$default = M('Warehouse')->where('to_hide=1 and is_default=1 and is_use=1')->find();
		$smarty->assign('default_warehouse',$default);
	}
	$w_name = empty($w_name)?'detail['.$smarty->getVariable('index')->value.'][warehouse_id]':$w_name;
	print '<input type="hidden" name="'.$w_name.'" value="'.$default['id'].'" >';
}

/**
 * 明细获取流程币种
 *
 * @param string $type
 * @param string $currency_name
 * @param object $smarty
 * @param bool $repeat
 * @return bool
 */
function smarty_function_getFlowCurrency($type,$currency_name,&$smarty,&$repeat){
	if($repeat==true){
		return ;
	}
	$currency_name	= empty($currency_name)?'detail['.$smarty->getVariable('index')->value.'][currency_id]':$currency_name;
	$data	= C(str_replace('flow_','',strtolower($type)));
	$currenty	= S('currency');
	$data	= @explode(',',$data);
	if(empty($type)){
		return true;
	}
	foreach ($data as $id) {
		$tmp[$id] = $currenty[$id]['currency_no'];
	}
	$data	= $tmp;
	if(count($data)==1){
		print '<input type="hidden" name="'.$currency_name.'" value="'.key($data).'" id="currency_id">';
		return false;
	}else{
		return true;
	}
}

/**
 * 添加条形码区域
 * @param array $params
 * @return string
 */
function smarty_function_barcode($params){
	$output	= '';
	if(C('barcode')==1&&(MODULE_NAME!='PreDelivery'&&MODULE_NAME!='Delivery')){
		$output	.= ''.L('barcode').'：<input id="barcode" class="spc_input" type="text" name="barcode" jqbarcode style="width:140px!important;">';
	}
	return $output;
}
/**
 * 取条形码
 * @param int $p_id 产品id
 * @param int $color_id 颜色id
 * @param int $size_id 尺码id 
 */
function smarty_function_getBarcode($p_id, $color_id  = 0, $size_id = 0){
	if(intval($p_id)<=0){
		return ;
	}
	$cache_barcode = S('barcode_'.$p_id);		 
	if (empty($cache_barcode)) {
		getProductBarCodeCache($p_id);
		$cache_barcode	= S('barcode_'.$p_id);
	}
	
	return $cache_barcode[$color_id][$size_id];
}
/**
 * 明细操作列
 * @param arrat $params
 *  - string width 操作列宽度
 *  - array show 操作列显示
 * @return string
 */
function smarty_function_detail_operation($params,&$smarty){
	define('TPL_MODULE_NAME', !empty($smarty->getVariable('tpl_module_name')->value) ? $smarty->getVariable('tpl_module_name')->value : MODULE_NAME);
	define('TPL_ACTION_NAME', !empty($smarty->getVariable('tpl_action_name')->value) ? $smarty->getVariable('tpl_action_name')->value : ACTION_NAME);
	$item	= $smarty->getVariable('item')->value;
	$show	= $smarty->getVariable('detail_op_show')->value;
	$detail_tfoot	= $smarty->getVariable('detail_tfoot')->value;
    $rs     = $smarty->getVariable('rs')->value;
	extract($params);
	$width	= $width?$width:'60';
	if($show !== false && empty($show) || in_array(TPL_ACTION_NAME,$show)){
		$state	= $item[key($viewstate)];
		if(in_array($state,reset($viewstate))&&!empty($viewstate)){
			return '<td class="t_center">---</td>';
		}
		if(empty($span)){
			if($smarty->getVariable('detail_tfoot')->value==0){
				if(!empty($del)&&!in_array($item[key($del)],reset($del))&&!empty($item)){
					//备注：装柜时 部分装柜不需要删除
					return '<td width="'.$width.'">
							<span class="icon icon-add-plus" onclick="$.copyRowWithFrom(this)" title="'.L('add').'"></span>

							</td>';
                }elseif (TPL_ACTION_NAME == 'selectProduct') {//added yyh 20150525 勾选
                    return '<td width="'.$width.'">
                            <span class="icon icon-pattern-nocheck" value="'.$item['id'].'" title="'.L('check_product').'" onclick="$.ButtenCheck(this)"></span>
                            </td>';
                }elseif(in_array(TPL_MODULE_NAME,array('DomesticWaybill'))||(TPL_MODULE_NAME=='ReturnSaleOrder' && (empty($rs)||$rs['is_related_sale_order']==1))){//added yyh 20150525 无需新增
                    $url = ' url="'.U('/'.TPL_MODULE_NAME.'/deleteDetail/id/'.$item['id']).'" ';
                    //退货单修改处理完成状态的单子，不允许删除明细        add by lxt 2015.11.13  
                    if (TPL_MODULE_NAME=='ReturnSaleOrder' && $item['return_sale_order_state']==C('PROCESS_COMPLETE')){
                        $del_hide   =   " style='display:none' ";
                    }
                    return '<td width="'.$width.'">
						<span style="display: none;" class="icon icon-add-plus" onclick="$.copyRowWithFrom(this, \'' . $insertRowSort . '\')" title="'.L('add').'"></span>
						<span '.$del_hide.' class="icon icon-del-plus" onclick="$.delRow(this,0);"'.$url.'title="'.L('delete').'"></span>
                        </td>';                   
                }elseif(in_array(TPL_MODULE_NAME,array('WarehouseFee'))){//added YYH 20150619
                    $url = ' url="'.U('/'.TPL_MODULE_NAME.'/deleteDetail/id/'.$item['id']).'" ';
                    return '<td width="'.$width.'">
							<span class="icon icon-add-plus" onclick="$.copyRowWithFrom(this, \'' . $insertRowSort . '\');setNextStartDay(this);" title="'.L('add').'"></span>
							<span class="icon icon-del-plus" onclick="deleteWarehouseFee(this);$.delRow(this,0);"'.$url.'title="'.L('delete').'"></span>
                            </td>';
                }elseif(in_array(TPL_MODULE_NAME,array('PackBox'))){//added yyh 20150826
                    $url = ' url="'.U('/'.TPL_MODULE_NAME.'/deleteDetail/id/'.$item['id']).'" ';
                    return '<td width="'.$width.'">
                            <span class="icon icon-del-plus" onclick="$.delRow(this,0);"'.$url.'title="'.L('delete').'"></span>
							</td>';
                }elseif(in_array(TPL_MODULE_NAME,array('OutBatch'))){//added yyh 20150901
                    $url = ' url="'.U('/'.TPL_MODULE_NAME.'/deleteDetail/id/'.$item['id']).'" ';
                    return '<td width="'.$width.'">
                            <span class="icon icon-del-plus" onclick="setNumber(this);$.delRow(this,0);"'.$url.'title="'.L('delete').'"></span>
                            </td>';
                }else{
					// 添加需要业务规则验证的明细－－何剑波
					$url = '';
					if (in_array(TPL_MODULE_NAME,C('AUTO_DELETE_DETAIL'))) {
						if (TPL_MODULE_NAME == 'Instock' && $smarty->getVariable('step')->value != 2) {//头程发货删除装箱明细 added by jp 20140314
							$url = ' url="'.U('/'.TPL_MODULE_NAME.'/deleteBoxDetail/id/'.$item['id']).'" ';
						} else {
							$url = ' url="'.U('/'.TPL_MODULE_NAME.'/deleteDetail/id/'.$item['id']).'" ';
						}
					}
                    if(MODULE_NAME=='Shipping'){
                       $copy_detail     = '<span class="icon icon-list-addInvoice" onclick="$.copyRowWithoutClearNew(this)" title="'.L('copy').'"></span>'; 
                    }
					return '<td width="'.$width.'">
							<span class="icon icon-add-plus" onclick="$.copyRowWithFrom(this, \'' . $insertRowSort . '\')" title="'.L('add').'"></span>
							<span class="icon icon-del-plus" onclick="$.delRow(this,0);"'.$url.'title="'.L('delete').'"></span>
							'.$copy_detail.'
                            </td>';
				}
			}else{
//				if(TPL_MODULE_NAME=='PreDelivery'||TPL_MODULE_NAME=='Delivery'){
//					return '<td></td>';
//				}
                if(TPL_MODULE_NAME=='ReturnSaleOrder'){
					return '<td width="'.$width.'">
						<span style="display: none;" class="icon icon-add-plus" onclick="$.copyRowWithFrom(this, \'' . $insertRowSort . '\')" title="'.L('add').'"></span>
						</td>';
				}elseif(in_array(TPL_MODULE_NAME,array('DomesticWaybill','PackBox','OutBatch'))){//added yyh 20150525 国内运单不想要添加
                    return '<td width="'.$width.'">
                            </td>';
                }
				return '<td width="'.$width.'">
						<span class="icon icon-add-plus" onclick="$.copyRowWithFrom(this, \'' . $insertRowSort . '\')" title="'.L('add').'"></span>
						</td>';
			}
		}else{
			if($smarty->getVariable('detail_tfoot')->value==0){
				$output	= '<td width='.$width.'>';
				foreach((array)$span as $_key=>$_val){
					$tfoot	= !isset($_val['tfoot'])?true:$_val['tfoot'];		//tfoot的操作列是否显示
					if($tfoot==false&&$detail_tfoot==1){
						continue;
					}
					$show	 = $_val['show'];
					unset($_val['show']);
					unset($_val['tfoot']);
					if(!empty($_val['link_id'])){
						$_val['url']	= U('/'.smarty_function_getUrl($_val['url'],$_val['link_id'],$item));
						unset($_val['link_id']);
					}
					if(in_array($item[key($show)],reset($show))||empty($show)){
						$output	.= '<span ';
						foreach((array)$_val as $key=>$value){
							$output	.= $key.'="'.$value.'" ';
						}
						$output	.= '></span>';
					}
				}
				$output	.= '</td>';
				return $output;
			}else{
				return '<td></td>';
			}
		}
	}else{
		return ;
	}
}


// 审核信息
function smarty_function_staff($info){
	if ($info) {
		extract($info);
		if(empty($add_user)){
			$var = M('User')->field('user_name')->find(intval($id));
			$add_user = $var['user_name'];
		}
	}else {
		$add_user = getUser('real_name') ? getUser('real_name') :getUser('user_name');
	}
	return '<div style="padding-left:10px;margin:0 auto;height:28px;line-height:28px;width:98%;background-color: #f5f5f5;">
<span style="width:260px;float:right;text-align:right;padding-right:15px;">'.L('doc_staff').'：'.$add_user.'</span><span style="width:260px;float:right;text-align:right;padding-right:15px;">'.L('doc_date').'：'.$create.'</span></div>';
}

/**
* 取仓库
* @param array $params
*  type:html标签
*  title:显示标题
*  hidden：隐藏域属性和属性值
*  url：aotocomplete 默认为AutoComplete/warehouse
*  show：配置为单一仓库时是否显示仓库名称 默认false
*  view：是否为查看信息
*  empty:是否显示空
*  class:控件样式
*  require:是否显示必填
* 
*/
function smarty_function_warehouse($params,&$smarty){
	$hidden	= $default	= array();
	$url	= U('AutoComplete/warehouse');
	$view	= false;
	$empty	= false;
	$input['class']='w100 ';
	foreach($params as $_key=>$_val){
		switch($_key){
			case 'type':
				$$_key	= $_val;break;
			case 'title':
				$$_key	= $_val;break;
			case 'hidden':
				$$_key	= (array)$_val;break;
			case 'url':
				$$_key	= U($_val);break;
			case 'view':
				$view	= $_val;break;
			case 'empty':
				$$_key	= $_val;break;
			case 'class':
				$input['class']	.= $_val;break;
			case 'require':
				$$_key	= '__*__';break;
			default:
				$input[$_key]=$_val;
				break;
		}
	}
	$input['url']=$url;
	//取默认仓库
	$default	= $smarty->getVariable('default_warehouse')->value;
	if(empty($default)){
		$default	= M('Warehouse')->where('to_hide=1 and is_default=1 and is_use=1')->find();
		$smarty->assign('default_warehouse',$default);
	}
	//初始化 默认显示默认仓库
	if(($hidden['value']==0||empty($hidden['value']))&&$empty==false){
		$hidden['value']=$default['id'];
		$input['value']=$default['w_name'];
	}
	if(C('multi_storage')==1){
		$output	= smarty_function_setHtml($type,$title,$input,$hidden,$view,$require);
	}else{
		if($hidden['value']){
			$output	= '<input type="hidden" name="'.$hidden['name'].'" value="'.$hidden['value'].'" >';	
		}else{
			$output	= '<input type="hidden" name="'.$hidden['name'].'" value="'.$default['id'].'" >';	
		}
	}
	return $output;
}

/**
 * 公司
 * @param array $params
 *  - string type 标签类型
 *  - string title 标题
 *  - string url autocomplete的地址
 *  - bool view 是否查看
 *  - array hidden 隐藏域参数
 *  - string require 是否显示为必填
 * @return string
 */
function smarty_function_company($params){
	$url	= 'AutoComplete/company';
	$view	= false;
	foreach($params as $_key=>$_val){
		switch($_key){
			case 'type':
				$$_key	= $_val;break;
			case 'title':
				$$_key	= $_val;break;
			case 'url':
				$$_key	= $_val;break;
			case 'view':
				$$_key	= $_val;break;
			case 'hidden':
				$$_key	= (array)$_val;break;
			case 'require':
				$require='__*__';break;
			default:
				$input[$_key]=$_val;
				break;
		}
	}
	if(C('show_many_basic')==1){ //多个公司
		$input['url']	= U($url);
		$output	= smarty_function_setHtml($type,$title,$input,$hidden,$view,$require);
	}else{
		$parameter	= '';
		foreach($hidden as $_key=>$_val){
			$parameter	.= $_key.'="'.$_val.'" ';
		}
		$output	= '<input type="hidden" value="'.C('DEFAULT_BASIC_ID').'" ' . $parameter . '/>';
	}
	return $output;
}


/**
 * 验证码
 * @author jph 20140801
 * @param array $params
 *  - string type 标签类型
 *  - string title 标题
 *  - string name 输入框name属性 默认为captcha
 *  - string id 输入框id属性 默认与name相同
 * @return string
 */
function smarty_function_captcha($params){
	foreach($params as $_key=>$_val){
		switch($_key){
			case 'type':
				$$_key	= $_val;break;
			case 'title':
				$$_key	= $_val;break;
			case 'name':
				$$_key	= $_val;break;	
			case 'id':
				$$_key	= $_val;break;				
			default:
				break;
		}
	}
	empty($name)	&& $name	= 'captcha';
	empty($id)		&& $id		= $name;
	$require			= '__*__';
	$captcha_token		= md5(time().getRands());
	$var_captcha		= C('VAR_CAPTCHA');
	$url				= U('/Public/buildImageVerify/' . $var_captcha . '/' . $captcha_token);
	$hidden_html		= '<input type="hidden" name="' . $var_captcha . '" value="' . $captcha_token . '" />';
	$input_html			= '<input type="text" name="' . $name . '" id="' . $id . '" autocomplete="off">';
	$image_html			= '<img src="' . $url . '" onclick="$(this).attr(\'src\', \'' . $url . '?\' +Math.random())" style="vertical-align: middle; cursor: pointer; height: 25px;" />';
	$html				= $hidden_html . $input_html . $require . $image_html;
	switch($type){
		case 'tr':
			$output	 = '<tr><td align="right">'.$title.'：</td>';
			$output	.='<td class="t_left">'.$html.'</td></tr>';
			break;
		case 'td':
			$output	 = '<td>'.$title.'：</td>';
			$output	.='<td class="t_left">'.$html.'</td>';
			break;
		default:
			$output	 = empty($type)?'':'<'.$type.'>';
			$output	.= empty($title)?'':'<label>'.$title.'：</label>';
			$output	.= $html;
			$output	.= empty($type)?'':'</'.$type.'>';
			break;
	}			  
	return $output;
}

/**
 * 显示html
 *
 * @param string $type 类型 ：tr li dt
 * @param string $title 标题
 * @param array $input 文本框
 * @param array $hidden 隐藏域
 * @param bool $view 是否为查看
 * @param string $require 必填项
 * @return string
 */
function smarty_function_setHtml($type,$title,$input=array(),$hidden=array(),$view=false,$require=null){
	//隐藏域
	$hidden_html	= '<input type="hidden" ';
	foreach($hidden as $_key=>$_val){
		$hidden_html	.= $_key.'="'.$_val.'" ';
	}
	$hidden_html	.= '/>';
	if($view==true){
		$input_html = $input['value'];
		$require	= '';
	}else{
		$input_html		= '<input type="text" ';
		foreach($input as $_key=>$_val){
			if($_key=='eval'){
				$input_html	.= $_val.' ';
			}else{
				$input_html	.= $_key.'="'.$_val.'" ';
			}
		}
		$input_html	.= 'jqac >';
	}
	switch($type){
		case 'tr':
			$output	= '<tr><td>'.$title.'：</td>';
			$output	.='<td class="t_left">'.$hidden_html.$input_html.$require.'</td></tr>';
			break;
		case 'td':
			$output	= '<td>'.$title.'：</td>';
			$output	.='<td class="t_left">'.$hidden_html.$input_html.$require.'</td>';
			break;
		default:
			if($type=='li'&&ACTION_SENT_EMAIL==1){
				$style	= ' style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;"';
			}
			$output	= empty($type)?'':'<'.$type.$style.' >';
			$output	.= empty($title)?'':'<label>'.$title.'：</label>';
			$output	.= 	$hidden_html.$input_html.$require;
			$output	.= empty($type)?'':'</'.$type.'>';
			break;
	}
	return $output;
}
/**
 * 解析url
 *
 * @param string $url    url为空时 取link_id的值解析（module_id），是数组时取第一个索引值
 * @param string or array $link_id
 * @param array $list
 * @return string
 */
function smarty_function_getUrl($url,$link_id,$list){
	if(empty($url)){
		//url为空时 默认取link_id来判断模块 action=view
		$tmp	= $link_id;
		is_array($tmp)?$tmp=reset($tmp):$tmp;
		list($module,$id)=@explode('_',$tmp);
		$url	= ucfirst($module).'/'.'view/id/'.$list[$link_id];
	}else{
		$valid	= isset($list[$url]);
		$url	= $valid?$list[$url]:$url;
	}
	$url_type	= stripos('_'.$url,'http');
	if($url_type>0||($valid&&empty($list[$url]))){
		return $url;
	}
	if(is_array($link_id)){
		foreach($link_id as $key=>$val){
			$tmp  = !isset($list[$val])?$val:$list[$val];
			$url .= '/'.$key.'/'.$tmp;
		}
	}else{
		$link_id = empty($link_id)?'id':$link_id;	//$link_id为空时 默认给id
		$url	.= '/'.$link_id.'/'.$list[$link_id];
	}
	return $url;
}

/**
 * 发票公司选择框
 *
 * @param array $info
 * @see smarty_function_company
 * @return string
 */
function smarty_function_invoiceCompany($info){
	if(C('invoice.company_from')==1){
		return smarty_function_company($info);
	}else{
		$info['url']='AutoComplete/invoiceCompany';
		$view	= false;
		foreach($info as $_key=>$_val){
			switch($_key){
				case 'type':
					$$_key	= $_val;break;
				case 'title':
					$$_key	= $_val;break;
				case 'url':
					$$_key	= $_val;break;
				case 'view':
					$$_key	= $_val;break;
				case 'hidden':
					$$_key	= (array)$_val;break;
				case 'require':
					$require='__*__';break;
				default:
					$input[$_key]=$_val;
					break;
			}
		}
		$url	= U($url);
		$input['url']=$url;
		return smarty_function_setHtml($type,$title,$input,$hidden,$view,$require);
	}
}


// 审核状态选择框
function smarty_function_paidDate($info) {	 
	extract($info);
	if ($minDate) {
		$onfocus	=	'onfocus="WdatePicker({minDate:\''.$minDate.'\'})"';
	}else {
		$onfocus	=	'onclick="WdatePicker()"';
	} 
	if (empty($name)) {	$name	=	$id;} 
	return '<input type="text" id="'.$id.'" name="'.$name.'"  value="'.$value.'" class="Wdate spc_input" '.$onfocus.' />';
} 

//产品 autoshow
function smarty_function_autoShow($params,&$smarty,$module_name=MODULE_NAME){
	$item	= $smarty->getVariable('item')->value;
    $module_name = in_array($module_name, array('Ajax')) ? 'ReturnSaleOrder' : $module_name;
	$output = '<img src="'.__PUBLIC__.'/Images/Default/atshow_ico.gif" onclick="$.autoShow(this,\''.$module_name.'\')" style="vertical-align:middle;cursor:pointer;}
" id="autoshow_img" pid="'.$item['product_id'].'">';
	//发票产品配置为独立产品 或者是发送邮件 不显示 autoshow
	if((C('invoice.product_from')==2&&substr(MODULE_NAME,0,7)=='Invoice')||ACTION_SENT_EMAIL==1){
		return ;
	}else{
		return $output;
	}
}

//当前登陆用户快捷操作，与权限相关
function smarty_function_quicklyAdd($params){
	$user_id = getUser('id');
	$module = $params['module'];
	if(empty($user_id) || empty($module)) return false;
	$var = RBAC::getModuleAccessList($user_id,$module);
	if($params['lang']){
		$lang = L($params['lang']);
	}else {
		$lang = L('insert').L('module_'.$module);
	}
	//新客户添加
	if ($var[strtoupper($module)]['INSERT']||(strtoupper($module)=='CLIENT')) {
		$output = '<a href="javascript:;" onclick="$.quicklyAdd(\''.$module.'\',\''.$params['type'].'\')">'.$lang.'</a>';
		return $output;
	}else {
		return false;
	}
}
/**
 * 没有搜索框时需要分页 模拟form
 * @param array $params
 * @param object $smarty
 * @return string
 */
function smarty_function_searchForm($params,&$smarty){
	$url	= '';
	foreach($_GET['_URL_'] as $val){
		$url	.= '/'.$val;
	}
	$url	= U($url);
	if($_POST['search_form']!=1){
		foreach($_POST as $key=>$val){
			if(is_array($val)){
				foreach($val as $k=>$v){
					if($k=='_URL_') continue;
					$post	.= '<input type="hidden" name="'.$k.'" value="'.$v.'">';
				}
			}else{
				$post	.= '<input type="hidden" name="'.$key.'" value="'.$val.'">';
			}
		}
		$form	= '<form id="search_form" method="post" action="'.$url.'" style="display:none">
						'.$post.'
						<input type="submit" id="ac_search" value="search">
						<input type="text" id="REQUEST_TIME" value="'.$smarty->getVariable('request_time').'">
						<input type="hidden" autocomplete="off" name="search_form" value="1">
						<input id="nextPage" type="hidden"  name="nextPage" value="'.(intval($smarty->getVariable('nowPage')->value)+1).'">
					</form>';
	}
	return $form;
}
?>