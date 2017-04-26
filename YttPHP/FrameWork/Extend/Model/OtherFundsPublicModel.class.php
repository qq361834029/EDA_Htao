<?php 
/**
 * 其他收入/支出款项公共类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class OtherFundsPublicModel extends AbsFundsPublicModel { 
	
	///列表查询的表的合计distinct对应的值
	public $indexCountPk	= 'id';  
	/// 模型名与数据表名不一致，需要指定
	public $tableName 		= 	'paid_detail';
	///款项类型
	public $object_type		=	'';///客户其他应收款
	///对象类型
	public $comp_type		=	0;
   
	/// 自动验证设置
	protected $_validate	 =	 array( 
					array("basic_id",'require',"require",1), 
					array("pay_class_id",'require',"require",1), 
					array("comp_id",'validObjectFundsInfo','require',1,'callbacks'), 	 
			); 
			
	public $_cash	=	array(
				array("pay_cash_currency_id",'require',"require",1),   
				array("pay_cash_money",'require',"require",1),
				array("pay_cash_money",'money','double',1),      
				array("pay_cash_paid_date",'require',"require",1),  
	);
	
	public $_bill	=	array(
				array("pay_bill_currency_id",'require',"require",1),   
				array("pay_bill_bill_no",'require',"require",1),      
				array("pay_bill_bill_no",'require',"unique",1,'bill_no'),      
				array("pay_bill_money",'require',"require",1),     
				array("pay_bill_money",'money',"double",1),      
				array("pay_bill_paid_date",'require',"require",1), 
				array("pay_bill_bill_date",'require',"require",1),   
	);
	
	public $_transfer	=	array(
				array("pay_transfer_bank_id",'require',"require",1),     
				array("pay_transfer_money",'require',"require",1),     
				array("pay_transfer_money",'money',"double",1),     
				array("pay_transfer_paid_date",'require',"require",1),   
	);	 
	
	
	/**
	 * 提交表单验证
	 *
	 * @param array $data
	 * @return array
	 */
	public function validObjectFundsInfo($data){     
			$detailFundsArray	=	array(
											1=>'_cash',
											2=>'_bill',
											3=>'_transfer', 
											);   
			$detailFunds	=	$detailFundsArray[$_POST['pay_paid_type']];
			if (!empty($detailFunds)){   
				return	$this->_validSubmit($_POST,$detailFunds);   
			}   
	}
	
	/**
	 * 其他支出(插入/修改);
	 *
	 * @param array $info
	 * @return array
	 */
	public function _fund($info){     
		$info['paid_type']	=	$info['pay_paid_type'];   
		$this->_beforeFund($info); 
		$vo					=	$this->_saveFunds($info); 
		return $vo;
	}
	
	/**
	 * 格式化页面来的信息
	 *
	 * @param array $info
	 * @return array
	 */
	public function formatOtherFunds(&$info){ 
 		$info['paid_type']	=	$info['pay_paid_type'];
		switch ($info['paid_type']){
			case 1:///现金
				$info['money']		=	$info['pay_cash_money'];
				$info['paid_date']	=	$info['pay_cash_paid_date'];
				$info['currency_id']=	$info['pay_cash_currency_id'];
				$info['comments']	=	$info['pay_cash_comments'];
				break;
			case 2:
				$info['currency_id']=	$info['pay_bill_currency_id'];
				$info['bill_no']	=	$info['pay_bill_bill_no'];
				$info['money']		=	$info['pay_bill_money'];
				$info['bill_date']	=	$info['pay_bill_bill_date'];
				$info['paid_date']	=	$info['pay_bill_paid_date'];
				$info['comments']	=	$info['pay_bill_comments'];
				break;
			case 3:
				$info['bank_id']	=	$info['pay_transfer_bank_id'];
				$info['money']		=	$info['pay_transfer_money']; 
				$info['paid_date']	=	$info['pay_transfer_paid_date'];
				$info['comments']	=	$info['pay_transfer_comments'];
				break;		 
		}
		///需要去除页面中POST中的信息
		$unset	=	array(
							'pay_cash_money',
							'pay_cash_currency_id',
							'pay_cash_paid_date',
							'pay_cash_comments',
							'pay_bill_currency_id',
							'pay_bill_bill_no',
							'pay_bill_money',
							'pay_bill_bill_date',
							'pay_bill_paid_date',
							'pay_bill_comments',
							'pay_transfer_bank_id',
							'pay_transfer_money',
							'pay_transfer_paid_date',
							'pay_transfer_comments', 
		);
		foreach ((array)$unset as $key=>$row) {
		    unset($info[$row]);
		} 
		return $info;
	}  
	 
	/**
	 * 删除其他支出
	 *
	 * @param int $id
	 * @return array
	 */
	public function deleteOp($id){  
		$id	=	is_array($id)?$id['id']:$id; 
		if ($id>0){
			$vo	=	$this->_deleteFunds($id); 
		} 
		return $vo;
	} 
	
}