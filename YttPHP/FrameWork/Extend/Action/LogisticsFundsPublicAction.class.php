<?php 
/**
 * 物流收款
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class LogisticsFundsPublicAction extends FundsCommonAction {
	
	///款项对象类型
 	public $comp_type	=	2;  
	   
	public function add(){
		$session_name	= 'logisticsFunds_'.USER_ID;
		if ($_GET['step']==2){ 
			$rs						=	session($session_name);   
			$rs['logistics_name']	=	SOnly('logistics',$rs['comp_id'],'logistics_name');    
			$currency				= 	SOnly('currency',$rs['currency_id']); ///支付币种中文 
			$rs['currency_name']	= 	$currency['currency_no'];  
			$this->assign('step',2); 
			$this->assign('rs',$rs);  
			$comp_currency	=	C('factory_currency'); 
			$this->assign('currency_id',$comp_currency);  
			///获取当前Action名称
			$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);   
	 		///欠款金额
	 		$account=	$model->getAccountInfo($rs);  
	 		$this->assign('account',$account); 
	 		/// 对账日期不能小于上次的对账日期,对账总平最小最后日期
 			$min_paid_date =	getMaxCloseOutDate($this->_comp_type,$rs['basic_id'],$rs['comp_id'],$rs['currency_id']); 
			$this->assign('min_paid_date',$min_paid_date);///最小付款日期
			
			$this->assign('comp_currency',$comp_currency);///涉及到的币种
			$this->assign('comp_currency_count',count(explode(',',$comp_currency)));///币种总数量 
///			$this->assign('comp_currency',C('logistics_currency'));///最小付款日期
			 
		}else{
				if ($_POST['step']==1){  
				///获取当前Action名称
				$name = $this->getActionName(); 
		 		///获取当前模型
				$model 	= D($name);     
				///模型验证
				if (false === $model->create($_POST)) {  
					$this->error ( $model->getError(),$model->errorStatus);
				}
				session($session_name,$_POST);
				$this->success('ok','',array('status'=>1,'href'=>U('/'.MODULE_NAME.'/add/step/2'),'title'=>title('add',MODULE_NAME)));   
				}else{  
					
				}  
		}
		$this->assign('comp_type',$this->comp_type);   
		
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
            foreach($list['list'] as &$val){
                $val['befor_currency_no']    = SOnly('currency', $val['befor_currency_id'],'currency_no');
            }
			$this->assign('list',$list);
            $total_sql      = $model->indexSql();
            $all_list       = $model->indexList('',$total_sql['sql']);
            $total_money    = $all_list['total']['currency_id_sum'];
            $total_befor_money = $all_list['total']['befor_currency_id_sum'];
            foreach (explode(',', C('factory_currency')) as $value){
                $total_money[$value]['currency']  = SOnly('currency', $value,'currency_no');
                $total_money[$value]['befor_money']   = $total_befor_money[$value]['befor_money'];
                $total_money[$value]['account_money'] = $total_befor_money[$value]['account_money'];
            }
            $total_money    = _formatList($total_money);
            $this->assign('total_money',$total_money);
		}
		///display
		$this->displayIndex();
	}
	
	public function _after_add(){    
		if ($_GET['step']==2){ 
			$this->display('next');
		}else{
			$this->display();
		} 
    } 
	
}