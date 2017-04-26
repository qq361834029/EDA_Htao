<?php 

/**
 * 可销售库存管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	可销售库存
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class SaleStoragePublicAction extends CommonAction {
	
	/// 可销售库存列表
	public function index(){
		if(C('sale_storage_show_type') == 2){
			$this->list = D('StorageShow')->getSaleStorage();
			$tpl_name = 'listByProduct';
		}else{
			$this->list = D('StorageShow')->getSaleStorageByClass();
			$tpl_name = 'list';
		}
		if ($_POST['search_form']) {
			$this->display($tpl_name);
		}else {
			$this->display();
		}
	}
	
	/// 在途库存列表
	public function lcStorage(){
		$this->list = D('StorageShow')->getLCStorage();
		if ($_POST['search_form']) {
			$this->display('lclist');
		}else {
			$this->display();
		}
	}
    
}
?>