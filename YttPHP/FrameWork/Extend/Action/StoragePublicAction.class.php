<?php 

/**
 * 实际库存管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	实际库存
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class StoragePublicAction extends CommonAction {

    public function _before_index(){
		getOutPutRand();
		$userInfo	=	getUser(); 
		if ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {//卖家
			$_POST['query']['p.factory_id'] = intval($userInfo['company_id']);
			$this->is_factory		= true;
		} elseif ($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){//仓储
            $no_sold_storage        = M('warehouse')->where('is_return_sold='.C('NO_RETURN_SOLD'))->getField('id',true);
            if(!empty($_POST['query']['warehouse_id']) && !in_array($_POST['query']['warehouse_id'], $no_sold_storage)){
                $_POST['query']['warehouse_id'] = intval($userInfo['company_id']);
            }
			
			$this->is_warehouser	= true;			
		}		
	}	
	
	/// 实际库存列表
	public function index(){
		if ($_POST['search_form']) {
            $this->list = D('StorageShow')->getProductStorage();
            if($this->list['list'][0]['is_return_sold'] == C('CAN_RETURN_SOLD')){
                $is_return_sold = 'RealStorage';
            }else{
                $is_return_sold = 'ReturnStorage';
            }
            $this->assign('is_return_sold',$is_return_sold);
			$this->display('list');
		}else {
			$this->display();
		}
	}
	
	/// 多个产品库存
	public function multiStorage(){
		$this->display();
	}
    
}
?>