<?php  
/**
 * 配货
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	款项信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class PreDeliveryPublicAction extends RelationCommonAction {
	
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
  
	
	public function waitPreDelivery(){ 
		$this->tplName	='waitpredelivery';
		$this->_autoIndex('index');
	} 
	
}
?>