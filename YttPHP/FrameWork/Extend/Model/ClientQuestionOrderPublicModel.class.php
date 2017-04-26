<?php 
/**
 * 退货单款项
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class ClientQuestionOrderPublicModel extends AbsFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	public $tableName 				= 'paid_detail';
	//款项类型
	public $object_type				=	125;//问题订单应收
    public $received_object_type    =	126;//问题订单已收
	//对象类型
	public $comp_type				=	1;
	//对象款项表
	public $object_type_table		=	'client_paid_detail';	
   
	/**
	 * 问题订单产生的款项
	 *
	 * @param array $id 退货单ID
	 * @return array $vo
	 */
	public function _fund($params){
		$id	=	$params['id'];   
	 	if($id>0) {
			$model	= M('QuestionOrder');
            $info['funds']   = $model->field('factory_id as comp_id,id as object_id,question_order_no as reserve_id,warehouse_id,proof_delivery_fee,compensation_fee,compensation_date')
                    ->where('id='.$id)->find();
            if(empty($info['funds']['warehouse_id'])){
                $info['funds']['warehouse_id']  = $params['warehouse_id'];
            }
            $info['currency_id']            = $info['currency_id']>0 ? $info['currency_id'] : SOnly('warehouse', $info['funds']['warehouse_id'],'w_currency_id');
            $info['funds']['comp_name']		= $this->getCompName($info['funds']);	
    		$info['funds']['basic_id']		= $info['funds']['basic_id'] > 0 ? $info['funds']['basic_id'] : C('MAIN_BASIC_ID');
    		$info['funds']['paid_date']		= !empty($info['funds']['paid_date']) ? $info['funds']['paid_date'] : date('Y-m-d');
    		$info['funds']['comp_type']		= $this->comp_type;
    		$info['funds']['currency_id']	= $info['currency_id']>0 ? $info['currency_id'] :C('SYS_EURO_ID');
        	$info['funds']['account_money']	= 0;
    		$info['funds']['comments']		= '';
        	$info['funds']['object_type']	= $this->object_type;
    		$info['funds']['relation_type']	= array_search('QuestionOrder', C('FUNDS_RELATED_DOC_MODULE'));//关联单据类型
        	$info['factory_info']			= M('Company')->find($info['funds']['comp_id']);//卖家信息，用于折扣计算
            $sys_pay_class					= C('QUESTION_SYS_PAY_CLASS');
    		$vo['question_order_id']        = $id; ///销售单ID 
            if($params['process_mode'] == C('UPLOADED_PROOF')){
                //签收证明费用
                $funds_class[]  = 'proofDeliveryFee';
            }
            if($params['process_mode'] == C('HAS_COMPENSATION')){
                //赔偿费用
                $funds_class[]  = 'compensationFee';
            }
            foreach ((array)$funds_class as $fun_name) {
                $info['funds']['pay_class_id']	= $sys_pay_class[$fun_name];
                $vo['funds'][$fun_name]			= $this->$fun_name($info);
            }
            unset($info);
            return $vo;
		}
	} 
    
    /**
     * @name 问题订单签收证明费用
     * @author added by yyh 20150425
     * @param array $info
     * @return array
     */
    public function proofDeliveryFee($info){  
		$funds				= $info['funds'];
        $this->setFundsId($funds);
        $funds['money']		= $info['funds']['proof_delivery_fee'];
		$funds['id']		= $this->_saveFunds($funds); 
		return $funds;  
    }
    
    /**
     * @name 问题订单赔偿金
     * @author added by yyh 20150425
     * @param array $info
     * @return array
     */
    public function compensationFee($info){  
        $info['funds']['object_type']	= $this->received_object_type;
		$funds				= $info['funds'];
        $funds['paid_date'] = $funds['compensation_date'];
        unset($funds['compensation_date']);
        $this->setFundsId($funds);        
        $funds['money']		= $info['funds']['compensation_fee'];
		$funds['id']		= $this->_saveFunds($funds); 
		return $funds;  
    }
    
    /**
	 * 设置款项id
	 * @param array $funds
	 */
	public function setFundsId(&$funds){
		$funds_id	= $this->table($this->object_type_table)->where('object_id=' . $funds['object_id'] . ' and object_type=' . $funds['object_type'] . ' and pay_class_id=' . $funds['pay_class_id'])->getField('paid_id');
		if ($funds_id > 0) {
//			unset($funds['paid_date']);
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
		$return_info	=	M('QuestionOrderDel')->where('id='.$id)->find();  
		//删除退货单欠款
		if($id>0) {
			$paid_id = $this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type in ('.$this->object_type.','.$this->received_object_type.') and to_hide=1'.$pay_class)
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
			$paid_info	=	$model->where('object_type in ('.$this->object_type.','.$this->received_object_type.') and object_id='.$id)->find();  
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