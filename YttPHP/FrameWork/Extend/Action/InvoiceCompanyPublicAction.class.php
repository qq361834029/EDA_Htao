<?php

/**
 * 发票公司
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceCompanyPublicAction extends BasicCommonAction {
	public $_default_post	=  array('query'=>array('to_hide'=>1));  //默认post值处理
	//默认where条件 
  	protected $_default_where	=  'comp_type=0'; 
	//需要更新的缓存字典 
  	protected 	$_cacheDd			=  array(28); 
}