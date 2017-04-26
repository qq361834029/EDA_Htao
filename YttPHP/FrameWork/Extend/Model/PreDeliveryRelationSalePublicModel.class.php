<?php 
/**
 * 配货
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class PreDeliveryPublicModel extends RelationCommonModel {
	
///		echo C('delivery.relation_predelivery'); 是否开启配货
///		echo C('delivery.multi_delivery'); 是否多次发货 
	/// 定义真实表名
	protected $tableName = 'pre_delivery';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'pre_delivery_id',
										'class_name'	=> 'pre_delivery_detail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array( 
			array("pre_delivery_date",'require',"require",1), 
			array("pre_delivery_date",'sale_date',"pre_egt_sale",1,'egtdate'), 
			array("",'_validDetail','require',1,'validDetail'),
			array('','validQuantity','',1,'callbacks'),
		);
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("color_id",'require','require',0),
			array("size_id",'require','require',0),
			array("quantity",'currency','double',1),
			array("capability",'pst_integer','pst_integer',0),
			array("dozen",'pst_integer','pst_integer',0),
			array("price",'double','double',1),
		);	
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), /// 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), /// 更新时间					
						);
						
	/**
	 * 初始化post
	 *
	 * @return unknown
	 */
	function setPost(){   
		return $_POST;
	}	
							
	/**
	 * 查看
	 *
	 * @return unknown
	 */
	public function view(){
		return $this->getInfo($this->id);
	}
	 
	/**
	 * 编辑
	 *
	 * @return unknown
	 */
	public function edit(){ 
		return $this->getInfo($this->id);
	}
	
	/**
	 * 获取关联信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function getInfo($id){
		$rs = $this->find($id);  
		$sql	=	' 
				select *
				from pre_delivery_detail 
				where pre_delivery_id='.$id.'
				group by id order by id
		';  
		$rs['detail'] = $this->db->query($sql);    
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		} 
		$rs = _formatListRelation($rs); 
		return $rs;
	}
	
	/**
	 * 获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public  function getBeforeInfo($id) {
		if (C('delivery.relation_predelivery')){///开启配货
			return $this->getBeforeInfoPreDelivery($id);
		}else{///未开启配货
			return $this->getBeforeInfoSale($id);
		} 
	}
	 
	/**
	 * 获取配货单发货信息
	 *
	 * @param int $id
	 * @return array
	 */
	private function getBeforeInfoPreDelivery($id){
		$sale	=	M('sale_order')	;
		$rs 	= 	$sale->find($id);  
		$detail	=	M('sale_order_detail'); 
		$rs['detail'] = $detail->field('*,'.$this->getQuantity('',true))->where('sale_order_id='.$id)->select();  
		///过滤掉ID
		foreach ((array)$rs['detail'] as $key=>$value){  
			unset($rs['detail'][$key]['id']);
		}
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}			
		/// 获取客户类型
		if (C("multi_client")) {
			$client_type 		= M('Company')->field('detail_type')->select($rs['client_id']);
			$rs['detail_type'] 	= $client_type['detail_type'];
		}
		return _formatListRelation($rs);
	}
	 
	/**
	 * 获取销售单发货信息
	 *
	 * @param int $id
	 * @return array
	 */
	private function getBeforeInfoSale($id){
		$sale	=	M('sale_order')	;
		$rs 	= 	$sale->find($id);  
		$detail	=	M('sale_order_detail'); 
		$rs['detail'] = $detail->field('*,'.$this->getQuantity('',true))->where('sale_order_id='.$id)->select();  
		///过滤掉ID
		foreach ((array)$rs['detail'] as $key=>$value){  
			unset($rs['detail'][$key]['id']);
		}
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}			
		/// 获取客户类型
		if (C("multi_client")) {
			$client_type 		= M('Company')->field('detail_type')->select($rs['client_id']);
			$rs['detail_type'] 	= $client_type['detail_type'];
		}
		return _formatListRelation($rs);
	}
		  
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		return $this->getListSql(); 
	}
	
	/**
	 * 已完成订单列表SQL
	 *
	 * @return  array
	 */
	public function WaitPreDeliverySql(){
		$info['field']	=	' a.id AS id,a.sale_order_no AS sale_order_no,a.client_id AS client_id,a.basic_id AS basic_id,a.currency_id AS currency_id,a.order_date AS order_date,a.expect_shipping_date AS expect_shipping_date,a.sale_order_state AS sale_order_state,a.order_type AS order_type,a.pre_delivery AS pre_delivery,a.receive_addr AS receive_addr,a.pr_money AS pr_money,a.base_pr_money AS base_pr_money,a.base_rate AS base_rate,a.base_state AS base_state,a.comments AS comments,a.audit_state AS audit_state,a.invoice_state AS invoice_state,a.auditor AS auditor,a.audit_date AS audit_date,a.create_time AS create_time,a.update_time AS update_time,a.add_user AS add_user,a.edit_user AS edit_user,a.lock_version AS lock_version,count(distinct product_id) AS sum_pid,sum(quantity) AS sum_quantity,sum(quantity*capability*dozen) AS sum_capability,b.id AS detail_id,b.product_id AS product_id,c.is_close AS is_close,c.should_paid AS should_paid,if (is_close>0,should_paid,have_paid) AS have_paid,if (is_close>0,0,need_paid) AS need_paid,if(need_paid>0 && is_close=0,1,0) AS tr_color ';
		$info['from']	= ' sale_order a INNER JOIN sale_order_detail b ON a.id = b.sale_order_id LEFT JOIN client_paid_detail c ON a.id = c.object_id and c.object_type=120 ';
		$info['extend']	= '	WHERE 1 and sale_order_state=1 and pre_delivery=0 and '._search().'  GROUP BY a.id ORDER BY a.sale_order_no desc ';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count	=	0;
		$sql_count	= 'select count(distinct(a.id)) as count '.' from '.$info['from'].' where to_hide=1 and '._search(); 
		$list	=	$this->query($sql_count);
		$count	=	$list[0]['count'];
		$info['sql']	=	$sql;
		$info['count']	=	$count; 
		return $info; 
	}
	
	/**
	 * 列表sql语句
	 *
	 * @param string $where
	 * @return array
	 */
	private function getListSql($where=null){
		$where && $where = ' and '.$where; 
		$info['from'] 	= 'pre_delivery';
		$info['extend'] = 'WHERE to_hide=1 and '._search().$where.' ORDER BY pre_delivery_no';
		$info['field']  = '*';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count	=	0;
		$sql_count	= 'select count(distinct(a.id)) as count '.' from '.$info['from'].' where to_hide=1 and '._search().$where; 
		$list	=	$this->query($sql_count);
		$count	=	$list[0]['count'];
		$info['sql']	=	$sql;
		$info['count']	=	$count; 
		return $info;
	}
	
}