<?php

class CommonAction extends Action {
	
	// 检测是否存在超管权限
	function _initialize() {
		// 用户权限检查
		if (!$_SESSION [C('SUPER_ADMIN_AUTH_KEY')]) {
			 redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
		}
		// 获取指定模块的默认值
		$this->rs = D('Admin')->getModuleConf(ACTION_NAME);
	}
	
	// 保存配置
    public function save(){
    	$config_type = $_POST['config_type']; 
    	if($config_type=='common') D('Admin')->updateCurrency($_POST);
    	D('Admin')->saveConfig();
    	redirect($config_type,2,'保存成功，2秒后跳转');
    }
}