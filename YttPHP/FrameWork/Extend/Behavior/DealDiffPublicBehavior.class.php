<?php 
/**
 * 销售差异
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class DealDiffPublicBehavior extends Behavior {
	
	public function run(&$params){   
		///记录销售单与发货单的差异
		$sale_order_id	=	$params['detail'][1]['sale_order_id'];
		if ($sale_order_id<=0){
			$model			=	M('delivery_detail');
			$detail			=	$model->where('delivery_id='.$params['id'])->find();
			$sale_order_id	=	$detail['sale_order_id'];
		} 
		if ($sale_order_id>0){  
			$this->dealDiff($sale_order_id); 
		}
		
	}
	
	
	/// 处理发货差异
	protected  function dealDiff($sale_order_id) {
		/// 是否有发货信息
		$model	=	M('delivery_detail');
		$rs		=	$model->where('sale_order_id='.$sale_order_id)->find();   
		if (empty($rs)) { /// 无发货信息
			$sql = "delete from  sale_delivery_diff where sale_order_id=".$sale_order_id;
			$model->execute($sql);
			return ;
		}
		$sql = "SELECT SUM( quantity ) AS quantity 
				FROM (
					SELECT SUM( quantity* capability*dozen ) AS quantity, sale_order_id
					FROM (
						SELECT sale_order_id, product_id, color_id, size_id, quantity, capability, dozen
						FROM  `sale_order_detail` 
						WHERE  `sale_order_id` =".$sale_order_id."
						UNION ALL 
						SELECT sale_order_id, product_id, color_id, size_id , - quantity, capability, dozen
						FROM  `delivery_detail` 
						WHERE  `sale_order_id` =".$sale_order_id."
					)a 	GROUP BY product_id, color_id, size_id, capability, dozen
				)b	GROUP BY sale_order_id";
		$rs  = $model->query($sql);	 	
		/// 先删除差异表中的记录
		$sql = "delete from  sale_delivery_diff where sale_order_id=".$sale_order_id;
		$model->execute($sql); 
		if (floatval($rs[0]['quantity'])!=0) {			
			$sql = "insert into sale_delivery_diff(sale_order_id) values (".$sale_order_id.")";
			$rs  = $model->execute($sql);
		}		
	}
	
	
	
	
}