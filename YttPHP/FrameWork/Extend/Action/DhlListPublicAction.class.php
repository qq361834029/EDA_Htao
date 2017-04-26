<?php  
/**
 * DHL 请求队列列表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2016-05-25
 */
class DhlListPublicAction extends CommonAction {
	protected $_default_where 	=  '';  	///默认查询条件=>例子$_default_where	=  'parent_id<>0';  
	protected $_default_post 	=  array(); ///默认post条件=>例子protected $_default_post	=  array('query'=>array('to_hide'=>1));
	protected $_view_model 		=  false;	///false 自身关联 否者关联getActionName+'View'

	public function __construct() {
		parent::__construct();
		$user	= getUser();
		if ($user['role_type']==C('SELLER_ROLE_TYPE')) {
			$_POST['sale_order']['query']['sale_order.factory_id']   = intval($user['company_id']);
			if ($user['company_id'] > 0) {
				$this->assign("fac_id", $user['company_id']);
				$this->assign("fac_name", SOnly('factory', $user['company_id'], 'factory_name'));
			}	
		}elseif ($user['role_type']==C('WAREHOUSE_ROLE_TYPE')) {
			$_POST['sale_order']['query']['warehouse_id'] = intval($user['company_id']);
			if ($user['company_id'] > 0) {
				$this->assign("w_id", $user['company_id']);
				$this->assign("warehouse_id", $user['company_id']);
				$this->assign("w_name", SOnly('warehouse', $user['company_id'], 'w_name'));
			}
		}
	}

	public function requestList(){
 		///获取当前模型
    	$model 	= $this->getModel();
    	///格式化+获取列表信息
    	$this->list	= $model->index();
		$this->displayIndex();
	}

	public function request(){
		if ($_GET['dhl_list_id'] > 0) {
			try {
				express_api_load_file('Dhl');
				$result	= dhl_process_request($_GET['request_type']);
				if (is_object($result)) {
					$error	= $result->getError();
					if (!empty($error)) {
						$this->error(implode("<br />", $error));
					} else {
						$module			= $this->getActionName();
						$action			= 'index';
						$ajax			= array(
							'status'	=> 1,
							'href'		=> U('/' . $module . '/' . $action),
							'title'		=> title($action, $module),
						);
						$this->success(L('_OPERATION_SUCCESS_'), '', $ajax);
					}
				} else {
					$this->error(L('_RECORD_HAS_UPDATE_'));
				}
			} catch (Exception $ex) {
				$ajax	= array(
					'code'	=> $ex->getCode(),
					'msg'	=> $ex->getMessage(),
				);
				$this->error(L('_OPERATION_WRONG_'), 0, '', $ajax);
			}
		} else {
			$this->error(L('_DATA_TYPE_INVALID_'));
		}
	}
}
?>