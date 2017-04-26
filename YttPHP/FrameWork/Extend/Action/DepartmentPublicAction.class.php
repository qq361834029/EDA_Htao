<?php

/**
 * 部门信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class DepartmentPublicAction extends BasicCommonAction {
	public  $_asc 			=  true;  	//默认排序
	public $_sortBy 		=  'department_no';  //默认排序字段
	public $_default_post	=  array('query'=>array('to_hide'=>1));  //默认post值处理
	public $_cacheDd		=  array(9);  //更新字典 
	public $_setauto_cache	= 'setauto_department_no';//编号对应超管配置中的值
	public $_auto_no_name	= 'department_no';		//编号no
	public function _before_index(){
  		getOutPutRand();
  	}
}