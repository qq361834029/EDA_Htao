<?php 
/**
 * 导入管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	导入
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-03-31
 */

class FileListPublicAction extends RelationCommonAction {
 
	 public function __construct() { 
    	parent::__construct(); 
		$userInfo	=	getUser();
		if ($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){//仓储
			$w_id	= intval($userInfo['company_id']);
			$_POST['query']['warehouse_id'] = $_POST['main']['query']['warehouse_id'] = $w_id;
			if ($w_id > 0) {
				$this->assign("w_id", $w_id);
				$this->assign("w_name", SOnly('warehouse',$w_id, 'w_name'));		
			}				
		}
	}
	
	public function _before_index(){
		getOutPutRand();
	}	
 
	///新增
	public function add() {
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
	} 

	public function _after_insert(){ 
		if(!empty($_POST['tocken'])){
			D('Gallery')->update($this->id,$_POST['tocken']);
		}
		$this->success(); 
	}
}