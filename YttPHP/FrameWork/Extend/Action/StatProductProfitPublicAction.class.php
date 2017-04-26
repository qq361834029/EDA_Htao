<?php
/**
 * 按产品利润
 * @copyright   Copyright (c) 2006 - 2012 YTT 展联软件友拓通
 * @category    按产品利润
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-08-10
 */
class StatProductProfitPublicAction extends RelationCommonAction {
	/// 列表
	public function index(){ 
		$model	= D('StatProductProfit');
		$list	= $model->index();
		$this->assign('list',$list);
		$this->displayIndex('index');
	}
}