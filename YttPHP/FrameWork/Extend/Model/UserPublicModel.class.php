<?php

/**
 * 用户信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	用户信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class UserPublicModel extends Model {
	
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'user';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
				array("user_type",'require',"require",1),
				//array("use_usbkey",'require',"require",1),
				//array("usbkey","use_usbkey",'require',0,'ifcheck','',1), 
				array("user_name",'require',"require",1),
				array("user_name",'email',"valid_email",1), 
				array("user_name",'',"unique",3,'unique'),//验证唯一  
				//array("real_name",'',"unique",1,'uniquenoempty'),//验证唯一  
				array("role_id","require",'require',1),  
				array("user_password",'require',"require",0),
				array("user_password",'user_passpord',"valid_password",0),
				array('user_password_confirm','user_password','confirm_password_error',1,'confirm'), // 验证确认密码是否和密码一致
				array("",'validCompany','',1,'callbacks'), 
				array("user_type",'require',"require",1),
				
	);
	
	/// 自动填充
	protected $_auto = array(
					   array("real_name", "trim", 3, "function"), // 真实姓名
					   array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间
					   array("update_time", "date", 2, "function", "Y-m-d H:i:s"), /// 更新时间	
					   array("user_password", "md5", 1, "function"),
	);

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
		}
		return $this->_validSubmit($data,$vasd);
	}
	
	/**
	 * 查看明细、修改时获取用户信息
	 *
	 * @param int $id
	 * @return  array
	 */
	public function getInfo($id){
		return _formatArray($this->field('*,if(user_type=4,company_id,0) as logistics_id,if(user_type=5,company_id,0) as warehouse_id,if(user_type=2 or user_type=3,company_id,0) as factory_id')->find($id)); 
	}
	
	/**
	 * 更新当前登陆用户密码
	 *
	 * @param  string
	 * @return  abool
	 */
	public function updatePwd($passwd){
		return $this->setField(array('id'=>$_SESSION[C('USER_AUTH_KEY')],'user_password'=>md5($passwd))); 
	}
	
	/**
	 * 重置用户密码
	 *
	 * @param  string
	 * @return  bool
	 */
	public function resetPasswd($id,$passwd){
		return $this->setField(array('id'=>$id,'user_password'=>md5($passwd))); 
	}
	
	/**
	 * 用户登陆成功信息处理
	 *
	 * @param   array $authInfo
	 * @return  bool
	 */
	public function loginUserInfo($authInfo){
		/// 设置验证信息
		$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
		if($authInfo['super_admin']=='1') {
			$_SESSION[C('ADMIN_AUTH_KEY')]			=	true;
			$_SESSION[C('SUPER_ADMIN_AUTH_KEY')]	=	true;
		}else {
			$var = M('Role')->find($authInfo['role_id']);
			if($var['is_admin']=='1') {
				$_SESSION[C('ADMIN_AUTH_KEY')]	=	true;
			}
			unset($var);
		}
		/// 设置系统中需要使用的登陆用户信息
		$result = array();
		$result['id']				= $authInfo['id'];				/// 用户ID
		$result['user_id']			= $authInfo['id'];				/// 登录名
		$result['user_name'] 		= $authInfo['user_name'];		/// 真实名称
		$result['role_id'] 			= $authInfo['role_id'];			/// 角色ID
		$result['state'] 			= $authInfo['to_hide'];			/// 当前状态
		$result['user_type']		= $authInfo['user_type'];		/// 1 公司，2 客户，3 厂家	 
		$result['use_usbkey']		= $authInfo['use_usbkey'];		/// 是否使用USBkey		 
		$result['usbkey']			= $authInfo['usbkey'];			/// USBKEY对应编码	
		$result['real_name']		= $authInfo['real_name'];		/// 角色名称
		$result['doc_audit']		= $authInfo['doc_audit'];		/// 单据审核
		$result['digital_format']	= $authInfo['digital_format'];	/// 数字显示格式
		$result['guide']			= $authInfo['guide'];			/// 是否显示向导
		$result['index']			= $authInfo['index'];			/// 默认首页
		$result['company_id']		= $authInfo['company_id'];		/// 用户对应的厂家，客户ID
		/// 如果是公司用户根据绑定员工信息获取所属公司
		if ($authInfo['user_type'] == 1) {
			$var = M('Employee')->field('basic_id,department_id')->getByEmployeeName($authInfo['real_name']);
			$result['employee_name']	 = $var['employee_name'];
			$result['basic_id']			 = $var['basic_id'];
			$result['department_id']	 = $var['department_id'];
			$result['basic_id'] && $var2 = M('Basic')->field('basic_name')->getById($result['basic_id']);
			$result['basic_name']		 = $var2['basic_name'];
			$var['department_id'] > 0 && $result['group_department_uid'] = $this->getUserIdByDept($var['department_id']);
			unset($var,$var2);
		}
		/// 如果启用key缓存用户key信息
		if ($authInfo['usbkey']>0 && $authInfo['usbkey']>0) {
			$var = M('Epass')->find($authInfo['usbkey']);
			$result['epass_no']		 = $var['epass_no'];
			$result['epass_key']	 = $var['epass_key'];
			$result['epass_data']	 = $var['epass_data'];
			unset($var);
		}
		/// 获取用户角色类别
		$var = M('Role')->find($result['role_id']);
		$result['role_type']		 = $var['role_type'];
		if($var['role_type']==C('SELLER_ROLE_TYPE')){
			$result['vat_quota_warning']	= D('Vat')->warehouseDebtVat($authInfo['company_id']);
		}
		/// 保存至session
		$_SESSION['LOGIN_USER'] = $result;
		/// 更新用户登陆信息
		$data = array();
		$data['id']					=	$authInfo['id'];
		$data['last_login_time']	=	date('Y-m-d H:i:s');
		$this->save($data);
	}
	
	
	/**
	 * 获取某个部门的用户帐号
	 *
	 * @param int $dept_id
	 * @return array
	 */
	private function getUserIdByDept($dept_id) {
		$rs	= M("employee")->where('department_id='.$dept_id)->select();
		foreach ((array)$rs as $list) {
			$name[] = "'".$list['employee_name']."'";
		}
		$rs = $this->field("group_concat(id) as uid")
					->where(" user_type=1 and  real_name in (".implode(",", $name).")")
					->group(' user_type')
					->find();		
		return $rs['uid'];
	}
	
}