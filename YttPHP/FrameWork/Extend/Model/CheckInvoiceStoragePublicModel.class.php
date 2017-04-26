<?php

/**
 * 检验发票库存
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class CheckInvoiceStoragePublicModel extends Model {
	protected $tableName = 'invoice_storage';
	protected $params	 = array();
	protected $db_data	 = array();
	protected $post_data = array();
	protected $db_product_id	= array();
	protected $post_product_id	= array();
	protected $checkData		= array();
	protected $module_name;
	
	public function run($params){
		if(C('invoice.storage_check')==2){
			return ;
		}
		$this->module_name	= ucwords_first(MODULE_NAME);
		$this->params	 = $params;
		$this->post_data = $this->getPostData();
		$this->db_data	 = $this->getDbData();
		$this->checkData = $this->setCheckData();
		$this->checkStorage();
	}

	/**
	* 取post数据
	* @param string $detail_key
	* @see 
	* @param string $detail_key  默认为detail
	* @return array
	*/
	public function getPostData($detail_key='detail'){
		$list	= array();
		foreach((array)$this->params[$detail_key] as $key=>$val){
			if(empty($val['product_id'])){
				continue;
			}
			$post_product_id[$val['product_id']]	= $val['product_id'];
			$list[$val['product_id']]['product_id']	= $val['product_id'];
			if(MODULE_NAME=='InvoiceOut'&&$this->params['invoice_type']==1){	//销售发票 为扣减库存
				$list[$val['product_id']]['quantity'] -= $val['quantity'];
			}else{
				$list[$val['product_id']]['quantity'] += $val['quantity'];
			}
		}
		$this->post_product_id	= (array)$post_product_id;
		return (array)$list;
	}
	/**
	* 取db数据
	* @param 
	* @see 
	* @param 
	* @return array
	*/
	public function getDbData(){
		$method_name =  $this->module_name.ucwords(ACTION_NAME);
		if (method_exists($this,$method_name)) {
			$id = intval($this->params['id']);
			if ($id<=0) { return array();}
			$info	= $this->$method_name($id);
			$list	= array();
			foreach((array)$info as $key=>$val){
				$db_product_id[$val['product_id']]		= $val['product_id'];
				$list[$val['product_id']]['product_id'] = $val['product_id'];
				$list[$val['product_id']]['quantity']	= $val['quantity'];
			}
			$this->db_product_id	= (array)$db_product_id;
			return $list;
		}else {
			throw_json(L('check_storage_method_not_exist'));
		}
	}
	/**
	 * 设置检验库存数据
	 *
	 * @return array
	 */
	public function setCheckData(){
		$product_id	= array_unique(array_merge($this->post_product_id,$this->db_product_id));
		$post_data	= $this->post_data;
		$db_data	= $this->db_data;
		foreach($product_id as $p_id){
			$quantity	= $post_data[$p_id]['quantity']+$db_data[$p_id]['quantity'];
			if($quantity!=0){
				$list['product_id']	= $p_id;
				$list['quantity']	= $quantity;
				$checkData[]		= $list;
			}
			unset($list);
		}
		return $checkData;
	}
	/**
	 * 验证库存
	 *
	 */
	public function checkStorage(){
		if(empty($this->checkData)){
			return ;
		}
		if(C('invoice.product')==1){	//产品号显示 为 是
			$lang	= L('product_no');
			$dd		= 'product_no';
		}else{  						//产品号 显示为 否
			$lang	= L('product_name');
			$dd		= 'product_name';
		}
		$s_name	= C('invoice.product_from')==1 ? 'product' : 'invoice_product';
		foreach($this->checkData as $val){
			$rs		= M($this->tableName)->where('product_id='.$val['product_id'])->find();
			if(($rs['quantity']+$val['quantity'])<0){
				$error[] = $lang.'“'.SOnly($s_name, $val['product_id'], $dd).'”'.L('storage_no_enough');
			}
		}
		if (!empty($error)) {
			throw_json($error);
		}
	}
	/**
	 * 进发票
	 *
	 * @param int $id
	 * @return array
	 */
	public function invoiceInUpdate($id){
		$info	= M('InvoiceInDetail')->field('*,-sum(quantity) quantity')->where('invoice_in_id='.$id)->group('product_id')->select();
		return $info;
	}
	
	public function invoiceInDelete($id){
		$info	= M('InvoiceInDetail')->field('*,-sum(quantity) quantity')->where('invoice_in_id='.$id)->group('product_id')->select();
		return $info;
	}
	/**
	 * 发票期初
	 *
	 * @param int $id
	 * @return array
	 */
	public function invoiceInitStorageUpdate($id){
		$info	= M('InvoiceInitStorageDetail')->field('*,-sum(quantity) quantity')->where('init_id='.$id)->group('product_id')->select();
		return $info;
	}
	
	public function invoiceInitStorageDelete($id){
		$info	= M('InvoiceInitStorageDetail')->field('*,-sum(quantity) quantity')->where('init_id='.$id)->group('product_id')->select();
		return $info;
	}
	/**
	 * 出发票
	 *
	 * @param int $id
	 * @return array
	 */
	public function invoiceOutInsert($id){
		
		return array();
	}
	
	public function invoiceOutUpdate($id){
		$list	= M('InvoiceOut')->find($id);
		if($list['invoice_type']==1){
			$info	= M('InvoiceOutDetail')->field('*,sum(quantity) quantity')->where('invoice_out_id='.$id)->group('product_id')->select();
		}
		if($list['invoice_type']==2){
			$info	= M('InvoiceOutDetail')->field('*,-sum(quantity) quantity')->where('invoice_out_id='.$id)->group('product_id')->select();
		}
		return $info;
	}
	
	public function invoiceOutDelete($id){
		$list	= M('InvoiceOut')->find($id);
		if($list['invoice_type']==1){
			$info	= M('InvoiceOutDetail')->field('*,sum(quantity) quantity')->where('invoice_out_id='.$id)->group('product_id')->select();
		}
		if($list['invoice_type']==2){
			$info	= M('InvoiceOutDetail')->field('*,-sum(quantity) quantity')->where('invoice_out_id='.$id)->group('product_id')->select();
		}
		return $info;
	}
}






