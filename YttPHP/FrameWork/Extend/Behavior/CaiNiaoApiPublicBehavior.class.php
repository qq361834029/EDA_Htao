<?php

class CaiNiaoApiPublicBehavior extends Behavior {
	private $_module	= '';
	private $_action	= '';

	public function run(&$params){
		$this->_module	= $params['_module'] ? $params['_module'] : getTrueModule();
		$this->_action	= $params['_action'] ? $params['_action'] : getTrueAction();
		$use_prc_zone	= false;//api是否使用北京时间
		if ($use_prc_zone) {
			$cur_zone	= date_default_timezone_get();
			date_default_timezone_set('PRC');
		}
		if (in_array($this->_action, array('insert','update')) || ($this->_module == 'ReturnSaleOrderStorage' && $this->_action == 'updateDeal')){
			switch ($this->_module) {
				case 'ReturnSaleOrder':
					if (cainiao_return_sale_order_id($params['id']) > 0) {
						switch ($params['return_sale_order_state']) {
							case C('RETURN_SALE_ORDER_STATE_SIGNED')://已签收
							case C('RETURN_SALE_ORDER_STATE_REFUSE')://拒收
								$this->sign($params);//签收接口
								break;
							case C('RETURN_SALE_ORDER_STATE_DROPPED')://已丢弃
								$this->innerCheckConfirm($params);//丢弃接口
								break;
						}
					}
					break;
				case 'ReturnSaleOrderStorage'://退货入库
					if (cainiao_return_sale_order_id($params['return_sale_order_id']) > 0) {
						$return_sale_order	= M('ReturnSaleOrder')->find($params['return_sale_order_id']);
						if ($this->_action == 'updateDeal') {
							switch ($return_sale_order['return_sale_order_state']) {
								case C('RETURN_SALE_ORDER_STATE_DROPPED')://已丢弃
									$this->innerCheckConfirm($return_sale_order);//丢弃接口
									break;
								case C('RETURN_FOR_DELIVERY')://退运待出库
								case C('PROCESS_COMPLETE')://处理完成
									$data						= D('ReturnSaleOrderStorage')->relation(true)->where('return_sale_order_id=' . $params['return_sale_order_id'])->find();
									$data['storage_abnormal']	= $data['storage_abnormal_reason'] ? 1 : 0;
									$product_id					= array();
									$product_info				= array();
									foreach ($data['detail'] as &$detail) {
										$detail['return_sale_order_number']	= $detail['quantity'] - $detail['drop_quantity'];
										if (!isset($product_info[$detail['product_id']])) {
											$product_id[$detail['product_id']]	= $detail['product_id'];
										}
									}
									if (!empty($product_id)) {
										$product_info	+= M('Product')->where(array('id'=>array('in',$product_id)))->getField('id,check_status,check_weight,weight');
									}
									foreach ($data['detail'] as &$detail) {
										$detail['weight']	= $product_info[$detail['product_id']]['check_weight'] == C('CHECK_STATUS_PASS') ? $product_info[$detail['product_id']]['check_weight'] : $product_info[$detail['product_id']]['weight'];
									}
									$this->inbound($data, $return_sale_order);//入库接口
									break;
							}
						} elseif(in_array($return_sale_order['return_sale_order_state'], array(C('STORAGE_ABNORMAL'), C('RETURN_SHELVES')))) {
							$this->inbound($params, $return_sale_order);//入库接口
						}
					}
					break;
				case 'PackBox'://装箱
					if($this->_action == 'update'){
						$this->packBoxOutbound($params);//出库接口
					}
					break;
				case 'OutBatch'://出库批次
					if($this->_action == 'update'){
						switch (true) {
							case $params['customs_clearance']:
								$this->gateClearCustoms($params);//清关确认接口
								break;
							case $params['associate_with']:
								$this->handover($params);//交接确认接口
								break;
							case $params['review_weight']://复核重量
								$this->outbound($params);//出库接口
								break;
						}
					}
					break;
			}
		}
		if ($use_prc_zone) {
			date_default_timezone_set($cur_zone);
		}
    }

	/**
	 *
	 * @param int $code
	 * @return string
	 */
	private function getCode($code){
		return str_pad($code, 2, '0', STR_PAD_LEFT);
	}

	/**
	 * 签收接口
	 * @param array $params
	 */
	private function sign($params) {
		$success	= $params['return_sale_order_state'] == C('RETURN_SALE_ORDER_STATE_REFUSE') ? 'false' : 'true';
		$signed		= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_SIGN', $params['return_logistics_no'], $success);
		if ($signed > 0) {
			return;
		}
		$data	= array(
					'module'				=> $this->_module,
					'action'				=> $this->_action,
					'factory_id'			=> C('CAINIAO_FACTORY_ID'),
					'logistic_provider_id'	=> C('TRAN_STORE_CODE'),
					'msg_type'				=> 'TRANSIT_WAREHOUSE_SIGN',
					'eventType'				=> 'TRANSIT_WAREHOUSE_SIGN',
					'eventTime'				=> date('Y-m-d H:i:s'),
					'eventSource'			=> C('TRAN_STORE_CODE'),
					'eventTarget'			=> C('CAINIAO_NO'),
					'logisticsOrderCode'	=> $params['return_logistics_no'],
					'occurTime'				=> date('Y-m-d H:i:s'),
					'timeZone'				=> getTimeZone(),
					'result'				=> $this->signResult($params),
				);
		cainiao_add_request($data);
	}

	/**
	 * 退货单签收状态 退货状态为拒收是签收失败
	 * 所属接口：签收接口
	 * @param array $params
	 * @return array
	 */
	private function signResult($params) {
		$result	= array();
		if ($params['return_sale_order_state'] == C('RETURN_SALE_ORDER_STATE_REFUSE')) {//拒收 即签收失败
			$result['success']	= 'false';
			$result['code']		= $this->getCode($params['refuse_reason']);
//			$result['desc']		= C('REFUSE_REASON.' . $params['refuse_reason']);
		} else {
			$result['success']	= 'true';
		}
		if (array_key_exists('desc', $params)) {
			$result['desc']		= $params['desc'];
		}
		return $result;
	}

	/**
	 * 丢弃接口
	 * @param array $params
	 */
	private function innerCheckConfirm($params) {
		$dropped						= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_INNER_CHECK_CONFIRM', $params['return_logistics_no'], 'true');
		if ($dropped > 0) {
			return;
		}
		//取消入库请求
		C(include THINK_PATH . 'CaiNiao/extendDd.php');
		$where							= cainiao_get_need_request_where();
		$where['factory_id']			= C('CAINIAO_FACTORY_ID');
		$where['msg_type']				= 'TRANSIT_WAREHOUSE_INBOUND';
		$where['logisticsOrderCode']	= $params['return_logistics_no'];
		M('CaiNiaoLog')->where($where)->setField('request_status', CAINIAO_REQUEST_STATUS_ABANDON);
		$data							= array(
					'module'				=> $this->_module,
					'action'				=> $this->_action,
					'factory_id'			=> C('CAINIAO_FACTORY_ID'),
					'logistic_provider_id'	=> C('TRAN_STORE_CODE'),
					'msg_type'				=> 'TRANSIT_WAREHOUSE_INNER_CHECK_CONFIRM',
					'eventType'				=> 'TRANSIT_WAREHOUSE_INNER_CHECK_CONFIRM',
					'eventTime'				=> date('Y-m-d H:i:s'),
					'eventSource'			=> C('TRAN_STORE_CODE'),
					'eventTarget'			=> C('CAINIAO_NO'),
					'logisticsOrderCode'	=> $params['return_logistics_no'],
					'occurTime'				=> date('Y-m-d H:i:s'),
					'timeZone'				=> getTimeZone(),
					'result'				=> $this->innerCheckConfirmResult($params),
				);
		cainiao_add_request($data);
	}

	/**
	 * 退货单丢弃状态
	 * 所属接口：丢弃接口
	 * @param array $params
	 * @return array
	 */
	private function innerCheckConfirmResult($params) {
		$result	= array(
					'success'	=> 'true',
				);
		if (array_key_exists('desc', $params)) {
			$result['desc']		= $params['desc'];
		}
		return $result;
	}

	/**
	 * 入库接口
	 * @param array $params
	 */
	protected function inbound($params, $return_sale_order = array()) {
		if (empty($return_sale_order)) {
			$return_sale_order	= M('ReturnSaleOrder')->find($params['return_sale_order_id']);
		}
		$success			= $params['storage_abnormal'] == 1 ? 'false' : 'true';
		$inbound			= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_INBOUND', $return_sale_order['return_logistics_no'], $success);
		if ($params['is_return'] !== true && $inbound > 0) {
			return;
		}
		$data				= array(
								'module'				=> $params['_module'] ? $params['_module'] : $this->_module,
								'action'				=> $params['_action'] ? $params['_action'] : $this->_action,
								'factory_id'			=> C('CAINIAO_FACTORY_ID'),
								'logistic_provider_id'	=> C('TRAN_STORE_CODE'),
								'msg_type'				=> 'TRANSIT_WAREHOUSE_INBOUND',
								'eventType'				=> 'TRANSIT_WAREHOUSE_INBOUND',
								'eventTime'				=> $params['eventTime'] ? $params['eventTime'] : date('Y-m-d H:i:s'),
								'eventSource'			=> C('TRAN_STORE_CODE'),
								'eventTarget'			=> C('CAINIAO_NO'),
								'logisticsOrderCode'	=> $return_sale_order['return_logistics_no'],
								'occurTime'				=> $params['occurTime'] ? $params['occurTime'] : date('Y-m-d H:i:s'),
								'timeZone'				=> getTimeZone(),
								'packageWeight'			=> $this->inboundPackageWeight($params),
								'weightUnit'			=> C('CAINIAO_WEIGHT_UNIT'),
								'hasBatteryOper'		=> $this->inboundHasBasBatteryOper($params),
								'result'				=> $this->inboundResult($params),
							);
		return $params['is_return'] === true ? $data : cainiao_add_request($data);
	}

	/**
	 * 退货入库单总重量 明细产品数量*重量+内包装重量*数量+外包装重量*数量
	 * 所属接口：入库接口
	 * @param array $params
	 * @return float
	 */
	private function inboundPackageWeight($params) {
		$packageWeight			= 0;
		foreach ($params['detail'] as $product) {
			$packageWeight		+= $product['return_sale_order_number'] * $product['weight'];
		}
		$hasOutPack	= $params['outer_pack'] == C('CHANGE_PACK') && $params['outer_pack_id'] > 0 && $params['outer_pack_quantity'] > 0;
		if ($hasOutPack) {//需更换外包装
			$pack_ids[$params['outer_pack_id']]		= $params['outer_pack_id'];
		}
		$hasWithinPack	= $params['within_pack'] == C('CHANGE_PACK') && $params['within_pack_id'] > 0 && $params['within_pack_quantity'] > 0;
		if ($hasWithinPack) {//需更换内包装
			$pack_ids[$params['within_pack_id']]	= $params['within_pack_id'];
		}
		if (!empty($pack_ids)) {
			$PackWeight		= M('Package')->where(array('id' => array('in', $pack_ids)))->getField('id,weight');
			$packageWeight	+= $hasOutPack ? $PackWeight[$params['outer_pack_id']] * $params['outer_pack_quantity'] : 0;
			$packageWeight	+= $hasWithinPack ? $PackWeight[$params['within_pack_id']] * $params['within_pack_quantity'] : 0;
		}
		return ceil($packageWeight);
	}

	/**
	 * 退货入库单中产品是否包含有电池 是：'true' 否：'false'
	 * 所属接口：入库接口
	 * @param array $params
	 * @return string
	 */
	private function inboundHasBasBatteryOper($params) {
		$p_ids			= array();
		foreach ($params['detail'] as $product) {
			$p_ids[$product['product_id']]	= $product['product_id'];
		}
		$where			= array(
							'product_id'	=> array('in', $p_ids),
							'hasBattery'	=> 'true',
						);
		return M('ProductExtend')->where($where)->count() > 0 ? 'true' : 'false';
	}

	/**
	 * 退货入库单入库异常状态
	 * 所属接口：入库接口
	 * @param array $params
	 * @return array
	 */
	private function inboundResult($params) {
		$result	= array();
		if ($params['storage_abnormal'] == 1) {//入库异常
			$result['success']	= 'false';
			$result['code']		= $this->getCode($params['storage_abnormal_reason']);
//			$result['desc']		= C('STORAGE_ABNORMAL_REASON.' . $params['storage_abnormal_reason']);
		} else {
			$result['success']	= 'true';
		}
		$where	= 'b.id in (' . C('PICTURE_GENERAL') . ', ' . C('PICTURE_3C') . ') and b.return_service_id=' . C('PICTURE');
		if (M('ReturnSaleOrderDetailService')->alias('a')->join('__RETURN_SERVICE_DETAIL__ b on a.service_detail_id=b.id')->where($where)->count() > 0) {
			$relation_type	= 27;
			$file_urls		= M('Gallery')->where('relation_type=' . $relation_type . ' and relation_id=' . $params['id'])->getField('file_url', true);
			foreach ($file_urls as $file_url) {
				$url[]	= 'https://edapic.amoydream.com/' . $file_url;
			}
			if (!empty($url)) {
				$result['imgUrl']	= implode('|' , $url);
			}
		}
		if (array_key_exists('desc', $params)) {
			$result['desc']		= $params['desc'];
		}
		return $result;
	}


	/**
	 * 装箱异常改为正常则需要再次出库
	 * @param array $params
	 */
	private function packBoxOutbound($params) {
		foreach ($params['detail'] as $val) {
			if ($val['return_sale_order_id'] > 0 && cainiao_return_sale_order_id($val['return_sale_order_id']) > 0) {
				if ($val['parcel_state'] == 0) {//出库正常
					$return_logistics_no	= M('ReturnSaleOrder')->where(array('id' => $val['return_sale_order_id']))->getField('return_logistics_no');
					//有下发出库异常到菜鸟，则需再次下发正常出库
					$outbound				= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_OUTBOUND', $return_logistics_no, 'false');
					if ($outbound > 0) {
						$out_bacth_id	= M('out_batch_detail')->where(array('pack_box_id' => $params['id']))->getField('out_batch_id');
						$pack_box_list	= M('out_batch_detail')->where(array('out_batch_id' => $out_bacth_id))->select();
						$this->outbound(array('detail' => $pack_box_list));
						break;
					}
				}
			}
		}
	}

	/**
	 * 出库接口
	 * @param array $params
	 */
	private function outbound($params) {
		$pack_box_id			= array();
		$packBoxWeight			= array();
		foreach ($params['detail'] as $detail) {
			if ($detail['pack_box_id'] > 0) {
				$pack_box_id[$detail['pack_box_id']]	= $detail['pack_box_id'];
				$packBoxWeight[$detail['pack_box_id']]	= $detail['review_weight'];
			}
		}
		$where					= array(
									'pack_box_id'	=> array('in', $pack_box_id),
								);
		$join					= array(
									'__PACK_BOX__ pb on pb.id=pbd.pack_box_id',
									'__RETURN_SALE_ORDER__ rso ON rso.id=pbd.return_sale_order_id',
								);
		$field					= 'rso.id, rso.return_logistics_no, pbd.pack_box_id, pb.pack_box_no, pbd.parcel_state';
		$return_sale_order_list	= M('PackBoxDetail')->alias('pbd')->join($join)->where($where)->field($field)->select();
		if (empty($return_sale_order_list)) {
			return;
		}
		$includedNum		= array();
		foreach ($return_sale_order_list as $key => $return_sale_order) {
			if (cainiao_return_sale_order_id($return_sale_order['id']) > 0) {
				$includedNum[$return_sale_order['pack_box_id']]++;
			} else {
				unset($return_sale_order_list[$key]);
			}
		}
		if (empty($return_sale_order_list)) {
			return;
		}
		$out_batch_no		= M('OutBatch')->where(array('id' => $params['id']))->getField('out_batch_no');
		$temp	= array(
					'module'				=> $this->_module,
					'action'				=> $this->_action,
					'factory_id'			=> C('CAINIAO_FACTORY_ID'),
					'logistic_provider_id'	=> C('TRAN_STORE_CODE'),
					'msg_type'				=> 'TRANSIT_WAREHOUSE_OUTBOUND',
					'eventType'				=> 'TRANSIT_WAREHOUSE_OUTBOUND',
					'eventTime'				=> date('Y-m-d H:i:s'),
					'eventSource'			=> C('TRAN_STORE_CODE'),
					'eventTarget'			=> C('CAINIAO_NO'),
					'logisticsOrderCode'	=> '',
					'occurTime'				=> date('Y-m-d H:i:s'),
					'timeZone'				=> getTimeZone(),
					'batchNo'				=> $out_batch_no,
					'packageCode'			=> '',
					'packageWeight'			=> '',
					'weightUnit'			=> C('CAINIAO_WEIGHT_UNIT'),
					'includedNum'			=> '',
					'result'				=> array(),
				);
		foreach ($return_sale_order_list as $return_sale_order) {
			$success					= $return_sale_order['parcel_state'] > 0 ? 'false' : 'true';
			$outbound					= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_OUTBOUND', $return_sale_order['return_logistics_no'], $success);
			if ($outbound > 0) {
				continue;
			}
			$data						= $temp;
			$data['logisticsOrderCode']	= $return_sale_order['return_logistics_no'];
			$data['packageCode']		= $return_sale_order['pack_box_no'];
			$data['packageWeight']		= ceil($packBoxWeight[$return_sale_order['pack_box_id']]);
			$data['includedNum']		= $includedNum[$return_sale_order['pack_box_id']];
			$data['result']				= $this->outboundResult($params, $return_sale_order);
			cainiao_add_request($data);
		}
	}

	/**
	 * 退货单出库状态
	 * 所属接口：出库接口
	 * @param array $params
	 * @return array
	 */
	private function outboundResult($params, $return_sale_order) {
		$result	= array();
		if ($return_sale_order['parcel_state'] > 0) {
			$result['success']	= 'false';
			$result['code']		= $this->getCode($return_sale_order['parcel_state']);
//			$result['desc']		= C('PARCEL_STATE.' . $return_sale_order['parcel_state']);
		} else {
			$result['success']	= 'true';
		}
		if (array_key_exists('desc', $params)) {
			$result['desc']		= $params['desc'];
		}
		return $result;
	}

	/**
	 * 清关确认接口
	 * @param array $params
	 */
	private function gateClearCustoms($params) {
		$pack_box_id			= array();
		foreach ($params['detail'] as $detail) {
			if ($detail['pack_box_id'] > 0) {
				$pack_box_id[$detail['pack_box_id']]	= $detail['pack_box_id'];
			}
		}
		if (empty($pack_box_id)) {
			return;
		}
		$where					= array(
									'pack_box_id'	=> array('in', $pack_box_id),
								);
		$join					= array(
									'__RETURN_SALE_ORDER__ rso ON rso.id=pbd.return_sale_order_id',
								);
		$field					= 'rso.id, rso.return_logistics_no, pbd.customs_clearance_state';
		$return_sale_order_list	= M('PackBoxDetail')->alias('pbd')->join($join)->where($where)->field($field)->select();
		if (empty($return_sale_order_list)) {
			return;
		}
		$temp	= array(
					'module'				=> $this->_module,
					'action'				=> $this->_action,
					'factory_id'			=> C('CAINIAO_FACTORY_ID'),
					'logistic_provider_id'	=> C('TRUNK_CODE'),
					'msg_type'				=> 'GATE_CLEAR_CUSTOMS',
					'eventType'				=> 'GATE_CLEAR_CUSTOMS',
					'eventTime'				=> date('Y-m-d H:i:s'),
					'eventSource'			=> C('TRUNK_CODE'),
					'eventTarget'			=> C('CAINIAO_NO'),
					'logisticsOrderCode'	=> '',
					'occurTime'				=> date('Y-m-d H:i:s'),
					'timeZone'				=> getTimeZone(),
					'result'				=> array(),
				);
		foreach ($return_sale_order_list as $return_sale_order) {
			if (cainiao_return_sale_order_id($return_sale_order['id']) > 0) {
				$success					= $return_sale_order['customs_clearance_state'] != C('CUSTOMS_CLEARANCE_NORMAL') ? 'false' : 'true';
				$clear						= cainiao_request_not_abandon_count('GATE_CLEAR_CUSTOMS', $return_sale_order['return_logistics_no'], $success);
				if ($clear > 0) {
					continue;
				}
				$data						= $temp;
				$data['logisticsOrderCode']	= $return_sale_order['return_logistics_no'];
				$data['result']				= $this->gateClearCustomsResult($params, $return_sale_order);
				cainiao_add_request($data);
			}
		}
	}

	/**
	 * 退货单清关状态
	 * 所属接口：清关确认接口
	 * @param array $params
	 * @param array $return_sale_order
	 * @return array
	 */
	private function gateClearCustomsResult($params, $return_sale_order) {
		$result	= array();
		if ($return_sale_order['customs_clearance_state'] != C('CUSTOMS_CLEARANCE_NORMAL')) {
			$result['success']	= 'false';
			$result['code']		= $this->getCode($return_sale_order['customs_clearance_state']);
//			$result['desc']		= C('CUSTOMS_CLEARANCE_STATE.' . $return_sale_order['customs_clearance_state']);
		} else {
			$result['success']	= 'true';
		}
		if (array_key_exists('desc', $params)) {
			$result['desc']		= $params['desc'];
		}
		return $result;
	}

	/**
	 * 交接确认接口
	 * @param array $params
	 */
	private function handover($params) {
		$pack_box_id			= array();
		foreach ($params['detail'] as $detail) {
			if ($detail['pack_box_id'] > 0) {
				$pack_box_id[$detail['pack_box_id']]	= $detail['pack_box_id'];
			}
		}
		$where					= array(
									'pack_box_id'	=> array('in', $pack_box_id),
								);
		$join					= array(
									'__RETURN_SALE_ORDER__ rso ON rso.id=pbd.return_sale_order_id',
								);
		$field					= 'rso.id, rso.return_logistics_no, pbd.associate_with_state';
		$return_sale_order_list	= M('PackBoxDetail')->alias('pbd')->join($join)->where($where)->field($field)->select();
		if (empty($return_sale_order_list)) {
			return;
		}
		$temp	= array(
					'module'				=> $this->_module,
					'action'				=> $this->_action,
					'factory_id'			=> C('CAINIAO_FACTORY_ID'),
					'logistic_provider_id'	=> C('TRUNK_CODE'),
					'msg_type'				=> 'TRANSIT_WAREHOUSE_HANDOVER',
					'eventType'				=> 'TRANSIT_WAREHOUSE_HANDOVER',
					'eventTime'				=> date('Y-m-d H:i:s'),
					'eventSource'			=> C('TRUNK_CODE'),
					'eventTarget'			=> C('CAINIAO_NO'),
					'logisticsOrderCode'	=> '',
					'occurTime'				=> date('Y-m-d H:i:s'),
					'timeZone'				=> getTimeZone(),
					'result'				=> array(),
				);
		foreach ($return_sale_order_list as $return_sale_order) {
			if (cainiao_return_sale_order_id($return_sale_order['id']) > 0) {
				$success					= $return_sale_order['associate_with_state'] == C('ASSOCIATE_WITH_ABNORMAL') ? 'false' : 'true';
				$handover					= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_HANDOVER', $return_sale_order['return_logistics_no'], $success);
				if ($handover > 0) {
					continue;
				}
				$data						= $temp;
				$data['logisticsOrderCode']	= $return_sale_order['return_logistics_no'];
				$data['result']				= $this->handoverResult($params, $return_sale_order);
				cainiao_add_request($data);
			}
		}
	}

	/**
	 * 退货单交接状态
	 * 所属接口：清关确认接口
	 * @param array $params
	 * @param array $return_sale_order
	 * @return array
	 */
	private function handoverResult($params, $return_sale_order) {
		$result	= array();
		if ($return_sale_order['associate_with_state'] == C('ASSOCIATE_WITH_ABNORMAL')) {
			$result['success']	= 'false';
		} else {
			$result['success']	= 'true';
		}
		if (array_key_exists('desc', $params)) {
			$result['desc']		= $params['desc'];
		}
		return $result;
	}
}
