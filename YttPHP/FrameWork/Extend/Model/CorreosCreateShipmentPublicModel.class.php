<?php

/**
 * CORREOS API createShipment
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Correos
 * @package   Model
 * @author     jph
 * @version  2.1,2016-10-21
 */
class CorreosCreateShipmentPublicModel extends CorreosPublicModel {

	/**
	 * 解析创建发给返回结果明细
	 * @param object $request_status
	 * @return array
	 */
	public function parseRequestResult($request_status){
		$this->correos_log['shipmentNumber']	= trim($request_status->Bulto->CodEnvio);
		$this->correos_log['Labelurl']			= trim($request_status->Bulto->Etiqueta->Etiqueta_pdf->NombreF);
		//保存pdf文件
		if ($request_status->Bulto->Etiqueta->Etiqueta_pdf->Fichero) {
			file_put_contents(WAY_BILL_PATH . $this->correos_log['Labelurl'], $request_status->Bulto->Etiqueta->Etiqueta_pdf->Fichero);
		}
	}

	/**
	 * 获取发货信息
	 * @return array
	 */
	public function getRequestParams(){
		$shipper_config				= $this->getShipperConfig();
		$sale						= array_merge(array_map('trim', $this->sale_order), $shipper_config);
		$check_data					= $this->getShipmentOrderBasic($sale);
		$order						= array (
			'FechaOperacion'	=> '',
			'CodEtiquetador'	=> $this->_CodEtiquetador,
			'Care'				=> '000000',//6	String	Aggregation code of shipment list. By default  000000
			'TotalBultos'		=> 1,//Integer	Always to 1.
			'ModDevEtiqueta'	=> 2,//1	String	Way in which the request is made for the label in the request answer:1.	XML. 2.	PDF
									//标签返回方式 1:xml 2:pdf
			'Remitente'			=> array(),//发货人信息不作为数据校验码的因子
			'Destinatario'		=> $check_data['Destinatario'],
			'Envio'				=> $check_data['Envio'],
		);
		$sale['api_checksum']		= md5(serialize($check_data));//生成数据校验码
		$this->sale					= $sale;
		$order['FechaOperacion']	= date('d-m-Y H:i:s');
		$order['Remitente']			= $this->getShipmentOrderShipper($sale);
		$_shipmentOrder				= empty($this->correos_log['status_message']) ? $order : array();
		return $_shipmentOrder;
	}

	public function getShipmentOrderBasic($sale){
		$order	= array(
			'Destinatario'	=> $this->getShipmentOrderReceiver($sale),
			'Envio'			=> $this->getShipmentOrderShipmentDetails($sale),
		);
		return $order;
	}

	/**
	 * 获取发货明细
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderShipmentDetails($sale){
		$shipmentDetails	= array (
			'CodProducto'			=> $this->_config['CodProducto'],
			'ReferenciaCliente'		=> $sale['sale_order_no'],//客户附加信息
			'TipoFranqueo'			=> 'FP',//-FP：邮资已付 - FM：机器盖印 - ES：现金 - ON：在线付款
			'ModalidadEntrega'		=> 'ST',//- ST：标准产品/家居 - LS：在选定的分支 -OR：在收件人的参考分支
			'Pesos'	=> array(
				'Peso'	=> array(
					'TipoPeso'	=> 'R',// R.实际重量 V.体积重
					'Valor'		=> ceil($sale['weight']),//单位克
				),
			),
		);
		return $shipmentDetails;
	}

	/**
	 * 获取发货人信息
	 * @return array
	 */
	protected function getShipperConfig(){
		$fields	= array(
			'shipper_name',
			'shipper_streetname',
			'shipper_streetnumber',
			'shipper_post_code',
			'shipper_province',
			'shipper_city',
			'shipper_contact',
			'shipper_phone',
			'shipper_email',
			'shipper_mobile',
		);
		foreach ($fields as $field) {
			$shipper_config[$field]	= C('correos_' . $field);
		}
		return $shipper_config;
	}

	/**
	 * 获取发货人(仓库)信息
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderShipper($sale){
		$data		= array(
			'basic_name'	=> mb_strcut($sale['shipper_name'], 0, 300, 'UTF-8'),//仓库公司名称
			'city_name'		=> mb_strcut($sale['shipper_city'], 0, 100, 'UTF-8'),//城市
			'post_code'		=> mb_strcut($sale['shipper_post_code'], 0, 5), 'UTF-8',//邮编
			'street_name'	=> mb_strcut($sale['shipper_streetname'], 0, 100, 'UTF-8'),//街道名称
		);
		//验证数据 st
		$error		= array();
		foreach ($data as $field => $value) {
			if (empty($value)) {
				$error[]	= L($field) . ': ' . L('require');
			}
		}
		$this->setStatusMessage($error, L('consigner'));
		//验证数据 ed
		$shipper	= array (
			'Identificacion'	=> array (
				'Nombre'	=> $data['basic_name'],//仓库公司名称
			),
			'DatosDireccion'	=> array(
				'Direccion'	=> $data['street_name'],//街道名称
				'Localidad'	=> $data['city_name'],
			),
			'DatosDireccion2'	=> NULL,
			'CP'				=> $data['post_code'],
		);
		if ($sale['shipper_contact']) {//联系人
			$shipper['Identificacion']['PesonaContacto']	= mb_strcut($sale['shipper_contact'], 0, 150, 'UTF-8');
		}
		if ($sale['shipper_streetnumber']) {//门牌号码
			$shipper['DatosDireccion']['Puerta']	= mb_strcut($sale['shipper_streetnumber'], 0, 5, 'UTF-8');
		}
		if ($sale['shipper_province']) {//省份/州
			$shipper['DatosDireccion']['Provincia']	= mb_strcut($sale['shipper_province'], 0, 40, 'UTF-8');
		}
		if ($sale['shipper_phone']) {//联系电话
			$shipper['Telefonocontacto']	= mb_strcut($sale['shipper_phone'], 0, 150, 'UTF-8');
		}
		if ($sale['shipper_email']) {//email
			$shipper['Email']	= mb_strcut($sale['shipper_email'], 0, 150, 'UTF-8');
		}
		if ($sale['shipper_mobile']) {//手机
			$shipper['DatosSMS']	= mb_strcut($sale['shipper_mobile'], 0, 150, 'UTF-8');
		}
		return $shipper;
	}

	/**
	 * 获取收货人信息
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderReceiver($sale){
		$data		= array(
			'consignee'		=> mb_strcut($sale['consignee'], 0, 30, 'UTF-8'),//收货人
			'city_name'		=> mb_strcut($sale['city_name'], 0, 100, 'UTF-8'),//城市
			'post_code'		=> mb_strcut($sale['post_code'], 0, 5), 'UTF-8',//邮编
			'street_name'	=> mb_strcut($sale['address'] . ($sale['address2'] ? ' ' . $sale['address2'] : ''), 0, 100, 'UTF-8'),//街道名称
		);
		//验证数据 st
		$error		= array();
		foreach ($data as $field => $value) {
			if (empty($value)) {
				$error[]	= L($field) . ': ' . L('require');
			}
		}
		$this->setStatusMessage($error, L('consignee'));
		//验证数据 ed
		$receiver					= array (
			'Identificacion'	=> array (
				'Nombre' => $data['consignee'],//收货人
			),
			'DatosDireccion'	=> array(
				'Direccion'	=> $data['street_name'],//街道名称
				'Localidad'	=> $data['city_name'],
			),
			'DatosDireccion2'	=> NULL,
			'CP'				=> $data['post_code'],
			'Pais'				=> SOnly('country', $sale['country_id'], 'abbr_district_name'),
		);
		if ($sale['company_name']) {//省份/州
			$receiver['DatosDireccion']['Provincia']	= mb_strcut($sale['company_name'], 0, 40, 'UTF-8');
		}
		if ($sale['mobile']) {//联系电话
			$receiver['Telefonocontacto']	= mb_strcut($sale['mobile'], 0, 150, 'UTF-8');
		}
		if ($sale['email']) {//email
			$receiver['Email']	= mb_strcut($sale['email'], 0, 150, 'UTF-8');
		}
		return $receiver;
	}
}