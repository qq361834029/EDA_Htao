<?php

/**
 * 缓存管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	缓存管理
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class CachePublicModel extends Model {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'Dd'; 
	 
	public function add(){
		$this->addDd();///更新Dd缓存
	}
	
	private function updateDdCache(){
		$list	=	$this->select(); 
		foreach ($list as $value) {
			if (!in_array($value['id'], C('CFG_NOT_CACHE_DD_NAME'))) {
				cacheDd($value['id']);
			}
    	}  
	}
	
	/**
	 * DD_config压入内存
	 *
	 */
	public function addDdConfig(){
		///缓存
    	$option 			= include(THINK_PATH.'Conf/dd_config.php');
    	foreach ((array)$option as $key => $value) { 
    		S('dd_config_'. strtolower($key),$value);
    	} 
	}
	
	/**
	 * 更新当前所有表中的包含日期的信息压入到S当中
	 *
	 */
	public function addTablesInfo(){
		$sql	= 'show tables'; 
		$tables	= $this->query($sql);
		$type	=	array( 
							'\'date\'',
							'\'datetime\'',
		); 
		$notIn	=	array( 
							'\'create_time\'',
							'\'update_time\'',
							'\'last_time\'',
		);
		foreach ((array)$tables as $key => $value) { 
			$detail		= '';
			$tableName	=	current($value);  
			$detail	= 'show columns from '.$tableName.' where type in ('.join(',',$type).') and Field not in ('.join(',',$notIn).')  ;';  
			$fields	= $this->query($detail);  
			if (is_array($fields) && count($fields)>0){   
				foreach ((array)$fields as $fieldsk => $fieldsv) {  
					$data[$tableName][]	=	array(
													'Field'=>$fieldsv['Field'],
													'Type'=>$fieldsv['Type'], 
					);
				} 
			} 
    	} 
    	S('create_table_about_date',$data); 
	}
	
	///更新Dd缓存
	public function updateCache(){
		$this->addDdConfig();
		$this->addTablesInfo();
		$this->updateDdCache(); 
		$this->deleteFormatListKeyInCache(); 
		
	}
	
	/**
	 * 删除历史_formatList中的第二个参数压入内存中的信息
	 *
	 */
	public function deleteFormatListKeyInCache(){
		S('_formatList',array()); 
	}
	
	
	/**
	 * 删除部署模式下生成的缓存文件
	 */
	public function deleteRuntimeFiles(){
		unlink(ADMIN_RUNTIME_PATH.'~runtime.php');
		$path = ADMIN_RUNTIME_PATH.'Data/_fields/';
		$dh = opendir($path);
		while ($file = readdir($dh)){
			if($file!="." && $file!="..") {
				unlink($path.$file);
			}
		}
		closedir($dh);
		return true;
	}
};