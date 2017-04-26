<?php 
/**
 * 厂家其他收款
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	吴盛龙
 * @version 	2.1,2017-1-4
 */

class ClientArrearagesPublicModel extends FundsOtherArrearagesPublicModel {
	/// 模型名与数据表名不一致，需要指定
	public $tableName 		= 	'paid_detail';
	///款项类型
	public $object_type		=	132;///厂家其他应收款
	///对象类型
	public $comp_type		=	1;

	public $indexTableName	=	'client_paid_detail'; ///列表查询的表的名字
    protected $_validate	 =	 array(
                                    array("comp_id",'require',"require",1),
                                    array("warehouse_id",'require',"require",1),
                                    array("basic_id",'require',"require",1),
                                    array("currency_id",'pst_integer',"require",1),
                                    array("paid_date",'require',"require",1),
                                    array("money",'require',"require",1),
                                    array("money",'money',"money_error",1),
                                    array("pay_class_id",'require',"require",1),
                                    array("billing_type",'require',"require",1),
                                    array("owed_money",'require',"require",1),
                                    array("owed_money",'money',"money_error",1),
                                    array("account_money",'ymoney',"money_error",2),
                                    array("paid_date",'require',"require",1),
                                    array("price",'double','double',1),
                                    array('price','currency','valid_money',1),
                                    array('','validByCondition','',1,'callbacks'),
									array("comments",'require',"require",1)
	); 	
    public function validByCondition($data) {
		$vasd	= array();
		if ($data['pay_class_id'] > 0) {
			$relation_type	= M('PayClass')->where('id=' . intval($data['pay_class_id']))->getField('relation_type');
			if ($relation_type > 0) {//关联单据必填
				$data['relation_type']	!= $relation_type && $_POST['relation_type']	= $relation_type;
				$vasd[]	= array("object_id",'require',"require",1);
				$vasd[]	= array("reserve_id",'require',"require",1);
			}
		}
		if (in_array($data['billing_type'], array(C('BILLING_TYPE_CUBE'),C('BILLING_TYPE_WEIGHT')))) {//数量可输入小数的计费方式
			$vasd[]	= array("quantity",'money4',"double",1);
		} else {
			$vasd[]	= array("quantity",'pst_integer',"pst_integer",1);
		}
		return $this->_validSubmit($data,$vasd);
	}
	/**
	 * 列表
	 *
	 * @return array
	 */
	public function indexSql(){
		$where			= _search($warehouse).$this->fundsWhere();	
		if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $where  .= ' and warehouse_id='.getUser('company_id');
        }
		if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
            $where  .= ' and comp_id='.getUser('company_id');
        }
		$info['field']	= ' * '.$this->fundsField() . ', quantity as cube, quantity as weight';
		$info['from']	= $this->indexTableName;
		$info['extend']	= ' WHERE  '.$where.' order by paid_date asc,comp_id asc';
		$sql_count		= 'select count(distinct(paid_id)) as count '.' from '.$info['from'].' WHERE  '.$where;
		$list			= $this->query($sql_count);
		$info['sql']	= 'select '.$info['field'].',0 as is_update'.' from '.$info['from'].' '.$info['extend'];
		$info['count']	= (int)$list[0]['count'];
        $_POST['where'] = $info['extend'];
		return $info;
	} 	
}