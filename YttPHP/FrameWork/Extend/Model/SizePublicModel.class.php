<?php 
/**
 * 尺寸
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class SizePublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'size';
	/// 自动验证设置
	protected $_validate	 =	 array(
				array("size_no",'require',"require",1),
				array("size_no",'',"unique",1,'unique'),///验证唯一 
				array("size_no",'is_no',"valid_error",1), 
				array("size_no",'validbarcode','',1,'callbacks'), 	   
				array("size_name",'require',"require",1),
				array("size_name",'',"unique",1,'unique'),///验证唯一  
			);  
}