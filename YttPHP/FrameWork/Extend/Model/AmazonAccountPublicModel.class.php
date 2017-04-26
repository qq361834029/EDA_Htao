<?php

/**
 * Amazon账号信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */
class AmazonAccountPublicModel extends CommonModel {
	public $_asc 		 = true;  	        //默认排序
	public $_sortBy 	 = 'user_id';       //默认排序字段
	protected $tableName = 'amazon_site';
	
	/// 自动验证设置
	protected $_validate = array(
		array("user_id",'is_accounts',"is_accounts",1), 	//账号
		array("user_id",'','unique',1,'unique'),
		array("factory_id",'require',"require",0),   
		array("full_user_id",'require',"require",1), 	 
		array("full_user_id",'email',"valid_email",2),      //Amazon账号邮箱格式
		array("site_name",'require',"require",1),     
		array("access_key_id",'require',"require",1),      
		array("secret_acess_key_id",'require',"require",1),      
		array("merchant_id",'require',"require",1),          
		array("marketplace_id",'require',"require",1),      
	);
	
	public function getInfo($id){
		$where	= 'id=' . (int)$id . getBelongsWhere();
		$rs		= $this->where($where)->find();
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}		
		if(is_array($rs)&&$rs){
			$cache_site	= C('AMAZON_COUNTRY');
			$rs['site'] = $cache_site[$rs['site_id']];
		}
		return $rs;
	}
}