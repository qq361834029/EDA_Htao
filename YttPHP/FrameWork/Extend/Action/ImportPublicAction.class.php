<?php 
/**
 * 导入列表
 * @copyright   2012 展联软件友拓通
 * @category   	调整信息
 * @package  	Action
 * @author    	wqy
 * @version 	2012-09-07
 */
class ImportPublicAction extends RelationCommonAction {
	//列表查询的前置操作	
	public function index() {	
		//格式化+获取列表信息
		addLang('ExcelTemplete');
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		$this->assign('list', D('Import')->getImportData()); 
		$this->display();		
	}
}
?>