<?php

/**
 * 自定义销售查询
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatSaleRatePublicAction extends Action {
	
	public function index(){
		$list	= D('StatSaleRate')->getSaleRate();
		$this->assign('list',$list);
		$this->assign('page',$list['page']);
		if($_POST['search_form']){
			$this->display('list');
		}else{
			$this->display();
		}
	}
}