<?php //
class ReturnSaleOrderStoragePublicBehavior extends Behavior {
    public function run(&$params){
		$_module	= $params['_module'] ? $params['_module'] : getTrueModule();
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        if ($_module == 'ReturnSaleOrder') {
            $storage_id     = M('return_sale_order_storage')->where('return_sale_order_id=' . (int)$params['id'])->getField('id'); //每个退货单只能上架一次
            $return_id      = $params['id'];
            if (in_array($params['return_sale_order_state'], C('SHOW_LOCATION_RETURN_SALE_ORDER_STATE'))) {
                if ($storage_id > 0 ) {
                    if($params['return_sale_order_state'] != C('PROCESS_COMPLETE')){
                        D('ReturnSaleOrderStorage')->returnStorageUpdate($params); //编辑退货上架
                    }
                } else {
                    D('ReturnSaleOrderStorage')->returnStorageInsert($params); //新增退货上架
                }
            } else if ($storage_id > 0 && MODULE_NAME != 'CaiNiao') {
                $id   = M('return_sale_order_storage')->where('return_sale_order_id='.$params['id'])->getField('id');
                D('ReturnSaleOrderStorage')->returnStorageDelete($id); //删除已上架
            } 
        }else{
            //add deleteDeal by lxt 2015.09.07
            if($_action=='delete' || $_action=='deleteDeal') {
                $return_id = M('return_sale_order_storage')->where('id=' . (int)$params['id'])->getField('return_sale_order_id'); //每个退货单只能上架一次
            } else {
                $return_id = $params['return_sale_order_id'];
            }
            //更新包装信息时同步到退货单
            if($_action == 'update'){
//                    $data['id']                     = $params['return_sale_order_id'];
//                    $data['outer_pack']             = $params['outer_pack'];
//                    $data['outer_pack_id']          = $params['outer_pack_id'];
//            //        $info['outer_pack_quantity']    = $params['outer_pack_quantity'];
//                    $data['within_pack']            = $params['within_pack'];
//                    $data['within_pack_id']         = $params['within_pack_id'];
//            //        $info['within_pack_quantity']   = $params['within_pack_quantity'];
                if(!empty($params['outer_pack']) || !empty($params['within_pack'])){
                    $sql    = 'UPDATE `return_sale_order` SET ';
                    if(!empty($params['outer_pack'])){
                        $sql    .= ' outer_pack='.$params['outer_pack'].',outer_pack_id='.(empty($params['outer_pack_id']) ? 0 :$params['outer_pack_id']);
                    }
                    if(!empty($params['outer_pack']) && !empty($params['within_pack'])){
                        $sql    .= ',';
                    }
                    if(!empty($params['within_pack'])){
                        $sql    .= ' within_pack='.$params['within_pack'].',within_pack_id='.(empty($params['within_pack_id']) ? 0 :$params['within_pack_id']);
                    }
                    $sql    .= '  where id='.$params['return_sale_order_id'];
                    M('return_sale_order')->query($sql);
                }
            }
            //更新退货服务方式      add by lxt 2015.09.02
            if (in_array($_action, array('insert','update','updateDeal'))){
                $this->updateService($params);
            }
            //更新速卖通产品信息         add by lxt 2015.08.31
            if (in_array($_action, array('insert','update'))){
                $this->updateProduct($params);
            }
        }
        if(MODULE_NAME == $params['_module']){// add yyh 20151222 删除处理完成的退货单
            //退货单状态     add by lxt 2015.08.30
            $state  =   $this->returnSaleOrderState($params);
            if ($state !== false) {
                $model  =   D('ReturnSaleOrder');
                if (in_array($state, array(C('DROPPED'),C('PROCESS_COMPLETE')))){
                    $model->where('(returned_date is NULL or returned_date="0000-00-00") and id='.$return_id)->setField('returned_date', date('Y-m-d'));
                }
                //更新退货单状态       edit by lxt 2015.08.30      $state
                $model->updateReturnStateById($return_id,$state);
            } 
        }
    }
    public function update($params){
        foreach ($params['detail'] as $val){
            $total_quantity     += $val['quantity'];
        }
        if($total_quantity <= 0){
            throw_json(L('greater_storage_quantity'));
        }
		$this->cainiaoCheckInbound($params);
    }

    public function deal($params){
		$this->checkDeal($params);
    }
	
	public function checkDeal($params){
		$rs	= M('ReturnSaleOrderStorage')->find($params['id']);
		if ($rs['is_deal'] == 1) {
			throw_json(L('_RECORD_HAS_UPDATE_'));
		}
		$this->cainiaoCheckDeal($rs['return_sale_order_id']);
	}


	public function updateDeal($params){
        foreach ($params['detail'] as $val){
            $total_quantity     += $val['quantity'];
        }
        if($total_quantity <= 0){
            throw_json(L('greater_storage_quantity'));
        }
		$this->checkDeal($params);
    }

	/**
	 * 菜鸟退货单必须等待卖家处理意见后才能处理
	 * @param type $return_sale_order_id
	 */
	public function cainiaoCheckDeal($return_sale_order_id) {
		if (cainiao_return_sale_order_id($return_sale_order_id) > 0) {
			$where				= array(
									'return_sale_order_id'	=> $return_sale_order_id,
									'b.return_service_id'	=> array('neq', C('PICTURE')),
								);
			$notPictureService	= M('ReturnSaleOrderDetailService')->alias('a')->join('__RETURN_SERVICE_DETAIL__ b on a.service_detail_id=b.id')->where($where)->getField('return_service_id');
			if (empty($notPictureService)) {
				throw_json('该退货单还在等待卖家处理意见，不允许处理！');
			}	
		}
	}

		//删除处理限制        add by lxt 2015.09.11
    public function deleteDeal($params){
        $rs		=   M('return_sale_order_storage')->find($params['id']);
		if ($rs['is_deal'] != 1) {
			throw_json(L('_RECORD_HAS_UPDATE_'));
		}
        $count	=   M('PackBoxDetail')->where('return_sale_order_id='.$rs['return_sale_order_id'])->count();
        if ($count){
            throw_json(L('limit_delete_deal'));
        }
		$this->cainiaoCheckDropped($rs['return_sale_order_id']);
    }

	public function cainiaoCheckDropped($return_sale_order_id){
		if (cainiao_return_sale_order_id($return_sale_order_id) > 0) {
			$return_logistics_no	= M('ReturnSaleOrder')->where(array('id' => $return_sale_order_id))->getField('return_logistics_no');
			$inbounded				= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_INBOUND', $return_logistics_no);
			if ($inbounded > 0) {
				$dropped	= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_INNER_CHECK_CONFIRM', $return_logistics_no);
				if ($dropped > 0) {
					throw_json('该退货单已在菜鸟丢弃，不允许删除退货入库处理！');
				}
			}
		}
	}


	public function add($params){
        $return_sale_order_state   = M('return_sale_order')->where('id='.(int)$params['id'])->getField('return_sale_order_state');
        if(!empty($return_sale_order_state)&&$return_sale_order_state== C('RETURN_SHELVES')){
            throw_json(L('return_sale_order_storaged'));
        }
        if(!empty($return_sale_order_state)&&!in_array($return_sale_order_state, C('STORAGE_RETURN_SALE_ORDER_STATE'))){
            throw_json(L('return_sale_order_cant_storage'));
        }
		$this->cainiaoCheckSign($params);
    }

    public function edit($params){
        $info   = M('return_sale_order_storage')->join(' as a left join return_sale_order as b on a.return_sale_order_id=b.id')->where('a.id='.(int)$params['id'])->field('a.is_deal,b.return_sale_order_state')->find();
        if(!in_array($info['return_sale_order_state'], explode(',', C('STORAGE_SHOW_STATE')))){//入库页面可显示状态       add by lxt 2015.08.31
            throw_json(L('del_return_storage'));
        }
        if($info['is_deal']){
            throw_json(L('return_storage_cant_edit'));
        }
    }
    //选择退货单状态       add by lxt 2015.08.30
    public function returnSaleOrderState($params){
		$_module	= $params['_module'] ? $params['_module'] : getTrueModule();
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        if ($_module!='ReturnSaleOrderStorage'){
            return false;
        }
        if (($_action=='update' && !$params['storage_abnormal']) || $_action=='deleteDeal'){
            return C('RETURN_SHELVES');
        }     
        if ($_action=='delete'){
            $id		= M('ReturnSaleOrderStorage')->where('id='.$params['id'])->getField('return_sale_order_id');
			$state	= C('SHOW_LOCATION_RETURN_SALE_ORDER_STATE');
			unset($state[array_search(C('PROCESS_COMPLETE'), $state)]);
			$where	= array(
				'object_id'		=> $id,
				'object_type'	=> array_search('ReturnSaleOrder', C('STATE_OBJECT_TYPE')),
				'state_id'		=> array('in', $state),
			);
			return M('state_log')->where($where)->order('id desc')->getField('state_id');
        }             
        $id =   $params['return_sale_order_id'];
        //入库异常优先级最高
        if ($params['storage_abnormal'] && $params['storage_abnormal_reason']){
            $state  =   C('STORAGE_ABNORMAL');
        }else{
            //服务方式
            $service_detail =   M('ReturnServiceDetail')
                                ->alias('a')
                                ->join('return_sale_order_detail_service b on b.service_detail_id=a.id')
                                ->where('b.return_sale_order_id='.$id)
                                ->field('a.return_service_id')
                                ->group('a.return_service_id')
                                ->select();
            if (count($service_detail)>0){
                foreach ($service_detail as $value){
                    $service_id[]   =   $value['return_service_id'];
                }
            }
            //丢弃优先级高于退运
            if (in_array(C('DOWN_AND_DESTORY'), $service_id)){
                $state  =   C('DROPPED');
            }elseif ($params['is_hand']){
                $state  =   C('PROCESS_COMPLETE');
            }elseif (in_array(C('BACK_TO_DOMESTIC'), $service_id)){
                $state  =   C('RETURN_FOR_DELIVERY');
            }else{
                $state  =   0;
            }
        }
        return $state;
    }
    //更新速卖通产品信息     add by lxt 2015.08.31
    public function updateProduct($params){
        if (!isset($params['detail'])){
            return true;
        }
        $model  =   M('Product');
        //只更新重量，长，宽，高
        foreach ($params['detail'] as $value){
            $product    =   array(
                'id'        =>  $value['product_id'],
                'to_hide'   =>  1,
            );
            //长，宽，高有值时才加入条件,如果检查通过，则更新检查尺寸，否则更新产品尺寸
            if ($value['check_status']==1){
                $product['check_weight']                         =   $value['weight'];   
                $value['cube_long'] && $product['check_long']    =   $value['cube_long'];
                $value['cube_wide'] && $product['check_wide']    =   $value['cube_wide'];
                $value['cube_high'] && $product['check_high']    =   $value['cube_high'];
            }else{
                $product['weight']                              =   $value['weight'];
                $value['cube_long'] && $product['cube_long']    =   $value['cube_long'];
                $value['cube_wide'] && $product['cube_wide']    =   $value['cube_wide'];
                $value['cube_high'] && $product['cube_high']    =   $value['cube_high'];
            }
            //如果没有修改，则不更新
            $flag   =   $model->where($product)->count();
            if (!$flag){
                $model->save($product);
            }else{
                continue;
            }
        }
    }
    //更新退货服务方式      add by lxt 2015.09.02
    public function updateService($params){
        $service    =   $params['service'];
        if (count($service)>0){
            $service_model  =   M('ReturnSaleOrderDetailService');
            $delete_flag    =   $service_model->where('return_sale_order_id='.$params['return_sale_order_id'])->delete();
            if ($service_model->addAll($service)===false){
                throw_json(L('_ERROR_ACTION_'));
            }
            $sql    =   ' update return_sale_order_detail_service a 
					left join return_sale_order_detail b
					on a.return_sale_order_id = b.return_sale_order_id and a.relation_id = b.relation_id
					set a.return_sale_order_detail_id = b.id
					where a.return_sale_order_id=' . $params['return_sale_order_id'];
            $result =   $service_model->query($sql);   
            if ($result===false || $delete_flag===false){
                throw_json(L('_ERROR_ACTION_'));
            }
        }
        return true;
    }

	/**
	 * 退货单未在菜鸟签收，不允许入库
	 * @param type $params
	 */
	public function cainiaoCheckSign($params) {
		if (cainiao_return_sale_order_id($params['id']) > 0) {
			$return_logistics_no	= M('ReturnSaleOrder')->where(array('id' => $params['id']))->getField('return_logistics_no');
			$signed					= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_SIGN', $return_logistics_no);
			if ($signed <= 0) {
				throw_json('该退货单未在菜鸟签收，不允许入库！');
			}
		}
	}

	/**
	 * 退货单已在菜鸟正常入库，不允许改为入库异常！
	 * @param type $params
	 */
	public function cainiaoCheckInbound($params) {
		if (cainiao_return_sale_order_id($params['return_sale_order_id']) > 0 && $params['storage_abnormal'] == 1) {
			$return_logistics_no	= M('ReturnSaleOrder')->where(array('id' => $params['return_sale_order_id']))->getField('return_logistics_no');
			$inbounded				= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_INBOUND', $return_logistics_no);
			if ($inbounded > 0) {
				throw_json('该退货单已在菜鸟正常入库，不允许改为入库异常！');
			}
		}
	}

	public function delete($params) {
        if(getTrueModule()  == 'ReturnSaleOrder'){
            $params['id']   = M('ReturnSaleOrderStorage')->where('return_sale_order_id='.$params['id'])->getField('id');
            if($params['id'] <= 0){
                return;
            }
		} else {
			$rs		=   M('return_sale_order_storage')->find($params['id']);
			if ($rs['is_deal'] == 1) {
				throw_json(L('_RECORD_HAS_UPDATE_'));
			}			
		}
		$this->cainiaoCheckInbounded($params);
	}

	/**
	 * 退货单已在菜鸟入库(无论正常与否)，不允许删除！
	 * @param type $params
	 */
	public function cainiaoCheckInbounded($params) {
		$return_sale_order_id	= M('ReturnSaleOrderStorage')->where(array('id' => $params['id']))->getField('return_sale_order_id');
		if (cainiao_return_sale_order_id($return_sale_order_id) > 0) {
			$return_logistics_no	= M('ReturnSaleOrder')->where(array('id' => $return_sale_order_id))->getField('return_logistics_no');
			$inbounded				= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_INBOUND', $return_logistics_no, '');
			if ($inbounded > 0) {
				throw_json('该退货单已在菜鸟入库，不允许删除！');
			}
		}
	}
}
