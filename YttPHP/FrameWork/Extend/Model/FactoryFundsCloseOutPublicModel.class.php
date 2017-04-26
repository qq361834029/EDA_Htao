<?php 
/**
 * 厂家付款平账操作
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FactoryFundsCloseOutPublicModel extends AbsFundsPublicModel {
	///款项类型
	public $object_type			=	204;///厂家销售单预付款
	///对象类型
	public $comp_type			=	2;  
	///厂家款项表
	public $tablePaidDetail		=	'FactoryPaidDetail';
   
	/**
	 * 平帐
	 *
	 * @param array $info
	 * @return array $vo
	 */
	public function _fund($info){  
		///平账   
		return $this->_closeOutFunds($info); 
	}
	 
}
?>