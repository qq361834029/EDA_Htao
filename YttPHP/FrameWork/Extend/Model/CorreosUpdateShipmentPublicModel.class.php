<?php

/**
 * CORREOS API updateShipment 一次只能处理一条数据
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Ebay
 * @package   Model
 * @author     jph
 * @version  2.1,2016-10-21
 */
class CorreosUpdateShipmentPublicModel extends CorreosCreateShipmentPublicModel {

	/**
	 * 获取发货信息
	 * @return array
	 */
	public function getRequestParams(){
		$shipper_config				= $this->getShipperConfig();
		$sale						= array_merge(array_map('trim', $this->sale_order), $shipper_config);
		$this->sale					= $sale;
		$check_data					= $this->getShipmentOrderBasic($sale);
		$order						= array (
			'FechaOperacion'	=> '',
			'codCertificado'	=> $sale['track_no'],
			'CodEtiquetador'	=> $this->_CodEtiquetador,
			'Care'				=> '000000',//6	String	Aggregation code of shipment list. By default  000000
			'TotalBultos'		=> 1,//Integer	Always to 1.
			'ModDevEtiqueta'	=> 2,//1	String	Way in which the request is made for the label in the request answer:1.	XML. 2.	PDF
									//标签返回方式 1:xml 2:pdf
			'RemitenteModif'	=> array(),//发货人信息不作为数据校验码的因子
			'Destinatario'		=> $check_data['Destinatario'],
			'Envio'				=> $check_data['Envio'],
		);
		$api_checksum				= md5(serialize($check_data));//生成数据校验码
		if ($sale['api_checksum'] == $api_checksum) {//无需更新
			$this->correos_log['request_status']	= 'cancel';
			$this->setStatusMessage(L('doc_not_change_cancel_request'));
		} else {
			$this->sale['api_checksum']	= $api_checksum;
		}
		$order['FechaOperacion']	= date('d-m-Y H:i:s');
		$order['RemitenteModif']	= $this->getShipmentOrderShipper($sale);
		$_shipmentOrder				= empty($this->correos_log['status_message']) ? $order : array();
		return $_shipmentOrder;
	}
}