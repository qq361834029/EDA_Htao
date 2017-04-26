<?php

/**
 * 进发票
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceInPublicModel extends RelationCommonModel  {
	
	/// 定义真实表名
	protected $tableName = 'invoice_in';
	
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'invoice_in_id',
										'class_name'	=> 'InvoiceInDetail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("factory_id",'require','require',1),
			array("iva",'require','require',1),
			array("iva",'double','double',0),
			array("iva",array(0,99),'invoice_iva_error','2','between'),
			array("check_no","paid_type",'require',0,'ifcheck','',2), 
			array("invoice_date",'require','require',1),
			array("basic_id",'require','require',0),
			array("invoice_no",'require','require',0), 
			array("invoice_no",'repeat',"repeat",0,'unique'),//验证唯一 
			array("paid_type",'require','require',1), 
			array("",'_validDetail','require',1,'validDetail'),
//			array("invoice_date",'checkInvoiceInDate','invoice_in_date',1,'callbacks'), //验证开发票日期 假期不可开发票(2012-09-24更改需求 进发票不需要限制)
		);
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("quantity",'pst_integer','pst_integer',1),
			array("price",'double','double',0),
		);
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);	
	///验证日期 是否可开发票
	protected function checkInvoiceInDate($data){
		$date = M("InvoiceHoliday")->where("(holiday_type=1 or holiday_type=3)  and to_hide=1")->select();		
		if (!empty($date)) {
			foreach ($date as $list) {
				$temp[] = date('Y-m-d', strtotime($list['holiday_date']));
			}			
			if (in_array(date('Y-m-d', strtotime(formatDate($data['invoice_date']))), $temp)) {
				$error['name']	= 'invoice_date';
				$error['value']	= 'invoice_in_date';
				$this->error[] = $error;			
				return false;  
			}
		}
		return true;
	}
	
	///列表
	public function index(){
		$sql	= $this->getInvoiceInSql();
		$list	= $this->query($sql);
		foreach($list as $key=>$val){
			$list[$key]['money']	= round($val['row_money'],2)+round($val['iva_cost'],2);
		}
		return _formatListForInvoice($list);
	}
	
	///取列表
	public function getInvoiceInSql(){
		$count 			= $this->where(getWhere($_POST))->count();
		$this->setPage($count);
		$ids			= $this->field('id')
								->where(getWhere($_POST))
								->order('id desc')
								->page()
								->selectIds();
		$info['from']	= 'invoice_in a left join invoice_in_detail b on(a.id=b.invoice_in_id)';
		$info['where']	= ' where a.id in '.$ids;
		$info['group']	= ' group by a.id order by a.id desc';
		$info['field']	= ' a.*, sum(b.quantity) as sum_qn,sum(b.quantity*b.price) as row_money,sum(b.quantity*b.price*iva*0.01) as iva_cost,sum(b.quantity*b.price*(1+iva*0.01)) as money';
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
	
	///发票信息
	public function getInfo($id){
		$rs 	= $this->find($id);  
		$sql	=	'select *,
					sum(quantity) sum_quantity,
					sum(quantity*price) money,
					sum(quantity*price) discount_money 
					from invoice_in_detail  where invoice_in_id='.$id.' group by id order by id';  
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
		//厂家信息
		if(C('invoice.factory_from')==1){
			$rs['client']	= D('Factory')->find(intval($rs['factory_id']));
		}else{
			$rs['client']	= D('InvoiceSupplier')->find(intval($rs['factory_id']));
		}
		//关联 信息
		if($rs['relation_id']>0){
			$rs['relation']	= _formatArray(M('Instock')->field('instock_no as relation_no,real_arrive_date as relation_date')->find($rs['relation_id']));
		}
		return $rs;	
	}
	
	///取入库信息--转发票
	public function getInstock($factory_id=null){
		$id	= $this->id;
		$rs	= M('Instock')->find($id);
		if(!empty($factory_id)&&C('invoice.factory_from')==1){
			$where	= ' and factory_id='.intval($factory_id);
		}
		$rs['detail']	= M('instock_detail')->field('*,delivery_fee_detail*quantity*capability*dozen delivery_fee_detail,sum(quantity*capability*dozen) sum_quantity,sum(quantity*capability*dozen) quantity,sum(quantity*capability*dozen*price) money')->where('invoice_state=1 and instock_id='.$id.$where)->group('id')->select();
		$relation=S('invoice_product_relation');
		foreach($rs['detail'] as $key=>$val){
			$factory[]	= $val['factory_id'];
			if(C('invoice.product_from')==2){
				$product	= $relation[$val['product_id']];
				$rs['detail'][$key]['product_id']	= $product['invoice_product_id'];
			}
		}
		$rs['fac_where']= implode(',',$factory);
		$rs	= _formatListRelationForInvoice($rs);
		return $rs;
	}
}














