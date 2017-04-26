<?php 
/**
 * 其他收入
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class OtherRevenuePublicModel extends OtherFundsPublicModel { 
	
	///列表查询的表的合计distinct对应的值
	public $indexCountPk	= 'id';  
	/// 模型名与数据表名不一致，需要指定
	public $tableName 		= 	'paid_detail';
	///款项类型
	public $object_type		=	801;///客户其他应收款
	///对象类型
	public $comp_type		=	0; 
	
}