<?php

/**
 * 出发票
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Behavior
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceOutPublicBehavior extends Behavior {
	
	public function run(&$params){
		T('InvoiceOut')->run($params,'invoiceOut');
	}
	
	/// 新增  验证是否开过发票
	public function insert(&$params){
		$relation_id	= intval($params['relation_id']);
		$client_id		= intval($params['client_id']);
		$invoice_type	= intval($params['invoice_type']);
		if($relation_id>0){
			$count	= M('InvoiceOut')->where('relation_id='.$relation_id.' and client_id='.$client_id.' and invoice_type='.$invoice_type)->count();
			if($count>0){
				throw_json(L('invoice_not_insert'));
			}
		}
	}
}