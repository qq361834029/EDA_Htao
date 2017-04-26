<?php 
/**
 * 产品外部SKU信息管理
 * @copyright   Copyright (c) 2006 - 2014 TOP UNION 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2014-09-28
 */
class ProductSkuPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'product_sku';
	/// 自动验证设置
	protected $_validate	 =	 array(
				array("sku",'require',"require",1),
				array("sku",'',"unique",1,'unique'),///验证唯一 
				array("factory_id",'require',"require",1),
				array("product_id ",'require',"require",1),
			);
}