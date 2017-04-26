<?php

/**
 * 检验发票库存行为
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Behavior
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class CheckInvoiceStoragePublicBehavior extends Behavior {
	
	public function run(&$params){
		
	}
	
	public function brf($params){
		D('CheckInvoiceStorage')->run($params);
	}
}