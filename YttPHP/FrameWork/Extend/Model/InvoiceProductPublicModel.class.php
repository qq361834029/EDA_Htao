<?php

/**
 * 发票产品
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceProductPublicModel extends RelationCommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'invoice_product';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'invoice_product_id',
										'class_name'	=> 'InvoiceProductRelation',
									)
								);
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("product_name",'require',"require",1), 	//编号
		array('','validProduct','require',1,'callbacks'),
		array('','validConProduct','been_binded',1,'callbacks'),
	);
	///验证产品号必填 和唯一
	protected $_validProductNo	= array(
		array('product_no','require','require',1),
		array("product_no",'repeat' ,"repeat",1,'unique'),
	);
	///验证产品名称唯一
	protected $_validProductName= array(
		array('product_name','repeat','repeat',1,'unique'),
	);
	///根据产品号配置 验证产品号和产品名称
	public function validProduct($data){
		//显示产品号 并且产品号唯一时 验证
		if(C('invoice.product')==1&&C('invoice.product_unique')==1){
			$name	= '_validProductNo';
			return $this->_validSubmit($data,$name);
		}else{
			$name	= '_validProductName';
			return $this->_validSubmit($data,$name);
		}
	}
	///检验设置关联产品
	public function validConProduct($data){
		foreach($data['detail'] as $key=>$val){
			$product[$key]=$val['product_id'];
		}
		$conn_product = array_unique(array_filter($product));	
		if (!empty($conn_product)) {
			$where = "1";
			if ($data['id']) {
				$where .= " and  invoice_product_id <>".intval($data['id']); 
			}
			foreach ($conn_product as $k => $p_id) {			
				$rs = M('invoice_product_relation')->where($where.' and product_id='.$p_id)->select();	
				if (count($rs)>0) {
					$error['name']	= "detail[$k][product_id]";
					$error['value']	= L('been_binded');
					$this->error[]	= $error;
				}
			}
		}
	}
	
	public function setPost(){
		$info	= $_POST;
		foreach($info['detail'] as $key=>$val){
			if(empty($val['product_id'])){
				unset($info['detail'][$key]);
			}
		}
		$this->Mdate	= $info;
		return $info;
	}
	
	///编辑
	public function edit(){
		return $this->getInfo($this->id);
	}
	
	///查看
	public function view(){
		return $this->getInfo($this->id);
	}
	
	///取发票产品
	public function getInfo($id){
		$rs	= $this->find($id);
		$sql	=	'select *
					from invoice_product_relation  where invoice_product_id='.$id.' group by id order by id';  
		$rs['detail'] = $this->db->query($sql); 
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
		$rs	= _formatListRelation($rs);
		return $rs;
	}
}