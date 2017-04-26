<?php

/**
 * 汇率异常
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	汇率异常
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class RateErrorPublicModel extends CommonModel {
	// 模型名与数据表名不一致，需要指定
	protected $tableName = 'rate_error';


	protected function _after_select(&$data){
		$currency = S('currency');
		foreach ($data as &$value) {
			$value['dd_from_currency_id'] = $currency[$value['from_currency_id']]['currency_no'];
			$value['dd_to_currency_id'] = $currency[$value['to_currency_id']]['currency_no'];
		}
	}
	
	public function setState($id){
		return $this->save(array('id'=>$id,'state'=>2));
	}
	
}