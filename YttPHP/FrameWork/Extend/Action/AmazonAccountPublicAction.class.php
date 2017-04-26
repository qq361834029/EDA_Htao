<?php

/**
 * Amazon账号信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class AmazonAccountPublicAction extends BasicCommonAction {
	
	public function _before_index(){
		getOutPutRand();
	}

	///新增
	public function add() {
		$company_id	=	getUser('company_id'); 
		if ($company_id > 0) {
			$this->assign("fac_id", $company_id);
			$this->assign("fac_name", SOnly('factory',$company_id, 'factory_name'));		
		}
	} 

	///插入
	public function insert() {    
		$name  = $this->getActionName();
		$model = D($name);      
		///模型验证
		if (false === $model->create($_POST)) {  
			$this->error ( $model->getError(),$model->errorStatus);
		}    
		///保存POST信息->返回主表ID
		$id	= $model->add();   
		if ($id!==false) { ///保存成功 
			import("ORG.Util.AmazonAuth"); 
			//生成认证和计划任务
			$AmazonAuth = new ModelAmazonAuth($id);
			//同步数据执行下列判断
			if($_POST['synchrodata']=='1'){
				$AmazonAuth->createAmazonSystemTasksFile();
			}else{
				$AmazonAuth->delAmazonSystemTasksFile();
			}
			unset($AmazonAuth);

			$this->id =	$id;
			///生成字典
			if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 
		} else { 
			///失败提示  
			$this->error (L('_ERROR_'));
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
			$userdata   = $model->find($id);
			if($userdata['to_hide']==1){
				import("ORG.Util.AmazonAuth"); 
				//生成认证和计划任务
				$AmazonAuth = new ModelAmazonAuth($id);
				//同步数据执行下列判断
				if($_POST['synchrodata']=='1'){
					$AmazonAuth->createAmazonSystemTasksFile();
				}else{
					$AmazonAuth->delAmazonSystemTasksFile();
				}
				unset($AmazonAuth);	
			}
			$this->id	=	$id;
			///生成字典
			if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 
		} else { 
			$this->error (L('_ERROR_'));
		}
	}	

	///列表
	public function index() {	 
		$name	= $this->getActionName();
		$model 	= D($name);
		$opert	= array('where'=>_search($this->_default_where,$this->_default_post));
		$list	= $this->_listAndFormat($model,$opert);
		if(is_array($list['list'])&&$list['list']){
			foreach($list['list'] as $k=>$v){
				$list['list'][$k]['synchrodata']  = $v['synchrodata']==0?L('manul'):L('auto');
			}
		}
		$this->assign('list',$list);
		$this->displayIndex();
	}	
	
	///删除
    public function delete(){ 
    	if ($_GET['restore']==1){
    		$this->restore();
    	}else{
		 	$name   = $this->getActionName();
			$model 	= D($name);   
			///当前主键
			$pk		=	$model->getPk ();
			$id 	= 	intval($_REQUEST[$pk]);
			if ($id>0) { 
				$condition = $pk.'='.$id; 
				$list	   = $model->where($condition)->setField('to_hide',2);
				$this->id  = $id;   
				///如果删除操作失败提示错误
				if ($list==false) {
					$this->error(L('data_right_del_error'));
				}
				//删除认证文件
				import("ORG.Util.AmazonAuth"); 
				$AmazonAuth = new ModelAmazonAuth($id);
				$AmazonAuth->deleteFile();
			}else{
				$this->error(L('_ERROR_'));
			} 
    	} 
    }

	///还原
    public function restore($id=null){
	 	$name  = $this->getActionName();
		$model = D($name);   
		///当前主键
		$pk	   = $model->getPk();
		$id    = $id ? intval($id) : intval($_REQUEST[$pk]);
		if ($id>0) { 
			$condition = $pk.'='.$id; 
			$list	   = $model->where( $condition )->setField('to_hide',1);  
			$this->id  = $id;     
			if ($list==false) { 
				$this->error(L('_ERROR_'));
			}
			$userdata  = $model->find($id);
			if($userdata){
				import("ORG.Util.AmazonAuth"); 
				$AmazonAuth = new ModelAmazonAuth($id);
				if($userdata['synchrodata']=='1'){
					$AmazonAuth->createAmazonSystemTasksFile();
				}else{
					$AmazonAuth->delAmazonSystemTasksFile();
				}
			}
		}else{ 
			$this->error(L('_ERROR_'));
		} 
    }   
}