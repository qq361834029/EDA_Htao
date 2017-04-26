<?php 
/**
 * 产品管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	yyh
 * @version 	2014-09-11
 */

class SkuKeywordsPublicModel extends Model {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'sku_keywords';
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("product_no",'require','require',1),
			array("product_no",'','unique',1,'unique'),
		);
    protected $_auto = array(
                            array("product_no", "trim", 3, "function"), // 模块					
                        );    
}