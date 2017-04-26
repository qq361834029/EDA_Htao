<?php
/**
 * 销售
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	yyh
 * @version 	2.1,2015-12-07
 */
class ClientOutBatchPublicBehavior extends Behavior {
	
	public function run(&$params){  
        if($params['associate_with']){
            $info   = D('ClientOutBatch')->_fund($params); 
        }
	} 
	
}