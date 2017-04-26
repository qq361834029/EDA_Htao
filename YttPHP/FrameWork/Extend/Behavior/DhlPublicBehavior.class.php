<?php

class DhlPublicBehavior extends Behavior {
	private $_module		= '';
	private $_action		= '';
	public $express_type	= 'DHL';
	private $model;

	public function run(&$params){
		$this->_module	= $params['_module'] ? $params['_module'] : getTrueModule();
		$this->_action	= $params['_action'] ? $params['_action'] : getTrueAction();
		$sale_order_id	= $params['id'];
		if ($sale_order_id <= C($this->express_type . '_SALE_ORDER_ID_LOWER_LIMIT')) {
			return;
		}
		switch ($this->_action) {
			case 'insert'://新增订单
				//订单状态为待处理且为dhl订单
				if ($params['sale_order_state'] == C('SALE_ORDER_STATE_PENDING') && express_api_sale_order_id($this->express_type, $sale_order_id) > 0) {
					express_api_create_request($this->express_type, $params['id']);
				}
				break;
			case 'delete'://删除订单
				$is_del	= $params['sale_order_state'] == C('SALE_ORDER_DELETED') ? false : true;
				//为dhl订单
				if (express_api_sale_order_id($this->express_type, $sale_order_id, $is_del) > 0) {
					express_api_delete_request($this->express_type, $sale_order_id, $is_del);
				}
				break;
			case 'update':
				if (express_api_sale_order_id($this->express_type, $sale_order_id) > 0) {
					switch ($params['sale_order_state']) {
						case C('SALE_ORDER_DELETED')://已删除
						case C('OBSOLETE')://已作废
						case C('SALE_ORDER_STATE_EDITING')://编辑中
						case C('ERROR_ADDRESS')://地址错误
							express_api_delete_request($this->express_type, $sale_order_id);
							break;
						case C('SALE_ORDER_STATE_PENDING')://待处理
							express_api_create_request($this->express_type, $params['id']);
							break;
						case C('SALE_ORDER_STATE_PICKING')://拣货中
						case C('SALE_ORDER_STATE_PICKED')://拣货完成
						case C('ADDRESS_CHANGED')://地址已改
						case C('SHIPPED')://已发货
							//暂存发货不更新
							if (false == ($params['submit_type'] == 3 && in_array($params['sale_order_state'], explode(',', C('SALE_ORDER_OUT_STOCK'))))) {
								express_api_update_request($this->express_type, $params['id']);
							}
							break;
						default :
//							express_api_update_request($this->express_type, $sale_order_id);
							break;
					}
				} else {
					express_api_delete_request($this->express_type, $sale_order_id);
				}
				break;
			case 'updateAddress':
				if (express_api_sale_order_id($this->express_type, $sale_order_id) > 0) {
					if (in_array($params['sale_order_state'], array(C('ERROR_ADDRESS'), C('OBSOLETE')))) {//地址错误，已作废
						express_api_delete_request($this->express_type, $sale_order_id);
					} else{
						express_api_update_request($this->express_type, $sale_order_id);
					}
				}
				break;
		}
    }

	/**
	 * 订单列表手动删除DHL发货
	 * 未创建DHL发货，则报错提示
	 * @param type $params
	 */
	public function deleteShipmentDD($params){
		if (express_api_sale_order_id($this->express_type, $params['id']) > 0 && express_api_allow_manually_delete_sale_order_id($this->express_type, $params['id']) <= 0) {//还未创建
			throw_json(L('_RECORD_HAS_UPDATE_'));
			exit;
		}
	}

	/**
	 * 订单列表手动删除DHL发货
	 * 未创建DHL发货，则报错提示
	 * @param type $params
	 */
	public function outStock($params){
		$where				= express_api_get_unfinished_request_where();
		$where['object_id']	= $params['id'];
		$module_name		= parse_name(strtolower($this->express_type) . '_list', 1);
		if (M($module_name)->where($where)->count() > 0) {//还未创建
			throw_json(sprintf(L('express_api_unfinished_not_allowed_outstock_error'), $this->express_type, title('index', $module_name)));
			exit;
		}
	}
}
