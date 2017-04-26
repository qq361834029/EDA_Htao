<?php

/**
 * 其他往来单位信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class OtherCompanyPublicAction extends BasicCommonAction {
	//默认post值处理
	protected $_default_post	=  array('query'=>array('to_hide'=>1)); 
	//默认where条件
  	protected $_default_where	=  'comp_type=3';  
	//自动编号 
	public $_setauto_cache		= 'setauto_othercompany_no';
	//编号对应超管配置中的值
  	public $_auto_no_name		= 'comp_no';		 //编号no  
//  	protected $_cacheDd			=  array(14);  
	public function _before_index(){
  		getOutPutRand();
  	}
}
