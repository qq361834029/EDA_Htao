<?php

/**
 * 信息公布栏
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category    信息类型列表
 * @package		Model
 * @author		lml
 * @version    2016-01-12
 */

class MessageCategoryPublicModel extends CommonModel {
   /// 定义真实表名
	protected $tableName = 'message_category';
	/// 定义索引字段
	public $id;
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("category_no",'require',"require",1), //仓库编号
			array("category_no",'repeat',"repeat",1,'unique'),//验证唯一
			array("category_name",'require',"require",1), //仓库名称
			array("category_name",'repeat',"repeat",1,'unique'), //仓库名称
		);
	 
}