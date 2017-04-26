<?php 

/**
 * 实际库存管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	实际库存
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class RealStoragePublicAction extends CommonAction {
	
	/// 实际库存列表
	public function index(){
		if(C('real_storage_show_type') == 2){
			$this->list = D('StorageShow')->getRealStorage();
			$tpl_name = 'listByProduct';
		}else{
			$this->list = D('StorageShow')->getRealStorageByClass();
			$tpl_name = 'list';
		}
		if ($_POST['search_form']) {
			$this->display($tpl_name);
		}else {
			$this->display();
		}
	}
	
	/// 多个产品库存
	public function multiStorage(){
		$this->display();
	}
    
}
?>