<?php
class PriceInstockPublicBehavior extends Behavior {
	public function run(&$params){
		///如果是删除则需要取之前的明细
		if (ACTION_NAME=='delete'){
			$detail					=	M('instock_detail_del');
			$params['detail']		=	$detail->field('product_id,price,currency_id')->where('instock_id='.$params['id'])->select();
			unset($detail);
		}
		foreach ((array)$params['detail'] as $k=>$v){
			if($v['product_id']){
				$p_ids[] = $v['product_id'];
			}
		}
		$last_price	= $this->getLastPrice($p_ids,$params);
		$avg_price	= $this->getAvgPrice($p_ids);
		foreach ((array)$params['detail'] as $k=>$v){
			if($v['product_id']){
				$info['last_price_'.$v['currency_id']]	= floatval($last_price[$v['product_id'].'_'.$v['currency_id']]);
				$info['avg_price_'.$v['currency_id']]	= floatval($avg_price[$v['product_id'].'_'.$v['currency_id']]);
				M('ProductPrice')->where('product_id='.intval($v['product_id']))->save($info);
			}
		}
	}
	
	
	/**
	 * 计算产品的最后一次入库价格
	 *
	 */
	protected  function getLastPrice($p_ids,$params) {
		if (ACTION_NAME=='delete'){
			$model	= M('Instock');
			$sql	= '
				SELECT max(id) as ids
				FROM instock_detail
				WHERE product_id in ('.implode(',',$p_ids).')
				GROUP BY product_id, currency_id
			';
			$ids	= $model->query($sql);
			foreach ($ids as $k=>$v){
				$ids_array[] = $v['ids'];
			}
			$sql	= '
				SELECT instock_detail.price, product_id,instock_id,currency_id
				FROM instock_detail
				WHERE id in ('.implode(',',$ids_array).')
			';
			$list	= $model->query($sql);
		}else{
			$list	= $params['detail'];
		}
		
		foreach ((array)$list as $k=>$v){
			$info[$v['product_id'].'_'.$v['currency_id']]	= $v['price']; 
		}
		return $info;
	}
	/**
	 * 计算产品的平均入库价格
	 *
	 */
	protected  function getAvgPrice($p_ids) {
		$model	= M('Instock');
		$sql	= '
			select sum(quantity*capability*dozen*price)/sum(quantity*capability*dozen)  as price,product_id,currency_id
			from instock_detail where product_id in ('.implode(',',$p_ids).') group by product_id,currency_id
		';
		$list	= $model->query($sql);
		foreach ((array)$list as $k=>$v){
			$info[$v['product_id'].'_'.$v['currency_id']]	= $v['price']; 
		}
		return $info;
	}
}


