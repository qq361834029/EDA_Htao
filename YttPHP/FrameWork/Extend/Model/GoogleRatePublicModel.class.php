<?php

/**
 * Google汇率
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class GoogleRatePublicModel extends Model {
	
	protected $tableName	= 'rate_info';
	
	protected $sec		= 1;									//获取汇率失败暂停时间
	
	protected $err_num	= 3;									//获取汇率失败时执行次数
	
	protected $do		= 1;									//当前执行次数
	
	/// 获取Google汇率地址
	function getUrl(){
		
		return 'http://www.google.com.hk/finance/converter?a=1&from=@FROM@&to=@TO@&meta=gl%3Dcn';
	}
	
	/**
	 * 取汇率
	 * @param sting $from 币种
	 * @param string $to 币种
	 * @return array
	 */
	function getRate($from,$to){
		
		$this->do	= 1;										//初始化执行次数
		$list		= self::getContent($from,$to);				//获取谷歌财经频道汇率
		if(!empty($list)){
			$list	= self::resetArray($list);					//重组汇率数组
		}
		
		if(empty($list)){
			//记录日志
		}else{
			$list['currency_from']	= $from;
			$list['currency_to']	= $to;
		}
		return $list;
	}
	/**
	 * 获取汇率内容
	 * @param string $from		币种
	 * @param string $to		币种
	 * @return array 
	 */
	function getContent($from,$to){
		$from		= $from=='RMB'?'CNY':$from;
		$from		= $from=='EURO'?'EUR':$from;
		$to			= $to=='RMB'?'CNY':$to;
		$to			= $to=='EURO'?'EUR':$to;
		$url		= str_replace('@FROM@',$from,self::getUrl());
		$url		= str_replace('@TO@',$to,$url);
		$content	= @file_get_contents($url);              						//从谷歌财经频道获取汇率
		preg_match("/<span.*?>(\d.*?\d)\s.*?<\/span>/i",$content,$rs);				//<span class=bld>汇率 币种</span>之间的数值 即为所要的汇率
		if(empty($rs[1]) && $this->do < $this->err_num){
			$this->do	= $this->do+1;													
			sleep($this->sec);														//暂停几秒后继续取汇率
			return self::getContent($from,$to);										//递归取汇率
		}else{
			return $rs[1];
		}
	}
	
	 ///重组汇率数组
	function resetArray($info){
		$date	= date('Y-m-d');
		$time	= date('Y-m-d H:i:s');
		if(!empty($info)){
			$list['rate_date']		= $date;
			$list['opened_y']		= $info;
			$list['opened_t']		= $info;
			$list['highest_price']	= $info;
			$list['lowest_price']	= $info;
			$list['bid_price']		= $info;
			$list['selling_price']	= $info;
			$list['insert_time']	= $time;
			return $list;
		}else{
			return array();
		}
	}
}
?>