<?php
class OrdersPublicBehavior extends Behavior {
	
	public function run(&$params){
		T('Orders')->run($params,'orders');
	}
	
	/**
	 * 编辑前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	protected  function edit($params){
		$rs = M('Orders')->find($params['id']);
		if ($rs['order_state']>=3) {
			throw_json(L('no_edit'));
		}
	}
	
	protected  function update($params){
		$load_ary = M('LoadContainerDetails')->where('orders_id='.$params['id'])->select();
		$load_info = array();
		foreach ($load_ary as $value) {
			$load_info[$value['order_details_id']] = $value['order_details_id'];
		}
		$post_info = array();
		foreach ($params['detail'] as $value) {
			if(empty($value['id'])) continue;
			$post_info[$value['id']] = $value['id'];
		}
		$flag = $this->checkNoDelete($load_info,$post_info);
		if ($flag===true) {
			throw_json(L('_RECORD_HAS_UPDATE_'));
		}
	}
	
	protected function checkNoDelete($ary1,$ary2){
		foreach ($ary1 as $order_detail_id) {
			if (!isset($ary2[$order_detail_id])) {
				return true;
				break;
			}
		}
		return false;
	}
	
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	protected  function delete($params){
		$count = M('OrderDetails')->where('detail_state!=1 and orders_id='.$params['id'])->count();
		if ($count<=0){
			$count = M('LoadContainerDetails')->where('orders_id='.$params['id'])->count();
		}
		if ($count>0) {
			throw_json(L('no_delete'));
		}
	}
	
	
	protected function deleteDetail($params){
		$count = M('OrderDetails')->where('detail_state!=1 and id='.$params['id'])->count();
		if ($count<=0){
			$count = M('LoadContainerDetails')->where('order_details_id='.$params['id'])->count();
		}
		if ($count>0) {
			throw_json(L('no_delete'));
		}
	}
	
		
}