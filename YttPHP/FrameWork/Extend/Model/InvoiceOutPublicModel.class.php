<?php

/**
 * 出发票
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceOutPublicModel extends RelationCommonModel  {
	
	/// 定义真实表名
	protected $tableName = 'invoice_out';
	
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'invoice_out_id',
										'class_name'	=> 'InvoiceOutDetail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("client_id",'require','require',1),
			array("iva",'require','require',1),
			array("iva",'double','double',0),
			array("iva",array(0,99),'invoice_iva_error','2','between'),
			array("check_no","paid_type",'require',0,'ifcheck','',2), 
			array("invoice_date",'require','require',1),
			array("basic_id",'require','require',0),
			array("paid_type",'require','require',1),
			array("invoice_no",'require','require',0), 
			array("",'_validDetail','require',1,'validDetail'),
			array("",'checkInvoiceOutDate','invoice_out_date',1,'callbacks'), //验证开发票日期 假期和设置的周末不可开发票
		);
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("quantity",'pst_integer','pst_integer',1),
			array("price",'double','double',0),
			array("discount",'double','double',2), 
			array("discount",array(0,1),'between',2,'between'),
		);
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);
	///验证日期 是否可开发票
	protected function checkInvoiceOutDate($data){
		$date = M("InvoiceHoliday")->where("(holiday_type=2 or holiday_type=3)  and to_hide=1")->select();		
		if (!empty($date)) {
			foreach ($date as $list) {
				$temp[] = date('Y-m-d', strtotime($list['holiday_date']));
			}			
			if (in_array(formatDate($data['invoice_date']), $temp)) {
				$error['name']	= 'invoice_date';
				$error['value']	= L('invoice_out_date');
				$this->error[] = $error;	
				return false;		  
			}
		}
		//设置周末不能开发票
		$weekend	= (array)@explode(',',C('invoice.weekend'));
		if (in_array(date('N', strtotime(formatDate($data['invoice_date']))), $weekend)) {
			$error['name']	= 'invoice_date';
			$error['value']	= L('invoice_out_date');
			$this->error[] = $error;
			return false;  
		}
		return true;
	}	
	
	///列表
	public function index(){
		$sql	= $this->getInvoiceOutSql();
		$list	= $this->query($sql);
		foreach($list as $key=>$val){
			$list[$key]['money']	= round($val['row_money'],2)+round($val['iva_cost'],2);
		}
		return _formatListForInvoice($list);
	}
	
	public function setPost(){
		$info	= $_POST;
		foreach ($info['detail'] as $k => $v) {  
			if (is_numeric($v['discount'])){
				$info['detail'][$k]['discount']	=	1-($v['discount']*0.01);
			}else{
				if (empty($v['discount'])){
					$info['detail'][$k]['discount']	=	1;
				}
			}
		}
		$this->Mdate	= $info;
		return $info;
	}
	
	///格式化列表
	function indexList($limit,$sql){
		$list	= $this->db->query($sql._limit($limit));
		foreach($list as $key=>$val){
			$list[$key]['money']	= round($val['row_money'],2)+round($val['iva_cost'],2);
		}
		$list	= _formatListForInvoice($list);  
		return $list;
	}
	
	///取列表
	public function getInvoiceOutSql(){
		$count 			= $this->where(getWhere($_POST))->count();
		$this->setPage($count);
		$ids			= $this->field('id')
								->where(getWhere($_POST))
								->order('id desc')
								->page()
								->selectIds();
		$info['from']	= 'invoice_out a left join invoice_out_detail b on(a.id=b.invoice_out_id)';
		$info['where']	= ' where a.id in '.$ids;
		$info['group']	= ' group by a.id order by a.id desc';
		$info['field']	= ' a.*,
						sum(b.quantity) as sum_qn,
						sum(b.quantity*b.price*discount) as row_money,
						sum(b.quantity*b.price*b.discount*iva*0.01) as iva_cost,
						sum(b.quantity*b.price*b.discount*(iva*0.01+1)) as money 
						';
		return 'select'.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
	///编辑
	public function edit(){
		return $this->getInfo($this->id);
	}
	
	///查看
	public function view(){
		return $this->getInfo($this->id);
	}
	
	///出发票信息
	public function getInfo($id){
		$rs 	= $this->find($id);  
		$sql	=	'select *,(1-discount)*100 discount,
					sum(quantity) sum_quantity,
					sum(quantity*price) money,
					sum(quantity*price*(1-discount)) pr_money,
					sum(quantity*price*discount) discount_money
					from invoice_out_detail  where invoice_out_id='.$id.' group by id order by id';  
		$rs['detail'] = $this->db->query($sql); 
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
		$rs	= _formatListRelationForInvoice($rs); 
		//公司信息
		if(C('invoice.company_from')==1){
			$rs['company']	= _formatArray(M('Basic')->find(intval($rs['basic_id'])));
		}else{
			$rs['company']	= _formatArray(M('InvoiceCompany')->find(intval($rs['basic_id'])));
		}
		//客户信息
		if(C('invoice.client_from')==1){
			$rs['client']	= M('Company')->find(intval($rs['client_id']));
		}else{
			$rs['client']	= M('InvoiceCompany')->find(intval($rs['client_id']));
		}
		//关联 信息
		if($rs['relation_id']>0){
			if($rs['invoice_type']==1){
				$rs['relation']	= _formatArray(M('SaleOrder')->field('sale_order_no as relation_no,order_date as relation_date')->find($rs['relation_id']));
			}else{
				$rs['relation']	= _formatArray(M('ReturnSaleOrder')->field('return_sale_order_no as relation_no,return_order_date as relation_date')->find($rs['relation_id']));
			}
		}
		return $rs;	
	}
	
	/**
	* 销售、退货信息--转发票
	* @param int $id
	* @param int $invoice_type
	* @see 函数 
	* @param string $invoice_type 
	* - 1 销售
	* - 2 退货
	* @return array
	*/
	public function getRelationInfo($id,$invoice_type){
		if($invoice_type==1){
			$rs	= $this->getSaleInfo($id);
		}
		if($invoice_type==2){
			$rs	= $this->getReturnInfo($id);
		}
		return $rs;
	}
	
	///取销售信息
	public function getSaleInfo($id){
		$rs		= M('SaleOrder')->find($id);
		$rs['detail'] = M('sale_order_detail')->field('*,'.$this->getQuantityDetail('',false,true))->where('sale_order_id='.$id)->select(); 
		$rs		= $this->_formatForInvoice($rs);
		return $rs;
	}
	
	///取退货信息
	public function getReturnInfo($id){
		$rs		= M('ReturnSaleOrder')->find($id);
		$rs['detail'] =M('return_sale_order_detail')->field('*,'.$this->getQuantityDetail('',false,true))->where('return_sale_order_id='.$id)->select();
		$rs		= $this->_formatForInvoice($rs);
		return $rs;
	}
	
	/**
	 * 格式化数据
	 * @param array $rs
	 * @return array
	 */
	public function _formatForInvoice($rs){
		if(C('invoice.client_from')==1){ //客户配置为客户列表
			$client		= S('client');
			$rs['iva']	= $client[$rs['client_id']]['client_iva'];
		}else{
			$client		= S('invoice_client');
			//取发票关联客户
			$re_client	= M('InvoiceCompany')->where('connect_client='.$rs['client_id'].' and comp_type=2')->find();
			$rs['connect_client']	= $rs['client_id'];
			$rs['client_id'] = $re_client['id'];
			$rs['client_name']=$re_client['company_name'];
			$rs['iva']	= $re_client['iva'];
		}
		if(C('invoice.company_from')==2){
			unset($rs['basic_id']);
		}
		$relation=S('invoice_product_relation');
		//去除明细id 配置为独立产品时 取关联产品
		foreach($rs['detail'] as $key=>$val){
			$rs['detail'][$key]['quantity']			= $val['sum_quantity'];
			$rs['detail'][$key]['edml_quantity']	= $val['edml_sum_quantity'];
			unset($rs['detail'][$key]['id']);
			if(C('invoice.product_from')==2){
				$product	= $relation[$val['product_id']];
				$rs['detail'][$key]['product_id']	= $product['invoice_product_id'];
			}
		}
		$rs = _formatListRelationForInvoice($rs);
		return $rs;
	}
}















