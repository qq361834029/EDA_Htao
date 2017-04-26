<?php 
/**
 * 颜色管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class ColorPublicAction extends BasicCommonAction {
	  
	public $_sortBy 			= 'color_no';  ///默认排序字段
	protected $_default_post	= array('query'=>array('to_hide'=>1));  ///默认post值处理 
  	protected $_cacheDd 		= array(20); 
	///自动编号  
	public $_setauto_cache		= 'setauto_color_no';///编号对应超管配置中的值 
    public $_auto_no_name		= 'color_no';		 ///编号no 
      
   public function _before_index(){
   		getOutPutRand();
   }
}