<?php

/**
 * 职位信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class PositionPublicModel extends CommonModel {
	
	protected $tableName = 'position';
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("position_no",'require',"require",1), 	//编号
		array("position_no",'is_no',"valid_error",1),  	
		array("position_no",'repeat',"repeat",1,'unique'),//验证唯一 
		array("position_name",'require',"require",1), //名称 
		array("position_name",'repeat',"repeat",1,'unique'), //职位名称
	);
}
