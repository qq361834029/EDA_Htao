<?php
/**
 * 款项类别信息管理
 * @copyright   2012 展联软件友拓通
 * @category  	 基本信息
 * @package  	Action
 * @author    	jph	
 * @version 	2014-01-26
 */

class FundsClassPublicAction extends BasicCommonAction {
	 public $_asc 			= true;  	//默认排序
	 public $_sortBy 		= 'pay_class_name';  //默认排序字段
	 public $_default_post	= array('query'=>array('to_hide'=>1));  //默认post值处理
	 public $_default_where	= '';
	 public $_cacheDd		= array(22);  //字典缓存id
	 public function _before_index(){
  		getOutPutRand();
  	 }
}