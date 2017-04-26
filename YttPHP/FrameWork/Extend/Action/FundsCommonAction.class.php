<?php  
/**
 * 关联操作公共基类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FundsCommonAction extends CommonAction { 
	
	///款项操作类型
 	public $comp_type	=	'';  
 	
 	///新增
	public function add(){
		$this->assign('comp_type',$this->comp_type);
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $warehouse_id   = getUser('company_id');
            $this->assign('warehouse_id',$warehouse_id);
        }
	}
    
    /**
     * 数据格式化
     *
     * @param array $info $_POST
     * @return array
     */
	public function setPost($info){
		return $info;
	}
    
    ///插入
	public function insert() {    
		///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);     
		///数据格式化
		$info	=	$this->setPost($_POST);  
		///模型验证 
		if (false === $model->create($info)) {  
			$this->error ( $model->getError(),$model->errorStatus);
		}   
		///业务规则
		$model->_brf(); 
		///保存POST信息->返回主表ID   
		$id		=	$model->paidDetail($info);   
		if ($id!==false) { ///保存成功 
			$this->id	=	$id;
			///生成字典
///			if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 
		} else { 
			///失败提示  
			$this->error (L('_ERROR_'));
		}   
		
	}
	
	public function _after_insert(){
		$this->success(L('_OPERATION_SUCCESS_')); 
	} 
	
	public function _after_update(){
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
  
    ///列表
	public function index() {	 
		if ($_POST['search_form']) {
			///获取当前Action名称
			$name = $this->getActionName(); 
			///获取当前模型
			$model 	= D($name);     
			///格式化+获取列表信息  
			$list	=	$model->index();
			///assign
			$this->assign('list',$list);
		}
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
			if (data_permission_validation($vo, 'comp_id') === false) {
				throw_json(L('data_right_error'));
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
	    	///获取当前Action名称
		 	$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);   
			///当前主键
			$pk		=	$model->getPk ();
			$id 	= 	intval($_REQUEST[$pk]);
			if ($id>0) {  
				$id		=	$model->paidDetail($id,'deleteOp');  
///				$condition 	= $pk.'='.$id; 
///				$list	=	$model->where($condition)->setField('to_hide',2);   
				///如果删除操作失败提示错误
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