<?php

/**
 * 库位信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     jph
 * @version  2.1,2014-01-17
 */

class WarehouseLocationPublicAction extends BasicCommonAction {

	protected $_default_post	=  array('query'=>array('to_hide'=>1));
	protected $_cacheDd 		=  array(19);//table:field->dd:id
	protected $_old_data;//更新前数据
	public	  $_delimiter		= '-';
	public	  $_spad_length		= 2;
	public	  $_spad_string		= '0';

	public function _after_insert(){ 
    	$this->createLocation();//生成库位表
	}
	
	public function _before_update() {
		//更新前的库区信息（用于判断是否更新库位）
		$this->_old_data	= M('WarehouseLocation')->find($_POST['id']);
	}

	public function _after_update(){
		$this->updateLocation();//更新库位表
	}
	
	/**
	 * 生成库位表
	 * 
	 * @author jph 20140124
	 */
	public function createLocation(){
		M('Location')->addAll($this->getLocationDataList());
		parent::_after_insert();
	}
	
	/**
	 * 更新库位表
	 * 
	 * @author jph 20140124
	 */
	public function updateLocation(){ 
		$model	= M('Location');
		$where	= 'warehouse_location_id=' . $this->id;
		$ware_location	= M('WarehouseLocation')->find($this->id);
		if ($this->_old_data['warehouse_id'] != $ware_location['warehouse_id']) {//更新所属仓库,更新条形码中的仓库编号
			$model->where($where)->setField('warehouse_id', $ware_location['warehouse_id']);
			$update_barcode	= true;
		}
		if ($this->_old_data['location_no'] != $ware_location['location_no']) {//更新条形码中的库区编号
			$update_barcode	= true;
		}
		if ($update_barcode	=== true) {
			$this->updateBarcodeNo($where);
		}
		if ($this->_old_data['path_sort'] != $ware_location['path_sort']) {//更新条形码中的优先级
			$model->where($where)->setField('path_sort', $ware_location['path_sort']);
		}		
		M('Storage')->where('quantity=0 and picking_quantity=0')->delete();//删除数量为零的库存记录 避免后面location_id错乱

		$start		= array();
		$del_where	= array();
		$start_diff	= $ware_location['layer_start'] - $this->_old_data['layer_start'];//新旧起始层数差异
		if ($start_diff < 0) {//需要补齐库位
			$start['layer_start']	= $ware_location['layer_start'];
		} elseif ($start_diff > 0) {//更新前已验证可删除，故此处不在验证，直接删除
			$del_where[$name]		= 'layer_no<' . $ware_location['layer_start'];
		}
		$spec		= array('col', 'layer', 'box');
		foreach ($spec as $name) {
			$name_number	= $name . '_number';
			$diff	= $ware_location[$name_number] - $this->_old_data[$name_number];//新旧数据差异
			if ($diff > 0) {//需要补齐库位
				$start[$name]		= $this->_old_data[$name_number] + 1;
			} elseif ($diff < 0) {//更新前已验证可删除，故此处不在验证，直接删除
				$del_where[$name]	= $name . '_no>' . $ware_location[$name_number];
			}			
		}
		if (!empty($start)) {//需要补齐库位
			/***
			 * b0为原来的起始层数
			 * b1为新的起始层数
			 * A0,B0,C0为原来的col，layer，box数目
			 * A1,B1,C1为新的col，layer，box数目
			 * 补齐步骤如下
			 * A0+1->A1,		b1->B1,				1->C1
			 *    1->A0, b1->b0-1 及 B0+1->B1,		1->C1
			 *    1->A0,		b0->B0,				C0+1->C1
			 */
			$dataList	= array();
			//A0+1->A1,	b1->B1,		1->C1
			if (isset($start['col'])) {
				$dataList						= array_merge($dataList, $this->getLocationDataList($ware_location, array('col' => $start['col'], 'layer' => $ware_location['layer_start'])));
				$ware_location['col_number']	= $this->_old_data['col_number'];
			}
			//1->A0,	b1->b0-1,	1->C1
			if (isset($start['layer_start'])) {
				$layer_number					= $ware_location['layer_number'];
				$ware_location['layer_number']	= $this->_old_data['layer_start'] - 1;
				$dataList						= array_merge($dataList, $this->getLocationDataList($ware_location, array('layer' => $ware_location['layer_start'])));
				$ware_location['layer_number']	= $layer_number;
			}
			//1->A0,	B0+1->B1,	1->C1
			if (isset($start['layer'])) {
				$dataList						= array_merge($dataList, $this->getLocationDataList($ware_location, array('layer' => $start['layer'])));
				$ware_location['layer_number']	= $this->_old_data['layer_number'];
			}
			//1->A0,	b0->B0,		C0+1->C1
			if (isset($start['box'])) {
				$dataList						= array_merge($dataList, $this->getLocationDataList($ware_location, array('box' => $start['box'], 'layer' => $this->_old_data['layer_start'])));
			}
			if (!empty($dataList)) {//补齐库位
				$model->addAll($dataList);
			}
		}
		if (!empty($del_where)) {//删除多余库位
			$where	.= ' and (' . implode(' or ', $del_where) . ')';
			$model->where($where)->delete();
		}
		parent::_after_update();
	}	
	
	public function _before_index(){
  		getOutPutRand();
  	}	
	
	/**
	 * 补齐字符串到指定长度（默认补齐方式为左边）
	 * 
	 * @author jph 20140124
	 * @param string $str
	 * @return string
	 */
	public function strPad($str) {
		return str_pad($str, $this->_spad_length , $this->_spad_string, STR_PAD_LEFT);
	}
	
	/**
	 * 补齐字段值到指定长度（默认补齐方式为左边）
	 * 
	 * @author jph 20140414
	 * @param string $field
	 * @return string
	 */
	public function fieldPad($field) {
		return 'lpad(' . $field . ',' . $this->_spad_length . ',' . $this->_spad_string . ')';
	}	
	
	/**
	 * 获取生成库位表数据
	 * 
	 * @author jph 20140124
	 * @param array $ware_location 库区信息
	 * @param array $start 列，层，格的起始编号集合
	 * @param int $end_layer
	 * @return array
	 */
	public function getLocationDataList($ware_location = array(), $start = array('col' => 1, 'layer' => 1, 'box' => 1)){
		if (empty($ware_location)) {
			$ware_location	= M('WarehouseLocation')->find($this->id);
		}
		//起始层数小于可用起始层数
		if ($start['layer'] < $ware_location['layer_start']) {
			$start['layer']	= $ware_location['layer_start'];
		}
		$spec	= array('col', 'layer', 'box');
		foreach ($spec as $name) {
			$start[$name]	= $start[$name] > 0 ? (int)$start[$name] : 1;
		}
		for($col = $start['col']; $col <= $ware_location['col_number']; $col++) {
			for($layer = $start['layer']; $layer <= $ware_location['layer_number']; $layer++) {
				for($box = $start['box']; $box <= $ware_location['box_number']; $box++) {
					$data		= array(
						'w_no'			=> SOnly('warehouse', $ware_location['warehouse_id'], 'w_no'),
						'location_no'	=> $ware_location['location_no'],
						'col_no'		=> $this->strPad($col),
						'layer_no'		=> $this->strPad($layer),
						'box_no'		=> $this->strPad($box),
					);
					$barcode_no	= $this->createBarcodeNo($data);
					$dataList[]	= array(
										'barcode_no'			=> $barcode_no,
										'warehouse_id'			=> $ware_location['warehouse_id'],
										'warehouse_location_id'	=> $ware_location['id'],
										'col_no'				=> $col,
										'layer_no'				=> $layer,
										'box_no'				=> $box,
										'path_sort'				=> $ware_location['path_sort']
									);
				}			
			}			
		}
		return $dataList;
	}
	
	/**
	 * 生成条形码
	 * @author jph 20140226
	 * @param array $data
	 * @param string $delimiter
	 * @return string
	 */
	public function createBarcodeNo($data, $delimiter = null){
		if (is_null($delimiter)) {
			$delimiter	= $this->_delimiter;
		}
		$fields	= array('w_no', 'location_no', 'col_no', 'layer_no', 'box_no');
		foreach ($fields as $field) {
			$info[]	= $data[$field];
		}
		return implode($delimiter, $info);
	}
	
	/**
	 * 更新条形码
	 * @author jph 20140226
	 * @param string $barcode_no
	 * @param string $where
	 */
	public function updateBarcodeNo($where) {
		$data		= array(
			'w_no'			=> 'w.`w_no`',
			'location_no'	=> 'wl.`location_no`',
			'col_no'		=> $this->fieldPad('l.`col_no`'),
			'layer_no'		=> $this->fieldPad('l.`layer_no`'),
			'box_no'		=> $this->fieldPad('l.`box_no`'),
		);
		$barcode_no	= $this->createBarcodeNo($data, ",'" . $this->_delimiter . "',");
		M()->query("update `location` l 
						left join warehouse w on l.`warehouse_id`=w.id 
						left join warehouse_location wl on l.`warehouse_location_id`=wl.id 
						set l.barcode_no=concat($barcode_no)
						where " . $where);				
	}
}