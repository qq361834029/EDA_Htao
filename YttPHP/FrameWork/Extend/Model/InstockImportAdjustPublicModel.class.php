<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class InstockImportAdjustPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'instock_adjust';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'adjust_id',
										'class_name'	=> 'instock_adjust_detail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("instock_id",'require',"require",1), //1为必须验证
			array("adjust_date",'require',"require",1), //1为必须验证
			array("currency_id",'require',"require",1), //1为必须验证
			array("comments",'require',"require",1), //1为必须验证
			array("",'_validDetail','require',1,'validDetail'),
			array('','validQuantity','',1,'callbacks'), 
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("instock_detail_id",'require','require',1),	//发货单详情ID
			array("box_id",'require','require',1),
			array("product_id",'require','require',1),
			array("product_id","validProductId",'require',1,'callbacks'),
			array("location_id",'require','require',1), 
			array("quantity",'not_zero_integer','not_zero_integer',1),
			array("quantity","validAdjustQuantity",'require',1,'callbacks'),
	);
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);
	
	public function validProductId(){
		$data['detail'] = is_array($this->Mdate)&&$this->Mdate ? $this->Mdate['detail'] : array();
		foreach($data['detail'] as $key => $val){
			$product = SOnly('product', $val['product_id']);
			if ($val['product_id'] && empty($product)) {
				$error['name']	= 'detail['.$key.'][product_id]';
				$error['value']	= L('product_not_exist');
				$this->error[]  = $error;
			}
		}
	}

	//验证调整后的数量不能小于0
	public function validAdjustQuantity(){
		$data['detail'] = is_array($this->Mdate)&&$this->Mdate ? $this->Mdate['detail'] : array();
		foreach($data['detail'] as $key => $val){
			$in_quantity = $val['original_in_number'] + $val['quantity'];
			if($in_quantity < 0){
				$error['name']	= 'detail['.$key.'][quantity]';
				$error['value']	= L('old_in_quantity').L('not_less_than_zero');
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
		$instockInfo = M('Instock')->where(array('id'=>$rs['instock_id']))->field('instock_no,warehouse_id')->find();
		$rs['instock_no'] = $instockInfo['instock_no'];
		$rs['warehouse_id'] = $instockInfo['warehouse_id'];
		$rs['detail'] = M('InstockAdjustDetail')->alias('a')
												->join('LEFT JOIN instock_detail d ON a.instock_detail_id=d.id')
												->field('a.*,d.quantity AS quantity,d.in_quantity,d.instock_id,a.quantity AS adjust_quantity')->where('adjust_id='.$id)->select();
		$adjust_total = 0;
		if(is_array($rs['detail'])&&$rs['detail']){
			foreach ($rs['detail'] as $row){
				if (!empty($row['location_id'])) {
					$location_id[] = $row['location_id'];
				}
			}
			$location = M('location');
			$sql	  = 'SELECT id,barcode_no
					     FROM location
						 WHERE id in ('.implode(',',$location_id).')';
			$data	  = $location->query($sql);
			foreach ((array)$data as $val){
				$barcode_no_data[$val['id']] = $val['barcode_no']; 
			}
			foreach($rs['detail'] as &$val){
				if(array_key_exists($val['location_id'],$barcode_no_data)){
					$val['barcode_no'] = $barcode_no_data[$val['location_id']]; 
				}else{
					$val['barcode_no'] = ''; 
				}
			}
		}
		$rs			  = _formatListRelation($rs);
		
		return $rs;
	}
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		///条件
		if (getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')) {
			$where = "instock.warehouse_id=".intval(getUser('company_id'));
		}
		$exists = 'select 1 from instock inner join instock_adjust on instock.id=instock_adjust.instock_id where '.$where;
		$detail_exists = 'select 1 from instock_adjust_detail inner join product on product.id=instock_adjust_detail.product_id where adjust_id=instock_adjust.id and '.getWhere($_POST['detail']);
		$count 	= $this->exists($exists,$where)
				->exists($detail_exists,$_POST['detail'])
				->where(getWhere($_POST['main']))->count('instock_adjust.id');
		$this->setPage($count);
		$ids	= $this->field('instock_adjust.id')
				->exists($exists,$where)
				->exists($detail_exists,$_POST['detail'])
				->where(getWhere($_POST['main']))->order('adjust_no desc')->page()->selectIds();
		$info['from'] 	= 'instock_adjust a
						   LEFT JOIN instock_adjust_detail b ON a.id = b.adjust_id
						   LEFT JOIN instock c ON a.instock_id=c.id';
		$info['group'] 	= ' group by a.id order by adjust_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id AS instockImportAdjust_id,
						   a.id AS id,
						   a.adjust_no AS adjust_no,
						   a.comments as comments,
						   b.adjust_id,
						   c.instock_no,
						   sum(quantity) AS total_quantity,
                           a.add_user AS add_user';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
}