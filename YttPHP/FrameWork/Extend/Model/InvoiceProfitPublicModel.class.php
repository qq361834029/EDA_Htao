<?php

/**
 * 发票盈亏管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceProfitPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'invoice_storage_log';
	///列表
	public function index(){
		$sql	= $this->getListSql();
		$list	= $this->query($sql);
		//计算单价和利润
		foreach((array)$list as $key=>$val){
			$avg_in_price				= $val['in_quantity']!=0?($val['in_money']+$val['in_iva_money'])/$val['in_quantity']:0;
			$avg_out_price				= $val['out_quantity']!=0?($val['out_money']+$val['out_iva_money'])/$val['out_quantity']:0;
			$list[$key]['avg_in_price']	= $avg_in_price;
			$list[$key]['avg_out_price']= $avg_out_price;
			$list[$key]['profit_money']	= $val['out_quantity']*(moneyFormat($avg_out_price,0,C('PRICE_LENGTH'))-moneyFormat($avg_in_price,0,C('PRICE_LENGTH')));
		}
		return _formatListForInvoice($list);
	}
	
	public function getListSql(){
		$count 			= M('invoice_storage_log')->where(getWhere($_POST))->count('distinct product_id');
		$this->setPage($count);
		$table			= C('invoice.product_from')==1?'product':'invoice_product';
		return M('invoice_storage_log')
				->join('inner join '.$table.' on invoice_storage_log.product_id='.$table.'.id')
				->where(getWhere($_POST).' and invoice_storage_log.product_id>0')
				->group('invoice_storage_log.product_id')
				->order('product_no,product_name')
				->field('invoice_storage_log.product_id,product_no,product_name,
						sum(if(object_type<>3,quantity,0)) in_quantity,
						sum(if(object_type<>3,quantity*invoice_storage_log.price,0)) in_money,
						sum(if(object_type<>3,quantity*invoice_storage_log.price*iva*0.01,0)) in_iva_money,
						sum(if(object_type=3,-1*quantity,0)) out_quantity,
						sum(if(object_type=3,-1*quantity*invoice_storage_log.price*discount,0)) out_money,
						sum(if(object_type=3,-1*quantity*invoice_storage_log.price*discount*iva*0.01,0)) out_iva_money
						')
				->page()
				->select(false);
		
		
		/*$info['from']	= ' invoice_storage_log  a inner join '.$table.' b on a.product_id=b.id';
		$info['where']	= ' where '.getWhere($_POST).' and a.product_id>0';
		$info['group']	= ' group by a.product_id order by b.product_no,b.product_name';
		$info['field']	= ' a.product_id,
							sum(if(object_type<>3,quantity,0)) in_quantity,
							sum(if(object_type<>3,quantity*a.price,0)) in_money,
							sum(if(object_type<>3,quantity*a.price*iva*0.01,0)) in_iva_money,
							sum(if(object_type=3,-quantity,0)) out_quantity,
							sum(if(object_type=3,-quantity*a.price*discount,0)) out_money,
							sum(if(object_type=3,-quantity*a.price*discount*iva*0.01,0)) out_iva_money
							';
		return 'select'.$info['field'].' from '.$info['from'].$info['where'].$info['group'];*/
	}
}