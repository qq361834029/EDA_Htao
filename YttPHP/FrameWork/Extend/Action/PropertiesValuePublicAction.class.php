<?php 
/**
 * 产品属性值管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class PropertiesValuePublicAction extends RelationCommonAction {
	
	public $_default_post	=  array('query'=>array('to_hide'=>1));  ///默认post值处理
    public $_sortBy			= 'pv_no'; 
	public $_setauto_cache	= 'setauto_propertiesvalue_no';///编号对应超管配置中的值
	public $_auto_no_name	= 'pv_no';		 ///编号no  
	public $_relation		=	array('properties_info');
	
	
	public function add() {     
    	///自动补上编号
    	$this->_autoMaxNo();
    }
     
	/// 新增
	function insert() {   
		///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);  
		///重新组合POST来的信息 
		$info	= $model->setPost(); 
		///模型验证
		if ($model->create($info)) {		  
			$r = $model->relation(true)->add(); 
			if (false === $r) {
				$this->error (L('_ADD_FAILED'));
			}
			$this->id	= $r;	 	
		} else {
			$this->error ( $model->getError(),2 );
		}  
	}  
	
	/// 修改提交
	function update() {   
		///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);  
		///重新组合POST来的信息 
		$info	= $model->setPost(); 
		///模型验证
		if ($model->create($info)) {		  
			$r = $model->relation(true)->save(); 
			if (false === $r) {
				$this->error (L('_ADD_FAILED'));
			}
			$this->id	= $r;
		} else {
			$this->error ( $model->getError() );
		}  
	}  
	
	 ///删除
    public function delete(){ 
    	///还原特殊处理 mingxing 
    	if ($_GET['restore']==1){
    		$this->restore();
    	}else{
	    	///获取当前Action名称
		 	$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);   
			///当前主键
			$pk		=	$model->getPk ();
			$id 	= 	intval($_REQUEST[$pk]);
			if ($id>0) { 
				$condition 	= $pk.'='.$id; 
				$this->id	= $id;
				$list	=	$model->where($condition)->setField('to_hide',2);   
				///如果删除操作失败提示错误
				if ($list==false) {
					$this->error(L('data_right_del_error'));
				}
			}else{
				$this->error(L('_ERROR_'));
			} 
			
    	} 
    }
    
    
      ///还原
    public function restore($id=null){
    	///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);   
		///当前主键
		$pk		=	$model->getPk();
		$id 	= 	$id ? intval($id) : intval($_REQUEST[$pk]);
		if ($id>0) { 
			///更新条件
			$condition 	= $pk.'='.$id; 
			///执行条件语句
			$list		= $model->where( $condition )->setField('to_hide',1);    
			///如果产品还原失败提示失败
			if ($list==false) { 
				$this->error(L('_ERROR_'));
			}			
		}else{ 
			$this->error(L('_ERROR_'));
		} 
    } 
	
	
	///修改
	function edit() { 
		///产品自动编号
		$this->_autoMaxNo();	
	 	///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);  
		///模型ID
		$this->id	= $id 	= 	intval($_REQUEST[$model->getPk ()]);  
		if ($id>0) {
			$vo	=	$model->getInfo($id); 
			$model->cacheLockVersion($vo);
			$this->assign ( 'rs', $vo );
		}else {
			$this->error();
		} 
	}  

	///修改
	function view() { 
	 	///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);  
		///模型ID
		$id 	= 	intval($_REQUEST[$model->getPk ()]);  
		if ($id>0) {
			$vo	=	$model->getInfo($id,'view');    
			$this->rs	=	$vo;
		}else {
			$this->error();
		} 
	}  
	
	///列表
	public function index() {	 
		///获取当前Action名称
	 	$name = $this->getActionName();
	 	if ($this->_view_model===true){
	 		$name	=	$name.'View';
	 	}  
 		///获取当前模型
		$model 	= D($name);      
		///条件
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post)); 
		
		///格式化+获取列表信息  
		$list	=	$this->_listAndFormat($model,$opert);
		
		///assign
		$this->assign('list',$list);
		///display
		$this->displayIndex();
	}	
	
}