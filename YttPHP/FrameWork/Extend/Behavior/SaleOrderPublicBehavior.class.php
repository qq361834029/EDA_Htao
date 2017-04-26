<?php
/**
 * 销售
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class SaleOrderPublicBehavior extends Behavior {
	
	public function run(&$params){ 
		$params['flow_type'] = 'sale_order';///定义修改状态的流程来源的类型
		T('SaleOrder')->run($params,'setState');///更改销售单状态
		$this->restoreDealPickingImport($params);//还原改销售单的拣货导入分配数量
	}
	
	///出库订单 复合订单是否可以验证发货的判断
	public function outStock($params){  
		$verifyType			   = intval($params['verifyType']);///验证发货
		if($verifyType==1){
			$id				   = intval($params['id']);  ///销售单ID
			if($id>0){
				$model         = D('SaleOrder');
				$count		   = $model->where('id='.$id.' and sale_order_state not in ('.C('SALE_ORDER_OUT_STOCK').')')->count();
				//echo $model->getLastSql();exit;
				if(intval($count)>0){
					throw_json(L('cant_out_stock'));
				}

				$rs	           = $model->getInfo($id,'out_stock');
				$quantity	   = intval($rs['detail_total']['quantity']);
				$real_quantity = intval($rs['detail_total']['real_quantity']);
				if($quantity>0&&$real_quantity>0&&$quantity==$real_quantity){
					return true;
				}else{
					throw_json('还有产品没有扫描到，不能验证发货！');
				}
			}else{
				throw_json('参数错误不可操作！');
			}
		}
	}
	
	/**
	 * 作废销售单时，还原对应拣货导入的分配数量
	 * @author jph 20140425
	 * @param array $params
	 * @return boolean
	 */
	public function restoreDealPickingImport($params) {
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        //判断是否删除发货过的销售单
        $is_out     = 0;
        $state_id   = 0;
        if($_action == 'delete'){
            //地址错误是否已经出库
            $is_out = M('StateLog')->where('object_type='.  array_search('SaleOrder', C('STATE_OBJECT_TYPE')).' and object_id='.$params['id'].' and state_id='.C('SHIPPED'))->count();
            if($is_out>0){
                $state_id   = M('sale_order_del')->where('id ='.$params['id'])->getField('sale_order_state');
                $is_out     = in_array($state_id, explode(',', C('AFTER_SHIPPED_STATE'))) ? true : false;
            }
        }
		if (($_action == 'update' && !in_array($params['sale_order_state'], explode(',', C('SALE_ORDER_UNRESTORE_DEAL')))) || $is_out) {
			$fileRelationDetail	= M('FileRelationDetail');
			$relation_picking_import		= $fileRelationDetail->field('id,object_id')->where('relation_id=' . $params['id'] . ' and file_type=' . array_search('PickingImport', C('CFG_FILE_TYPE')))->find();
            $picking_import_id				= $relation_picking_import['object_id'];
			if ($picking_import_id > 0) {
				$fileDetail			= M('FileDetail');
				//本次需要还原分配的拣货导入明细 st
				$field				= 'fd.id, fd.product_id, fd.quantity-fd.undeal_quantity-sum(ifnull(sl.quantity, 0)) as restore_quantity, undeal_quantity, undeal_quantity as org_undeal_quantity';
				$where				= 'fd.file_id=' . $picking_import_id . ' and fd.state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ',' . C('CFG_IMPORT_PROCESSED_STATE') . ')';
				$join				= 'LEFT JOIN __STORAGE_LOG__ sl on sl.main_id=fd.file_id and sl.detail_id=fd.id and sl.relation_type=' . C('STORAGE_LOG_UNDEAL_QUANTITY_TYPE');
				$file_detail_list	= $fileDetail->alias('fd')->join($join)->field($field)->where($where)->group('fd.id')->having('restore_quantity>0')->select();
                if (empty($file_detail_list)) {
					return false;
				}
				$product_list		= array();
				foreach ($file_detail_list as $file_detail) {
					$product_list[$file_detail['product_id']][$file_detail['id']]	= $file_detail;
				}
				//本次需要还原分配的拣货导入明细 ed				
				
				//销售单明细
				$sale_detail	= M('SaleOrderDetail')->where('sale_order_id=' . $params['id'])->group('product_id')->getField('product_id, sum(quantity)');
				foreach ($sale_detail as $product_id => $sale_quantity) {
					//本次分配明细中无此产品或已全部分配完（需要合计暂不处理）
					if (!isset($product_list[$product_id])){
						rollback();
						throw_json('数据异常，请立即联系客服人员！');
						exit;
					}
					foreach($product_list[$product_id] as &$restore) {
						$diff	= $sale_quantity - $restore['restore_quantity'];
						if ($diff > 0) {//不够还原，继续
							$sale_quantity									 = $diff;
							$restore['undeal_quantity']	+= $restore['restore_quantity'];
						} else {//还原完成，跳出循环
							$restore['undeal_quantity']	+= $sale_quantity;
							$sale_quantity									 = 0;
							break;
						}
					}
					//销售单有产品未全部还原分配，属于异常情况
					if ($sale_quantity > 0) {
						rollback();
						throw_json('数据异常，请立即联系客服人员！');
						exit;
					}
				}
				unset($restore);
				//解除关联绑定
				$fileRelationDetail->where('id=' . $relation_picking_import['id'])->delete();
				
				//更新未分配明细
				foreach ($product_list as $detail) {
					foreach($detail as $undeal) {
						//此次有进行实际还原分配才更新
						if ($undeal['org_undeal_quantity'] < $undeal['undeal_quantity']) {
							$undeal['undeal_quantity']	= array('exp', 'undeal_quantity+' . ($undeal['undeal_quantity'] - $undeal['org_undeal_quantity']));
							unset($undeal['org_undeal_quantity'], $undeal['restore_quantity']);
							$fileDetail->save($undeal);
						}
					}
				}				
			}
		}
	}
    
	public function checkDelete(&$params){
		$state     = M('SaleOrder')->where('id='.(int)$params['id'])->getField('sale_order_state');
        $is_shipped = M('state_log')->where('object_type='.array_search('SaleOrder', C('STATE_OBJECT_TYPE')).' and state_id='.C('SHIPPED').' and object_id='.(int)$params['id'])->group('object_id')->getField('object_id');
		if (saleOrderCheckDelete($state,$is_shipped>0) !== 1) {
			throw_json(L('cant_delete'));
		}
        //edit yyh 20151225 发过货也能删除
		$shipped	= M('StateLog')->where('object_id=' . $params['id'] . ' and object_type=2 and state_id=' . (int)C('SHIPPED'))->count();
		if ($shipped > 0) {//销售单发过货，不可删除
			throw_json(L('error_shipped_cant_del'));
		}		
		$picked	= M('FileRelationDetail')->where('relation_id=' . $params['id'] . ' and file_type=' . array_search('PickingImport',C('CFG_FILE_TYPE')))->count();
		if ($picked > 0) {//销售单已拣货完成，不可删除
			throw_json(L('error_picked_cant_del'));
		}		
	}

	public function checkEdit(&$params, $check_update = false){
		$checks		= array();
		//可编辑验证
		$checks[]	= array(
			'state'	=> M('SaleOrder')->where('id='.(int)$params['id'])->getField('sale_order_state'),
			'error'	=> L('error_cant_edit'),
		);
		if ($check_update === true) {
			//可更新验证
			$checks[]	= array(
				'state'	=> $params['sale_order_state'],
				'error'	=> L('error_cant_update'),
			);	
		}
        foreach ($checks as $check) {
            //卖家可以将地址错误修改为已作废add yyh 20160115
            if(getUser('role_type') != C('SELLER_ROLE_TYPE') || $check['state']!=C('SALEORDER_OBSOLETE') || !$check_update){
                if (saleOrderCheckEdit($check['state'],$params['id'], $params) !== 1) {
                    throw_json($check['error']);
                }
            }
		}
	}	

	public function checkUpdate(&$params){
		$sale		= M('SaleOrder')->where('id='.(int)$params['id'])->field('warehouse_id, express_id, sale_order_state')->find();
		$state		= $sale['sale_order_state'];
		$role_type	= getUser('role_type');
		//销售单状态有变化
        if ($state != $params['sale_order_state']) {
			if($role_type == C('SELLER_ROLE_TYPE')){//卖家角色
				//销售单状态有变化时 不能更新到 //3拣货中 //4拣货完成 状态
				//即 //1待处理 //2编辑中 状态 不能更新到 //3拣货中 //4拣货完成 状态
                if (in_array($params['sale_order_state'], array(C('SALE_ORDER_STATE_PICKING'), C('SALE_ORDER_STATE_PICKED'),C('SALEORDER_OBSOLETE')))){
                    if($params['sale_order_state']==C('SALEORDER_OBSOLETE')){
                        //卖家可以将地址错误修改为已作废add yyh 20160115
                        if(saleOrderCheckEdit($params['sale_order_state'],$params['id'], $params) !== 1 && $state!=C('ERROR_ADDRESS')){
                            throw_json(L('error_cant_update'));
                        }
                    }else{
                        throw_json(L('error_cant_update'));
                    }
				}				
			} else {//非卖家角色
				if(in_array($state, explode(',',C('ADMIN_SHIPPED_CAN_EDIT_STATE')))) {
					//5已发货//6邮局退回//7库存不足//8地址错误//12地址错误（邮局退回） 状态只能更新到 //5已发货//6邮局退回//7库存不足//8地址错误//12地址错误（邮局退回） 状态
                    if($state==C('SALE_ORDER_POST_OFFICE_RETURNED')){
                        $count  = M('ReturnSaleOrder')->where('sale_order_id='.$params['id'])->count();
                        if($count>0){
                            throw_json(L('error_cant_update'));
                        }
                    }
					if(!in_array($params['sale_order_state'],explode(',',C('ADMIN_SHIPPED_CAN_EDIT_STATE')))){
						throw_json(L('error_cant_update'));
					}
				} elseif ($params['sale_order_state'] == C('SHIPPED')){
					//非 //5已发货//6邮局退回//7库存不足//8地址错误//12地址错误（邮局退回） 态不能更新到 //5已发货 状态
					throw_json(L('error_cant_update'));
				}
			}
		}
		$error	= array();
		if($role_type == C('SELLER_ROLE_TYPE')){//卖家角色
			if (in_array($state, explode(',',C('SALE_CAN_ADD_STATE')))) {
				if (!in_array($state, array(C('SALE_ORDER_STATE_EDITING')))) {
					$cant_change_fields	= array(
						'warehouse_id'	=> L('warehouse_no') . ': ' . L('cant_change_current_status'),
					);
				}
			} else {
				$cant_change_fields	= array(
					'warehouse_id'	=> L('warehouse_no') . ': ' . L('cant_change_current_status'),
					'express_id'	=> L('shipping_name') . ': ' . L('cant_change_current_status'),
				);
			}
			foreach ($cant_change_fields as $field => $err) {
				if ($params[$field] != $sale[$field]) {
					$error[]	= $err;
				}
			}
		}
		if (!empty($error)) {
			throw_json(implode('<br />', $error));
		}
	}	
	
	protected function update(&$params){		
		if(trim($params['from_type'])=='out_stock'){
			$count  = M('SaleOrder')->where('id='.(int)$params['id'].' and sale_order_state not in ('.C('SALE_ORDER_OUT_STOCK').')')->count();
			if(intval($count)>0){
				throw_json(L('cant_out_stock'));
			}
		}else{
            if($params['id']>0){
                $this->checkEdit($params, true);//可编辑状态验证，可更新状态验证
                $this->checkUpdate($params);
				if($params['sale_order_state']==1){//待处理
					$this->checkVatQuota($params);
				}
            }else{
                $this->insert($params);
            }
		}
	}		
	
	public function edit(&$params){
		$this->checkEdit($params);		
	}	
	
	public function delete(&$params){
		$this->checkDelete($params);
        //added yyh 20151225验证关联 退货单/问题订单 的不能删除
        $this->checkRelationReturn($params);
	}
	
	protected function insert(&$params){	
		if(isset($params['sale_order_state']) && !in_array($params['sale_order_state'],explode(',',C('SALE_CAN_ADD_STATE')))){
			throw_json(L('invalid_data'));
		}
		$this->checkVatQuota($params);
	}
    public function checkRelationReturn($params){
        $return_sale_order  = M('ReturnSaleOrder')->where('sale_order_id='.$params['id'])->find();
        if(!empty($return_sale_order)){
            throw_json( L('relation_retuan_no_delete'));
        }
        $question_order     = M('QuestionOrder')->where('sale_order_id='.$params['id'])->find();
        if(!empty($question_order)){
            throw_json(L('relation_question_no_delete'));
        }
    }
	//20160804 VAT限额验证
	public function checkVatQuota($params){
        $result	= D('Vat')->warehouseDebtVat($params['factory_id'],(array)$params['warehouse_id']);
		if($result){
			throw_json($result);
		}
    }
}