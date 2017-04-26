<?php
/**
 * email
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class EmailListPublicBehavior extends Behavior {
	
	public function run(&$params){    
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
		if ($params['id']>0 && in_array($_action,array('insert','delete','update'))){
			$model	= D('EmailList');
			$model->$params['_module']($params['id']);
		}
		 
	}  
	
}