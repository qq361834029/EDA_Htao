<?php 

/**
 * 卖家信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     jph
 * @version  2.1,2014-01-16
 */

class FactoryPublicAction extends RelationCommonAction {
	///默认post值处理
	protected $_default_post	=  array('query'=>array('to_hide'=>1)); 
	///默认where条件 
  	protected $_default_where	=  'comp_type=1'; 
  	///自动编号  
	public $_setauto_cache		= 'setauto_factory_no';
	///编号对应超管配置中的值
	public $_auto_no_name		= 'comp_no';
	///需要更新的缓存字典 

  	protected 	$_cacheDd		=  array(12,13); 
	
	protected $_user_type		= 2;//1：公司，2：卖家，3：卖家员工
	public function __construct() {
        parent::__construct();
        if(isset($_POST['company_factory'][1]['is_warehouse_fee']) && $_POST['company_factory'][1]['is_warehouse_fee']<=0){
            $_POST['company_factory'][1]['warehouse_fee_start_date'] = '0000-00-00';
        }
        if(in_array(ACTION_NAME, array('update','updateSetting'))){
            $count  = M('warehouse_account')->where('factory_id='.intval($_POST['id']))->count();
            if($count > 0){
//                unset($_POST['company_factory'][1]['warehouse_fee_start_date']);
            }
        }
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
    }

	public function _before_index(){
  		getOutPutRand();
  	}
	public function add(){
		$this->clientCurrency();
	}

	public function clientCurrency(){
		///模型ID
		$client_currency      = M('Currency')->where('id in (' . C('CLIENT_CURRENCY') . ')')->getField('id, lower(currency_no) as currency_no');
		$this->assign('client_currency',$client_currency);
	}

	 public function view(){     
    	///获取当前Action名称
	 	$name = $this->getActionName(); 
 		///获取当前模型
		$model 	= D($name);   
    	///主表ID
		$id 	= 	intval($_REQUEST[$model->getPk()]);
		$this->clientCurrency();
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
   
    ///列表
	public function index() {	
		///获取当前Action名称
	 	$name = $this->getActionName();
	 	if ($this->_view_model===true){
	 		$name	=	$name.'View';
	 	}  	
 		///获取当前模型
		$model 	= 	D($name);
		if (isset($_GET['to_hide'])) {
			$_POST['query']['to_hide']	= $_GET['to_hide'];
		}
		///条件
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post),'sortBy'=>$this->_sortBy);
		///格式化+获取列表信息     
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME; 
		$list	= $this->_listAndFormat($model,$opert,$_formatListKey);
		if (in_array(MODULE_NAME, C('MERGE_ADDRESS_MODULE'))) {//added by jp 20140115
			_mergeAddress($list);
		}
		//获取最后登录时间 st
		if ($list['list']) {
			foreach ((array)$list['list'] as $key=>$val) {
				$company[]	= $val['id'];
			}
			import("ORG.Util.Date");
			$dateModel	= new Date();
			//已添加产品的卖家禁止删除
			$productModel = M('Product');
			//已添加产品的卖家
			$factoryids = array();
			$factoryids = $productModel->group('factory_id')->where('factory_id in (' . implode(',', $company) . ')')->getField('id,factory_id');

			$userModel	= M('User');
			$rs	= $userModel->where('user_type=' . (int)$this->_user_type . ' and company_id in (' . implode(',', $company) . ')')->getField('company_id,user_name,role_id,last_login_time,create_time');
			$warehouse_data = M('express_discount')->alias('e')->join('left join warehouse as w on e.warehouse_id=w.id')->where('factory_id in (' . implode(',', $company) . ')')->order('factory_id desc')->group('factory_id')->getField('factory_id as id,group_concat(distinct w.w_no) as s_w_no');
			foreach ((array)$list['list'] as $key=>$val) {
				//是否启用
				$list['list'][$key]['is_enable'] = $val['to_hide']==1?0:1;
				$list['list'][$key]['is_del'] = ($val['to_hide']==2||in_array($val['id'], $factoryids))?0:1;
				$list['list'][$key]	= array_merge($rs[$val['id']],$list['list'][$key]);
				$list['list'][$key]['role_name']	= SOnly('role', $list['list'][$key]['role_id'], 'role_name');
				$list['list'][$key]['fmd_last_login_time']	= $list['list'][$key]['last_login_time'] > 0 ? $dateModel->getFormat($list['list'][$key]['last_login_time']) : 'N/A';
				if(isset($warehouse_data[$val['id']])){
					$list['list'][$key]['enabled_warehouse'] =   $warehouse_data[$val['id']];
				}
			}
			unset($rs,$userModel);
		}
		//获取最后登录时间 ed
		$this->assign('list',$list);
		$this->displayIndex();
	}	
	
	public function setPost() {
		$_POST['user_name']								= $_POST['email'];
		$_POST['real_name']								= $_POST['comp_name'];
		$_POST['comments']								= $_POST['user_comments'];
		$_POST['user_id'] && $_POST[D('User')->getPk()]	= $_POST['user_id'];
	}	
	
	public function setPostDiscount() {
		$discount_fields	= array('express_discount', 'package_discount', 'process_discount');
		foreach ($discount_fields as $discount) {
			(empty($_POST[$discount])||$_POST[$discount]=='0.00')&&$_POST[$discount] = 1;
		}
		//条形码配置
		if (ACTION_NAME == 'updateSetting') {
			if ($_POST['product_barcode_config']) {
				$cfg_factory_product_barcode_config	= C('CFG_FACTORY_PRODUCT_BARCODE_CONFIG');
				foreach ($_POST['product_barcode_config'] as $key => $caption) {
					if (!isset($cfg_factory_product_barcode_config[$caption])) {
						unset($_POST['product_barcode_config'][$key]);
					}
				}
				$_POST['product_barcode_config']	= implode(',', $_POST['product_barcode_config']);
			} else {
				$_POST['product_barcode_config']	= '';
			}	
		}
        foreach($_POST['warehouse_fee'] as $warehouse_fee_detail){
            $is_max = $warehouse_fee_detail['end_days'];
        }
        if($is_max > 0){
            $max_detail['start_days']       =  ++$is_max;
            $max_detail['end_days']         = '';
            $max_detail['first_quarter']    = 0;
            $max_detail['second_quarter']   = 0;
            $max_detail['third_quarter']    = 0;
            $max_detail['fourth_quarter']   = 0;
            
            $_POST['warehouse_fee'][]       = $max_detail;
        }
	}		
	
	  ///插入
	public function insert() {    
		///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);  
		$error	= array();
		//邮箱唯一性空格过滤
		$_POST['email'] = trim($_POST['email']); 
		$this->setPostDiscount();
		///模型验证
		if (false === $model->create($_POST)) {  
			$error			= array_merge($error, $model->getError());
			$errorStatus	= $model->errorStatus;
		}    
		
		//账户信息处理及验证 st
		$userModel 	= D('User');  
		$userAction	= A('User');
		$this->setPost();
		if (method_exists($userAction, '_before_insert')) {
			$userAction->_before_insert();
		}
		$user_info	= $userModel->create($_POST);
		if (false === $user_info) {  
			$error			= array_merge($error, $userModel->getError());
			$errorStatus	= $userModel->errorStatus;
		}   
		//账户信息处理及验证 ed
		if (!empty($error)) {
			$this->error($error, $errorStatus);
		}		
		
		///保存POST信息->返回主表ID
        $id	= $model->relationInsert(); 
		if ($id!==false) { ///保存成功 
			$this->id	=	$id;
			if($_POST['tocken']){
				D('Gallery')->update($id,$_POST['tocken']);//更新产品图片关联信息
			}
			///生成字典
			if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 
			
			//保存账户信息 st
			$user_info['user_type']		= $this->_user_type;
			$user_info['company_id']	= $id;
			$user_id					=	$userModel->add($user_info);
			if ($user_id!==false) {///保存成功 
				$userAction->id	= $user_id;
				if (is_array($userAction->_cacheDd)) { $userAction->checkCacheDd($user_id); } 
			} else { ///失败提示 
				$this->error (L('_ERROR_'));
			}  
			//保存账户信息 ed
		} else { ///失败提示  
			$model->rollback();
			$this->error (L('_ERROR_'));
		}   
		
	}
	
    ///更新
	public function update($updateSetting = false) {
		///获取当前Action名称}
	 	$name = $this->getActionName();
        ///获取当前模型
		$model 	= D($name);   
		///主表ID
		$id 	= 	intval($_POST[$model->getPk()]); 
        if ($_POST['auth_token'] != session($id . 'ApiToken')) {
            $this->error(L('token_timeout'));
        }
		//邮箱唯一性空格过滤
		$_POST['email'] = trim($_POST['email']); 
		$this->setPostDiscount();	
		///模型验证
		if (false === $model->create($_POST)) {
			$this->error ( $model->getError (),$model->errorStatus);
		}
		//账户信息处理及验证 st
		$userAction				= A('User');
		$userModel				= D('User'); 	
		$_POST['company_id']	= $id;
		$this->setPost();
		if (method_exists($userAction, '_before_update')) {
			$userAction->_before_update();
		}		
		$user_info				= $userModel->create ($_POST);
		if (false === $user_info) {
			$this->error ( $userModel->getError (),$userModel->errorStatus);
		} 		
		//账户信息处理及验证 ed
        
        //是否需要重新生成产品条形码
		$needRegenerateProductBarcode	= $updateSetting == false ? false : M('Company')->where('id='.$id)->getField('product_barcode_config') != $_POST['product_barcode_config'];
				
		///更新数据	
		$list	=	$model->relationUpdate();
        if (false !== $list) {
            $this->id	=	$id;
            ///生成字典
            if (is_array($this->_cacheDd)) { $this->checkCacheDd(); } 	
            //更新账户信息 st
            $user_id	= intval($_POST[$userModel->getPk()]); 
            $list		= $userModel->save($_POST); 
			if (false !== $list) {
				$userAction->id	=	$user_id;
				///生成字典
				if (is_array($userAction->_cacheDd)) { $userAction->checkCacheDd(); } 
				if ($needRegenerateProductBarcode) {//重新生成产品条形码图片
					$this->regenerateProductBarcode($id);
				}
				//mod ljw-2015-07-17 判断前台是否有传来to_hide字段-start
				if(array_key_exists($_POST['to_hide'],C('IS_ENABLE'))){
					//更新所属卖家员工启用状态
					$userModel->where('company_id='.$id)->setField('to_hide',$_POST['to_hide']);
				}
				//mod ljw-2015-07-17 判断前台是否有传来to_hide字段-end
			} else { 
				$this->error (L('_ERROR_'));
			}	
			//更新账户信息 ed
		} else { 
			$this->error (L('_ERROR_'));
		}	
	}	 
	
	//作废或还原账户信息
	public function _before_delete(){ 
		$id 	= 	$id ? intval($id) : intval($_REQUEST['id']);		
		if ($id>0) { 
			$Product  = M('Product');
			$count    = $Product->where('factory_id='.$id)->count(); ///总个数
			if(intval($count)>0){
				throw_json(L('seller_exist_product'));
			}

			$condition 	= 'user_type=' . (int)$this->_user_type . ' and company_id='.$id;
			$list	=	D('User')->where($condition)->setField('to_hide',$_GET['restore']==1 ? 1 : 2);//$_GET['restore']==1 还原 else 作废
			///如果删除操作失败提示错误
			if ($list==false) {
				$this->error(L('data_right_del_error'));
			}
		}else{
			$this->error(L('_ERROR_'));
		} 
    }	
	
	/******启用设置*****/
	public function setEnable(){
		$name    = $this->getActionName();
		$model   = D($name);   
		$pk	     = $model->getPk ();
		$id      = intval($_REQUEST[$pk]);
		$to_hide = intval($_REQUEST['to_hide']);		 
		$create_time=date('Y-m-d H:i:s',time());		 
		if ($id>0) { 
                    $condition = $pk.'='.$id; 
                    //mod ljw-2015-07-20 判断是否有传来to_hide字段-start
                    if(array_key_exists($to_hide,C('IS_ENABLE'))){
                        //设置卖家
                        $list = $model->where($condition)->setField('to_hide',$to_hide);
                        if($list==false) {
                            //操作失败提示错误
                            $this->error(L('_OPERATION_WRONG_'));
                        }else{
                            $this->id  = $id;
                            //设置卖家员工
                            $userModel = D('User');                            
			    $data['to_hide'] = $to_hide;
			    $data['create_time'] = $create_time;			    
			    $userModel->where('company_id='.$id)->data($data)->save();
                            $this->success(L('_OPERATION_SUCCESS_'));
                        }
                    }else{
                        $this->error(L('_ERROR_'));
                    }
                    //mod ljw-2015-07-20 判断是否有传来to_hide字段-end    
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
			//删除卖家
			$condition 	= $pk.'='.$id; 
			$list	=	$model->where($condition)->delete();   
			//删除卖家员工
			$userModel = D('User');
			$userModel->where('company_id='.$id)->delete();
			$this->id  = $id;
			$model->relationDelete($this->id);
			///如果删除操作失败提示错误
			if ($list==false) {
				$this->error(L('data_right_del_error'));
			}
		}else{
			$this->error(L('_ERROR_'));
		} 
    }    
	/**********物理删除***********/

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
	
	public function getUserInfo($company_id, $field = null) {
		$user_info = M('User')->where('company_id=' . (int)$company_id . ' and user_type=' . (int)$this->_user_type)->find();
		if (is_string($field)) {
			return $user_info[$field];
		} else {
			return $user_info;
		}
	}
	
	public function setting() {
		$user	= getUser();
		if ($user['role_type'] != C('SELLER_ROLE_TYPE') || $user['company_id'] != $_REQUEST['id']) {
		   throw_json(L('_VALID_ACCESS_'));
		}
		$this->edit();	
		$this->display();
	}
	
	public function updateSetting(){
        unset($_POST['auth_status']);
		$this->update(true);
		$this->success(L('_OPERATION_SUCCESS_')); 
	}
	
	public function edit() {
		///自动补上编号
    	//$this->_autoMaxNo();
		///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);   
		///模型ID
		$this->clientCurrency();
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
            //添加APITOKEN缓存
            session($id.'ApiToken', $vo['auth_token']);
			$this->rs	=	$vo; 
			$model->cacheLockVersion($vo);
		}else {
			$this->error(L('_ERROR_'));
		}
	}  
	
	/**
	 * 重新生成产品条形码图片
	 * @author jph 20140910
	 * @param type $id 厂家id
	 */
	public function regenerateProductBarcode($id){
		//批量更新条形码
		$product_list	= M('Product')->where('factory_id='.$id)->getField('id,id,product_no,product_name,custom_barcode');
		if ($product_list) {
			$Action			= A('Product');
			foreach ($product_list as $product) {
				$Action->id	= $product['id'];
				$Action->generateBarcode($product['custom_barcode'], $product['product_no'], $product['product_name'], $_POST['product_barcode_config']);
			}
		}
	}
    public function updateApi() {
        if(!isset($_REQUEST['state'])){
            $token  = getApiToken();
            $data   = array('auth_token'=>$token);
        }else{
            $data   = array('auth_status'=>intval($_REQUEST['state']));
        }
		$id 	= 	intval($_REQUEST['id']);
		if ($id>0) { 
			$list		= M('company')->where('id='.$id)->setField($data);  
			$this->id	= $id;     
			///如果产品还原失败提示失败
			if ($list==false) { 
				$this->error(L('_ERROR_'));
			}			
		}else{ 
			$this->error(L('_ERROR_'));
		}
        $this->success(L('_OPERATION_SUCCESS_'));
    }

}