<?php 
/**
 * 产品类别对应的product_class_info中的管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class BracodePublicBehavior extends Behavior {
	
	///行为扩展的执行入口必须是run
    public function run(&$params){
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
    	///判断是否开启生成条形码
    	if ($params['id']>0 && C('barcode')==1){ 
    		$product_id	=	intval($params['id']);
    		$product	=	D('Barcode'); 
    		switch ($_action){
    			case 'insert':
    				$Pinfo		=	$product->addBarcode($product_id); 
    				break;
    			case 'update':
    				$Pinfo		=	$product->updateBarcode($product_id); 
    				break;
    			case 'delete':
    				$Pinfo		=	$product->deleteBarcode($product_id); 
    				break; 
    		}
    		
    	} 
    } 
}