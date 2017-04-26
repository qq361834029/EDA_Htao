<?php 
/**
 * 物流其他款项
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class WarehouseOtherArrearagesPublicAction extends FundsCommonAction {
	  ///款项对象类型
 	public $comp_type	=	4;
    public function __construct() {
        parent::__construct();
        if(!empty($_POST['comp_id'])){
           $_POST['warehouse_id']   = $_POST['comp_id'];
        }
        if(empty($_POST['comp_name'])){
           $_POST['comp_name']      = SOnly('warehouse',$_POST['comp_id'],'w_name');
        }
    }

     public function setPost($info) {
		if ($info['billing_type'] == C('BILLING_TYPE_TOTAL')) {//计费方式为合计时
			$info['quantity']	= 1;
			$info['price']		= $info['owed_money'];
		}	
		return parent::setPost($info);
	} 
}