<?php 
/**
 * 其他收款
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class FundsOtherArrearagesPublicModel extends AbsFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	public $tableName 		= 	'';
	///款项类型
	public $object_type		=	0;///厂家其他应收款
	///对象类型
	public $comp_type		=	0;

	public $indexTableName	=	''; ///列表查询的表的名字
	
	/// 自动验证设置
	protected $_validate	 =	 array(
										array("comp_id",'require',"require",1),
										array("basic_id",'require',"require",1),
										array("currency_id",'pst_integer',"require",1),
										array("paid_date",'require',"require",1),
										array("money",'require',"require",1),
										array("money",'money',"money_error",1),
	); 

	/**
	 * 处理厂家期初期初欠款(插入/修改);
	 *
	 * @param array $info
	 * @return array
	 */
	public function _fund($info){
		$this->_beforeFund($info);
		$vo		= $this->_saveFunds($info);
		return $vo;
	}
	
	/**
	 * 列表
	 *
	 * @return array
	 */
	public function indexSql(){ 
		$info['field']	=	' * '.$this->fundsField();
		$info['from']	=	$this->indexTableName;
		$info['extend']	=	' WHERE  '._search().$this->fundsWhere().' order by paid_date desc';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend'];
		$count	=	0;
		$sql_count	= 'select count(distinct(paid_id)) as count '.' from '.$info['from'].' WHERE  '._search().$this->fundsWhere();
		$list	=	$this->query($sql_count);
		$count	=	$list[0]['count'];
		$info['sql']	=	$sql;
		$info['count']	=	$count;
		return $info;
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

}