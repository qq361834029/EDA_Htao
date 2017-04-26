<?php
class PackBoxPublicBehavior extends Behavior {
    public $_action    = '';
	public $_module    = '';

    public function run(&$params){
        $this->_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        $this->_module	= $params['_module'] ? $params['_module'] : getTrueModule();
        //更新退货状态
        $model  = D('ReturnSaleOrder');
        
        if($this->_action == 'insert'){
            foreach($params['detail'] as $detail){
                if($detail['return_sale_order_id'] > 0){
                    $return_id[$detail['return_sale_order_id']]  = $detail['return_sale_order_id'];
                }
            }
            $model->updateReturnStateById($return_id,C('PACKED_FOR_DELIVERY'));
        }elseif($this->_action == 'delete'){
            $return_id  = M('pack_box_detail_del')
                    ->where('pack_box_id='.$params['id'])
                    ->getField('return_sale_order_id',true);
            $model->updateReturnStateById($return_id,C('RETURN_FOR_DELIVERY'));
        }
	}
    
    public function insert($params){
		$return_sale_order_id	= array();
        foreach($params['detail'] as $detail){
            if($detail['return_sale_order_id']>0){
                $return_sale_order_id[$detail['return_sale_order_id']]	= $detail['return_sale_order_id'];
            }
        }
        if(count($return_sale_order_id) == 0){
            throw_json(L('pack_box_detail_not_null'));
		} elseif(M('ReturnSaleOrder')->where(array('id' => array('in', $return_sale_order_id)))->getField('count(distinct factory_id) as count') > 1) {
			throw_json(L('please_select_a_seller_return_order'));
		}
    }

    public function edit($params){
        $model  = D('PackBox');
        if($model->isOutBatch($params['id']) && $model->isAbnormal($params['id'])){
            throw_json(L('pack_box_no_update'));
        }
    }

    public function update($params){
        $model  = D('PackBox');
        if($model->isOutBatch($params['id']) && $model->isAbnormal($params['id'])){
            throw_json(L('pack_box_no_update'));
        }
		$this->cainiaoCheckOutBounded($params);
    }

	public function cainiaoCheckOutBounded($params){
		foreach ($params['detail'] as $val) {
			if ($val['return_sale_order_id'] > 0 && cainiao_return_sale_order_id($val['return_sale_order_id']) > 0) {
				if ($val['parcel_state'] > 0) {
					$return_logistics_no	= M('ReturnSaleOrder')->where(array('id' => $val['return_sale_order_id']))->getField('return_logistics_no');
					$outbound				= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_OUTBOUND', $return_logistics_no);
					if ($outbound > 0) {
						 throw_json('该退货单已在菜鸟出库正常，不允许回退为出库异常！');
					}
				}
			}
		}
	}

	public function delete($params){
        $model  = D('PackBox');
        if($model->isOutBatch($params['id'])){
            throw_json(L('pack_box_no_delete'));
        }
		$return_list	= M('PackBoxDetail')->alias('p')->join('inner join __RETURN_SALE_ORDER__ r on r.id=p.return_sale_order_id')->where(array('pack_box_id' => $params['id']))->field('return_sale_order_id, return_logistics_no')->select();
		$this->cainiaoCheckOutBound($return_list);
    }


	public function deleteDetail($params) {
		$return_list	= M('PackBoxDetail')->alias('p')->join('inner join __RETURN_SALE_ORDER__ r on r.id=p.return_sale_order_id')->where(array('p.id' => $params['id']))->field('return_sale_order_id, return_logistics_no')->select();
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
			throw_json(implode("<br />", $error));
		}
	}
	
}