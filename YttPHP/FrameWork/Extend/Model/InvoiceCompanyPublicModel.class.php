<?php

/**
 * 发票公司
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceCompanyPublicModel extends CommonModel {
	
	/// 定义真实表名
	protected $tableName = 'invoice_company';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("company_name",'require',"require",1),	
		array("company_name",'repeat',"repeat",1,'unique','',array('comp_type' => 1)),//验证唯一 
		array("register_fund","money","money_error",2),
	);
}
?>