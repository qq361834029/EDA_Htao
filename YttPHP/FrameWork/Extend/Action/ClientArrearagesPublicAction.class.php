<?php 
/**
 * 新卖家应付款
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	吴盛龙
 * @version 	2.1,2017-01-3
 */

class ClientArrearagesPublicAction extends FundsCommonAction {
	///款项对象类型
 	public $comp_type	=	1;
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
		$this->assign('rand',md5(time()));
		///display
		$this->displayIndex();
	}
}