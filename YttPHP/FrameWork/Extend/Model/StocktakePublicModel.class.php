<?php
/**
 * 盘点类
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category    盘点类
 * @package		Action
 * @author     何剑波
 * @version  2.1,2013-08-09
 */
class StocktakePublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'stocktake';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'stocktake_id',
										'class_name'	=> 'StocktakeDetail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("stocktake_date",'require','require',1),
			array("warehouse_id",'require','require',1),
			array("",'_validDetail','require',1,'validDetail'),
			array("class_name",'validDetailUnique','require',1,'callbacks'), 	 
			array('','validQuantity','',1,'callbacks'), 
	);
	/// 验证明细
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("color_id",'require','require',0),
			array("size_id",'require','require',0),
			array("quantity",'currency','double',1),
			array("capability",'pst_integer','pst_integer',0),
			array("dozen",'pst_integer','pst_integer',0),
		);
	///验证产品是否重复
	protected $_validDetailUnique	 =	 array(
			array("product_id",'z_integer','unique',1),
		);		
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);	
	/**
	 * 验证产品ID不可以重复
	 *
	 * @param array $data
	 * @return bool
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
	
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		return $this->getStocktakeListSql(); 
	}
	
	/**
	 * 盘点列表sql
	 * @return array
	 */
	private function getStocktakeListSql(){
		$count 	= $this->exists('select 1 from stocktake_detail b where '.getWhere($_POST['detail']).' and stocktake_id=stocktake.id',$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from stocktake_detail b where '.getWhere($_POST['detail']).'  and stocktake_id=stocktake.id',$_POST['detail'])->where(getWhere($_POST['main']))->order('stocktake_no desc')->page()->selectIds();
		$info['from'] 	= 'stocktake a left join stocktake_detail b on(a.id=b.stocktake_id)';
		$info['where'] 	= 'where a.id in '.$ids;
		$info['group']	= 'group by a.id order by a.stocktake_no desc';
		$info['field'] 	= 'a.*,a.id as stocktake_id,sum(b.quantity) as sum_quantity,
						sum(b.quantity*b.capability*b.dozen) as sun_capability';
		return 	 'select '.$info['field'].' from '.$info['from'].' '.$info['where'].$info['group']; 
//		$count	=	0;
//		$sql_count	= 'select count(distinct(a.id)) as count '.' from '.$info['from'].' where  '._search().$where; 
//		$list	=	$this->query($sql_count);
//		$count	=	$list[0]['count'];
//		$info['sql']	=	$sql;
//		$info['count']	=	$count; 
		return $info;
	}
	
	/// 查看
	public function view(){
		return $this->getInfo($this->id);
	}
	
	/// 编辑
	public function edit(){
		return $this->getInfo($this->id);
	}
	
	/**
	 * 取信息数组
	 *
	 * @param int $id
	 * @return array
	 */
	public function getInfo($id){
		$rs = $this->find($id);  
		$sql	=	' 
				select a.*,(a.quantity*a.capability*a.dozen) as sum_quantity
				from stocktake_detail as a 
				where a.stocktake_id='.$id.' 
				group by a.id order by id';  
		$rs['detail'] = $this->db->query($sql);   
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		} 
		$rs = _formatListRelation($rs);
		return $rs;
	}
		
}