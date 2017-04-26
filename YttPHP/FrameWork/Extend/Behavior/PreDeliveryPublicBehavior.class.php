<?php
/**
 * 配货
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class PreDeliveryPublicBehavior extends Behavior {
	
	public function run(&$params){  
		$params['flow_type'] = 'PreDelivery';///定义修改状态的流程来源的类型
		T('SaleOrder')->run($params,'getState');
	}
	  
	
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	public  function edit($params){  
		$id	=	$params['id'];///配货单ID
		if ($this->saleOrderState($id)==false) {
			throw_json('已发货不可操作！');
		} 
		
	}
	
	
	
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	public  function delete($params){  
		$id	=	$params['id'];///配货单ID 
		if ($this->saleOrderState($id)==false) {
			throw_json('已发货不可操作！');
		} 
	}
	
	
	/**
	 * 判断销售单状态是否已发货
	 *
	 * @param int $id 配货单ID
	 * @return bool
	 */
	public function saleOrderState($id){   
		$model			=	M('pre_delivery');
		$info			=	$model->field('sale_order_id')->where('id='.$id)->find(); 
		$sale_order_id	=	$info['sale_order_id'];
		$count 			= 	M('delivery_detail')->where('sale_order_id='.$sale_order_id.' ')->count();
		if ($count>0) {
			return false;
		} 
		return true;
	}
	
	
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	public  function insert($params){   
		$id				=	$params['id'];///配货单ID  
		$sale_order_id	=	$params['sale_order_id'];///配货单ID   
		if ($sale_order_id>0){
			///判断销售单转成配货单是否多页面打开重复提交的问题
			$error	=	$this->repeatSubmit($sale_order_id); 
			if ($error['state']==-1) {
				throw_json(join('<br>',$error['error_msg']));
			} 
		} 
		
		$error	=	$this->checkQuantity($params); 
		if ($error['state']==-1) {
			throw_json(join('<br>',$error['error_msg']));
		} 
		
	}
	
	/**
	 * 判断销售单转成配货单是否多页面打开重复提交的问题
	 *
	 * @param int $sale_order_id
	 * @return array
	 */
	public function repeatSubmit($sale_order_id){
		$errorInfo['state']	=	1;
		$model	=	M('pre_delivery');
		$info	=	$model->where('sale_order_id='.$sale_order_id)->find(); 
		
		if (is_array($info)>0){
			$errorInfo['state']	=	-1;
			$errorInfo['error_msg'][]	=	L('repeat_submit');		
		} 
		return $errorInfo; 
	}
	
	
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	public  function update($params){  
		$this->edit($params);   
		$error	=	$this->checkQuantity($params); 
		if ($error['state']==-1) {
			throw_json(join('<br>',$error['error_msg']));
		}  
	}
	
	
	/**
 	 * 检查数量是否与销售数量一致
 	 *
 	 * @param array $info 表单POST过来的数据
 	 * @return array 错误信息
 	 */
 	public function checkQuantity($info) {   
 		$errorInfo['state']	=	1;
 		$o_data = M('SaleOrderDetail') 	
 						->field('id,sum(quantity) as quantity,product_id,color_id,size_id,capability,dozen')					
 						->where('sale_order_id='.$info['sale_order_id']) 	
 						->group('product_id,color_id,size_id,capability,dozen')				
 						->formatFindAll(array('key' => 'id'));  	 			 	
 		if (!$o_data) {
 			return false;
 		}
 		///表单数据
 		foreach ($info['detail'] as $list) {
 			if ($list['product_id']<=0){ continue; }
 			$list['capability'] = isset($list['capability']) ? $list['capability'] :1;
 			$list['dozen'] 		= isset($list['dozen']) ? $list['dozen'] :1; 
 			$key = $list['product_id'].'_'.$list['capability'].'_'.$list['dozen']; 
 			(C('preDelivery.color')==1) && $key.= '_'.$list['color_id'];
 			(C('preDelivery.size')==1) && $key.= '_'.$list['size_id'];		  
 			$sum[$key]+= $list['quantity'];
 		}  	 	
 		///比较数据
		$color		= S('color');
		$size		= S('size');	 
 		foreach ($o_data as $list) {
 			$key =$list['product_id'].'_'.$list['capability'].'_'.$list['dozen'];	
 			(C('preDelivery.color')==1) && $key.= '_'.$list['color_id'];
 			(C('preDelivery.size')==1) && $key.= '_'.$list['size_id'];		 
 			if ($sum[$key] != $list['quantity'] && !in_array($key, $ids)) { 
 				$error	= L('product_no').':'.SOnly('product', $list['product_id'], 'product_no');
				(C('preDelivery.color')==1) && $list['color_id']>0 && $error.= ','.L('color_name').':'.$color[$list['color_id']]['color_name'];
				(C('preDelivery.size')==1) &&$list['size_id']>0  && $error.= ','.L('size_name').':'.$size[$list['size_id']]['size_name'];	 
 				$errorInfo['state']	=	-1;
				$errorInfo['error_msg'][]	=	$error.','.L('dif_quantity');					
 			} 			
 			$ids[] = $key;
 		} 
 		return $errorInfo;
 	}
	
	
	
}