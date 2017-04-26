<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: convention.php 2942 2012-05-12 05:16:48Z liu21st@gmail.com $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP惯例配置文件
 * 该文件请不要修改，如果要覆盖惯例配置的值，可在项目配置文件中设定和惯例不符的配置项
 * 配置名称大小写任意，系统会统一转换成小写
 * 所有配置参数都可以在生效前动态改变
 +------------------------------------------------------------------------------
 * @category Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id: convention.php 2942 2012-05-12 05:16:48Z liu21st@gmail.com $
 +------------------------------------------------------------------------------
 */
!defined('THINK_PATH') && exit();
return  array(
    /* 项目设定 */
    'APP_STATUS'            => 'debug',  // 应用调试模式状态 调试模式开启后有效 默认为debug 可扩展 并自动加载对应的配置文件
    'APP_FILE_CASE'         => false,   // 是否检查文件的大小写 对Windows平台有效
    'APP_AUTOLOAD_PATH'     => '',// 自动加载机制的自动搜索路径,注意搜索顺序
    'APP_TAGS_ON'           => true, // 系统标签扩展开关
    'APP_SUB_DOMAIN_DEPLOY' => false,   // 是否开启子域名部署
    'APP_SUB_DOMAIN_RULES'  => array(), // 子域名部署规则
    'APP_SUB_DOMAIN_DENY'   => array(), //  子域名禁用列表
    'APP_GROUP_LIST'        => '',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
    /* Cookie设置 */
    'COOKIE_EXPIRE'         => 3600,    // Coodie有效期
    'COOKIE_DOMAIN'         => '',      // Cookie有效域名
    'COOKIE_PATH'           => '/',     // Cookie路径
    'COOKIE_PREFIX'         => '',      // Cookie前缀 避免冲突

    /* 默认设定 */
    'DEFAULT_APP'           => '@',     // 默认项目名称，@表示当前项目
    'DEFAULT_LANG'          => 'cn', // 默认语言
    'DEFAULT_THEME'    => '',	// 默认模板主题名称
    'DEFAULT_GROUP'         => 'Home',  // 默认分组
    'DEFAULT_MODULE'        => 'Index', // 默认模块名称
    'DEFAULT_ACTION'        => 'index', // 默认操作名称
    'DEFAULT_CHARSET'       => 'utf-8', // 默认输出编码
    'DEFAULT_TIMEZONE'      => 'Europe/Berlin',	// 默认时区
    'ORDERS_TIMEZONE'      => 'Europe/Berlin',	// 默认国内部分时区
    'SALE_TIMEZONE'      => 'Europe/Berlin',	// 默认国外部分时区
    'DEFAULT_AJAX_RETURN'   => 'JSON',  // 默认AJAX 数据返回格式,可选JSON XML ...
    'DEFAULT_FILTER'        => 'htmlspecialchars', // 默认参数过滤方法 用于 $this->_get('变量名');$this->_post('变量名')...

    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',     // 数据库类型
	'DB_HOST'               => 'localhost', // 服务器地址
	'DB_NAME'               => '',          // 数据库名
	'DB_USER'               => 'root',      // 用户名
	'DB_PWD'                => '',          // 密码
	'DB_PORT'               => '',        // 端口
	'DB_PREFIX'             => '',    // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => true,        // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        => false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         => 1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           => '', // 指定从服务器序号
    'DB_SQL_BUILD_CACHE'    => false, // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE'    => 'file',   // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH'   => 20, // SQL缓存的队列长度

    /* 数据缓存设置 */
    'DATA_CACHE_TIME'		=> 0,      // 数据缓存有效期 0表示永久缓存
    'DATA_CACHE_COMPRESS'   => false,   // 数据缓存是否压缩缓存
    'DATA_CACHE_CHECK'		=> false,   // 数据缓存是否校验缓存
    'DATA_CACHE_TYPE'		=> 'Memcache',  // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
    'DATA_CACHE_PATH'       => TEMP_PATH,// 缓存路径设置 (仅对File方式缓存有效)
    'DATA_CACHE_SUBDIR'		=> false,    // 使用子目录缓存 (自动根据缓存标识的哈希创建子目录)
    'DATA_PATH_LEVEL'       => 1,        // 子目录缓存级别
    'QUERY_CACHE'       	=> 1,        // 查询缓存，query,select时有效 1表示开启 0表示关闭
	'DD_SPLIT_LIMIT'		=> 5000,	//缓存分割组长度限制

    /* 错误设置 */
    'ERROR_MESSAGE'         => '您浏览的页面暂时发生了错误！请稍后再试～',//错误显示信息,非调试模式有效
    'ERROR_PAGE'            => '',	// 错误定向页面
    'SHOW_ERROR_MSG'        => false,    // 显示错误信息
    'SHOW_PAGE_TRACE'        => false,    // 显示错误信息

    /* 日志设置 */
    'LOG_RECORD'            => false,   // 默认不记录日志
    'LOG_TYPE'                 => 3, // 日志记录类型 0 系统 1 邮件 3 文件 4 SAPI 默认为文件方式
    'LOG_DEST'                 => '', // 日志记录目标
    'LOG_EXTRA'               => '', // 日志记录额外信息
    'LOG_LEVEL'                => 'EMERG,ALERT,CRIT,ERR',// 允许记录的日志级别
    'LOG_FILE_SIZE'         => 2097152,	// 日志文件大小限制
    'LOG_EXCEPTION_RECORD'  => false,    // 是否记录异常信息日志

    /* SESSION设置 */
    'SESSION_AUTO_START'    => true,    // 是否自动开启Session
    'SESSION_OPTIONS'           => array(), // session 配置数组 支持type name id path expire domian 等参数
    'SESSION_TYPE'              => '', // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX'            => '', // session 前缀
    'VAR_SESSION_ID'        => 'session_id',     //sessionID的提交变量

    /* 模板引擎设置 */
    'TMPL_ENGINE_TYPE'		=> 'Smarty',
    'TMPL_CONTENT_TYPE'     => 'text/html', // 默认模板输出类型
    'TMPL_ACTION_ERROR'     => THINK_PATH.'Tpl/Public/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   => THINK_PATH.'Tpl/Public/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE'   => THINK_PATH.'Tpl/Public/think_exception.tpl',// 异常页面的模板文件
    'TMPL_DETECT_THEME'     => false,       // 自动侦测模板主题
    'TMPL_TEMPLATE_SUFFIX'  => '.tpl',     // 默认模板文件后缀
    'TMPL_FILE_DEPR'=>'/', //模板文件MODULE_NAME与ACTION_NAME之间的分割符，只对项目分组部署有效
    /*Smarty参数设置 */
    'TMPL_ENGINE_CONFIG' => array( 
					    		'template_dir' 		=> TMPL_DIR, 
					    		'compile_dir' 		=> TEMP_PATH, 
					    		'caching' 			=> false,
					    		'cache_dir' 		=> TEMP_PATH, 
					    		'left_delimiter' 	=> '{',
					    		'right_delimiter' 	=> '}',
					    		'compile_check' 	=> true,
    						), 

    /* URL设置 */
	'URL_CASE_INSENSITIVE'  => false,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'             => 1,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
    'URL_PATHINFO_DEPR'     => '/',	// PATHINFO模式下，各参数之间的分割符号
    'URL_PATHINFO_FETCH'     =>   'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL', // 用于兼容判断PATH_INFO 参数的SERVER替代变量列表
    'URL_HTML_SUFFIX'       => '',  // URL伪静态后缀设置
    'URL_PARAM_BIND'        =>  true, // URL变量绑定到Action方法参数

    /* 系统变量名称设置 */
    'VAR_PAGE'              => 'nextPage',		// 默认分页跳转变量
    'VAR_GROUP'             => 'g',     // 默认分组获取变量
    'VAR_MODULE'            => 'm',		// 默认模块获取变量
    'VAR_ACTION'            => 'a',		// 默认操作获取变量
    'VAR_AJAX_SUBMIT'       => 'ajax',  // 默认的AJAX提交变量
    'VAR_PATHINFO'          => 's',	// PATHINFO 兼容模式获取变量例如 ?s=/module/action/id/1 后面的参数取决于URL_PATHINFO_DEPR
    'VAR_URL_PARAMS'      => '_URL_', // PATHINFO URL参数变量
    'VAR_TEMPLATE'          => 't',		// 默认模板切换变量
    'VAR_FILTERS'           =>  '',     // 全局系统变量的默认过滤方法 多个用逗号分割
    
    /* 表单令牌 验证 */
    'TOKEN_ON'=>false,  // 是否开启令牌验证
	'TOKEN_NAME'=>'__hash__',    // 令牌验证的表单隐藏字段名称
	'TOKEN_TYPE'=>'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'=>true,  //令牌验证出错后是否重置令牌 默认为true

	/* 乐观锁 验证 */
    'LOCK_ON'		=> TRUE,  // 是否开启乐观锁验证
	'LOCK_NAME'		=> 'lock_version',    // 乐观锁验证的表单隐藏字段名称

    /* 权限验证配置 */
    'USER_AUTH_ON'              =>true,
    'USER_AUTH_TYPE'			=>2,		// 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_MODEL'           =>'User',	// 默认验证数据表模型
    'AUTH_PWD_ENCODER'          =>'md5',	// 用户认证密码加密方式
    'USER_AUTH_GATEWAY'         =>'/Public/login',// 默认认证网关
    'ADMIN_GATEWAY'         	=>'/Admin/index',// 默认认证网关
    'NOT_AUTH_MODULE'           =>'Public,Index,Ajax,AutoComplete,AjaxExpand,AutoShow,QuicklyOperate,EmailList,EbaySeller,AmazonSeller,ProcessData,InstockBarcode',	// 默认无需认证模块
    'REQUIRE_AUTH_MODULE'       =>'',		// 默认需要认证模块
    'NOT_AUTH_ACTION'           =>'Public,editPsw,resetPasswd,setFormat,updateFormat,setOrderFinished,getUnloadOrder,deleteDetail,deleteBoxDetail,updateService,RatePlan,quicklyShowSaleType,edit,setting,updateSetting,setEnable,import,editStateUpdate,editConfirm',		// 默认无需认证操作
    'AUTO_DELETE_DETAIL'		=> array('Orders','LoadContainer','Instock','Adjust','InitStorage','SaleOrder','ReturnSaleOrder','Delivery','Transfer','Shipping','ReturnService'),
    'REQUIRE_AUTH_ACTION'       =>'',		// 默认需要认证操作
    'GUEST_AUTH_ON'             =>false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'             =>0,        // 游客的用户ID
    'DB_LIKE_FIELDS'            =>'title|remark',
    'RBAC_ROLE_TABLE'           =>'role',
    'RBAC_USER_TABLE'           =>'user',
    'RBAC_ACCESS_TABLE'         =>'access',
    'RBAC_NODE_TABLE'           =>'node',
	'KEEP_PAGE_ACTION'          => array('delete', 'backShelves'),		// 保留列表查询状态的操作
    
   	/// 固定值配置
   	'DEFAULT_BASIC_ID'			=> 1, // 单公司时默认公司ID值为1
   	'DEFAULT_WAREHOUSE_ID'		=> 1, // 单仓库时默认仓库ID值为1
   	
	/// 定义需要启用事务的操作
	'TRANS_ACTION'    			=> array('insert','update','delete', 'dealPicking','backShelves'),

	/// 定义系统用户，管理员，超级管理员session的默认key值
	'USER_AUTH_KEY'         => 'ytt_wms_user',		// 用户认证SESSION标记
    'ADMIN_AUTH_KEY'		=> 'ytt_wms_admin',		// 系统管理认证SESSION标记
    'SUPER_ADMIN_AUTH_KEY'	=> 'ytt_wms_super_admin',	// 超管认证SESSION标记

	//EBAY信息
	//'EBAY_RUNAME'           => 'EDZ-EDZ2252c9-b8ff--jgrhpjlok',	// 定义RUNAME
	'EBAY_RUNAME'           => 'EZD-EZDe5bad9-07e6--gforybd',	// 定义RUNAME
	
    'EBAY_DAYLIGH_SAVINGS'  => false,						    // 是否启用夏令时
    'EBAY_ENTRIES_PRE_PAGE' => '100',						    // 每页抓取记录
    'EBAY_VARIATION'	    => false,							// 是否启用EBAY多属性功能
    'EBAY_VARIATION_SIZE'   => '1',						        // EBAY属性所对应的尺码属性名称
    'EBAY_VARIATION_COLOR'  => '2',						        // EBAY属性所对应的颜色属性名称
	//亚马逊站点
	'AMAZON_COUNTRY'        => array(
							'United Kingdom'	=> array('MarketplaceID'=>'A1F83G8C2ARO7P',
														'URL'=>'www.amazon.co.uk',
														'MWS_URL'=>'https://mws-eu.amazonservices.com'),
							'Germany'	=> array('MarketplaceID'=>'A1PA6795UKMFR9',
														'URL'=>'www.amazon.de',
														'MWS_URL'=>'https://mws-eu.amazonservices.com'),
							'France'	=> array('MarketplaceID'=>'A13V1IB3VIYZZH',
														'URL'=>'www.amazon.fr',
														'MWS_URL'=>'https://mws-eu.amazonservices.com'),
							'Italy'	=> array('MarketplaceID'=>'APJ6JRA9NG5V4',
														'URL'=>'www.amazon.it',
														'MWS_URL'=>'https://mws-eu.amazonservices.com'),
							'Spain'	=> array('MarketplaceID'=>'A1RKKUPIHCS9HS',
														'URL'=>'www.amazon.es',
														'MWS_URL'=>'https://mws-eu.amazonservices.com'),
							'Japan'	=> array('MarketplaceID'=>'A1VC38T7YXB528',
														'URL'=>'www.amazon.co.jp',
														'MWS_URL'=>'https://mws.amazonservices.jp'),
							'China'	=> array('MarketplaceID'=>'AAHKV2X7AFYLW',
														'URL'=>'www.amazon.cn',
														'MWS_URL'=>'https://mws.amazonservices.com.cn'),
							'Canada'	=> array('MarketplaceID'=>'A2EUQ1WTGCTBG2',
														'URL'=>'www.amazon.ca',
														'MWS_URL'=>'https://mws.amazonservices.ca'),
							'United States'	=> array('MarketplaceID'=>'ATVPDKIKX0DER',
														'URL'=>'www.amazon.com',
														'MWS_URL'=>'https://mws.amazonservices.com'),
							'India'	=> array('MarketplaceID'=>'A21TJRUUN4KGV',
														'URL'=>'www.amazon.in',
														'MWS_URL'=>'https://mws.amazonservices.in'),
	),
);