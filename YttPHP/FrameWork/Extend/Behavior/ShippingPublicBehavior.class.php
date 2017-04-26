<?php
class ShippingPublicBehavior extends Behavior {
	public function run(&$params){
		
	}
	
	public function delete(&$params){
		if (M('SaleOrder')->where('express_id=' . $params['id'])->count() > 0) {
			throw_json(L('record_is_used_cant_del'));
		}
	}
	
	protected function deleteDetail(&$params){
		$ids = trim($_POST['id']);
		if($ids){
			$count = M('SaleOrder')->where('express_detail_id in ('.$ids.')')->count(); 
			//echo M('SaleOrder')->getLastSql();
			if ($count>0) {
				throw_json(L('record_is_used_cant_del'));
			}
		}
	}	
}