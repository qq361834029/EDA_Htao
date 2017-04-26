<?php 

/**
 * 装柜信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	装柜信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class LoadContainerPublicAction extends RelationCommonAction {
	
	/// 发送EMAIL的字段名称
	public $_email_object_id 		=	'factory_id';
	
	/// 暂存庥装箱列表
	public function alistUndelivery(){
		$this->_autoIndex('index');
	}
	
	/// 待装柜列表
	public function waitLoadContainer(){
		$this->list = D('LoadContainer')->waitLoadContainer();
		if ($_POST['search_form']) {
			$this->display ('waitlist');
		}else {
			$this->display('waitDelivery');
		}
	}
	
	/// 计算厂家小计
	public function _after_edit(){ 
		$this->factory_list  = D('LoadContainer')->getFactoryDetail($this->rs['detail']);
		$temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;  
		$this->display($temp_file);
	}
	
	/// 计算厂家小计
	public function _after_view(){ 
		$this->factory_list  = D('LoadContainer')->getFactoryDetail($this->rs['detail']);
		$temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;  
		$this->display($temp_file);
	}
}
?>