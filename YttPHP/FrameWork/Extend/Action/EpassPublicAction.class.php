<?php 
/**
 * epass
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	系统信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */


class EpassPublicAction extends BasicCommonAction {
	  
	public $_sortBy 			= 'epass_no';  ///默认排序字段
	protected $_default_post	= array('query'=>array('to_hide'=>1));  ///默认post值处理 
  	protected $_cacheDd			=  array(25);  ///需要更新的缓存字典 
  	 
  	///新增
	public function _before_add() {      
		$this->assign('epass_key',getRands(16));
		$this->assign('epass_date',getRands(32)); 
	} 
  
}