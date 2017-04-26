<?php 
/**
 * 产品属性值
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class PropertiesValuePublicModel extends RelationModel{
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'properties_value';
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("pv_no",'require','require',1),
			array("pv_no",'is_no',"valid_error",1),  	
			array("pv_no",'','unique',1,'unique'), 
			array("pv_name",'require','require',1),
			array("pv_name",'','unique',1,'unique'),
			array("pv_name_de",'require','require',1),
			array("pv_name_de",'','unique',1,'unique'),
		);  
	///关联插入	
	public $_link = array('properties_info' => array(
						  						'mapping_type'	=> HAS_MANY,												
												'class_name'	=> 'properties_info',
												'foreign_key'	=> 'properties_value_id', 
						  				)
						);
	/**
	 * 初始化post
	 *
	 */
	public function setPost(){
		if ($_POST['properties']) {
			$i = 1;
			foreach ($_POST['properties'] as $value) {
				$_POST['properties_info'][$i]['properties_id'] = $value;
				$i++;
			}
		}
	}
	
	/**
	 * 取属性值信息
	 *
	 * @param int $id
	 * @param string $type
	 * @return array
	 */
	public function getInfo($id,$type='edit'){ 
		$rs 	= $this->find($id);
		$temp 	= M('PropertiesInfo')->where('properties_value_id='.$id)->select();
		('edit'!=$type) && $cache	= S('properties');  
		foreach ((array)$temp as $value) {
			if ('edit'==$type) {
				$temp2[] = $value['properties_id'];
			}else {
				$temp2[] = $cache[$value['properties_id']]['properties_name']; 
			}
		}
		if ('edit'==$type) { 
			$temp2 && $rs['properties_id'] = implode(',',$temp2);
		}else {
			$temp2 && $rs['properties_value'] = implode('，',$temp2);
		}
		return $rs;
	}	
	
}