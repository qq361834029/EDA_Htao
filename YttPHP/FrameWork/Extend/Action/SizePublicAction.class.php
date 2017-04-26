<?php 
/**
 * 尺码管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class SizePublicAction extends BasicCommonAction {
	
	public $_sortBy 			=  'size_no';  ///默认排序字段
	protected $_default_post	=  array('query'=>array('to_hide'=>1));  ///默认post值处理 
	public $_setauto_cache		= 'setauto_size_no';///编号对应超管配置中的值  
	public $_auto_no_name		= 'size_no';		///编号no    
	protected $_cacheDd 		=  array('21','10');  
	
	public function _before_index(){
		getOutPutRand();
	}
 
}