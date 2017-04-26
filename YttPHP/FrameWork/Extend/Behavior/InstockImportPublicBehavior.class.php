<?php

/**
 * 入库单导入
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    入库
 * @package   Behavior
 * @author     jph
 * @version  2.1,2014-04-03
 */

class InstockImportPublicBehavior extends FileListPublicBehavior {
	
	public $import_key	= 'InstockImport';

	public function updateFollowProcess(&$params) {
		//更新发货明细入库数量
		$sql	= 'update instock_detail a left join file_detail b on a.box_id=b.box_id and a.product_id=b.product_id set a.in_quantity=a.in_quantity+b.quantity where b.id=' . $params['id'] . ' and b.state=' . C('CFG_IMPORT_PROCESSED_STATE');
		M()->execute($sql);
		//更新发货单状态
		$file_id	= M('FileDetail')->where('id=' . $params['id'])->getField('file_id');
		$this->updateInstockState($file_id, $params['box_id']);
	}
	
	public function insertFollowProcess(&$params) {
		//更新发货明细入库数量
		$where	= 'file_id =' . $params['id'] . ' AND `state` = ' . C('CFG_IMPORT_SUCCESS_STATE');
		$sql	= 'UPDATE instock_detail a 
					RIGHT JOIN (
						SELECT product_id, sum(quantity) AS quantity, box_id
						FROM file_detail 
						WHERE ' . $where . '
						GROUP BY product_id, box_id
					)tmp 
					ON a.box_id = tmp.box_id AND a.product_id = tmp.product_id
					SET a.in_quantity = a.in_quantity+tmp.quantity';
		M()->execute($sql);
		//更新发货单状态
		$box_id	= M('FileDetail')->where($where)->group('box_id')->getField('box_id', true);
		if (count($box_id) > 0) {
			$this->updateInstockState($params['id'], $box_id);
		}
	}	

	public function getAllInstockID($file_id, $box_id){
		is_array($box_id) && $box_id	= implode(',', $box_id);
		if (empty($box_id)) {
			return array();
		}
		$file_type						= array_search('InstockImport', C('CFG_FILE_TYPE'));
		$fileRelationDetail				= M('FileRelationDetail');
		//已记录关联发货单id
		$relationed_instock_id			= $fileRelationDetail->where('object_id=' . $file_id . ' and file_type=' . $file_type)->getField('relation_id', true);
		$where							= 'id in (' . $box_id . ')';
		$all_instock_id					= M('InstockBox')->where($where)->group('instock_id')->getField('instock_id', true);
		if ($all_instock_id && $relationed_instock_id) {
			$intersect		= array_intersect($all_instock_id, $relationed_instock_id);
			//未记录关联发货单id
			$all_instock_id	= array_diff($all_instock_id, $intersect);
		}
		if ($all_instock_id && ACTION_NAME != 'delete') {
			//插入关联记录
			$insert_relation_detail			= array();
			foreach($all_instock_id as $instock_id) {
				$insert_relation_detail[]	= array('object_id'=>$file_id, 'relation_id'=>$instock_id, 'file_type'=> $file_type);
			}
			$fileRelationDetail->addAll($insert_relation_detail);
			unset($insert_relation_detail);
		}
		return $intersect ? ($all_instock_id ? array_merge($all_instock_id, $intersect) : $intersect) : $all_instock_id;
	}
	
	/// 删除时检验
	protected function delete(&$params){
		//已费用结清发货单数量
		$count	= M('FileRelationDetail')->join('a left join instock b on b.id=a.relation_id')->where('a.object_id=' . $params['id'] . ' and a.file_type=' . $this->_file_type . ' and b.instock_type=' . C('CFG_INSTOCK_TYPE_CHECKOUTED'))->count();
		if ($count > 0) {//导入产品所属发货单已费用结清，则不可删除
			throw_json(L('error_instock_checkouted_cant_del'));
		}
	}	
	
	public function deleteFollowProcess(&$params) {
		//更新发货明细入库数量
		$where	= 'file_id =' . $params['id'] . ' AND `state` in ( ' . C('CFG_IMPORT_SUCCESS_STATE') . ',' . C('CFG_IMPORT_PROCESSED_STATE') . ')';
		$sql	= 'UPDATE instock_detail a 
					RIGHT JOIN (
						SELECT product_id, sum(quantity) AS quantity, box_id
						FROM file_detail_del 
						WHERE ' . $where . '
						GROUP BY product_id, box_id
					)tmp 
					ON a.box_id = tmp.box_id AND a.product_id = tmp.product_id
					SET a.in_quantity = a.in_quantity-tmp.quantity';
		M()->execute($sql);
		//还原发货单状态
		$box_id	= M('FileDetailDel')->where($where)->group('box_id')->getField('box_id', true);
		if (count($box_id) > 0) {
			$this->updateInstockState($params['id'], $box_id);
		}
	}	

	public function updateInstockState($file_id, $box_id) {
		$all_instock_id	= $this->getAllInstockID($file_id, $box_id);
		if (!empty($all_instock_id)) {
			$model	= D('Instock');
			$model->where(array('id' => array('in', $all_instock_id)))->setField('update_time', date('Y-m-d H:i:s'));
			$model->updateInstockStateById($all_instock_id);
		}
	}
}