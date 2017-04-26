<?php 
/**
 * 款项汇总表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FundStatPublicAction extends CommonAction {
	
	public function index() { 
       	///获取当前Action名称
	 	$name = $this->getActionName(); 
 		///获取当前模型
		$model 	= D($name);     
		///格式化+获取列表信息  
		$list	=	$model->index();  
		///assign
		$this->assign('list',$list);
		///display
		$this->displayIndex();
       
    }
     
	///查看明细
	public function view() {     
	   ///获取当前Action名称
	 	$name = $this->getActionName(); 
			///获取当前模型
		$model 	= D($name);       
		///格式化+获取列表信息  
		$list	=	$model->view();  
		///assign
		$this->assign('list',$list); 
		///display
		$this->display('view');
	}
}