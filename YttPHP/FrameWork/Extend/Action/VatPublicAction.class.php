<?php

/**
 * VAT信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     jph
 * @version  2.1,2014-01-17
 */

class VatPublicAction extends BasicCommonAction {
	public $_asc 			=  true;  	//默认排序
	public $_sortBy 		=  'factory_id';  //默认排序字段
//	public $_default_post	=  array('query'=>array('to_hide'=>1));  //默认post值处理
//	public $_default_format	=  array('dd'=>array('basic_id'=>'basic'),'format_date'=>false);  //_formatArray需要格式化的数组
//	public $_cacheDd		=  array(6);

	public function __construct() {
    	parent::__construct();
		getOutPutRand();
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		$user	= getUser();
    	if ($user['role_type']==C('SELLER_ROLE_TYPE')) {//角色类型为卖家类型
			$_POST['query']['factory_id'] = intval($user['company_id']);
		}
		if ($user['role_type']==C('WAREHOUSE_ROLE_TYPE')) {//角色类型为仓库人员类型
			$country_id	= M('Warehouse')->where('id='.intval($user['company_id']))->getField('country_id');
			$_POST['query']['country_id'] = $country_id;
			if(ACTION_NAME=='add'){
				$this->assign('country_id',$country_id);
				$this->assign('country_name',SOnly('country', $country_id, 'district_name'));
			}
		}
    }

	///列表
	public function index() {
		///获取当前Action名称
	 	$name = $this->getActionName();
	 	if ($this->_view_model===true){
	 		$name	=	$name.'View';
	 	}
 		///获取当前模型
		$model 	= 	D($name);
		///条件
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post),'sortBy'=>$this->_sortBy);
		///格式化+获取列表信息
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME;
		$list	= $this->_listAndFormat(&$model,$opert,$_formatListKey);
		if (in_array(MODULE_NAME, C('MERGE_ADDRESS_MODULE'))) {//added by jp 20140115
			_mergeAddress($list);
		}
		if($list['list']){
			foreach ($list['list'] as $v){
				$vats[]	= $v['id'];
			}
			$gallery	= M('Gallery')->where('relation_id in('.implode(',', $vats).') and relation_type='.C('VAT_FILE'))->select();
			$base_url	= getUploadPath(C('VAT_FILE'));
			foreach ($gallery as $v){
				$vat_gallery[$v['relation_id']][]	= '<a href="'.$base_url.$v['file_url'].'" target="_blank">'.$v['cpation_name'].'</a>';
			}
			foreach ($list['list'] as $k=>$v){
				$list['list'][$k]['attachment']	= implode('</br>', $vat_gallery[$v['id']]);
			}
		}
		///assign
		$this->assign('list',$list);
		///display
		$this->displayIndex();
	}

	public function _after_insert(){
  		if($_POST['tocken']){
			D('Gallery')->update($this->id,$_POST['tocken']);//更新产品图片关联信息
		}
		parent::_after_insert();
  	}
	public function _before_update(){
		if(getUser('role_type')==C('SELLER_ROLE_TYPE') && $_POST['confirm_status']==2){
			$_POST['confirm_status']	= 1;
		}
	}
	///删除
    public function delete(){
    	///还原特殊处理 mingxing
    	if ($_GET['restore']==1){
    		$this->restore();
    	}else{
	    	///获取当前Action名称
		 	$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);
			///当前主键
			$pk		=	$model->getPk ();
			$id 	= 	intval($_REQUEST[$pk]);
			if ($id>0) {
				$condition 	= $pk.'='.$id;
				$list	=	$model->where($condition)->delete();
				$this->id	=	$id;
				///如果删除操作失败提示错误
				if ($list==false) {
					$this->error(L('data_right_del_error'));
				}
			}else{
				$this->error(L('_ERROR_'));
			}

    	}
    }
}