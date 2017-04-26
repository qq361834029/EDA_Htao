<?php 
/**
 * 销售单欠款 object_type 120 
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author		何剑波
 * @version 	2.1,2012-07-22
 */
class ClientSalePublicModel extends AbsFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	public $tableName 				= 'paid_detail';
	///款项类型
	public $object_type				=	120;///客户期初欠款
	///对象类型
	public $comp_type				=	1;
	///对象款项表
	public $object_type_table		=	'client_paid_detail';	
    public $funds_class             = array();
    public function _initialize(){
        parent::_initialize();
        if(MODULE_NAME == 'Ajax' && ACTION_NAME == 'setInsurePrice'){
            $this->funds_class    = array(
                                'insurePrice'//投保金额-应收款
                            );
        }else{
			$this->funds_class	= array(
                                'deliveryFee', //派送费用-应收款 (基本价格【+挂号费】)【*卖家派送折扣】
                                'processFee', //处理费用-应收款 处理费用【+(产品数-1)*增加数量费用】
                                'packageFee', //包装费用-应收款
                                'deliveryCost',//派送成本-应付款 基本价格(成本)【+挂号费(成本)】
                                'insurePrice'//投保金额-应收款
                            );
        }
    }

    /**
	 * 销售产生的款项
	 *
	 * @param array $info $info['id'] 销售单号 $info['info'] 页面post来的原始信息
	 * @return array $vo
	 */
	public function _fund($info){
		$sale_id	= $info['id']; 
		///获取销售单主表信息,组合付款的信息
		$info['funds']					=	M('SaleOrder')->field('send_date as paid_date,factory_id as comp_id,id as object_id,sale_order_no as reserve_id,warehouse_id,express_id,express_detail_id,is_registered,package_id,weight,volume_weight,is_insure,insure_price,order_type')->where('id='.$sale_id)->find();
		///获取客户名称
        $info['funds']['warehouse_id']  = $info['warehouse_id']>0 ? $info['warehouse_id'] : $info['funds']['warehouse_id'];
        $info['currency_id']            = $info['currency_id']>0 ? $info['currency_id'] : SOnly('warehouse', $info['funds']['warehouse_id'],'w_currency_id');
		$info['funds']['comp_name']		= $this->getCompName($info['funds']);	
		$info['funds']['basic_id']		= $info['basic_id'] > 0 ? $info['basic_id'] : C('MAIN_BASIC_ID');
		$info['funds']['paid_date']		= !empty($info['paid_date']) ? $info['paid_date'] : date('Y-m-d');
		$info['funds']['comp_type']		= $this->comp_type;
		$info['funds']['currency_id']	= $info['currency_id']>0 ? $info['currency_id'] :C('SYS_EURO_ID');
		$info['funds']['account_money']	= 0;
		$info['funds']['comments']		= '';
		$info['funds']['object_type']	= $this->object_type;
		$info['funds']['relation_type']	= array_search('SaleOrder', C('FUNDS_RELATED_DOC_MODULE'));//关联单据类型
		$info['package']				= M('Package')->find($info['funds']['package_id']);
		$info['express_detail']			= M('ExpressDetail')->field('main.shipping_type, main.warehouse_id, main.company_id,main.calculation,detail.id as express_detail_id, detail.*')->join(' as detail left join __EXPRESS__ as main on main.id=detail.express_id')->where('detail.id=' . $info['funds']['express_detail_id'])->find();
//		$info['factory_info']			= M('Company')->find($info['funds']['comp_id']);//卖家信息，用于折扣计算
        $where['c.id']              = $info['funds']['comp_id'];
        $where['e.warehouse_id']    = $info['funds']['warehouse_id'];
		$factory_info   = M('Company')->alias('c')->join(' __EXPRESS_DISCOUNT__  e on e.factory_id=c.id')->field('c.package_discount,e.process_discount')->where($where)->select();//卖家信息，用于折扣计算
		$info['factory_info']   = $factory_info[0];
        $sys_pay_class					= C('SYS_PAY_CLASS');
//		if (M($this->object_type_table)->where('object_id=' . $sale_id . ' and object_type=' . $this->object_type)->count() > 0) {//只更新包装费用
//			$funds_class					= array(
//												'packageFee', //包装费用-应收款
//											);			
//		} else {//第一次保存全部款项，后面只更新包装费用
//        if(MODULE_NAME == 'Ajax' && ACTION_NAME == 'setInsurePrice'){
//            $funds_class    = array(
//                                'insurePrice'//投保金额-应收款
//                            );
//        }else{
//			$funds_class	= array(
//                                'deliveryFee', //派送费用-应收款 (基本价格【+挂号费】)【*卖家派送折扣】
//                                'processFee', //处理费用-应收款 处理费用【+(产品数-1)*增加数量费用】
//                                'packageFee', //包装费用-应收款
//                                'deliveryCost',//派送成本-应付款 基本价格(成本)【+挂号费(成本)】
//                                'insurePrice'//投保金额-应收款
//                            );
//        }
//		}
        
		$vo['sale_id']					=	$info['id']; ///销售单ID 
		foreach ((array)$this->funds_class as $fun_name) {
			$info['funds']['pay_class_id']	= $sys_pay_class[$fun_name];
			$vo['funds'][$fun_name]			= $this->$fun_name($info);
		}
		unset($info);
		return $vo;
	}
    
    public function cleanFund($params){
        $funds_class    = $this->funds_class;
        $sys_pay_class  = C('SYS_PAY_CLASS');
        $fund['object_id']      = intval($params['id']);
        $fund['object_type']    = $this->object_type;
        foreach((array)$funds_class as $funds_name){
            $fund['pay_class_id']   = $sys_pay_class[$funds_name];
            $this->setFundsId($fund);
            if($fund['id']> 0){
                $this->_deleteFunds($fund);
                $fund['id'] = 0;
            }
        }
    }

    /**
	 * 投保费
	 *
	 * @param int $id
	 * @return array
	 */
	public function insurePrice($info){
		$funds				= $info['funds'];
        if($funds['is_insure'] == 1){
            $funds['money'] = $funds['insure_price'];
            unset($funds['is_insure'],$funds['insure_price'],$funds['express_id'], $funds['express_detail_id'], $funds['is_registered'], $funds['package_id'], $funds['weight']);
            $this->setFundsId($funds);
            if(in_array(ACTION_NAME,array('delete','DeleteOrder'))){
                if($funds['id'] > 0){
                    $this->_deleteFunds($funds['id']);
                }
            }else{
                $funds['id']    = $this->_saveFunds($funds);   
            }
            return $funds;  
        }
        return ;
	}
	
	/**
	 * 派送费用
	 *
	 * @param int $id
	 * @return array
	 */
	public function deliveryFee($info){
		$funds				= $info['funds'];
		$funds['money']		= $info['express_detail']['price'] + ($funds['is_registered'] == 1 ? $info['express_detail']['registration_fee'] : 0);
		//超过每公斤所需要费用 added by jp 20141202
        $order_weight=choose_weight($funds['weight'],$funds['volume_weight'],$info['express_detail']); 
        $sum_weight   = $order_weight+$info['package']['weight'];
		$funds['money']		+= step_price_calculate(false,$sum_weight,$info['express_detail']);
		
		if (in_array(M('Express')->where('id=' . $info['express_detail']['express_id'])->getField('shipping_type'),C('SHIPPING_TYPE_EXPRESS'))) {//派送类型为快递才有折扣
            $express_discount   = M('express_discount')->field('express_discount')->where('factory_id='.$info ['funds']['comp_id'].' and warehouse_id='.$info ['warehouse_id'])->find();

			if ($express_discount['express_discount'] > 0) {
				$funds['money']	*= $express_discount['express_discount'];
			}
		}
		unset($funds['is_insure'],$funds['insure_price'],$funds['express_id'], $funds['express_detail_id'], $funds['is_registered'], $funds['package_id'], $funds['weight']);
		$this->setFundsId($funds);
		$funds['id']		= $this->_saveFunds($funds);   
		return $funds;  
	}	
	
	/**
	 * 处理费用
	 *
	 * @param int $id
	 * @return array
	 */
	public function processFee($info){
		$funds			= $info['funds'];
        $this->setFundsId($funds);  //判断是更新还是新增款项
		$sum_weight		= choose_weight($funds['weight'],$funds['volume_weight'],$info['express_detail'])+$info['package']['weight'];
		//对应卖家的收费类型   add by lxt 2015.06.19
		$factory_detail = M('SaleOrder')
		                  ->alias('a')
		                  ->join('company as b on a.factory_id=b.id')
		                  ->join('express as c on a.express_id=c.id')
		                  ->field('b.process_discount_type,c.shipping_type')
		                  ->where('a.id='.$info['id'].' and c.id='.$funds['express_id'])
		                  ->find();
		//从明细表中查找价格信息     edit by lxt 2015.06.19
		$process_fee	= M('ProcessFeeDetail')->alias("a")->join("process_fee b on a.process_fee_id=b.id")
		                  ->field("a.price as price,a.step_price as step_price,a.max_price as max_price,b.accord_type as accord_type")
		                  ->where('a.weight_begin<=' . $sum_weight . ' and a.weight_end>=' . $sum_weight . ' and b.shipping_type=' . $factory_detail['shipping_type'].' and b.warehouse_id='.$info['warehouse_id'].' and b.accord_type='.$factory_detail['process_discount_type'].' and b.order_type in (0,'.$funds['order_type'].')')
		                  ->order(" b.order_type<>{$funds['order_type']},b.create_time")->find();
		if ($process_fee) {
			$sale_quantity		= M('SaleOrderDetail')->where('sale_order_id=' . $info['id'])->getField('sum(quantity)');
			//按数量才要计算增加费用，但是按重量的数据没有step_price字段，所以公式不变      edit by lxt 2015.06.19
			$funds['money']		= $process_fee['price']+($sale_quantity-1)*$process_fee['step_price'];	
            //先算封顶再算折扣
            //封顶费用 added  by  yyh 20150130
            if(($funds['money']>$process_fee['max_price']) && $process_fee['accord_type']==1){//只有按数量才有封顶费用     edit by lxt 2015.06.19
                $funds['money'] = $process_fee['max_price'];
            }
            if ($info['factory_info']['process_discount'] > 0) {
				$funds['money']	*= $info['factory_info']['process_discount'];
			}
            //派送方式为DE-KR或ES-CD的订单，订单处理费用乘以2  add by lml 2016.01.05
            if($funds['express_id']== C('EXPRESS_DE-KR_ID') || $funds['express_id']== C('EXPRESS_ES-CD_ID')){
                $funds['money']	*= 2;
            }
            unset($funds['is_insure'],$funds['insure_price'],$funds['express_id'], $funds['express_detail_id'], $funds['is_registered'], $funds['package_id'], $funds['weight']);
            $funds['id']		= $this->_saveFunds($funds);
            return $funds;
		} elseif ($funds['id'] > 0) {
			$this->_deleteFunds($funds['id']);
		}
	}
	
	/**
	 * 包装费用
	 *
	 * @param int $id
	 * @return array
	 */
	public function packageFee($info){
		$funds			= $info['funds'];
		$this->setFundsId($funds);
		if ($info['package']['id'] > 0) {
			$funds['money']	= $info['package']['price'];	
			if ($info['factory_info']['package_discount'] > 0) {
				$funds['money']	*= $info['factory_info']['package_discount'];
			}				
			unset($funds['is_insure'],$funds['insure_price'],$funds['express_id'], $funds['express_detail_id'], $funds['is_registered'], $funds['package_id'], $funds['weight']);
			$funds['id']	= $this->_saveFunds($funds);   
			return $funds;  
		} elseif ($funds['id'] > 0) {
			$this->_deleteFunds($funds['id']);
		}
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
