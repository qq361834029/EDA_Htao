<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

class PublicAction extends PublicPublicAction {
	

	// 登录检测
	public function checkLogin() {
		if(empty($_POST['user_name'])) {
			$this->error(L('login_failed'));
		}elseif (empty($_POST['password'])){
			$this->error(L('login_failed'));
		}
        //生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['user_name']	= $_POST['user_name'];
		$map['super_admin']	= 1;
        $map["to_hide"]		= array('ELT',1);
        $authInfo = RBAC::authenticate($map);
        //使用用户名、密码和状态的方式进行认证
        if(empty($authInfo)) {
            $this->error(L('login_failed_state'));
        }elseif ($authInfo['user_password'] != md5($_POST['password'])){
        	$this->error(L('login_failed'));
        }else {
        	$ip = trim($authInfo['user_ip']);
            if(!empty($ip)) {
            	if(!RBAC::authip($authInfo['user_ip'])){
            		$this->error(L('login_failed_ip'));
            	}
            }
          	D('User')->loginUserInfo($authInfo);
			// 缓存访问权限
            RBAC::saveAccessList($authInfo['id']);
			$this->success(L('login_success'));

		}
	}
	 
}
?>