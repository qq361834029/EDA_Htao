<?php

/**
 * 进销存统计
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatStoragePublicAction extends CommonAction {
	
	///进销存统计 按类别
	public function index(){
		if ($_POST['query']['a.product_id']) {
			$params	= array('pid'=>$_POST['query']['a.product_id']);
			if(!empty($_POST['from_date'])){
				$params['from_date']=formatDate($_POST['from_date']);
			}
			if(!empty($_POST['to_date'])){
				$params['to_date']=formatDate($_POST['to_date']);
			}
			redirect(U('/StatStorage/storageProduct',$params));
		}
		$source_file = 'storageStat';
		if ($_POST['class_level']) {
			if ($_POST['class_level']<=1) {
				$source = D('StatStorage')->getStorage();
				$this->assign('list',$source);
			}else {
				$source_file = 'storageGroup';
				$source = D('StatStorage')->getStorage();
				$this->assign('list',$source);
				$this->assign('total',$source);
			}
		}
		$this->assign('source_file',$source_file);
		if($_POST['search_form']){
			$this->display('list');
		}else{
			$this->display();
		}
	}
	
	/// 进销存统计 按产品
	public function storageProduct(){		
		$source = D('StatStorage')->getProduct();
		$this->assign('list',$source);
		$this->assign ("page", $source['page'] );// 分页条
		$this->display();
	}
	
	 /// 统计明细
	public function storageDetail() {
		$source = D('StatStorage')->storageDetail();
		$this->assign('list',$source);
		$this->assign ("page", $source['page'] );// 分页条
		$this->display();
	}
}