<?php 

/**
 * 库存调整
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	库存调整
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class WarehouseAccountPublicAction extends RelationCommonAction {
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
			$_POST['in']['warehouse_id'] = $relation_warehouse;
		}elseif ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {//卖家
			$_POST['query']['factory_id'] = intval($userInfo['company_id']);
//			$this->assign("is_factory", true);
		}
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
	}
    
    public function add(){
		if (intval($_GET['step']) == 2) {// 第二步时获取主表信息
            $rs         = D('WarehouseAccount')->warehouseAccountDetail();
            $this->rs   = $rs;
		}
    }
    
    public function insert() {
		ini_set('max_execution_time', 0);
		$_POST['account_end_date']	= formatDate($_POST['account_end_date']);
        if (intval($_POST['step']) == 2) {//下一步，输入产品明细信息
            parent::insert();
		}else{
            $name = $this->getActionName(); 
            $model 	= D($name);     
            ///模型验证
            if (false === $model->create($_POST)) {  
                $this->error ( $model->getError(),$model->errorStatus);
            }
            $model->_brf();
        }
    }
    
    public function _after_add() {
        if (intval($_GET['step']) == 2) {// 第二步时获取主表信息
            $this->display('checkAccount'); 
        }else{
            parent::_after_add();
        }
    }

    public function _after_insert(){
		if ($_POST['step'] == 1) {//下一步，输入产品明细信息
            $rand   = 'account_'.md5(time());
            S($rand,$_POST);
			$url	= U(MODULE_NAME.'/add','rand='.$rand.'&step=2');
			$ajax = array('status'=>2,'href'=>$url,'title'=>title('add',MODULE_NAME) , 'detail' =>'');
			$this->success(L('_OPERATION_SUCCESS_'), $url, $ajax); 
		} else {
            $url	= U(MODULE_NAME.'/add');
			$ajax = array('status'=>2,'href'=>$url,'title'=>title('add',MODULE_NAME) , 'detail' =>'');
			$this->success(L('_OPERATION_SUCCESS_'), $url, $ajax); 
			$this->success(L('_OPERATION_SUCCESS_'));
		}
	}

    public function _autoIndex() { 
		$this->action_name = ACTION_NAME;
    	$model 			   = $this->getModel();
		$list			   = $model->index();
        foreach($list['list'] as &$value){
            $value['amount_money']  += $value['amount_money']*$value['warehouse_percentage']/100;//省略小数点后面多余的0
        }
    	$this->list		   = $list;
		getOutPutRand();
		$this->displayIndex();
	}
    
//    public function viewDetail(){
//        $quarter    = intval($_GET['quarter']);
//        $product_id = intval($_GET['product_id']);
//        $name = $this->getActionName();
//        $model 	= D($name);
//        if($_GET['rand'] === 'false'){
//            $this->rs   = $model->getDetailInfo();
//        }else{
//            if($quarter>0 && $product_id>0 && isset($_GET['storage_date'])){
//                $this->rs   = $model->warehouseAccountDetail();
//            } else {
//                $this->error(L('_ERROR_ACTION_'));
//            }
//        }
//        $this->display(ACTION_NAME);
//    }
	public function viewDetail(){
        $name = $this->getActionName();
        $model 	= D($name);
        $this->rs   = $model->getDetailInfo();
        $this->display(ACTION_NAME);
    }
}
?>