<?php 
/**
 * 退货单款项
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class ClientReturnSaleStoragePublicModel extends AbsFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	public $tableName 				= 'paid_detail';
	//款项类型
	public $object_type				=	123;//退货单款项
	public $sale_object_type		=	120;//退换货单
	//对象类型
	public $comp_type				=	1;
	//对象款项表
	public $object_type_table		=	'client_paid_detail';	
   
	/**
	 * 退货产生的款项
	 *
	 * @param array $id 退货单ID
	 * @return array $vo
	 */
	public function _fund($params){
		$id	=	$params['id'];   
	 	if($id>0) {
			$model	= M('ReturnSaleOrderStorage');
            $info['funds']   = $model->field('b.factory_id as comp_id,a.return_sale_order_id as object_id,b.return_sale_order_no as reserve_id,b.returned_date as paid_date,a.outer_pack,a.outer_pack_id,a.outer_pack_quantity,a.within_pack,a.within_pack_id,a.within_pack_quantity,c.warehouse_id,b.sale_order_id')
                    ->join(' as a left join return_sale_order as b on a.return_sale_order_id=b.id 
                            left join return_sale_order_detail c on b.id=c.return_sale_order_id')
                    ->where('a.id='.$id)->find();
            if(empty($info['funds']['warehouse_id'])){
                $info['funds']['warehouse_id']  = $params['warehouse_id'];
            }
            $info['currency_id']            = $info['currency_id']>0 ? $info['currency_id'] : SOnly('warehouse', $info['funds']['warehouse_id'],'w_currency_id');
            $info['funds']['comp_name']		= $this->getCompName($info['funds']);	
    		$info['funds']['basic_id']		= $info['funds']['basic_id'] > 0 ? $info['funds']['basic_id'] : C('MAIN_BASIC_ID');
    		$info['funds']['paid_date']		= !empty($info['funds']['paid_date']) && $info['funds']['paid_date'] != '0000-00-00' ? $info['funds']['paid_date'] : date('Y-m-d');
            $info['funds']['comp_type']		= $this->comp_type;
    		$info['funds']['currency_id']	= $info['currency_id']>0 ? $info['currency_id'] :C('SYS_EURO_ID');
        	$info['funds']['account_money']	= 0;
    		$info['funds']['comments']		= '';
        	$info['funds']['object_type']	= $this->object_type;
    		$info['funds']['relation_type']	= array_search('ReturnSaleOrder', C('FUNDS_RELATED_DOC_MODULE'));//关联单据类型
        	$info['factory_info']			= M('Company')->find($info['funds']['comp_id']);//卖家信息，用于折扣计算
            $sys_pay_class					= C('SYS_PAY_CLASS');
    		$vo['return_sale_order_storage_id']			= $id; 
            //退货单相关费用st add by lxt 2015.09.09
            $return_info  =   M('ReturnSaleOrder')->find($info['funds']['object_id']);
            //处理完成后才生成包装费 add by yyh 20150910
            if ($return_info['return_sale_order_state']==C('PROCESS_COMPLETE')){
                if($info['funds']['outer_pack'] == C('CHANGE_PACK')){
                    $funds_class[]          = 'outerPackFee';
                    $info['outer_pack']     = M('package')->where('id='.$info['funds']['outer_pack_id'])->find();
                }
                if($info['funds']['within_pack'] == C('CHANGE_PACK')){
                    $funds_class[]          = 'withinPackFee';
                    $info['within_pack']    = M('package')->where('id='.$info['funds']['within_pack_id'])->find();
                }
            }

            //状态为已丢弃/处理完成
            if (in_array($return_info['return_sale_order_state'],array(C('DROPPED'),C('PROCESS_COMPLETE'))) && (ACTION_NAME=='updateDeal' || MODULE_NAME == 'OutBatch' || MODULE_NAME == 'ReturnSaleOrder')){
                //款项日期用退货的处理完成日期
                $info['funds']['returned_date'] =   $return_info['returned_date']?$return_info['returned_date']:date('Y-m-d',time());
				//退货处理费
                $params['return_process_fee']   = $this->getProcessFee($info['funds']);
                if (!empty($params['return_process_fee'])){
                    $funds_class[]  =   'returnProcessFee';
                    $info['return_process_fee'] =   $params['return_process_fee'];
                }
                //回邮费
                if ($return_info['return_reason']==C('RETURN_POSTAGE')){
                    $funds_class[]  =   'returnPostageFee';
                    $info['return_postage_fee'] =   $return_info['return_postage_fee'];
                }
                //退货运费
                if ($return_info['is_related_sale_order'] && in_array($return_info['return_reason'],C('RECORD_RETURN_FEE'))){
                    $funds_class[]  =   'returnFee';
                    $express            =   $model
                                            ->alias('a')
                                            ->join('return_sale_order as b on a.return_sale_order_id=b.id')
                                            ->join('sale_order as c on c.id=b.sale_order_id')
                                            ->where('a.id='.$id)
                                            ->field('c.express_detail_id,c.weight')
                                            ->find();
                    $info['express']            =   M('ExpressDetail')->alias('a')->join('express as b on b.id=a.express_id')->field('a.id,a.return_fee,a.step_price,b.shipping_type')->where('a.id='.$express['express_detail_id'])->find();
                    $info['express']['money']   =   $info['express']['return_fee']+$info['express']['step_price']*  ceil(intval($express['weight'])/1000);
                }
                //额外费用
                $funds_class[]  =   'returnAdditionalFee';
                $info['return_additional_fee']  = M('return_sale_order_detail_service')->where('return_sale_order_id='.$info['funds']['object_id'])->getField('sum(price)');
            }

            foreach ((array)$funds_class as $fun_name) {
                $info['funds']['pay_class_id']	= $sys_pay_class[$fun_name];
                $vo['funds'][$fun_name]			= $this->$fun_name($info);
            }
            unset($info);
            return $vo;
		}
	} 
    
    public function outerPackFee($info){
		$funds			= $info['funds'];
		$this->setFundsId($funds);
		if ($info['outer_pack']['id'] > 0) {
			$funds['money']	= $info['outer_pack']['price'] * $funds['outer_pack_quantity'];	//外包装费用
			if ($info['factory_info']['package_discount'] > 0) {
				$funds['money']	*= $info['factory_info']['package_discount'];
			}
            $funds['id']	= $this->_saveFunds($funds);   
			return $funds;  
		} elseif ($funds['id'] > 0) {
			$this->_deleteFunds($funds['id']);
		}
	}
    public function withinPackFee($info){
       	$funds			= $info['funds'];
		$this->setFundsId($funds);
		if ($info['within_pack']['id'] > 0) {
			$funds['money']	= $info['within_pack']['price'] * $funds['within_pack_quantity'];	//内包装费用
			if ($info['factory_info']['package_discount'] > 0) {
				$funds['money']	*= $info['factory_info']['package_discount'];
			}
            $funds['id']	= $this->_saveFunds($funds);   
			return $funds;  
		} elseif ($funds['id'] > 0) {
			$this->_deleteFunds($funds['id']);
		}
    }
    //退货处理费     add by lxt 2015.09.01
    public function returnProcessFee($info){
        $funds  =   $info['funds'];
        $this->setFundsId($funds);
        if(ACTION_NAME != 'delete'){
            $funds['money'] =   $info['return_process_fee'];
            $funds['id']    =   $this->_saveFunds($funds);
        }else{
			$this->_deleteFunds($funds['id']);
        }
        return $funds;
    }

	//获取包装重量
	public function getPackWeight($funds){
		$pack_id				= array();
		$funds['outer_pack'] == C('CHANGE_PACK') && $funds['outer_pack_id'] && $pack_id[]   =   $funds['outer_pack_id'];
		$funds['within_pack'] == C('CHANGE_PACK') && $funds['within_pack_id'] && $pack_id[]   =   $funds['within_pack_id'];
		//是否有更换包装
		if (count($pack_id)>0){
			$pack_detail		= M('Package')->where('to_hide=1 and id in ('.join(',', $pack_id).')')->getField('id,weight');
			//包装总重量
			$pack_weight		= $pack_detail[$funds['outer_pack_id']]*$funds['outer_pack_quantity']+$pack_detail[$funds['within_pack_id']]*$funds['within_pack_quantity'];
		}
		return $pack_weight;
	}
    //计算处理
    public function getProcessFee($funds){
		$factory_id		= $funds['comp_id'];
        $sale_order_id  = (int)$funds['sale_order_id'];
        $warehouse_id   = $funds['warehouse_id'];
        //卖家信息
        $factory_detail = M('CompanyFactory')->alias('b')
							->join('__SALE_ORDER__ a on a.id=' . $sale_order_id)
							->where('b.factory_id='.$factory_id)
							->field('b.is_return_process_fee,if(a.order_type='.C('ALIEXPRESS').',"0",b.return_process_percentage) as return_process_percentage')
							->find();
        //是否需要收取退货处理费
        if ($factory_detail['is_return_process_fee']){
			//包装重量
			$pack_weight			= $this->getPackWeight($funds);
            //产品重量
			$product_detail			= M('return_sale_order_storage_detail')->where('return_sale_order_id='.$funds['object_id'])->select();
            foreach ($product_detail as $value){
                $product_id[]		=   $value['product_id'];
            }
            $product				=   M('Product')->where('to_hide=1 and id in('.join(',', $product_id).')')->field('id, if(check_status=' . C('CHECK_STATUS_PASS') . ', check_weight, weight) as weight')->getField('id,weight');
            //产品总重量
            foreach ($product_detail as $value){
                //如果入库单页面有传产品重量，则用页面专递的值
                $product_weight +=  $value['quantity']*$product[$value['product_id']];
            }
            //总重量
            $total_weight   =   $pack_weight+$product_weight;
            //根据总重量计算退货处理费
            if (intval($total_weight)>0){
                $return_process_fee     =   M('ReturnProcessFee')
                                            ->alias('a')
                                            ->join('return_process_fee_detail b on b.return_process_fee_id=a.id')
                                            ->where('a.warehouse_id='.$warehouse_id.' and weight_begin<='.$total_weight.' and weight_end>='.$total_weight)
                                            ->find();
                //存在对应的重量区间
                if ($return_process_fee){
                    //退货处理费
                    $money          = $return_process_fee['price']+  ceil(($total_weight-$return_process_fee['weight_begin'])/1000)*$return_process_fee['step_price'];
                    //加价百分比
                    $money          *= (1+$factory_detail['return_process_percentage']/100);
                    return $money;
                }
            }
        }
    }
    

    //回邮费用      add by lxt 2015.08.31
    public function returnPostageFee($info){
        $funds  =   $info['funds'];;
        $this->setFundsId($funds);
        if(ACTION_NAME != 'delete'){
            $funds['money'] =   $info['return_postage_fee'];
            $funds['id']    =   $this->_saveFunds($funds);
        }else{
			$this->_deleteFunds($funds['id']);
        }
        return $funds;
    }
    
    /**
     * 退货额外费用
     */
    public function returnAdditionalFee($info){
        $funds				= $info['funds'];
        $this->setFundsId($funds);
        if(ACTION_NAME != 'delete'){
            $funds['money']		= $info['return_additional_fee'];
            $funds['id']		= $this->_saveFunds($funds);
        }else{
			$this->_deleteFunds($funds['id']);
        }
        return $funds;
    }
    
    /**
     * 退货运费
     */
    public function returnFee($info){
        $funds				= $info['funds'];
        $this->setFundsId($funds);
        if(ACTION_NAME != 'delete'){
            $funds['money']		= $info['express']['money'];
            if(in_array($info['express']['shipping_type'], C('SHIPPING_TYPE_EXPRESS'))){
                $express_discount   = M('express_discount')->field('express_discount')->where('factory_id='.$info ['funds']['comp_id'].' and warehouse_id='.$info ['funds']['warehouse_id'])->find();
                if ($express_discount['express_discount'] > 0) {
                    $funds['money']	*= $express_discount['express_discount'];
                }
            }
            $funds['id']		= $this->_saveFunds($funds);
        }else{
			$this->_deleteFunds($funds['id']);
        }
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
	 * 删除退货单
	 *
	 * @param int or array $id
	 * @return unknown
	 */
	public function deleteOp($id,$pay_class=NULL){ 
        $pay_class  && $pay_class   =' and pay_class_id in (' . $pay_class.')';
		$id	=	is_array($id)?$id['id']:$id;
        
        //延续旧数据记录return_sale_order_id为objiect_id
		$id	=	M('returnSaleOrderStorage')->where('id='.$id)->getField('return_sale_order_id');
		//删除退货单欠款
		if($id>0) {
			$paid_id = $this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1'.$pay_class)
			->getField('id',true);
			//款项表ID 
			if (!empty($paid_id)){
				$vo	=	$this->_deleteFunds($paid_id);  
			}
		}  
		return $vo;
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
		if ($this->validCheckAccountDate(formatDate($info['return_order_date'],'vf_date'),$info)===false){ 
			$error['state']	=	-1;
			$error['error_msg'][]	=	$info['return_order_date'].','.L('order_date_chk');//已指定操作,不可删除
		}   
		return $error;
	}
 
	/**
	 * 验证是否可修改
	 *
	 * @param array $info
	 * @return bool
	 */
	public function checkEdit($info){ 
		return $this->checkReturn($info); 
	}
	 
	/**
	 * 验证是否可删除
	 *
	 * @param array $info
	 * @return bool
	 */
	public function checkDelete($info){  
		return $this->checkReturn($info);  
	} 
	
	/**
	 * 验证退货的删除与修改条件
	 *
	 * @param array $info
	 * @return bool
	 */
	private function checkReturn($info){
		$error['state']		=	1;  
		//退货ID
		$id	=	is_array($info)?$info['id']:$info; 
		if ($id>0) {
			//款项信息
			$model		=	M($this->getCompPaidDetail($this->comp_type));
			$paid_info	=	$model->where('object_type='.$this->object_type.' and object_id='.$id)->find();  
			//验证是否被指定支付 
			$error		=	parent::checkDelete($paid_info); 
			//验证是否被总平 
			if ($error['state']!=-1) {   
				$error	=	$this->checkAccountDate($paid_info);	 	
			}
		}else{
			$error['state']			=	-1; 
			$error['error_msg'][]	=	L('error_funds_values_error');//款项验证,参数错误,请重新操作
		} 
		return $error; 
	}
	
}
?>