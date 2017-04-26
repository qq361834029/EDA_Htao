<?php
/**
 * 总利润
 * @copyright   Copyright (c) 2006 - 2012 YTT 展联软件友拓通
 * @category    总利润
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-08-10
 */
class StatProfitPublicAction extends RelationCommonAction {
	/// 列表
	public function index(){ 
		if($_GET['search_form']==1){
			$model	= D('StatProfit');
			$list	= $model->index();
			$this->assign('list',$list);
			$this->displayIndex();
		}else{
			$this->displayIndex('index');
		}
	}
}