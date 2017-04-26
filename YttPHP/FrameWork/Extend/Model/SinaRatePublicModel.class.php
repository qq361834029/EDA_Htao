<?php

/**
 * 新浪汇率
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    汇率
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class SinaRatePublicModel extends Model{
	
	protected $tableName	= 'rate_info';
	
	protected $sec		= 1;										//获取汇率失败时暂停时间
	
	protected $err_num	= 2;										//获取汇率失败时执行次数
	
	protected $do		= 0;										//当前执行次数
	
	/**
	 * 设置汇率地址
	 */
	function getUrl(){
		
		return 'http://hq.sinajs.cn/?list=@LIST@';
	}
	
	/**
	 * 获取汇率
	 *
	 * @param string $from	币种
	 * @param string $to	币种
	 * @return array $rate	汇率
	 */
	function getRate($from,$to){
		$this->do		= 1;									//执行次数初始化
		$rate			= self::getContent($from,$to);			//直接取汇率
		if(empty($rate)){
			$this->do	= 1;
			$rate		= self::getContent($to,$from);			//反向取汇率
			$rate		= self::calculate($rate);				//重新计算汇率
		}
		if(empty($rate)){
			$this->do	= 1;
			$rate		= self::fetchTwo($from,$to);			//用RMB转换汇率		 
		}
		if(!empty($rate)){
			$rate		= self::resetArray($rate);
		}
		return $rate;
	}
	
	/**
	 * 从新浪网获取汇率
	 *
	 * @param string $from
	 * @param string $to
	 * @return array $rate  各种汇率值 0-时间 1-买入价 2-卖出价 3-昨收盘 4-振幅 5-今开盘 6-最高价 7-最低价 8-最新价
	 */
	function getContent($from,$to){
		$from		= $from=='RMB'?'CNY':$from;
		$from		= $from=='EURO'?'EUR':$from;
		$to			= $to=='RMB'?'CNY':$to;
		$to			= $to=='EURO'?'EUR':$to;
		$url		= str_replace('@LIST@',$from.$to,$this->getUrl());

		$content	= file_get_contents($url);              	//从新浪网获取汇率
		
		preg_match("/\"(.*?)\"/i",$content,$rs);				//截取引号内的值  即为各种汇率的值
		if(empty($rs[1])){
			if($this->do < $this->err_num){
//				sleep($this->sec);									//暂停几秒后继续取汇率
				$this->do++;
				return self::getContent($from,$to);
			}
		}else{
			$rate		= @explode(",",$rs[1]);
			return $rate;
		}
	}
	
	/**
	 * 重组汇率数组
	 */
	function resetArray($info){
		$date	= date('Y-m-d');
		$time	= date('Y-m-d H:i:s');
		if(!empty($info)){
			$list['rate_date']		= $date;
			$list['opened_y']		= $info[3];
			$list['opened_t']		= $info[5];
			$list['highest_price']	= $info[6];
			$list['lowest_price']	= $info[7];
			$list['bid_price']		= $info[1];
			$list['selling_price']	= $info[2];
			$list['insert_time']	= $time;
		}
		return $list;
	}
	
	/**
	 * 计算汇率
	 */
	function calculate($rate){
		if(is_array($rate)){
			for($i=1;$i<=8;$i++){
				$i!=4&&$rate[$i]!=0?$rate[$i]	= round(1/$rate[$i],4):'';		//振幅不计算   汇率为0时也不计算
			}
		}
		return $rate;
	}
	
	/**
	 * 计算二阶汇率   以RMB为计算桥梁 
	 * 说明：USD-TWD和TWD-USD都不能从新浪网获取到汇率，通过USD-RMB,RMB-TWD来计算出USD-TWD的汇率
	 */
	function fetchTwo($from,$to){
		$rate1		= self::getContent($from,'CNY');
		if(empty($rate1)){
			$rate1	= self::getContent('CNY',$from);
			$rate1	= self::calculate($rate1);
		}
		$rate2		= self::getContent('CNY',$to);
		if(empty($rate2)){
			$rate2	= self::getContent($to,'CNY');
			$rate2	= self::calculate($rate2);
		}
		if(!empty($rate1)&&!empty($rate2)){
			for($i=1;$i<=8;$i++){
				$rate[$i]=round($rate1[$i]*$rate2[$i],4);
			}
		}
		return $rate;
	}
}