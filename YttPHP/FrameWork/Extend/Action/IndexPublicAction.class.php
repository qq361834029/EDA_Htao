<?php
// 本类由系统自动生成，仅供测试用途
class IndexPublicAction extends CommonAction {
    public function index(){
    	C('SHOW_PAGE_TRACE',false);
    	import('ORG.Util.RBAC');
    	$menu = RBAC::getUserMenu($_SESSION[C('USER_AUTH_KEY')]);
    	$this->assign('menu',$menu);
    	$this->display();
    }
    
}