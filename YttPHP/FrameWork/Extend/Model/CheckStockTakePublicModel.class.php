<?php

/**
 * 盘点检查
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	盘点检查
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class CheckStockTakePublicModel extends Model {
	protected $tableName = 'stocktake';
	protected $params 		= array();
	
	/**
	 * 盘点检查公共接口
	 *
	 * @param  参数 $params
	 * @param  方法名称，默认取模块名称，首字母转小写
	 */
	public function run($params){
		// 销售流程如果关联发货不检查返回
		if ($this->_module=='SaleOrder' && C('sale.relation_sale_follow_up')!=1) {
			return true;
		}
		// 获取当前盘点未完成的仓库信息
		$temp1 = $this->field('distinct warehouse_id as warehouse_id')->where('state=1')->select();
		$temp2 = M('Profitandloss')->field('distinct warehouse_id as warehouse_id')->where('state=1')->select();
		$warehouse_id = array();
		foreach ((array)$temp1 as $value) {
			$warehouse_id[$value['warehouse_id']] = $value['warehouse_id'];
		}
		foreach ((array)$temp2 as $value) {
			$warehouse_id[$value['warehouse_id']] = $value['warehouse_id'];
		}
		// 不存在任何限制的仓库，返回
		if(count($warehouse_id)<=0) return true;
		if ($this->_action=='delete' || $this->_action=='edit') {
			$flow_warehouse_id = $this->getDeleteWarehouse($params,$this->_module);
		}else {
			$flow_warehouse_id = $this->getSaveWarehouse($params,$this->_module);
		}
		$error = '';
		$dd_awrehouse = S('warehouse');
		foreach ((array)$flow_warehouse_id as $warehouse) {
			if(array_search($warehouse,$warehouse_id)==true){
				$error[] = L('warehouse').'“'.$dd_awrehouse[$warehouse]['w_name'].'”'.L('stocktake_error_2');
			}
		}
		if (!empty($error)) {
			throw_json($error);
		}
	}
	
	/**
	 * 根据流程获取关联到的仓库ID-－添加时使用
	 *
	 * @param array $info
	 * @param string $flow
	 * @return string array
	 */
	protected function getSaveWarehouse($info,$flow) {
		$warehouse_id = null;
		switch ($flow) {
			case 'Instock':
				return $info['warehouse_id'];
				break;
			case 'SaleOrder':
				// 不存在发货流程时才有效
				foreach ($info['detail'] as $value) {
					$warehouse_id[$value['warehouse_id']] = $value['warehouse_id'];  // 防止重复记录
				}
				return $warehouse_id;
				break;
			case 'ReturnSaleOrder':
				if ($info['return_sale_order_type']==2) {
					empty($info['sale']) && $info['sale'] = array();
					$temp = array_merge($info['detail'],$info['sale']);
				}else {
					$temp = $info['detail'];
				}
				foreach ($temp as $value) {
					if(empty($value['product_id'])) continue;
					$warehouse_id[$value['warehouse_id']] = $value['warehouse_id'];  // 防止重复记录
				}
				return $warehouse_id;
				break;
			case 'Delivery':
				foreach ($info['detail'] as $value) {
					if(empty($value['product_id'])) continue;
					$warehouse_id[$value['warehouse_id']] = $value['warehouse_id'];  // 防止重复记录
				}
				return $warehouse_id;
				break;
			case 'Adjust':
				foreach ($info['detail'] as $value) {
					if(empty($value['product_id'])) continue;
					$warehouse_id[$value['warehouse_id']] = $value['warehouse_id'];  // 防止重复记录
				}
				return $warehouse_id;
				break;
			case 'Transfer':
				foreach ($info['detail'] as $value) {
					if(empty($value['product_id'])) continue;
					$warehouse_id[$value['warehouse_id']] 		= $value['warehouse_id'];  // 防止重复记录
					$warehouse_id[$value['in_warehouse_id']] 	= $value['in_warehouse_id'];  // 防止重复记录
				}
				return $warehouse_id;
				break;
			case 'InitStorage':
				return $info['warehouse_id'];;
				break;
		}
	}
	
	/**
	 * 根据流程获取关联到的仓库ID-－编辑、删除时使用
	 *
	 * @param array $info
	 * @param string $flow
	 * @return string array
	 */
	protected function getDeleteWarehouse($info,$flow) {
		$warehouse_id = null;
		switch ($flow) {
			case 'Instock':
				$row = M('InstockDetail')->field('warehouse_id')->where('instock_id='.$info['id'])->find();
				return $row['warehouse_id'];
				break;
			case 'SaleOrder':
				$row = M('SaleOrderDetail')->field('distinct warehouse_id')->where('sale_order_id='.$info['id'])->select();
				foreach ($row as $value) {
					$warehouse_id[] = $value['warehouse_id'];
				}
				return $warehouse_id;
				break;
			case 'ReturnSaleOrder':
				$row = M('ReturnSaleOrderDetail')->field('distinct warehouse_id')->where('return_sale_order_id='.$info['id'])->select();
				foreach ($row as $value) {
					$warehouse_id[] = $value['warehouse_id'];
				}
				return $warehouse_id;
				break;
			case 'Delivery':
				$row = M('DeliveryDetail')->field('distinct warehouse_id')->where('delivery_id='.$info['id'])->select();
				foreach ($row as $value) {
					$warehouse_id[] = $value['warehouse_id'];
				}
				return $warehouse_id;
				break;
			case 'Adjust':
				$row = M('AdjustDetail')->field('distinct warehouse_id')->where('adjust_id='.$info['id'])->select();
				foreach ($row as $value) {
					$warehouse_id[] = $value['warehouse_id'];
				}
				return $warehouse_id;
				break;
			case 'Transfer':
				$row = M('TransferDetail')->field('warehouse_id,in_warehouse_id')->where('transfer_id='.$info['id'])->select();
				foreach ($row as $value) {
					$warehouse_id[] = $value['warehouse_id'];
					$warehouse_id[] = $value['in_warehouse_id'];
				}
				return array_unique($warehouse_id);
				break;
			case 'InitStorage':
				$row = M('InitStorage')->field('distinct warehouse_id')->where('id='.$info['id'])->select();
				foreach ($row as $value) {
					$warehouse_id[] = $value['warehouse_id'];
				}
				return $warehouse_id;
				break;
		}
	}
	
}