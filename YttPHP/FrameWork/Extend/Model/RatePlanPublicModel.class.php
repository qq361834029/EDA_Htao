<?php

/**
 * 汇率计划任务
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class RatePlanPublicModel extends Model{
	
	protected $tableName	= 'rate_info';
	
	protected $email		= '542092324@qq.com';
	
	protected $error;
	
	public function index(){

		//汇率中心 取汇率
		$this->getRate();
		$this->sendMail($this->email);
		//app 取汇率
		$app	= M('rate_config')->select();
		foreach($app as $_key=>$_val){
			$this->getRate($_val);
			$this->saveDiffRate($_val);
			//发送错误日志
			$this->sendMail($_val['email']);
		}
	}
	
	/**
	 * 取汇率
	 * @param array $list
	 */
	public function getRate($list=array()){
		$rateInfo	= $this->getCurrency($list['app_db']);
		if(!empty($list)){
			$rateInfo	= $this->getCenterRate($rateInfo);
		}
		foreach($rateInfo as &$info){
			if($info['rate_center']==0){
				$rate	= $this->getRateToday($info['currency_from'],$info['currency_to'],$list);
				$info	= array_merge($info,$rate);
			}
		}
		$this->saveRate($rateInfo,$list);
	}
	
	//取 币种
	public function getCurrency($app_db=null){
		if(empty($app_db)){
			$model	= M('currency');
		}else{
			$model	= M($app_db.'.currency');
		}
		$currency	= $model->where('to_hide=1 and is_delete=1')->select();
		$rateInfo	= array();
		foreach($currency as $value){
			foreach($currency as $val){
				if($value['id']==$val['id']) continue;
				$tmp['from_currency_id']	= $value['id'];
				$tmp['currency_from']		= $value['currency_no'];
				$tmp['to_currency_id']		= $val['id'];
				$tmp['currency_to']			= $val['currency_no'];
				$tmp['rate_date']			= date('Y-m-d');
				$rateInfo[]					= $tmp;
				unset($tmp);
			}
		}
		return $rateInfo;
	}
	
	/**
	 * 从汇率中心获取汇率
	 * @param array $rateInfo
	 * @return array
	 */
	public function getCenterRate($rateInfo){
		$list	= M('rate_info')->where("rate_date='".date('Y-m-d')."'")->select();
		foreach($rateInfo as &$val){
			foreach($list as $rate){
				unset($rate['id']);
				if($val['from_currency_id']==$rate['from_currency_id']&&$val['to_currency_id']==$rate['to_currency_id']){
					$val['rate_center']	= 1;
					$val	= array_merge($val,$rate);
				}
			}
		}
		return $rateInfo;
	}
	/**
	 * 获取今天汇率
	 * @param string $from
	 * @param string $to
	 * @param array $list
	 * @return array
	 */
	public function getRateToday($from,$to,$list=array()){
		$rate	= D('SinaRate')->getRate($from,$to);
		if(empty($rate)){
			$rate	= D('GoogleRate')->getRate($from,$to);
		}
		if(empty($rate)){
			$db	= empty($list['app_db'])?C('DB_NAME'):$list['app_db'];
			$this->saveLog( date('Y-m-d H:i:s').'数据库'.$db.':'.$from.'--'.$to.'获取汇率失败' );
		}
		return $rate;
	}
	/**
	 * 保存汇率
	 * @param array $rateInfo
	 * @param array $app
	 */
	public function saveRate($rateInfo,$app=null){
		if(empty($app)){
			$model	= M('rate_info');
		}else{
			$model	= M($app['app_db'].'.rate_info');
		}
		$model->startTrans(); 
		try{
			$model->where("rate_date='".date('Y-m-d')."'")->delete();
			foreach($rateInfo as $list){
				$model->where("rate_date='".$list['rate_date']."' and from_currency_id='".$list['from_currency_id']."' and to_currency_id='".$list['to_currency_id']."'")->delete();
				$model->data($list)->add();
			}
			$model->commit();
		}catch(Exception $e){
			$model->rollback();
			$db	= empty($app['app_db'])?C('DB_NAME'):$app['app_db'];
			$this->saveLog( date('Y-m-d H:i:s').' '.$db.'数据库添加汇率失败：'.$e->getMessage());
		}
	}
	/**
	 * 保存错误日志
	 * @param string $msg
	 */
	public function saveLog($msg){

		$this->error[]	= $msg;
	}
	/**
	 * 同步之前日期的汇率
	 * @param array $app
	 */
	public function saveDiffRate($app){
		if(empty($app['app_db'])){
			return ;
		}
		$currency	= M($app['app_db'].'.currency')->field('group_concat(id) id')->where('to_hide=1 and is_delete=1')->find();
		$currency	= empty($currency['id'])?0:$currency['id'];
		$sql	= "select * from rate_info where id not in (
						select a.id from rate_info a 
						inner join ".$app['app_db'].".rate_info b 
						on a.rate_date=b.rate_date and a.from_currency_id=b.from_currency_id and a.to_currency_id=b.to_currency_id
						where a.from_currency_id in (".$currency.") and a.to_currency_id in (".$currency.")
					) and from_currency_id in (".$currency.") and to_currency_id in (".$currency.")";
		if(!empty($app['start_date'])){
			$sql	.= " and rate_date>='".$app['start_date']."'";
		}
		
		$rs		= $this->query($sql);
		$model	= M($app['app_db'].'.rate_info');
		try{
			$model->startTrans(); 
			foreach((array)$rs as $key=>$list){
				$model->where("rate_date='".$list['rate_date']."' and from_currency_id=".$list['from_currency_id']." and to_currency_id=".$list['to_currency_id'])->delete();
				unset($list['id']);
				$model->data($list)->add();
			}
			$model->commit();
		}catch (Exception $e){
			$model->rollback();
			$this->saveLog( date('Y-m-d H:i:s').' '.$app['app_db'].'数据库同步汇率失败：'.$e->getMessage());
		}
	}
	
	///发送错误日志邮件
	public function sendMail($toMail){
		$log		= $this->error;
		$content	= @implode('<br>',(array)$log);
		//日志记录到数据库
		if(!empty($log)){
			$data		= array('error_msg'=>$content,'insert_date'=>date('Y-m-d'));
			M('rate_error')->data($data)->add();
		}
		$title		= date('Y-m-d').'取汇率失败';
		postEmail($toMail,$title,$content);
		unset($this->error);
	}
}