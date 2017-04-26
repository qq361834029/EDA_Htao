<?php 
/**
 * 客户/厂家/物流对款项账公共类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FundsCheckAccountPublicModel extends AbsFundsPublicModel {
	
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 			= 	'paid_detail';
	///款项类型
	public $object_type				=	329;
	///平账款项类型
	public $object_type_close_out	=	304;
	///对象类型
	public $comp_type				=	3;
	///款项类型扩展属性
	public $object_type_extend		=	4;
	///列表查询的表的名字
	public $indexTableName			=	'logistics_paid_detail'; 
	 
	/// 自动验证设置
	protected $_validate	 =	 array(
										array("paid_date",'require',"require",1), 
										array("comp_id",'require',"require",1), 
										array("basic_id",'require',"require",0), 						
										array("currency_id",'pst_integer',"require",1), 
										array("money",'require',"require",1), 
										array("money",'money',"money_error",1), 	
	);  
	
	/**
	 * 处理物流应收款对账(插入/修改);
	 *
	 * @param array $info
	 * @return array
	 */
	public function _fund($info){ 
		$this->_beforeFund($info);  
		///object_type_extend 默认为0 1,为指定支付但是没有平账 2为指定支付且平账 3为总平账包括物流对账 4对账
		$info['object_type_extend']	=	$this->object_type_extend;  
		///对账平帐损失信息 
		///$close_out			=	array('funds'=>$info,'paid_info'=>$paid_for,'object_type_extend'=>$this->object_type_extend);	
		 $close_out			=	array('funds'=>$info,'paid_info'=>array(),'object_type_extend'=>$this->object_type_extend);	
		$fundsCloseOut		=	$this->CloseOut($close_out); 
		if(is_array($fundsCloseOut) && $fundsCloseOut['id']>0) {
			$paid_for[]	=	$fundsCloseOut['id'];
			///平帐的所有被打包的ID
			if (is_array($fundsCloseOut['extend_paid_id'])){
				$paid_for	=	array_merge($paid_for,$fundsCloseOut['extend_paid_id']);
				$paid_for	=	array_unique($paid_for);///移除重复的paid_id的信息
			} 
		} 
		
		///打包paid_for信息
		if(count($paid_for)>1 && $this->object_type_extend>0) {   
			///绑定记录  
 			$insert_paid_for	=	$this->addPaidFor($this->comp_type,$paid_for,$info['currency_id']);   
 			if ($this->object_type_extend>1){
 				$operate_id	=	$insert_paid_for[0]['operate_id'];
 				///更改paid_detail中指定支付的打包关系记录在OperateId字段当中 
 				$this->updateOperateId($insert_paid_for,true,'','operate_id=""');
 			} 
		}   
		/**
		 * 特殊处理
		 */
		$info['reserve_id']		=	$operate_id; 
///		$info['object_id']		=	1; ///如果是对账关联产生损失的ID
		$info['object_id']		=	$fundsCloseOut['id']; ///如果是对账关联产生损失的ID
		///插入对账信息  
		$paid_id				= $this->_saveFunds($info);    
		return $paid_id;
	}
	  
	/**
	 * 不制定某日期之前的对账
	 *
	 * @param array $info
	 * @return array
	 */
	public function CloseOut($info){
		return Funds($info,$this->object_type_close_out);
	} 
	
	/**
	 * 删除
	 *
	 * @param int $id
	 */
	/**
	 * 删除
	 *
	 * @param int $id
	 * @return bool
	 */
	public function deleteOp($id){  
		return $this->_deleteCheckAccountFunds($id); 
	} 
	
}