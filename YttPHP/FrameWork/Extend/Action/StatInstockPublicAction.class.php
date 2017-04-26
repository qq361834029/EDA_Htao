<?php
/**
 * 入库查询统计列表
 * @copyright   Copyright (c) 2006 - 2012 YTT 展联软件友拓通
 * @category   	入库查询统计列表
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-09-13
 */
class StatInstockPublicAction extends RelationCommonAction {
 	/// 计算总合计
	public function _before_index(){
		$total	= D('StatInstock')->getListTotal();
		$this->assign('total',$total);
	}
}