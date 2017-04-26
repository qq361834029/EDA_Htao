<?php 

/**
 * 快递公司列表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class ExpressPublicAction extends BasicCommonAction {
	///默认post值处理
	protected $_default_post	=  array('query'=>array('to_hide'=>1)); 
	///默认where条件
  	protected $_default_where	=  'comp_type=3';  
  	///需要更新的缓存字典
  	protected $_cacheDd			=  array(26,18,13);  
  	public $_sortBy				= 'comp_no';
  	///自动编号 
	public $_setauto_cache		= 'setauto_express_no';
	///编号对应超管配置中的值
  	public $_auto_no_name		= 'comp_no';		 
  	
	public function _before_index(){
  		getOutPutRand();
  	}
}