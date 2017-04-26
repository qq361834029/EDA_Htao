<?php  

class SaleOrderImportPublicAction extends RelationCommonAction {

	public function __construct(){
		parent::__construct(); 
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) { 
			if (getUser('company_id') > 0) {
				$this->assign("fac_id", getUser('company_id'));
				$this->assign("fac_name", SOnly('factory',getUser('company_id'), 'factory_name'));		
			}	
		}elseif (getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')) { 
			if (getUser('company_id') > 0) {
				$this->assign("warehouse_id", getUser('company_id'));
				$this->assign("w_name", SOnly('warehouse',getUser('company_id'), 'w_name'));		
			}	
		}
	}
	
	/**
	 * 后置操作
	 *
	 * @param array $info
	 * @param string $action_name
	 * @return array
	 */
	function _after_update(){
		if (in_array(ACTION_NAME,array('insert','update'))) {
			//暂时取消令牌验证
			C('TOKEN_ON',false);
			$client_info	   = $_POST['addition'][1];
			$client_info['id'] = $_POST['client_id'];
			$client			   = M('Client');
			///更新客户的资料
			///模型验证
			if (false === $client->create ($client_info)) {
				$this->error ( $client->getError (),$client->errorStatus);
			} 
			///更新数据
			$list	=	$client->save();
			if(false === $list){
				$this->error (L('_ERROR_'));
			}
		}
		if($_POST['from_type']=='out_stock'){
			$this->success(L('_OPERATION_SUCCESS_'),'',array('status'=>1,'href'=>U('/SaleOrder/outStock'),'title'=>title('outStock','SaleOrder'))); 
		}else{
			$this->success(L('_OPERATION_SUCCESS_')); 
		}
	}

	public function _before_index(){
		getOutPutRand();
	}

	//列表
	public function _autoIndex($temp_file=null) { 
		if (empty($temp_file)){ 
			$temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;  
		}  
		$this->display($temp_file);
	}
}
?>