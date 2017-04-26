<?php

/**
 * DHL API createShipment
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Ebay
 * @package   Model
 * @author     jph
 * @version  2.1,2016-04-21
 */
class DhlCreateShipmentPublicModel extends DhlPublicModel {

	/**
	 * 创建发货请求对象
	 * @return object
	 */
	protected function getRequestClass(){
		$_shipmentOrder		= $this->getShipmentOrder();
		if ($this->requestDataEmpty($_shipmentOrder)) {
			return false;
		}
		$requestClassName	= $this->getRequestClassName();
		return new $requestClassName($this->_version, $_shipmentOrder);
	}

	/**
	 * 解析创建发给返回结果明细
	 * @param object $result
	 * @return array
	 */
	protected function parseRequestResult($result){
		foreach ($result->CreationState as $val) {
			$value								= (Object)$val;
			$sale_id							= $value->SequenceNumber;
			$statusMessage						= $value->StatusMessage;
			$shipmentNumber						= $value->ShipmentNumber ? $value->ShipmentNumber->shipmentNumber : '';
			$request_status						= $value->StatusCode == 0 ? 'true' : 'false';
			$detail								= array(
				'shipmentNumber'	=> $shipmentNumber,
				'Labelurl'			=> $request_status == 'true' ? trim($value->Labelurl) : '',
				'request_status'	=> $request_status,
				'status_code'		=> $value->StatusCode,
				'status_message'	=> is_array($statusMessage) ? array_unique($statusMessage) : array($statusMessage),
			);
			$this->dhl_log['detail'][$sale_id]	= array_merge($this->dhl_log['detail'][$sale_id], $detail);
		}
	}

	/**
	 * 获取发货信息
	 * @return array
	 */
	protected function getShipmentOrder(){
		$_shipmentOrder	= array();
		$limit			= $this->_config['CREATE_LIMIT'];
		$count			= 0;
		$shipper_config	= $this->getShipperConfig();
		foreach ($this->sale_order_list as $sale) {
			$sale							= array_merge(array_map('trim', $sale), $shipper_config);
			$sale_id						= $sale['sale_order_id'];
			$this->initializeLogDetail($sale);
			$order							= $this->getShipmentOrderBasic($sale);
			$sale['api_checksum']			= md5(serialize($order));//生成数据校验码
			$this->sale_list[$sale_id]		= $sale;
			$order['Shipment']['ShipmentDetails']['ShipmentDate']	= date('Y-m-d');
			$order['Shipment']['Shipper']	= $this->getShipmentOrderShipper($sale);
			if (empty($this->dhl_log['detail'][$sale_id]['status_message'])) {
				$count++;
				if ($limit > 0 && $count > $limit){
					$this->setDetailStatusCode($sale_id, -2);
					$this->addDetailError($sale_id, sprintf(L('request_exceeds_limit'), $count, $limit));
				} else {
					$_shipmentOrder[]	= $order;
				}
			} else {
				$this->setDetailStatusCode($sale_id, -1);
			}
		}
		return $_shipmentOrder;
	}

	public function getShipmentOrderBasic($sale){
		$order							= array (
			'SequenceNumber'	=> $sale['sale_order_id'],
			'Shipment'			=> array (
				'ShipmentDetails'	=> $this->getShipmentOrderShipmentDetails($sale),
				'Shipper'			=> array(),//发货人信息不作为数据校验码的因子
				'Receiver'			=> $this->getShipmentOrderReceiver($sale),
			),
		);
		return $order;
	}

	/**
	 * 获取发货明细
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderShipmentDetails($sale){
		$region			= $this->getRegionByCountryID($sale['country_id']);
		$ProductCode	= is_array($this->_config['PRODUCT_CODE']) ? $this->_config['PRODUCT_CODE'][$region] : $this->_config['PRODUCT_CODE'];
		$partnerID		= is_array($this->_config['PARTNER_ID']) ? $this->_config['PARTNER_ID'][$region] : $this->_config['PARTNER_ID'];
		$shipmentDetails	= array (
			'ProductCode'	=> $ProductCode,
			'ShipmentDate'	=> '',
			'EKP'			=> $this->_config['EKP'],
			'Attendance'	=> array (
				'partnerID' => $partnerID,
			),
			'ShipmentItem' => array (
				'WeightInKG'	=> ceil($sale['weight'] * 2 / 1000) / 2,
				'PackageType'	=> $this->_config['PACKAGE_TYPE'],
			),
		);
		return $shipmentDetails;
	}

	/**
	 * 获取发货人信息
	 * @return array
	 */
	protected function getShipperConfig(){
		$fields		= array(
			'shipper_name1',
			'shipper_name2',
			'shipper_streetname',
			'shipper_streetnumber',
			'shipper_post_code',
			'shipper_city',
			'shipper_country_id',
			'shipper_contact',
			'shipper_phone',
			'shipper_email',
			'shipper_fax',
			'shipper_mobile',
		);
		foreach ($fields as $field) {
			$shipper_config[$field]	= C('dhl_' . $field);
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
			'basic_name'	=> mb_strcut($sale['shipper_name1'], 0, 30, 'UTF-8'),//仓库公司名称
			'street_name'	=> mb_strcut($sale['shipper_streetname'], 0, 30, 'UTF-8'),//街道名称
			'house_number'	=> mb_strcut($sale['shipper_streetnumber'], 0, 7), 'UTF-8',//门牌号
			'city_name'		=> mb_strcut($sale['shipper_city'], 0, 20, 'UTF-8'),//城市
		);
		//验证数据 st
		$error		= array();
		foreach ($data as $field => $value) {
			if (empty($value)) {
				$error[]	= L($field) . ': ' . L('require');
			}
		}
		$this->addDetailError($sale['sale_order_id'], $error, L('consigner'));
		//验证数据 ed
		$shipper	= array (
			'Company'		=> array (
				'Company' => array (
					'name1' => $data['basic_name'],//仓库公司名称
				),
			),
			'Address'		=> array (
				'streetName'	=> $data['street_name'],//街道名称
				'streetNumber'	=> $data['house_number'],//门牌号
				'Zip'			=> $this->getShipmentOrderZip($sale, true),//邮编
				'city'			=> $data['city_name'],//城市
				'Origin'		=> $this->getShipmentOrderAddressOrigin($sale['shipper_country_id']),
			),
			'Communication' => $this->getShipmentOrderShipperCommunication($sale),
		);
		return $shipper;
	}

	/**
	 * 获取收货人信息
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderReceiver($sale){
		$data		= array(
			'consignee'	=> mb_strcut($sale['consignee'], 0, 30, 'UTF-8'),//收货人
		);
		//验证数据 st
		$error		= array();
		foreach ($data as $field => $value) {
			if (empty($value)) {
				$error[]	= L($field) . ': ' . L('require');
			}
		}
		$this->addDetailError($sale['sale_order_id'], $error, L('consignee'));
		//验证数据 ed
		$receiver					= array (
			'Company'		=> array (
				'Company' => array (
					'name1' => $data['consignee'],//收货人
				),
			),
		);
		$this->getShipmentOrderReceiverAddress($receiver, $sale);
		$receiver['Communication']	= $this->getShipmentOrderReceiverCommunication($sale);
		return $receiver;
	}

	/**
	 * 根据国家id获取地区名称
	 * @param int $country_id
	 * @return string
	 */
	protected function getRegionByCountryID($country_id){
		switch ($country_id) {
			case C('DE_COUNTRY_ID'):
				$region	= 'germany';
				break;
			case C('UK_COUNTRY_ID'):
			case C('GB_COUNTRY_ID'):
				$region	= 'england';
				break;
			default :
				$region	= 'other';
				break;
		}
		return $region;
	}
	
	/**
	 * 获取邮编
	 * @param array $sale
	 * @param boolean $is_consigner 是否为发货人
	 * @return array
	 */
	protected function getShipmentOrderZip($sale, $is_consigner = false){
		$prefix		= $is_consigner ? 'shipper_' : '';
		$country_id	= $sale[$prefix . 'country_id'];
		$post_code	= $sale[$prefix . 'post_code'];
		$error		= array();
		if (empty($post_code)) {
			$error[]	= L('post_code') . ': ' . L('require');
		}
		$zip		= array ();
		$region		= $this->getRegionByCountryID($country_id);
		switch ($region) {
			case 'germany'://德国 长度5位
				$length			= 5;
				$zip[$region]	= mb_strcut($post_code, 0, $length, 'UTF-8');
				if (!empty($zip[$region]) && strlen($zip[$region]) != $length) {
					$error[]	= L('post_code') . ': ' . sprintf(L('post_code_length_illegal'), $length);
				}
				break;
			case 'england'://英国 字段长度<=8
				$zip[$region]	= mb_strcut($post_code, 0, 8, 'UTF-8');
				break;
			case 'other':
			default ://其他 字段长度<=10
				$zip[$region]	= mb_strcut($post_code, 0, 10, 'UTF-8');
				break;
		}
		$label		= $is_consigner ? L('consigner') : L('consignee');
		$this->addDetailError($sale['sale_order_id'], $error, $label);
		return $zip;
	}

	/**
	 * 获取国家信息
	 * @param int $country_id
	 * @return array
	 */
	protected function getShipmentOrderAddressOrigin($country_id){
		$country	= SOnly('country', $country_id);
		$origin		= empty($country) ? array() : array(
			'countryISOCode'	=> mb_strcut($country['abbr_district_name'], 0, 2, 'UTF-8'),//可选 国家代码 长度1-3位
			'country'			=> mb_strcut(reset(explode(',', $country['district_name'])), 0, 30, 'UTF-8'),//可选 国家名称
		);
		return $origin;
	}

	/**
	 * 获取发货人联系信息
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderShipperCommunication($sale){
		$communication	= array();
		if ($sale['shipper_phone'] && strlen($sale['shipper_phone']) < 20) {
			$communication['phone']			= $sale['shipper_phone'];
		}
		if ($sale['shipper_email'] && strlen($sale['shipper_email']) < 30) {
			$communication['email']			= $sale['shipper_email'];
		}
		if ($sale['shipper_mobile'] && strlen($sale['shipper_mobile']) < 20) {
			$communication['mobile']		= $sale['shipper_mobile'];
		}
		if ($sale['shipper_contact'] && strlen($sale['shipper_contact']) < 30) {
			$communication['contactPerson']	= $sale['shipper_contact'];
		}
		return $communication;
	}

	/**
	 * 设置收货人地址信息
	 * @param array &$Receiver
	 * @param array $sale
	 */
	protected function getShipmentOrderReceiverAddressOriginal(&$receiver, $sale){
		$matches	= array();
		$is_mathch	= preg_match('/^(?<Name>.+\D)(?<Number>\d+.*)$/', $sale['address'], $matches);
		$data		= array(
			'city_name'	=> mb_strcut($sale['city_name'], 0, 30, 'UTF-8'),//城市
		);
		$error		= array();
		foreach ($data as $field => $value) {
			if (empty($value)) {
				$error[]	= L($field) . ': ' . L('require');
			}
		}
		$zip		= $this->getShipmentOrderZip($sale);//邮编
		$origin		= $this->getShipmentOrderAddressOrigin($sale['country_id']);
		switch (true) {
			case stripos($sale['address'], 'Packstation'):
			case stripos($sale['address'], 'Paketestation'):
				if ($sale['country_id'] != C('DE_COUNTRY_ID')) {
					$error[]	= L('country_name') . ': ' . L('must_be_germany');
				}
				if ($matches['Number'] <= 0) {
					$error[]	= 'PackstationNumber(' . L('street1') . '): ' . L('pst_integer');
				}
				if ($sale['address2'] <= 0) {
					$error[]	= 'PostNumber(' . L('street2') . '): ' . L('pst_integer');
				}
				$receiver['Packstation']	= array (
					'PackstationNumber'	=> intval($matches['Number']),
					'PostNumber'		=> intval($sale['address2']),
					'Zip'				=> $zip['germany'],//邮编
					'City'				=> $data['city_name'],//城市
					'Origin'			=> $origin,
				);
				break;
			case stripos($sale['address'], 'Postfiliale'):
				if ($sale['country_id'] != C('DE_COUNTRY_ID')) {
					$error[]	= L('country_name') . ': ' . L('must_be_germany');
				}
				if ($matches['Number'] <= 0) {
					$error[]	= 'PostfilialNumber(' . L('street1') . '): ' . L('pst_integer');
				}
				if ($sale['address2'] <= 0) {
					$error[]	= 'PostNumber(' . L('street2') . '): ' . L('pst_integer');
				}
				$receiver['Postfiliale']	= array (
					'PostfilialNumber'	=> intval($matches['Number']),
					'PostNumber'		=> intval($sale['address2']),
					'Zip'				=> $zip['germany'],//邮编
					'City'				=> $data['city_name'],//城市
					'Origin'			=> $origin,
				);
				break;
			default :
				$street_name			= mb_strcut(trim($is_mathch ? $matches['Name'] : $sale['address']), 0, 30, 'UTF-8');
				$street_number			= mb_strcut($is_mathch ? $matches['Number'] : $sale['address2'], 0, 7, 'UTF-8');
				if (empty($street_name)) {
					$error[]	= 'streetName(' . L('street1') . '): ' . L('require');
				}
				if (empty($street_number)) {
					$error[]	= 'streetNumber(' . L('street1') . '/' . L('street2') . '): ' . L('require');
				}
				$receiver['Address']	= array (
					'streetName'	=> $street_name,//街道名称
					'streetNumber'	=> $street_number,//门牌号
					'Zip'			=> $zip,//邮编
					'city'			=> $data['city_name'],//城市
					'Origin'		=> $origin,
				);
				break;
		}
		$this->addDetailError($sale['sale_order_id'], $error, L('consignee'));
	}

	/**
	 * 设置收货人地址信息
	 * @param array &$Receiver
	 * @param array $sale
	 */
	protected function getShipmentOrderReceiverAddress(&$receiver, $sale){
		$matches	= array();
		$is_mathch	= preg_match('/^(?<Name>.+\D)(?<Number>\d+.*)$/', $sale['address'], $matches);
		$data		= array(
			'city_name'	=> mb_strcut($sale['city_name'], 0, 35, 'UTF-8'),//城市
		);
		$error		= array();
		foreach ($data as $field => $value) {
			if (empty($value)) {
				$error[]	= L($field) . ': ' . L('require');
			}
		}
		$zip		= $this->getShipmentOrderZip($sale);//邮编
		$origin		= $this->getShipmentOrderAddressOrigin($sale['country_id']);
		_mergeAddress($sale, ',', array('address', 'address2'));
		switch (true) {
			case stripos($sale['merge_address'], 'Packstation') !== false:
			case stripos($sale['merge_address'], 'Paketestation') !== false:
				if ($sale['country_id'] != C('DE_COUNTRY_ID')) {
					$error[]	= L('country_name') . ': ' . L('must_be_germany');
				}
				if ($matches['Number'] <= 0) {
					$error[]	= 'PackstationNumber(' . L('street1') . '): ' . L('pst_integer');
				}
				if ($sale['address2'] <= 0) {
					$error[]	= 'PostNumber(' . L('street2') . '): ' . L('pst_integer');
				}
				$street_name								= 'Packstation';
				$street_number								= intval($matches['Number']);
				$receiver['Company']['Company']['name2']	= intval($sale['address2']);
				break;
			case stripos($sale['merge_address'], 'Postfiliale') !== false:
				if ($sale['country_id'] != C('DE_COUNTRY_ID')) {
					$error[]	= L('country_name') . ': ' . L('must_be_germany');
				}
				if ($matches['Number'] <= 0) {
					$error[]	= 'PostfilialNumber(' . L('street1') . '): ' . L('pst_integer');
				}
				if ($sale['address2'] <= 0) {
					$error[]	= 'PostNumber(' . L('street2') . '): ' . L('pst_integer');
				}
				$street_name								= 'Postfiliale';
				$street_number								= intval($matches['Number']);
				$receiver['Company']['Company']['name2']	= intval($sale['address2']);
				break;
			case stripos($sale['merge_address'], 'ParcelShop') !== false:
				if ($matches['Number'] <= 0) {
					$error[]	= 'parcelShopNumber(' . L('street1') . '): ' . L('pst_integer');
				}
				$street_name								= mb_strcut(trim($is_mathch ? $matches['Name'] : $sale['address']), 0, 35, 'UTF-8');
				$street_number								= intval($matches['Number']);
				$receiver['Company']['Company']['name2']	= intval($sale['address2']);
				break;
			default :
				$street_name								= mb_strcut(trim(($is_mathch ? $matches['Name'] : $sale['address'])), 0, 35, 'UTF-8');
				$street_number								= mb_strcut($is_mathch ? $matches['Number'] : $sale['address2'], 0, 5, 'UTF-8');
				$receiver['Company']['Company']['name2']	= $sale['address2'];
				if (empty($street_name)) {
					$error[]	= 'streetName(' . L('street1') . '): ' . L('require');
				}
				if (empty($street_number)) {
					$error[]	= 'streetNumber(' . L('street1') . '/' . L('street2') . '): ' . L('require');
				}
				break;
		}
		$receiver['Address']	= array (
			'streetName'	=> $street_name,//街道名称
			'streetNumber'	=> $street_number,//门牌号
			'Zip'			=> $zip,//邮编
			'city'			=> $data['city_name'],//城市
			'Origin'		=> $origin,
		);
		$this->addDetailError($sale['sale_order_id'], $error, L('consignee'));
	}

	/**
	 * 获取收货人联系信息
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderReceiverCommunication($sale){
		$communication	= array();
		if ($sale['mobile'] && strlen($sale['mobile']) < 20) {
			$communication['phone']			= $sale['mobile'];
		}
		if ($sale['email'] && strlen($sale['email']) < 30) {
			$communication['email']			= $sale['email'];
		}
		if ($sale['fax'] && strlen($sale['fax']) < 50) {
			$communication['fax']			= $sale['fax'];
		}
		return $communication;
	}
}