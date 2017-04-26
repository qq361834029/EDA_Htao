<?php

/**
 * 公共操作管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	公共操作
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class PublicPublicAction extends Action {
	protected $_verifyName	= '';
	// 检查用户是否登录
	
	public function __construct() {
		parent::__construct();
		$this->_verifyName	= $_REQUEST[C('VAR_CAPTCHA')] ? $_REQUEST[C('VAR_CAPTCHA')] : 'verify';
	}

	protected function checkUser() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('jumpUrl','Public/login');
			$this->error('没有登录');
		}
		
	}

    // 后台首页 查看系统信息
    public function main() {
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            'ThinkPHP版本'=>THINK_VERSION.' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round((@disk_free_space(".")/(1024*1024)),2).'M',
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
            );
        $this->assign('info',$info);
        $this->display();
    }

	// 用户登录页面
	public function login() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')]) && !isset($_SESSION[C('ADMIN_AUTH_KEY')])) {
			$this->show();
		}else{
			$this->index();
		}
	}

	public function index()
	{
		//如果通过认证跳转到首页
		redirect(__APP__);
	}

	// 用户登出
    public function logout()
    {
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
        }
		cookie('cookie_expire',null,-1);
//		windowClose();
        redirect(U('Public/login'));
    }

	// 登录检测
	public function checkLogin() {
		if(empty($_POST['user_name'])) {
			$this->error(L('login_failed'));
		}elseif (empty($_POST['password'])){
			$this->error(L('login_failed'));
		}
		$captcha_error	= $this->getCaptchaError();
		if ($captcha_error != '') {
			$this->error($captcha_error);
		}
        //生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['user_name']	= $_POST['user_name'];
        $map["to_hide"]		= array('ELT',1);
        $authInfo = RBAC::authenticate($map);
        //使用用户名、密码和状态的方式进行认证
        if(empty($authInfo)) {
            $this->error(L('account_unable'));
        }elseif ($authInfo['user_password'] != md5($_POST['password'])){
        	$this->error(L('login_failed'));
        }else {
        	$ip = trim($authInfo['user_ip']);
            if(!empty($ip)) {
            	if(!RBAC::authip($authInfo['user_ip'])){
            		$this->error(L('login_failed_ip'));
            	}
            }
            // 登陆时的epass检查
            if ($authInfo['use_usbkey']>0 && $authInfo['usbkey']>0) {
				if(!strpos($_SERVER["HTTP_USER_AGENT"],'MSIE 9.0') && !strpos($_SERVER["HTTP_USER_AGENT"],'MSIE 8.0') && !strpos($_SERVER["HTTP_USER_AGENT"],'MSIE 7.0') && !strpos($_SERVER["HTTP_USER_AGENT"],'MSIE 6.0')){
					$this->error(L('usbkey_ie'));
				}
				if (empty($_POST['epass_data']) || empty($_POST['epass_no'])) {
					$this->error(L('login_failed_insert_epass'));
				}
				$bool = D('Epass')->checkEpass(array('epass_no'=>$_POST['epass_no'],'epass_data'=>$_POST['epass_data']),$authInfo['usbkey']);
				if ($bool===false) {
					$this->error(L('login_failed_error_epass'));
				}
			}		
            $var = M('Role')->find($authInfo['role_id']);
            if($var['role_type'] == C('SELLER_ROLE_TYPE')){
                $this->checkArrears($authInfo['company_id']);
            }
            D('User')->loginUserInfo($authInfo);
			// 缓存访问权限
            RBAC::saveAccessList($authInfo['id']);
			$this->success(L('login_success'));

		}
	}
    
    public function checkArrears($company_id){
        $arrears_limit  = D('CompanyFactory')->where('factory_id='.$company_id)->getField('arrears_limit');
        if($arrears_limit != 2){
            $arrears_amount = D('Remind')->rechargeList($company_id);
            foreach((array)$arrears_amount as $money_amount){
                if($money_amount['total_need_paid'] > 0){
                    $this->error(L('arrears_limit_the_use_please_contact_us'));
                    break;
                }
            }
        }
    }

        // 页面访问Epass检查
	public function checkEpass(){
		if ($_SESSION['LOGIN_USER']['epass_no']!=$_POST['epass_no'] || $_SESSION['LOGIN_USER']['epass_data']!=$_POST['epass_data']) {
			$this->error(L('login_failed_error_epass'));
		}
		$this->success();
	}
	
	// 查看客服管理
	public function service(){
		$array = M('Service')->select();
    	foreach ((array)$array as $value) {
    		$rs[$value['name']] = $value['value'];
    	}
    	$this->assign('rs',$rs);
    	$this->display();
	}
    
	// 快捷菜单
	public function shortMenu(){
    	$list = M('ShortcutMenu')->where('user_id='.(int)getUser('id'))->order('menu_order asc,id desc')->select();
    	foreach ($list as &$value) {
    		$value['menu_name'] = title($value['action'],$value['model']);
    	}
    	$this->assign('list',$list);
    	$this->display();
    }
	 
	
	/**
	 * 用户注册页面
	 * 
	 * @author jph 20140127
	 */
	public function register() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')]) && !isset($_SESSION[C('ADMIN_AUTH_KEY')])) {
			$this->show();
		}else{
			$this->index();
		}
	}
	
	public function registerSuccess(){
		redirect(__URL__.'/login',2,'注册成功，2秒后跳转');
	}

	/**
	 * 生成验证码图像
	 * 验证码MD5加密串保存为$_SESSION[$this->_verifyName]
	 * @author jph 20140127
	 */
	public function buildImageVerify() {
		import("ORG.Util.Image");
		import('ORG.Util.StringOp');
		$imageModel	= new Image();
		$imageModel->buildImageVerify(4, 1, 'png', 48, 25, $this->_verifyName);		
	}

	/**
	 * 创建卖家及卖家用户，成功则直接登录
	 * @author jph 20140127
	 */
	public function insertFactory() {    
		$model					= D('Factory');  
		$userModel				= D('User');  
		$_POST['email'] =       trim($_POST['email']);
		$_POST['user_name']		= $_POST['email'];
		$_POST['real_name']		= $_POST['comp_name'];
		$_POST['contact']		= $_POST['comp_name'];
		$_POST['password']		= $_POST['user_password'];//登录用
		//$_POST['user_password']			&& $_POST['user_password']			= md5($_POST['user_password']);			// 密码加密	
		//$_POST['user_password_confirm'] && $_POST['user_password_confirm']	= md5($_POST['user_password_confirm']);	// 密码加密	
		//$_POST['create_time']   = date("Y-m-d H:i:s");			// 账号创建时间		
		///默认停用
		$_POST['to_hide']		= 2;
		///模型验证
		$model->create($_POST);   	
		///用户信息验证
		$user_info	= $userModel->create($_POST);
		if (false === $user_info) {  
			$model->addError($userModel->getError());
		}  
		//检查验证码
		$captcha_error	= $this->getCaptchaError();
		if ($captcha_error != '') {
			$err		= array('name'=>'captcha', 'value'=>$captcha_error);
			$model->addError(array($err));
		}		

		$error	= $model->getError();
		if (!empty($error)) {
			$this->error($error, 2);
		}
		
		///保存POST信息->返回主表ID
		$model->startTrans();
		$id		=	$model->add();   
		if ($id!==false) { ///保存成功 
			cacheDd(12, $id);
			cacheDd(13, $id);	
			//保存账户信息 st
			$user_info['user_type']		= 2;//1：公司，2：卖家，3：卖家员工
			$user_info['company_id']	= $id;
			$user_id					= $userModel->add($user_info);
			if ($user_id!==false) {///保存成功 
				$model->commit();
				cacheDd(10, $user_id);
				cacheDd(11, $user_id);		
				cacheDd(23, $user_id);
				///默认停用
				$this->error ('',3);
				//$this->checkLogin();
			} else { ///失败提示 
				$model->rollback();
				$this->error (L('_ERROR_'));
			}  
			//保存账户信息 ed
		} else { ///失败提示 
			$model->rollback();
			$this->error (L('_ERROR_'));
		}   
		
	}	
	
	/**
	 * 检查验证码
	 * @author jph 20140801
	 * @param type $captcha
	 * @return int 0:空; -2:已过期; -1:错误; 1:正确
	 */
	public function checkCaptcha($captcha = null){
		is_null($captcha) && $captcha	= $_POST['captcha'];
		$session_captcha	= session($this->_verifyName);
		if (empty($captcha)) {
			return 0;
		} elseif (empty($session_captcha)){
			return -2;
		} elseif(md5($captcha) != $session_captcha) {
			return -1;
		} else {
			return 1;
		}	
	}
	
	/**
	 * 获取验证码错误信息
	 * @author jph 20140801
	 * @param string $captcha
	 * @return string
	 */
	public function getCaptchaError($captcha = null){
		$verify_captcha	= $this->checkCaptcha($captcha);
		switch ($verify_captcha) {
			case -2:
				$error	= L('captcha_expired');
				break;
			case -1:
				$error	= L('captcha_error');
				break;
			case 0:
				$error	= L('captcha_empty');
				break;
			case 1:
			default:
				$error	= '';
				break;
		}
		return $error;
	}



	// 忘记密码
	public function forgotPassword() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')]) && !isset($_SESSION[C('ADMIN_AUTH_KEY')])) {
			$this->show();
		}else{
			$this->index();
		}
	}	
	
	// 重置密码检测
	public function checkforgotPassword() {
		if(empty($_POST['user_name'])) {
			$this->error(L('email_empty'));
		}
		$captcha_error	= $this->getCaptchaError();
		if ($captcha_error != '') {
			$this->error($captcha_error);
		}
        //生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['user_name']	= $_POST['user_name'];
        $authInfo = RBAC::authenticate($map);
        //使用用户名(邮箱)进行认证
        if(empty($authInfo)) {//无效的邮箱
            $this->error(L('email_unregistered'));
        }else {
        	//发送邮件
			$reset_password_key	= md5(getRands() . $_POST['user_name'] . getRands());
			$reset_url	= U('/'.MODULE_NAME.'/resetPassword/confirmation/'.$reset_password_key, '', true, false, true);
			$content	= L('email_info_1') . "<br /><br />" . $reset_url . "<br /><br />" . L('email_info_2') . "<br /><br />" . U('/', '', true, false, true) . "<br /><br />" . L('email_info_3');
			if(postEmail($_POST['user_name'], L('resetPasswd'), $content)) {//邮件发送成功
				//保存密钥
				D('User')->where('id=' . $authInfo['id'])->setField('reset_password_key', $reset_password_key);
				$this->success(sprintf(L('email_send_success'), $_POST['user_name']));
			} else {//邮件发送失败
				$this->error(L('email_send_failed'));
			}
		}
	}	

	// 重置密码
	public function resetPassword() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')]) && !isset($_SESSION[C('ADMIN_AUTH_KEY')])) {
			//生成认证条件
			$map            =   array();
			// 支持使用绑定帐号登录
			$map['reset_password_key']	= $_GET['confirmation'];
			$authInfo = RBAC::authenticate($map);
			//使用用户名(邮箱)进行认证
			if(empty($authInfo)) {//密钥错误或已被覆盖
				redirect(U('/'.MODULE_NAME.'/forgotPassword'));			
			} else {
				$this->show();
			}
		}else{
			$this->index();
		}
	}	
	
	
	// 重置密码检测
	public function checkResetPassword() {
		if (empty($_POST['user_password'])){
			$this->error(L('password_empty'));
		}elseif (empty ($_POST['user_password_confirm'])) {
			$this->error(L('password_confirm_empty'));
		}elseif ($_POST['user_password'] != $_POST['user_password_confirm']) {
			$this->error(L('password_input_val_neq'));
		}
        //生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['reset_password_key']	= $_POST['confirmation'];
        $authInfo = RBAC::authenticate($map);
        if(empty($authInfo)) {//密钥错误或已被覆盖
            $this->error(L('email_unregistered'));
        }else {//重置密码
        	D('User')->where('id=' . $authInfo['id'])->setField(array('reset_password_key'=>'', 'user_password'=>md5($_POST['user_password'])));
			$this->success(L('reset_password_success'));
		}
	}	
	///合并
	public function addCombine(){
		$where		    = $sale_order_ids = trim($_GET['sale_order_ids']);
		$sale_order_ids = explode(',',$sale_order_ids);
		if(count($sale_order_ids)>1){
			sort($sale_order_ids,SORT_NUMERIC);
			//取第一个订单的处理单号为合并订单的处理单号
			$sale_order_no = M('sale_order')->where('id='.$sale_order_ids[0])->getField('sale_order_no');
			if($sale_order_no){
				$rs		   = M('sale_order')->where('id in('.$where.')')->setField('sale_order_no',$sale_order_no);
			}
			$rs===FALSE?$this->error(L('_OPERATION_FAIL_')):$this->error(L('_OPERATION_SUCCESS_')); 
		}else{
			$this->error(L('two_more'));
		}
	}

	///取消合并
	public function delCombine(){
		$sale_order_no = trim($_GET['sale_order_no']);
		if($sale_order_no){
			$sale_order_ids = M('sale_order')->field('id')->where('sale_order_no="'.$sale_order_no.'"')->order('id asc')->select();
			if(is_array($sale_order_ids)&&$sale_order_ids){
				foreach ($sale_order_ids as $key=>$row){
					$where[$row['id']] = $row['id'];
				}
				$rs	= M('sale_order')->where('id in('.implode(',',$where).')')->setField('sale_order_no','');
			}
			$rs===FALSE?$this->error(L('_OPERATION_FAIL_')):$this->error(L('_OPERATION_SUCCESS_')); 
		}else{
			$this->error(L('_OPERATION_FAIL_'));
		}
	}

	/// 获取token值	
	public function getTokenStatus() {
		$model    = D('EbayAccount');
		$data     = $model->find(intval($_GET['id']));
		$notice   = L('system_error');
		if($data['user_id']&&$data['site_id']){
			import("ORG.Util.EbayToken"); 
			$EbayToken = new ModelEbayToken($data['user_id'],$data['site_id']);
			$notice    = $EbayToken->getTokenStatus()==1?L('token_valid'):L('token_novalid'); //返回值0失效 1有效
		}
		throw_json($notice);
		return false;
	}

	public function cainiaoRequest(){
		header('Content-Type:text/html; charset=utf-8');
		set_time_limit(0);
		$limit	= $_GET['limit'] > 0 ? intval($_GET['limit']) : 50;
		$debug	= $_GET['debug'] > 0 ? true : false;
		cainiao_load_file();
		cainiao_process_request($limit, $debug);
		echo '<br />OK!';
	}

	public function dhlRequest(){
		header('Content-Type:text/html; charset=utf-8');
		$request_type	= $_GET['request_type'] ? $_GET['request_type'] : 'createShipmentDD';
		$dateTime	= date('Y-m-d H:i:s');
		$time	= date('H:i:s');
		$start		= C('DHL_LIMIT_DAY_START_HOUR') . ':' . C('DHL_LIMIT_DAY_START_MINUTE') . ':00';
		$end		= C('DHL_LIMIT_DAY_END_HOUR') . ':' . C('DHL_LIMIT_DAY_END_MINUTE') . ':00';
		$type	= array('createShipmentDD');
		if (in_array($request_type, $type) && $start <= $time && $time < $end) {
			echo '每天' . $start . '-' . $end . '(' . C('DEFAULT_TIMEZONE') . ')时间段不运行处理' . implode(', ', $type) . '请求！';
			exit;
		}

		$week		= date('w') > 0 ? date('w') : 7;
		$week_start	= C('DHL_LIMIT_WEEK_START') > 0 ? C('DHL_LIMIT_WEEK_START') : 7;
		$week_end	= C('DHL_LIMIT_WEEK_END') > 0 ? C('DHL_LIMIT_WEEK_END') : 7;
		$start_time	= date('Y-m-d', strtotime(($week > $week_start ? '-' . ($week - $week_start) : '+' . ($week_start - $week)) . ' days')) . ' ' . C('DHL_LIMIT_WEEK_START_HOUR') .':' . C('DHL_LIMIT_WEEK_START_MINUTE') . ':00';
		$end_time	= date('Y-m-d', strtotime(($week > $week_end ? '-' . ($week - $week_end) : '+' . ($week_end - $week)) . ' days')) . ' ' . C('DHL_LIMIT_WEEK_END_HOUR') .':' . C('DHL_LIMIT_WEEK_END_MINUTE') . ':00';
		if ($end_time < $start_time) {
			$end_time		= date('Y-m-d H:i:s', strtotime($end_time) + 7 * 24 * 60 * 60);
		}
		if (in_array($request_type, $type) && $start_time <= $dateTime && $dateTime < $end_time) {
			echo $start_time . ' - ' . $end_time . '(' . C('DEFAULT_TIMEZONE') . ')时间段不运行处理' . implode(', ', $type) . '请求！';
			exit;
		}
		
		$debug			= $_GET['debug'] > 0 ? true : false;
		express_api_load_file('Dhl');
		echo 'Start<hr />';
		$result	= dhl_process_request($request_type);
		if (is_object($result)) {
			$error			= $result->getError();
			if ($debug) {
				if ($error) {
					echo '<br /><br />';
					echo implode('<br />', $error);
				}
				echo '<br /><br />DHL LOG:<br />';
				dump($result->getProperty('dhl_log'));
				echo '<br /><br />SALE LIST:<br />';
				dump($result->getProperty('sale_list'));
			} else {
				echo 'Successful!<br />';
			}			
		} else {
			echo L('no_record_for_search') . '<br />';
		}
		echo '<hr />End';
	}

	public function dhlUpdateSaleOrderState(){
		addLang('DHL');
		$sale_ids				= array();
		$saleOrder				= D('SaleOrder');
		$old_sale_order_state	= C('SALE_ORDER_STATE_PENDING');
		$new_sale_order_state	= C('SALE_ORDER_STATE_EXPORTING');
		$state_log_comments		= L('dhl_create_shipment');
		$sale_where		= array(
							'sale_order_state'	=> $old_sale_order_state,
							'id'				=> array('in', $sale_ids),
		);
		$ids			= $saleOrder->where($sale_where)->getField('id', true);
		$saleOrder->updateSaleOrderStateById($ids, $new_sale_order_state, $state_log_comments);
	}
	
	public function correosRequest(){
		header('Content-Type:text/html; charset=utf-8');
		$request_type	= $_GET['request_type'] ? $_GET['request_type'] : 'createShipmentDD';
		$dateTime		= date('Y-m-d H:i:s');
		$time			= date('H:i:s');
		$start			= C('CORREOS_LIMIT_DAY_START_HOUR') . ':' . C('CORREOS_LIMIT_DAY_START_MINUTE') . ':00';
		$end			= C('CORREOS_LIMIT_DAY_END_HOUR') . ':' . C('CORREOS_LIMIT_DAY_END_MINUTE') . ':00';
		$type			= array('createShipmentDD');
		if (in_array($request_type, $type) && $start <= $time && $time < $end) {
			echo '每天' . $start . '-' . $end . '(' . C('DEFAULT_TIMEZONE') . ')时间段不运行处理' . implode(', ', $type) . '请求！';
			exit;
		}

		$week		= date('w') > 0 ? date('w') : 7;
		$week_start	= C('CORREOS_LIMIT_WEEK_START') > 0 ? C('CORREOS_LIMIT_WEEK_START') : 7;
		$week_end	= C('CORREOS_LIMIT_WEEK_END') > 0 ? C('CORREOS_LIMIT_WEEK_END') : 7;
		$start_time	= date('Y-m-d', strtotime(($week > $week_start ? '-' . ($week - $week_start) : '+' . ($week_start - $week)) . ' days')) . ' ' . C('CORREOS_LIMIT_WEEK_START_HOUR') .':' . C('CORREOS_LIMIT_WEEK_START_MINUTE') . ':00';
		$end_time	= date('Y-m-d', strtotime(($week > $week_end ? '-' . ($week - $week_end) : '+' . ($week_end - $week)) . ' days')) . ' ' . C('CORREOS_LIMIT_WEEK_END_HOUR') .':' . C('CORREOS_LIMIT_WEEK_END_MINUTE') . ':00';
		if ($end_time < $start_time) {
			$end_time		= date('Y-m-d H:i:s', strtotime($end_time) + 7 * 24 * 60 * 60);
		}
		if (in_array($request_type, $type) && $start_time <= $dateTime && $dateTime < $end_time) {
			echo $start_time . ' - ' . $end_time . '(' . C('DEFAULT_TIMEZONE') . ')时间段不运行处理' . implode(', ', $type) . '请求！';
			exit;
		}

		$debug			= $_GET['debug'] > 0 ? true : false;
		express_api_load_file('Correos');
		echo 'Start<hr />';
		$result	= correos_process_request($request_type);
		if (is_object($result)) {
			$error			= $result->getError();
			if ($debug) {
				if ($error) {
					echo '<br /><br />';
					echo implode('<br />', $error);
				}
				echo '<br /><br />CORREOS LOG:<br />';
				dump($result->getProperty('correos_log'));
				echo '<br /><br />SALE:<br />';
				dump($result->getProperty('sale'));
			} else {
				echo 'Successful!<br />';
			}
		} else {
			echo L('no_record_for_search') . '<br />';
		}
		echo '<hr />End';
	}

	public function correosUpdateSaleOrderState(){
		addLang('Correos');
		$sale_ids				= array();
		$saleOrder				= D('SaleOrder');
		$old_sale_order_state	= C('SALE_ORDER_STATE_PENDING');
		$new_sale_order_state	= C('SALE_ORDER_STATE_EXPORTING');
		$state_log_comments		= L('correos_create_shipment');
		$sale_where		= array(
			'sale_order_state'	=> $old_sale_order_state,
			'id'				=> array('in', $sale_ids),
		);
		$ids			= $saleOrder->where($sale_where)->getField('id', true);
		$saleOrder->updateSaleOrderStateById($ids, $new_sale_order_state, $state_log_comments);
	}

	/*
	 * 每日统计发货订单数
	 */
	public function countSaleOrderByExpress(){
		$model	= M('SaleOrderCount');
		$update_time	= date('Y-m-d',strtotime('-1 day'));
		$model->where('count_date="'.$update_time.'"')->delete();
		$sql	= 'INSERT INTO `sale_order_count`(`express_id`,`factory_id`,`warehouse_id`,`count_num`,`count_date`)
					SELECT express_id,factory_id,warehouse_id,count(id),DATE(send_date) FROM `sale_order`
					where sale_order_state in ('.C('ADD_QUESTION_ORDER_AUTOSEARCH').') and DATE(send_date)="'.$update_time.'"'.'
					group by express_id,factory_id,warehouse_id,DATE(send_date) order by send_date';
		$model->query($sql);
	}

	/**
	 * 菜鸟退货单补充请求入库API队列
	 */
	public function cainiaoInBound(){
		$where			= array(
			'return_logistics_no'	=> array('in', array('')),
		);
		$join			= 'inner join __STATE_LOG__ l on l.object_type=' . array_search('ReturnSaleOrder', C('STATE_OBJECT_TYPE')) . ' and l.object_id=r.id and l.state_id in (' . C('STORAGE_ABNORMAL') . ', ' . C('RETURN_FOR_DELIVERY') . ', ' . C('RETURN_SHELVES') . ')';
		$inBoundList	= M('ReturnSaleOrder')->alias('r')->join($join)->where($where)->group('r.id')->getField('r.id, return_logistics_no, min(l.create_time) as create_time');
		$product_info	= array();
		foreach ($inBoundList as $return_sale_id => $inBound) {
			$params						= D('ReturnSaleOrderStorage')->relation(true)->where('return_sale_order_id=' . $return_sale_id)->find();
			$params['eventTime']		= $inBound['create_time'];
			$params['occurTime']		= $inBound['create_time'];
			$params['_module']			= 'ReturnSaleOrderStorage';
			$params['_action']			= 'update';
			$params['storage_abnormal']	= $params['storage_abnormal_reason'] ? 1 : 0;
			$product_id					= array();
			foreach ($params['detail'] as &$detail) {
				$detail['return_sale_order_number']	= $detail['quantity'] - $detail['drop_quantity'];
				if (!isset($product_info[$detail['product_id']])) {
					$product_id[$detail['product_id']]	= $detail['product_id'];
				}
			}
			if (!empty($product_id)) {
				$product_info	+= M('Product')->where(array('id'=>array('in',$product_id)))->getField('id,check_status,check_weight,weight');
			}
			foreach ($params['detail'] as &$detail) {
				$detail['weight']	= $product_info[$detail['product_id']]['check_weight'] == C('CHECK_STATUS_PASS') ? $product_info[$detail['product_id']]['check_weight'] : $product_info[$detail['product_id']]['weight'];
			}
			dump($inBound['return_logistics_no'] . ':');
			try {
				$CaiNiaoApi				= new CaiNiaoApiPublicBehavior();
				$params['is_return']	= $_GET['return'] == 1 ? true : false;
				$params['method_name']	= 'inbound';
				dump($CaiNiaoApi->brf($params));
			} catch (Exception $ex) {
				dump($ex->getMessage());
			}
		}
	}

	///仓储费 日结余
	public function warehouseFeeBalance(){
		header('Content-Type:text/html; charset=utf-8');
		if(empty($_GET['date'])){
			$this_day	= date('Y-m-d', strtotime("-2 day"));
		}else{
			$this_day	= date('Y-m-d',  strtotime($_GET['date']));
		}
		$factory	= M('company_factory')->field('a.factory_id,warehouse_fee_start_date,MAX(ifnull(b.account_date,"0000-00-00")) as account_date,MIN(s.in_date) as stock_date')
				->join('a left join warehouse_account b on a.factory_id=b.factory_id and account_date<="'.$this_day.'" inner join product p on p.factory_id=a.factory_id'
						. ' inner join stock_in s on s.product_id=p.id and in_date>=warehouse_fee_start_date and in_date<="'.$this_day.'"')
				->where('is_warehouse_fee<>0 and warehouse_fee_start_date<="'.$this_day.'"')
				->group('a.factory_id')->having('account_date<"'.$this_day.'"')->select();
		foreach ($factory as $v){
			if($v['account_date']=='0000-00-00'){
				$cur_date	= ($v['stock_date']>$v['warehouse_fee_start_date'])? $v['stock_date'] : $v['warehouse_fee_start_date'];
			}else{
				$cur_date	= ($v['stock_date']>$v['account_date'])? $v['stock_date'] : date('Y-m-d', strtotime($v['account_date']."+1 day"));
			}
			while($cur_date<=$this_day){
				$list[$v['factory_id']][]	= $cur_date;
				$cur_date	= date('Y-m-d', strtotime($cur_date."+1 day"));
			}
		}
		$i	= 0;
		$debug	= true;
		foreach ($list as $factory=>$date_array){
			foreach ($date_array as $date){
				$model	= D('WarehouseAccount');
				$model->isAjax	= true;
				if ($debug === true) {
					echo '<br /><br />' . ++$i . ':' . '<br />';
					echo '日期:' . $date . '<br />';
					echo '卖家:' . SOnly('factory', $factory, 'factory_name') . '[' . $factory . ']<br />';
				}
				$model->warehouseFeeBalanceByDay($date,$factory, $debug);
			}
		}
		echo '........OK!';
	}


	/**
	 * 将状态为“请求中”且最后一次请求时间在5分钟之前的记录请求状态全部置为“请求异常”
	 */
	public function apiRequestStatusReset(){
		$expire_time	= array('elt', date('Y-m-d H:i:s', strtotime('-5 minutes')));
		//菜鸟退货
		$exists_where	= array(
			'_string'		=> 'cai_niao_log_id=l.id',
			'request_time'	=> $expire_time,
		);
		$exists	= M('CaiNiaoLogDetail')->where($exists_where)->field('"1"')->buildSql();
		$where	= array(
			'request_status'	=> CAINIAO_REQUEST_STATUS_PROCESSING,
			'_string'			=> 'NOT EXISTS' . $exists,
		);
		$join	= 'inner join __CAI_NIAO_LOG_DETAIL__ d on d.cai_niao_log_id=l.id';
		M('CaiNiaoLog')->alias('l')->join($join)->where($where)->setField('request_status', CAINIAO_REQUEST_STATUS_ABNORMAL);

		//DHL/西邮API
		$express_where	= array(
			'request_status'	=> EXPRESS_API_REQUEST_STATUS_REQUESTING,
			'last_request_time'	=> $expire_time,
		);
		$express_type	= array('Dhl', 'Correos');
		foreach ($express_type as $express) {
			M($express . 'List')->where($express_where)->setField('request_status', EXPRESS_API_REQUEST_STATUS_ABNORMAL);
		}
	}

	///gls request
	public function glsRequest(){
		header('Content-Type:text/html; charset=utf-8');
		$sale_order	= M('SaleOrder')->field('sale_order.id,track_no_update_tips,sale_order_state,warehouse_id')
			->join('left join sale_order_addition b on sale_order.id=b.sale_order_id inner join district d on b.country_id=d.id')
			->where('is_print=0 and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
				and EXISTS(select 1 from express e where sale_order.express_id=e.id and e.enable_api=1 and e.company_id in('.implode(',',C('GLS_API_EXPRESS_ID')).') )
				and d.abbr_district_name not in('.  implode(',', C('GLS_NOT_USE_COUNTRIES')).')')
			->formatFindAll(array('key'=>'id'));
		if(empty($sale_order)){
			echo L('no_record_for_search') . '<br />';
		}else{
			foreach ($sale_order as $id=>$value){
				if($used_out[$w_id]){//该仓包裹号已用完!
					continue;
				}
				$w_id	= $value['warehouse_id'];
				$model	= D('Gls');
				$track_no	= $model->getMaxPackageNo($w_id);
				if($track_no){
					$data['track_no']	= $model->getVerification($track_no);
					$data['track_no_update_tips']	= 0;
					$state	= ($value['sale_order_state']==C('SALE_ORDER_STATE_PENDING'))?true:false;
					$r	= $model->updateSaleOrder($id,$data,$state);
				}else{
					echo L('GLS_PACKAGE_NUMBER_ERROR').'('.SOnly('warehouse', $w_id,'w_name').')<br>';
					$used_out[$w_id]	= $w_id;
//					exit;
				}
			}
		}
	}

	function apiRequestTimes(){
		$api_request_times	= S('API_REQUEST_TIMES');
		if ($_GET['module'] && $_GET['action'] && $_GET['ip']) {
			$label	= trim($_GET['module']) . '_' . trim($_GET['action']) . '_' . trim($_GET['ip']);
			$key	= md5($label);
			if (!empty($api_request_times[$key])) {
				$request_times	= 0;
				$time_limit		= time() - ($_GET['time'] > 0 ? intval($_GET['time']) : 5) * 60;
				foreach ($api_request_times[$key] as $request_time => $times) {
					if ($request_time >= $time_limit) {
						$request_times	+= $times;
					}
				}
			}
			echo $label . ': Request Times is ' . $request_times . '<br />';
		} else {
			dump($api_request_times);
		}
	}
	//GLS_API DELETE
	public function glsDeleteRequest(){
		header('Content-Type:text/html; charset=utf-8');
		$list	= M('GlsTrackNoList')->select();
		if($list){
			foreach ($list as $val){
				$delete_list[$val['warehouse_id']][]	= $val['track_no'];
			}
			foreach ($delete_list as $w_id=>$track_no_list){
				$rs	= A('Gls')->requestDelete($track_no_list,$w_id);
				if($rs===true){
					M('GlsTrackNoList')->where('track_no in('.  implode(',', $track_no_list).')')->delete();
					echo '('.SOnly('warehouse', $w_id,'w_name').')<br>track_no:<br>'.implode('<br>', $track_no_list).'<br>DELETE SUCCESS!<br>';
				}else{
					echo '('.SOnly('warehouse', $w_id,'w_name').')<br>'.$rs.'<br>';
				}
			}
		}
	}
}
?>