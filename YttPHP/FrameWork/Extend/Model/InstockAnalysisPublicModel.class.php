<?php

/**
 * 进货价格分析
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	公共操作
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class InstockAnalysisPublicModel extends RelationCommonModel{

	// 定义真实表名
	protected $tableName = 'instock';
	// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'instock_id',
										'class_name'	=> 'InstockDetail',
									)
								);	
}
?>