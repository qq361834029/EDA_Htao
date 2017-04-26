<?php

/**
 * CORREOS API
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Correos
 * @package   Model
 * @author     jph
 * @version  2.1,2016-10-21
 */
abstract class CorreosPublicModel extends RelationModel {
	protected $tableName		= 'correos_log';
	protected $_config;
	protected $wsdl;
	protected $_Location;
	protected $_CodEtiquetador;
	protected $request_type		= '';//请求类型
	protected $sale_order		= array();//销售单
	protected $correos_log_id	= 0;//请求日志id
	protected $correos_log		= array(//请求日志信息
		'correos_list_id'	=> 0,
		'shipmentNumber'	=> '',
		'Labelurl'			=> '',
		'request_status'	=> 'false',
		'status_code'		=> '',
		'status_message'	=> array(),
	);
	protected $sale				= array();//销售信息：存储追踪单号，销售单id，销售单号等，用于错误信息显示

	public function __construct($name='', $tablePrefix='', $connection='') {
		parent::__construct($name, $tablePrefix, $connection);
		addLang('Correos');
		ini_set('memory_limit','512M');
		ini_set('display_errors',true);
		set_time_limit(60);
		error_reporting(-1);
		load('Correos.CorreosAutoload', LIBRARY_PATH);
		$this->setConfig();
	}

	public function __destruct() {
	}

	/**
	 * 获取请求信息
	 */
    abstract function getRequestParams();

	/**
	 * 保存请求日志
	 */
	protected function saveLog(){
		$this->correos_log['request_type']	= $this->request_type;
		$this->correos_log['request_time']	= date('Y-m-d H:i:s');
		$this->correos_log['id']			= $this->add($this->correos_log);
	}

	/**
	 * 更新请求日志
	 */
	protected function updateLog(){
		if ($this->correos_log['id'] > 0) {
			$this->parseError();
			if (!isset($this->correos_log['return_time'])) {
				$this->correos_log['return_time']	= date('Y-m-d H:i:s');
			}
			$this->relation(true)->save($this->correos_log);
		}
	}

	/**
	 * 设置配置信息
	 */
	protected function setConfig(){
		$this->_config								= C('CORREOS_SANDBOX') === true ? C('CORREOS_SANDBOX_CONFIG') : C('CORREOS_CONFIG');
		//wsdl 配置
		$wsdl										= array();
		$wsdl[CorreosWsdlClass::WSDL_URL]			= LIBRARY_PATH . 'Correos/' . $this->_config['WSDL_URL'];
		$wsdl[CorreosWsdlClass::WSDL_CACHE_WSDL]	= constant($this->_config['WSDL_CACHE_WSDL']);
		$wsdl[CorreosWsdlClass::WSDL_TRACE]			= $this->_config['WSDL_TRACE'];
		$wsdl[CorreosWsdlClass::WSDL_LOGIN]			= $this->_config['WSDL_LOGIN'];
		$wsdl[CorreosWsdlClass::WSDL_PASSWD]		= $this->_config['WSDL_PASSWD'];
		$this->wsdl									= $wsdl;
		//auth 配置
		$this->_Location							= $this->_config['_Location'];
		$this->_CodEtiquetador						= $this->_config['_CodEtiquetador'];
	}

	/**
	 * 获取请求类
	 */
	protected function getRequestClass(){
		$_requestParams		= $this->getRequestParams();
		if (empty($_requestParams)) {
			return false;
		}
		$requestClass	= array(
			'createShipmentDD'	=> 'CorreosStructPreregistroEnvio',
			'updateShipmentDD'	=> 'CorreosStructPeticionModificar',
			'deleteShipmentDD'	=> 'CorreosStructPeticionAnular',
		);
		$requestClassName	= $requestClass[$this->request_type];
		return new $requestClassName($_requestParams);
	}

	/**
	 * 获取方法名
	 */
	protected function getRequestMethod(){
		$requestMethod	= array(
			'createShipmentDD'	=> 'PreRegistro',
			'updateShipmentDD'	=> 'ModificarOp',//
			'deleteShipmentDD'	=> 'AnularOp',
		);
		return $requestMethod[$this->request_type];
	}

	/**
	 * 获取服务对象
	 */
	protected function getServiceClass(){
		$serviceClass	= array(
			'createShipmentDD'	=> 'CorreosServicePre',
			'updateShipmentDD'	=> 'CorreosServiceModificar',//
			'deleteShipmentDD'	=> 'CorreosServiceAnular',
		);
		$serviceClassName	= $serviceClass[$this->request_type];
		$serviceModel		= new $serviceClassName($this->wsdl);
		$serviceModel->setLocation($this->_Location);
		return $serviceModel;
	}

	/**
	 * 处理请求
	 * @param array $correos_list
	 * @return mixed
	 */
	public function process($sale_order, $request_type){
		if (!is_array($sale_order) || empty($sale_order)) {
			return false;
		}
		$this->sale_order						= $sale_order;
		$this->request_type						= $request_type;
		$this->correos_log['correos_list_id']	= $sale_order['correos_list_id'];
		$this->saveLog();
		try {
			$requestModel	= $this->getRequestClass();
			if (is_object($requestModel)) {
				try {
					$serviceModel						= $this->getServiceClass();
					$request_method						= $this->getRequestMethod();
					$request_status						= $serviceModel->$request_method($requestModel);
					$this->correos_log['return_time']	= date('Y-m-d H:i:s');
					if($request_status){
						if ($request_status->Resultado == 0) {
							$this->correos_log['request_status']	= 'true';
							$this->correos_log['status_code']		= 0;
							$this->correos_log['status_message']	= '';
							if (method_exists($this, 'parseRequestResult')) {
								$this->parseRequestResult($request_status);
							}
						} else {
							$this->correos_log['request_status']	= 'false';
							$result									= (Object)$serviceModel->getResult();
							C('DEBUG_MSG', dump($result, false));
							if (property_exists($result, 'BultoError')) {
								$code		= $result->BultoError->Error;
								$message	= $result->BultoError->DescError;
							} elseif(property_exists($result, 'ErroresValidacion') && property_exists((Object)$result->ErroresValidacion, 'ErrorVal')) {
								if (is_array($result->ErroresValidacion->ErrorVal)) {
									$code	= 'Multiple Errors';
									foreach ($result->ErroresValidacion->ErrorVal as $ErrorVal) {
										$message[]	= $ErrorVal->DescError . '[' . $ErrorVal->Error . ']';
									}
								} else {
									$code		= $result->ErroresValidacion->ErrorVal->Error;
									$message	= $result->ErroresValidacion->ErrorVal->DescError;
								}
							} else {
								$code		= 'Unknown Code';
								$message	= '未知错误';
							}
							if (empty($message)) {
								$message	= $code;
								$code		= 'Unknown Code';
							}
							$this->correos_log['status_code']		= $code;
							$this->correos_log['status_message']	= $message;
						}
					} else {
						$this->correos_log['request_status']	= 'false';
						$lastError								= (Object)$serviceModel->getLastErrorForMethod(get_class($serviceModel) . '::' . $request_method);
						$this->correos_log['status_code']		= $lastError->faultcode;//soapenv:Server.generalException 服务端报错（报文错误等）； Client 客户端报错（超时等）；HTTP
						$this->correos_log['status_message']	= $lastError->faultstring;//com.ibm.ejs.container.UnknownLocalException: nested exception is: java.lang.NullPointerException: Unexpected subelement Shipment； Maximum execution time of 30 seconds exceeded ； Could not connect to host
					}
				} catch (Exception $ex) {
					$this->correos_log['return_time']		= date('Y-m-d H:i:s');
					$this->correos_log['request_status']	= 'abnormal';
					$this->correos_log['status_code']		= $ex->getCode() ? $ex->getCode() : -2;
					$this->correos_log['status_message']	= $ex->getMessage();
				}
			} else {
				$this->correos_log['return_time']		= date('Y-m-d H:i:s');
				$this->correos_log['status_code']		= 'Local';
			}
		} catch (Exception $ex) {
			$this->correos_log['return_time']		= date('Y-m-d H:i:s');
			$this->correos_log['request_status']	= 'abnormal';
			$this->correos_log['status_code']		= $ex->getCode() ? $ex->getCode() : -1;
			$this->correos_log['status_message']	= $ex->getMessage();
		}
		$this->updateLog();
	}

	/**
	 * 解析错误
	 */
	protected function parseError(){
		if ($this->correos_log['request_status'] != 'true' && $this->getErrorBySatusCode($this->correos_log['status_code'])) {
			$this->getSatusError($this->correos_log['status_code'], $this->correos_log['status_message']);
		}
		if (is_array($this->correos_log['status_message'])) {
			$this->correos_log['status_message']	= implode("<br />", $this->correos_log['status_message']);
		}
	}

	/**
	 * 根据状态代码返回状态
	 * @param string $status_code
	 * @return boolean
	 */
	protected function getErrorBySatusCode($status_code){
		return $status_code ? true : false;
	}

	/**
	 * 获取错误信息
	 * @param string $status_code
	 * @param mixed $status_message
	 */
	protected function getSatusError($status_code, $status_message){
		$serial_no			= 0;
		$error				= array();
		$error[]			= L('request_id') . ': ' . $this->correos_log['id'];
		$error[]			= (++$serial_no) . '. ' . L('status_code') . ': ' . $status_code;
		$status_msg_serial	= (++$serial_no) . '.';
		$status_msg_label	= $status_msg_serial . ' ' . L('status_message') . ': ';
		$is_array			= is_array($status_message);
		$status_msg			= $is_array ? array_unique($status_message) : $status_message;
		if (!$is_array || count($status_msg) == 1) {
			$error[]			= $status_msg_label . ($is_array ? reset($status_msg) : $status_msg);
		} else {
			$error[]		= $status_msg_label;
			foreach ($status_msg as $key => $msg) {
				$error[]	= $status_msg_serial . ($key + 1) . '. ' . $msg;
			}
		}
		$this->appendError($error);
	}

	/**
	 * 增加错误信息
	 * @param mixed $error
	 * @param string $label
	 */
	protected function setStatusMessage($error, $label = ''){
		if (empty($error)) {
			return;
		}
		if (!empty($label)) {
			$label	= '[' . $label . ']';
		}
		if (!is_array($error)) {
			$error	= array($error);
		}
		foreach ($error as $err) {
			$this->correos_log['status_message'][]	= $label . $err;
		}
	}
}