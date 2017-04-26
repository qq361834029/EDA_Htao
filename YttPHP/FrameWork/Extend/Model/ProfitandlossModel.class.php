<?php

/**
 * 盈亏管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	盈亏管理
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
*/
 
class ProfitandlossPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'profitandloss';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'profitandloss_id',
										'class_name'	=> 'ProfitandlossDetail',
									)
	);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("profitandloss_type",'require','require',1),
			array("",'_validDetail','require',1,'validDetail')
	);
	/// 验证明细
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1)
	);
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间							
	);	
	/**
	 * 插入盈亏单明细
	 *
	 * @param 主键 $id
	 * @param array $post
	 */
	public function setPost(){
		if(ACTION_NAME=='insert'){
			 $data = array('warehouse_id'=>intval($_POST['warehouse_id']),'profitandloss_date'=>date('Y-m-d'),'profitandloss_type'=>$_POST['profitandloss_type'],'stocktake_ids'=>@implode(',',$_POST['stocktake_id']),'currency_id'=>$_POST['currency_id'],'comments'=>$_POST['comments']);
		 	$data['detail'] = $this->getDetail($_POST);
		}else{
			$this->_validDetail	= array(
				array("product_id",'require','require',1),
				array("price",'double','double',1)
			);
			$data			= $_POST;
			$data['state']	= 2;
		}
	 	return $data;
	}
	
	 /**
	  * 获取差异sql
	  *
	  * @param array $_POST
	  * @return string
	  */
	 private function getDetail($_POST) {
	 	$type 			= intval($_POST['profitandloss_type']);
	 	$warehouse_id 	= intval($_POST['warehouse_id']);
	 	$sql 			= '';
	 	$group 			= $this->getStorageGroup();
	 	foreach ($group as $field_name) {
	 		$select[] 		= 'a.'.$field_name;
	 		$join_where[] 	= 'a.'.$field_name.'='.'c.'.$field_name;
	 	}
	 	$sql = 'select '.implode(',',$select).',sum(a.quantity) as stocktake_quantity,c.quantity as storage_quantity,c.id as storage_id from stocktake_detail a left join stocktake b on(a.stocktake_id=b.id) left join storage c on (b.warehouse_id=c.warehouse_id and '.implode(' and ',$join_where).') where b.warehouse_id='.$warehouse_id.' and b.state=1 group by '.implode(',',$select);
	 	$detail_array 	= $this->query($sql);
	 	$storage_ids	= array();
	 	$detail			= array(array('product_id'=>null));
	 	foreach ((array)$detail_array as $key => $value) {
	 		if ($value['storage_id']) {
	 			$storage_ids[] = $value['storage_id'];
	 		}
	 		$value['stocktake_quantity'] +=0;
	 		$value['storage_quantity'] +=0;
	 		unset($value['storage_id']);
	 		$detail[]	= $value;
	 	}
	 	if ($type==2) {
	 		if (empty($storage_ids)) {
	 			$temp = M('Storage')->field('quantity,'.implode(',',$group))->where('warehouse_id='.$warehouse_id.' and quantity!=0')->select();
	 		}else {
	 			$temp = M('Storage')->field('quantity,'.implode(',',$group))->where('warehouse_id='.$warehouse_id.' and id not in('.implode(',',$storage_ids).') and quantity!=0')->select();
	 		}
	 		foreach ((array)$temp as $t_storage) {
	 			$t_storage['stocktake_quantity'] = 0;
	 			$t_storage['storage_quantity'] = $t_storage['quantity'];
	 			unset($t_storage['id'],$t_storage['warehouse_id'],$t_storage['insert_time'],$t_storage['quantity']);
	 			$detail[] = $t_storage;
	 		}
	 	}
	 	return $detail;
	 }
	 
    /**
	 * 获取库存分组条件
	 *
	 * @return string 返回字符串
	 */
	private function getStorageGroup(){
		$ary = array('product_id');
		C('stocktake.storage_format')>=2 	&& $ary[] = 'capability';
		C('stocktake.storage_format')==3 	&& $ary[] = 'dozen';
		C('stocktake.color')		== 1 	&& $ary[] = 'color_id';
		C('stocktake.size')			== 1 	&& $ary[] = 'size_id';
		C('stocktake.mantissa')		== 1 	&& $ary[] = 'mantissa';
		return $ary;
	}
	
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		return $this->getProfitandlossSql(); 
	}
	
	
	/**
	 * 盈亏列表
	 * @param string $where
	 * @return array
	 */
	private function getProfitandlossSql($where=null){
		$count 	= $this->exists('select 1 from profitandloss_detail b where '.getWhere($_POST['detail']).' and profitandloss_id=profitandloss.id',$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from profitandloss_detail b where '.getWhere($_POST['detail']).' and profitandloss_id=profitandloss.id',$_POST['detail'])->where(getWhere($_POST['main']))->order('profitandloss_no desc')->page()->selectIds();
		$info['from'] 	= 'profitandloss a left join profitandloss_detail b on(a.id=b.profitandloss_id) ';
		$info['where'] 	= 'where a.id in '.$ids;
		$info['group']	= 'group by a.id order by a.profitandloss_no desc';
		$info['field'] 	= 'a.id,a.id AS profitandloss_id,a.profitandloss_no AS profitandloss_no,
						  a.profitandloss_date AS profitandloss_date,a.warehouse_id AS warehouse_id,
						  a.currency_id AS currency_id,a.profitandloss_type AS profitandloss_type,
						  a.stocktake_ids AS stocktake_ids,a.state AS state,a.comments AS comments,
						  a.add_user AS add_user,a.edit_user AS edit_user,a.create_time AS create_time,
						  a.update_time AS update_time,sum((stocktake_quantity-storage_quantity)*capability*dozen) AS sum_quantity,
						  sum((stocktake_quantity-storage_quantity)) AS total_quantity ';
		return 	 'select '.$info['field'].' from '.$info['from'].' '.$info['where'].$info['group']; 
		
		$where && $where = ' and '.$where;
		$info['from'] = 'profitandloss a left join profitandloss_detail b on(a.id=b.profitandloss_id) ';
		$info['extend'] = 'where '._search().$where.' group by a.id order by a.profitandloss_no desc';
		$info['field'] = 'a.id,a.id AS profitandloss_id,a.profitandloss_no AS profitandloss_no,
						  a.profitandloss_date AS profitandloss_date,a.warehouse_id AS warehouse_id,
						  a.currency_id AS currency_id,a.profitandloss_type AS profitandloss_type,
						  a.stocktake_ids AS stocktake_ids,a.state AS state,a.comments AS comments,
						  a.add_user AS add_user,a.edit_user AS edit_user,a.create_time AS create_time,
						  a.update_time AS update_time,sum((stocktake_quantity-storage_quantity)*capability*dozen) AS sum_quantity,
						  sum((stocktake_quantity-storage_quantity)) AS total_quantity ';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count	=	0;
		$sql_count	= 'select count(distinct(a.id)) as count '.' from '.$info['from'].' where '._search().$where; 
		$list	=	$this->query($sql_count);
		$count	=	$list[0]['count'];
		$info['sql']	=	$sql;
		$info['count']	=	$count; 
		return $info;
	}
	
	/**
	 * 查看盈亏明细
	 * @return array
	 */
	public function view(){
		return $this->getInfo($this->id);
	}
	
	
	/**
	 * 查看盈亏明细
	 * @return array
	 */
	public function rightExtra(){
		return $this->getInfo($this->id);
	}
	
	
	/**
	 * 取信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function getInfo($id){
		$rs = $this->find($id);  
		$sql	=	' 
				select a.*, 
					   storage_quantity AS quantity, (
					stocktake_quantity - storage_quantity
					) AS profitandloss_quantity, price AS avg_price, (
					price * ( stocktake_quantity - storage_quantity ) * capability * dozen
					) AS money
				from profitandloss_detail a where profitandloss_id='.$id;  
		$rs['detail'] = $this->db->query($sql);   
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		} 
		$rs = _formatListRelation($rs);
		return $rs;
	}
	/// 记录日志
	public function setLog($log,$id){
		if(ACTION_NAME=='update'){
			$rs 		= $this->find($id);
			$log_new	= L('add').L('profitandloss').L('RightExtra').'，'.L('code').'：'.$rs['profitandloss_no'].'；';
			return $log_new;
		}else{
			return $log;
		}
	}
}