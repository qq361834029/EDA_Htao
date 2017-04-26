<?php 
/**
 * 厂家收款
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FactoryFundsPublicModel extends ObjectFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 			= 'paid_detail';
	///表查询
	public $comp_paid_detail 		= 'factory_paid_detail'; 
	///合计数量的count对应的字段id
	public $indexCountPk 			= 'id'; 
	///款项类型
	public $object_type				=	203;///厂家不指定收款2
	///厂家平账款项类型
	public $object_type_close_out	=	204;
	///对象类型
	public $comp_type				=	3;	 
	///
	public $sale_object_type		=	220;
	 
}