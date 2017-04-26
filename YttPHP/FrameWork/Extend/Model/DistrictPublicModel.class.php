<?php

/**
 * 国家信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class DistrictPublicModel extends CommonModel  {
	
	protected $tableName = 'district';
	
	// 自动验证设置
	protected $_validate	 =	 array(
		array("district_name",'require',"require",1),
		array("district_name",'repeat',"unique",1,'unique'),//验证唯一  
		array("parent_id",'require',"require",0),
		array("no_vat_quota",'money',"double",2),
		array("no_vat_warning",'money',"double",2),
		array("has_other_vat_quota",'money',"double",2),
		array("has_other_vat_warning",'money',"double",2),
	);

	/**
	* 获取国家信息
	* @param int $id
	* @see 函数 
	* @return array
	*/
	public function getInfo($id){
		$model	= M('District');
		$vo		= $model->field('*,parent_id as city_parent_id')->find($id);
		return $vo;
	}
	
	/**
	* 添加日志
	* @param string $log
	* @param int $id
	* @see 函数 
	* @return string
	*/
	public function setLog($log,$id){
		switch(ACTION_NAME){
			case 'insert':
				$log = L('add');
				$rs = $this->find($id);
				break;
			case 'update':
				$log = L('update');
				$rs = $this->find($id);
				break;
			case 'delete':
				$log = $_GET['restore'] ? L('restore') : L('delete');
				$rs = $this->find($id);
				break;
			default:
				break;	
		}
		if($rs['parent_id']>0){
			$log .= L('module_City').'，';
		}else{
			$log .= L('module_'.MODULE_NAME).'，';
		}
		$name_field	= 'district_name';
		if ($rs[$name_field]) {
			$log .= L('name').'：'. $rs[$name_field].'；';
		}
		return $log;
	}
}