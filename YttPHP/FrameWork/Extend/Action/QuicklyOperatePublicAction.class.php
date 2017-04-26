<?php
/**
 * Ajax类
 * @copyright   2011 展联软件友拓通
 * @category   	通用
 * @package  	Action 
 * @version 	2011-03-25
 * @author 		邹燕娟
 */
class QuicklyOperatePublicAction extends Action {
	
	protected $notNeed_autoNo_Action	= array(
            'editState',
            'Barcode',
            'exportBarcode',
            'printBarcode',
            'printSaleOrder',
            'editAddress',
            'setCustomsClearanceState',
            'setAssociateWithState',
            'warehouseProcess',
            'pikingExport',
            'setReviewWeight',
            'batchUpload',
            'setPostSection',
            'setInsurePrice',
            'batchEdit',
            'remindMessage',
        );


	public function _initialize(){
		C('SHOW_PAGE_TRACE',false);
		addLang(ACTION_NAME);
		$this->type = $_GET['type']; 
		//自动补上编号 
		!in_array(ACTION_NAME, $this->notNeed_autoNo_Action) && A(ACTION_NAME)->_autoMaxNo(); 
		$userInfo	= getUser(); 
		$factory_id	= intval($_GET['factory_id']);
		if ($factory_id>0 || $userInfo['company_id'] > 0) {
			$factory_id = $factory_id>0 ? $factory_id : $userInfo['company_id'];
			$this->assign("fac_id", $factory_id);
			$this->assign("fac_name", SOnly('factory',$factory_id, 'factory_name'));		
		}
		if(intval($_GET['id'])>0){
			$this->assign("parent_id", $_GET['id']);
			$this->assign("country_name", SOnly('country',$_GET['id'], 'country_name'));		
		}
	}
	
	/**
	 * @author yyh 20140827
	 *  编辑发货单状态
	 */
	public function editState() {
		C('THROW_JSON_TO_STRING', true);	//让throw_json直接返回错误信息
		$_GET['method_name']    = 'edit';
		tag($_GET['module'].'&'. $_GET['method_name'], $_GET); /// 添加action_init 标签  
		$state_name	      = array_search($_GET['module'],C('STATE_OBJECT_FIELD'));
		switch ($_GET['module']) {
			default :
				$state_data	      = C(C('STATE_DATA.'.$_GET['module']));
				break;
		}
        $model  = D($_GET['module']);
        $vo     = $model->find($_GET['id']);
        $model->cacheLockVersion($vo); 
		$this->assign('real_arrive_date',$vo['real_arrive_date']);
		$this->assign("state_data", $state_data);
		$this->assign("state_name", $state_name);
		$this->display();
	}
    public function printSaleOrder(){   
        $sql    = 'SELECT a.weight,a.warehouse_id,d.shipping_type,b.consignee,b.address,b.address2,b.company_name,b.post_code,b.city_name,b.country_id,b.country_name,a.express_id,d.company_id,if(a.express_id in ('.C('EXPRESS_DPW_ID').','.C('EXPRESS_PL-DPW_ID').'),\'warensendung\',\'\') as DPW
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc';
        $rs   = M()->query($sql); 
        $rs     = _formatList($rs);
        if(empty($rs)){
            echo L('no_sale_order');
            exit;
        }else{
            $this->rs   =$rs['list'];
            switch ($this->rs[0]['company_id']){
                case C('EXPRESS_IT-NEXIVE_ID'):
                    $tpl    = ACTION_NAME.'_IT-NEXIVE';
                    break;
                default :
                    $tpl    = '';
                    break;
            }
            $this->display($tpl);
        }        
    }

    public function Barcode(){
		$id	= intval($_GET['id']);
		switch ($_GET['module']) {
			case 'Instock':
				$member	= 'Instock';
				$model 		= D($_GET['module']);  
				$model->setId($id);
				$rs	= $model->view();
				$pc	= array();
				foreach ($rs['box'] as $box){
					$pc[]	= $box['id'];
				}
                $box_info   = getInstockBoxInfo($pc);
                $this->assign('box_info',$box_info);
				$this->rs	= $pc;
				break;
			case 'InstockIncludeProduct':
				$member	= 'InstockIncludeProduct';
				$model 		= D('Instock');  
				$model->setId($id);
				$rs	= $model->view();
				$pc	= array();
				foreach ($rs['box'] as $box){
					$box_id	= $box['id'];
					$pc[$box_id][]	= $box_id;
				}
				if ($rs['product']) {
					foreach ($rs['product'] as $product){
						$box_id	= $product['box_id'];
						$pc[$box_id][]	= $box_id . '/' . $product['product_id'];
					}					
				}
				$this->rs	= $pc;
				break;
            case 'Product':
                if ($_GET['quantity'] > 0) {
                    $member	= 'Product';
                    $product_info   = getProductBarcodeInfo($_GET['id']);
                    $rs=array('module'=>$_GET['module'],'id'=>$_GET['id'],'quantity'=>$_GET['quantity'],'html'=>$product_info[$_GET['id']]['html']);
                    $this->rs	= $rs;
                }
				break;
		}
		$this->display($member . ACTION_NAME);
	}
	
	/**
	 * 弹窗用以导出条形码pdf
	 * @author jph 20140904
	 */
	public function exportBarcode(){
		if ($this->type !== 'batch') {
			$id	= intval($_GET['id']);
			$dd	= strtolower($_GET['module']);
			//add by lxt 2015.10.21
			switch ($dd){
			    case 'returnsaleorder':
			        $member  =   'ReturnSaleOrder';
			        $info    =   array(
			            'id' =>  $id,
			            'no' =>  M($member)->where('id='.$id)->getField('order_no'),
			        );
			        break;
			        default:
			            $info	= array(
			                'id'	=> $id,
			                'no'	=> SOnly($dd, $id, $dd.'_no'),
			            );
			            break;
			}
			$this->rs	= array($info);
		}
		$this->display($member . ACTION_NAME);
	}	
    /**
     * 弹出导出输入条码个数的窗口
	 * @author yyh 20141013
     */
    public function printBarcode() {
        $id = intval($_GET['id']);
        $dd = strtolower($_GET['module']);
        $info = array(
            'id' => $id,
        );
        $this->rs = array($info);
        $this->display($member . ACTION_NAME);
    }

    public function ReturnService(){
		$index				  = intval($_POST['index']);
		$action				  = trim($_POST['action']);
		$module               = trim($_POST['module']);//调用模块     add by lxt 2015.08.30
		$factory_id           = intval($_POST['factory_id']);
		$return_service		  = trim($_POST['return_service']);
		$state_id             = intval($_POST['state_id']);//add by yyh 20151016
		$return_sale_order_id = intval($_POST['return_sale_order_id']);
		$is_cainiao_return	  = $return_sale_order_id > 0 && cainiao_return_sale_order_id($return_sale_order_id);
		$where				  = $action == 'add' ? 'where a.status=1 and b.is_return_service=1':'';
		$return_service		  = json_decode(htmlspecialchars_decode(stripcslashes($return_service)),true);
		$array				  = array(); 
		if(is_array($return_service)&&$return_service){
			foreach($return_service as $value){
				if(intval($value[0])>0&&intval($value[1])>0){
					$array[$value[0]][C('RETURN_SERVICE_QUANTITY')] = $value[1];
					$array[$value[0]][C('RETURN_SERVICE_PRICE')]    = trim($value[2]); 
				}
			}
		}

		$model 				  = M('ReturnService');  
		$sql				  = ' select a.id,a.return_service_no,a.return_service_name,
								  b.return_service_id,b.id as detail_id,b.item_number,b.item_name,b.price_explanation,b.comments
								  from return_service a
								  left join return_service_detail b
								  on a.id=b.return_service_id
								  '.$where.'
								  order by a.return_service_no asc,b.item_number asc';
		$list				  = $model->query($sql);

		if(is_array($list)&&$list){
		    //卖家或者超级管理员登入         edit by lxt 2015.08.30
			if(getUser('role_type')==C('SELLER_ROLE_TYPE') || $_SESSION[C('SUPER_ADMIN_AUTH_KEY')] || getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
				$seller_flag = true;
				$style		 = 'style="width:80px!important;" class="spc_input" ';
                $style_edit		 = 'style="width:80px!important;" class="spc_input disabled" ';
			}else{
				$seller_flag = false;
				$style		 = 'style="width:80px!important;" class="spc_input" ';
			}
			//查找选中的退货服务编号      add by lxt 2015.08.28
			foreach ($list as $value){
			    if (array_key_exists($value['detail_id'], $array)){
			        $service_id[]    =   $value['id'];
			        //如果有图片服务，则可以继续勾选‘送回国内’或者‘销毁’
			        if ($value['id']==C('PICTURE')){
			            $picture_tag    =   true;
			        }
			    }
			}
			if (($module=='ReturnSaleOrder' && $factory_id==C('CAINIAO_FACTORY_ID')) || $module=='ReturnSaleOrderStorage'){
			    $limit_tag    =   true;
			}
			
			foreach($list as $k => &$v){
			    //如果不是同个退货服务编号,不允许勾选(除非有图片服务)     add by lxt 2015.08.28
			    if (!($picture_tag && in_array($v['id'], array(C('DOWN_AND_DESTORY'),C('BACK_TO_DOMESTIC')))) && $limit_tag){
			        if (!in_array($v['id'], $service_id)){
			            $disabled   =   ' disabled ';
			        }
			        //退货入库不允许修改服务方式，只能修改数量(除非有图片服务)       add by lxt 2015.08.30
			        if ($module=='ReturnSaleOrderStorage' && $v['id']!=C('PICTURE')){
			            $false       =   ' onclick="return false;" ';
			            $readonly    =   ' readonly="true" ';
			        }
			    }else{
			        unset($disabled,$false,$readonly);
			    }
			    
				if(array_key_exists($v['detail_id'], $array)){ 
					$quantity	   = $array[$v['detail_id']]['quantity'];
					$price	       = $array[$v['detail_id']]['price']; 
                    if($price=="0.00"){
                        $price="";
                    }
					switch($action){
						case 'view':
							$v['checkbox'] = L('yes');
							$v['quantity'] = $quantity;
							$v['price']    = $price;
							break;
						case 'add':
							$v['checkbox'] = '<input type="checkbox" id="type_'.$k.'" name="type_'.$k.'[]" value="'.$v['detail_id'].'" checked>';
							$v['quantity'] = '<input type="text" id="r_quantity_'.$k.'" name="r_quantity_'.$k.'" value="'.$quantity.'" '.$style.'>';
							if(getUser('role_type')==C('SELLER_ROLE_TYPE') &&$module=='ReturnSaleOrder'){
                                $v['price']    = '<input type="text" readonly="true" id="r_price_'.$k.'" name="r_price_'.$k.'" value="'.$price.'" '.$style_edit.'>';
                            }else{
                                $v['price']    = '<input type="text" id="r_price_'.$k.'" name="r_price_'.$k.'" value="'.$price.'" '.$style.'>';
                            }      
							break;
						case 'edit':
							if($seller_flag){
							    if (in_array($state_id,C('WAREHOUSE_ROLE_CAN_EDIT')) || $is_cainiao_return){
							        $v['checkbox'] = L('yes').'<input type="checkbox" style="display:none;" id="type_'.$k.'" name="type_'.$k.'[]" value="'.$v['detail_id'].'" checked onclick="return false;" >';
							        $v['quantity'] = $quantity.'<input type="hidden" id="r_quantity_'.$k.'" name="r_quantity_'.$k.'" value="'.$quantity.'" '.$style.' readonly="true" >';
							        $v['price']    = '<input type="text" id="r_price_'.$k.'" name="r_price_'.$k.'" value="'.$price.'" '.$style.'>';
							    }else{
							        $v['checkbox'] = '<input type="checkbox" id="type_'.$k.'" name="type_'.$k.'[]" value="'.$v['detail_id'].'" checked'.$false.'>';
							        $v['quantity'] = '<input type="text" id="r_quantity_'.$k.'" name="r_quantity_'.$k.'" value="'.$quantity.'" '.$style.'>';
							        if(getUser('role_type')==C('SELLER_ROLE_TYPE') &&$module=='ReturnSaleOrder'){
                                        $v['price']    = '<input type="text" readonly="true" id="r_price_'.$k.'" name="r_price_'.$k.'" value="'.$price.'" '.$style_edit.'>';
                                    }else{
                                        $v['price']    = '<input type="text" id="r_price_'.$k.'" name="r_price_'.$k.'" value="'.$price.'" '.$style.$readonly.'>';
                                    }
                    
							    }
							}else{
								$v['checkbox'] = L('yes');
								$v['quantity'] = $quantity;
								$v['price']    = $price;
							} 
							break;
					}
				}elseif($is_cainiao_return){
					unset($list[$k]); 
				}else{
					switch($action){
						case 'view':
							unset($list[$k]); 
							break;
						case 'add':
							$v['checkbox'] = '<input type="checkbox" id="type_'.$k.'" name="type_'.$k.'[]" value="'.$v['detail_id'].'">';
							$v['quantity'] = '<input type="text" id="r_quantity_'.$k.'" name="r_quantity_'.$k.'" value="" '.$style.'>';
                            if(getUser('role_type')==C('SELLER_ROLE_TYPE') &&$module=='ReturnSaleOrder'){
                                $v['price']    = '<input type="text" readonly="true" id="r_price_'.$k.'" name="r_price_'.$k.'" value="" '.$style_edit.'>';
                            }else{
                                $v['price']    = '<input type="text" id="r_price_'.$k.'" name="r_price_'.$k.'" value="" '.$style.'>';                               
                            }
							break;
						case 'edit':
							if($seller_flag){
                                $v['checkbox'] = '<input type="checkbox" id="type_'.$k.'" name="type_'.$k.'[]" value="'.$v['detail_id'].'"'.$disabled.$false.'>';
                                $v['quantity'] = '<input type="text" id="r_quantity_'.$k.'" name="r_quantity_'.$k.'" value="" '.$style.'>';
                                if(getUser('role_type')==C('SELLER_ROLE_TYPE') &&$module=='ReturnSaleOrder'){
                                   $v['price']    = '<input type="text" readonly="true" id="r_price_'.$k.'" name="r_price_'.$k.'" value="" '.$style_edit.'>';
                                }else{
                                   $v['price']    = '<input type="text" id="r_price_'.$k.'" name="r_price_'.$k.'" value="" '.$style.$readonly.'>'; 
                                }                               
                                if(in_array($state_id,C('WAREHOUSE_ROLE_CAN_EDIT'))){
                                    unset($list[$k]); 
                                }
                            }else{
								unset($list[$k]); 
							}
							break;
					}
				}
			}
		}
		$tpl_name   = 'ReturnService';
		$this->assign ('return_service', $list);
		$this->display($tpl_name);
	}
    public function editAddress(){
        $rs = M($_GET['module'].'Addition')->field("*,b.id as addition_id,a.id as id")->join('b left join sale_order a on a.id=b.sale_order_id ')->where('sale_order_id='.(int)$_GET['id'])->find();
        $rs = _formatArray($rs);
        $this->assign ('rs', $rs);
        $this->assign('login_user',  getUser());
		$this->display();
    }

    //小窗口内状态有差异 清空明细状态  选择明细状态 清空小窗口状态
    public function setCustomsClearanceState(){
        $id     = intval($_POST['id']);
        $customs_clearance_state    = $_POST['customs_clearance_state'];
        
        if(empty($customs_clearance_state)){//状态非空时该装箱单明细一致
            $state  = trim($_POST['state']);
            $state= json_decode(htmlspecialchars_decode(stripcslashes($state)),true);
            foreach($state as $val){
                $return_state[$val[0]]  = $val[1];
            }
        }
        
        
        $rs['detail'] = M('pack_box_detail')
                ->join('pbd left join return_sale_order r on pbd.return_sale_order_id=r.id')
                ->where('pack_box_id='.$id)
                ->getField('pbd.id,pbd.return_sale_order_id,r.return_logistics_no,r.return_track_no'); 
        foreach($rs['detail'] as $detail){
            $return_sale_order_id[$detail['return_sale_order_id']]  = $detail['return_sale_order_id'];
        }
        $weight = D('PackBox')->getReturnWeight($return_sale_order_id);
        
        $customs_clearance_state_name   = C('CUSTOMS_CLEARANCE_STATE');
        
        foreach($rs['detail'] as &$value){
            $value['weight']    = $weight[$value['return_sale_order_id']];
            //如果JSON为空 小窗口用明细中的状态
            if(empty($return_state)){
                $value['customs_clearance_state']   = $customs_clearance_state;
            }else{
                $value['customs_clearance_state']   = empty($return_state[$value['return_sale_order_id']]) ? 0 : $return_state[$value['return_sale_order_id']];
            }
            $value['customs_clearance_state_name']  = $customs_clearance_state[$value['customs_clearance_state']];
        }
        
        $rs = _formatListRelation($rs);
        $this->assign ('rs', $rs);
		$this->display();
    }
        //小窗口内状态有差异 清空明细状态  选择明细状态 清空小窗口状态
    public function setAssociateWithState(){
        $id     = intval($_POST['id']);
        $associate_with_state   = $_POST['associate_with_state'];
        //与清关不同 窗口中有差异则明细显示异常
//        if(empty($associate_with_state)){//状态非空时该装箱单明细一致
            $state  = trim($_POST['state']);
            $state= json_decode(htmlspecialchars_decode(stripcslashes($state)),true);
            foreach($state as $val){
                $return_state[$val[0]]  = $val[1];
            }
//        }
        
        $rs['detail'] = M('pack_box_detail')
                ->join('pbd left join return_sale_order r on pbd.return_sale_order_id=r.id')
                ->where('pack_box_id='.$id)
                ->getField('pbd.id,pbd.return_sale_order_id,r.return_logistics_no,r.return_track_no'); 
        foreach($rs['detail'] as $detail){
            $return_sale_order_id[$detail['return_sale_order_id']]  = $detail['return_sale_order_id'];
        }
        $weight = D('PackBox')->getReturnWeight($return_sale_order_id);
        
        $associate_with_state_name  = C('ASSOCIATE_WITH_STATE');
        
        foreach($rs['detail'] as &$value){
            $value['weight']    = $weight[$value['return_sale_order_id']];
            //如果JSON为空 小窗口用明细中的状态
            if(empty($return_state)){
                $value['associate_with_state']  = $associate_with_state;
            }else{
                $value['associate_with_state']  = empty($return_state[$value['return_sale_order_id']]) ? 0 : $return_state[$value['return_sale_order_id']];
            }
            $value['associate_with_state_name'] = $customs_clearance_state[$value['associate_with_state']];
        }
        
        $rs = _formatListRelation($rs);
        $this->assign ('rs', $rs);
		$this->display();
    }
    
    public function setReviewWeight(){
        $id     = intval($_POST['id']);
        $state  = trim($_POST['state']);
        $state= json_decode(htmlspecialchars_decode(stripcslashes($state)),true);
        foreach($state as $val){
            $return_state[$val[0]]  = $val[1];
        }
        $rs['detail'] = M('pack_box_detail')
                ->join('pbd left join return_sale_order r on pbd.return_sale_order_id=r.id')
                ->where('pack_box_id='.$id)
                ->getField('pbd.id,pbd.return_sale_order_id,r.return_track_no,r.waybill_no'); 
        
        foreach($rs['detail'] as $detail){
            $return_sale_order_id[$detail['return_sale_order_id']]  = $detail['return_sale_order_id'];
        }
        
        $weight = D('PackBox')->getReturnWeight($return_sale_order_id);
        
        foreach($rs['detail'] as &$value){
            $value['weight']    = $weight[$value['return_sale_order_id']];
            $value['review_weight'] = $return_state[$value['return_sale_order_id']];
        }
        $rs = _formatListRelation($rs);
        $this->assign ('rs', $rs);
		$this->display();
    }
    public function batchUpload(){
        $this->assign('file_tocken',md5(time()));
		$this->display();
    }
    
    public function batchEdit(){
        $id_arr         = $_POST['id'];
        $this->assign('id',  implode(',', $id_arr));
		$this->display();
    }
    //退货入库列表拣货单导出           add by lxt 2015.09.22
    public function pikingExport(){
        $this->display();
    }
    
    public function setPostSection(){
        $id = intval($_POST['id']);
        $post_section   = trim($_POST['post_section']);
        $post_section   = json_decode(htmlspecialchars_decode(stripcslashes($post_section)),true);
        $post_key   = array('english','post_begin','post_end');
        foreach($post_section as &$post){
            $post   = array_combine($post_key, $post);
        }
        $rs['detail']   = $post_section;
        $this->assign('rs',  _formatListRelation($rs));
        $this->display();
    }
    
    public function setInsurePrice(){
        $rs['id']   = intval($_POST['id']);
        $info = M('SaleOrder')->find($rs['id']);
        $rs['insure_price']     = $info['insure_price'];
        $rs['w_currency_no']    = SOnly('currency', SOnly('warehouse', $info['warehouse_id'],'w_currency_id'),'currency_no');
        $this->assign('rs', _formatArray($rs));
        $this->display();
    }
}
?>