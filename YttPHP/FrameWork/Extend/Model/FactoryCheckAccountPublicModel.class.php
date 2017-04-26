<?php 
/**
 * 厂家对账
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FactoryCheckAccountPublicModel extends FundsCheckAccountPublicModel {
	
	/// 模型名与数据表名不一致，需要指定
	public $tableName 				= 	'paid_detail';
	///款项类型
	public $object_type				=	229;
	///平账款项类型
	public $object_type_close_out	=	204;
	
	public $onload_object_type		=	221;
	///对象类型
	public $comp_type				=	2;
	///款项类型扩展属性
	public $object_type_extend		=	4;
	///列表查询的表的名字
	public $indexTableName			=	'factory_paid_detail'; 
	  
	
	/**
 	 * 业务规则插入前的验证
 	 *
 	 * @param array $info 表单POST过来的数据
 	 * @return array 错误信息
 	 */ 
	public function checkInsert($info){
 		/// 同一厂家同一币种同一天只能有一笔对帐记录
 		$rs = $this->where(array(	'currency_id' 	=> $info['currency_id'],
 								'object_type'	=> $this->object_type,
 								'paid_date' 	=> $info['paid_date'],
 								'comp_id' 		=> $info['comp_id'],
 								'comp_type' 	=> $this->comp_type,
 								'to_hide'		=> 1)
 								)
 				->find(); 
 		if (is_array($rs)) {
 			$error['state']	=	-1;
			$error['error_msg'][]	=	L('record_repeat');
			return $error;
 		}
 		/// 对账日期不能小于上次的对账日期
 		$max_paid_date = $this->where('to_hide=1 and currency_id='.$info['currency_id'].' and comp_id='.$info['comp_id'].' and comp_type='.$this->comp_type.' 
 						and ( object_type='.$this->object_type.' or (object_type=203 and object_type_extend=3 ))')
 						->max('paid_date'); 	
 		if ($max_paid_date >= formatDate($info['paid_date'])) { 			
 			$error['state']	=	-1;
			$error['error_msg'][]	=	L('check_account_date_error');
			return $error;
 		} 	 	
 		/// 有在路上金额时不可对帐
 		$rs	= $this->where(array('currency_id' => $info['currency_id'],
 									'object_type'	=> $this->onload_object_type, 								
 									'comp_id' 		=> $info['comp_id'],
 									'comp_type' 	=> $this->comp_type,
 									'paid_date'		=> array('0'=>'ELT', formatDate($info['paid_date'])),
 									'to_hide'		=> 1))
 								->find(); 		
 		if (is_array($rs)) {
 			$error['state']	=	-1;
			$error['error_msg'][]	=	L('onload_error');
			return $error;
 		}
 		///验证对账日期不可以在打包过得日期之间
 		if ($error['state']!=-1) {
 			if ($this->checkPaidDateNoInPaidForMiddle($info)==false) {
 				$error['state']		=	-1;
				$error['error_msg'][]	=	L('check_account_date_middle_error');
				return $error;
 			} 
 		} 
	}
	
}