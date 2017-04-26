<?php

/**
 * 发票编号
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Behavior
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceNoPublicBehavior extends Behavior {
	
	protected $module;
	
	public function run(&$params){
		if(ACTION_NAME=='insert'){
			$maxno	= $this->setMaxNo($params);
			if(empty($maxno)){
				return ;
			}
			M($this->module)->where('id='.$params['id'])->setField('invoice_no',$maxno);
		}
	}
	
	/// 设置发票编号
	public function setMaxNo($params){
		switch(MODULE_NAME){
			case 'InvoiceIn':
				$this->module = 'invoice_in';
				$config	= C('invoiceIn');break;
			case 'InvoiceOut':
				if($params['invoice_type']==2){
					$this->module	= 'invoice_out';
					$config	= C('invoiceReturn');
				}else{
					$this->module	= 'invoice_out';
					$config	= C('invoiceOut');
				}
				break;
			default:
				break;
		}
		if(empty($config)||$config['invoice_no']==2){
			return ;
		}
		$model	= M($this->module);
		$serial	= intval($config['serial'])>0?$config['serial']:4;
		$prefix	= empty($config['prefix'])?'AC':$config['prefix'];
		if($config['create_method']==2){
			$info	= $model->field("IFNULL(max(right(invoice_no,".$serial.")),0) as  max_no")->where("mid(invoice_no,3,6)=DATE_FORMAT((select max(invoice_date) from ".$this->module." where id='".$params['id']."'),'%y%m%d')")->select();
			$maxno		= intval($info[0]['max_no'])+1; 
			$maxno 		= sprintf("%0".$serial."d",$maxno);
			$maxno		= $prefix.date('ymd',strtotime(formatDate($params['invoice_date']))).$maxno;
		}else{
			$info		= $model->field("IFNULL(max(right(invoice_no,".$serial.")),0) as  max_no")->select();
			$maxno		= $info[0]['max_no']+1;
			$maxno 		= sprintf("%0".$serial."d",$maxno);
			$maxno		= $prefix.$maxno;
		}
		return $maxno;
	}
}
?>