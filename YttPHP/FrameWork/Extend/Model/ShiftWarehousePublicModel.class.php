<?php

/**
 * 移仓管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class ShiftWarehousePublicModel extends RelationCommonModel {

    /// 定义真实表名
	protected $tableName = 'shift_warehouse';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'shift_warehouse_id',
										'class_name'	=> 'shift_warehouse_detail',
									)
								);	
    
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("shift_warehouse_date",'require','require',1),
			array("",'_validDetail','require',1,'validDetail'),
			array("","validProductId",'',1,'callbacks'),
			array("","validLocation",'',1,'callbacks'),
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("out_location_id",'require','require',1), 
			array("in_location_id",'require','require',1),
			array("quantity",'pst_integer','pst_integer',1), 
		);
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);
	
	public function validProductId($data){
		foreach($data['detail'] as $key => $val){
			$product	= SOnly('product', $val['product_id']);
			if ($val['product_id'] && empty($product)) {
				$error['name']	= 'detail['.$key.'][product_id]';
				$error['value']	= L('product_not_exist');
				$this->error[]  = $error;
			}
		}
	}


	/**
	 * 移入库位与移出库位不得相同
	 * @param array $data
	 */
	public function validLocation($data){
		foreach($data['detail'] as $key => $val){
			if ($val['out_location_id'] > 0 && $val['out_location_id'] == $val['in_location_id']) {
				$error['name']	= 'detail['.$key.'][in_location_id]';
				$error['value']	= L('in_out_not_same_location');
				$this->error[]  = $error;
			}
		}
	}

	/**
	 * 查看调整明细
	 *
	 * @return  array
	 */
	public function view(){ 
		return $this->getInfo($this->id);
	}
	
	/**
	 * 编辑调整明细
	 *
	 * @return  array
	 */
	public function edit(){
		return $this->getInfo($this->id);
	}
	
	/**
	 * 获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public  function getInfo($id) {		
		$rs			  = $this->find($id);
		$rs['detail'] = M('ShiftWarehouseDetail')->field('*,quantity AS sum_quantity')->where('shift_warehouse_id='.$id)->select();
		if(is_array($rs['detail'])&&$rs['detail']){
			foreach ($rs['detail'] as $row){
				if (!empty($row['out_location_id'])) {
					$location_id[$row['out_location_id']] = $row['out_location_id'];
				}
				if (!empty($row['in_location_id'])) {
					$location_id[$row['in_location_id']] = $row['in_location_id'];
				}
			}
			$location = M('location');
			$sql	  = 'SELECT id,barcode_no,warehouse_id
					     FROM location
						 WHERE id in ('.implode(',',$location_id).')';
			$data	  = $location->where('id in ('.implode(',',$location_id).')')->getField('id,barcode_no');
			foreach($rs['detail'] as &$val){
				if(array_key_exists($val['out_location_id'],$data)){
					$val['out_barcode_no'] = $data[$val['out_location_id']]; 
				}else{
					$val['out_barcode_no'] = ''; 
				}
				if(array_key_exists($val['in_location_id'],$data)){
					$val['in_barcode_no'] = $data[$val['in_location_id']]; 
				}else{
					$val['in_barcode_no'] = ''; 
				}
			}
		}
		//pr($rs,'',1);
		$rs			  = _formatListRelation($rs);
		return $rs;
	}
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		$count 	= $this->exists('select 1 from shift_warehouse_detail inner join product on product.id=shift_warehouse_detail.product_id where shift_warehouse_id=shift_warehouse.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from shift_warehouse_detail inner join product on product.id=shift_warehouse_detail.product_id where shift_warehouse_id=shift_warehouse.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('shift_warehouse_no desc')->page()->selectIds();
		$info['from'] 	= 'shift_warehouse a 
						   LEFT JOIN shift_warehouse_detail b ON a.id = b.shift_warehouse_id
						   LEFT JOIN product c		 ON b.product_id=c.id';
		$info['group'] 	= ' group by a.id order by shift_warehouse_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id AS id,
						   a.shift_warehouse_no AS shift_warehouse_no,
						   a.comments as comments,
						   b.shift_warehouse_id,
						   b.product_id AS product_id,
						   count(distinct b.product_id) as product_counts,
						   b.out_location_id AS out_location_id,
						   b.in_location_id AS in_location_id,
						   b.quantity AS quantity,  
						   sum(quantity) AS sum_quantity,
						   sum(quantity) AS total_quantity,
						   c.product_no AS product_no,
                           a.add_user AS add_user';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}

	public function setPost() {
		$location_id	= array();
		foreach($_POST['detail'] as $val){
			if ($val['out_warehouse_id'] <= 0 && $val['out_location_id'] > 0) {
				$location_id[$val['out_location_id']]	= $val['out_location_id'];
			}
			if ($val['in_warehouse_id'] <= 0 && $val['in_location_id'] > 0) {
				$location_id[$val['in_location_id']]	= $val['in_location_id'];
			}
		}
		if (!empty($location_id)) {
			$location	= M('Location')->where(array('id' => array('in', $location_id)))->getField('id, warehouse_id');
			foreach($_POST['detail'] as &$val){
				if ($val['out_warehouse_id'] <= 0 && $val['out_location_id'] > 0) {
					$val['out_warehouse_id']	= $location[$val['out_location_id']];
				}
				if ($val['in_warehouse_id'] <= 0 && $val['in_location_id'] > 0) {
					$val['in_warehouse_id']		= $location[$val['in_location_id']];
				}
			}
			unset($val);
		}
		$this->Mdate	=	$_POST;
		return $_POST;
	}
}