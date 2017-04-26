<?php 
/**
 * 卖家员工管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	卖家信息
 * @package  	Action
 * @author    	
 * @version 	2014/1/15 16:04:03
 */

class SellerStaffPublicAction extends BasicCommonAction {
 	/// 默认post值处理
	protected $_default_post	=  array('query'=>array('to_hide'=>1));  
	
	/// 默认查询条件
	protected $_default_where	= 'super_admin!=1 and user_type=3';
	
    public $_view_dir 			= 'SellerStaff';	/// 定义模板显示路径
    //protected $_cacheDd 		= array(17); 
	protected $_user_type		= 3;				///1：公司，2：卖家，3：卖家员工
	
	protected $belongsWhereField	= 'company_id';//added by jp 20140724

	public function __construct() { 
    	parent::__construct(); 
    	if(intval($_GET['company_id'])>0){
			$_POST['query']['company_id'] = $_GET['company_id'];
			$this->assign("fac_id", $_GET['company_id']);
			$this->assign("fac_name", SOnly('factory',$_GET['company_id'], 'factory_name'));					
		}
    }

	public function add() {
		$userInfo = getUser(); 
		if ($userInfo['company_id']>0) {
			$this->assign("fac_id", $userInfo['company_id']);
			$this->assign("fac_name", SOnly('factory',$userInfo['company_id'], 'factory_name'));		
		}		
    }

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
	
	/// 新增前置操作	
	public function _before_insert() {
		//$_POST['user_password'] && $_POST['user_password'] 		= md5($_POST['user_password']);	// 密码加密	
		//$_POST['user_password_confirm'] && $_POST['user_password_confirm'] = md5($_POST['user_password_confirm']);	// 密码加密	
		$_POST['create_time']   = date("Y-m-d H:i:s");			// 账号创建时间
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
		$this->display (); 
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
		///所属卖家未启用所属的员工不允许设置启用状态
		if(intval($_POST['company_id'])>0){
			$Factory = D('Factory'); ;
			$to_hide  = $Factory->where('id='.$_POST['company_id'])->getField('to_hide');	
			if($to_hide==2&&$_POST['to_hide']!=$to_hide){
				$this->error (L('sellerstaff_unable'));
			}
		}
		///更新数据
		$list = $model->save($_POST); 	
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
		$model = D('Factory'); 
		$sql   = 'select id from company
				  where to_hide=1 and comp_type=1';
		$list  = $model->query($sql);
		if($list){
			foreach($list as $k=>$v){
				$company_list[$v['id']] = $v['id'];
			}
			if($company_list){
				$this->_default_where .= ' and company_id in('.implode(',', $company_list).')';
			}
		}
		$model = D('SellerStaff');      
		$opert = array('where'=>_search($this->_default_where,$this->_default_post));
		$list  = $this->_listAndFormat($model,$opert);
		
		//获取最后登录时间 st
		if ($list['list']) {
			/*
			foreach ((array)$list['list'] as $key=>$val) {
				$company[$val['company_id']]	= $val['company_id'];
			}
			//已添加产品的卖家禁止删除
			$productModel = M('Product');
			//已添加产品的卖家
			$factoryids = array();
			$factoryids = $productModel->group('factory_id')->where('factory_id in (' . implode(',', $company) . ')')->getField('id,factory_id');
			*/
			import("ORG.Util.Date");
			$dateModel	= new Date();
			$userModel	= M('User');
			foreach ((array)$list['list'] as $key=>$val) {
				//$list['list'][$key]['is_del'] = in_array($val['company_id'], $factoryids)?0:1;
				//是否启用
				$list['list'][$key]['is_enable'] = $val['to_hide']==1?0:1;
				$list['list'][$key]['last_login_time'] = $list['list'][$key]['last_login_time'] > 0 ? $dateModel->getFormat($list['list'][$key]['last_login_time']) : 'N/A';
			}		
			unset($userModel);
		}
		//获取最后登录时间 ed

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
    
	/******启用设置*****/
	public function setEnable(){
		$name    = $this->getActionName();
		$model   = D($name);   
		$pk	     = $model->getPk ();
		$id      = intval($_REQUEST[$pk]);
		$to_hide = intval($_REQUEST['to_hide']);
		if ($id>0) { 
			//设置卖家员工
			$condition = $pk.'='.$id; 
			$list      = $model->where($condition)->setField('to_hide',$to_hide);  
			$this->id  = $id;
			///如果操作失败提示错误
			if ($list==false) {
				$this->error(L('_OPERATION_WRONG_'));
			}
			$this->success(L('_OPERATION_SUCCESS_')); 
		}else{
			$this->error(L('_ERROR_'));
		} 
	}
	/******启用设置*****/

	/**********物理删除**********/
	///物理删除
    public function delete(){ 
		$name  = $this->getActionName();
		$model = D($name);   
		///当前主键
		$pk	   = $model->getPk ();
		$id    = intval($_REQUEST[$pk]);
		if ($id>0) { 
			//删除卖家员工
			$condition 	= $pk.'='.$id; 
			$list	    = $model->where($condition)->delete();   
			$this->id   = $id;
			///如果删除操作失败提示错误
			if ($list==false) {
				$this->error(L('data_right_del_error'));
			}
		}else{
			$this->error(L('_ERROR_'));
		} 
    }    
	/**********物理删除***********/
    
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
			$userModel	= D('User');
			$userModel->resetPasswd($_POST['id'],$_POST['user_password']);
			$this->id = $userModel->where('id='.(int)$_POST['id'])->getField('company_id');
			$this->success(L('success_reset_password'));
			exit;
		}
		$this->rs = $this->getUserInfo($_GET['id']);
		$this->display();			
	}	
	
	public function getUserInfo($id, $field = null) {
		$user_info = M('User')->where('id=' . (int)$id . getBelongsWhere('', 'company_id') . ' and user_type=' . (int)$this->_user_type)->find();
		if (is_string($field)) {
			return $user_info[$field];
		} else {
			return $user_info;
		}
	}


	public function _before_index(){
  		getOutPutRand();
  	}	
}