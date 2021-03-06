<?php 
/**
 * 出库单欠款 object_type 131
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author		何剑波
 * @version 	2.1,2012-07-22
 */
class ClientOutBatchPublicModel extends AbsFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	public $tableName 				= 'paid_detail';
	///款项类型
	public $object_type				=	131;
	///对象类型
	public $comp_type				=	1;
	///对象款项表
	public $object_type_table		=	'client_paid_detail';	
   
 	/**
	 * 出库产生的款项
	 *
	 * @param array $info $info['id'] 出库批次id $info['info'] 页面post来的原始信息
	 * @return array $vo
	 */
	public function _fund($info){
        $info_funds                     = M('OutBatch')
                                        ->alias('ob')
                                        ->join('left join __OUT_BATCH_DETAIL__ obd on ob.id=obd.out_batch_id')
                                        ->join('left join __PACK_BOX__ pb on pb.id=obd.pack_box_id')
                                        ->where('ob.id='.$info['id'])
                                        ->field('ob.transport_type,pb.factory_id as comp_id,pb.id as object_id,pb.pack_box_no as reserve_id,pb.warehouse_id,pb.package_id,if(ob.transport_type='.C('SEA_TRANSPORT').',obd.review_cube,obd.review_weight) as review')
                                        ->select();
		return $this->saveFunds($info_funds, $info);
	}

	/**
	 *
	 * @param type $info_funds
	 * @return type
	 */
	public function saveFunds($info_funds, $info){
        foreach($info_funds as $funds_val){
            $comp_arr[$funds_val['comp_id']]    = $funds_val['comp_id'];
        }
        $factory_info                       = getCompanyFactory($comp_arr,'domestic_freight');
        foreach ($info_funds as $value){
            $info['funds']                  = $value;
            $info['funds']['warehouse_id']  = $info['warehouse_id']>0 ? $info['warehouse_id'] : $info['funds']['warehouse_id'];
            $info['currency_id']            = $info['currency_id']>0 ? $info['currency_id'] : SOnly('warehouse', $info['funds']['warehouse_id'],'w_currency_id');
            $info['funds']['comp_name']		= $this->getCompName($info['funds']);
            $info['funds']['basic_id']		= $info['basic_id'] > 0 ? $info['basic_id'] : C('MAIN_BASIC_ID');
            $info['funds']['paid_date']		= !empty($info['paid_date']) ? $info['paid_date'] : ($info['funds']['paid_date'] ? $info['funds']['paid_date'] : date('Y-m-d'));
            $info['funds']['comp_type']		= $this->comp_type;
            $info['funds']['currency_id']	= $info['currency_id']>0 ? $info['currency_id'] :C('SYS_EURO_ID');
            $info['funds']['account_money']	= 0;
            $info['funds']['comments']		= '';
            $info['funds']['object_type']	= $this->object_type;
            $info['funds']['relation_type']	= array_search('PackBox', C('FUNDS_RELATED_DOC_MODULE'));//关联单据类型
            $info['factory_info']           = $factory_info[$info['funds']['comp_id']];
            //是否收取国内运费
            if($info['factory_info']['is_charge']){
                $sys_pay_class  = C('OUT_BATCH_SYS_PAY_CLASS');
                $funds_class    = array(
                                    'domesticShippingFee'
                                    );
                $vo['sale_id']					=	$info['id']; ///销售单ID
                foreach ((array)$funds_class as $fun_name) {
                    $info['funds']['pay_class_id']	= $sys_pay_class[$fun_name];
                    $vo['funds'][$fun_name]			= $this->$fun_name($info);
                }
            }
        }
		unset($info);
		return $vo;
	}
	/**
	 * 国内运费
	 *
	 * @param array $info
	 * @return array
	 */
	public function domesticShippingFee($info){
		$funds			= $info['funds'];
		$this->setFundsId($funds);
        $price = domesticShippingFee($funds['warehouse_id'],$funds['transport_type'],(float)$funds['review']);
        //计算折扣
        if($info['factory_info']['percentage']>0){
            $price *= 1 + $info['factory_info']['percentage'];
        }
		$funds['money']	= $price * $funds['review'] / ($funds['transport_type'] == C('SEA_TRANSPORT') ? 1000000 : 1000);
        $funds['id']	= $this->_saveFunds($funds);
        return $funds;
	}
	
	/**
	 * 设置款项id
	 * @param array $funds
	 */
	public function setFundsId(&$funds){
		$funds_id	= $this->table($this->object_type_table)->where('object_id=' . $funds['object_id'] . ' and object_type=' . $funds['object_type'] . ' and pay_class_id=' . $funds['pay_class_id'])->getField('paid_id');
        if ($funds_id > 0) {
			unset($funds['paid_date']);
			$funds['id']	= $funds_id;
		}		
	}


	/**
	 * 派送成本(快递公司欠款)
	 *
	 * @param int $id
	 * @return array
	 */
	public function deliveryCost($info){
		return Funds($info,220);  		
	}	
	 
	/**
	 * 删除销售单
	 *
	 * @param int $id
	 * @return array
	 */
	public function deleteOp($id){   
		///删除销售单款项
		if($id>0) {
			$paid_id = $this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1')
			->getField('id', true); 
			///款项表ID
			if (count($paid_id)>0){
				$vo	=	$this->_deleteFunds($paid_id);  
			}
		} 
		///删除预付款款项
		Funds($id,121,'delete');
		//删除派送成本
		Funds($id,220,'delete');  	
		return $vo;
	}
	
	/**
	 * 销售单欠款信息
	 *
	 * @param int $id 销售单ID
	 * @return array
	 */
	public function fundInfo($id) {  
		if($id>0) {
			$model			=	M($this->getCompPaidDetail($this->comp_type));
			///销售单欠款
			$info['funds'] 	= _formatList($this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1')
			->select());   
			///预付款信息
			$info['advance']			=	Funds($id,121,'fundInfo');///预付款信息
			$info['advance_have_paid']	=	Funds($id,121,'getAdvanceTotalMoney');//////预付款信息总金额
			///销售单款项信息
			$info['sale_order_paid']	=	_formatArray($model->field('sum(should_paid*income_type*-1) as need_paid')->where('object_type in (120,121,122) and object_id='.$id)->find());      
			return $info;
		}
	}
	
	/**
	 * 销售单欠款
	 *
	 * @param int $id
	 * @return array
	 */
	public function saleFunds($id){
		if($id>0) {
			$this->format_data = false; 
			$model	= M('saleOrderDetail');
		 	$info	= $model
		 			->field( 	'b.basic_id as basic_id,b.currency_id as currency_id,date(b.order_date) as paid_date,
								b.client_id as comp_id,'.$this->comp_type.' as comp_type,b.id as object_id,b.sale_order_no as reserve_id,
								(sum(quantity*capability*dozen*discount*price)-b.pr_money) as money,
								0 as account_money,
								c.paid_id as id,
								'.$this->object_type.' as object_type
								')
							->join('as a 
									left join sale_order as b on a.sale_order_id=b.id and b.id='.$id.' 
									left join '.$this->object_type_table.' as c 
										on c.object_id=a.sale_order_id and c.object_type='.$this->object_type.' ')
							->where('a.sale_order_id='.$id.' ')
							->group('a.sale_order_id')
							->find();
			 
				///如果开启发货模块 
				if (C('sale.relation_sale_follow_up')==1){///销售是否有后续流程 
					$info['state']	=	0;
				}else{
					$info['state']	=	1;
				}    
				$info['id']		=	 $this->_saveFunds($info);   
				return $info;  
		}
	}
	
	/**
	 * 销售单预付款
	 *
	 * @param array $info
	 * @return array
	 */
	public function saleAdvance($info) { 
		return Funds($info,121);
	} 
	 
	/**
	 * 销售单平帐信息
	 *
	 * @param array $info
	 */
	public function saleCloseOut($info) { 
///		return Funds($info,122);
	} 
	
	/**
	 * 插入前的业务规则验证
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkInsert($info){    
		return	$this->checkClientDate($info);  
	}
	 
	/**
	 * 修改插入数据前的业务规则验证
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkUpdate($info){ 
		return	$this->checkClientDate($info);  
	} 
	
	/**
	 * 验证某日期以前的款项是否可以被插入
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkClientDate($info){
		$error['state']	=	1;    
		if ($this->validCheckAccountDate(formatDate($info['order_date'],'vf_date'),$info)===false){
			$error['state']	=	-1;
			$error['error_msg'][]	=	$info['order_date'].L('order_date_chk');///已指定操作,不可删除
		}  
		return $error;
	}
	 
	/**
	 * 验证是否可修改
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkEdit($info) {  
		return $this->checkHaveCloseOut($info); 
	}
	 
	/**
	 * 验证是否可删除
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkDelete($info) {  
		return $this->checkHaveCloseOut($info);
	}
	 
	/**
	 * 验证多个厂家是否被对账或总平或者指定支付
	 *
	 * @param array $info
	 * @return array
	 */
	private function checkHaveCloseOut($info) { 
		$error['state']	=	1; 
		///销售单id
		$id	=	is_array($info)?$info['id']:$info; 
		///验证是否被对账或者总平
		if ($id>0) { 
			///销售单删除验证
			$error	=	$this->_checkSaleOrder($id); 
		}else {
			$error['state']			=	-1; 
			$error['error_msg'][]	=	L('error_funds_values_error');///款项验证,参数错误,请重新操作
		}   
		return $error; 
	}
	
	 
}
?>