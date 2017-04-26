<?php
class OrdersPublicStatus extends Status {
	
	// 订单修改结束后更新订单状态
	protected function orders($params){
		if (ACTION_NAME=='update') {
			$var = M('OrderDetails')->where('orders_id='.$params['id'])->select();
			foreach ($var as $value) {
				if ($value['detail_state']<=2) {
					$order_quantity = $value['quantity']*$value['capability']*$value['dozen'];
					if ($value['load_quantity']>0) {
						if ($order_quantity<=$value['load_quantity']) {
							$detail_state=3;
						}else {
							$detail_state = 2;
						}
					}else {
						$detail_state = 1;
					}
					M('OrderDetails')->where('id='.$value['id'])->setField('detail_state',$detail_state); 
				}
			}
			$this->updateOrdersState($params['id']);
		}
	}
	
	
	/**
	 * 装柜结束后更新订单信息
	 *
	 * @param unknown_type $params
	 */
	protected function loadContainer($params){
		// 获取影响到的订单号，包括删除的,修改前的
		$order_details_id = array();
		$orders_id = array();
		foreach ((array)$params['old'] as $value) {
			if (!empty($value['order_details_id'])) $order_details_id[] = $value['order_details_id'];
			if (!empty($value['orders_id'])) $orders_id[] = $value['orders_id'];
		}
		foreach ((array)$params['detail'] as $value) {
			if (empty($value['order_details_id'])) {
				continue;
			}
			$order_details_id[] = $value['order_details_id'];
			$orders_id[] = $value['orders_id'];
		}
		$sql = 'select orders_id,order_details_id from load_container_details_del where load_container_id='.$params['id'];
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$order_details_id[] = $value['order_details_id'];
			$orders_id[] = $value['orders_id'];
		}
		$order_details_id = array_unique($order_details_id);	// 移除重复记录
		$orders_id = array_unique($orders_id);	// 移除重复记录
		if (empty($order_details_id)) {
			throw_json('装柜单无法获取对应订货单信息！');
		}
		// 获取影响到的订单对应明细装柜信息，不含暂存
		$sql = 'select 
					a.*,b.order_details_id,(a.quantity*a.capability*a.dozen) as ordres_quantity,sum(if(c.load_state=2,0,b.quantity)) as load_capability,sum(if(c.load_state=2,0,b.quantity*b.capability*b.dozen)) as load_quantity 
				from order_details a 
				left join load_container_details b on(a.id=b.order_details_id) 
				left join load_container c on(b.load_container_id=c.id) 
				where a.id in('.implode(',',$order_details_id).') group by a.id';
		$var = $this->db->query($sql);
		$order_detail_info = array();
		foreach ($var as $value) {
			$order_detail_info[$value['order_details_id']] = $value;
		}
		// 更新关联订货单信息
		$order_data = array();
		foreach ($order_details_id as $details_id) {
			$load_capability 	= intval($order_detail_info[$details_id]['load_capability']);
			$load_quantity 		= intval($order_detail_info[$details_id]['load_quantity']);
			$ordres_quantity 	= intval($order_detail_info[$details_id]['ordres_quantity']);
			$ary = array('id'=>$details_id,'load_quantity'=>$load_quantity,'load_capability'=>$load_capability);
			if ($order_detail_info[$details_id]['detail_state']==4) {
				M('OrderDetails')->save($ary);
				continue;
			}elseif ($load_quantity==0){
				$ary['detail_state'] = 1;
			}elseif ($load_quantity>0 && $load_quantity<$ordres_quantity){
				$ary['detail_state'] = 2;
			}elseif ($load_quantity>=$ordres_quantity){
				$ary['detail_state'] = 3;
			}
			M('OrderDetails')->save($ary);
		}
		
		foreach ((array)$orders_id as $id) {
			$this->updateOrdersState($id);
		}
	}
	
	/**
	 * 根据订单ID更新指定订单的主表订货单状态
	 *
	 * @param int $orders_id
	 */
	public function updateOrdersState($orders_id){
		// 查询是存在未装柜记录
		$no_load = M('OrderDetails')->where('orders_id='.$orders_id.' and detail_state=1')->count();
		// 查询是存在部分装柜记录
		$part_load = M('OrderDetails')->where('orders_id='.$orders_id.' and detail_state=2')->count();
		// 查询是存在装柜完成记录
		$fin_load = M('OrderDetails')->where('orders_id='.$orders_id.' and detail_state=3')->count();
		// 查询是存在手动记录
		$sfin_load = M('OrderDetails')->where('orders_id='.$orders_id.' and detail_state=4')->count();
		$order_state = 0;
		if ($no_load>0 || $part_load>0) {
			$order_state = 1;
			if ($sfin_load>0) {
				$order_state = 2;
			}
		}else{
			$order_state = 3;
			if ($sfin_load>0) {
				$order_state = 4;
			}
		}
		M('Orders')->where('id='.$orders_id)->setField('order_state',$order_state); 
	}
	
	/**
	 * 根据订单明细ID更新指定订单的主表订货单状态
	 *
	 * @param int $orders_id
	 */
	public function updateOrdersDetailState($detail_id){
		$rs = M('OrderDetails')->field('quantity*capability*dozen as ordres_quantity,load_capability,load_quantity,detail_state')->find($detail_id);
		if($rs['detail_state']==4) return ;
		$load_capability 	= $rs['load_capability'];
		$load_quantity 		= $rs['load_quantity'];
		$ordres_quantity 	= $rs['ordres_quantity'];
		$ary = array('id'=>$detail_id);
		if ($load_quantity==0){
			$ary['detail_state'] = 1;
		}elseif ($load_quantity>0 && $load_quantity<$ordres_quantity){
			$ary['detail_state'] = 2;
		}elseif ($load_quantity>=$ordres_quantity){
			$ary['detail_state'] = 3;
		}
		M('OrderDetails')->save($ary);
	}
}