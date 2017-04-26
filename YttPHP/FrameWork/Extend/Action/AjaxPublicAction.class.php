<?php
/**
 * Ajax类
 * @copyright   2013 展联软件友拓通
 * @category   	通用
 * @package  	Action
 * @version 	2013-03-25
 * @author 		何剑波
 */
class AjaxPublicAction extends CommonAction {

	public $_view_dir 			= 'Ajax';			/// tpl目录名

	public function _initialize(){
		parent::_initialize();
		C('SHOW_PAGE_TRACE',false);
	}

	/// 构造函数
	public function __destruct(){
		exit;
	}
    public function downPdf(){
        $id = intval($_GET['id']);
        $rs = M('gallery')->find($id);
		gallery_permission_validation_factory($rs);
		$file_name	= isset($_GET['view']) ? $rs['file_url'] : $rs['file_url'];
		$file_name = getUploadPath($rs['relation_type']).$file_name;
        $file = fopen($file_name,"r"); // 打开文件
        // 输入文件标签
        header('content-type:application/pdf');
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: ".filesize($file_name));
        Header("Content-Disposition: attachment; filename=" . $rs['cpation_name']);
        // 输出文件内容
        echo fread($file,filesize($file_name));
        fclose($file);
        exit;
    }

    /// 获取城市的autocomplete
	public function getCity() {
		$id		    = intval($_GET['id']);
		$city_id    = intval($_GET['city_id']);
		$input_name	= intval($_GET['city_name_flag'])==1? 'addition[1][city_id]' : 'city_id';
		if($city_id>0){
			$city_value     = $city_id;
			$cityname_value = SOnly('city',$city_id, 'city_name');
		}
		echo '<input type="hidden" name="'.$input_name.'" id="city_id" value="'.$city_value.'"><input value="'.$cityname_value.'" type="text" name="city_name" url="'.U('AutoComplete/city').'" where="'.urlencode("parent_id='".$id."'").'" jqac/>';
	}

	/// 获取派送方式的autocomplete
	public function getExpressWay() {
		   $id = intval($_GET['id']);
           if(isset($_GET['index'])){
               $express_id      = 'detail['.$_GET['index'].'][express_id]';
               $express_name    = 'temp['.$_GET['index'].'][express_name]';
           }else{
                $express_id      = 'express_id';
                $express_name    = 'express_name';
           }
		   echo '<input type="hidden" name="'.$express_id.'" id="express_id" onchange="getExpressInfo();"><input type="text" name="'.$express_name.'" url="'.U('AutoComplete/shippingUse').'" where="'.urlencode("warehouse_id='".$id."'").'" jqac/>';
	}
	/// 获取派送方式的autocomplete
	public function getTableExpressWay() {
            $id = intval($_GET['id']);
            echo '<input type="hidden" name="express_id" id="express_id" onchange="getExpressInfo();"><input type="text" name="express_name" url="'.U('AutoComplete/shippingUse').'" where="'.urlencode("warehouse_id='".$id."'").'" jqac/>';
	}

/// 获取派送方式的autocomplete
	public function getExpressWayEdit() {
		   $id = intval($_GET['id']);
		   echo '<input type="hidden" name="express_id" id="express_id" onchange="getExpressInfoEdit();"><input type="text" name="express_name" url="'.U('AutoComplete/shippingUse').'" where="'.urlencode("warehouse_id='".$id."'").'" jqac/>';
	}

    /// 根据当前级别取产品上级类别信息
	public function getParentProductClass(){
		if (C('PRODUCT_CLASS_LEVEL')<=1) {
			return '';exit;
		}
		$id = intval($_GET['id']);
		if ($id<=0) { echo 'error';}
		$rs = M('ProductClass')->field('class_name,parent_id')->select($id);
		$html = $rs['class_name'];
		for ($i=0;;$i++) {
			if ($rs['parent_id']<=0) {break;}
			$rs = M('ProductClass')->field('class_name,parent_id')->select($rs['parent_id']);
			$html = $rs['class_name'].'->'.$html;
		}
		echo $html;
	}

	/// 判断颜色是否可删除
	public function checkProdcutColor(){
		$product_id = intval($_GET['product']);
		$color_id 	= intval($_GET['color']);
		$count 		= M('Storage')->where('product_id='.$product_id.' and color_id='.$color_id.' and quantity>0')->count();
		echo $count;
	}

	/// 判断尺码是否可删除
	public function checkProdcutSize(){
		$product_id = intval($_GET['product']);
		$size_id = intval($_GET['size']);
		$count = M('Storage')->where('product_id='.$product_id.' and size_id='.$size_id.' and quantity>0')->count();
		echo $count;
	}

	///退货获取产品ID
	public function getReturnSaleProductNoInput() {
		$client_id 		= intval($_POST['client_id']);
		$basic_id 		= intval($_POST['basic_id']);
	  ///$currency_id 	= intval($_POST['currency_id']);
		if($client_id==0 || $basic_id==0) {
			return false;
		}
		///销售单信息
		$sale_select	=	'select id from sale_order where client_id='.$client_id.' and basic_id='.$basic_id.' ';
		if(C('sale.relation_sale_follow_up')==1) {
			///发货
			$model	=	M('deliveryDetail');
			$info	= $model->field('group_concat(distinct(product_id)) as product_id')
			->where(' sale_order_id in ( '.$sale_select.' )')
			->select();
		}else {
			///销售
			$model	=	M('saleOrderDetail');
			$info	= $model->field('group_concat(distinct(product_id)) as product_id')
			->where(' sale_order_id in ( '.$sale_select.' )')
			->select();
		}
		if(!empty($info[0]['product_id'])) {		$extend	=	' sale_order_detail.product_id in ('.$info[0]['product_id'].')';	}else{	$extend	=	' sale_order_detail.product_id=0 ';}
		echo $extend;
		exit();
	}

	/// 根据银行ID获取对应的币种ID
	public function getBankCurrencyId(){
		$bank_id		=	$_GET['bank_id'];
		if ($bank_id>0){
			$bank_currency	=	S('bank_currency');
			$currency		=	$bank_currency[$bank_id];
		}
		echo json_encode($currency);
		exit();
	}

	/// 根据银行ID获取对应的币种信息
	public function getCurrencyIdByBank(){
		$bank_id		=	$_GET['bank_id'];
		if ($bank_id>0){
			$bank_currency	=	S('bank_currency');
			$currency_no	=	S('currency_no');
			$currency['currency_id']	= $bank_currency[$bank_id]['currency_id'];
			$currency['currency_name']	= $currency_no[$currency['currency_id']]['currency_no'];
		}
		echo json_encode($currency);
		exit();
	}

	/// 获取company表的信息(厂家/客户等)
	public function getCompanyInfo() {
		$id = intval($_GET['id']);
		if ($id > 0) {
			$info = M("Company")->field('currency_id')->select($id);
			echo json_encode($info);
		}
		exit();
	}

	/// 获取产品信息(流程使用)
	public function getProductInfo() {
		$id 			= intval($_GET['id']);
		$flow			= trim($_GET['flow']);
		if ($id > 0) {
			if(in_array($flow,array('adjust','declared_value','ShiftWarehouse','no_return'))){
				$fields	= 'id as product_id,product_no,product_name,custom_barcode,
											weight,cube_high,cube_wide,cube_long,
											(cube_high*cube_wide*cube_long) as per_size,
											(cube_high*cube_wide*cube_long) as cube';
            }elseif(in_array($flow,array('instock'))){
                $fields	= 'id as product_id,product_no,product_name,custom_barcode,
											if(check_status=1,check_weight,weight) as weight,
											if(check_status=1,check_high,cube_high) as cube_high,
											if(check_status=1,check_wide,cube_wide) as cube_wide,
											if(check_status=1,check_long,cube_long) as cube_long,
                                            if(check_status=1,check_long,cube_long)*if(check_status=1,check_wide,cube_wide)*if(check_status=1,check_high,cube_high) as cube,
                                            if(check_status=1,check_long,cube_long)*if(check_status=1,check_wide,cube_wide)*if(check_status=1,check_high,cube_high) as per_size,
                                            if(check_status=1,check_weight,0) as check_weight,
                                            if(check_status=1,check_high,0) as check_high,
											if(check_status=1,check_wide,0) as check_wide,
											if(check_status=1,check_long,0) as check_long,
                                            if(check_status=1,check_long,0)*if(check_status=1,check_wide,0)*if(check_status=1,check_high,0) as check_cube';
            }else{
				$fields	= 'id as product_id,product_no,product_name,custom_barcode,
											if(check_status=1,check_weight,weight) as weight,
											if(check_status=1,check_high,cube_high) as cube_high,
											if(check_status=1,check_wide,cube_wide) as cube_wide,
											if(check_status=1,check_long,cube_long) as cube_long,
                                            if(check_status=1,check_long,cube_long)*if(check_status=1,check_wide,cube_wide)*if(check_status=1,check_high,cube_high) as cube,
                                            if(check_status=1,check_long,cube_long)*if(check_status=1,check_wide,cube_wide)*if(check_status=1,check_high,cube_high) as per_size';

//											(cube_high*cube_wide*cube_long) as per_size,
//											(cube_high*cube_wide*cube_long) as cube'
			}
			$where	= 'id=' . $id;
			if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
				$where .= ' and factory_id='.intval(getUser('company_id'));
			}
			$product = M("Product")->field($fields)->where($where)->find();
			if ($product) {
				if(in_array($flow,array('adjust','declared_value','ShiftWarehouse'))){
                    if($flow = 'declared_value'){
                        $flow   = 'adjust';
                    }
					$product['output']  = $product['product_no'].'<img src="'.PUBLIC_PATH.'Images/Default/atshow_ico.gif" onclick="$.autoShow(this,\''.$flow.'\')" style="vertical-align:middle;cursor:pointer;}" id="autoshow_img" pid="'.$product['product_id'].'">';
				}
                if($flow == 'instock'){
                    $product['declared_value']  = M('product_detail')->where('product_id='.$product['product_id'].' and properties_id='.C('DECLARED_VALUE'))->getField('value');
                }
				$info = _formatArray($product);
				_formatWeightCube($info);
				echo json_encode($info);
			}
		}
		exit();
	}

	///获取仓库ID
	public function getWarehouseId(){
		$location_id = intval($_GET['location_id']);
		if ($location_id > 0 ) {
			$info['warehouse_id'] = M("location")->where('id='.$location_id)->getField('warehouse_id');
			echo json_encode($info);
		}
		exit();
	}

	/// 获取订单详情
	public  function getOrderDetails() {
		$detail_id 	= intval($_GET['detail_id']);
		$order_id	= intval($_GET['order_id']);
		$p_id		= intval($_GET['p_id']);
		$color_id	= intval($_GET['color_id']);
		$size_id	= intval($_GET['size_id']);
		/// 实例化类
		$model = D("Orders");
		///构造查询条件
		$where		= ' b.detail_state<3';
		$detail_id && $where.=" and b.id=".$detail_id;
		$order_id  && $where.=" and a.id=".$order_id;
		$p_id      && $where.=" and b.product_id=".$p_id ;
		$color_id  && $where.=" and b.color_id=".$color_id;
		$size_id   && $where.=" and b.size_id=".$size_id;
		$order_id  && $group_by = 'id';
		$p_id 	   && $group_by.=($group_by?',':'').'product_id,size_id,color_id';
		$opert['where']	= $where;
		$opert['group_by'] = $group_by;
		if($order_id){
			$opert['field'] = ' ,if( d.load_state =2, 0, ( c.quantity * c.capability * c.dozen ) ) AS load_quantity,
							    ( b.quantity * b.capability * b.dozen) as order_qn,
							    ((b.quantity * b.capability * b.dozen) - IFNULL(if( d.load_state =2, 0, ( c.quantity * c.capability * c.dozen ) ),0)
								) AS unload_quantity,group_concat(a.id) as multi_id';
		}else{
			$opert['field'] = ' ,if( d.load_state =2, 0, sum( c.quantity * c.capability * c.dozen ) ) AS load_quantity,
							    sum( b.quantity * b.capability * b.dozen) as order_qn,
							    (sum(b.quantity * b.capability * b.dozen) - IFNULL(if( d.load_state =2, 0, sum( c.quantity * c.capability * c.dozen ) ),0)
								) AS unload_quantity,group_concat(a.id) as multi_id';
		}
		/// 执行查询操作
		$rs		= $model->detail($opert);
		$rs['show_capbility']	= 0;
		$rs['show_delivery']	= 0;
		$rs['show_color']		= 0;
		$rs['show_size']		= 0;
		if(C('instock.delivery')==2){
			/// 取产品每箱数量、每包数量
			$temp 					= M('Product')->field('weight,(cube_long*cube_wide*cube_high) as per_size')->find($p_id);
			$temp					= _formatList(array($temp));
			$rs['per_size'] 		= $temp['list'][0]['edml_per_size'];
			$rs['weight'] 			= $temp['list'][0]['edml_weight'];
			$rs['show_delivery']	= true;
		}
		if(C('order.storage_format')==C('loadContainer.storage_format')) $rs['show_capbility']	= 1;
		if(C('order.color')==1){
			$rs['show_color']	= 1;
		}else{
			if (C('product_color')==1){
				$rs['show_color']	= 2;
			}
		}
		if(C('order.size')==1){
			$rs['show_size']	= 1;
		}else{
			if (C('product_size')==1){
				$rs['show_size']	= 2;
			}
		}
		unset($model,$temp);
		echo json_encode($rs);
		exit() ;
	}

	/// 获取装柜/整单装柜信息
	public  function getLoadDetails() {
		$detail_id 	= intval($_GET['detail_id']);
		$order_id	= intval($_GET['order_id']);
		/// 实例化类
		$model = D('LoadContainer');
		///构造查询条件
		$where		= ' detail_state<3 ';
		$detail_id && $where	.=" and b.id=".$detail_id;
		$order_id  && $where	.=" and a.id=".$order_id;
		/// 执行查询操作
		$rs['list']			= $model->getDetail($where);
		if(C('loadContainer.storage_format')==C('order.storage_format')){
			$rs['storage_format']	= 1;
		}
		if(C('instock.delivery')==2){
			$rs['show_delivery']	= 1;
		}
		unset($model);
		echo json_encode($rs);
		exit() ;
	}


	///获取客户信息
	public function getClientInfo() {
		if ($_GET['id'] > 0) {
			$rs = M('Client')->find(intval($_GET['id']));
///			if (C('multi_client')) {
///				$rs = $this->_formatArray($rs);
///			}
			$rs = _formatArray($rs);
			echo json_encode($rs);
		}
		exit();
	}

	/**
	 * 获取销售信息
	 * @param type $returnType 返回类型
	 * @return type 1-json，2-数组
	 */

	public function getSaleOrderInfo($returnType = 1) {
		$sale_order_id    = intval($_GET['sale_order_id']);
        $count  = M('sale_order')->where('warehouse_id='.(int)$_GET['warehouse_id'].' and id='.$sale_order_id)->count();
		if ($sale_order_id > 0 && $count>0) {
			//基本信息
            if(empty($sale_order_id) || !empty($_GET['id'])){
                $table_name     = 'return_sale_order';
                $sale_order_id  = intval($_GET['id']);
		$return_sale_order_id  = intval($_GET['id']);
            }else{
                $table_name     = 'sale_order';
            }
			$rs           = _formatArray(M($table_name)->find($sale_order_id));
			if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
				exit();
			}
			//明细信息
			$where			    = $table_name.'_id='.$sale_order_id;
			$rs['detail']       = M($table_name.'_detail')->field('*')->where($where)->select();

		if($return_sale_order_id>0){
		    $model=D('ReturnSaleOrder');
			$return_service=$model->getReturnService($return_sale_order_id);
			 foreach ($rs['detail'] as &$temp_row){
				if(isset($return_service[$temp_row['id']])){
					$temp_row['return_service_no'] =   $return_service[$temp_row['id']]['return_service_no'];
				}
		    }
		}
			$is_factory			= getUser('role_type')==C('SELLER_ROLE_TYPE')?1:0;
            $storage_info       = M('return_sale_order_storage_detail')->where('return_sale_order_id='.(int)$_GET['id'])->getField('product_id,location_id,quantity,return_sale_order_storage_id');
            $detail_info        = M('return_sale_order_detail')->where('return_sale_order_id='.(int)$_GET['id'])->getField('id,product_id,quantity');
            // 处理方式
            $sql = 'select a.*
				from return_sale_order_detail_service as a
				where a.return_sale_order_id=' . (int)$_GET['id'] . '
				group by a.id order by id';
            $rs['service'] = M('return_sale_order_detail_service')->query($sql);

            foreach ((array) $rs['service'] as $key => $val) {
                $service_key = $val['return_sale_order_id'] . '_' . $val['return_sale_order_detail_id'] . '_' . $val['relation_id'];
		$service_data[$service_key][] = array(
                    "0" => $val['service_detail_id'],
                    "1" => $val['quantity'],
                    "2" => moneyFormat($val['price'], 0, 2, false)
                );
            }
            $rs['return_sale_order_state']      = M('return_sale_order')->where('id='.(int)$_GET['id'])->getField('return_sale_order_state');

            foreach((array)$rs['detail'] as $k=>$v){
                if( $table_name != 'return_sale_order'){
                    $rs['detail'][$k]['sale_order_number']      = $v['quantity'];
                }
				$rs['detail'][$k]['is_factory']             = $is_factory;
				empty($rs['detail'][$k]['relation_id']) && $rs['detail'][$k]['relation_id'] = $v['id'];
                if (!empty($detail_info)) {
                    $rs['detail'][$k]['quantity'] = $detail_info[$v['id']]['quantity'];
                    $rs['detail'][$k]['id'] = $v['id'];
                    $detail_key = $_GET['id'] . '_' . $rs['detail'][$k]['id'] . '_' . $rs['detail'][$k]['relation_id'];
                    if (array_key_exists($detail_key, $service_data)) {
                        $rs['detail'][$k]['return_service'] = json_encode($service_data[$detail_key]);
                    }elseif($rs['detail'][$k]['quantity']>0){
			$rs['detail'][$k]['return_service']= '';
		    }else{
                        $rs['detail'][$k]['no_show']        = 1;
                    }
                }  else {
                    unset($rs['detail'][$k]['quantity']);
                    unset($rs['detail'][$k]['id']);
                }
                if (!empty($storage_info)) {
                    $rs['detail'][$k]['location_id']       = $storage_info[$v['product_id']]['location_id'];
                    $rs['detail'][$k]['in_quantity']       = $storage_info[$v['product_id']]['quantity'];
                    $rs['detail'][$k]['location_no']       = getLocationNo($storage_info[$v['product_id']]['location_id']);
                    $rs['detail'][$k]['return_sale_order_storage_id']                = $storage_info[$v['product_id']]['id'];
                }
                if(empty($rs['warehouse_id'])){
                    $rs['warehouse_id'] = $v['warehouse_id'];
                }
            }
			$sale_info			= _formatList($rs['detail']);
			$rs['detail']	    = $sale_info['list'];
			$rs['detail_total'] = $sale_info['total'];
			//退货关联处理单号 added by jp 20141112
			$rs['is_related_sale_order']	= C('IS_RELATED_SALE_ORDER');
			$view			    = Think::instance('View');
			$view->assign ('rs', $rs);
			$view->assign ('tpl_module_name', 'ReturnSaleOrder');
            if($table_name != 'return_sale_order' || ($rs['is_related_sale_order']!=C('IS_RELATED_SALE_ORDER') && in_array($rs['return_sale_order_state'],C('CAN_EDIT_SERVICE')))){
                $view->assign ('tpl_action_name', 'add');
            }else{
                $view->assign ('tpl_action_name', 'edit');
            }
            if(in_array($_GET['return_sale_order_state'], C('SHOW_LOCATION_RETURN_SALE_ORDER_STATE'))&& getUser('role_type')!=C('SELLER_ROLE_TYPE')){
                $rs['html']         = $view->display('ReturnSaleOrder:shelves_return_detail','','',true);
            }else{
                $rs['html']         = $view->display('ReturnSaleOrder:return_detail','','',true);
            }
			//客户信息
			$client				= M('Client')->field('comp_name as client_name,comp_no as client_no,email as comp_email')->find($rs['client_id']);
            if($client){
				$rs				= array_merge($rs,$client);
			}
            $sale_order_id      = empty($rs['sale_order_id'])? $rs['id']:$rs['sale_order_id'];
			$addition_data 	    = M('sale_order_addition')->field('address,address2,post_code,country_name,city_name,country_id,fax,email,mobile,tax_no,consignee,company_name,transmit_name')->where('sale_order_id='.$sale_order_id)->find();
            if($addition_data){
				$rs				= array_merge($rs,$addition_data);
			}
            $edit_comments  =$rs['edit_comments'];
			$rs				    = _formatArray($rs);
            $rs['edit_comments']    = $edit_comments;
			if($returnType == 2) return $rs;
			echo json_encode($rs);
		}
		if($returnType == 1) exit();
	}
    public function getQuestionInfo(){
        $sale_order_id    = intval($_GET['sale_order_id']);
        $count  = M('sale_order')->where('warehouse_id='.(int)$_GET['warehouse_id'].' and id='.$sale_order_id)->count();
		if ($sale_order_id > 0 && $count>0) {
			//基本信息
            $table_name     = 'sale_order';
			$rs             = _formatArray(M($table_name)->find($sale_order_id));
			if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
				exit();
			}
			//明细信息
			$where			    = 'sale_order_id='.$sale_order_id;
			$rs['detail']       = M('sale_order_detail')->field('*')->where($where)->select();
			$is_factory			= getUser('role_type')==C('SELLER_ROLE_TYPE')?1:0;
            $detail_info        = M('sale_order_detail')->where('sale_order_id='.(int)$_GET['sale_order_id'])->getField('id,product_id,quantity');
            foreach((array)$rs['detail'] as $k=>$v){
				$rs['detail'][$k]['is_factory']             = $is_factory;
                if (!empty($detail_info)) {
                    $rs['detail'][$k]['quantity'] = $detail_info[$v['id']]['quantity'];
                    $rs['detail'][$k]['id'] = $v['id'];
                }  else {
                    unset($rs['detail'][$k]['quantity']);
                    unset($rs['detail'][$k]['id']);
                }
            }
			$sale_info			= _formatList($rs['detail']);
			$rs['detail']	    = $sale_info['list'];
			$rs['detail_total'] = $sale_info['total'];

			$view			    = Think::instance('View');
			$view->assign ('rs', $rs);
			$view->assign ('tpl_module_name', 'QuestionOrder');
            $view->assign ('tpl_action_name', 'view');
            $rs['html']         = $view->display('QuestionOrder:question_detail','','',true);
			//客户信息
			$client				= M('Client')->field('comp_name as client_name,comp_no as client_no,email as comp_email')->find($rs['client_id']);
            if($client){
				$rs				= array_merge($rs,$client);
			}
            $sale_order_id      = empty($rs['sale_order_id'])? $rs['id']:$rs['sale_order_id'];
			$addition_data 	    = M('sale_order_addition')->field('address,address2,post_code,country_name,city_name,country_id,fax,email,mobile,tax_no,consignee,company_name,transmit_name')->where('sale_order_id='.$sale_order_id)->find();
            if($addition_data){
				$rs				= array_merge($rs,$addition_data);
			}
            $edit_comments  =$rs['edit_comments'];
			$rs['ship_id']		= $rs['express_id'];	//缓存派送方式命名有误，转换
			$rs				    = _formatArray($rs);
            $rs['edit_comments']    = $edit_comments;
			$rs['express_name']		= $rs['ship_name'];	//缓存派送方式命名有误，转换
			echo json_encode($rs);
		}
		exit();
    }

        ///获取客户信息
	public function getExpressInfo() {
        $rs = M('Express')->find($_GET['id']);
        if($rs['company_id']==C('EXPRESS_BRT_ID') && intval($_GET['warehouse_id'])== C('EXPRESS_IT_WAREHOUSE_ID')){
            $rs['brt_init']         = true;
        }
        if(in_array($rs['id'],explode(',',C('EXPRESS_FR_REGISTERED_ID')))){
            $rs['reg_init']=true;
        }

        $rs = _formatArray($rs);
        echo json_encode($rs);
        exit();
	}

	//获取派送信息(订单编辑时)
	public function getExpressInfoEdit() {
		   if (intval($_GET['id']) > 0 && intval($_GET['warehouse_id']) > 0) {
					$rs = M('Express')->find($_GET['id']);
					if($rs['company_id']==C('EXPRESS_BRT_ID') && $_GET['warehouse_id']== C('EXPRESS_IT_WAREHOUSE_ID')){
						$rs['brt_init']=true;
					}
                    if(in_array($rs['id'],explode(',',C('EXPRESS_FR_REGISTERED_ID')))){
                        $rs['reg_init']=true;
                    }
				    $rs = _formatArray($rs);
				   echo json_encode($rs);
		   }
		   exit();
	}




	//获取卖家的BRT账号
	public function getBrtAccountNo(){
        $brt_account_no = M('company')->where('id='.intval($_GET['factory_id']))->getField('brt_account_no');
        echo json_encode($brt_account_no);
        exit();
	}
	/// 通过条形码获取产品信息
	public function getProductByBarcode() {
		$info = inputBarcode(trim($_GET['barcode']));
		if ($info !== false) {
			$info = _formatArray($info);
			echo json_encode($info);
		}
		exit();
	}

	/// 根据产品信息获取条形码
	public function getBarcode() {
		$product_id = intval($_POST['p_id']);
		$color_id	= intval($_POST['color_id']);
		$size_id	= intval($_POST['size_id']);
		if ($product_id > 0) { ///
			echo getBarcode($product_id,$color_id,$size_id);
		}
		exit();
	}

	/// 通过条形码找销售单信息
	public function getSaleInfoByBarcode() {
		$info 			= inputBarcode(trim($_GET['barcode']));
		$sale_order_id 	= intval($_GET['sale_order_id']);
		if ($info !== false && $sale_order_id > 0 ) {
			$where = 'product_id='.$info['p_id'].' and sale_order_id='.$sale_order_id;
			$cache_barcode = S('barcode');
			if ($cache_barcode['barcode']['color_no'] >0 && $info['color_id']) {
				$where.=' and color_id='.$info['color_id'];
			}
			if ($cache_barcode['barcode']['size_no'] >0 && $info['size_id']) {
				$where.=' and size_id='.$info['size_id'];
			}
			$sale_info = M('SaleOrderDetail')->field('*,sum(quantity*capability*dozen*pieces) as sum_qn')->group('1')->where($where)->select();
			if ($sale_info['id'] > 0) {
				$sale_info = $this->_formatArray($sale_info);
				echo json_encode($sale_info);
			}
		}
		exit();
	}

	/// 通过列表直接修改产品单价
	public function setProductPrice(){
		$id		= intval($_POST['id']);
		$price	= $_POST['price'];
		$type	= trim($_POST['type']);
		///安全过滤
		if(in_array($type,array('wholesale_price','sale_price','retail_price')) && $price>=0 && $id>=0){
			echo M('Product')->where('id='.$id)->setField($type,$price);
		}else{
			echo 'error';
		}
	}

	///获取汇率和转换至金额
	public function getRateMoneyTo(){
		$data['opened_y'] = sprintf("%.8f",D('RateInfo')->getRate($_GET['currency_id'],$_GET['confirm_date'],$_GET['confirm_currency_id']));
		$data['money_to'] = sprintf("%.2f", $_GET['money'] * $data['opened_y']);
		echo json_encode($data);
	}

	/// 设置当前登陆用户的向导是否启用
	public function setGuide(){
		$user_id 			= getUser('user_id');
		$guide				= intval($_POST['guide']);
		$_SESSION['LOGIN_USER']['guide']	= $guide;
		echo M('User')->where('id='.$user_id)->setField('guide',$guide);
	}

	/// 获取IVA
	public function getIva() {
		$id 	= intval($_GET['id']);
		$from	= $_GET['from'];
		if ($id > 0) {
			if (C('invoice.'.$from)=='1') {///客户列表  供应商列表
				$table='company';
				$invoice_from	= 0;
			} else{
				$table='InvoiceCompany';
				$invoice_from	= 1;
			}
			$data = M($table)->find($id);
			$data['invoice_from']	= $invoice_from;
			$data['factory_from']	= C('invoice.factory_from');
			echo json_encode($data);
			exit();
		}
	}

	/// 根据产品ID获取产品的尾箱信息，尾箱指与产品基本信息中配置不一致的规格，如果产品信息未配置不处理
	public function getLastStorage(){
		$product_id = intval($_GET['id']);
		$state 		= intval($_GET['state']);
		if(empty($product_id)) return false;
		$where = 'product_id='.$product_id.' and quantity>0 and mantissa='.$state;
		$info = M('SaleStorage')->where($where)->select();
		if (count($info)>1) {	/// 多条记录时客户自由选择，无需返回值
			echo json_encode(array('state'=>2,'data'=>array()));
		}elseif (count($info)==1) {
			echo json_encode(array('state'=>1,'data'=>$info[0]));
		}else {
			echo '';
		}
		exit();
	}

	/// 根据产品ID取得产品的默认数值
	public function getProductDefaultStorage(){
		$product_id 	= intval($_GET['id']);
		$flow 			= trim($_GET['flow']);
		$state 			= trim($_GET['mantissa']);
		if(empty($product_id)) return false;
		if ($flow=='sale' || $flow=='sale_return') {
			$temp = M('SaleStorage')->where('product_id='.$product_id.' and quantity>0 and mantissa='.$state)->select();
			if (count($temp)==1) {
				$p_info['capability'] = $temp[0]['capability'];
				$p_info['dozen'] = $temp[0]['dozen'];
				$p_info['autocomplete'] = false;
			}else if(empty($temp)){
				$p_info['capability'] = 0;
				$p_info['dozen'] = 0;
				$p_info['autocomplete'] = false;
			}else {
				$p_info['capability'] = 0;
				$p_info['dozen'] = 0;
				$p_info['autocomplete'] = true;
			}
		}else {
			if (C('STORAGE_FORMAT')==3) {
				$capability = 'floor(capability/dozen) as capability';
			}else{
				$capability = 'capability';
			}
			$p_info = M('Product')->field($capability.',dozen')->where('id='.$product_id)->select();
			$p_info['autocomplete'] = false;
		}
		if (count($p_info)>0) {
			echo json_encode($p_info);
		}
		exit;
	}
	/// 获取库存状态
	public function getStorageState() {
		$product_id = intval($_GET['product_id']);
		$capability = intval($_GET['capability']);
		$dozen 		= intval($_GET['dozen']);
		$warehouse_id = intval($_GET['warehouse_id']);
		if (empty($product_id) || empty($capability) || empty($dozen)) {
			return false;
		}else {
			$rs = M('Storage')->field('mantissa')->where('product_id='.$product_id.' and quantity>0 and capability='.$capability.' and dozen='.$dozen.' and warehouse_id='.$warehouse_id)->select();
			echo $rs['mantissa'];
		}
		exit;
	}


	/// 获取产品颜色
	public function getProductColorId(){
		$product_id = intval($_POST['id']);
		$list = M('ProductColor')->where('product_id='.$product_id)->select();
		$result = array(0);
		foreach ((array)$list as $value) {
			$result[] = $value['color_id'];
		}
		echo implode(',',$result);
	}
	/// 获取产品尺码
	public function getProductSizeId(){
		$product_id = intval($_POST['id']);
		$list = M('ProductSize')->where('product_id='.$product_id)->select();
		$result = array(0);
		foreach ((array)$list as $value) {
			$result[] = $value['size_id'];
		}
		echo implode(',',$result);
	}
	/// 新装柜时获取订单厂家，币咱
	public function getOrderFacCur(){
		$order_id = intval($_GET['id']);
		$rs = M('Orders')->field('id,factory_id,currency_id')->find($order_id);
		echo json_encode(_formatArray($rs));
	}


	/// 根据厂家ID获取对应的币种ID
	public function getFacCurrencyId(){
		$fac_id		=	$_GET['id'];
		if ($fac_id>0){
			$currency['id']					= M('Company')->where('id='.$fac_id)->getField('currency_id');
			$array							= S('currency');
			$currency['no']					= $array[$currency['id']]['currency_no'];
		}
		echo json_encode($currency);
		exit();
	}

	/// 根据产品ID获取产品名称和单价
	public function getProductInfoById(){
		$p_id	= $_GET['id'];
		if($p_id>0){
			$rs	= M('Product')->field('instock_price,product_name')->find($p_id);
			echo json_encode(_formatArray($rs));
			exit();
		}
		exit();
	}

	/// 新装柜时获取订单产品
	public function getOrderProduct(){
		$order_id = intval($_GET['id']);
		$rs = M('Orders')->field('p_id')->find($order_id);
		echo json_encode(_formatArray($rs));
	}
	/// 获取仓库名称
	public function getWareName(){
		$ware_id	= intval($_POST['id']);
		if($ware_id>0){
			$ware_arr	= S('warehouse');
			echo $ware_arr[$ware_id]['w_name'];exit();
		}
		exit();
	}

	/// 销售单的款项验证
	public function checkVaildSale(){
		$model	= D('SaleOrder');
		$rs		= $model->validFunds($_POST);
		echo 	json_encode($rs);
		exit();
	}
	/// 发票获取导入信息
	public function getRelationInfo(){
		$id		= intval($_POST['relation_id']);
		$type	= $_POST['import_type'];
		$factory_id = intval($_POST['factory_id']);
		switch ($type){
			case 'instock':
				$model	= D('InvoiceIn');
				$model->setId($id);
				$info	= $model->getInstock($factory_id);
				break;
			case 'saleorder':
				$info	= D('InvoiceOut')->getSaleInfo($id);
				break;
			case 'return':
				$info	= D('InvoiceOut')->getReturnInfo($id);
				break;
			default:
				$info	= array();break;
		}
		echo json_encode($info);
		exit;
	}
	///销售预付款转账获取银行简称,暂时
	function getBankName(){
		$id	= intval($_POST['id']);
		if($id>0){
			$bank_name	= S('bank');
			echo $bank_name[$id]['account_name'];
		}
		exit();
	}
	/// 获取发票产品信息
	public function getInvoiceProductInfo(){
		$id		= $_GET['id'];
		$info	= M('InvoiceProduct')->find($id);
		echo json_encode($info);
		exit;
	}

	/******************付款开始*************************/
	/// 付款后台验证(客户/厂家/物流)
	public function checkVaildPaid(){
		$model	= D('ObjectFunds');
		$rs		= $model->validPaidFunds($_POST);
		echo 	json_encode($rs);
		exit();
	}
	/******************付款结束*************************/

	/// 实际库存分显示时，展开明细
	public function storageExtend(){
		$where = json_decode('{'.$_POST['data'].'}',true);
		unset($_POST['data']);
		foreach ($where as $field => $value) {
			if($field=='stop_date'){
				$_POST['stop_date'] = $value;
			}else {
				$_POST['query']['a.'.$field] = $value;
			}
		}
		$this->list = D('StorageShow')->getExpand();
		$this->display();
	}

	/// 多个库存显示
	public function multiStorage(){
		$this->pid = intval($_POST['id']);
		$this->list = _formatList(M('Storage')->field('*,quantity*capability*dozen as real_storage')->where('product_id='.$this->pid.' and quantity!=0')->order('product_id,color_id,size_id,capability,dozen,mantissa')->select());
		$this->display();
	}

	/// 统计卖家余额
	public function statSellerBalance(){
		//获取厂家交易币种
		$configMap['config_key'] = 'factory_currency';
		$configMap['config_type'] = 'common';
		$config_value = M('Config')->where($configMap)->getField('config_value');
		$currencyArr = M('Currency')->field('id,currency_no')->where(array('id'=>array('in',$config_value)))->select();

		if(!empty($currencyArr)){
			$balanceResult = $unBalanceResult = array();

			/*--    可用余额   --*/
			$Client_paid_detail = M('Client_paid_detail');
			$balanceMap['comp_id'] = $_SESSION['LOGIN_USER']['company_id'];

			/*--    不可用余额  --*/
			$Recharge = M('Recharge');
			$unBalanceMap['factory_id'] = $_SESSION['LOGIN_USER']['company_id'];
			$unBalanceMap['confirm_state'] = 0;

			foreach($currencyArr as $key=>$value){
				$balanceMap['currency_id'] = $value['id'];
				$rs = $Client_paid_detail->field('sum(round(IF(income_type=1,-1*original_money,original_money), ' . C('MONEY_LENGTH') . ')) AS sum')->where($balanceMap)->find();
				if($rs['sum'] != 0.00){
					$balanceResult[$key]['currency_id'] =  $value['id'];
					$balanceResult[$key]['currency_no'] =  $value['currency_no'];
					$balanceResult[$key]['sum'] =  -1 * sprintf("%.2f",$rs['sum']);
				}

				$unBalanceMap['currency_id'] = $value['id'];
				$rs = $Recharge->field('sum(round(money,' . C('MONEY_LENGTH') . ')) AS sum')->where($unBalanceMap)->find();
				if($rs['sum'] != 0.00){
					$unBalanceResult[$key]['currency_id'] =  $value['id'];
					$unBalanceResult[$key]['currency_no'] =  $value['currency_no'];
					$unBalanceResult[$key]['sum'] =  sprintf("%.2f",$rs['sum']);
				}
			}

			$this->assign('balanceResult',$balanceResult);
			$this->assign('unBalanceResult',$unBalanceResult);
		}
		$this->display();

	}


	/// 底部工具条－开始
	public function todayRemind(){
		$url	=	'index.php/';
		$today	=	date('Y-m-d');
		if(!$_SESSION[C('ADMIN_AUTH_KEY')] ){
			$all_rights  = RBAC::getAccessList(USER_ID);
		}
		if ($all_rights['STATSALE']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')]) {
			$rs['today_sale']				=	D('Remind')->todaySale();
			$rs['today_sale_url']			=	U('/StatSale/index/sp_date_order_date/'.$today);
		}
		if ($all_rights['CLIENTFUNDS']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')]) {
			$rs['today_advance']			=	D('Remind')->todayAdvance();
			$rs['today_advance_url']		=	U('/ClientFunds/index/sp_date_paid_date/'.$today);
		}
		if ($all_rights['STATINSTOCK']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')]) {
			$rs['today_instock']			=	D('Remind')->todayInstock();
			$rs['today_instock_url']		=	U('/StatInstock/index/sp_date_real_arrive_date/'.$today);
		}
		if ($all_rights['CLIENTSTAT']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')]) {
			$rs['today_client']				=	D('Remind')->todayClient();
			$rs['today_client_url']			=	U('/ClientStat/index/show/0');
			$rs['today_arrearage']			=	D('Remind')->todayArrearage();
			$rs['today_arrearage_url']		=	U('/ClientStat/index/sp_date_paid_date/'.$today);
		}

///		$rs['today_factory']			=	D('Remind')->todayFactory();
///		$rs['today_logistics']			=	D('Remind')->todayLogistics();
		if($rs){
			$show	=	1;
			$this->assign('rs',$rs);
			$this->display();
		}
	}

	/// 提醒
	public function getRemindState(){
		$list = $this->getRemindBasic(false);

	 	$i = 0;
	 	foreach ($list as $key=>$value) {
	 		$i += count($value['list']);
	 	}
		echo $i>0?'remind':'remind_active';
		exit;
	}

	/// 提醒
	public function getRemind(){
		$list = $this->getRemindBasic();
	 	$list = D('Remind')->resetData($list);
	 	foreach ($list as $key => $value) {
	 		echo '<li><a href="javascript:;" onclick="addTab(\''.$value['link_url'].'\',\''.$value['link_title'].'\');$.closeAllToolbar();" title="'.$value['link_title'].'" url="'.$value['link_url'].'">'.$value['caption'].$value['total'].'</a></li>';
	 	}
	}


	/// 提醒扩展
	public function getRemindBasic($return_data = true){
		if(!$_SESSION[C('ADMIN_AUTH_KEY')]){
			$all_rights  = RBAC::getAccessList(USER_ID);
		}
		///客户待收款提醒
	 	if (C('REMIND_CLIENT') && ($all_rights['SALEORDER']['ALISTUNFINISH'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
	 		$list['client']		=	D('Remind')->clientList();
			if(!$return_data){
				return $list;
			}
	 	}
		///订货提醒
	 	if ($return_data && C('REMIND_ORDER') && C('REMIND_VALUE_ORDER')>=0 && ($all_rights['ORDERS']['ALISTUNFINISHORDER'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
	 		$list['order']		=	D('Remind')->orderList();
			if(!$return_data){
				return $list;
			}
	 	}
	 	///入库提醒
	 	if (C('REMIND_INSTOCK') && C('REMIND_VALUE_INSTOCK')>=0 && ($all_rights['INSTOCK']['WAITINSTOCK'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
	 		$list['instock']	=	D('Remind')->instockList();
			if(!$return_data){
				return $list;
			}
	 	}
	 	///待配货提醒
	 	if (C('REMIND_PREDELIVERY') && C('REMIND_VALUE_PREDELIVERY')>=0 && ($all_rights['PREDELIVERY']['WAITPREDELIVERY'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
	 		$list['predelivery']=	D('Remind')->preDeliveryList();
			if(!$return_data){
				return $list;
			}
	 	}
	 	///待发货提醒
	 	if (C('REMIND_DELIVERY') && C('REMIND_VALUE_DELIVERY')>=0 && ($all_rights['DELIVERY']['WAITDELIVERY'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
	 		$list['delivery']	=	D('Remind')->deliveryList();
			if(!$return_data){
				return $list;
			}
	 	}
	 	///厂家待付款提醒
	 	if (C('REMIND_FACTORY') && ($all_rights['INSTOCK']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
	 		$list['factory']	=	D('Remind')->factoryList();
			if(!$return_data){
				return $list;
			}
	 	}
	 	///物流待付款提醒
	 	if (C('REMIND_LOGISTICS') && ($all_rights['INSTOCK']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
	 		$list['logistics']	=	D('Remind')->logisticsList();
			if(!$return_data){
				return $list;
			}
	 	}

	 	///卖家待审核提醒 added by jp 20140310
	 	if (($all_rights['CLINET']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
	 		$list['auditfactory']	=	D('Remind')->auditFactoryList();
			if(!$return_data){
				return $list;
			}
	 	}

		if (getUser('role_type') != C('SELLER_ROLE_TYPE') || getUser('company_id') == C('CAINIAO_FACTORY_ID')) {
			//出库提醒 added by yyh 20150924
			if (($all_rights['RETURNSALEORDERSTORAGE']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
				$list['returnStorageOut']   =	D('Remind')->returnStorageOutList();
				if(!$return_data){
					return $list;
				}
			}
			//交接提醒 added by yyh 20150924
			if (($all_rights['OUTBATCH']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
				$list['transfer']	=	D('Remind')->transferList();
				if(!$return_data){
					return $list;
				}
			}

			//当日待签收提醒、签收异常提醒     add by lxt 2015.09.24
			if (($all_rights['RETURNSALEORDER']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
				$list['todayWithoutSigned']  =   D('Remind')->todayWithoutSigned();
				if(!$return_data){
					return $list;
				}
				$list['abnormalReturn']      =   D('Remind')->abnormalReturn();
				if(!$return_data){
					return $list;
				}
				$list['signedWithoutStorage']=   D('Remind')->signedWithoutStorage();
				if(!$return_data){
					return $list;
				}
			}

			//待买家处理意见提醒      add by lxt 2015.09.24
			if (($all_rights['RETURNSALEORDERSTORAGE']['INDEX'] || $_SESSION[C('ADMIN_AUTH_KEY')])){
				$list['waitForFactory']  =   D('Remind')->waitForFactory();
				if(!$return_data){
					return $list;
				}
			}
		}
		//充值提醒      add by lml 2015.12.28
//		$userInfo	= getUser();
//	 	if (C('CLIENT_CURRENCY') && ((($all_rights['CLIENTSTAT']['INDEX'])&&$userInfo['role_type']==C('SELLER_ROLE_TYPE')) || $_SESSION[C('ADMIN_AUTH_KEY')])){
//	 	    $list['recharge']  =   D('Remind')->rechargeList();
//			if(!$return_data){
//				return $list;
//			}
//	 	}
		//未读信息      add by lml 2016.01.15
	 	if ($userInfo['user_type']>0){
	 	    $list['message']  =   D('Remind')->messageUnread();
	 	}
		return $list;
	}

	/// 提醒扩展
	public function getRemindExtends(&$list){
		return $list;
	}

	/// 工具栏 产品
	public function toolBarProduct(){
		$product_no = $_REQUEST['no'];

		//卖家限制
		$userInfo	= getUser();
		$p_where    = $userInfo['role_type']==C('SELLER_ROLE_TYPE') ? ' and factory_id='.intval($userInfo['company_id']) : ' ';

		$s_where	= array();
		if (intval($_REQUEST['is_id']) !== 1) {
			$s_where[]	= 'product_no like \'%'.mysql_real_escape_string($product_no).'%\'';
		}
		if (is_numeric($product_no)) {
			$s_where[]	= 'id=\'' . $product_no . '\'';
		}
		$rs		= M('Product')->where('(' . implode(' or ', $s_where) . ')'.$p_where)->select();

		if(count($rs) > 1){
			$state  = 2;
			$reg_product_no		= '/(' .specConvertStr(addcslashes($product_no, '*.?+$^[](){}|\/')) . ')/i';
			$style_product_no	= '<font color=red><b>\1</b></font>';
			foreach($rs as $v){
				$format_data[]	= '<td><a href="javascript:;" onclick="$.setToolsBarProduct(\''.$v['id'].'\', 1)">'.preg_replace($reg_product_no, $style_product_no, $v['id'], 1).'</a></td>'.
									'<td><a href="javascript:;" onclick="$.setToolsBarProduct(\''.$v['product_no'].'\')">'.preg_replace($reg_product_no, $style_product_no, $v['product_no'], 1).'</a></td>';
			}
			//奇数个产品时，补齐末行表格
			if (count($format_data) % 2 === 1) {
				$format_data[] = '<td>&nbsp;</td><td>&nbsp;</td>';
			}
			$rs = array_chunk($format_data, 2);//按两个产品一组划分
		}elseif(is_array($rs)&&$rs){
			$state	= 1;
			$rs     = _formatArray(array_shift($rs));

			$where  = ' a.product_id= '.$rs['id'] ;
			//仓储人员限制
			if($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){
				$where .= ' and warehouse_id= '.intval($userInfo['company_id']) ;
			}
			$child_sql	= 'select
							p.*,b.warehouse_id,a.product_id,a.quantity as onroad_qn,0 as sale_qn, 0 as real_qn, 0 as reserve_qn
						from instock_detail a
						left join instock b on b.id=a.instock_id
						left join product p on p.id=a.product_id
						where ' . $where . ' and b.instock_type > ' . C('CFG_INSTOCK_TYPE_UNEDIT') . ' and a.in_quantity <= 0
						union all
						select
							p.*,a.warehouse_id,a.product_id,0 as onroad_qn,a.quantity as sale_qn, 0 as real_qn, 0 as reserve_qn
						from sale_storage a
						left join product p on p.id=a.product_id
						where ' . $where . '
						union all
						select
							p.*,a.warehouse_id,a.product_id,0 as onroad_qn,0 as sale_qn, a.quantity as real_qn, 0 as reserve_qn
						from storage a
						left join product p on p.id=a.product_id
						where ' . $where;
			$field_str	= '*,
						   sum(onroad_qn) as onroad_quantity,
						   sum(sale_qn) as sale_quantity,
						   sum(real_qn) as real_quantity,
						   sum(real_qn)-sum(sale_qn) as reserve_quantity';
			$sql = 'select ' . $field_str . '
					from (' . $child_sql . ') as tmp
					group by product_id,warehouse_id';

			$storage = _formatList(M()->query($sql));
			$this->assign('storage',$storage);
		}
		$this->assign('state',$state);
		$this->assign('rs',$rs);
		$this->display();
	}
	/**
	 * 底部工具条－结束
	 */

	public function setIndex(){
		$id = getUser('id');
		$index = $_POST['url'];
		M('User')->where('id='.$id)->setField('index',$index);
		exit;
	}
	/**
	 * 快捷菜单－－开始
	 */
	public function setShortcutMenu(){
		$user_id = getUser('id');
		$model	 = trim($_POST['model']);
		$action  = trim($_POST['action']);
		$info = array('user_id' => $user_id,'model' => $model,'action' => $action);
		M('ShortcutMenu')->delete(array('where'=>'user_id='.$user_id.' and model=\''.$model.'\' and action=\''.$action.'\''));
		echo M('ShortcutMenu')->add($info);
		exit;
	}

	public function loadShortcutMenu(){
		$user_id = getUser('id');
		$list = M('ShortcutMenu')->where('user_id='.$user_id)->order('menu_order asc,id desc')->select();
		$total_i = intval($_GET['mt']);
		$i = 1;
		$info = array();
		foreach ($list as $value) {
			if($i>$total_i){
				$info['hidden'][] = array('model'=>$value['model'],'action'=>$value['action'],'menu_name'=>title($value['action'],$value['model']));
			}else{
				$info['short'][] = array('model'=>$value['model'],'action'=>$value['action'],'menu_name'=>title($value['action'],$value['model']));
			}
			$i++;
		}
		$this->assign('short_menu',$info);
		$this->display();
	}

	public function updateShortMenu(){
		$info = array();
		$data = trim($_POST['data'],',');
		$temp = explode(',',$data);
		foreach ($temp as $value){
			$temp2 = explode(':',$value);
			M('ShortcutMenu')->save(array('id'=>$temp2[0],'menu_order'=>($temp2[1]+1)));
		}
		return true;
	}
	public function deleteShortMenu(){
		$id = intval($_POST['id']);
		return M('ShortcutMenu')->delete($id);
	}
	/**
	 * 快捷菜单－－结束
	 */

	/// autoshow
	public function autoshow(){
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
	}

	public function validRate(){
		$model	= D('Instock');
		$data	= $model->validRate($_POST);
		echo json_encode($data);
		exit;
	}

	/// 导入excel
	public function imporExcel() {
		echo json_encode(A('Excel')->insert());
		exit;
	}

	/// 下载excel
	function exportCsv(){
		$id			      = intval($_GET['id']);
		$relation_type    = intval($_GET['relation_type']);
		if($id>0&&$relation_type>0){
			$gallery	= M('gallery')->where('id='.$id.' and relation_type='.$relation_type)->find();
			gallery_permission_validation_factory($gallery);
			$path		= getUploadPath($relation_type);
			if(file_exists($path.$gallery['file_url'])){
				$file = fopen($path.$gallery['file_url'],"r");
				Header("Content-type: application/octet-stream");
				Header("Accept-Ranges: bytes");
				Header("Accept-Length: ".filesize($path.$gallery['file_url']));
				header("Content-type:text/csv");
				header("Content-Disposition:attachment;filename=".$gallery['cpation_name']);
				echo fread($file,filesize($path.$gallery['file_url']));
				fclose($file);
				exit;
			}
		}
	}

	///列表导出csv
	public function outPutExcel(){
		set_time_limit(0);
		ini_set('memory_limit', '512M');
		$csvname 	= trim($_GET['state']);   ///文件命名
		addLang($csvname);
		if (isset($_GET['id'])) {
			switch ($_GET['module_name']) {
				case 'WarehouseLocation':
					$info		 = _formatArray(D($_GET['module_name'])->getById( $_GET['id'] ));
					$csvname 	.= '(' . $info['w_no'] . '-' . $info['location_no'] . ')';
					break;
			}
            switch ($csvname){
                    case 'instockDetail':
                    $csvname      = M('instock')->where('id='.$_GET['id'])->getField('instock_no');
                    break;
            }
		}else{
			switch($csvname){
				case 'exportDeutscheSaleOrder':
                case 'expressFrPostSaleOrder':
				case 'exportDhlSaleOrder':
                case 'exportItBrtSaleOrder':
//                case 'exportFrGlsSaleOrder':
                case 'exportUKDPDSaleOrder':
                case 'exportROYALMAILSaleOrder':
                case 'exportYodelSaleOrder':
				case 'exportFRDPDSaleOrder':
				case 'exportSaleOrder':
                case 'exportFedexSaleorder':
                case 'exportITUpsSaleOrder':
                case 'exportInternationalFedexSaleOrder':
				case 'exportParcelForceSaleorder':
                case 'exportMyHemersSaleOrder':
                case 'exportMondialRelaySaleOrder':
				case 'exportGeodisSaleOrder':
					startTrans();//开启事务，导出失败则回滚
					$w_id 		  = intval($_GET['w_id']);
					$company_id	  = intval($_GET['company_id']);
					$comments	  = htmlspecialchars(urldecode($_GET['comments']));//comments
					$w_no		  = SOnly('warehouse',$w_id,'w_no');
					$express_no	  = SOnly('express',$company_id,'express_no');
					$csvname	  = 'TR-'.$w_no.'-'.$express_no.'-'.date('YmdHis');
					$encode		  = true;
					break;
			}
		}
		$model		= D('Excel');
		$list		= $model->getOutPut();
		if($encode&&is_array($list['list'])&&$list['list']){
			switch ($company_id) {
				case C('EXPRESS_IT-GLS_ID')://IT-GLS 快递公司用xls
					$filetype	= 'xls';
					break;
//				case C('EXPRESS_FR-DPD_ID')://FR-DPD 快递公司用txt
//					$filetype	= 'txt';
//					break;
				default:
					$filetype	= 'csv';
					break;
			}
			$filename	    = $csvname. '.' . $filetype;
			//记录到gallery st
			$data			= array(
								'file_url'		=> $filename,
								'cpation_name'	=> $filename,
								'insert_date'	=> date('Y-m-d'),
								'relation_type'	=> C('TRACK_ORDER_RELATION_TYPE'),
                                'upload_date'   => date("Y-m-d H:i:s"),
								'comments'		=> $comments,
							);
			$gallery_id		= M('gallery')->add($data);
			$dataList		= array();
			foreach ($list['list'] as $val) {
				if ($val['sale_order_id'] > 0) {
					$dataList[]		= array(
						'gallery_id'	=> $gallery_id,
						'relation_id'	=> $val['sale_order_id'],
					);
				}
			}
			if ($dataList) {
				M('GalleryRelation')->addAll($dataList);
			}
			//记录到gallery ed
			$info		    = $list['list'];
			$need_array	    = $list['value'];
			$tran_array	    = array();
			$path		    = getUploadPath(C('TRACK_ORDER_RELATION_TYPE')).$filename;
			//$head		    = $list['fields'];
			$head		    = in_array($_GET['state'], array('exportDeutscheSaleOrder','exportGeodisSaleOrder')) ? $list['fields'] : array();
			switch ($_GET['state']){
                case 'exportYodelSaleOrder':
                case 'exportROYALMAILSaleOrder':
                case 'exportUKDPDSaleOrder':
                case 'exportFedexSaleorder':
				case 'exportParcelForceSaleorder':
                case 'exportMyHemersSaleOrder':
                    $sign   = ',';
                    break;
                case 'exportDhlSaleOrder':
                    $sign   = '|';
                    break;
//                case 'exportFRDPDSaleOrder':
//                    $sign   = "\t";
//                    break;
                default :
                    $sign   = ';';
                    break;
            }
			if ($filetype == 'txt') {
				 $retrun_result = tranTxt($info,$need_array,$tran_array,$path,$head,$sign, true);
			}elseif ($filetype == 'xls') {
			    $retrun_result = tranXls($info,$need_array,$tran_array,$path,$head,$sign);
			} else {
				$retrun_result = tranCsv($info,$need_array,$tran_array,$path,$head,$sign);
			}
			if($retrun_result&&file_exists($path)){
				commit();
				if ($filetype == 'txt') {
					header("Content-Type: application/force-download");
					header("Content-Disposition: attachment; filename=".basename($path));
					readfile($path);
				} else {
					$filename	= rtrim(dirname(__APP__), '/') . ltrim($path,'.');
	                echo '<iframe style="display:none" src="' . $filename . '"></iframe>';
				}
			} else {
				rollback();
				halt(L('_OPERATION_FAIL_'));
			}
			exit;
		}else{
			$filetype	= in_array($_GET['state'], array('SaleOrderReport')) ? 'xls' : 'csv';
			$csvname 	.= '.' . $filetype;
			$data		= @implode("\t",$list['fields'])."\n";
			foreach ((array)$list['list'] as  $k => $v){
				$info	= array();
				foreach((array)$list['value'] as $key => $value){
					$v[$value] = preg_replace('/(\t|<br\s*+\/?>)/i', ' ', $v[$value]);//<br> 这个要处理
					if(in_array($value, array('product_no','product_name','factory_name','client_name'))){
						$v[$value] = "\"".str_replace('"','""',$v[$value])."\"";
					}
					$info[] = $v[$value];
				}
				$data	.= implode("\t", $info) . "\n";
			}
			//判断浏览器，输出双字节文件名不乱码
			$ua = $_SERVER["HTTP_USER_AGENT"];
			if (preg_match("/MSIE/", $ua)) {
				header('Content-Disposition: attachment; filename="' . str_replace("+","%20",urlencode($csvname)) . '"');
			} else if (preg_match("/Firefox/", $ua)) {
				header('Content-Disposition: attachment; filename*="utf8\'\'' . $csvname . '"');
			} else {
				header('Content-Disposition: attachment; filename="' . $csvname . '"');
			}
			if ($filetype == 'xls') {
				header('Content-type: application/vnd.ms-excel;charset=UTF-16LE');
			} else {
				header('Content-type: text/' . $filetype . '; charset=UTF-16LE');
			}
			//输出BOM
			echo(chr(255).chr(254));
			echo(mb_convert_encoding($data,"UTF-16LE","UTF-8"));
			exit;
		}
	}

	/// 计划任务,每天执行计算利润
	function tasksProfit(){
		$absStat	= new AbsStatPublicModel();
		///本位币
		$base_currency_id	=	 C('currency');
		///销售单
		$absStat->iniProfitSale($base_currency_id);
		///款项
		$absStat->iniProfitFund($base_currency_id);
		///初始化退货利润
		$absStat->iniProfitReturn();
	}

	/// 获取SessionID
	function getEbaySessionID(){
		import("ORG.Util.EbayToken");
		$EbayToken = new ModelEbayToken($_POST['username']);
		echo json_encode(array('SessionID'=>$EbayToken->getSessionID()));
		unset($EbayToken);
		exit;
	}

	/// 获取getToken
	function getEbayToken(){
		import("ORG.Util.EbayToken");
		$EbayToken = new ModelEbayToken($_POST['UserName']);
		echo json_encode($EbayToken->getToken($_POST['SessionID']));
		unset($EbayToken);
		exit;
	}

	function getFundsRelationType(){
		echo M('PayClass')->where('id=' . (int)$_POST['id'])->getField('relation_type');
		exit;
	}

	function getFundsRelationDocInfo(){
		$id	= intval($_GET['id']);
		if ($id <= 0) {
			return ;
		}
		switch ($_GET['relation_type']) {
			case 1:
				$module_name	= 'Instock';
				$sql			= 'select b.instock_no,b.go_date,sum(1) as quantity,
									sum(if(a.check_weight>0,a.check_weight,a.weight)) as weight,
									b.head_way,b.real_arrive_date,b.instock_type,b.warehouse_id
									from instock_box a
									left join instock b on a.instock_id=b.id
									where b.id=' . $id .'
									group by b.id';
				break;
			case 2:
				$module_name	= 'SaleOrder';
				$sql			= 'select b.sale_order_no,b.order_no,b.order_date,sum(quantity) as quantity,
									sum(if(c.check_status=' . C('CHECK_STATUS_PASS') . ',c.check_long*c.check_wide*c.check_high,c.cube_long*c.cube_wide*c.cube_high)) as cube,
									sum(if(c.check_status=' . C('CHECK_STATUS_PASS') . ',c.check_weight,c.weight)) as weight,
									b.warehouse_id,d.company_id as express_id,d.express_name as shipping_name,b.sale_order_state
									from sale_order_detail a
									left join sale_order b on a.sale_order_id=b.id
									left join product c on a.product_id=c.id
									left join express d on b.express_id=d.id
									where b.id=' . $id;
				break;
			case 3:
				$module_name	= 'ReturnSaleOrder';
				$sql			= 'select b.return_sale_order_no,b.sale_order_no,b.return_order_date,sum(quantity) as quantity,
									sum(if(c.check_status=' . C('CHECK_STATUS_PASS') . ',c.check_long*c.check_wide*c.check_high,c.cube_long*c.cube_wide*c.cube_high)) as cube,
									sum(if(c.check_status=' . C('CHECK_STATUS_PASS') . ',c.check_weight,c.weight)) as weight,
									a.warehouse_id,b.return_sale_order_state
									from return_sale_order_detail a
									left join return_sale_order b on a.return_sale_order_id=b.id
									left join product c on a.product_id=c.id
									where b.id=' . $id;
				break;
			case 4:
				$module_name	= 'Product';
				$sql			= 'select *,cube_long*cube_wide*cube_high as cube,check_long*check_wide*check_high as check_cube from  product where id=' . $id;
				break;
		}
		addLang($module_name);
		$this->rs = _formatArray(M()->queryOne($sql));
		$html	= $this->display('fundsRelation'.ucwords($module_name),'','',true);
		echo json_encode(array('html'=>$html,'info'=>$this->rs));
		exit;
	}

	function getFundsInfo(){
		$module_name		= trim($_GET['module_name']);
		addLang($module_name);
		$rs					= array('comp_id' => intval($_GET['comp_id']), 'currency_id' => intval($_GET['currency_id']), 'basic_id' => intval($_GET['basic_id']));
		$this->module_name	= $module_name;
		$this->fund			= D($module_name)->getCheckFundsInfo($rs);///获取款型指定可选择信息
		$html				= $this->display('Accounts:funds_info','','',true);
		echo json_encode(array('html'=>$html, 'rs'=>$rs));
		exit;
	}

	/*
	 * 导出条形码到pdf数据验证
	 * @author jph 20140905
	 */
	function exportBarcodeValid(){
		$model			= M();
		$_validDetail	= array(
			array("id",'require','require',1),
			array("quantity",'pst_integer','pst_integer',1),
		);
		$_validate		= array(
			array("",$_validDetail,'require',1,'validDetail'),
		);
		$model->addError(validDetailSpecRepeat($_POST, array('id'), 'id'));
		$sum			= 0;
		$errKey			= 0;
		foreach ($_POST['detail'] as $key=>$val) {
			if (!empty($val['id']) && $val['quantity'] > 0) {
				$errKey	 = $key;
				$sum	+= (int)$val['quantity'];
			}
		}
		if ($sum > C('EXPORT_SUM_QUANTITY_LIMIT')) {
			$model->addError(array('name' => 'detail[' . $errKey . '][quantity]', 'value'=> sprintf(L('error_export_sum_quantity'), C('EXPORT_SUM_QUANTITY_LIMIT'))));
		}
		if (false === $model->_validSubmit($_POST, $_validate)) {
			$this->error($model->getError(), $model->errorStatus);
			exit;
		}
		$key	= md5(serialize($_POST).time());
		S($key, $_POST);
		echo json_encode(array('status'=>1, 'key'=>$key, 'info'=>L('_OPERATION_SUCCESS_')));
		exit;
	}
    /**
     * 打印条形码数据验证
	 * @author yyh 20141013
     */

	function printBarcodeValid(){
		$model			= M();
		$_validDetail	= array(
			array("id",'require','require',1),
			array("quantity",'pst_integer','pst_integer',1),
		);
		$_validate		= array(
			array("",$_validDetail,'require',1,'validDetail'),
		);
		$model->addError(validDetailSpecRepeat($_POST, array('id'), 'id'));
		$sum			= 0;
		$errKey			= 0;
		foreach ($_POST['detail'] as $key=>$val) {
			if (!empty($val['id']) && $val['quantity'] > 0) {
				$errKey	 = $key;
				$sum	+= (int)$val['quantity'];
			}
		}
		if (false === $model->_validSubmit($_POST, $_validate)) {
			$this->error($model->getError(), $model->errorStatus);
			exit;
		}
        echo json_encode(array('status'=>1,'module'=>$_POST['module'],'id'=>$_POST['detail'][1]['id'],'quantity'=>$_POST['detail'][1]['quantity'], 'info'=>L('_OPERATION_SUCCESS_')));
		exit;
	}
    /*
	 * 导出条形码到pdf
	 * @author jph 20140925
	 */
	function exportBarcode(){
		addLang('Common');
		$_POST	= S($_GET['key']);
		S($_GET['key'], null);//防止重复刷新生成pdf
		$this->exportBarcodePdf($_POST['module'], $_POST['detail']);
	}
    function getApiToken() {
        $token  =  getApiToken();
        session($_GET['id'] . 'ApiToken', $token);
        exit($token);
    }
    function exportInstockBarcode(){
        addLang('Common');
		$id		= intval($_GET['id']);
        $module = $_GET['module'];
        if(in_array($module,array('Instock'))){
            $data	= $id > 0 ? M('instock_box')->field('id')->where('instock_id='.$id)->select() : array();
            $path	= '/' . $id;
        }else{
            $data   = $id;
            $path   = null;
        }
		$this->exportBarcodePdf($module, $data, $path);
    }

	public function exportBarcodePdf($module, $data, $path = null){
		if (empty($module) || empty($data)) {
			redirect(__APP__);
		}
		//生成pdf
		$base_path			= BARCODE_PATH . ucfirst($module);
		$path				= $base_path . (!empty($path) ? '/' . trim($path, '/') : '');
		$barcode_pc_type	= '.' . C('BARCODE_PC_TYPE');
		$filename			= $module . 'Barcode' . date('Ymd');
		ini_set('max_execution_time','60');
		ini_set('memory_limit', '512M');
		vendor('tcpdf6.tcpdf','','.php');
        //PDF设置画布大小
        if($module == 'SaleOrder'){
            $order_info = M($module)->alias('s')->join('left join __EXPRESS__ e on s.express_id=e.id')->where('s.id='.$data)->field('e.company_id,e.shipping_type')->find();
            if($order_info['company_id'] == C('EXPRESS_IT-NEXIVE_ID')){
                $PageSizeFromFormat = 'SALEORDER_ITNEXIVE_BARCODE';
            }else if($order_info['shipping_type'] == C('SHIPPING_TYPE_SURFACE')){
                $PageSizeFromFormat = 'SALEORDER_POST_BARCODE';
            }else{
                $PageSizeFromFormat = 'SALEORDER_DEFAULT_BARCODE';
            }
        }else{
            $PageSizeFromFormat  = $module . '_Barcode';
        }
		$pdf = new TCPDF('L', 'mm', $PageSizeFromFormat);
		$pdf->SetTitle($filename);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		switch ($module) {
		    //退货标签        add by lxt 2015.10.21
		    case 'ReturnSaleOrder':
		        //防止中文乱码
		        $pdf->SetFont('droidsansfallback','',14);
		        foreach ((array)$data as $val) {
		            $quantity =   $val['quantity'];
		            $info     =   D('ReturnSaleOrder')->relation(true)->find($val['id']);
		            $html     .=  '<span style="height:10.5pt"><strong>Return LP:'.$info['return_logistics_no'].'</strong></span><br>';
					$img_path = BARCODE_PATH . 'ReturnSaleOrder/' . $info['id'] . '.' . C('BARCODE_PC_TYPE');
					if(file_exists($img_path)) $html .=  '<span style="height:52.5pt"><img width="215pt" height="70pt" src="'.$img_path.'"></span><br>';
		            $html     .=  '<span style="font-size:16pt"><strong>From:'.$info['addition']['country_name'].'</strong></span><br>';
		            $html     .=  '<span style="font-size:10.5pt">Return Order:'.$info['order_no'].'</span><br>';
		            $html     .=  '<span style="font-size:10.5pt">'.$info['factory_addition']['consignee'].'</span><br>';
		            $html     .=  '<span style="font-size:10.5pt">'.$info['factory_addition']['mobile'].'</span><br>';
		            $html     .=  '<span style="font-size:10.5pt">'.$info['factory_addition']['address'].'</span><br>';
		            $html     .=  '<span style="font-size:10.5pt">'.$info['factory_addition']['company_name'].' '.$info['factory_addition']['city_name'].' '.$info['factory_addition']['address2'].'</span><br>';
		            do{
		                $pdf->AddPage();
		                $pdf->writeHTMLCell($w, $h, 5, 5,$html);
		                $quantity--;
		            }while ($quantity>0);
		        }
		        break;
            case 'PackBox':
                $pdf->SetFont('droidsansfallback','',11);
                    $quantity   = $val['quantity'];
                    do{
                        $info   = D('PackBox')->getInfo($data);
                        foreach($info['detail'] as $detail){
                            $info['weight'] += $detail['weight'];
                        }
                        $weight = D('package')->where('id='.$info['package_id'])->getField('weight');
                        $info['weight'] = WeightGtoKG($info['weight']+$weight);
                        $html   .= '<span>FROM:EDA ES WH<br />';
                        $html   .= 'TO:COE HK WH<br />';
                        $html   .= '<br />';
                        $html   .= L('big_pack_no').':'.$info['pack_box_no'].'<br />';
                        $html   .= L('big_pack_barcode').'：<br />';
                        $html   .= '<img width="141pt" src="'.BARCODE_PATH . 'PackBox/' . $info['pack_box_no'] . '.' . C('BARCODE_PC_TYPE').'"><br />';
                        $html   .= L('internal_quantity').'：'.count($info['detail']).' 个<br />';
                        $html   .= L('whole_bag_weight').'：'.$info['weight'].' kg<br /></span>';
                        $pdf->AddPage();
                        $pdf->writeHTMLCell(0,0 , 5, 5, $html);
                        $quantity--;
                    }while ($quantity>0);
                break;
            case 'Product':
                $pdf->SetFont('droidsansfallback','',8);
                foreach((array)$data as $val){
                    if($val['id'] > 0){
                        $product_id[$val['id']] = $val['id'];
                    }
                }
                $product_barcode_info   = getProductBarcodeInfo($product_id);
                foreach ((array)$data as $val) {
                    $quantity   = $val['quantity'];
                    $src	= $path . '/' . $val['id'] . $barcode_pc_type;
                    do{
                        $html   = '<div style="line-height:90% ;font-size:8pt;text-align:center;" ><span><img height="32px" src="'.$src.'"><br /></span>';
                        $html   .= $product_barcode_info[$val['id']]['html'];
                        $html   .= '</div>';
                        $pdf->AddPage();
                        $pdf->writeHTMLCell(0,0 , 0, 0, $html);
                        $quantity--;
                    }while ($quantity>0);
				}
                break;
            case 'Instock':
                $pdf->SetFont('droidsansfallback','',11);
                foreach((array)$data as $val){
                    if($val['id'] > 0){
                        $instock_box[$val['id']] = $val['id'];
                    }
                }
                $box_barcode_info   = getInstockBoxInfo($instock_box);
                foreach ((array)$data as $val) {
                    $src	= $path . '/' . $val['id'] . $barcode_pc_type;
                    $html   = '<div style="line-height:90% ;font-size:11pt;font-weight:bolder;text-align:center;" ><span><img src="'.$src.'"><br /></span>';
                    $html   .= $box_barcode_info[$val['id']]['html'];
                    $html   .= '</div>';
                    $pdf->AddPage();
                    $pdf->writeHTMLCell(0,0 , 0, 0, $html);
				}
                break;
            case 'SaleOrder':
                $pdf->SetFont('droidsansfallback','',8);
				$html_info  = $this->getSaleOrderHTML($data,true);
				$html		.= $html_info['info'];
                $pdf->AddPage();
                $pdf->writeHTMLCell(0,0 , 0, 0, $html);
                break;
			default:
				foreach ((array)$data as $val) {
                    $quantity   = $val['quantity'];
                    $src	= $path . '/' . $val['id'] . $barcode_pc_type;
                    do{
                        $pdf->AddPage();
                        $pdf->Image($src, 0, 0, '', '', 'GIF');
                        $quantity--;
                    }while ($quantity>0);
				}
				break;
		}
		$pdf->Output($filename . '.pdf', 'I');
	}


	/**
	 *
	 */
	public function getClientInfoHtml(){
		$client_id	= intval($_POST['client_id']);
		if ($client_id > 0) {
			$rs = M('Client')->find($client_id);
			$this->rs = _formatArray($rs);
		}
		$this->not_readonly	= $_POST['not_readonly'] == 'true' ? true : false;
		$this->display('Public:client_info');
	}

	/**
	 *
	 */
	public function getReturnOrderDetail() {
        //退货是否关联处理单号
        $is_related_sale_order = in_array(intval($_POST['is_related_sale_order']), C('WHETHER_RELATED_DEAL_NO')) ? intval($_POST['is_related_sale_order']) : C('IS_RELATED_SALE_ORDER');
        if ($_POST['id'] > 0) {
            $rs = M('return_sale_order')->find($_POST['id']);
            if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
                exit();
            }
            //明细信息
            $where = 'return_sale_order_id=' . $_POST['id'];
            $rs['detail'] = M('return_sale_order_detail')->field('*')->where($where)->select();
			$model=D('ReturnSaleOrder');
			$return_service=$model->getReturnService($_POST['id']);
			 foreach ($rs['detail'] as &$temp_row){
				if(isset($return_service[$temp_row['id']])){
					$temp_row['return_service_no'] =   $return_service[$temp_row['id']]['return_service_no'];
				}
		    }
            $is_factory = getUser('role_type') == C('SELLER_ROLE_TYPE') ? 1 : 0;
            $storage_info = M('return_sale_order_storage_detail')->where('return_sale_order_id=' . (int) $_POST['id'])->getField('product_id,location_id,quantity,return_sale_order_storage_id');
            $detail_info = M('return_sale_order_detail')->where('return_sale_order_id=' . (int) $_POST['id'])->getField('id,product_id,quantity');
            // 处理方式
            $sql = 'select a.*
				from return_sale_order_detail_service as a
				where a.return_sale_order_id=' . (int) $_POST['id'] . '
				group by a.id order by id';
            $rs['service'] = M('return_sale_order_detail_service')->query($sql);
            foreach ((array) $rs['service'] as $key => $val) {
                $service_key = $val['return_sale_order_id'] . '_' . $val['return_sale_order_detail_id'] . '_' . $val['relation_id'];
                $service_data[$service_key][] = array(
                    "0" => $val['service_detail_id'],
                    "1" => $val['quantity'],
                    "2" => moneyFormat($val['price'], 0, 2, false)
                );
            }
            $rs['return_sale_order_state'] = M('return_sale_order')->where('id=' . (int) $_POST['id'])->getField('return_sale_order_state');

            foreach ((array) $rs['detail'] as $k => $v) {
                $rs['detail'][$k]['sale_order_number'] = $v['quantity'];
                $rs['detail'][$k]['is_factory'] = $is_factory;
                if (!empty($detail_info)) {
                    $rs['detail'][$k]['quantity'] = $detail_info[$v['id']]['quantity'];
                    $rs['detail'][$k]['id'] = $v['id'];
                    $detail_key = $_POST['id'] . '_' . $rs['detail'][$k]['id'] . '_' . $rs['detail'][$k]['relation_id'];
                    if (array_key_exists($detail_key, $service_data)) {
                        $rs['detail'][$k]['return_service'] = json_encode($service_data[$detail_key]);
                    }
                } else {
                    unset($rs['detail'][$k]['quantity']);
                    unset($rs['detail'][$k]['id']);
                }
                if (!empty($storage_info)) {
                    $rs['detail'][$k]['location_id'] = $storage_info[$v['product_id']]['location_id'];
                    $rs['detail'][$k]['in_quantity'] = $storage_info[$v['product_id']]['quantity'];
                    $rs['detail'][$k]['location_no'] = getLocationNo($storage_info[$v['product_id']]['location_id']);
                    $rs['detail'][$k]['return_sale_order_storage_id'] = $storage_info[$v['product_id']]['id'];
                }
            }
            $sale_info = _formatList($rs['detail']);
            $rs['detail'] = $sale_info['list'];
            $rs['detail_total'] = $sale_info['total'];
            //退货关联处理单号 added by jp 20141112
            $rs['is_related_sale_order'] = $is_related_sale_order;

            $view = Think::instance('View');
            $view->assign('rs', $rs);
            $view->assign('tpl_module_name', 'ReturnSaleOrder');
            if($rs['is_related_sale_order']!=C('IS_RELATED_SALE_ORDER') && in_array($_POST['return_sale_order_state'],C('CAN_EDIT_SERVICE'))){
                $this->tpl_action_name	= 'add';
            }else{
                $this->tpl_action_name	= 'edit';
            }
            if (in_array($_GET['return_sale_order_state'], C('SHOW_LOCATION_RETURN_SALE_ORDER_STATE')) && getUser('role_type') != C('SELLER_ROLE_TYPE')) {
                $rs['html'] = $view->display('ReturnSaleOrder:shelves_return_detail', '', '', true);
            }else {
                $rs['html'] = $view->display('ReturnSaleOrder:return_detail', '', '', true);
            }
            //客户信息
            $client = M('Client')->field('comp_name as client_name,comp_no as client_no,email as comp_email')->find($rs['client_id']);
            if ($client) {
                $rs = array_merge($rs, $client);
            }
            $addition_data = M('return_sale_order_addition')->field('address,address2,post_code,country_name,city_name,country_id,fax,email,mobile,tax_no,consignee,company_name,transmit_name')->where($where)->find();
        }else{
            $rs['is_related_sale_order'] = $is_related_sale_order;
            $this->rs               = $rs;
            $this->tpl_module_name	= 'ReturnSaleOrder';
            $this->tpl_action_name	= 'add';
        }
        if (in_array($_POST['return_sale_order_state'], C('SHOW_LOCATION_RETURN_SALE_ORDER_STATE')) && getUser('role_type') != C('SELLER_ROLE_TYPE')) {
            $this->display('ReturnSaleOrder:shelves_return_detail');
        }elseif ($_POST['return_sale_order_state']==C('PROCESS_COMPLETE')){
            $this->display('ReturnSaleOrder:process_return_detail');
        }else{
            $this->display('ReturnSaleOrder:return_detail');
        }
    }
    /**
	 * 加载问题订单关联订单明细
	 */
	public function getQuestionOrderDetail() {
            $rs['warehouse_id'] = $_POST['warehouse_id'];
            $this->rs               = $rs;
            $view->tpl_module_name	= 'QuestionOrder';
            $this->tpl_action_name	= 'view';
            $this->display('QuestionOrder:question_detail');
    }

    public function printSaleOrderAddition(){
		//GLS api
		$gls_sale	= M('SaleOrder')->field('sale_order.id,is_print,sale_order_state')
			->join('left join sale_order_addition b on sale_order.id=b.sale_order_id inner join district d on b.country_id=d.id')
			->where('sale_order.id='.intval($_GET['id']).' and exists(select 1 from express e where e.id=sale_order.express_id and e.enable_api=1 and e.company_id in('.implode(',',C('GLS_API_EXPRESS_ID')).') )
				and d.abbr_district_name not in('.  implode(',', C('GLS_NOT_USE_COUNTRIES')).')')->find();
		if(!empty($gls_sale)){
			if($gls_sale['sale_order_state']!=C('SHIPPED')){
				$error	= '当前状态不可打印运单';
			}else if($gls_sale['is_print']>0){
				$error	= '-1';
			}else{
				$this->printGlsWaybill();
			}
			echo	json_encode(array('error'=>$error));
			exit;
		}
        $result = $this->getSaleOrderHTML();
        echo json_encode($result);
        exit;
    }

    public function getSaleOrderHTML($id=0,$is_pdf=false){
        $id <= 0 && $id = intval($_GET['id']);
        $data					= M('sale_order')->join('as a left join sale_order_addition as b on a.id=b.sale_order_id')->where('a.id='.$id)->find();
        $data['addition'][1]    = $data;
        $express				= M('express')->field('company_id, shipping_type')->find($data['express_id']);
		$data					= array_merge($data, $express);
		$data['id']				= $id;
        return get_sale_order_barcode_info($data, $is_pdf);
    }

    public function printPackBoxAddition(){
        $id     = intval($_GET['id']);
        $info   = D('PackBox')->getInfo($id);
        $weight = 0;
        if($info['is_out_batch']){
            $review_weight = M('out_batch_detail')->where('pack_box_id='.$id)->getField('review_weight');
            if(!empty($review_weight)){
                $weight = $review_weight;
            }
        }
        if($weight == 0){
            foreach($info['detail'] as $detail){
                $weight += $detail['weight'];
            }
            $weight += D('package')->where('id='.$info['package_id'])->getField('weight');
        }
        $info['weight'] = WeightGtoKG($weight);
        $htmlInfo   = A('PackBox')->packBoxLabel($info);
        $size       = array('width'=>'80mm','height'=>'90mm');
        echo json_encode(array('size'=>$size,'info'=>$htmlInfo));
        exit;
    }
    //打印退货物流单号          add by lxt 2015.09.11
    public function printReturnLogisticsNo(){
        $id     = intval($_GET['id']);
        $info   = D('ReturnSaleOrder')->relation(true)->find($id);
        $htmlInfo   = A('ReturnSaleOrder')->returnLogisticsNoLabel($info);
        $size       = array('width'=>'120mm','height'=>'90mm');
        echo json_encode(array('size'=>$size,'info'=>$htmlInfo));
        exit;
    }

    public function printOutBatchAddition(){
        $id     = intval($_GET['id']);
        $info   = D('OutBatch')->getInfo($id);
        $field  = $info['is_review_weight'] ? 'review_weight' : 'weight';
        foreach($info['detail'] as &$detail){
            $detail['weight']   = WeightGtoKG($detail[$field]);
        }
        $info   = _formatListRelation($info);
        $htmlInfo   = A('OutBatch')->outBatchLabel($info);
        $size       = array('width'=>'200mm','height'=>'280mm');//210*297
        echo json_encode(array('size'=>$size,'info'=>$htmlInfo));
        exit;
    }

    public function printProductBarcode(){
        $id         = intval($_GET['id']);
        $quantity   = intval($_GET['quantity']);
        $base_path			= BARCODE_PATH . 'Product';
		$barcode_pc_type	= '.' . C('BARCODE_PC_TYPE');
        $product_info   = getProductBarcodeInfo($id);
		if (data_permission_validation($product_info[$id]) === false) {
			exit;
		}
        $src	= $base_path . '/' . $id . $barcode_pc_type;
        $html   = '<div><div style="line-height:90% ;font-size:8pt;text-align:center;" ><span><img src="'.$src.'"><br /><br /></span>';
        $html   .= $product_info[$id]['html'];
        $html   .= '</div></div>';
        $size       = array('width'=>'75mm','height'=>'25mm');
        echo json_encode(array('size'=>$size,'info'=>$html));
        exit;
    }

    public function batchPrintProductBarcode(){
        $id         = intval($_GET['id']);
        $quantity   = intval($_GET['quantity']);
        $base_path			= BARCODE_PATH . 'Product';
		$barcode_pc_type	= '.' . C('BARCODE_PC_TYPE');
        $product_info   = getProductBarcodeInfo($id);
        $src	= $base_path . '/' . $id . $barcode_pc_type;
        for($iteration=1;$quantity>=$iteration;$iteration++){
            if(($iteration % 40) == 1){
                $html   .= '<ul style="clear: both;page-break-after:always;">';
            }
            $html   .= '<li style=" float: left; height:110;vertical-align: top;margin-top: 41px ;text-align:center;">
                <img width="190" src="'.$src.'"><br />';
            $html   .= $product_info[$id]['html'];
            $html   .= '</li>';
            if($quantity==$iteration || ($iteration % 40) == 0){
                $html   .= '</ul>';
            }
        }
        $size   = array('width'=>'210mm','height'=>'297mm');
        echo json_encode(array('size'=>$size,'info'=>$html));
        exit;
    }

    //快速编辑单元格
    public function editCell(){
        $id             = intval($_GET['id']);
        $value          = trim($_GET['value']);
        $col_name       = trim($_GET['col']);
        $type           = intval($_GET['type']);
		if ($value =="") {
            echo json_encode(array('status'=>0, 'info'=>L('require')));
			exit;
		}
        if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
            $count  = M('sale_order')->where('id='.$id.' and sale_order_state in ('.  implode(',', C('EDIT_ORDER_NO_STATE')).')')->count();
            if($count <= 0){
                echo json_encode(array('status'=>-1,'info'=>L('order_no_state_changed')));
                exit;
            }
        }
        $data           = array('id'=>$id,$col_name=>$value);
        $order_info = M('sale_order')->field('order_no,package_bg,factory_id')->find($id);
        $package_bg = $order_info['package_bg'];
        !empty($order_info['package_bg']) && $order_info['package_bg'] = '|'.$order_info['package_bg'];
        $old_value  = empty($order_info['package_bg']) ? $order_info['order_no'] : $order_info['order_no'].$order_info['package_bg'];
        if($type==1){
            $result             = array('id'=>$id,'value'=>$order_info['order_no']);
            $result_data        = array('status'=>1, 'result'=>$result, 'info'=>L('_OPERATION_SUCCESS_'));
        }else{
            $count      = M('sale_order')->where('factory_id='.$order_info['factory_id'].' and order_no="'.$value.'" and package_bg="'.$package_bg.'" and id<>'.$id)->find();
            if($count>0){
                $result           = array('id'=>$id,'value'=>$old_value);
                $result_data    = array('status'=>-1,'result'=>$result,'info'=>L('unique'));
            }else{
                if (M('SaleOrder')->save($data) !== FALSE) {
                    $result           = array('id'=>$id,'value'=>$value.$order_info['package_bg']);
                    $result_data    = array('status'=>1, 'result'=>$result, 'info'=>L('_OPERATION_SUCCESS_'));
                } else {
                    $result           = array('id'=>$id,'value'=>$old_value);
                    $result_data    = array('status'=>-1,'result'=>$result,'info'=>L('oper_error'));
                }
            }
        }
        echo json_encode($result_data);
        exit;
    }
    public function weightByPackage(){
        $weight['weight']   = M('package')->where('id='.(int)$_GET['package_id'])->getField('weight');
        $id = (int)$_GET['id'];
        $data           = M('sale_order')->find($id);
        $data['detail'] = M('sale_order_detail')->where('sale_order_id='.$id)->select();
        $model  = D('SaleOrder');
        if($data['detail']){
            $product_list   = $model->getProductInfo($data['detail']);
        }
        if($product_list){
            $data           = $model->getTotalWeightCube($product_list,$data);
        }
		$express_data = M('express')->field('calculation')->where(array('id'=>$data['express_id']))->find();
		$order_weight = choose_weight($data['detail_total']['edml_weight'],$data['detail_total']['volume_weight'],$express_data);
		$weight['weight'] += $order_weight;
        $weight         = _formatArray($weight);
        $total_weight   = _formatWeight($weight);
        echo  json_encode($total_weight);
        exit;
    }

    public function getSaleOrderNo(){
        $sale_order_no_arr  = M('SaleOrderDel')->where('id in ('.implode(',', $_GET['storage_id']).')')->getField('sale_order_no',true);
        exit(json_encode(implode(',', $sale_order_no_arr).L('delete_defeat')));
    }
    public function getStorageInfo(){
        $data   = M('storage')->where('id in ('.implode(',', $_GET['storage_id']).')')->order('product_id')->select();
        $data   = _formatList($data);
        foreach($data['list'] as $val){
            $location_id[]  = $val['location_id'];
        }
        $location_no    = M('location')->where('id in ('.  implode(',', $location_id).')')->getField('id,barcode_no ');
        foreach($data['list'] as &$value){
            $value['location_no']   = $location_no[$value['location_id']];
        }
        echo  json_encode($data['list']);
        exit;
    }

    public function getReturnInfo(){
        $warehouse_id           = intval($_GET['warehouse_id']);
        $return_logistics_no    = trim($_GET['return_logistics_no']);
        $return_track_no             = trim($_GET['return_track_no']);
        $is_aliexpress          = intval($_GET['is_aliexpress']);
        $factory_id             = intval($_GET['factory_id']);
        $where  = '';
        $warehouse  = M('warehouse')->where('relation_warehouse_id='.$warehouse_id)->getField('id',true);
        $warehouse[]    = $warehouse_id;
        $where  = 'rs.warehouse_id in ('.implode(',', $warehouse).')';
        if(!empty($return_logistics_no)){
            $where  .= ' and r.return_logistics_no like "'.$return_logistics_no.'"';
        }

        if(!empty($return_track_no)){
            $where  .= ' and r.return_track_no like "'.$return_track_no.'"';
        }
		$where  .= ' and ' . ($is_aliexpress == C('SELECT_YES') ? '' : 'not') . '(' . cainiao_return_sale_order_where('r', 'rs', true) . ')';
        //退货状态
        $where  .= ' and r.return_sale_order_state='.C('RETURN_FOR_DELIVERY');
        //退货服务
        $where  .= ' and rsd.return_service_id='.C('BACK_TO_DOMESTIC');
        $where  .= ' and r.factory_id='.$factory_id;
        //查找对应退货单
        $return_sale_order  = M('return_sale_order_storage')
                ->join(' rs left join return_sale_order r on rs.return_sale_order_id=r.id
                        left join return_sale_order_detail_service rds on rds.return_sale_order_id=r.id
                        left join return_service_detail rsd on rsd.id=rds.service_detail_id')
                ->where($where)
                ->field('r.id,r.return_track_no,r.return_logistics_no,rs.warehouse_id')
                ->find();
        //where    r.return_sale_order_state='.C('RETURN_SHELVES').' and rds.service_detail_id='.C('RETURN_HOME').' and
        if(!empty($return_sale_order)){
            //退货单产品重量
            $weight = D('PackBox')->getReturnWeight($return_sale_order['id']);
            $return_sale_order['weight']    = $weight[$return_sale_order['id']];
        }
        $return_sale_order  = _formatArray($return_sale_order);
        echo  json_encode($return_sale_order);
        exit;
    }

	public function recordCheckId(){
        $id		= intval($_GET['id']);
        $token	= $_GET['record_check_token'];
		$S		= S($token);
		if (empty($S)) {
			$S	= array($id);
		} else {
			$key		= array_search($id, $S);
			if($key !== false){
				unset($S[$key]);
			}else{
				$ids				= $S;
				$ids[]				= $id;
				$where				= array(
										'id'	=> array('in', $ids),
									);
				$packBox			= M('pack_box');
				$warehouse_count    = $packBox->where($where)->count('distinct warehouse_id');
				if($warehouse_count > 1){
				   echo 1;
				   exit;
				}
				$factory_count      = $packBox->where($where)->count('distinct is_aliexpress');
				if($factory_count > 1){
				   echo 2;
				   exit;
				}
				$S[]    = $id;
			}
		}
		S($token, $S);
    }

    public function cleanCheck(){
        $token = $_GET['record_check_token'];
		S($token, null);
    }
    public function isCheckPackBox(){
		$S	= S($_GET['token']);
        echo json_decode((empty($S)) ? 0 : 1);
        exit;
    }

    //特殊处理退货入库列表的拣货单导出        add by lxt 2015.09.22
    public function setPikingExport(){
        //是否速卖通
        if ($_POST['is_aliexpress']){
            $info['query']['a.factory_id']      =   C('CAINIAO_FACTORY_ID');
        }else{
            $info['notequal']['a.factory_id']   =   C('CAINIAO_FACTORY_ID');
        }
        if ($_POST['warehouse_id']){
            $info['query']['b.warehouse_id']    =   $_POST['warehouse_id'];
        }
        switch ($_POST['service_detail_id']){
            //如果服务方式查询选择是下架销毁，那么对应的退货单状态必为已丢弃，只要要对应的退货单状态查询即可
            case 1:
                $info['query']['a.return_sale_order_state']   =   C('DROPPED');
                break;
            //送回国内同理
            case 2:
                $info['query']['a.return_sale_order_state']   =   C('RETURN_FOR_DELIVERY');
                break;
                default:
                    $info['in']['a.return_sale_order_state']    =   array(C('DROPPED'),C('RETURN_FOR_DELIVERY'));
                    break;
        }
        //把小窗口的查询条件保存到session中
        $rand   =   md5(time());
        session($rand,$info);
        $rs =   array(
            'rand'  =>  $rand,
            'state' =>  1
        );
        echo json_encode($rs);
    }
    public function sentEmail(){
        $result       =  A('OutBatch')->sentEmail('OutBatch',$_POST);
        $email_list   =  array();
        foreach($result as $email => $flag){
            if($flag !== true){
                $email_list[]       = $email;
                $abnormal_output    = ob_get_clean();
            }
        }
        echo json_encode(array("state"=> empty($email_list),"object_id" => $_POST['object_id'],"email_address" => $email_list,"abnormal_output"=>$abnormal_output));
    }
	public function messageAnnounced(){
		$messageModel = D('Message');
		$data['is_announced'] = C('HAVE_ANNOUNCED');
		$result=$messageModel->where('id='.$_POST['id'])->data($data)->save();
		echo $result;
	}

    public function isCustomBarcode(){
        $factory_id = intval($_GET['factory_id']);
        if($factory_id>0){
            echo json_encode(isCustomBarcode($factory_id));
        }
    }
    public function showWCurrency(){
        $warehouse_id   = intval($_GET['warehouse_id']);
        $currency_no    = SOnly('currency', SOnly('warehouse', $warehouse_id,'w_currency_id'),'currency_no');
        echo $currency_no;
    }
	//获取销售处理单号产品信息
	public function getSaleOrderProductList(){
		$where['sale_order_id']   = intval($_GET['sale_order_id']);
		$data = M('sale_order_detail')->alias('s')->field('s.product_id,p.product_no,p.product_name,p.custom_barcode,s.quantity')
									->join('left join product p on s.product_id=p.id')->where($where)->select();
		echo json_encode($data);
	}
	//获取发货产品信息
	public function getInstockProductInfo(){
		$instock_id = $_GET['instock_id'];
        $box_id = $_GET['box_id'];
		$product_id = $_GET['product_id'];

		//获取入库导入发货单
		$fileMap['a.relation_id'] = $instock_id;
		$fileMap['a.file_type'] = 1;
		$fileMap['d.box_id'] = $box_id;
		$fileMap['d.product_id'] = $product_id;
		$detailInfo = M('file_relation_detail')->alias('a')->field('d.location_id,d.barcode_no as location_no')->join('left join file_detail d on a.object_id = d.file_id ')->where($fileMap)->find();

		//获取发货单详情
		$instockMap['a.id'] = $instock_id;
		$instockMap['d.instock_id'] = $instock_id;
		$instockMap['d.box_id'] = $box_id;
		$instockMap['d.product_id'] = $product_id;
		$instockDetail = M('instock')->alias('a')->field('a.warehouse_id,d.id as instock_detail_id,d.quantity,d.in_quantity')->join('left join instock_detail d on a.id=d.instock_id')->where($instockMap)->find();

		$detailInfo['product_no'] = SOnly('product',$product_id,'product_no');
		$detailInfo = array_merge($detailInfo,$instockDetail);
		//部分产品未入库
		if(empty($detailInfo['in_quantity'])) {
			$detailInfo['in_quantity'] = 0;
		}
		echo json_encode($detailInfo);
    }
    public function getProductIdByBarcode(){
        $product_barcode    = $_GET['product_barcode'];
        echo M('product')->where('custom_barcode="'. $_GET['product_barcode'].'"')->getField('id');
    }
    public function setPostSection(){
        $model			= M();
		$_validDetail	= array(
			array("english",'english','english',2),
			array("post_begin",'z_integer','z_integer',2),
			array("post_end",'z_integer','z_integer',2),
            array('post_end','post_begin','post_limit',2,'gt'),
            array('post_begin','require','end_need_begin',1,'ifcheck2', '', 'post_end'),
		);
		$_validate		= array(
			array("",$_validDetail,'require',1,'validDetail'),
		);
		$model->addError(validDetailSpecRepeat($_POST, array('id'), array('english','post_begin','post_end')));
		if (false === $model->_validSubmit($_POST, $_validate)) {
			$this->error($model->getError(), $model->errorStatus);
			exit;
		}
		echo json_encode(array('status'=>1, 'info'=>L('_OPERATION_SUCCESS_')));
		exit;
    }

    public function getReturnServiceNo(){
        $arr				= $_POST['service'];
		$service_detail_id	= array();
        foreach( $arr as $val){
			if ($val[0] > 0) {
                $service_detail_id[]	= intval($val[0]);
			}
        }
		if (!empty($service_detail_id)) {
			$res    = array(
				'a.id'	=> array('in', $service_detail_id),
			);
			$rest   = M('return_service_detail')->join('as a left join return_service as b ON a.return_service_id=b.id')->where($res)->group('b.id')->getField('return_service_no',true);
			echo implode(',', $rest);
		}
        exit;
    }

    public function setInsurePrice(){
        $data['id']             = intval($_POST['id']);
        $data['insure_price']   = trim($_POST['insure_price']);
        $info   = M('SaleOrder')->find($data['id']);
        M('SaleOrder')->save($data);
        if($info['insure_price'] != $data['insure_price']){
            D('ClientSale')->_fund($data);
        }
        exit;
    }
    public function printWaybill(){
        $id     = intval($_GET['id']);
        if($id>0){
            $htmlInfo   = A('SaleOrder')->printWaybillLabel($id);
        }
        $size       = array('width'=>'200mm','height'=>'280mm', 'is_it_nexive'=>true);//210*297
        echo json_encode(array('size'=>$size,'info'=>$htmlInfo));
        exit;
    }
    public function remindMessage(){
        $list = $_SESSION[C('ADMIN_AUTH_KEY')] ? 0 : $this->getRemindBasic(false);
        echo json_encode(count($list['message']['list']));
        exit;
    }
    public function messageJump(){
        $this->display('Message:index');
    }

	public function getWarehouseAccountStartDate(){
		if ($_REQUEST['factory_id'] > 0 && $_REQUEST['warehouse_id'] > 0) {
			//起始计费时间
			$warehouse_fee_start_date	= M('company_factory')->where(array('factory_id' => $_REQUEST['factory_id']))->getField('warehouse_fee_start_date');
			echo formatDate(get_warehouse_account_start_date($_REQUEST['factory_id'], $_REQUEST['warehouse_id'], $warehouse_fee_start_date), 'outdate');
		}
		exit;
	}
    public function showProduct(){
        $custom_barcode=$_REQUEST['custom_barcode'];
        $product_id = M('product')->where('custom_barcode="'.$custom_barcode.'"')->getField('id');
        $product_id =intval($product_id);
        echo $product_id;
        exit;
    }
	public function setVatWarning(){
		$_SESSION['LOGIN_USER']['vat_quota_warning']	= '';
		exit;
	}

	//GLS API运单
	public function printGlsWaybill(){
        $id     = intval($_GET['id']);
		$mac_address	= trim($_GET['mac_address']);
		$gls	= D('Gls');
		//GLS api
        if($id>0){
			$sale	= express_api_get_sale_order_info('GLS', $id);
			$w_id	= $sale['warehouse_id'];
			$printer	= M('GlsPrinterName')->where('mac_address="'.$mac_address.'"')->count();
			if($printer==0){
				$error	= L('GLS_PRINTER_NAME_ERROR');
			}else if($sale['sale_order_state'] != C('SHIPPED')){
				$error	= '1';
			}else {
				if($sale['track_no_update_tips']>0 || empty($sale['track_no']) || $sale['is_print']>0){//set track_no
					$track_no	= $gls->getMaxPackageNo($w_id);
					if($track_no){
						$data['Labelurl']	= $sale['track_no'];
						$data['track_no']	= $gls->getVerification($track_no);
						$data['track_no_update_tips']	= 0;
						$r	= $gls->updateSaleOrder($id,$data);
						if($r==false){
							$error	= 'update track no failed';
						}
					}else{
						$error	= L('GLS_PACKAGE_NUMBER_ERROR').'('.SOnly('warehouse', $w_id,'w_name').')';
					}
				}
			}
			if(empty($error)){
				$gls->getShipmentOrderBasic($sale);
				$error	= $gls->StatusMessage;
			}
			$result	= $error;
			if(empty($result)){
				$rs		= A('Gls')->requestPrint($id,$w_id);
				if($rs){
					$data	= array(
						'track_no_update_tips'	=> 0,
						'is_print'		=> 1
					);
					$gls->updateSaleOrder($id, $data);
				}
				if($sale['is_print']>0){
					if(!empty($sale['track_no'])){
						M('GlsTrackNoList')->add(array('track_no'=>$sale['track_no'],'warehouse_id'=>$w_id));
					}
					$result	= "<div style='text-align:center'>打印成功!</div>";
				}else{
					$result	= '1';
				}
//			$result		= D('Gls')->parseRequestResult($id,$rs,$gls_sale['sale_order_no']);
			}
        }
        echo json_encode(array('error'=>$result));
        exit;
    }
    public function addGlsConfig(){
        $index  = intval($_POST['index'])+1;
        $item   = array(
            'w_id'  => 0,   'w_name'    => '',
            'ip'  => '',    'port'  => '',
            'user_account'  => '',  'receive_station_code' => '',
            'contact_id' => '', 'customer_id' => '',
            'shipper_name'  => '',  'shipper_name2' => '',  'shipper_name3' => '',
            'shipper_address' => '',    'country_code'  => '',
            'postcode'  => '',  'city'  => '',
            'package_no_start'  => '',  'package_no_end'  => '',
        );
        addLang('config');
        $this->assign('w_id',$index);
        $this->assign('item',$item);
        $this->display('Config:gls_config');
    }
}
?>