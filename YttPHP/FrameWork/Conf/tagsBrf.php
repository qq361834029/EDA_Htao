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
/*
业务规则检测，任何操作有效，以&链接符为逻辑执行前验证，以^链接符为逻辑执行过程验证。

一、系统自动调用；
二、严格区分大小写；
命名规则：模块名+操作名（模块名与操作名之前用&格开，操作名中不允许再出现_否则出错）
行为类：操作名将做行为类的默认调用方法，行为类目录：Extend/Behavior 行为类名与模块名一致。

*/

return array(
	'Product&insert'		=> array('ProductSku'),
	'Product&update'		=> array('ProductSku'),

	'FundsClass&edit'		=> array('FundsClass'),
	'FundsClass&delete'		=> array('FundsClass'),

    'Orders&edit' 			=> array('Orders'),
    'Orders&update' 		=> array('Orders'),
    'Orders&deleteDetail'	=> array('Orders'),
    'Orders&delete' 		=> array('Orders'),
    
    'LoadContainer&edit' 	=> array('LoadContainer','Funds'), 
    'LoadContainer&delete' 	=> array('LoadContainer'),
    'LoadContainer^insert' 	=> array('Funds'),
    'LoadContainer^update' 	=> array('LoadContainer','Funds'), 
    
	'Instock&edit' 			=> array(/*'CheckStockTake','Funds',*/'Instock'),
    'Instock&delete'		=> array(/*'CheckStockTake','CheckStorage','Funds',*/'Instock'),
    'Instock&deleteDetail'	=> array('Instock'),
	'Instock&deleteBoxDetail'	=> array('Instock'),
//    'Instock^insert' 		=> array(/*'Funds',*/'CheckStockTake'),
 	'Instock^update'		=> array(/*'CheckStockTake','CheckStorage','Funds',*/'Instock'), 
	
	'InstockImport&delete'		=> array('InstockImport', 'CheckStorage'),
	'InstockImport^insert'      => array('InstockImport'),
	'InstockAbnormal&edit'		=> array('InstockImport'), 
	
	'Picking&delete'			=> array('Picking'),
	'Picking&insert'			=> array(),
	
	//'PickingImport^insert'		=> array('CheckStorage'),//因为明细是在行为执行后才读取excel生成的，所以只能在FileListPublicModel.class.php中执行
	'PickingImport&delete'		=> array('PickingImport'),
	'PickingImport&backShelves'	=> array('PickingImport'),//重新上架验证验证是不存在未处理异常记录且未分配数量大于0 验证可销售库存（已移到重新分配后面验证 by jp 20150105）
	
	'PickingAbnormal&edit'		=> array('PickingImport'), 
	'PickingAbnormal^update'	=> array('PickingImport'),//验证实际库存
	
	'Shipping&delete'		    => array('Shipping'),
	'Shipping&deleteDetail'	    => array('Shipping'),
	//'Shipping^update'			=> array('Shipping'),
        'Cost&delete'		    => array('Cost'),
	'Cost&deleteDetail'	    => array('Cost'),

	/*
    //'SaleOrder&delete' 			=> array('CheckStockTake','SaleOrder','Funds'),
    //'SaleOrder&edit' 			    => array('CheckStockTake','SaleOrder','Funds'),
	//'SaleOrder^insert' 			=> array('CheckStockTake','SaleOrder','CheckStorage','Funds'),
    //'SaleOrder^update' 			=> array('Funds','CheckStorage','SaleOrder'), 
	*/
	//暂时不处理款项
	'SaleOrder&outStock' 		=> array('SaleOrder'),

	'SaleOrder&delete' 			=> array('SaleOrder'),
    'SaleOrder&edit' 			=> array('SaleOrder'),
	'SaleOrder^insert' 			=> array('SaleOrder','CheckStorage'),
    'SaleOrder^update' 			=> array('CheckStorage','SaleOrder', 'ExpressApi', 'Gls'),
	'SaleOrder&deleteShipmentDD'=> array('ExpressApi','Gls'),
	

    'PreDelivery&delete'			=> array('PreDelivery'),
    'PreDelivery&edit' 				=> array('PreDelivery'),
    'PreDelivery&update' 			=> array('PreDelivery'),
    'PreDelivery^insert' 			=> array('PreDelivery'),
    
    'Delivery&delete' 				=> array('CheckStockTake','Delivery','Funds'),
    'Delivery&edit' 				=> array('CheckStockTake','Delivery','Funds'),
    'Delivery^insert' 				=> array('CheckStockTake','CheckStorage','Delivery'),
    'Delivery^update' 				=> array('CheckStockTake','CheckStorage'),  
	
	
	
	'ReturnSaleOrder&delete'		=> array(/*'CheckStorage',*/'ReturnSaleOrder','CheckStorage','ReturnSaleOrderStorage'),
    'ReturnSaleOrder&edit'			=> array('ReturnSaleOrder'),
    'ReturnSaleOrder^insert'		=> array(/*'CheckStorage',*/'ReturnSaleOrder'),
    'ReturnSaleOrder^update'		=> array(/*'CheckStorage',*/'ReturnSaleOrder'),
	
    'ReturnSaleOrderStorage&delete' => array('CheckStorage','ReturnSaleOrderStorage'),
    'ReturnSaleOrderStorage&edit'	=> array('ReturnSaleOrderStorage'),
    'ReturnSaleOrderStorage&add'	=> array('ReturnSaleOrderStorage'),
    'ReturnSaleOrderStorage^update' => array('CheckStorage','ReturnSaleOrderStorage'),
    'ReturnSaleOrderStorage^insert' => array(),
    //处理            add by lxt 2015.09.07
	'ReturnSaleOrderStorage&deal'		=>  array('ReturnSaleOrderStorage'),
    'ReturnSaleOrderStorage^updateDeal' =>  array('CheckStorage','ReturnSaleOrderStorage'),
    'ReturnSaleOrderStorage&deleteDeal' =>  array('ReturnSaleOrderStorage'),
    
	'ReturnService&delete'			=> array('ReturnService'),
	'ReturnService&deleteDetail'	=> array('ReturnService'),

    /*
    'ReturnSaleOrder&delete'		=> array('CheckStockTake','CheckStorage','Funds','ReturnSaleOrder'),
    'ReturnSaleOrder&deleteDetail'	=> array('CheckStockTake','CheckStorage'),
    'ReturnSaleOrder&edit'			=> array('CheckStockTake','Funds'),
    'ReturnSaleOrder^insert'		=> array('CheckStockTake','CheckStorage','Funds'),
    'ReturnSaleOrder^update'		=> array('CheckStockTake','CheckStorage','Funds'),
    */
    //added by jp 20131216 st
    'PriceAdjust&delete'		=> array('Funds','PriceAdjust'),
    'PriceAdjust^insert'		=> array('Funds'),
    //added by jp 20131216 ed
    
 
    'Adjust&delete'					=> array(/*'CheckStockTake',*/'CheckStorage'),
    //'Adjust&edit'					=> array(/*'CheckStockTake'*/),
    'Adjust&deleteDetail'			=> array(/*'CheckStockTake',*/'CheckStorage'),
    'Adjust^insert'					=> array(/*'CheckStockTake',*/'CheckStorage'),
    'Adjust^update'					=> array(/*'CheckStockTake',*/'CheckStorage'),
	
	'InstockImportAdjust&delete'		=> array('CheckStorage'),
	'InstockImportAdjust&deleteDetail'	=> array('CheckStorage'),
    'InstockImportAdjust^insert'		=> array('CheckStorage'),
    'InstockImportAdjust^update'		=> array('CheckStorage'),
   
    'InitStorage^insert'			=> array('CheckStockTake','InitStorage'),
    'InitStorage&edit'				=> array('CheckStockTake'),
    'InitStorage^update'			=> array('CheckStockTake','InitStorage','CheckStorage'),
    'InitStorage&delete'			=> array('CheckStockTake','CheckStorage'),
    'InitStorage&deleteDetail'		=> array('CheckStockTake','CheckStorage'),
    
    'Transfer&edit'					=> array('CheckStockTake'),
    'Transfer&delete'				=> array('CheckStockTake','CheckStorage'),
    'Transfer&deleteDetail'			=> array('CheckStorage'),
    'Transfer^insert'				=> array('CheckStockTake','CheckStorage'),
    'Transfer^update'				=> array('CheckStockTake','CheckStorage'),
    
    //added by jp 20131010 st
    'MoveWare&edit'					=> array('CheckStockTake','MoveWare'),
    'MoveWare&delete'				=> array('CheckStockTake','MoveWare'),    
    'MoveWare^insert'				=> array('CheckStockTake','CheckStorage'),
    'MoveWare^update'				=> array('CheckStockTake','CheckStorage','MoveWare'),
    //added by jp 20131010 ed
    
    'ClientOtherArrearages&delete'	=> array('Funds'),
    'ClientOtherArrearages^insert'	=> array('Funds'),
    'ClientIni&delete'				=> array('Funds'),
    'ClientIni^insert'				=> array('Funds'),
    'ClientFunds&delete'			=> array('Funds'),
    'ClientFunds^insert'			=> array('Funds'),
    'ClientCheckAccount&delete'		=> array('Funds'), 
    'ClientCheckAccount^insert'		=> array('Funds'), 
    
    'FactoryOtherArrearages&delete'	=> array('Funds'),
    'FactoryOtherArrearages^insert'	=> array('Funds'),
    'FactoryIni&delete'				=> array('Funds'),
    'FactoryIni^insert'				=> array('Funds'),
    'FactoryFunds&delete'			=> array('Funds'),
    'FactoryFunds^insert'			=> array('Funds'),
    'FactoryCheckAccount&delete'	=> array('Funds'), 
    'FactoryCheckAccount^insert'	=> array('Funds'), 
    
    'LogisticsOtherArrearages&delete'=> array('Funds'),
    'LogisticsOtherArrearages^insert'=> array('Funds'),
    'LogisticsIni&delete'			=> array('Funds'),
    'LogisticsIni^insert'			=> array('Funds'),
    'LogisticsFunds&delete'			=> array('Funds'),
    'LogisticsFunds^insert'			=> array('Funds'),
    'LogisticsCheckAccount&delete'	=> array('Funds'), 
    'LogisticsCheckAccount^insert'	=> array('Funds'), 
    //盘点
    'Stocktake&delete'	=> array('Stocktake'),
    'Stocktake&edit'	=> array('Stocktake'),
    'Profitandloss&add'	=> array('Stocktake'),
    //发票
    'InvoiceIn^insert'	=> array('InvoiceIn'),
    'InvoiceIn^update'	=> array('CheckInvoiceStorage'),
    'InvoiceIn&delete'	=> array('CheckInvoiceStorage'),
    'InvoiceOut^insert' => array('InvoiceOut','CheckInvoiceStorage'),
    'InvoiceOut^update'	=> array('CheckInvoiceStorage'),
    'InvoiceOut&delete'	=> array('CheckInvoiceStorage'),
    'InvoiceInitStorage^update'	=> array('CheckInvoiceStorage'),
    'InvoiceInitStorage&delete'	=> array('CheckInvoiceStorage'),
    //盈亏
    'Profitandloss&rightExtra'	=> array('Profitandloss'),
    'Profitandloss&delete'		=> array('Profitandloss'),
    
    // 角色
    'Role&edit'	=> array('Role'),
    'Role&delete'	=> array('Role'),
    'Epass&edit'	=> array('Epass'),
    'Epass&update'	=> array('Epass'),
    'Epass&delete'	=> array('Epass'),
	
	'Recharge&delete'			=> array('Recharge'),//删除充值
	'Recharge&confirm'			=> array('Recharge'),//确认或取消确认充值
	'Recharge&editConfirm'	    => array('Recharge'),//编辑操作确认充值
    'ClientRecharge&delete'		=> array('Funds'),//取消确认充值
    'ClientRecharge^insert'		=> array('Funds'),//确认充值
    
    'InstockStorage&delete'         => array('CheckStorage'),
    'InstockStorage&deleteDetail'   => array('CheckStorage'),
    'InstockStorage&add'            => array('InstockStorage'),
    'InstockStorage^insert'         => array('InstockStorage','CheckStorage'),
    'InstockStorage^update'         => array('InstockStorage','CheckStorage'),
    
    'TrackOrder&delete'             => array('TrackOrder'),
    
    'Warehouse^update'              => array('Warehouse'),
    'Warehouse&delete'              => array('Warehouse'),
    
    'DomesticWaybill&delete'					=> array('CheckStorage'),
    'DomesticWaybill&deleteDetail'              => array('CheckStorage'),
    'DomesticWaybill^insert'					=> array('CheckStorage'),
    'DomesticWaybill^update'					=> array('CheckStorage'),
    
    'Factory^insert'                => array('Factory'),
    'Factory^update'                => array('Factory'),
    'Factory^updateSetting'         => array('Factory'),
    
    'ShiftWarehouse&delete'         => array('CheckStorage'),
    'ShiftWarehouse&deleteDetail'   => array('CheckStorage'),
    'ShiftWarehouse^insert'         => array('CheckStorage'),
    'ShiftWarehouse^update'         => array('CheckStorage'),
    
//    'WarehouseAccount&delete'       => array('WarehouseAccount'),
//    'WarehouseAccount^insert'       => array('WarehouseAccount'),
    
    'WarehouseFee^insert'           => array('WarehouseFee'),
    'WarehouseFee^update'           => array('WarehouseFee'),
	'WarehouseFee&delete'           => array('WarehouseFee'),

    //退回国内装箱
//    'PackBox^insert'                => array('PackBox','CheckStorage'),
//    'PackBox^update'                => array('CheckStorage','PackBox'),
//    'PackBox&delete'                => array('PackBox'),
    'PackBox^insert'                => array('PackBox'),
    'PackBox^update'                => array('PackBox'),
	'PackBox&edit'					=> array('PackBox'),
    'PackBox&delete'                => array('PackBox'),
	'PackBox&deleteDetail'          => array('PackBox'),
    
    'OutBatch&add'					 => array('OutBatch'),
    'OutBatch&edit'                  => array('OutBatch'),
	'OutBatch&deleteDetail'          => array('OutBatch'),
    'OutBatch&delete'                => array('OutBatch'),
    'OutBatch^insert'                => array('OutBatch','CheckStorage'),
    'OutBatch^update'                => array('OutBatch','CheckStorage'),

    'OrderType&delete'               => array('OrderType'),
);