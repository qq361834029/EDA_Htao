<?php

/**
 * dhl api 公共函数库
 * @category   Think
 * @package  Common
 * @author   jph 
 * @version  $Id$
 */

	/**
	 * 获取请求数据
	 * @return array
	 */
	function dhl_get_need_request_order($request_type = 'createShipmentDD'){
		$default_where	= array(
			'request_type'	=> $request_type,
		);
		if ($_GET['dhl_list_id'] > 0) {
			$default_where['id']		= $_GET['dhl_list_id'];
		}
		if ($_GET['object_id'] > 0) {
			$default_where['object_id']	= $_GET['object_id'];
		}
		if (!empty($_GET['object_no'])) {
			$default_where['object_no']	= $_GET['object_no'];
		}
		$limit			= dhl_get_request_limit($request_type);
		$dhl_list		= express_api_get_need_request('DHL', $default_where, $limit);
		$func_name		= 'dhl' . ucfirst($request_type);
		return $func_name($dhl_list);
	}

	/**
	 * 执行请求前将状态置为请求，以防重复执行
	 * @param array $ids
	 */
	function dhl_set_requesting($ids) {
		$where			= express_api_get_need_request_where();
		$where['id']	= array('in', $ids);
		$data			= array(
			'request_status'	=> EXPRESS_API_REQUEST_STATUS_REQUESTING,
			'last_request_time'	=> date('Y-m-d H:i:s'),
		);
		return M('DhlList')->where($where)->setField($data);
	}

	function dhl_get_request_limit($request_type){
		switch ($request_type) {
			case 'createShipmentDD':
				$type	= 'CREATE';
				break;			
			case 'updateShipmentDD':
				$type	= 'UPDATE';
				break;			
			case 'deleteShipmentDD':
				$type	= 'DELETE';
				break;
		}
		$type			.= '_LIMIT';
		$default_limit	= C('DHL_SANDBOX') === true ? C('DHL_SANDBOX_CONFIG.' . $type) : C('DHL_CONFIG.' . $type);
		$limit			= $_GET['limit'];
		if ($limit <= 0 || $limit > $default_limit) {
			$limit	= $default_limit;
		}
		if ($limit <= 0) {
			$limit	= 1;
		}
		if ($request_type == 'updateShipmentDD') {
			$limit	= 1;
		}
		return (int)$limit;
	}


	/**
	 * @param string $request_type
	 * @param int $limit
	 * @param boolean $debug
	 */
	function dhl_process_request($request_type = 'createShipmentDD'){
		$sale_order_list	= dhl_get_need_request_order($request_type);
		if (!empty($sale_order_list)) {
			addLang(array('Dhl', 'SaleOrder'));
			$ids					= array();
			foreach ($sale_order_list as $sale_order) {
				$ids[]	= $sale_order['dhl_list_id'];
			}
			dhl_set_requesting($ids);
			$model			= dhl_request($sale_order_list, $request_type);
			$dhl_log		= $model->getProperty('dhl_log');
			$sale_list		= $model->getProperty('sale_list');
			$dhlList		= M('DhlList');
			$saleOrder		= D('SaleOrder');
			$saleOrderDel	= D('SaleOrderDel');
			$dhl_list		= array();
			$sale_ids		= array();
			//开启事务
			startTrans();
			foreach ($dhl_log['detail'] as $sale_id => $detail) {
				$dhl_list_id	= $detail['dhl_list_id'];
				switch ($dhl_log['request_status']) {
					case 'true':
						switch ($detail['request_status']) {
							case 'true':
								$data		= array(
									'id'				=> $dhl_list_id,
									'request_status'	=> EXPRESS_API_REQUEST_STATUS_SUCCESSFUL,
								);				
								$sale_ids[]	= $sale_id;
								$sale		= array(
									'id'			=> $sale_id,
								);
								switch ($request_type) {
									case 'createShipmentDD':
									case 'updateShipmentDD':
										$data['shipmentNumber']	= $detail['shipmentNumber'];
										$data['Labelurl']		= $detail['Labelurl'];
										$sale['track_no']		= $detail['shipmentNumber'];
										$sale['Labelurl']		= $detail['Labelurl'];
										$sale['api_checksum']	= $sale_list[$sale_id]['api_checksum'];
										if ($request_type == 'updateShipmentDD') {
											$sale['track_no_update_tips']	= 1;
										}
										break;
									case 'deleteShipmentDD':
										$sale['track_no']		= '';
										$sale['Labelurl']		= '';
										$sale['api_checksum']	= '';
										break;
								}
								$dhlList->save($data);
								if ($saleOrder->where(array('id' => $sale_id))->count() > 0) {
									$saleOrder->save($sale);
								} else {
									$saleOrderDel->save($sale);
								}
								break;
							case 'false':
								$dhl_list[EXPRESS_API_REQUEST_STATUS_FAILED][]		= $dhl_list_id;
								break;
							case 'abnormal':
								$dhl_list[EXPRESS_API_REQUEST_STATUS_ABNORMAL][]	= $dhl_list_id;
								break;
							case 'cancel':
								$dhl_list[EXPRESS_API_REQUEST_STATUS_CANCELLED][]	= $dhl_list_id;
								break;
						}
						break;
					case 'false':
						if ($detail['request_status'] == 'cancel') {
							$dhl_list[EXPRESS_API_REQUEST_STATUS_CANCELLED][]	= $dhl_list_id;
						} else {
							$dhl_list[EXPRESS_API_REQUEST_STATUS_FAILED][]		= $dhl_list_id;
						}
						break;
					case 'abnormal':
						if ($detail['request_status'] == 'cancel') {
							$dhl_list[EXPRESS_API_REQUEST_STATUS_CANCELLED][]	= $dhl_list_id;
						} else {
							$dhl_list[EXPRESS_API_REQUEST_STATUS_ABNORMAL][]	= $dhl_list_id;
						}
						break;
				}
			}
			foreach ($dhl_list as $request_status => $dhl_list_id) {
				$dhlList->where(array('id' => array('in', $dhl_list_id)))->setField('request_status', $request_status);
			}
			if ($sale_ids) {
				switch ($request_type) {
					case 'createShipmentDD'://如果订单状态为待处理，则更新为导出中状态
					case 'updateShipmentDD':
						$old_sale_order_state	= C('SALE_ORDER_STATE_PENDING');
						$new_sale_order_state	= C('SALE_ORDER_STATE_EXPORTING');
						$state_log_comments		= L('dhl_create_shipment');
						break;
					case 'deleteShipmentDD':
						$old_sale_order_state	= C('SALE_ORDER_STATE_EXPORTING');
						$new_sale_order_state	= C('SALE_ORDER_STATE_EDITING');
						$state_log_comments		= L('dhl_delete_shipment');
						break;
				}
				if ($new_sale_order_state) {
					$sale_where		= array(
										'sale_order_state'	=> $old_sale_order_state,
										'id'				=> array('in', $sale_ids),
					);
					$ids			= $saleOrder->where($sale_where)->getField('id', true);
					$saleOrder->updateSaleOrderStateById($ids, $new_sale_order_state, $state_log_comments);
				}
			}
			commit();
			return $model;
		}
	}

	/**
	 * dhl 请求
	 * @param array $data
	 * @return array
	 */
	function dhl_request($sale_order_list, $request_type = 'createShipmentDD'){
		$module			= 'Dhl' . ucfirst(preg_replace('/[A-Z]+$/', '', $request_type));
		$model			= D($module);
		$model->process($sale_order_list, $request_type);
		return $model;
	}

	/**
	 * createShipmentDD 获取请求数据
	 * @param array $dhl_list
	 * @return array
	 */
	function dhlCreateShipmentDD($dhl_list){
		if (empty($dhl_list)) {
			return array();
		}
		$sale_order_id		= array_keys($dhl_list);
		$sale_order_list	= express_api_get_sale_order_info('DHL', $sale_order_id);
		$cancel_sale_list	= array();
		foreach ($dhl_list as $sale_id => $val) {
			if ($sale_order_list[$sale_id]) {
				$sale_order_list[$sale_id]	= array_merge($val, $sale_order_list[$sale_id]);
			} else {
				$cancel_sale_list[]	= $sale_id;
			}
		}
		if (!empty($cancel_sale_list)) {//因异常原因导致：订单已不是dhl订单或已被删除/作废/订单状态变为编辑中等，却并未取消新增请求的记录，在此再次重新取消请求
			express_api_cancel_request('DHL', $cancel_sale_list);
		}
		if (empty($sale_order_list)) {
			return array();
		}
		return $sale_order_list;
	}

	/**
	 * createShipmentDD 获取请求数据
	 * @param array $dhl_list
	 * @return array
	 */
	function dhlDeleteShipmentDD($dhl_list){
		if (empty($dhl_list)) {
			return array();
		}
		$sale_order_id		= array_keys($dhl_list);
		$where				= express_api_created_sale_order_where('s');
		$where['s.id']		= array('in', $sale_order_id);
		$field				= 's.id as sale_order_id, s.sale_order_no, s.track_no, s.Labelurl';
		$join				= 'inner join __DHL_LIST__ list on list.object_id=s.id';
		$sale_order_sql		= M('SaleOrder')->alias('s')->join($join)->where($where)->field($field)->buildSql();
		$sale_order_del_sql	= M('SaleOrderDel')->alias('s')->join($join)->where($where)->field($field)->buildSql();
		$sql				= 'SELECT * FROM (' . $sale_order_sql . ' UNION ALL ' . $sale_order_del_sql . ') tmp';
		$rs					= M()->query($sql);
		$sale_order_list	= resetArrayIndex($rs, 'sale_order_id');
		$cancel_sale_list	= array();
		foreach ($dhl_list as $sale_id => $val) {
			if ($sale_order_list[$sale_id]) {
				$sale_order_list[$sale_id]	= array_merge($val, $sale_order_list[$sale_id]);
			} else {
				$cancel_sale_list[]	= $sale_id;
			}
		}
		if (!empty($cancel_sale_list)) {//因异常原因导致：订单track_no或Labelurl缺失，在此再次重新取消请求
			express_api_cancel_request('DHL', $cancel_sale_list);
		}
		if (empty($sale_order_list)) {
			return array();
		}
		return $sale_order_list;
	}


	/**
	 * updateShipmentDD 获取请求数据
	 * @param array $dhl_list
	 * @return array
	 */
	function dhlUpdateShipmentDD($dhl_list){
		if (empty($dhl_list)) {
			return array();
		}
		$sale_order_id		= array_keys($dhl_list);
		$sale_order_list	= express_api_get_sale_order_info('DHL', $sale_order_id);
		$cancel_sale_list	= array();
		foreach ($dhl_list as $sale_id => $val) {
			if ($sale_order_list[$sale_id]) {
				$sale_order_list[$sale_id]	= array_merge($val, $sale_order_list[$sale_id]);
			} else {
				$cancel_sale_list[]	= $sale_id;
			}
		}
		if (!empty($cancel_sale_list)) {//因异常原因导致：订单已不是dhl订单或已被删除/作废/订单状态变为编辑中等，却并未取消新增请求的记录，在此再次重新取消请求
			express_api_cancel_request('DHL', $cancel_sale_list);
		}
		if (empty($sale_order_list)) {
			return array();
		}
		return $sale_order_list;
	}