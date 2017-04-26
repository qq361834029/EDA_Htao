<?php

/**
 * 修改汇率
 * @copyright   2011 展联软件友拓通
 * @category   	基本信息
 * @package  	Behavior 
 */
 
class RateInfoPublicBehavior extends Behavior {
	
	// 行为扩展的执行入口必须是run
    public function run(&$params){
    	if ($params['id']>0){
//    		$model	=	M('AbsStat'); 
    		$rate	=	D('rateinfo'); 
    		$info	=	$rate->where('id='.intval($params['id']))->find();  
	 		if (is_array($info)) {
	 			$info['rate']	=	$info['opened_y']; 
	 			//重新计算属于当天的所有利润
//	 			$model->_updateTodayProfit($info); 
	 		}  
    	} 
    } 
    
}