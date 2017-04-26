<?php
/**
 * 盈亏管理
 * @copyright   Copyright (c) 2006 - 2012 YTT 展联软件友拓通
 * @category   	盈亏管理
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-08-10
 */
class ProfitandlossPublicAction extends RelationCommonAction {
    /// 新增盈亏单
	public function add(){
		$w_id 		= intval($_GET['w_id']);
		$this->rs	= M('Stocktake')->field('stocktake_no,id')->where('warehouse_id='.$w_id.' and state=1')->select();
    	$this->assign('w_name',SOnly('warehouse', $w_id, 'w_name'));
	}
	
	/// 过账
	public function rightExtra(){
		$id	=	intval($_GET['id']);	 
		if ($id> 0) {
			$model		= D('Profitandloss');
			$this->id	= $id;
			$model->setId($id);
			$this->rs	= $model->rightExtra();
			$this->display('extra');
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}		
	}
	/// 保存后去更新明细状态
	function _after_update(){
		M('ProfitandlossDetail')->where('profitandloss_id='.intval($this->id))->setField('is_confirm',2); 
		parent::_after_update();
	}
}