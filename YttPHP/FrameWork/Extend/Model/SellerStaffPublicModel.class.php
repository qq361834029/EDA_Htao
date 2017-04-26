<?php 
/**
 * 卖家员工管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	卖家员工信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2014/1/15 16:11:23
 */

class SellerStaffPublicModel extends Model {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'user';
	public $_asc 		 = true;  	        //默认排序
	public $_sortBy 	 = 'user_name';      //默认排序字段
	/// 自动验证设置
	protected $_validate = array(
		array("user_type",'require',"require",1),
		//array("use_usbkey",'require',"require",1),
		//array("usbkey","use_usbkey",'require',0,'ifcheck','',1), 
		array("user_name",'require',"require",1),
		array("user_name",'email',"valid_email",1), 
		array("user_name",'',"unique",1,'unique'),//验证唯一  
		//array("real_name",'require',"require",1),
		//array("real_name",'',"unique",1,'uniquenoempty'),//验证唯一  
		//array("is_enable",'require',"require",1),
		array("role_id","require",'require',1),//验证唯一  
		array("user_password",'require',"require",0),
		array("user_password",'user_passpord',"valid_password",0),
		array('user_password_confirm','user_password','confirm_password_error',1,'confirm'), // 验证确认密码是否和密码一致
		array("",'validCompany','',1,'callbacks'), 
	);	
	
	/// 自动填充
	protected $_auto = array(array("user_password", "md5", 3, "function"));

	/**
	 * 自定义验证规则，用于验证选择用户类型后有可能的必填项
	 *
	 * @param  array $data
	 * @return  array
	 */
	protected function validCompany($data){
		// 用户类型为 厂家/客户 时所属公司必填
		if ($data['user_type']>1) {
			$vasd = array(array("company_id",'require',"require",1));
			return $this->_validSubmit($data,$vasd);
		}
	}

	/**
	 * 查看明细、修改时获取用户信息
	 *
	 * @param int $id
	 * @return  array
	 */
	public function getInfo($id){
		$where	= 'id=' . (int)$id . getBelongsWhere('', 'company_id');
		return $this->field('*,if(user_type=4,company_id,0) as logistics_id,if(user_type=2 or user_type=3,company_id,0) as factory_id')->where($where)->find(); 
	}
}