<?php

/**
 * DHL API
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Ebay
 * @package   Model
 * @author     jph
 * @version  2.1,2016-04-21
 */
class DhlPublicModel extends RelationModel {
	protected $tableName		= 'dhl_log';
	protected $_config;
	protected $wsdl;
	protected $_user;
	protected $_signature;
	protected $_accountNumber;
	protected $_type;
	protected $_version;
	protected $request_type		= '';//请求类型
	protected $sale_order_list	= array();//销售单列表
	protected $dhl_log_id		= 0;//请求日志id
	protected $dhl_log			= array();//请求日志信息
	protected $sale_list		= array();//销售信息：存储追踪单号，销售单id，销售单号等，用于错误信息显示

	/// 定义表关联
	protected $_link	= array(
		'detail' => array(
			'mapping_type'	=> HAS_MANY,
			'foreign_key' 	=> 'dhl_log_id',
			'class_name'	=> 'DhlLogDetail',
		),
	);

	public function __construct($name='', $tablePrefix='', $connection='') {
		parent::__construct($name, $tablePrefix, $connection);
		addLang('Dhl');
		ini_set('memory_limit','512M');
		ini_set('display_errors',true);
		set_time_limit(120);
		error_reporting(-1);
		load('DHL.DHLAutoload', LIBRARY_PATH);
		$this->setConfig();
	}

	public function __destruct() {
	}

	/**
	 * 处理请求
	 * @param array $dhl_list
	 * @return mixed
	 */
	public function process($sale_order_list, $request_type){
		if (!is_array($sale_order_list) || empty($sale_order_list)) {
			return false;
		}
		$this->sale_order_list	= $sale_order_list;
		$this->request_type		= $request_type;
		$this->saveLog();
		try {
			$requestModel	= $this->getRequestClass();
			if (is_object($requestModel)) {
				try {
					$serviceModel						= $this->getServiceClass();
					$request_status						= $serviceModel->$request_type($requestModel);
					$this->dhl_log['return_time']		= date('Y-m-d H:i:s');
					if($request_status){
						$this->dhl_log['request_status']	= 'true';
						$result								= (Object)$serviceModel->getResult();
						$status								= property_exists($result, 'Status') ? (Object)$result->Status : (Object)$result->status;
						$this->dhl_log['status_code']		= $status->StatusCode;
						$this->dhl_log['status_message']	= $status->StatusMessage;
						$this->parseRequestResult($result);
					} else {
						$this->dhl_log['request_status']	= 'false';
						$lastError							= (Object)$serviceModel->getLastErrorForMethod(get_class($serviceModel) . '::' . $this->request_type);
						$this->dhl_log['status_code']		= $lastError->faultcode;//soapenv:Server 服务端报错（报文错误等）； Client 客户端报错（超时等）；HTTP
						$this->dhl_log['status_message']	= $lastError->faultstring;//org.apache.axis2.databinding.ADBException: Unexpected subelement Shipment； Maximum execution time of 30 seconds exceeded ； Could not connect to host
					}
				} catch (Exception $ex) {
					$this->dhl_log['return_time']		= date('Y-m-d H:i:s');
					$this->dhl_log['request_status']	= 'abnormal';
					$this->dhl_log['status_code']		= $ex->getCode() ? $ex->getCode() : -2;
					$this->dhl_log['status_message']	= $ex->getMessage();
				}
			} else {
				$this->dhl_log['return_time']		= date('Y-m-d H:i:s');
			}
		} catch (Exception $ex) {
			$this->dhl_log['return_time']		= date('Y-m-d H:i:s');
			$this->dhl_log['request_status']	= 'abnormal';
			$this->dhl_log['status_code']		= $ex->getCode() ? $ex->getCode() : -1;
			$this->dhl_log['status_message']	= $ex->getMessage();
		}
		$this->updateLog();
	}

	/**
	 * 获取请求类
	 */
    protected function getRequestClass() {}
	
	/**
	 * 解析请求结果
	 * @param object $result
	 */
    protected function parseRequestResult($result) {}

	/**
	 * 保存请求日志
	 */
	protected function saveLog(){
		$this->dhl_log			= array(
			'request_type'	=> $this->request_type,
			'request_time'	=> date('Y-m-d H:i:s'),
		);
		$this->dhl_log['id']	= $this->add($this->dhl_log);
	}

	/**
	 * 更新请求日志
	 */
	protected function updateLog(){
		if ($this->dhl_log['id'] > 0) {
			$this->parseError();
			if (!isset($this->dhl_log['return_time'])) {
				$this->dhl_log['return_time']	= date('Y-m-d H:i:s');
			}
			$this->relation(true)->save($this->dhl_log);
		}
	}

	/**
	 * 解析错误
	 */
	protected function parseError(){
		if (!empty($this->dhl_log['detail'])) {
			foreach ($this->dhl_log['detail'] as $sale_id => &$detail) {
				$sale	= $this->sale_list[$sale_id];
				if ($detail['request_status'] != 'true' && $this->getErrorBySatusCode($detail['status_code'])) {
					$this->getSatusError($detail['status_code'], $detail['status_message'], L('deal_no') . ': ' . $sale['sale_order_no']);
				}
				if (is_array($detail['status_message'])) {
					$detail['status_message']	= implode("<br />", $detail['status_message']);
				}
			}
			unset($detail);
		}
		$error							= $this->clearError();
		$status							= $this->getErrorStatus($error);
		if ($status) {//明细有错误或请求有错误
			switch ($this->dhl_log['request_status']) {
				case 'true'://请求成功，但部分失败
					$label	= L('dhl_api_request_partial_failure');
					break;
				case 'false'://请求失败
					$label	= L('dhl_api_request_failure');
					break;
				case 'abnormal'://请求异常
				default :
					$label	= L('dhl_api_request_abnormal');
					break;
			}
			$this->getSatusError($this->dhl_log['status_code'], $this->dhl_log['status_message'], $label, false);
		}
		if (!empty($error)) {
			$this->appendError($error);
		}
	}
	
	/**
	 * 获取主错误状态
	 * @param array $error 明细错误信息
	 * @return boolean
	 */
	protected function getErrorStatus($error){
		$status	= !empty($error) || $this->getErrorBySatusCode($this->dhl_log['status_code']);
		return $status;
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
	 * @staticvar int $serial_no
	 * @param string $status_code
	 * @param mixed $status_message
	 * @param string $label
	 * @param boolean $is_detail
	 */
	protected function getSatusError($status_code, $status_message, $label, $is_detail = true){
		static $serial_no	= 0;
		$serial_no++;
		$indent_str			= '&nbsp;&nbsp;';//缩进字符串
		$error				= array();
		if ($label) {
			$error[]		= ($is_detail ? $indent_str . $serial_no . '. ' : '') . $label;
		}
		if ($is_detail === false) {
			$error[]		= L('request_id') . ': ' . $this->dhl_log['id'];
		}
		$child_serial_no	= 0;
		$error[]			= ($is_detail ? $indent_str . $serial_no . '.' . (++$child_serial_no) . '. ' : '') . L('status_code') . ': ' . $status_code;
		$status_msg_serial	= ($is_detail ? $indent_str . $serial_no . '.' . (++$child_serial_no) . '.' : '');
		$status_msg_label	= ($is_detail ? $status_msg_serial . ' ' : '') . L('status_message') . ': ';
		$is_array			= is_array($status_message);
		$status_msg			= $is_array ? array_unique($status_message) : $status_message;
		if (!$is_array || count($status_msg) == 1) {
			$error[]			= $status_msg_label . ($is_array ? reset($status_msg) : $status_msg);
		} else {
			$error[]		= $status_msg_label;
			foreach ($status_msg as $key => $msg) {
				$error[]	= ($is_detail ? $indent_str . $status_msg_serial : '') . ($key + 1) . '. ' . $msg;
			}
		}
		$this->appendError($error);
	}

	/**
	 * 设置配置信息
	 */
	protected function setConfig(){
		$this->_config							= C('DHL_SANDBOX') === true ? C('DHL_SANDBOX_CONFIG') : C('DHL_CONFIG');
		//wsdl 配置
		$wsdl									= array();
		$wsdl[DHLWsdlClass::WSDL_URL]			= LIBRARY_PATH . 'DHL/' . $this->_config['WSDL_URL'];
		$wsdl[DHLWsdlClass::WSDL_CACHE_WSDL]	= constant($this->_config['WSDL_CACHE_WSDL']);
		$wsdl[DHLWsdlClass::WSDL_TRACE]			= $this->_config['WSDL_TRACE'];
		$wsdl[DHLWsdlClass::WSDL_LOGIN]			= $this->_config['WSDL_LOGIN'];
		$wsdl[DHLWsdlClass::WSDL_PASSWD]		= $this->_config['WSDL_PASSWD'];
		$this->wsdl								= $wsdl;
		//auth 配置
		$this->_user							= $this->_config['_USER'];
		$this->_signature						= $this->_config['_SIGNATURE'];
		$this->_accountNumber					= $this->_config['_ACCOUNTNUMBER'];
		$this->_type							= $this->_config['_TYPE'];
		//其他配置
		$this->_version							= $this->_config['_VERSION'];
	}

	/**
	 * 获取服务类名
	 */
	protected function getServiceClassName(){
		$serviceClass	= array(
			'createShipmentTD'	=> 'DHLServiceCreate',
			'createShipmentDD'	=> 'DHLServiceCreate',//
			'deleteShipmentTD'	=> 'DHLServiceDelete',
			'deleteShipmentDD'	=> 'DHLServiceDelete',//
			'doManifestTD'		=> 'DHLServiceDo',
			'doManifestDD'		=> 'DHLServiceDo',
			'getLabelTD'		=> 'DHLServiceGet',
			'getLabelDD'		=> 'DHLServiceGet',//
			'getVersion'		=> 'DHLServiceGet',
			'getExportDocTD'	=> 'DHLServiceGet',
			'getExportDocDD'	=> 'DHLServiceGet',
			'getManifestDD'		=> 'DHLServiceGet',
			'bookPickup'		=> 'DHLServiceBook',
			'cancelPickup'		=> 'DHLServiceCancel',
			'updateShipmentDD'	=> 'DHLServiceUpdate',//
		);
		return $serviceClass[$this->request_type];
	}

	/**
	 * 获取服务对象
	 */
	protected function getServiceClass(){
		$serviceClassName	= $this->getServiceClassName();
		$serviceModel		= new $serviceClassName($this->wsdl);
		$authModel			= new DHLStructAuthentificationType($this->_user, $this->_signature, $this->_accountNumber, $this->_type);
		$serviceModel->setSoapHeaderAuthentification($authModel);
		return $serviceModel;
	}

	/**
	 * 获取请求类名
	 * @return string
	 */
	protected function getRequestClassName(){
		$requset_type	= $this->request_type;
		return 'DHLStruct' . ($requset_type == 'getVersion' ? 'Version' : ucfirst($requset_type) . 'Request');
	}

	/**
	 * 初始化日志明细
	 * @param array $sale
	 * @param string $_shipmentNumber
	 * @param string $labelUrl
	 */
	protected function initializeLogDetail($sale, $_shipmentNumber = '', $labelUrl = ''){
		$this->dhl_log['detail'][$sale['sale_order_id']]	= array(
			'dhl_list_id'		=> $sale['dhl_list_id'],
			'shipmentNumber'	=> $_shipmentNumber,
			'Labelurl'			=> $labelUrl,
			'request_status'	=> 'false',
			'status_code'		=> '',
			'status_message'	=> array(),
		);
	}

	/**
	 * 增加明细错误信息
	 * @param int $sale_id
	 * @param mixed $error
	 * @param string $label
	 */
	protected function addDetailError($sale_id, $error, $label = ''){
		if (empty($error)) {
			return;
		}
		if (!empty($label)) {
			$label	= '[' . $label . ']';
		}
		if (is_array($error)) {
			foreach ($error as $err) {
				$this->dhl_log['detail'][$sale_id]['status_message'][]	= $label . $err;
			}
		} else {
			$this->dhl_log['detail'][$sale_id]['status_message'][]	= $label . $error;
		}
	}

	/**
	 * 设置明细状态代码
	 * @param int $sale_id
	 * @param string $status_code
	 */
	protected function setDetailStatusCode($sale_id, $status_code){
		$this->dhl_log['detail'][$sale_id]['status_code']	= $status_code;
	}

	/**
	 * 验证请求数据是否为空
	 * @param array $request_data
	 * @return boolean
	 */
	protected function requestDataEmpty($request_data){
		if (empty($request_data)) {
			$this->dhl_log['request_status']	= 'false';
			$this->dhl_log['status_code']		= 'Local';
			$this->dhl_log['status_message']	= L('no_record_for_search');
			return true;
		}
		return false;
	}
}