<?php
class LoadContainerPublicBehavior extends Behavior {
	
	
	public function run(&$params){
		/**
		 * 更新装柜单对应的订货单已装柜数量及箱数,更新规则(如果是暂存不更新订货关联数量，直接更新订货单状态)
		 * 一、修改前还原历史单据数量（此步在装柜类中已完成）
		 * 二、根据明细重新分配已装柜数量，两种方案
		 * 		1.不是尾箱按规格分配，
		 * 		2.尾箱按第一笔未完成分配，如果所有都完成按第一笔分配
		 * 三、数量更新后再更新相关订货单状态（这里包含被修改订单装柜类中已记录）
		 */
		$add_order_detail_id = null;
		$list = M('LoadContainerDetails')->field('*,quantity*capability*dozen as load_quantity,quantity as load_capability')
		->where('load_container_id='.$params['id'])->order('mantissa asc')->select();
		foreach ($list as $value) {
			// 如果是尾箱不知道明细ID这里需要计算，不可以修改上边的排序
			if ($value['mantissa']==2) {
				$add_order_detail_id[$value['id']] = $value['order_details_id'] = D('Orders')->getLoadDetailId($value);
			}
			D('Orders')->updateLoadQuantity($value['order_details_id'],$value['load_quantity'],$value['load_capability'],true);
			$params['before_orders_id'][] = $value['orders_id'];
			$params['before_order_details_id'][] = $value['order_details_id'];
		}
		// 尾箱补全订货单明细ID时更新装柜表信息
		foreach ((array)$add_order_detail_id as $loadcontainerdetail_id => $order_detail_id) {
			M('LoadContainerDetails')->where('id='.$loadcontainerdetail_id)->setField('order_details_id',$order_detail_id); 
		}
		
		$order_details_id = array_unique($params['before_order_details_id']);	// 移除重复记录
		foreach ((array)$order_details_id as $value) {
			if($value<=0) continue;
			T('Orders')->run($value,'updateOrdersDetailState');
		}
		$orders_id = array_unique($params['before_orders_id']);	// 移除重复记录
		foreach ((array)$orders_id as $value) {
			if($value<=0) continue;
			T('Orders')->run($value,'updateOrdersState');
		}
	}
	
	
	public function edit($params){ 
		$rs = M('LoadContainer')->field('load_state')->find($params['id']);
		if ($rs['load_state']==3) {
			throw_json(L('no_edit'));
		}
	}
	
	public function update($params){
		$rs = M('LoadContainer')->field('load_state')->find($params['id']);
		if ($rs['load_state']==3) {
			throw_json(L('no_edit'));
		}
	}
	
	public function delete($params){
		$rs = M('LoadContainer')->field('load_state')->find($params['id']);
		if ($rs['load_state']==3) {
			throw_json(L('no_delete'));
		}
	}
}


