<?php

/**
 * 发票期初库存
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceInitStoragePublicModel extends RelationCommonModel {
	
	/// 定义真实表名
	protected $tableName = 'invoice_init_storage';
	
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'init_id',
										'class_name'	=> 'InvoiceInitStorageDetail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("init_date",'require','require',1),
			array("",'_validDetail','require',1,'validDetail'),
			array('','validProduct','',1,'callbacks'),
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
	///验证产品 是否添加过期初
	protected function validProduct($data){
		$product_arr	= array();
		foreach($data['detail'] as $key=>$val){
			if(empty($val['product_id'])){
				continue;
			}
			$product_arr[$val['product_id']]++;
			$count	= M('invoice_init_storage_detail')->where('product_id='.intval($val['product_id']).' and id<>'.intval($val['id']))->count();
			if($count>0||$product_arr[$val['product_id']]>1){
				$error['name']	= 'detail['.$key.'][product_id]';
				$error['value']	= L('init_info_exist');
				$this->error[]	= $error;
			}
		}
	}
	
	///列表
	public function indexSql(){
		return $this->getListSql(); 
	}
	
	///取列表
	public function getListSql(){
		$count 			= $this->where(getWhere($_POST))->count();
		$this->setPage($count);
		$ids			= $this->field('id')
								->where(getWhere($_POST))
								->order('init_no desc')
								->page()
								->selectIds();
		$info['from']	= 'invoice_init_storage a left join invoice_init_storage_detail b on(a.id=b.init_id)';
		$info['where']	= ' where a.id in '.$ids;
		$info['group']	= ' group by a.id order by a.id desc';
		$info['field']	= ' a.id,init_date,init_no,sum(b.quantity) as sum_qn,sum(b.quantity*b.price) as money ';
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
	
	/**
	 * 取发票信息
	 * @param int $id
	 * @return array
	 */
	public function getInfo($id){
		$rs 	= $this->find($id);  
		$sql	=	'select *,
					sum(quantity) sum_quantity,
					sum(quantity*price) money 
					from invoice_init_storage_detail  where init_id='.$id.' group by id order by id';  
		$rs['detail'] = $this->db->query($sql); 
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
		$rs	= _formatListRelationForInvoice($rs); 
		return $rs;	
	}
}