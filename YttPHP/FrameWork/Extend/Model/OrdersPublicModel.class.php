<?php

/**
 * 订货信息管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	订货信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
*/

class OrdersPublicModel extends RelationCommonModel {
	
	/// 定义真实表名
	protected $tableName = 'orders';
	
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'orders_id',
										'class_name'	=> 'OrderDetails',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("factory_id",'require','require',1),
			array("order_date",'require','require',1),
			array("expect_date",'require','require',1),
			array("currency_id",'require','require',1),
			array("",'_validDetail','require',1,'validDetail'),
			array("expect_date",'order_date','expect_egt_order',1,'egtdate'), 
			array("class_name",'validDetailUnique','require',1,'callbacks'), 	 
		);
		
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("color_id",'require','require',0),
			array("size_id",'require','require',0),
			array("quantity",'pst_integer','pst_integer',1),
			array("capability",'pst_integer','pst_integer',0),
			array("dozen",'pst_integer','pst_integer',0),
			array("price",'double','double',1),
	);	
	
	/// 验证产品重复
	protected $_validDetailUnique	 =	 array(
			array("product_id",'z_integer','unique',1),
	);		
		
	/// 自动填充
	protected $_auto = array(
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"),
		array("update_time", "date", 2, "function", "Y-m-d H:i:s"),					
	);	
						
	/**
	 * 验证产品ID不可以重复
	 *
	 * @param  array $data
	 * @return array
	 */
	public function validDetailUnique($data){  
		$_moduleValidate	=	'_validDetailUnique';
		$info				=	$data;
		$product			=	array();
		$check				=	array('product_id','size_id','color_id','capability','dozen');
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
						
	/// 查看
	public function view(){
		return $this->getInfo($this->id);
	}
	
	/// 编辑
	public function edit(){
		return $this->getInfo($this->id);
	}
	
	/// 取信息
	public function getInfo($id){
		$rs = $this->find($id);  
		$sql	=	' 
				select *,    
							(quantity*capability*dozen) as sum_quantity , 
							(quantity*capability*dozen*price) as money	,			
							load_capability,load_quantity,(quantity*capability*dozen)-load_quantity as diff_quantity 
				from order_details where orders_id='.$id;  
		$rs['detail'] = $this->db->query($sql);   
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		} 
		$rs = _formatListRelation($rs);
		return $rs;
	}
		 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		return $this->getOrdersListSql(); 
	}
	
	/**
	 * 已完成订单列表SQL
	 *
	 * @return  array
	 */
	public function alistFinishOrderSql(){
		return $this->getOrdersListSql('(order_state>=3)');
	}
	
	/**
	 * 未完成订单列表SQL
	 *
	 * @return  array
	 */
	public function alistUnfinishOrderSql(){ 
		return $this->getOrdersListSql('(order_state<=2) and '._search_array(_getSpecialUrl($_GET)));
	}
	
	/**
	 * 订货列表信息数组
	 *
	 * @param  string $where
	 * @return  array
	 */
	public function getOrdersListSql($where=null){  
		$where && $where = ' and '.$where;
		$count 	= $this->exists('select 1 from order_details where orders_id=orders.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']).$where)->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from order_details where orders_id=orders.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']).$where)->order('order_no desc')->page()->selectIds();
		
		$info['from'] 	= 'orders a left join order_details b on(a.id=b.orders_id) ';
		$info['group'] 	= ' group by a.id order by order_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.*,a.id as orders_id,count(distinct b.product_id) as product_qn,
						sum(b.quantity) as sum_capability,
						sum(b.quantity*b.capability*b.dozen) as sun_quantity, 
						if(sum(b.quantity*b.capability*b.dozen)!=b.load_quantity && b.load_quantity>0,1,0) as load_state, 
						sum(b.quantity*b.capability*b.dozen*b.price) as money, 
						sum(b.load_capability) as load_capability,
						sum(b.load_quantity) as load_quantity';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group']; 
		
	}

	
	/**
	 * 装柜时按订单查询显示列表
	 *
	 * @param  array $post
	 * @return array
	 */
	public function getUnloadOrderSql($post){
		$post['order_id'] > 0 && $where.=" and a.id=".intval($post['order_id']);
		$post['fac_id'] > 0 && $where.=" and a.factory_id=".intval($post['fac_id']);
		$post['p_id'] > 0 && $where.=" and b.product_id=".intval($post['p_id']);
		$info['from'] = 'orders a left join order_details b on(a.id=b.orders_id) 
						left join load_container_details c on(b.id=c.order_details_id) 
						left join load_container d on(c.load_container_id=d.id) ';
		$info['extend'] = 'where detail_state in (0,1,2)  '.$where.' group by b.id order by a.order_no desc';
		$info['field'] = 'a.*,a.id as orders_id,b.quantity as sum_quantity,b.id as detial_id,
						(b.quantity*b.capability*b.dozen) as sum_capability,b.product_id,
						(b.quantity*b.capability*b.dozen*b.price) as money,b.color_id,b.size_id,
						b.quantity-IFNULL(if(d.load_state=2,0,sum(c.quantity)),0) as load_capability,
						(b.quantity*b.capability*b.dozen)-IFNULL(if(d.load_state=2,0,sum(c.quantity*c.capability*c.dozen)),0) as load_quantity';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$list	= $this->indexList('',$sql);
		return $list['list'];
	}
	
	/**
	 * 获取订单明细
	 *
	 * @param array $opert
	 * @return array
	 */
	public function detail($opert) {	
		$sql = 'select 
					a.id,a.id, a.currency_id, b.id AS detail_id, order_no, 
					a.factory_id, b.product_id, b.color_id, b.size_id, 
				    (b.quantity * b.capability * b.dozen * b.price) AS quantity, 
				    b.capability AS order_capability, b.dozen AS order_dozen, 
				    b.price AS order_pieces, b.price as price'.$opert['field'].'
					from orders a left join order_details b on(a.id=b.orders_id) 
						left join load_container_details c on(b.id=c.order_details_id) 
						left join load_container d on(c.load_container_id=d.id) 
					where '.$opert['where'].' group by '.$opert['group_by'].' order by a.order_no desc';
		$rs = $this->indexList('',$sql);
		return $rs['list'];
	}
	
	
	/**
	 * 装柜单修改时先还原订货单已装柜数量
	 *
	 * @param  int $detail_id
	 * @param  int $quantity
	 * @param int  $capability
	 * @param  ool $update_status
	 * @return  bool
	 */
	public function updateLoadQuantity($detail_id,$quantity,$capability,$update_status=false){
		// 按规格订货时更新总箱数
		if (C('order.storage_format')>1) {
			M()->execute('update order_details set load_capability=load_capability+'.$capability.' where id='.$detail_id);
		}
		M()->execute('update order_details set load_quantity=load_quantity+'.$quantity.' where id='.$detail_id);
		if ($update_status===true) {
			T('Orders')->run($detail_id,'updateOrdersDetailState');
		}
		return true;
	}
	
	/**
	 * 装柜时如果是尾箱不知道对应的明细ID是谁，在这里设置规则为第一个未完成，如果都完成取第一个
	 * @param  array $load_detail
	 * @return  int $detail_id
	 */
	public function getLoadDetailId($load_detail){
		$attr = getModuleSpec('order');
		$key = array_search('capability',$attr);
		if($key) unset($attr[$key]);
		$key = array_search('dozen',$attr);
		if($key) unset($attr[$key]);
		foreach ($attr as $field) {
			$str_where[] = $field.'='.intval($load_detail[$field]);
		}
		$rs = M('OrderDetails')->field('id')->where('detail_state<3 and orders_id='.$load_detail['orders_id'].' and '.implode(' and ',$str_where))->order('id asc')->find();
		if ($rs['id']>0) {
			return $rs['id'];
		}
		$rs = M('OrderDetails')->field('id')->where('orders_id='.$load_detail['orders_id'].' and '.implode(' and ',$str_where))->order('id asc')->find();
		return $rs['id'];
	}
	
}