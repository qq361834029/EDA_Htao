<?php  

class ProductImportPublicAction extends RelationCommonAction {

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