<?php

/**
 * 快递公司信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class ExpressPublicModel extends CommonModel {
	
	protected $tableName = 'company';
	
	protected $_validate	 =	 array(
		array("comp_no",'require',"require",1),
		array("comp_no",'is_no',"valid_error",1),  	
		array("comp_no",'',"unique",1,'unique',3,array('comp_type'=>3)),//验证唯一
		array("comp_name",'require',"require",1),
		array("comp_name",'',"unique",1,'unique',3,array('comp_type'=>3)),//验证唯一
		array("email",'email',"valid_email",2), 
		array("priority",'pst_integer',"pst_integer",2), 
		array("",'validCountry','',1,'callbacks'),
	);

	protected function validCountry($data){
		if (!empty($data['country_name'])) {
			$vasd = array(array("country_id",'pst_integer',"require",1));
		}
		return $this->_validSubmit($data,$vasd);
	}
}