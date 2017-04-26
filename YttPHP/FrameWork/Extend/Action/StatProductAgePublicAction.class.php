<?php 
/**
 * 产品库龄
 * @copyright   Copyright (c) 2006 - 2012 YTT 展联软件友拓通
 * @category    产品库龄
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-08-28
 */
class StatProductAgePublicAction extends RelationCommonAction {
	/// 列表
	public function index(){
		if($_GET['search_form']==1){
			$model	= D('StatProductAge');
			$list	= $model->index();
			if ($list===false){   
				if ($model->error_type==1){  
					$this->error ( $model->getError(),$model->errorStatus);	
				}else{  
					$this->error (L('_ERROR_'));
				} 
			}
			$this->assign('list',$list);
			$this->displayIndex();
		}else{
			$this->displayIndex('index');
		}
	}
}
?>