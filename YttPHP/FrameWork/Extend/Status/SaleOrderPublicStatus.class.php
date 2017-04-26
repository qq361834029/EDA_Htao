<?php
class SaleOrderPublicStatus extends Status {
	public $SALE_FLOW_SALE_DOMESTIC_DELIVERY = 1; 	//国内发货 
	public $SALE_FLOW_SALE_ORDER		     = 2; 	//客户订单
	public $SALE_FLOW_SALE_RETURN_ORDER 	 = 3; 	//客户退换货
	
	/**
	 * 获取状态值
	 *
	 * @param unknown_type $params
	 */
	protected function getState($params){ 
		 $id			   = intval($params['id']); 
		 $sale_order_state = intval($params['sale_order_state']);
		 if ($id>0&&array_key_exists($sale_order_state,C('SALE_ORDER_STATE'))){
		 	 switch ($params['flow_type']){
			 	case 'domestic_delivery': //国内发货 
			 		$object_type = $this->SALE_FLOW_SALE_DOMESTIC_DELIVERY;
			 		break;
			 	case 'sale_order':		  //客户订单 
			 		$object_type = $this->SALE_FLOW_SALE_ORDER;
			 		break;
			 	case 'return_order':	  //客户退换货
			 		$object_type = $this->SALE_FLOW_SALE_RETURN_ORDER;
			 		break;
		 	}
			if($object_type){
				$this->setSaleOrderState($id,$object_type,$params);	
			}
		 }  
	}
	
	/**
	 * 修改销售单状态
	 *
	 * @param unknown_type $sale_order_id
	 * @param unknown_type $sale_order_state
	 */
	public function setSaleOrderState($sale_order_id,$object_type,$params){
		if ($sale_order_id>0){
			$model			  = M('SaleOrder'); 
			$sale_order_state = intval($params['sale_order_state']);
			$data			  = array('sale_order_state'=>$sale_order_state); 
			$model->where('id='.$sale_order_id)->setField($data);   
			//插入日志
			$comments		  = trim($params['state_log_comments']);
			$modelStateLog    = M('state_log'); 
			$stateLogInsert	  = array(
									  'object_type' => $object_type,
									  'object_id'   => $sale_order_id,
									  'state_id'    => $sale_order_state,
									  'user_id'     => getUser('id'),
									  'create_time' => date("Y-m-d H:i:s"),
									  'comments'    => $comments,
			);
			$modelStateLog->add($stateLogInsert); 
			unset($stateLogInsert);
		} 
	}
}