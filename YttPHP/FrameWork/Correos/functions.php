<?php

/**
 * correos api 公共函数库
 * @category   Think
 * @package  Common
 * @author   jph 
 * @version  $Id$
 */

	/**
	 * 获取请求数据
	 * @return array
	 */
	function correos_get_need_request_order($request_type = 'createShipmentDD'){
		$default_where	= array(
			'request_type'	=> $request_type,
		);
		if ($_GET['correos_list_id'] > 0) {
			$default_where['id']		= $_GET['correos_list_id'];
		}
		if ($_GET['object_id'] > 0) {
			$default_where['object_id']	= $_GET['object_id'];
		}
		if (!empty($_GET['object_no'])) {
			$default_where['object_no']	= $_GET['object_no'];
		}
		$correos_list	= express_api_get_need_request('CORREOS', $default_where);
		$func_name		= 'correos' . ucfirst($request_type);
		return $func_name(reset($correos_list));
	}

	/**
	 * 执行请求前将状态置为请求，以防重复执行
	 * @param array $ids
	 */
	function correos_set_requesting($ids) {
		$where			= express_api_get_need_request_where();
		$where['id']	= array('in', $ids);
		$data			= array(
			'request_status'	=> EXPRESS_API_REQUEST_STATUS_REQUESTING,
			'last_request_time'	=> date('Y-m-d H:i:s'),
		);
		return M('CorreosList')->where($where)->setField($data);
	}

	/**
	 * @param string $request_type
	 * @param int $limit
	 * @param boolean $debug
	 */
	function correos_process_request($request_type = 'createShipmentDD'){
		$sale_order	= correos_get_need_request_order($request_type);
		if (!empty($sale_order)) {
			addLang(array('Correos', 'SaleOrder'));
			$sale_id		= $sale_order['object_id'];
			$correos_list_id= $sale_order['correos_list_id'];
			correos_set_requesting($correos_list_id);
			$model			= correos_request($sale_order, $request_type);
			$correos_log	= $model->getProperty('correos_log');
			$sale			= $model->getProperty('sale');
			$correosList	= M('CorreosList');
			$saleOrder		= D('SaleOrder');
			$saleOrderDel	= D('SaleOrderDel');
			//开启事务
			startTrans();
			switch ($correos_log['request_status']) {
				case 'true':
					$request_status	= EXPRESS_API_REQUEST_STATUS_SUCCESSFUL;
					$data			= array(
						'id'	=> $sale_id,
					);
					switch ($request_type) {
						case 'createShipmentDD':
						case 'updateShipmentDD':
							$correos				= array(
								'id'				=> $correos_list_id,
								'shipmentNumber'	=> $correos_log['shipmentNumber'],
								'Labelurl'			=> $correos_log['Labelurl'],
							);
							$correosList->save($correos);
							$data['track_no']			= $correos_log['shipmentNumber'];
							$data['Labelurl']			= $correos_log['Labelurl'];
							$data['api_checksum']		= $sale['api_checksum'];
							if ($request_type == 'updateShipmentDD') {
								$data['track_no_update_tips']	= 1;
							}
							//如果订单状态为待处理，则更新为导出中状态
							$old_sale_order_state	= C('SALE_ORDER_STATE_PENDING');
							$new_sale_order_state	= C('SALE_ORDER_STATE_EXPORTING');
							$state_log_comments		= L('correos_create_shipment');
							break;
						case 'deleteShipmentDD':
							$data['track_no']		= '';
							$data['Labelurl']		= '';
							$data['api_checksum']	= '';
							$old_sale_order_state	= C('SALE_ORDER_STATE_EXPORTING');
							$new_sale_order_state	= C('SALE_ORDER_STATE_EDITING');
							$state_log_comments		= L('correos_delete_shipment');
							break;
					}
					if ($saleOrder->where(array('id' => $sale_id))->count() > 0) {
						$saleOrder->save($data);
					} else {
						$saleOrderDel->save($data);
					}
					$sale_where	= array(
						'sale_order_state'	=> $old_sale_order_state,
						'id'				=> $sale_id,
					);
					$id			= $saleOrder->where($sale_where)->getField('id');
					$saleOrder->updateSaleOrderStateById($id, $new_sale_order_state, $state_log_comments);
					break;
				case 'false':
					$request_status	= EXPRESS_API_REQUEST_STATUS_FAILED;
					break;
				case 'abnormal':
					$request_status	= EXPRESS_API_REQUEST_STATUS_ABNORMAL;
					break;
				case 'cancel':
					$request_status	= EXPRESS_API_REQUEST_STATUS_CANCELLED;
					break;
			}
			$correosList->where(array('id' => $correos_list_id))->setField('request_status', $request_status);
			commit();
			return $model;
		}
	}

	/**
	 * correos 请求
	 * @param array $data
	 * @return array
	 */
	function correos_request($sale_order, $request_type = 'createShipmentDD'){
		$module			= 'Correos' . ucfirst(preg_replace('/[A-Z]+$/', '', $request_type));
		$model			= D($module);
		$model->process($sale_order, $request_type);
		return $model;
	}

	/**
	 * createShipmentDD 获取请求数据
	 * @param array $correos
	 * @return array
	 */
	function correosCreateShipmentDD($correos){
		if (empty($correos)) {
			return array();
		}
		$sale_order_id	= $correos['object_id'];
		$sale			= express_api_get_sale_order_info('CORREOS', $sale_order_id);
		if ($sale) {
			return array_merge($correos, $sale);
		} else {//因异常原因导致：订单已不是correos订单或已被删除/作废/订单状态变为编辑中等，却并未取消新增请求的记录，在此再次重新取消请求
			express_api_cancel_request('CORREOS', $sale_order_id);
			return array();
		}
	}

	/**
	 * createShipmentDD 获取请求数据
	 * @param array $correos
	 * @return array
	 */
	function correosDeleteShipmentDD($correos){
		if (empty($correos)) {
			return array();
		}
		$sale_order_id		= $correos['object_id'];
		$where				= express_api_created_sale_order_where('s');
		$where['s.id']		= $sale_order_id;
		$field				= 's.id as sale_order_id, s.sale_order_no, s.track_no, s.Labelurl';
		$join				= 'inner join __CORREOS_LIST__ list on list.object_id=s.id';
		$sale_order_sql		= M('SaleOrder')->alias('s')->join($join)->where($where)->field($field)->buildSql();
		$sale_order_del_sql	= M('SaleOrderDel')->alias('s')->join($join)->where($where)->field($field)->buildSql();
		$sql				= 'SELECT * FROM (' . $sale_order_sql . ' UNION ALL ' . $sale_order_del_sql . ') tmp';
		$sale				= M()->queryOne($sql);
		if ($sale) {
			return	array_merge($correos, $sale);
		} else {//因异常原因导致：订单track_no或Labelurl缺失，在此再次重新取消请求
			express_api_cancel_request('CORREOS', $sale_order_id);
			return array();
		}
	}


	/**
	 * updateShipmentDD 获取请求数据
	 * @param array $correos
	 * @return array
	 */
	function correosUpdateShipmentDD($correos){
		if (empty($correos)) {
			return array();
		}
		$sale_order_id	= $correos['object_id'];
		$sale			= express_api_get_sale_order_info('CORREOS', $sale_order_id);
		if ($sale) {
			return	array_merge($correos, $sale);
		} else {
			express_api_cancel_request('CORREOS', $sale_order_id);
			return array();
		}
	}