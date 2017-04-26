<?php 
/**
 * 产品属性信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class PropertiesPublicAction extends BasicCommonAction {

	protected $_cacheDd 	=  array('6'); 
	public $_default_post	=  array('query'=>array('to_hide'=>1));  ///默认post值处理
	public $_view_dir 		= 'Basic'; 
	public $_sortBy			= 'properties_no';
	///自动编号  
	public $_setauto_cache	= 'setauto_properties_no';///编号对应超管配置中的值 
	public $_auto_no_name	= 'properties_no';		 ///编号no 
	
	public function _before_index(){
		getOutPutRand();
	}
	  
}