<?php

/**
 * 发票库存
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceStoragePublicModel extends RelationCommonModel  {
	/// 定义真实表名
	protected $tableName = 'invoice_storage';
	
	///列表
	public function index(){
		$sql	= $this->getListSql();
		$list	= $this->query($sql);
		foreach($list as $key=>$val){
			$price	= $val['in_quantity']>0?$val['in_money']/$val['in_quantity']:0;
			$list[$key]['money']=$val['quantity']*$price;
		}
		return _formatListForInvoice($list);
	}
	
	public function getListSql(){
		$count 			= M('invoice_storage_log')->where(getWhere($_POST))->having('sum(quantity)>0')->count('distinct product_id');
		$this->setPage($count);
		$table			= C('invoice.product_from')==1?'product':'invoice_product';
		return M('invoice_storage_log')
				->join('inner join '.$table.' on invoice_storage_log.product_id='.$table.'.id')
				->where(getWhere($_POST).' and invoice_storage_log.product_id>0')
				->group('invoice_storage_log.product_id')
				->having('sum(quantity)<>0')
				->order('product_no,product_name')
				->page()
				->field('invoice_storage_log.product_id,
						sum(quantity) quantity,
						sum(if(object_type=3,-1*quantity,0)) as out_quantity, 
						sum(if(object_type=3,quantity*price*discount*(1+iva*0.01),0)) as out_money,
						sum(if(object_type<>3,quantity,0)) as in_quantity,
						sum(if(object_type<>3,quantity*price*discount*(1+iva*0.01),0)) as in_money
						')
				->select(false);
	}
	
	///查看
	public function view(){
		$s_name				= C('invoice.product_from')==1 ? 'product' : 'invoice_product';
		$rs					= SOnly($s_name, $this->id);
		$rs['init_detail']	= $this->getInitList($this->id);
		$rs['in_detail']	= $this->getInList($this->id);
		$rs['sale_detail']	= $this->getSaleList($this->id);
		$rs['return_detail']= $this->getReturnList($this->id);
		return $rs;
	}
	
	///期初库存
	public function getInitList($id){
		$info	= M('invoice_init_storage_detail')
				->join('invoice_init_storage on invoice_init_storage_detail.init_id=invoice_init_storage.id')
				->field('init_date,init_id,init_no,product_id,price,sum(quantity) quantity,sum(quantity*price) money')
				->where('product_id='.$id)
				->group('init_id,price')
				->select();
		return _formatListForInvoice($info);
	}
	
	///进发票
	public function getInList($id){
		$info	= M('invoice_in_detail')
				->join('invoice_in on invoice_in_detail.invoice_in_id=invoice_in.id')
				->field('factory_id,basic_id,invoice_date,invoice_in_id,invoice_no,product_id,price,sum(quantity) quantity,sum(quantity*price) money,sum(iva*0.01*quantity*price) iva_cost,sum(quantity*price+iva*0.01*quantity*price) total_money')
				->where('product_id='.$id)
				->group('invoice_in_id,price')
				->select();
		return _formatListForInvoice($info);
	}
	
	///销售发票
	public function getSaleList($id){
		$info	= M('invoice_out_detail')
				->join('invoice_out on invoice_out_detail.invoice_out_id=invoice_out.id')
				->field('client_id,basic_id,invoice_date,invoice_out_id,invoice_no,product_id,price,sum(quantity) quantity,(1-discount)*100 discount,sum(quantity*price) money,sum(quantity*price*discount) after_discount_money,sum(iva*0.01*quantity*price*discount) iva_cost,sum(quantity*price*discount+iva*0.01*quantity*price*discount) total_money')
				->where('product_id='.$id.' and invoice_type=1')
				->group('invoice_out_id,price,discount')
				->select();
		return _formatListForInvoice($info);
	}
	
	///退货发票
	public function getReturnList($id){
		$info	= M('invoice_out_detail')
				->join('invoice_out on invoice_out_detail.invoice_out_id=invoice_out.id')
				->field('client_id,basic_id,invoice_date,invoice_out_id,invoice_no,product_id,price,sum(quantity) quantity,(1-discount)*100 discount,sum(quantity*price) money,sum(quantity*price*discount) after_discount_money,sum(iva*0.01*quantity*price*discount) iva_cost,sum(quantity*price*discount+iva*0.01*quantity*price*discount) total_money')
				->where('product_id='.$id.' and invoice_type=2')
				->group('invoice_out_id,price,discount')
				->select();
		return _formatListForInvoice($info);
	}
}









