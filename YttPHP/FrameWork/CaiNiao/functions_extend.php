<?php

/**

 * Think 标准模式公共函数库(3.0ytt开始增加的部分)
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 */


	/**
	 * 构造退货单
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_make_return_sale_order_details($data){
		//退货单信息
		$ReturnSaleOrderDetails	= cainiao_make_return_sale_order_details_basic($data);
		switch (CAINIAO_API_NAME) {
			case 'AddReturnOrder':
				$ReturnSaleOrderDetails['is_related_sale_order']	= 0;
				$ReturnSaleOrderDetails['create_time']				= cainiao_get_date($data['occurTime'], true);
				$ReturnSaleOrderDetails['warehouse_id']				= C('EXPRESS_ES_WAREHOUSE_ID');
				$ReturnSaleOrderDetails['return_track_no']			= '';
				$ReturnSaleOrderDetails['factory_id']				= C('CAINIAO_FACTORY_ID');
				$ReturnSaleOrderDetails['return_sale_order_state']	= C('RETURN_SALE_ORDER_STATE_WAIT_RETURN_WAREHOUSE');
				//收货信息
				$addition											= cainiao_make_ship_to_address($data);
				$addition['factory_id']								= C('CAINIAO_FACTORY_ID');
				$addition['comp_type']								= C('CAINIAO_DEFAULTCONFIG_CLIENT_TYPE');
				$addition['comp_name']								= $addition['consignee'];
				$ReturnSaleOrderDetails['addition']					= $addition;
				$ReturnSaleOrderDetails['factory_addition']			= cainiao_make_ship_to_address($data, 'sellerContact');
				//合并退货单明细信息
				$ReturnSaleOrderDetails								= array_merge($ReturnSaleOrderDetails, cainiao_make_return_sale_order_details_product($data));
				break;
			case 'AddReturnOrderTrackNo':
				$ReturnSaleOrderDetails['update_time']				= cainiao_get_date($data['occurTime'], true);
				$ReturnSaleOrderDetails['return_track_no']			= $data['mailNo'];
				$model												= D(CAINIAO_MODULE_NAME);
				$doc_id												= cainiao_return_sale_order_id(0, $data['logisticsOrderCode']);
				if ($doc_id > 0) {
					$model->setId($doc_id);
					$ReturnSaleOrder								= $model->edit();
					unset($ReturnSaleOrder['detail_total'], $ReturnSaleOrder['pics'], $ReturnSaleOrder['service']);
					foreach ($ReturnSaleOrderDetails as $key => $val) {
						$ReturnSaleOrder[$key]	= $val;
					}
					$rs												= cainiao_make_return_sale_order_details_product_by_tarck_no($data);
					foreach ($ReturnSaleOrder['detail'] as $key => $val) {
						$ReturnSaleOrderDetails['warehouse_id']	= $val['warehouse_id'];
						if (isset($rs['detail'][$val['product_no']])) {
							if ($rs['detail'][$val['product_no']] != $val['quantity']) {
								$val['quantity']									= $rs['detail'][$val['product_no']];
								$return_service										= json_decode($val['return_service'],true);
								foreach ($return_service as &$service) {
									$service[1]	= $val['quantity'];
								}
								$ReturnSaleOrder['detail'][$key]['return_service']	= json_encode($return_service);
							}
						} else {
							unset($ReturnSaleOrder['detail'][$key]);
						}
					}
					unset($val);
					$ReturnSaleOrder['product']						= $rs['product'];
					$ReturnSaleOrderDetails							= $ReturnSaleOrder;
				}
				break;
			case 'ConfirmReturnOrder':
				$ReturnSaleOrderDetails['update_time']				= cainiao_get_date($data['occurTime'], true);
				$model												= D(CAINIAO_MODULE_NAME);
				$doc_id												= cainiao_return_sale_order_id(0, $data['logisticsOrderCode']);
				if ($doc_id > 0) {
					$model->setId($doc_id);
					$ReturnSaleOrder								= $model->edit();
					unset($ReturnSaleOrder['detail_total'], $ReturnSaleOrder['pics'], $ReturnSaleOrder['service']);
					foreach ($ReturnSaleOrderDetails as $key => $val) {
						$ReturnSaleOrder[$key]	= $val;
					}
					$return_service_info							= cainiao_get_return_sale_order_details_return_service_info($data);
					foreach ($ReturnSaleOrder['detail'] as &$val) {
						$ReturnSaleOrderDetails['warehouse_id']	= $val['warehouse_id'];
						$val['return_service_info'][]			= array(
																		'return_service_id'	=> $return_service_info['return_service_id'],
																		'service_detail_id'	=> $return_service_info['service_detail_id'],
																		'quantity'			=> $val['quantity'],
																		'price'				=> 0,
																	);
						$val['return_service']					= $val['return_service_info'];
					}
					unset($val);
					$ReturnSaleOrderDetails							= $ReturnSaleOrder;
				}
				break;
		}
		unset($data);
		return $ReturnSaleOrderDetails;
	}

	/**
	 * 构造退货单基本信息
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_make_return_sale_order_details_basic($data){
		//销售单信息
		$ReturnSaleOrderDetails								= array();
		$ReturnSaleOrderDetails['from_type']				= 'cainiao';///用来减少不必要的判断
		$ReturnSaleOrderDetails['return_order_date']		= cainiao_get_date($data['occurTime']);
		$ReturnSaleOrderDetails['return_logistics_no']		= $data['logisticsOrderCode'];
		cainiao_optional_fields_process($ReturnSaleOrderDetails, $data, C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS'));
		if (array_key_exists('totalDeclaredPrice', $ReturnSaleOrderDetails)) {
			$ReturnSaleOrderDetails['totalDeclaredPrice']	/= 100;//美分转换成美元
		}
		return $ReturnSaleOrderDetails;
	}
	
	/**
	 * 构造订单收货人信息
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_make_ship_to_address($data, $key = 'buyerContact'){
		$addition						= array();
		$addition['consignee']			= $data[$key]['name'];
		$addition['address']			= $data[$key]['streetAddress'];
		cainiao_optional_fields_process($addition, $data[$key], C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS.' . $key));
		$addition['city_name']			= $data[$key]['city'];
		$addition['country_id']			= (string)DdToId('country', strtoupper($data[$key]['countryCode'])); //国家代码
		if (empty($addition['country_name']) && $addition['country_id'] > 0) {
			$addition['country_name']	= SOnly('country', $addition['country_id'], 'district_name');
		}
		$addition['from_type']			= 'cainiao';///用来减少不必要的判断
		if (!empty($addition['phone']) || !empty($addition['mobile'])) {
			$addition['mobile']	= trim($addition['mobile'] . ',' . $addition['phone'], ',');
			unset($addition['phone']);
		}
		return $addition;
	}

	/**
	 * 构造退货单明细
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_make_return_sale_order_details_product($data){
		$detail					= array();
		$product				= array();
		$return_service_info	= cainiao_get_return_sale_order_details_return_service_info($data);
		foreach ((array)$data['items']['item'] as $val){
			if (!empty($val['id'])) {
				$product_no[$val['id']]	= $val['id'];
			}
		}
		if ($product_no) {
			$product_id	= getProductIdByFactory($product_no, C('CAINIAO_FACTORY_ID'));
		}
		foreach ((array)$data['items']['item'] as $val){
			$product_no		= $val['id'];
			if (empty($product_no)) {
				continue;
			}
			if (!isset($product[$product_no])) {
				$val['product_id']		= isset($product_id[$product_no]) ? $product_id[$product_no] : 0;
				$product[$product_no]	= cainiao_make_product($val);
			}
			$return_service	= array(
									array(
										'return_service_id'	=> $return_service_info['return_service_id'],
										'service_detail_id'	=> $return_service_info['service_detail_id'],
										'quantity'			=> $val['quantity'],
										'price'				=> 0,
									),
								);
			$unique_key		= $product_no;
			if (!isset($detail[$unique_key])) {
				$detail[$unique_key]				= array(
														'product_id'		=> $val['product_id'],
														'product_no'		=> $product_no,
														'sale_order_number'	=> 0,
														'quantity'			=> $val['quantity'],
														'return_service'	=> $return_service,
													);
			} else {
				$detail[$unique_key]['quantity']	+= $val['quantity'];
				foreach ($return_service as $u_k => $service) {
					$service['quantity']							+= $detail[$unique_key]['return_service'][$u_k]['quantity'];
					$detail[$unique_key]['return_service'][$u_k]	= $service;
				}
			}
		}
		sort($detail);
		sort($product);
		//防止明细在_validBeforDate被过滤
		$temp	= array();
		foreach ($detail as $key => $val) {
			$temp[$key]	= array(
								'product_no'	=> $val['product_no'],
							);
		}
		return array('product' => $product, 'detail' => $detail, 'temp' => $temp);
	}

	/**
	 * 构造退货单产品退货服务信息
	 * @param array $data
	 * @return array
	 */
	function  cainiao_get_return_sale_order_details_return_service_info($data){
		$return_service	= array();
		switch ($data['undeliveryOption']) {
			case 1://丢弃
				$return_service['return_service_id']	= C('DOWN_AND_DESTORY');//退货服务：销毁
				$return_service['service_detail_id']	= cainiao_get_return_service_detail_id($return_service['return_service_id']);
				break;
			case 4://拍照
				$return_service['return_service_id']	= C('PICTURE');//退货服务：拍照
				$return_service['service_detail_id']	= $data['photoType'] == 2 ? C('PICTURE_3C') : C('PICTURE_GENERAL');
				break;
			case 2://退回
			default :
				$return_service['return_service_id']	= C('BACK_TO_DOMESTIC');//退货服务：退回
				$return_service['service_detail_id']	= cainiao_get_return_service_detail_id($return_service['return_service_id']);
				break;
		}
		return $return_service;
	}

	/**
	 * 快递单号接口 获取退货单产品退货数量
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_make_return_sale_order_details_product_by_tarck_no($data){
		$detail					= array();
		$product				= array();
		foreach ((array)$data['items']['item'] as $val){
			if (!empty($val['id'])) {
				$product_no[$val['id']]	= $val['id'];
			}
		}
		if ($product_no) {
			$product_id	= getProductIdByFactory($product_no, C('CAINIAO_FACTORY_ID'));
		}
		foreach ((array)$data['items']['item'] as $val){
			$product_no		= $val['id'];
			if (empty($product_no)) {
				continue;
			}
			if (!isset($product[$product_no])) {
				$val['product_id']		= isset($product_id[$product_no]) ? $product_id[$product_no] : 0;
				$product[$product_no]	= cainiao_make_product($val);
			} else {
				$val['product_id']		= $product[$product_no]['id'];
			}
			$detail[$product_no]		+= $val['quantity'];
		}
		sort($product);
		return array('product' => $product, 'detail' => $detail);
	}

	/**
	 * 在指定退货服务中获取其一种服务项目
	 * @param int $return_service_id
	 * @return int
	 */
	function cainiao_get_return_service_detail_id($return_service_id){
		return $return_service_id > 0 ? M('ReturnServiceDetail')->where('return_service_id=' . (int)$return_service_id)->order('id asc')->getField('id') : 0;
	}

	/**
	 * 构造产品
	 * @param array $data
	 * @return array
	 */
	function  cainiao_make_product($data){
		$Product					= array();
		$Product['from_type']		= 'cainiao';///用来减少不必要的判断
		if ($data['product_id'] <= 0) {
			$Product['factory_id']		= C('CAINIAO_FACTORY_ID');
			$Product['check_status']	= C('CHECK_STATUS_WAIT_CHECK');//查验状态：0未查验
			if (M('CompanyFactory')->where(array('factory_id' => C('CAINIAO_FACTORY_ID')))->getField('is_custom_barcode') == 1) {//开启外部条码
				$Product['custom_barcode']		= $data['id'];
			}
		} else {
			$Product['id']				= $data['product_id'];
		}
		$Product['product_no']		= $data['id'];
		$Product['product_name']	= $data['nameEN'];
		$items_optional_fields		= C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS.items');
		cainiao_optional_fields_process($Product, $data, $items_optional_fields['item']);
		$Product['product_type']	= C('PRODUCT_TYPE_SIMPLE_PRODUCT');
		$data['unitPrice']			/= 100;//分转换成元 记为销售单价
		//产品明细
		$Product['product_detail']	= cainiao_make_product_detail($data);
		$Product['product_extend']	= cainiao_make_product_extend($Product, $data, $items_optional_fields['item']);
		if ($Product['weight'] == 0) {
			unset($Product['weight']);
		}
		return $Product;
	}

	/**
	 * 构造产品明细
	 * @param array $data
	 * @return array
	 */
	function  cainiao_make_product_detail($data){
		$product_detail	= array();
		foreach (C('CAINIAO_PRODUCT_DETAIL_FIELDS') as $properties_id=>$filed) {
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
	 * 构造产品扩展信息
	 * @param array $Product
	 * @param array $data
	 * @param array $_optional_fields
	 * @return array
	 */
	function  cainiao_make_product_extend(&$Product, $data, $_optional_fields){
		$product_extend	= array(
								'product_id'		=> $data['product_id'],
								'categoryNameCN'	=> trim($data['categoryNameCN']),
							);
		foreach ($_optional_fields as $field => $key) {
			if ($key != 'weight' && array_key_exists($field, $data)) {
				$product_extend[$field]	= $data[$field];
				unset($Product[$key]);
			}
		}
		return $product_extend;
	}

	/**
	 *
	 * @param array $Product
	 * @param array $product_ids
	 */
	function cainiao_fill_product_detail(&$Product, $product_ids){
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

	/**
	 * 退货服务验证
	 * @param type $DocInfo
	 * @param type $return_error
	 */
	function cainiao_valid_return_service(&$DocInfo, &$return_error){
		$tips	= C(CAINIAO_PARSE_MODULE_NAME . '_IMPORT_TIPS');
		foreach ($DocInfo['detail'] as &$product) {
			$ReturnService				= array();
			foreach ($product['return_service'] as $return_service) {
				if ($return_service['return_service_id'] <= 0) {//退货服务编号不存在
					$return_error['return_service_no_' . $product['product_no']]	= ($tips['return_service_no'] ? $tips['return_service_no'] : L('return_service_no')) . $return_service['return_service_no'] . ': 不存在!';
				}
				$service_detail_id	= $return_service['service_detail_id'];
				if ($service_detail_id <= 0) {//退货服务项目编号不存在
					$return_error['item_number_' . $product['product_no']]	= ($tips['item_number'] ? $tips['item_number'] : L('item_number')) . $return_service['item_number'] . ': 不存在!';
				}
				if (!isset($ReturnService[$service_detail_id])) {
					$ReturnService[$service_detail_id]		= array(
																0	=> $service_detail_id,
																1	=> $return_service['quantity'],
																2	=> $return_service['price'],
															);
				} else {
					$ReturnService[$service_detail_id][1]	= $return_service['quantity'];
				}
			}
			$product['return_service']	= json_encode($ReturnService);
		}
	}

	/**
	 * 构造产品
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_make_product_details($data){
		$Product					= array();
		$Product['from_type']		= 'cainiao';///用来减少不必要的判断
		$data['product_id']			= getProductIdByFactory($data['skuCode'], C('CAINIAO_FACTORY_ID'));
		if ($data['product_id'] <= 0) {
			$Product['factory_id']		= C('CAINIAO_FACTORY_ID');
			$Product['check_status']	= C('CHECK_STATUS_WAIT_CHECK');//查验状态：0未查验
			if (M('CompanyFactory')->where(array('factory_id' => C('CAINIAO_FACTORY_ID')))->getField('is_custom_barcode') == 1) {//开启外部条码
				$Product['custom_barcode']		= $data['referenceCode'];
			}
		} else {
			$Product['id']				= $data['product_id'];
		}
		$Product['product_no']		= $data['skuCode'];
		$Product['product_name']	= $data['itemName'];
		cainiao_optional_fields_process($Product, $data, C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS'));
		$Product['product_type']	= C('PRODUCT_TYPE_SIMPLE_PRODUCT');
		$Product['weight']			= $data['weight'] * 1000;//千克转换成克 记为产品种类
		$Product['cube_long']		= $data['length'];
		$Product['cube_wide']		= $data['width'];
		$Product['cube_high']		= $data['height'];
		//产品明细
		$Product['product_detail']	= cainiao_make_product_detail($data);
		$Product['product_extend']	= cainiao_make_product_extend($Product, $data, C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_EXTEND_FIELDS'));
		if ($Product['weight'] == 0) {
			unset($Product['weight']);
		}
		return $Product;
	}


	/**
	 * 构造发货单
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_make_instock_details($data){
		//发货单信息
		$doc	= cainiao_make_instock_details_basic($data);
		//明细
		cainiao_make_instock_details_detail($doc, $data);
		unset($data);
		return $doc;
	}

	/**
	 * 构造发货单基本信息
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_make_instock_details_basic($data){
		$doc					= array();
		$doc['from_type']		= 'cainiao';///用来减少不必要的判断
		$doc['container_no']	= $data['receiveOderCode'];
		$doc['go_date']			= cainiao_get_date($data['shipDate']);//发货日期
		$doc['delivery_date']	= cainiao_get_date($data['deliveryDate']);//交货日期
		$doc['warehouse_id']	= DdToId('warehouse', strtoupper($data['warehouseCode']));
		$doc['head_way']		= $data['carrierCode'];//头程运输方式
        if($doc['head_way'] == 1){//海运需要选择装柜类型
            $doc['container_type']	= $data['boxType'];
        }
		$doc['is_get']			= 2;//是否取货
        if($doc['is_get'] == 1){//取货需要填写取货地址
            $doc['get_address']	= $data['getAddress'];
        }
		cainiao_optional_fields_process($doc, $data, C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS'));
		switch (CAINIAO_API_NAME) {
			case 'AddShipping':
				$doc['factory_id']		= C('CAINIAO_FACTORY_ID');
				$doc['instock_type']	= C('CFG_INSTOCK_TYPE_WAIT_AUDIT');
				break;
		}
		return $doc;
	}


	/**
	 * 构造发货单箱号明细
	 * @param array &$docDetails
	 * @param array $data
	 */
	function  cainiao_make_instock_details_detail(&$doc, $data){
		$doc['box']		= array();
		$doc['product']	= array();
		foreach ((array)$data['lstItem'] as $val){
			if (!empty($val['skuCode'])) {
				$product_no[$val['skuCode']]	= $val['skuCode'];
			}
		}
		if ($product_no) {
			$product_id	= getProductIdByFactory($product_no, C('CAINIAO_FACTORY_ID'));
		}
		foreach ((array)$data['lstItem'] as $val){
			$product_no	= $val['skuCode'];
			if (empty($product_no)) {
				continue;
			}
			$box_no		= $val['boxNumber'];
			if (!empty($box_no)) {//箱号存在
				if (!array_key_exists($box_no, $doc['box'])) {
					$doc['box'][$box_no]	= array(
												'box_no'	=> $box_no,
												'cube_long'	=> 0,
												'cube_wide'	=> 0,
												'cube_high'	=> 0,
												'weight'	=> 0,
											);
				}
				$doc['box'][$box_no]['weight']	+= $val['weight'];
			}
			$unique_key	= $product_no . '_' . $box_no;
			if (!array_key_exists($unique_key, $doc['product'])) {
				$doc['product'][$unique_key]	= array(
													'box_no'				=> $box_no,
													'product_id'			=> isset($product_id[$product_no]) ? $product_id[$product_no] : 0,
													'product_no'			=> $product_no,
													'quantity'				=> 0,
													'accepting_quantity'	=> 0,

													'packageType'			=> $val['packageType'],
													'goodsType'				=> $val['goodsType'],
													'weight'				=> $val['weight'],
												);
			}
			$doc['product'][$unique_key]['quantity']			+= $val['quantity'];
			$doc['product'][$unique_key]['accepting_quantity']	+= $val['acceptedQuantity'];
		}
		sort($doc['box']);
		sort($doc['product']);
	}