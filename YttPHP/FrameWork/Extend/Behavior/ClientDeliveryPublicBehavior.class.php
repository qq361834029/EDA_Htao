<?php
class ClientDeliveryPublicBehavior extends Behavior {
	
	public function run(&$params){
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
		$Model	= D('ClientDelivery');   
		if ($_action=='delete'){
			$id				= $params['id'];///发货单ID
			$m				= M('delivery_detail_del');
			$info			= $m->where('delivery_id='.$id)->find(); 
			$sale_order_id	= $info['sale_order_id'];///销售单ID
			$Model->deleteOp($sale_order_id); 
		}else{
			///销售单款项 
			$info		= $Model->_fund($params); 
		} 
	} 
	
}