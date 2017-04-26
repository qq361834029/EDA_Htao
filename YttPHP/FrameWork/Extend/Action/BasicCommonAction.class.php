<?php  
/**
 * 关联操作公共基类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class BasicCommonAction extends CommonAction { 
	
	protected $_cacheDd 		=  array(); ///如果父类有值,即需要更新字典,需要更新多个字典array(key=>value); key更新的ID,value为where条件
	protected $_default_where 	=  '';  	///默认查询条件=>例子$_default_where	=  'parent_id<>0';  
	protected $_default_post 	=  array(); ///默认post条件=>例子protected $_default_post	=  array('query'=>array('to_hide'=>1));
	protected $_view_model 		=  false;	///false 自身关联 否者关联getActionName+'View'
	
	public function add() {
    	///自动补上编号
    	$this->_autoMaxNo();
    }
    
    ///插入
	public function insert() {    
		///获取当前Action名称
		$name   = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);      
		///模型验证
		$rs     = $model->create($_POST);
		if (false === $rs) {  
			$this->error ( $model->getError(),$model->errorStatus);
		}    
		///保存POST信息->返回主表ID
		$id		=	$model->add($rs);   
		if ($id!==false) { ///保存成功 
			$this->id	=	$id;
			///生成字典
			if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 
		} else { 
			///失败提示  
			$this->error (L('_ERROR_'));
		}   
		
	}
	
	public function _after_insert(){
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
	 
    ///修改
	public function edit() {
		///自动补上编号
    	$this->_autoMaxNo();
		///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);   
		///模型ID
		$id 	= 	intval($_REQUEST[$model->getPk()]);  
		if ($id>0) {
			if (method_exists($model,'getInfo')) {
				$vo = _formatArray($model->getInfo($id),$this->_default_format);  
			}else{
				$vo = _formatArray($model->getById($id),$this->_default_format);  
			}
			///如果查询结果是空提示错误 
			if (!is_array($vo)) {
				exit(L('data_right_error'));
			} 
			$this->rs	=	$vo; 
			$model->cacheLockVersion($vo);
		}else {
			$this->error(L('_ERROR_'));
		}
		$this->display (); 
	}  
    
    ///更新
	public function update() {
		///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);   
		///主表ID
		$id 	= 	intval($_POST[$model->getPk()]); 
		///模型验证
		if (false === $model->create ($_POST)) {
			$this->error ( $model->getError (),$model->errorStatus);
		} 
		///更新数据
		$list	=	$model->save(); 
		if (false !== $list) {
			$this->id	=	$id;
			///生成字典
			if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 
		} else { 
			$this->error (L('_ERROR_'));
		}
		
	}	
	
	public function _after_update(){
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
  
    ///列表
	public function index() {	 
		///获取当前Action名称
	 	$name = $this->getActionName();
	 	if ($this->_view_model===true){
	 		$name	=	$name.'View';
	 	}  	
 		///获取当前模型
		$model 	= 	D($name);      
		///条件
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post),'sortBy'=>$this->_sortBy);
		///格式化+获取列表信息   
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME; 
		$list	= $this->_listAndFormat($model,$opert,$_formatListKey);
		if (in_array(MODULE_NAME, C('MERGE_ADDRESS_MODULE'))) {//added by jp 20140115
			_mergeAddress($list);
		}
		///assign
		$this->assign('list',$list);
		///display
		$this->displayIndex();
	}	
	 
    ///查看
    public function view(){     
    	///获取当前Action名称
	 	$name = $this->getActionName(); 
 		///获取当前模型
		$model 	= D($name);   
    	///主表ID
		$id 	= 	intval($_REQUEST[$model->getPk()]); 
		if ($id>0) {
			if (method_exists($model,'getInfo')) {
				$vo = _formatArray($model->getInfo($id),$this->_default_format);  
			}else{
				$vo = _formatArray($model->getById( $id ),$this->_default_format);   
			}
			if(empty($vo)) {
				$this->error(L('data_right_error'));
			}
			$this->rs	=	$vo;
		}else{
			$this->error(L('_ERROR_'));
		}
    }
    
    public function _after_view(){
		$this->display();
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
				$list	=	$model->where($condition)->setField('to_hide',2);
				$this->id	=	$id;   
				///如果删除操作失败提示错误
				if ($list==false) {
					$this->error(L('data_right_del_error'));
				}
			}else{
				$this->error(L('_ERROR_'));
			} 
			
    	} 
    }
    
    public function _after_delete(){
    	$this->success(L('_OPERATION_SUCCESS_')); 	
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
			$this->id	=	$id;     
			///如果产品还原失败提示失败
			if ($list==false) { 
				$this->error(L('_ERROR_'));
			}			
		}else{ 
			$this->error(L('_ERROR_'));
		} 
    }   
}
?>