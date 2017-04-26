<?php
/**
 * 盘点行为处理类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    盘点行为处理类
 * @package   	Behavior
 * @author     	何剑波
 * @version  	2.1
 */
class StocktakePublicBehavior extends Behavior {
	
	public function run(&$params){  
		T('Stocktake')->run($params,'getState');
	}
	
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	protected function delete($params){  
		$id	=	$params['id'];///配货单ID
		if ($this->stocktakeState($id)==false) {
			throw_json(L('delete_stocktake_error'));
		} 
	}
	
	
	/**
	 * 修改前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	protected function edit($params){  
		$id	=	$params['id'];///配货单ID
		if ($this->stocktakeState($id)==false) {
			throw_json(L('edit_stocktake_error'));
		} 
	}
	
	/**
	 * 判断盘点单状态是否已做盈亏单
	 *
	 * @param int $id 盘点单id
	 * @return bool
	 */
	public function stocktakeState($id){  
		$model	=	M('Stocktake');
		$info	=	$model->field('state')->find($id);
		if ($info['state']>1) {
			
			return false;
		} 
		return true;
	}
	
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	protected  function add($params){  
		$id	=	$params['id'];///配货单ID
		if ($this->stocktakeState($id)==false) {
			throw_json(L('add_proloss_error'));
		} 
	}
	
}