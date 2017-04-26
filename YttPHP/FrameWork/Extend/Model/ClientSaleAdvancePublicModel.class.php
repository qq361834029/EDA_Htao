<?php 
/**
 * 销售单预付款 object_type 103 
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class ClientSaleAdvancePublicModel extends AbsFundsPublicModel {
	///款项类型
	public $object_type			=	121;///客户销售单预付款
	///预收款->款项类型
	public $object_type_sale	=	120;
	///对象类型
	public $comp_type			=	1;	///客户类型
  
	 
	/**
	 * 销售产生的款项
	 *
	 * @param array $info $info['id'] 销售单号 $info['info'] 页面post来的原始信息
	 * @return array $vo
	 */
	public function _fund($info){
		$sale_id		=	$info['sale_id']; 
		///获取销售单主表信息,组合付款的信息
		$info['funds']	=	M('SaleOrder')->where('id='.$sale_id)->field('sale_order_state,basic_id,currency_id,date(order_date) as paid_date,client_id as comp_id,id as object_id,sale_order_no as reserve_id')->find();
		///获取客户名称
		$info['funds']['comp_name']	= $this->getCompName($info['funds']);
		///格式化页面来的信息	 
		$paid_info		=	$this->formatAdvance($info);
		///查找历史预付款ID
		$old_id			=	$this->getBeforPaidIdArray($sale_id);  
		///删除历史预付款
		if(count($old_id)>0) {
			$this->_deleteFunds($old_id);   
		}
		///根据销售单状态给予预付款是否能使用的状态
		$state	= $info['funds']['sale_order_state']==3?1:0;
		///插入新预付款信息  
		foreach ((array)$paid_info as $key=>$row) {  
			$row['state']	=	$state;    
			$vo[]			= $this->_saveFunds($row);
		}   
		return $vo;
	}
	
	/**
	 * 删除款项
	 *
	 * @param int $id 销售单ID
	 * @return array
	 */
	public function deleteOp($id){ 
		///流程ID
		if($id>0) {
			$model	=	M($this->getCompPaidDetail($this->comp_type));
			$paid_id = $model
			->where('object_id='.$id.' and object_type='.$this->object_type.' ') 
			->group('object_id')
			->getField('group_concat(paid_id)');   
			///款项表ID
			if (!empty($paid_id)){
				$vo	=	$this->_deleteFunds($paid_id);  
				return $vo;
			}
		} 
	} 
	
	/**
	 * 格式化整理页面Post传递来的数据整理成paid_detail需要的数据格式
	 *
	 * @param array $info
	 * @return array
	 */
	public function formatAdvance($info){  
		$funds	=	$info['funds'];  
		///对页面多种款项支付时没有点击"新增"的特殊处理
		$this->beforFormatAdvance($info);    
		if(is_array($info['advance']['cash'])) {
			foreach ((array)$info['advance']['cash'] as $key=>$row) {
				if(is_array($row)) { 
					$row['basic_id']	=	$funds['basic_id'];	///所属公司
					$row['currency_id']	=	$funds['currency_id'];///币种
					$row['paid_date']	=	$funds['paid_date'];///日期
					$row['paid_type']	=	1;///现金
					$row['comp_id']		=	$funds['comp_id'];///客户ID
					$row['comp_type']	=	$this->comp_type;///客户类型
					$row['comp_name']	=	$funds['comp_name'];///客户名称
					$row['object_type']	=	$this->object_type;///款项类型
					$row['object_id']	=	$funds['object_id'];///销售单ID
					$row['reserve_id']	=	$funds['reserve_id'];///关联ID  
					$paid_info[]	=	$row;								    
				}
			}						
		}
		if(is_array($info['advance']['bill'])) {
			foreach ((array)$info['advance']['bill'] as $key=>$row) {
				if(is_array($row)) { 
					$row['basic_id']	=	$funds['basic_id'];	///所属公司
					$row['currency_id']	=	$funds['currency_id'];///币种
					$row['paid_date']	=	$funds['paid_date'];///日期
					$row['bill_date']	=	$row['bill_date'];///日期
					$row['paid_type']	=	2;///支票
					$row['comp_id']		=	$funds['comp_id'];///客户ID
					$row['comp_type']	=	$this->comp_type;///客户类型
					$row['comp_name']	=	$funds['comp_name'];///客户名称
					$row['object_type']	=	$this->object_type;///款项类型
					$row['object_id']	=	$funds['object_id'];///销售单ID
					$row['reserve_id']	=	$funds['reserve_id'];///关联ID  
					$paid_info[]	=	$row;								    
				}
			}						
		}
		if(is_array($info['advance']['transfer'])) { 
			foreach ((array)$info['advance']['transfer'] as $key=>$row) {
				if(is_array($row)) { 
					$row['basic_id']	=	$funds['basic_id'];	///所属公司
					$row['currency_id']	=	$funds['currency_id'];///币种
					$row['paid_date']	=	$funds['paid_date'];///日期
					$row['paid_type']	=	3;///转账
					$row['comp_id']		=	$funds['comp_id'];///客户ID
					$row['comp_type']	=	$this->comp_type;///客户类型
					$row['comp_name']	=	$funds['comp_name'];///客户名称
					$row['object_type']	=	$this->object_type;///款项类型
					$row['object_id']	=	$funds['object_id'];///销售单ID
					$row['reserve_id']	=	$funds['reserve_id'];///关联ID 
					$paid_info[]	=	$row;
				}								    
			}						
		}  
		return $paid_info;
	}
	
	
	/**
	 * 对页面多种款项支付时没有点击"新增"的特殊处理
	 *
	 * @param array $info
	 * @return array
	 */
	public function beforFormatAdvance(&$info){   
 		$post	= &$info['advance']['post'];   
		if ($post['pay_paid_type']>0){
			switch ($post['pay_paid_type']){
				case 1:
					if (moneyFormat($post['pay_cash_money'],1)>0){
						$info['advance']['cash']['sys_add']	=	array(
																'money'			=>$post['pay_cash_money'],
																'paid_date'		=>$post['pay_cash_paid_date'],
																'comments'		=>$post['pay_cash_comments'],);
					}
					break;
				case 2:
					if (moneyFormat($post['pay_bill_money'],1)>0){
						$info['advance']['bill']['sys_add']	=	array(
																'money'			=>$post['pay_bill_money'],
																'paid_date'		=>$post['pay_bill_paid_date'],
																'comments'		=>$post['pay_bill_comments'],
																'bill_no'		=>$post['pay_bill_bill_no'],
																'bill_date'		=>$post['pay_bill_bill_date'],);
					}
					break;
				case 3:
					if (moneyFormat($post['pay_transfer_money'],1)>0){
						$info['advance']['transfer']['sys_add']	=	array(
																'money'				=>$post['pay_transfer_money'],
																'paid_date'			=>$post['pay_transfer_paid_date'],
																'comments'			=>$post['pay_transfer_comments'],
																'bank_id'			=>$post['pay_transfer_bank_id'],);
					}
					break;		
			}
		}
	}
	  
	/**
	 * 销售单预付款信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function fundInfo($id){ 
		if($id>0) { 
			///销售单预付款信息
			$info = _formatList($this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1')
			->select());  
		}else{
			return true;
		}
		
		if(is_array($info['list'])) {
			///支票 转账信息
			$bank_center	=	M('BankCenter');
			$bank			=	_formatList($bank_center->where('paid_object_type='.$this->object_type.' and to_hide=1 and bank_object_id='.$id.' ')->select());  
			
			foreach ((array)$bank['list'] as $key=>$row) {
			     $bill_transfer[$row['paid_id']]	=	$row;
			}  
			///划分预付款支付类型
			$advance_type	=	array(1=>'cash',2=>'bill',3=>'transfer');
			
		 	foreach ((array)$info['list'] as $key=>$row) { 
		 		$row['bank_center']	=	$bill_transfer[$row['id']];
		    	$advance[$advance_type[$row['paid_type']]][]	=	$row;
			}
		}     
		return $advance;
	}
	
	/**
	 * 获取预付款总金额
	 *
	 * @param int $id 销售单ID
	 * @return array 预付款总金额
	 */
	public function getAdvanceTotalMoney($id){
			///销售单欠款
			if ($id>0){
				$info = _formatArray($this
				->field('sum(money+account_money) as money')->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1')
				->find());   
				return $info; 			
			} 
	}
	  
}
?>