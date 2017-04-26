<?php
/**
 * 发货
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class DeliveryPublicBehavior extends Behavior {
	
	public function run(&$params){  
		$params['flow_type'] = 'Delivery';///定义修改状态的流程来源的类型
		T('SaleOrder')->run($params,'getState');
	}
	
		/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	protected  function insert($params){   
		$_POST['query']['sale_order_id']	=	$params['sale_order_id']; 
		$model	=	D('Delivery');
		$list	=	$model->index('waitDelivery');       
		$errorInfo['state']	=	1; 
		///判断该待发货是否还在待发货列表当中~! 如果有说明未发货!可以执行发货操作
		if (count($list['list'])==0){ 
			$errorInfo['state']			=	-1;
			$errorInfo['error_msg'][]	=	L('repeat_submit');	 
			throw_json(join('<br>',$errorInfo['error_msg'])); 
		}
		
///		$errorInfo['state']	=	1; 
///		if (C('delivery.relation_predelivery')==2){///开启配货  
///			$sale_order_id	=	$params['sale_order_id'];///配货单ID  
///			if ($sale_order_id>0){
///				///判断销售单转成配货单是否多页面打开重复提交的问题 
///				$error	=	$this->repeatSubmit($sale_order_id); 
///				if ($error['state']==-1) {
///					throw_json(join('<br>',$error['error_msg']));
///				} 
///			} 
///		} 
		return $errorInfo;
	}
	
	/**
	 * 判断销售单转成配货单是否多页面打开重复提交的问题
	 *
	 * @param int $sale_order_id
	 * @return array
	 */
	public function repeatSubmit($sale_order_id){
		$errorInfo['state']	=	1;
		$model	=	M('delivery');
		$info	=	$model->where('id in ( select delivery_id from delivery_detail where sale_order_id='.$sale_order_id.' group by delivery_id ) and sale_finish=1 ')->find();
		if (is_array($info)>0){
			$errorInfo['state']	=	-1;
			$errorInfo['error_msg'][]	=	L('repeat_submit');		
		} 
		return $errorInfo; 
	}
}