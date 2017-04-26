<?php

/**
 * 销售统计
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatSalePublicAction extends CommonAction  {
	
	public function index(){
		$this->getAddtionPost('from_order_date','date'); 
		$_REQUEST && $source = D('StatSale')->getSaleStat();
		$source_file = 'saleStat';	
		if ($_POST['query']['b.product_id'] || $_GET['type'] == 4) {
			$source_file = 'saleStatProduct';				
			$this->assign('list', $source);	
			$this->assign ("page", $source['page'] );/// 分页条
		} else if ($_REQUEST['class_level'] ==5) {
			$source_file = 'saleStatClient';
			$this->assign('list',$source);	
			$this->assign ("page", $source['page'] );/// 分页条
		} else {
			$this->assign('list',$source);	
			$this->assign ("page", $source['page'] );/// 分页条
		}		
		$this->assign('source_file',$source_file);
		$this->assign('client_currency',count(explode(',',C('client_currency'))));
		if($_POST['search_form']){
			$this->display('list');
		}else{
			$this->display();
		}
	}
	
     ///把GET的指定的TYPE类型的内容转换成POST变量中的参数
    function getAddtionPost($key,$type=''){
    	if ($type){ 
    		if (isset($_GET[$key])){
    			if (C('digital_format')=='zh'){
    				$_POST[$type][$key]	=	$_GET[$key];
    			}else{
    				$_POST[$type][$key]	=	formatDate($_GET[$key],'outdate');
    			} 
			} 
    	}else{  
    		if (isset($_GET[$key])){
				$_POST[$key]	=	$_GET[$key];
			} 
    	}
    	
    }
    
    // 销售统计表明细
	public function saleStatDetail() {
		$_GET['type'] ==1 && $source = D('StatSale')->getSaleDetail();
		$_GET['type'] > 1 && $source = D('StatSale')->getReturnDetail();
		$source_file = 'saleStatDetail';			
		$_GET['type'] > 1 && $source_file = 'saleStatReturnDetail';
		$this->assign('list',$source);
		$this->assign ("page", $source['page'] );// 分页条
		$this->assign('source_file',$source_file);
		$this->assign('client_currency',count(explode(',',C('client_currency'))));
		$this->display();
	}
	// 销售统计表明细(按产品分组)
	public function saleStatProduct() {
		$source = D('StatSale')->getSaleStat();
		$source_file = 'saleStatProduct';
		$this->assign('list', $source);	
		$this->assign ("page", $source['page'] );// 分页条
		$this->assign('source_file',$source_file);
		$this->assign('client_currency',count(explode(',',C('client_currency'))));
		$this->display();
	}	
}