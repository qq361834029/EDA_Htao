<?php 
/**
 * 拣货导入异常管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	拣货信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-04-15
 */

class PickingAbnormalPublicModel extends FileListPublicModel {
	/// 定义真实表名
	public $tableName = 'file_detail';//必须	
	public $import_key = 'PickingImport';//必须	
	///关联插入	 
	public $_link = array();//必须	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("quantity",'z_integer','z_integer',1),//数量
			array("state",'require','require',1),//处理状态
		);		
	public function __construct($name = '', $tablePrefix = '', $connection = '') {
		parent::__construct($name, $tablePrefix, $connection);
		if ($_POST['state'] == C('CFG_IMPORT_PROCESSED_STATE')){
			$_validate = array(
				array("",'validInfo','require',1,'callbacks'),//验证基本信息
			);
			$this->_validate	= array_merge($this->_validate, $_validate);
		}
	}
	
	
	///验证基本信息
	public function validInfo(&$data){
		$error					= false;
		if($data['quantity'] != $data['real_quantity']) {
			$error	= true;
			$this->error[]	= array('name'=>'quantity', 'value'=>L('picking_import_real_quantity_inconsistent'));
		}
		return $error;
	}	
}