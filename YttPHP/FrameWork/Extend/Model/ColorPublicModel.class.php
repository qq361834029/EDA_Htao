<?php 
/**
 * 颜色信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class ColorPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'color';
	/// 自动验证设置
	protected $_validate	 =	 array(
				array("color_no",'require',"require",1),
				array("color_no",'',"unique",1,'unique'),///验证唯一 
				array("color_no",'is_no',"valid_error",1),   
				array("color_no",'validbarcode','',1,'callbacks'), 	 
				array("color_name",'require',"require",1),
				array("color_name",'',"unique",1,'unique'),///验证唯一  
			); 
			
}