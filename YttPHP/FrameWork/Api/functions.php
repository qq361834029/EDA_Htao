<?php

/**

 * Think 标准模式公共函数库(3.0ytt开始增加的部分)
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 */


	/**
	 * 验证卖家
	 * @param int $factory_id
	 */
	function api_valid_factory(){
		$factory_id	= C('API_FACTORY_ID');
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
		api_session_user_info($authInfo);
		return 1;
	}

	/**
	 * 获取卖家id
	 * @return int
	 */
	function api_set_factory_id($actionXmlData){
		$where			= array(
							'comp_type'		=> C('API_DEFAULTCONFIG_COMP_TYPE'),
							'to_hide'		=> 1,
							'email'			=> trim($actionXmlData['User']),
							'auth_status'	=> 1,//授权码启用状态
						);
		$factory_id		= (int)M('Company')->where($where)->getField('id');
		C('API_FACTORY_ID', $factory_id);
	}

	/**
	 *
	 * @return string
	 */
	function api_ob_get_clean(){
		$ob_get_clean	= trim(ob_get_clean());
		return $ob_get_clean ? htmlspecialchars_decode($ob_get_clean) : '';
	}

	/**
	 * 获取Api Xml 保存文件名
	 * @param type $id
	 * @param type $request_time
	 * @return string
	 */
	function api_get_xml_file_name($id, $request_time){
		$path	= DATA_PATH . 'ApiXml/'.date('Ymd', strtotime($request_time)) . '/' . API_NAME . '/';
		mk_dir($path);
		@chmod($path, 0777);
		return	$path . $id . '.log';
	}

	/**
	 * 增加错误信息
	 * @param mixed &$error
	 * @param mixed $add_err
	 * @return array $error
	 */
	function api_add_error(&$error, $add_err){
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
                if(is_array($err)){
                    foreach($err as $err_value){
                        $error[]	= $err_value;
                    }
                }else{
                    $error[]	= $err;
                }
			}
		}
		if ($to_str === true) {
			$error	= api_err_string($error);
		}
	}

	/**
	 * 错误信息数组转字符串
	 * @param mixed $error
	 * @return string
	 */
	function api_err_string($error){
		return is_array($error) ? implode("\r\n", array_filter($error)) : $error;
	}

	/**
	 *
	 * @param type $model
	 * @param string $return_error
	 * @param type $tips
	 */
	function api_get_model_error($model, &$return_error) {
		$error_data = $model->getError();
		if (is_array($error_data)) {
			$tips	= C(API_PARSE_MODULE_NAME . '_IMPORT_TIPS');
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
						$return_error[$error['name']] = '第' . ($matches[$count_key] + $sub_inc) .'行' . C('API_' . API_PARSE_MODULE_NAME . '_DETAIL_KEYS.' . $matches[$field_key]) . '明细['. $name . ']: ' . $error['value'];
					}
				} else {
					$return_error[$error['name']] = ($tips[$error['name']] ? $tips[$error['name']] : L($error['name'])).': '.$error['value'];
				}
			}
		} else {
			$return_error[]	= $error_data;
		}
	}

	/**
	 *
	 * @param type $detail
	 * @param type $error_type
	 * @param type $error_msg
	 * @param type $real_error_msg
	 * @param type $return_error
	 */
	function api_get_valid_detail_error(&$detail, $error_type, $error_msg, $real_error_msg, $return_error){
		if (!empty($return_error)) {
			$error_type		= API_ERRORTYPE_DATA_VERIFY_FAILED;
			$error_msg		= $return_error;
			api_add_error($real_error_msg, $return_error);
		}
		if (!empty($real_error_msg)) {
			C('API_DEBUG') === 1 && $error_msg	= $real_error_msg;
		}
		$detail['ErrorCode']		= $error_type;
		$detail['ErrorMessage']		= $error_msg;
		$detail['RealErrorMessage']	= empty($real_error_msg) ? $error_msg : $real_error_msg;
	}

	/**
	 *
	 * @param type $detail
	 * @param type $error_type
	 * @param type $error_msg
	 * @param type $real_error_msg
	 * @param type $api
	 */
	function api_get_detail_error(&$detail, $error_type, $error_msg, $real_error_msg, $api, $label_field){
		if (!empty($real_error_msg)) {
			$api->addRealErrorMsg($detail[$label_field] . ': ');
			$api->addRealErrorMsg($real_error_msg);
			C('API_DEBUG') === 1 && $error_msg	= $real_error_msg;
		}
		if (!empty($error_msg)) {
			if (C('API_DEBUG') !== 1) {
				$api->addErrorMsg($detail[$label_field] . ': ');
			}
			$api->addErrorMsg($error_msg);
		}
		$detail['Ack']			= $api->getErrorStatus($error_type);
		$detail['ErrorCode']	= $error_type;
		$detail['ErrorMessage']	= empty($error_msg) ? $api->getError($error_type) : api_err_string($error_msg);
		$api->setErrorTypeByDetail($error_type);
	}

	function api_get_detail_init_error(&$detail){
		$init_error	= array(
					'error_type'		=> $detail['ErrorCode'],
					'error_msg'			=> !empty($detail['ErrorMessage']) ? (array)$detail['ErrorMessage'] : array(),
					'real_error_msg'	=> !empty($detail['RealErrorMessage']) ? (array)$detail['RealErrorMessage'] : array(),
				);
		unset($detail['ErrorCode'], $detail['ErrorMessage'], $detail['RealErrorMessage']);
		return $init_error;
	}

	/**
	 * 返回行号信息
	 * @param int $line 行号
	 * @return string
	 */
	function api_line($line){
		return '(行号:' . $line . ')';
	}

	/**
	 * 获取authToken
	 * @param array $actionXmlData
	 * @return string
	 */
	function api_set_debug($actionXmlData){
		$debug	= intval($actionXmlData['Debug']);
		C('API_DEBUG', $debug);
	}

	/**
	 * 调试打印数据
	 * @param mixed $data
	 * @param bool $exit
	 */
	function api_dump($data, $exit = false){
		if (C('API_DEBUG') === 1) {
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
	function api_session_user_info($authInfo){
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
	function api_brf($method_name, $params){
		/// 业务规则检查
		$all_tags			= C('extends');
		$action_tag_name	= API_MODULE_NAME.'&'.$method_name;
		if (isset($all_tags[$action_tag_name])) {
			$params['method_name']	= $method_name;
			tag($action_tag_name, $params);
		}
	}

	/**
	 * 产品子sku验证
	 * @param array $ProductInfo
	 * @param array $return_error
	 */
	function api_valid_product_son(&$ProductInfo, &$return_error){
		if (C('multiple_product_type') != 1 || $ProductInfo['product_type'] != C('PRODUCT_TYPE_COMBINATION_PRODUCT')) {//非组合产品直接过滤子产品明细
			$ProductInfo['product_son']	= array();
		} else {
			//产品sku验证
			if (empty($ProductInfo['product_son'])) {
				$return_error[] = '子产品：不能为空';
			} else {
				api_valid_detail_product($ProductInfo['product_son'], $return_error, 'product_son_id');
			}
		}
	}

	/**
	 * 生成本地数据签名
	 * @author jph 20160510
	 * @param string $requestXml 报文xml
	 * @param type $auth_token
	 * @return string
	 */
	function api_get_data_digest($requestXml, $auth_token){
		$data_digest	= md5(substr($auth_token, 0, 16) . $requestXml . substr($auth_token, 16, 16));
		return $data_digest;
	}

	/**
	 * 验证处理单号
	 * @author jph 20141022
	 * @param string $processNo
	 * @return boolean.
	 */
	function api_valid_process_no($processNo){
		if (empty($processNo) || preg_match('/^DD\d{10,11}$/i', $processNo) == 0){
			return false;
		}
		return true;
	}

	/**
	 * 验证退货处理单号
	 * @author jph 20150728
	 * @param string $returnProcessNo
	 * @return boolean.
	 */
	function api_valid_return_process_no($returnProcessNo){
		if (empty($returnProcessNo) || preg_match('/^RT\d{10}$/i', $returnProcessNo) == 0){
			return false;
		}
		return true;
	}

    /**
	 * 验证发货处理单号
	 * @author yyh 20151118
	 * @param string $returnProcessNo
	 * @return boolean.
	 */
	function api_valid_instock_no($returnProcessNo){
		if (empty($returnProcessNo) || preg_match('/^JH\d{10}/i', $returnProcessNo) == 0){
			return false;
		}
		return true;
	}
    
	function api_valid_product_id($product_id){
		if (empty($product_id) || preg_match('/^[1-9]\d*$/', $product_id) == 0){
			return false;
		}
		return true;
	}
	
	/**
	 * 验证产品sku
	 * @author jph 20150706
	 * @param string $sku
	 * @return boolean.
	 */
	function api_valid_sku($sku){
		if (empty($sku)){
			return false;
		}
		return true;
	}

	/**
	 * 验证仓库编号
	 * @author jph 20151028
	 * @param string $WarehouseNo
	 * @return boolean.
	 */
	function api_valid_warehouse_no($WarehouseNo){
		if (empty($WarehouseNo) || preg_match('/^[0-9a-zA-Z]{1,2}$/', $WarehouseNo) == 0){
			return false;
		}
		return true;
	}

	/**
	 *
	 * @param string $msg
	 * @param object $ex
	 * @return array
	 */
	function api_set_abnormal_error($msg, $ex = null){
		$error	= array(
					$msg,
					$ex->getMessage(),
					api_ob_get_clean()
				);
		return $error;
	}

	/**
	 * 每页数量
	 * @param type $actionXmlData
	 */
	function api_get_items_per_page($actionXmlData){
		$ItemsPerPage	= intval($actionXmlData['ItemsPerPage']);
		if ($ItemsPerPage <= 0) {
			$ItemsPerPage	= API_RESPONSECONFIG_DEFAULT_ITEMSPERPAGE;
		}
		if ($ItemsPerPage > API_RESPONSECONFIG_MAX_ITEMSPERPAGE) {
			$ItemsPerPage	= API_RESPONSECONFIG_MAX_ITEMSPERPAGE;
		}
		return $ItemsPerPage;
	}

	/**
	 * 当前页码
	 * @param type $actionXmlData
	 */
	function api_get_page_number($actionXmlData){
		return (int)($actionXmlData['PageNumber'])>0 ? (int)($actionXmlData['PageNumber']) : 1;
	}
	
	/**
	 * 获取日期
	 * @param array $date
	 * @return array
	 */
	function api_get_date($date, $is_time = false){
        $is_time_str    = $is_time ? ' H:i:s' : '';
        if((validateDate($date,'Y-m-d'.$is_time_str) || validateDate($date,'d/m/Y'.$is_time_str)) && checkdateDate($date,$is_time)){
                if(strpos($date,'/')){//支持欧洲格式 日/月/年
                    $date	= preg_replace('/([0-3]\d)\/([0-1]\d)\/(\d{4}|\d{2})/', '$3-$2-$1', $date);
                }
                $dateTime	= strtotime($date);
                if ($dateTime == false || $dateTime == -1){
                    return '';
                }
            return date('Y-m-d' . $is_time_str, $dateTime);
        }
        return '';
	}

	/**
	 * 获取列表
	 * @param mixed $list
	 * @return array
	 */
	function  api_get_doc_list($list){
		if (!is_array($list) || empty($list)) {
			$list	= array();
		}elseif (!isset($list[0])){//单个元素处理
			$list	= array($list);
		}
		$make_function	= 'api_make_' . API_PARSE_MODULE_NAME . '_details';
		foreach ($list as $key =>$details){
			$details	= api_get_doc_details($details);
			if (!empty($details)) {
				$list[$key]	= $make_function($details);
			} else {
				unset($list[$key]);
			}
		}
		return $list;
	}

	/**
	 * 验证列表信息有效性
	 * @param array $list
	 * @param string $verif_fun
	 * @return boolean
	 */
	function api_get_invalid_of_list(&$list, $verif_fun = '', $delete_invalid = false){
		if (empty($list)) {
			$list	= array();
		} elseif (is_string($list)) {//单个产品SKU处理
			$list	= array($list);
		}
		$invalid	= count($list) > 0 ? true : false;//用于验证明细是否全部无效
		foreach ($list as $key =>$val){
			$val	= trim($val);
			if ((!empty($verif_fun) && function_exists($verif_fun) && $verif_fun($val)) || ((empty($verif_fun) || !function_exists($verif_fun)) && !empty($val))) {
				$invalid	= false;
				$list[$key]	= $val;
			} else {
				if ($delete_invalid) {
					unset($list[$key]);
				}
			}
		}
		$list	= array_unique($list);
		return $invalid;
	}

	function api_array_to_list(&$data, $key, $sub_key = array()){
		$keys	= is_array($key) ? $key : explode(',', $key);
		foreach ($keys as $key) {
			$key	= trim($key);
			if (empty($key)) {
				continue;
			}
			if (!is_array($data[$key]) || empty($data[$key])) {
				$data[$key]	= array();
			}elseif (!isset($data[$key][0])){//单个处理
				$data[$key]	= array($data[$key]);
			}
			if (!empty($data[$key]) && isset($sub_key[$key])) {
				foreach ($data[$key] as &$val) {
					api_array_to_list($val, $sub_key);
				}
			}
		}
	}

	function api_get_format_value($value, $field, $int_fields){
		return in_array($field, $int_fields) ? intval($value) : trim($value);
	}
	
	function api_get_value(&$data, &$is_empty, $field, $val, $optional_fields, $int_fields, $detail_fields = array()){
		//非必填字段过滤
		if (!array_key_exists($field, $val) && (array_key_exists($field, $optional_fields) || array_key_exists($field, $detail_fields))) {
			return;
		}
		if (!empty($val[$field])) {
			$is_empty	= false;
		}
		$data[$field]	= api_get_format_value($val[$field], $field, $int_fields);
	}


	/**
	 * 获取单据明细
	 * @param mixed $data
	 * @return array
	 */
	function  api_get_doc_details($data){
		if (!is_array($data) || empty($data)) {
			return array();
		}
		$doc_details		= array();
		$is_empty			= true;
		$_fields			= (array)C('API_' . API_PARSE_MODULE_NAME . '_FIELDS');
		$_detail_fields		= (array)C('API_' . API_PARSE_MODULE_NAME . '_DETAIL_FIELDS');
		$_int_fields		= (array)C('API_' . API_PARSE_MODULE_NAME . '_INT_FIELDS');
		$_optional_fields	= (array)C('API_' . API_PARSE_MODULE_NAME . '_OPTIONAL_FIELDS');
		$_sub_key			= (array)C('API_' . API_PARSE_MODULE_NAME . '_SUB_KEY');
		$_sub_keys			= (array)C('API_' . API_PARSE_MODULE_NAME . '_SUB_KEYS');
		$_third_sub_keys	= (array)C('API_' . API_PARSE_MODULE_NAME . '_THIRD_SUB_KEYS');
		api_array_to_list($data, $_sub_keys, $_third_sub_keys);
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
								foreach ($val[$three_subscript] as $k => $v) {
									foreach ($third as $field) {
										api_get_value($doc_details[$subscript][$key][$three_subscript][$k], $is_empty, $field, $v, $optional_fields, $int_fields);
									}
								}
							} else {
								$field	= $three_subscript;
								api_get_value($doc_details[$subscript][$key], $is_empty, $field, $val, $optional_fields, $int_fields);
							}
						}
					}
					break;
				case in_array($subscript, $_sub_key)://一维明细，例：订单发货地址等
					foreach ($sub as $field) {
						api_get_value($doc_details[$subscript], $is_empty, $field, $data[$subscript], $optional_fields, $int_fields);
					}
					break;
				default :
					$field	= $subscript;
					api_get_value($doc_details, $is_empty, $field, $data, $optional_fields, $int_fields, $_detail_fields);
					break;
			}
		}
		if ($is_empty){
			return array();
		}
		return $doc_details;
	}

	function api_optional_fields_process(&$result, $data, $_optional_fields, $need_flip = false){
		$exists_fields		= api_get_exists_fields($data, $_optional_fields, $need_flip);
		foreach ($exists_fields as $filed=>$key) {
			$result[$key]		= $data[$filed];
		}
	}

	function api_get_exists_fields($data, $_optional_fields, $need_flip = false, $is_exists = true){
		$optional_fields	= api_get_array_string_element($_optional_fields);
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

	function api_get_not_exists_fields_string($data, $_optional_fields, $need_flip = false){
		$not_exists_fields	= api_get_exists_fields($data, $_optional_fields, $need_flip, false);
		return !empty($not_exists_fields) ? ',' . implode(',', array_keys($not_exists_fields)) : '';
	}

	function api_valid_detail_product(&$detail, &$return_error, $key = 'product_id'){
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
	 *
	 * @param array $DocInfo
	 * @param string $return_error
	 */
	function api_valid_detail_box($DocInfo, &$return_error){
		$instock_box	= array();
		foreach ($DocInfo['box'] as $box) {
			$instock_box[]	= $box['box_no'];
		}
		foreach ($DocInfo['product'] as $product) {
			if (!in_array($product['box_no'], $instock_box)) {
				$return_error[]	= L('box_no') . $product['box_no'] . ': 不存在';
			}
		}
	}

	/**
	 *
	 * @param array $array
	 * @return array
	 */
	function api_get_array_string_element($array){
		$string_array	= array();
		foreach ($array as $key => $val) {
			if (is_string($val)) {
				$string_array[$key]	= $val;
			}
		}
		return $string_array;
	}

	/**
	 *
	 * @param array $DocInfo
	 * @param string $return_error
	 * @param array $vasd
	 * @return boolean
	 */
	function api_get_model_valid(&$DocInfo, &$return_error, $vasd = array()){
		$_POST					= $DocInfo;
		if (empty($_POST['module_name'])) {
			$_POST['module_name']	= API_MODULE_NAME;
		}
		$model					= D($_POST['module_name']);
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
			api_get_model_error($model, $return_error);
			$result		= false;
		} else {
			$detail_keys	= C('API_' . parse_name($_POST['module_name']) . '_DETAIL_KEYS');
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
	 * 唯一性验证信息缓存key
	 * @param string $check_field
	 * @return string
	 */
	function api_get_unique_data_key($check_field){
		return 'api_unique_data_key_' . $check_field . '_' . C('API_AUTH_TOKEN');
	}
	
	/**
	 * 缓存唯一性验证信息
	 * 解决：Api并发请求同一单据时，由于数据未插入系统，导致唯一性验证失败
	 * @param array $DocInfo 单据信息
	 * @param array $return_error 错误信息
	 * @param string $error_field 错误字段名
	 * @param string $check_field 验证字段名
	 * @param string $error_msg 错误提示语言
	 */
	function api_set_unique_data(&$DocInfo, &$return_error, $error_field, $check_field){
		if (!empty($DocInfo[$check_field]) && !array_key_exists($error_field, $return_error)) {
			$s_key	= api_get_unique_data_key($check_field);
			$s_list	= S($s_key);
			$now	= time();
			foreach ($s_list as $key => $time) {
				if ($now - $time > 5*60) {
					unset($s_list[$key]);
				}
			}
			S($s_key, $s_list);
			if (array_key_exists($DocInfo[$check_field], (array)$s_list)) {
				$return_error[$error_field]	= '该' .  L($check_field) . '已在API请求处理中，请勿重复操作或稍后重试！';
			} else {
				$s_list[$DocInfo[$check_field]]	= time();
				S($s_key, $s_list);
			}
		}
	}

	/**
	 * 删除唯一性验证信息缓存
	 * @param array $DocInfo
	 * @param string $check_field
	 */
	function api_unset_unique_data(&$DocInfo, $check_field){
		if (!empty($DocInfo[$check_field])) {
			$s_key	= api_get_unique_data_key($check_field);
			$s_list	= S($s_key);
			unset($s_list[$DocInfo[$check_field]]);
			S($s_key, $s_list);
		}
	}
	
	/**
	 * 构造单据基本信息
	 * @param array $DocInfo
	 * @return array
	 */
	function api_make_doc_basic($DocInfo){
		$DocBasic	= array(
							'Ack'		=> $DocInfo['Ack'],
							'Errors'	=> array(
												'ErrorCode'		=> $DocInfo['ErrorCode'],
												'ErrorMessage'	=> $DocInfo['ErrorMessage'],
											),
						);
		return $DocBasic;
	}

	/**
	 * 构造单据信息列表数组
	 * @param type $DocList
	 * @return array
	 */
	function api_make_doc_list($DocList, $function){
		foreach ((array)$DocList as $key => $OrderInfo) {
			$DocList[$key]	= $function($OrderInfo);
		}
		return $DocList;
	}

	function api_get_doc_list_by_doc_no(&$requestData, $key, $fields){
		if (!empty($requestData[$key]) && is_array($requestData[$key])) {
			switch ($key) {
				case 'ProcessNo':
					$field			= 'sale_order_no';
					$valid_function	= 'api_valid_process_no';
					break;
				case 'ReturnProcessNo':
					$field			= 'return_order_no';
					$valid_function	= 'api_valid_return_process_no';
					break;
				case 'SKU':
					$field			= 'product_no';
					$valid_function	= 'api_valid_sku';
					break;
                case 'InstockNo':
					$field			= 'instock_no';
					$valid_function	= 'api_valid_instock_no';
					break;
			}
			foreach ($requestData[$key] as $processNo) {
				if ($valid_function($processNo) !== false){
					$doc_no[]	= $processNo;
				}
			}
			$where		= array(
							'factory_id'	=> C('API_FACTORY_ID'),
							$field			=> array('in', $doc_no),
						);
			$doc_list	= M(API_MODULE_NAME)->where($where)->getField($field . ',' . $fields);
			foreach ($requestData[$key] as $processNo) {
				$doc							= isset($doc_list[$processNo]) ? $doc_list[$processNo] : array($field => $processNo);
				$requestData[API_DETAILS_KEY][]	= $doc;
			}
		}
	}


	/**
	 * 构造xml接口发货地址信息数组
	 * @param array $DocInfo
	 * @return array
	 */
	function api_make_xml_ship_to_address($DocInfo){
		//发货地址
		$ShipToAddress	= array(
							'CityName'			=> $DocInfo['city_name'],
							'Country'			=> $DocInfo['abbr_district_name'],
							'CountryName'		=> $DocInfo['edit_country_name'],
							'Name'				=> $DocInfo['consignee'],
							'Phone'				=> $DocInfo['mobile'],
							'PostalCode'		=> $DocInfo['post_code'],
							'StateOrProvince'	=> $DocInfo['company_name'],
							'Street1'			=> $DocInfo['edit_address'],
							'Street2'			=> $DocInfo['edit_address2'],
						);
		return $ShipToAddress;
	}