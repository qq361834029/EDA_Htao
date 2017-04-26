<?php 
/**
 * 销售
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class SaleOrderPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected 	$tableName			= 'sale_order';
	public  	$object_type		= 120;
	public		$express_api_tips	= array();


	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'sale_order_id',
										'class_name'	=> 'sale_order_detail',
									),
								 'addition' =>
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'sale_order_id',
										'class_name'	=> 'sale_order_addition',
									),
								);	
	/// 自动验证设置
	public $_validate	 =	 array(
			array("order_no",'require',"require",0),   /// 0表示存在字段就验证
			array("order_no,factory_id,package_bg",'','unique',1,'unique'),   /// 0表示存在字段就验证
			array("factory_id",'pst_integer',"require",self::EXISTS_VAILIDATE),
			array("order_date",'require',"require",1), ///1为必须验证
			array("order_date",'date',"illegal_date", self::VALUE_VAILIDATE), ///1为必须验证
			array("order_type",'pst_integer',"require",1),
			array("track_no",'track_no',"valid_track_no",2),
			array("sale_order_state",'pst_integer',"require",2),
			array("is_insure",'yes_no',"invalid_data",self::EXISTS_VAILIDATE),
			array("",'_validMain','require',1,'_validMain'),
			array("",'_validDetail','require',1,'validDetail'),
			array("",'validAddition','require',1,'callbacks'),
			array("",'validDetailRealQuantity','require',1,'callbacks'),
			array("",'validAutomatisch','',1,'callbacks'),
			//array("",'validTrackNo','',1,'callbacks'),
			array("",'validAutomatischDetail','',1,'callbacks'),
			array("",'validData','',1,'callbacks'),
			array("",'validOrderType','',1,'callbacks'),
		);
	///产品明细验证
	protected $_validDetail	 =	 array(
			array("quantity",'pst_integer','pst_integer',1),
	);
	///地址明细验证规则
	protected $_validAddition	 =	 array(
			array("consignee",'require','require',1),
			array("address",'require','require',1),
			array("post_code",'require','require',1),
			array("country_name",'require','require',1),
			array("city_name",'require','require',1),
            array("city_name",'not_number','valid_city',2),
			array("country_id",'require','require',1),
			array('email','email','valid_email',2),	//邮箱格式
	);
	protected $_validDetailRealQuantity	 =	 array(
			array("real_quantity",'pst_integer','pst_integer',1),
			array('real_quantity','quantity','real_quantity_inconsistent',1,'confirm'), // 发货数量与销售数量不一致
	);

	protected $_validDetailNormalRealQuantity =	 array(
			array("real_quantity",'z_integer','z_integer',2),
			array("real_quantity",'quantity','real_quantity_chk',2,'elt'),
	);

	protected $_validDetailVerifyRealQuantity =	 array( 
			array("real_quantity",'pst_integer','pst_integer',1),
			array('real_quantity','quantity','real_quantity_inconsistent',1,'confirm'), // 发货数量与销售数量不一致
			array("verify_quantity",'pst_integer','pst_integer',1),
			array('verify_quantity','quantity','verify_quantity_inconsistent',1,'confirm'), // 验证数量与销售数量不一致
	);

	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), /// 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), /// 更新时间					
						);		
    public function validOrderType($data){
        if($data['order_type'] == C('ALIEXPRESS')){
            $_validOrderType        =	 array(array('aliexpress_token','require','require',  self::MUST_VALIDATE));
            return $this->_validSubmit($data,$_validOrderType);
        }
    }

    ///销售单类型，销售单状态基本有效性验证
	public function validData($data){
		$state	= true;
        $sale_ordet_type    = M('orderType')->where('to_hide=1')->getField('id,order_type_name');
		$valid_fields	= array(
//			'order_type'=>'SALE_ORDER_TYPE',
			'is_registered'=>'IS_ENABLE',
			'sale_order_state'=>'SALE_ORDER_STATE',
			);
		foreach ($valid_fields as $field => $C_key) {
			if (isset($data[$field]) && !array_key_exists($data[$field],C($C_key))) {
				$this->error[]	=  array('name'=>$field,'value'=>L('invalid_data'));
				$state	= false;
			}				
		}
//			'order_type'=>'SALE_ORDER_TYPE',销售渠道改成自定义,修改验证数据有效性20160128
        if (isset($data['order_type']) && !array_key_exists($data['order_type'],$sale_ordet_type)) {
            $this->error[]	=  array('name'=>'order_type','value'=>L('invalid_data'));
            $state	= false;
        }	
		if(in_array($data['express_id'],C('VIRTUAL_ORDERTYPE_EXPRESS')) && $data['order_type'] !=  C('ORDER_TYPE_VIRTUAL_TRAY')){
			$this->error[]	=  array('name'=>'order_type','value'=> L('EXPRESS_BIND_ORDER_TYPE').'：'.SOnly('order_type', C('ORDER_TYPE_VIRTUAL_TRAY'),'order_type_name'));
			$state	= false;
		}
		if(in_array($data['express_id'],C('TRAY_ORDERTYPE_EXPRESS')) && $data['order_type'] !=  C('ORDER_TYPE_TRAY_EXPRESS')){
			$this->error[]	=  array('name'=>'order_type','value'=>L('EXPRESS_BIND_ORDER_TYPE').'：'.SOnly('order_type', C('ORDER_TYPE_TRAY_EXPRESS'),'order_type_name'));
			$state	= false;
		}			
		return $state; 
	}	
	
	///地址明细验证
	public function validAddition($data){
		$valid		= '_validAddition';
//		if ($data['from_type']!='automatisch') {
//			if (M('express')->where('id=' . $data['express_id'])->getField('company_id') == C('EXPRESS_FR-GLS_ID')) {
//				$this->_validAddition[] = array("address", 'address_length', 'address_length', 0);
//				$this->_validAddition[] = array("address2", 'address_length', 'address_length', 0);
//			}
//		}
		return $this->_moduleValidationDetail($this,$data,'addition',$valid); 
	}

	///出库追踪单号填写
	public function validTrackNo($data){
		if ($data['from_type']=='out_stock') {
			$vasd = array(array("track_no",'require',"require",1));
		}
		return $this->_validSubmit($data,$vasd);
	}

	public function validAutomatisch($data){
		if ($data['from_type']!='automatisch') {
			$vasd = array(array("is_registered",'pst_integer',"require",1),
						array('is_registered',array(1,2),'is_registered_error',1,'between'),
						array("warehouse_id",'pst_integer',"require",1));
		}
		if (!in_array($data['from_type'], array('import', 'apiimport'))) {
			$vasd[] = array("client_id",'pst_integer',"require",0);
		}
		return $this->_validSubmit($data,$vasd);
	}

	public function validAutomatischDetail($data){
		if ($data['from_type']!='automatisch') {
			$vasd = array(array("product_id",'pst_integer','require',1));
		}
		return $this->_validSubmitDetail($data,$vasd);
	}

	///出库发货数量验证
	public function validDetailRealQuantity($data){
		if ($data['from_type']=='out_stock') {
			$_moduleValidate = '_validDetailNormalRealQuantity';
			if($data['sale_order_state']==C('SHIPPED')&&$data['submit_type']!='3'){
				$_moduleValidate = '_validDetailRealQuantity';
			}
			if($data['verifyType']=='1'&&$data['sale_order_state']==C('SHIPPED')&&$data['submit_type']!='3'){
				$_moduleValidate = '_validDetailVerifyRealQuantity';
			}
			return $this->_moduleValidationDetail($this,$data,'detail',$_moduleValidate);  
		} 
	}
	
	///初始化post信息
	public function setPost($data,$judge) {  
        if (empty($data))	$data =	$_POST;
		if (!empty($data['order_date'])) {
			$data['order_date']	= $_POST['order_date'] = formatDate($data['order_date']);
		}
		///如果是自动抓取的则不验证快递公司及仓库								
		if ($data['from_type']!='automatisch') {								
			if($data['detail']){
				$product_list   = $this->getProductInfo($data['detail']);
			}
			if($product_list){
				$data           = $this->getTotalWeightCube($product_list,$data);
			}
			//派送方式选择	
			if(!empty($judge)){									
			    $express_id		    = $data['express_id'];
			    $country_id		    = $data['country_id'];
			    $old_post_code      = trim($data['post_code']); 								
			}else{								
			    $addition		    = $data['addition'][1];
			    $express_id		    = $data['express_id'];
			    $country_id		    = $addition['country_id'];
			    $old_post_code	    = trim($addition['post_code']); 
			}
            $post_arr   = array();
            preg_match_all('/^([a-z]*)(\d*)/i', $old_post_code, $post_arr);								
            $post_english   = $post_arr[1][0];								
            $post_code      = $post_arr[2][0];
			//派送公司为it-gls时省份必须为两位字母
			if ($express_id > 0 && !in_array($express_id, array(C('SHIPPING_IT-BRT-OVERSEA_ID'))) && in_array(D('Shipping')->where('id='.$express_id)->getField('company_id'),array(C('EXPRESS_IT-GLS_ID'),C('EXPRESS_BRT_ID')))) {								
			    $this->addProperty('_validAddition', array('company_name','/^[A-Za-z]{2}$/','valid_province_name',self::VALUE_VAILIDATE));//所在省份，必须为两个字母
			}
			//默认派送为0
			$data['express_id'] = $data['express_detail_id'] = 0;
			//仓库启用，派送方式启用，派送明细派送
			if(intval($data['warehouse_id'])>0&&intval($express_id)>0&&intval($country_id)>0){								
				//设置派送方式明细
				$this->setExpressDetailId($data, $judge, $country_id, $express_id, $post_english, $post_code);
                if ($data['express_detail_id'] == 0) {								
                    if(!empty($judge)){
                        return  1;
                    }								
                    $error['name']	= 'express_id';
                    $error['value'] = L('select_express_way_error');
                    $this->error[]	= $error;
                }elseif(!empty($judge)){								
                    $re_express['express_detail_id']=$data['express_detail_id'];
                    $re_express['express_id']		=$data['express_id'];
                    return  $re_express;		
                }								
                //送货地址是：Paketestation 时，只允许客人选用DHL的派送方式
                _mergeAddress($data['addition'][1], ',', array('address', 'address2', 'company_name'));
                if (intval($data['express_detail_id']) > 0 && checkStrIn(C('EXPRESS_WAY_DHL'), $data['addition'][1]['merge_address'])) {
                    $dhl_count = M('express')->where('id=' . $express_id . ' and company_id in (' . (int) C('EXPRESS_DHL_ID') . ',' . (int) C('EXPRESS_BRT_ID') . ')')->count();
                    if (intval($dhl_count) <= 0) {
                        $error['name'] = 'express_id';
                        $error['value'] = L('select_dhl_express_way_error');
                        $this->error[] = $error;
                    }
                    if (preg_match('/^\d+$/', trim($data['addition'][1]['address2'])) == 0) {//必须输入PostNumer，dhl api需要此信息
                        $error['name']	= 'addition[1][address2]';
                        $error['value'] = L('invalid_post_numer');
                        $this->error[]	= $error;
					}
                }
            }
            if($express_id==0){
				if(intval($data['warehouse_id'])<=0){
					$error['name']	= 'warehouse_id';
					$error['value']	= L('require');
					$this->error[]	= $error;	
				}
				$error['name']	= 'express_id';
				$error['value']	= L('require');
				$this->error[]	= $error;				
			}
			//暂存处理 订单状态 拣货完成保持
			if($data['submit_type']=='3'){
				$data['sale_order_state'] = M('SaleOrder')->where('id=' . $data['id'])->getField('sale_order_state');
			}
			//订单已发货状态处理
			$this->setSaleOrderDeliveryStatus($data);
		}
		$return_data = $data;
		$rs			 = _formatListRelation($data);
		//判断简单订单 复合订单
		$return_data['out_stock_type'] = intval($rs['detail_total']['quantity'])==1?1:(intval($rs['detail_total']['total_product'])==1?2:3); 																		
		return $return_data;
	}
	
    public function setAddressPost($data){	
		if (empty($data)){
            $data = $_POST;
        }
        //如果是自动抓取的则不验证快递公司及仓库
        $addition = $data['addition'][1];
        $express_id = $data['express_id'];
        $express_detail_id  = $data['express_detail_id'];
        $country_id = $addition['country_id'];
        $post_code = trim($addition['post_code']);
        //派送公司为it-gls时省份必须为两位字母
        if ($express_id > 0 && !in_array($express_id, array(C('SHIPPING_IT-BRT-OVERSEA_ID'))) && in_array(D('Shipping')->where('id=' . $express_id)->getField('company_id'), array(C('EXPRESS_IT-GLS_ID'), C('EXPRESS_BRT_ID')))) {
            $this->addProperty('_validAddition', array('company_name', '/^[A-Za-z]{2}$/', 'valid_province_name', self::VALUE_VAILIDATE)); //所在省份，必须为两个字母
        }
        //邮编限制
        $express_list       = M('express_detail')->where('express_id='.$express_id)->select();
        $is_sent    = TRUE;
        foreach ($express_list as $v) {
            if ($v['post_is_express'] == 2) {
                if ((!empty($express_detail['post_begin']) || $express_detail['post_begin'] == 0) && !empty($express_detail['post_end'])) {
                    if ($express_detail['post_begin'] <= $post_code && $post_code <= $express_detail['post_end']) {
                        $is_sent = FALSE;
                        break;
                    }
                } elseif (!empty($express_detail['post_begin']) && $express_detail['post_begin'] == $post_code) {
                    $is_sent = FALSE;
                    break;
                }
            }
        }
        $check_post_code    = FALSE;
        if($is_sent){
        $express_detail     = M('expressDetail')->where('id='.$express_detail_id)->find();
        if($express_detail['post_is_express']==1){
            if ((!empty($express_detail['post_begin'])|| $express_detail['post_begin']==0) && !empty($express_detail['post_end'])) {
                if ($express_detail['post_begin'] > $post_code || $post_code > $express_detail['post_end']) {
                    $check_post_code    = TRUE;
                }
            } elseif (!empty($express_detail['post_begin']) && $express_detail['post_begin'] != $post_code) {
                $check_post_code    = TRUE;
            }
        } else {
            if ((!empty($express_detail['post_begin'])|| $express_detail['post_begin']==0) && !empty($express_detail['post_end'])) {
                if ($express_detail['post_begin'] <= $post_code && $post_code <= $express_detail['post_end']) {
                    $check_post_code    = TRUE;
                }
            } elseif (!empty($express_detail['post_begin']) && $express_detail['post_begin'] == $post_code) {
                $check_post_code    = TRUE;
            }
        }
        }else{
            $check_post_code    = TRUE;
        }
        if($check_post_code){
                $error['name'] = 'addition[1][post_code]';
                $error['value'] = L('error_post_code');
                $this->error[] = $error;
        }
        //送货地址是：Paketestation 时，只允许客人选用DHL的派送方式
        _mergeAddress($data['addition'][1], ',', array('address', 'address2', 'company_name'));
        if (intval($data['express_detail_id']) > 0) {
            $error_addition_name    = FALSE;
            if (checkStrIn(C('EXPRESS_WAY_DHL'), $data['addition'][1]['address'])) {
                $error_addition_name = 'addition[1][address]';
            } else if (checkStrIn(C('EXPRESS_WAY_DHL'), $data['addition'][1]['address2'])) {
                $error_addition_name = 'addition[1][address2]';
            }
            if($error_addition_name) {
                $dhl_count = M('express')->where('id=' . $express_id . ' and company_id in (' . (int) C('EXPRESS_DHL_ID') . ',' . (int) C('EXPRESS_BRT_ID') . ')')->count();
                if (intval($dhl_count) <= 0) {
                    $error['name'] = $error_addition_name;
                    $error['value'] = L('select_dhl_express_way_error');
                    $this->error[] = $error;
                }
            }
        }
    }

	/**
	 * 导入EXCEL关联insert
	 *
	 * @return array
	 */
	public function importInsert(){ 
		$info	= $this->data;
		$this->_brf();
		unset($this->data['referer'],$this->data['error_message']);
		if($this->_beforeModel($info) == false){
			$this->error_type	= 1;
			return false;
		}
		
        static $order_no      = array();
        if(in_array($this->data['order_no'], $order_no)){
            $error[]    = L('order_no').':'.L('unique');
            $this->error_type	= 1;
            $this->addError($error);
            return false;
        }
        $container_no[$this->data['order_no']]  = $this->data['order_no'];
        $where['factory_id']    = $this->data['factory_id'];
        $where['order_no']      = $this->data['order_no'];
        $order_no_exist         = $this->where($where)->find();
        if(!empty($order_no_exist)){
            $error[]    = L('order_no').':'.L('unique'); 
            $this->error_type	= 1;
            $this->addError($error);
            return false;
        }
        //array("is_insure",'require',"require",self::EXISTS_VAILIDATE),
        //验证is_insure必填
        if(!in_array($this->data['is_insure'], array('1','2'))){
            $error[]    = L('insure').':'.L('require'); 
            $this->error_type	= 1;
            $this->addError($error);
            return false;
        }
		$id = $this->relation(true)->add();
		if (false === $id) {
			$this->error_type	=	2;
			return false; 
		}	 
		$this->id	=	$id;  
		empty($info) ? $_POST['id'] = $id : $info['id'] = $id; 
		$this->_afterModel($info); 
		//订单导入新增状态日志
        $info['state_module_name']  = 'SaleOrder';
        $info['state_log_comments'] = L('sale_order_import');
        $info['sale_order_state']   = C('SALE_ORDER_STATE_PENDING');
		$this->execTags($info);
		return $this->id;
	}
	

	/**
	 * api修改销售单关联update
	 * @author jph 20141030
	 * @return array
	 */
	public function importUpdate(){ 
        $sale_order_state   = M('sale_order')->where('id='.$this->data['id'])->getField('sale_order_state');
        if($sale_order_state != C('SALE_ORDER_STATE_PENDING')){
            unset($this->data['is_insure']);
        }else{
            //验证is_insure
            if($this->data['is_insure']==0){
                unset($this->data['is_insure']);
            }else{
                if(!in_array($this->data['is_insure'], array('1','2'))){
                    $error[]    = L('insure').':'.L('require'); 
                    $this->error_type	= 1;
                    $this->addError($error);
                    return false;
                }
            }
        }
		$info	= $this->data;
		$this->id	=	$info['id'];
		$this->_brf();
		unset($this->data['referer'],$this->data['error_message']);
		if($this->_beforeModel($info) == false){
			$this->error_type	= 1;
			return false;
		}
		$r = $this->relation(true)->save();
		if (false === $r) {
			$this->error_type	=	2;
			return false;
		}
		if($this->_afterModel($info) == false){
			$this->error_type	= 1;
			return false;
		}		
		$this->execTags($info);
	}	

	/// 查看
	public function view(){   
		return $this->getInfo($this->id);
	}
	/// 编辑
	public function edit(){ 
		return $this->getInfo($this->id);
	} 
	
	/**
	 * 获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public function getInfo($id,$type,$mark) {
		$where		= 'id=' . (int)$id . getBelongsWhere();
		$rs			= $this->where($where)->find();
		$rs['brt_account_no'] =M('company')->where('id='.$rs['factory_id'])->getField('brt_account_no');		
        $express_array        = M('express')->where('id='.$rs['express_id'])->field('company_id,calculation,enable_print')->select();
        foreach($express_array as $value){
            $rs['company_id']              =$value['company_id'];
            $rs['express_calculation']     =$value['calculation'];
            $rs['express_enable_print']    =$value['enable_print'];           
        }
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			if($type=='out_stock'){
				return array();
			}else{
				halt(L('data_right_error'));
			}
		}			
		
		//查找关联退货单     add by lxt 2015.06.11
		$return_sale_order  =   M('ReturnSaleOrder')->field("id,return_sale_order_no")->where("is_related_sale_order=1 and sale_order_id=".(int)$id.getBelongsWhere())->find();
		$rs['return_id']    =   $return_sale_order['id'];
		$rs['return_no']    =   $return_sale_order['return_sale_order_no'];
		
		$detail = M('sale_order_detail');
		$rs['detail'] = $detail->field('*,'.$this->getQuantityDetail('',false,true))->where('sale_order_id='.$id)->select(); 
		$client				= M('Client')->field('comp_name as client_name,comp_no as client_no,email as comp_email')->find($rs['client_id']);
		if($client){
			$rs				= array_merge($rs,$client);
		}	
		$addition 		  = M('sale_order_addition');
		$addition_data	  = $addition->field('id,address,address2,post_code,country_name,city_name,country_id,fax,email,mobile,tax_no,consignee,company_name,transmit_name')->where('sale_order_id='.$id)->find(); 
		if(isset($addition_data)&&$addition_data){
			$rs['addition_id'] = $addition_data['id'];
			unset($addition_data['id']);
			$rs			  = array_merge($rs,$addition_data);
		}     
		if($rs){
			//查看时编辑按钮的处理	
			$rs['is_update']	= saleOrderCheckEdit($rs['sale_order_state'],$id);
			!isset($rs['ship_id'])  && $rs['ship_id']	= $rs['express_id'];
			if($rs['detail']){
				$product_list = $this->getProductInfo($rs['detail']);
				foreach($rs['detail'] as $key=>$val){
					$rs['detail'][$key]['sale_order_state'] = $rs['sale_order_state'];
					if(isset($product_list[$val['product_id']])){
						unset($product_list[$val['product_id']]['id']);//删掉产品id以防覆盖订单明细id
						$rs['detail'][$key]	= array_merge($rs['detail'][$key], $product_list[$val['product_id']]);
					}
                    $rs['detail'][$key]['package_bg']   = $rs['package_bg'];
				}
			}
		   //added by lml 20151118
		    $state = array(C('SALEORDER_OBSOLETE'),C('SHIPPED'),C('SALE_ORDER_POST_OFFICE_RETURNED'), C('SALE_ORDER_STATE_OUT_STOCK'), C('ERROR_ADDRESS'),C('ADDRESS_ERROR_RETURNED'));								
		    if (in_array($rs['sale_order_state'],$state)){			 //状态为已出库
//                if($rs['sale_order_state'] == C('ERROR_ADDRESS')){   //判断状态为地址错误时，再进一步判断是否已出库									
                    $rest['object_id']=$rs['id'];
                    $rest['state_id']=C('SHIPPED');
                    $rest['object_type']=(int)array_search('SaleOrder',C('STATE_OBJECT_TYPE'));								
                    $result =M('state_log')->where($rest)->count();								
                    if($result){								
                        $mytype=1;//已出库			       
                    }else{
                        $mytype=0; //未出库
                    }								
//                }else{
//                    $mytype=1;
//                }			
		    }else{
                $mytype=0;//未出库
		    }	
            $rs['is_out']   = $mytype;
            //added by yyh 20150930
           // if($rs['sale_order_state'] == C('SHIPPED')){
	    if($mytype==1){//已生成快递费用款项   
                $sys_pay_class		= C('SYS_PAY_CLASS');
		//$rs['detail']['s_weight']=$rs['weight'];
                $rs['expected_delivery_costs']  = M('sale_order')->join('a left join client_paid_detail deliveryFee on deliveryFee.object_id=a.id and deliveryFee.object_type='.$this->object_type.' and deliveryFee.pay_class_id='.intval($sys_pay_class['deliveryFee']) )
                        ->where('a.id='.$id)->getField('deliveryFee.should_paid');
                $rs['expected_delivery_costs']	   = moneyFormat($rs['expected_delivery_costs'],0,2);
//        }elseif((ACTION_NAME=='view'&&$type!='out_stock')||ACTION_NAME=='outStock'){//查看明细计算预计快递费用
//				if(intval($rs['express_id'])>0&&intval($rs['express_detail_id'])>0){
//					$sql = 'select b.price,b.weight_begin,b.weight_end,b.step_price,b.registration_fee, a.shipping_type	,a.company_id 	
//							from express a 
//							left join express_detail b
//							on a.id=b.express_id
//							left join warehouse c
//							on a.warehouse_id=c.id
//							where b.is_express=1 and c.is_use=1 and a.status=1
//							and b.id='.$rs['express_detail_id'].' and b.express_id='.$rs['express_id'];
//					$list		  = $this->db->query($sql);
//					$express_data = $list[0];
//					$ori_weight   = choose_weight($data['weight'],$data['volume_weight'],$express_detail);;
//					if(is_array($express_data)&&$express_data){
//						$rs['expected_delivery_costs'] = $express_data['price'] + ($rs['is_registered']==1 ? $express_data['registration_fee'] : 0);//订单挂号则加上挂号费用
//						//超过每公斤所需要费用 added by jp 20141202
//						$rs['expected_delivery_costs'] += step_price_calculate(false, $ori_weight, $express_data);
//						
//						if(in_array($express_data['shipping_type'], C('SHIPPING_TYPE_EXPRESS'))){//派送类型为快递才有折扣
//							//取卖家折扣				
//							$express_discount	= M('express_discount')->where('factory_id='.$rs['factory_id'].' and warehouse_id='.$rs['warehouse_id'])->getField('express_discount');
//							if($express_discount){
//								$rs['expected_delivery_costs'] = $rs['expected_delivery_costs']*$express_discount;
//							}
//						}
//						$rs['expected_delivery_costs']	   = moneyFormat($rs['expected_delivery_costs'],0,2);
//								
//                        $rs['shipping_type']               = $express_data['shipping_type'];
//					}
//				}
			}																							
		}								
		//added by yyh 20140917
		$file_url = D('Gallery')->getAry($id,C('DOWNLOAD_FILE_TYPE')); 
		$path	= getUploadPath(C('DOWNLOAD_FILE_TYPE'));
        foreach($file_url as &$val){
            $val['file_url']      = $path . $val['file_url'];
        }
        $rs['gallery']  = $file_url;
		if (in_array(MODULE_NAME, C('MERGE_ADDRESS_MODULE'))) {//added by jp 20140115
			_mergeAddress($rs);
		}
		$rs	  = _formatListRelation($rs);
		$data = $this->getTotalWeightCube($product_list,$rs);

		if($mytype==1){
		    $data['detail_total']['s_weight']=$rs['dml_weight'];
		}		
		if($mytype==0){										
		    $judge=1;
		    $flag=$this->setPost($data,$judge);	
		    if(is_array($flag)){													
//				//计算快递费用	
//				$express_detail=M('express_detail')->join('ed left join express e on ed.express_id=e.id')->where('ed.id='.$flag['express_detail_id'])->field('e.company_id,e.shipping_type,e.calculation,ed.*')->find();								
//				$weight=choose_weight($data['weight'],$data['volume_weight'],$express_detail);//获取重量	               
//				$delivery_fee	= $express_detail['price'] + ($rs['is_registered']==1 ? $express_detail['registration_fee'] : 0);//订单挂号则加上挂号费用
//				//超过每公斤所需要费用  
//				$delivery_fee		+= step_price_calculate(false, $weight, $express_detail);								
//				//派送类型为快递才有折扣
//				if(in_array($express_detail['shipping_type'], C('SHIPPING_TYPE_EXPRESS')) && isset($express_discount)){
//                    $express_discount_data['factory_id']=$rs['factory_id'];
//                    $express_discount_data['warehouse_id']=$rs['warehouse_id'];								
//                    $express_discount=M('express_discount')->where($express_discount_data)->getField('express_discount');
//					$delivery_fee *= $express_discount;
//				}								
//				$data['expected_delivery_costs']	= moneyFormat($delivery_fee,0, C('money_length'));	
                $data['express_detail_id']    = $flag['express_detail_id'];
		    }
            if(intval($data['express_id'])>0&&intval($data['express_detail_id'])>0){
                $sql = 'select b.price,b.weight_begin,b.weight_end,b.step_price,b.registration_fee, a.shipping_type	,a.company_id,a.calculation	 	
                        from express a 
                        left join express_detail b
                        on a.id=b.express_id
                        left join warehouse c
                        on a.warehouse_id=c.id
                        where b.is_express=1 and c.is_use=1 and a.status=1
                        and b.id='.$data['express_detail_id'].' and b.express_id='.$data['express_id'];
                $list		  = $this->db->query($sql);
                $express_data = $list[0];
                $data['weight']=$data['detail_total']['weight'];  //获取最新重量
                $order_weight=choose_weight($data['weight'],$data['volume_weight'],$express_data); 
                if(is_array($express_data)&&$express_data){
                    $data['expected_delivery_costs'] = $express_data['price'] + ($data['is_registered']==1 ? $express_data['registration_fee'] : 0);//订单挂号则加上挂号费用
                    //超过每公斤所需要费用 added by jp 20141202                   
                    $data['expected_delivery_costs'] += step_price_calculate(false,$order_weight,$express_data);   
                    if(in_array($express_data['shipping_type'], C('SHIPPING_TYPE_EXPRESS'))){//派送类型为快递才有折扣
                        //取卖家折扣				
                        $express_discount	= M('express_discount')->where('factory_id='.$data['factory_id'].' and warehouse_id='.$data['warehouse_id'])->getField('express_discount');
                        if($express_discount){
                            $data['expected_delivery_costs'] = $data['expected_delivery_costs']*$express_discount;
                        }
                    }
                    $data['expected_delivery_costs']	   = moneyFormat($data['expected_delivery_costs'],0,2);
                    $data['shipping_type']               = $express_data['shipping_type'];
                }
			}
		}
		if($flag==1){			    											    
		    $data['expected_delivery_costs']=moneyFormat(0,0,C('money_length'));
		}				
		if($mark>0){								
		    return $data['expected_delivery_costs'];								
		}
        $data['w_currency_no']  = SOnly('currency', $data['w_currency_id'],'currency_no');
        foreach($data['detail'] as &$detail_value){
            $detail_value['ship_name']    = $rs['ship_name'];
        }
		return $data;	
	}
			    
	public function getOutStockList($sale_order_id=''){
		$map['custom_barcode'] = $_REQUEST['query']['custom_barcode'];
		$product_id = M('product')->where($map)->getField('id');
		$saleOrderCache = S('pickImport:saleOrder:'.$_REQUEST['query']['warehouse_id'].'_'.$_REQUEST['query']['pick_no']);
		//$where	= 'a.warehouse_id>0 and a.express_id>0 and a.express_detail_id>0 and a.sale_order_state in ('.C('SALE_ORDER_OUT_STOCK').')';
		//订单状态为"拣货完成,拣货中,已删除"中查询 排序：数量->销售日期->id
		if(intval($sale_order_id)>0){
			$where	.= ' and a.id='.$sale_order_id;
		}else{
			$id = !empty($saleOrderCache[$product_id][0]) ? $saleOrderCache[$product_id][0] : 0;
			$where	= 'a.id='.$id;
			//$where	.= ' and b.quantity!=b.real_quantity and ' . getWhere($_POST);
			//过滤正在出库的订单 added by jp 20160706
//			$queue	= S('queue_out_stock_sale_order');
//			if ($queue) {
//				//清除超时记录
//				$now		= time();
//				$update		= false;
//				$user_id	= getUser('id');
//				foreach ($queue as $sale_id => $val) {
//					if ($user_id == $val['user_id'] || $now - $val['time'] > 60) {
//						$update	= true;
//						unset($queue[$sale_id]);
//					}
//				}
//				//过滤正在出库的订单
//				if ($queue) {
//					$where	.= ' and a.id not in (' . implode(',', array_keys($queue)) . ')';
//				}
//				//更新队列
//				if ($update) {
//					S('queue_out_stock_sale_order', $queue);
//				}
//			}
		}
	
		
		$dhl_exists	= 'EXISTS(select 1 from dhl_list where object_id=a.id and ' . express_api_get_unfinished_request_where(true) . ')';
		$correos_exists	= 'EXISTS(select 1 from correos_list where object_id=a.id and ' . express_api_get_unfinished_request_where(true) . ')';
		$sql      = 'select a.id,a.out_stock_type,sum(quantity) as quantity,a.order_date
				     from sale_order a
				     inner join sale_order_detail b ON a.id=b.sale_order_id
                     left join express e on a.express_id=e.id
                     left join product p on b.product_id=p.id
				     where %where%
				     group by a.id 
					 having sum(quantity)>0
				     order by a.out_stock_type,sum(quantity),a.order_date,a.id
					 limit 1';
		$rs		  = $this->query(str_replace('%where%', $where . ' and NOT ' . $dhl_exists . ' and NOT ' . $correos_exists, $sql));
		$data     = array();
		if ($rs) {
//			$product    = array();
//			foreach($rs as $val){
//				$product[$val['out_stock_type']][]  = $val['id'];
//			}
//			$sale_id_arr    = array_shift($product);
//			shuffle($sale_id_arr);
//			$rs[0]['id']    = $sale_id_arr[0];
			if(is_array($rs)&&$rs){
				$id   = $rs[0]['id'];
				if(intval($id)>0){
//					//进入出库中订单队列 added by jp 20160706
//					$queue					= S('queue_out_stock_sale_order');
//					$queue[$id]				= array(
//						'user_id'	=> getUser('id'),
//						'time'		=> time(),
//					);
//					S('queue_out_stock_sale_order', $queue);
					
					$data				    = $this->getInfo($id,'out_stock');
                    if(!empty($data)){
                        if($data['express_calculation']==1&&$data['weight']<$data['volume_weight']){
                            $data['detail_total']['s_unit_weight']  = $data['detail_total']['s_unit_volume_weight'];
                        }
                    }
					//判断简单订单 复合订单
					$data['out_stock_type'] = intval($data['detail_total']['quantity'])==1?1:(intval($data['detail_total']['total_product'])==1?2:3);
					$file_url = D('Gallery')->getAry($id,C('DOWNLOAD_FILE_TYPE'));
					$path	= getUploadPath(C('DOWNLOAD_FILE_TYPE'));
					foreach($file_url as &$val){
						$val['file_url']      = $path . $val['file_url'];
					}
					$data['gallery']  = $file_url;
				}
			}
		} else {
			$dhl	= $this->query(str_replace('%where%', $where . ' and ' . $dhl_exists, $sql));
			if ($dhl) {
				$this->express_api_tips[]	= 'Dhl';
			}

			$correos	= $this->query(str_replace('%where%', $where . ' and ' . $correos_exists, $sql));
			if ($correos) {
				$this->express_api_tips[]	= 'Correos';
			}
		}
		return $data;
	}

	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){  
		return $this->getSaleListSql(); 
	}
	
	/**
	 * 组合销售单列表的SQL语句
	 *
	 * @param string $where
	 * @return array
	 */
	public function getSaleListSql($whereArray=null){
		$funds_class		= array(
									'deliveryFee', //派送费用-应收款 (基本价格【+挂号费】)【*卖家派送折扣】
									'processFee', //处理费用-应收款 处理费用【+(产品数-1)*增加数量费用】
									'packageFee', //包装费用-应收款
								);
		$sys_pay_class		= C('SYS_PAY_CLASS');
		$funds_left_join	= '';
		$funds_fields		= '';
		foreach ($funds_class as $class) {
			$funds_left_join	.= ' left join client_paid_detail ' . $class . ' on ' . $class . '.object_id=a.id and ' . $class . '.object_type=' . $this->object_type . ' and ' . $class . '.pay_class_id=' . intval($sys_pay_class[$class]) . ' ';
			$field_name			 = strtolower(preg_replace('/([A-Z])/', '_\1', $class));
			$funds_fields		.= ', ' . $class . '.should_paid as ' . $field_name . ', ' . $class . '.paid_id as ' . $field_name . '_paid_id';
		}
		$exists_sale_order_detail	= 'select 1 from sale_order_detail left join product on product.id=sale_order_detail.product_id where sale_order_id=sale_order.id and '.getWhere($_POST['sale_order_detail']);
		$exists_sale_order_addition	= 'select 1 from sale_order_addition where sale_order_addition.sale_order_id=sale_order.id and '.getWhere($_POST['sale_order_addition']);
		$exists_client				= 'select 1 from client where client.id=sale_order.client_id and '.getWhere($_POST['client']);
		$exists_return_sale_order	= 'select 1 from return_sale_order where is_related_sale_order = 1 and return_sale_order.sale_order_id=sale_order.id and '.getWhere($_POST['return_sale_order']);
		$exists_sale_order_consigner= 'select 1 from state_log where object_type='.array_search('SaleOrder',C('STATE_OBJECT_TYPE')).' and state_id='.C('SHIPPED').' and state_log.object_id=sale_order.id and '.getWhere($_POST['state_log']);
		$count 	= $this->exists($exists_sale_order_detail, $_POST['sale_order_detail'])
						->exists($exists_sale_order_addition, $_POST['sale_order_addition'])
						->exists($exists_client,$_POST['client'])
						->exists($exists_return_sale_order, $_POST['return_sale_order'])
						->exists($exists_sale_order_consigner, $_POST['state_log'])
						->where(getWhere($_POST['sale_order']))
						->count();
		$this->setPage($count);  
        if($_POST['sale_order']['query']['sale_order_state']==C('SHIPPED')){
            $info['order'] 			= 'send_date desc';
        } else {
            $info['order'] 			= 'sale_order_no desc';
        }
		$ids	= $this->field('id')
						->exists($exists_sale_order_detail, $_POST['sale_order_detail'])
						->exists($exists_sale_order_addition, $_POST['sale_order_addition'])
						->exists($exists_client, $_POST['client'])
						->exists($exists_return_sale_order, $_POST['return_sale_order'])
						->exists($exists_sale_order_consigner, $_POST['state_log'])
						->where(getWhere($_POST['sale_order']))
						->order($info['order'])->page()->selectIds(); 
		$info['table'] 			= 'sale_order a 
								   INNER JOIN sale_order_detail b   ON a.id = b.sale_order_id
								   LEFT JOIN sale_order_addition c ON a.id = c.sale_order_id
								   left join client d on a.client_id=d.id
								   left join express e on a.express_id=e.id
								   left join company ec on e.company_id=ec.id
                                   left join package p on p.id=a.package_id
								   ' . $funds_left_join;
		 
		$info['where'] 			= 'a.id in '.$ids;
		$info['group'] 			= 'a.id';
        $info['order'] 			= 'a.'.$info['order'];
		$info['field'] 			= 'a.package_bg,a.is_insure,a.insure_price,a.other_type_user_id,a.out_stock_type,a.express_id,a.express_id as ship_id,a.express_detail_id,a.is_registered,if(isnull(p.weight),a.weight,a.weight+p.weight) as weight,if(isnull(p.weight),a.volume_weight,a.volume_weight+p.weight) as volume_weight,a.factory_id,a.id,a.sale_order_no,a.order_no,a.package_id,a.client_id,d.comp_name as client_name,d.comp_no as client_no,d.email as comp_email,a.order_date,date(a.send_date) as go_date,a.sale_order_state,a.order_type,a.comments,a.audit_state,a.auditor,a.audit_date,a.create_time,a.update_time,a.add_user,a.edit_user,a.lock_version,a.track_no,a.track_no_update_tips,a.transaction_id,a.is_print,
		'.$this->getStockStandard('b.').' 
		,b.id AS detail_id,b.product_id,a.warehouse_id,c.consignee,c.address,c.address2,c.post_code,c.city_name,c.country_id,c.country_name,
		group_concat(distinct b.product_id) as p_ids,ec.web_url,e.company_id as courier_id, e.shipping_type,e.calculation
		' . $funds_fields;
		return $sql	= 'select '.$info['field'].' from '.$info['table'].' where '.$info['where'].' group by '.$info['group'] .' order by '.$info['order']; 
	}
	
	/**
	 * 后续流程信息
	 *
	 * @return array
	 */
	public function quicklyShowSaleType(){   
		return $this->quicklyShowSaleTypeInfo($this->id);
	}

	/**
	 * 返回销售单修改状态信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function quicklyShowSaleTypeInfo($id){ 
		$sql  = 'select \'SaleOrder\' as object_type,a.object_id,a.state_id,a.user_id,a.create_time as paid_date,a.comments as log_comments,b.sale_order_no as flow_no
				 from state_log a 
				 left join sale_order b
				 on a.object_id = b.id
				 where object_id='.$id.' and object_type=2
				 order by a.id desc'; 
		$list =	_addFlowLink(_formatList(M()->query($sql)));   
		return $list; 
	}

	public function getProductInfo($data){ 
		$product_id = array();
		foreach($data as $val){
			if(intval($val['product_id'])>0){
				$product_id[$val['product_id']] = $val['product_id'];
			}
		}
		$product_list = array();
		if($product_id){
			$sql  = 'select id,
					 if(check_status=1,check_weight,weight) as weight,
					 if(check_status=1,check_high,cube_high) as cube_high,
					 if(check_status=1,check_wide,cube_wide) as cube_wide,
					 if(check_status=1,check_long,cube_long) as cube_long,
					 product_no,product_name,custom_barcode,
					 if(check_status=1,check_long,cube_long)*if(check_status=1,check_wide,cube_wide)*if(check_status=1,check_high,cube_high) as cube,
                     check_status
					 from product
					 where id in('.implode(',',$product_id).')';               
			$list = _formatList($this->db->query($sql), null, 1, 'id');           
			$product_list = $list['list'];            
			_formatWeightCubeList($product_list);
		}  
		return $product_list;
	}
	
	public function getTotalWeightCube($product_list,$data){ 
		$cube_size = $A = $B = $C =  array();
		$shortest  = 0;
		foreach($data['detail'] as &$val){
			if(intval($val['quantity'])>0&&array_key_exists($val['product_id'],$product_list)){
				//重量相加
				$rs['weight']  += $product_list[$val['product_id']]['weight']*$val['quantity'];

				$cube_long	    = $product_list[$val['product_id']]['cube_long'];
				$cube_wide		= $product_list[$val['product_id']]['cube_wide'];
				$cube_high		= $product_list[$val['product_id']]['cube_high'];
				$tmp			= array();
				array_push($tmp,$cube_long);
				array_push($tmp,$cube_wide);
				array_push($tmp,$cube_high);
				sort($tmp);
				array_push($A,array_pop($tmp));//最大
				array_push($B,array_pop($tmp));//中间大
				array_push($C,array_pop($tmp)*$val['quantity']);//最小
			}
			$val['warehouse_id'] = $data['warehouse_id'];
			$val['w_name']		 = $data['w_name'];
		}
		if($A&&$B&&$C){
			sort($A);
			sort($B);
			array_push($cube_size,array_pop($A));
			array_push($cube_size,array_pop($B));
			array_push($cube_size,array_sum($C));
			sort($cube_size);

			//长
			$rs['cube_long']     = array_pop($cube_size);
			//宽
			$rs['cube_wide']     = array_pop($cube_size);
			//高
			$rs['cube_high']     = array_pop($cube_size);
			$rs['cube']			 = ($rs['cube_long'] * $rs['cube_wide'] * $rs['cube_high']);
            $data['volume_weight']= volume_weight_calculate(false,$rs['cube_long']*$rs['cube_wide']*$rs['cube_high'],false);  
            $rs['volume_weight']  = $data['volume_weight'];
			$rs					  = _formatArray($rs);
			_formatWeightCube($rs, 'weight_unit', 'length_unit', 'bulk_unit');
			if(empty($data['detail_total'])){
				$data['detail_total'] = array();
			}
			$data['detail_total']= array_merge($data['detail_total'], $rs);
		}
        $data=  _formatArray($data); 
		return $data;
	}

	//拣货导出时，销售单状态自动更新为“拣货中” added by jp 20140418
	public function updateSaleOrderStateById($sale_order_id, $sale_order_state = 0, $state_log_comments = null){
		if (empty($sale_order_id)) {
			return true;
		}
		$sale_order_state <= 0 && $sale_order_state	= C('SALE_ORDER_STATE_PICKING');
		is_null($state_log_comments) && $state_log_comments = L('module_Picking');		
		!is_array($sale_order_id) && $sale_order_id = explode(',', $sale_order_id);
		if ($sale_order_id) {
			//批量更新状态
			$update	= array(
						'sale_order_state'	=> $sale_order_state,
						C('LOCK_NAME')		=> array('exp', C('LOCK_NAME') . '+1'),
                        'update_time'       => date('Y-m-d H:i:s'),
					);
            if($sale_order_state == C('SALE_ORDER_STATE_PICKED')){
                $where  = array('id' => array('in', $sale_order_id),'sale_order_state'=>C('SALE_ORDER_STATE_PICKING'));
            }else{
                 $where  = array('id' => array('in', $sale_order_id));
            }
			M('SaleOrder')->where($where)->setField($update);
			//记录状态日志
			$params			= array(
								'id'				=> $sale_order_id,
								'state_module_name'	=> 'SaleOrder',
								'sale_order_state'	=> $sale_order_state,
								'state_log_comments'=> $state_log_comments
							);
			T('SaleOrder')->run($params,'setState');
		}
	}
	
	/**
	 * 获取销售单信息（用于api接口）
	 * @author jph 20141022
	 * @param int $id
	 * @return array
	 */
	public function apiGetOrder($id = null){
		if (is_null($id)) {
			$id	= $this->id;
		}
		$OrderInfo	= $this->OrderDetails($id);
		return $OrderInfo;
	}
	
	/**
	 * 获取销售单信息（用于api接口）
	 * @author jph 20141022
	 * @param mixed $ids
	 * @return array
	 */
	public function apiGetOrderList($ids){
		$OrderInfo	= C('API_GET_DATA_TYPE') == 'Simple' ?  $this->OrderDetailsSimpleList($ids) : $this->OrderDetailsList($ids);
		return $OrderInfo['list'];
	}

    /**
	 * 获取发货单基本信息列表
	 * @author jph 20161223
	 * @param mixed $ids
	 * @return array
	 */
	public function OrderDetailsSimpleList($ids){
		if (!is_array($ids)) {
			$ids	= explode(',', $ids);
		}
		if (empty($ids)) {
			return array();
		}
		$rs		= $this->where(array('id' => array('in', $ids)))->order('sale_order_no desc')->getField('id,id,order_no,sale_order_no,sale_order_state,send_date,order_date');
		if (!empty($rs)) {
			$params['_action']	= 'edit';
			foreach ($rs as &$value){
				$value['is_edit']	= saleOrderCheckEdit($value['sale_order_state'], $value['id'], $params);
				$value['is_delete']	= saleOrderCheckDelete($value['sale_order_state']);
			}
		}

		return _formatList($rs);
	}
	
	/**
	 * 获取新增销售单信息（用于api接口）
	 * @author jph 20141022
	 * @param mixed $ids
	 * @return array
	 */
	public function apiAddOrder($ids){
		$OrderInfo	= $this->OrderDetailsList($ids);
		return $OrderInfo['list'];
	}	
	
	/**
	 * 获取修改销售单信息（用于api接口）
	 * @author jph 20141030
	 * @param mixed $ids
	 * @return array
	 */
	public function apiModifyOrder($ids){
		$OrderInfo	= $this->OrderDetailsList($ids);
		return $OrderInfo['list'];
	}	

	/**
	 * 获取销售单基本信息
	 * @author jph 20141022
	 * @param type $id
	 * @return type
	 */
	public function OrderDetails($id = null){
		if (is_null($id)) {
			$id	= $this->id;
		}
		$rs	= $this->OrderDetailsList((int)$id);
		return array_shift($rs['list']);
	}

	/**
	 * 获取销售单基本信息列表
	 * @author jph 20141022
	 * @param type $ids
	 * @return type
	 */
	public function OrderDetailsList($ids){
		if (!is_array($ids)) {
			$ids	= explode(',', $ids);
		}
		if (empty($ids)) {
			return array();
		}
		$funds_class		= array(
									'deliveryFee', //派送费用-应收款 (基本价格【+挂号费】)【*卖家派送折扣(派送类型为快递)】
									'processFee', //处理费用-应收款 (处理费用【+(产品数-1)*增加数量费用】)【*卖家处理费用折扣】
									'packageFee', //包装费用-应收款 包装费用【*卖家包装费用折扣】
								);
		$sys_pay_class		= C('SYS_PAY_CLASS');
		$funds_left_join	= '';
		$funds_fields		= '';
		foreach ($funds_class as $class) {
			$funds_left_join	.= ' left join client_paid_detail ' . $class . ' on ' . $class . '.object_id=a.id and ' . $class . '.object_type=120 and ' . $class . '.pay_class_id=' . intval($sys_pay_class[$class]) . ' ';
			$field_name			 = strtolower(preg_replace('/([A-Z])/', '_\1', $class));
			$funds_fields		.= ', ' . $class . '.should_paid as ' . $field_name . ', ' . $class . '.paid_id as ' . $field_name . '_paid_id';
		}			
		$sql = 'select a.aliexpress_token,d.company_id,e.brt_account_no,a.is_insure,a.insure_price,
				a.order_no,a.sale_order_no,a.track_no,a.sale_order_state,a.send_date,a.order_date,
				a.client_id,b.comp_name as client_name,b.comp_no as client_no,b.email as comp_email,
				a.order_type,a.express_id as ship_id,a.warehouse_id,a.transaction_id,
				a.is_registered,a.weight,a.factory_id,a.id,a.package_id, a.comments, 
				c.email,c.fax,c.tax_no,c.city_name,c.country_id,c.country_name,c.consignee,c.mobile,c.post_code,c.company_name,c.address,c.address2,c.transmit_name,
				(f.price+if(is_registered=1,1,0)*f.registration_fee+' . step_price_calculate(true) . ')*if(ed.express_discount>0 && d.shipping_type in (' . implode(',',C('SHIPPING_TYPE_EXPRESS')) . '),ed.express_discount,1) as expected_delivery_costs' . $funds_fields . '
				from sale_order a 
				left join client b on b.id=a.client_id
				INNER JOIN sale_order_addition c ON a.id = c.sale_order_id 
				left join company e on a.factory_id=e.id
				left join express_detail f on f.id=a.express_detail_id
				left join express d on d.id=f.express_id
				left join express_discount ed on ed.factory_id=a.factory_id and ed.warehouse_id=a.warehouse_id
				' .  $funds_left_join . '
				where a.id in(\'' . implode("', '", (array)$ids) . '\') ' . '
				group by a.id
				order by a.id desc';
		$rs	= $this->db->query($sql);
		foreach ($rs as &$val){
			if ($val['delivery_fee_paid_id'] <= 0) {
				$val['delivery_fee']				= $val['expected_delivery_costs'];
			} else {
				$val['expected_delivery_costs']		= $val['delivery_fee'];
			}
		}
		$rs	= _formatList($rs);
		//销售单明细
		$details		= _formatList(M('SaleOrderDetail')
							->field('sod.sale_order_id as sale_id,sod.product_id,p.product_no,sum(sod.quantity) as quantity')
							->join('sod left join product p on p.id=sod.product_id')
							->where('sod.sale_order_id in (' . implode(',', $ids) . ')')
							->group('sod.sale_order_id,sod.product_id')
							->select(), null, 0,array('sale_id'));
		//其他费用明细
		$other_fee_detail	= D('ClientOtherArrearages')->getOtherFeeTotal($ids);		
		foreach ($rs['list'] as &$val){
			$val['detail']			= $details['list'][$val['id']];
			$val['other_fee_total']	= $other_fee_detail['list'][$val['id']];
		}
		return $rs;
	}

    public function updateAddressValid($data){
		unset($this->_validate);
		$this->_validate = array(
            array("",'validAddition','require',1,'callbacks'),
            array("sale_order_state",'pst_integer',"require",2), 
        );
        $this->_validAddition	 =	 array(
			array("consignee",'require','require',1),
			array("address",'require','require',1),
			array("post_code",'require','require',1),
			array("city_name",'require','require',1),
            array("city_name",'not_number','valid_city',2),
			array('email','email','valid_email',2),	//邮箱格式
	);
        $this->setAddressPost($data);//地址明细特殊验证
		return $this->_validSubmit($data,$this->_validate);
	}

    public function updateAddress(){
		$info	=	$_POST;
	 	if ($this->create($info)) {
			$this->_brf();
			$this->id	=	$info['id'];
			if($this->_beforeModel($info) == false){
				$this->error_type	= 1;
				return false;
			}
			$lock_no	= C('LOCK_ON');
			C('LOCK_ON',false);
			$r = $this->relation(true)->save();
            C('LOCK_ON',$lock_no);
			if (false === $r) {
				$this->error_type	=	2;
				return false;
			}
			$this->_afterModel($info);
			$this->execTags($info);
	 	} else {
	 		$this->error_type	=	1; 
			return false;  
	 	}
	}

    /**
	 * 删除订货信息
	 *
	 * @param int $id
	 * @param string $module
	 */
	public  function relationDelete($id,$module=null) { 
        $state  = $this->where('id='.$id)->getField('sale_order_state');
        if($state   == C('SALE_ORDER_STATE_PICKING')){
			$this->_brf(); 
			$this->id = $id;
			//$relation = array('detail');			
			// 删除操作
			$info = array(
                'id'=>$id,
                'sale_order_state' => C('SALE_ORDER_DELETED'),
                    );
			if($this->_beforeModel($info) == false){
				$this->error_type	= 1;
				return false;
			}
            
			C('LOCK_ON',false);
			$r = $this->save($info); 
            C('LOCK_ON',true);
			if (false === $r) {
				halt($this->getError());
			}
            
			$info['id']	=	$this->id;
			$module && $info['method_name'] = $module;
			$this->_afterModel($info,'delete'); 
			$this->execTags($info);   	
        }else{
           return parent::relationDelete($id);
        }
	}

    public function updateSaleCubeWeight($id){
        $sale_id    = $this->join('s left join sale_order_detail sd on s.id=sd.sale_order_id')->where('sd.product_id='.$id.' and sale_order_state not in ('.C('AFTER_SHIPPED_STATE').')')->field('distinct s.id as id')->getField('id',true);
        if(!empty($sale_id)){
            $sale_product   = M('sale_order_detail')->where('sale_order_id in ('.implode(',', $sale_id).')')->select();
            
            foreach($sale_product as $value){
                $detail_product[$value['sale_order_id']]['detail'][]  = $value;
            }
            //获取销售单产品信息
            foreach($detail_product as $key=>$val){
                $product_list   = $this->getProductInfo($val['detail']);
                if($product_list){
                    $val['id']  = $key;
                    $data   = $this->getTotalWeightCube($product_list,$val);
                    $sale_order[$key]['cube_high']  = $data['detail_total']['cube_high'];
                    $sale_order[$key]['cube_wide']  = $data['detail_total']['cube_wide'];
                    $sale_order[$key]['cube_long']  = $data['detail_total']['cube_long'];
                    $sale_order[$key]['weight']     = $data['detail_total']['weight'];
                    $sale_order[$key]['id']         = $key;
                    $sale_order[$key]['sale_order_state']   = array('not in',C('AFTER_SHIPPED_STATE'));
                }
            }
            
            foreach($sale_order as $v){
                $this->save($v);
            }
        }
    }

    /**
     * 销售单是否已经出库过added yyh 20151230
     * @param array $id 需要检验的销售单ID
     * @return array 发货过的销售单ID
     */
    public function isSent($id){
        !is_array($id) && $id= explode(',', $id);
        return  M('StateLog')->where('object_type='.  array_search('SaleOrder', C('STATE_OBJECT_TYPE')).' and object_id in ('.implode(',', $id).') and state_id='.C('SHIPPED'))->group('object_id')->getField('object_id',true);
    }
    
    public function setBackShelves($val,$picking_import_id){
        $sql    = 'UPDATE file_detail SET undeal_quantity=undeal_quantity+'.$val['quantity'].' WHERE product_id='.$val['product_id'].' AND location_id='.$val['location_id'].' AND file_id='.$picking_import_id;
        $this->db->query($sql);
    }

   /**
    * 初始化post信息
    */
    public function setNewPost($post,$judge){
        $this->_validDetail	 =	 array(
            array("quantity",'pst_integer','pst_integer',1),
            array("express_id",'require','require',1),
        );
		if (empty($post))	$post =	$_POST;
		if (!empty($post['order_date'])) {
			$post['order_date']	= $_POST['order_date'] = formatDate($post['order_date']);
		}
		$post['order_no']	= trim($post['order_no']);
		//是否需要清空GLS订单追踪单号
		if($post['id'] && D('Gls')->needClearGlsTrackNo($post)){
			$post['track_no']	= '';
		}
		///如果是自动抓取的则不验证快递公司及仓库
		$data_detail	= array();
        foreach($post['detail'] as $key=>$detail_info){
            if(!empty($detail_info['product_id']) && !empty($detail_info['quantity']) ){
                $data_detail[trim($detail_info['package_bg'])][$key]    = $detail_info;
            }
        }
		$bg_index		= array();
        foreach($data_detail as $package_bg=>$value){
            $id                                 = $post['id'];
            $list[$package_bg]                  = $post;
            $list[$package_bg]['package_bg']    = $package_bg;
            $list[$package_bg]['detail']        = $value;
            $express    = '';
            foreach($value as $index=>$v){
                empty($express) && $express = $v['express_id'];
                $list[$package_bg]['express_id']    = $v['express_id'];
                $bg_index[$package_bg][]    = $index;
                if($express != $v['express_id']){
                    $error_bg[$package_bg] = $package_bg;
                }
            }
        }

        //同一个包裹的全部明细都给出提示(派送方式不一致提示)
        if(!empty($error_bg)){
            foreach($error_bg as $package_bg){
                foreach($bg_index[$package_bg] as $index){
                    $error['name']  = 'detail['.$index.'][express_id]';
                    $error['value'] = L('only_choose_a_express');
                    $this->error[]  = $error;
                }
            }
        }
		
        foreach($list as $package_bg=>$data){
			//同包裹派送方式有多个的错误子订单不进行详细验证
			if (isset($error_bg[$package_bg])) {
				continue;
			}
            ///如果是自动抓取的则不验证快递公司及仓库								
            if ($data['from_type']!='automatisch') {								
                if($data['detail']){
                    $product_list   = $this->getProductInfo($data['detail']);
                }
                if($product_list){
                    $data           = $this->getTotalWeightCube($product_list,$data);
                }
                //派送方式选择	
                if(!empty($judge)){									
                    $express_id		    = $data['express_id'];
                    $country_id		    = $data['country_id'];
                    $old_post_code      = trim($data['post_code']); 								
                }else{								
                    $addition		    = $data['addition'][1];
                    $express_id		    = $data['express_id'];
                    $country_id		    = $addition['country_id'];
                    $old_post_code	    = trim($addition['post_code']); 
                }
                $post_arr   = array();
                preg_match_all('/^([a-z]*)(\d*)/i', $old_post_code, $post_arr);								
                $post_english   = $post_arr[1][0];								
                $post_code      = $post_arr[2][0];								
                //派送公司为it-gls时省份必须为两位字母
                if ($express_id > 0 && !in_array($express_id, array(C('SHIPPING_IT-BRT-OVERSEA_ID'))) && in_array(D('Shipping')->where('id='.$express_id)->getField('company_id'),array(C('EXPRESS_IT-GLS_ID'),C('EXPRESS_BRT_ID')))) {								
                    $this->addProperty('_validAddition', array('company_name','/^[A-Za-z]{2}$/','valid_province_name',self::VALUE_VAILIDATE));//所在省份，必须为两个字母
                }
                //默认派送为0
                $data['express_id'] = $data['express_detail_id'] = 0;
                //仓库启用，派送方式启用，派送明细派送
                if(intval($data['warehouse_id'])>0&&intval($express_id)>0&&intval($country_id)>0){								
					//设置派送方式明细
					$this->setExpressDetailId($data, $judge, $country_id, $express_id, $post_english, $post_code);
                    if ($data['express_detail_id'] == 0) {								
                        if(!empty($judge)){
                            return  1;
                        }								
                        foreach($bg_index[$package_bg] as $index){
                            $error['name']  = 'detail['.$index.'][express_id]';
                            $error['value'] = L('select_express_way_error');
                            $this->error[]  = $error;
                        }
                    }elseif(!empty($judge)){								
                        $re_express['express_detail_id']=$data['express_detail_id'];
                        $re_express['express_id']=$data['express_id'];   								
                        return  $re_express;	
                    }								
                    //送货地址是：Paketestation 时，只允许客人选用DHL的派送方式
                    _mergeAddress($data['addition'][1], ',', array('address', 'address2', 'company_name'));
                    if (intval($data['express_detail_id']) > 0 && checkStrIn(C('EXPRESS_WAY_DHL'), $data['addition'][1]['merge_address'])) {
                        $dhl_count = M('express')->where('id=' . $express_id . ' and company_id in (' . (int) C('EXPRESS_DHL_ID') . ',' . (int) C('EXPRESS_BRT_ID') . ')')->count();
                        if (intval($dhl_count) <= 0) {
                            foreach($bg_index[$package_bg] as $index){
                                $error['name']  = 'detail['.$index.'][express_id]';
                                $error['value'] = L('select_dhl_express_way_error');
                                $this->error[]  = $error;
                            }
                        }
						if (preg_match('/^\d+$/', trim($data['addition'][1]['address2'])) == 0) {//必须输入PostNumer，dhl api需要此信息
							$error['name']	= 'addition[1][address2]';
							$error['value'] = L('invalid_post_numer');
							$this->error[]	= $error;
						}
                    }
                }
                if($express_id==0){
                    if(intval($data['warehouse_id'])<=0){
                        $error['name']	= 'warehouse_id';
                        $error['value']	= L('require');
                        $this->error[]	= $error;	
                    }
                    foreach($bg_index[$package_bg] as $index){
                        $error['name']  = 'detail['.$index.'][express_id]';
                        $error['value'] = L('select_dhl_express_way_error');
                        $this->error[] = $error;
                    }			
                }
                //暂存处理 订单状态 拣货完成保持
                if($data['submit_type']=='3'){
                    $data['sale_order_state'] = M('SaleOrder')->where('id=' . $data['id'])->getField('sale_order_state');
                }
                //订单已发货状态处理
                $this->setSaleOrderDeliveryStatus($data);
            }
            $return_data = $data;
            $rs			 = _formatListRelation($data);
            //判断简单订单 复合订单
            $return_data['out_stock_type'] = intval($rs['detail_total']['quantity'])==1?1:(intval($rs['detail_total']['total_product'])==1?2:3);
            $return_list[$package_bg]   = $return_data;
        }

        //编辑销售单(销售单号,包裹号)唯一验证
        if(!empty($post['order_no']) && $post['id']>0){
            $userInfo   = getUser();
            if($userInfo['role_type'] == C('SELLER_ROLE_TYPE')){
                $factory_id = $userInfo['company_id'];
            }else{
                $factory_where['id']    = $post['id'];
                $factory_id = M('SaleOrder')->where($factory_where)->getField('factory_id');
            }
            $package_bg_arr = $this->where('order_no="'.$post['order_no'].'" and factory_id='.$factory_id.' and id!="'.$post['id'].'"')->getField('package_bg',TRUE);
            foreach($bg_index as $bg_no=>$index_num){
                if(in_array($bg_no, $package_bg_arr)){
                    foreach($index_num as $index){
                        $error['name']  = 'detail['.$index.'][package_bg]';
                        $error['value'] = L('exist_package_bg');
                        $this->error[]  = $error;
                    }
                }
            }
        }
		return $return_list;
    }

    /**
	 * 关联insert
	 *
	 * @return array
	 */
	public function relationInsert(){
        if(in_array($_POST['sale_order_state'], explode(',', C('SALE_CAN_ADD_STATE')))){
            $_post  = $_POST;
            //重新组合POST来的信息 
            $info	= $this->setNewPost();
            //模型验证
            $first  = array_shift($info);
            if ($this->create($first)) {
                $_POST  = $first;
                $this->_brf();
                if($this->_beforeModel($first) == false){
                    $this->error_type	= 1;
                    return false;
                }
                $id = $this->relation(true)->add();
                if (false === $id) {
                    $this->error_type	=	2;
                    return false;
                }	 
                $this->id	=	$id;
                empty($first) ? $_POST['id'] = $id : $first['id'] = $id;
                $this->_afterModel($first);
                $this->execTags($first);
                if (!empty($_POST['file_tocken'])) {
                    D('Gallery')->update($this->id, $_POST['file_tocken']);
                }
            } else {
                $this->error_type	=	1; 
                return false; 
            }
            if(!empty($info)){
                $this->splitPackageInsert($info);
                $this->splitPackageGallery();
            }
            $_POST  = $_post;
        }else{
            return parent::relationInsert();
        }
	}

    /**
	 * 关联insert
	 *
	 * @return array
	 */
	public function splitPackageInsert($info){
        $sale_order_info    = M('sale_order')->find($this->id);
        if($sale_order_info['edit_user'] > 0){
            $sale_order_info['add_user']    = $sale_order_info['edit_user'];
        }
        if($sale_order_info['update_time'] > 0){
            $sale_order_info['create_time'] = $sale_order_info['update_time'];
        }
        unset($sale_order_info['id'],$sale_order_info['sale_order_no'],$sale_order_info['lock_version'],$sale_order_info['edit_user'],$sale_order_info['update_time'],$sale_order_info['is_question']);
        $sale_order_info['addition'][1] = M('sale_order_addition')->where('sale_order_id='.$this->id)->find();
        unset($sale_order_info['addition'][1]['id'],$sale_order_info['addition'][1]['sale_order_id']);
        foreach($info as $key=>$value){
            $sale_order_info['cube_long'] = $value['cube_long'];
            $sale_order_info['cube_wide'] = $value['cube_wide'];
            $sale_order_info['cube_high'] = $value['cube_high'];
            $sale_order_info['weight']    = $value['weight'];
            $sale_order_info['volume_weight']    = $value['volume_weight'];
            $sale_order_info['out_stock_type']   = $value['out_stock_type'];
            $data   = $sale_order_info;
            $data['package_bg'] = $value['package_bg'];
            $data['order_no']   = $value['order_no'];
            $data['express_id'] = $value['express_id'];
            $data['express_detail_id']  = $value['express_detail_id'];
            $data['detail']  = $value['detail'];
            $this->data = $data;
            $this->_action  = 'insert';
            $_POST  = $this->data;
            $this->_brf();
            unset($this->data['referer'],$this->data['error_message']);
            if($this->_beforeModel($data) == false){
                $this->error_type	= 1;
                return false;
            }
            $id = $this->relation(true)->add();
            if (false === $id) {
                $this->error_type	=	2;
                return false; 
            }
            empty($data) ? $_POST['id'] = $id : $data['id'] = $id; 
            $this->_afterModel($data); 
            //订单导入新增状态日志
            $data['state_module_name']  = 'SaleOrder';
            $data['state_log_comments'] = L('sale_order_split_package');
            $this->execTags($data);
            if($id>0){
                A('SaleOrder')->generateBarcode($id);
                $this->split_order_id[$id] = $id;
            }else{
                $this->error_type	=	2;
                return false;
            }
        }
	}

    public function splitPackageGallery(){
        if(C('IS_PRODUCT_TYPE') && !empty($this->split_order_id)){
            $model  = D('Gallery');
            $sale_order_file    = $model->getAry($this->id,C('DOWNLOAD_FILE_TYPE'));
            if(!empty($sale_order_file)){
                $path	= getUploadPath(C('DOWNLOAD_FILE_TYPE'));
                foreach($sale_order_file as $file_info){
					$old_file   = $path . $file_info['file_url'];
                    $suffix     = '.'.pathinfo($old_file,PATHINFO_EXTENSION);
                    foreach($this->split_order_id as $sale_order_id){
                        $new_file_url   = getRands(15).$suffix;
                        $new_file       = $path.$new_file_url;
                        if(copy($old_file, $new_file)){
                            $file_info['file_url']      = $new_file_url;
                            $file_info['relation_id']   = $sale_order_id;
                            unset($file_info['id']);
                            M('Gallery')->add($file_info);
                        }else{
                            $this->error        = L('copy_file_failed');
                            $this->error_type	= 2;
                            return false;
                        }
                    }
                }
            }
        }
    }

    /**
	 * 保存编辑操作
	 *
	 * @return array
	 */
	public function relationUpdate() {
        if(trim($_POST['from_type']) != 'out_stock'){
            $_post  = $_POST;
            $info	=	$this->setNewPost();
            $first  = array_shift($info);
            if ($this->create($first)) {
                $_POST  = $first;
                $this->_brf();
                $this->id	=	$first['id'];
				if($this->_beforeModel($first) == false){
                    $this->error_type	= 1;
                    return false;
                }
                $r = $this->relation(true)->save();
                if (false === $r) {
                    $this->error_type	=	2;
                    return false;
                }
                $this->_afterModel($first); 
                $this->execTags($first);   
            } else {
                $this->error_type	=	1; 
                return false;  
            }
            if(!empty($info)){
                $this->_action  = 'insert';
                $this->splitPackageInsert($info);
                $this->splitPackageGallery();
                $this->_action  = 'update';
            }
            $_POST  = $_post;
        }else{
            return parent::relationUpdate();
        }
    }

	/**
	 * 获取设置派送方式明细
	 * @param array $data
	 * @param string $judge
	 * @param intval $country_id
	 * @param intval $express_id
	 * @param string $post_english
	 * @param string $post_code
	 */
	public function setExpressDetailId(&$data, $judge, $country_id, $express_id, $post_english, $post_code){
		$list		= $this->getShippingList($country_id, $data['warehouse_id'], $express_id, $post_english, $post_code);
		//邮编是否在不派送范围内
		$is_sent	= $this->checkNotDelivery($list, $post_english, $post_code);
		if($is_sent){
			if(empty($judge)){
				$data['cube_long']	= $data['detail_total']['cube_long'];
				$data['cube_wide']	= $data['detail_total']['cube_wide'];
				$data['cube_high']	= $data['detail_total']['cube_high'];
				$data['weight']		= $data['detail_total']['weight'];
				if($data['sale_order_state']==C('SHIPPED')&&$data['package_id']>0){//发货时加上包装重量
					$package_weight = M('package')->where('id='.$data['package_id'])->getField('weight');
				}
			}
            $order_weight		= $data['detail_total']['weight'];
            $order_weight=choose_weight($order_weight,$data['volume_weight'],$list[0]);            
            $order_weight		+= $package_weight;
			$ori_size	= array();
			$ori_size[]	= $data['detail_total']['cube_high'];
			$ori_size[]	= $data['detail_total']['cube_wide'];
			$ori_size[]	= $data['detail_total']['cube_long'];
			sort($ori_size);
			$meet_array	= $this->allowExpressDetail($list, $post_english, $post_code, $ori_size, $order_weight);
			if (is_array($meet_array) && $meet_array) {
				asort($meet_array, SORT_NUMERIC);
				$express_detail_id			= array_keys($meet_array);
				$data['express_detail_id']	= $express_detail_id[0];
				$data['express_id']			= $express_id;
			}
		}
	}
	
	/**
	 *
	 * @param intval $country_id
	 * @param intval $warehouse_id
	 * @param intval $express_id
	 * @param string $post_english
	 * @param string $post_code
	 * @return array
	 */
	public function getShippingList($country_id, $warehouse_id, $express_id, $post_english, $post_code){
		if(!empty($post_english) || !empty($post_code)){
			$post_where = ' or (e.english="'.$post_english.'" )';
		}
		$where  = ' and ((e.english="" and e.post_begin="" and e.post_end="") or (b.post_is_express=2)'.$post_where.')';

		$sql = 'select a.*,b.*,b.id as express_detail_id,e.*
				from express a
				left join express_detail b
				on a.id=b.express_id
				left join warehouse c
				on a.warehouse_id=c.id
				left join express_country d
				on d.express_detail_id=b.id
				left join express_post e
				on e.express_detail_id=b.id
				where (c.is_use=1 and a.status=1 and b.is_express=1
				and d.country_id='.$country_id.'
				and a.warehouse_id='.$warehouse_id.' and a.id='.$express_id.')'.$where;
		$list = $this->db->query($sql);
		return $list;
	}

	/**
	 * 检查是否属于不派送邮编
	 * @param type $list
	 * @param type $post_english
	 * @param type $post_code
	 * @return boolean
	 */
	public function checkNotDelivery($list, $post_english, $post_code){
		if (empty($list) || !is_array($list)) {
			return false;
		} elseif (empty ($post_english) && empty ($post_code)) {
			return true;
		}
		$is_sent = TRUE;
		foreach ($list as $val) {
			//跳过不是不派送邮编区间或邮编区间全为空的记录
			if ($val['post_is_express'] != 2 || (empty($val['post_begin']) && empty($val['post_end']) && empty($val['english']))) {
				continue;
			}

			/**
			 * 匹配不派送的3种情况说明：
			 * 1/3. 邮编区间纯英文无数字区间，此时填写邮编一旦英文前缀匹配，则属于不派送
			 * 2/3. 邮编区间纯数字区间无英文，此时填写邮编仅当无英文前缀，且数字后缀在数字区间内(只填写起始邮编，则数字后缀应与此一致)，则属于不派送
			 * 3/3. 邮编区间带英文和数字区间，此时填写邮编仅当有英文前缀，且数字后缀在数字区间内(只填写起始邮编，则数字后缀应与此一致)，则属于不派送
			 */
			//1/3只有英文
			if(empty($val['post_begin']) && empty($val['post_end'])){
				//填写邮编英文前缀与派送方式英文一致
				if (strtoupper($val['english']) == strtoupper($post_english)) {
					$is_sent = FALSE;
					break;
				}
			//2/3只有数字
			} elseif (empty($val['english']) && (!empty($val['post_begin']) || !empty($val['post_end']))) {
				if (!empty($post_english)){
					continue;
				}
				//填写邮编为纯数字且在邮编区间内
				if (empty($val['post_end'])) {//结束邮编为空
					if ($val['post_begin'] == $post_code) {//填写邮编等于起始邮编
						$is_sent = FALSE;
						break;
					}
				} else {//结束邮编不为空
					//填写邮编在邮编区间内
					if ($val['post_begin']<= $post_code &&  $post_code <= $val['post_end']) {
						$is_sent = FALSE;
						break;
					}
				}
			//3/3有英文，数字
			} elseif ((!empty($val['post_begin']) || !empty($val['post_end'])) && !empty($val['english'])){
				if (strtoupper($val['english']) != strtoupper($post_english) || empty($post_code)) {
					continue;
				}
				if (empty($val['post_end'])) {//结束邮编为空
					if ($val['post_begin'] == $post_code) {//填写邮编等于起始邮编
						$is_sent = FALSE;
						break;
					}
				} else {//结束邮编不为空
					//填写邮编在邮编区间内
					if ($val['post_begin']<= $post_code &&  $post_code <= $val['post_end']) {
						$is_sent = FALSE;
						break;
					}
				}
			}
		}
		return $is_sent;
	}
	
	/**
	 * 获取符合的派送方式明细
	 * @param array $list
	 * @param string $post_english
	 * @param string $post_code
	 * @param array $ori_size
	 * @param float $order_weight
	 * @return array
	 */
	public function allowExpressDetail($list, $post_english, $post_code, $ori_size, $order_weight){
		$meet_array		= array();
		$has_priority	= false;
		foreach ($list as $val) {
			if ($has_priority && $val['post_is_express'] != 1) {
				continue;
			}
			//邮编限制
			if ($val['post_is_express'] == 1) {
				if(!empty($val['post_begin']) || !empty($val['post_end']) || !empty($val['english'])){
					if(!empty($val['post_begin']) || !empty($val['post_end']) || strtoupper($val['english']) != strtoupper($post_english)){
						if(!empty($val['english'])){
							if(strtoupper($val['english']) != strtoupper($post_english)){
								continue;
							}elseif(empty($val['post_begin']) && empty($val['post_end']) && !empty ($post_code)){
								continue;
							}
						}
						if ((!empty($val['post_begin']) || $val['post_begin'] == 0) && !empty($val['post_end'])) {
							if ($val['post_begin'] > $post_code || $post_code > $val['post_end']) {
								continue;
							}
						} elseif (!empty($val['post_begin']) && $val['post_begin'] != $post_code) {
							continue;
						}
					}
				}
			}
			//重量限制
			if ($val['weight_begin'] > $order_weight || $order_weight > $val['weight_end']) {
				continue;
			}
			$new_size = array();
			$new_size[] = $val['cube_long'];
			$new_size[] = $val['cube_wide'];
			$new_size[] = $val['cube_high'];
			sort($new_size);
			//按基本价格最便宜的排序
			if ($ori_size[2] <= $new_size[2] && $ori_size[0] <= $new_size[0] && $ori_size[1] <= $new_size[1]) {
				if ($val['post_is_express'] == 1) {//存在
					$priority_meet_array[$val['express_detail_id']] = $val['price'];
					$has_priority = true;
				}
				$meet_array[$val['express_detail_id']] = $val['price'];
			}
		}
		if (!empty($priority_meet_array)) {
			$meet_array = $priority_meet_array;
		}
		return $meet_array;
	}

	/**
	 * 订单已发货状态处理
	 * @param array $data
	 */
	public function setSaleOrderDeliveryStatus(&$data){
		if($data['detail']){
			if($data['from_type']=='out_stock'){
				//出库模块
				foreach($data['detail'] as $key=>$val){
					if($data['sale_order_state']==C('SHIPPED')){
						$data['detail'][$key]['state']		   = 4;					//明细产品发货完成
					}else{
						switch($data['out_stock_type']){
							case 1://简单订单1 单个产品单个数量
								$data['detail'][$key]['state']	   = 1;
								break;
							case 2://复合订单2 单个产品多个数量
							case 3://复合订单3 多个产品多个数量
								if($val['real_quantity']==$val['quantity']){
									$data['detail'][$key]['state'] = 4;
								}else{
									$data['detail'][$key]['state'] = 2;
								}
								break;
							default:
								break;
						}
					}
				}
			}else{
				//订单模块
				foreach($data['detail'] as $key=>$val){
					if($data['sale_order_state']==C('SHIPPED')){
						$data['detail'][$key]['real_quantity'] = $val['quantity'];
						$data['detail'][$key]['state']		   = 4;					//明细产品发货完成
					}else{
						$data['detail'][$key]['real_quantity'] = 0;
						$data['detail'][$key]['state']		   = 1;					//明细产品待处理
					}
				}
			}
		}
	}
}