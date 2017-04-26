<?php
/**
 * 菜鸟api请求状态 added by jp
 */
define('CAINIAO_REQUEST_STATUS_NOT_YET',								0);			//未操作
define('CAINIAO_REQUEST_STATUS_SUCCESS',								1);			//请求成功
define('CAINIAO_REQUEST_STATUS_FAILED',									2);			//请求失败
define('CAINIAO_REQUEST_STATUS_ABNORMAL',								3);			//请求异常
define('CAINIAO_REQUEST_STATUS_TIME_OUT',								4);			//请求超时
define('CAINIAO_REQUEST_STATUS_RETRY_SUCCEEDS',							5);			//再次请求成功
define('CAINIAO_REQUEST_STATUS_ABANDON',								8);			//放弃请求
define('CAINIAO_REQUEST_STATUS_PROCESSING',								9);			//请求中

/**
 * 快递api请求状态 added by jp
 */
define('EXPRESS_API_REQUEST_STATUS_PENDING',							'Pending');			//待请求
define('EXPRESS_API_REQUEST_STATUS_REQUESTING',							'Requesting');		//请求中
define('EXPRESS_API_REQUEST_STATUS_SUCCESSFUL',							'Successful');		//请求成功
define('EXPRESS_API_REQUEST_STATUS_FAILED',								'Failed');			//请求失败
define('EXPRESS_API_REQUEST_STATUS_ABNORMAL',							'Abnormal');		//请求异常
define('EXPRESS_API_REQUEST_STATUS_CANCELLED',							'Cancelled');		//取消请求

return array(
	'SYSTEM_LANG'		=> array('cn'=>'中文', 'de'=>'Deutsch', 'it'=>'Italiano', 'es'=>'Español', 'pl'=>'Polski','en'=>'English','fr'=>'français'),// 系统支持的语言	,'it'=>'意大利语','tw'=>'繁体中文'
	'LONG_LANG_TPL'     => array('de','it','es', 'pl', 'en', 'fr'),//语言包长模版,默认为中文(短)模版
    'CFG_RIGHT_TYPE'	=> array(//权限类型
					'RightAdd' 		=> L('RightAdd'),
					'RightView'		=> L('RightView'),
					'RightDelete'	=> L('delete'),
					'RightCancel'	=> L('cancel'),
					'RightEdit' 	=> L('RightEdit'),
					'RightAudit'=> L('audit'),
					'RightQuery'=> L('RightQuery'),
					'RightReset'=> L('RightReset'),
					'RightList' => L('index'),
					'RightPrint'=> '打印',
					'RightExtra' => '自定义'
				    ),
	//added by jp  st
	'CFG_FREIGHT_STRATEGY' => array(//快递公司选择策略
		1 => L('manual_control'),//手动控制
		2 => L('speed_priority'),//速度优先
		3 => L('postage_priority'),//邮费优先
	),
	'CFG_ZONE_TYPE' => array(//库区类型
		1 => L('genuine_zone'),//正品区
		2 => L('defective_zone'),//次品区
		3 => L('inspection_zone'),//验货区
		4 => L('returns_zone'),//退换货区
		5 => L("stocking_zone"),//备货区     add by lxt 2015.06.25
	),
	'MERGE_ADDRESS_MODULE' => array(//列表需要合并地址的模块
		'Client',
		'Factory',
		'Logistics',
		'Express',
		'SaleOrder',
		'ComplexOrder',
	),
	'CFG_PAY_RALATION_OBJECT'	=> array(
		1	=> L('company'),//公司
		2	=> L('seller'),//卖家
		3	=> L('express'),//快递公司
		4	=> L('logistics'),//物流公司
        5	=> L('warehouse')//仓库公司
	),
    'CFG_INSTOCK_TYPE_WAIT_AUDIT'			=> 1,//待审核
	'CFG_INSTOCK_TYPE_UNEDIT'               => 3,//不接单
	'CFG_INSTOCK_TYPE_WARE_CHECK_DOMESTIC'		=> 6,//仓库验货(国内)
	'CFG_INSTOCK_TYPE_ARRIVE_WARE'			=> 9,//货物到仓
	'CFG_INSTOCK_TYPE_WARE_CHECK_FOREIGN'		=> 10,//仓库验货(国外)
	'CFG_INSTOCK_TYPE_DELIVERY_IN'			=> 14,//仓库验货(国外)
	'CFG_INSTOCK_TYPE_INSTOCK_FOREIGN'		=> 11,//货物入库（国外）
	'CFG_INSTOCK_TYPE_CHECKOUTED'			=> 12,//费用结清
    'NO_ONROAD_STATE'                       => '1,2,3,11,12,16,17',//不记录在途库存的状态
	'CFG_INSTOCK_TYPE' => array(
		1	=> L('wait_audit'),//待审核
		2	=> L('editing'),//编辑中
		3	=> L('unaccept'),//不接单
		4	=> L('accept'),//同意接单
		//5	=> L('instock_domestic'),//货物入库（国内）
		6	=> L('ware_check_domestic'),//仓库验货(国内)
		7	=> L('apply_to_customs'),//报关及订仓=>到达发货港口/机场
		8	=> L('in_transit'),//货物在途=>已开航
		9	=> L('arrive_ware'),//货物到仓=>抵达目的港口/机场
		10	=> L('ware_check_foreign'),//仓库验货(国外)=>清关中
		14	=> L('delivery_in'),//派送中
		15	=> L('signed'),             //已签收
		16	=> L('abnormal_sign'),      //签收异常
		11	=> L('instock_foreign'),//货物入库（国外）=> 商品上架（国外）
		17	=> L('abnormal_instock'),	//入库异常
		12	=> L('checkouted'),	//费用结清
//		13	=> L('obsolete'),已作废
	),
	 'SHOW_ACCEPTING_QUANTITY_INSTOCK_STATE' =>array(//显示验收数量状态
		6	 ,//仓库验货(国内)
		7 ,//报关及订仓=>到达发货港口/机场
		8 ,//货物在途=>已开航
		9 ,//货物到仓=>抵达目的港口/机场
		10 ,//仓库验货(国外)=>清关中
		14 ,//派送中
		11 ,//货物入库（国外）=> 商品上架（国外）
		12 ,	//费用结清
	),	// 发货单状态'
	'SHOW_IN_INSTOCK_STATE' =>array(//已入库状态		 
		11 ,//货物入库（国外）=> 商品上架（国外）
		12 ,	//费用结清
	),	// 发货单状态'
    'NO_ON_ROAD_TYPE'      => '1,2,3,13',
    'CAN_STORAGE'   => array(1,2,3,4,5,6,7,8,9,10,14,15),
	'CFG_CONTAINER_TYPE' => array(
		1	=> L('20_feet'),	//20尺
		2	=> L('40_ft'),		//40尺高柜
		3	=> L('40_hc'),		//40尺高柜
		4	=> L('lcl')			//拼箱
	),
    'CFG_CONTAINER_TYPE_BETWEEN'    => array(1,2,3,4),
    'CAN_RETURN_SOLD'    => 1,//退货可再销售
    'NO_RETURN_SOLD'     => 2,//退货不可再销售
	//added by jp  ed
	 'CFG_PUBLIC_RIGHTS' =>array('Index','Memche','Ajax','AjaxBrf','AjaxExpand','AjaxValidation','AutoComplete','AutoShow','AjaxUploadify','EbaySeller','AmazonSeller','InstockBarcode'),// 公共权限
	 'CFG_USER_TYPE'	 =>array(1=>L('company'),2=>L('seller'),3=>L('seller_staff'),4=>L('partner'),5=>L('warehouse')),// 用户账号类型
     'CFG_WAREHOUSE_TYPE'	     =>array(5=>L('warehouse')),// 仓库账号类型
     'CFG_SELLER_STAFF_TYPE'	 =>array(3=>L('seller_staff')),// 卖家员工账号类型
     'CFG_PARTNER_TYPE'	         =>array(4=>L('partner')),// 合作伙伴账号类型
    
	 'CLIENT_TYPE'		=>array(1=>L('bfclient'),2=>L('lsclient'),3=>L('qtclient')),
	 'BASICSTATE'		=>array(1=>L('normal'),2=>L('cancel')),
	 'PRICE_RANGE'		=>array(1=>L('more_than_0'),2=>L('equal_than_0')),
	 'AUDIT_STATE'		=>array(1 => L('wait_audit'), 2 => L('audited'), 3 => L('unpass')),// 审核状态
	 'SEX'				=>array(1=>L('man'),2=>L('wowan')), 				// 性别
	 'IS_USE'			=>array(1=>L('able'),2=>L('unable')), 				//是否可用
     'IS_RETURN_SOLD'   =>array(1=>L('yes'),2=>L('no')),                //是否退货可再销售
	 'IS_GET'			=>array(1=>L('yes'),2=>L('no')), 				//是否取货
	 'IS_ENABLE'		=>array(1=>L('yes'),2=>L('no')), 				//是否可用
	 'IS_DEFAULT'		=>array(1=>L('yes'),2=>L('no')), 				//是否默认
	 'PAY_TYPE'			=>array(1=>L('outlay'),2=>L('income')),													// 支付类别
	 'FUNDS_TYPE'		=>array(1=>l('payables') . '/' . L('outlay'),2=>l('receivable') . '/' . L('income')),											// 款项类别
	 'INCOME_TYPE'		=>array(1=>L('income'),-1=>L('outlay')), 			// 支付类别
	 'SAVE_DRAW_TYPE'	=>array(1=>L('save_type'),-1=>L('withdraw')), 			// 支付类别
	 'YES_NO'			=>array(1=>L('yes'),0=>L('no')), 				// 只做为配置使用，0值不入库
	 'IS_PRODUCTION'	=>array(1=>L('yes'),0=>L('no')), 				// 只做为配置使用，0值不入库
	 'SET_RATE'			=>array(1=>L('fixedrate'),2=>L('set_rate_type_2'),3=>L('set_rate_type_3')),
	 'PROPERTIES_TYPE'	=>array(1=>L('input_type_1'),2=>L('input_type_2'),3=>L('input_type_3'),4=>L('input_type_4')),
	 'PATTERN_TYPE_ALL'	=>array(1=>L('pattern_type_1'),2=>L('pattern_type_2'),3=>L('pattern_type_3')),
	 'TRANSPORT_TYPE'	=>array(1=>L('sea_transport'),2=>L('air_transport')),//头程运输方式
	 'INPUT_TYPE'		=>array(1=>L('manual_input'), 2=>L('excle_import')),//明细输入方式
	 'IS_INSURE'        =>array(1=>L('yes'),2=>L('no')), 
	 'ARREARS_LIMIT'    =>array(1=>L('yes'),2=>L('no')), 
	 // 用于添加菜单时的选项
	/* 'FLOW_NAME'		=>array('basic'=>L('basic'),'pattern'=>L('pattern'),'order'=>L('order'),'container'=>L('container'),
	 							'instock'=>L('instock'),'sale'=>L('sale'),'pre_delivery'=>L('pre_delivery'),'delivery'=>L('delivery'),
	 							'invoice'=>L('invoice'),'accounts'=>L('accounts'),'stat'=>L('stat'),'system'=>L('system')), // 流程配置
     */
	 'AUDIT_STATE'			=> array(1 => L('wait_audit'), 2 => L('audited'), 3 => L('unpass')),// 审核状态
	 'CHECK_STATUS'			=> array(0 => L('wait_check'), 1 => L('pass'), 2 => L('notpass')),// 查验状态
	 'CHECK_STATUS_WAIT_CHECK'	=> 0,
	 'CHECK_STATUS_PASS'		=> 1,
	 'ORDER_DETAIL_STATE' 	=> array(1 => L('order_normal'), 2 => L('order_part_finished'), 3 => L('order_finished'),4=>L('manual_finished')), // 订单明细状态
	 'ORDER_STATE' 			=> array(1 => L('order_normal'), 2 => L('order_part_finished'), 3 => L('order_finished'),4=>L('manual_finished')),	// 订单状态
     'OUT_STOCK_CHANGE_WAREHOUSE'   => '4',//新拣货订单类型-转仓
    'ORDER_OUT_STOCK_TYPE' => array(1 => L('simple_orders'), 2 => L('complex_orders'), 4 => L('change_warehouse')),	// 订单类型
    'SALE_ORDER_OUT_STOCK_TYPE'      => array(1 => L('simple_orders'), 2 => L('complex_orders')),	// 订单类型
	 'LOAD_STATE' 			=> array(1 =>  L('loaded'), 2 =>  L('temp_load'), 3 =>  L('finished')),	// 装柜状态
	 'BANK_SOURCE' 			=> array(1001 =>  L('stat_ini'), 1002 =>  L('BankJournal'),1003 =>  L('BankRemittance'),1005 =>  L('BankSwap'), 121 =>  L('stat_advance_income_money'), 103 =>  L('ClientFunds'), 800 =>  L('otherexpenses'), 801 =>  L('otherrevenue'), 203 =>  L('FactoryFunds'), 303 =>  L('LogisticsFunds'),403 =>  L('WarehouseFunds')),	// 装柜状态
	'EVERY_FUNDS_DETAIL_SOURCE' => array(1001=>L('stat_ini'),1002=>L('BankJournal'),1003=>L('BankRemittance'),121 =>  L('stat_advance_income_money'), 103 =>  L('ClientFunds'), 800 =>  L('otherexpenses'), 801 =>  L('otherrevenue')),	//每日出入明细资金来源
	 'BILL_SOURCE' 			=> array(121 =>  L('stat_advance_income_money'), 103 =>  L('ClientFunds'), 800 =>  L('otherexpenses'), 801 =>  L('otherrevenue'), 203 =>  L('FactoryFunds'), 303 =>  L('LogisticsFunds'),403 =>  L('WarehouseFunds')),	// 装柜状态
	'PAID_DETAIL_OBJECT_TYPE'	=>	array(
							1=>'ComCashIni',//公司现金期初
							101=>'ClientIni',//客户期初欠款
							102=>'ClientOtherArrearages',//客户其他欠款
							103=>'ClientFunds',//客户不指定收款
							104=>'ClientFundsCloseOut',//客户付款平帐

							120=>'ClientSale',//销售单客户欠款
							121=>'ClientSaleAdvance',//销售单预收款
							122=>'ClientSaleCloseOut',//销售单指定平帐
							123=>'ClientReturnSale',//退货
							124=>'ClientSaleDelivery',//销售单实际发货
                            125=>'ClientQuantityOrder',//问题订单应收款项 added by yyh 20150427
                            126=>'ClientQuantityOrderReceived',//问题订单已收款项 added by yyh 20150427
                            127=>'ClientWarehousAccount',//仓储费应收款款项 added by yyh 20150427
							129=>'ClientCheckAccount', // 客户对账
                            130=>'PriceAdjust',//调价 added by jp 20131216
                            131=>'ClientOutBatch',//装箱单运费应收款 add yyh 20151127

							201=>'FactoryIni',//厂家期初欠款
							202=>'FactoryOtherArrearages',//厂家其他欠款
							203=>'FactoryFunds',//厂家不指定收款
							204=>'FactoryFundsCloseOut',//厂家付款平帐

							220=>'FactoryInstock',//入库欠款
							221=>'FactoryOnRoad',//厂家装柜在路上的款项
							229=>'FactoryCheckAccount', // 厂家对账

							301=>'LogisticsIni',//物流期初欠款
							302=>'LogisticsOtherArrearages',//物流其他欠款
							303=>'LogisticsFunds',//物流不指定收款
							304=>'LogisticsFundsCloseOut',//物流付款平帐

							320=>'LogisticsInstock',//物流入库欠款
							329=>'LogisticsCheckAccount', //物流公司对账

                            401=>'WarehouseIni',//仓库期初欠款
							402=>'WarehouseOtherArrearages',//仓库其他欠款
							403=>'WarehouseFunds',//仓库不指定收款
							404=>'WarehouseFundsCloseOut',//仓库付款平帐

							420=>'WarehouseInstock',//仓库入库欠款
							429=>'WarehouseCheckAccount', //仓库公司对账

							800=>'ComOtherExpenses',//公司其他支出
							801=>'ComOtherRevenue',//公司其他收入
							901 =>  L('bankjournal'),//银行存取款
	),
	'PAID_DETAIL_LANG'	=>	array(
							0=>L('BankRemittanceandIni'),///转回国内或期初(特殊显示)
							1=>L('ComCashIni'),///客户期初欠款
							101=>L('stat_ini'),///客户期初欠款
							102=>L('stat_other_fund'),///客户期初欠款
							103=>L('ClientFunds'),///客户付款
							104=>L('ClientFundsCloseOut'),//客户付款平帐
							121=>L('stat_advance_income_money'),///销售单预收款
							122=>L('stat_advance_income_money_close'),///销售单预收款平帐损失--何剑波
							120=>L('deal_no'),///销售单客户欠款
							123=>L('return_sale_order_no'),///退货
							129=>L('stat_close_out'),///客户对账
                            130=>L('price_adjust'),//调价 added by jp 20131216

							201=>L('FactoryIni'),///厂家期初欠款
							202=>L('FactoryOtherArrearages'),///厂家其他欠款
							203=>L('FactoryFunds'),///厂家不指定收款
							220=>L('deal_no'),///销售单发货公司相对快递公司欠款
							229=>L('stat_close_out'),///厂家对账
							221=>L('fac_onroad_money'), /// 厂家在路上金额

							301=>L('LogisticsIni'),///物流期初欠款
							302=>L('LogisticsOtherArrearages'),///物流其他欠款
							303=>L('LogisticsFunds'),///物流不指定收款
							320=>L('instock_no'),///入库欠款
							329=>L('stat_close_out'),///物流对账

							800=>L('otherexpenses'),///其他支出
							801=>L('otherrevenue'),///其他收入

							1001=>L('stat_ini'),		///银行账号期初
							1002=>L('BankJournal'),	///银行存取款
							1003=>L('BankRemittance'),///银行汇款
							1004=>L('BankOther'),	///银行其他转入
                            1005=>L('BankSwap'),	///银行换汇 added by jp 20131210
	),
	'FAC_PAID_DETAIL_LANG'	=>	array(
							103=>L('payment'),///客户付款
	),
    'RETURN_OBJECT_TYPE'    => 123,
	'FLOW_URL' => array(
						120=>'/SaleOrder/view/id/',
						121=>'/SaleOrder/view/id/',
						122=>'/SaleOrder/view/id/',
						123=>'/ReturnSaleOrder/view/id/',
                        130=>'/PriceAdjust/view/id/',//added by jp 20131216
						320=>'/Instock/view/id/',
						220=>'/SaleOrder/view/id/',
						221=>'/LoadContainer/view/id/',
						'Orders'	=>'/Orders/view/id/',
						'LoadContainer'=>'/LoadContainer/view/id/',
						'Instock'	=>'/Instock/view/id/',
						'SaleOrder'	=>'/SaleOrder/view/id/',
						'Delivery'	=>'/Delivery/view/id/',
						'PreDelivery'	=>'/PreDelivery/view/id/',
						102=>array(//卖家应收款关联单据url added by jp 20140526
							1=>'/Instock/view/id/',
							2=>'/SaleOrder/view/id/',
							3=>'/ReturnSaleOrder/view/id/',
							4=>'/Product/view/id/',
						),
                        202=>array(
                            1=>'/Instock/view/id/',
							2=>'/SaleOrder/view/id/',
							3=>'/ReturnSaleOrder/view/id/',
							4=>'/Product/view/id/',
                        ),
                        302=>array(
                            1=>'/Instock/view/id/',
							2=>'/SaleOrder/view/id/',
							3=>'/ReturnSaleOrder/view/id/',
							4=>'/Product/view/id/',
                        ),
                        402=>array(
                            1=>'/Instock/view/id/',
							2=>'/SaleOrder/view/id/',
							3=>'/ReturnSaleOrder/view/id/',
							4=>'/Product/view/id/',
                        ),
	),
	'BANK_OBJECT_TYPE'	=>	array(
							1=>'BankIni',		//银行账号期初
							2=>'BankJournal',	//银行存取款
							3=>'BankRemittance',//银行汇款
							4=>'BankOther',		//银行其他转入
	),
	//状态日志type值对应model值
	'STATE_OBJECT_TYPE' => array(
							1=>'Instock',					//国内发货
							2=>'SaleOrder',					//客户订单
							3=>'ReturnSaleOrder',			//客户退换货
                            4=>'Recharge',                  //卖家充值确认
                            5=>'QuestionOrder',             //问题订单
	),
	//状态日志字段值对应model值
	'STATE_OBJECT_FIELD' => array(
							'instock_type'=>'Instock',						//国内发货
							'sale_order_state'=>'SaleOrder',				//客户订单
							'return_sale_order_state'=>'ReturnSaleOrder',	//客户退换货
                            'confirm_state'=>'Recharge',
                            'question_order_state'=>'QuestionOrder',// 问题订单
	),
	//状态日志字段值对应model值
	'STATE_DATA' => array(
							'Instock'=>'CFG_INSTOCK_TYPE',
	),
	/*
	'STATE_OBJECT_ID' => array(
							1=>'',			//国内发货
							'sale_order_id'=>'SaleOrder', //客户订单
							3=>'',			//客户退换货
	),
	*/
	'BANK_OBJECT_LANG'	=>	array(
							1=>L('BankIni'),		//银行账号期初
							2=>L('BankJournal'),	//银行存取款
							3=>L('BankRemittance'),//银行汇款
							4=>L('BankOther'),		//银行其他转入
                            5=>L('BankSwap'),		//银行换汇 added by jp 20131211
	),
	 'AUDIT_TYPE_MODEL' 	=> array(1=>'Orders', 2=>'LoadContainer', 3=>'Instock', 4 => 'SaleOrder', 5 => 'PreDelivery'), // 审核中类型对应的模块
    'ORDER_TYPE_CHANGE_WAREHOUSE'		=> '5',//销售渠道-转仓
//    'SALE_ORDER_TYPE'					=>	array(1=>L('website'),2=>L('ebay'),3=>L('amazon'),5=>L('change_warehouse'),4=>L('else'),6=>L('aliexpress')),// 销售类型
	'PROCESS_DISCOUNT_TYPE' => array(1=>L('quantity'),2=>L('weight')),//处理费用折扣类型
	 'RETURN_SALE_ORDER_TYPE' => array(1 => L('return_sale_type_order'), 2 => L('return_sale_type_exchange')), // 销退类型
	 'EMAIL_TYPE'			=>	array(1 => '订货单', 2 => '装柜单', 3 => '入库单', 4 => '销售单', 5 => '发货单'),	//支票贴现状态
	 'SALE_ORDER_STATE_PENDING'				=> 1,//销售单待处理状态
	 'SALE_ORDER_STATE_EDITING'				=> 2,//销售单编辑中状态
     'SALE_ORDER_STATE_EXPORTING'			=> 10,//销售单导出中状态
	 'SALE_ORDER_STATE_PICKING'				=> 3,//销售单拣货中状态
	 'SALE_ORDER_STATE_PICKED'				=> 4,//销售单拣货完成状态
	 'SALE_ORDER_STATE_OUT_STOCK'			=> 7,//销售单库存不足状态
	 'SALE_ORDER_BUYER_RETURN'				=> 60,//销售单买家退回状态
	 'SALE_ORDER_OTHER_WAREHOUSE_RETURN'	=> 61,//销售单其他仓库退货状态
	 'SALE_ORDER_POST_OFFICE_RETURNED'		=> 6,//销售单邮局退回状态
	'SHIPPED'								=> '5',//已发货状态值
	'SALEORDER_OBSOLETE'					=> '9',//已作废态值
	'SALE_CAN_ADD_STATE'					=> '1,2',//新增销售单能选择的状态
	'SELLER_CAN_EDIT_STATE'					=> '1,2,3,4',//卖家可以编辑的状态
	'SELLER_CAN_DEL_STATE'					=> '1,2,3',//卖家可以删除的状态
	'ADMIN_CAN_EDIT_STATE'					=> '1,5,60,61,6,7,8,9,12',//后台可以编辑的状态
	'SALE_ORDER_OUT_STOCK'					=> '4,13',//出库操作的销售单状态 (数字从小到大排列)
	'SALE_ORDER_UNRESTORE_DEAL'				=> '4,5,60,61,6,7,8,11,12',	//不还原未分配数量的状态
	'ADMIN_SHIPPED_CAN_EDIT_STATE'			=> '5,60,61,6,7,8,12',//管理员已发货不能修改状态
    'EDIT_ADDRESS_ORDER_STATE'				=>'8,11,4',       //  管理员地址修改可选状态
    'ADDRESS_CHANGED'						=> '11',
    'PICKED'								=> '4',
    'ERROR_ADDRESS'							=> '8',
    'ADDRESS_ERROR_RETURNED'				=> '12',
    'ERROR_OBSOLETE'						=> '8,9',
    'OBSOLETE'								=> '9',
    'STORAGE_LOG_SALE_ORDER_TYPE'			=> '12',
    'STORAGE_LOG_UNDEAL_QUANTITY_TYPE'		=> '18',//edit by yyh 20150720 原(14)
    'SALE_ORDER_DELETED'					=> '13',         //已删除
    'DELETED_CAN_EDIT_STATE'				=> '13,9',      //已删除可编辑的状态
    'AFTER_SHIPPED_STATE'					=> '5,60,61,6,7,8,12',//出库后状态（不包含已作废）
    'ADD_QUESTION_ORDER_AUTOSEARCH'			=> '5,60,61,6',//问题订单可关联的销售单状态
    'INVENTORY_SHORTAGE'					=> '7',//库存不足
    'EDIT_ORDER_NO_STATE'					=> array(7,8,9,11),//地址错误，库存不足，已作废，地址已改
	'SALE_ORDER_DETAIL_VIEW_STATE_SELLER'	=> array(3,4,5,60,61,6,7,8,9,13),
	'SALE_ORDER_DETAIL_VIEW_STATE'			=> array(1,2,3,4,5,60,61,6,7,8,9,13),
	'SALE_ORDER_DETAIL_SPLIT_PACKAGE'		=> array(3,4,5,60,61,6,7,8,9,13),
	'SALE_ORDER_OUT_DETAIL_VIEW_STATE'		=> array(1,2,3,4,5,60,61,6,7,8,9),
	'SALE_ORDER_OUT_INFO_FILTER_DELETED'	=> '1,2,3,4,5,60,61,6,7,8,10,11,12,13',
	'SALE_ORDER_OUT_INFO_FILTER'			=> '1,2,3,4,10,11,13',
	// 销售单状态
	 'SALE_ORDER_STATE'						=>	array(
												1 => L('pending'),                //1待处理【默认】
												2 => L('editing'),		        //2编辑中
												10=> L('exporting'),              //10导出中
												3 => L('pick_in'),	            //3拣货中
												4 => L('picked'),			     	//4拣货完成
												5 => L('shipped'),                //5已发货
												60=> L('buyer_return'),			//60买家退货
												61=> L('other_warehouse_return'),	//61其他仓库退货
												6 => L('post_office_returned'),  //6邮局退回
												7 => L('inventory_shortage'),     //7库存不足
												8 => L('address_error'),          //8地址错误
												11 => L('Address_changed'),       //11地址已改
												9 => L('obsolete'),               //9已作废
												12=> L('address_error_returned'), //12地址错误（邮局退回）
												13=> L('deleted'),                //13已删除
												//注意：编辑成新状态若无需还原分配数量请在（SALE_ORDER_UNRESTORE_DEAL）中也添加同ID，或增加需要分配拣货的销售单状态
											  ),
     'ADMIN_EDIT_ADDRESS_SALE_ORDER_STATE'         => array(//后台编辑地址
                                        3,                  //3拣货中
                                        4,			     	//4拣货完成
                                        8,                  //8地址错误
                                        11,                 //11地址已改
     ),
    'EDIT_ADDRESS_SALE_ORDER_STATE'         => array(//客户编辑地址
                                        8,                  //8地址错误
                                        11,                 //11地址已改
    ),
    'SELECT_SALE_ORDER_STATE'         => array(//后台编辑地址
                                         array('id'=>8,  'value' => L('address_error')),          //8地址错误
                                         array('id'=>11, 'value' => L('Address_changed')),       //11地址已改
     ),
    'ORDER_TYPE'                        => array(2,3),//订单销售渠道EBAY,AMAZON
    'ORDER_TYPE_EBAY'                   => 2,//add yyh 20150929销售渠道ebay
    'NO_SEND_EBAY'                      => 1,//add yyh 20150929已发货的销售单未同步到Ebay
    'CHECK_EBAY_SALE_SHIPPED_LIMIT'     => 500,//add yyh 20150929遍历数据库里几天内未同步到Ebay的发货单CHECK_EBAY_SALE_SHIPPED_LIMIT/天
    'ORDER_TYPE_TABLE_NAME'             => array(
                                    '2' => 'ebay_site',
                                    '3' => 'amazon_site',
    ),

    'ORDER_TYPE_MODULE_NAME'            => array(
                                    '2' => 'EbayAccount',
                                    '3' => 'AmazonAccount',
    ),
	'RETURN_SALE_ORDER_STATE_PENDING'				=> 1,	//退货状态：待海外仓处理
	'RETURN_SALE_ORDER_STATE_WAIT_RETURN_WAREHOUSE'	=> 9,	//退货状态：待退货到仓
	'RETURN_SALE_ORDER_STATE_SIGNED'				=> 11,	//退货状态：已签收
	'RETURN_SALE_ORDER_STATE_REFUSE'				=> 12,	//退货状态：拒收
	'RETURN_SALE_ORDER_STATE_DROPPED'				=> 17,	//退货状态：已丢弃
    'RETURN_CAN_DELETE'                 => '1,8',
	//卖家可以修改的状态
	'SELLER_CAN_EDIT_RETURN_STATE'      => '1,8,9,10',
    'WAIT_ORIGINAL_PACK'                => '8',//待卖家处理意见
    'RETURN_RECEIPT'                    => '2',     //2收到退货
    'FINISH_PROCESSING'                 => '10',     //10卖家已经处理完成,
    'RETURN_SHELVES'                    => '7',//7退货已上架
    'CAN_EDIT_SERVICE'                  => array('1','9') ,
    'PROCESS_COMPLETE'                  => '4',//退货-处理完成
    'RETURN_FOR_DELIVERY'               => '13',
    'PACKED_FOR_DELIVERY'               => '14',
    'DELIVERY_FOR_CLEARANCE'            => '15',//已出库待清关
    'BOOKING_CONFIRM'                   => '16',//已订舱清关确认
    'DELIVERY_FOR_RECEIVE'              => '19',//已出库待收取
    'WAREHOUSE_ROLE_CAN_EDIT'           => array(4),//仓库角色可编辑处理完成和退货已上架
        //added by yyh 20150924
    'NO_OUT_BATCH' => '0',
    'YES_OUT_BATCH' => '1',
    'IS_OUT_BATCH' => array(1=>L('yes'),0=>L('no')),
    'RETURN_SALE_ORDER_STATE_NO_OUT'    =>'13,14',//added by yyh 20150924处理未出库
    'RETURN_SALE_ORDER_STATE_IS_OUT'    =>'19,15,16,17',//added by yyh 20150924 处理已仓库
    'EXCEL_SHOW_LOCATION'   => '4,7,17,13,14,15,16,17,18,19',//added by yyh 20151027 导出显示库位(处理完成需要判断是否手动完成)
    'RETURN_IS_HAND'        => 1, //add by yyh 20151104 手动处理完成
    'RETURN_SALE_ORDER_STATE' =>array(
                                       9 => L('wait_return_warehouse'), //9待退货到仓
                                       1 => L('pending_warehouse'),                //1待处理【默认】
                                       2 => L('return_receipt'),	  //2收到退货
                                       8 => L('wait_seller_opinion'),    //8待卖家处理意见
                                       10=> L('finish_processing'),     //10卖家已经处理完成
                                       3 => L('processing'),	         //3处理中
                                       6 => L('wait_original_pack'),     //6等待原包装
                                       5 => L('wait_accessories'),       //5等待配件
									   4 => L('process_complete'),		 //4处理完成
                                       7 => L('return_shelves'),         //7退货已上架
                                       //针对速卖通新状态       add by lxt 2015.08.26
                                       11=> L('signed'),                //已签收
                                       12=> L('refuse'),                //拒收
                                       13=> L('return_for_delivery'),   //退运待出库
                                       14=> L('packed_for_delivery'),   //已打包待出库
                                       19=> L('delivery_for_receive'),//已出库待收取
                                       15=> L('delivery_for_clearance'),//已出库待清关
                                       16=> L('booking_confirm'),       //已订舱清关确认
                                       17=> L('dropped'),               //已丢弃
                                       18=> L('storage_abnormal'),      //入库异常
									  ),	// 退货单状态
    'DELETE_RETURN_STATE'   =>  array(9,1,2,8,10,3,6,5,11,12),
	'SELLER_RETURN_SALE_ORDER_STATE' =>array(//卖家可选状态
                                       9 => L('wait_return_warehouse'), //9待退货到仓
                                       1 => L('pending_warehouse'),                //1待处理【默认】
	                                   8 => L('wait_seller_opinion'),    //8待卖家处理意见
	                                   10=> L('finish_processing'),     //10卖家已经处理完成       add by lxt 2015.10.15
//								       2 => L('return_receipt'),		 //2收到退货
//									   3 => L('processing'),	         //3处理中
//									   4 => L('process_complete'),		 //4处理完成
									  ),	// 卖家退货单状态
    'ADMIN_RETURN_SALE_ORDER_STATE' =>array(//后台可选状态
                                       9 => L('wait_return_warehouse'), //9待退货到仓
                                       1 => L('pending_warehouse'),                //1待处理【默认】
								       8 => L('wait_seller_opinion'),    //8待卖家处理意见
									   3 => L('processing'),	         //3处理中
                                       6 => L('wait_original_pack'),     //4等待原包装
                                       5 => L('wait_accessories'),       //5等待配件
									   4 => L('process_complete'),		 //4处理完成
                                       7 => L('return_shelves'),         //7退货已上架
                                       //针对速卖通新状态       add by lxt 2015.08.26
                                       11=> L('signed'),                //已签收
                                       12=> L('refuse'),                //拒收
                                       13=> L('return_for_delivery'),   //退运待出库
                                       14=> L('packed_for_delivery'),   //已打包待出库
                                       19=> L('delivery_for_receive'),//已出库待收取
                                       15=> L('delivery_for_clearance'),//已出库待清关
                                       16=> L('booking_confirm'),       //已订舱清关确认
                                       17=> L('dropped'),               //已丢弃
									  ),	// 退货单状态
    'SHOW_LOCATION_RETURN_SALE_ORDER_STATE' =>array(//显示入库库位状态
                                       8,    //8待卖家处理意见
                                       10,      //10卖家已经处理完成
									   3,	         //3处理中
                                       6,     //4等待原包装
                                       5,       //5等待配件
                                       4,       //4处理完成
                                       11,      //已签收
									  ),	// 退货单状态'
    'STORAGE_RETURN_SALE_ORDER_STATE' =>array(//可入库状态
									   3,       //3处理中
                                       4,       //4处理完成
                                       5,       //5等待配件
                                       6,       //6等待原包装
                                       11,      //11已签收         add by lxt 2015.08.28
									  ),	// 退货单状态
    'VIEW_STORAGE_RETURN_STATE'=> array(
                                       3,       //3处理中
                                       4,       //4处理完成
                                       5,       //5等待配件
                                       6,       //6等待原包装
                                       7,       //7退货已上架
									  ),	// 退货单状态

    'RECORD_RETURN_FEE'    => array(//退货费用记录应收款
                            1,//地址错误
                            2,//多次投递未成
                            5,//多次投递未成
                            //6,//回邮单         add by lxt 2015.08.31
        ),
    'CHECK_PACK_RETURN_REASON'=>array(3,4,5),
    'OUTER_PACK'=>array(//外包装
		1=>L('outer_pack_condition'),//外包装完好
		2=>L('outer_pack_broken'),//需换外包装
	),
    'WITHIN_PACK'=>array(//内包装
		1=>L('within_pack_condition'),//内包装完好
		2=>L('within_pack_broken'),//需换内包装
	),
    'CHANGE_PACK'   => 2,
	'RETURN_REASON_OF_SALE_ORDER_STATE_BUYER_RETURN'	=> array(3, 6),//更新订单为“买家退货”状态的退货原因，退货原因4则更新订单为“其他仓库退货”状态,，其他退货原因则更新订单状态为“邮局退回”
	'RETURN_REASON_OTHER_WAREHOUSE_RETURN'				=> 4,//更新订单为“其他仓库退货”状态的退货原因, 退货原因3,6则更新订单为“买家退货”状态，其他退货原因则更新订单状态为“邮局退回”
	'RETURN_REASON'			=> array(//退货原因
								1	=> L('address_error'),//地址错误
								2	=> L('mult_delivery_failure'),//多次投递未成
								3	=> L('buyer_return'),//买家退货
								4	=> L('other_warehouse_return'),//其他仓库退货
                                5	=> L('post_office_returned'),//其他仓库退货
                                6   => L('return_postage'),//回邮单        add by lxt 2015.08.31
	),
    'DAMAGED_OR_LESS'               => 30,          //包裹有破损，或有少货
    //问题订单原因
    'QUESTION_REASON'       => array(
                                10  => L('information_not_updated_timely'),    //信息更新不及时
                                20  => L('delivery_no_sign'),                  //包裹投递成功，但客人未收到
                                30  => L('damaged_or_less'),                   //包裹有破损，或有少货
                                40  => L('package_lost'),                      //包裹已丢失
                                50  => L('address_error'),                     //地址错误   add by lxt 2015.06.11
                                60  => L('provide_buyers_proof'),              //提供买家签收证明   add by ljw 2015.07.28
    ),
    'PROCESS_MODE_REQUIRE'  => '20,30',      //处理方式必填
    'PENDING'               => 10,            //待处理
    'FINISH'                =>  60,         //完成        add by lxt 2015.06.05
    //问题订单状态
    'UNFINISHED'            => 20,
    'QUESTION_ORDER_STATE'  => array(
                                20  => L('unfinished'),         //未完成
                                30  => L('finishi'),            //已完成
    ),
    'UPLOAD_INVOICES'           => 20,          //索赔，请上传发票
    'UPLOADED_PROOF'            => 30,          //已上传签收证明
    'HAS_COMPENSATION'          => 50,          //已赔偿
    'PROVIDE_CLIENT_MOBILE'     =>  45,         //提供买家电话    add by lxt 2015.06.11
    'PENDING_WAREHOUSE'         => 5,            //待海外仓处理 
    'CHECK_CLIENT_INFO'         => 47,          //请核实买家地址或名称    add by lc 2016.04.22
    'WAIT_FOR_SELLOR_TO_DEAL'   => 48,          //待卖家处理      add by lc 2016.04.22
    'PROCESS_MODE'          => array(
                                //未完成
                                5  => L('pending_warehouse'),  //待海外仓处理
                                10  => L('wait_response'),      //待快递公司回复
                                20  => L('upload_invoices'),    //索赔，请上传发票
                                30  => L('uploaded_proof'),     //已上传签收证明
                                40  => L('wait_compensation'),  //等待赔偿
                                45  => L('provide_client_mobile'),//请提供买家电话  add by lxt 2015.06.11
                                46  => L('uploaded_invoices'),//已上传发票  add by ljw 2015.07.17
								47  => L('check_client_info'),//请核实买家地址或名称  add by lml 2016.01.06
							    48  => L('wait_for_sellor_to_deal'),//待卖家处理  add by lml 2016.01.06
                                //已完成
                                50  => L('has_compensation'),   //已赔偿
                                60  => L('process_complete'),   //处理完成
                                70  => L('information_updated'),//信息已更新
    ),
    //问题订单未完成处理方式状态
    'QUESTION_ORDER_UNFINISHED_TREATMENT'  => array(
                                //未完成
                                5  => L('pending_warehouse'),  //待海外仓处理
                                10  => L('wait_response'),      //待快递公司回复
                                20  => L('upload_invoices'),    //索赔，请上传发票
                                30  => L('uploaded_proof'),     //已上传签收证明
                                40  => L('wait_compensation'),  //等待赔偿
                                45  => L('provide_client_mobile'),//请提供买家电话  add by lxt 2015.06.11
                                46  => L('uploaded_invoices'),//已上传发票  add by ljw 2015.07.17
								47  => L('check_client_info'),//请核实买家地址或名称  add by lml 2016.01.06
							    48  => L('wait_for_sellor_to_deal'),//待卖家处理   add by lml 2016.01.06
    ),

    //问题订单已完成处理方式状态
    'QUESTION_ORDER_FINISHED_TREATMENT' => array(
                                //已完成
                                50  => L('has_compensation'),   //已赔偿
                                60  => L('process_complete'),   //处理完成
                                70  => L('information_updated'),//信息已更新
            ),
    //卖家问题订单未完成处理方式状态  add by lc 2016.04.22
    'QUESTION_ORDER_SALLER_UNFINISHED_TREATMENT'  => array(   
                                //未完成
                                5  => L('pending_warehouse'),  //待海外仓处理
                                48  => L('wait_for_sellor_to_deal'),//待卖家处理   
           ),
        
	 'SALE_ORDER_STATE2'	=>	array(1 => L('sale_unfinished'), 3 => L('sale_finished')),	// 销售单状态
	 'PAID_TYPE'			=>	array(1 => L('cash'), 2 => L('pay_bill'), 3 => L('bank')),	// 付款类型
	 'FUND_TYPE'			=>	array(1 =>L('cash'),3=>L('bank')), 				// 款项类型
	 'IS_COST'				=>	array(1 => L('yes'), 2 => L('no')),	//是否记录成本
	 'INSTOCK_TYPE'			=>	array(1 => L('loadcontainer_instock'), 2 => L('add_instock')),	//入库方式
	 'BILL_STATE'			=>	array(2 => L('bill_state_yes'), 1 => L('bill_state_no')),	//支票贴现状态
	 'RELEVANCE_CASH'		=>	array(1 => L('yes'), 2 => L('no')),	//支票贴现状态
	 'MAIN_BASIC_ID'		=>	1,	// 本公司(默认把没有选择所属公司的账目记录到此公司ID当中)
	 'ROLE_TYPE'			=>	array(1 => L("full"), 2=>L("seller"),3 => L('warehouse'),4 => L("partner")), // 角色类型
	 'RECEIVER_TYPE'        =>  array(2=>L("seller"),3 => L('warehouse'),4 => L("partner")),//接收角色类型
	 'MANTISSA'		=>	array(1 => L('mantissa_1'), L('mantissa_2')), // 正箱，尾箱
	 'ACCOUNT_CONDITION'	=>	array(1=>L('paid_payment'),2 => L('non_payment')), // 销售单支付类型
	'QUANTITY_STATE'		=>	array(1 => L('quantity_state_1'), L('quantity_state_2'), L('quantity_state_3'), L('quantity_state_4')), // 角色类型
	 'IMPORT_EXCEL'			=>	array(1=>'国家、城市','员工','颜色','尺码','产品','客户','厂家','其它往来单位','期初库存','库存盘点','厂家期初欠款','客户期初欠款'), // 销售单支付类型
	 'UPLOAD_DIR'			=>	array(		//上传文件目录
	 							1 => 'Product/',//产品
	 							2 => 'Pattern/',//打板
	 							3 => 'SaleOrder/',//打板
	 							10 => 'Excel/',//导入的Excel文件
								11 => 'Excel/TrackOrder/',//导入的追踪订单Excel文件
								12 => 'Excel/InstockDetail/',//导入的Excel文件 发货导入
								13 => 'Excel/InstockImport/',//导入的Excel文件 入库单导入
								14 => 'Excel/SaleOrderImport/',//导入的Excel文件 订单导入
								15 => 'Excel/Picking/',//导出的Excel文件 拣货导出
								16 => 'Excel/PickingImport/',//导入的Excel文件 拣货导入
								17 => 'Excel/ProductImport/',//导入的Excel文件 产品导入
								18 => 'Excel/AdjustDetail/',//导入的Excel文件 库存导入
                                19 => 'SaleOrderFile/',   //订单列表附件
								20 => 'Excel/TrackOrder/',//订单导出
                                21 => 'Excel/InstockStorage/',//发货入库导入
                                22 => 'ReturnSaleOrder/Image/',//退货图片
                                23 => 'QuestionOrder/QuestionImage/',       //问题订单破损图片
                                24 => 'QuestionOrder/TransactionProof/',   //上传签收证明
                                25 => 'QuestionOrder/InvoiceFile/',   //上传发票附件
                                26 => 'Excel/ShiftWarehouseDetail/',//移仓导入    add by lxt 2015.07.20
                                27 => 'ReturnSaleOrderStorage/',//退货入库图片服务       add by lxt 2015.08.31
                                28 => 'Excel/ExpressPost/',//派送方式邮编导入    add by yyh 20151102
                                29 => 'Message/File/',//派送方式邮编导入    add by yyh 20151102
								30 => 'Factory/Logo/',//卖家logo
                                31 => 'Excel/EmailFile/',
								32 => 'Vat/VatFile/',//VAT上传VAT证明
                                33 => 'Excel/ProductCheckImport/',//导入的Excel文件 产品查验导入
		 						35 => 'Excel/AdjustInstockDetail/',//导入的Excel文件 入库导入调整导入
	 							),
    'QUESTION_IMAGE'                => 23,//Gallery表格中  问题订单破损图片关联类型
    'TRANSACTION_PROOF'             => 24,//Gallery表格中  上传签收证明关联类型
    'INVOICE_FILE'                  => 25,//Gallery表格中  上传发票附件关联类型
    'TRACK_ORDER_RELATION_TYPE'     => 20,//Gallery表格中  新订单导出关联类型
	'VAT_FILE'						=> 32,//Gallery表格中  新VAT上传VAT证明
	 'INVOICE_HOLIDAY_TYPE'=> array(1=>L('in_invoice'),2=>L('out_invoice'),3=>L('both_invoice')),
	 'STOCKTAKE_TYPE'=> array(1=>L('stocktake_type_1'),2=>L('stocktake_type_2')),//盈亏单盘点类别
	 'INVOICE_TYPE'	=> array(1=>L('saleorder'),2=>L('return_sale_type_order')),
	 'COMPARE_TYPE'	=> array(1=>L('compare_type_year'),2=>L('compare_type_month'),3=>L('compare_type_day')),
	 'PROFIT_USER'	=> array(1=>L('compare_type_month'),2=>L('compare_type_year')),
     'ACTION_TITLE_ARY' => array(
		'alistUnfinishOrder' => L('alistUnfinishOrder'),
		'alistFinishOrder' => L('alistFinishOrder'),
		'alistUnfinish' => L('alistUnfinish'),
		'alistFinish' => L('alistFinish'),
		'alistUndelivery' => L('alistUndelivery'),
		'unsentEmailList' => L('unsentEmailList'),
		'deleteEmailList' => L('deleteEmailList'),
		'waitDelivery' => L('waitDelivery'),
		'waitLoadContainer' => L('waitLoadContainer'),
		'waitInstock' => L('waitInstock'),
		'waitPreDelivery' => L('waitPreDelivery'),
		'waitDelivery' => L('waitDelivery'),
		'alistReturnOrder' => L('alistReturnOrder'),
		'alistSaleOrder' => L('alistSaleOrder'),
		'lcStorage' => L('lcStorage'),
		'multiStorage' => L('multiStorage'),
		'returnNoUse' => L('returnNoUse'),
		'productInstock'=>L('product_instock'),
        'onloadQuantity'=>L('onload_quantity'),
		'productSale'	=> L('product_sale'),
		'productAdjust'	=> L('product_adjust'),
		'storageDetail'	=> L('storage_detail'),
		'saleStatDetail'=> L('sale_stat_detail'),
		'saleStatProduct'=>L('sale_stat_product'),
		'clientDealAnalysisDetail'=>L('clientDealAnalysisDetail'),
		'clientDealAnalysisProduct'=>L('clientDealAnalysisProduct'),
		'orderUnload'	=> L('order_unload'),
		'loadUninstock'	=> L('load_uninstock'),
		'productReturn'	=> L('productReturn'),
		'productStorageIni'=>L('productStorageIni'),
		'productDelivery'=>L('productDelivery'),
		'insertcity'=> L('insertcity'),
		'exportSaleOrder'=> L('exportSaleOrder'),
        'exportSaleOrderList'=>L('exportSaleOrderList'),
		'importTrackNo'  => L('importTrackNo'),
		'trackNoList'    => L('trackNoList'),
		'ClientOtherArrearages'=>array(
			'add'=>L('addclientotherarrearages'),
			'insert'=>L('addclientotherarrearages'),
			'delete'=>L('delclientotherarrearages'),
			),
		'ClientStat'=>array(
			'view'=>L('viewclientstat'),
			'collectByClass'=>L('collectbyclassclientstat'),
			),
        'FactoryStat'	=> array(
			 'view' => L('view_factoryt_stat')
		 ),
        'FactoryOtherArrearages'=> array(
			 'index' => L('module_factoryotherarrearages_detail')
		 ),
		'Factory'	=> array(
			 'setting' => L('company_setting')
		 ),
        'LogisticsStat'	=> array(
			 'view' => L('view_logistics_stat')
		 ),
        'LogisticsOtherArrearages'=> array(
			 'index' => L('module_logisticsarrearages_detail')
		 ),
        'WarehouseStat'	=> array(
			 'view' => L('view_warehouse_stat')
		 ),
        'WarehouseOtherArrearages'=> array(
			 'index' => L('module_warehousearrearages_detail')
		 ),
        'StatProduct'   => array(
            'productDetail' => L('module_StatProduct'),
        ),
        'WarehouseAccount'   => array(
            'checkAccount' => L('warehouse_check_account'),
        ),
        'DhlList'   => array(
			'request'			=> L('execution_request'),
            'requestList'	=> L('dhl_request_list'),
        ),
        'CorreosList'   => array(
			'request'			=> L('execution_request'),
            'requestList'	=> L('correos_request_list'),
        ),
        'Config'   => array(
			'index'			=> L('module_Config'),
        ),
	),
    'FAC_ACTION_TITLE_ARY' => array(
		'ClientOtherArrearages'=>array(
			'add'=>L('addclientotherarrearages'),
			'insert'=>L('addclientotherarrearages'),
			'delete'=>L('delclientotherarrearages'),
			),
		'ClientStat'=>array(
			'index'			=> L('payable_stat_list'),
			'view'			=>L('funds_detail_list'),
			'collectByClass'=> L('funds_rollup'),
			),
		 'SellerStaff'=>array(
			 'add'		=> L('insert') . L('module_Employee'),
			 'insert'	=> L('insert') . L('module_Employee'),
			 'index'	=> L('module_Employee') . L('index'),
		 ),
		'module_243'	=> L('funds_manage'),
	),
	'MODULE_NO_INDEX' => array('SaleOrderImport','ProductImport','ProductCheckImport'),
	'BANK_LOG_PAY_CLASS_ID' => 2,
	//卖家角色值
	'SELLER_ROLE_ID'   => 3,
	'ADMIN_ROLE_TYPE'  =>1,
	//卖家类型值
	'SELLER_ROLE_TYPE' => 2,
    //合作伙伴类型值
	'PARTNER_ROLE_TYPE' => 4,
	//仓库类型值
	'WAREHOUSE_ROLE_TYPE' => 3,
	//卖家下级所属角色
	'SELLER_BELONG_ROLE_ID' => '3,4,5,6',
	//卖家角色所属数据模块
	'BELONG_DATA_MODEL' =>array('SellerStaff','SaleOrder','EbayAccount','AmazonAccount'),
	//仓库角色所属数据模块
	'WAREHOUSE_DATA_MODEL' =>array('SaleOrder'),
	//系统尺寸单位
	'SIZE_UNIT'	=>L('size_unit'),
	'VOLUME_SIZE_UNIT'	=>L('volume_size_unit'),
	//系统重量单位
	'WEIGHT_UNIT'	=>L('weight_unit'),

	'BARCODE_PC_TYPE'	=> 'gif',
	'BARCODE_CODE_TYPE'	=> 'code128',
	//默认订单导出发货人
    'EXPORT_DE_DPD_SALEORDER_CONSIGNOR' => 'EDA Dienstleistungen GmbH',//德国DPD
	'EXPORT_SALEORDER_CONSIGNOR'		=> 'Eda Warehousing DE. UG',
	'EXPORT_DEUTSCHE_POST_CONSIGNOR'	=> 'Eda Warehousing DE. UG',
    'EXPORT_FR_POST_CONSIGNOR'          => 'Eda Warehousing FR.',
	'EXPORT_IT-GLS_CONSIGNOR'			=> 'EDA ITALY S.R.L',
	//默认德国邮政adress_typ值
	'EXPRESS_WAY_DHL_DEUTSCHE_POST' => array('Postfach'),
	//默认德国邮政adress_typ值
	'EXPORT_DEUTSCHE_POST_ADRESS_TYP_DEFAULT' => 'HOUSE',
	//德国邮政包含Postfach时adress_typ值
	'EXPORT_DEUTSCHE_POST_ADRESS_TYP_OTHER'   => 'POBOX',
	//送货地址是：Paketestation 时，只允许客人选用DHL的派送方式
	'EXPRESS_WAY_DHL'			 => array('Postfiliale','Packstation','Paketestation'),
	//派送方式绑定虚拟托盘销售渠道
	'VIRTUAL_ORDERTYPE_EXPRESS'	=>  array(C('EXPRESS_PL-VIRTUAL'),C('EXPRESS_IT-VIRTUAL'),C('EXPRESS_FR-VIRTUAL'),C('EXPRESS_ES-VIRTUAL'),C('EXPRESS_DE-VIRTUAL')),
	//派送方式绑定托盘派送销售渠道
	'TRAY_ORDERTYPE_EXPRESS'	=>  array(C('EXPRESS_UK-Palletforc'),C('EXPRESS_PL-Pallet-UK'),C('EXPRESS_PL-Pallet-Oversea'),C('EXPRESS_PL-Pallet-3'),C('EXPRESS_PL-Pallet-2'),C('EXPRESS_PL-Pallet'),C('EXPRESS_FR-Pallet-UKFBA'),C('EXPRESS_FR-Pallet-OVERSEA'),C('EXPRESS_FR-Pallet'),C('EXPRESS_ES-Pallet-OVERSEA'),C('EXPRESS_ES-Pallet'),C('EXPRESS_DE-Palette')),
	// COOKIE登录无操作过期时间间隔
	'COOKIE_EXPIRE_INTERVAL'=> array(
		0   => 1800,	  //管理员
		1	=> 1800,	  //公司
		2	=> 1800,	  //卖家
		3	=> 1800,      //卖家员工
		4	=> 1800,      //合作伙伴
		5	=> 300,       //仓库
	),
	//模板序号
	'YTT_TABLE_SERIAL'   =>1,
	//导入文件类型
	'CFG_FILE_TYPE'	=> array(
		1	=> 'InstockImport',//入库导入
		2	=> 'Picking',//拣货导出
		3	=> 'PickingImport',//拣货导入
	),
	//导入成功状态
	'CFG_IMPORT_SUCCESS_STATE'	=> 101,
	//导入失败待处理状态
	'CFG_IMPORT_FAILED_STATE'	=> 102,
	//导入失败已处理状态
	'CFG_IMPORT_PROCESSED_STATE'	=> 103,
	//导入状态
	'CFG_FILE_IMPORT_STATE'	=> array(
		101	=> L('import_success'),//导入成功
		102 => L('pending'),//导入失败
		103 => L('processed'),//导入失败处理完成
	),
	//是否挂号取值
	'CFG_IS_REGISTERED'=> array(1=>L('yes'),2=>L('no')),
	//订单导入提示
	'SALE_ORDER_IMPORT_TIPS' => array(
        'aliexpress_token'=> L('aliexpress_token'),
        'order_date'    => L('order_date'),
        'is_registered' => L('is_registered'),
        'country_name'  => L('country_name'),
		'order_no,factory_id,backage_bg'	=> L('order_no_serial_number'),
		'order_no,factory_id'	=> L('order_no_serial_number'),
		'order_no'      => L('order_no_serial_number'),
		'client_id'     => L('clientname'),
		'order_type'    => L('order_type_serial_number'),
		'warehouse_id'  => L('shipping_warehouse_sn'),
		'express_id'    => L('shipping_name'),
		'express_detail_id' => L('select_express_way_error'),
		'comp_name'		=> L('clientname'),
		//'comp_type'		=> L('client_type'),
		'consignee'     => L('consignee'),
		'address'       => L('street1'),
		'address2'      => L('street2'),
		'city_name'		=> L('city'),
		'post_code'		=> L('postcode'),
		'country_id'    => L('country_no'),
		'company_name'	=> L('street3'),
		'is_insure'     => L('insure'),
        'addition[1][company_name]' =>L('street3'),
	),
	//产品导入提示
	'PRODUCT_IMPORT_TIPS' => array(
		'cube_long'		        => L('long_with_unit'),
		'cube_wide'		        => L('wide_with_unit'),
		'cube_high'		        => L('high_with_unit'),
		'weight'		        => L('weight_with_unit'),
		'warning_quantity'      => L('storage_remind'),
		'product_no,factory_id' => L('product_no'),
        'custom_barcode'        => L('custom_barcode'),
	),
    //产品查验导入导入提示
	'PRODUCT_CHECK_IMPORT_TIPS' => array(
        'id'                    => L('product_id'),
		'check_long'		    => L('long_with_unit'),
		'check_wide'		    => L('wide_with_unit'),
		'check_high'		    => L('high_with_unit'),
		'check_weight'		    => L('weight_with_unit'),
		'check_status'          => L('check_status'),
	),
	//订单导入提示
	'RETURN_SALE_ORDER_IMPORT_TIPS' => array(
		'sale_order_number'	=> L('sale_quantity'),
		'warehouse_id'		=> L('shipping_warehouse_sn'),
		'consignee'			=> L('consignee'),
		'address'			=> L('street1'),
		'city_name'			=> L('city'),
		'post_code'			=> L('postcode'),
		'country_id'		=> L('country_no'),
		'company_name'		=> L('street3'),
		'return_order_date'	=> L('return_sale_date'),
		'return_track_no'	=> L('return_waybill_no'),
	),
    'INSTOCK_IMPORT_TIPS'   => array(
        'container_no'      => L('logistics_no'),
        'container_no,factory_id'      => L('logistics_no'),
        'logistics_id'      => L('logistics_name'),
        'warehouse_id'      => L('warehouse_no'),
    ),
	//退货服务配置
	'RETURN_SERVICE_DETAIL_ID'		  => 'service_detail_id',
	'RETURN_SERVICE_QUANTITY'		  => 'quantity',
	'RETURN_SERVICE_PRICE'		      => 'price',
	'FUNDS_RELATED_DOC_NO'				=> array(//款项类别关联单据
									1 => L('delivery_no'),//头程发货-发货单号
									2 => L('deal_no'),//销售单-处理单号
									3 => L('return_sale_order_no'),//退货单-退货单号
									4 => L('product_id'),//产品id
                                    5 => L('question_order'),//问题订单
                                    6 => L('warehouse_account'),//仓储费对账单
                                    7 => L('module_packbox'),//仓储费对账单
	),
	'FUNDS_RELATED_DOC_MODULE'			=> array(//款项类别关联单据
									1 => 'Instock',
									2 => 'SaleOrder',
									3 => 'ReturnSaleOrder',
									4 => 'Product',
                                    5 => 'QuestionOrder',   //问题订单
                                    6 => 'WarehouseAccount',   //仓储费对账
                                    7 => 'PackBox',   //仓储费对账
	),
	'BILLING_TYPE'			=> array(//计费方式
		1 => L('billing_type_total'),//合计
		2 => L('billing_type_box_quantity'),//箱数
		3 => L('billing_type_cube'),//立方数
		4 => L('billing_type_weight'),//重量
		5 => L('billing_type_quantity'),//数量
	),
	'BILLING_TYPE_TOTAL'	=> 1,//计费方式->合计
	'BILLING_TYPE_CUBE'		=> 3,//计费方式->立方数
	'BILLING_TYPE_WEIGHT'	=> 4,//计费方式->重量
	'SHIPPING_TYPE_SURFACE' => 1,//平邮
	'SHIPPING_TYPE'=>array(//派送类别
		1=>L('shipping_type_surface'),//平邮
		2=>L('shipping_type_express'),//快递
        3=>L('oneself_take'),//自提
	),
	'SHIPPING_TYPE_EXPRESS'	=> array(2,3),// 需要打折的派送类别
	'SYS_EURO_ID'	=> 2,//系统币种欧元ID
	'VAR_CAPTCHA'	=> 'captcha_token',//验证码session下标变量
	'CONFIRM_STATE' => array(
		0	=> L('unconfirmed'),//待确认
		1	=> L('confirmed'),//已确认
	),
	'CONFIRM_STATE_CONFIRMED'	=> 1,
	'CFG_FACTORY_PRODUCT_BARCODE_CONFIG' => array(
		'product_name'	=> L('product_name'),
		'made_in_china'	=> L('made_in_china'),
	),
	'CFG_NOT_CACHE_DD_NAME'=>array(
		'client'	=> 14,
	),
	'FACTORY_PERMISSION_DENIED' => array(
		'Bank'					=> array('edit', 'update', 'add', 'insert', 'delete'),
		'Shipping'				=> array('edit', 'update', 'add', 'insert', 'delete'),
		'Warehouse'				=> array('edit', 'update', 'add', 'insert', 'delete'),
		'ShippingCost'			=> array('edit', 'update', 'add', 'insert', 'delete'),
		'ProcessFee'			=> array('edit', 'update', 'add', 'insert', 'delete'),
		'ReturnProcessFee'		=> array('edit', 'update', 'add', 'insert', 'delete'),
		'DomesticShippingFee'	=> array('edit', 'update', 'add', 'insert', 'delete'),
		'Basic'					=> array('edit', 'update', 'add', 'insert', 'delete'),
		'WarehouseLocation'		=> array('edit', 'update', 'add', 'insert', 'delete'),
		'OrderType'				=> array('edit', 'update', 'add', 'insert', 'delete'),
		'WarehouseFee'			=> array('edit', 'update', 'add', 'insert', 'delete'),
		'FundsClass'			=> array('edit', 'update', 'add', 'insert', 'delete'),
		'Message'				=> array('edit', 'update', 'add', 'insert', 'delete'),
		'Package'				=> array('edit', 'update', 'add', 'insert', 'delete'),
		'ReturnService'			=> array('edit', 'update', 'add', 'insert', 'delete'),
		'FundsClass'			=> array('edit', 'update', 'add', 'insert', 'delete'),
	),
	'EXPORT_SUM_QUANTITY_LIMIT' => 1000,//导出总数量限制
	'PRINT_BARCODE_MODULE'	=> array(//1不弹窗显示，2弹窗显示
		'Product'	=> 1,
		'Instock'	=> 2,
		'SaleOrder'	=> 1,
        'PackBox'   => 1,
        'OutBatch'  => 1,
	    'ReturnSaleOrder'  =>  1,//add by lxt 2015.09.01
	),
    //跟原来的EXPORT_BARCODE_MODULE一样，为了防止有的模块不需要这个功能       add by lxt 2015.10.21
    'PRINGT_BARCODE_MODULE' =>  array(
        'Product',
    ),
	'EXPORT_BARCODE_MODULE'	=> array(
		'Product',
	    'ReturnSaleOrder',//add by lxt 2015.10.21
	),
	'QUICK_EXPORT_BARCODE_MODULE'	=> array(
		'Instock',
        'PackBox',
        'SaleOrder',
	),
    'STORAGE_REMIND_EMAIL_TYPE'     => 6,//库存预警邮件类型
    'DOWNLOAD_FILE_TYPE'            => 19,//编辑订单中的下载附件类型
    'MESSAGE_DOWNLOAD_FILE_TYPE'    => 29,//编辑订单中的下载附件类型

	'WHETHER_RELATED_DEAL_NO'		=>array(1=>L('yes'),0=>L('no')),//退货是否关联处理单号
	'IS_RELATED_SALE_ORDER'			=> 1,
    'barcode'       =>1,
    'FIFO_PICKING'  => 11,



//装箱单列表配置
    //装箱小包状态
    'PARCEL_STATE'  => array(
        0   => L('normal'),
        1  => L('warehouse_damaged'),
        2  => L('warehouse_lose'),
    ),

    'CUSTOMS_CLEARANCE_NORMAL'                  =>0,
    'CUSTOMS_CLEARANCE_REPORTING_DISCREPANCIES' =>1,
    'CUSTOMS_CLEARANCE_CUSTOMS_SEIZED'          =>2,
    'CUSTOMS_CLEARANCE_STATE'  => array(
        0   => L('normal'),
        1  => L('reporting_discrepancies'),
        2  => L('customs_seized'),
    ),

    'ASSOCIATE_WITH_NORMAL'     => 0,
    'ASSOCIATE_WITH_ABNORMAL'   => 1,
    'ASSOCIATE_WITH_STATE'  => array(
        0   => L('normal'),
        1  => L('abnormal'),
    ),
    //added by yyh 20150924
    'NO_ASSOCIATE_WITH' => 0,//未交接
    'IS_ASSOCIATE_WITH' => array(1=>L('yes'),0=>L('no')),


    'QUARTER'       => array(//月份所属季度
        '01' => 1,
        '02' => 1,
        '03' => 1,
        '04' => 2,
        '05' => 2,
        '06' => 2,
        '07' => 3,
        '08' => 3,
        '09' => 3,
        '10' => 4,
        '11' => 4,
        '12' => 4,
    ),
    'QUARTER_END_DATE'  => array(
        1   => '04-01',
        2   => '07-01',
        3   => '10-01',
        4   => '01-01',//需要年份加1
    ),
    'NEW_YEAR_QUARTER'  => 4,//跨年的季度
    'QUARTER_FIELD' => array(
        1 => "first_quarter",
        2 => "second_quarter",
        3 => "third_quarter",
        4 => "fourth_quarter",
    ),
    //订单处理费用类型      add by lxt 2015.06.18
    'ACCORD_TYPE'      =>  array(
        1   =>  L('quantity'),
        2   =>  L('weight'),
    ),
    //定时器类型timer
    'TIMER_TYPE'            => array(
		'InstockBox'	=> 1,
	),
    'IS_COMPLETE'   => array(
        'pending'       => 0,//待处理
        'processing'    => 1,//处理中
        'succeed'       => 2,//成功
        'failed'        => 3,//失败
    ),
    'IS_COMPLETE_SUCCEED'   => 2,//定时器处理完成
    'PRODUCT_TYPE_SIMPLE_PRODUCT'		=> 1,
    'PRODUCT_TYPE_COMBINATION_PRODUCT'	=> 2,
    'PRODUCT_TYPE'						=> array(1 => L('simple_product'), 2 => L('combination_product')),// 产品类型
    'IS_PRODUCT_TYPE' => C('multiple_product_type')==1 ? TRUE : FALSE,
    //拒收原因          add by lxt 2015.08.27
    'REFUSE_REASON'     =>  array(
        1   =>  L('package_damaged'),//包裹破损拒收
        2   =>  L('freight_at_destination'),//包裹运单到付拒收
    ),
    //拒收        add by lxt 2015.08.28
    'REFUSE'    =>  12,
    //签收        add by lxt 2015.08.28
    'SIGNED'    =>  11,
    //已丢弃           add by lxt 2015.08.28
    'DROPPED'   =>  17,
    //入库异常原因            add by lxt 2015.08.30
    'STORAGE_ABNORMAL_REASON'   =>  array(
        1   =>  L('cant_identify'),//单号无法识别，系统同步问题
        2   =>  L('product_with_wrong_name'),//货物与品名不符
        3   =>  L('not_through_security'),//未通过安检
        4   =>  L('quantity_not_to_match'),//实收件数与系统退货件数不符
    ),
    //入库异常      add by lxt 2015.08.30
    'STORAGE_ABNORMAL'  =>  18,
    //退运待出库     add by lxt 2015.08.30
    'RETURN_FOR_DELIVERY'   =>  13,
    //退货入库列表可显示的退货单状态       add by lxt 2015.08.30
    'STORAGE_SHOW_STATE'    =>  '4,7,13,14,15,16,17,18,19',
    //回邮单       add by lxt 2015.08.31
    'RETURN_POSTAGE'    =>  6,
    //速卖通
    'ALIEXPRESS'    =>  6,
    'IS_ALIEXPRESS' =>array(1=>L('yes'),2=>L('no')), 				//是否速卖通
    'SELECT_YES'    => 1,
    //处理方式          add by lxt 2015.09.22
    'TREATMENT'     =>  array(
        1   =>  L('down_and_destory'),
        2   =>  L('back_to_domestic')
    ),
    //是否开启外部条码  add yyh 20151016
    'IS_CUSTOM_BARCODE' =>array(1=>L('yes'),2=>L('no')),
    //邮编数字区间
    'CUSTOM_BARCODE_MIN'  => 6,
    'CUSTOM_BARCODE_MAX'  => 13,
    'CUSTOM_BARCODE_PREFIX' => 'EDA',//产品条码默认前缀
    'SEA_TRANSPORT'     => 1,
	'HAVE_READED'=>1,  //信息已读状态
	'UNREAD' =>2,//信息未读状态
	'HAVE_ANNOUNCED'=>1,//信息已发布
	'BEFORE_ANNOUNCED'=>2,//信息尚未发布
	'IS_ANNOUNCED'=>array(
		1=>L('yes'),
		2=>L('no'),
	),
	'IS_READ'=>array(
			1=>L('yes'),
			2=>L('no'),
		),
	'EXPRESS_API_ALLOW_REQUEST_STATUS'		=> array(//快递api 需要重新发送请求的状态
		EXPRESS_API_REQUEST_STATUS_PENDING,		//待请求
		EXPRESS_API_REQUEST_STATUS_FAILED,		//请求失败
		EXPRESS_API_REQUEST_STATUS_ABNORMAL,	//请求异常
	),
	'EXPRESS_API_REQUEST_STATUS'			=> array(//快递api 请求状态列表
		EXPRESS_API_REQUEST_STATUS_PENDING		=> L('request_status_pending'),//待请求
		EXPRESS_API_REQUEST_STATUS_REQUESTING	=> L('request_status_requesting'),//请求中
		EXPRESS_API_REQUEST_STATUS_SUCCESSFUL	=> L('request_status_successful'),//请求成功
		EXPRESS_API_REQUEST_STATUS_FAILED		=> L('request_status_failed'),//请求失败
		EXPRESS_API_REQUEST_STATUS_ABNORMAL		=> L('request_status_abnormal'),//请求异常
		EXPRESS_API_REQUEST_STATUS_CANCELLED	=> L('request_status_cancelled'),//取消请求
	),
	'EXPRESS_API_REQUEST_TYPE'				=> array(//快递api 请求类型列表
		'createShipmentDD'		=> L('request_type_create'),//创建发货
		'updateShipmentDD'		=> L('request_type_update'),//更新发货
		'deleteShipmentDD'		=> L('request_type_delete'),//删除发货
	),
	//状态
	'VAT_CONFIRM_STATUS'	=> array(
		1 => '待审核',//导入成功
		2 => '未通过',//导入失败
		3 => '已通过',//导入失败处理完成
	),
	//问题订单统计时间
	'QUESTION_ORDER_PERIOD'	=> array(
		1 => '-1 month',//一个月内
		2 => '-3 months',//三个月内
		3 => '-6 months',//半年内
	),
	//
	'WAREHOUSE_ACCOUNT_MIN_DATE'	=> '2017-01-01',
);