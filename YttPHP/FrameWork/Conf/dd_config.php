<?php
/**
 +------------------------------------------------------------------------------
 * Dd字典转换公共文件
 +------------------------------------------------------------------------------
 * @copyright   2011 展联软件友拓通
 * @category   	DD配置文件
 * @package  	PHP 
 * @version     2011-03-23
 * @author      all
 +------------------------------------------------------------------------------
 */
return array( 
	//字典 
	'FORMAT_DD'	=> array(
								'basic_id' 	 		=> 'basic', 			// 本公司
								'city_id' 	 		=> 'city', 				// 城市
								'country_id' 		=> 'country',			// 国家
								'role_id'	 		=> 'role',				// 角色
								'employee_id'		=> 'employee',			// 员工---规范DD名称
								'position_id'		=> 'position',			// 职务
								'department_id'		=> 'department',		// 部门
								'currency_id'		=> 'currency',			// 币种
//								'befor_currency_id'		=> 'currency',		// 币种
//								'factory_currency_id'=>'currency',			// 该表有两种币种
								'user_name'			=> 'employee_no', 		// 用户名称
//								'client_id'	 		=> 'client' ,			// 客户
								'express_id'        => 'express',           // 快递
								'package_id'	 	=> 'package' ,			// 包装
								'factory_id'		=> 'factory' ,			// 厂家
								'logistics_id'		=> 'logistics' ,			// 物流公司
								'product_id'		=> 'product' ,			// 产品
								'product_class_id'	=> 'product_class' ,	// 类别
								'properties_id'	 	=> 'properties' ,		// 产品属性
								'color_id'			=> 'color',				// 颜色
								'size_id'			=> 'size',				// 尺码
								'warehouse_id'		=> 'warehouse',			// 仓库
								'user_id'	 		=> 'user_real_name' ,	// 用户
								'add_user'			=> 'add_user',				// 用户 
								'user_id'			=> 'add_user',				// 用户 
								'auditor'			=> 'auditor',				// 用户
								'p_id'	 			=> 'product' ,			//请修改
								'company_id'		=> 'company' ,			//请修改
								'comp_id'	 		=> 'company' ,			//请修改
								'bank_id'	 		=> 'bank' ,				//银行
								'b_bank_id'	 		=> 'bank' ,				//银行
								'pay_class_id'	 	=> 'pay_class' ,				//银行
//								'from_currency_id'	 => 'currency' ,				//汇率来源币种
//								'to_currency_id'	 => 'currency' ,				//汇率来源币种
								'usbkey'			 => 'epass',			// USBKey
								'return_currency_id' => 'currency',
								'connect_client'	 => 'client',
								'supplier_id'		 => 'invoice_company',
								'invoice_comp_id'	 => 'invoice_company',
//								'invoice_product_id' => 'invoice_product',
								'invoice_client_id'	 => 'invoice_company', 
								'city_parent_id'	 => 'country',
								'warehouse_location_id' => 'warehouse_location',
								'ship_id'			 => 'shipping',
                                'shipping_cost_id'   =>'shipping_cost',
								'warehouse_fee_id'   => 'warehouse_fee',//added by yyh20150819
                                'order_type'         => 'order_type',//added by yyh20160127
							),
	//HTML
	'FORMAT_HTML'	=> array(
								'comments', 
								'notify', 
								'receive_addr', // 发货地址
								'pattern_comments',//打板备注
								'finish_comments',//交板备注
								'address',	
								'address2',
								'merge_address',
								'bank_account',
								'w_address',
								'user_comments',
								'log_comments',
								'check_comments',//查验备注
								'get_address',//取货地址
								'client_comments',//卖家备注
								'country_name',
								'warehouse_comment',
								'warehouse_comments',
                                'factory_comments',
								'status_message',
							),
	//数字小数位数 金额=>1,单价=>2,数量=>3,整数=>4,体积规格=>5
	'FORMAT_MONEY'	=> array(
								'sum_pid'=>3, 
								'order_qn'=>4,
								'remind_money'=>1, 
								'money'=>1, 
								'other_money'=>1, 
								'sum_other_money'=>1, 
								'register_fund'=>1,
								'remind_money'=>1, 
								'base_money'=>1, 
								'owed_money'=>1,
								'account_money'=>1, 
								'total_money'=>1, 
								'should_paid'=>1, 
								'original_money'=>1, 
								'remaining_money'=>1, 
								'return_money'=>1,
								'in_money'=>1, 
								'out_money'=>1, 
								'have_paid'=>1, 
								'use_paid'=>1, 
								'sum_need_paid'=>1, 
								'befor_money'=>1, 
								'paid_for_money'=>1, 
								'income_money'=>1, 
								'outlay_money'=>1, 
								'account_money'=>1, 
								'discount_money'=>1, 	//折扣
								'need_paid'=>1, 		//需付款
								'expected_delivery_costs'=>1,           //需付款
								'credit'=>1, 
								'instock_price'=>2, 
								'sale_price'=>2,
                                //added by jp 20131202 st
                                'box'=>4,
                                'item'=>4,
                                'parts'=>4, 
                                'sum_box'=>4,
                                'sum_item'=>4,
                                'sum_parts'=>4,         
                                //added by jp 20131202 st
								'quantity'=>C('quantity_format')==2?2:4,  
								'diff_quantity'=>4,
								'accepting_quantity'=>4,//验收数量
								'load_quantity'=>4, 
								'sun_quantity'=>4, 
								'order_quantity'=>4, 
								'capability'=>4, 
								'dozen'=>4, 
								'pieces'=>4, 
								'other_quantity'=>4, 
								'other_capability'=>4, 
								'other_dozen'=>4, 
								'other_pieces'=>4, 
								'balance' =>1,
								'total_quantity'		=> C('quantity_format')==2?2:4,
								'real_storage'=>3, 
								'sale_storage'=>3, 
								'no_use_quantity'=>3, 
								'sale_quantity'=>C('quantity_format')==2?2:4, 
								'init_quantity'=>C('quantity_format')==2?2:4, 
								'stock_quantity'=>C('quantity_format')==2?2:4, 
								'back_quantity'=>C('quantity_format')==2?2:4, 
								'adjust_quantity'=>C('quantity_format')==2?2:4, 
								'stocktake_quantity'=>C('quantity_format')==2?2:4, 
								'real_quantity'=>C('quantity_format')==2?2:4, 
								'sale_order_number'=>C('quantity_format')==2?2:4, 
								'onroad_quantity'=>C('quantity_format')==2?2:4, 
								'reserve_quantity'=>C('quantity_format')==2?2:4, 
								'picking_quantity'=>C('quantity_format')==2?2:4, 
								'undeal_quantity'=>C('quantity_format')==2?2:4, //未分配数量
								'sum_load_quantity'=>C('quantity_format')==2?2:4, 
								'sum_sale_quantity'=>C('quantity_format')==2?2:4, 
								'sum_init_quantity'=>C('quantity_format')==2?2:4, 
								'sum_stock_quantity'=>C('quantity_format')==2?2:4, 
								'sum_back_quantity'=>C('quantity_format')==2?2:4, 
								'sum_adjust_quantity'=>C('quantity_format')==2?2:4, 
								'sum_stocktake_quantity'=>C('quantity_format')==2?2:4, 
								'sum_no_use_quantity'=>C('quantity_format')==2?2:4, 
								'sum_real_quantity'=>C('quantity_format')==2?2:4, 
								'sum_sale_order_number'=>C('quantity_format')==2?2:4, 
								'sum_onroad_quantity'=>C('quantity_format')==2?2:4,
								'sum_reserve_quantity'=>C('quantity_format')==2?2:4,
								'sum_picking_quantity'=>C('quantity_format')==2?2:4,
								'sum_undeal_quantity'=>C('quantity_format')==2?2:4,//未分配数量
								'out_quantity'		=> C('quantity_format')==2?2:4,
								'in_quantity'		=> C('quantity_format')==2?2:4,
								're_quantity'		=> C('quantity_format')==2?2:4,
								'use_qn'			=> C('quantity_format')==2?2:4,
								'no_use_qn'			=> C('quantity_format')==2?2:4,
								'sum_qua'			=> C('quantity_format')==2?2:4,
								'pattern_price'=>2, //交板价格
								'delivery_fee'=>1, 
								'process_fee'=>1, 
								'package_fee'=>1, 
								'return_fee'=>1,
                                'return_additional_fee'=>1,
								'delivery_cost'=>1,
								'other_fee_total'=>1,
								'other_fee'=>1,
								'delivery_fee_detail'=>2, 
								'row_money'=>1, 
								'price'=>2,
								'cost'=>2,
								'registration_fee' =>2,
								'registration_cost' =>2,
								'return_base_price'=>2, 
								'avg_price'=>2, 
								'wholesale_price'=>2, 
								'retail_price'=>2, 
								'exchange_rate'=>2, 
								'rate'	=>2,
								'last_price_1' =>2,  
								'last_price_2' =>2,  
								'last_price_3' =>2,  
								'last_price_4' =>2,  
								'last_price_5' =>2,  
								'avg_price_1' =>2,
								'avg_price_2' =>2,
								'avg_price_3' =>2,
								'avg_price_4' =>2,
								'avg_price_5' =>2,
								'pr_money'	  =>2, // 优惠金额
								'discount'	  =>2 ,// 折扣
								'express_discount'=>2, //派送费用折扣
								'package_discount'=>2, //包装费用折扣
								'process_discount'=>2, //处理费用折扣
								'after_discount_money' => 2, // 折后金额
								'real_money'	=> 2, // 优惠后金额
								'sum_rqn'	=> 2, // 合计退货数量
								'sum_sqn'	=> 2, // 合计退货销售数量
								'sum_qn'			=> C('quantity_format')==2?2:4, // 合计数量
								'sum_quantity'		=> C('quantity_format')==2?2:4, // 合计数量
								'un_delivery_qn'		=> C('quantity_format')==2?2:4, // 合计数量
								'sum_other_quantity'		=> 3, // 合计数量
								'sum_capability'	=> 3, // 合计数量
								'sale_quantity' => 3, // 销售数量
								'sum_load_qn' => C('quantity_format')==2?2:4, // 销售数量
								'return_use_quantity' => C('quantity_format')==2?2:4, // 退货可用
								'return_unuse_quantity' => C('quantity_format')==2?2:4, // 退货不可用
								'lc_quantity' => C('quantity_format')==2?2:4, // 退货不可用
								//利润
								'befor_money'=>1,
								'in_stock_money'=>1,
								'adjust_money'=>1,
								'sale_money'=>1,
								'stock_money'=>1,
								'profit_money'=>1,
								'other_in_money'=>1,
								'other_out_money'=>1,
								'close_out_money'=>1,
								'pure_profit_money'=>1,
								//统计
								'total_need_paid'	=> 1, 
								'total_comp_need_paid'	=> 1,
								'total_on_road'		=> 1, // 在路上款项
								'total_original_money'		=> 1, 
								'total_have_paid'			=> 1, 
								'total_discount_money'		=> 1, 
								'unstock_quantity'		=>C('quantity_format')==2?2:4, 
								'load_capability'			=> 4,
								'unload_quantity'		=> C('quantity_format')==2?2:4,
								//账户汇总
								'bank_money'			=> 1,
								'banklog_money'			=> 1,
								'advance_money'			=> 1,
								'client_money'			=> 1,
								'factory_money'			=> 1,
								'logistics_money'		=> 1,
								'other_out_money'		=> 1,
								'other_in_money'		=> 1,  
								'iva'					=> 2,
								'iva_cost'				=> 1,
								'expected_delivery_costs'=>1,
								'avg_out_price'			=> 1,
								'avg_in_price'			=> 1,
								'pattern_count_number'	=> 3,
								'total_production'		=> 3,
								'return_capability'		=> 3,
								'return_quantity'		=> 3,   
								'package_spec'	=> 5,
								'cube'			=> 5,   
								'cube_long'		=> 5,   
								'cube_wide'		=> 5,   
								'cube_high'		=> 5, 
								'check_cube'	=> 5,   
								'check_long'	=> 5,   
								'check_wide'	=> 5,   
								'check_high'	=> 5, 
                                'volume_weight' => 5, 
								'per_size'=>5, 
								'per_capability'=>5, 
								'real_per_capability'=>5, 
								'real_per_szie'=>5, 
								'weight'		=> 5,
								'check_weight'	=> 5,
								'weight_begin'	=> 5,
								'weight_end'	=> 5,
								'review_weight'	=> 5,
								'review_long'	=> 5,
								'review_wide'	=> 5,
								'review_high'	=> 5,
								'review_cube'	=> 5,
								'init_price'	=> 1,
								'in_price'		=> 1,
								'return_price'	=> 1,
								'sum_instock_quantity'	=> 3,
								'diff_load_quantity'	=> 3,
								'diff_instock_quantity'	=> 3,
								'all_sale_storage'=>C('quantity_format')==2?2:4,
								'unload_sum_qn'=>C('quantity_format')==2?2:4,
								'unstock_sum_qn'=>C('quantity_format')==2?2:4,
								'storage'=>4,
								'delivery_qn'=>4,
								'step_price'=>2,
                                'max_price'=>2,
								'invoice_money'=>2,//发票金额
								'insured_amount'=>2,//保价金额
								'error_quantity'		=> 3,
								'product_count'			=> C('quantity_format')==2?2:4, // 商品ID个数
								'product_error_count'	=> C('quantity_format')==2?2:4, // 异常ID个数
								'state_sum'		=> 4,
								'state_sum_1'	=> 4,
								'state_sum_2'	=> 4,
								'state_sum_3'	=> 4,
								'state_sum_4'	=> 4,
                                'state_sum_5'	=> 4,
								'state_sum_6'	=> 4,
								'state_sum_7'	=> 4,
								'state_sum_8'	=> 4,//退货提醒退货状态列value
                                'state_sum_9'	=> 4,//退货提醒退货状态列value
                                'state_sum_10'	=> 4,
	                            //退货单新增状态提醒        add by lxt 2015.09.09
                        	    'state_sum_11'	=> 4,
                        	    'state_sum_12'	=> 4,
                        	    'state_sum_13'	=> 4,
                        	    'state_sum_14'	=> 4,
                        	    'state_sum_15'	=> 4,
                        	    'state_sum_16'	=> 4,
                        	    'state_sum_17'	=> 4,
                        	    'state_sum_18'	=> 4,
                        	    'state_sum_19'	=> 4,
                                'proof_delivery_fee'    => 1,//问题订单签收证明费用 //added by yyh 20150424
                                'compensation_fee'      => 1,//问题订单赔偿金额     //added by yyh 20150424
                                'first_quarter' => 1,   //卖家第一季度仓库费    //added by yyh 20150609
                                'second_quarter'=> 1,
                                'third_quarter' => 1,
                                'fourth_quarter'=> 1,
								'over_year'		=> 1,
                                'warehouse_percentage'          => 1,
                                'return_process_percentage'     => 1,
                                'domestic_freight_percentage'   => 1,
//                                'row_total'     => 1,//行合计 //added by yyh 20150722
//                                'amount_money'  => 1,
                                'freight'   =>1,
	                            'return_postage_fee'   =>  1,//回邮费     add by lxt 2015.09.10
                                'insure_price'  => 2,//销售单投保金额 add by yyh 20150104
								'warning_balance_rmb' => 2,//余额预警人民币
		                        'warning_balance_gbp' => 2,//余额预警英镑
								'warning_balance_euro' => 2,//余额预警欧元
								'free_stock_quantity'	=>3,
								'quarter_stock_quantity'=> 3,
								'quarter_warehouse_fee'	=> 1,//季度仓储单价
								'quarter_warehouse_account'	=> 1,//季度仓储费
								'year_stock_quantity'	=> 5,
								'year_warehouse_fee'	=> 1,//超1年仓储单价
								'year_warehouse_account'	=> 1,//超1年仓储费
								'stock_quantity'		=> 3,
								'warehouse_account_fee'	=> 1,
							),
	//格式化日期
	'FORMAT_DATE'	=> array(
								'entry_date', //入职日期
								'close_date', //平帐日期
								'leave_date', //离职日期
								'pattern_date', 	//打板日期
								'estimated_date', 	//预计完成日期
								'finish_date', 		//完成日期
								'order_date',
								'return_order_date',
								'expect_date',
								'get_date',
								'go_date',
								'message_time',
								'arrive_date',
								'real_arrive_date',	
								'delivery_date',	 // 发货日期
								'expect_arrive_date', // 预计到达日期
								'load_date',		 // 装柜日期
								'expect_shipping_date', // 预计发货日期								
								'audit_date',
								'create_time',
								'update_time',
								'paid_date',
								'bank_date', 
								'due_date', //支票兑现日期
								'adjust_date',
								'pre_delivery_date', //配货日期
								'sale_date',
								'transfer_date',
								'init_storage_date',
								'stocktake_date',
								'profitandloss_date',
								'pay_cash_paid_date',
								'pay_bill_paid_date',
								'pay_transfer_paid_date',
								'holiday_date',
								'invoice_date',
								'init_date',
								'remind_date',
								'rate_date',
								'insert_time',
								'send_time',
                                'send_date',
								'delete_time',
								'relation_date',
                                'move_date',//added by jp 20131010
                                'price_adjust_date',//added by jp 20131217
                                'price_adjust_date_format',//added by jp 20131217
								'recharge_date',//重置日期
                                'add_order_date',//问题订单建单日期 added by yyh 20150424
								'compensation_date',
	                            'returned_date',//退货完成日期   add by lxt 2015.06.08
								'account_start_date',
								'account_end_date',
								'last_request_time',//最后请求时间
								'request_time',//请求时间
								'return_time',//返回时间
							),
	//字段合计 如果有需要合计返回的数组中增加$list['total'] =array('total_sum_quantity'=>200)
	'FORMAT_SUM'	=> array(
								'remind_money'=>1,
								'sum_quantity'=>3, 
								'dozen'=>3, //入职日期 
								'real_storage'=>3, //数量 
								'sale_storage'=>3, //数量 
								'order_quantity'=>3,
								'sum_other_quantity'=>3,
                                //added by jp 20131202 st
                                'box'=>4,
                                'item'=>4,
                                'parts'=>4, 
                                'sum_box'=>4,
                                'sum_item'=>4,
                                'sum_parts'=>4,         
                                //added by jp 20131202 st        
								'quantity'=>4,		// 数量
								'in_quantity'=>4,
								'accepting_quantity'=>4, //验收数量
								'capability'=>4,		// 数量
								'other_quantity'=>4,		// 数量
								'other_capability'=>4,	
								'sum_other_quantity'=>4,		// 数量
								'sum_other_capability'=>4,		// 数量
								'money'=>1		,	// 金额
								'load_quantity'=>3, //装柜数量
								'diff_quantity'=>3, //装柜数量
								'load_quantity'=>3, //装柜数量
								'after_discount_money'=>1, // 折后金额
								'should_paid'=>1, // 应付
								'need_paid'=>1, // 需付
								'expected_delivery_costs'=>1,           //需付款        
                                'owed_money'=> 1,//
								'original_money'=>1, // 实际
								'discount_money'=>1, // 折扣
                                'account_money'=>1, //折扣
								'have_paid'=>1, // 折扣
								'use_paid'=>1, // 折扣								
								'in_money'=>1, // 折扣
								'out_money'=>1, // 折扣
								'sale_quantity'=>4, 
								'init_quantity'=>4, 
								'stock_quantity'=>4, 
								'back_quantity'=>4, 
								'profitandloss_quantity'=>4,
								'no_use_quantity'=>4, 
								'adjust_quantity'=>4, 
								'stocktake_quantity'=>4, 
								'real_quantity'=>4, 
								'sale_order_number'=>4, 
								'onroad_quantity'=>4,//在途数量 
								'reserve_quantity'=>4,//预留数量
								'picking_quantity'=>4,//拣货中数量
								'undeal_quantity'=>4,//未分配数量
								'return_use_quantity' => 4,
								'return_unuse_quantity' => 4,
								'unload_quantity'		=> 4,		
								'unstock_quantity'		=> 4,	
								//利润
								'befor_money'=>1,
								'in_stock_money'=>1,
								'adjust_money'=>1,
								'sale_money'=>1,
								'stock_money'=>1,
								'profit_money'=>1,
								'other_in_money'=>1,
								'other_out_money'=>1,
								'close_out_money'=>1,
								'pure_profit_money'=>1,
								'iva_cost'			=> 1,
								'expected_delivery_costs'=>1,
								'total_money'		=> 1,
								'all_sale_storage'		=> C('quantity_format')==2?2:4,
								'real_per_capability'		=> 5,
								'real_per_szie'		=> 5,
								'cube'				=> 5,
								'check_cube'		=> 5,
								'weight'		=> 5,
								'check_weight'	=> 5,
								'delivery_fee'=>1, 
								'process_fee'=>1, 
								'package_fee'=>1, 
								'return_fee'=>1,
                                'return_additional_fee'=>1,
								'delivery_cost'=>1,
								'other_fee_total'=>1,
								'other_fee'=>1,
								'state_sum'		=> 4,
								'state_sum_1'	=> 4,
								'state_sum_2'	=> 4,
								'state_sum_3'	=> 4,
								'state_sum_4'	=> 4,	
        						'state_sum_5'	=> 4,
								'state_sum_6'	=> 4,
								'state_sum_7'	=> 4,
								'state_sum_8'	=> 4,//退货提醒合计value
                                'state_sum_9'	=> 4,//退货提醒退货状态列value
                                'state_sum_10'	=> 4,
                                'state_sum_11'	=> 4,
								'state_sum_12'	=> 4,
								'state_sum_13'	=> 4,
								'state_sum_14'	=> 4,	
        						'state_sum_15'	=> 4,
								'state_sum_16'	=> 4,
								'state_sum_17'	=> 4,
								'state_sum_18'	=> 4,//退货提醒合计value
                                'state_sum_19'	=> 4,//退货提醒退货状态列value
								'review_weight'	=> 5,
								'review_long'	=> 5,
								'review_wide'	=> 5,
								'review_high'	=> 5,
								'review_cube'	=> 5,
                                'freight'       => 1,
							),	 					
							
	'FORMAT_CONST'	=> array(
								'state_id'      => 'SALE_ORDER_STATE',
								'detail_type'	=> 'CLIENT_TYPE',
								'comp_type'		=> 'CFG_USER_TYPE',
								'user_type'		=> 'CFG_USER_TYPE',
								//added by jp 20140117 st
								'freight_strategy' => 'CFG_FREIGHT_STRATEGY',
								'merger'		=> 'YES_NO',
                                'auth_status'	=> 'YES_NO',
								'zone_type'		=> 'CFG_ZONE_TYPE',
								'relation_type'	=> 'FUNDS_RELATED_DOC_NO',
								'relation_object'	=> 'CFG_PAY_RALATION_OBJECT',
								'check_status'	=> 'CHECK_STATUS',
                                //added bu yyh 20140905
                                'is_shipping'	=> 'IS_ENABLE',
								'is_express'	=> 'IS_ENABLE',
								'is_return_service'	=> 'IS_ENABLE',
								'status'		=> 'IS_ENABLE',
                                'calculation'	=> 'IS_ENABLE',
								'state_id'		=> 'SALE_ORDER_STATE',
								'is_registered'	=> 'IS_ENABLE',
								'is_get'		=> 'IS_GET',
                                'is_aliexpress' => 'IS_ALIEXPRESS',
								'head_way'		=> 'TRANSPORT_TYPE',
                                'transport_type'=> 'TRANSPORT_TYPE',
								'instock_type'	=> 'CFG_INSTOCK_TYPE',
								'container_type'=> 'CFG_CONTAINER_TYPE',
								//added by jp 20140117 ed
								'properties_type'	=> 'PROPERTIES_TYPE',
								'is_admin'		=> 'YES_NO',
								'sex'			=> 'SEX',
								'pay_type'		=> 'FUNDS_TYPE',
								'flow_name'		=>  'FLOW_NAME',
								'is_use'		=>  'IS_USE',
                                'is_return_sold'=>  'IS_RETURN_SOLD',
								'is_default'	=>  'IS_DEFAULT',
								'audit_state'	=>	'AUDIT_STATE',
								'detail_state'	=>	'ORDER_DETAIL_STATE',
								'order_state'	=>	'ORDER_STATE',
								'load_state'	=>	'LOAD_STATE',
//								'order_type'	=>  'SALE_ORDER_TYPE',
                                'process_discount_type'     => 'PROCESS_DISCOUNT_TYPE',//处理费用折扣类型added yyh 20150604
								'return_sale_order_type'	=> 'RETURN_SALE_ORDER_TYPE',
								'return_sale_order_state'	=> 'RETURN_SALE_ORDER_STATE',
								'sale_order_state'=> 'SALE_ORDER_STATE',
								'if_print'		=> 'IS_DEFAULT',
								'income_type'		=> 'INCOME_TYPE',
								'save_draw_type'	=>'SAVE_DRAW_TYPE',
								'paid_type'		=> 'PAID_TYPE',
								'profitandloss_type'=> 'STOCKTAKE_TYPE',
								'is_cost'		=> 'IS_COST',
								'object_type'		=> 'PAID_DETAIL_OBJECT_TYPE',
								'bill_state'		=> 'BILL_STATE',
								'relevance_cash'	=> 'RELEVANCE_CASH',
								'use_usbkey'		=> 'YES_NO',
								'to_hide'=>'IS_ENABLE',
								'paid_object_type'	=> 'PAID_DETAIL_OBJECT_TYPE',
								'role_type'			=>	'ROLE_TYPE',
								'receiver_type'     => 'RECEIVER_TYPE',//接受角色类型
								'is_read'     => 'IS_READ',
								'doc_audit'			=>  'YES_NO',
								'is_production'		=>  'IS_PRODUCTION',
								'mantissa'	=>  'MANTISSA',
								'excel_module'	=>  'IMPORT_EXCEL',
								'holiday_type'	=> 'INVOICE_HOLIDAY_TYPE',
								'invoice_type'	=> 'INVOICE_TYPE',
								'email_type'	 	 => 'EMAIL_TYPE',
								'import_state'		=> 'CFG_FILE_IMPORT_STATE',
								'billing_type'		=> 'BILLING_TYPE',
								'shipping_type'		=> 'SHIPPING_TYPE',
								'confirm_state'		=> 'CONFIRM_STATE',
								'is_related_sale_order'	=> 'WHETHER_RELATED_DEAL_NO',
								'return_reason'	=> 'RETURN_REASON',
                                'outer_pack'        => 'OUTER_PACK',
                                'within_pack'       => 'WITHIN_PACK',
                                'question_order_state'  => 'QUESTION_ORDER_STATE',
                                'question_reason'   => 'QUESTION_REASON',
                                'process_mode'      => 'PROCESS_MODE',
                                'is_warehouse_fee'      => 'YES_NO',//是否收取仓储费
                                'is_return_process_fee' => 'YES_NO',//是否收取退货处理费
                                'is_domestic_freight'   => 'YES_NO',//是否收取送回国内运费
                                'parcel_state'          => 'PARCEL_STATE',//装箱状态
	                            'refuse_reason'    =>  'REFUSE_REASON',//拒收原因      add by lxt 2015.08.28
	                            'storage_abnormal_reason'  =>  'STORAGE_ABNORMAL_REASON',//入库异常原因      add by lxt 2015.08.30
	                            'storage_abnormal'  =>  'YES_NO',//入库是否异常       add by lxt 2015.08.30
	                            'accord_type'      =>  'ACCORD_TYPE',//订单处理费计算类型       add by lxt 2015.09.01
                                'is_custom_barcode' => 'IS_CUSTOM_BARCODE',
								'is_announced'=>'IS_ANNOUNCED',//是否发布
							    'is_insure'         => 'IS_INSURE',//是否投保
							    'arrears_limit'     => 'ARREARS_LIMIT',//欠费后自动限制使用
								'enable_api'		=> 'IS_ENABLE',//派送方式是否启用api
								'express_api_request_status'	=> 'EXPRESS_API_REQUEST_STATUS',
								'express_api_request_type'		=> 'EXPRESS_API_REQUEST_TYPE',
								'confirm_status'				=> 'VAT_CONFIRM_STATUS',
	),
	//需要事物处理的action名称,即有增加相对应的模块操作时开启事物,执行完毕后关闭
	'MYSQL_OBJECT_ACTION'	=> array(
								'update', 
								'delete', 
								'insert',  
								'restore',  
								'save',   
								'deleteCtn',   
								'editCtn',   
								'finished',   
								'insertDetail',   
								'updateHandPattern',   
								'updateProductClassInfo',     
								'insertProfitandloss',     
							),
	'FORMAT_TABLE'			=>array(
								'product_no'	=> 't_left',
								'class_no'		=> 't_left',
								'dd_paid_type'	=> 't_center',
								'stocktake_date'	=> 't_center',
								'tax_no'		=> 't_left',
								'iva'			=> 't_right',
								'product_qn'	=> 't_right',
								'sum_qua'		=> 't_right',
								'sum_quantity'	=> 't_right',
								'sun_capability'=> 't_right',
								'product_name'	=> 't_left',
								'container_no'	=> 't_left',
								'dd_sale_order_state'	=> 't_center',
								'profitandloss_date'	=> 't_center',
								'mantissa'	=> 't_center',
								'remind_day'	=> 't_center',
								'dd_sex'	=> 't_center',
								'phone'	=> 't_center',
								'dd_use_usbkey'	=> 't_center',
								'dd_user_type'	=> 't_center',
								'insert_time'	=> 't_center',
								'ip'	=> 't_center',
								'epass_serial'	=> 't_center',
								'epass_key'		=> 't_center',
								'epass_data'	=> 't_center',
								'dd_pay_type'	=> 't_center',
								'error_date'	=> 't_center',
								'dd_holiday_type'=> 't_center',
								'profit_date'	=> 't_center',	
								'rate_date'		=> 't_center',	
								'opened_y'		=> 't_right',	
								'comments'			=> 't_left',
								'pay_class_name'	=> 't_left',
								'bank_name'			=> 't_left',
								'in_bank_name'		=> 't_left',
								'client_name'		=> 't_left',
								'factory_name'		=> 't_left',
								'logistics_name'	=> 't_left',
								'express_name'   	=> 't_left',
								'dml_state_sum'		=> 't_right',
								'dml_state_sum_1'	=> 't_right',
								'dml_state_sum_2'	=> 't_right',
								'dml_state_sum_3'	=> 't_right',
								'dml_state_sum_4'	=> 't_right',
        						'dml_state_sum_5'	=> 't_right',
								'dml_state_sum_6'	=> 't_right',
								'dml_state_sum_7'	=> 't_right',
								'dml_state_sum_8'	=> 't_right',
                                'dml_state_sum_9'	=> 't_right',
                                'dml_state_sum_10'	=> 't_right',
                                'dml_state_sum_11'	=> 't_right',
								'dml_state_sum_12'	=> 't_right',
								'dml_state_sum_13'	=> 't_right',
								'dml_state_sum_14'	=> 't_right',
        						'dml_state_sum_15'	=> 't_right',
								'dml_state_sum_16'	=> 't_right',
								'dml_state_sum_17'	=> 't_right',
								'dml_state_sum_18'	=> 't_right',
								'dml_state_sum_19'	=> 't_right',
								'dd_confirm_state'	=> 't_center',
								'dd_confirm_status'	=> 't_center',
	),			
);
 
?>