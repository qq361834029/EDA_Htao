<?php 
/**
 * 入库单导入异常管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	入库
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-04-08
 */

class InstockAbnormalPublicAction extends FileListPublicAction {
	///列表
	public function index() { 
		$this->action_name	=   ACTION_NAME;
 		///获取当前模型 
    	$model 	= $this->getModel();
    	///格式化+获取列表信息  	
    	$this->list	= $model->index('abnormalList');   
		$this->displayIndex();
	} 
}