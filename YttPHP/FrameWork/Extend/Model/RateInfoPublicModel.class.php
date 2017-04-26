<?php

/**
 * 汇率信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	汇率信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class RateInfoPublicModel extends Model {
	// 模型名与数据表名不一致，需要指定
	protected $tableName = 'rate_info';
	public $_validate	 =	 array(  
										array("opened_y",'require',"require",1),
										array("opened_y",'money',"money_error",1),  
										
	);  
	
	/**
	 * 根据当前币种获取与本位币的汇率
	 *
	 * @param  $from_currency 币种ID
	 * @param   $date 转换日期
	 */
	public function getRate($from_currency,$rate_date,$to_currency = 0){
		$rate_type 		= C('set_rate_type');
		if($to_currency == 0){
			$to_currency 	= C('currency');
		}
		$from_currency	= intval($from_currency);
		if($from_currency==$to_currency && $to_currency>0) return 1;
		import('ORG.Util.Date');
		$date = new Date($rate_date);
		switch ($rate_type) {
			case 1:
				$rate_info = M('FixedRate')->field('rate')->where('from_currency_id='.$from_currency.' and to_currency_id='.$to_currency)->find();
				break;
			case 2:
				if($to_currency == 1 && $from_currency != 1){
					$rate_info = M('RateInfo')->field('opened_y as rate')->where('from_currency_id='.$from_currency.' and to_currency_id='.$to_currency.' and rate_date=\''.$date->format('%Y-%m').'-01\'')->find();				
				}elseif($to_currency != 1 && $from_currency == 1){
					$rate_info = M('RateInfo')->field('1/opened_y as rate')->where('from_currency_id='.$to_currency.' and to_currency_id='.$from_currency.' and rate_date=\''.$date->format('%Y-%m').'-01\'')->find();			
				}elseif($to_currency != 1 && $from_currency != 1){
					$rate_return = M('RateInfo')->field('opened_y as rate,from_currency_id')->where('from_currency_id in ('.$from_currency.','.$to_currency.') and rate_date=\''.$date->format('%Y-%m').'-01\'')->formatFindAll(array('key'=>'from_currency_id','v_key'=>'rate'));
					$rate_info['rate'] = round($rate_return[$from_currency]/$rate_return[$to_currency],4);
				}
				break;
			default:
				if($to_currency == 1 && $from_currency != 1){
					$rate_info = M('RateInfo')->field('opened_y as rate')->where('from_currency_id='.$from_currency.' and to_currency_id='.$to_currency.' and rate_date=\''.$date->format('%Y-%m-%d').'\'')->find();
				}elseif($to_currency != 1 && $from_currency == 1){
					$rate_info = M('RateInfo')->field('1/opened_y as rate')->where('from_currency_id='.$to_currency.' and to_currency_id='.$from_currency.' and rate_date=\''.$date->format('%Y-%m-%d').'\'')->find();
				}elseif($to_currency != 1 && $from_currency != 1){
					$rate_return = M('RateInfo')->field('opened_y as rate,from_currency_id')->where('from_currency_id in ('.$from_currency.','.$to_currency.') and rate_date=\''.$date->format('%Y-%m-%d').'\'')->formatFindAll(array('key'=>'from_currency_id','v_key'=>'rate'));
					$rate_info['rate'] = round($rate_return[$from_currency]/$rate_return[$to_currency],4);
				}
				break;
		}
		// 找不到对应汇率时取固定汇率记录汇率错误日志，一天只记录一次
		if ($rate_info['rate']<=0) {
			$count = M('RateError')->where('error_date=\''.$date->format('%Y-%m-%d').'\' and from_currency_id='.$from_currency.' and to_currency_id='.$to_currency)->count();
			if ($count<=0) {
				M('RateError')->add(array('from_currency_id'=>$from_currency,'to_currency_id'=>$to_currency,'error_date'=>$rate_date));
			}
			$rate_info = M('FixedRate')->field('rate')->where('from_currency_id='.$from_currency.' and to_currency_id='.$to_currency)->find();
		}
		return $rate_info['rate'];
	}
	
	
}