<?php

/**
 * DHL API deleteShipment
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Ebay
 * @package   Model
 * @author     jph
 * @version  2.1,2016-04-21
 */
class DhlDeleteShipmentPublicModel extends DhlPublicModel {

	/**
	 * 删除发货请求对象
	 * @param array $sale_order
	 * @return object
	 */
	protected function getRequestClass(){
		$_shipmentNumber	= $this->getShipmentNumber();
		if ($this->requestDataEmpty($_shipmentNumber)) {
			return false;
		}
		$requestClassName	= $this->getRequestClassName();
		return new $requestClassName($this->_version, $_shipmentNumber);
	}

	/**
	 * 解析返回删除发货结果明细
	 * @param object $result
	 * @return array
	 */
	protected function  parseRequestResult($result){
		foreach ($result->DeletionState as $val) {
			$value								= (Object)$val;
			$status								= (Object)$value->Status;
			$statusMessage						= $status->StatusMessage;
			$shipmentNumber						= $value->ShipmentNumber->shipmentNumber;
			$sale								= $this->sale_list[$shipmentNumber];
			$sale_id							= $sale['sale_order_id'];
			$detail								= array(
				'request_status'	=> in_array($status->StatusCode, array('0', '2000', '2010')) ? 'true' : 'false',//0：删除成功 2000：找不到单据 2010：已删除
				'status_code'		=> $status->StatusCode,
				'status_message'	=> is_array($statusMessage) ? array_unique($statusMessage) : array($statusMessage),
			);
			$this->dhl_log['detail'][$sale_id]	= array_merge($this->dhl_log['detail'][$sale_id], $detail);
		}
	}

	/**
	 * 获取追踪单号信息
	 * @return array
	 */
	protected function getShipmentNumber(){
		$_shipmentNumber	= array();
		$limit				= $this->_config['DELETE_LIMIT'];
		$count				= 0;
		foreach ($this->sale_order_list as $sale) {
			$sale								= array_map('trim', $sale);
			$sale_id							= $sale['sale_order_id'];
			$this->sale_list[$sale['track_no']]	= $sale;
			$this->initializeLogDetail($sale, $sale['track_no'], $sale['Labelurl']);
			$order								= array (
				'shipmentNumber'	=> $sale['track_no'],
			);
			if (empty($this->dhl_log['detail'][$sale_id]['status_message'])) {
				$count++;
				if ($limit > 0 && $count > $limit){
					$this->setDetailStatusCode($sale_id, -2);
					$this->addDetailError($sale_id, sprintf(L('request_exceeds_limit'), $count, $limit));
				} else {
					$_shipmentNumber[]	= $order;
				}
			} else {
				$this->setDetailStatusCode($sale_id, -1);
			}
		}
		return $_shipmentNumber;
	}

	/**
	 * 获取主错误状态
	 * @param array $error 明细错误信息
	 * @return boolean
	 */
	protected function getErrorStatus($error){
		if (empty($error) && in_array($this->dhl_log['status_code'], array('1050'))) {//针对所有明细都为已删除的情况下
			return false;
		}
		return parent::getErrorStatus($error);
	}
}