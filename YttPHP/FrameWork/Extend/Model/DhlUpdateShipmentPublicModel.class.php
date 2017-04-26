<?php

/**
 * DHL API updateShipment 一次只能处理一条数据
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Ebay
 * @package   Model
 * @author     jph
 * @version  2.1,2016-04-21
 */
class DhlUpdateShipmentPublicModel extends DhlCreateShipmentPublicModel {

	/**
	 * 创建发货请求对象
	 * @return object
	 */
	protected function getRequestClass(){
		$_shipment			= $this->getShipment();
		$_shipmentOrder		= $_shipment['shipmentOrder'];
		if ($this->requestDataEmpty($_shipmentOrder)) {
			return false;
		}
		$_shipmentNumber	= $_shipment['shipmentNumber'];
		if (!isset($_shipmentNumber['shipmentNumber'])) {//updateShipmentDD 一次只能处理一条数据
			$_shipmentNumber	= reset($_shipmentNumber);
			$_shipmentOrder		= reset($_shipmentOrder);
		}
		$requestClassName	= $this->getRequestClassName();
		return new $requestClassName($this->_version, $_shipmentNumber, $_shipmentOrder);
	}

	/**
	 * 解析创建发给返回结果明细
	 * @param object $result
	 * @return array
	 */
	protected function parseRequestResult($result){
		if ($result->CreationState) {
			$value			= (Object)$result->CreationState;
			$sale_id		= $value->SequenceNumber;
			$statusMessage	= $value->StatusMessage;
			$shipmentNumber	= $value->ShipmentNumber ? $value->ShipmentNumber->shipmentNumber : '';
			$Labelurl		= trim($value->Labelurl);
			$request_status	= $value->StatusCode == 0 ? 'true' : 'false';
			$status_code	= $value->StatusCode;
		} else {
			$value			= $result->status ? $result->status : $result;
			$sale_id		= reset(array_keys($this->dhl_log['detail']));
			$statusMessage	= $value->StatusMessage;
			$shipmentNumber	= '';
			$Labelurl		= '';
			$request_status	= $value->StatusCode == 2000 ? 'cancel' : 'false';
			$status_code	= $value->StatusCode;
		}
		$detail								= array(
			'shipmentNumber'	=> $shipmentNumber,
			'Labelurl'			=> $Labelurl,
			'request_status'	=> $request_status,
			'status_code'		=> $status_code,
			'status_message'	=> is_array($statusMessage) ? array_unique($statusMessage) : array($statusMessage),
		);
		$this->dhl_log['detail'][$sale_id]	= array_merge($this->dhl_log['detail'][$sale_id], $detail);
	}

	/**
	 * 获取发货信息
	 * @return array
	 */
	protected function getShipment(){
		$_shipmentNumber	= array();
		$_shipmentOrder		= array();
		$limit				= $this->_config['UPDATE_LIMIT'];
		$count				= 0;
		$sale				= $this->sale_order_list;
		$shipper_config		= $this->getShipperConfig();
		foreach ($this->sale_order_list as $sale) {
			$_shipmentNumber[]				= array(
				'shipmentNumber'	=> $sale['track_no']
			);
			$sale							= array_merge(array_map('trim', $sale), $shipper_config);
			$sale_id						= $sale['sale_order_id'];
			$this->sale_list[$sale_id]		= $sale;
			$this->initializeLogDetail($sale);
			$order							= $this->getShipmentOrderBasic($sale);
			$api_checksum					= md5(serialize($order));//生成数据校验码
			if ($sale['api_checksum'] == $api_checksum) {//无需更新
				$this->dhl_log['detail'][$sale_id]['request_status']	= 'cancel';
				$this->addDetailError($sale_id, L('doc_not_change_cancel_request'));
				continue;
			} else {
				$this->sale_list[$sale_id]['api_checksum']	= $api_checksum;
			}
			$order['Shipment']['ShipmentDetails']['ShipmentDate']	= date('Y-m-d');
			$order['Shipment']['Shipper']	= $this->getShipmentOrderShipper($sale);
			if (empty($this->dhl_log['detail'][$sale_id]['status_message'])) {
				$count++;
				if ($limit > 0 && $count > $limit){
					$this->setDetailStatusCode($sale_id, -2);
					$this->addDetailError($sale_id, sprintf(L('request_exceeds_limit'), $count, $limit));
				} else {
					$_shipmentOrder[]									= $order;
				}
			} else {
				$this->setDetailStatusCode($sale_id, -1);
			}
		}
		return array(
			'shipmentNumber'	=> $_shipmentNumber,
			'shipmentOrder'		=> $_shipmentOrder,
		);
	}

	/**
	 * 获取主错误状态
	 * @param array $error 明细错误信息
	 * @return boolean
	 */
	protected function getErrorStatus($error){
		if (empty($error) && in_array($this->dhl_log['status_code'], array('Local'))) {//针对单据取消更新的时候
			return false;
		}
		return parent::getErrorStatus($error);
	}
}