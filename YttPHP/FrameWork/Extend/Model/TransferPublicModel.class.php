<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
*/

class TransferPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'transfer';
	/// 定义自增ID
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'transfer_id',
										'class_name'	=> 'transfer_detail',
									)
								);	
	/// 表单验证
	protected $_validate	 =	 array(
			array("transfer_date",'require',"require",1), //1为必须验证
			array("",'_validDetail','require',1,'validDetail'),
			array('','validQuantity','',1,'callbacks'), 
		);
	/// 表单明细验证
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("in_warehouse_id",'require','require',1),
			array("warehouse_id",'require','require',1),
			array('in_warehouse_id','warehouse_id','transfer_warehouse_err',1,'unconfirm'), // 验证确认密码是否和密码一致
			array("color_id",'require','require',0),
			array("size_id",'require','require',0),
			array("quantity",'currency','double',1),
			array("capability",'z_integer','z_integer',0),
			array("dozen",'z_integer','z_integer',0),
		);
		
	/// 自动填充
	protected $_auto = array(
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间
		array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间
	);
							
	/// 查看
	public function view(){ 
		return $this->getInfo($this->id);
	}
	
	/// 编辑
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
		$rs['detail'] = M('TransferDetail')->field('*,1 as detail_state,(quantity*capability*dozen) AS sum_quantity,(quantity*capability*dozen*price) AS money')->where('transfer_id='.$id)->select();
		$warehouse = S('warehouse');
		foreach ($rs['detail'] as &$value) {
			$value['dd_in_w_name'] = $warehouse[$value['in_warehouse_id']]['w_name'];
		}
		return _formatListRelation($rs);
	}
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		$count 	= $this->exists('select 1 from transfer_detail where transfer_id=transfer.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from transfer_detail where transfer_id=transfer.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('transfer_no desc')->page()->selectIds();
		$info['from'] 	= 'transfer a LEFT JOIN transfer_detail b ON a.id = b.transfer_id';
		$info['group'] 	= ' group by a.id order by transfer_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id,a.transfer_no,a.transfer_date,b.transfer_id,b.product_id,b.size_id,b.quantity,b.capability,sum(quantity*capability*dozen) AS sum_quantity,sum(quantity) AS total_quantity,sum(quantity*capability*dozen*price) AS money';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
}