<?php

/**
 * CommonAction
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	公共action类
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class CommonAction extends Action {
 
	public $_id	=	'';
	
    function _initialize() {
        import('ORG.Util.Cookie');
		$user_type = getUser('user_type');
		if(empty($user_type) && getUser('role_type')) $user_type = 0;	   //管理员
		$cookie_expire_interval =  C('COOKIE_EXPIRE_INTERVAL.'.$user_type);//不同登录账号过期时间不同
		//判断cookie是否过期
		if(!empty($_COOKIE['cookie_expire'])){
			if($_COOKIE['cookie_expire'] < time()){
				//首页刷新退出
				if(MODULE_NAME == 'Index' && ACTION_NAME == 'index'){
					redirect(U('Public/logout'));
				}
				//消息提醒不列入超时操作
				if(MODULE_NAME != 'Ajax' && ACTION_NAME != 'getRemind'){
					throw_json(L('_LOGIN_TIMEOUT_'));
				}
			}else{
				cookie('cookie_expire',time() + $cookie_expire_interval);	//cookie加过期时间间隔
			}
		}else{
			cookie('cookie_expire',time() + $cookie_expire_interval);	//cookie加过期时间间隔
		}
       	///检查认证识别号
        if (!$_SESSION [C('USER_AUTH_KEY')] && !$_SESSION[C('SUPER_ADMIN_AUTH_KEY')] && !(MODULE_NAME=='EmailList' && in_array(ACTION_NAME, array('edit','sentStorageWarn'))) &&!(in_array(MODULE_NAME,array('EbaySeller','AmazonSeller'))) && C('SNAP_DISABLE_VERIFY') !== true) {
			///判断是否已经退出如果是则自动关闭页面
			if(MODULE_NAME == 'Index' && ACTION_NAME == 'index'){
				///跳转到认证网关
				redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
			}else{
				redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));//added by jp 20140610
				windowClose();
			}
        }
        if ($_SESSION[C('SUPER_ADMIN_AUTH_KEY')] && $_SESSION['LOGIN_USER']['state']==0) {
        	redirect(__APP_ROOT__.'/admin.php');
        }
        /// 用户权限检查
        if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
            if ($_SESSION['LOGIN_USER']['role_type'] == C('SELLER_ROLE_TYPE') && in_array(ACTION_NAME, (array)C('FACTORY_PERMISSION_DENIED.' . MODULE_NAME))) {
               throw_json(L('_VALID_ACCESS_'));
            }			
            if (!RBAC::AccessDecision()) {
               throw_json(L('_VALID_ACCESS_'));
            }
        }             
        define('USER_ID',$_SESSION[C('USER_AUTH_KEY')]);
        /// 获取当前模块权限
    	$this->module_access = $_SESSION['_MODULE_ACCESS_'] = RBAC::getModuleAccessList(USER_ID,MODULE_NAME);
        /// 数据操作权限检查，后台配置“权限范围”值为“是”时有效
        if (C('show_data_right')==1) {
        	if (!RBAC::AccessDataRights()) {
        		throw_json(L('_VALID_DATA_ACCESS_'));
        	}
        }
        /// 业务规则检查
        $all_tags 	 = C('extends');
        $action_tag_name = MODULE_NAME.'&'.ACTION_NAME;
        if (isset($all_tags[$action_tag_name])) {
        	tag($action_tag_name,array_merge($_GET,$_POST));
        }
        /// 如果只是检查业务规则检查完毕后退出
        if ($_POST['accessCheck'] || $_GET['accessCheck']) {
        	$this->success('权限及业务规则检查通过！');
        }
        /// 设置全局公共属性
    	$this->super_admin	= $_SESSION[C('SUPER_ADMIN_AUTH_KEY')];
    	$this->admin		= $_SESSION[C('ADMIN_AUTH_KEY')];
    	/// 设置当前登陆用户信息
    	$this->login_user	= getUser();
    	///当前时间
    	C('digital_format',getUser('digital_format'));
    	$this->this_time	= formatDate(date("Y-m-d H:i:s"),'outdate');
    	$this->this_day		= formatDate(date("Y-m-d"),'outdate');
    	$this->autoLang();
    	/// 点击查询时保存当前查询条件
    	if ($_POST['search_form']) {
    		session('post_'.MODULE_NAME.'_'.ACTION_NAME,$_POST);
    	}
    	/// 保存并转至列表时获取查询条件
		/// 公司列表排序BUG
		if ($_GET['s_r']==1&&!(MODULE_NAME=='Basic'&&ACTION_NAME=='index'&&C('SHOW_MANY_BASIC')==2)){
    		$_POST		= session('post_'.MODULE_NAME.'_'.ACTION_NAME);
			$_REQUEST	= array_merge($_REQUEST, $_POST);
    		unset($_POST['search_form']);
    	}
    	unset($_GET['newtab'],$_GET['s_r']);
    }

    public function index() {
       /* ///列表过滤器，生成查询Map对象
        $map = $this->_search();
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $name = $this->getActionName();
        $model = D($name);
        if (!empty($model)) {
            _list($model, $map);
        }
        $this->display();
        return;*/
       ///获取当前Action名称
	 	$name = $this->getActionName(); 
 		///获取当前模型
		$model 	= D($name);     
		///格式化+获取列表信息  
		$list	=	$model->index();
		///assign
		$this->assign('list',$list);
		$this->assign('session_expire',$_SESSION['expire']);
		///display
		$this->displayIndex();
       
    }

    /**
     * 取得操作成功后要返回的URL地址
     * 默认返回当前模块的默认操作
     * 可以在action控制器中重载
     * @access public
     * @return string
     * @throws ThinkExecption
     */
    function getReturnUrl() {
        return __URL__ . '?' . C('VAR_MODULE') . '=' . MODULE_NAME . '&' . C('VAR_ACTION') . '=' . C('DEFAULT_ACTION');
    } 

    /**
     * 根据表单生成查询条件
     * 进行列表过滤
     * 加格式化数据
     *
     * @param array $options
     * @param object $model
     * @return array
     */
    public function _listAndFormat(&$model,&$options,$optionsKey=null){ 
    	return _formatList(_list($model,$options),$optionsKey);
    }
    
	///新增
	public function add(){
	}
	 
    public function _after_add(){  
    	 $this->display();
    } 
    
    function edit() {
        $name = $this->getActionName();
        $model = M($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->getById($id);
        $this->assign('vo', $vo);
        $model->cacheLockVersion($vo);
    } 
    
    function update() {
        ///B('FilterString');
        $name = $this->getActionName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        /// 更新数据
        $list = $model->save();
        if (false !== $list) {
            ///成功提示
            $this->assign('jumpUrl', Cookie::get('_currentUrl_'));
            $this->success('编辑成功!');
        } else {
            ///错误提示
            $this->error('编辑失败!');
        }
    }

    /**
     * 默认删除操作
     * @access public
     * @return string
     * @throws ThinkExecption
     */
    public function delete() {
        ///删除指定记录
        $name = $this->getActionName();
        $model = M($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                $list = $model->where($condition)->setField('status', - 1);
                if ($list !== false) {
                    $this->success('删除成功！');
                } else {
                    $this->error('删除失败！');
                }
            } else {
                $this->error('非法操作');
            }
        }
    }

    public function foreverdelete() {
        ///删除指定记录
        $name = $this->getActionName();
        $model = D($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                if (false !== $model->where($condition)->delete()) {
                    ///echo $model->getlastsql();
                    $this->success('删除成功！');
                } else {
                    $this->error('删除失败！');
                }
            } else {
                $this->error('非法操作');
            }
        }
        $this->forward();
    }

    public function clear() {
        ///删除指定记录
        $name = $this->getActionName();
        $model = D($name);
        if (!empty($model)) {
            if (false !== $model->where('status=1')->delete()) {
                $this->assign("jumpUrl", $this->getReturnUrl());
                $this->success(L('_DELETE_SUCCESS_'));
            } else {
                $this->error(L('_DELETE_FAIL_'));
            }
        }
        $this->forward();
    }

    /**
     * 默认禁用操作
     * @access public
     * @return string
     * @throws FcsException
     */
    public function forbid() {
        $name = $this->getActionName();
        $model = D($name);
        $pk = $model->getPk();
        $id = $_REQUEST [$pk];
        $condition = array($pk => array('in', $id));
        $list = $model->forbid($condition);
        if ($list !== false) {
            $this->assign("jumpUrl", $this->getReturnUrl());
            $this->success('状态禁用成功');
        } else {
            $this->error('状态禁用失败！');
        }
    }

    public function checkPass() {
        $name = $this->getActionName();
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->checkPass($condition)) {
            $this->assign("jumpUrl", $this->getReturnUrl());
            $this->success('状态批准成功！');
        } else {
            $this->error('状态批准失败！');
        }
    }

    public function recycle() {
        $name = $this->getActionName();
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->recycle($condition)) {
            $this->assign("jumpUrl", $this->getReturnUrl());
            $this->success('状态还原成功！');
        } else {
            $this->error('状态还原失败！');
        }
    }

    public function recycleBin() {
        $map = $this->_search();
        $map ['status'] = - 1;
        $name = $this->getActionName();
        $model = D($name);
        if (!empty($model)) {
            _list($model, $map);
        }
        $this->display();
    }

    /**
     * 默认恢复操作
     * @access public
     * @return string
     * @throws FcsException
     */
    function resume() {
        ///恢复指定记录
        $name = $this->getActionName();
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->resume($condition)) {
            $this->assign("jumpUrl", $this->getReturnUrl());
            $this->success('状态恢复成功！');
        } else {
            $this->error('状态恢复失败！');
        }
    }

    function saveSort() {
        $seqNoList = $_POST ['seqNoList'];
        if (!empty($seqNoList)) {
            ///更新数据对象
            $name = $this->getActionName();
            $model = D($name);
            $col = explode(',', $seqNoList);
            ///启动事务
            $model->startTrans();
            foreach ($col as $val) {
                $val = explode(':', $val);
                $model->id = $val [0];
                $model->sort = $val [1];
                $result = $model->save();
                if (!$result) {
                    break;
                }
            }
            ///提交事务
            $model->commit();
            if ($result !== false) {
                ///采用普通方式跳转刷新页面
                $this->success('更新成功');
            } else {
                $this->error($model->getError());
            }
        }
    }
    
    /**
     * Enter description here...
     *
     * @param array $model
     * @return string
     */
    public function getMaxNo($model=array()){ 
		return $max_no	=	$this->_autoMaxNo(0,$model); 
	}
	
	/**
	 * 返回对应的ID
	 *
	 * @param int $id
	 * @return int $id
	 */
	public function getPkValue($id){
		if ($id>0){
			$this->_id	=	$id;
		} 
		return $this->_id;
	}
	
	/**
	 * 生成字典
	 *
	 * @return unknown
	 */
    public function checkCacheDd($id=null){ 
    	$id	=	$this->getPkValue()>0?$this->getPkValue():$id;
		foreach ((array)$this->_cacheDd as $key=>$row) {  
			 cacheDd($row,$id);
		}    
    	return true;
    }
    
    
    
    /**
     * 获取页面传递来的查询条件
     * @access public
     * @Author 何剑波
     * @return $default_where 默认的where条件
     * @return $default 第一次载入附加的where条件
     */	
	public function _search($default_where=null,$default=null){ 
		!empty($default_where)	&&	$where	=	' and '.$default_where;  
		return self::getWhere($_POST,$default).$where;
	}	
	
	/**
	 * 处理一些特殊的URL
	 *
	 */
	public function getSpaceData(){  
		if (!is_array($_GET)){
			return ;
		}
		$findme = array('date2'=>'spacedate2_','date'=>'spacedate_','no'=>'space_','query'=>'spacequery_'); 
		foreach($findme as $key=>$value){
			foreach($_GET as $key_p=>$value_p){   
				$pos = strpos($key_p, $value); 
				if ($pos === false) {
				 	
				}else{
					if ($key=='no'){
						$_POST[str_replace($value,'',$key_p)]	=	$value_p;
					}else{
						$_POST[$key][str_replace($value,'',$key_p)]	=	$value_p;
					}
				} 
			}
		}
		$_POST['date_key']=2; 
	} 
	
	/**
	* 根据数组 调用不同条件，提取 SQL语句的 WHERE条件
	*
	* @param array $info
	* @return string
	*/
	public function getWhere($info,$default){  
		global $_search_form;
		$_POST['ac_search'] && $_search_form = true;
		/// 合并default_post属性值与实际的POST值，实际POST优先级高
		if (is_array($default)) {
			$_POST = array_merge($default,$info);
		} 
		$where	= ' 1 ';               ///WHERE 的初始化   
		if(count($default['query']) > 0)    ///where的默认条件
		{ 
			foreach ($default['query'] as $fieldName => &$fieldValue) {
				
				if (!empty($fieldName) && $fieldValue!=NULL &&	empty($info['query'][$fieldName]) && !isset($info['query'][$fieldName]))
				{
					$fieldValue	= trim($fieldValue);
					if (empty($fieldValue)) {	continue;	}
					///					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'="'.$fieldValue.'" ';
					///POST转换将.替换成_
					if (strpos($fieldName,'.')) {
						$new_key = str_replace('.','_',$fieldName);
						unset($default['query'][$new_key]);
						$_POST['query'][$new_key]	=	$fieldValue;
					}
				}
			}
		} 
		if(count($info['query']) > 0)    ///一般 WHERE条件的提取
		{ 
			foreach ($info['query'] as $fieldName => &$fieldValue) {
				if ($fieldValue!=NULL && $fieldValue<>0){
					if($fieldValue=='-2') continue;
					///					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'="'.$fieldValue.'" ';
					///POST转换将.替换成_
					if (strpos($fieldName,'.')) {
						$new_key = str_replace('.','_',$fieldName);
						unset($info['query'][$new_key]); 
						$_POST['query'][$new_key]	=	$fieldValue;
					}
				}
			}
		}
		if(count($info['morethan']) > 0)    ///大于等于
		{
			foreach ($info['morethan'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=NULL)
				{
					$fieldValue	= trim($fieldValue);
					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'>="'.$fieldValue.'" ';
				}
			}
		} 
		if(count($info['like']) > 0)   ///LIKE 语句的提取
		{
			foreach ($info['like'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=null)
				{ 
					$where 	.= ' and '.$fieldName.' like "%'.$fieldValue.'%" ';
					///POST转换将.替换成_
					if (strpos($fieldName,'.')) {
						$new_key = str_replace('.','_',$fieldName);
						unset($info['query'][$new_key]);  
						$_POST['like'][$new_key]	=	$fieldValue;
					}
				}
			}
		} 
		///多个日期查询需要在页面中增加 date_key 几组日期的数量
		if ($info['date_key']>0) { 
			for ($i = 1; $i <= $info['date_key']; $i++) {
				$info_key	=	$i>1?$i:'';
				$where		.=	$this->_getWhereDate($info,'date'.$info_key); 
			} 
		}else{
			$where	.=	$this->_getWhereDate($info); 
		}
		
		return $where;
	}	
	
	/**
	 * 多个日期查询
	 *
	 * @param array $info
	 * @param string $info_key 日期下标KEY值
	 * @return string
	 */
	public function _getWhereDate($info,$info_key='date'){
		$where	=	'';
		if(count($info[$info_key]) > 0)   ///日期 语句的提取
		{
			foreach ($info[$info_key] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=null)
				{
					$fieldValue		= formatDate($fieldValue,'date'); ///对日期格式化 存入数据库
					if (strpos($fieldName,'.')) {
						///POST转换将.替换成_
						$_POST['date'][str_replace('.','_',$fieldName)]	=	$fieldValue;
						$exp_date	=	explode('.',$fieldName);
						$fieldName	=	$exp_date[1];
						$fix_date	=	$exp_date[0].'.';
					}
					if(substr($fieldName,0,9) == 'needdate_')
					{
						$fieldName	= substr($fieldName,9);
						$needdate	= 1;
					}
	
					if(substr($fieldName,0,5) == 'from_')
					{
						$fileds		= $needdate	?	substr($fieldName,5)	:	substr($fieldName,5);
						$date_from	= $fieldValue;
					}
					else if(substr($fieldName,0,3) == 'to_')
					{
						$fileds		= $needdate	?	substr($fieldName,3)	:	substr($fieldName,3);
						$date_to	= $fieldValue.' 23:59:59';
					}
					else if(substr($fieldName,0,3) == 'mt_')   ///大于 该日期段
					{
						$fileds		= $needdate	?	substr($fieldName,3)	:	substr($fieldName,3);
						$where 		.= ' and '.$fileds.'>="'.$fieldValue.'" ';
					}
					else if(substr($fieldName,0,4) == 'mtt_')   ///大于 该日期段
					{
						$fileds		= $needdate	?	substr($fieldName,4)	:	substr($fieldName,4);
						$where 		.= ' and '.$fileds.'>"'.$fieldValue.'" ';
					}
					else if(substr($fieldName,0,3) == 'lt_')   ///小于 该日期段
					{
						$fileds		= $needdate	?	substr($fieldName,3)	:	substr($fieldName,3);
						$where 		.= ' and '.$fileds.'<="'.$fieldValue.' 23:59:59" ';
					}
					else if(substr($fieldName,0,4) == 'ltt_')   ///小于 该日期段
					{
						$fileds		= $needdate	?	substr($fieldName,4)	:	substr($fieldName,4);
						$where 		.= ' and '.$fileds.'<"'.$fieldValue.' 23:59:59" ';
					}
					else {
						$where 		.= ' and '.$fieldName.'="'.$fieldValue.' 23:59:59" ';
					}
				}
			}
		}
		if($date_from  || $date_to)
		{
			if($date_from && $date_to)   ///日期都存在
			{
				$where	.= ' and '.$fix_date.$fileds.'>="'.$date_from.'" and '.$fix_date.$fileds.'<="'.$date_to.' 23:59:59" ';
			}
			else
			{
				$date_from	?	$date	= $date_from : ($date_to	?	$date	= $date_to : $date = '-1');
				$where	.= ' and '.$fix_date.$fileds.'>="'.$date.'" and '.$fix_date.$fileds.'<="'.$date.' 23:59:59" ';
			}
		}
		return $where;
	}

	/// 显示图片信息
    public function img() {
		showImg($_GET['id']);
    }
    
    /// 新窗口查看大图
    public function showimg() {
    	echo '<img src="'.U(MODULE_NAME.'/img',array('view'=>true,'id'=>$_GET['id'])).'">';
    	exit;
    }
    /// 根据流程动态设置语言包
    public function autoLang($module_name=''){
    	
    	$flow_key = array(
    		'Orders' => 'order',
    		'LoadContainer' => 'loadContainer',
    		'Instock' => 'instock',
    		'SaleOrder' => 'sale',
    		'PreDelivery' => 'preDelivery',
    		'Delivery' => 'delivery',
    		'Adjust' => 'adjust',
    		'Transfer' => 'transfer',
    		'Stocktake' => 'stocktake',
    	);
    	if(empty($module_name)){
    		$module_name=MODULE_NAME;
    	}
    	L('quantity',L('quantity_3'));
    	$flow_config = C($flow_key[$module_name]);
    	if ($flow_config['storage_format']==2) {
    		L('quantity',L('quantity_2'));
    		L('capability',L('storage_1'));
    	}elseif($flow_config['storage_format']==3) {
    		L('quantity',L('quantity_2'));
    		L('capability',L('storage_2'));
    	}
    	L('profitandloss_quantity',L('profitandloss').L('quantity'));
    	L('stocktake_quantity',L('stocktake').L('quantity'));
    	L('storage_quantity',L('storage').L('quantity'));
    	
    }
    
    /**
     * 解析一维数组为pathinfo格式
     *
     * @param  array $array
     * @param bool $rule 是否按解析规则解析
     * @return unknown
     */
	public function arraytourl($array,$rule=true) {
		$url = null;
		if (true===$rule) {
			foreach ((array)$array as $fieldName => $fieldValue) {
				if (is_array($fieldValue)){ continue; }
	    		$url[] = $fieldName.'/'.$fieldValue;
	    	}
	    	if ($url) {
	    		$url = implode('/',$url);
	    	}
			return $url;
		}
		$rule = array('eq_','ne_','gt_','lt_','ge_','le_');
    	foreach ((array)$array as $fieldName => $fieldValue) {
    		$ary_rule = substr($fieldName,0,3);
    		if (false===in_array($ary_rule,$rule) || empty($fieldValue)) {
    			continue;
    		}
    		
    		$url[] = $fieldName.'/'.base64_encode($fieldValue);
    	}
    	if ($url) {
    		$url = implode('/',$url);
    	}
		return $url;
	}

}

?>