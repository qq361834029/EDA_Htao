<?php 
/**
 * 条形码
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	系统信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class BarcodePublicAction extends BasicCommonAction {
	 public $_asc 			= true;  	///默认排序
	 public $_sortBy 		= 'id';  	///默认排序字段
	 public $_default_post	= array('query'=>array('to_hide'=>1));  ///默认post值处理
	 
	 public function _before_index(){
	 	getOutPutRand();
	 }

}