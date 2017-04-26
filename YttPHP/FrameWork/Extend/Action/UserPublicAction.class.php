<?php 

/**
 * 用户信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	用户信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class UserPublicAction extends BasicCommonAction {
	
	/// 默认post值处理
	protected $_default_post	=  array('query'=>array('to_hide'=>1));  
	
	/// 默认查询条件
	protected $_default_where	= 'super_admin!=1';
	
	/// 需要更新的缓存信息
	protected $_cacheDd 		= array('10','11','23'); 
	public function __construct() {
        parent::__construct();
        if(getUser('user_type') == 1 && !$_SESSION[C('ADMIN_AUTH_KEY')]){
            $admin_auth_key = true;
        }else{
            $admin_auth_key = false;
        }
        $this->assign('admin_auth_key',$admin_auth_key);
        if(getUser('role_type') == C('SELLER_ROLE_TYPE')){
            $_POST['query']['user_type'] 	=  3;  
            $_POST['query']['company_id'] 	=  getUser('company_id');  
        }
        if(getUser('role_type') == C('PARTNER_ROLE_TYPE')){
            $_POST['query']['user_type'] 	=  4;
            $_POST['query']['company_id'] 	=  getUser('company_id');  
        }
        if(getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')){
            $_POST['query']['user_type'] 	=  5; 
            $_POST['query']['company_id'] 	=  getUser('company_id');  
        }
    }
  
	/// 新增前置操作	
	public function _before_insert() {
		//$_POST['user_password'] && $_POST['user_password'] 		= md5($_POST['user_password']);	// 密码加密	
		//$_POST['user_password_confirm'] && $_POST['user_password_confirm'] = md5($_POST['user_password_confirm']);	// 密码加密	
		//$_POST['create_time']   = date("Y-m-d H:i:s");			// 账号创建时间
		$this->filterPost();
		
	}	
    /// 修改前置操作	
	public function _before_update() {
		$this->filterPost();
	}
	
	////编辑前过滤post数据
	private function filterPost(){
		$_POST['user_name'] = trim($_POST['user_name']);
	}




	/// 重置密码	
	public function resetPasswd() {
		if (isset($_POST['user_password'])) {
			if(empty($_POST['user_password'])){
				$this->error(array('name'=>'user_password','value'=>L('require')),2);
				exit;
			}
			$name  = $this->getActionName();
			$model = D($name); 
			if(!$model->regex($_POST['user_password'],'user_passpord')){
				$this->error(array('name'=>'user_password','value'=>L('valid_password')),2);
				exit;
			}
			if ($_POST['user_password_confirm']!=$_POST['user_password']) {
				$this->error(array('name'=>'user_password_confirm','value'=>L('password_input_val_neq')),2);
				exit;
			}
			D('User')->resetPasswd(intval($_POST['id']),$_POST['user_password']);
			$this->id = intval($_POST['id']);
			$this->success(L('success_reset_password'));
			exit;
		}
		$this->rs = M('User')->find($_GET['id']);
		$this->display();			
	}
	
	/// 超管帐号管理
	public function service(){
		$rs = M('User')->getByIsSuperAdmin("1");
		$this->assign('rs',$rs);
		$this->display();
	}
    
	/// 更新超管帐号信息
	public function updateService(){
		$rs = M('User')->getByIsSuperAdmin("1");
		M('User')->setField(array('id'=>$rs['id'],'to_hide'=>intval($_POST['to_hide'])));
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
	
	/// 设置显示样式
    public function setFormat() {    	
    	$this->rs = M('User')->field('id,digital_format,user_name')->find(getUser('id'));	
    	$this->display();
    }
    
     /// 保存显示样式
     public function updateFormat() {
     	M('User')->where('id='.getUser('id'))->setField('digital_format',$_POST['digital_format']);
     	getUser('digital_format',$_POST['digital_format']);
   		$this->success(L('_OPERATION_SUCCESS_'));
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
		
		$count  = $model->where('id='.$id.' and user_type='.C('SELLER_ROLE_TYPE'))->count(); ///总个数
		if(intval($count)>0){
			throw_json(L('seller_cant_delete'));
		}

    	///还原特殊处理 mingxing 
    	if ($_GET['restore']==1){
    		$this->restore();
    	}else{
	    	
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
}
?>