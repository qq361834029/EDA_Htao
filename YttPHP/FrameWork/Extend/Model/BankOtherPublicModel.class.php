<?php 
/**
 * 其他转入
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class BankOtherPublicModel extends AbsBankPublicModel {
	
	///对象类型
	public $object_type	=	4;///其他转入 
   
	/**
	 * 插入支票/转账信息
	 *
	 * @param array $info paid_detail中的数据
	 * @return array
	 */
	public function _fund($info){      
			///支票
			if($info['paid_type']==2) {
				$info['bank_date']			=	$info['bill_date']; 
				$info['state']				=	1;	///未确认
			}else{
				$info['bank_date']			=	$info['paid_date'];
				$info['delivery_date']		=	$info['paid_date'];///实际到账日期
				$info['state']				=	2;	///直接确认
			} 
			$info['income_type']		=	1;
			///支出/收入类型 800=>其他支出	203=>转出给厂家 303=>转出给物流
			if (in_array($info['object_type'],array(800,203,303))) {
				$info['income_type']	=	-1;
			}  
			///特殊处理对于转账的记录到银行的地方重新通过银行分配币种
			if ($info['paid_type']==3 && $info['bank_id']>0){ 
///				$info['currency_id']	=	$bank_currency_array[$info['bank_id']];
				$info['currency_id']	=	SOnly('bank_currency',$info['bank_id'],'currency_id');
			}  
			$info['paid_object_type']	=	$info['object_type']; 
			$info['bank_object_type']	=	$this->object_type;
			$info['bank_object_id']		=	$info['object_id'];   
			
			$info['id']			= $this->_saveFunds($info);  
			return $info; 
	}
	
	/**
	 * 更新支票信息
	 *
	 * @param array $info
	 * @return array
	 */
	public function updateBill($info){
		$info['id']			= $this->_saveFunds($info);  
		return $info; 
	} 
}
?>