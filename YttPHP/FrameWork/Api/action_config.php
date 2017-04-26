<?php
return array(
	'API_ACTION_LIST'					=> array(//允许访问的接口=>array('MODULE'=>对应模块, 'TIMES'=>//指定时间内请求次数限制)
											'AddOrder'			=> array(
																	'MODULE'	=> 'SaleOrder',
																	'ACTION'	=> 'insert',
																	'TIMES'		=> 500,
																),	//新增销售单
											'ModifyOrder'		=> array(
																	'MODULE'	=> 'SaleOrder',
																	'ACTION'	=> 'update',
																	'TIMES'		=> 500,
																),	//修改销售单
											'DeleteOrder'		=> array(
																	'MODULE'	=> 'SaleOrder',
																	'ACTION'	=> 'delete',
																	'TIMES'		=> 500,
																),	//删除销售单
											'GetOrder'			=> array(
																	'MODULE'	=> 'SaleOrder',
																	'ACTION'	=> 'view',
																	'TIMES'		=> 500,
																),	//获取销售单
											'GetOrderList'		=> array(
																	'MODULE'	=> 'SaleOrder',
																	'ACTION'	=> 'index',
																	'TIMES'		=> 100,
																),	//获取销售单列表
											'GetStorageList'	=> array(
																	'MODULE'	=> 'Storage',
																	'ACTION'	=> 'index',
																	'TIMES'		=> 1000,
																),	//获取库存列表
											'AddProduct'		=> array(
																	'MODULE'	=> 'Product',
																	'ACTION'	=> 'insert',
																	'TIMES'		=> 1000,
																),	//新增产品
											'ModifyProduct'		=> array(
																	'MODULE'	=> 'Product',
																	'ACTION'	=> 'update',
																	'TIMES'		=> 1000,
																),	//修改产品
											'DeleteProduct'		=> array(
																	'MODULE'	=> 'Product',
																	'ACTION'	=> 'delete',
																	'TIMES'		=> 500,
																),	//删除产品
											'GetProductList'	=> array(
																	'MODULE'	=> 'Product',
																	'ACTION'	=> 'index',
																	'TIMES'		=> 100,
																),	//获取产品列表
											'AddShipping'		=> array(
																	'MODULE'	=> 'Instock',
																	'ACTION'	=> 'insert',
																	'TIMES'		=> 100,
																),	//新增发货
											'ModifyShipping'	=> array(
																	'MODULE'	=> 'Instock',
																	'ACTION'	=> 'update',
																	'TIMES'		=> 100,
																),	//修改发货
											'DeleteShipping'	=> array(
																	'MODULE'	=> 'Instock',
																	'ACTION'	=> 'delete',
																	'TIMES'		=> 50,
																),	//修改发货
											'GetShippingList'	=> array(
																	'MODULE'	=> 'Instock',
																	'ACTION'	=> 'index',
																	'TIMES'		=> 100,
																),	//获取发货列表
											'GetStockInList'	=> array(
																	'MODULE'	=> 'Instock',
																	'ACTION'	=> 'index',
																	'TIMES'		=> 100,
																),	//获取发货入库列表
											'AddReturnOrder'		=> array(
																	'MODULE'	=> 'ReturnSaleOrder',
																	'ACTION'	=> 'insert',
																	'TIMES'		=> 100,
																),	//新增退货
											'DeleteReturnOrder'	=> array(
																	'MODULE'	=> 'ReturnSaleOrder',
																	'ACTION'	=> 'delete',
																	'TIMES'		=> 50,
																),	//修改退货
											'GetReturnOrderList'	=> array(
																	'MODULE'	=> 'ReturnSaleOrder',
																	'ACTION'	=> 'index',
																	'TIMES'		=> 100,
																),	//获取退货列表
											'GetShippingMethodsList'=> array(
																	'MODULE'	=> 'Shipping',
																	'ACTION'	=> 'index',
																	'TIMES'		=> 10,
																),	//获取退货列表
										),
	'API_PAGE_ACTION'					=> array(//需要分页的action 已有正则匹配/[a-z]List$/开启，不符合正则规则的下面另行配置
										),
	'API_TRANS_ACTION'					=> array(//需要开启事务的action 已有正则匹配/^(Add|Delete|Modify)[A-Z]/开启，不符合正则规则的下面另行配置
										),
	'API_FILTER_ACTION'					=> array(//需要过滤接收字段的action
//											'ModifyOrder',//暂未实现此功能
										),
);