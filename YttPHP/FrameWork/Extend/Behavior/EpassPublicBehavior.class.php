<?php
/**
 * epass
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class EpassPublicBehavior extends Behavior {
	
	public function run(&$params){  
	} 
	
	public function edit($params){
		$count = M('User')->where('usbkey='.$params['id'])->count();
		if ($count>0) {
			throw_json(L('error_epass_is_user'));
		}
		
	}
	
	public function update($params){
		$count = M('User')->where('usbkey='.$params['id'])->count();
		if ($count>0) {
			throw_json(L('error_epass_is_user'));
		}
		
	}
	
	public function delete($params){
		$count = M('User')->where('usbkey='.$params['id'])->count();
		if ($count>0) {
			throw_json(L('error_epass_is_user'));
		}
		
	}
	
	
}