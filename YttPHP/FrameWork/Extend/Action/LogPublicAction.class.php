<?php 

/**
 * 系统日志管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	系统日志
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class LogPublicAction extends BasicCommonAction {
	
	/// 设置默认条件
	protected $_default_where	= 'id>0'; 
	
    /// 日志列表
	public function index() {
	 	$name = $this->getActionName();
	 	if ($this->_view_model===true){
	 		$name	=	$name.'View';
	 	}
		$model 	= 	D($name);      
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post),'sortBy'=>$this->_sortBy);
		$list	=	$this->_listAndFormat($model,$opert);
		foreach ($list['list'] as &$value) {
			$value['module'] = L('module_'.$value['module']);
		}
		$this->assign('list',$list);
		$this->displayIndex();
	}
	
}
?>