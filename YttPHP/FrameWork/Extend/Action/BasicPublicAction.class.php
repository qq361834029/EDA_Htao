<?php

/**
 * 公司信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class BasicPublicAction extends BasicCommonAction {
	public $_default_post	=  array('query'=>array('to_hide'=>1));  ///默认post值处理
	public $_cacheDd		=  array(9);  ///需要更新的缓存字典
	public $_sortBy			=  'basic_name';  ///
	
	public function _before_index(){
  		getOutPutRand();
  	}	
	
}