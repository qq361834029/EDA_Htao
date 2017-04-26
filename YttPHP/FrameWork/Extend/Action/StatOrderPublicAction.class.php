<?php 
/**
 * 进货进度管理表
 * @copyright   Copyright (c) 2006 - 2012 YTT 展联软件友拓通
 * @category    进货进度管理表
 * @package   Action
 * @author     何剑波
 * @version  2.1
 */
class StatOrderPublicAction extends RelationCommonAction {
	
	/// 进货进度管理
	public function index(){
		addLang('orders,loadcontainer');
		$this->list	= D('StatOrder')->orderProcess();
		$this->displayIndex();
	}
}
?>