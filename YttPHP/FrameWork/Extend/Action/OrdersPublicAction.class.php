<?php 

/**
 * 订货信息管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	订货信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-07-22
*/

class OrdersPublicAction extends RelationCommonAction {
	
	/// 指定发送email的字段名称
	public $_email_object_id 		=	'factory_id';
	
	/// 构造函数
	public function __construct() {
		parent::__construct();
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$_POST['query']['factory_id'] = intval(getUser('company_id'));
		}
	}
	
	/// 获取手动完成的列表数据
	public  function setOrderFinished() {	
		$id	=	intval($_GET['id']);	
		if ($id> 0) {		
			//获取当前Action名称
			$model 		= $this->getModel();
			$this->id	= $id;
			$model->setId($id);
			$this->rs	= $model->view();
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}			 	
	}
	
	/// 显示手动完成的列表
	public function _after_setOrderFinished(){ 
		$this->display(); 
	}
	
	/// 订单明细手动完成操作
	public function  setFinishDetailState() {
		$this->id	=	intval($_GET['id']);
		if ($this->id > 0) {
			//获取当前模型
			$model 	= M('order_details');
			//当前主键
			$pk		=	$model->getPk ();
			$id 	= 	intval($_REQUEST[$pk]);
			if ($id>0) {
				$condition 	= $pk.'='.$id;
				if ($_GET['type']==1) {
					$model->where($condition)->setField('detail_state',4);
				}else {
					$model->where($condition)->setField('detail_state',0);
					T('Orders')->run($id,'updateOrdersDetailState');
				}
				T('Orders')->run(intval($_GET['orders_id']),'updateOrdersState');	// 更新订货单主表状态
			}else{
				$this->error(L('_ERROR_'));
			}
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}
	}
	
	/// 订单明细手动完成后跳转信息
	public function _after_setFinishDetailState(){
    	$this->success(L('_OPERATION_SUCCESS_')); 	
    } 
    
	/// 订单列表
	public function alistFinishOrder(){
		$this->_autoIndex('index');
	}
	
	/// 未完成订单列表
	public function alistUnfinishOrder(){
		$this->_autoIndex('index');
	}
	
    /// 未装柜订单信息
    public function getUnloadOrder(){
    	$model 		= $this->getModel();
    	$this->list	= $model->getUnloadOrderSql($_POST);
    	$this->display('load_detail');
    }
}
?>