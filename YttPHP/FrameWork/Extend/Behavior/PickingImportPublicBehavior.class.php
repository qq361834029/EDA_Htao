<?php

/**
 * 拣货导入
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    拣货
 * @package   Behavior
 * @author     jph
 * @version  2.1,2014-04-19
 */

class PickingImportPublicBehavior extends FileListPublicBehavior {
	
	public $import_key	= 'PickingImport';
	
	public function updateFollowProcess(&$params) {
		$rs						= M('FileDetail')->field('fd.file_id, fl.relation_id')->join('fd left join file_list fl on fl.id=fd.file_id')->where('fd.id=' . $params['id'])->find();
		$params['file_id']		= $rs['file_id'];//更新关联记录时需要用到
		//获取拣货导入单绑定的拣货导出单
		$params['picking_id']	= $rs['relation_id'];
		//未分配数量大于0且状态为导入成功或已处理状态
		$this->dealPicking($params);
	}
	
	public function insertFollowProcess(&$params) {
		$params['file_id']		= $params['id'];//更新关联记录时需要用到
		$params['picking_id']	= $params['relation_id'];
		//通过缓存分配拣货
		$this->dealPickingByCache($params);
		//分配拣货
//		$this->dealPicking($params);

	}	
	
	public function dealPickingByCache(&$params){
		$pickingSaleOrder = S('picking:saleOrder:'.$params['picking_no']);			//拣货导出订单缓存
		$pickingProduct = S('picking:product:'.$params['picking_no']);				//拣货导出产品缓存
		$pickImportProduct = S('pickImport:remainProduct:'.$params['picking_no']);  //拣货导入产品缓存
		if(empty($pickingSaleOrder) || empty($pickingSaleOrder) || empty($pickingSaleOrder)){
			return false;
		}
		
		
		//将不同库位的产品数量累加起来
		foreach($pickImportProduct as $import_product_id=>$value){
			foreach ($value as $v){
				$tempArr[$import_product_id] += $v;
			}
		}
		$pickImportProduct = $tempArr;
		unset($tempArr);
		asort($pickImportProduct);
		//进行拣货订单分配
		foreach($pickImportProduct as $import_product_id=>&$import_quantity){
			asort($pickingProduct[$import_product_id]);
			foreach($pickingProduct[$import_product_id] as $sale_order_id=>&$sale_order_quantity){
				if($sale_order_quantity <= $import_quantity){										//某订单一产品数量足够拣货分配
					foreach($pickingSaleOrder[$sale_order_id] as $product_id=>&$product_quantity){	//循环出该产品订单的所有产品
						if($product_quantity > $pickImportProduct[$product_id] ){					//判断该订单产品是否都足够拣货分配
							$is_pick = false;
							break;
						}
					}
					//满足则放入待出库订单缓存数组，抵扣拣货导入产品数量,并删除拣货导出缓存中的该订单
					if($is_pick !== false){
						$update_sale_order[$sale_order_id] = $sale_order_id;	//需要更新状态的订单	
						foreach($pickingSaleOrder[$sale_order_id] as $product_id=>$product_quantity){ 
							$pickedSaleOrder[$product_id][] = $sale_order_id;	//待出库订单缓存数组
							$pickImportProduct[$product_id] -=  $product_quantity;
							unset($pickingProduct[$product_id][$sale_order_id]);
						}
						unset($pickingSaleOrder[$sale_order_id]);
					}
				}
			}
		}
		if($update_sale_order){
			//更新销售单位拣货完成状态并记录状态日志
			D('SaleOrder')->updateSaleOrderStateById($update_sale_order, C('SALE_ORDER_STATE_PICKED'), L('module_PickingImport'));
			//更新缓存
			S('picking:saleOrder:'.$params['picking_no'],$pickingSaleOrder);
			S('picking:product:'.$params['picking_no'],$pickingProduct);
			S('pickImport:remainProduct:'.$params['picking_no'],$pickImportProduct);
			S('pickImport:saleOrder:'.$params['warehouse_id'].'_'.$params['pick_no'],$pickedSaleOrder);
			unset($update_sale_order,$pickedSaleOrder,$pickingSaleOrder,$pickingProduct,$pickImportProduct);
		}
		return true;
	}
	
	
	public function dealPicking(&$params){
		$fileDetail			= M('FileDetail');
		//本次分配的拣货导入明细 st
		$file_detail_list	= $fileDetail->field('*')->where('file_id=' . $params['file_id'] . ' and undeal_quantity>0 and state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ',' . C('CFG_IMPORT_PROCESSED_STATE') . ')')->select();
		if (empty($file_detail_list)) {
			return false;
		}
		$product_list		= array();
		$product_quantity_list	= array();
		foreach ($file_detail_list as $file_detail) {
			$product_list[$file_detail['product_id']][$file_detail['location_id']]		= $file_detail;
			$product_quantity_list[$file_detail['product_id']]['undeal_quantity']		+= $file_detail['undeal_quantity'];
			$product_quantity_list[$file_detail['product_id']]['org_undeal_quantity']	+= $file_detail['undeal_quantity'];
		}
		unset($file_detail_list);
		//本次分配的拣货导入明细 ed

		$fileRelationDetail	= M('FileRelationDetail');
		//需要分配的拣货中或已发货销售单明细 st (根据拣货导入绑定的拣货导出单，找到拣货导出单绑定的销售单，需要排除已分配完成的销售单，否则在异常处理时有可能重新进行分配)
		//增加需要分配拣货的销售单状态： 库存不足，地址错误，地址已改，邮局退回,地址错误（邮局退回） added by jp 20141218
		$sale_detail_field	= 'c.sale_order_id, c.product_id, sum(c.quantity) AS quantity, b.sale_order_state';
		$sale_detail_join	= 'a left join sale_order b on a.relation_id=b.id left join sale_order_detail c on c.sale_order_id=b.id';
		$file_detail_where	= 'a.file_type=' . array_search('Picking', C('CFG_FILE_TYPE')) . ' and a.object_id=' . $params['picking_id'];
		$sale_detail_where	= $file_detail_where . ' and b.sale_order_state in (' . C('SALE_ORDER_STATE_PICKING') . ', ' . C('SHIPPED') . ', ' .C('SALE_ORDER_STATE_OUT_STOCK') . ', ' .C('ERROR_ADDRESS') . ', ' .C('ADDRESS_CHANGED') . ', ' .C('SALE_ORDER_POST_OFFICE_RETURNED') .','.C('ADDRESS_ERROR_RETURNED'). ')';
		//过滤已分配完成的销售单
		$picking_sale_list	= $fileRelationDetail->alias('a')->where($file_detail_where)->getField('relation_id', true);//拣货导出的销售单
		$deal_sale_list		= $fileRelationDetail->where('file_type=' . array_search('PickingImport', C('CFG_FILE_TYPE')) . ' and relation_id in (' . implode(',', $picking_sale_list) . ')')->getField('relation_id', true);
		if ($deal_sale_list) {
			$picking_sale_list	= array_diff($picking_sale_list, $deal_sale_list);
			unset($deal_sale_list);
		}
		if (empty($picking_sale_list)) {
			return false;
		}
		$sale_detail_where	.= ' and b.id in(' . implode(',', $picking_sale_list) . ')';
		unset($picking_sale_list);
		$sale_detail_list	= $fileRelationDetail->field($sale_detail_field)
												->join($sale_detail_join)
												->where($sale_detail_where)
												->group('c.sale_order_id, c.product_id')
												->order('c.sale_order_id')
												->select();
		if (empty($sale_detail_list)) {
			return false;
		}
		$sale_list			= array();
		$sale_state_list	= array();//用于记录销售单状态
		foreach ($sale_detail_list as $sale_detail) {
			$sale_list[$sale_detail['sale_order_id']][$sale_detail['product_id']]	= $sale_detail['quantity'];
			$sale_state_list[$sale_detail['sale_order_id']]							= $sale_detail['sale_order_state'];
		}
		unset($sale_detail_list);
		//需要分配的拣货中或已发货销售单明细 ed

		//进行分配 按销售单分配，销售单中每个产品都够分配则分配此销售单，否则跳过
		$picked_sale_order	= array();
		foreach ($sale_list as $sale_order_id => $sale_detail) {
			$is_picked	= true;
			$temp_product_list	= $product_quantity_list;
			foreach ($sale_detail as $product_id => $sale_quantity) {
				//本次分配明细中无此产品或已全部分配完（需要合计暂不处理）
				if (!isset($temp_product_list[$product_id])){
					$is_picked	= false;
					break;
				}
				$diff	= $sale_quantity - $temp_product_list[$product_id]['undeal_quantity'];
				if ($diff > 0) {//不够分配，继续
					$is_picked	= false;
					break;
				} else {
					$temp_product_list[$product_id]['undeal_quantity']	-= $sale_quantity;
				}
			}
			//该销售单可以分配，记录销售单id后面更新为拣货完成状态；更新未分配明细
			if ($is_picked) {
				$picked_sale_order[$sale_order_id]	= $sale_order_id;
				$product_quantity_list				= $temp_product_list;
			}

		}
		unset($temp_product_list, $sale_list);
		if ($picked_sale_order) {
			$file_type						= array_search('PickingImport', C('CFG_FILE_TYPE'));
			$insert_relation_detail			= array();		
			$update_state_sale_order		= array();
			foreach ($picked_sale_order as $sale_order_id) {
				if ($sale_state_list[$sale_order_id] == C('SALE_ORDER_STATE_PICKING')) {//拣货中状态的订单才更新状态为拣货完成
					$update_state_sale_order[$sale_order_id]	= $sale_order_id;
				}
				$insert_relation_detail[]	= array('object_id'=>$params['file_id'], 'relation_id'=>$sale_order_id, 'file_type'=> $file_type);
			}
			//插入关联记录
			$fileRelationDetail->addAll($insert_relation_detail);
			//更新销售单位拣货完成状态并记录状态日志
			D('SaleOrder')->updateSaleOrderStateById($update_state_sale_order, C('SALE_ORDER_STATE_PICKED'), L('module_PickingImport'));
			unset($picked_sale_order, $fileRelationDetail, $insert_relation_detail, $update_state_sale_order);
			//更新未分配明细
			$deal	= array();
            
			foreach ($product_quantity_list as $product_id => $undeal) {
                //此次有进行实际分配才更新
                if ($undeal['org_undeal_quantity'] > $undeal['undeal_quantity']) {
                    $deal[$product_id]	= $undeal['org_undeal_quantity'] - $undeal['undeal_quantity'];
                    $product_id_arr[]   = $product_id;
                }
			}
            if(!isset($params['relation_id'])){//拣货导入异常
                $params['relation_id']  = M('file_list')->where('id='.$params['file_id'])->getField('relation_id');
            }
            $stock_out_info = M('stock_out')->where('product_id in ('.implode(',', $product_id_arr).') and out_relation_type=11 and main_id='.$params['relation_id'])->order('in_date desc')->getField('id,product_id,in_location_id as location_id,quantity');
            foreach($stock_out_info as $value){
                $stock[$value['product_id']][]  = $value; 
            }
            foreach($deal as $product_id=>$deal_quantity){
                foreach($stock[$product_id] as $stock_info){
                    if($deal_quantity > $stock_info['quantity']){
                        $stock_out[$product_id][$stock_info['location_id']] += $stock_info['quantity'];
                        $deal_quantity  -= $stock_info['quantity'];
                    }else{
                        $stock_out[$product_id][$stock_info['location_id']] += $deal_quantity;
                        break;
                    }
                }
            }
//                $out_stock  = M('out_stock')->where('product_id='.$p_id.'')->select();
            
			$updateAll	= array();
			foreach ($stock_out as $product_id=>$val) {
                foreach($val as $location_id=>$quantity){
                    $undeal_quantity    = $product_list[$product_id][$location_id];
                    $undeal_quantity['undeal_quantity'] -= $quantity;
					if ($undeal_quantity['undeal_quantity'] < 0) {
						rollback();
						throw_json(L('分配拣货数量出现异常，请立即联系客服人员!'));
					}
                    $updateAll[]        = $undeal_quantity;
                }
			}
			unset($product_list);
			if (count($updateAll) > 0) {
				$fileDetail->addAll($updateAll, array(), true);
				unset($fileDetail, $updateAll);
			}
		}
		return true;
	}
//	public function dealPicking(&$params){
//		$fileDetail			= M('FileDetail');
//		//本次分配的拣货导入明细 st
//		$file_detail_list	= $fileDetail->field('*, undeal_quantity as org_undeal_quantity')->where('file_id=' . $params['file_id'] . ' and undeal_quantity>0 and state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ',' . C('CFG_IMPORT_PROCESSED_STATE') . ')')->select();
//		if (empty($file_detail_list)) {
//			return false;
//		}
//		$product_list		= array();
//		foreach ($file_detail_list as $file_detail) {
//			$product_list[$file_detail['product_id']][$file_detail['id']]	= $file_detail;
//            $product_quantity_list[$file_detail['product_id']]['undeal_quantity']		+= $file_detail['undeal_quantity'];
//			$product_quantity_list[$file_detail['product_id']]['org_undeal_quantity']	+= $file_detail['undeal_quantity'];
//		}
//		unset($file_detail_list);
//		//本次分配的拣货导入明细 ed
//
//		$fileRelationDetail	= M('FileRelationDetail');
//		//需要分配的拣货中或已发货销售单明细 st (根据拣货导入绑定的拣货导出单，找到拣货导出单绑定的销售单，需要排除已分配完成的销售单，否则在异常处理时有可能重新进行分配)
//		//增加需要分配拣货的销售单状态： 库存不足，地址错误，地址已改，邮局退回,地址错误（邮局退回） added by jp 20141218
//		$sale_detail_field	= 'c.sale_order_id, c.product_id, sum(c.quantity) AS quantity, b.sale_order_state';
//		$sale_detail_join	= 'a left join sale_order b on a.relation_id=b.id left join sale_order_detail c on c.sale_order_id=b.id';
//		$file_detail_where	= 'a.file_type=' . array_search('Picking', C('CFG_FILE_TYPE')) . ' and a.object_id=' . $params['picking_id'];
//		$sale_detail_where	= $file_detail_where . ' and b.sale_order_state in (' . C('SALE_ORDER_STATE_PICKING') . ', ' . C('SHIPPED') . ', ' .C('SALE_ORDER_STATE_OUT_STOCK') . ', ' .C('ERROR_ADDRESS') . ', ' .C('ADDRESS_CHANGED') . ', ' .C('SALE_ORDER_POST_OFFICE_RETURNED') .','.C('ADDRESS_ERROR_RETURNED'). ')';
//		//过滤已分配完成的销售单
//		$picking_sale_list	= $fileRelationDetail->alias('a')->where($file_detail_where)->getField('relation_id', true);//拣货导出的销售单
//		$deal_sale_list		= $fileRelationDetail->where('file_type=' . array_search('PickingImport', C('CFG_FILE_TYPE')) . ' and relation_id in (' . implode(',', $picking_sale_list) . ')')->getField('relation_id', true);
//		if ($deal_sale_list) {
//			$picking_sale_list	= array_diff($picking_sale_list, $deal_sale_list);
//			unset($deal_sale_list);
//		}
//		if (empty($picking_sale_list)) {
//			return false;
//		}
//		$sale_detail_where	.= ' and b.id in(' . implode(',', $picking_sale_list) . ')';
//		unset($picking_sale_list);
//		$sale_detail_list	= $fileRelationDetail->field($sale_detail_field)
//												->join($sale_detail_join)
//												->where($sale_detail_where)
//												->group('c.sale_order_id, c.product_id')
//												->order('c.sale_order_id')
//												->select();
//		if (empty($sale_detail_list)) {
//			return false;
//		}
//		$sale_list			= array();
//		$sale_state_list	= array();//用于记录销售单状态
//		foreach ($sale_detail_list as $sale_detail) {
//			$sale_list[$sale_detail['sale_order_id']][$sale_detail['product_id']]	= $sale_detail['quantity'];
//			$sale_state_list[$sale_detail['sale_order_id']]							= $sale_detail['sale_order_state'];
//		}
//		unset($sale_detail_list);
//		//需要分配的拣货中或已发货销售单明细 ed
//
//		//进行分配 按销售单分配，销售单中每个产品都够分配则分配此销售单，否则跳过
//		$picked_sale_order	= array();
//		foreach ($sale_list as $sale_order_id => $sale_detail) {
//			$is_picked	= true;
//			$temp_product_list	= $product_list;
//			foreach ($sale_detail as $product_id => $sale_quantity) {
//				//本次分配明细中无此产品或已全部分配完（需要合计暂不处理）
//				if (!isset($temp_product_list[$product_id])){
//					$is_picked	= false;
//					break;
//				}
//				foreach($temp_product_list[$product_id] as &$undeal) {
//					//此产品已全部分配完
//					if ($undeal['undeal_quantity'] == 0) {
//						continue;
//					}
//					$diff	= $sale_quantity - $undeal['undeal_quantity'];
//					if ($diff > 0) {//不够分配，继续
//						$sale_quantity				 = $diff;
//						$undeal['undeal_quantity']	 = 0;
//					} else {//分配完成，跳出循环
//						$undeal['undeal_quantity']	-= $sale_quantity;
//						$sale_quantity				 = 0;
//						break;
//					}
//				}
//				//数量不足以分配，标记该销售单不分配，跳出循环
//				if ($sale_quantity > 0) {
//					$is_picked	= false;
//					break;
//				}
//			}
//			//该销售单可以分配，记录销售单id后面更新为拣货完成状态；更新未分配明细
//			if ($is_picked) {
//				$picked_sale_order[$sale_order_id]	= $sale_order_id;
//				$product_list						= $temp_product_list;
//				unset($undeal);//删除变量以解除地址引用，因为后面代码有以该名称作变量名，没解除引用会出问题
//			}
//
//		}
//		unset($temp_product_list, $sale_list);
//		if ($picked_sale_order) {
//			$file_type						= array_search('PickingImport', C('CFG_FILE_TYPE'));
//			$insert_relation_detail			= array();		
//			$update_state_sale_order		= array();
//			foreach ($picked_sale_order as $sale_order_id) {
//				if ($sale_state_list[$sale_order_id] == C('SALE_ORDER_STATE_PICKING')) {//拣货中状态的订单才更新状态为拣货完成
//					$update_state_sale_order[$sale_order_id]	= $sale_order_id;
//				}
//				$insert_relation_detail[]	= array('object_id'=>$params['file_id'], 'relation_id'=>$sale_order_id, 'file_type'=> $file_type);
//			}
//			//插入关联记录
//			$fileRelationDetail->addAll($insert_relation_detail);
//			//更新销售单位拣货完成状态并记录状态日志
//			D('SaleOrder')->updateSaleOrderStateById($update_state_sale_order, C('SALE_ORDER_STATE_PICKED'), L('module_PickingImport'));
//			unset($picked_sale_order, $fileRelationDetail, $insert_relation_detail, $update_state_sale_order);
//			//更新未分配明细
//			$updateAll	= array();
//			foreach ($product_list as $detail) {
//				foreach($detail as $undeal) {
//					//此次有进行实际分配才更新
//					if ($undeal['org_undeal_quantity'] > $undeal['undeal_quantity']) {
//						unset($undeal['org_undeal_quantity']);
//						$updateAll[]	= $undeal;
//					}
//				}
//			}
//			unset($product_list);
//			if (count($updateAll) > 0) {
//				$fileDetail->addAll($updateAll, array(), true);
//				unset($fileDetail, $updateAll);
//			}
//		}
//		return true;
//	}
	
	/// 删除时检验
	protected function delete(&$params){
		//已发货状态销售单数量
//		$count	= M('FileRelationDetail')->join('a left join state_log b on b.object_id=a.relation_id')->where('a.object_id=' . (int)$params['id'] . ' and a.file_type=' . $this->_file_type . ' and b.object_type=2 and b.state_id=' . C('SHIPPED'))->count();
        $picking_id = M('FileList')->where('id='.$params['id']. ' and file_type=' . $this->_file_type )->getField('relation_id');
        $count	= M('FileRelationDetail')->join('a left join state_log b on b.object_id=a.relation_id')->where('a.object_id=' . (int)$picking_id . ' and a.file_type=2 and b.object_type=2 and b.state_id=' . C('SHIPPED'))->count();
        if ($count > 0 || $count_del>0) {//导入产品所属销售单已发货，则不可删除
			throw_json(L('error_sale_order_shipped_cant_del'));
		}
	}	
	
	public function deleteFollowProcess(&$params) {
		//解除拣货导出绑定
		$picking_update_info	= M('FileListDel')->field('relation_id as id,0 as relation_id')->where('id=' . (int)$params['id'])->find();
		M('FileList')->save($picking_update_info);
		//还原订单状态至“拣货中”
		$sale_order_list	= M('FileRelationDetailDel')->where('file_type=' . $this->_file_type . ' and object_id=' . (int)$params['id'])->getField('relation_id', true);
		D('SaleOrder')->updateSaleOrderStateById($sale_order_list, C('SALE_ORDER_STATE_PICKING'), title(ACTION_NAME, MODULE_NAME));
	}
	
	/// 更新时时检验
	protected function update(&$params){
		if ($params['state'] == C('CFG_IMPORT_PROCESSED_STATE')) {//状态为已处理
			$storage_quantity	= M('Storage')->where('warehouse_id=' . (int)$params['warehouse_id'] . ' and location_id=' . (int)$params['location_id'] . ' and product_id=' . (int)$params['product_id'])->getField('quantity');
			if ($storage_quantity<$params['quantity']) {
				throw_json(L('storage_no_enough'));
			}
		}		
	}	
	
	/// 已重新上架
	protected function backShelves(&$params){
		$options			= array(
								'field'		=> 'sum(state=' . C('CFG_IMPORT_FAILED_STATE') . ') as untreated_count,sum(undeal_quantity) AS undeal_quantity',
								'where'		=> 'file_id = ' . $params['id'],
								'group'		=> 'file_id',
							);
		$fileDetailModel	= M('FileDetail');
		$undeal_quantity	= $fileDetailModel->find($options);
		if ($undeal_quantity['untreated_count'] > 0) {//存在未处理拣货异常明细
			throw_json(L('error_exists_untreated_picking_abnormal'));
		}
		if ($undeal_quantity['undeal_quantity'] <= 0) {//不存在未分配数量
			throw_json(L('error_does_not_exist_undeal_quantity'));
		}
	}
}