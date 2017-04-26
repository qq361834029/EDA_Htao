<?php

/**
 * 语言包
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class LangPublicModel extends CommonModel {
	
	protected $tableName = 'lang';
	
	protected $_validate	 =	 array(
		array("module",'require',"require",1),
	);
	
    /// 自动去首尾空格 added by jp 20131122
    protected $_auto = array(
                            array("module", "trim", 3, "function"), // 模块	
                            array("lang_key", "trim", 3, "function"), // 下标					
                        );
    
	public function getInfo($id){
		$rs	= $this->find($id);
		return $rs;
	}
	/**
	 * 更新语言包生成文件
	 *
	 * @param string $where 根据条件更新语言包 
	 */
	public function updateFile($where=''){
		///数据库 设置语言种类
		$dbFields	= $this->getDbFields();
		foreach($dbFields as $key=>$val){
			if(substr($val,0,11)=='lang_value_'){
				$lang_type[]	= substr($val,11);
			}
		}
		$list	= $this->where('1=1 '.$where)->select();
		///按语言模块重整list
		foreach($list as $key=>$val){
			foreach($lang_type as $type){
				$lang_arr[$type][$val['module']][$val['lang_key']]	= $val['lang_value_'.$type] ? $val['lang_value_'.$type] : $val['lang_value_'.C('DEFAULT_LANG')];//语言包为空则取默认语言
			}
		}
		
		///取语言包生成文件路径
		if(defined('ADMIN_RUNTIME_PATH')){
			$path	= ADMIN_RUNTIME_PATH.'Lang/';
		}else{
			$path	= RUNTIME_PATH.'Lang/';
		}
		mk_dir($path);
		///生成语言包文件
		foreach($lang_arr as $key=>$val){
			$lang_path	= $path.$key.'/';
			mk_dir($lang_path);
			@chmod($lang_path, 0777);
			foreach($val as $module=>$value){
				F($module,$value,$lang_path);
				@chmod($lang_path.$module.'.php', 0777);
			}
		}
		
	}
	
	/**
	 * 语言包修改后生成缓存文件
	 *
	 */
	public function deleteFile(){
		if(defined('ADMIN_RUNTIME_PATH')){
			$path	= ADMIN_RUNTIME_PATH.'Lang/';
		}else{
			$path	= RUNTIME_PATH.'Lang/';
		}
		
		$lang	= getAllFile($path,true);
		foreach($lang as $val){
			$tmp	= getAllFile($path.$val.'/',true);
			foreach($tmp as $v){
				@unlink($path.$val.'/'.$v);
			}
			rmdir($path.$val.'/');
		}
	}
}