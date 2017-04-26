<?php

/**
 * 出发票状态
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Status
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceOutPublicStatus extends Status {
	
	/**
	 * 开发票 修改关联单子的状态
	 * @param array $params
	 */
	public function invoiceOut(&$params){
		if(ACTION_NAME=='insert'){
			if($params['invoice_type']==1){
				$this->setSaleOrderStatus($params['relation_id'],2);
			}else{
				$this->setReturnOrderStatus($params['relation_id'],2);
			}
		}
		if(ACTION_NAME=='delete'){
			$info	= M('invoice_out_del')->find($params['id']);
			if($info['invoice_type']==1){
				$this->setSaleOrderStatus($info['relation_id'],1);
			}else{
				$this->setReturnOrderStatus($info['relation_id'],1);
			}
		}
	}
	/**
	 * 修改销售单 开发票状态
	 * @param int $relation_id
	 * @param int $invoice_state
	 */
	public function setSaleOrderStatus($relation_id,$invoice_state){
		if($relation_id>0){
			M('SaleOrder')->where("id='".$relation_id."'")->setField('invoice_state',$invoice_state);
		}
	}
	
	/**
	 * 修改退货单 开发票状态
	 * @param int $relation_id
	 * @param int $invoice_state
	 */
	public function setReturnOrderStatus($relation_id,$invoice_state){
		if($relation_id>0){
			M('ReturnSaleOrder')->where("id='".$relation_id."'")->setField('invoice_state',$invoice_state);
		}
	}
}