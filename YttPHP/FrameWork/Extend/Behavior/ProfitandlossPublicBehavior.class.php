<?php
/**
 * 盈亏行为处理类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    盈亏行为处理类
 * @package   	Behavior
 * @author     	何剑波
 * @version  	2.1
 */
class ProfitandlossPublicBehavior extends Behavior {
	
	public function run(&$params){ 
		if(ACTION_NAME!='update'){
			T('Stocktake')->run($params,'getState');
		}
	}
	
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	protected function delete($params){  
		$id	=	$params['id'];///配货单ID
		if ($this->profitandlossState($id)==false) {
			throw_json(L('delete_proloss_error'));
		} 
	}
	
	
	/**
	 * 修改前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	protected function rightExtra($params){  
		$id	=	$params['id'];///配货单ID
		if ($this->profitandlossState($id)==false) {
			throw_json(L('add_proloss_money_error'));
		} 
	}
	
	/**
	 * 判断盈亏单是否过账
	 *
	 * @param int $id 盘点单id
	 * @return bool
	 */
	public function profitandlossState($id){  
		$model	=	M('Profitandloss');
		$info	=	$model->field('state')->find($id);
		if ($info['state']>1) {
			return false;
		} 
		return true;
	}
}