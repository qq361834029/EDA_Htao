<?php

/**
 * 进发票行为类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Behavior
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceInPublicBehavior extends Behavior {
	
	public function run(&$params){
		T('Instock')->run($params,'invoice');
	}
	/// 新增 是否开过发票
	public function insert(&$params){
		$relation_id	= intval($params['relation_id']);
		$factory_id		= intval($params['factory_id']);
		if($relation_id>0){
			if(C('invoice.factory_from')==1){
				$where	= ' and factory_id='.$factory_id;
			}
			$count	= M('InvoiceIn')->where('relation_id='.$relation_id.$where)->count();
			if($count>0){
				throw_json(L('invoice_not_insert'));
			}
		}
	}
}