<?php

/**
 * 国家信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class DistrictPublicAction extends BasicCommonAction {
	public $_asc 			=  true;  	//默认排序
	public $_sortBy 		=  'a.district_name';  //默认排序字段	
	public $_default_where	=  'a.parent_id=0';  //默认查询条件

	//需要更新的缓存字典 
  	protected 	$_cacheDd	=  array(1,2);  
	//国家列表显示
	public function index(){
		$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name.'View');
		if($_POST['like']['a.district_name']){
			$str	= explode("—", $_POST['like']['a.district_name']);
			$_POST['like']['a.district_name']	= ($str[1])?$str[1]:$str[0];
		}
		$opert	=	array('where'=>$this->_search($this->_default_where,$this->_default_post),'group'=>'a.district_name','sortBy'=>'a.district_name asc');
		$list	= $this->_listAndFormat($model,$opert);
		$this->assign('list',$list);
		if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){	//仓库角色，仓库所属国家ID
			$ware_country_id	= M('Warehouse')->where('id='.getUser('company_id'))->getField('country_id');
			$this->assign('ware_country_id',$ware_country_id);
		}
		getOutPutRand();
		if ($_POST['search_form']) {
			$this->display ('list');
		}else {
			$this->display ();
		}
	}
	public function _after_view() {
		if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){	//仓库角色，仓库所属国家ID
			$ware_country_id	= M('Warehouse')->where('id='.getUser('company_id'))->getField('country_id');
			$is_update	= ($ware_country_id==$_GET['id'])?true:false;
			$this->assign('is_update',$is_update);
		}
		if(getUser('role_type')==C('SELLER_ROLE_TYPE')){	//卖家角色
			$this->assign('is_update',false);
		}
		parent::_after_view();
	}
	//删除
    public function delete(){ 
    	//获取当前Action名称
	 	$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);   
		//当前主键
		$pk		=	$model->getPk ();
		$id 	= 	intval($_REQUEST[$pk]);
		$this->id	= $id;
		if ($id>0) { 
			$condition 	= $pk.'='.$id; 
			if($_REQUEST['restore']==1){
				//还原自身
				$list		= $model->where( $condition )->setField('to_hide',1);
				$info		= $model->find($id);
				//还原上级
				if($info['parent_id']>0){
					$flag	= $model->where($pk.'='.$info['parent_id'])->setField('to_hide',1);
				}
			}else{
				//删除自身
				$list	=	$model->where($condition)->setField('to_hide',2);   
				//删除下级
				$flag	=	$model->where('parent_id='.$id)->setField('to_hide',2);
			}
			//如果删除操作失败提示错误
			if ($list==false) {
				$this->error(L('data_right_del_error'));
			}
		}else{
			$this->error(L('_ERROR_'));
		} 
		if($_REQUEST['restore']==1){
			$this->success('数据还原成功！'); 
		}else{
			$this->success('数据删除成功！'); 
		}
    }  
}
