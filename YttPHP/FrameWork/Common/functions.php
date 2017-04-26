<?php
/**
 * Think 标准模式公共函数库
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 */

/**
 * 错误输出
 *
 * @param  string ,array $error
 * @return  string
 */
function halt($error) {
    $e = array();
    if (APP_DEBUG) {
        ///调试模式下输出错误信息
        if (!is_array($error)) {
            $trace = debug_backtrace();
            $e['message'] = $error;
            $e['file'] = $trace[0]['file'];
            $e['class'] = $trace[0]['class'];
            $e['function'] = $trace[0]['function'];
            $e['line'] = $trace[0]['line'];
            $traceInfo = '';
            $time = date('y-m-d H:i:m');
            foreach ($trace as $t) {
                $traceInfo .= '[' . $time . '] ' . $t['file'] . ' (' . $t['line'] . ') ';
                $traceInfo .= $t['class'] . $t['type'] . $t['function'] . '(';
                $traceInfo .= implode(', ', $t['args']);
                $traceInfo .=')<br/>';
            }
            $e['trace'] = $traceInfo;
        } else {
            $e = $error;
        }
        /// 包含异常页面模板
        include C('TMPL_EXCEPTION_FILE');
    } else {
        ///否则定向到错误页面
        $error_page = C('ERROR_PAGE');
        if (!empty($error_page)) {
            redirect($error_page);
        } else {
            if (C('SHOW_ERROR_MSG'))
                $e['message'] = is_array($error) ? $error['message'] : $error;
            else
                $e['message'] = C('ERROR_MESSAGE');
            /// 包含异常页面模板
            include C('TMPL_EXCEPTION_FILE');
        }
    }
    exit;
}

/**
 * 自定义异常处理
 *
 * @param  string $msg
 * @param string $type
 * @param int $code
 * @return string
 */
function throw_exception($msg, $type='ThinkException', $code=0) {
    if (class_exists($type, false)){
        throw new $type($msg, $code, true);
    }else{
        halt($msg);        /// 异常类型不存在则输出错误信息字串
    }
}

/**
 * 自定义异常处理
 *
 * @param string array $msg  只允许字符串和一级数组
 * @param array $code
 */
function throw_json($msg, $code=0) {
    throw_exception($msg,'JsonException',$code);
}


/**
 * 浏览器友好的变量输出
 *
 * @param array $var
 * @param  bool $echo  直接输出或返回数据
 * @param  bool $label  去除头尾字符
 * @param  bool $strict  输出方式
 * @return string
 */
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

/**
 * 404 处理
 *
 * @param string $msg
 * @param string $url
 */
function _404($msg='',$url='') {
    APP_DEBUG && throw_exception($msg);
    if($msg && C('LOG_EXCEPTION_RECORD')) Log::write($msg);
    if(empty($url) && C('URL_404_REDIRECT')) {
        $url    =   C('URL_404_REDIRECT');
    }
    if($url) {
        redirect($url);
    }else{
        send_http_status(404);
        exit;
    }
}

/**
 * 区间调试开始
 *
 * @param  string $label  变量下标
 */
function debug_start($label='') {
    $GLOBALS[$label]['_beginTime'] = microtime(TRUE);
    if (MEMORY_LIMIT_ON)
        $GLOBALS[$label]['_beginMem'] = memory_get_usage();
}

/**
 * 区间调试结束，显示指定标记到当前位置的调试
 *
 * @param  string $label  变量下标
 */
function debug_end($label='') {
    $GLOBALS[$label]['_endTime'] = microtime(TRUE);
    echo '<div style="text-align:center;width:100%">Process ' . $label . ': Times ' . number_format($GLOBALS[$label]['_endTime'] - $GLOBALS[$label]['_beginTime'], 6) . 's ';
    if (MEMORY_LIMIT_ON) {
        $GLOBALS[$label]['_endMem'] = memory_get_usage();
        echo ' Memories ' . number_format(($GLOBALS[$label]['_endMem'] - $GLOBALS[$label]['_beginMem']) / 1024) . ' k';
    }
    echo '</div>';
}

/**
 * 添加和获取页面Trace记录
 *
 * @param  string $title
 * @param  string $value
 * @return array
 */
function trace($title='',$value='') {
    if(!C('SHOW_PAGE_TRACE')) return;
    static $_trace =  array();
    if(is_array($title)) { /// 批量赋值
        $_trace   =  array_merge($_trace,$title);
    }elseif('' !== $value){ /// 赋值
        $_trace[$title] = $value;
    }elseif('' !== $title){ /// 取值
        return $_trace[$title];
    }else{ /// 获取全部Trace数据
        return $_trace;
    }
}

/**
 * 设置当前页面的布局
 *
 * @param bool $layout
 */
function layout($layout) {
    if(false !== $layout) {
        /// 开启布局
        C('LAYOUT_ON',true);
        if(is_string($layout)) { /// 设置新的布局模板
            C('LAYOUT_NAME',$layout);
        }
    }else{/// 临时关闭布局
        C('LAYOUT_ON',false);
    }
}

/**
 * URL组装 支持不同模式,格式：U('[分组/模块/操作@域名]?参数','参数','伪静态后缀','是否跳转','显示域名')
 *
 * @param string $url
 * @param array $vars
 * @param string $suffix
 * @param string $redirect
 * @param string $domain
 * @return string
 */
function U($url='',$vars='',$suffix=true,$redirect=false,$domain=false, $root = false) {
	if(empty($url)) return ;
    /// 解析URL
    $info =  parse_url($url);
    $url   =  !empty($info['path'])?$info['path']:ACTION_NAME;
    if(false !== strpos($url,'@')) { /// 解析域名
        list($url,$host)    =   explode('@',$info['path'], 2);
    }
    /// 解析子域名
    if(isset($host)) {
        $domain = $host.(strpos($host,'.')?'':strstr($_SERVER['HTTP_HOST'],'.'));
    }elseif($domain===true){
        $domain = $_SERVER['HTTP_HOST'];
        if(C('APP_SUB_DOMAIN_DEPLOY') ) { /// 开启子域名部署
            $domain = $domain=='localhost'?'localhost':'www'.strstr($_SERVER['HTTP_HOST'],'.');
            /// '子域名'=>array('项目[/分组]');
            foreach (C('APP_SUB_DOMAIN_RULES') as $key => $rule) {
                if(false === strpos($key,'*') && 0=== strpos($url,$rule[0])) {
                    $domain = $key.strstr($domain,'.'); /// 生成对应子域名
                    $url   =  substr_replace($url,'',0,strlen($rule[0]));
                    break;
                }
            }
        }
    }

    /// 解析参数
    if(is_string($vars)) { /// aaa=1&bbb=2 转换成数组
        parse_str($vars,$vars);
    }elseif(!is_array($vars)){
        $vars = array();
    }
    if(isset($info['query'])) { /// 解析地址里面参数 合并到vars
        parse_str($info['query'],$params);
        $vars = array_merge($params,$vars);
    }

    /// URL组装
    $depr = C('URL_PATHINFO_DEPR');
    if($url) {
        if(0=== strpos($url,'/')) {/// 定义路由
            $route   =  true;
            $url   =  substr($url,1);
            if('/' != $depr) {
                $url   =  str_replace('/',$depr,$url);
            }
        }else{
            if('/' != $depr) { /// 安全替换
                $url   =  str_replace('/',$depr,$url);
            }
            /// 解析分组、模块和操作
            $url   =  trim($url,$depr);
            $path = explode($depr,$url);
            $var  =  array();
            $var[C('VAR_ACTION')] = !empty($path)?array_pop($path):ACTION_NAME;
            $var[C('VAR_MODULE')] = !empty($path)?array_pop($path):MODULE_NAME;
            if(C('URL_CASE_INSENSITIVE')) {
                $var[C('VAR_MODULE')] =  parse_name($var[C('VAR_MODULE')]);
            }
            if(!C('APP_SUB_DOMAIN_DEPLOY') && C('APP_GROUP_LIST')) {
                if(!empty($path)) {
                    $group   =  array_pop($path);
                    $var[C('VAR_GROUP')]  =   $group;
                }else{
                    if(GROUP_NAME != C('DEFAULT_GROUP')) {
                        $var[C('VAR_GROUP')]  =   GROUP_NAME;
                    }
                }
                if(C('URL_CASE_INSENSITIVE') && isset($var[C('VAR_GROUP')])) {
                    $var[C('VAR_GROUP')] =  strtolower($var[C('VAR_GROUP')]);
                }
            }
        }
    }

	$_app_url	= $root === true ? __APP_ROOT__ : __APP__;
    if(C('URL_MODEL') == 0) { /// 普通模式URL转换
        $url   =  $_app_url.'?'.http_build_query(array_reverse($var));
        if(!empty($vars)) {
            $vars = http_build_query($vars);
            $url   .= '&'.$vars;
        }
    }else{ /// PATHINFO模式或者兼容URL模式
        if(isset($route)) {
            $url   =  $_app_url.'/'.rtrim($url,$depr);
        }else{
            $url   =  $_app_url.'/'.implode($depr,array_reverse($var));
///            $url   =  implode($depr,array_reverse($var));
        }
        if(!empty($vars)) { /// 添加参数
            $vars = http_build_query($vars);
            $url .= $depr.str_replace(array('=','&'),$depr,$vars);
        }
        if($suffix) {
            $suffix   =  $suffix===true?C('URL_HTML_SUFFIX'):$suffix;
            if(0 < strpos($suffix, '|')){
                $suffix = strstr($suffix, '|', true);
            }
            if($suffix && $url[1]){
                $url  .=  '.'.ltrim($suffix,'.');
            }
        }
    }
    if($domain) {
        $url   =  (is_ssl()?'https://':'http://').$domain.$url;
    }
	$url = str_replace('//', '/', $url);
    if($redirect) /// 直接跳转URL
        redirect($url);
    else
        return $url;
}


/**
 * 加密2
 *
 * @param string $txt
 * @param string $key
 * @return string
 */
function passport_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}

/**
 * 解密2
 *
 * @param string $txt
 * @param string $key
 * @return string
 */
function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

/**
 * 传入值乱序
 *
 * @param string $txt
 * @param  string $encrypt_key
 * @return string
 */
function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}


/**
 * 判断是否SSL协议
 *
 * @return  bool
 */
function is_ssl() {
    if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
        return true;
    }elseif(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}

/**
 * URL重定向
 *
 * @param string $url
 * @param int $time
 * @param string $msg
 */
function redirect($url, $time=0, $msg='') {
    ///多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        /// redirect
		header('Content-Type:text/html; charset=utf-8');
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}

/**
 * 缓存管理函数
 *
 * @param string $name
 * @param array $value
 * @param int $expire
 * @return  bool
 */
function cache($name,$value='',$expire=0) {
    static $cache  =   '';
    if(empty($cache)) { /// 自动初始化
        $cache =   Cache::getInstance();
    }
    if(is_array($name)) { /// 缓存初始化
        $type   =   isset($name['type'])?$name['type']:C('DATA_CACHE_TYPE');
        unset($name['type']);
        $cache =   Cache::getInstance($type,$name);
        return $cache;
    }elseif(''=== $value){ /// 获取缓存值
        /// 获取缓存数据
        return $cache->get($name);
    }elseif(is_null($value)) { /// 删除缓存
        return $cache->rm($name);
    }else { /// 缓存数据
        return $cache->set($name, $value, $expire);
    }
}

/**
 * 全局缓存设置和读取
 *
 * @param string $name
 * @param array string $value
 * @param string $expire
 * @param string $type
 * @param string $options
 * @return  array string
 */
function S($name, $value='', $expire=null, $type='',$options=null) {
	static $_cache = array();
	$dd_id	= intval(C('CFG_NOT_CACHE_DD_NAME.'.$name));
	$name	= APP_NAME.'_'.C('USER_AUTH_KEY').'_'.$name;
	if ($dd_id <= 0) {
		///取得缓存对象实例
		$cache = Cache::getInstance($type,$options);
		if ('' !== $value) {
        if (is_null($value)) {
            /// 删除缓存
///            M('cache_info')->where('name=\''.$name.'\'')->delete(); ; 
            $result = $cache->rm($name);
            if ($result)
                unset($_cache[$type . '_' . $name]);
            return $result;
        }else {
///        	M('cache_info')->add(array('name'=>$name)); 
            /// 缓存数据
            $cache->set($name, $value, $expire);
            $_cache[$type . '_' . $name] = $value;
        }
        return;
    }
	}
    if (isset($_cache[$type . '_' . $name]))
        return $_cache[$type . '_' . $name];
	if ($dd_id > 0) {
		$dd		= M('dd')->find($dd_id);
		$dd_key	= $dd['dd_key'];
		$result	= M($dd['dd_table'])->field($dd_key . ', ' . $dd['dd_value'])->select();
		foreach ($result as $row) {
			$key			= $row[$dd_key];
			unset($row[$dd_key]);
			$value[$key]	= $row;
		}		
	} else {
		/// 获取缓存数据
		$value = $cache->get($name);
	}
    $_cache[$type . '_' . $name] = $value;
    return $value;
}

/**
 * 返回一个明确S下标的对应的值
 *
 * @param string $name
 * @param int $id
 * @return string
 */
function SOnly($name,$id,$field=null){
	$dd_split	= $name != 'Dd_split' ? SOnly('Dd_split', $name) : 0;
	if ($dd_split > 0) {
		$name	.= '_' . intval(($id-1) / C('DD_SPLIT_LIMIT'));
	}
	$info		= S($name);
	$array		= $info[$id];
	if (empty($field)){
		return $array;
	}else{
		return	$array[$field];
	} 
}

/**
 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
 *
 * @param string $name
 * @param array string $value
 * @param string $path
 * @return  array string
 */
function F($name, $value='', $path=DATA_PATH) {
    static $_cache = array();
    $filename = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            /// 删除缓存
            return unlink($filename);
        } else {
            /// 缓存数据
            $dir = dirname($filename);
            /// 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir);
            $_cache[$name] =   $value;
            return file_put_contents($filename, strip_whitespace("<?php\nreturn " . var_export($value, true) . ";\n?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    /// 获取缓存数据
    if (is_file($filename)) {
        $value = include $filename;
        $_cache[$name] = $value;
    } else {
        $value = false;
    }
    return $value;
}


/**
 * 取得对象实例 支持调用类的静态方法
 *
 * @param string $name
 * @param string $method
 * @param  array $args
 * @return  object
 */
function get_instance_of($name, $method='', $args=array()) {
    static $_instance = array();
    $identify = empty($args) ? $name . $method : $name . $method . to_guid_string($args);
    if (!isset($_instance[$identify])) {
        if (class_exists($name)) {
            $o = new $name();
            if (method_exists($o, $method)) {
                if (!empty($args)) {
                    $_instance[$identify] = call_user_func_array(array(&$o, $method), $args);
                } else {
                    $_instance[$identify] = $o->$method();
                }
            }
            else
                $_instance[$identify] = $o;
        }
        else
            halt(L('_CLASS_NOT_EXIST_') . ':' . $name);
    }
    return $_instance[$identify];
}

/**
 * 根据PHP各种类型变量生成唯一标识号
 *
 * @param  object $mix
 * @return unknown
 */
function to_guid_string($mix) {
    if (is_object($mix) && function_exists('spl_object_hash')) {
        return spl_object_hash($mix);
    } elseif (is_resource($mix)) {
        $mix = get_resource_type($mix) . strval($mix);
    } else {
        $mix = serialize($mix);
    }
    return md5($mix);
}


/**
 * xml编码
 *
 * @param  string $data 数据
 * @param  string $encoding 字符集默认utf8
 * @param  string $root 根标签
 * @return string
 */
function xml_encode($data, $encoding='utf-8', $root='think') {
    $xml = '<?xml version="1.0" encoding="' . $encoding . '"?>';
    $xml.= '<' . $root . '>';
    $xml.= data_to_xml($data);
    $xml.= '</' . $root . '>';
    return $xml;
}

/**
 * 数组转为xml数据
 *
 * @param  array $data
 * @return string
 */
function data_to_xml($data) {
    $xml = '';
    foreach ($data as $key => $val) {
        is_numeric($key) && $key = "item id=\"$key\"";
        $xml.="<$key>";
        $xml.= ( is_array($val) || is_object($val)) ? data_to_xml($val) : $val;
        list($key, ) = explode(' ', $key);
        $xml.="</$key>";
    }
    return $xml;
}


/**
 * session管理函数
 *
 * @param string $name
 * @param string $value
 * @return unknown
 */
function session($name,$value='') {
    $prefix   =  C('SESSION_PREFIX');
    if(is_array($name)) { /// session初始化 在session_start 之前调用
        if(isset($name['prefix'])) C('SESSION_PREFIX',$name['prefix']);
        if(isset($_REQUEST[C('VAR_SESSION_ID')])){
            session_id($_REQUEST[C('VAR_SESSION_ID')]);
        }elseif(isset($name['id'])) {
            session_id($name['id']);
        }
        ini_set('session.auto_start', 0);
        if(isset($name['name'])) session_name($name['name']);
        if(isset($name['path'])) session_save_path($name['path']);
        if(isset($name['domain'])) ini_set('session.cookie_domain', $name['domain']);
        if(isset($name['expire'])) ini_set('session.gc_maxlifetime', $name['expire']);
        if(isset($name['use_trans_sid'])) ini_set('session.use_trans_sid', $name['use_trans_sid']?1:0);
        if(isset($name['use_cookies'])) ini_set('session.use_cookies', $name['use_cookies']?1:0);
        if(isset($name['type'])) C('SESSION_TYPE',$name['type']);
        if(C('SESSION_TYPE')) { /// 读取session驱动
            $class = 'Session'. ucwords(strtolower(C('SESSION_TYPE')));
            /// 检查驱动类
            if(require_cache(EXTEND_PATH.'Driver/Session/'.$class.'.class.php')) {
                $hander = new $class();
                $hander->execute();
            }else {
                /// 类没有定义
                throw_exception(L('_CLASS_NOT_EXIST_').': ' . $class);
            }
        }
        /// 启动session
        if(C('SESSION_AUTO_START'))  session_start();
    }elseif('' === $value){ 
        if(0===strpos($name,'[')) { /// session 操作
            if('[pause]'==$name){ /// 暂停session
                session_write_close();
            }elseif('[start]'==$name){ /// 启动session
                session_start();
            }elseif('[destroy]'==$name){ /// 销毁session
                $_SESSION =  array();
                session_unset();
                session_destroy();
            }elseif('[regenerate]'==$name){ /// 重新生成id
                session_regenerate_id();
            }
        }elseif(0===strpos($name,'?')){ /// 检查session
            $name   =  substr($name,1);
            if($prefix) {
                return isset($_SESSION[$prefix][$name]);
            }else{
                return isset($_SESSION[$name]);
            }
        }elseif(is_null($name)){ /// 清空session
            if($prefix) {
                unset($_SESSION[$prefix]);
            }else{
                $_SESSION = array();
            }
        }elseif($prefix){ /// 获取session
            return $_SESSION[$prefix][$name];
        }else{
            return $_SESSION[$name];
        }
    }elseif(is_null($value)){ /// 删除session
        if($prefix){
            unset($_SESSION[$prefix][$name]);
        }else{
            unset($_SESSION[$name]);
        }
    }else{ /// 设置session
        if($prefix){
            if (!is_array($_SESSION[$prefix])) {
                $_SESSION[$prefix] = array();
            }
            $_SESSION[$prefix][$name]   =  $value;
        }else{
            $_SESSION[$name]  =  $value;
        }
    }
}


/**
 * Cookie 设置、获取、删除
 *
 * @param string $name
 * @param string $value
 * @param string $option
 * @return bool
 */
function cookie($name, $value='', $option=null) {
    /// 默认设置
    $config = array(
        'prefix' => C('COOKIE_PREFIX'), /// cookie 名称前缀
        'expire' => C('COOKIE_EXPIRE'), /// cookie 保存时间
        'path' => C('COOKIE_PATH'), /// cookie 保存路径
        'domain' => C('COOKIE_DOMAIN'), /// cookie 有效域名
    );
    /// 参数设置(会覆盖黙认设置)
    if (!empty($option)) {
        if (is_numeric($option))
            $option = array('expire' => $option);
        elseif (is_string($option))
            parse_str($option, $option);
        $config = array_merge($config, array_change_key_case($option));
    }
    /// 清除指定前缀的所有cookie
    if (is_null($name)) {
        if (empty($_COOKIE))
            return;
        /// 要删除的cookie前缀，不指定则删除config设置的指定前缀
        $prefix = empty($value) ? $config['prefix'] : $value;
        if (!empty($prefix)) {/// 如果前缀为空字符串将不作处理直接返回
            foreach ($_COOKIE as $key => $val) {
                if (0 === stripos($key, $prefix)) {
                    setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
                    unset($_COOKIE[$key]);
                }
            }
        }
        return;
    }
    $name = $config['prefix'] . $name;
    if ('' === $value) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null; /// 获取指定Cookie
    } else {
        if (is_null($value)) {
            setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
            unset($_COOKIE[$name]); /// 删除指定cookie
        } else {
            /// 设置cookie
            $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
            setcookie($name, $value, $expire, $config['path'], $config['domain']);
            $_COOKIE[$name] = $value;
        }
    }
}


/**
 * 加载扩展配置文件
 *
 */
function load_ext_file() {
    /// 加载自定义外部文件
    if(C('LOAD_EXT_FILE')) {
        $files =  explode(',',C('LOAD_EXT_FILE'));
        foreach ($files as $file){
            $file   = COMMON_PATH.$file.'.php';
            if(is_file($file)) include $file;
        }
    }
    /// 加载自定义的动态配置文件
    if(C('LOAD_EXT_CONFIG')) {
        $configs =  C('LOAD_EXT_CONFIG');
        if(is_string($configs)) $configs =  explode(',',$configs);
        foreach ($configs as $key=>$config){
            $file   = CONF_PATH.$config.'.php';
            if(is_file($file)) {
                is_numeric($key)?C(include $file):C($key,include $file);
            }
        }
    }
}

/**
 * 获取客户端IP地址
 *
 * @return  string
 */
function get_client_ip() {
    static $ip = NULL;
    if ($ip !== NULL) return $ip;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos =  array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip   =  trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    /// IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}

/**
 * 获取http对应的状态信息
 *
 * @param  string $code 状态值 如404
 */
function send_http_status($code) {
    static $_status = array(
        /// Success 2xx
        200 => 'OK',
        /// Redirection 3xx
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily ',  /// 1.1
        /// Client Error 4xx
        400 => 'Bad Request',
        403 => 'Forbidden',
        404 => 'Not Found',
        /// Server Error 5xx
        500 => 'Internal Server Error',
        503 => 'Service Unavailable',
    );
    if(isset($_status[$code])) {
        header('HTTP/1.1 '.$code.' '.$_status[$code]);
        /// 确保FastCGI模式下正常
        header('Status:'.$code.' '.$_status[$code]);
    }
} 

/**
 * 获取当前登陆用户缓存在session中的信息
 *
 * @param string $field
 * @return ustring,array
 */
function getUser($field=null,$value=null){
	if ($field==null) {
		return $_SESSION['LOGIN_USER'];
	}
	if (!empty($value)) {
		$_SESSION['LOGIN_USER'][strtolower($field)] = $value;
		return ;
	}
	return $_SESSION['LOGIN_USER'][strtolower($field)];
}

/**
 * 将字符串的首字母转为小写
 */
function ucwords_first($str){
	if(empty($str)) return ;
	$f = strtolower($str{0});
	return $f.substr($str,1);
}

/**
 * 根据M和A的值获取对应语言包信息
 */
function title($action,$module=null){
	$s_name	= 'menu_title';
	if (is_numeric($action)) {
		$s_key = 'parenttitle_'.$action;
	}elseif (empty($module)){
		$s_key = MODULE_NAME.$action;
	}else {
		$s_key = $module.$action;
	}
	if ($mem_info = SOnly($s_name, $s_key)) {
		$module = $mem_info['module'];
		$action = $mem_info['action'];
	}else {
		if (is_numeric($action)) {
			$rs = M('Node')->find($action);
			if (empty($rs['module'])) {
				$module = $rs['id'];
				$action = null;
			}elseif ($rs['level']==3) {
				$rs2 = M('Node')->find($rs['parent_id']);
				$module = $rs2['module'];
				$action = $rs['module'];
			}else {
				$module = $rs['module'];
				$action = 'index';
			}
		}else {
			if (empty($module)) {$module = MODULE_NAME;}
		}
		$s_value			= S($s_name);
		$mem_info			= array('module'=>$module,'action'=>$action);
		$s_value[$s_key]	= $mem_info;
		S($s_name, $s_value);
	}
	$title = '';
	$action_ary = C('ACTION_TITLE_ARY');
	$fac_action_ary	= C('FAC_ACTION_TITLE_ARY');
	if (getUser('role_type') == C('SELLER_ROLE_TYPE') && !empty($fac_action_ary)) {
		$action_ary	= array_merge_deep($action_ary, $fac_action_ary);
	}
	if (is_null($action) && isset($action_ary['module_'.$module])) {
		$title = $action_ary['module_'.$module];
	}elseif (isset($action_ary[$module][$action])) {
		$title = $action_ary[$module][$action];
	} else {
		switch ($action) {	
			case 'insert':
			case 'add':
				$title = L('insert').L('module_'.$module);
				break;
			case 'edit':
			case 'update':
				$title = L('update').L('module_'.$module);
				break;
			case 'view':
				$title = L('view').L('module_'.$module);
				break;
			case null:
				$title = L('module_'.$module);
				break;
			case isset($action_ary[$action]):
				$title = $action_ary[$action];
				break;			
			default:
				$title = L('module_'.$module);
				if(!in_array($module,C('MODULE_NO_INDEX'))){
					$title .= L($action);
				}
				break;
		}
	}
	return $title;
}

/**
 * 获取指定菜单的上级菜单
 *
 * @param string $module
 * @return string
 */
function parentsTitle($module){
	if (S('parentstitle_'.$module)) {
		$parents_id = S('parentstitle_'.$module);
	}else {
		$rs = M('Node')->getByModule($module);
		$rs = M('Node')->where('id='.$rs['parent_id'])->find();
		if ($rs['parent_id']) {
			$rs = M('Node')->find($rs['parent_id']);
		}
		S('parentstitle_'.$module,$rs['id']);
		$parents_id = $rs['id'];
	}
	return L( 'node_'.$parents_id);
}

/**
 * 获取固定项配置，主要是产品的库存属性
 *
 * @param  string $module  模块名称
 * @return array
 */
function getModuleSpec($module){
	$spec = C($module);
	/// 声明固定项产品号
	$attr = array('product_id');
	if ($spec['storage_format']>=2) {
		$attr[] = 'capability';
	}
	if ($spec['storage_format']>=3) {
		$attr[] = 'dozen';
	}
	if ($spec['color']==1) {
		$attr[] = 'color_id';
	}
	if ($spec['size']==1) {
		$attr[] = 'size_id';
	}
	if ($spec['mantissa']==1) {
		$attr[] = 'mantissa';
	}
	return $attr;
}

/**
 * 启动事务
 *
 */
function startTrans(){
	M()->startTrans();
}

/**
 * 提交事务
 *
 */
function commit(){
	M()->commit();
}

/**
 * 回滚事务
 *
 */
function rollback(){
	M()->rollback();
}