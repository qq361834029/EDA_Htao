<?php 

/**
 * 库存调整
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	库存调整
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class ShiftWarehousePublicAction extends RelationCommonAction {
	public function __construct() { 
    	parent::__construct(); 
		$userInfo	=	getUser();
		if ($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){//仓储
			$w_id	= intval($userInfo['company_id']);
            $is_sold    = M('warehouse')->where('id='.$w_id)->getField('is_return_sold');
            if($is_sold != C('NO_RETURN_SOLD')){
                $relation_warehouse = M('warehouse')->where('is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id='.$w_id)->getField('id',true);
            }
            $relation_warehouse[]   = $w_id;
			$_POST['detail']['in']['out_warehouse_id'] = $relation_warehouse;
			if ($w_id > 0) {
				$this->assign("w_id", $w_id);
				$this->assign("w_name", SOnly('warehouse',$w_id, 'w_name'));		
			}				
		}
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
	}
}
?>