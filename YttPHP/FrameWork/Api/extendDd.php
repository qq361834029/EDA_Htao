<?php
define('API_ERRORTYPE_NOT_ERROR', 0);								//正常
define('API_ERRORTYPE_XML_ABNORMAL', 1);							//xml异常
define('API_ERRORTYPE_INTERFACE_DOES_NOT_EXIST', 2);				//接口不存在
define('API_ERRORTYPE_DATA_DIGEST_ERROR', 3);						//授权码错误
define('API_ERRORTYPE_TIMES_OVER_THE_LIMIT', 4);					//请求超过限制
define('API_ERRORTYPE_PARAMETERS_ERROR', 5);						//参数错误
define('API_ERRORTYPE_DATA_VERIFY_FAILED', 6);						//数据验证失败
define('API_ERRORTYPE_SYSTEM_ERROR', 7);							//系统错误
define('API_ERRORTYPE_OPERATION_FAILED', 8);						//操作失败
define('API_ERRORTYPE_BATCH_PROCESS_OVER_THE_LIMIT', 9);			//批量处理超过限制

define('API_REQUESTCONFIG_TIME_INTERVAL', 5);						//次数限制时间间隔 单位：分钟
define('API_REQUESTCONFIG_TIMES_LIMIT', 9999);						//默认最大请求数量
define('API_REQUESTCONFIG_BATCH_PROCESS_LIMIT', 100);				//最大批量处理数量
define('API_RESPONSECONFIG_DEFAULT_ITEMSPERPAGE', 100);				//默认每页返回数量
define('API_RESPONSECONFIG_MAX_ITEMSPERPAGE', 200);					//最大每页返回数量

return array(
	'LOCK_ON'							=> false,					//关闭乐观锁验证
	'TOKEN_ON'							=> false,					//关闭表单令牌验证
	'SHOW_PAGE_TRACE'					=> false,					//
	'SNAP_DISABLE_VERIFY'				=> true,					//开启临时免验证
	'USER_AUTH_ON'						=> false,					//关闭权限验证
	'THROW_JSON_TO_STRING'				=> true,					//让throw_json直接返回错误信息
	
	'API_AUTH_TOKEN'					=> '',						//token
	'API_FACTORY_ID'					=> 0,						//卖家id
	'API_DEFAULTCONFIG_COMP_TYPE'		=> 1,						//往来单位类型: 1=>卖家
	'API_DEFAULTCONFIG_CLIENT_TYPE'		=> 1,						//客户类型: 1=>买家
	'API_ERROR_STATUS_DEFINITION'		=> array(//返回状态 成功:'Success',失败:'Failure',警告:'Warning'
												API_ERRORTYPE_NOT_ERROR						=> 'Success',
												API_ERRORTYPE_XML_ABNORMAL					=> 'Failure',
												API_ERRORTYPE_INTERFACE_DOES_NOT_EXIST		=> 'Failure',
												API_ERRORTYPE_DATA_DIGEST_ERROR				=> 'Failure',
												API_ERRORTYPE_TIMES_OVER_THE_LIMIT			=> 'Warning',
												API_ERRORTYPE_PARAMETERS_ERROR				=> 'Failure',
												API_ERRORTYPE_DATA_VERIFY_FAILED			=> 'Warning',
												API_ERRORTYPE_SYSTEM_ERROR					=> 'Failure',
												API_ERRORTYPE_OPERATION_FAILED				=> 'Failure',
												API_ERRORTYPE_BATCH_PROCESS_OVER_THE_LIMIT	=> 'Warning',
											),
	'API_ERROR_MSG_DEFINITION'			=> array(		//错误原因
												API_ERRORTYPE_NOT_ERROR						=> '请求正常!',
												API_ERRORTYPE_XML_ABNORMAL					=> '请求的Xml文件异常!',
												API_ERRORTYPE_INTERFACE_DOES_NOT_EXIST		=> '请求的接口不存在!',
												API_ERRORTYPE_DATA_DIGEST_ERROR				=> '数据签名错误!',
												API_ERRORTYPE_TIMES_OVER_THE_LIMIT			=> '请求超过限制!',
												API_ERRORTYPE_PARAMETERS_ERROR				=> '参数错误!',
												API_ERRORTYPE_DATA_VERIFY_FAILED			=> '数据验证失败!',
												API_ERRORTYPE_SYSTEM_ERROR					=> '系统错误!',
												API_ERRORTYPE_OPERATION_FAILED				=> '操作失败!',
												API_ERRORTYPE_BATCH_PROCESS_OVER_THE_LIMIT	=> '批量处理超过限制!',
											),
	'API_ERROR_LEVEL_DEFINITION'		=> array(//返回错误等级
												API_ERRORTYPE_NOT_ERROR						=> 0,
												API_ERRORTYPE_BATCH_PROCESS_OVER_THE_LIMIT	=> 110,
												API_ERRORTYPE_TIMES_OVER_THE_LIMIT			=> 120,
												API_ERRORTYPE_DATA_VERIFY_FAILED			=> 130,
												API_ERRORTYPE_OPERATION_FAILED				=> 240,
												API_ERRORTYPE_PARAMETERS_ERROR				=> 250,
												API_ERRORTYPE_DATA_DIGEST_ERROR				=> 666,
												API_ERRORTYPE_XML_ABNORMAL					=> 777,
												API_ERRORTYPE_INTERFACE_DOES_NOT_EXIST		=> 888,
												API_ERRORTYPE_SYSTEM_ERROR					=> 999,
											),
);