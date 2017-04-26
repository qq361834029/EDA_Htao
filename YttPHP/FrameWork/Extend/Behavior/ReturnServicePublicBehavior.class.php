<?php
class ReturnServicePublicBehavior extends Behavior {
	public function run(&$params){
		
	}
	
	public function delete(&$params){
		$model	= M('ReturnServiceDetail');
		$sql	= 'SELECT id
				   FROM return_service_detail
				   WHERE return_service_id='.$params['id'];
		$list	= $model->query($sql);
		foreach ($list as $k=>$v){
			$ids_array[] = $v['id'];
		}
		if ($ids_array && M('ReturnSaleOrderDetailService')->where('service_detail_id in (' .implode(',',$ids_array). ')')->count() > 0) {
			throw_json(L('record_is_used_cant_del'));
		}
	}
	
	protected function deleteDetail(&$params){
		$count = M('ReturnSaleOrderDetailService')->where('service_detail_id='.$params['id'])->count();
		if ($count>0) {
			throw_json(L('record_is_used_cant_del'));
		}
	}	
	
}