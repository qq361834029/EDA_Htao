<?php

/**

 * Think 标准模式公共函数库(3.0ytt开始增加的部分)
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 */

	/**
	 * 构造xml接口订单信息数组
	 * @param array $OrderInfo
	 * @return array
	 */
	function api_make_xml_order_details($OrderInfo){
		if (C('API_GET_DATA_TYPE') == 'Simple') {
			$OrderDetails	= array(
				'OrderNo'			=> $OrderInfo['order_no'],
				'ProcessNo'			=> $OrderInfo['sale_order_no'],
				'OrderState'		=> $OrderInfo['dd_sale_order_state'],
				'OrderDate'			=> $OrderInfo['fmd_order_date'],
				'ShippingDate'		=> $OrderInfo['fmd_send_date'],
			);
		} else {
			//产品明细
			$Product		= array();
			foreach ((array)$OrderInfo['detail'] as $detail){
				$Product[]	= array(
								'Sku'		=> $detail['product_no'],
								'Quantity'	=> $detail['quantity'],
							);
			}
			//其他费用合计
			if ($OrderInfo['other_fee_total']) {
				$OrderInfo['other_fee']	= array();
				foreach ($OrderInfo['other_fee_total'] as $other_fee) {
					$OrderInfo['other_fee'][]	= array(
													'Currency'	=> $other_fee['currency_no'],
													'Cost'		=> $other_fee['other_fee_total'],
												);
				}
				if (count($OrderInfo['other_fee']) == 1) {
					$tmpCost				= reset($OrderInfo['other_fee']);
					$OrderInfo['other_fee']	= $tmpCost['Cost'];
				}
			}
			$OrderDetails	= array(
				'OrderNo'			=> $OrderInfo['order_no'],
				'ProcessNo'			=> $OrderInfo['sale_order_no'],
				'ShippingCost'		=> $OrderInfo['delivery_fee'],
				'ProcessCost'		=> $OrderInfo['process_fee'],
				'PackageCost'		=> $OrderInfo['package_fee'],
				'OtherCost'			=> $OrderInfo['other_fee'],
				'TrackNo'			=> $OrderInfo['track_no'],
				'OrderState'		=> $OrderInfo['dd_sale_order_state'],
				'ShippingDate'		=> $OrderInfo['fmd_send_date'],
				'OrderDate'			=> $OrderInfo['fmd_order_date'],
				'CustomerName'		=> $OrderInfo['client_name'],
				'OrderType'			=> $OrderInfo['order_type_name'],
				'ShippingName'		=> $OrderInfo['ship_name'],
				'WarehouseName'		=> $OrderInfo['w_name'],
				'Email'				=> $OrderInfo['email'],
				'Fax'				=> $OrderInfo['fax'],
				'TaxNo'				=> $OrderInfo['tax_no'],
				'TransactionId'		=> $OrderInfo['transaction_id'],
				'Registered'		=> $OrderInfo['dd_is_registered'],
				'IsInsure'          => $OrderInfo['dd_is_insure'],
				'InsurePrice'       => $OrderInfo['edml_insure_price'],
			);
			if($OrderInfo['company_id'] == C('EXPRESS_BRT_ID') && $OrderInfo['warehouse_id'] == C('EXPRESS_IT_WAREHOUSE_ID')){
				$OrderDetails['BrtAccountNo']   = $OrderInfo['brt_account_no'];
			}
			if($OrderInfo['order_type'] == C('ALIEXPRESS')){
				$OrderDetails['AliexpressToken']   = $OrderInfo['aliexpress_token'];
			}
			$OrderDetails['Comments']		= $OrderInfo['edit_comments'];
			$OrderDetails['ShipToAddress']  = api_make_xml_ship_to_address($OrderInfo);
			$OrderDetails['Product']        = $Product;
		}
		return $OrderDetails;
	}

	/**
	 * 构造xml接口库存信息数组
	 * @param array $storage
	 * @return array
	 */
	function api_make_xml_storage($storage){
		//产品明细
		$StorageDetails		= array();
		foreach ((array)$storage['detail'] as $detail){
			$StorageDetails[]	= array(
							'WarehouseNo'	=> $detail['w_no'],
							'SaleQuantity'	=> $detail['sale_quantity'],
							'RealQuantity'	=> $detail['real_quantity'],
						);
		}
		$Storage	= array(
							'ProductID'			=> $storage['product_id'],
							'SKU'				=> $storage['product_no'],
							'SaleQuantity'		=> $storage['sale_quantity'],
							'RealQuantity'		=> $storage['real_quantity'],
							'StorageDetails'	=> $StorageDetails,
						);
		return $Storage;
	}

	/**
	 * 构造xml接口产品信息数组
	 * @param array $product
	 * @return array
	 */
	function api_make_xml_product($product){
		//产品明细
		$Product	= array(
							'ProductID'			=> $product['product_id'],
							'SKU'				=> $product['product_no'],
							'ProductName'		=> $product['product_name'],
							'CustomBarcode'		=> $product['custom_barcode'],
							'Long'				=> $product['cube_long'],
							'Width'				=> $product['cube_wide'],
							'High'				=> $product['cube_high'],
							'Weight'			=> $product['weight'],
							'HsCode'			=> $product['HsCode'],
							'SalePrice'			=> $product['SalePrice'],
							'Material'			=> $product['Material'],
							'DeclaredValue'		=> $product['DeclaredValue'],
						);
		return $Product;
	}

	/**
	 * 构造xml接口订单信息数组
	 * @param array $DocInfo
	 * @return array
	 */
	function api_make_xml_return_order_details($DocInfo){
		$DocDetails		= array(
							'ReturnOrderNo'			=> $DocInfo['return_sale_order_no'],
							'ReturnProcessNo'		=> $DocInfo['return_order_no'],
							'IsEdit'				=> $DocInfo['is_edit'],
							'IsDelete'				=> $DocInfo['is_delete'],
						);
		if (C('API_GET_DATA_TYPE') != 'Simple') {
			$DocDetails['IsRelatedSaleOrder']	= $DocInfo['is_related_sale_order'];
			$DocDetails['WarehouseNo']			= $DocInfo['w_no'];
			$DocDetails['ReturnOrderDate']		= $DocInfo['fmd_return_order_date'];
			$DocDetails['ReturnTrackNo']		= $DocInfo['return_track_no'];
			$DocDetails['ReturnLogisticsNo']    = $DocInfo['return_logistics_no'];
			$DocDetails['ProcessNo']			= $DocInfo['sale_order_no'];
			$DocDetails['OrderNo']				= $DocInfo['order_no'];
			$DocDetails['CustomerName']			= $DocInfo['client_name'];
			$DocDetails['TrackNo']				= $DocInfo['track_no'];
			$DocDetails['OrderDate']			= $DocInfo['fmd_order_date'];
			$DocDetails['ReturnFee']			= $DocInfo['return_fee'];
			$DocDetails['ReturnAdditionalFee']	= $DocInfo['return_additional_fee'];
			$DocDetails['Email']				= $DocInfo['email'];
			$DocDetails['Fax']					= $DocInfo['fax'];
			$DocDetails['TaxNo']				= $DocInfo['tax_no'];
			$DocDetails['ReturnOrderState']		= $DocInfo['return_sale_order_state'];
			$DocDetails['ReturnReason']			= $DocInfo['dd_return_reason'];
			$DocDetails['ShipToAddress']		= api_make_xml_ship_to_address($DocInfo);
			//产品明细
			$Product							= array();
			foreach ((array)$DocInfo['detail'] as $detail){
				$Product[]	= array(
								'Sku'				=> $detail['product_no'],
								'SaleOrderNumber'	=> $detail['sale_order_number'],
								'ReturnQuantity'	=> $detail['quantity'],
								'ReturnService'		=> api_make_xml_return_service($detail['return_service']),
							);
			}
			$DocDetails['Product']			= $Product;
		}
		return $DocDetails;
	}

	/**
	 * 构造xml接口退货服务信息数组
	 * @param array $DocList
	 * @return array
	 */
	function api_make_xml_return_service($DocList){
		//退货服务
		foreach ($DocList as $DocInfo) {
		$ReturnService[]	= array(
								'ReturnServiceNo'	=> $DocInfo['return_service_no'],
								'ItemNumber'		=> $DocInfo['item_number'],
								'Quantity'			=> $DocInfo['quantity'],
							);
		}
		return $ReturnService;
	}
	
	/**
	 * 构造xml接口删除订单信息数组
	 * @param type $DocInfo
	 * @return array
	 */
	function api_make_xml_delete_order($DocInfo){
		$DocBasic	= api_make_doc_basic($DocInfo);
		$DocDetails	= array(
						'OrderNo'		=> $DocInfo['order_no'],
						'TransactionId'	=> $DocInfo['transaction_id'],
						'ProcessNo'		=> $DocInfo['sale_order_no'],
					);
		return array_merge($DocBasic, $DocDetails);
	}

	/**
	 * 构造xml接口新增订单信息数组
	 * @param type $DocInfo
	 * @return array
	 */
	function api_make_add_order($DocInfo){
		$DocBasic	= api_make_doc_basic($DocInfo);
		$DocDetails	= array(
						'OrderNo'		=> $DocInfo['order_no'],
						'TransactionId'	=> $DocInfo['transaction_id'],
						'ProcessNo'		=> $DocInfo['sale_order_no'],
						'ShippingCost'	=> $DocInfo['delivery_fee'],
					);
		return array_merge($DocBasic, $DocDetails);
	}

	/**
	 * 构造xml接口新增发货单信息数组
	 * @param type $DocInfo
	 * @return array
	 */
	function api_make_add_return_order($DocInfo){
		$DocBasic	= api_make_doc_basic($DocInfo);
		$DocDetails	= array(
						'OrderNo'			=> $DocInfo['order_no'],
						'ReturnProcessNo'	=> $DocInfo['return_order_no'],
						'ReturnOrderNo'		=> $DocInfo['return_sale_order_no'],
					);
		return array_merge($DocBasic, $DocDetails);
	}

	/**
	 * 构造xml接口删除发货单信息数组
	 * @param type $DocInfo
	 * @return array
	 */
	function api_make_delete_return_order($DocInfo){
		$DocBasic	= api_make_doc_basic($DocInfo);
		$DocDetails	= array(
						'ReturnProcessNo'	=> $DocInfo['return_order_no'],
					);
		return array_merge($DocBasic, $DocDetails);
	}

	/**
	 * 构造xml接口新增发货单信息数组
	 * @param type $DocInfo
	 * @return array
	 */
	function api_make_add_shipping($DocInfo){
		$DocBasic	= api_make_doc_basic($DocInfo);
		$DocDetails	= array(
						'InstockNo'		=> $DocInfo['instock_no'],
						'ContainerNo'	=> $DocInfo['container_no'],
						'InstockId'		=> $DocInfo['id'],
					);
		return array_merge($DocBasic, $DocDetails);
	}

	/**
	 * 构造订单
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_sale_order_details_basic($data){
		//销售单信息
		$OrderDetails						= array();
		$OrderDetails['order_no']			= $data['OrderNo'];
		$OrderDetails['order_date']			= api_get_date($data['OrderDate']);
		$OrderDetails['express_id']			= DdToId('shipping', strtoupper($data['ShippingName']));
		$OrderDetails['order_type']			= $data['OrderType'];
		$OrderDetails['warehouse_id']		= DdToId('warehouse', strtoupper($data['WarehouseNo']));
		$OrderDetails['is_registered']		= $data['Registered'];
        if(isset($data['IsInsure'])){
            $OrderDetails['is_insure']          = $data['IsInsure'];
        }
		$OrderDetails['disabled_package']	= 1;//API新增订单禁止填写包裹号进行拆分包裹
		$OrderDetails['from_type']			= 'apiimport';///用来减少不必要的判断
		api_optional_fields_process($OrderDetails, $data, C('API_' . API_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS'));
		return $OrderDetails;
	}

	/**
	 * 构造订单明细
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_sale_order_details_product($data){
		$detail							= array();
		foreach ((array)$data['Product'] as $val){
			if (!empty($val['Sku'])) {
				$product_no[$val['Sku']]	= $val['Sku'];
			}
		}
		if ($product_no) {
			$product	= getProductIdByFactory($product_no, C('API_FACTORY_ID'));
		}
		foreach ((array)$data['Product'] as $val){
			$product_no	= $val['Sku'];
			if (empty($product_no)) {
				continue;
			}
			if (!isset($detail[$product_no])) {
				$detail[$product_no]	= array(
								'quantity'			=> $val['Quantity'],
								'product_id'		=> isset($product[$product_no]) ? $product[$product_no] : 0,
								'product_no'		=> $product_no,
								'warehouse_id'		=> DdToId('warehouse', strtoupper($data['WarehouseNo'])),
							);
			} else {
				$detail[$product_no]['quantity']	+= $val['Quantity'];
			}
		}
		sort($detail);
		return $detail;
	}

	/**
	 * 构造订单收货人信息
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_ship_to_address($data){
		$addition						= array();
		api_optional_fields_process($addition, $data, C('API_' . API_PARSE_MODULE_NAME . '_DETAIL_FIELDS'), true);
//		$addition['email']				= $data['Email'];
//		$addition['tax_no']				= $data['TaxNo'];
//		$addition['fax']				= $data['Fax'];
		$addition['consignee']			= $data['ShipToAddress']['Name'];
		$addition['address']			= $data['ShipToAddress']['Street1'];
		api_optional_fields_process($addition, $data['ShipToAddress'], C('API_' . API_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS.ShipToAddress'));
//		$addition['address2']			= $data['ShipToAddress']['Street2'];
//		$addition['mobile']				= $data['ShipToAddress']['Phone'];
//		$addition['company_name']		= $data['ShipToAddress']['StateOrProvince'];
		$addition['city_name']			= $data['ShipToAddress']['CityName'];
		$addition['post_code']			= $data['ShipToAddress']['PostalCode'];
		$addition['country_name']		= $data['ShipToAddress']['CountryName'];
		$addition['country_id']			= (string)DdToId('country', strtoupper($data['ShipToAddress']['Country'])); //国家代码
		$addition['from_type']			= 'apiimport';///用来减少不必要的判断
		return $addition;
	}

	/**
	 * 构造订单明细
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_return_sale_order_details_product($data){
		$detail	= array();
		foreach ((array)$data['Product'] as $val){
			if (!empty($val['Sku'])) {
				$product_no[$val['Sku']]	= $val['Sku'];
			}
		}
		if ($product_no) {
			$product	= getProductIdByFactory($product_no, C('API_FACTORY_ID'));
		}
		foreach ((array)$data['Product'] as $val){
			$product_no		= $val['Sku'];
			if (empty($product_no)) {
				continue;
			}
			$return_service	= api_make_return_sale_order_details_return_service($val);
			$unique_key		= $product_no;
			if (!isset($detail[$unique_key])) {
				$detail[$unique_key]				= array(
														'product_id'		=> isset($product[$product_no]) ? $product[$product_no] : 0,
														'product_no'		=> $product_no,
														'sale_order_number'	=> 0,
														'quantity'			=> $val['ReturnQuantity'],
														'return_service'	=> $return_service,
													);
			} else {
				$detail[$unique_key]['quantity']	+= $val['ReturnQuantity'];
				foreach ($return_service as $u_k => $service) {
					$service['quantity']							+= $detail[$unique_key]['return_service'][$u_k]['quantity'];
					$detail[$unique_key]['return_service'][$u_k]	= $service;
				}
			}
		}
		sort($detail);
		return $detail;
	}

	/**
	 * 构造订单明细
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_return_sale_order_details_return_service($data){
		$detail					= array();
		foreach ((array)$data['ReturnService'] as $val){
			$return_service_no	= $val['ReturnServiceNo'];
			$item_number		= $val['ItemNumber'];
			if (empty($return_service_no)) {
				continue;
			}
			$unique_key	= $return_service_no . '_' . $item_number;
			if (!isset($detail[$unique_key])) {
				$return_service_id					= getReturnServiceId($return_service_no);
				$detail[$unique_key]				= array(
														'return_service_id'			=> getReturnServiceId($return_service_no),
														'return_service_no'			=> $return_service_no,
														'service_detail_id'			=> getReturnServiceItemNumberId($item_number, $return_service_id),
														'item_number'				=> $item_number,
														'quantity'					=> $val['Quantity'],
														'price'						=> 0,
													);
			} else {
				$detail[$unique_key]['quantity']	+= $val['Quantity'];
			}
		}
		return $detail;
	}

	/**
	 * 构造xml接口产品信息数组
	 * @param type $DocInfo
	 * @return array
	 */
	function api_make_xml_product_detail($DocInfo){
		$DocBasic	= api_make_doc_basic($DocInfo);
		$DocDetails	= array(
						'SKU'		=> $DocInfo['product_no'],
						'ProductId'	=> $DocInfo['id'],
					);
		return array_merge($DocBasic, $DocDetails);
	}

	/**
	 * 构造产品
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_product($data){
		//销售单信息
		$Product					= array();
		$Product['from_type']		= 'apiimport';///用来减少不必要的判断
		$Product['factory_id']		= C('API_FACTORY_ID');
		$Product['product_no']		= $data['SKU'];
		$Product['product_name']	= $data['ProductName'];
		api_optional_fields_process($Product, $data, C('API_' . API_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS'));
		$Product['product_type']	= C('multiple_product_type') != 1 ? C('PRODUCT_TYPE_SIMPLE_PRODUCT') : $data['ProductType'];
        $custom_barcode  = isCustomBarcode(C('API_FACTORY_ID'));
        if($custom_barcode['is_custom_barcode'] == 1 && API_NAME == 'AddProduct'){
            $Product['custom_barcode']  = $data['CustomBarcode'];
        }
		return $Product;
	}

	/**
	 * 构造产品明细
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_product_detail($data){
		$product_detail	= array();
		foreach (C('API_PRODUCT_DETAIL_FIELDS') as $properties_id=>$filed) {
			if (array_key_exists($filed, $data)) {
				$product_detail[]	= array(
										'properties_id'	=> $properties_id,
										'value'			=> $data[$filed]
									);
			}
		}
		return $product_detail;
	}

	/**
	 * 构造子产品明细
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_product_son($data){
		$detail	= array();
		if (C('multiple_product_type') != 1 || $data['ProductType'] != C('PRODUCT_TYPE_COMBINATION_PRODUCT')) {//非组合产品直接过滤子产品明细
			return $detail;
		}
		foreach ((array)$data['SubSKU'] as $val){
			if (!empty($val['SKU'])) {
				$product_no[$val['SKU']]	= $val['SKU'];
			}
		}
		if ($product_no) {
			$product	= getProductIdByFactory($product_no, C('API_FACTORY_ID'));
		}
		foreach ((array)$data['SubSKU'] as $val){
			$product_no	= $val['SKU'];
			if (empty($product_no)) {
				continue;
			}
			if (!isset($detail[$product_no])) {
				$detail[$product_no]	= array(
											'quantity'			=> $val['Quantity'],
											'product_son_id'	=> isset($product[$product_no]) ? $product[$product_no] : 0,
											'product_no'		=> $product_no,
										);
			} else {
				$detail[$product_no]['quantity']	+= $val['Quantity'];
			}
		}
		sort($detail);
		return $detail;
	}

	/**
	 * 构造发货单
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_instock_details_basic($data){
		//销售单信息
		$InstockDetails						= array();
		$InstockDetails['from_type']		= 'apiimport';///用来减少不必要的判断
		$InstockDetails['go_date']			= api_get_date($data['InstockDate']);
		$InstockDetails['delivery_date']	= api_get_date($data['DeliveryDate']);
		$InstockDetails['warehouse_id']		= DdToId('warehouse', strtoupper($data['WarehouseNo']));
		$InstockDetails['head_way']			= $data['TransportType'];
        if($InstockDetails['head_way'] == 1){
            $InstockDetails['container_type']	= $data['ContainerType'];
        }
		$InstockDetails['is_get']			= $data['IsGet'];
        if($InstockDetails['is_get'] == 1){
            $InstockDetails['get_address']      = $data['GetAddress'];
        }
		api_optional_fields_process($InstockDetails, $data, C('API_' . API_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS'));
		if (array_key_exists('logistics_id', $InstockDetails)) {
			$InstockDetails['logistics_id']		= (int)DdToId('logistics', strtoupper($InstockDetails['logistics_id']));
		}
		if (array_key_exists('arrive_date', $InstockDetails)) {
			$InstockDetails['arrive_date']		= api_get_date($InstockDetails['arrive_date']);
		}
		return $InstockDetails;
	}

	/**
	 * 构造发货单箱号明细
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_instock_details_box($data){
		$detail				= array();
		$optional_fields	= C('API_' . API_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS.BoxDetail');
		foreach ((array)$data['BoxDetail'] as $val){
			$box_no	= $val['BoxNo'];
			if (empty($box_no)) {
				continue;
			}
			$detail[$box_no]	= array(
									'box_no'	=> $box_no,
									'cube_long'	=> $val['Long'],
									'cube_wide'	=> $val['Width'],
									'cube_high'	=> $val['High'],
									'weight'	=> $val['Weight'],
								);
			api_optional_fields_process($detail[$box_no], $val, $optional_fields);
		}
		if (!empty($detail)) {
			$where		= array('i.instock_no' => $data['InstockNo'], 'box_no' => array('in', array_keys($detail)));
			$box_ids	= M('InstockBox')->alias('ib')->join('__INSTOCK__ i on i.id=ib.instock_id')->where($where)->getField('box_no, ib.id');
			foreach ($box_ids as $box_no => $box_id) {
				$detail[$box_no]['id']	= $box_id;
			}
		}
		sort($detail);
		return $detail;
	}

	/**
	 * 构造发货单产品明细
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_instock_details_product($data){
		$detail				= array();
		$optional_fields	= C('API_' . API_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS.ProductDetail');
		foreach ((array)$data['ProductDetail'] as $val){
			if (!empty($val['SKU'])) {
				$product_no[$val['SKU']]	= $val['SKU'];
			}
		}
		if ($product_no) {
			$product	= getProductIdByFactory($product_no, C('API_FACTORY_ID'));
		}
		foreach ((array)$data['ProductDetail'] as $val){
			$product_no	= $val['SKU'];
			if (empty($product_no)) {
				continue;
			}
			$box_no		= $val['BoxNo'];
			$unique_key	= $product_no . '_' . $box_no;
			if (!array_key_exists($unique_key, $detail)) {
				$detail[$unique_key]	= array(
								'box_no'			=> $box_no,
								'product_id'		=> isset($product[$product_no]) ? $product[$product_no] : 0,
								'product_no'		=> $product_no,
								'quantity'			=> $val['Quantity'],
							);
				api_optional_fields_process($detail[$unique_key], $val, $optional_fields);
			} else {
				$detail[$unique_key]['quantity']	+= $val['Quantity'];
			}
			$detail[$unique_key]['accepting_quantity']	= $detail[$unique_key]['quantity'];
		}
		sort($detail);
		return $detail;
	}

	/**
	 * 构造退货单基本信息
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_return_sale_order_details_basic($data){
		//销售单信息
		$ReturnSaleOrderDetails								= array();
		$ReturnSaleOrderDetails['from_type']				= 'apiimport';///用来减少不必要的判断
		$ReturnSaleOrderDetails['is_related_sale_order']	= $data['IsRelatedSaleOrder'];
		$ReturnSaleOrderDetails['warehouse_id']				= DdToId('warehouse', strtoupper($data['WarehouseNo']));
		$ReturnSaleOrderDetails['return_order_date']		= api_get_date($data['ReturnOrderDate']);
		$ReturnSaleOrderDetails['return_track_no']			= $data['ReturnTrackNo'];
		$ReturnSaleOrderDetails['return_logistics_no']      = $data['ReturnLogisticsNo'];

		api_optional_fields_process($ReturnSaleOrderDetails, $data, C('API_' . API_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS'));
		if ($ReturnSaleOrderDetails['is_related_sale_order'] == C('IS_RELATED_SALE_ORDER')) {//关联处理单号
			$ReturnSaleOrderDetails['sale_order_no']		= $data['ProcessNo'];
		} else {
			$ReturnSaleOrderDetails['order_no']				= $data['OrderNo'];
		}
		return $ReturnSaleOrderDetails;
	}
	
	/**
	 * 构造产品
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_product_details($data){
		//产品信息
		$Product					= api_make_product($data);
		switch (API_NAME) {
			case 'AddProduct':
				$Product['check_status']	= C('CHECK_STATUS_WAIT_CHECK');//查验状态：0未查验
				break;
			case 'ModifyProduct':
				$Product['id']				= $data['ProductId'];
				break;
		}

		//产品明细
		$Product['product_detail']	= api_make_product_detail($data);

		//子产品明细
		$Product['product_son']		= api_make_product_son($data);
		unset($data);
		return $Product;
	}

	/**
	 * 构造订单
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_sale_order_details($data){
		//销售单信息
		$OrderDetails	= api_make_sale_order_details_basic($data);
		//销售单收货信息
		$addition		= api_make_ship_to_address($data);

		switch (API_NAME) {
			case 'AddOrder':
				$OrderDetails['factory_id']			= C('API_FACTORY_ID');
				$OrderDetails['sale_order_state']	= C('SALE_ORDER_STATE_PENDING');
				$addition['factory_id']				= C('API_FACTORY_ID');
				$addition['comp_type']				= C('API_DEFAULTCONFIG_CLIENT_TYPE');
				$addition['comp_name']				= $data['CustomerName'];
				break;
			case 'ModifyOrder':
				$OrderDetails['sale_order_no']	= $data['ProcessNo'];
				break;
		}

		$OrderDetails['addition'][1]	= $addition;
		//销售单明细
		$OrderDetails['detail']			= api_make_sale_order_details_product($data);
		unset($data);
		return $OrderDetails;
	}

	/**
	 * 构造发货单
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_instock_details($data){
		//发货单信息
		$InstockDetails	= api_make_instock_details_basic($data);

		switch (API_NAME) {
			case 'AddShipping':
				$InstockDetails['factory_id']		= C('API_FACTORY_ID');
				$InstockDetails['instock_type']		= C('CFG_INSTOCK_TYPE_WAIT_AUDIT');
				break;
			case 'ModifyShipping':
				$InstockDetails['instock_no']		= $data['InstockNo'];
				$InstockDetails['id']				= $data['InstockId'];
				break;
		}

		//箱号明细
		$InstockDetails['box']		= api_make_instock_details_box($data);
		//产品明细
		$InstockDetails['product']	= api_make_instock_details_product($data);
		unset($data);
		return $InstockDetails;
	}

	/**
	 * 构造退货单
	 * @param mixed $data
	 * @return array
	 */
	function  api_make_return_sale_order_details($data){
		//发货单信息
		$ReturnSaleOrderDetails	= api_make_return_sale_order_details_basic($data);
		if ($ReturnSaleOrderDetails['is_related_sale_order'] != C('IS_RELATED_SALE_ORDER')) {//不关联处理单号
			//销售单收货信息
			$addition				= api_make_ship_to_address($data);
		}

		switch (API_NAME) {
			case 'AddReturnOrder':
				$ReturnSaleOrderDetails['factory_id']				= C('API_FACTORY_ID');
				$ReturnSaleOrderDetails['return_sale_order_state']	= C('RETURN_SALE_ORDER_STATE_WAIT_RETURN_WAREHOUSE');
				if ($ReturnSaleOrderDetails['is_related_sale_order'] != C('IS_RELATED_SALE_ORDER')) {//不关联处理单号
					$addition['factory_id']	= C('API_FACTORY_ID');
					$addition['comp_type']	= C('API_DEFAULTCONFIG_CLIENT_TYPE');
					$addition['comp_name']	= $data['CustomerName'];
				}
				break;
		}
		if ($ReturnSaleOrderDetails['is_related_sale_order'] != C('IS_RELATED_SALE_ORDER')) {//不关联处理单号
			$ReturnSaleOrderDetails['addition']	= $addition;
		}
		//退货单明细
		$ReturnSaleOrderDetails['detail']			= api_make_return_sale_order_details_product($data);

		unset($data);
		return $ReturnSaleOrderDetails;
	}

	/**
	 * 获取订单列表搜索条件
	 * @param array $requestData
	 * @return array
	 */
	function api_get_order_list_where($requestData){
		$where				= array(
								'factory_id'	=> C('API_FACTORY_ID'),
							);
		$complex			= array();
		!empty($requestData['ProcessNo']) && $complex['sale_order_no']	= array('in', $requestData['ProcessNo']);
		!empty($requestData['OrderNo']) && $complex['order_no']			= array('in', $requestData['OrderNo']);
		if (count($complex) > 1) {
			$complex['_logic']	= 'or';
			$where['_complex']	= $complex;
		} else {
			$where	= array_merge($where, $complex);
		}
		//日期处理
		$where_string	= array();
		$date_fields	= array('OrderDate'=>'date(order_date)', 'ShippingDate'=>'date(send_date)', 'ModifyDate'=>'update_time');
		foreach ($date_fields as $date=>$field) {
			if (!empty($requestData[$date]['StartTime'])) {
				$where_string[]	= $field . ">='" . $requestData[$date]['StartTime'] . "'";
			}
			if (!empty($requestData[$date]['EndTime'])) {
				$where_string[]	= $field ."<='" . $requestData[$date]['EndTime'] . "'";
			}
		}
		if (count($where_string) > 0) {
			$where['_string']	= implode(' and ', $where_string);
		}
		//订单状态处理
		isset($requestData['OrderState']) && $where['sale_order_state']	= intval($requestData['OrderState']);
		return $where;
	}

	/**
	 * 获取库存列表信息
	 * @param array $requestData
	 * @param object $api
	 * @return array
	 */
	function api_get_storage_list($requestData, $api){
		$where			= array(
							'factory_id'	=> C('API_FACTORY_ID'),
						);
		!empty($requestData['ProductID']) && $where['p.id']	= array('in', $requestData['ProductID']);
		!empty($requestData['SKU']) && $where['p.product_no']	= array('in', $requestData['SKU']);
		isset($requestData['warehouse_id']) && $where['warehouse_id']	= $requestData['warehouse_id'];
		unset($requestData);
		$model			= M();
		$order			= 'ORDER BY product_no DESC';
		$left_product	= 'RIGHT JOIN __PRODUCT__ p ON p.id=a.product_id';
		$sale_fields	= 'p.product_no, a.warehouse_id, p.id as product_id, a.quantity AS sale_qn, 0 AS real_qn';
		$real_fields	= 'p.product_no, a.warehouse_id, p.id as product_id, 0 AS sale_qn, a.quantity AS real_qn';
		$sale_table		= array('__SALE_STORAGE__'=>'a');
		$real_table		= array('__STORAGE__'=>'a');
		$sale_sql		= $model->table($sale_table)->join($left_product)->field($sale_fields)->where($where)->buildSql();
		$real_sql		= $model->table($real_table)->join($left_product)->field($real_fields)->where($where)->buildSql();
		$ids_sql		= 'SELECT product_id FROM (' . $sale_sql . ' UNION ALL ' . $real_sql . ') AS tmp GROUP BY product_id ' . $order;
		$rs				= $model->query($ids_sql);
		foreach ($rs as $val) {
			$product_ids[$val['product_id']]	= $val['product_id'];
		}
		unset($rs);
		$storageList	= array();
		if (count($product_ids) > 0) {
			$product_ids	= $api->setPage($product_ids);
			$where['p.id']	= array('in', $product_ids);
			unset($where['p.product_no']);
			$sale_sql		= $model->table($sale_table)->join($left_product)->field($sale_fields)->where($where)->buildSql();
			$real_sql		= $model->table($real_table)->join($left_product)->field($real_fields)->where($where)->buildSql();
			$sql			= 'SELECT tmp.*, w.w_no, sum(sale_qn) AS sale_quantity, sum(real_qn) AS real_quantity FROM
								(' . $sale_sql . ' UNION ALL ' . $real_sql . ') AS tmp
								LEFT JOIN warehouse w on w.id=tmp.warehouse_id
								GROUP BY warehouse_id, product_id
								' . $order;
			$rs				= $model->query($sql);
			foreach($rs as $storage){
				if (!isset($storageList[$storage['product_id']])) {
					$storageList[$storage['product_id']]					= $storage;
					$storageList[$storage['product_id']]['sale_quantity']	= 0;
					$storageList[$storage['product_id']]['real_quantity']	= 0;
				}
				$storageList[$storage['product_id']]['sale_quantity']		+= $storage['sale_quantity'];
				$storageList[$storage['product_id']]['real_quantity']		+= $storage['real_quantity'];
				if ($storage['warehouse_id'] > 0) {
					$storageList[$storage['product_id']]['detail'][]		= $storage;
				}
			}
		}
		return $storageList;
	}

	function api_get_product_list($requestData, $api){
		$where			= array(
							'factory_id'	=> C('API_FACTORY_ID'),
						);
		!empty($requestData['ProductID']) && $where['id']	= array('in', $requestData['ProductID']);
		!empty($requestData['SKU']) && $where['product_no']	= array('in', $requestData['SKU']);
		unset($requestData);
		$model			= M(API_MODULE_NAME);
		$order			= 'id DESC';
		$product_ids	= $model->where($where)->order($order)->getField('id', true);
		$productList	= array();
		if (count($product_ids) > 0) {
			$product_ids	= $api->setPage($product_ids);
			$where['id']	= array('in', $product_ids);
			unset($where['product_no']);
			$fields			= 'id as product_id, product_no, product_name,custom_barcode,
								if(check_status=1, check_weight, weight) as weight,
								if(check_status=1, check_high, cube_high) as cube_high,
								if(check_status=1, check_wide, cube_wide) as cube_wide,
								if(check_status=1, check_long, cube_long) as cube_long';
			$rs				= $model->field($fields)->where($where)->order($order)->select();
			foreach($rs as $product){
				$productList[$product['product_id']]	= $product;
			}
			$_detail_fileds = C('API_' . API_PARSE_MODULE_NAME . '_DETAIL_FIELDS');
			$where			= array(
								'product_id'	=> array('in', $product_ids),
								'properties_id'	=> array('in', array_keys($_detail_fileds)),
							);
			$product_detail	= M('ProductDetail')->where($where)->select();
			foreach ((array)$product_detail as $detail) {
				$productList[$detail['product_id']][$_detail_fileds[$detail['properties_id']]]	= $detail['value'];
			}
		}
		return $productList;
	}


	/**
	 * 获取退货单列表搜索条件
	 * @param array $requestData
	 * @return array
	 */
	function api_get_return_order_list_where($requestData){
		$where			= array(
							'factory_id'	=> C('API_FACTORY_ID'),
						);
		!empty($requestData['ReturnProcessNo']) && $where['return_order_no']	= array('in', $requestData['ReturnProcessNo']);
		//日期处理
		$where_string	= array();
		$date_fields	= array('ReturnOrderDate'=>'date(return_order_date)', 'UpdateTime'=>'update_time');
		foreach ($date_fields as $date=>$field) {
			if (!empty($requestData[$date]['StartTime'])) {
				$where_string[]	= $field . ">='" . $requestData[$date]['StartTime'] . "'";
			}
			if (!empty($requestData[$date]['EndTime'])) {
				$where_string[]	= $field ."<='" . $requestData[$date]['EndTime'] . "'";
			}
		}
		if (count($where_string) > 0) {
			$where['_string']	= implode(' and ', $where_string);
		}
		return $where;
	}

	/**
	 *
	 * @param array $Product
	 * @param array $product_ids
	 */
	function api_fill_product_detail(&$Product, $product_ids){
		if (!empty($product_ids)) {//填充产品明细信息
			$rs						= M('ProductDetail')->where(array('product_id' => array('in', $product_ids)))->select();
			$product_detail_list	= array();
			foreach ($rs as $v) {
				$product_detail_list[$v['product_id']][$v['properties_id']]	= $v;
			}
			foreach ($Product as &$ProductInfo) {
				$product_detail	= $product_detail_list[$ProductInfo['id']];
				if (empty($product_detail)) {
					continue;
				}
				foreach ($ProductInfo['product_detail'] as $ProductDetail) {
					if (array_key_exists($ProductDetail['properties_id'], $product_detail)) {
						$product_detail[$ProductDetail['properties_id']]['value']	= $ProductDetail['value'];
					}
				}
				$ProductInfo['product_detail']	= $product_detail;
			}
		}
	}

	function api_return_sale_order_fill_related_sale_order_info($requestData){
		$process_no_list	= array();
		foreach ($requestData[API_DETAILS_KEY] as $val) {
			if ($val['is_related_sale_order'] == C('IS_RELATED_SALE_ORDER') && api_valid_process_no($val['sale_order_no'])) {//关联处理单号
				$process_no_list[$val['sale_order_no']]	= $val['sale_order_no'];
			}
		}
		if (!empty($process_no_list)) {
			$where			= array(
								'factory_id'	=> C('API_FACTORY_ID'),
								'sale_order_no' => array('in', $process_no_list)
							);
			$addition_list	= M('SaleOrder')->join('s left join __SALE_ORDER_ADDITION__ sa on s.id=sa.sale_order_id')->where($where)->getField('s.sale_order_no, s.id as sale_order_id, s.client_id, s.order_no, sa.consignee, sa.country_name, sa.country_id, sa.city_name, sa.email, sa.tax_no, sa.address, sa.address2, sa.company_name, sa.post_code, sa.mobile, sa.fax');
			$sale_qn_list	= M('SaleOrder')->join('s left join __SALE_ORDER_DETAIL__ sd on s.id=sd.sale_order_id')->field('concat(s.id,"_", sd.product_id) as unique_key, sum(sd.quantity) as quantity')->where($where)->group('s.id, sd.product_id')->getField('unique_key, quantity');
			foreach ($requestData[API_DETAILS_KEY] as &$val) {
				if ($val['is_related_sale_order'] != C('IS_RELATED_SALE_ORDER') || !isset($addition_list[$val['sale_order_no']])) {//不关联处理单号或处理单号无效
					continue;
				}
				$val['addition']		= $addition_list[$val['sale_order_no']];
				$val['sale_order_id']	= $val['addition']['sale_order_id'];
				$val['order_no']		= $val['addition']['order_no'];
				$val['client_id']		= $val['addition']['client_id'];
				unset($val['addition']['sale_order_id'], $val['addition']['order_no'], $val['addition']['client_id']);
				foreach ($val['detail'] as &$product) {
					$product['sale_order_number']	= (int)$sale_qn_list[$val['sale_order_id'] . '_' . $product['product_id']];
				}
			}
		}
		return $requestData;
	}

	function api_valid_return_service(&$DocInfo, &$return_error){
		$tips	= C(API_PARSE_MODULE_NAME . '_IMPORT_TIPS');
		foreach ($DocInfo['detail'] as &$product) {
			$return_service_quantity	= 0;
			$ReturnService				= array();
			foreach ($product['return_service'] as $return_service) {
				if ($return_service['return_service_id'] <= 0) {//退货服务编号不存在
					$return_error['return_service_no_' . $return_service['return_service_no']]	= ($tips['return_service_no'] ? $tips['return_service_no'] : L('return_service_no')) . $return_service['return_service_no'] . ': 不存在!';
				}
				if ($return_service['service_detail_id'] <= 0) {//退货服务项目编号不存在
					$return_error['item_number_' . $return_service['item_number']]	= ($tips['item_number'] ? $tips['item_number'] : L('item_number')) . $return_service['item_number'] . ': 不存在!';
				}
				$return_service_quantity	+= $return_service['quantity'];
				$ReturnService[]			= array(
												0	=> $return_service['service_detail_id'],
												1	=> $return_service['quantity'],
												2	=> $return_service['price'],
											);
			}
			if ($return_service_quantity > $product['quantity']) {//退货服务总数量不得大于退货数量
				$return_error['return_service_quantity_' . $product['product_no']]	= L('product_no') .'[' . $product['product_no'] . ']: 退货服务总数量不得大于退货数量!';
			}
			$product['return_service']	= json_encode($ReturnService);
		}
	}
    /**
	 * 构造xml接口删除发货单信息数组
	 * @param type $DocInfo
	 * @return array
	 */
	function api_make_delete_instock($DocInfo){
		$DocBasic	= api_make_doc_basic($DocInfo);
		$DocDetails	= array(
						'InstockNo'	=> $DocInfo['instock_no'],
					);
		return array_merge($DocBasic, $DocDetails);
	}

    /**
	 * 获取发货单列表搜索条件
	 * @param array $requestData
	 * @return array
	 */
	function api_get_instock_list_where($requestData){
		$where			= array(
							'factory_id'	=> C('API_FACTORY_ID'),
						);
		!empty($requestData['InstockNo']) && $where['instock_no']	= array('in', $requestData['InstockNo']);
		//日期处理
		$where_string	= array();
		$date_fields	= array('InstockDate'=>'date(go_date)');
		foreach ($date_fields as $date=>$field) {
			if (!empty($requestData[$date]['StartTime'])) {
				$where_string[]	= $field . ">='" . $requestData[$date]['StartTime'] . "'";
			}
			if (!empty($requestData[$date]['EndTime'])) {
				$where_string[]	= $field ."<='" . $requestData[$date]['EndTime'] . "'";
			}
		}
		if (count($where_string) > 0) {
			$where['_string']	= implode(' and ', $where_string);
		}
		return $where;
	}
    
    /**
	 * 构造xml接口订单信息数组
	 * @param array $DocInfo
	 * @return array
	 */
	function api_make_xml_instock_details($DocInfo){
		$DocDetails		= array(
							'InstockNo'             => $DocInfo['instock_no'],
							'IsEdit'				=> $DocInfo['is_edit'],
							'IsDelete'				=> $DocInfo['is_delete'],
						);
		if (C('API_GET_DATA_TYPE') != 'Simple') {
			$DocDetails['InstockType']      = $DocInfo['instock_type'];
			$DocDetails['InstockNo']        = $DocInfo['instock_no'];
			$DocDetails['InstockId']		= $DocInfo['instock_id'];
			$DocDetails['InstockDate']		= $DocInfo['instock_date'];
			$DocDetails['DeliveryDate']     = $DocInfo['delivery_date'];
			$DocDetails['WarehouseNo']		= $DocInfo['w_no'];
			$DocDetails['TrackNo']			= $DocInfo['track_no'];
			$DocDetails['ContainerNo']      = $DocInfo['container_no'];
			$DocDetails['ContainerName']    = $DocInfo['logistics_name'];
			$DocDetails['TransportType']    = $DocInfo['transport_type'];
            if($DocDetails['TransportType'] == 1){
                $DocDetails['ContainerType']    = $DocInfo['container_type'];
            }
			$DocDetails['IsGet']            = $DocInfo['is_get'];
            if($DocDetails['IsGet'] == 1){
                $DocDetails['GetAddress']      = $DocInfo['get_address'];
            }
			$DocDetails['InvoiceMoney']     = $DocInfo['invoice_money'];
			$DocDetails['InsuredAmount']    = $DocInfo['insured_amount'];
			$DocDetails['ArriveDate']       = $DocInfo['arrive_date'];
			$DocDetails['ClientId']         = $DocInfo['client_id'];
			$DocDetails['WarehouseCountry'] = $DocInfo['warehouse_country'];
			//产品明细
			$ProductDetail                  = array();
			foreach ((array)$DocInfo['detail'] as $detail){
				$ProductDetail[]    = array(
								'BoxNo'             => $detail['box_no'],
								'SKU'               => $detail['product_no'],
								'Quantity'          => $detail['quantity'],
								'DeclaredValue'		=> $detail['declared_value'],
							);
			}
			$DocDetails['ProductDetail']			= $ProductDetail;
            
			//装箱明细
			$BoxDetail                  = array();
			foreach ((array)$DocInfo['box'] as $detail){
				$BoxDetail[]    = array(
								'BoxNo'         => $detail['box_no'],
								'BoxId'         => $detail['box_id'],
								'Long'          => $detail['cube_long'],
								'High'          => $detail['cube_high'],
								'Width'         => $detail['cube_wide'],
								'Weight'        => $detail['weight'],
								'Comments'      => $detail['comments'],
							);
			}
			$DocDetails['BoxDetail']        = $BoxDetail;
		}
		return $DocDetails;
	}
    
    /**
	 * 构造xml接口订单信息数组
	 * @param array $DocInfo
	 * @return array
	 */
	function api_make_xml_stock_in_details($DocInfo){
		$DocDetails		= array(
							'InstockNo'             => $DocInfo['instock_no'],
						);
		if (C('API_GET_DATA_TYPE') != 'Simple') {
			$DocDetails['InstockNo']        = $DocInfo['instock_no'];
			$DocDetails['stockInDate']		= $DocInfo['storage_date'];


			//产品明细
			$ProductDetail                  = array();
			foreach ((array)$DocInfo['detail'] as $detail){
				$ProductDetail[]    = array(
								'BoxNo'             => $detail['box_no'],
								'SKU'               => $detail['product_no'],
								'Quantity'          => $detail['quantity'],
							);
			}
			$DocDetails['ProductDetail']			= $ProductDetail;
		}
		return $DocDetails;
	}
    /**
	 * 获取发货入库单列表搜索条件
	 * @param array $requestData
	 * @return array
	 */
	function api_get_stock_in_list_where($requestData){
		$where			= array(
							'i.factory_id'	=> C('API_FACTORY_ID'),
						);
		!empty($requestData['InstockNo']) && $where['i.instock_no']	= array('in', $requestData['InstockNo']);
        //日期处理
		$where_string	= array();
		$date_fields	= array('UpdateTime'=>'if(i.update_time<=0,i.create_time,i.update_time)');
		foreach ($date_fields as $date=>$field) {
			if (!empty($requestData[$date]['StartTime'])) {
				$where_string[]	= $field . ">='" . $requestData[$date]['StartTime'] . "'";
			}
			if (!empty($requestData[$date]['EndTime'])) {
				$where_string[]	= $field ."<='" . $requestData[$date]['EndTime'] . "'";
			}
		}
		if (count($where_string) > 0) {
			$where['_string']	= implode(' and ', $where_string);
		}
		return $where;
	}