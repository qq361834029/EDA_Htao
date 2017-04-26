<?php 
/**
 * 包装管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	包装信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2014/1/15 16:11:23
 */

class OrderTypePublicModel extends RelationModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'order_type';
	public $_asc 		 = true;  	        //默认排序
	public $_sortBy		 = 'id';
	/// 自动验证设置
	protected $_validate = array(
		array("order_type_name",'require',"require",1),
	);	
	
	public function getInfo($id){
        return $this->find($id);
	}
}