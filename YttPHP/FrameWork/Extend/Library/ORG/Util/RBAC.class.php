<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: RBAC.class.php 2601 2012-01-15 04:59:14Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 基于角色的数据库方式验证类
 +------------------------------------------------------------------------------
 * @category   ORG
 * @package  ORG
 * @subpackage  Util
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: RBAC.class.php 2601 2012-01-15 04:59:14Z liu21st $
 +------------------------------------------------------------------------------
 */
// 配置文件增加设置
// USER_AUTH_ON 是否需要认证
// USER_AUTH_TYPE 认证类型
// USER_AUTH_KEY 认证识别号
// REQUIRE_AUTH_MODULE  需要认证模块
// NOT_AUTH_MODULE 无需认证模块
// USER_AUTH_GATEWAY 认证网关
// RBAC_DB_DSN  数据库连接DSN
// RBAC_ROLE_TABLE 角色表名称
// RBAC_USER_TABLE 用户表名称
// RBAC_ACCESS_TABLE 权限表名称
// RBAC_NODE_TABLE 节点表名称

class RBAC {
    // 认证方法
    static public function authenticate($map,$model='')
    {
        if(empty($model)) $model =  C('USER_AUTH_MODEL');
        //使用给定的Map进行认证
        return M($model)->where($map)->find();
    }
    // 检查登陆IP
    static public function authip($strip){
		$user_ip = get_client_ip();	 // 当前登录用户的IP
		$system_ip = explode(";",$strip); // 账号中设置的允许登录的IP
		$allow = false;
		$user_ip_arr	= explode ('.', $user_ip);
		for ($i = 0; $i<count($system_ip); $i++) { // 遍历各IP
			$cur_allow		= true;
			$system_ip_arr	= explode ('.',$system_ip[$i]);
			if (count($system_ip_arr) != 4) {
				continue;
			}
			foreach ($user_ip_arr as $val) {
				$value	= array_shift($system_ip_arr);
				if ($value!='*' && $val != $value) {
					$cur_allow	= false;
					break;
				}
			}
			if ($cur_allow) {
				$allow	= true;
				break;
			}
		}	
    	return $allow;
    }
    
    //用于检测用户权限的方法,并保存到Session中
    static function saveAccessList($authId=null)
    {
        if(null===$authId)   $authId = $_SESSION[C('USER_AUTH_KEY')];
        // 如果使用普通权限模式，保存当前用户的访问权限列表
        // 对管理员开发所有权限
        if(C('USER_AUTH_TYPE') !=2 && !$_SESSION[C('ADMIN_AUTH_KEY')] )
            $_SESSION['_ACCESS_LIST']	=	RBAC::getAccessList($authId);
        return ;
    }

	// 取得模块的所属记录访问权限列表 返回有权限的记录ID数组
	static function getRecordAccessList($authId=null,$module='') {
        if(null===$authId)   $authId = $_SESSION[C('USER_AUTH_KEY')];
        if(empty($module))  $module	=	MODULE_NAME;
        //获取权限访问列表
        $accessList = RBAC::getModuleAccessList($authId,$module);
        return $accessList;
	}

    //检查当前操作是否需要认证
    static function checkAccess()
    {
        //如果项目要求认证，并且当前模块需要认证，则进行权限认证
        if( C('USER_AUTH_ON') ){
			$_module	=	array();
			$_action	=	array();
            if("" != C('REQUIRE_AUTH_MODULE')) {
                //需要认证的模块
                $_module['yes'] = explode(',',strtoupper(C('REQUIRE_AUTH_MODULE')));
            }else {
                //无需认证的模块
                $_module['no'] = explode(',',strtoupper(C('NOT_AUTH_MODULE')));
            }
            //检查当前模块是否需要认证
            if((!empty($_module['no']) && !in_array(strtoupper(MODULE_NAME),$_module['no'])) || (!empty($_module['yes']) && in_array(strtoupper(MODULE_NAME),$_module['yes']))) {
				if("" != C('REQUIRE_AUTH_ACTION')) {
					//需要认证的操作
					$_action['yes'] = explode(',',strtoupper(C('REQUIRE_AUTH_ACTION')));
				}else {
					//无需认证的操作
					$_action['no'] = explode(',',strtoupper(C('NOT_AUTH_ACTION')));
				}
				//检查当前操作是否需要认证
				if((!empty($_action['no']) && !in_array(strtoupper(ACTION_NAME),$_action['no'])) || (!empty($_action['yes']) && in_array(strtoupper(ACTION_NAME),$_action['yes']))) {
					return true;
				}else {
					return false;
				}
            }else {
                return false;
            }
        }
        return false;
    }

    //权限认证的过滤器方法
    static public function AccessDecision($appName=APP_NAME)
    {
        //检查是否需要认证
        if(RBAC::checkAccess()) {
            //存在认证识别号，则进行进一步的访问决策
            $accessGuid   =   md5($appName.MODULE_NAME.ACTION_NAME);
            if(empty($_SESSION[C('ADMIN_AUTH_KEY')])) {
                if(C('USER_AUTH_TYPE')==2) {
                    //加强验证和即时验证模式 更加安全 后台权限修改可以即时生效
                    //通过数据库进行访问检查
                    $accessList = RBAC::getAccessList($_SESSION[C('USER_AUTH_KEY')]);
                }else {
                    // 如果是管理员或者当前操作已经认证过，无需再次认证
                    if( $_SESSION[$accessGuid]) {
                        return true;
                    }
                    //登录验证模式，比较登录后保存的权限访问列表
                    $accessList = $_SESSION['_ACCESS_LIST'];
                }
                //判断是否为组件化模式，如果是，验证其全模块名
               // $module = defined('P_MODULE_NAME')?  P_MODULE_NAME   :   MODULE_NAME;
                if(!isset($accessList[strtoupper(MODULE_NAME)][strtoupper(ACTION_NAME)])) {
                    $_SESSION[$accessGuid]  =   false;
                    return false;
                }
                else {
                    $_SESSION[$accessGuid]	=	true;
                }
            }else{
                //管理员无需认证
				return true;
			}
        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 取得当前认证号的所有权限列表
     +----------------------------------------------------------
     * @param integer $authId 用户ID
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    static public function getAccessList($authId)
    {
    	if (session('user_access_ary')) {
			return session('user_access_ary');
		}
        // Db方式权限数据
        $db     =   Db::getInstance(C('RBAC_DB_DSN'));
        $table = array('role'=>C('RBAC_ROLE_TABLE'),'user'=>C('RBAC_USER_TABLE'),'access'=>C('RBAC_ACCESS_TABLE'),'node'=>C('RBAC_NODE_TABLE'));
       // 读取公共模块的权限
    	$sql    =   "select node.id,node.module from ".$table['node']." as node,".$table['node']." as node2 where node.parent_id=node2.id and node.level=3 and node.status=1 and node2.module='Public'";
    	$rs =   $db->query($sql);
    	foreach ($rs as $a){
    		$publicAction[$a['module']]	 =	 $a['id'];
    	}
    	$access =  array();
    	// 读取项目的模块权限
    	$sql    =   "select node.id,node.module from ".
    	$table['role']." as role,".
    	$table['user']." as user,".
    	$table['access']." as access ,".
    	$table['node']." as node ".
    	"where user.id='{$authId}' and user.role_id=role.id and access.role_id=role.id and access.node_id=node.id and node.level=2 and node.status=1";
    	$modules =   $db->query($sql);
    	foreach($modules as $key=>$module) {
    		if (empty($module['module']) || strtoupper($module['module'])=='PUBLIC') continue;
    		$moduleId	=	 $module['id'];
    		$moduleName = $module['module'];
    		// 依次读取模块的操作权限
    		$sql    =   "select node.id,node.module from ".
    		$table['role']." as role,".
    		$table['user']." as user,".
    		$table['access']." as access ,".
    		$table['node']." as node ".
    		"where user.id='{$authId}' and user.role_id=role.id and access.role_id=role.id and access.node_id=node.id and node.level=3 and node.status=1 and node.parent_id={$moduleId}";
    		$rs =   $db->query($sql);
    		$action = array();
    		foreach ($rs as $a){
    			$action[$a['module']]	 =	 $a['id'];
    		}
    		// 和公共模块的操作权限合并
    		$action ? $action += $publicAction : $action = $publicAction;
    		
    		$access[strtoupper($moduleName)]   =  array_change_key_case($action,CASE_UPPER);
    		
    	}
    	if (C('access_type')!=1) {
			session('user_access_ary',$access);
		}
		return $access;
    }

    /**
     * 数据权限检查
     *
     * @return  bool
     */
    static public function AccessDataRights(){
    	if(empty($_SESSION[C('ADMIN_AUTH_KEY')])) {
    		$_module['no'] = explode(',',strtoupper(C('NOT_AUTH_MODULE')));
    		if(in_array(strtoupper(MODULE_NAME),$_module['no'])){
    			return true;
    		}else {
    			$_action['no'] = explode(',',strtoupper(C('NOT_AUTH_ACTION')));
    			if (in_array(strtolower(ACTION_NAME),$_action['no'])) {
    				return true;
    			}
    			$access = $_SESSION['_MODULE_ACCESS_'];
    			$module = strtoupper(MODULE_NAME);
    			switch (ACTION_NAME){
    				case 'delete':
    					$action = 'DELETE';
    					break;
    				case 'edit':
    					$action = 'UPDATE';
    					break;
    				default:
    					return true;
    					break;
    			}
    			$rs = $access[$module][$action];
    			if (empty($rs)) {
    				return true;
    			}else {
    				// 定义模块与类名，表名不一致的信息数组
    				$module_to_calss = array(
    					'REALSTORAGE' => 'StorageShow',
    				);
    				if (isset($module_to_calss[$module])) {
    					$dr_model = D($module_to_calss[$module]);
    				}else {
    					$dr_model = D(MODULE_NAME);
    				}
    				$fields = $dr_model->getDbFields();
    				if(!in_array('add_user', $fields)) {return true;} // 没有该字段则不需验证
    				$count = 0;
    				$data_rights = $rs['data_rights'];
    				$where = ' and id='.$_REQUEST['id'];
    				switch ($data_rights) {
    					case 1:
    						$count = 1;
    						break;
    					case 2:
    						if ($_SESSION['LOGIN_USER']['department_id']) {
				    			$multi_user = $_SESSION['LOGIN_USER']['group_department_uid'];	// 获取同部门的用户帐号
				    			if ($multi_user) {
				    				$count = $dr_model->where('add_user in ('.$multi_user.')'.$where)->count();
				    			}    			 			
				    		}
    						break;
    					case 3:
				    		$count = $dr_model->where('add_user='.USER_ID.$where)->count();
    						break;
    					default:
    						is_null($data_rights) && $count = 1;
    						break;
    				}
    				if($count>=1) return true; else return false;
    			}
    		}
    	}else {
    		return true;
    	}
    }
    
	// 读取模块所属的记录访问权限
	static public function getModuleAccessList($authId,$module,$action=null) {
		$module = strtoupper($module);
		if (session('module_access_ary_'.$module)) {
			return session('module_access_ary_'.$module);
		}
		if(C('USER_AUTH_TYPE')!=2) {
			//登录验证模式，比较登录后保存的权限访问列表
			return $_SESSION['_ACCESS_LIST'][$module];
		}
        // Db方式
        $db     =   Db::getInstance(C('RBAC_DB_DSN'));
        $table = array('role'=>C('RBAC_ROLE_TABLE'),'user'=>C('RBAC_USER_TABLE'),'access'=>C('RBAC_ACCESS_TABLE'),'node'=>C('RBAC_NODE_TABLE'));
        $where = '';
        if ($_SESSION[C('ADMIN_AUTH_KEY')]) {
        	$sql    =   "select node.id,node.module,node.group_id from ".$table['node']." as node where node.module='{$module}' and node.status=1";
        }else{
        	$where = "user.id='{$authId}' and user.role_id=role.id and access.role_id=role.id and access.node_id=node.id and node.status=1 and";
        	$sql    =   "select node.id,node.module,node.group_id from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access,".
                    $table['node']." as node ".
                    "where {$where} node.module='{$module}' ";
                 
        }
        $rs =   $db->query($sql);
        if(empty($rs)) return false;
        if ($_SESSION[C('ADMIN_AUTH_KEY')]) {
        	$sql    =   "select node.id,node.module,node.group_id from ".$table['node']." as node where node.parent_id=".$rs[0]['id'];
        }else{
        	 $sql    =   "select node.id,node.module,node.group_id,access.data_rights from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access,".
                    $table['node']." as node ".
                    "where {$where} node.parent_id=".$rs[0]['id'];
        }
        $rs2 =   $db->query($sql);
        if(!empty($rs2)) $rs = array_merge($rs,$rs2);
        $action = array();
        foreach ($rs as $value) {
        	$action[strtoupper($value['module'])] = $value;
        }
        $access	=	array($module=>$action);
        
        if (C('access_type')!=1) {
			session('module_access_ary_'.$module,$access);
		}
		return $access;
	}
	
	// 获取用户菜单列表
	static public function getUserMenu($authId,$type='0') {
		/*
		if ($type=='0' && session('user_menu_ary')) {
			return session('user_menu_ary');
		}
		*/
		 // Db方式
        $db     =   Db::getInstance(C('RBAC_DB_DSN'));
        $table  = array('role'=>C('RBAC_ROLE_TABLE'),'user'=>C('RBAC_USER_TABLE'),'access'=>C('RBAC_ACCESS_TABLE'),'node'=>C('RBAC_NODE_TABLE'));
        if ($_SESSION[C('ADMIN_AUTH_KEY')]){
			//后台管理员隐藏的菜单id
			$ext	= getUser('role_type')!=C('SELLER_ROLE_TYPE')&&C('ADMIN_NOT_SHOW_MENU_ID') ? ' and node.id not in('.C('ADMIN_NOT_SHOW_MENU_ID').') ' : '';
			$sql    =   "select node.* from ".$table['node']." as node ".
                    "where ((node.group_id>0) or (node.group_id=0 and node.level=1)) and node.status=1 ".$ext." order by group_id asc,sort asc";
		}else {
			$sql    =   "select node.* from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access,".
                    $table['node']." as node ".
                    "where user.id='{$authId}' and user.role_id=role.id and access.role_id=role.id and access.node_id=node.id and ((node.group_id>0) or (node.group_id=0 and node.level=1)) and node.status=1 order by group_id asc,sort asc";
		}
        $list =   $db->query($sql);
		foreach($list as $key=>$value) {
			$reset_list[$value['id']] = $value;	
		}
        $access	=	array();
        foreach($list as $key=>$value) {
        	if ($value['group_id']>0) {	
        		$parent_id = $value['group_id'];
        		if (isset($menu[$parent_id])) {	// 二级菜单
        			$menu[$parent_id]['sub'][$value['id']] = $value;
        		}else {	// 三级菜单
        			foreach ($menu as $key1 => $value1) {
        				if (isset($value1['sub'][$parent_id])) {
        					// 判断显示方式，存在parent_link_id时不显示标题链接
			        		if ($value['parent_link_id']>0) {
								//卖家类型特殊处理
								//if($_SESSION['LOGIN_USER']['role_type']==C('SELLER_ROLE_TYPE')){
								//	$menu[$key1]['sub'][$parent_id]['sub'][$value['id']] = $value;
								//}else{
									if(!isset($menu[$key1]['sub'][$parent_id]['sub'][$value['parent_link_id']])){
										$menu[$key1]['sub'][$parent_id]['sub'][$value['parent_link_id']] = $reset_list[$value['parent_link_id']];
									}
									$menu[$key1]['sub'][$parent_id]['sub'][$value['parent_link_id']]['ico_link'] = $value;	
								//}
			        			break;
			        		}
							if(!isset($menu[$key1]['sub'][$parent_id]['sub'][$value['id']])){
								$menu[$key1]['sub'][$parent_id]['sub'][$value['id']] = $value;
        						break;
							}
        				}
        			}
        		}
        	}else {// 一级菜单
        		$menu[$value['id']] = $value;
        	}
        }
		/*
		//卖家类型特殊处理
		if($_SESSION['LOGIN_USER']['role_type']==C('SELLER_ROLE_TYPE')){
			foreach ($menu as $key=>$value) {
				if(isset($value['sub'])&&$value['sub']){
					foreach($value['sub'] as $k=>$v){
						if(isset($v['sub'])&&$v['sub']){
							foreach($v['sub'] as $kk=>$vv){
								$menu[$key]['sub'][$vv['id']] = $vv;
							}
							unset($menu[$key]['sub'][$k]);
						}
					}
				}
			}
		}*/
		//pr($menu,'',1);

        // 定义销售地址与模块地址不一致数据
        $module_to_url = array(
        	'insert' => 'add',
        	'update' => 'edit',
        );
        // 设置二、三级菜单链接地址
        foreach ($menu as &$value1) {
        	$value1['href'] = 'javascript:;';
        	foreach ($value1['sub'] as &$value2) {
        		if ($value2['level']==3) {
        			$temp = M($table['node'])->find($value2['parent_id']);
        			$action = isset($module_to_url[$value2['module']]) ? $module_to_url[$value2['module']] : $value2['module'];
        			$value2['href'] = $temp['module'].C('URL_PATHINFO_DEPR').$action;
        		}else {
        			$value2['module'] && $value2['href'] = $value2['module'].C('URL_PATHINFO_DEPR').'index';
        		}
        		foreach ($value2['sub'] as &$value3) {
        			if ($value3['level']==3) {
	        			$temp = M($table['node'])->find($value3['parent_id']);
	        			$action = isset($module_to_url[$value3['module']]) ? $module_to_url[$value3['module']] : $value3['module'];
	        			$value3['href'] = $temp['module'].C('URL_PATHINFO_DEPR').$action;
	        		}else {
	        			$value3['module'] && $value3['href'] = $value3['module'].C('URL_PATHINFO_DEPR').'index';
	        		}
	        		if (empty($value2['href'])) {
	        			$value2['href'] = $value3['href'];
	        		}
        		}
        	}
        }
		if (C('access_type')==2) {
			session('user_menu_ary',$menu);
		}
        return $menu;
	}
	
	/**
	 * 获取角色设置时菜单数据
	 */
	static function getRoleNode(){
		$db     =   Db::getInstance(C('RBAC_DB_DSN'));
        $list =   M(C('RBAC_NODE_TABLE'))->where('level=1 and is_user=1 and status=1 and group_id=0')->select();
        $menu	=	array();
        foreach($list as $key=>$value) {
        	if (in_array($value['id'], array(2, 242))) {
        		$list2 =   M(C('RBAC_NODE_TABLE'))->where('is_user=1 and status=1 and group_id>0 and parent_id=' . $value['id'])->select();
        		foreach ($list2 as $value2) {
        			$menu[$value2['id']] = $value2;
        			$sql = 'select * from node where level=2 and status=1 and group_id>0 and parent_id =\''.$value2['id'].'\' order by sort asc';
	        		$list3 =   $db->query($sql);
	        		$menu[$value2['id']]['sub'] = $list3;
        		}
        	}else {
        		$menu[$value['id']] = $value;
	        	$sql = 'select * from node where level=2 and status=1 and group_id>0 and (parent_id in (select id from node where parent_id=\''.$value['id'].'\') or parent_id=\''.$value['id'].'\') order by sort asc';
	        	$list2 =   $db->query($sql);
	        	$menu[$value['id']]['sub'] = $list2;
        	}
        }
        if (C('rights_level')==3) {
        	foreach ($menu as &$value2) {
        		foreach ($value2['sub'] as &$value) {
        			$rights = M(C('RBAC_NODE_TABLE'))->where('is_user=1 and status=1 and parent_id='.$value['id'])->select();
        			$value['rights'] = $rights;
        		}
        	}
        }
        return $menu;
	}
}