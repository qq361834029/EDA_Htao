<?php 

/**
 * 角色信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	角色信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class RolePublicAction extends RelationCommonAction {
	
	/// 默认查询条件
	protected $_default_where = 'to_hide=1';
	
	/// 需要更新的缓存信息
	protected $_cacheDd 		= array('5'); 
	
	/// 新增页面前置操作
	public function _before_add(){
		$this->assign('node',RBAC::getRoleNode());
	}
	
	/// 新增角色
	public function insert() {   
		$model 	= D('Role');  
		$info	= $model->setPost($_POST);   
		if ($model->create($info)) {	 
			$id = $model->relation(true)->add(); 
			if (false === $id) {
				$this->error (L('_ADD_FAILED'));
			}
			$this->checkCacheDd(); 
			$this->id	=	$id;
		} else {
			$this->error ( $model->getError(),2);
		}
	}
	
	/// 新增后置操作
	public function _after_insert(){ 
		$this->checkCacheDd();
		parent::_after_insert();
	}
	
	/// 修改页面前置操作
	public function _before_edit(){
		$this->assign('node',RBAC::getRoleNode());
	}
	
	/// 修改角色
	public function edit() {	
		$id	=	intval($_GET['id']);	
		if ($id > 0) {
			$this->id	= $id; 
			$model 		= D('Role');
			$this->rs	= $model->relation(true)->find($id);
			$model->cacheLockVersion($this->rs);
		} else {
			$this->error(L('_ERROR_ACTION_')); 
		}
	}
    
	/// 修改页面后置操作
	public function _after_edit(){
		foreach ($this->rs['access'] as $value) {
			$var[$value['node_id']] = $value;
		}
		$this->assign ( 'access', $var );
		$this->display();	
	}
	
	/// 更新角色信息
	public function update() {	
		$model 	= D('Role');  
		$info	=	$model->setPost($info);   
		if ($model->create($info)) {			
			$r = $model->relation(true)->save(); 
			$this->id	=	$info['id'];	
			if (false === $r) {
				$this->error (L('EDIT_FAILED'));
			} 
			$this->checkCacheDd();
		} else {
			$this->error ( $model->getError() ,$model->errorStatus);
		}
	}
	
	/// 更新角色后置操作
	public function _after_update(){
		$this->checkCacheDd();
		parent::_after_insert();
	}
	
	/// 角色列表
	public function index() {	 
		$model 	= D('Role');      
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post));
		$list	=	$this->_listAndFormat($model,$opert);
		$this->assign('list',$list);
		$this->displayIndex();
	}
	
	/// 删除角色
	public function delete() {
		$name = $this->getActionName();
		$model 	= D($name);  
		$pk		= $model->getPk (); 
    	$id 	= intval($_REQUEST[$pk]); 
    	$this->id	=	$id;
		$r 		= $model->relation(true)->delete($id);		
		if (false === $r) {
			$this->error ( L('DELETE_FAILED') );
		} else if ($r === 0) {
			$this->error ( L('data_right_del_error') );
		} 
	}
	
}
?>