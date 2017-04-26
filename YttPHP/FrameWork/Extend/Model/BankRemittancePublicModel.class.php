<?php  
/**
 * 银行期初款项
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class BankRemittancePublicModel extends AbsBankPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 				= 	'bank_center';
	///银行类型
	public $bank_object_type			=	3;///银行期初存款
	///对象类型
	public $comp_type					=	0;
	///转回国内费用
	public $paid_detail_pay_class_id	=	1;
	public $paid_object_type			=	1003;
	public $other_funds_object_type		=	800;

	public $indexTableName			=	'bank_center'; ///列表查询的表的名字
	
	public $bank_no_fix				=	'HK';///银行汇款
  
	 
	/// 自动验证设置
	protected $_validate	 =	 array(
										array("out_bank_id",'require',"require",1), 
										array("in_bank_id",'require',"require",1), 
										array("currency_id",'require',"require",1), 
										array("delivery_date",'require',"require",1),
										array("quantity",'require',"require",1),			///笔数		
										array("quantity",'pst_integer',"pst_integer",1),	///笔数		
										array("money",'require',"require",1),
										array("money",'money',"money_error",1),
										array("other_cost",'money',"money_error",2), 	
	); 
 
  
	/**
	 * 银行汇款
	 *
	 * @param array $info  页面传递来的数据
	 * @return array
	 */
	public function _fund($info){      
			///转出的笔数
			$quantity	=	$info['quantity'];
			unset($info['quantity']); 
			///获取绑定的流水单号  
			$bank_no	=	$this->getBankNo($this->bank_object_type,$this->bank_no_fix,$info['delivery_date']);
			for ($i = 1; $i <= $quantity; $i++) { 
				///插入汇款转出
				$out_info					= $info;
				$out_info['bank_id']		= $info['out_bank_id'];
				$out_info['relevance_cash']	= $info['out_bank_id']>0?2:1;
				$out_info['income_type']	= -1;
				$out_info['bank_no']		= $bank_no;
				$out_info['reserve_id']		= $bank_no;
				$out_info['currency_id']	= $info['currency_id'];
				if($out_info['bank_id']>0){
					$out_info['paid_type']	= 3;
				}else{
					$out_info['paid_type']	= 1;
				}
				$this->_beforeFund($out_info);
				$out_info['id']				= $this->_saveFunds($out_info);    
				
				///插入汇款转入 
				$in_info					= $info;
				$in_info['bank_id']			= $info['in_bank_id'];
				$in_info['relevance_cash']	= $info['in_bank_id']>0?2:1;
				$in_info['income_type']		= 1; 
				$in_info['bank_no']			= $bank_no;
				$in_info['reserve_id']		= $bank_no;
				$in_info['currency_id']		= $info['currency_id'];
				if($in_info['bank_id']>0){
					$in_info['paid_type']	= 3;
				}
				else{
					$in_info['paid_type']	= 1;
				}
				$this->_beforeFund($in_info);
				$in_info['id']				= $this->_saveFunds($in_info);    
			}
			
			///其他支出
			if ($info['other_cost']>0){
				$otherFunds		=	array(
											'paid_type'=>1,
											'basic_id'=>C('DEFAULT_BASIC_ID'),
											'pay_class_id'=>$this->paid_detail_pay_class_id,
											'is_cost'		=>1,
											'pay_paid_type'	=>1,
											'money'=>$info['other_cost']*$quantity,
											'paid_date'=>$info['delivery_date'],
											'paid_date'=>$info['delivery_date'],
											'currency_id'=>$info['currency_id'],
											'reserve_id'=>$bank_no,
											'comments'=>$info['comments'],
				);
				$otherFundsInfo	=	Funds($otherFunds,$this->other_funds_object_type);
			}
			return array('in'=>$in_info,'out'=>$out_info);
	}
	
	/**
	 * 删除款项
	 *
	 * @param int $id 银行中心ID
	 * @return array
	 */
	public function deleteOp($id){ 
		///获取汇款的关联ID 
		$info = $this
		->where('bank_object_type='.$this->bank_object_type.' and reserve_id in 
		( select reserve_id from bank_center where to_hide=1 and bank_object_type='.$this->bank_object_type.' and id='.$id.' and reserve_id is not null ) and to_hide=1')
		->select(); 
		if (is_array($info)){
			foreach ($info as $key=>$row) {
				if($row['id']>0) {  
					$vo	=	$this->_deleteFunds($row['id']);  
				}
			}
			$bank_no	=	$info[0]['bank_no'];
			if (!empty($bank_no)){
				///删除其他支出
				$otherFunds	=	M('paid_detail')->where('reserve_id=\''.$bank_no.'\'')->find(); 
				if (is_array($otherFunds)){ 
					$otherFundsInfo	=	Funds($otherFunds,$this->other_funds_object_type,'delete');
				} 
			}
		}
		return true;
	}
	
	/**
	 * 列表
	 *
	 * @return array
	 */
	public function indexSql(){  
		///特殊处理
		if ($_POST['out_bank_id']>0 || $_POST['in_bank_id']>0){
			empty($_POST['out_bank_id'])	&&	$_POST['out_bank_id']	=	-1;
			empty($_POST['in_bank_id'])		&&	$_POST['in_bank_id']	=	-1;
///			$defWhere	.=	' and bank_id in ('.$_POST['out_bank_id'].','.$_POST['in_bank_id'].') '; 
			if ($_POST['out_bank_id']<0 || $_POST['in_bank_id']<0){ 
					$_POST['out_bank_id']>0	&& $defWhere	.=' and income_type=-1 and bank_id='.$_POST['out_bank_id'];
					$_POST['in_bank_id']>0	&& $defWhere	.=' and income_type=1 and bank_id='.$_POST['in_bank_id'];
			}else{ 
					$defWhere	=' and bank_id='.$_POST['out_bank_id'].' and income_type=-1  and reserve_id in ( select reserve_id from bank_center where '._search().' and bank_object_type=3 and to_hide=1 and state=2 and  bank_id='.$_POST['in_bank_id'].' and income_type=1 )'; 
			}
			$info['field']	=	' * ,(count(id)) as quantity,(count(id))*money as real_money';
		}else{
			$info['field']	=	' * ,(count(id)/2) as quantity,(count(id)/2)*money as real_money';
		}   
		$info['from']	=	$this->indexTableName?$this->indexTableName:$this->tableName;
		$info['extend']	=	' WHERE  '._search().$this->fundsWhere().$defWhere.' and to_hide=1 group by bank_no order by delivery_date desc,id desc';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count	=	0;
		$sql_count	= ' select count(*) as count from (
		select count(id) as counta '.' from '.$info['from'].' WHERE  '._search().$this->fundsWhere().$defWhere.' and to_hide=1 group by bank_no
		) as a
		';
		$list	=	$this->query($sql_count);
		$count	=	$list[0]['count'];
		$info['sql']	=	$sql;
		$info['count']	=	$count;
		return $info;
	}  
	
	
	/**
	 * 根据SQL语句获取数据
	 *
	 * @param array $limit
	 * @param string $sql
	 * @return array
	 */
	function indexList($limit,$sql){ 
		$list	= _formatList($this->db->query($sql._limit($limit)));  
		foreach ((array)$list['list'] as $key=>$value) { 
			$income_type	=	$value['income_type'];
		    $bank_no[]	=	'\''.$value['bank_no'].'\'';
		}  
		$income_type	=	$income_type*-1; 
		if (is_array($bank_no)){
			$sql		=	' select bank_id,bank_no from bank_center where bank_no in ('.join(',',$bank_no).') and income_type='.$income_type.' and to_hide=1 group by bank_no ';
			$newList	=	_formatList($this->query($sql));
			foreach ((array)$newList['list'] as $key=>$value) {
		   	 	$Inbank[$value['bank_no']]	=	$value;
			}  
			$paidDetailSql		=	' select money,reserve_id from paid_detail where reserve_id in ('.join(',',$bank_no).') and reserve_id is not null and object_type='.$this->other_funds_object_type.' and pay_class_id='.$this->paid_detail_pay_class_id.' group by id ';
			$paidDetailInfo		=	$this->query($paidDetailSql);
			foreach ((array)$paidDetailInfo as $key=>$value) {
		   	 	$otherMoney[$value['reserve_id']]	=	$value['money'];
			} 
			foreach ((array)$list['list'] as $key=>$value) {  
				if ($value['income_type']==-1){
					$list['list'][$key]['in_bank_name']		=	$Inbank[$value['bank_no']]['bank_name'];
				}else{ 
					$list['list'][$key]['in_bank_name']		=	$value['bank_name'];
					$list['list'][$key]['bank_id']			=	$Inbank[$value['bank_no']]['bank_id'];
				} 
		   	 	$list['list'][$key]['other_money']		=	isset($otherMoney[$value['bank_no']])?$otherMoney[$value['bank_no']]/$value['quantity']:0;
		   	 	$list['list'][$key]['sum_other_money']	=	isset($otherMoney[$value['bank_no']])?$otherMoney[$value['bank_no']]:0;
			} 
		}
		$list	=	_formatList($list['list']);
		return $list;
	}
}