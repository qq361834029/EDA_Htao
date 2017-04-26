<?php

/**
 * Ebay账号信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class EbayAccountPublicAction extends RelationCommonAction {

	public function _before_index(){
		getOutPutRand();
	}
	
	///新增
	public function add() {
		$userInfo	=	getUser(); 
		if ($userInfo['company_id'] > 0) {
			$this->assign("fac_id", $userInfo['company_id']);
			$this->assign("fac_name", SOnly('factory',$userInfo['company_id'], 'factory_name'));		
		}
		//国家名称
		$attr_country  = S("country"); 
		foreach ($attr_country as $id => $val){
			$country[] = array('id' => $id, "name" => $val['abbr_district_name'].'-'.$val['district_name']);
		} 
		$country	   = json_encode($country);
		$this->assign("country", $country);
	}

	public function edit(){
		///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);   
		///模型ID
		$id 	= 	intval($_REQUEST[$model->getPk()]);  
		if ($id>0) {
			$vo = _formatArray($model->getInfo($id),$this->_default_format);
			///如果查询结果是空提示错误 
			if (!is_array($vo)) {
				exit(L('data_right_error'));
			} 
			$this->rs	=	$vo; 
			$model->cacheLockVersion($vo);
		}else {
			$this->error(L('_ERROR_'));
		}
		//国家名称
		$attr_country  = S("country"); 
		foreach ($attr_country as $id => $val){
			$country[] = array('id' => $id, "name" => $val['abbr_district_name'].'-'.$val['district_name']);
		} 
		$country	   = json_encode($country);
		$this->assign("country", $country); 
		//$this->display();
	}


	///插入
	public function _after_insert() {    
		$this->saveAfter();
		parent::_after_insert();
	}

	public function _after_update(){
		$this->saveAfter();
		parent::_after_update();
	}

	public function saveAfter(){
		///主表ID
		$name   = $this->getActionName();
		$model 	= D($name);
		//$userdata   = $model->find($model->id);
		//if($userdata['to_hide']==1){
			import("ORG.Util.EbayToken"); 
			//Ebay生成认证和计划任务
			$EbayToken = new ModelEbayToken($_POST['user_id'],$_POST['site_id']);
			$EbayToken->createEbayFile($_POST['token']);
			//同步数据执行下列判断
			if($_POST['synchrodata']=='1'){
				$EbayToken->createEbaySystemTasksFile();
			}else{
				$EbayToken->delEbaySystemTasksFile();
			}
			unset($EbayToken);
		//}
	}

	///列表
	public function index() {
		$name	= $this->getActionName();
		$model 	= D($name);
		$opert	= array('where'=>_search($this->_default_where,$this->_default_post));
		$list	= $this->_listAndFormat($model,$opert);
		if(is_array($list['list'])&&$list['list']){
			$cache_site = S('SiteDetails');
			foreach($list['list'] as $k=>$v){
				$list['list'][$k]['synchrodata']  = $v['synchrodata']==0?L('manul'):L('auto');
				$list['list'][$k]['site']         = $cache_site[$v['site_id']];
				$list['list'][$k]['token_status'] = $v['token_status']==0?L('no_auth'):($v['token_status']==1?L('yes_auth'):L('fail_auth'));
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
				$userdata = $model->find($id);
				if($userdata['user_id']&&$userdata['site_id']){
					import("ORG.Util.EbayToken"); 
					$EbayToken = new ModelEbayToken($userdata['user_id'],$userdata['site_id']);
					$EbayToken->deleteFile();
				}
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
			//删除认证文件
			$userdata  = $model->find($id);
			if($userdata['user_id']&&$userdata['site_id']){
				import("ORG.Util.EbayToken"); 
				$EbayToken = new ModelEbayToken($userdata['user_id'],$userdata['site_id']);
				$EbayToken->createEbayFile($userdata['token']);
				if($userdata['synchrodata']=='1'){
					$EbayToken->createEbaySystemTasksFile();
				}else{
					$EbayToken->delEbaySystemTasksFile();
				}
			}
		}else{ 
			$this->error(L('_ERROR_'));
		} 
    }   
	
	/// 获取token值	
	public function getEbayToken() {
		$name  = $this->getActionName();
		$model = D($name);
		if (isset($_POST['id'])) {
			if(empty($_POST['SessionID'])){
				$error_array[] = array('name'=>'SessionID','value'=>L('requir_sessionid'));
			}
			if(empty($_POST['token'])){
				$error_array[] = array('name'=>'token','value'=>L('requir_token'));
			}
			if(empty($_POST['expiration_time'])) {
				$error_array[] = array('name'=>'expiration_time','value'=>L('requir_token'));
			}
			if(is_array($error_array)&&$error_array){
				$this->error($error_array,2);
			}
			$id       = intval($_POST['id']);
			$userdata = $model->find($id);
			if($userdata['user_id']&&$userdata['site_id']){
				if($userdata['site_id']){
					//获取链接
					$cache_URLDetails = S('URLDetails'.$userdata['site_id']);
					//查询地址
					$site_domain      = trim($cache_URLDetails['ViewItemURL']);
					//评价地址
					$feedback_url     = trim($cache_URLDetails['ViewUserURL']);
				}
				$token			      = trim($_POST['token']);
				$expiration_time      = trim($_POST['expiration_time']);

				$sql  = 'update ebay_site 
						 set token="'.$token.'",
							 expiration_time="'.$expiration_time.'",
							 site_domain="'.$site_domain.'",
							 feedback_url="'.$feedback_url.'",
							 token_status=1,
							 to_hide=1
						 where id='.$id;  
				$model->execute($sql);   
	
				import("ORG.Util.EbayToken"); 
				$EbayToken = new ModelEbayToken($userdata['user_id'],$userdata['site_id']);
				$EbayToken->createEbayFile($token);

				//同步数据执行下列判断
				if($userdata['synchrodata']=='1'){
					$EbayToken->createEbaySystemTasksFile();
				}else{
					$EbayToken->delEbaySystemTasksFile();
				}
				unset($EbayToken);
				
				$this->id = $id;
				$this->success(L('_OPERATION_SUCCESS_')); 
				exit;
			}else{
				$this->error(L('_OPERATION_FAIL_'));
				exit;
			}
		}
		$this->rs = $model->getInfo($_GET['id']);
		$this->display();			
	}	
}