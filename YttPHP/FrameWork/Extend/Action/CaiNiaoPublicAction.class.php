<?php
/**
 * CaiNiaoPublicAction
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	公共CaiNiao类
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-10-08
 */
class CaiNiaoPublicAction {
	private $_trans								= false;	//事务开启标志
	protected $reason							= '';		//错误编码
	protected $error_msg						= array();	//自定义错误信息
	protected $real_error_msg					= array();	//自定义错误信息

	private $request_time						= '';		//请求时间
	private $request_id							= null;		//请求id(请求日志id)
	private $log_detail_id						= null;		//请求日志明细id
	private $request_ip							= '';		//请求ip
	private $docDetails							= array();	//请求数据
	private $unique_field						= '';

	private $logistics_interface				= '';		//消息内容
	private $logistic_provider_id				= '';		//CP编号CPCode（菜鸟会提供）
	private $msg_type							= '';		//消息类型
	private $data_digest						= '';		//消息正文的摘要（签名） base64_encode(md5(logistics_interface+秘钥))
	private $local_data_digest					= '';		//本地消息正文的摘要（签名） base64_encode(md5(logistics_interface+秘钥))
	private $msg_id								= '';		//消息ID

	private $eventType							= '';		//事件类型
	private $eventTime							= '';		//报文发送时间
	private $eventSource						= '';		//事件发起方
	private $eventTarget						= '';		//事件接收方

	private $logisticsOrderCode					= '';		//退货物流单号，简称LP号

	private $response_time						= '';		//返回时间
	private $responseXml						= '';		//返回xml
	private $responseXmlFp						= '';		//返回xml保存文件句柄

    public function __construct() {
		$this->validRequestType();
		$this->_initialize();		//初始化
		$this->saveCaiNiaoLog();	//记录日志
		$this->parseRequestXml();	//获取数据
		$this->validRequestData();	//数据验证
	}

	public function validRequestType() {
		if (IS_POST !== true) {
			exit();
		}
	}

	/**
	 * 获取请求数据
	 */
	public function parseRequestData(){
		$this->logistics_interface  = str_replace('&', '&amp;', htmlspecialchars_decode(MAGIC_QUOTES_GPC ? $_POST['logistics_interface'] : stripslashes($_POST['logistics_interface']) ));
		$this->logistic_provider_id	= $_POST['logistic_provider_id'];
		$this->msg_type				= $_POST['msg_type'];
		$this->data_digest			= $_POST['data_digest'];
		$this->msg_id				= $_POST['msg_id'];
	}

	/**
	 * 初始化
	 */
	public function _initialize(){
		cainiao_load_file();
		cainiao_set_debug();
		$this->request_time			= date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);			//请求时间
		$this->request_ip			= get_client_ip();
		$this->parseRequestData();
		define('CAINIAO_MSG_TYPE', $this->msg_type);											//消息类型
		C('CAINIAO_ACTION_INFO', C('CAINIAO_MSG_TYPE_LIST.'.CAINIAO_MSG_TYPE));
		define('CAINIAO_API_NAME', C('CAINIAO_ACTION_INFO.API_NAME'));							//API名称
		define('CAINIAO_MODULE_NAME', C('CAINIAO_ACTION_INFO.MODULE'));							//请求模块
		define('CAINIAO_ACTION_NAME', C('CAINIAO_ACTION_INFO.ACTION'));							//请求方法
		define('CAINIAO_PARSE_MODULE_NAME', parse_name(CAINIAO_MODULE_NAME));					//请求模块
		define('CAINIAO_PARSE_API_NAME', parse_name(CAINIAO_API_NAME));							//API名称
		define('IS_4PX', C('CAINIAO_ACTION_INFO.4PX') === true ? true : false);					//是否为4px单据
		define('CAINIAO_DETAILS_KEY', C('CAINIAO_MODULE_DETAILS_KEY.'.CAINIAO_MODULE_NAME));	//请求模块明细下标
		addLang(array(MODULE_NAME, CAINIAO_MODULE_NAME));
		/// 判断操作是否需要开启事务
		if (preg_match('/^(Add|Delete|Modify|Confirm)[A-Z]/', CAINIAO_API_NAME) || in_array(CAINIAO_API_NAME, C('CAINIAO_TRANS_ACTION'))) {
			$this->_trans = true;
		}
	}
	
	/**
	 * 接口验证/调用
	 * @param string $method
	 * @param array $parameter
	 */
	public function __call($method, $parameter) {
		$method	= CAINIAO_API_NAME . 'Action';
		if (method_exists($this, $method)) {
			try {
				call_user_func_array(array(&$this, $method), (array)$parameter);
			} catch (Exception $ex) {
				$error	= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '执行请求出错: ', $ex);
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_SYSTEM_ABNORMAL, $error);
			}
		} else {//接口不存在
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_REQUEST_PARAMETERS, cainiao_line(__LINE__) . $method . '不存在!');
		}
	}
	
	/**
	 * 获取请求数据
	 */
	public function parseRequestXml(){
		if (empty($this->logistics_interface)) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_RETURN_CONTENT_EMPTY, cainiao_line(__LINE__) . '报文xml为空!');
		}
		try {
			import('ORG.Util.XML2Array');			
			$xmlData	= XML2Array::createArray($this->logistics_interface);
			$key		= 'request';
			$event_key	= IS_4PX === true ? 'event' : 'logisticsEvent';
			if (!isset($xmlData[$key]) || !is_array($xmlData[$key])) {
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_NOTIFICATION_CONTENT, cainiao_line(__LINE__) . $key . ': 不存在或不是数组!');
			}
			if (!isset($xmlData[$key][$event_key]) || !is_array($xmlData[$key][$event_key])) {
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_NOTIFICATION_CONTENT, cainiao_line(__LINE__) . $event_key . ': 不存在或不是数组!');
			}
			$event		= $xmlData[$key][$event_key];
			unset($xmlData);
			$this->getEventHeaderInfo($event['eventHeader']);
			try {
				$this->docDetails	= $this->getRequestData($event['eventBody']);
			} catch (Exception $ex) {
				//获取数据出错
				$error	= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '获取数据出错: ', $ex);
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
			}
			unset($event);
		} catch (Exception $ex) {
			//xml解析异常
			$error	= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '解析xml出错: ', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_XML_OR_JSON, $error);
		}
	}

	/**
	 * 获取报文头部信息
	 * @param type $eventHeader
	 */
	private function getEventHeaderInfo($eventHeader){
		if (empty($eventHeader) || !is_array($eventHeader)) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_XML_OR_JSON, cainiao_line(__LINE__) . 'eventHeader: 不存在或不是数组!');
		}
		$this->eventType	= $eventHeader['eventType'];	//事件类型
		$this->eventTime	= $eventHeader['eventTime'];	//报文发送时间
		$this->eventSource	= $eventHeader['eventSource'];	//事件发起方
		$this->eventTarget	= $eventHeader['eventTarget'];	//事件接收方
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
	 * @param int $reason
	 */
	private function commitTrans($reason = null){
		if ($this->_trans == true) {
			if (is_null($reason)) {
				$reason	= $this->reason;
			}
			if (cainiao_has_error($reason)) {
				rollback();	//回滚事务
			} else {
				commit();	//提交事务
			}
		}
	}
	
	/**
	 * 获取请求数据数组
	 * @param array $eventBody
	 */
	private function getRequestData($eventBody) {
		if (empty($eventBody) || !is_array($eventBody)) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_XML_OR_JSON, cainiao_line(__LINE__) . 'eventBody: 不存在或不是数组!');
		}
		switch (CAINIAO_MODULE_NAME) {
			case 'Product':
				$logisticsOrderCode_key			= 'skuCode';
				$docDetails						= $eventBody;
				break;
			case 'Instock':
				$logisticsOrderCode_key			= 'receiveOderCode';
				$docDetails						= $eventBody;
				break;
			case 'ReturnSaleOrder':
				$logisticsOrderCode_key			= 'logisticsOrderCode';
				if (empty($eventBody['logisticsDetails'][CAINIAO_DETAILS_KEY]) || !is_array($eventBody['logisticsDetails'][CAINIAO_DETAILS_KEY])) {
					$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, cainiao_line(__LINE__) . '' . CAINIAO_DETAILS_KEY . ': 不存在或不是数组!');
				}
				$docDetails						= $eventBody['logisticsDetails'][CAINIAO_DETAILS_KEY];
				break;
		}
		if(IS_4PX === true) {
			$this->setAuthToken($docDetails);//授权码
			cainiao_set_factory_id();
		}
		if (!array_key_exists($logisticsOrderCode_key, $docDetails)) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_REQUEST_PARAMETERS, cainiao_line(__LINE__) . $logisticsOrderCode_key . ':不存在!');
		} elseif (empty($docDetails[$logisticsOrderCode_key])) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, cainiao_line(__LINE__) . $logisticsOrderCode_key . ':不应为空!');
		}
		$this->logisticsOrderCode				= $docDetails[$logisticsOrderCode_key];
		$docDetails								= cainiao_get_doc($docDetails);
		return $docDetails;
	}


	/**
	 * 获取authToken
	 * @param array $docDetails
	 * @return string
	 */
	private function setAuthToken($docDetails){
		$authToken	= trim($docDetails['cust_sign']);
		$this->validAuthToken($authToken);
		C('CAINIAO_AUTH_TOKEN', $authToken);
	}
	
	/**
	 * 更新日志并返回信息
	 */
	public function __destruct() {
		$this->validRequestType();
		$this->response_time		= date('Y-m-d H:i:s');	//返回时间
		//接收并清除可能的输出字符串
		$this->addRealErrorMsg(cainiao_ob_get_clean());
		$this->real_error_msg	= cainiao_err_string($this->real_error_msg) . C('REQUEST_REAL_ERROR_MSG');
		$this->getResponseXml();
		$this->updateCaiNiaoLog();						//更新记录日志
		$this->response();							//返回xml
	}
	
	/**
	 * 记录日志
	 */
	private function saveCaiNiaoLog(){
		//保存请求日志
		$cainiao_log			= array(
									'module'				=> CAINIAO_MODULE_NAME,						//请求模块
									'action'				=> CAINIAO_API_NAME,						//请求方法
									'factory_id'			=> C('CAINIAO_FACTORY_ID'),					//卖家id
									'request_ip'			=> $this->request_ip,						//请求ip
									'request_status'		=> CAINIAO_REQUEST_STATUS_SUCCESS,
									'logistic_provider_id'	=> $this->logistic_provider_id,				//消息内容，下发的所有报文内容都在此。
									'data_digest'			=> $this->data_digest,						//消息签名
									'msg_type'				=> $this->msg_type,							//消息类型
									'msg_id'				=> $this->msg_id,							//消息ID
								);
		$this->request_id		= M('CaiNiaoLog')->add($cainiao_log);
		//保存请求日志
		$cainiao_log_detail		= array(
									'cai_niao_log_id'		=> $this->request_id,
									'request_time'			=> $this->request_time,						//请求时间
								);
		$this->log_detail_id	= M('CaiNiaoLogDetail')->add($cainiao_log_detail);
		cainiao_save_xml($this->request_id, $this->logistics_interface, $this->request_time, CAINIAO_MSG_TYPE);//保存请求xml
		$this->responseXmlFp	= @fopen(cainiao_get_xml_file_name($this->request_id, $this->request_time, CAINIAO_MSG_TYPE, false), 'x+');//打开保存返回xml文件句柄(在析构函数中没有文件打开权限)
	}

	/**
	 * 记录日志
	 */
	private function updateCaiNiaoLog(){
		//保存请求日志
		$cainiao_log			= array(
									'id'					=> $this->request_id,
									'local_data_digest'		=> $this->local_data_digest,					//本地消息签名
									'eventType'				=> $this->eventType,							//事件类型
									'eventTime'				=> $this->eventTime,							//事件发送时间
									'eventSource'			=> $this->eventSource,							//事件发起方
									'eventTarget'			=> $this->eventTarget,							//事件接收方
									'logisticsOrderCode'	=> $this->logisticsOrderCode,					//退货物流单号 ，简称LP号
								);
		M('CaiNiaoLog')->save($cainiao_log);
		//保存请求日志
		$cainiao_log_detail		= array(
									'id'					=> $this->log_detail_id,
									'success'				=> !cainiao_has_error($this->reason) ? 'true' : 'false',	//
									'reason'				=> $this->reason,
									'desc'					=> cainiao_err_string($this->error_msg),
									'response_time'			=> $this->response_time,							//返回时间
									'errorInfo'				=> cainiao_err_string($this->real_error_msg),	//详细错误信息
								);
		M('CaiNiaoLogDetail')->save($cainiao_log_detail);
	}

	/**
	 * 返回数据
	 */
	private function response(){
		echo $this->responseXml;
	}

	/**
	 * 获取返回xml data
	 */
	private function getResponseXmlData($save = false){
		$desc			= (C('CAINIAO_DEBUG') === 1 || $save === true) && !empty($this->real_error_msg) ? cainiao_err_string($this->real_error_msg) : $this->getError();
		$respnseXmlData	= cainiao_make_response_xml($this->request_id, $this->reason, $desc);
		return $respnseXmlData;
	}

	/**
	 * 获取返回xml
	 */
	private function getResponseXml(){
		$respnseXmlData		= $this->getResponseXmlData();
		import('ORG.Util.Array2XML');
		try {
			$xml				= Array2XML::createXML('response', $respnseXmlData);
			$this->responseXml	= $xml->saveXML();
		} catch (Exception $ex) {
			$error				= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '返回数据xml构造失败!', $ex);
			$this->addRealErrorMsg($error);
			$this->responseXml	= xml_encode($respnseXmlData, 'utf-8', 'response');
		}
		$this->saveResponseXml();
	}

	/**
	 * 保存返回xml文件
	 */
	private function saveResponseXml(){
		if ($this->responseXmlFp) {
			$root				= 'response';
			if (C('CAINIAO_DEBUG') === 1){
				$responseXml		= $this->responseXml;
			} else {
				$respnseXmlData		= $this->getResponseXmlData(true);
				import('ORG.Util.Array2XML');
				try {
					$xml			= Array2XML::createXML($root, $respnseXmlData);
					$responseXml	= $xml->saveXML();
				} catch (Exception $ex) {
					$error			= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '返回数据xml构造失败!', $ex);
					$this->addRealErrorMsg($error);
					$responseXml	= xml_encode($respnseXmlData, 'utf-8', $root);
				}
			}
			if (empty($responseXml)) {
				$respnseXmlData	= array(
									$root	=> $respnseXmlData,
								);
				$returnXml		= var_export($respnseXmlData, true);
			} else {
				$returnXml		= $responseXml;
			}
			@fwrite($this->responseXmlFp, $returnXml);
			@fclose($this->responseXmlFp);
		}
	}

	/*********************************接口基本验证方法 st****************************************/

	/**
	 * 验证AuthToken
	 */
	private function validAuthToken($authToken){
		if (cainiao_valid_auth_token($authToken) === false){
			$error	= 'cust_sign为空或格式错误!';
			$this->addErrorMsg($error);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, cainiao_line(__LINE__) . $error);
		}
	}
	
	/**
	 * 验证卖家
	 * @param int $factory_id
	 */
	private function validFactory(){
		$result	= cainiao_valid_factory();
		if ($result <= 0) {
			switch ($result) {
				case -3:
					$real_msg	= 'ip(' . $this->request_ip . ')受限!';
					break;
				case -2:
					$real_msg	= '卖家账号信息不存在!';
					break;
				case -1:
					$real_msg	= '授权码找不到卖家!';
					break;
			}
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, cainiao_line(__LINE__) . $real_msg);
		}
	}

	/**
	 * 请求数据验证
	 */
	private function validRequestData(){
		//验证消息类型
		$this->validMsgType();
		//验证签名
		$this->validDataDigest();
		//验证卖家
		$this->validFactory();
		//接口验证
		$validMethod	= 'valid' . CAINIAO_API_NAME . 'RequestData';
		if (method_exists($this, $validMethod)) {
			$this->$validMethod();
		}
	}

	/**
	 * 验证消息类型
	 */
	private function validMsgType(){
		$action_info	= C('CAINIAO_ACTION_INFO');
		if (empty($action_info)) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_NOTIFICATION_TYPE, cainiao_line(__LINE__) . '消息类型不存在!');
		}
		if ($this->msg_type != $this->eventType) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_NOTIFICATION_CONTENT, cainiao_line(__LINE__) . '消息类型与报文中的事件类型不一致!');
		}
	}

	/**
	 * 验证签名
	 */
	private function validDataDigest(){
		$this->local_data_digest	= cainiao_get_data_digest($this->logistics_interface);
		if ($this->data_digest != $this->local_data_digest) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_DIGITAL_SIGNATURE, cainiao_line(__LINE__) . '消息签名错误![data_digest: ' . $this->data_digest . '; local_data_digest: ' . $this->local_data_digest . ']');
		}
	}

	/*********************************接口基本验证方法 ed****************************************/

	/*********************************接口错误处理方法 st****************************************/
	
    /**
	 * @param mixed $error
	 */
    public function addRealErrorMsg($error){
		cainiao_add_error($this->real_error_msg, $error);
    }

    /**
	 * @param mixed $error
	 */
    public function addErrorMsg($error){
		cainiao_add_error($this->error_msg, $error);
    }

	/**
	 * 设置错误类型并exit
	 * @param int $reason
	 */
	private function setErrorTypeAndExit($reason, $error){
		$this->addRealErrorMsg($error);
		$this->reason	= $reason;
		if (cainiao_has_error($this->reason)) {
			exit;
		}
	}

	/**
	 * 获取错误信息
	 * @return string
	 */
	public function getError($reason = null) {
		if (is_null($reason)){
			if(!empty($this->error_msg)) {
				return cainiao_err_string($this->error_msg);
			}
			$reason	= $this->reason;
		}
		return C('CAINIAO_ERROR_MSG_DEFINITION.' . $reason);
	}

	/**
	 *
	 * @param array $return_error
	 */
	public function analyzeReturnError(&$DocInfo, $return_error, $allow_repeat = false, $repeat_field = ''){
		cainiao_get_model_valid($DocInfo, $return_error);
		if ($allow_repeat === true) {
			if (count($return_error) == 1 && array_key_exists($repeat_field, $return_error)) {
				//退货物流编号已存在（因网络问题创建完退货单未能发送反馈信息给菜鸟，导致菜鸟重新发送请求），
				//则直接退出（即返回成功状态）
				$this->unsetUniqueData($DocInfo);
				exit;
			}
		}
		$error	= cainiao_get_valid_detail_error($return_error);
		if (cainiao_has_error($error['ErrorCode'])) {
			$this->unsetUniqueData($DocInfo);
			$this->addErrorMsg($error['ErrorMessage']);
			$this->setErrorTypeAndExit($error['ErrorCode'], $error['RealErrorMessage']);
		}
	}
	
	/*********************************接口错误处理方法 ed****************************************/


	/*********************************接口辅助方法 st****************************************/
	
	/**
	 * 新增、修改产品并返回 array(产品号=>产品ID)列表
	 * @param array $products_list
	 * @return array
	 */
	private function AddProduct($products_list){
		$module			= 'Product';
		$error_msg		= array();
		$real_error_msg	= array();
		$product_ids	= array();
		foreach ($products_list as $product) {
			$p_reason	= '';
			try {
				try {
					$model					= D($module);
					$action					= $product['id'] > 0 ? 'update' : 'insert';
					$model->setModuleInfo($module, $action);
					$model->data($product);
					$_POST					= $model->data();
					$_POST['method_name']	= $action;
					$product_id				= $model->import();
					if ($product['id'] > 0 && $product_id !== false) {
						$product_id	= $product['id'];
					}
				} catch (Exception $ex) {
					$p_reason		= CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION;
					cainiao_add_error($error_msg, $ex->getMessage());
					$error			= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '保存产品出错:', $ex);
					cainiao_add_error($real_error_msg, $error);
				}
				if (!cainiao_has_error($p_reason)) {
					if($product_id > 0){
						$product_ids[$product['product_no']]	= $product_id;
						try {
							$Action	= A($module);
							$Action->id	= $product_id;
							$Action->generateBarcode();
						} catch (Exception $ex) {
							$p_reason		= CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION;
							$error			= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '生成产品[' . $product['product_no'] . ']条形码出错:', $ex);
							cainiao_add_error($real_error_msg, $error);
						}
					} else {
						$p_reason		= CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION;
						$error			= array(
											cainiao_line(__LINE__) . '产品[' . $product['product_no'] . ']保存失败:',
											$model->getError(),
											cainiao_ob_get_clean(),
										);
						cainiao_add_error($real_error_msg, $error);
					}
				}
			} catch (Exception $ex) {
				$p_reason	= CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION;
				$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '新增产品[' . $product['product_no'] . ']失败:', $ex);
				cainiao_add_error($real_error_msg, $error);
			}
			if (cainiao_has_error($p_reason) && !cainiao_has_error($this->reason)) {
				$this->reason	= $p_reason;
			}
		}
		if (cainiao_has_error($this->reason)) {
			$this->addErrorMsg($error_msg);
			$this->setErrorTypeAndExit($this->reason, $real_error_msg);
		}
		return $product_ids;
	}

	/**
	 * 退货单生成买家
	 * @param array $addition
	 * @return int
	 */
	private function AddClient($addition){
		try {
			$addition['comp_no']	= getModuleMaxNo('Client');
		} catch (Exception $ex) {
			$error					= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '生成买家编号出错:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		try {
			$Client		= D('Client');
			$client_id	= $Client->add($addition);
			if ($client_id === false) {
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, cainiao_line(__LINE__) . '保存买家出错!');
			}
		} catch (Exception $ex) {
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '创建买家出错:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		return $client_id;
	}

	/**
	 * 缓存唯一性验证信息
	 * 解决：Api并发请求同一单据时，由于数据未插入系统，导致唯一性验证失败
	 * @param array $DocInfo 单据信息
	 */
	function setUniqueData($DocInfo){
		if (empty($this->unique_field) || empty($DocInfo[$this->unique_field])) {
			return;
		}
		$doc_no	= $DocInfo[$this->unique_field];
		$s_key	= $this->getUniqueDataKey();
		$s_list	= (array)S($s_key);
		$now	= time();
		foreach ($s_list as $key => $time) {
			if ($now - $time > 5*60) {
				unset($s_list[$key]);
			}
		}
		S($s_key, $s_list);
		if (array_key_exists($doc_no, $s_list)) {
			$error		= '该' .  L($this->unique_field) . '[' . $doc_no . ']已在API请求处理中，请勿重复操作或稍后重试！';
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_REQUEST_PARAMETERS, $error);
		} else {
			$s_list[$doc_no]	= time();
			S($s_key, $s_list);
		}
	}

	/**
	 * 唯一性验证信息缓存key
	 * @return string
	 */
	function getUniqueDataKey(){
		return 'cainiao_unique_data_key_' . $this->unique_field . '_' . C('CAINIAO_FACTORY_ID');
	}

	/**
	 * 删除唯一性验证信息缓存
	 * @param array $DocInfo
	 */
	function unsetUniqueData($DocInfo){
		if (empty($this->unique_field) || empty($DocInfo[$this->unique_field])) {
			return;
		}
		$s_key	= $this->getUniqueDataKey();
		$s_list	= S($s_key);
		unset($s_list[$DocInfo[$this->unique_field]]);
		if (empty($s_list)) {
			$s_list	= NULL;
		}
		S($s_key, $s_list);
	}
	/*********************************接口辅助方法 ed****************************************/
	
	/*********************************接口实现方法 st****************************************/

	/**
	 * AddReturnOrder 请求数据验证
	 */
	public function validAddReturnOrderRequestData(){
		$this->unique_field	= 'return_logistics_no';
		$DocInfo			= $this->docDetails;
		$return_error		= array();
		$this->setUniqueData($DocInfo);
		try {
			//新增或更新产品 验证
			if (!empty($DocInfo['product'])) {
				$products_list	= $DocInfo['product'];
				foreach ($products_list as &$product) {
					$product['module_name']	= 'Product';
					$product['method_name']	= $product['id'] > 0 ? 'update' : 'insert';
					cainiao_get_model_valid($product, $return_error, array(), 'product_' . $product['product_no']);
				}
				unset($product);
			}

			//买家信息验证
			$DocInfo['addition']['module_name']	= 'Client';
			$DocInfo['addition']['method_name']	= 'insert';
			cainiao_get_model_valid($DocInfo['addition'], $return_error);
			
			//退货服务验证
			cainiao_valid_return_service($DocInfo, $return_error);

			//退货单验证
			$DocInfo['method_name']				= 'insert';
			$this->analyzeReturnError($DocInfo, $return_error, true, $this->unique_field);
			$DocInfo['product']	= $products_list;
		} catch (Exception $ex) {
			$this->unsetUniqueData($DocInfo);
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '新增退货单数据出错:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		
		$this->docDetails	= $DocInfo;
	}

	/**
	 * AddReturnOrder 保存数据
	 */
	public function AddReturnOrderAction(){
		$DocInfo	= $this->docDetails;
		$this->startTrans();
		try {
			//新增，修改产品
			if (!empty($DocInfo['product'])) {
				$product_ids			= $this->AddProduct($DocInfo['product']);
				foreach ($DocInfo['detail'] as &$product) {
					$product['product_id']	= $product_ids[$product['product_no']];
				}
				unset($product);
			}
			unset($DocInfo['product']);

			//生成买家
			$DocInfo['client_id']	= $this->AddClient($DocInfo['addition']);

			try {
				$action					= 'insert';
				$model					= D(CAINIAO_MODULE_NAME);
				$model->setModuleInfo(CAINIAO_MODULE_NAME, $action);
				$model->setReturnService($DocInfo);
				$model->data($DocInfo);
				$_POST					= $model->data();
				$_POST['method_name']	= $action;
				$doc_id					= $model->importInsert();
				if($doc_id > 0){
					$DocInfo['id']	= $doc_id;
				} else {
					$this->unsetUniqueData($DocInfo);
					$error			= array(
										cainiao_line(__LINE__) . '新增退货单失败:',
										$model->getError(),
										cainiao_ob_get_clean(),
									);
					$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
				}
			} catch (Exception $ex) {
				$this->unsetUniqueData($DocInfo);
				$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '保存退货单出错:', $ex);
				$this->addErrorMsg($ex->getMessage());
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
			}
		} catch (Exception $ex) {
			$this->unsetUniqueData($DocInfo);
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '新增退货单失败:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		$this->commitTrans();
		$this->unsetUniqueData($DocInfo);
	}

	/**
	 * AddReturnOrderTrackNo 请求数据验证
	 */
	public function validAddReturnOrderTrackNoRequestData(){
		$DocInfo		= $this->docDetails;
		if ($DocInfo['id'] <= 0) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_REQUEST_PARAMETERS, cainiao_line(__LINE__) . '该LP编号退货单不存在!');
		}
		$return_error	= array();
		try {
			//新增或更新产品 验证
			if (!empty($DocInfo['product'])) {
				$products_list	= $DocInfo['product'];
				foreach ($products_list as &$product) {
					$product['module_name']	= 'Product';
					$product['method_name']	= $product['id'] > 0 ? 'update' : 'insert';
					cainiao_get_model_valid($product, $return_error, array(), 'product_' . $product['product_no']);
				}
				unset($product);
			}

			//退货单验证
			$DocInfo['method_name']				= 'update';
			$this->analyzeReturnError($DocInfo, $return_error);
			$DocInfo['product']	= $products_list;
		} catch (Exception $ex) {
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '验证退货单数据出错:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}

		$this->docDetails	= $DocInfo;
	}

	/**
	 * AddReturnOrderTrackNo 保存数据
	 */
	public function AddReturnOrderTrackNoAction(){
		$DocInfo	= $this->docDetails;
		$this->startTrans();
		try {
			//新增，修改产品
			if (!empty($DocInfo['product'])) {
				$product_ids			= $this->AddProduct($DocInfo['product']);
				foreach ($DocInfo['detail'] as &$product) {
					$product['product_id']	= $product_ids[$product['product_no']];
				}
				unset($product);
			}
			unset($DocInfo['product']);

			try {
				$action					= 'update';
				$model					= D(CAINIAO_MODULE_NAME);
				$model->setModuleInfo(CAINIAO_MODULE_NAME, $action);
				$model->setReturnService($DocInfo);
				$model->data($DocInfo);
				$_POST					= $model->data();
				$_POST['method_name']	= $action;
				$r						= $model->importUpdate();
				if($r === false) {
					$error			= array(
										cainiao_line(__LINE__) . '更新退货单快递单号失败:',
										$model->getError(),
										cainiao_ob_get_clean(),
									);
					$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
				}
			} catch (Exception $ex) {
				$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '更新退货单快递单号出错:', $ex);
				$this->addErrorMsg($ex->getMessage());
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
			}
		} catch (Exception $ex) {
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '更新退货单快递单号失败:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		$this->commitTrans();
	}

	/**
	 * ConfirmReturnOrder 请求数据验证
	 */
	public function validConfirmReturnOrderRequestData(){
		$DocInfo		= $this->docDetails;
		if ($DocInfo['id'] <= 0) {
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_ILLEGAL_REQUEST_PARAMETERS, cainiao_line(__LINE__) . '该LP编号退货单不存在!');
		}
		$return_error	= array();
		try {
			//退货服务验证
			cainiao_valid_return_service($DocInfo, $return_error);

			//退货单验证
			$DocInfo['method_name']				= 'update';
			$this->analyzeReturnError($DocInfo, $return_error);
		} catch (Exception $ex) {
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '验证退货单数据出错:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}

		$this->docDetails	= $DocInfo;
	}

	/**
	 * ConfirmReturnOrder 保存数据
	 */
	public function ConfirmReturnOrderAction(){
		$DocInfo	= $this->docDetails;
		$this->startTrans();
		try {
			$action					= 'update';
			$model					= D(CAINIAO_MODULE_NAME);
			$model->setModuleInfo(CAINIAO_MODULE_NAME, $action);
			$model->setReturnService($DocInfo);
			$model->data($DocInfo);
			$_POST					= $model->data();
			$_POST['method_name']	= $action;
			$r						= $model->importUpdate();
			if($r === false) {
				$error			= array(
									cainiao_line(__LINE__) . '确认退货失败:',
									$model->getError(),
									cainiao_ob_get_clean(),
								);
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
			}
		} catch (Exception $ex) {
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '确认退货出错:', $ex);
			$this->addErrorMsg($ex->getMessage());
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		$this->commitTrans();
	}

	/**
	 * AddProduct 请求数据验证
	 */
	public function validAddProductRequestData(){
		$DocInfo		= $this->docDetails;
		$return_error	= array();
		try {
			$DocInfo['method_name']	= $DocInfo['id'] > 0 ? 'update' : 'insert';
			$this->analyzeReturnError($DocInfo, $return_error);
		} catch (Exception $ex) {
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '新增产品数据出错:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		$this->docDetails	= $DocInfo;
	}

	/**
	 * AddProduct 保存数据
	 */
	public function AddProductAction(){
		$DocInfo	= $this->docDetails;
		$this->startTrans();
		$this->AddProduct(array($DocInfo));
		$this->commitTrans();
	}
	
	/**
	 * AddShipping 请求数据验证
	 */
	public function validAddShippingRequestData(){
		$DocInfo		= $this->docDetails;
		$return_error	= array();
		try {
			cainiao_valid_detail_box($DocInfo, $return_error);
			cainiao_valid_detail_product($DocInfo['product'], $return_error);
			//退货单验证
			$DocInfo['method_name']	= 'insert';
			$this->analyzeReturnError($DocInfo, $return_error, true, 'container_no,factory_id');
		} catch (Exception $ex) {
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '新增发货单数据出错:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		$this->docDetails	= $DocInfo;
	}

	/**
	 * AddShipping 保存数据
	 */
	public function AddShippingAction(){
		$DocInfo	= $this->docDetails;
		$this->startTrans();
		try {
			$action					= 'insert';
			$model					= D(CAINIAO_MODULE_NAME);
			$model->setModuleInfo(CAINIAO_MODULE_NAME, $action);
			$model->data($DocInfo);
			$_POST					= $model->data();
			$_POST['method_name']	= $action;
			$doc_id					= $model->importInsert();
			if($doc_id > 0){
				$DocInfo['id']		= $doc_id;
			} else {
				$error				= array(
										cainiao_line(__LINE__) . '新增发货单失败:',
										$model->getError(),
										cainiao_ob_get_clean(),
									);
				$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
			}
		} catch (Exception $ex) {
			$error		= cainiao_set_abnormal_error(cainiao_line(__LINE__) . '新增发货单失败:', $ex);
			$this->setErrorTypeAndExit(CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION, $error);
		}
		$this->commitTrans();
	}
	/*********************************接口实现方法 ed****************************************/
}
