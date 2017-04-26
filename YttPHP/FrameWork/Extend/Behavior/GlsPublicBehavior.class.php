<?php

class GlsPublicBehavior extends Behavior {
	private $_module		= '';
	private $_action		= '';
	public $express_type	= 'GLS';
	private $model;

	public function run(&$params){
		$this->_module	= $params['_module'] ? $params['_module'] : getTrueModule();
		$this->_action	= $params['_action'] ? $params['_action'] : getTrueAction();
		$sale_order_id	= $params['id'];
		switch ($this->_action) {
			case 'delete'://删除订单
				if (express_api_sale_order_id($this->express_type, $sale_order_id)>0 && D('Gls')->isUseGlsApi($sale_order_id)) {
					D('Gls')->clearGlsTrackNo($params['id']);
				}
				break;
			case 'update':
				if (express_api_sale_order_id($this->express_type, $sale_order_id)>0 && D('Gls')->isUseGlsApi($sale_order_id)) {
					switch ($params['sale_order_state']) {
						case C('SALE_ORDER_DELETED')://已删除
						case C('OBSOLETE')://已作废
						case C('SALE_ORDER_STATE_EDITING')://编辑中
//						case C('ERROR_ADDRESS')://地址错误
							D('Gls')->clearGlsTrackNo($params['id']);
//							express_api_delete_request($this->express_type, $sale_order_id);
							break;
						case C('SALE_ORDER_STATE_PENDING')://待处理
//							$this->updateTrackNo($sale_order_id);
//							express_api_create_request($this->express_type, $params['id']);
							break;
						case C('SALE_ORDER_STATE_PICKING')://拣货中
//						case C('SALE_ORDER_STATE_PICKED')://拣货完成
							if(empty($params['track_no'])){
								$this->updateTrackNo($sale_order_id);
							}
							break;
						case C('ADDRESS_CHANGED')://地址已改
						case C('SHIPPED')://已发货
							//api_checksum
							if ($params['from_type'] != 'out_stock') {
								$this->updateTrackNo($sale_order_id);
							}
							//暂存发货不更新
//							if (false == ($params['submit_type'] == 3 && in_array($params['sale_order_state'], explode(',', C('SALE_ORDER_OUT_STOCK'))))) {
//								express_api_update_request($this->express_type, $params['id']);
//							}
							break;
						default :
							break;
					}
				}
				break;
			case 'updateAddress':
				if (express_api_sale_order_id($this->express_type, $sale_order_id)>0 && D('Gls')->isUseGlsApi($sale_order_id)) {
					if (in_array($params['sale_order_state'], array(C('ERROR_ADDRESS'), C('OBSOLETE'),C('SALE_ORDER_STATE_PICKING'),C('PICKED')))) {//地址错误，已作废,拣货中,拣货完成
//						D('Gls')->clearGlsTrackNo($params['id']);
					} else{
						$this->updateTrackNo($sale_order_id);
					}
				}
				break;
		}
    }

	/**
	 * 订单出库
	 * 还有待请求队列，则报错提示
	 * @param type $params
	 */
	public function update($params){
		if ($params['from_type'] == 'out_stock' && $params['sale_order_state'] == C('SHIPPED')) {
			if (express_api_sale_order_id($this->express_type, $params['id'])>0 && D('Gls')->isUseGlsApi($params['id'])) {
				$sale	= express_api_get_sale_order_info($this->express_type, $params['id']);
				$gls	= D('Gls');
				if($sale['track_no'] != $params['track_no']){
					$gls->addDeleteTrackNo($params['id']);
				}
				$gls->getShipmentOrderBasic($sale);
				if($gls->StatusMessage){
					throw_json($gls->StatusMessage);
				}
			}
		}
	}

	/**
	 * 订单列表手动删除API发货
	 * 未创建API发货，则报错提示
	 * @param type $params
	 */
	public function deleteShipmentDD($params){
		if (express_api_sale_order_id($this->express_type, $params['id']) > 0 && D('Gls')->getAllowManualDeleteSale($params['id']) <= 0) {//
			throw_json(L('_RECORD_HAS_UPDATE_') . $this->express_type);
			exit;
		}
	}

	public function updateTrackNo($sale_order_id){
		$sale	= express_api_get_sale_order_info($this->express_type, $sale_order_id);
		$w_id	= $sale['warehouse_id'];
		$gls	= D('Gls');
		$order	= $gls->getShipmentOrderBasic($sale);
		if($sale['sale_order_state']==C('SALE_ORDER_STATE_PICKING') && empty($sale['track_no'])){
			$track_no	= $gls->getMaxPackageNo($w_id);
			if($track_no){
				$data['track_no']	= $gls->getVerification($track_no);
				$data['api_checksum']	= md5(serialize($order));
				$gls->updateSaleOrder($sale_order_id, $data);
			}else{
				throw_json(L('GLS_PACKAGE_NUMBER_ERROR'));
			}
		}else if($sale['api_checksum']!=md5(serialize($order))){
			$data['track_no_update_tips']	= 1;
			$data['api_checksum']	= md5(serialize($order));
			$gls->updateSaleOrder($sale_order_id, $data);
		}
	}
}
