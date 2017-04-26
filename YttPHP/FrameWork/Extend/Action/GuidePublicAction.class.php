<?php 

/**
 * 向导
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class GuidePublicAction extends Action {
	
	public function index(){
		$user	= getUser();
		$rights	= array_change_key_case(RBAC::getAccessList($user['id']));
		foreach($rights as &$val){
			$val=array_change_key_case($val);
		}
		$this->assign('admin_auth_key',$_SESSION[C('ADMIN_AUTH_KEY')]);
		$this->assign('rights',$rights);  
		$this->display();
	}
	 
	
	
}
?>