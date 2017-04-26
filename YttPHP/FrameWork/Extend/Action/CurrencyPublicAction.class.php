<?php
/**
 * 币种信息管理
 * @copyright   2012 展联软件友拓通
 * @category  	 基本信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2012-07-10
 */

class CurrencyPublicAction extends BasicCommonAction {
	 public $_asc 			= true;  	//默认排序
	 public $_sortBy 		= 'currency_no';  //默认排序字段
	//默认where条件 
  	protected 	$_default_where	=  'is_delete=1'; 
}