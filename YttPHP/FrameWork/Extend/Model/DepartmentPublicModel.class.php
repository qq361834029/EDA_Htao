<?php

/**
 * 部门信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class DepartmentPublicModel extends CommonModel {
	
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'department';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("department_no",'require',"require",1), 	//编号
		array("department_no",'is_no',"valid_error",1),  	
		array("department_no",'repeat',"repeat",1,'unique'),//验证唯一 
		array("department_name",'require',"require",1), //名称 
		array("department_name",'repeat',"repeat",1,'unique'), //仓库名称 
	);
}