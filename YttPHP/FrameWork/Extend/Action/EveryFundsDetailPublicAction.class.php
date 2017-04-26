<?php 
/**
 * 每日出入明细的处理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-08-06
 */
class EveryFundsDetailPublicAction extends CommonAction {
	
	public function index() { 
       //获取当前Action名称
	 	$name = $this->getActionName();
		if(count($_POST)>2){
			if($_POST['date']['from_paid_date']=='' || $_POST['date']['from_paid_date']=='' || $_POST['query']['currency_id'] == ''){
				echo '<div style="width:100%;color:red;font-size:16px;text-align:center;">请输入日期和币种！</div>';
				exit;
			}else{
				//获取当前模型
				$model 	= D($name);

				//格式化+获取列表信息
				$list	=	$model->index();
				$this->assign('list',$list);
			}
		}
		//display
		$this->displayIndex(); 
    }
    
}