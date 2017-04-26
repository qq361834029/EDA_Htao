<?php
class OutBatchPublicBehavior extends Behavior {
    public $_action    = '';
	public $_module    = '';
	public function run(&$params){
        $this->_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        $this->_module	= $params['_module'] ? $params['_module'] : getTrueModule();
        $model  = D('ReturnSaleOrder');
        if(!empty($params['detail'])){
            foreach ($params['detail'] as $detail){
                if(!empty($detail['pack_box_id'])){
                    $pack_box_id[$detail['pack_box_id']]    = $detail['pack_box_id'];
                }
            }
        }else{
            $pack_box_id    = M('out_batch_detail_del')->where('out_batch_id='.$params['id'])->getField('pack_box_id',true);
        }

        $return_id  = M('pack_box_detail')->where('pack_box_id in ('.implode(',', $pack_box_id).')')->getField('return_sale_order_id',true);
		if($this->_action =='insert'){
            $model->updateReturnStateById($return_id,C('DELIVERY_FOR_RECEIVE'));
            $result	= A('OutBatch')->sendEmail($params);
        }elseif($this->_action == 'delete'){
            $model->updateReturnStateById($return_id,C('PACKED_FOR_DELIVERY'));
        }elseif($this->_action == 'update'){//清关 交接
            if($params['customs_clearance'] || $params['associate_with']){
                if($params['customs_clearance']){
                    $field  = 'customs_clearance_state';
                }else{
                    $field  = 'associate_with_state';
                }
                foreach($params['detail'] as &$detail){
                    if($detail['pack_box_id'] > 0){
                        $state  = json_decode(htmlspecialchars_decode(stripcslashes($detail['state'])),true);
                        if(empty($state)){
                            switch ($detail[$field]){
                                case 1:
                                    if($params['customs_clearance']){
                                        $state_id_arr_1    = C('CUSTOMS_CLEARANCE_REPORTING_DISCREPANCIES');
                                    }else{
                                        $state_id_arr_1    = C('ASSOCIATE_WITH_ABNORMAL');
                                    }
                                    $state_arr_1[]     = $detail['pack_box_id'];
                                    break;
                                case 2:
                                    $state_id_arr_2    = C('CUSTOMS_CLEARANCE_CUSTOMS_SEIZED');
                                    $state_arr_2[]     = $detail['pack_box_id'];
                                    break;
                            }
                            $pack_box_id_arr[$detail['pack_box_id']]['id']      = $detail['pack_box_id'];
                            $pack_box_id_arr[$detail['pack_box_id']]['state']   = $detail['associate_with_state'];
                        }else{
                            foreach($state as $value){
                                switch ($value[1]){
                                    case 1:
                                        if($params['customs_clearance']){
                                            $state_id_1    = C('CUSTOMS_CLEARANCE_REPORTING_DISCREPANCIES');
                                        }else{
                                            $state_id_1    = C('ASSOCIATE_WITH_ABNORMAL');
                                        }
                                        $state_1[]     = $value[0];
                                        break;
                                    case 2:
                                        $state_id_2    = C('CUSTOMS_CLEARANCE_CUSTOMS_SEIZED');
                                        $state_2[]     = $value[0];
                                        break;
    //                                default :
    //                                    if($params['customs_clearance']){
    //                                        $state_id_0    = C('CUSTOMS_CLEARANCE_NORMAL');
    //                                    }else{
    //                                        $state_id_0    = C('ASSOCIATE_WITH_NORMAL');
    //                                    }
    //                                    $state_0[]      = $value[0];
    //                                    break;
                                }
                            }
                        }
                    }
                }
                
                if(!empty($pack_box_id)){
                    if($params['customs_clearance']){
                        $state_id_0    = C('CUSTOMS_CLEARANCE_NORMAL');
                    }else{
                        $state_id_0    = C('ASSOCIATE_WITH_NORMAL');
                    }
                    $sql    = 'update pack_box_detail set '.$field.'='.$state_id_0.' where pack_box_id in ('.  implode(',', $pack_box_id).')';
                    M('pack_box_detail')->query($sql);
                }
                if(!empty($state_arr_1)){
                    $sql    = 'update pack_box_detail set '.$field.'='.$state_id_arr_1.' where pack_box_id in ('.  implode(',', $state_arr_1).')';
                    M('pack_box_detail')->query($sql);
                }
                if(!empty($state_arr_2)){
                    $sql    = 'update pack_box_detail set '.$field.'='.$state_id_arr_2.' where pack_box_id in ('.  implode(',', $state_arr_2).')';
                    M('pack_box_detail')->query($sql);
                }
                if(!empty($state_1)){
                    $sql    = 'update pack_box_detail set '.$field.'='.$state_id_1.' where return_sale_order_id in ('.  implode(',', $state_1).')';
                    M('pack_box_detail')->query($sql);
                }
                if(!empty($state_2)){
                    $sql    = 'update pack_box_detail set '.$field.'='.$state_id_2.' where return_sale_order_id in ('.  implode(',', $state_2).')';
                    M('pack_box_detail')->query($sql);
                }
                if($params['customs_clearance']){
                    $model->updateReturnStateById($return_id,C('BOOKING_CONFIRM'),L('customs_clearance'));
                }elseif($params['associate_with']){
					//如果没有过处理完成的状态记录,更新退货单的处理完成时间       add by lxt 2015.11.13
					$completed_id   = M('StateLog')->where('object_type='.intval(array_search('ReturnSaleOrder',C('STATE_OBJECT_TYPE'))).' and object_id in ('. implode(', ', $return_id).') and state_id='.C('PROCESS_COMPLETE'))->getField('object_id', true);
					$undone_id		= $completed_id ? array_diff($return_id, $completed_id) : $return_id;
					if (!empty($undone_id)){
						M('ReturnSaleOrder')->where(array('id' => array('in', $return_id)))->setField('returned_date',date('Y-m-d',time()));
					}
                    $model->updateReturnStateById($return_id,C('PROCESS_COMPLETE'),L('associate_with'));
                }
            }
            else if($params['review_weight']){
//                foreach($params['detail'] as &$detail){
//                    if($detail['pack_box_id'] > 0){
//                        $state  = json_decode(htmlspecialchars_decode(stripcslashes($detail['state'])),true);
//                        foreach($state as $value){
//                            $sql    = 'UPDATE pack_box_detail SET review_weight='.$value[1].' where return_sale_order_id='.$value[0];
//                            M('pack_box_detail')->query($sql);
//                        }
//                    }
//                }
                if(!empty($return_id)){
                    $return_id  = M('return_sale_order')->where('id in ('.  implode(',', $return_id).') and return_sale_order_state='.C('DELIVERY_FOR_RECEIVE'))->getField('id',true);
                    if(!empty($return_id)){
                        $model->updateReturnStateById($return_id,C('DELIVERY_FOR_CLEARANCE'),L('review_weight'));
                    }
                }
            }
        }
	}
    
    public function insert($params){
        foreach($params['detail'] as $detail){
            if(!empty($detail['pack_box_id'])){
                $pack_box_id[$detail['pack_box_id']]    = $detail['pack_box_id'];
            }
        }
        $pack_box_id[]  = 0;
        $pack_id    = M('out_batch_detail')->where('pack_box_id in ('.implode(',', $pack_box_id).')')->getField('pack_box_id',true);
        
        if(!empty($pack_id)){
            $pack_box_no    = M('pack_box')->where('id in ('.implode(',', $pack_id).')')->getField('pack_box_no',true);
            throw_json(L('pack_box_out'));
        }
    }
    
    public function update($params){
		$this->edit($params);
		if ($params['customs_clearance']) {
			$this->cainiaoCheckClearance($params);
		}
		if ($params['associate_with']) {
			$this->cainiaoCheckHandover($params);
		}
    }

	public function cainiaoCheckClearance($params){
		$pack_box_id			= array();
		foreach ($params['detail'] as $detail) {
			if ($detail['pack_box_id'] > 0) {
				$pack_box_id[$detail['pack_box_id']]	= $detail['customs_clearance_state'];
			}
		}
		$where					= array(
									'pack_box_id'	=> array('in', array_keys($pack_box_id)),
								);
		$join					= array(
									'__PACK_BOX__ pb ON pb.id=pbd.pack_box_id',
									'__RETURN_SALE_ORDER__ rso ON rso.id=pbd.return_sale_order_id',
								);
		$field					= 'rso.id, rso.return_logistics_no, pbd.pack_box_id, pb.pack_box_no';
		$return_sale_order_list	= M('PackBoxDetail')->alias('pbd')->join($join)->where($where)->field($field)->select();
		if (empty($return_sale_order_list)) {
			return;
		}
		$error	= array();
		foreach ($return_sale_order_list as $return_sale_order) {
			if (cainiao_return_sale_order_id($return_sale_order['id']) > 0 && $pack_box_id[$return_sale_order['pack_box_id']] != C('CUSTOMS_CLEARANCE_NORMAL')) {
				$clear	= cainiao_request_not_abandon_count('GATE_CLEAR_CUSTOMS', $return_sale_order['return_logistics_no']);
				if ($clear > 0) {
					$error[$return_sale_order['pack_box_id']]	= '大包[' . $return_sale_order['pack_box_no'] . ']内的退货单已在菜鸟正常清关，不允许回退为清关异常！';
				}
			}
		}
		if (!empty($error)) {
			throw_json(implode("<br />", $error));
		}
	}

	public function cainiaoCheckHandover($params){
		$pack_box_id			= array();
		foreach ($params['detail'] as $detail) {
			if ($detail['pack_box_id'] > 0) {
				$pack_box_id[$detail['pack_box_id']]	= $detail['associate_with_state'];
			}
		}
		$where					= array(
									'pack_box_id'	=> array('in', array_keys($pack_box_id)),
								);
		$join					= array(
									'__PACK_BOX__ pb ON pb.id=pbd.pack_box_id',
									'__RETURN_SALE_ORDER__ rso ON rso.id=pbd.return_sale_order_id',
								);
		$field					= 'rso.id, rso.return_logistics_no, pbd.pack_box_id, pb.pack_box_no';
		$return_sale_order_list	= M('PackBoxDetail')->alias('pbd')->join($join)->where($where)->field($field)->select();
		if (empty($return_sale_order_list)) {
			return;
		}
		$error	= array();
		foreach ($return_sale_order_list as $return_sale_order) {
			if (cainiao_return_sale_order_id($return_sale_order['id']) > 0 && $pack_box_id[$return_sale_order['pack_box_id']] != C('ASSOCIATE_WITH_NORMAL')) {
				$handover	= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_HANDOVER', $return_sale_order['return_logistics_no']);
				if ($handover > 0) {
					$error[$return_sale_order['pack_box_id']]	= '大包[' . $return_sale_order['pack_box_no'] . ']内的退货单已在菜鸟正常交接，不允许回退为交接异常！';
				}
			}
		}
		if (!empty($error)) {
			throw_json(implode("<br />", $error));
		}
	}

	public function edit($params){
		$this->hasAbnormal($params);
        if($this->isReviewWeight($params) == 1){
            throw_json('该出库批次已复核重量，不能执行当前操作!!');
        }
        if($this->isCustomsClearance($params) == 1){
            throw_json(L('customs_clearance_no_edit'));
        }
        if($this->isAssociateWith($params) == 1){
            throw_json('该出库批次已交接不能修改清关!!');
        }
    }

	public function hasAbnormal($params){
        if($params['customs_clearance'] && D('OutBatch')->hasOutBoundAbnormal($params['id']) == 1){
            throw_json('出库异常不能清关！');
        }
        if($params['associate_with'] && D('OutBatch')->hasClearanceAbnormal($params['id']) == 1){
            throw_json('清关异常不能交接！');
        }
	}

	public function deleteDetail($params){
		$return_list	= M('OutBatchDetail ')->alias('o')->join('inner join __PACK_BOX_DETAIL__ p on p.pack_box_id=o.pack_box_id inner join __RETURN_SALE_ORDER__ r on r.id=p.return_sale_order_id')->where(array('o.id' => $params['id']))->field('return_sale_order_id, return_logistics_no')->select();
		$this->cainiaoCheckOutBound($return_list);
    }

    public function delete($params){
        if($this->isCustomsClearance($params) == 1){
            throw_json(L('customs_clearance_no_delete'));
        }
		$return_list	= M('OutBatchDetail ')->alias('o')->join('inner join __PACK_BOX_DETAIL__ p on p.pack_box_id=o.pack_box_id inner join __RETURN_SALE_ORDER__ r on r.id=p.return_sale_order_id')->where(array('o.out_batch_id' => $params['id']))->field('return_sale_order_id, return_logistics_no')->select();
		$this->cainiaoCheckOutBound($return_list);
    }

	public function cainiaoCheckOutBound($return_list) {
		$error	= array();
		foreach ($return_list as $return_sale_order) {
			if (cainiao_return_sale_order_id($return_sale_order['return_sale_order_id']) > 0) {
				$outbounded	= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_OUTBOUND', $return_sale_order['return_logistics_no'], '');
				if ($outbounded > 0) {
					$error[]	= '退货单[' . $return_sale_order['return_logistics_no'] . ']已在菜鸟出库，不允许删除！';
				}
			}
		}
		if (!empty($error)) {
			throw_json(implode("\n", $error));
		}
	}

	//是否已经复核重量
    public function isReviewWeight($params){
        if(!$params['customs_clearance'] && !$params['associate_with']){
            return M('OutBatch')->where('id='.$params['id'])->getField('is_review_weight');
        }
    }

	//是否已经清关
    public function isCustomsClearance($params){
        if(!$params['customs_clearance'] && !$params['associate_with']){
            return M('OutBatch')->where('id='.$params['id'])->getField('is_customs_clearance');
        }
    }

	//是否已经交接
    public function isAssociateWith($params){
        if($params['customs_clearance']){
            return M('OutBatch')->where('id='.$params['id'])->getField('is_associate_with');
        }
    }
}