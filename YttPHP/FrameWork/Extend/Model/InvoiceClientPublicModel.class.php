<?php

/**
 * 发票客户
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceClientPublicModel extends CommonModel {
	
	/// 定义真实表名
	protected $tableName = 'invoice_company';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("company_name",'require',"require",1),	
		array("company_name",'repeat',"repeat",1,'unique','',array('comp_type' =>3)),//验证唯一 
		array("iva",'require','require',1),				
		array("iva","double",'double',2),
		array('iva',array(0,99),'iva_error','2','between'),	
		array("tax_no",'require','require',1),
		array("connect_client",'repeat','been_binded',2,'unique','',array('comp_type' => 3)),
	);
}