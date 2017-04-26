<?php 
/**
 * 银行关联操作公共基类
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-7-30
 */
class BankCommonAction extends CommonAction { 
	 
    /**
     * 数据格式化
     *
     * @param array $info $_POST
     * @return unknown
     */
	public function setPost($info){
		return $info;
	}
    
    //插入
	public function insert() {    
		//获取当前Action名称
		$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);     
		//数据格式化
		$info	=	$this->setPost($_POST); 
		//模型验证  
		if (false === $model->create($info)) {  
			$this->error ( $model->getError(),$model->errorStatus);
		}     
		//保存POST信息->返回主表ID
		$id		=	$model->paidDetail($info);  
		if ($id!==false) { //保存成功 
			$this->id	=	$id;
		} else { 
			//失败提示  
			$this->error (L('_ERROR_'));
		}   
		
	}
	
	public function _after_insert(){
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
	
	public function _after_update(){
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
  
    //列表
	public function index() {	 
		//获取当前Action名称
	 	$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);      
		//格式化+获取列表信息  
		$list	=	$model->index();
		//assign
		$this->assign('list',$list);
		//display
		$this->displayIndex();
	}	
	 
    //查看
    public function view(){     
    	//获取当前Action名称
	 	$name = $this->getActionName(); 
 		//获取当前模型
		$model 	= D($name);   
    	//主表ID
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
      
    //删除
    public function delete(){ 
		//获取当前Action名称
		$name = $this->getActionName();
		//获取当前模型
		$model 	= D($name);   
		//当前主键
		$pk		=	$model->getPk();
		$id 	= 	intval($_REQUEST[$pk]);
		if ($id>0) {  
			$id		=	$model->paidDetail($id,'deleteOp');   
			//如果删除操作失败提示错误
			if ($id==false) {
				$this->error(L('data_right_del_error'));
			}
		}else{
			$this->error(L('_ERROR_'));
		}  
    }
    
    public function _after_delete(){
    	$this->success(L('_OPERATION_SUCCESS_')); 	
    }
       
}
?>