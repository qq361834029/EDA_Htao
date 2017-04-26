<?php 
/**
 * 卖家充值 object_type 103
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author		jph
 * @version 	2.1,2014-08-11
 */
class ClientRechargePublicModel extends AbsFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	public $tableName 				= 'paid_detail';
	///款项类型
	public $object_type				= 103;///卖家充值款项
	///对象类型
	public $comp_type				= 1;
	///对象款项表
	public $object_type_table		= 'client_paid_detail';	
   
 	/**
	 * 卖家充值确认产生的款项
	 *
	 * @param array $info $info['id'] 卖家充值id $info['info'] 页面post来的原始信息
	 * @return array $vo
	 */
	public function _fund($info){
		///获取充值信息
		$funds					= $this->rechargeFunds($info);
		$funds['id']			= $this->_saveFunds($funds);  
		return $funds;
	}
	
	public function rechargeFunds($info){
		$id						= is_array($info) ? $info['id'] : $info;
		///获取充值信息
		$funds					= M('Recharge')->field('money, factory_id as comp_id, id as object_id,"" as reserve_id , currency_id, recharge_date as paid_date, comments,warehouse_id')->where('id='.$id)->find();
		///获取客户名称
		$funds['comp_name']		= $this->getCompName($funds);	
		$funds['basic_id']		= $info['basic_id'] > 0 ? $info['basic_id'] : C('MAIN_BASIC_ID');
		$funds['comp_type']		= $this->comp_type;
		$funds['account_money']	= 0;
		$funds['object_type']	= $this->object_type;
		$funds['relation_type']	= 0;//关联单据类型	
		$funds['paid_type']		= 3;
		//确认金额存在时，用确认金额，确认币种，确认日期,注意事项，原币种用确认币种
		if(!empty($info['confirm_money'])) {
			$funds['currency_id']	= $info['confirm_currency_id'];
			$funds['money']	= $info['confirm_money'];
			$funds['paid_date']	= $info['confirm_date'];
			$funds['comments']	= $info['confirm_comments'];
		}
		return $funds;
	}

		/**
	 * 删除卖家充值款项
	 *
	 * @param int $id
	 * @return array
	 */
	public function deleteOp($id){   
		///删除卖家充值款项
		if($id>0) {
			$paid_id = $this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1')
			->getField('id', true); 
			///款项表ID
			if (count($paid_id)>0){
				$vo	= $this->_deleteFunds($paid_id);  
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
		return	$this->checkPaidDate($info,'paid_date');  
	}	
	
	 
	/**
	 * 查看款项信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function fundInfo($id){ 
		///查看款项信息
		if($id>0) {
			$info = _formatArray($this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1')
			->find());  
			return $info;
		}
	}	
}
?>