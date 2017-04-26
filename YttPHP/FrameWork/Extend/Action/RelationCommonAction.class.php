<?php  
/**
 * 关联操作公共基类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class RelationCommonAction extends CommonAction {
   
	public $_Member 				=	'';
	public $_email_object_id 		=	'factory_id';///默认客户 其余 factory_id
	
	///新增查看
	public function _after_add(){  
		$temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;  
		$this->display($temp_file); 
	}
	
	///新增
	public function insert() {   
		$model = $this->getModel();  
		if ($model->relationInsert()===false){   
			if ($model->error_type==1){  
				$this->error ( $model->getError(),$model->errorStatus);	
			}else{  
				$this->error (L('_ERROR_'));
			}
		}
		$this->id	=	$model->id;  
	}  

	public function _after_insert(){
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
	
	///修改
	public function update() {	 
		$this->id	=	intval($_POST['id']); 
		if ($this->id > 0) {  
			$model	= $this->getModel();
			if ($model->relationUpdate()===false){
				if ($model->error_type==1){  
					$this->error ( $model->getError(),$model->errorStatus);	
				}else{
					$this->error (L('_ERROR_'));
				} 
			}
		} else {
			$this->error(L('_ERROR_ACTION_'));
		} 	 
	}
	
	public function _after_update(){
		$this->success(L('_OPERATION_SUCCESS_')); 
	} 

	/// 編辑操作
	public function edit() {	
		$id	=	intval($_GET['id']);	
		if ($id > 0) {	
			///获取当前Action名称
			$name = $this->getActionName();
	 		///获取当前模型
			$model 		= D($name);  
			$this->id	= $id; 
			$model->setId($id);
			$this->rs	= $model->edit();
			if (data_permission_validation($this->rs) === false) {
				throw_json(L('data_right_error'));
			}
			$model->cacheLockVersion($this->rs);
		} else {
			$this->error(L('_ERROR_ACTION_')); 
		}
	}	

    public function _after_edit(){
		$temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;  
		$this->display($temp_file);
	}
	

    /// 查看明细
	public  function view(){
		$id	=	intval($_GET['id']);	 
		if ($id> 0) {  
			///获取当前Action名称
			$model 		= $this->getModel();
			$model->setId($id);
			$this->rs	= $model->view();
			if (data_permission_validation($this->rs) === false) {
				throw_json(L('data_right_error'));
			}
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}				 	
	}
	
	/**
	 * 发送邮件的地址
	 *
	 * @param array $emailArray
	 * @return array
	 */
        
	public function getEmailAddress($comp_ids){  
		$array				=	null;
		$email_object_id	=	$this->_email_object_id;
		if (empty($email_object_id)){ return $array; }
		$comp_array = explode(',',$comp_ids);
		foreach((array)$comp_array as $value){
			switch ($email_object_id){
				case 'factory_id':
					$email_address	=	SOnly('factory',$value,'comp_email');
					break;
				default:
					$email_address	=	SOnly('client',$value,'comp_email');
					break;		
			} 
			///判断是否有email地址
			if (!empty($email_address)){
				$array[]	=	array('email_address'=>$email_address);
			}
		}
		return $array;
	} 
	
	/**
	 * 发送邮件
	 *
	 * @param string $name
	 */
	public function sentEmail($name,$info){   
		define('ACTION_SENT_EMAIL',1);  
		
		addLang($name);
		$return = false;
		$emailArray	=	$this->getEmailAddress($info['comp_id']);
		if (is_array($emailArray)){
			foreach((array)$emailArray as $key=>$value){
				$this->view(); 
				$str	=	'<html xmlns="http:///www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						<title>'.C('email_title').'</title>
						</head>
						<body>';	  
				$str	.=	$this->_after_view_str($name,'view_email').'</body>'.'</html>';
				$return = postEmail($value['email_address'],'',$str); 
			}  
		} 
		define('ACTION_SENT_EMAIL',2);
		return $return;
	}
	
	
	public function _after_view($temp_file){
		if (empty($temp_file)){ 
			$temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;  
		} 
		$this->display($temp_file);
	}
	
	public function _after_view_str($name,$temp_file){ 
		if (empty($temp_file)){ 
			$temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;  
		}  
		if ($name){
			$temp_file	=	$name.':'.$temp_file;
		}
		return $this->display($temp_file,'','',true);
	}
	
	/// 删除
	public function  delete() {
		$this->id	=	intval($_GET['id']);
		if ($this->id > 0) {  
			$model	= $this->getModel();   
			if ($model->relationDelete($this->id)===false){ 
				if ($model->error_type==1){
					$this->error ( $model->getError(),$model->errorStatus);	
				}else{
					$this->error (L('_ERROR_'));
				} 
			}  
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}
	}
	
	///删除
	public function _after_delete(){
    	$this->success(L('_OPERATION_SUCCESS_')); 	
    }
	///列表
	public function index() { 
		$this->_autoIndex();
	} 
		///列表
	public function _autoIndex($temp_file=null) { 
		$this->action_name	=   ACTION_NAME;
 		///获取当前模型 
    	$model 	= $this->getModel();
    	///格式化+获取列表信息  	
    	$this->list	= $model->index();  
		$this->displayIndex($temp_file);
	}  
    
    public function editStateUpdate() {
			///获取当前Action名称
			$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);  
			startTrans();
			if($model->editStateUpdateValid($_POST) === true && $model->editStateUpdate() !==false){//验证信息
				commit();
                $this->success(L('_OPERATION_SUCCESS_'));
			}else{
				rollback();
                if ($model->error_type==1){  
                    $this->error ( $model->getError(),$model->errorStatus);	
                }else{  
                    $this->error (L('_ERROR_'));
                } 
			}
	}	
	 
}
?>