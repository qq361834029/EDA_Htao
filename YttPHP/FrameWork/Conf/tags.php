<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: tags.php 2726 2012-02-11 13:34:24Z liu21st $

// 系统默认的核心行为扩展列表文件
return array(
    /* 
    关联行为操作，
    一、relationModel 中 insert update delete 方法自动调用标签名称同模块名的行为（标签严格区分大小写）
    二、行为名称严格区分大小写且与行为类名一致 
   */
    'Product' => array(
		'Product',
    ),
    'rateinfo' => array( 
    	'RateInfo', 
    ),
    'Orders' => array(
    	'Orders',
    	'EmailList',//邮件
    ),
    // 装柜
    'LoadContainer' => array( 
    	'LoadContainer',  
    	'Storage',  
    	'FactoryOnRoad',  
    	'EmailList',//邮件
    ),
    
    //入库
    'Instock'	=> array(
    	'Instock',
//    	'Storage',
//    	'FactoryInstock',
//    	'FactoryOnRoad',
//    	'LogisticsInstock',
//    	'PriceInstock',
//    	'FiFo',	// 先进先出
    	'EmailList',//邮件
    ),
	
	
	//入库单导入
	'InstockImport'	=> array(
		'InstockImport',
		'Storage',
		'FiFo',
	),	
	
	//入库单导入异常处理
	'InstockAbnormal'	=> array(
		'InstockImport',
		'Storage',
		'FiFo',
	),	
	
    
    //拣货导出
    'Picking'	=> array(
        'FiFo',
    	'Picking',
		'Storage',//更新picking_quantity
    ),	
	
	//拣货导入
	'PickingImport'	=> array(
		'PickingImport',
		'Storage',
		'FiFo',//先先进先出再扣减库存
	),	
	
	//拣货导入异常处理
	'PickingAbnormal'	=> array(
		'PickingImport',
//		'FiFo',//先先进先出再扣减库存
		'Storage',
	),		
	
	'SaleOrder' => array( 
        'SaleOrder',  
		'Storage',
		'ClientSale',  //销售单款项
		'ExpressApi',
		'Gls',
//		'EmailList',//邮件
    ),
    'PreDelivery' => array( 
    	'PreDelivery',    
    	 
    ),
    
    'Delivery' => array( 
    	'Delivery',   //销售单状态
    	'DealDiff',   //销售差异 
    	'Storage',
    	'ClientDelivery',   //销售单款项
//    	'FiFo',	// 先进先出
    	'EmailList',//邮件
    ),
	'ReturnSaleOrder'=>array(   
    	'ReturnSaleOrder', 
        'ReturnSaleOrderStorage',
		'ClientReturnSaleStorage',
		'CaiNiaoApi',//菜鸟api added by jp 20150910
    ),
    'ReturnSaleOrderStorage'=>array(//退货入库 
        'ReturnSaleOrderStorage',
        'ClientReturnSaleStorage',//调换顺序       edit by lxt 2015.09.09
        'Storage',
        'FiFo',	// 先进先出
		'CaiNiaoApi',//菜鸟api added by jp 20150910
    ),
    'PriceAdjust'=>array(//added by jp 20131217
    	'ClientPriceAdjust',  //调价单
    	'PriceAdjust', 
    ),
    
    'Adjust' => array( 
    	'Storage',
    	'FiFo',	// 先进先出
    ),
	//入库导入调整
	'InstockImportAdjust' => array(
		'Storage',
		'FiFo',	// 先进先出
    ),
    
    'Transfer' => array( 
    	'Storage',
//    	'FiFo',	// 先进先出
    ),
    
    'MoveWare' => array(//added by jp 20131010 
    	'Storage',
//    	'FiFo',	// 先进先出
    ),    
    
    'InitStorage' => array( 
    	'Storage',
//    	'FiFo',	// 先进先出
    ),
    //盈亏管理
    'Profitandloss'	=> array(
    	'Profitandloss',
    	'Storage',
    	'FiFo',	// 先进先出
    ),
    
    'InvoiceIn'	  => array(
    	'InvoiceNo',
    	'InvoiceIn',
    ),
    
    'InvoiceOut' => array(
    	'InvoiceNo',
    	'InvoiceOut',
    ),
	
	'Recharge' => array( 
        'Recharge',  
    ),	
    'DeclaredValue' => array(//批量更新产品申报价值
        'ProductDeclaredValue'
    ),
    'InstockStorage' => array(
        'InstockStorage',
        'Storage',
        'FiFo',	// 先进先出
		'EmailList',//邮件
    ),
    
    'QuestionOrder' => array(//问题订单  added by yyh 20150425
        'QuestionOrder',
        'ClientQuestionOrder',
    ),
        
    'DomesticWaybill' => array( //国内运单
    	'Storage',
    	'FiFo',	// 先进先出
    ),
    
    'ShiftWarehouse' => array( //移仓 added by yyh 20150629
    	'Storage',
    	'FiFo',	// 先进先出
    ),
    
    'WarehouseAccount'=> array(//仓储费对账 added by yyh 20150805
        'ClientWarehouseAccount',
    ),    
    
    'PackBox'   =>array(//退回国内装箱 added by yyh 20150829
        'PackBox',
		'CaiNiaoApi',//菜鸟api added by jp 20151021
    ),
    
    'OutBatch'  =>array(//出库批次 added by yyh 20150901
        'OutBatch',
        'ClientReturnSaleStorage',
        'ClientOutBatch',//运费added by 20151207
        'Storage',//added by yyh 20150921
		'FiFo',	// 先进先出
		'CaiNiaoApi',//菜鸟api added by jp 20150910
        'EmailList',//邮件
    ),
    
    /* 
    框架运行必须加载的行为控件，请不要修改
    */
    'app_init'=>array(
    ),
    'app_begin'=>array(
        'CheckLang', // 检测语言包
        'ReadHtmlCache', // 读取静态缓存
    ),
    'route_check'=>array(
        'CheckRoute', // 路由检测
    ), 
    'app_end'=>array(),
    'path_info'=>array(),
    'action_begin'=>array(),
    'action_end'=>array('Log'),
    'view_begin'=>array(),
    'view_template'=>array(
        'LocationTemplate', // 自动定位模板文件
    ),
    'view_parse'=>array(
        'ParseTemplate', // 模板解析 支持PHP、内置模板引擎和第三方模板引擎
    ),
    'view_filter'=>array(
        'ContentReplace', // 模板输出替换
        'TokenBuild',   // 表单令牌
        'WriteHtmlCache', // 写入静态缓存
        'ShowRuntime', // 运行时间显示
    ),
    'view_end'=>array(
        'ShowPageTrace', // 页面Trace显示
    ),

);