<?php 

class DeliveryFailedPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'sale_order';
	public    $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'sale_order_id',
										'class_name'	=> 'sale_order_detail',
									),
								 'addition' =>
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'sale_order_id',
										'class_name'	=> 'sale_order_addition',
									),
								);	
	/// 查看
	public function view(){   
		return $this->getInfo($this->id);
	}
	
	/// 获取明细信息(用于查看/编辑)
	public function getInfo($id) {	
		$model = D('SaleOrder');	 
		$rs    = $model->getInfo($id,'out_stock');  
		return $rs;
	}
}