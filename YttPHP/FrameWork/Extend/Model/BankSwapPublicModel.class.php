<?php  
/**
 * 银行换汇
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2013-12-10
 */
class BankSwapPublicModel extends AbsBankPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName        = 	'bank_center';
	///银行类型
	public $bank_object_type    =	5;///银行换汇
	///对象类型
	public $comp_type           =	0;
    
	public $paid_object_type    =	1005;

	public $indexTableName      =	'bank_center'; ///列表查询的表的名字
	
	public $bank_no_fix         =	'HH';///银行换汇单号前缀
  
	 
	/// 自动验证设置
	protected $_validate	 =	 array(
                                        array("delivery_date",'require',"require",1),
										array("out_bank_id",'require',"require",1),
                                        array("out_money",'require',"require",1),
                                        array("out_money",'money',"money_error",1),
										array("in_bank_id",'require',"require",1), 
                                        array("rate",'require',"require",1),
                                        array("rate",'money',"money_error",1), 	
										array("in_money",'require',"require",1),
										array("in_money",'money',"money_error",1),        
										
	); 
    
    protected $_auto    = array(
                                array('bank_date', 'date', 1, 'function', 'Y-m-d'),//记录当前日期
    );




    /**
	 * 银行换汇
	 *
	 * @param array $info  页面传递来的数据
	 * @return array
	 */
	public function _fund($info){    
        ///获取绑定的流水单号  
        $bank_no	=	$this->getBankNo($this->bank_object_type,$this->bank_no_fix,$info['delivery_date']);
        ///插入换汇转出
        $out_info					= $info;
        $out_info['bank_id']		= $info['out_bank_id'];
        $out_info['relevance_cash']	= 2;
        $out_info['income_type']	= -1;
        $out_info['bank_no']		= $bank_no;
        $out_info['reserve_id']		= $bank_no;
        $out_info['currency_id']	= $info['out_currency_id'];
        $out_info['money']          = $info['out_money'];
        $out_info['paid_type']      = 3;
        $this->_beforeFund($out_info);
        $out_info['id']				= $this->_saveFunds($out_info);    

        ///插入换汇转入 
        $in_info					= $info;
        $in_info['bank_id']			= $info['in_bank_id'];
        $in_info['relevance_cash']	= 2;
        $in_info['income_type']		= 1; 
        $in_info['bank_no']			= $bank_no;
        $in_info['reserve_id']		= $bank_no;
        $in_info['currency_id']		= $info['in_currency_id'];
        $in_info['money']           = $info['in_money'];
        $in_info['comments']        = $info['in_comments'];//备注只记录到换汇转入
        $in_info['paid_type']       = 3;
        $this->_beforeFund($in_info);
        $in_info['id']				= $this->_saveFunds($in_info);    
        return array('in'=>$in_info,'out'=>$out_info);
	}
	
	/**
	 * 删除换汇
	 *
	 * @param int $id 银行中心ID
	 * @return array
	 */
	public function deleteOp($id){ 
        $tableName      = $this->indexTableName?$this->indexTableName:$this->tableName;
		///获取汇款的关联ID 
		$ids = $this->table($tableName)
                    ->where('bank_object_type='.$this->bank_object_type.' and reserve_id in ( select reserve_id from ' . $tableName . ' where to_hide=1 and bank_object_type='.$this->bank_object_type.' and id='.$id.' and reserve_id is not null ) and to_hide=1')
                    ->getField('id', true); 
		if (is_array($ids)){
			foreach ($ids as $_id) {
				if($_id>0) {  
					$vo	=	$this->_deleteFunds($_id);  
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
        $tableName      = $this->indexTableName?$this->indexTableName:$this->tableName;
        $defWhere       = ' in_swap.income_type=1 and out_swap.income_type=-1  and in_swap.to_hide=1 and out_swap.to_hide=1 ';
        $info['field']	= 'id, bank_no, delivery_date, out_bank_id, out_currency_id, out_money, in_bank_id, in_currency_id, if(out_money != 0, (in_money/out_money), 0) as rate, in_money, comments';
		$info['from']   = $this->field('in_swap.id, in_swap.bank_no, in_swap.delivery_date, out_swap.bank_id as out_bank_id, out_swap.currency_id as out_currency_id, out_swap.money as out_money, in_swap.bank_id as in_bank_id, in_swap.currency_id as in_currency_id, in_swap.money as in_money, in_swap.comments')
                               ->table($tableName . ' in_swap left join ' . $tableName . ' out_swap on out_swap.bank_no=in_swap.bank_no')
                               ->where($defWhere . $this->fundsWhere())
                               ->select(false) . ' as temp';
        $info['extend']	= ' WHERE  '._search().' order by delivery_date desc,id desc';
		$sql            = 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$info['sql']	= $sql;
		$info['count']	= $this->table($info['from'])->where(_search())->count();
		return $info;
	}  
	
	/**
	 * 默认的where条件
	 *
	 * @return string
	 */
	public function fundsWhere(){
		if(isset($this->bank_object_type)){
            $where[]	=	' in_swap.bank_object_type='.$this->bank_object_type;
            $where[]	=	' out_swap.bank_object_type='.$this->bank_object_type;
        }
		if (is_array($where)){
			$str	=	' and '.join(' and ',$where);
		}
		return $str;
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
        if (count($list['list']) > 0){
            $bank_name      = S('bank');
            $currency_no    = S('currency');            
            foreach ($list['list'] as &$value) { 
                $value['out_bank_name']    = $bank_name[$value['out_bank_id']]['bank_name'];
                $value['in_bank_name']     = $bank_name[$value['in_bank_id']]['bank_name'];
                $value['out_currency_no']  = $currency_no[$value['out_currency_id']]['currency_no'];
                $value['in_currency_no']   = $currency_no[$value['in_currency_id']]['currency_no'];         
            }  
        }
		return $list;
	}
}