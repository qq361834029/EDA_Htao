<?php

/**
 * 公司信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class BasicPublicModel extends CommonModel {
	
	protected $tableName = 'basic';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("basic_name",'require',"require",1),
		array("basic_name",'repeat',"repeat",1,'unique'),//验证唯一 
		array("email",'email',"valid_email",2), 
		array("register_fund","money","money_error",2),
	);
}
