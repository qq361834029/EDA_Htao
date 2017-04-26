<?php

/**
 * 发票产品
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceProductPublicAction extends RelationCommonAction {
	//默认查询条件
	protected $_default_post	=  array('query'=>array('to_hide'=>1));  //默认post值处理
	public $_cacheDd		=  array(29,40);  //需要更新的缓存字典
	public $id;
	
	public function _after_insert(){
		$this->checkCacheDd();
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
	
	public function _after_update(){
		$this->checkCacheDd();
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
	//列表
	public function index() {	 
		//获取当前Action名称
	 	$name = $this->getActionName();
	 	if ($this->_view_model===true){
	 		$name	=	$name.'View';
	 	}  	
 		//获取当前模型
		$model 	= D($name);      
		//条件
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post));
		//格式化+获取列表信息  
		$list	=	$this->_listAndFormat($model,$opert);
		//assign
		$this->assign('list',$list);
		//display
		$this->displayIndex();
	}	
	
	public function delete() {
    	//还原特殊处理 
    	if ($_GET['restore']==1){
    		$this->restore();
    	}else{ 
			//获取当前Action名称
			$name = $this->getActionName();
	 		//获取当前模型
			$model 	= D($name);  
			$pk		= $model->getPk (); 
	    	$id 	= intval($_REQUEST[$pk]); 
	    	$condition	=	'id='.$id;
	    	$r	=	$model->where($condition)->setField('to_hide',2);   
			if (false === $r) {
				$this->error ( L('DELETE_FAILED') );
			} else if ($r === 0) {
				$this->error ( L('data_right_del_error') );
			} 
		}
	}
	
	//还原
    public function restore($id=null){
    	//获取当前Action名称
	 	$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);   
		//当前主键
		$pk		=	$model->getPk();
		$id 	= 	$id ? intval($id) : intval($_REQUEST[$pk]);
		if ($id>0) { 
			//更新条件
			$condition 	= $pk.'='.$id; 
			//执行条件语句
			$list		= $model->where( $condition )->setField('to_hide',1);    
			//如果产品还原失败提示失败
			if ($list==false) { 
				$this->error(L('_ERROR_'));
			}			
		}else{ 
			$this->error(L('_ERROR_'));
		} 
    }
}















