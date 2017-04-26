<?php
class RolePublicBehavior extends Behavior {
	
	public function run(&$params){  
	} 
	
	public function edit($params){
		// 管理员没有修改限制
		if ($_SESSION[C('ADMIN_AUTH_KEY')]) {
			return true;
		}
		$rs = M('Role')->find($params['id']);
		if ($rs['status']>1) {
			throw_json(L('role_no_oper'));
		}
	}
	
	public function delete($params){
		$count = M('User')->where('role_id='.$params['id'])->count();
		if ($count>0) {
			throw_json(L('role_has_user'));
		}
		// 管理员没有删除限制
		if ($_SESSION[C('ADMIN_AUTH_KEY')]) {
			return true;
		}
		$rs = M('Role')->find($params['id']);
		if ($rs['status']>1) {
			throw_json(L('role_no_oper'));
		}
	}
	
	
}