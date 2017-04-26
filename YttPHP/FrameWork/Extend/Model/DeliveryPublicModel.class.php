<?php
/**
 * 发货
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	销售信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-07-22
*/

class DeliveryPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'delivery';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'delivery_id',
										'class_name'	=> 'delivery_detail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("delivery_date",'require',"require",1), 
			array("delivery_date",'sale_date',"pre_egt_sale",1,'egtdate'),  
			array("",'_validDetail','require',1,'validDetail'),
			array('','validQuantity','',1,'callbacks'),
		);
	protected $_validDetail	 =	 array(
			array("warehouse_id",'require','require',1),
			array("product_id",'require','require',1),
			array("color_id",'require','require',0),
			array("size_id",'require','require',0),
			array("quantity",'currency','double',1),
			array("capability",'pst_integer','pst_integer',0),
			array("dozen",'pst_integer','pst_integer',0),
			array("price",'double','double',1),
			array("discount",'double','double',2), 
			array("discount",array(0,1),'between',2,'between'),
		);	
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), /// 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), /// 更新时间					
						);		

	/**
	 * 初始化post
	 *
	 * @return array
	 */
	public function setPost(){ 
		$info=	$_POST;
		$info['delivery_date_format']	=	formatDate($info['delivery_date'],'date'); 
		$info['sale_finish']	=$info['sale_finish']==1?1:0;	///销售是否完成
		foreach ($info['detail'] as $k => $v) {  
			if (is_numeric($v['discount'])){
				$info['detail'][$k]['discount']	=	1-($v['discount']*0.01);
			}else{
				if (empty($v['discount'])){
					$info['detail'][$k]['discount']	=	1;
				}
			}
		}   
		return $info; 
	}
	
	/**
	 * 后置操作
	 *
	 * @param array $info
	 * @param string $action_name
	 * @return array
	 */
	function _afterModel($info,$action_name=''){ 
		$id	=	$info['id'];   
		///修改手动完成状态 
		$model			=	M('delivery');  
		$main			=	$model->find($id);  
		if (is_array($main)){
			$model	=	M('delivery');
			$sale_order_id  = M('delivery_detail')->field('group_concat(sale_order_id) as sale_order_id')->group('sale_order_id')->where('delivery_id='.$id)->find();
			$sale_order_id['sale_order_id'] = empty($sale_order_id['sale_order_id'])?'0':$sale_order_id['sale_order_id'];
			$delivery_id    = M('delivery_detail')->field('group_concat(delivery_id) as delivery_id')->group('delivery_id')->where('sale_order_id in ('.$sale_order_id['sale_order_id'].')')->find();
			$delivery_id['delivery_id']     = empty($delivery_id['delivery_id'])?'0':$delivery_id['delivery_id'];
			$sql            = ' id in ('.$delivery_id['delivery_id'].') ';
			if ($info['sale_finish']===1){
					$data = array('sale_finish'=>1);  
			}else{
					$data = array('sale_finish'=>0);  	
			}
			$model->where($sql)->setField($data);   
		}else{ 
			$detail			=	M('delivery_detail_del');
			$detailInfo		=	$detail->where('delivery_id='.$id)->find(); 
			$sale_order_id	=	$detailInfo['sale_order_id'];
			$sale           =   M('delivery_detail')->field('group_concat(delivery_id) as delivery_id')->group('delivery_id')->where('sale_order_id='.$sale_order_id)->find();
			$sale['delivery_id']    = empty($sale['delivery_id'])?'0':$sale['delivery_id'];
			$sql            = ' id in ('.$sale['delivery_id'].') ';
			$model			=	M('delivery'); 
			$data 			= 	array('sale_finish'=>0);  	
			$model->where($sql)->setField($data);  
		}
		
		///记录销售与配货的差异信息
		
		
		return true;
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
	 * 获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public  function getBeforeInfo($id) {
		if (C('delivery.relation_predelivery')==1){///开启配货  
			$list	= $this->getBeforeInfoPreDelivery($id);
		}else{///未开启配货  
			$list 	= $this->getBeforeInfoSale($id); 
		}   
		///获取客户电话 
		$client	=	M('company')->where('id='.$list['client_id'])->find(); 
		$list['mobile']	=	$client['mobile']; 
		return $list;
	}
	
	/**
	 * 获取配货单发货信息
	 *
	 * @param int $id
	 * @return array
	 */
	private function getBeforeInfoPreDelivery($id){  
		$sale	=	M('pre_delivery');
		$rs 	= 	_formatArray($sale->find($id)); 
		if (empty($rs)) {
			throw_json(L('_RECORD_NULL_'));
		}
		$rs['before_flow_date']	=	$rs['fmd_pre_delivery_date']; 
		$detail	=	M('pre_delivery_detail'); 
		$rs['detail'] = $detail->field('*,id as pre_delivery_detail_id,sale_order_detail_id,'.$rs['sale_order_id'].' as sale_order_id,'.$this->getQuantityDetail('',false,true))->where('pre_delivery_id='.$id)->select();   
 
		///计算未发货数量
		$sale_order_id	= $rs['sale_order_id'];
		$rs				= $this->getUnDelivery($sale_order_id,$rs,'pre_delivery_detail_id'); 
		///过滤掉ID
		foreach ((array)$rs['detail'] as $key=>$value){  
			unset($rs['detail'][$key]['id']);
			if ($value['un_delivery_qn']<=0){  
				unset($rs['detail'][$key]);
				continue;
			}
///			$rs['detail'][$key]['quantity']	=	$value['un_delivery_qn'];
		}  
		
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}			
		/// 获取客户类型
		if (C("multi_client")) {
			$client_type 		= M('Company')->field('detail_type')->select($rs['client_id']);
			$rs['detail_type'] 	= $client_type['detail_type'];
		} 
		///获取销售单信息
		$sale_order_id			=	$rs['sale_order_id'];
 
		/// 获取收获地址	
		$sale_info				= M('SaleOrder')->where('id='.$sale_order_id)->find();	
		$rs['receive_addr']		= $sale_info['receive_addr'];
		$rs['currency_id']		= $sale_info['currency_id'];
		$rs['sale_date'] 		= $rs['pre_delivery_date'];  
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
		if (empty($rs)) {
			throw_json(L('_RECORD_NULL_'));
		}
		$rs['before_flow_date']	=	$rs['fmd_order_date'];  
		///特殊处理名字不相同
		$rs['orders_no']	=	$rs['sale_order_no']; 
		$detail	=	M('sale_order_detail'); 
		$rs['detail'] = $detail->field(' *,id as sale_order_detail_id,0 as pre_delivery_detail_id ,'.$rs['id'].' as sale_order_id, '.$this->getQuantityDetail('',false,true))->where('sale_order_id='.$id)->select();  
		
		$sale_order_id	=	$id; 
		$rs	=	$this->getUnDelivery($sale_order_id,$rs,'id');
		///过滤掉ID
		foreach ((array)$rs['detail'] as $key=>$value){  
			unset($rs['detail'][$key]['id']);
			if ($value['un_delivery_qn']<=0){  
				unset($rs['detail'][$key]);
				continue;
			}
			$rs['detail'][$key]['quantity']		=	$value['un_delivery_qn'];
			$rs['detail'][$key]['sum_quantity']	=	$value['un_delivery_qn'] * $value['capability'] * $value['dozen'];
			$rs['detail'][$key]['money']		=	$rs['detail'][$key]['sum_quantity'] * $value['price'];
			$rs['detail'][$key]['discount_money']=	$rs['detail'][$key]['money'] * (1-$rs['detail'][$key]['discount']*0.01);//edited by jp 20131227 (add "*0.01") 发货折扣金额显示错误BUG
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
	 * 获取信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function getInfo($id){ 
		$rs = $this->find($id);   
		$sql	=	'SELECT id,delivery_id,product_id,color_id,size_id,price,quantity,mantissa,capability,dozen,price,warehouse_id,sale_order_id,sale_order_detail_id,pre_delivery_detail_id, (quantity * capability * dozen ) as sum_quantity, (quantity * price * capability * dozen ) as money , (quantity * price * capability * dozen ) * discount as discount_money, if (discount=1,0, (1-discount)*100) as discount FROM delivery_detail WHERE delivery_id='.$id.' ';
		$rs['detail'] = $this->db->query($sql);   
		if ($rs['detail']) {
			$sale_order_id	= $rs['detail'][0]['sale_order_id'];
			$rs				= $this->getUnDelivery($sale_order_id,$rs);
			  
			///获取收获地址	
			$sale_info 				= M('SaleOrder')->where('id='.$sale_order_id)->find();
			$rs['receive_addr']  	= $sale_info['receive_addr'];
			$rs['sale_order_state']	= $sale_info['sale_order_state'];	
			$rs['currency_id']		= $sale_info['currency_id'];	
			$rs['sale_date']		= C('delivery.relation_predelivery')==1 ? $this->sale_date : $sale_info['order_date'];
			$rs=_formatListRelation($rs); 
			return $rs;
		}
	} 
	
	/**
	 * 计算销售单中未发货的数量
	 *
	 * @param int $sale_order_id
	 * @param array $rs
	 * @param string $rs_key
	 * @return array
	 */
	public function getUnDelivery($sale_order_id,$rs,$rs_key=''){
		if ($sale_order_id>0){
			/// 获取未发货数量 
			$un_delivery_qn 	= $this->getUnDeliveryQn($sale_order_id);
				 	 
			if (!empty($rs_key)){ 
				foreach ($rs['detail'] as $k => $list) { 
						$rs['detail'][$k]['un_delivery_qn'] = $un_delivery_qn[$list[$rs_key]]['quantity']; 	
				} 
			}else{ 
				foreach ($rs['detail'] as $k => $list) {
					if (C('delivery.relation_predelivery')==1) {  
						$rs['detail'][$k]['un_delivery_qn'] = $un_delivery_qn[$list['pre_delivery_detail_id']]['quantity'];
					} else {
						$rs['detail'][$k]['un_delivery_qn'] = $un_delivery_qn[$list['sale_order_detail_id']]['quantity'];
					}
				}
			}
		}
		return $rs;
	}
	
	/**
	 * 获取未发货数量.
	 *
	 * @param int sale_order_id 销售单ID
	 * @return array 未发货数量.
	 */
	protected function getUnDeliveryQn($sale_order_id) {
		$delivery_qn	= $this->getDeliveryQn($sale_order_id);
		$sale_detail	= $this->getSaleQn($sale_order_id);
		if (!empty($delivery_qn)) {
			foreach ($sale_detail as $k => &$v) {
				///注释掉这些代码不考虑多种规格的情况
				//if($sale_detail[$k]['capability'] == $delivery_qn[$k]['capability'] && $sale_detail[$k]['dozen'] == $delivery_qn[$k]['dozen']){
					$sale_detail[$k]['quantity'] -= $delivery_qn[$k]['quantity'];
					$sale_detail[$k]['quantity']  = $sale_detail[$k]['quantity'] < 0 ? 0 : $sale_detail[$k]['quantity'];
				//}
			}
		}
		return $sale_detail;		
	}
	
	/**
	 * 获取销售单发货数量
	 *
	 * @param int sale_order_id 销售单ID
	 * @return array 发货数量
	 */
	protected function getDeliveryQn($sale_order_id) {
		if (C('delivery.relation_predelivery')==1) {
			$delivery_detail = M('DeliveryDetail')
										->field('pre_delivery_detail_id,sum(quantity) as quantity,capability,dozen')
										->group('pre_delivery_detail_id')
										->where('sale_order_id='.$sale_order_id)										
										->formatFindAll(array('key'=>'pre_delivery_detail_id'));		
		} else {
			$delivery_detail = M('DeliveryDetail')
										->field('sale_order_detail_id,sum(quantity) as quantity,capability,dozen')
										->group('sale_order_detail_id')
										->where('sale_order_id='.$sale_order_id)										
										->formatFindAll(array('key'=>'sale_order_detail_id'));		
		}						
		return $delivery_detail;		
	}
	
	/**
	 * 获取销售数量
	 *
	 * @param int sale_order_id 销售单ID
	 * @return array 销售数量
	 */
	protected function getSaleQn($sale_order_id) {
		if (C('delivery.relation_predelivery')==1) {
				$rs = M('PreDelivery')->where('sale_order_id='.$sale_order_id)->find(); 
				$id = $rs['id'];
				$this->sale_date = $rs['pre_delivery_date'];
				$sale_detail = M('PreDeliveryDetail')
							->field('id,sum(quantity) as quantity,capability,dozen')						
							->where('pre_delivery_id='.$id)
							->group("id")
							->formatFindAll(array('key'=>'id'));	
		} else {
			$sale_detail = M('SaleOrderDetail')
							->field('id,quantity,capability,dozen')						
							->where('sale_order_id='.$sale_order_id)
							->formatFindAll(array('key'=>'id'));
		}
		return $sale_detail;
	} 
	
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		return $this->getListSqlFor(); 
	}
	 
	
	/**
	 * 已完成订单列表SQL
	 *
	 * @return  array
	 */
	public function WaitDeliverySql(){ 
		if (C('delivery.relation_predelivery')==1){///开启配货  
			$model	=	M('pre_delivery');
			$count 	= $model->exists('select 1 from pre_delivery_detail where pre_delivery_id=pre_delivery.id and '.getWhere($_POST['pre_delivery_detail']),$_POST['pre_delivery_detail'])
							->exists('select 1 from sale_order where id=pre_delivery.sale_order_id and sale_order_state=2 and '.getWhere($_POST['sale_order']),$_POST['sale_order'])
							->where(getWhere($_POST['pre_delivery']))->count(); 
			$model->setPage($count);  
			$ids	= $model->field('id')
							->exists('select 1 from pre_delivery_detail where pre_delivery_id=pre_delivery.id and '.getWhere($_POST['pre_delivery_detail']),$_POST['pre_delivery_detail'])
							->exists('select 1 from sale_order where id=pre_delivery.sale_order_id and sale_order_state=2 and '.getWhere($_POST['sale_order']),$_POST['sale_order'])
							->where(getWhere($_POST['pre_delivery']))
							->order('pre_delivery_no desc')->page()->selectIds(); 
			$info['field']	=	'  a.sale_order_id,a.id AS id,a.pre_delivery_no AS pre_delivery_no,a.pre_delivery_date AS pre_delivery_date,a.client_id AS client_id,a.basic_id AS basic_id,a.sale_order_id AS sale_order_id,a.orders_no AS orders_no,a.if_print AS if_print,a.audit_state AS audit_state,a.auditor AS auditor,a.audit_date AS audit_date,a.create_time AS create_time,a.update_time AS update_time,a.add_user AS add_user,a.edit_user AS edit_user,a.lock_version AS lock_version,
			count(distinct product_id) as product_qn,
			sum(quantity) as sum_qua,
			sum(quantity*capability*dozen) AS sum_quantity,sum(b.quantity) AS total_quantity,
			c.expect_shipping_date,
			b.id AS detail_id,c.order_date AS order_date  '; 
			$info['from']	= '  pre_delivery a INNER JOIN pre_delivery_detail b ON a.id = b.pre_delivery_id LEFT JOIN sale_order c ON a.sale_order_id = c.id  ';
			$info['extend']	= '	WHERE a.id in '.$ids.'  ';
			$info['group']	= ' GROUP BY a.id ORDER BY a.pre_delivery_no desc ';
		 
		}else{  
			$model	=	M('sale_order');
			$where	=	getWhere($_POST['sale_order']).' and sale_order_state=1 ';
			$count 	= $model->exists('select 1 from sale_order_detail where sale_order_id=sale_order.id and '.getWhere($_POST['sale_order_detail']),$_POST['sale_order_detail'])
							->where($where)->count();
			$model->setPage($count);  
			$ids	= $model->field('id')
							->exists('select 1 from sale_order_detail where sale_order_id=sale_order.id and '.getWhere($_POST['sale_order_detail']),$_POST['sale_order_detail'])
							->where($where)
							->order('sale_order_no desc')->page()->selectIds();   
							
			 $where && $where = ' and '.$where; 
			 $info['field']	=	' a.id AS id,a.client_id AS client_id,a.sale_order_no AS sale_order_no,a.basic_id AS basic_id,a.currency_id AS currency_id,a.order_date AS order_date,a.expect_shipping_date,
			 '.$this->getStockStandard('b.').' , 
			 b.id AS detail_id ';
			 $info['from']		='  sale_order a INNER JOIN sale_order_detail b ON a.id = b.sale_order_id ';
			 $info['extend']	=' WHERE a.id in '.$ids.' ';
			 $info['group']		=' GROUP BY a.id ORDER BY a.sale_order_no desc ';
		} 
		
		return $sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend'].$info['group'];
	} 
	
	/**
	 * 获取列表信息
	 *
	 * @param string $where
	 * @return array
	 */
	private function getListSqlFor($where=null){  
		$model	=	M('delivery');
		$count 	= $model->exists('select 1 from delivery_detail where delivery_id=delivery.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['delivery']))->count();
		$model->setPage($count);
		$ids	= $model->field('id')->exists('select 1 from delivery_detail where delivery_id=delivery.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['delivery']))->order('delivery_no desc')->page()->selectIds(); 
		$where && $where = ' and '.$where;
		$info['field']	=	'   b.sale_order_id,a.id AS id,a.delivery_no AS delivery_no,a.delivery_date AS delivery_date,a.mobile AS mobile,a.orders_no AS orders_no,a.client_id AS client_id,a.basic_id AS basic_id,a.sale_finish AS sale_finish,a.if_print AS if_print,a.comments AS comments,a.audit_state AS audit_state,a.auditor AS auditor,a.audit_date AS audit_date,a.create_time AS create_time,a.update_time AS update_time,a.add_user AS add_user,a.edit_user AS edit_user,a.lock_version AS lock_version,c.expect_shipping_date,
		'.$this->getStockStandard().'  
		,b.id AS detail_id,b.product_id AS product_id ';
		$info['from']	= '  delivery a 
				INNER JOIN delivery_detail b ON a.id = b.delivery_id
				INNER JOIN sale_order c ON c.id = b.sale_order_id
				  ';
		$info['extend']	= '	WHERE a.id in '.$ids.' GROUP BY a.id ORDER BY a.delivery_no desc ';
	 	$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		return $sql;
	}
	
	
	/**
	 * 计算己发货数量
	 *
	 * @param array $rs  销售数据
	 * @return array 发货数量
	 */
	public function countDeliveryQn($rs) {		
///		if (C('MULTI_DELIVERY')) { /// 开启多次发货
			if (C('delivery.relation_predelivery')==1){ /// 开启配货流程
					$v_key = 'sale_order_id';
			} else {
					$v_key = 'id';	
			}
			foreach ($rs['list'] as $list) {
				$sale_order_id[] = $list[$v_key];
			} 
			if (!empty($sale_order_id)) {  
				$delivery_qn = M('DeliveryDetail')
								->field('sale_order_id, sum(quantity*capability*dozen) as sum_qn')
								->where('sale_order_id in ('.implode(',', $sale_order_id).')')
								->group('sale_order_id')
								->formatFindAll(array('key'=>'sale_order_id', 'v_key'=>'sum_qn')); 							
				if (!empty($delivery_qn)) {
					$nrs	=	$rs;
					unset($nrs['list']);
					foreach ($rs['list'] as $k => $list) { 
						$nrs['list'][$list[$v_key]]	= $list;
						$nrs['list'][$list[$v_key]]['delivery_qn'] = $delivery_qn[$list[$v_key]];
					} 
				}
			}
///		} 
		return is_array($nrs)?$nrs:$rs;
	}
}