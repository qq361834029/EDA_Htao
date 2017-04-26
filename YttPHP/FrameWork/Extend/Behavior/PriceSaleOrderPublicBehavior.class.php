<?php
class PriceSaleOrderPublicBehavior extends Behavior {
	public function run(&$params){
		///如果是删除则需要取之前的明细
		if (ACTION_NAME=='delete'){
			$detail					= M('sale_order_detail_del');
			$params['detail']		= $detail->field('product_id,price')->where('sale_order_id='.$params['id'])->select();
			unset($detail);
			$sale_order				= M('sale_order_del');
			$currency_id			= $sale_order->field('currency_id')->where('id='.$params['id'])->find();
			$params['currency_id']	= $currency_id['currency_id'];
			unset($sale_order);
		}
		foreach ((array)$params['detail'] as $k=>$v){
			if($v['product_id']){
				$p_ids[] = $v['product_id'];
			}
		}
		$last_price	= $this->getLastPrice($p_ids,$params);
		$avg_price	= $this->getAvgPrice($p_ids);
		/*
		pr($last_price,'$last_price');
		pr($avg_price,'$avg_price');
		pr($params,'$params');
		*/
		foreach ((array)$params['detail'] as $k=>$v){
			if($v['product_id']){
				$info['sale_last_price_'.$params['currency_id']]	= floatval($last_price[$v['product_id'].'_'.$params['currency_id']]);
				$info['sale_avg_price_'.$params['currency_id']]		= floatval($avg_price[$v['product_id'].'_'.$params['currency_id']]);
				//pr($info,'$info');
				M('ProductPrice')->where('product_id='.intval($v['product_id']))->save($info);
			}
		}
	}

	/**
	 * 计算产品的最后一次销售价格
	 *
	 */
	protected  function getLastPrice($p_ids,$params) {
		if (ACTION_NAME=='delete'){
			$model	= M('SaleOrder');
			$sql	= 'SELECT max(detail.id) as ids
					FROM sale_order_detail as detail inner join sale_order as sale on detail.sale_order_id=sale.id
					WHERE detail.product_id in ('.implode(',',$p_ids).') and sale.currency_id='.$params['currency_id'].'
					GROUP BY detail.product_id';
			$ids	= $model->query($sql);
			foreach ($ids as $k=>$v){
				$ids_array[] = $v['ids'];
			}
			if(count($ids_array)>0){
				$sql	= 'SELECT price,product_id FROM sale_order_detail WHERE id in ('.implode(',',$ids_array).')';
				$list			= $model->query($sql);
			}
		}else{
			$list			= $params['detail'];
		}
		foreach ((array)$list as $k=>$v){
			if($v['product_id']){
				$info[$v['product_id'].'_'.$params['currency_id']]	= $v['price'];
			}
		}
		return $info;
	}
	
	/**
	 * 计算产品的平均销售价格
	 *
	 */
	protected  function getAvgPrice($p_ids) {
		$sql	= 'select sum(detail.quantity*detail.capability*detail.dozen*detail.price)/sum(detail.quantity*detail.capability*detail.dozen) as price,detail.product_id,sale.currency_id
			from sale_order_detail as detail inner join sale_order  as sale on detail.sale_order_id=sale.id
			where detail.product_id in ('.implode(',',$p_ids).') group by detail.product_id,sale.currency_id
		';
		$list	= M('ProductPrice')->query($sql);
		foreach ((array)$list as $k=>$v){
			$info[$v['product_id'].'_'.$v['currency_id']]	= $v['price']; 
		}
		return $info;
	}
}


