<?php
/**
 * 卖家充值信息管理
 * @copyright   2012 展联软件友拓通
 * @category  	 基本信息
 * @package  	Action
 * @author    	jph
 * @version 	2014-06-04
 */

class RechargePublicAction extends RelationCommonAction {
	public $_asc 			= false;  	//默认排序
	public $_sortBy 		= 'recharge_date';  //默认排序字段
	
	
	public function __construct() {
        parent::__construct();
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
    }
	
	
    ///列表
	public function _autoIndex() {	
		$this->action_name = ACTION_NAME;
    	$model 			   = $this->getModel();
		$list			   = $model->index();
		foreach ((array)$list['list'] as $key=>$value){
			$list['list'][$key]['opened_y'] = sprintf("%.8f", $value['opened_y']);//汇率
			$list['list'][$key]['dml_money'] = $value['dml_money'].' '.$value['currency_no'];	//充值金额+币种
			$current_no = SOnly('currency',$value['confirm_currency_id'],'currency_no');
			$list['list'][$key]['dml_money_to'] = $value['money_to'].' '.$current_no; //转换至金额+币种
			$list['list'][$key]['dml_confirm_money'] = $value['confirm_money'].' '.$current_no; //确认金额+币种
			if(!empty($value['cpation_name'])){
				$list['list'][$key]['fmd_cpation_name'] = "<img src='".PUBLIC_PATH."/Images/Admin/file.gif'/>";
			}
			$list['list'][$key]['file_link'] = getUploadPath(34).$value['file_url'];	//文件链接	
			if(!empty($value['confirm_comments'])){	//确认充值时的注意事项
				$list['list'][$key]['dml_confirm_money'] .= " <a id='auto_show_img' tabindex='-1' onclick=$.autoShow(this,'Recharge','') pid='".$value['id']."' href='javascript:;'><img src='".PUBLIC_PATH."/Images/Default/atshow_ico.gif'></a>";
			}
		}
		///assign
		$this->assign('list',$list);
		getOutPutRand();
		///display
		$this->displayIndex();
	}
	
	
	public function  view(){
		//获取当前Action名称
	 	$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);   
		//模型ID
		$id 	= 	intval($_REQUEST[$model->getPk()]);  
		if ($id>0) {
			$vo 					= _formatArray($model->getById($id),$this->_default_format);  
			$vo['pics'] = D('Gallery')->getAry($id,34);
			$vo['confirm_currency_no'] = SOnly('currency',$vo['confirm_currency_id'],'currency_no');
			$vo['opened_y'] = sprintf("%.8f", $vo['opened_y']);//汇率
			//如果查询结果是空提示错误 
			if (!is_array($vo)) {
				exit(L('data_right_error'));
			} 
			$this->rs	=	$vo; 
		}else {
			$this->error(L('_ERROR_'));
		}
	}


	public function add() {
		$userInfo	=	getUser(); 
		if ($userInfo['company_id'] > 0) {
			$this->assign("fac_id", $userInfo['company_id']);
			$this->assign("fac_name", SOnly('factory',$userInfo['company_id'], 'factory_name'));		
		}
        if($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){
            $this->assign("warehouse_id", $userInfo['company_id']);
        }
	}
	
	 //修改
	public function edit() {
		//获取当前Action名称
	 	$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);   
		//模型ID
		$id 	= 	intval($_REQUEST[$model->getPk()]);  
		if ($id>0) {
			$vo 					= _formatArray($model->getById($id),$this->_default_format);  
			$vo['pics'] = D('Gallery')->getAry($id,34);
			if($vo['currency_id'] == 2){	//默认确认币种为EUR，充值币种如果为EUR，则汇率为1
				$vo['opened_y'] = 1;
				$vo['money_to'] = sprintf("%.2f",$vo['money']);
			}else{
				//获取今天的汇率
				$vo['opened_y'] =  sprintf("%.8f",D('RateInfo')->getRate($vo['currency_id'],'',2));
				$vo['money_to'] = sprintf("%.2f",$vo['money'] * $vo['opened_y']);
			}
			
			//如果查询结果是空提示错误 
			if (!is_array($vo)) {
				exit(L('data_right_error'));
			} 
			$this->rs	=	$vo; 
		}else {
			$this->error(L('_ERROR_'));
		}
	} 
	

	
	public function _after_insert(){
		//更新产品图片关联信息
		if(!empty($_POST['tocken'])){
			D('Gallery')->update($this->id,$_POST['tocken']);
		}
		parent::_after_insert();
	}


	
	//编辑充值确认
	public function editConfirm(){
		///获取当前Action名称
		$name = $this->getActionName();
		///获取当前模型
		$model 	= D($name);  
		$result	= $model->editConfirm(); 
		if (false === $result) {
			$this->error ( L('DELETE_FAILED') );
		} else {
			$this->success(L('_OPERATION_SUCCESS_'));
		}
	}
	
	
	//充值确认/取消
	public function confirm() {
			///获取当前Action名称
			$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);  
			$result	= $model->confirm(); 
			if (false === $result) {
				$this->error ( L('DELETE_FAILED') );
			} else {
				$msg = $_GET['confirm_state'] == 1 ? L('_OPERATION_SUCCESS_') : L('request_status_cancelled');
				$this->success($msg);
			}
	}
}