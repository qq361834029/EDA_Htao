<?php 
/**
 * 产品信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-01-14
 */

class SkuKeywordsPublicAction extends BasicCommonAction {
    public $_view_dir 			= 'Basic';	/// 定义模板显示路径
    public $_sortBy				= 'product_no';
    protected $_cacheDd 		= array(29);//对应dd表中的id 
    public function _after_delete(){
        $this->checkCacheDd($id); 
    	parent::_after_delete();
    }
    ///还原
    public function _after_restore($id=null){
        $this->checkCacheDd($id); 
    	$this->success(L('_OPERATION_SUCCESS_')); 
    }
}