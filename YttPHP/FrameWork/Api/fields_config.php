<?php
return array(
	'API_MODULE_DETAILS_KEY'				=> array(
												'SaleOrder'			=> 'OrderDetails',
												'Product'			=> 'Product',
												'Instock'			=> 'ShippingDetails',
												'ReturnSaleOrder'	=> 'ReturnOrderDetails',
												'Storage'			=> 'StorageList',
												'GetStockInList'    => 'StockInDetails',
												'Shipping'			=> 'ShippingMethods',
											),
	'API_SALE_ORDER_FIELDS'					=> array(//订单明细字段
												'OrderNo',
												'ProcessNo',
												'OrderState',
												'OrderDate',
												'CustomerName',
												'OrderType',
												'ShippingName',
												'WarehouseNo',
												'Email',
												'Fax',
												'TaxNo',
												'TransactionId',
												'Registered',
                                                'IsInsure',
                                                'BrtAccountNo',
                                                'AliexpressToken',
												'ShipToAddress'	=> array(
																	'CityName',
																	'Country',
																	'CountryName',
																	'Name'	,
																	'Phone'	,
																	'PostalCode',
																	'StateOrProvince',
																	'Street1',
																	'Street2',
																),

												'Product'		=> array(
																	'Sku',
																	'Quantity',
																),
											),
	'API_SALE_ORDER_INT_FIELDS'				=> array(//整数字段
												'OrderState',
												'OrderType',
												'Registered',
												'IsInsure',
												'ShipToAddress'	=> array(),
												'Product'		=> array(
																	'Quantity',
																),
											),
	'API_SALE_ORDER_OPTIONAL_FIELDS'		=> array(//非必填字段
												'TransactionId'	=> 'transaction_id',
                                                'IsInsure'      => 'is_insure',
                                                'AliexpressToken'=>'aliexpress_token',
												'ShipToAddress'	=> array(
																	'Phone'				=> 'mobile',
																	'StateOrProvince'	=> 'company_name',
																	'Street2'			=> 'address2',
																),
											),
	'API_SALE_ORDER_DETAIL_FIELDS'			=> array(
												'email'		=> 'Email',
												'fax'		=> 'Fax',
												'tax_no'	=> 'TaxNo',
											),
	'API_SALE_ORDER_SUB_KEY'				=> array(//一维子明细下标
												'ShipToAddress',
											),
	'API_SALE_ORDER_SUB_KEYS'				=> array(//二维子明细下标
												'Product',
											),
	'API_SALE_ORDER_DETAIL_KEYS'			=> array(
												'detail'	=> L('module_Product')
											),

	'API_PRODUCT_FIELDS'					=> array(//产品明细字段
												'ProductId',//修改时存在
												'SKU',
												'ProductName',
												'Long',
												'Width',
												'Height',
												'Weight',
												'HsCode',
												'SalePrice',
												'Material',
												'DeclaredValue',
												'ProductType',
												'CustomBarcode',

												'SubSKU'		=> array(
																	'SKU',
																	'Quantity',
																),
											),
	'API_PRODUCT_INT_FIELDS'				=> array(//整数字段
												'ProductId',//修改时存在
												'ProductType',
												'SubSKU'			=> array(
													'Quantity',
												),
											),
	'API_PRODUCT_OPTIONAL_FIELDS'			=> array(//非必填字段
												'Long'		=> 'cube_long',
												'Width'		=> 'cube_wide',
												'Height'	=> 'cube_high',
												'Weight'	=> 'weight',
											),
	'API_PRODUCT_DETAIL_FIELDS'				=> array(//明细对应属性ID的C变量下标
												C('MATERIAL_DESCRIPTION')	=> 'Material',
												C('HS_CODE')				=> 'HsCode',
												C('DECLARED_VALUE')			=> 'DeclaredValue',
												C('SALE_PRICE')				=> 'SalePrice',
											),
	'API_PRODUCT_SUB_KEYS'					=> array(//二维子明细下标
												'SubSKU',
											),
	'API_PRODUCT_DETAIL_KEYS'				=> array(//另外特殊处理了
//												'product_son'	=> L('module_Product')
											),
	'API_INSTOCK_FIELDS'					=> array(//发货明细字段
												'InstockNo',
												'InstockDate',
												'DeliveryDate',
												'WarehouseNo',
												'TrackNo',
												'ContainerNo',
												'ContainerName',
												'TransportType',
												'ContainerType',
												'IsGet',
												'GetAddress',
												'InvoiceMoney',
												'InsuredAmount',
												'ArriveDate',
												'Comments',

												'BoxDetail'		=> array(
																	'BoxNo',
																	'Long',
																	'Width',
																	'High',
																	'Weight',
																	'Comments',
																),

												'ProductDetail'	=> array(
																	'BoxNo',
																	'SKU',
																	'Quantity',
																	'DeclaredValue',
																),
											),
	'API_INSTOCK_INT_FIELDS'				=> array(//整数字段
												'TransportType',
												'ContainerType',
												'IsGet',
												'BoxDetail'		=> array(),
												'ProductDetail'	=> array(
													'Quantity',
												),
											),
	'API_INSTOCK_OPTIONAL_FIELDS'			=> array(//非必填字段
												'TrackNo'		=> 'track_no',
												'ContainerNo'	=> 'container_no',
												'ContainerName'	=> 'logistics_id',
												'InvoiceMoney'	=> 'invoice_money',
												'InsuredAmount'	=> 'insured_amount',
												'ArriveDate'	=> 'arrive_date',
												'Comments'		=> 'client_comments',
												'BoxDetail'		=> array(
																	'Comments'	=> 'comments',
																),
												'ProductDetail'	=> array(
																	'DeclaredValue'	=> 'declared_value',
																),
											),
	'API_INSTOCK_SUB_KEYS'					=> array(//二维子明细下标
												'BoxDetail',
												'ProductDetail',
											),
	'API_INSTOCK_DETAIL_KEYS'				=> array(
												'box'		=> L('box_no'),
												'product'	=> L('module_Product')
											),

	'API_RETURN_SALE_ORDER_FIELDS'			=> array(//订单明细字段
												'IsRelatedSaleOrder',
												'WarehouseNo',
												'ReturnOrderDate',
												'ReturnTrackNo',
												'ReturnLogisticsNo',
												'ProcessNo',
												'OrderNo',
												'CustomerName',
												'Email',
												'Fax',
												'TaxNo',

												'ShipToAddress'	=> array(
																	'CityName',
																	'Country',
																	'CountryName',
																	'Name'	,
																	'Phone'	,
																	'PostalCode',
																	'StateOrProvince',
																	'Street1',
																	'Street2',
																),

												'Product'		=> array(
																	'Sku',
																	'ReturnQuantity',
																	'ReturnService'	=> array(
																							'ReturnServiceNo',
																							'ItemNumber',
																							'Quantity',
																					),
																),
											),
	'API_RETURN_SALE_ORDER_INT_FIELDS'		=> array(//整数字段
												'IsRelatedSaleOrder',
												'ShipToAddress'	=> array(),
												'Product'		=> array(
																	'ReturnQuantity',
																	'ReturnService'	=> array(
																							'Quantity',
																					),
																),
											),
	'API_RETURN_SALE_ORDER_OPTIONAL_FIELDS'	=> array(//非必填字段
												'ShipToAddress'	=> array(
																	'Phone'				=> 'mobile',
																	'StateOrProvince'	=> 'company_name',
																	'Street2'			=> 'address2',
																),
											),
	'API_RETURN_SALE_ORDER_DETAIL_FIELDS'	=> array(
												'email'		=> 'Email',
												'fax'		=> 'Fax',
												'tax_no'	=> 'TaxNo',
											),
	'API_RETURN_SALE_ORDER_SUB_KEY'			=> array(//一维子明细下标
												'ShipToAddress',
											),
	'API_RETURN_SALE_ORDER_SUB_KEYS'		=> array(//二维子明细下标
												'Product',
											),
	'API_RETURN_SALE_ORDER_THIRD_SUB_KEYS'		=> array(//三维子明细下标
												'Product' => 'ReturnService',
											),
	'API_RETURN_SALE_ORDER_DETAIL_KEYS'		=> array(
												'detail'	=> L('module_Product')
											),
);