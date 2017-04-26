<?php  
/**
 * 发货
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	销售信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class DeliveryPublicAction extends RelationCommonAction {
 	public function  _initialize(){
 		parent::_initialize(); 
 		if (C('delivery.relation_predelivery')==2){ 
			$this->_Member	=	'DeliverySale:';
		} 
 	} 
  
	public function add(){   
		///获取销售单信息
		$id	=	intval($_GET['id']);
		if ($id > 0) {	 
			$model 	= $this->getModel();
			///获取当前Action名称 
			$rs	=	$model->getBeforeInfo($id);   
	 		///获取当前模型  
			$this->rs	= $rs;    
		} else {
			$this->error(L('_ERROR_ACTION_')); 
		}
	}
  
	
	public function waitDelivery(){     
		///获取当前模型  
    	$model 		= $this->getModel();
    	///格式化+获取列表信息  	
    	$this->list	= $model->index();     
    	///计算已发货数量
		$this->list	= $model->countDeliveryQn($this->list);   
		///显示  
		$this->tplName	='waitdelivery';
		$this->displayIndex('index'); 
	}
}
?>