<?php
/**
 * ApiPublicAction
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	公共Api类
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-10-08
 */
class ApiPublicAction {
	private $_trans								= false;	//事务开启标志
	protected $error_type						= 0;		//错误类别
	protected $error_msg						= array();	//自定义错误信息
	protected $real_error_msg					= array();	//自定义错误信息
	private $request_time						= '';		//请求时间
	private $data_digest						= '';		//数据签名
	private $local_data_digest					= '';		//本地数据签名
	private $requestXml							= '';		//请求xml
	private $xmlFp								= '';		//xml保存文件句柄
	private $requestData						= array();	//请求数据
	private $request_id							= null;		//请求id(请求日志id)
	private $request_ip							= '';		//请求ip
	private $return_time						= '';		//返回时间
	private $responseData						= array();	//返回数据
	private $responseXml						= '';		//返回xml
	private $PageNumber							= 1;		//页码
	private $ItemsPerPage						= 100;		//每页数量
	private $TotalNumberOfEntries				= 0;		//总数量
	private $TotalNumberOfPages					= 0;		//总页数
	private $_page								= false;	//分页标志

    public function __construct() {
		$this->validRequestType();
		$this->_initialize();		//初始化
		//验证请求次数
		$this->validRequestTimes();
		$this->saveApiLog();		//记录日志
    	/// 判断操作是否需要开启事务
        if (preg_match('/^(Add|Delete|Modify)[A-Z]/', API_NAME) || in_array(API_NAME, C('API_TRANS_ACTION'))) {
        	$this->_trans = true;
        }
		$actionXmlData	= $this->parseRequestXml();	//解析xml
		$this->validRequest($actionXmlData);						//请求验证
		$this->parseRequestData($actionXmlData);	//解析数据
		$this->validRequestData();					//数据验证
	}

	public function validRequestType() {
		if (IS_POST !== true) {
			exit();
		}
	}

	/**
	 * 加载配置及扩展函数文件
	 */
	private function load_file(){
		$config_file	= array('action_config', 'fields_config', 'extendDd');
		foreach ($config_file as $file_name) {
			$file_path	= THINK_PATH . 'Api/' . $file_name . '.php';
			if(is_file($file_path)){
				C(include $file_path);
			}
		}
		$function_file	= array('functions', 'functions_extend');
		foreach ($function_file as $file_name) {
			$file_path	= THINK_PATH . 'Api/' . $file_name . '.php';
			if(is_file($file_path)){
				require_cache($file_path);
			}
		}
	}
	
	/**
	 * 初始化
	 */
	public function _initialize(){
		$this->load_file();
		define('API_NAME', ACTION_NAME);//API名称
		C('API_ACTION_INFO', C('API_ACTION_LIST.'.API_NAME));
		define('API_MODULE_NAME', C('API_ACTION_INFO.MODULE'));//请求模块
		define('API_ACTION_NAME', C('API_ACTION_INFO.ACTION'));//请求方法
		define('API_PARSE_MODULE_NAME', parse_name(API_MODULE_NAME));//请求模块
		define('API_DETAILS_KEY', C('API_MODULE_DETAILS_KEY.'.API_ACTION_NAME) ? C('API_MODULE_DETAILS_KEY.'.API_ACTION_NAME) : C('API_MODULE_DETAILS_KEY.'.API_MODULE_NAME));//请求模块明细下标
		$this->request_time	= date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);	//请求时间
		$this->request_ip	= get_client_ip();
		$this->error_type	= API_ERRORTYPE_NOT_ERROR;
		$this->ItemsPerPage	= API_RESPONSECONFIG_DEFAULT_ITEMSPERPAGE;
		addLang(array(MODULE_NAME, API_MODULE_NAME));
    	/// 判断操作是否需要分页
        if (preg_match('/[a-z]List$/', API_NAME) || in_array(API_NAME, C('API_PAGE_ACTION'))) {
        	$this->_page = true;
        }
		$this->data_digest	= trim($_GET['DataDigest']);	//数据签名
		$this->requestXml	= file_get_contents('php://input');//正式
		MAGIC_QUOTES_GPC === true && $this->requestXml	= stripslashes($this->requestXml);
	}
	
	/**
	 * 接口验证/调用
	 * @param string $method
	 * @param array $parameter
	 */
	public function __call($method, $parameter) {
		$method	= $method . 'Action';
		if (method_exists($this, $method)) {
			try {
				call_user_func_array(array(&$this, $method), (array)$parameter);
			} catch (Exception $ex) {
				$error	= api_set_abnormal_error(api_line(__LINE__) . '执行请求出错: ', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		} else {//接口不存在
			$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, api_line(__LINE__) . $method . '不存在!');
		}
	}
	
	/**
	 * 获取请求XML
	 */
	public function parseRequestXml(){
		try {
			import('ORG.Util.XML2Array');			
			$xmlData = XML2Array::createArray($this->requestXml);
			if (empty($xmlData[API_NAME])) {
				$error	= '[Action][/Action]必须存在且不能为空!';
				$this->addErrorMsg($error);
				$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
			}
			$actionXmlData		= $xmlData[API_NAME];
			api_set_debug($actionXmlData);
			//获取并设置分页配置(页码,每页数量)
			$this->_page == true && $this->getPageConfig($actionXmlData);
			if (empty($actionXmlData['User'])) {
				$error	= '[User][/User]必须存在且不能为空!';
				$this->addErrorMsg($error);
				$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
			}
			api_set_factory_id($actionXmlData);	//卖家id
			return $actionXmlData;
		} catch (Exception $ex) {
			//xml解析异常
			$error	= api_set_abnormal_error(api_line(__LINE__) . '解析xml出错: ', $ex);
			$this->setErrorTypeAndExit(API_ERRORTYPE_XML_ABNORMAL, $error);
		}
	}

	/**
	 * 获取请求数据
	 * @param array $actionXmlData
	 */
	public function parseRequestData($actionXmlData){
		$this->requestData	= $this->getRequestData($actionXmlData);
		C('API_GET_DATA_TYPE', strtolower($this->requestData['GetDataType']) != 'simple' ? 'All' : 'Simple');//获取数据类型
	}
    
	/**
	 * 开启事务
	 */
	private function startTrans(){
		if ($this->_trans == true) {
			startTrans();
		}
	}

	/**
	 * 提交事务/回滚事务
	 * @param int $error_type
	 */
	private function commitTrans($error_type = null){
		if ($this->_trans == true) {
			if (is_null($error_type)) {
				$error_type	= $this->error_type;
			}
			if ($error_type == API_ERRORTYPE_NOT_ERROR) {
				commit();	//提交事务
			} else {
				rollback();	//回滚事务
			}
		}
	}
	
	/**
	 * 获取请求数据数组
	 * @param array $actionXmlData
	 */
	private function getRequestData($actionXmlData) {
		$requestData	= $actionXmlData[API_NAME . 'Request'];
		$getMethod		= 'get' . API_NAME . 'RequestData';
		if (method_exists($this, $getMethod)) {
			try {
				$requestData	= $this->$getMethod($requestData);
			} catch (Exception $ex) {
				$error	= api_set_abnormal_error(api_line(__LINE__) . '获取请求数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		}
		return $requestData;
	}

	/**
	 * 更新日志并返回信息
	 */
	public function __destruct() {
		$this->validRequestType();
		$this->return_time		= date('Y-m-d H:i:s');	//返回时间
		//接收并清除可能的输出字符串
		$this->addRealErrorMsg(api_ob_get_clean());
		$this->real_error_msg	= api_err_string($this->real_error_msg) . C('REQUEST_REAL_ERROR_MSG');
		$this->getResponseXml();
		$this->commitTrans();
		$this->updateApiLog();						//更新记录日志	
		$this->response();							//返回xml
	}
	
	/**
	 * 记录日志
	 */
	private function saveApiLog(){
		$this->request_id	= (string)microtime(true)*10000;
		$this->xmlFp		= @fopen(api_get_xml_file_name($this->request_id, $this->request_time), 'a');//打开保存xml文件句柄(在析构函数中没有文件打开权限)
	}

	/**
	 * 记录日志
	 */
	private function updateApiLog(){
		if (!in_array($this->error_type, array(API_ERRORTYPE_NOT_ERROR, API_ERRORTYPE_TIMES_OVER_THE_LIMIT))) {
			//保存请求日志
			$api_log	= array(
				'request_id'		=> $this->request_id,
				'module'			=> API_MODULE_NAME,
				'action'			=> API_NAME,		//请求方法
				'request_ip'		=> $this->request_ip,	//请求ip
				'request_time'		=> $this->request_time,	//请求时间
				'data_digest'		=> $this->data_digest,	//数据签名
				'factory_id'		=> C('API_FACTORY_ID'),						//卖家id
				'local_data_digest'	=> '',
				'return_time'		=> $this->return_time,						//返回时间
				'return_status'		=> $this->getErrorStatus(),					//请求状态
				'error_type'		=> $this->error_type,						//错误类型
				'error_msg'			=> $this->getError(),						//错误信息
				'real_error_msg'	=> api_err_string($this->real_error_msg),	//详细错误信息
			);
			if ($this->data_digest != $this->local_data_digest) {//本地数据签名
				$api_log['local_data_digest']	= $this->local_data_digest;
			}
			M('ApiLog')->add($api_log);
		}
	}	

	/**
	 * 返回数据
	 */
	private function response(){
		echo $this->responseXml;//正式
	}

	/**
	 * 获取返回xml data
	 */
	private function getResponseXmlData($save = false){
		$error_msg			= (C('API_DEBUG') === 1 || $save === true) && !empty($this->real_error_msg) ? $this->real_error_msg : $this->getError();
		$actionResponse		= API_NAME . 'Response';
		$respnseXmlData		= array(
								'Ack'			=> $this->getErrorStatus(),
								'RequestID'		=> $this->request_id,
								'Errors'		=> array(
														'ErrorCode'		=> $this->error_type,
														'ErrorMessage'	=> api_err_string($error_msg),
														'ErrorAction'	=> API_NAME,
													),
								'Timestamp'		=> $this->request_time,
								'Pagination'	=> array(),
								$actionResponse	=> $this->responseData
							);
		if ($this->_page == true) {
			$respnseXmlData['Pagination']	= $this->getPagination();
		} else {
			unset($respnseXmlData['Pagination']);
		}
		return $respnseXmlData;
	}

	/**
	 * 获取返回xml
	 */
	private function getResponseXml(){
		$respnseXmlData		= $this->getResponseXmlData();
		import('ORG.Util.Array2XML');
		try {
			$xml				= Array2XML::createXML(API_NAME, $respnseXmlData);
			$this->responseXml	= $xml->saveXML();
		} catch (Exception $ex) {
			$error				= api_set_abnormal_error(api_line(__LINE__) . '返回数据xml构造失败!', $ex);
			$this->addRealErrorMsg($error);
			$this->responseXml	= xml_encode($respnseXmlData, 'utf-8', API_NAME);
		}
		if (!in_array($this->error_type, array(API_ERRORTYPE_NOT_ERROR, API_ERRORTYPE_TIMES_OVER_THE_LIMIT))) {
			$this->saveResponseXml();
		}
		@fclose($this->xmlFp);
	}

	/**
	 * 保存返回xml文件
	 */
	private function saveResponseXml(){
		if ($this->xmlFp) {
			$root				= API_NAME;
			if (C('API_DEBUG') === 1) {
				$responseXml		= $this->responseXml;
			} else {
				$respnseXmlData		= $this->getResponseXmlData(true);
				import('ORG.Util.Array2XML');
				try {
					$xml			= Array2XML::createXML($root, $respnseXmlData);
					$responseXml	= $xml->saveXML();
				} catch (Exception $ex) {
					$error			= api_set_abnormal_error(api_line(__LINE__) . '返回数据xml构造失败!', $ex);
					$this->addRealErrorMsg($error);
					$responseXml	= xml_encode($respnseXmlData, 'utf-8', $root);
				}
			}
			if (empty($responseXml)) {
				$respnseXmlData	= array(
									$root	=> $this->getResponseXmlData(true),
								);
				$returnXml		= var_export($respnseXmlData, true);
			} else {
				$returnXml		= $responseXml;
			}
			@fwrite($this->xmlFp, "Request[" . $this->request_time . "]:\n" . $this->requestXml . "\n\nResponse[" . $this->return_time . "]:\n" . $returnXml . "\n\n");
		}
	}

	/*********************************接口基本验证方法 st****************************************/

	/**
	 * 验证签名
	 */
	private function validDataDigest(){
		$auth_token					= M('Company')->where(array('id' => C('API_FACTORY_ID')))->getField('auth_token');
		$this->local_data_digest	= api_get_data_digest($this->requestXml, $auth_token);
		if ($this->data_digest != $this->local_data_digest) {
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_DIGEST_ERROR, api_line(__LINE__) . '数据签名错误![data_digest: ' . $this->data_digest . '; local_data_digest: ' . $this->local_data_digest . ']');
		}
		$api_data_digest	= S('API_DATA_DIGEST');
		if ($api_data_digest[$this->data_digest] === true) {
			$error	= '请勿重复请求!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_DIGEST_ERROR, api_line(__LINE__) . $error);
		} else {
			$api_data_digest[$this->data_digest]	= true;
			S('API_DATA_DIGEST', $api_data_digest);
		}
		C('API_AUTH_TOKEN', $auth_token);
	}
	
	/**
	 * 验证卖家
	 * @param int $factory_id
	 */
	private function validFactory(){
		$result	= api_valid_factory();
		if ($result <= 0) {
			switch ($result) {
				case -3:
					$real_msg	= 'ip(' . $this->request_ip . ')受限!';
					break;
				case -2:
					$real_msg	= '卖家账号信息不存在!';
					break;
				case -1:
					$real_msg	= 'E-mail找不到卖家!';
					break;
			}
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_DIGEST_ERROR, api_line(__LINE__) . $real_msg);
		}
	}

	/**
	 * 请求验证
	 */
	private function validRequest($actionXmlData){
		//验证请求接口
		$this->validRequestAction();
		//验证卖家
		$this->validFactory();
		//验证Time
		$this->validRequestTime($actionXmlData);
		//验证签名
		$this->validDataDigest();
	}

	/**
	 * 请求数据验证
	 */
	private function validRequestData(){
		//接口验证
		$validMethod	= 'valid' . API_NAME . 'RequestData';
		if (method_exists($this, $validMethod)) {
			$this->$validMethod();
		}
	}

	/**
	 * 验证RequestTime
	 */
	private function validRequestTime($actionXmlData){
		if (empty($actionXmlData['RequestTime'])) {
			$line	= api_line(__LINE__);
			$error	= '[RequestTime][/RequestTime]必须存在且不能为空!';
		}
		if (api_get_date($actionXmlData['RequestTime'], true) == '') {
			$line	= api_line(__LINE__);
			$error	= '[RequestTime][/RequestTime]无效，时间格式必须为Y-m-d H:i:s!';
		}
		if ($error) {
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, $line . $error);
		}
	}

	/**
	 * 验证接口
	 */
	private function validRequestAction(){
		$action_info	= C('API_ACTION_INFO');
		if (empty($action_info)) {
			$this->setErrorTypeAndExit(API_ERRORTYPE_INTERFACE_DOES_NOT_EXIST, api_line(__LINE__) . '接口不存在!');
		}
	}

	/**
	 * 验证请求次数
	 */
	private function validRequestTimes(){
		$time					= time();
		$request_times_limit	= C('API_ACTION_INFO.TIMES') > 0 ? (int)C('API_ACTION_INFO.TIMES') : API_REQUESTCONFIG_TIMES_LIMIT;
		if (API_REQUESTCONFIG_TIME_INTERVAL > 0 && $request_times_limit > 0) {
			$key					= md5(API_MODULE_NAME . '_' . API_NAME . '_' . $this->request_ip);
			$api_request_times		= S('API_REQUEST_TIMES');
			$time_limit				= $time - (int)API_REQUESTCONFIG_TIME_INTERVAL * 60;
			if (!empty($api_request_times[$key])) {
				$request_times			= 0;
				foreach ($api_request_times[$key] as $request_time => $times) {
					if ($request_time >= $time_limit) {
						$request_times	+= $times;
					} else {
						unset($api_request_times[$key][$request_time]);
					}
				}
				if ($request_times >= $request_times_limit) {
					$this->setErrorTypeAndExit(API_ERRORTYPE_TIMES_OVER_THE_LIMIT, api_line(__LINE__) . '请求次数超过限制(' . $count . '/' . $request_times_limit . ')!');
				}
			} else {
				$api_request_times[$key]	= array();
			}
			$api_request_times[$key][$time]++;
			S('API_REQUEST_TIMES', $api_request_times);
		}
	}

	/*********************************接口基本验证方法 ed****************************************/

	/*********************************接口错误处理方法 st****************************************/
	
    /**
	 * @param mixed $error
	 */
    public function addRealErrorMsg($error){
		api_add_error($this->real_error_msg, $error);
    }

    /**
	 * @param mixed $error
	 */
    public function addErrorMsg($error){
		api_add_error($this->error_msg, $error);
    }

	/**
	 * 设置错误类型并exit
	 * @param int $error_type
	 */
	private function setErrorTypeAndExit($error_type, $error){
		$this->addRealErrorMsg($error);
		$this->error_type	= $error_type;
		if ($this->error_type != API_ERRORTYPE_NOT_ERROR) {
			exit;
		}
	}

	/**
	 * 通过比较决定是否用明细错误类型覆盖主错误类型
	 * @param int $error_type
	 */
	public function setErrorTypeByDetail($error_type){
		if ($this->getErrorLevel() < $this->getErrorLevel($error_type)) {
			$this->error_type	= $error_type;
		}
	}

	/**
	 * 获取错误等级
	 * @param int $error_type
	 * @return int
	 */
	private function getErrorLevel($error_type = null){
		if (is_null($error_type)) {
			$error_type	= $this->error_type;
		}
		return C('API_ERROR_LEVEL_DEFINITION.'.$error_type);
	}

	/**
	 * 获取错误信息
	 * @return string
	 */
	public function getError($error_type = null) {
		if (is_null($error_type)){
			if(!empty($this->error_msg)) {
				return api_err_string($this->error_msg);
			}
			$error_type	= $this->error_type;
		}
		return C('API_ERROR_MSG_DEFINITION.'.$error_type);
	}

	/**
	 * 获取请求状态
	 * @return string
	 */
	public function getErrorStatus($error_type = null) {
		if (is_null($error_type)) {
			$error_type	= $this->error_type;
		}
		return C('API_ERROR_STATUS_DEFINITION.'.$error_type);
	}
	
	/*********************************接口错误处理方法 ed****************************************/

	/*********************************接口分页处理方法 st****************************************/
	
	/*
	 * 获取分页配置信息
	 */
	private function getPageConfig($actionXmlData){
		$this->PageNumber	= api_get_page_number($actionXmlData);
		$this->ItemsPerPage	= api_get_items_per_page($actionXmlData);
	}

	/**
	 * 总数量
	 * @param int $count
	 */
	private function setTotalNumberOfEntries($count = 0){
		$this->TotalNumberOfEntries	= $count > 0 ? intval($count) : 0;
	}

	/**
	 * 总页数
	 */
	private function setTotalNumberOfPages(){
		$this->TotalNumberOfPages	= $this->ItemsPerPage > 0 ? ceil($this->TotalNumberOfEntries/$this->ItemsPerPage) : 0;
	}

	/**
	 * 当前页码
	 */
	private function setPageNumber(){
		$this->PageNumber		= $this->PageNumber > 0 ? $this->PageNumber : 1;
		$this->PageNumber > $this->TotalNumberOfPages && $this->PageNumber = $this->TotalNumberOfPages;
	}

	/**
	 * 设置分页信息
	 * @param int $count
	 */
	private function setPagination($count = 0){
		//总数量
		$this->setTotalNumberOfEntries($count);
		//总页数
		$this->setTotalNumberOfPages();
		//当前页
		$this->setPageNumber();
	}

	/**
	 * 根据获取的id集进行分页，并返回当前页id集
	 * @param array $ids
	 * @return array
	 */
	public function setPage($ids	= array()){
		$count		= is_array($ids) ? count($ids) : 0;
		if ($this->_page == true && $count > 0) {
			$this->setPagination($count);
			$chunk_ids	= array_chunk($ids, $this->ItemsPerPage, true);
			$ids		= $chunk_ids[$this->PageNumber - 1];
		}
		return $ids;
	}

	/**
	 * 返回分页信息
	 * @return array
	 */
	private function getPagination(){
		$Pagination	= array(
			'ItemsPerPage'			=> $this->ItemsPerPage,
			'PageNumber'			=> $this->PageNumber,
			'TotalNumberOfEntries'	=> $this->TotalNumberOfEntries,
			'TotalNumberOfPages'	=> $this->TotalNumberOfPages,
		);
		return $Pagination;
	}

	/*********************************接口分页处理方法 ed****************************************/

	/*********************************接口辅助方法 st****************************************/
	
	/**
	 * 获取处理单号列表
	 * @param mixed $ProcessNo
	 * @param string $valid_function
	 * @param boolean $delete_invalid 是否删除无效数据default:true
	 * @return array
	 */
	private function  getProcessNoList($ProcessNo, $valid_function = 'api_valid_process_no', $delete_invalid = true){
		$invalid	= api_get_invalid_of_list($ProcessNo, $valid_function, $delete_invalid);
		if ($invalid === true) {
			$error	= $valid_function=='api_valid_instock_no' ? '不存在符合格式的发货单号!' : '不存在符合格式的处理单号!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
		return $ProcessNo;
	}
	
	/**
	 * 获取产品ID列表
	 * @param mixed $ProductID
	 * @return array
	 */
	private function getProductIDList($ProductID){
		$invalid	= api_get_invalid_of_list($ProductID, 'api_valid_product_id', true);
		if ($invalid === true) {
			$error	= '不存在符合格式的产品ID!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
		return $ProductID;
	}
	
	/**
	 * 获取产品SKU列表
	 * @param mixed $ProductSku
	 * @return array
	 */
	private function  getProductSkuList($ProductSku, $delete_invalid = true){
		$invalid	= api_get_invalid_of_list($ProductSku, 'api_valid_sku', $delete_invalid);
		if ($invalid === true) {
			$error	= '不存在符合格式的产品SKU!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
		return $ProductSku;
	}

	/**
	 * 获取搜索日期
	 * @param array $date
	 * @return array
	 */
	private function getSearchDate($date, $is_time = false){
		$date_fields	= array('StartTime', 'EndTime');
		foreach ($date_fields as $field) {
			if (!empty($date[$field])) {
				$date[$field]	= api_get_date($date[$field], $is_time);
				if ($date[$field] == '') {
					$error	= '日期格式错误!';
					$this->addErrorMsg($error);
					$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
				}
			} else {
				unset($date[$field]);
			}
		}
		return $date;
	}

	/**
	 * 获取单据列表
	 * @param mixed $requestData
	 * @return array
	 */
	private function  getDocList($requestData){
		$DocList						= api_get_doc_list($requestData[API_DETAILS_KEY]);
		if (empty($DocList)) {
			$error	= '不存在符合格式的单据!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
		$this->validBatchProcessLimit($DocList);
		$requestData[API_DETAILS_KEY]	= $DocList;
		return $requestData;
	}

	/**
	 * 批量处理数据量限制
	 * @param array $data
	 */
	private function validBatchProcessLimit($data){
		if (count($data) > API_REQUESTCONFIG_BATCH_PROCESS_LIMIT){
			$error	= '一次性处理的单据数量超过限制(' . count($data) . '/' . API_REQUESTCONFIG_BATCH_PROCESS_LIMIT . ')!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_BATCH_PROCESS_OVER_THE_LIMIT, api_line(__LINE__) . $error);
		}
	}

	/*********************************接口辅助方法 ed****************************************/
	
	/*********************************接口实现方法 st****************************************/
	
	/**
	 * GetOrder请求数据验证
	 */
	public function validGetOrderRequestData(){
		$requestData	= $this->requestData;
		if (empty($requestData['ProcessNo']) && empty($requestData['OrderNo'])) {
			$error	= '查询条件不能为空!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
		if (!empty($requestData['ProcessNo']) && api_valid_process_no($requestData['ProcessNo']) === false) {
			$error	= '处理单号格式错误!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}
	
	/**
	 * GetOrder请求获取数据
	 */
	public function GetOrderAction(){
		$requestData	= $this->requestData;
		$where		= array(
						'factory_id'	=> C('API_FACTORY_ID'),
					);
		$complex			= array();
		!empty($requestData['ProcessNo']) && $complex['sale_order_no']	= trim($requestData['ProcessNo']);
		!empty($requestData['OrderNo']) && $complex['order_no']			= trim($requestData['OrderNo']);
		if (count($complex) > 1) {
			$complex['_logic']	= 'or';
			$where['_complex']	= $complex;
		} else {
			$where	= array_merge($where, $complex);
		}
		$model		= D(API_MODULE_NAME);
		$sale_id	= $model->where($where)->getField('id');
		if ($sale_id > 0) {
			try {
				$function	= 'api' . API_NAME;
				$OrderInfo	= $model->$function($sale_id);
				$this->responseData[API_DETAILS_KEY]	= api_make_xml_order_details($OrderInfo);
			} catch (Exception $ex) {
				$error	= api_set_abnormal_error(api_line(__LINE__) . '获取销售单数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		} else {
			$error	= '销售单不存在!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . '销售单不存在或不属于该卖家!');
		}
	}	

	/**
	 * DeleteOrder获取请求数据
	 */
	public function getDeleteOrderRequestData($requestData){
		$requestData['ProcessNo']	= $this->getProcessNoList($requestData['ProcessNo'], 'api_valid_process_no', false);
		$this->validBatchProcessLimit($requestData['ProcessNo']);
		api_get_doc_list_by_doc_no($requestData, 'ProcessNo', 'sale_order_no,id,order_no,transaction_id,sale_order_state');
		return $requestData;
	}
	
	/**
	 * DeleteOrder请求数据验证
	 */
	public function validDeleteOrderRequestData(){
		if (empty($this->requestData['ProcessNo']) || !is_array($this->requestData['ProcessNo'])) {
			$error	= '处理单号不存在或格式错误!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}
	
	/**
	 * DeleteOrder请求获取数据
	 */	
	public function DeleteOrderAction(){
		$action		= 'delete';
		$DocList	= array();
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type		= API_ERRORTYPE_NOT_ERROR;
			$error_msg		= array();
			$real_error_msg	= array();
			$doc_id			= $DocInfo['id'];
			$processNo		= $DocInfo['sale_order_no'];
			if ($doc_id > 0) {
				$this->startTrans();
				$model		= D(API_MODULE_NAME);
				$model->setModuleInfo(API_MODULE_NAME, $action);
				try {
					$_POST	= array(
								'id'				=> $doc_id,
								'method_name'		=> API_MODULE_NAME,
								'_module'			=> API_MODULE_NAME,
								'_action'			=> $action,
							);
					if ($DocInfo['sale_order_state'] == C('SALE_ORDER_STATE_PICKING')) {
						$_POST['sale_order_state']	= C('SALE_ORDER_DELETED');
					}
					//业务规则验证
					api_brf($action, $_POST);
					//前置业务规则处理
					$model->_brf();
					if ($model->_beforeModel($_POST)) {
						if ($DocInfo['sale_order_state'] == C('SALE_ORDER_STATE_PICKING')) {//拣货中的销售单删除时状态更改为已删除
							$sale_order_state			= C('SALE_ORDER_DELETED');
							$info						= array(
															'id'				=> $doc_id,
															'sale_order_state'	=> $sale_order_state,
															C('LOCK_NAME')		=> array('exp', C('LOCK_NAME') . '+1'),
															'update_time'       => date('Y-m-d H:i:s'),
														);
							$r							= $model->save($info);
							//订单已删除新增状态日志
							$_POST['state_module_name']  = API_MODULE_NAME;
							$_POST['state_log_comments'] = 'API同步删除';
							$_POST['sale_order_state']   = $sale_order_state;
						} else {					
							$r	= $model->relation(true)->delete($doc_id);
						}
						if (false === $r) {
							$error	= array(
										api_line(__LINE__) . $processNo . '删除失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
							api_add_error($error_msg, $model->getError());
							$error_type	= API_ERRORTYPE_OPERATION_FAILED;
						} else {
							unset($_POST['method_name']);
							try{
								$model->_afterModel($_POST, $action);
								$model->execTags($_POST);
							} catch (Exception $ex) {
								$error	= api_set_abnormal_error(api_line(__LINE__) . '删除销售单后续行为处理出错: ', $ex);
								api_add_error($real_error_msg, $error);
								api_add_error($error_msg, $ex->getMessage());
								$error_type		= API_ERRORTYPE_DATA_VERIFY_FAILED;
							}
						}
					} else {
							$error	= array(
										api_line(__LINE__) . $processNo . '删除失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
							api_add_error($error_msg, $model->getError());
							$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
					}
				} catch (Exception $ex) {
					$error		= api_set_abnormal_error(api_line(__LINE__) . $processNo . '删除失败:', $ex);
					api_add_error($real_error_msg, $error);
					api_add_error($error_msg, $ex->getMessage());
					$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
				}
				$this->commitTrans($error_type);
			} else {
				$error		= $processNo . '找不到订单!';
				api_add_error($real_error_msg, api_line(__LINE__) . $error);
				api_add_error($error_msg, $error);
				$error_type	= API_ERRORTYPE_PARAMETERS_ERROR;
			}
			api_get_detail_error($DocInfo, $error_type, $error_msg, $real_error_msg, $this, 'sale_order_no');
			$DocList[]		= $DocInfo;
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_xml_delete_order');
	}	

	/**
	 * GetOrderList 获取请求数据
	 */
	public function getGetOrderListRequestData($requestData){
		//单号处理
		if (isset($requestData['ProcessNoArray']) && is_array($requestData['ProcessNoArray'])) {
			$requestData['ProcessNo']	= $this->getProcessNoList($requestData['ProcessNoArray']['ProcessNo']);
		}
		//订单号处理
		if (isset($requestData['OrderNoArray']) && is_array($requestData['OrderNoArray'])) {
			$requestData['OrderNo']	= $this->getProcessNoList($requestData['OrderNoArray']['OrderNo'], '');
		}
		//日期处理
		$date_fields	= array('OrderDate', 'ShippingDate', 'ModifyDate');
		foreach ($date_fields as $field) {
			if (!empty($requestData[$field])) {
				$is_time				= in_array($field, array('ModifyDate')) ? true : false;
				$requestData[$field]	= $this->getSearchDate($requestData[$field], $is_time);
			}
		}
		if (isset($requestData['OrderState']) && trim($requestData['OrderState']) == '') {
			unset($requestData['OrderState']);
		}
		return $requestData;
	}
	
	/**
	 * GetOrderList 请求数据验证
	 */
	public function validGetOrderListRequestData(){
		$requestData	= $this->requestData;
		if (!empty($requestData['OrderState']) && preg_match('/^\d+$/', trim($requestData['OrderState'])) == 0){
			$error	= '订单状态格式错误!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
		if(empty($requestData['ProcessNo']) && empty($requestData['OrderNo']) && empty($requestData['OrderDate']) && empty($requestData['ShippingDate']) && empty($requestData['ModifyDate']) && !isset($requestData['OrderState'])){
			$error	= '查询条件不能为空!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}
	
	/**
	 * GetOrderList 请求获取数据
	 */
	public function GetOrderListAction(){
		$where		= api_get_order_list_where($this->requestData);
		$model		= D(API_MODULE_NAME);
		$doc_ids	= $model->where($where)->order('sale_order_no desc')->getField('id', true);
		$count		= count($doc_ids);
		$DocList	= array();
		if ($count > 0) {
			try {
				$doc_ids	= $this->setPage($doc_ids);
				$function	= 'api' . API_NAME;
				$DocList	= $model->$function($doc_ids);
			} catch (Exception $ex) {
				$error		= api_set_abnormal_error(api_line(__LINE__) . '获取销售单列表数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}			
		}		
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_xml_order_details');
	}
	
	/**
	 * AddOrder请求数据验证
	 */
	public function getAddOrderRequestData($requestData){
        //添加默认数据
        if(!isset($requestData['OrderDetails']['IsInsure'])){
            $requestData['OrderDetails']['IsInsure']    = 2;
        }
		return $this->getDocList($requestData);
	}
	
	/**
	 * AddOrder请求数据验证
	 */
	public function validAddOrderRequestData(){
		$DocList	= array();
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type		= API_ERRORTYPE_NOT_ERROR;
			$error_msg		= '';
			$real_error_msg	= array();
			$return_error	= array();
			try {
                if(in_array($DocInfo["express_id"],explode(',',C('EXPRESS_FR_REGISTERED_ID')))){
                    $DocInfo["is_registered"]=1;
                }
                $DocInfo[C('LOCK_NAME')]    = 2;
				//买家信息验证
				$DocInfo['addition'][1]['module_name']	= 'Client';
				api_get_model_valid($DocInfo['addition'][1], $return_error);
				api_valid_detail_product($DocInfo['detail'], $return_error);
				$vasd	= array(
							array('order_no,factory_id','','order_no_repeat',1,'unique'),//同卖家订单号不能重复
							array('is_insure','yes_no','invalid_data',1),//是否投保
						);
				api_get_model_valid($DocInfo, $return_error, $vasd);
				api_set_unique_data($DocInfo, $return_error, 'order_no,factory_id', 'order_no');
			} catch (Exception $ex) {
				$error	= api_set_abnormal_error(api_line(__LINE__) . '新增销售单数据出错:', $ex);
				api_add_error($real_error_msg, $error);
				$error_type		= API_ERRORTYPE_SYSTEM_ERROR;
			}
			api_get_valid_detail_error($DocInfo, $error_type, $error_msg, $real_error_msg, $return_error);
			$DocList[]	= $DocInfo;
		}
		$this->requestData[API_DETAILS_KEY]	= $DocList;
	}

	/**
	 * AddOrder请求获取数据
	 */
	public function AddOrderAction(){
		$DocList	= array();
		$doc_ids	= array();
		$action		= 'insert';
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$DocDetails	= array();
			$init_error	= api_get_detail_init_error($DocInfo);//初始化$error_type, $error_msg, $real_error_msg
			extract($init_error);
			if ($error_type == API_ERRORTYPE_NOT_ERROR) {
				$this->startTrans();
				try {
					$addition	= $DocInfo['addition'][1];
					try {
						$addition['comp_no']	= getModuleMaxNo('Client');
					} catch (Exception $ex) {
						$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
						$error		= api_set_abnormal_error(api_line(__LINE__) . '生成买家编号出错:', $ex);
						api_add_error($real_error_msg, $error);
					}
					if ($error_type == API_ERRORTYPE_NOT_ERROR) {
						try {
							$Client					= D('Client');
							$DocInfo['client_id']	= $Client->add($addition);
						} catch (Exception $ex) {
							$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
							$error		= api_set_abnormal_error(api_line(__LINE__) . '创建买家出错:', $ex);
							api_add_error($real_error_msg, $error);
						}
						if ($error_type == API_ERRORTYPE_NOT_ERROR) {
							try {
								$model					= D(API_MODULE_NAME);
								$model->setModuleInfo(API_MODULE_NAME, $action);
								$model->data($DocInfo);
								$_POST					= $model->data();
								$_POST['method_name']	= $action;
								$doc_id				= $model->importInsert();
							} catch (Exception $ex) {
								$error		= api_set_abnormal_error(api_line(__LINE__) . '保存销售单出错:', $ex);
								api_add_error($error_msg, $ex->getMessage());
								api_add_error($real_error_msg, $error);
								$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
							}
							if ($error_type == API_ERRORTYPE_NOT_ERROR) {
								if($doc_id > 0){
									$DocDetails['id']	= $doc_id;
									$doc_ids[]			= $doc_id;
									try {
										A(API_MODULE_NAME)->generateBarcode($doc_id);
									} catch (Exception $ex) {
										$error		= api_set_abnormal_error(api_line(__LINE__) . '生成销售单条形码出错:', $ex);
										api_add_error($real_error_msg, $error);
										$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
									}
								} else {
									$error		= array(
													api_line(__LINE__) . '新增销售单失败:',
													$model->getError(),
													api_ob_get_clean(),
												);
									api_add_error($real_error_msg, $error);
									$error_type	= API_ERRORTYPE_OPERATION_FAILED;
								}
							}
						}
					}			
				} catch (Exception $ex) {
					$error		= api_set_abnormal_error(api_line(__LINE__) . '新增销售单失败:', $ex);
					api_add_error($real_error_msg, $error);
					$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
				}
				$this->commitTrans($error_type);
			}
			api_unset_unique_data($DocInfo, 'order_no');
			$DocDetails['order_no']			= $DocInfo['order_no'];
			$DocDetails['transaction_id']	= $DocInfo['transaction_id'];
			api_get_detail_error($DocDetails, $error_type, $error_msg, $real_error_msg, $this, 'order_no');
			$DocList[]						= $DocDetails;
		}
		if (!empty($doc_ids)){
			try{
				$model			= D(API_MODULE_NAME);
				$function		= 'api' . API_NAME;
				$DocInfoList	= resetArrayIndex($model->$function($doc_ids), 'id');
				foreach ($DocList as &$DocInfo) {
					$sale_id	= $DocInfo['id'];
					if(isset($DocInfoList[$sale_id])){
						$DocInfo	= array_merge($DocInfo, $DocInfoList[$sale_id]);
					}
				}
				$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_add_order');
				unset($DocInfoList);
			} catch (Exception $ex) {
				$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_add_order');
				$error									= api_set_abnormal_error(api_line(__LINE__) . '获取新增销售单数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		} else {
			$this->responseData[API_DETAILS_KEY]		= api_make_doc_list($DocList, 'api_make_add_order');
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_VERIFY_FAILED, '销售单全部新增失败！');
		}
	}	
	
	/**
	 * ModifyOrder请求数据验证
	 */
	public function getModifyOrderRequestData($requestData){
		return $this->getDocList($requestData);
	}
	
	/**
	 * ModifyOrder请求数据验证
	 */
	public function validModifyOrderRequestData(){
		$DocList	= array();
		$where		= array(
						'factory_id'	=> C('API_FACTORY_ID'),
					);
		$action		= 'edit';
		$_POST		= array(
			'method_name'	=> API_MODULE_NAME,
			'_module'		=> API_MODULE_NAME,
			'_action'		=> $action,
		);
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type			= API_ERRORTYPE_NOT_ERROR;
			$error_msg			= '';
			$real_error_msg		= array();
			$return_error		= array();
			try {
				if (api_valid_process_no($DocInfo['sale_order_no']) === false) {
					$real_error_msg[]	= '处理单号格式错误!';
					$error_type			= API_ERRORTYPE_PARAMETERS_ERROR;
				} else {
					$where['sale_order_no']	= $DocInfo['sale_order_no'];
					$fields					= 'id, factory_id, client_id, sale_order_state';
					$fields					.= api_get_not_exists_fields_string($DocInfo, C('API_SALE_ORDER_OPTIONAL_FIELDS'), true);
					$sale_order				= M(API_MODULE_NAME)->field($fields)->where($where)->find();
					if ($sale_order['id'] <= 0) {
						$real_error_msg[]	= '处理单号不存在或不属于当前卖家!';
						$error_type		= API_ERRORTYPE_PARAMETERS_ERROR;
					} else {
						try{
							$_POST['id']			= $sale_order['id'];
							//业务规则验证
							api_brf($action, $_POST);					
							$DocInfo					= array_merge($DocInfo, $sale_order);
							$fields						= 'id';
							$fields						.= api_get_not_exists_fields_string($DocInfo['addition'][1], C('API_SALE_ORDER_OPTIONAL_FIELDS.ShipToAddress'), true);
							$fields						.= api_get_not_exists_fields_string($DocInfo['addition'][1], C('API_SALE_ORDER_DETAIL_FIELDS'), false);
							$addition					= M('SaleOrderAddition')->field($fields)->where(array('sale_order_id' => $sale_order['id']))->find();
							$DocInfo['addition'][1]	= array_merge($DocInfo['addition'][1], $addition);
							api_valid_detail_product($DocInfo['detail'], $return_error);
							api_get_model_valid($DocInfo, $return_error);
						} catch (Exception $ex) {
							api_add_error($return_error, $ex->getMessage());
							$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
						}
					}
				}
			} catch (Exception $ex) {
				$error		= api_set_abnormal_error(api_line(__LINE__) . '修改销售单数据出错:', $ex);
				api_add_error($real_error_msg, $error);
				$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
			}
			api_get_valid_detail_error($DocInfo, $error_type, $error_msg, $real_error_msg, $return_error);
			$DocList[]					= $DocInfo;
		}
		$this->requestData[API_DETAILS_KEY]	= $DocList;
	}
	
	/**
	 * ModifyOrder请求获取数据
	 */
	public function ModifyOrderAction(){
		$DocList	= array();
		$doc_ids	= array();
		$action		= 'update';
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$doc_id	= (int)$DocInfo['id'];
			$DocDetails	= array(
								'id'	=> $doc_id,
							);
			$init_error	= api_get_detail_init_error($DocInfo);//初始化$error_type, $error_msg, $real_error_msg
			extract($init_error);
			if ($error_type == API_ERRORTYPE_NOT_ERROR && $doc_id > 0) {
				$doc_ids[]		= $doc_id;
				$this->startTrans();
				try {
					try {
						$model					= D(API_MODULE_NAME);
						$model->setModuleInfo(API_MODULE_NAME, $action);
						$model->data($DocInfo);
						$_POST					= $model->data();
						$_POST['method_name']	= $action;
						$updateResult			= $model->importUpdate() === false ? false : $DocInfo['id'];
					} catch (Exception $ex) {
						$error_type		= API_ERRORTYPE_DATA_VERIFY_FAILED;
						$error_msg[]	= $ex->getMessage();
						$error			= api_set_abnormal_error(api_line(__LINE__) . '修改销售单数据出错:', $ex);
						api_add_error($real_error_msg, $error);
					}
					if ($error_type == API_ERRORTYPE_NOT_ERROR) {
						if ($updateResult !== false) {
							try {
								A(API_MODULE_NAME)->generateBarcode($doc_id);
							} catch (Exception $ex) {
								$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
								$error		= api_set_abnormal_error(api_line(__LINE__) . '生成销售单条形码出错:', $ex);
								api_add_error($real_error_msg, $error);
							}							
						} else {
							$error_type		= API_ERRORTYPE_OPERATION_FAILED;
							$error	= array(
										api_line(__LINE__) . '修改销售单失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
						}
					}			
				} catch (Exception $ex) {
					$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
					$error		= api_set_abnormal_error(api_line(__LINE__) . '修改销售单失败:', $ex);
					api_add_error($real_error_msg, $error);
				}
				$this->commitTrans($error_type);
			}
			$DocDetails['order_no']			= $DocInfo['order_no'];
			$DocDetails['transaction_id']	= $DocInfo['transaction_id'];
			$DocDetails['sale_order_no']	= $DocInfo['sale_order_no'];
			api_get_detail_error($DocDetails, $error_type, $error_msg, $real_error_msg, $this, 'sale_order_no');
			$DocList[]						= $DocDetails;
		}
		if (!empty($doc_ids)){
			try{
				$model			= D(API_MODULE_NAME);
				$function		= 'api' . API_NAME;
				$DocInfoList	= resetArrayIndex($model->$function($doc_ids), 'id');
				foreach ($DocList as &$DocInfo) {
					$sale_id	= $DocInfo['id'];
					if(isset($DocInfoList[$sale_id])){
						$DocInfo	= array_merge($DocInfo, $DocInfoList[$sale_id]);
					}
				}
				$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_add_order');
				unset($DocInfoList);
			} catch (Exception $ex) {
				$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_add_order');
				$error									= api_set_abnormal_error(api_line(__LINE__) . '获取修改销售单数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}			
		} else {
			$this->responseData[API_DETAILS_KEY]		= api_make_doc_list($DocList, 'api_make_add_order');
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_VERIFY_FAILED, '销售单全部修改失败!');
		}
	}

	/**
	 * GetStorageList 获取请求数据
	 */
	public function getGetStorageListRequestData($requestData){
		//产品id
		if (isset($requestData['ProductIDArray']) && is_array($requestData['ProductIDArray'])) {
			$requestData['ProductID']	= $this->getProductIDList($requestData['ProductIDArray']['ProductID']);
		}
		//产品sku
		if (isset($requestData['SKUArray']) && is_array($requestData['SKUArray'])) {
			$requestData['SKU']	= $this->getProductSkuList($requestData['SKUArray']['SKU']);
		}
		if (isset($requestData['WarehouseNo'])) {
			$requestData['warehouse_id']	= (int)DdToId('warehouse', strtoupper($requestData['WarehouseNo']));
		}
		return $requestData;
	}
	
	/**
	 * GetStorageList 请求数据验证
	 */
	public function validGetStorageListRequestData(){
		$requestData	= $this->requestData;
		if (!empty($requestData['ProductID']) && !empty($requestData['SKU'])){
			$error	= '产品ID和产品SKU只能输入其中的一项!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}
	
	/**
	 * GetStorageList 请求获取数据
	 */
	public function GetStorageListAction(){
		$storageList							= api_get_storage_list($this->requestData, $this);
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($storageList, 'api_make_xml_storage');
	}

	/**
	 * GetProductList获取请求数据
	 */
	public function getGetProductListRequestData($requestData){
		//产品id
		if (isset($requestData['ProductIDArray']) && is_array($requestData['ProductIDArray'])) {
			$requestData['ProductID']	= $this->getProductIDList($requestData['ProductIDArray']['ProductID']);
		}
		//产品sku
		if (isset($requestData['SKUArray']) && is_array($requestData['SKUArray'])) {
			$requestData['SKU']	= $this->getProductSkuList($requestData['SKUArray']['SKU']);
		}
		return $requestData;
	}

	/**
	 * GetProductList请求获取数据
	 */
	public function GetProductListAction(){
		$productList							= api_get_product_list($this->requestData, $this);
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($productList, 'api_make_xml_product');
	}

	/**
	 * AddProduct请求数据验证
	 */
	public function getAddProductRequestData($requestData){
		return $this->getDocList($requestData);
	}

	/**
	 * AddProduct请求数据验证
	 */
	public function validAddProductRequestData(){
		$Product	= array();
		foreach ($this->requestData[API_DETAILS_KEY] as $ProductInfo) {
			$error_type			= API_ERRORTYPE_NOT_ERROR;
			$error_msg			= '';
			$real_error_msg		= array();
			$return_error		= array();
			try {
				api_valid_product_son($ProductInfo, $return_error);
				api_get_model_valid($ProductInfo, $return_error);
				api_set_unique_data($ProductInfo, $return_error, 'product_no,factory_id', 'product_no');
			} catch (Exception $ex) {
				$error	= api_set_abnormal_error(api_line(__LINE__) . '新增产品数据出错:', $ex);
				api_add_error($real_error_msg, $error);
				$error_type		= API_ERRORTYPE_SYSTEM_ERROR;
			}
			api_get_valid_detail_error($ProductInfo, $error_type, $error_msg, $real_error_msg, $return_error);
			$Product[]	= $ProductInfo;
		}
		$this->requestData[API_DETAILS_KEY]	= $Product;
	}

	/**
	 * AddProduct请求获取数据
	 */
	public function AddProductAction(){
		$ProductList	= array();
		$product_ids	= array();
		$action			= 'insert';
		foreach ($this->requestData[API_DETAILS_KEY] as $ProductInfo) {
			$Product		= array();
			$init_error		= api_get_detail_init_error($ProductInfo);//初始化$error_type, $error_msg, $real_error_msg
			extract($init_error);
			if ($error_type == API_ERRORTYPE_NOT_ERROR) {
				$this->startTrans();
				try {
					try {
						$model					= D(API_MODULE_NAME);
						$model->setModuleInfo(API_MODULE_NAME, $action);
						$model->data($ProductInfo);
						$_POST					= $model->data();
						$_POST['method_name']	= $action;
						$product_id				= $model->import();
					} catch (Exception $ex) {
						$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
						api_add_error($error_msg, $ex->getMessage());
						$error		= api_set_abnormal_error(api_line(__LINE__) . '保存产品出错:', $ex);
						api_add_error($real_error_msg, $error);
					}
					if ($error_type == API_ERRORTYPE_NOT_ERROR) {
						if($product_id > 0){
							$Product['id']	= $product_id;
							$product_ids[]	= $product_id;
							try {
								$Action	= A(API_MODULE_NAME);
								$Action->id	= $product_id;
								$Action->generateBarcode();
							} catch (Exception $ex) {
								$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
								$error		= api_set_abnormal_error(api_line(__LINE__) . '生成产品条形码出错:', $ex);
								api_add_error($real_error_msg, $error);
							}
						} else {
							$error_type	= API_ERRORTYPE_OPERATION_FAILED;
							$error		= array(
											api_line(__LINE__) . '新增产品失败:',
											$model->getError(),
											api_ob_get_clean(),
										);
							api_add_error($real_error_msg, $error);
						}
					}
				} catch (Exception $ex) {
					$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
					$error		= api_set_abnormal_error(api_line(__LINE__) . '新增产品失败:', $ex);
					api_add_error($real_error_msg, $error);
				}
				$this->commitTrans($error_type);
			}
			api_unset_unique_data($ProductInfo, 'product_no');
			$Product['product_no']		= $ProductInfo['product_no'];
			api_get_detail_error($Product, $error_type, $error_msg, $real_error_msg, $this, 'product_no');
			$ProductList[]				= $Product;
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($ProductList, 'api_make_xml_product_detail');
		if (empty($product_ids)){
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_VERIFY_FAILED, '产品全部新增失败!');
		}
	}

	/**
	 * ModifyProduct请求数据验证
	 */
	public function getModifyProductRequestData($requestData){
		return $this->getDocList($requestData);
	}

	/**
	 * ModifyProduct请求数据验证
	 */
	public function validModifyProductRequestData(){
		$Product	= array();
		$where		= array(
						'factory_id'	=> C('API_FACTORY_ID'),
					);
		foreach ($this->requestData[API_DETAILS_KEY] as $ProductInfo) {
			$error_type			= API_ERRORTYPE_NOT_ERROR;
			$error_msg			= '';
			$real_error_msg		= array();
			$return_error		= array();
			try {
				$where['id']	= $ProductInfo['id'];
				$product		= M(API_MODULE_NAME)->field('id, product_type')->where($where)->find();
				if ($product['id'] <= 0) {
					$real_error_msg[]	= '产品不存在或不属于当前卖家!';
					$error_type		= API_ERRORTYPE_PARAMETERS_ERROR;
				} else {
					$ProductInfo	= array_merge($ProductInfo, $product);
					api_valid_product_son($ProductInfo, $return_error);
					if (api_get_model_valid($ProductInfo, $return_error)) {
						$product_ids[]	= $ProductInfo['id'];
					}
				}
			} catch (Exception $ex) {
				$error	= api_set_abnormal_error(api_line(__LINE__) . '修改产品数据出错:', $ex);
				api_add_error($real_error_msg, $error);
				$error_type		= API_ERRORTYPE_SYSTEM_ERROR;
			}
			api_get_valid_detail_error($ProductInfo, $error_type, $error_msg, $real_error_msg, $return_error);
			$Product[]	= $ProductInfo;
		}
		api_fill_product_detail($Product, $product_ids);
		$this->requestData[API_DETAILS_KEY]	= $Product;
	}

	/**
	 * ModifyProduct请求获取数据
	 */
	public function ModifyProductAction(){
		$ProductList	= array();
		$product_ids	= array();
		$action			= 'update';
		foreach ($this->requestData[API_DETAILS_KEY] as $ProductInfo) {
			$product_id		= (int)$ProductInfo['id'];
			$Product		= array(
								'id'	=> $product_id,
							);
			$init_error		= api_get_detail_init_error($ProductInfo);//初始化$error_type, $error_msg, $real_error_msg
			extract($init_error);
			if ($error_type == API_ERRORTYPE_NOT_ERROR && $product_id > 0) {
				$product_ids[]			= $product_id;
				$this->startTrans();
				try {
					try {
						$model					= D(API_MODULE_NAME);
						$model->setModuleInfo(API_MODULE_NAME, $action);
						$model->data($ProductInfo);
						$_POST					= $model->data();
						$_POST['method_name']	= $action;
						$updateResult			= $model->import() === false ? false : $ProductInfo['id'];
					} catch (Exception $ex) {
						$error_type		= API_ERRORTYPE_DATA_VERIFY_FAILED;
						$error_msg[]	= $ex->getMessage();
						$error			= api_set_abnormal_error(api_line(__LINE__) . '修改产品数据出错:', $ex);
						api_add_error($real_error_msg, $error);
					}
					if ($error_type == API_ERRORTYPE_NOT_ERROR) {
						if ($updateResult !== false) {
							try {
								$Action	= A(API_MODULE_NAME);
								$Action->id	= $product_id;
								$Action->generateBarcode();
							} catch (Exception $ex) {
								$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
								$error		= api_set_abnormal_error(api_line(__LINE__) . '生成产品条形码出错:', $ex);
								api_add_error($real_error_msg, $error);
							}
						} else {
							$error_type		= API_ERRORTYPE_OPERATION_FAILED;
							$error	= array(
										api_line(__LINE__) . '修改产品失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
						}
					}
				} catch (Exception $ex) {
					$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
					$error		= api_set_abnormal_error(api_line(__LINE__) . '修改产品失败:', $ex);
					api_add_error($real_error_msg, $error);
				}
				$this->commitTrans($error_type);
			}
			$Product['product_no']		= $ProductInfo['product_no'];
			api_get_detail_error($Product, $error_type, $error_msg, $real_error_msg, $this, 'product_no');
			$ProductList[]				= $Product;
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($ProductList, 'api_make_xml_product_detail');
		if (empty($product_ids)){
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_VERIFY_FAILED, '产品全部修改失败!');
		}
	}

	/**
	 * DeleteProduct获取请求数据
	 */
	public function getDeleteProductRequestData($requestData){
		$requestData['SKU']	= $this->getProductSkuList($requestData['SKU'], false);
		$this->validBatchProcessLimit($requestData['SKU']);
		api_get_doc_list_by_doc_no($requestData, 'SKU', 'product_no,id');
		return $requestData;
	}

	/**
	 * DeleteProduct请求数据验证
	 */
	public function validDeleteProductRequestData(){
		if (empty($this->requestData['SKU']) || !is_array($this->requestData['SKU'])) {
			$error	= 'SKU不存在或格式错误!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}

	/**
	 * DeleteProduct请求处理数据
	 */
	public function DeleteProductAction(){
		$action		= 'delete';
		$DocList	= array();
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type			= API_ERRORTYPE_NOT_ERROR;
			$error_msg			= array();
			$real_error_msg		= array();
			$sku				= $DocInfo['product_no'];
			$product_id			= $DocInfo['id'];
			if ($product_id > 0) {
				$this->startTrans();
				try {
					$model	= D(API_MODULE_NAME);
					$model->setModuleInfo(API_MODULE_NAME, $action);
					$map	= array(
								'id'	=> $product_id,
							);
					$r	= $model->where($map)->setField('to_hide',2);
					if (false === $r) {
						$error	= array(
									api_line(__LINE__) . $sku . '删除失败:',
									$model->getError(),
									api_ob_get_clean(),
								);
						api_add_error($real_error_msg, $error);
						$error_type	= API_ERRORTYPE_OPERATION_FAILED;
						api_add_error($error_msg, $model->getError());
					} else {
						$product_ids[]	= $product_id;
					}
				} catch (Exception $ex) {
					$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
					$error		= api_set_abnormal_error(api_line(__LINE__) . $sku . '删除失败:', $ex);
					api_add_error($real_error_msg, $error);
				}
				$this->commitTrans($error_type);
			} else {
				$error	= $sku . '找不到产品!';
				$this->addRealErrorMsg(api_line(__LINE__) . $error);
				$this->addErrorMsg($error);
				$error_type	= API_ERRORTYPE_PARAMETERS_ERROR;
			}
			api_get_detail_error($DocInfo, $error_type, $error_msg, $real_error_msg, $this, 'product_no');
			$DocList[]				= $DocInfo;
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_xml_product_detail');
		if (empty($product_ids)){
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_VERIFY_FAILED, '产品全部删除失败!');
		}
	}

	/**
	 * AddShipping 请求数据验证
	 */
	public function getAddShippingRequestData($requestData){
		return $this->getDocList($requestData);
	}

	/**
	 * AddShipping 请求数据验证
	 */
	public function validAddShippingRequestData(){
		$DocDetails		= array();
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type		= API_ERRORTYPE_NOT_ERROR;
			$error_msg		= '';
			$real_error_msg	= array();
			$return_error	= array();
			try {
				api_valid_detail_box($DocInfo, $return_error);
				api_valid_detail_product($DocInfo['product'], $return_error);
				api_get_model_valid($DocInfo, $return_error);
				api_set_unique_data($DocInfo, $return_error, 'container_no,factory_id', 'container_no');
			} catch (Exception $ex) {
				$error		= api_set_abnormal_error(api_line(__LINE__) . '新增发货单数据出错:', $ex);
				api_add_error($real_error_msg, $error);
				$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
			}
			api_get_valid_detail_error($DocInfo, $error_type, $error_msg, $real_error_msg, $return_error);
			$DocDetails[]					= $DocInfo;
		}
		$this->requestData[API_DETAILS_KEY]	= $DocDetails;
	}

	/**
	 * AddShipping 请求获取数据
	 */
	public function AddShippingAction(){
		$DocList	= array();
		$doc_ids	= array();
		$action		= 'insert';
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$DocDetails	= array();
			$init_error	= api_get_detail_init_error($DocInfo);//初始化$error_type, $error_msg, $real_error_msg
			extract($init_error);
			if ($error_type == API_ERRORTYPE_NOT_ERROR) {
				$this->startTrans();
				try {
					try {
						$model					= D(API_MODULE_NAME);
						$model->setModuleInfo(API_MODULE_NAME, $action);
						$model->data($DocInfo);
						$_POST					= $model->data();
						$_POST['method_name']	= $action;
						$doc_id					= $model->importInsert();
					} catch (Exception $ex) {
						$error		= api_set_abnormal_error(api_line(__LINE__) . '保存发货单出错:', $ex);
						api_add_error($error_msg, $ex->getMessage());
						api_add_error($real_error_msg, $error);
						$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
					}
					if ($error_type == API_ERRORTYPE_NOT_ERROR) {
						if($doc_id > 0){
							$DocDetails['id']	= $doc_id;
							$doc_ids[]			= $doc_id;
						} else {
							$error				= array(
													api_line(__LINE__) . '新增发货单失败:',
													$model->getError(),
													api_ob_get_clean(),
												);
							api_add_error($real_error_msg, $error);
							$error_type	= API_ERRORTYPE_OPERATION_FAILED;
						}
					}
				} catch (Exception $ex) {
					$error		= api_set_abnormal_error(api_line(__LINE__) . '新增发货单失败:', $ex);
					api_add_error($real_error_msg, $error);
					$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
				}
				$this->commitTrans($error_type);
			}
			api_unset_unique_data($DocInfo, 'container_no');
			$DocDetails['container_no']		= $DocInfo['container_no'];
			api_get_detail_error($DocDetails, $error_type, $error_msg, $real_error_msg, $this, 'container_no');
			$DocList[]				= $DocDetails;
		}
		if (!empty($doc_ids)){
			try{
				$DocNoList	= M(API_MODULE_NAME)->where(array('id' => array('in', $doc_ids)))->getField('id, instock_no');
				foreach ($DocList as &$DocInfo) {
					$doc_id	= $DocInfo['id'];
					if(isset($DocNoList[$doc_id])){
						$DocInfo['instock_no']	= $DocNoList[$doc_id];
					}
				}
				$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_add_shipping');
				unset($DocNoList);
			} catch (Exception $ex) {
				$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_add_shipping');
				$error									= api_set_abnormal_error(api_line(__LINE__) . '获取新增发货单数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		} else {
			$this->responseData[API_DETAILS_KEY]		= api_make_doc_list($DocList, 'api_make_add_shipping');
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_VERIFY_FAILED, '发货单全部新增失败！');
		}
	}

	/**
	 * ModifyShipping 请求数据验证
	 */
	public function getModifyShippingRequestData($requestData){
		return $this->getDocList($requestData);
	}

	/**
	 * ModifyShipping 请求数据验证
	 */
	public function validModifyShippingRequestData(){
		$DocList	= array();
		$where		= array(
						'factory_id'	=> C('API_FACTORY_ID'),
					);
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type			= API_ERRORTYPE_NOT_ERROR;
			$error_msg			= '';
			$real_error_msg		= array();
			$return_error		= array();
			try {
				$where['instock_no']	= $DocInfo['instock_no'];
				$fields			= 'id, instock_type, factory_id, instock_no';
				$fields			.= api_get_not_exists_fields_string($DocInfo, C('API_INSTOCK_OPTIONAL_FIELDS'), true);
				$doc			= M(API_MODULE_NAME)->field($fields)->where($where)->find();
				if ($doc['id'] <= 0) {
					$real_error_msg[]		= '发货单不存在或不属于当前卖家!';
					$error_type				= API_ERRORTYPE_PARAMETERS_ERROR;
				} else {
					$DocInfo				= array_merge($DocInfo, $doc);
					api_valid_detail_box($DocInfo, $return_error);
					api_valid_detail_product($DocInfo['product'], $return_error);
					api_get_model_valid($DocInfo, $return_error);
				}
			} catch (Exception $ex) {
				$error			= api_set_abnormal_error(api_line(__LINE__) . '修改发货单数据出错:', $ex);
				api_add_error($real_error_msg, $error);
				$error_type		= API_ERRORTYPE_SYSTEM_ERROR;
			}
			api_get_valid_detail_error($DocInfo, $error_type, $error_msg, $real_error_msg, $return_error);
			$DocList[]			= $DocInfo;
		}
		$this->requestData[API_DETAILS_KEY]	= $DocList;
	}

	/**
	 * ModifyShipping 请求获取数据
	 */
	public function ModifyShippingAction(){
		$DocList	= array();
		$doc_ids	= array();
		$action		= 'update';
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$doc_id	= (int)$DocInfo['id'];
			$DocDetails	= array(
								'id'	=> $doc_id,
							);
			$init_error	= api_get_detail_init_error($DocInfo);//初始化$error_type, $error_msg, $real_error_msg
			extract($init_error);
			if ($error_type == API_ERRORTYPE_NOT_ERROR && $doc_id > 0) {
				$doc_ids[]		= $doc_id;
				$this->startTrans();
				try {
					try {
						$model					= D(API_MODULE_NAME);
						$model->setModuleInfo(API_MODULE_NAME, $action);
						$model->data($DocInfo);
						$_POST					= $model->data();
						$_POST['method_name']	= $action;
						$updateResult			= $model->importUpdate() === false ? false : $DocInfo['id'];
					} catch (Exception $ex) {
						$error_type		= API_ERRORTYPE_DATA_VERIFY_FAILED;
						$error_msg[]	= $ex->getMessage();
						$error			= api_set_abnormal_error(api_line(__LINE__) . '修改发货单数据出错:', $ex);
						api_add_error($real_error_msg, $error);
					}
					if ($error_type == API_ERRORTYPE_NOT_ERROR) {
						if ($updateResult === false) {
							$error_type		= API_ERRORTYPE_OPERATION_FAILED;
							$error	= array(
										api_line(__LINE__) . '修改发货单失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
						}
					}
				} catch (Exception $ex) {
					$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
					$error		= api_set_abnormal_error(api_line(__LINE__) . '修改发货单失败:', $ex);
					api_add_error($real_error_msg, $error);
				}
				$this->commitTrans($error_type);
			}
			$DocDetails['container_no']		= $DocInfo['container_no'];
			$DocDetails['instock_no']		= $DocInfo['instock_no'];
			api_get_detail_error($DocDetails, $error_type, $error_msg, $real_error_msg, $this, 'instock_no');
			$DocList[]						= $DocDetails;
		}
		$this->responseData[API_DETAILS_KEY]= api_make_doc_list($DocList, 'api_make_add_shipping');
		if (empty($doc_ids)){
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_VERIFY_FAILED, '发货单全部修改失败！');
		}
	}

	/**
	 * AddShipping请求数据验证
	 */
	public function getAddReturnOrderRequestData($requestData){
		return api_return_sale_order_fill_related_sale_order_info($this->getDocList($requestData));
	}

	/**
	 * AddReturnOrder 请求数据验证
	 */
	public function validAddReturnOrderRequestData(){
		$DocDetails		= array();
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type		= API_ERRORTYPE_NOT_ERROR;
			$error_msg		= '';
			$real_error_msg	= array();
			$return_error	= array();
			try {
				api_valid_detail_product($DocInfo['detail'], $return_error);
				if ($DocInfo['is_related_sale_order'] == C('IS_RELATED_SALE_ORDER')){//关联处理单号
					if ($DocInfo['sale_order_id'] <= 0) {
						$return_error['sale_order_id']	= L('deal_no') . '[' . $DocInfo['sale_order_no'] . ']: 不存在!';
					}
				} elseif (!empty($DocInfo['addition']['comp_name'])) {//不关联处理单号买家名称不为空
					//买家信息验证
					$DocInfo['addition']['module_name']	= 'Client';
					api_get_model_valid($DocInfo['addition'], $return_error);
				}
				api_valid_return_service($DocInfo, $return_error);
				api_get_model_valid($DocInfo, $return_error);
				api_set_unique_data($DocInfo, $return_error, 'return_logistics_no', 'return_logistics_no');
			} catch (Exception $ex) {
				$error	= api_set_abnormal_error(api_line(__LINE__) . '新增退货单数据出错:', $ex);
				api_add_error($real_error_msg, $error);
				$error_type		= API_ERRORTYPE_SYSTEM_ERROR;
			}
			api_get_valid_detail_error($DocInfo, $error_type, $error_msg, $real_error_msg, $return_error);
			$DocDetails[]					= $DocInfo;
		}
		$this->requestData[API_DETAILS_KEY]	= $DocDetails;
	}

	/**
	 * AddReturnOrder 请求获取数据
	 */
	public function AddReturnOrderAction(){
		$DocList	= array();
		$doc_ids	= array();
		$action		= 'insert';
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$DocDetails	= array();
			$init_error		= api_get_detail_init_error($DocInfo);//初始化$error_type, $error_msg, $real_error_msg
			extract($init_error);
			if ($error_type == API_ERRORTYPE_NOT_ERROR) {
				$this->startTrans();
				try {
					if ($DocInfo['is_related_sale_order'] != C('IS_RELATED_SALE_ORDER') && !empty($DocInfo['addition']['comp_name'])) {//不关联处理单号且买家名称不为空
						$addition				= $DocInfo['addition'];
						try {
							$addition['comp_no']	= getModuleMaxNo('Client');
						} catch (Exception $ex) {
							$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
							$error		= api_set_abnormal_error(api_line(__LINE__) . '生成买家编号出错:', $ex);
							api_add_error($real_error_msg, $error);
						}
						if ($error_type == API_ERRORTYPE_NOT_ERROR) {
							if ($DocInfo['is_related_sale_order'] != C('IS_RELATED_SALE_ORDER')) {
								try {
									$Client					= D('Client');
									$DocInfo['client_id'] = $Client->add($addition);
								} catch (Exception $ex) {
									$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
									$error		= api_set_abnormal_error(api_line(__LINE__) . '创建买家出错:', $ex);
									api_add_error($real_error_msg, $error);
								}
							}
						}
					}
					if ($error_type == API_ERRORTYPE_NOT_ERROR) {
						try {
							$model					= D(API_MODULE_NAME);
							$model->setModuleInfo(API_MODULE_NAME, $action);
							$model->data($DocInfo);
							$_POST					= $model->data();
							$_POST['method_name']	= $action;
							$doc_id					= $model->importInsert();
						} catch (Exception $ex) {
							$error		= api_set_abnormal_error(api_line(__LINE__) . '保存退货单出错:', $ex);
							api_add_error($error_msg, $ex->getMessage());
							api_add_error($real_error_msg, $error);
							$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
						}
						if ($error_type == API_ERRORTYPE_NOT_ERROR) {
							if($doc_id > 0){
								$DocDetails['id']	= $doc_id;
								$doc_ids[]			= $doc_id;
							} else {
								$error		= array(
												api_line(__LINE__) . '新增退货单失败:',
												$model->getError(),
												api_ob_get_clean(),
											);
								api_add_error($real_error_msg, $error);
								$error_type	= API_ERRORTYPE_OPERATION_FAILED;
							}
						}
					}
				} catch (Exception $ex) {
					$error		= api_set_abnormal_error(api_line(__LINE__) . '新增退货单失败:', $ex);
					api_add_error($real_error_msg, $error);
					$error_type	= API_ERRORTYPE_SYSTEM_ERROR;
				}
				$this->commitTrans($error_type);
			}
			api_unset_unique_data($DocInfo, 'return_logistics_no');
			$DocDetails['order_no']	= $DocInfo['order_no'];
			api_get_detail_error($DocDetails, $error_type, $error_msg, $real_error_msg, $this, 'order_no');
			$DocList[]				= $DocDetails;
		}
		if (!empty($doc_ids)){
			try{
				$DocNoList	= M(API_MODULE_NAME)->where(array('id' => array('in', $doc_ids)))->getField('id, return_sale_order_no, return_order_no');
				foreach ($DocList as &$DocInfo) {
					$doc_id	= $DocInfo['id'];
					if(isset($DocNoList[$doc_id])){
						$DocInfo	= array_merge($DocInfo, $DocNoList[$doc_id]);
					}
				}
				$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_add_return_order');
			} catch (Exception $ex) {
				$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_add_return_order');
				$error									= api_set_abnormal_error(api_line(__LINE__) . '获取新增退货单数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		} else {
			$this->responseData[API_DETAILS_KEY]		= api_make_doc_list($DocList, 'api_make_add_return_order');
			$this->setErrorTypeAndExit(API_ERRORTYPE_DATA_VERIFY_FAILED, '退货单全部新增失败！');
		}
	}

	/**
	 * DeleteReturnOrder获取请求数据
	 */
	public function getDeleteReturnOrderRequestData($requestData){
		$requestData['ReturnProcessNo']	= $this->getProcessNoList($requestData['ReturnProcessNo'], 'api_valid_return_process_no', false);
		$this->validBatchProcessLimit($requestData['ReturnProcessNo']);
		api_get_doc_list_by_doc_no($requestData, 'ReturnProcessNo', 'return_order_no,id');
		return $requestData;
	}

	/**
	 * DeleteReturnOrder请求数据验证
	 */
	public function validDeleteReturnOrderRequestData(){
		if (empty($this->requestData['ReturnProcessNo']) || !is_array($this->requestData['ReturnProcessNo'])) {
			$error	= '处理单号不存在或格式错误!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}

	/**
	 * DeleteReturnOrder请求获取数据
	 */
	public function DeleteReturnOrderAction(){
		$action			= 'delete';
		$DocList		= array();
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type		= API_ERRORTYPE_NOT_ERROR;
			$error_msg		= array();
			$real_error_msg	= array();
			$DocDetails		= array();
			$processNo		= $DocInfo['return_order_no'];
			$doc_id			= $DocInfo['id'];
			if ($doc_id > 0) {
				$this->startTrans();
				$model	= D(API_MODULE_NAME);
				$model->setModuleInfo(API_MODULE_NAME, $action);
				try {
					$_POST		= array(
									'id'			=> $doc_id,
									'method_name'	=> API_MODULE_NAME,
									'_module'		=> API_MODULE_NAME,
									'_action'		=> $action,
								);
					//业务规则验证
					api_brf($action, $_POST);
					//前置业务规则处理
					$model->_brf();
					if ($model->_beforeModel($_POST)) {
						$r	= $model->relation(true)->delete($doc_id);
						if (false === $r) {
							$error	= array(
										api_line(__LINE__) . $processNo . '删除失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
							api_add_error($error_msg, $model->getError());
							$error_type	= API_ERRORTYPE_OPERATION_FAILED;
						} else {
							unset($_POST['method_name']);
							try{
								$model->_afterModel($_POST, $action);
								$model->execTags($_POST);
							} catch (Exception $ex) {
								$error	= api_set_abnormal_error(api_line(__LINE__) . '删除退货单后续行为处理出错: ', $ex);
								api_add_error($real_error_msg, $error);
								api_add_error($error_msg, $ex->getMessage());
								$error_type		= API_ERRORTYPE_DATA_VERIFY_FAILED;
							}
						}
					} else {
							$error	= array(
										api_line(__LINE__) . $processNo . '删除失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
							api_add_error($error_msg, $model->getError());
							$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
					}
				} catch (Exception $ex) {
					$error		= api_set_abnormal_error(api_line(__LINE__) . $processNo . '删除失败:', $ex);
					api_add_error($real_error_msg, $error);
					api_add_error($error_msg, $ex->getMessage());
					$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
				}
				$this->commitTrans($error_type);
			} else {
				$error		= $processNo . '找不到退货单!';
				api_add_error($real_error_msg, api_line(__LINE__) . $error);
				api_add_error($error_msg, $error);
				$error_type	= API_ERRORTYPE_PARAMETERS_ERROR;
			}
			$DocDetails['return_order_no']	= $processNo;
			api_get_detail_error($DocDetails, $error_type, $error_msg, $real_error_msg, $this, 'return_order_no');
			$DocList[]						= $DocDetails;
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_delete_return_order');
	}

	public function getGetReturnOrderListRequestData($requestData){
		//单号处理
		if (isset($requestData['ReturnProcessNoArray']) && is_array($requestData['ReturnProcessNoArray'])) {
			$requestData['ReturnProcessNo']	= $this->getProcessNoList($requestData['ReturnProcessNoArray']['ReturnProcessNo'], 'api_valid_return_process_no');
		}
		//日期处理
		$date_fields	= array('ReturnOrderDate', 'UpdateTime');
		foreach ($date_fields as $field) {
			if (!empty($requestData[$field])) {
				$requestData[$field]	= $this->getSearchDate($requestData[$field], in_array($field, array('UpdateTime')) ? true : false);
			}
		}
		return $requestData;
	}

	/**
	 *  GetReturnOrderList 请求数据验证
	 */
	public function validGetReturnOrderListRequestData(){
		$requestData	= $this->requestData;
		if(empty($requestData['ReturnProcessNo']) && empty($requestData['ReturnOrderDate']) && empty($requestData['UpdateTime'])){
			$error	= '查询条件不能为空!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}

	/**
	 * GetReturnOrderList 请求获取数据
	 */
	public function GetReturnOrderListAction(){
		$where		= api_get_return_order_list_where($this->requestData);
		$model		= D(API_MODULE_NAME);
		$doc_ids	= $model->where($where)->order('return_order_no desc')->getField('id', true);
		$count		= count($doc_ids);
		$DocList	= array();
		if ($count > 0) {
			try {
				$doc_ids	= $this->setPage($doc_ids);
				$function	= 'api' . API_NAME;
				$DocList	= $model->$function($doc_ids);
			} catch (Exception $ex) {
				$error		= api_set_abnormal_error(api_line(__LINE__) . '获取退货单列表数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_xml_return_order_details');
	}

	/**
	 * GetShippingMethodsList 请求数据验证
	 */
	public function validGetShippingMethodsListRequestData(){
		if (api_valid_warehouse_no($this->requestData['WarehouseNo']) === false) {
			$error	= '仓库编号格式错误!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}

	/**
	 * GetShippingMethodsList 请求获取数据
	 */
	public function GetShippingMethodsListAction(){
		$where		= array(
						'w.w_no'	=> $this->requestData['WarehouseNo'],
					);
		$model		= D(API_MODULE_NAME);
		$doc_ids	= $model->alias('s')->join('inner join __WAREHOUSE__ w on w.id=s.warehouse_id')->where($where)->getField('s.id', true);
		$count		= count($doc_ids);
		$DocList	= array();
		if ($count > 0) {
			try {
				$doc_ids	= $this->setPage($doc_ids);
				$DocList	= $model->alias('s')->join('inner join __WAREHOUSE__ w on w.id=s.warehouse_id')->where(array('s.id' => array('in', $doc_ids)))->getField('s.express_name', true);
			} catch (Exception $ex) {
				$error		= api_set_abnormal_error(api_line(__LINE__) . '获取派送方式列表数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		}
		$this->responseData[API_DETAILS_KEY]	= $DocList;
	}
	
	    /**
     *  DeleteShipping获取请求数据
	 */
	public function getDeleteShippingRequestData($requestData){
		$requestData['InstockNo']	= $this->getProcessNoList($requestData['InstockNo'], 'api_valid_instock_no', false);
		$this->validBatchProcessLimit($requestData['InstockNo']);
		api_get_doc_list_by_doc_no($requestData, 'InstockNo', 'instock_no,id');
		return $requestData;
	}

	/**
	 * DeleteReturnOrder请求数据验证
	 */
	public function validDeleteShippingRequestData(){
		if (empty($this->requestData['InstockNo']) || !is_array($this->requestData['InstockNo'])) {
			$error	= '发货单号不存在或格式错误!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}

	/**
	 * DeleteReturnOrder请求获取数据
	 */
	public function DeleteShippingAction(){
		$action			= 'delete';
		$DocList		= array();
		foreach ($this->requestData[API_DETAILS_KEY] as $DocInfo) {
			$error_type		= API_ERRORTYPE_NOT_ERROR;
			$error_msg		= array();
			$real_error_msg	= array();
			$DocDetails		= array();
			$processNo		= $DocInfo['instock_no'];
			$doc_id			= $DocInfo['id'];
			if ($doc_id > 0) {
				$this->startTrans();
				$model	= D(API_MODULE_NAME);
				$model->setModuleInfo(API_MODULE_NAME, $action);
				try {
					$_POST		= array(
									'id'			=> $doc_id,
									'method_name'	=> API_MODULE_NAME,
									'_module'		=> API_MODULE_NAME,
									'_action'		=> $action,
								);
                    //业务规则验证
                    api_brf($action, $_POST);
                    //前置业务规则处理
					$model->_brf();
                    
					if ($model->_beforeModel($_POST)) {
						$r	= $model->relation(true)->delete($doc_id);
						if (false === $r) {
							$error	= array(
										api_line(__LINE__) . $processNo . '删除失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
							api_add_error($error_msg, $model->getError());
							$error_type	= API_ERRORTYPE_OPERATION_FAILED;
						} else {
							unset($_POST['method_name']);
							try{
								$model->_afterModel($_POST, $action);
								$model->execTags($_POST);
							} catch (Exception $ex) {
								$error	= api_set_abnormal_error(api_line(__LINE__) . '删除发货单后续行为处理出错: ', $ex);
								api_add_error($real_error_msg, $error);
								api_add_error($error_msg, $ex->getMessage());
								$error_type		= API_ERRORTYPE_DATA_VERIFY_FAILED;
							}
						}
					} else {
							$error	= array(
										api_line(__LINE__) . $processNo . '删除失败:',
										$model->getError(),
										api_ob_get_clean(),
									);
							api_add_error($real_error_msg, $error);
							api_add_error($error_msg, $model->getError());
							$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
					}
				} catch (Exception $ex) {
					$error		= api_set_abnormal_error(api_line(__LINE__) . $processNo . '删除失败:', $ex);
					api_add_error($real_error_msg, $error);
					api_add_error($error_msg, $ex->getMessage());
					$error_type	= API_ERRORTYPE_DATA_VERIFY_FAILED;
				}
				$this->commitTrans($error_type);
			} else {
				$error		= $processNo . '找不到发货单!';
				api_add_error($real_error_msg, api_line(__LINE__) . $error);
				api_add_error($error_msg, $error);
				$error_type	= API_ERRORTYPE_PARAMETERS_ERROR;
			}
			$DocDetails['instock_no']	= $processNo;
			api_get_detail_error($DocDetails, $error_type, $error_msg, $real_error_msg, $this, 'instock_no');
			$DocList[]						= $DocDetails;
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_delete_instock');
	}
    
    public function getGetShippingListRequestData($requestData){
//		单号处理
		if (isset($requestData['InstockNoArray']) && is_array($requestData['InstockNoArray'])) {
			$requestData['InstockNo']	= $this->getProcessNoList($requestData['InstockNoArray']['InstockNo'], 'api_valid_instock_no');
		}
//		日期处理
		$date_fields	= array('InstockDate');
		foreach ($date_fields as $field) {
			if (!empty($requestData[$field])) {
				$requestData[$field]	= $this->getSearchDate($requestData[$field]);
			}
		}
		return $requestData;
	}

	/**
	 * GetShippingList 请求数据验证
	 */
	public function validGetShippingListRequestData(){
		$requestData	= $this->requestData;
		if(empty($requestData['InstockNo']) && empty($requestData['InstockDate'])){
			$error	= '查询条件不能为空!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}

	/**
	 * GetShippingList 请求获取数据
	 */
	public function GetShippingListAction(){
		$where		= api_get_instock_list_where($this->requestData);
		$model		= D(API_MODULE_NAME);
		$doc_ids	= $model->where($where)->order('instock_no desc')->getField('id', true);
		$count		= count($doc_ids);
		$DocList	= array();
		if ($count > 0) {
			try {
				$doc_ids	= $this->setPage($doc_ids);
				$function	= 'api' . API_NAME;
				$DocList	= $model->$function($doc_ids);
			} catch (Exception $ex) {
				$error		= api_set_abnormal_error(api_line(__LINE__) . '获取发货单列表数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_xml_instock_details');
	}
    
    /**
     * GetStockInList 发货入库列表
     */
    public function getGetStockInListRequestData($requestData){
//		单号处理
		if (isset($requestData['InstockNoArray']) && is_array($requestData['InstockNoArray'])) {
			$requestData['InstockNo']	= $this->getProcessNoList($requestData['InstockNoArray']['InstockNo'], 'api_valid_instock_no');
		}
//		日期处理
		$date_fields	= array('UpdateTime');
		foreach ($date_fields as $field) {
			if (!empty($requestData[$field])) {
				$is_time				= in_array($field, array('UpdateTime')) ? true : false;
				$requestData[$field]	= $this->getSearchDate($requestData[$field], $is_time);
			}
		}
		return $requestData;
	}

	/**
	 * GetStockInList 请求数据验证
	 */
	public function validGetStockInListRequestData(){
		$requestData	= $this->requestData;
		if(empty($requestData['InstockNo']) && empty($requestData['UpdateTime'])){
			$error	= '查询条件不能为空!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(API_ERRORTYPE_PARAMETERS_ERROR, api_line(__LINE__) . $error);
		}
	}

	/**
	 * GetStockInList 请求获取数据
	 */
	public function GetStockInListAction(){
		$where		= api_get_stock_in_list_where($this->requestData);
		$model		= D(API_MODULE_NAME);
        
        //非接收的查询条件
        $where['d.in_quantity']   = array('gt',0);
        
        $doc_ids    = M('instock')->join('i left join __INSTOCK_DETAIL__ d on i.id=d.instock_id')->where($where)->group('i.id')->order('i.instock_no desc')->field('i.id as id')->getField('id', true);

        $count		= count($doc_ids);
		$DocList	= array();
		if ($count > 0) {
			try {
				$doc_ids	= $this->setPage($doc_ids);
				$function	= 'api' . API_NAME;
				$DocList	= $model->$function($doc_ids);
			} catch (Exception $ex) {
				$error		= api_set_abnormal_error(api_line(__LINE__) . '获取发货入库列表数据出错:', $ex);
				$this->setErrorTypeAndExit(API_ERRORTYPE_SYSTEM_ERROR, $error);
			}
		}
		$this->responseData[API_DETAILS_KEY]	= api_make_doc_list($DocList, 'api_make_xml_stock_in_details');
	}
	
	/*********************************接口实现方法 ed****************************************/
}
