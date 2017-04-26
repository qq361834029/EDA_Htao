<?php

/**
 * 银行信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	银行信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class BankPublicModel extends Model {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'bank';
	/// 表单验证
	protected $_validate	 =	 array(
		array("account_name",'require',"require",1),
//		array("account_name",'',"unique",1,'unique'),///验证唯一 
		array("bank_name",'require',"require",1),
		array("currency_id",'pst_integer',"require",1),
		array("account",'require',"require",1),
		array("account",'',"unique",1,'unique'),///验证唯一 
        array("contact",'require',"require",1),
	);
}