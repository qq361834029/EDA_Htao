<?php

/**
 * 其他往来单位信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class OtherCompanyPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'company';
	///自动验证
	protected $_validate	 =	 array(
		array("comp_no",'require',"require",1),
		array("comp_no",'is_no',"valid_error",1),  	
		array("comp_no",'',"unique",1,'unique',3,array('comp_type'=>4)),//验证唯一
		array("comp_name",'require',"require",1),
		array("comp_name",'',"unique",1,'unique',3,array('comp_type'=>4)),//验证唯一 
		array("email",'email',"valid_email",2), 
	);
}