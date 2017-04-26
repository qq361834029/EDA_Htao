<?php 

class ReturnServicePublicAction extends RelationCommonAction {
	
	protected $_default_post = array('main'=>array('query'=>array('status'=>1)));  ///默认post值处理
	//protected $_cacheDd 	 = array(28);//对应dd表中的id 

	public function _initialize() {
		parent::_initialize(); 
		$userInfo = getUser(); 
		if ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {//卖家
			$_POST['main']['query']['status'] = 1;
			$this->assign("is_factory", true);
		}		
	}	

	public function _after_insert(){   
		$this->checkCacheDd();
		parent::_after_insert();
	}
	
	public function _after_update(){
		$this->checkCacheDd();
		parent::_after_update();
	} 	
	
	///列表
	public function index() { 
		if (!$_POST['search_form']) {
			$_POST	= array_merge($this->_default_post, $_POST);
		}		
		$this->_autoIndex(); 
	}
}
?>