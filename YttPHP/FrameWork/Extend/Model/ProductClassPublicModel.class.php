<?php 
/**
 * 产品类别
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class ProductClassPublicModel extends Model {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'product_class';
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("",'validClassInfo','',1,'callbacks'), 	 
		);   
	public $productClass1	=		array( 
			array("class_name",'require','require',1),
			array("class_name",'','unique',1,'unique','',array('class_level'=>1)),
			array("class_no",'require','require',1),
			array("class_no",'','unique',1,'unique','',array('class_level'=>1)),
			array("class_no",'validbarcode','',1,'callbacks'),
			array("class_no",'is_no',"valid_error",1)
			);
	public $productClass2	=		array( 
			array("class_name",'require','require',1),
			array("class_name",'','unique',1,'unique','',array('class_level'=>2)),
			array("class_no",'require','require',1),
			array("class_no",'','unique',1,'unique','',array('class_level'=>2)),
			array("class_no",'is_no',"valid_error",1),
			array("class_no",'validbarcode','',1,'callbacks'),
			array("parent_id",'require','require',1),
			);
	public $productClass3	=		array( 
			array("class_name",'require','require',1),
			array("class_name",'','unique',1,'unique','',array('class_level'=>3)),
			array("class_no",'require','require',1),
			array("class_no",'','unique',1,'unique','',array('class_level'=>3)),
			array("class_no",'is_no',"valid_error",1),
			array("class_no",'validbarcode','',1,'callbacks'),
			array("parent_id",'require','require',1),
			);
	public $productClass4	=		array( 
			array("class_name",'require','require',1),
			array("class_name",'','unique',1,'unique','',array('class_level'=>4)),
			array("class_no",'require','require',1),
			array("class_no",'','unique',1,'unique','',array('class_level'=>4)),
			array("class_no",'is_no',"valid_error",1),
			array("class_no",'validbarcode','',1,'callbacks'),
			array("parent_id",'require','require',1),
			);						
			 
	/**
	 * 类别验证
	 *
	 * @param array $data
	 * @return array
	 */
	public function validClassInfo($data){   
		$name	=	'productClass'.$data['class_level']; 
		return $this->_validSubmit($data,$name);     
	}
	
	
	
} 
