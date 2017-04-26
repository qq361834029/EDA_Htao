<?php

/**
 * 客户久未交易分析
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatClientDealPublicAction extends CommonAction {
	
	public function index(){
		if($_REQUEST['search_form']){
			$_REQUEST &&  $source = D('StatSale')->getClientUndealDays();
			$_REQUEST &&  $this->assign('list',$source);	
			$this->assign ("page", $source['page'] );// 分页条	
			$this->display('list');
		}else{	
			$this->display();
		}
	}
}