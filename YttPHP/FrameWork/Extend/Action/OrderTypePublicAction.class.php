<?php 
/**
 * 包装信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	销售渠道信息
 * @package  	Action
 * @author    	
 * @version 	2014/1/15 16:04:03
 */

class OrderTypePublicAction extends RelationCommonAction {
 
	protected $_default_post	=  array('query'=>array('to_hide'=>1));  ///默认post值处理
    public $_view_dir 			= 'OrderType';	/// 定义模板显示路径
    protected $_cacheDd 		= array(35); 

    ///插入
	public function insert() {
		$name	= $this->getActionName();
		$model 	= D($name);      
		///模型验证
		if (false === $model->create($_POST)) {  
			$this->error ( $model->getError(),$model->errorStatus);
		}    
		///保存POST信息->返回主表ID
		$id		=	$model->add();   
		if ($id!==false) { ///保存成功 
			$this->id	=	$id;
			///生成字典
			if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 
		} else { 
			///失败提示  
			$this->error (L('_ERROR_'));
		}   
	}
	 
    ///修改
	public function edit() {
	 	$name	= $this->getActionName();
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
	}  
    
    ///更新
	public function update() {
	 	$name   = $this->getActionName();
		$model 	= D($name);   
		///主表ID
		$id 	= 	intval($_POST[$model->getPk()]); 
		///模型验证
		if (false === $model->create($_POST)) {
			$this->error ( $model->getError (),$model->errorStatus);
		} 
		///更新数据
		$list = $model->save(); 	
		if (false !== $list) {
			$this->id	=	$id;
			///生成字典
			if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 
		} else { 
			$this->error (L('_ERROR_'));
		}
	}	
	
  
    ///列表
	public function index() {
	 	$name   = $this->getActionName();
		$model 	= D($name);      
		$opert	= array('where'=>_search($this->_default_where,$this->_default_post));
		$list	= $this->_listAndFormat($model,$opert);
		$this->assign('list',$list);
		$this->displayIndex();
	}	
	 
    ///查看
    public function view(){     
	 	$name   = $this->getActionName(); 
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
    
    ///还原
    public function restore($id=null){
	 	$name   = $this->getActionName();
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
    
	public function _before_index(){
  		getOutPutRand();
  	}	
}