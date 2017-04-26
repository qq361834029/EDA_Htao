<?php 
/**
 * 拣货导入管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	拣货信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-04-15
 */

class PickingImportPublicModel extends FileListPublicModel {
	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("file_upload",'file_name','import_file_not_exist',1, 'ifcheck','',''),
			array("picking_no",'require','require',1),
			array("pick_no",'require','require',1),
			array("pick_no",'',"unique",1,'unique',3),//验证唯一
			array("",'validPickingNo','require',1,'callbacks'),//验证基本信息
		);	
	
	///拣货单号
	public function validPickingNo($data){
		if (!empty($data['picking_no'])) {
			$relation	= M('FileList')->field('id as relation_id, relation_id as picking_import_id, warehouse_id')->where("file_list_no='" . $data['picking_no'] . "' and file_type=" . array_search('Picking', C('CFG_FILE_TYPE')))->find();
			if ((int)$relation['relation_id'] <= 0) {
				$error['name']	= 'picking_no';
				$error['value']	= L('record_not_exist');
				$this->error[]	= $error;			
			} elseif ($relation['picking_import_id'] > 0){
				$error['name']	= 'picking_no';
				$error['value']	= L('do_not_repeat_import');
				$this->error[]	= $error;					
			} else {
				unset($relation['picking_import_id']);
				$this->vdata	= array_merge($this->vdata, $relation);
				$_POST			= array_merge($_POST, $relation);
			}
		}
	}	
	
	
	public function setInsertInfo(&$info){
		$info['warehouse_id']	= $this->data['warehouse_id'];
		$info['relation_id']	= $this->data['relation_id'];//后面绑定关联需要用到
	}
	
	public function setInsertDetail(&$detail_list) {
		$fileDetail	= M('FileDetail');
//		if (count($detail_list) != $fileDetail->where('file_id=' . $this->data['relation_id'])->count()) {
//			return L('picking_import_and_picking_export_records_inconsistent');
//		}
		$compare_fields			= array('product_id', 'barcode_no', 'real_quantity');
		$picking_detail_list	= $fileDetail->join('fd left join location l on l.id=fd.location_id')->where('file_id=' . $this->data['relation_id'])->getField('fd.id, fd.product_id, fd.quantity as real_quantity, fd.quantity as undeal_quantity, l.barcode_no, fd.location_id, fd.id as relation_id');
		$pickingAbnormal		= D('PickingAbnormal');
		$detail_row_number		= 1;//记录明细所在excel行号（第1行为字段行略过）
		$error_msg				= array();//记录错误信息
		$remainProductCache     = S('pickImport:remainProduct:'.$_POST['picking_no']);	//拣货导入剩余产品缓存
		foreach ($detail_list as &$detail) {
			$detail_row_number++;
			$is_match	= false;
			foreach ($picking_detail_list as $picking_id => $picking_detail) {
				$i				= 0;//匹配过程标示当前匹配字段为为第$i+1个字段
				$compare_result	= 0;//记录最终匹配结果
				foreach ($compare_fields as $field) {
					$compare_result	+= $detail[$field] == $picking_detail[$field] ? 1<<$i : 0;//匹配结果
					unset($picking_detail[$field]);//删除比较字段，后面匹配成功时也无需合并此字段
					$i++;
				}
				$right_result	= (1<<$i)-1;//完全匹配
				//各字段完全一致时，匹配成功
				if (($compare_result & $right_result) == $right_result) {
					$detail				= array_merge($detail, $picking_detail);
					$detail['state']	=  C('CFG_IMPORT_SUCCESS_STATE');
					$is_match			= true;
					unset($picking_detail_list[$picking_id]);
					break;
				}
			}
			//验证多次拣货导入的数量是否小于等于拣货导出数量
			if(($remainProductCache[$detail['product_id']][$detail['barcode_no']] + $detail['quantity']) > $detail['real_quantity']){
				$is_match			= false;
			}
			if ($is_match === false) {
				$error_msg[]	= sprintf(L('row_data_error'), $detail_row_number);
			}
		}		
		return empty($error_msg) ? true : implode("<br />", $error_msg);
	}
	
	
	public function setIndexList(&$list) {
		$ids	= array_keys($list);
//		$relation_details	= M('FileRelationDetail')->field('object_id as file_id,b.id as sale_order_id, b.sale_order_no')->join('a left join sale_order b on b.id=a.relation_id')->where('object_id in (' . implode(',', $ids) . ') and file_type=' . $this->_file_type)->order('b.sale_order_no desc')->select();
//		if ($relation_details) {
//			foreach ($relation_details as $detail) {
//				$sale_order_list	= isset($list[$detail['file_id']]['sale_order_list']) ? explode('<br />', $list[$detail['file_id']]['sale_order_list']) : array();
//				$sale_order_list[]	= '<a href="javascript:;" onclick="addTab(\'' . U('/SaleOrder/view/id/' . $detail['sale_order_id']) .  '\',\'' . title('view', 'SaleOrder') .  '\'); ">' . $detail['sale_order_no'] . '</a>';
//				$list[$detail['file_id']]['sale_order_list']	= implode('<br />', $sale_order_list);
//			}
//		}	
//		unset($relation_details);
		$relation_list	= M('FileList')->field('a.id as file_id, b.file_list_no as relation_no')->join('a left join file_list b on b.id=a.relation_id')->where('a.id in (' . implode(',', $ids) . ') and a.relation_id>0')->select();
		if ($relation_list) {
			foreach ($relation_list as $detail) {
				$list[$detail['file_id']]['relation_no']	= $detail['relation_no'];
			}
		}
		return $list;
	}

	///列表
	public function indexSql(){
		$where = getWhere($_POST) . ' and file_type=' . $this->_file_type;
		if ($_POST['has_undeal_quantity'] == 1) {
			$file_ids	= M('FileDetail')->where('undeal_quantity>0 and state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ',' . C('CFG_IMPORT_PROCESSED_STATE') . ')')->group('file_id')->getField('file_id', true);
			$where		.= count($file_ids) > 0 ? ' and id in (' . implode(',', $file_ids) . ')' : ' and 0 ';
		}
		$count 	= $this->where($where)->count();
		$this->setPage($count);
		$ids	= $this->field('id')->where($where)->order('file_list_no desc')->page()->selectIds();
		$info['from'] 	= 'file_list';
		$info['order'] 	= ' order by file_list_no desc';
		$info['where'] 	= ' where id in'.$ids;
		$info['field'] 	= "*";
		return	'select '.$info['field'].' from '.$info['from'].$info['where'].$info['order'];
	}
	
	
	public function _afterModel(){
		$this->makePickImportCache();
	}
	
	/**	
	 * 生成拣货导入缓存（剩余产品缓存）
	 * @return array|boolean|null
	 */
    public function makePickImportCache(){
		if (ACTION_NAME == 'insert') {
			$remainProductCache  = S('pickImport:remainProduct:'.$_POST['picking_no']);
			//累加
			foreach ($_POST['detail'] as $key=>$value){
				$remainProductCache[$value['product_id']][$value['barcode_no']] += $value['quantity'];
			}
			S('pickImport:remainProduct:'.$_POST['picking_no'],$remainProductCache);
		}elseif(ACTION_NAME == 'delete'){
			$relation_id = M('file_list_del')->where(array('id'=>$this->id))->getField('relation_id');
			$picking_no = M('file_list')->where(array('id'=>$relation_id))->getField('file_list_no');
			//累计减少
			
			
			
			S('pickImport:remainProduct:'.$picking_no,null);
		}
	}

}