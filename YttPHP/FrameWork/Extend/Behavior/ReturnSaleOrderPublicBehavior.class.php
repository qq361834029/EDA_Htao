<?php

/**
 * 退换货行为类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    销售
 * @package   Behavior
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class ReturnSaleOrderPublicBehavior extends Behavior {
	
	public function run(&$params){
		$_action				= $params['_action'] ? $params['_action'] : getTrueAction();
		$params['flow_type']	= 'return_sale_order';
		T('ReturnSaleOrder')->run($params,'setState');///新增退货单状态记录日志
		if (in_array($_action,array('insert','update'))) {
			//added by jp 20140523 为退货单号加上退货单id前缀
            $userType   = $_action=='insert' ? getUser('role_type') : M('user')->where('id='.(int)$params['add_user'])->getField('user_type');
			$prefix		= $userType==C('SELLER_ROLE_TYPE') ? 'M' : 'HW';
			$this->updateService($params['id']);
			$ReturnService  = M('return_sale_order_detail_service');
			$join           = 'as a left join return_service_detail as b on a.service_detail_id=b.id
							left join return_service as c on b.return_service_id=c.id';
			$service        = $ReturnService->join($join)->where('a.return_sale_order_id='.$params['id'])->group('c.return_service_no')->getField('return_service_no',true);
			if(empty($params['factory_id'])){
				$factory_id = M('return_sale_order')->where('id='.$params['id'])->getField('factory_id');
			} else {
				$factory_id	= $params['factory_id'];
			}
			if ($params['id'] > 0 && $params['id'] <= C('OLD_FORMAT_RETURN_SALE_ORDER_NO_MAX_ID')) {
				M('ReturnSaleOrder')->execute('update return_sale_order set return_sale_order_no = concat("'.implode('-', $service).'-'.$prefix.'",id,"-",return_sale_order_no,"-","'.SOnly('company', $factory_id,'basic_name_en').'") where id=' . $params['id']);
			} else {
				M('ReturnSaleOrder')->execute('update return_sale_order set return_sale_order_no = concat("'.implode('', $service).'",id,"'.SOnly('company', $factory_id,'basic_name_en').'") where id=' . $params['id']);
			}
		}
        if($_action=='delete'){
            $detail     = M('ReturnSaleOrderDel')->field('is_related_sale_order,sale_order_id')->where('id='.$params['id'])->find();
            if($detail['is_related_sale_order']==C('IS_RELATED_SALE_ORDER')){
                D('SaleOrder')->updateSaleOrderStateById($detail['sale_order_id'],C('SHIPPED'),L('delete_return_order'));
            }
        }elseif($params['is_related_sale_order']==C('IS_RELATED_SALE_ORDER') && array_key_exists($params['return_reason'], C('RETURN_REASON'))){
			if (in_array($params['return_reason'], C('RETURN_REASON_OF_SALE_ORDER_STATE_BUYER_RETURN'))) {
				$state	= C('SALE_ORDER_BUYER_RETURN');//买家退货
			} elseif($params['return_reason'] == C('RETURN_REASON_OTHER_WAREHOUSE_RETURN')){
				$state	= C('SALE_ORDER_OTHER_WAREHOUSE_RETURN');//其他仓库退货
			} else {
				$state	= C('SALE_ORDER_POST_OFFICE_RETURNED');//邮局退回
			}
			D('SaleOrder')->updateSaleOrderStateById($params['sale_order_id'], $state, title($_action, 'ReturnSaleOrder') . ':' . C('RETURN_REASON.' . $params['return_reason']));
        }
	}
	
    public function updateService($return_sale_order_id){
		$model	=	M('return_sale_order_detail_service');
		$sql    = ' update return_sale_order_detail_service a 
					left join return_sale_order_detail b
					on a.return_sale_order_id = b.return_sale_order_id and a.relation_id = b.relation_id
					set a.return_sale_order_detail_id = b.id
					where a.return_sale_order_id=' . $return_sale_order_id;
		$list   = $model->query($sql);  
	}
	
	protected  function delete(&$params){ 
		if(D('ReturnSaleOrder')->checkDelete($params['id']) == 0){
			throw_json(L('return_sale_order_cant_del')); 
		}
        $count  = M('PackBox')->alias('a')->join('left join __PACK_BOX_DETAIL__ b on a.id=b.pack_box_id ')->where('b.return_sale_order_id='.$params['id'])->count();
        if($count > 0){
            throw_json(L('return_packed_not_delete'));
        }
        if (MODULE_NAME != 'CaiNiao' && APP_DEBUG !== true && cainiao_return_sale_order_id($params['id']) > 0) {
			throw_json(L('cainiao_return_not_delete'));
		}
	}
 
	protected function edit(&$params){
		if(D('ReturnSaleOrder')->checkEdit($params['id']) == 0){
			throw_json(L('return_sale_order_cant_edit'));
		}	
	}

	//用户为卖家操作
	public function getOperating(){
		if (getUser('role_type')!=C('SELLER_ROLE_TYPE') && $_SESSION[C('SUPER_ADMIN_AUTH_KEY')] !== true) {
			throw_json(L('no_rights'));
		}
	}
	
	public function insert($params){
		$this->checkQuantity($params);
		if (MODULE_NAME != 'CaiNiao' && cainiao_return_sale_order($params)) {
			$label	= getUser('role_type')==C('SELLER_ROLE_TYPE') ? '您' : '该卖家';
			throw_json($label . '不允许添加 [仓库：' . SOnly('warehouse', $params['warehouse_id'], 'w_name') . '；关联处理单号：' . C('WHETHER_RELATED_DEAL_NO.'.$params['is_related_sale_order']) . '] 类型的退货单！');
		}
	}
	
	public function update($params){
		if (MODULE_NAME != 'CaiNiao') {
			$this->edit($params);
		}
		$this->checkQuantity($params);
		$this->cainiaoCheckState($params);
	}

	public function checkQuantity($params){
		$_action		= $params['_action'] ? $params['_action'] : getTrueAction();
		$tmp_detail		= _formatList($params['detail']);
		$detail_total   = $tmp_detail['total']['quantity'];
		//退货单退货总数量
		if($detail_total===0){
			throw_json('退货单退货数量不能为0');
		}
		//退货不关联处理单号 added by jp 20141112
		if(isset($params['is_related_sale_order']) && $params['is_related_sale_order'] != C('IS_RELATED_SALE_ORDER')) {
			return;
		}		
		$new_params		= array(); 
		$attr		    = array('warehouse_id','product_id'); 
		foreach ($params['detail'] as $value){ 
			if ($value['product_id'] > 0 && $value['quantity'] > 0) {
				$key = array(); 
				foreach ($attr as $field){
					if(!isset($value[$field]) && !isset($params[$field])){
						throw_json('ReturnSaleOrder '.$field.'不存在库存规格数据，无法进行数量验证！');
					}
					$key[] = $value[$field] ? $value[$field] : $value[$field] = $params[$field];
				}
				$key = implode('_', $key);
				if (isset($new_params[$key])) {
					$new_params[$key]['quantity'] += $value['quantity'];
				}else {
					$new_params[$key] = $value;
				}
			}
		} 
		if($new_params){
			$model	=	M('return_sale_order_detail');
			$ext_where = $_action == 'update' ? ' and a.id!='.$params['id'] : '';
			foreach($params['detail'] as $key => $val){
				$warehouse_id	= $params['warehouse_id'] ? $params['warehouse_id'] : $val['warehouse_id'];
				if ($val['product_id'] > 0 && $val['quantity'] > 0) {
					$db_key = $warehouse_id.'_'.$val['product_id'];
					if(isset($db_params[$db_key])) { continue; }
					$sql = 'select sum(quantity) as quantity,warehouse_id,product_id
							from 
							(
								select -1*quantity as quantity,b.warehouse_id,product_id
								from return_sale_order a
								left join return_sale_order_detail b
								on a.id=b.return_sale_order_id
								where a.sale_order_id='.$params['sale_order_id'].$ext_where.'
								and b.product_id='.$val['product_id'].'
								and b.warehouse_id='.$warehouse_id.'
								union all
								select quantity,b.warehouse_id,product_id
								from sale_order a
								left join sale_order_detail b
								on a.id=b.sale_order_id
								where a.id='.$params['sale_order_id'].' 
								and b.product_id='.$val['product_id'].'
								and b.warehouse_id='.$warehouse_id.'
							) as tmp
							group by warehouse_id,product_id';
					$list = $model->query($sql);  
					$db_params[$db_key] = $list[0]; 
					if(isset($new_params[$db_key])&&($new_params[$db_key]['quantity']>$list[0]['quantity'])){
						 $error[]	= L('product_no').'“'.SOnly('product', $val['product_id'], 'product_no').'”'.L('sale_quantity_no_enough');
					}
				}
			}
		}
		if (!empty($error)) {
			throw_json($error);
		}
	}

	public function cainiaoCheckState($params) {
		if (cainiao_return_sale_order_id($params['id']) > 0) {
			$msg_type	= 'TRANSIT_WAREHOUSE_SIGN';
			switch ($params['return_sale_order_state']) {
				//已在菜鸟成功丢弃则禁止改回已签收
				case C('RETURN_SALE_ORDER_STATE_SIGNED')://已签收
					$dropped	= cainiao_request_not_abandon_count('TRANSIT_WAREHOUSE_INNER_CHECK_CONFIRM', $params['return_logistics_no']);
					if ($dropped > 0) {
						throw_json('该退货单已在菜鸟丢弃，不允许回退为签收！');
					}
					break;
				//已在菜鸟成功签收或正在请求菜鸟签收则禁止拒收
				case C('RETURN_SALE_ORDER_STATE_REFUSE')://拒收
					$signed		= cainiao_request_not_abandon_count($msg_type, $params['return_logistics_no']);
					if ($signed > 0) {
						throw_json('该退货单已在菜鸟签收，不允许拒收！');
					}
					break;
				//只有在菜鸟签收成功后才能进行丢弃操作
				case C('RETURN_SALE_ORDER_STATE_DROPPED')://已丢弃
					$signed		= cainiao_request_not_abandon_count($msg_type, $params['return_logistics_no']);
					if ($signed <= 0) {
						throw_json('该退货单未在菜鸟签收，不允许丢弃！');
					}
					break;
			}
		}
	}
}