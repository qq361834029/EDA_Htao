<?php  
/**
 * Correos 请求队列列表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2016-10-21
 */
class CorreosListForSellerPublicAction extends CommonAction {
	protected $_default_where 	=  '';  	///默认查询条件=>例子$_default_where	=  'parent_id<>0';  
	protected $_default_post 	=  array(); ///默认post条件=>例子protected $_default_post	=  array('query'=>array('to_hide'=>1));
	protected $_view_model 		=  false;	///false 自身关联 否者关联getActionName+'View'

	public function __construct() {
		parent::__construct();
		$user	= getUser();
		if ($user['role_type']==C('SELLER_ROLE_TYPE')) {
			$_POST['sale_order']['query']['s.factory_id']   = intval($user['company_id']);
			if ($user['company_id'] > 0) {
				$this->assign("fac_id", $user['company_id']);
				$this->assign("fac_name", SOnly('factory', $user['company_id'], 'factory_name'));
			}	
		}elseif ($user['role_type']==C('WAREHOUSE_ROLE_TYPE')) {
			$_POST['sale_order']['query']['s.warehouse_id'] = intval($user['company_id']);
			if ($user['company_id'] > 0) {
				$this->assign("w_id", $user['company_id']);
				$this->assign("warehouse_id", $user['company_id']);
				$this->assign("w_name", SOnly('warehouse', $user['company_id'], 'w_name'));
			}
		}
	}
}
?>