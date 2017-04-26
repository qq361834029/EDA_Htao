<?php

/**
 * 期初库存管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	期初库存
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
*/


class InitStoragePublicModel extends RelationCommonModel {
	
	/// 定义真实表名
	protected $tableName = 'init_storage';
	
	/// 定义主键
	public $id;
	
	// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'init_storage_id',
										'class_name'	=> 'init_storage_detail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("init_storage_date",'require',"require",1), //1为必须验证
			array("currency_id",'require',"require",1), //1为必须验证
			array("warehouse_id",'require',"require",1), //1为必须验证
			array("",'_validDetail','require',1,'validDetail'),
			array("class_name",'validDetailUnique','require',1,'callbacks'),
			array('','validQuantity','',1,'callbacks'),
		);

	/// 自定义验证规则
	protected $_validDetailUnique	 =	 array(
		array("product_id",'z_integer','unique',1), //验证产品是否重复
	);
	
	/// 流程明细验证
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("color_id",'require','require',0),
			array("size_id",'require','require',0),
			array("quantity","validQuantity",'require',1,'callbacks'),
//			array("quantity",'pst_integer','pst_integer',1),
			array("capability",'pst_integer','pst_integer',0),
			array("dozen",'pst_integer','pst_integer',0),
			array("price",'double','double',1),
		);
		
	/**
	 * 验证产品ID不可以重复
	 *
	 * @param  array $data
	 * @return  bool
	 */
	public function validDetailUnique($data){  
		$_moduleValidate	=	'_validDetailUnique';
		$info				=	$data;
		$product			=	array();
		$check				=	array('product_id','size_id','color_id','capability','dozen','mantissa');
		foreach ((array)$info['detail'] as $key=>$value){ //循环验证明细 
			if ($value['product_id']>0){ 
				$real_key	=	'';	
				foreach ((array)$check as $k=>$v){ //循环验证明细  
					if (isset($value[$v])){
						$real_key	.=	'_'.$value[$v];
					} 
				} 
				if (isset($product[$real_key])){
					$info['detail'][$key]['product_id']	=	'a';//特殊处理
					continue;
				}
				$product[$real_key]	=	2; 
			}
		}   
		$this->_moduleValidationDetail($this,$info,'detail',$_moduleValidate);    
	}		
		
	/// 自动填充
	protected $_auto = array(
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
		array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
	);				
							
	/// 查看单据明细
	public function view(){ 
		return $this->getInfo($this->id);
	}
	/// 编辑单据明细
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
		$rs = $this->find($id);
		$rs['detail'] = M('InitStorageDetail')->field('*,(quantity*capability*dozen) AS sum_quantity,(quantity*capability*dozen*price) AS money')->where('init_storage_id='.$id)->select();
		return _formatListRelation($rs);
	}
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		$count 	= $this->exists('select 1 from init_storage_detail where init_storage_id=init_storage.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from init_storage_detail where init_storage_id=init_storage.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('init_storage_no desc')->page()->selectIds();
		$info['from'] 	= 'init_storage a LEFT JOIN init_storage_detail b ON a.id = b.init_storage_id';
		$info['group'] 	= ' group by a.id order by init_storage_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id,a.init_storage_no,a.init_storage_date,a.currency_id,a.warehouse_id,b.init_storage_id,b.product_id,b.size_id,b.quantity,b.capability,sum(quantity*capability*dozen) AS sum_quantity,sum(quantity) AS total_quantity,sum(quantity*capability*dozen*price) AS money';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
}