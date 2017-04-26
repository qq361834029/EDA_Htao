<?php

/**
 * 语言包
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class LangPublicAction extends BasicCommonAction {
	
	///列表
	public function index() {
		if(empty($_REQUEST['search_form'])&&empty($_REQUEST['s_r'])){
			$this->display();
			exit;
		}
		///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= 	D($name);      
		$where	= _search().$this->getWhere($_GET);
		$list	= $model->where($where)->order('module,lang_value_cn')->select();
		$this->assign('list',$list);
		$this->displayIndex();
	}
	
	/**
	 * 更新对应模块语言包文件
	 *
	 * @return 
	 */
	public function _after_update(){
		D('Lang')->updateFile(" and module='".$_POST['module']."'");
		parent::_after_update();
	}
	///热键参数条件
	public function getWhere($info){
		$dbFields	= D('Lang')->getDbFields();
		foreach($info as $key=>$val){
			if(in_array($key,$dbFields)){
				$where	.= " and ".$key." like '%".$val."%'";
				$_POST['like'][$key]	= $val;
			}
		}
		session(MODULE_NAME,$_POST);
		return $where;
	}
}