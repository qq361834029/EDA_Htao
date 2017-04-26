<?php 
/**
 * 其他支出
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class OtherExpensesPublicAction extends FundsCommonAction {
	  
	/**
	 * 格式化页面Post来的值
	 *
	 * @param array $info
	 * @return array
	 */
	public function setPost($info){
		///获取当前Action名称
		$name = $this->getActionName();
		///获取当前模型
		$model 	= D($name);   
		
		return $model->formatOtherFunds($info);
	}
}