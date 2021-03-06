<?php
//系统错误
define('CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_XML_OR_JSON',				'S01');		//非法的XML/JSON
define('CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_DIGITAL_SIGNATURE',			'S02');		//非法的数字签名
define('CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_LOGISTICS_OR_WAREHOUSING',	'S03');		//非法的物流公司/仓储公司
define('CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_NOTIFICATION_TYPE',			'S04');		//非法的通知类型
define('CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_NOTIFICATION_CONTENT',		'S05');		//非法的通知内容
define('CAINIAO_ERROR_REASON_SYSTEM_NETWORK_TIMEOUT',					'S06');		//网络超时，请重试
define('CAINIAO_ERROR_REASON_SYSTEM_SYSTEM_ABNORMAL',					'S07');		//系统异常，请重试
define('CAINIAO_ERROR_REASON_SYSTEM_HTTP_STATUS_ABNORMAL',				'S08');		//HTTP状态异常（非200）
define('CAINIAO_ERROR_REASON_SYSTEM_RETURN_CONTENT_EMPTY',				'S09');		//返回报文为空
define('CAINIAO_ERROR_REASON_SYSTEM_NOT_FOUND_GATEWAY',					'S10');		//找不到对应的网关信息
define('CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_GATEWAY',					'S11');		//非法的网关信息
define('CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_REQUEST_PARAMETERS',		'S12');		//非法的请求参数
define('CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION',		'S13');		//业务服务异常

//业务错误
define('CAINIAO_ERROR_REASON_BUSINESS_UNKNOWN_BUSINESS_ERROR',			'B00');		//未知业务错误
define('CAINIAO_ERROR_REASON_BUSINESS_MISSING_KEY_FIELDS',				'B01');		//关键字段缺失
define('CAINIAO_ERROR_REASON_BUSINESS_KEY_DATA_FORMAT_INCORRECT',		'B02');		//关键数据格式不正确
define('CAINIAO_ERROR_REASON_BUSINESS_NOT_FOUND_REQUEST_DATA',			'B03');		//没有找到请求的数据
define('CAINIAO_ERROR_REASON_BUSINESS_CAN_NOT_OPERATE',					'B04');		//当前数据状态不能进行该项操作
define('CAINIAO_ERROR_REASON_BUSINESS_FAILED_TO_SAVE_DATA',				'B98');		//数据保存失败

return array(
	'LOCK_ON'								=> false,					//关闭乐观锁验证
	'TOKEN_ON'								=> false,					//关闭表单令牌验证
	'SHOW_PAGE_TRACE'						=> false,					//
	'SNAP_DISABLE_VERIFY'					=> true,					//开启临时免验证
	'USER_AUTH_ON'							=> false,					//关闭权限验证
	'THROW_JSON_TO_STRING'					=> true,					//让throw_json直接返回错误信息

	'CAINIAO_DEFAULTCONFIG_COMP_TYPE'		=> 1,						//往来单位类型: 1=>卖家
	'CAINIAO_DEFAULTCONFIG_CLIENT_TYPE'		=> 1,						//客户类型: 1=>买家
	'CAINIAO_ERROR_MSG_DEFINITION'			=> array(//错误原因
												//系统错误
												CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_XML_OR_JSON					=> '非法的XML/JSON',
												CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_DIGITAL_SIGNATURE			=> '非法的数字签名',
												CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_LOGISTICS_OR_WAREHOUSING	=> '非法的物流公司/仓储公司',
												CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_NOTIFICATION_TYPE			=> '非法的通知类型',
												CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_NOTIFICATION_CONTENT		=> '非法的通知内容',
												CAINIAO_ERROR_REASON_SYSTEM_NETWORK_TIMEOUT						=> '网络超时，请重试',
												CAINIAO_ERROR_REASON_SYSTEM_SYSTEM_ABNORMAL						=> '系统异常，请重试',
												CAINIAO_ERROR_REASON_SYSTEM_HTTP_STATUS_ABNORMAL				=> 'HTTP状态异常（非200）',
												CAINIAO_ERROR_REASON_SYSTEM_RETURN_CONTENT_EMPTY				=> '返回报文为空',
												CAINIAO_ERROR_REASON_SYSTEM_NOT_FOUND_GATEWAY					=> '找不到对应的网关信息',
												CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_GATEWAY						=> '非法的网关信息',
												CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_REQUEST_PARAMETERS			=> '非法的请求参数',
												CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION			=> '业务服务异常',

												//业务错误
												CAINIAO_ERROR_REASON_BUSINESS_UNKNOWN_BUSINESS_ERROR			=> '未知业务错误',
												CAINIAO_ERROR_REASON_BUSINESS_MISSING_KEY_FIELDS				=> '关键字段缺失',
												CAINIAO_ERROR_REASON_BUSINESS_KEY_DATA_FORMAT_INCORRECT			=> '关键数据格式不正确',
												CAINIAO_ERROR_REASON_BUSINESS_NOT_FOUND_REQUEST_DATA			=> '没有找到请求的数据',
												CAINIAO_ERROR_REASON_BUSINESS_CAN_NOT_OPERATE					=> '当前数据状态不能进行该项操作',
												CAINIAO_ERROR_REASON_BUSINESS_FAILED_TO_SAVE_DATA				=> '数据保存失败',
											),
	'CAINIAO_ALLOW_REQUEST_STATUS'			=> array(//需要重新发送请求的状态
												CAINIAO_REQUEST_STATUS_NOT_YET,		//未操作
												CAINIAO_REQUEST_STATUS_FAILED,		//请求失败
												CAINIAO_REQUEST_STATUS_ABNORMAL,	//请求异常
												CAINIAO_REQUEST_STATUS_TIME_OUT,	//请求超时
											),
);