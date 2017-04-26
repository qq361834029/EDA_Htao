<?php

/**
 * 库位信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     jph
 * @version  2.1,2014-01-17
 */

class WarehouseLocationPublicModel extends CommonModel {
	public $_asc			= true;
	public $_sortBy			= 'location_no';	
	protected $tableName	= 'warehouse_location';
	
	// 自动验证设置
	protected $_validate	 =	 array(
			array("zone_type",'require',"require",1), //库区类型必填
			array("location_no",'require',"require",1), //库区编号必填
			array("location_no",'/^[0-9a-zA-Z]{1,4}$/',"valid_zone_no",1),//不超过3位的字母或数字
			array("warehouse_id",'require',"require",1), //所属仓库必填
			array("col_number",'require',"require",1), //货架列数必填
			array("col_number",'2pst_integer',"2pst_integer",1), //货架列数为1-99的正整数
			array("",'validNo_Col','',1,'callbacks'),//验证库区编号及货架总列数
			array("",'validLocation','',1,'callbacks',2),//修改时验证库位
			array("layer_number",'require',"require",1), //货架层数必填
			array("layer_number",'1pst_integer',"1pst_integer",1), //货架层数为1-9的正整数
			array("layer_start",'require',"require",self::MUST_VALIDATE), //起始层数必填
			array("layer_start",'1pst_integer',"1pst_integer", self::MUST_VALIDATE), //起始层数为1-9的正整数
			array("layer_start",'layer_number',"starting_layers_over_the_limit", self::MUST_VALIDATE, 'elt'), //起始层数为1-9的正整数
			array("box_number",'require',"require",1), //每层单位数必填
			array("box_number",'2pst_integer',"2pst_integer",1), //货架每层单位数为1-99的正整数
	);
	
	/**
	 * 验证保存库位时的库区编号重复性及同仓库同类型库区货架总列数不超过99
	 *
	 * @author jph 20140124
	 * @param array $data
	 * @return array
	 */
	public function validNo_Col($data){    
		if ($data['warehouse_id'] > 0) {
			$where	= array(
				'warehouse_id'	=> $data['warehouse_id'],
			);
			if (isset($data['id'])) {
				$where['id']	= array('neq', $data['id']);
			}			
			$w_name	= SOnly('warehouse', $data['warehouse_id'],'w_name');
			$zone_type = C('CFG_ZONE_TYPE');
			if (!empty($data['location_no'])) {
				$where['location_no']	= $data['location_no'];
				$location_list			= $this->where($where)->select();
				if (!empty($location_list) && $data['col_number'] > 0 && $data['layer_number'] > 0 && $data['box_number'] > 0) {
					$spec	= array('layer', 'col', 'box');
					foreach ($spec as $type) {
						$range[$type]	= $this->getLocationRange($data, $type);
					}
					foreach ($location_list as $location) {
						$intersect	= true;
						foreach ($spec as $type) {
							$intersect	= $intersect && count(array_intersect($range[$type], $this->getLocationRange($location, $type))) > 0;
						}
						if ($intersect) {
							$error['name']	= 'location_no';
							$error['value']	= L('location_overlap');
							$this->error[]	= $error;
							break;
						}
					}
				}
				unset($where['location_no']);
			}
			if (false && $data['col_number'] > 0) {//验证同仓库同库区类型总货架列数不超过99 //edited by jp 20140312 取消该验证
				$where['zone_type']	= $data['zone_type'];
				$rs					= $this->field('sum(col_number) as sum')->where($where)->find();
				if ($rs['sum'] + (int)$data['col_number'] > 99) {
					$error['name']	= 'col_number';
					$error['value']	= sprintf(L('zone_all_col_num_over_limit'), $w_name, $zone_type[$data['zone_type']]);
					$this->error[]	= $error;			
				}
			}
		}
	}

	public function getLocationRange($location, $type){
		$start	= $location[$type . '_start'] > 0 ? $location[$type . '_start'] : 1;
		return range($start, $location[$type . '_number']);
	}

		/**
	 * 验证更新库位时的货架列数，层数，格子数是否合法（减少的库位中不存在产品）
	 *
	 * @autor jph 20140124
	 * @param array $data
	 * @return array
	 */
	public function validLocation($data){   
		$id	= (int)$data['id'];
		if ($id > 0) {
			$old_data	= M('WarehouseLocation')->find($_POST['id']);
			$spec		= array('col' => L('shelves_cols'), 'layer' => L('shelves_layers'), 'box' => L('layer_boxs'));
			foreach ($spec as $name => $label) {
				$key	= $name . '_number';
				if ($data[$key] < $old_data[$key]) {
					$error['name']	= $key;
					$error['value']	= sprintf(L('not_less_than'), $label, $label);
					$this->error[]	= $error;
				}
			}
			if ($data['layer_start'] > $old_data['layer_start']) {
				$error['name']	= 'layer_start';
				$label			= L('starting_layers');
				$error['value']	= sprintf(L('not_greater_than'), $label, $label);
				$this->error[]	= $error;
			}
//			$spec		= array('col', 'layer', 'box');
//			$fields		= array();
//			foreach ($spec as $name) {
//				$ext_condition	= ($name == 'layer' ? ' or layer_no<' . (int)$data['layer_start']: '');
//				$fields[]	= "sum(if(l." . $name . "_no>" . (int)$data[$name . '_number'] . $ext_condition . ",1,0)) as " . $name;
//			}
//			$err_msg	= L('exist_product_on_location');
//			$rs = $this->query('select ' . implode(',', $fields) . ' from storage s left join location l on s.location_id=l.id where (quantity<>0 or picking_quantity<>0) and warehouse_location_id=' . $id . ' group by warehouse_location_id');
//			foreach ($spec as $name) {
//				if ($rs[0][$name] > 0) {
//					$error['name']	= $name . '_number';
//					$error['value']	= $err_msg;
//					$this->error[]	= $error;
//				}
//			}
		}
	}		
}