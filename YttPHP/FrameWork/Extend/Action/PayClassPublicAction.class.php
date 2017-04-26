<?php
/**
 * 收支类别信息管理
 * @copyright   2012 展联软件友拓通
 * @category  	 基本信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2012-07-10
 */

class PayClassPublicAction extends BasicCommonAction {
	 public $_asc 			= true;  	//默认排序
	 public $_sortBy 		= 'pay_class_name';  //默认排序字段
	 public $_default_post	= array('query'=>array('to_hide'=>1, 'relation_object'=>1));  //默认post值处理
	 public $_cacheDd		= array(22);  //默认post值处理
	 public function _before_index(){
  		getOutPutRand();
  	 }
}