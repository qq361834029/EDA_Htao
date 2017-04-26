<?php

/**
 * 客户交易分析
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatClientAnalysisPublicAction extends RelationCommonAction  {
	
	public function index(){
		
		$model	= D('StatClientAnalysis');
		if($model->validSearch()===false){
			if ($model->error_type==1){  
				$this->error ( $model->getError(),$model->errorStatus);	
			}else{  
				$this->error (L('_ERROR_'));
			}
		}
		$info	= D('StatClientAnalysis')->getOrderDate();
		unset($_POST['date']);
		$_POST['date']['from_order_date']	= $info['from_order_date'];
		$_POST['date']['to_order_date']		= $info['to_order_date'];
		if($_POST['search_form']){
			$source = D('StatSale')->getClientDealData();
			$this->assign('list',$source);
			$this->assign('page',$info['page']);
			$this->displayIndex('list');
		}else{
			$this->displayIndex();
		}
	}
	//客户交易分析明细
	public function clientDealAnalysisDetail(){
		$_REQUEST &&  $source = D('StatSale')->getSaleNumByClient();
		$_REQUEST &&  $this->assign('list', $source);
		$_REQUEST &&  $this->assign('page',$source['page']);	
//		echo '<pre>';print_r($source);
		$this->display();
	}
	// 客户交易分析图(产品)
	public function clientDealAnalysisProduct() {
		$_REQUEST &&  $source = D('StatSale')->getClientDealProduct();
		$_REQUEST &&  $this->assign('list', $source);	
		$this->assign ("page", $source['page'] );// 分页条		
		$this->display();
	}
}