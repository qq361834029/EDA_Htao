<?php

class OtherAction extends CommonAction {
	
	 // 客服管理
    public function service(){
    	$array = M('Service')->select();
    	foreach ((array)$array as $value) {
    		$rs[$value['name']] = $value['value'];
    	}
    	$this->assign('rs',$rs);
    	$this->display();
    }
    // 保存客服管理
    public function saveService(){
    	unset($_POST['__hash__']);
    	M('Service')->where("id>0")->delete();
    	foreach ($_POST as $key => $value) {
    		M('Service')->add(array('name'=>$key,'value'=>$value));
    	}
    	redirect('service',2,'保存成功，2秒后跳转');
    }
	
	public function updateConfig(){
		F('_tables',NULL);	// 删除文件缓存
		D('Admin')->updateConfig();
		D('Admin')->saveExcelAry();
	}
	
	public function updateDd(){
		S('API_DATA_DIGEST', null);//API数据签名缓存
		D('Cache')->updateCache();
	}
	
	public function updateEbay(){
		import("ORG.Util.EbayToken"); 
		//Ebay生成认证和计划任务
		$EbayToken = new ModelEbayToken();
		$EbayToken->updateEbayCache();	
	}
	
	public function updateRuntime(){
		D('Cache')->deleteRuntimeFiles();		
	}
	
	public function updateExcelTemplete(){
		$data 	= include(ADMIN_RUNTIME_PATH . '~ExcelTemplete.php');
		foreach ((array)$data as $key=>$value){
			$this->saveTemplete($key);
		}
	}
	
	public function updateLang(){
		$model	= D('Lang');
		$model->deleteFile();
		$model->updateFile();		
	}
	
	public function updateMenu() {
		RBAC::getUserMenu($_SESSION[C('USER_AUTH_KEY')],1);
		S('menu_title', null);//在title函数中定义此缓存
	}

	public function updateCache(){
    	switch ($_GET['type']){
    		case 'config':
				$this->updateConfig();
    			break;
    		case 'dd':
    			$this->updateDd();
    			break;
			case 'ebay':
				$this->updateEbay();
    			break;
    		case 'runtime':
    			$this->updateRuntime();
    			break;
    		case 'excel':
				$this->updateExcelTemplete();
    			break;
    		case 'lang':
				$this->updateLang();
    			break;
			case 'menu':
				$this->updateMenu();
    			break;
    		default:
				$this->updateConfig();
				$this->updateDd();
//				$this->updateEbay();
				$this->updateRuntime();
				$this->updateExcelTemplete();
				$this->updateLang();
    			$this->updateMenu();
    			break;
    	}
		redirect(__URL__.'/cache', 5, '更新成功，5秒后跳转！');
    }
    
    // 导入模版
    public function importTemp(){
    	$data = include(ADMIN_RUNTIME_PATH.'~ExcelTemplete.php');
		asort($data);
		$this->list	= $data;
		$this->display('excelTemplate');
    }
    
    // 生成所有模板文件
    public function saveTempleteAll() {
		$data 	= include(ADMIN_RUNTIME_PATH.'~ExcelTemplete.php');
		foreach ((array)$data as $key=>$value){
			$this->saveTemplete($key);
		}
		redirect('importTemp',2,'保存成功，2秒后跳转');
	}
	
	// 生成指定模板文件
	public function saveTemplete($filename=null) {
		empty($filename) && $filename = trim($_GET['key']);
		if(empty($filename)) return false;
		unset($_GET['key']);
		$data = include(ADMIN_RUNTIME_PATH.'~ExcelTemplete.php');
		$data = $data[$filename];
		$model= D('Admin');
		$model->saveTemplete($data,$filename);
		if(ACTION_NAME=='saveTemplete'){
			redirect(__URL__.'/importTemp',2,'保存成功，2秒后跳转');
		}
	}
	
	// 系统数据初始化
	public function resetRole(){
		if ($_GET['update']) {
			$exec = include(THINK_PATH.'Conf/sqlInit.php');
			foreach ($exec as $sql) {
				M()->execute($sql);
			}
			if (C('product_color')==2) {
				M()->execute("INSERT INTO `access` (`id`, `role_id`, `node_id`, `data_rights`) VALUES (14, 2, 340, NULL),(15, 2, 341, NULL);");
			}
			if(C('product_size')==2){
				M()->execute("INSERT INTO `access` (`id`, `role_id`, `node_id`, `data_rights`) VALUES (19, 2, 343, NULL),(20, 2, 344, NULL);");
			}
			exit('初始化成功');
		}else {
			$this->display();
		}
	}
	/// 语言包管理
	public function langConfig(){
		$model 	= D('Lang');      
		//格式化+获取列表信息  
		$opert	=	array('where'=>_search(),'sortBy'=>'module');  
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME; 
		$list	= _list($model,$opert,$_formatListKey);
		///assign
		$this->assign('list',$list);
		$this->display();
	}
	public function langAdd(){
		$this->display();
	}
	public function langInsert(){
		///获取当前模型
		$model 	= D('Lang');      
		///模型验证
		if (false === $model->create($_POST)) {  
			redirect(__URL__.'/langConfig',2,'保存失败，2秒后跳转');
		}    
		///保存POST信息->返回主表ID
		$id		=	$model->add($_POST); 
		if ($id!==false) { ///保存成功 
			$model->updateFile("and module='".$_POST['module']."'");
			redirect(__URL__.'/langConfig',2,'保存成功，2秒后跳转');
		} else { 
			///失败提示  
			redirect(__URL__.'/langConfig',2,'保存失败，2秒后跳转');
		}   
	}
	public function langEdit(){
		$id	= intval($_GET['id']);
		$rs	= D('Lang')->getInfo($id);
		$this->assign('rs',$rs);
		$this->display();
	}
	public function langUpdate(){
		$model	= D('Lang');
		$id 	= 	intval($_POST['id']); 
		if (false === $model->create ($_POST)) {
			redirect(__URL__.'/langConfig',2,'保存失败，2秒后跳转');
		} 
		$list	=	$model->save(); 
		///更新修改模块语言包
		$model->updateFile("and module='".$_POST['module']."'");
		redirect(__URL__.'/langConfig',2,'保存成功，2秒后跳转');
	}
	public function langDelete(){
		$model	= D('Lang');
		$id 	= 	intval($_GET['id']);
		try{
			$model->where('id='.$id)->delete();
			redirect(__URL__.'/langConfig',2,'保存成功，2秒后跳转');
		}catch (Exception $e){
			redirect(__URL__.'/langConfig',2,'保存失败，2秒后跳转');
		}
	}
}