<?php
return array(
	'CAINIAO_MSG_TYPE_LIST'	=> array(//允许访问的接口=>array('MODULE'=>对应模块, 'API_NAME'=>对应方法, 'TIMES'=>//指定时间内请求次数限制)
								'TRANSIT_WAREHOUSE_ORDER_NOTICE'			=> array(
																				'MODULE'	=> 'ReturnSaleOrder',
																				'API_NAME'	=> 'AddReturnOrder',
																				'ACTION'	=> 'insert',
																				'TIMES'		=> 100,
																			),	//申请退货接口
								'TRANSIT_WAREHOUSE_MAILNO_NOTICE'			=> array(
																				'MODULE'	=> 'ReturnSaleOrder',
																				'API_NAME'	=> 'AddReturnOrderTrackNo',
																				'ACTION'	=> 'update',
																				'TIMES'		=> 100,
																			),	//快递单号接口
								'TRANSIT_WAREHOUSE_INNER_CHECK_DECISION'	=> array(
																				'MODULE'	=> 'ReturnSaleOrder',
																				'API_NAME'	=> 'ConfirmReturnOrder',
																				'ACTION'	=> 'update',
																				'TIMES'		=> 100,
																			),	//确认退货接口
								'CreateItem'								=> array(
																				'MODULE'	=> 'Product',
																				'API_NAME'	=> 'AddProduct',
																				'ACTION'	=> 'insert',
																				'TIMES'		=> 500,
																				'4PX'		=> true,
																			),	//确认退货接口
								'CreateReceivingOrder'						=> array(
																				'MODULE'	=> 'Instock',
																				'API_NAME'	=> 'AddShipping',
																				'ACTION'	=> 'insert',
																				'TIMES'		=> 100,
																				'4PX'		=> true,
																			),	//确认退货接口
							),
	'CAINIAO_TRANS_API_NAME'	=> array(//需要开启事务的action 已有正则匹配/^(Add|Delete|Modify|Confirm)[A-Z]/开启，不符合正则规则的下面另行配置
							),
);