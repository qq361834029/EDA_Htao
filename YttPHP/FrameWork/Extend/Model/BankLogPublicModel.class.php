<?php
/**
 * 银行存取
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-12-03
*/

class BankLogPublicModel extends AbsBankPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 				= 'bank_center';
	///银行类型
	public $bank_object_type			= 2;///银行存取款
	///对象类型
	public $comp_type					= 0;
	///转回国内费用
	public $paid_detail_pay_class_id	= 1;
	public $paid_object_type			= 1002;
    public $other_funds_object_type		= 800;//added by jp 20131217
	public $indexTableName			= 'bank_center'; ///列表查询的表的名字
	public $bank_no_fix				= 'CQ';///银行汇款
	 
	/// 自动验证设置
	protected $_validate	 =	 array(
										array("currency_id",'require',"require",1),
										array("delivery_date",'require',"require",1),
										array("relevance_cash",'require',"require",1),
										array("bank_id","relevance_cash",'require',0,'ifcheck','',1),
										array("money",'require',"require",1),
										array("money",'money',"money_error",1),
                                        array("other_cost",'money',"money_error",2), 
	);

	
	/**
	 * 插入银行款项信息
	 *
	 * @param array $info
	 * @return array
	 */
	public function _fund($info){  
        $bank_no	=	$this->getBankNo($this->bank_object_type,$this->bank_no_fix,$info['delivery_date']);
        $info['bank_no']		= $bank_no;
        $info['reserve_id']		= $bank_no;        
		$vo		= $this->_saveFunds($info);
        ///其他支出
        if ($info['other_cost']>0){//added by jp 20131217
            $otherFunds		=	array(
                                        'paid_type'=>1,
                                        'basic_id'=>C('DEFAULT_BASIC_ID'),
                                        'pay_class_id'=>$this->paid_detail_pay_class_id,
                                        'is_cost'		=>1,
                                        'pay_paid_type'	=>1,
                                        'money'=>$info['other_cost'],
                                        'paid_date'=>$info['delivery_date'],
                                        'paid_date'=>$info['delivery_date'],
                                        'currency_id'=>$info['currency_id'],
                                        'reserve_id'=>$bank_no,
                                        'comments'=>$info['comments'],
            );
            $otherFundsInfo	=	Funds($otherFunds,$this->other_funds_object_type);        
        }
		return $vo;
	}

    /**
	 * 列表
	 *
	 * @return array
	 */
	public function indexSql(){ 
		$info['field']	=	' *,income_type as save_draw_type,if(income_type>0,money,0) as income_money,if(income_type<0,money,0) as outlay_money ';
		$info['from']	=	$this->indexTableName?$this->indexTableName:$this->tableName;
		$info['extend']	=	' WHERE  '._search().$this->fundsWhere().' order by delivery_date desc,id desc';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count	=	0;
		$sql_count	= 'select count(distinct('.$this->indexCountPk.')) as count '.' from '.$info['from'].' WHERE  '._search().$this->fundsWhere().' ';
		$list	=	$this->query($sql_count);
		$count	=	$list[0]['count'];
		$info['sql']	=	$sql;
		$info['count']	=	$count;
		return $info;
	}
    

	/**
	 * 根据SQL语句获取数据
	 *
	 * @param $limit
	 * @param $sql
	 * @return array
	 */
	function indexList($limit,$sql){ 
		$list	= _formatList($this->db->query($sql._limit($limit))); 
		foreach ((array)$list['list'] as $key=>$value) { 
		    if ($value['bank_no']) {
                $bank_no[]	=	'\''.$value['bank_no'].'\'';
            }
		}  
		if (is_array($bank_no)){
			$paidDetailSql		=	' select money,reserve_id from paid_detail where reserve_id in ('.join(',',$bank_no).') and reserve_id is not null and object_type='.$this->other_funds_object_type.' and pay_class_id='.$this->paid_detail_pay_class_id.' group by id ';
			$paidDetailInfo		=	$this->query($paidDetailSql);
			foreach ((array)$paidDetailInfo as $key=>$value) {
		   	 	$otherMoney[$value['reserve_id']]	=	$value['money'];
			} 
			foreach ((array)$list['list'] as $key=>$value) {  
		   	 	$list['list'][$key]['other_money']		=	isset($otherMoney[$value['bank_no']])?$otherMoney[$value['bank_no']]:0;
			} 
            $list	=	_formatList($list['list']);
		}
		return $list;
	}    
}