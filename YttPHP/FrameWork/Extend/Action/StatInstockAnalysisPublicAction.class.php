<?php
/**
 * 进货数量价格分析
 * @copyright   Copyright (c) 2006 - 2012 YTT 展联软件友拓通
 * @category    进货数量价格分析
 * @package   Action
 * @author     何剑波
 * @version  2.1
 */
class StatInstockAnalysisPublicAction extends RelationCommonAction {
	/// 列表
	public function index(){
		if($_GET['search_form']==1){
			$model	= D('StatInstockAnalysis');
			$list	= $model->index();
			if ($list===false){   
				if ($model->error_type==1){  
					$this->error ( $model->getError(),$model->errorStatus);	
				}else{  
					$this->error (L('_ERROR_'));
				} 
			}
//			$list	= $model->index();
			$this->assign('list',$list);
			$this->assign('page',$list['page']);
			$this->displayIndex();
		}else{
			$this->displayIndex('index');
		}
	}
	/// 计算总合计
//	public function _before_view(){
//		$total	= D('StatInstockAnalysis')->getListTotal();
//		$this->assign('total',$total);
//	}
	
	/// 进货数量价格分析图/表(明细)
	public function view() {
		$model	= D('StatInstockAnalysis');
		$list	= $model->instockAnalysisDetail();	
		$this->assign('list',$list);
//		$this->displayIndex('view');	
	}
}