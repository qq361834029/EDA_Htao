<?php

/**
 * 库存调整
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	库存调整
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class WarehouseFeePublicAction extends RelationCommonAction {

	public $_cacheDd		= array(30);  ///需要更新的缓存字典

	public function __construct() {
    	parent::__construct();
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {//卖家
			$this->assign("is_factory", true);
		}
	}
    public function add() {
        parent::add();
        $rs['detail']	= M('warehouse')->where('to_hide=1 and is_use=1')->field('id as warehouse_id,w_name,currency_id')->select();
		$currency		= S('currency');
		foreach ($rs['detail'] as $k=>$v){
			$rs['detail'][$k]['w_name']	.= str_replace(array('欧元'), array($currency[$v['currency_id']]['currency_name']) ,L('EUR_CMB_day'));
		}
		$rs['detail']	= array_merge(array('0'=>''),$rs['detail']);
		unset($rs['detail'][0]);
        $this->assign('rs',$rs);
    }
	public function _after_insert() {
		$this->checkCacheDd($this->id);
		parent::_after_insert();
	}
	public function _after_update() {
		$this->checkCacheDd($this->id);
		parent::_after_update();
	}
	public function _after_delete() {
		$this->checkCacheDd();
		parent::_after_delete();
	}
}
?>