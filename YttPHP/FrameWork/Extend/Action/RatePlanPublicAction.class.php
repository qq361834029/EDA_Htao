<?php

/**
 * 汇率计划任务
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    汇率计划任务
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class RatePlanPublicAction extends Action{
	
	public function index(){
		$model	= D($this->getActionName());
		$model->index();
	}

}