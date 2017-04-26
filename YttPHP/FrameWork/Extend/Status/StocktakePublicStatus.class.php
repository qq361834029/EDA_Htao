<?php
/**
 * 盘点状态类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    盘点状态类
 * @package   	Status
 * @author     	何剑波
 * @version  	2.1
 */
class StocktakePublicStatus extends Status {
		 
	/**
	 * 生成盈亏单后更新盘点单状态
	 *
	 * @param unknown_type $params
	 */
	protected function getState($params){ 
		 if(intval($params['id'])>0){
		 	$this->setStateWithStocktake($params);
		 }
	}
	
	/**
	 * 修改盘点单状态
	 *
	 * @param unknown_type $
	 * @param unknown_type $state
	 */
	public function setStateWithStocktake($params){
		if(ACTION_NAME=='delete'){
			if(intval($params['id'])>0){
				$row 	= M('ProfitandlossDel')->field('stocktake_ids')->find($params['id']);
				$row['stocktake_ids'] && M('Stocktake')->where('id in('.$row['stocktake_ids'].')')->setField('state',1);
			}
		}else{
			if(intval($params['warehouse_id'])>0){
				$model = M('Stocktake'); 
				$data = array('state'=>2); 
				$model->where('warehouse_id='.$params['warehouse_id'].' and state=1')->setField($data);   
			}
		}
	}
}