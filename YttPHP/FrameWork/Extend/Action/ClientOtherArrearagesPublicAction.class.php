<?php 
/**
 * 卖家应收款
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-05-22
 */

class ClientOtherArrearagesPublicAction extends FundsCommonAction {
	///款项对象类型
 	public $comp_type	=	1;  
     public function _initialize() {
         parent::_initialize();
		 $userInfo	= getUser();
         if($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){
             $this->assign('warehouse_id',getUser('company_id'));
         }elseif ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {//卖家
			$_POST['query']['comp_id'] = $userInfo['company_id'];
			$this->assign("is_factory", true);
		}
         $this->assign('rand',md5(time()));
     }

     public function setPost($info) {
		if ($info['billing_type'] == C('BILLING_TYPE_TOTAL')) {//计费方式为合计时
			$info['quantity']	= 1;
			$info['price']		= $info['owed_money'];
		}	
		return parent::setPost($info);
	}    
    public function index() {	 
		if ($_POST['search_form']) {
			///获取当前Action名称
			$name = $this->getActionName(); 
			///获取当前模型
			$model 	= D($name);     
			///格式化+获取列表信息  
			$list	=	$model->index();
			///assign
            getOutPutRand();
			$this->assign('list',$list);
            $total_sql      = $model->indexSql();
            $all_list       = $model->indexList('',$total_sql['sql']);
            $total_money    = $all_list['total']['currency_id_sum'];
            foreach ( $total_money as $key => $value){
                $total_money[$key]['currency']  = SOnly('currency', $key,'currency_no');
            }
            $total_money    = _formatList($total_money);
            $this->assign('total_money',$total_money);
		}
		///display
		$this->displayIndex();
	}
    function edit() {
        $name = $this->getActionName();
        $model = D($name);
        $list = $model->getInfo($_GET['id']);
		if (data_permission_validation($list['list'][0], 'comp_id') === false) {
			throw_json(L('data_right_error'));
		}
        $this->assign('comp_type',$this->comp_type);
        $this->assign('list',$list['list'][0]);
        $this->display();
    }
    public function update() {	 
        if($_POST['billing_type']==C('BILLING_TYPE_TOTAL')){
            $_POST['quantity']  = 1;
            $_POST['price']     = $_POST['owed_money'];
        }
		$this->id	=	intval($_POST['id']); 
		if ($this->id > 0) {  
			$model	= $this->getModel();
			if ($model->relationUpdate()===false){
				if ($model->error_type==1){  
					$this->error ( $model->getError(),$model->errorStatus);	
				}else{
					$this->error (L('_ERROR_'));
				} 
			}
		} else {
			$this->error(L('_ERROR_ACTION_'));
		} 	 
	}	
}