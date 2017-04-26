<?php
/**
 * 客户款项
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class ClientFundsSaleOrderPublicBehavior extends Behavior {
	
	public function run(&$params){
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
		$ClientSale	= D('ClientSale');   
		if ($_action=='delete'){
			$id			= $params['id']; 
			$info		= $ClientSale->deleteOp($id); 
		}else{
			///销售单款项 
			$info		= $ClientSale->_funds($params); 
		} 
	} 
	
}