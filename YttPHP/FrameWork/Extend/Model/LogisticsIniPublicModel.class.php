<?php 
/**
 * 物流期初款项
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class LogisticsIniPublicModel extends FundsIniPublicModel {
	/// 模型名与数据表名不一致，需要指定
	public $tableName 		= 	'paid_detail';
	///款项类型
	public $object_type		=	301;///物流其他应收款
	///对象类型
	public $comp_type		=	3;
	///表查询
	public $indexTableName	=	'logistics_paid_detail'; ///列表查询的表的名字
	  
	
}