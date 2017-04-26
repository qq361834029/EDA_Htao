<?php

/**
 * 发票系统登陆
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceIndexPublicAction extends BasicCommonAction {
	  public function index(){
    	C('SHOW_PAGE_TRACE',false);
    	import('ORG.Util.RBAC');
    	addLang('index');
    	$menu = RBAC::getUserMenu($_SESSION[C('USER_AUTH_KEY')]);
    	$menu = D('InvoiceIndex')->getInvoice($menu);
    	$this->assign('menu',$menu);
    	$this->display();
    }
    
   
}