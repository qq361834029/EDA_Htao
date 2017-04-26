<?php

/**
 * 导入
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	导入
 * @package  	Model
 * @author    	wqy
 * @version 	2.1,2012-07-22
*/

class ImportPublicModel extends RelationCommonModel {
	// 定义真实表名
	protected $tableName = 'product';
	
	public function getImportData(){
		$rights = RBAC::getAccessList($_SESSION[C('USER_AUTH_KEY')]);
		$list = array();
		$list = include(RUNTIME_PATH.'~ExcelTemplete.php');
		foreach ((array)$list as $key => $value) {
			switch ($key) {
				case 'OtherCompany':
					$s_key = 'othercompany';
					break;
				case 'InitStorage':
					$s_key = 'initstorage';
					break;
				case 'ClientIni':
					$s_key = 'clientini';
					break;	
				case 'FactoryIni':
					$s_key = 'factoryini';
					break;
				default:
					$s_key = $key;
					break;
			}
			if (in_array('INSERT',array_flip($rights[strtoupper($s_key)])) && in_array('DELETE',array_flip($rights[strtoupper($s_key)]))) {
				continue;
			}
			unset($list[$key]);
		}
		return $list;
	}
}
?>