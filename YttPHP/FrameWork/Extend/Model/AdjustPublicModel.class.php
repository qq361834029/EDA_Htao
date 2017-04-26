<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class AdjustPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'adjust';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'adjust_id',
										'class_name'	=> 'adjust_detail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("adjust_date",'require',"require",1), //1为必须验证
			array("currency_id",'require',"require",1), //1为必须验证
			array("",'_validDetail','require',1,'validDetail'),
			array('','validQuantity','',1,'callbacks'), 
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("product_id","validProductId",'require',1,'callbacks'),
			array("location_id",'require','require',1), 
			//array("warehouse_id",'require',"require",1),
			array("quantity",'not_zero_integer','not_zero_integer',1), 
		);
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);
	
	public function validProductId(){
		$data['detail'] = is_array($this->Mdate)&&$this->Mdate ? $this->Mdate['detail'] : array();
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
		$rs['detail'] = M('AdjustDetail')->field('*,quantity AS sum_quantity')->where('adjust_id='.$id)->select();
		if(is_array($rs['detail'])&&$rs['detail']){
			foreach ($rs['detail'] as $row){
				if (!empty($row['location_id'])) {
					$location_id[] = $row['location_id'];
				}
			}
			$location = M('location');
			$sql	  = 'SELECT id,barcode_no,warehouse_id
					     FROM location
						 WHERE id in ('.implode(',',$location_id).')';
			//echo $sql;exit;
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
		
		$count 	= $this->exists('select 1 from adjust_detail inner join product on product.id=adjust_detail.product_id where adjust_id=adjust.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from adjust_detail inner join product on product.id=adjust_detail.product_id where adjust_id=adjust.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('adjust_no desc')->page()->selectIds();
		$info['from'] 	= 'adjust a 
						   LEFT JOIN adjust_detail b ON a.id = b.adjust_id
						   LEFT JOIN product c		 ON b.product_id=c.id';
		$info['group'] 	= ' group by a.id order by adjust_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id AS id,
						   a.adjust_no AS adjust_no,
						   a.adjust_date AS adjust_date,
						   a.currency_id AS currency_id,
						   a.comments as comments,
						   b.adjust_id,
						   b.product_id AS product_id,
						   count(distinct b.product_id) as product_counts,
						   b.location_id AS location_id,
						   b.quantity AS quantity,  
						   sum(quantity) AS sum_quantity,
						   sum(quantity) AS total_quantity,
						   c.product_no AS product_no,
                           a.add_user AS add_user,
                           GROUP_CONCAT(distinct b.warehouse_id) as warehouse_id';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
}