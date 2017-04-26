<?php 
/**
 * 客户应付款统计
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class ClientStatPublicAction extends RelationCommonAction {
	
	 function _initialize(){
	 	addLang('stat');
	 	parent::_initialize();
	 }
	///查看列表
	public function index() {
		if (!empty($_POST['search_form'])||!empty($_GET['flag'])) {
			$this->statFundDate();	///统计日期的显示公式	
			///获取当前Action名称
			$name = $this->getActionName(); 
			///获取当前模型
			$model 	= D($name);     
			///格式化+获取列表信息  
			$list	=	$model->getIndex();
			$this->assign('list',$list);
		}
		$this->displayIndex();
	}

	///卖家款项汇总
	public function collectByClass() {  
		if (!empty($_POST['search_form'])){
		   ///获取当前Action名称
			$name = $this->getActionName();
			///获取当前模型
			$model 	= D($name);
			///格式化+获取列表信息  
			$list	=	$model->collectByClass();
			$this->assign('list',$list);
			$this->_Member	= 'list_';
		}
		$this->display(empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME);
	}
	
        ///查看明细
	public function view() {  
		$get	= $_GET;
		unset($get['_URL_']);
		if (!empty($get) || !empty($_POST['search_form'])){
		   ///获取当前Action名称
			$name = $this->getActionName();
			///获取当前模型
			$model 	= D($name);
			$_GET	= array_merge($_GET, $_POST);
			if (!empty($_POST['search_form'])) {
				if (!empty($_GET['from_paid_date']) && !empty($_GET['to_paid_date'])){
					$sourcetype = 4;
				}else{
					$sourcetype = empty($_GET['to_paid_date']) ? 1 : 4;	
				}
				$for_type	= 0;
				$show_type	= 'page';
				if(in_array($sourcetype, array('1','2','3'))){
					if($sourcetype==1){
						$for_type = C('UNPAID_ARREARAGE_DETAILS');
						if($for_type==2) $show_type = 'not_page';
					}elseif($sourcetype==2){
						$for_type = C('ALL_ARREARAGE_DETAIL');
					}else{
						$for_type = C('ARREARAGE_DETAILS_AFCLOSEOUT');
					}
					if($for_type==3) $for_type = 1;
				}
				$_GET['type']		= $sourcetype;
				$_GET['for_type']	= $for_type;
				$_GET['show_type']	= $show_type;
				$_REQUEST			= array_merge($_REQUEST, $_GET);
				$_POST				= array_merge($_POST, $_GET);
			}
			$client_id	=	$_GET['client_id']?$_GET['client_id']:$_GET['comp_id'];
			$url		= '/ClientStat/view/currency_id/'.$_GET['currency_id'].'/comp_id/'.$client_id.'/basic_id/'.$_GET['basic_id'];
			if (!empty($_GET['pay_class_id'])) {
				$this->pay_class_name	= SOnly('pay_class', $_GET['pay_class_id'], 'pay_class_name');
				$url	.= '/pay_class_id/' . $_GET['pay_class_id'];
			}			
			if (!empty($_GET['from_paid_date'])) {
				$url	.= '/from_paid_date/' . $_GET['from_paid_date'];
			}
			if (!empty($_GET['to_paid_date'])) {
				$url	.= '/to_paid_date/' . $_GET['to_paid_date'];
			}		
			$this->assign('link1',U($url . '/type/1'));
			$this->assign('link2',U($url . '/type/2'));
			$this->assign('link3',U($url . '/type/3'));
			///格式化+获取列表信息  
			$list	=	$model->getDetail($_GET);
			$this->assign('list',$list);
			if (!empty($_POST['search_form'])) {
				$this->_Member	= 'list_';
			}
		}
		$this->factory_name	= SOnly('factory', $client_id, 'factory_name');
		$this->factory_id	= $client_id;
        $this->assign('w_name',SOnly('warehouse', $_GET['warehouse_id'], 'w_name'));
		$this->uri			= str_replace("view","sentEmailDetail",__SELF__);
	}
    public function _after_view($temp_file) {
        //设置导出POST
        $rand_post['rand']                      = $_POST['rand'];
        $rand_post['query']['comp_id']          = $_POST['comp_id'];
        $rand_post['query']['pay_class_id']     = $_POST['pay_class_id'];
        $rand_post['query']['currency_id']      = $_POST['currency_id'];
        $rand_post['date']['from_paid_date']    = $_POST['date']['from_paid_date'];
        $rand_post['date']['to_paid_date']      = $_POST['date']['to_paid_date'];
        $rand_post['query']['currency_id']      = $_POST['currency_id'];
        $_POST['where']         = getWhere($rand_post);
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $_POST['where']  .= ' and warehouse_id in ('.getUser('company_id').',0) ';
        }else{
            if(!empty($_POST['warehouse_id'])){
                $_POST['where']  .= ' and warehouse_id in ('.$_POST['warehouse_id'].',0) ';
            }
        }
        getOutPutRand();
        parent::_after_view($temp_file);
    }

	///查看明细
	public function sentEmailDetail() {     
	   ///获取当前Action名称
		$name = $this->getActionName(); 
		///获取当前模型
		$model 	= D($name);
		echo json_encode($this->sentEmail('ClientStat',$_GET));
	}
    	
    	
    ///统计日期的显示公式
	public function statFundDate(){ 
		if ($_POST['date']['from_paid_date']){ 
			if (empty($_POST['date']['to_paid_date'])){
				$_POST['date']['to_paid_date']	=	date('Y-m-d');	
			} 
			$_POST['paid_date']				=	$_POST['date']['to_paid_date'];
		}elseif ($_POST['date']['to_paid_date'] && empty($_POST['date']['from_paid_date'])){
			$_POST['paid_date']	=	$_POST['date']['lt_paid_date']	=	$_POST['date']['to_paid_date'];
			unset($_POST['date']['to_paid_date']);
		}
	}
	
}
?>