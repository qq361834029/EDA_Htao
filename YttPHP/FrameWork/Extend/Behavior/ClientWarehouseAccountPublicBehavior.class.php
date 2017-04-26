<?php
/**
 * 销售
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class ClientWarehouseAccountPublicBehavior extends Behavior {
	
	public function run(&$params){  
        $info   = D('ClientWarehouseAccount')->_fund($params); 
	} 
	
}