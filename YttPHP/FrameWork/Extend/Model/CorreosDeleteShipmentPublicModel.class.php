<?php

/**
 * CORREOS API deleteShipment
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Correos
 * @package   Model
 * @author     jph
 * @version  2.1,2016-10-21
 */
class CorreosDeleteShipmentPublicModel extends CorreosPublicModel {

	/**
	 * 获取追踪单号信息
	 * @return array
	 */
	public function getRequestParams(){
		$sale									= array_map('trim', $this->sale_order);
		$this->sale								= $sale;
		$this->correos_log['shipmentNumber']	= $sale['track_no'];
		$this->correos_log['Labelurl']			= $sale['Labelurl'];
		$order									= array (
			'CodCertificado'	=> $sale['track_no'],
		);
		$_shipmentNumber						= empty($this->correos_log['status_message']) ? $order : array();
		return $_shipmentNumber;
	}
}