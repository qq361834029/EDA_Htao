<?php
/**
 * 销售
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class ClientSalePublicBehavior extends Behavior {
	
	public function run(&$params){  
		$Model		= D('ClientSale');
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
		if ($_action=='update' && $params['sale_order_state'] == C('SHIPPED')){
			///销售单款项 
			$info		= $Model->_fund($params); 
		}elseif ($_action=='update' && $params['sale_order_state'] == C('SALEORDER_OBSOLETE')){
			///销售单款项 
            $Model->cleanFund($params);
		} 
	} 
	
}