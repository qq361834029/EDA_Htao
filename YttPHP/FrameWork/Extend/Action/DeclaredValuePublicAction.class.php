<?php 

/**
 * 批量修改申报价值
 * @category   	申报价值
 * @package  	Action
 * @author    	YYH
 * @version 	20141106
*/

class DeclaredValuePublicAction extends RelationCommonAction {
	public function __construct() { 
    	parent::__construct();
    	if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {//角色类型为卖家类型
			$factory_id = intval(getUser('company_id'));
		}
        $_POST['factory_id']    = $factory_id;
        $this->assign('factory_id',$factory_id);
	}
}
?>