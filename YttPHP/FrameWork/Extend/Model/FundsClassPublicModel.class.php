<?php

/**
 * 收支类别信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	收支类别
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class FundsClassPublicModel extends CommonModel {
	// 模型名与数据表名不一致，需要指定
	protected $tableName = 'pay_class';
	// 自动验证设置
	protected $_validate	 =	 array(
		array("relation_object",'require',"require",1),
		array("pay_type",'require',"require",1),
		array("pay_class_name",'',"unique",1,'unique',3),//验证唯一  
		array("pay_class_name",'require',"require",1), //名称 
		
	);
}