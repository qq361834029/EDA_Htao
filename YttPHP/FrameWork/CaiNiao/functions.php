<?php

/**
 * 菜鸟api公共函数库
 * @category   Think
 * @package  Common
 * @author   jph 
 * @version  $Id$
 */

	/**
	 * 获取请求数据
	 * @param int $limit
	 * @return array
	 */
	function cainiao_get_need_request($limit = 50){
		$where					= cainiao_get_need_request_where();
		$logisticsOrderCodes	= M('CaiNiaoLog')->where($where)->group('logisticsOrderCode')->limit($limit)->getField('logisticsOrderCode', true);
		return cainiao_get_need_request_order($logisticsOrderCodes);
	}

	/**
	 * 根据所给的LP编号获取请求数据
	 * @param string|array $logisticsOrderCodes
	 * @return array
	 */
	function cainiao_get_need_request_order($logisticsOrderCodes){
		if (empty($logisticsOrderCodes)) {
			return array();
		} elseif (is_string($logisticsOrderCodes)) {
			$logisticsOrderCodes	= explode(',', $logisticsOrderCodes);
		}
		$where							= cainiao_get_need_request_where();
		$where['logisticsOrderCode']	= array('in', $logisticsOrderCodes);
		$field							= 'id,request_status,logistic_provider_id,msg_type,eventTime,logisticsOrderCode';
		$select	= M('CaiNiaoLog')->where($where)->field($field)->order('id asc')->select();
		return formatArray($select, 'logisticsOrderCode,id');
	}

	/**
	 * 执行请求前将状态置为处理中，以防重复执行
	 * @param array $ids
	 */
	function cainiao_set_request_processing($ids) {
		$where			= cainiao_get_need_request_where();
		$where['id']	= array('in', $ids);
		M('CaiNiaoLog')->where($where)->setField('request_status', CAINIAO_REQUEST_STATUS_PROCESSING);
	}

	/**
	 *
	 * @param int $limit
	 */
	function cainiao_process_request($limit = 50, $debug = false){
		$request_list	= cainiao_get_need_request($limit);
		if (!empty($request_list)) {
			$ids					= array();
			foreach ($request_list as $request) {
				foreach ($request as $data) {
					$ids[]	= $data['id'];
				}
			}
			cainiao_set_request_processing($ids);
			foreach ($request_list as $request) {
				$flag	= true;
				foreach ($request as $data) {
					$request_status			= $data['request_status'];
					$reset_stauts			= false;
					if ($flag === true) {
						try {
							$data			= cainiao_request($data, $debug);
							if (cainiao_request_failed($data['request_status'])) {//一次请求失败后，该LP单据后续请求将不再执行
								$flag		= false;
							}
							$reset_stauts	= false;
						} catch (Exception $ex) {
							$flag			= false;
							$reset_stauts	= true;
						}
						cainiao_request_abnormal_send_email($data['id'], $flag);
					} else {
						$reset_stauts		= true;
					}
					if ($reset_stauts === true) {//未执行请求或请求异常 还原状态
						$cainiao_log		= array(
												'id'				=> $data['id'],
												'request_status'	=> $request_status,
											);
						M('CaiNiaoLog')->save($cainiao_log);
					}
				}
			}
		}
	}

	function cainiao_request_failed($request_status){
		return in_array($request_status, cainiao_request_success()) ? false : true;
	}

	function cainiao_request_abnormal_send_email($cai_niao_log_id, $flag = false){
		if ($flag === false) {
			$where	= array(
						'cai_niao_log_id'	=> $cai_niao_log_id
					);
			$count	= M('CaiNiaoLogDetail')->where($where)->count();
			if ($count >= C('CAINIAO_REQUEST_ABNORMAL_LIMIT')) {//记录邮件发送
				D('EmailList')->CaiNiaoRequestAbnormal($cai_niao_log_id);
			}
		} else {//取消发送邮件
			$model	= D('EmailList');
			$model->set_email_type('CaiNiaoRequestAbnormal');
			$model->setEmailList($cai_niao_log_id);
		}
	}

	/**
	 * 菜鸟请求
	 * @author jph 20150829
	 * @param array $data
	 * @return array
	 */
	function cainiao_request($data, $debug = false){
		$logistics_interface	= cainiao_get_xml($data['id'], $data['eventTime'], $data['msg_type']);
		if ($debug) {
			echo '<pre>';
			echo 'id:' . $data['id'] . '<br />';
			echo 'request:<br />';
			echo htmlentities($logistics_interface);
		}
		$data['data_digest']	= cainiao_get_data_digest($logistics_interface);
		$data['request_time']	= date('Y-m-d H:i:s');
		$data['log_detail_id']	= cainiao_save_request_log($data);
		$errno					= CURLE_OK;
		switch (C('CAINIAO_RESPONSE_TYPE')) {
			case -1://直接返回xml
				$reason			= C('CAINIAO_RESPONSE_REASON');
			case 0://直接返回xml
				$desc			= C('CAINIAO_RESPONSE_DESC') ? C('CAINIAO_RESPONSE_DESC') :  (cainiao_has_error($reason) ? C('CAINIAO_ERROR_MSG_DEFINITION.' . $reason) : '');
				$success		= C('CAINIAO_RESPONSE_TYPE') == -1 ? 'false' : 'true';
				$responseXml	= '<response><success>' . $success . '</success><errorCode>' . $reason . '</errorCode><errorMsg>' . $desc . '</errorMsg></response>';
				break;
			case 1://发送信息到测试环境地址
			case 2://发送信息到生成环境地址
			default :
				$url			= C('CAINIAO_RESPONSE_TYPE') == 1 ? C('CAINIAO_TEST_URL') : C('CAINIAO_URL');
				$post			= array(
									'logistics_interface'	=> $logistics_interface,
									'logistic_provider_id'	=> $data['logistic_provider_id'],
									'msg_type'				=> $data['msg_type'],
									'data_digest'			=> $data['data_digest'],
									'msg_id'				=> $data['id'],
								);
				$response		= curlRequest($url, $post);
				$errno			= $response['errno'];
				$responseXml	= $response['content'];
				break;
		}
		if ($debug) {
			echo '<br /><br />';
			echo 'detail_id:' . $data['log_detail_id'] . '<br />';
			echo 'return:<br />';
			echo htmlentities($responseXml);
		}
		$data['response_time']	= date('Y-m-d H:i:s');
		cainiao_parse_response_xml($responseXml, $data, $errno);
		cainiao_update_request_log($data, $responseXml);
		return $data;
	}

	/**
	 *
	 * @param type $responseXml
	 * @param type $data
	 */
	function cainiao_parse_response_xml($responseXml, &$data, $errno = CURLE_OK) {
		if ($errno) {
			$data['request_status']	= CAINIAO_REQUEST_STATUS_TIME_OUT;
			$data['errorInfo']		= '请求失败[errno=' . $errno . ']';
		} else {
			if (!empty($responseXml)) {
				try {
					import('ORG.Util.XML2Array');
					$responseData		= XML2Array::createArray($responseXml);
					$response			= $responseData['response'];
					if (is_array($response) && !empty($response)) {
						if ($response['success'] == 'true') {
							$data['success']		= 'true';
							$data['request_status']	= $data['request_status'] == CAINIAO_REQUEST_STATUS_NOT_YET ? CAINIAO_REQUEST_STATUS_SUCCESS : CAINIAO_REQUEST_STATUS_RETRY_SUCCEEDS;
						} else {
							$data['success']		= 'false';
							$data['reason']			= $response['errorCode'];
							$data['request_status']	= strtoupper($data['reason']{0}) == 'B' ? CAINIAO_REQUEST_STATUS_ABANDON : CAINIAO_REQUEST_STATUS_FAILED;
						}
						$data['desc']				= $response['errorMsg'];
					} else {
						$data['request_status']		= CAINIAO_REQUEST_STATUS_ABNORMAL;
						$data['errorInfo']			= '返回数据格式有误';
					}

				} catch (Exception $exc) {
					$data['request_status']	= CAINIAO_REQUEST_STATUS_ABNORMAL;
					$data['errorInfo']		= '返回xml解析出错: '.$exc->getMessage();
				}
			} else {
				$data['request_status']	= CAINIAO_REQUEST_STATUS_TIME_OUT;
				$data['errorInfo']		= '返回内容为空';
			}
		}
	}

	/**
	 * 菜鸟api 更新请求日志
	 * @param array $data
	 * @return int 请求明细id
	 */
	function cainiao_save_request_log($data){
		//保存请求日志
		$cainiao_log			= array(
									'id'					=> $data['id'],
									'data_digest'			=> $data['data_digest'],				//消息签名
								);
		M('CaiNiaoLog')->save($cainiao_log);
		//保存请求日志
		$cainiao_log_detail		= array(
									'cai_niao_log_id'		=> $data['id'],
									'request_time'			=> $data['request_time'],				//请求时间
								);
		return M('CaiNiaoLogDetail')->add($cainiao_log_detail);
	}

	/**
	 * 菜鸟api 更新请求日志
	 * @param array $data
	 * @param xml $logistics_interface
	 */
	function cainiao_update_request_log($data, $logistics_interface){
		//保存请求日志
		$cainiao_log			= array(
									'id'					=> $data['id'],
									'request_status'		=> $data['request_status'],				//请求状态 0未请求 1请求成功 2请求失败 3请求异常 4请求超时 5重新请求成功 8不再请求 9请求中
								);
		M('CaiNiaoLog')->save($cainiao_log);
		//保存请求日志
		$cainiao_log_detail		= array(
									'id'					=> $data['log_detail_id'],
									'cai_niao_log_id'		=> $data['id'],
									'success'				=> $data['success'],
									'reason'				=> $data['reason'],
									'desc'					=> $data['desc'],
									'response_time'			=> $data['response_time'],
									'errorInfo'				=> $data['errorInfo'],					//详细错误信息
								);
		M('CaiNiaoLogDetail')->save($cainiao_log_detail);
		cainiao_save_xml($data['id'] . '_' . $data['log_detail_id'], $logistics_interface, $data['eventTime'], $data['msg_type'], false);
	}

	
/***************************************************************************************************************************/

	/**
	 *
	 * @param string $reason
	 * @return boolean
	 */
	function cainiao_has_error($reason){
		return !empty($reason);
	}
	/**
	 * 返回行号信息
	 * @param int $line 行号
	 * @return string
	 */
	function cainiao_line($line){
		return '[' . $line . ']';
	}

	/**
	 * 获取debug
	 * @return string
	 */
	function cainiao_set_debug(){
		$debug	= intval($_POST['debug']);
		C('CAINIAO_DEBUG', $debug);
	}

	/**
	 * 调试打印数据
	 * @param mixed $data
	 * @param bool $exit
	 */
	function cainiao_dump($data, $exit = false){
		if (C('CAINIAO_DEBUG') === 1) {
			if (is_string($data) || is_numeric($data)) {
				echo $data;
			} else {
				dump($data);
			}
			if ($exit) {
				exit;
			}
		}
	}

	/**
	 * 设置系统中可能需要使用的用户信息
	 */
	function cainiao_session_user_info($authInfo){
		/// 设置系统中可能需要使用的用户信息
		$result					= array(
									'id'			=> $authInfo['id'],				/// 用户ID
									'user_id'		=> $authInfo['id'],				/// 用户ID
									'role_id' 		=> $authInfo['role_id'],		/// 角色ID
									'user_type'		=> $authInfo['user_type'],		/// 1 公司，2 客户，3 厂家
									'company_id'	=> $authInfo['company_id'],		/// 用户对应的厂家，客户ID
									'role_type'		=> M('Role')->where('id=' . (int)$authInfo['role_id'])->getField('role_type'),
								);
		define('USER_ID', $authInfo['id']);
		/// 保存至session
		$_SESSION['LOGIN_USER'] = $result;
	}

	/**
	 * 业务规则验证
	 * @param string $method_name
	 * @param array $params
	 */
	function cainiao_brf($method_name, $params){
		/// 业务规则检查
		$all_tags			= C('extends');
		$action_tag_name	= CAINIAO_MODULE_NAME.'&'.$method_name;
		if (isset($all_tags[$action_tag_name])) {
			$params['method_name']	= $method_name;
			tag($action_tag_name, $params);
		}
	}

	/**
	 * 验证AuthToken
	 * @author jph 20160215
	 * @param string $authToken
	 * @return boolean.
	 */
	function cainiao_valid_auth_token($authToken){
		if (empty($authToken) || preg_match('/^[a-z0-9A-Z]{32}$/', $authToken) == 0){
			return false;
		}
		return true;
	}
	
	/**
	 * 获取卖家id
	 * @return int
	 */
	function cainiao_set_factory_id(){
		$where			= array(
							'comp_type'		=> C('CAINIAO_DEFAULTCONFIG_COMP_TYPE'),
							'to_hide'		=> array('ELT',1),
							'auth_token'	=> C('CAINIAO_AUTH_TOKEN'),
							'auth_status'	=> 1,//授权码启用状态
						);
		$factory_id		= (int)M('Company')->where($where)->getField('id');
		C('CAINIAO_FACTORY_ID', $factory_id);
	}
	
	/**
	 * 验证卖家
	 * @param int $factory_id
	 */
	function cainiao_valid_factory(){
		$factory_id	= C('CAINIAO_FACTORY_ID');
		if ($factory_id <= 0){
			return -1;
		}
		$map		=   array(
						'role_id'		=> C('SELLER_ROLE_ID'),
						'to_hide'		=> array('ELT',1),
						'user_type'		=> 2,//1：公司，2：卖家，3：卖家员工
						'company_id'	=> $factory_id,
					);
		$authInfo	= RBAC::authenticate($map);
		if (empty($authInfo)){
			return -2;
		}
		if(!empty($authInfo['user_ip']) && !RBAC::authip($authInfo['user_ip'])){
			return -3;
		}
		cainiao_session_user_info($authInfo);
		return 1;
	}

	/**
	 *
	 * @return string
	 */
	function cainiao_ob_get_clean(){
		$ob_get_clean	= trim(ob_get_clean());
		return $ob_get_clean ? htmlspecialchars_decode($ob_get_clean) : '';
	}

	/**
	 * 增加错误信息
	 * @param mixed &$error
	 * @param mixed $add_err
	 * @return array $error
	 */
	function cainiao_add_error(&$error, $add_err){
		if (empty($add_err)) {
			return;
		}
		if (!is_array($error)){
			$error	= array($error);
			$to_str	= true;
		}
		!is_array($add_err)	&& $add_err	= array($add_err);
		$add_err	= array_filter($add_err);
		foreach ($add_err as $err){
			if (!empty($err)) {
				$error[]	= $err;
			}
		}
		if ($to_str === true) {
			$error	= cainiao_err_string($error);
		}
	}

	/**
	 * 错误信息数组转字符串
	 * @param mixed $error
	 * @return string
	 */
	function cainiao_err_string($error){
		return is_array($error) ? implode("\r\n", array_filter($error)) : $error;
	}

	/**
	 *
	 * @param type $model
	 * @param string $return_error
	 * @param string $key_prefix
	 */
	function cainiao_get_model_error($model, &$return_error, $key_prefix = '') {
		$error_data = $model->getError();
		if (is_array($error_data)) {
			$tips	= C(CAINIAO_PARSE_MODULE_NAME . '_IMPORT_TIPS');
			$detail_key	= 1;
			$count_key	= 2;
			$field_key	= 3;
			$sub_inc	= 0;
			foreach($error_data as $error){
				preg_match('/([a-z_]+)\[(\d+)\]\[(\w+)\]/', $error['name'], $matches);
				if (!empty($matches)) {
					$name	= ($tips[$matches[$field_key]] ? $tips[$matches[$field_key]] : L($matches[$field_key]));
					if ($matches[$detail_key] == 'addition') {
						$return_error[$error['name']] = $name . ': ' . $error['value'];
					} else {
						if ($matches[$count_key] == 0) {
							$sub_inc	= 1;
						}
						$return_error[$error['name']] = '第' . ($matches[$count_key] + $sub_inc) .'行' . C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_DETAIL_KEYS.' . $matches[$field_key]) . '明细['. $name . ']: ' . $error['value'];
					}
				} else {
					$return_error[($key_prefix ? $key_prefix . '_' : '') . $error['name']] = ($tips[$error['name']] ? $tips[$error['name']] : L($error['name'])).': '.$error['value'];
				}
			}
		} else {
			$return_error[]	= $error_data;
		}
	}

	/**
	 *
	 * @param array $return_error
	 * @return array
	 */
	function cainiao_get_valid_detail_error($return_error){
		$real_error_msg	= array();
		if (!empty($return_error)) {
			$reason			= CAINIAO_ERROR_REASON_SYSTEM_BUSINESS_SERVICE_EXCEPTION;
			$error_msg		= $return_error;
			cainiao_add_error($real_error_msg, $return_error);
		}
		if (!empty($real_error_msg)) {
			C('CAINIAO_DEBUG') === 1 && $error_msg	= $real_error_msg;
		}
		$error	= array(
					'ErrorCode'			=> $reason,
					'ErrorMessage'		=> $error_msg,
					'RealErrorMessage'	=> empty($real_error_msg) ? $error_msg : $real_error_msg,
				);
		return $error;
	}

	/**
	 *
	 * @param string $msg
	 * @param object $ex
	 * @return array
	 */
	function cainiao_set_abnormal_error($msg, $ex = null){
		$error	= array(
					$msg,
					$ex->getMessage(),
					cainiao_ob_get_clean()
				);
		return $error;
	}
	
	/**
	 * 获取日期
	 * @param array $date
	 * @return array
	 */
	function cainiao_get_date($date, $is_time = false){
		if(strpos($date,'/')){//支持欧洲格式 日/月/年
			$date	= preg_replace('/([0-3]\d)\/([0-1]\d)\/(\d{4}|\d{2})/', '$3-$2-$1', $date);
		}
		$dateTime	= strtotime($date);
		if ($dateTime == false || $dateTime == -1){
			return '';
		}
		return date('Y-m-d' . ($is_time ? ' H:i:s' : ''), $dateTime);
	}

	/**
	 *
	 * @param array $doc
	 * @return array
	 */
	function cainiao_get_doc($doc) {
		$details		= cainiao_get_doc_details($doc);
		$make_function	= 'cainiao_make_' . CAINIAO_PARSE_MODULE_NAME . '_details';
		return $make_function($details);
	}

	/**
	 *
	 * @param array $data
	 * @param array $keys
	 */
	function cainiao_array_to_list(&$data, $keys){
		foreach ($keys as $key => $k) {
			$k	= trim($k);
			if (!is_array($data[$key]) || empty($data[$key])) {
				$data[$key]	= array();
			}
			if (empty($k)) {
				if (!isset($data[$key][0])) {
					$data[$key]	= array($data[$key]);
				}
			} else {
				if (!is_array($data[$key][$k]) || empty($data[$key][$k])) {
					$data[$key][$k]	= array();
				} elseif (!isset($data[$key][$k][0])) {
					$data[$key][$k]	= array($data[$key][$k]);
				}
			}
		}
	}

	/**
	 *
	 * @param mixed $value
	 * @param string $field
	 * @param array $int_fields
	 * @return mixed
	 */
	function cainiao_get_format_value($value, $field, $int_fields){
		return in_array($field, $int_fields) ? intval($value) : trim($value);
	}

	/**
	 *
	 * @param array $data
	 * @param boolean $is_empty
	 * @param string $field
	 * @param array $val
	 * @param array $optional_fields
	 * @param array $int_fields
	 * @param array $detail_fields
	 * @return void
	 */
	function cainiao_get_value(&$data, &$is_empty, $field, $val, $optional_fields, $int_fields, $detail_fields = array()){
		//非必填字段过滤
		if (!array_key_exists($field, $val) && (array_key_exists($field, $optional_fields) || array_key_exists($field, $detail_fields))) {
			return;
		}
		if (!empty($val[$field])) {
			$is_empty	= false;
		}
		$data[$field]	= cainiao_get_format_value($val[$field], $field, $int_fields);
	}

	/**
	 * 获取单据明细
	 * @param mixed $data
	 * @return array
	 */
	function  cainiao_get_doc_details($data){
		if (!is_array($data) || empty($data)) {
			return array();
		}
		$doc_details		= array();
		$is_empty			= true;
		$_fields			= (array)C('CAINIAO_' . CAINIAO_PARSE_API_NAME . '_FIELDS');
		$_detail_fields		= (array)C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_DETAIL_FIELDS');
		$_int_fields		= (array)C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_INT_FIELDS');
		$_optional_fields	= (array)C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS');
		$_sub_key			= (array)C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_SUB_KEY');
		$_sub_keys			= (array)C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_SUB_KEYS');
		$_third_sub_keys	= (array)C('CAINIAO_' . CAINIAO_PARSE_MODULE_NAME . '_THIRD_SUB_KEYS');
		cainiao_array_to_list($data, $_third_sub_keys);
		foreach ($_fields as $field => $sub) {
			if (is_array($sub)) {
				$subscript			= $field;
				$int_fields			= isset($_int_fields[$subscript]) ? $_int_fields[$subscript] : array();
				$optional_fields	= isset($_optional_fields[$subscript]) ? $_optional_fields[$subscript] : array();
			} else {
				$subscript			= $sub;
				$int_fields			= $_int_fields;
				$optional_fields	= $_optional_fields;
			}
			switch ($subscript) {
				case in_array($subscript, $_sub_keys)://二维明细，例：产品明细等
					foreach ($data[$subscript] as $key => $val) {
						foreach ($sub as $field => $third) {
							if (is_array($third)) {
								$three_subscript	= $field;
								$int_fields			= isset($_int_fields[$subscript][$three_subscript]) ? $_int_fields[$subscript][$three_subscript] : array();
								$optional_fields	= isset($_optional_fields[$subscript][$three_subscript]) ? $_optional_fields[$subscript][$three_subscript] : array();
							} else {
								$three_subscript	= $third;
							}
							if (in_array($three_subscript, $_third_sub_keys)) {//三级明细
								foreach ($val as $k => $v) {
									foreach ($third as $field) {
										cainiao_get_value($doc_details[$subscript][$key][$k], $is_empty, $field, $v, $optional_fields, $int_fields);
									}
								}
							} else {
								$field	= $three_subscript;
								cainiao_get_value($doc_details[$subscript][$key], $is_empty, $field, $val, $optional_fields, $int_fields);
							}
						}
					}
					break;
				case in_array($subscript, $_sub_key)://一维明细，例：订单发货地址等
					foreach ($sub as $field) {
						cainiao_get_value($doc_details[$subscript], $is_empty, $field, $data[$subscript], $optional_fields, $int_fields);
					}
					break;
				default :
					$field	= $subscript;
					cainiao_get_value($doc_details, $is_empty, $field, $data, $optional_fields, $int_fields, $_detail_fields);
					break;
			}
		}
		if ($is_empty){
			return array();
		}
		return $doc_details;
	}

	/**
	 *
	 * @param array $result
	 * @param array $data
	 * @param array $_optional_fields
	 * @param boolean $need_flip
	 */
	function cainiao_optional_fields_process(&$result, $data, $_optional_fields, $need_flip = false){
		$exists_fields		= cainiao_get_exists_fields($data, $_optional_fields, $need_flip);
		foreach ($exists_fields as $filed=>$key) {
			$result[$key]		= $data[$filed];
		}
	}

	/**
	 *
	 * @param array $data
	 * @param array $_optional_fields
	 * @param boolean $need_flip
	 * @param boolean $is_exists
	 * @return array
	 */
	function cainiao_get_exists_fields($data, $_optional_fields, $need_flip = false, $is_exists = true){
		$optional_fields	= cainiao_get_array_string_element($_optional_fields);
		if ($need_flip) {
			$optional_fields	= array_flip($optional_fields);
		}
		$exists_fields		= array();
		$not_exists_fields	= array();
		foreach ($optional_fields as $filed=>$key) {
			if (array_key_exists($filed, $data)) {
				$exists_fields[$filed]	= $key;
			} else {
				$not_exists_fields[$filed]	= $key;
			}
		}
		return $is_exists ? $exists_fields : $not_exists_fields;
	}

	/**
	 *
	 * @param array $data
	 * @param array $_optional_fields
	 * @param boolean $need_flip
	 * @return string
	 */
	function cainiao_get_not_exists_fields_string($data, $_optional_fields, $need_flip = false){
		$not_exists_fields	= cainiao_get_exists_fields($data, $_optional_fields, $need_flip, false);
		return !empty($not_exists_fields) ? ',' . implode(',', array_keys($not_exists_fields)) : '';
	}

	/**
	 *
	 * @param array $array
	 * @return array
	 */
	function cainiao_get_array_string_element($array){
		$string_array	= array();
		foreach ($array as $key => $val) {
			if (is_string($val)) {
				$string_array[$key]	= $val;
			}
		}
		return $string_array;
	}

	/**
	 * 模型数据验证
	 * @param array $DocInfo
	 * @param string $return_error
	 * @param array $vasd
	 * @return boolean
	 */
	function cainiao_get_model_valid(&$DocInfo, &$return_error, $vasd = array(), $key_prefix = ''){
		$_POST					= $DocInfo;
		if (empty($_POST['module_name'])) {
			$_POST['module_name']	= CAINIAO_MODULE_NAME;
		}
		if (empty($_POST['method_name'])) {
			$_POST['method_name']	= CAINIAO_ACTION_NAME;
		}
		$model					= D($_POST['module_name']);
		$model->setModuleInfo($_POST['module_name'], $_POST['method_name']);
		if (!empty($vasd)) {
			$model->mergeProperty('_validate', $vasd);
		}
		$model->isAjax	= true;
		if (method_exists($model, 'setPost')) {
			$DocInfo	= $model->setPost();
		}
		$validData		= $model->create($DocInfo);
		$result			= true;
		if($validData === false){
			cainiao_get_model_error($model, $return_error, $key_prefix);
			$result		= false;
		} else {
			$detail_keys	= C('CAINIAO_' . parse_name($_POST['module_name']) . '_DETAIL_KEYS');
			if (!empty($detail_keys) && is_array($detail_keys)) {
				foreach ($detail_keys as $key => $label) {
					if (empty($validData[$key])) {
						$return_error[]	= $label . '明细' . L('require');
						$result			= false;
					}
				}
			}
			$DocInfo	= $validData;
		}
		return $result;
	}

	/**
	 * 反馈报文接收状态
	 * @param int $request_id
	 * @param string $reason 错误编码
	 * @param string $desc 错误描述
	 * @return array
	 */
	function cainiao_make_response_xml($request_id, $reason = '', $desc = ''){
		if (cainiao_has_error($reason)) {//失败时返回错误编号
			$response		= array(
								'success'		=> 'false',//*//状态 true：成功 false：失败
								'errorCode'		=> $reason,
							);
		} else {
			$response		= array(
								'success'		=> 'true',//*//状态 true：成功 false：失败
							);
		}
		$response['errorMsg']	= $desc;
		$response['request_id']	= $request_id;
		return $response;
	}

	/**
	 * 明细验证产品ID大于0
	 * @param array $detail
	 * @param string $return_error
	 * @param string $key
	 */
	function cainiao_valid_detail_product(&$detail, &$return_error, $key = 'product_id'){
		//产品sku验证
		$product_label	= $key == 'product_son_id' ? '子产品' : '产品';
		foreach ($detail as $k => $product){
			if ($product[$key] <= 0) {
				$return_error[] = $product_label . ': ' . $product['product_no'] . '不存在';
				unset($detail[$k]);
			}
		}
	}


	/**
	 * 明细验证箱号存在
	 * @param array $DocInfo
	 * @param string $return_error
	 */
	function cainiao_valid_detail_box($DocInfo, &$return_error){
		foreach ($DocInfo['product'] as $product) {
			if (empty($product['box_no'])) {
				$return_error[]	=  $product['product_no'] . ': ' . L('box_no') . '不存在';
			}
		}
	}