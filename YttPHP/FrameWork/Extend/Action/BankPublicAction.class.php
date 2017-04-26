<?php
/**
 * 银行帐号信息管理
 * @copyright   2012 展联软件友拓通
 * @category  	 基本信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2012-07-10
 */

class BankPublicAction extends BasicCommonAction {
	public $_asc 			= true;  	//默认排序
	public $_sortBy 		= 'bank_name';  //默认排序字段
	public $_default_post	= array('query'=>array('to_hide'=>1));  //默认post值处理
	public $_cacheDd		= array(4,21);  //默认post值处理
	public function _before_index(){
		getOutPutRand();
	}
}