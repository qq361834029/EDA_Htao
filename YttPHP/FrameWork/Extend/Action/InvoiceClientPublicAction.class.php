<?php

/**
 * 发票客户
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceClientPublicAction extends BasicCommonAction {
	//默认post值处理
	protected $_default_post	=  array('query'=>array('to_hide'=>1)); 
	//默认where条件 
  	protected $_default_where	=  'comp_type=2'; 
  	//需要更新的缓存字典 
  	protected 	$_cacheDd			=  array(38); 
}
?>
