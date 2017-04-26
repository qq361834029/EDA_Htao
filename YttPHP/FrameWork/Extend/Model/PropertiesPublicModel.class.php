<?php  
/**
 * 产品属性
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class PropertiesPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'properties';
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("properties_no",'require','require',1),
			array("properties_no",'is_no',"valid_error",1),  	
			array("properties_no",'','unique',1,'unique'),
			array("properties_name",'require','require',1),
			array("properties_name",'','unique',1,'unique'),
			array("properties_name_de",'require','require',1),
			array("properties_name_de",'','unique',1,'unique'),
			array("properties_type",'require','require',0),
		);  
		
	
}