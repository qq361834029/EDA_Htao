<?php

/**
 * 发票假期
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceHolidayPublicModel extends CommonModel {
	
	protected $tableName = 'invoice_holiday';
	
	// 自动验证设置
	protected $_validate	 =	 array(
		array("holiday_date",'require',"require",1), 	
		array('holiday_type','require','require',1),
		array("holiday_date",'repeat',"repeat",1,'unique',array('to_hide'=>1)),//验证唯一 
	);
}