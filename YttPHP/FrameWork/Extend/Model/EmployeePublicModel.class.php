<?php

/**
 * 员工信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class EmployeePublicModel extends CommonModel {
	
	protected $tableName = 'employee';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("employee_no",'require',"require",1), 	//编号
		array("employee_no",'is_no',"valid_error",1),  	
		array("employee_no",'repeat',"repeat",1,'unique'),//验证唯一 
		array("employee_name",'require',"require",1), //名称 
		array("employee_name",'repeat',"repeat",1,'unique'),  	 
		array("entry_date",'require',"require",1), 	 
		array("email",'email',"valid_email",2), 
	);
}