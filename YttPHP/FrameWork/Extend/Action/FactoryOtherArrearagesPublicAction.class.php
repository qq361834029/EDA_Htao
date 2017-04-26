<?php 
/**
 * 厂家其他款项
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FactoryOtherArrearagesPublicAction extends FundsCommonAction {
	///款项对象类型
 	public $comp_type	=	3;   
 	public function setPost($info) {
		if ($info['billing_type'] == C('BILLING_TYPE_TOTAL')) {//计费方式为合计时
			$info['quantity']	= 1;
			$info['price']		= $info['owed_money'];
		}	
		return parent::setPost($info);
	} 
}