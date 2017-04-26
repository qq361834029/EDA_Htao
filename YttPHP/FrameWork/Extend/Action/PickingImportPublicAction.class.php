<?php 
/**
 * 拣货单导入管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	拣货
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-04-15
 */

class PickingImportPublicAction extends FileListPublicAction {
		///列表
	public function _autoIndex($temp_file=null) { 
		$this->action_name	=   ACTION_NAME;
 		///获取当前模型 
    	$model 	= $this->getModel();
    	///格式化+获取列表信息  	
    	$list	= $model->index(); 
		$file_ids	= array_keys((array)$list['list']);
		if (count($file_ids) > 0) {
			$options			= array(
									'field'		=> 'file_id, sum(state=' . C('CFG_IMPORT_FAILED_STATE') . ') as untreated_count, sum((state!=' . C('CFG_IMPORT_FAILED_STATE') . ')*undeal_quantity) AS undeal_quantity',
									'where'		=> 'file_id in (' . implode(',', $file_ids) . ')',
									'group'		=> 'file_id',
								);
			$fileDetailModel	= M('FileDetail');
			$_sql				= $fileDetailModel->buildSql($options);
			$undeal_list		= _formatList($fileDetailModel->query($_sql), null, 1, 'file_id');
			foreach ($list['list'] as $file_id => $file_deail) {
				$list['list'][$file_id]	= array_merge($file_deail, (array)$undeal_list['list'][$file_id]);
				if ($list['list'][$file_id]['untreated_count'] == 0 && $list['list'][$file_id]['undeal_quantity'] > 0) {
					$list['list'][$file_id]['can_backShelves']	= 1;//可重新上架
				} else {
					$list['list'][$file_id]['can_backShelves']	= 0;//不可重新上架
				}
			}
			$list['total']		= array_merge_recursive($list['total'], $undeal_list['total']);
			unset($undeal_list);
		}
		$this->list	= $list; 
		$this->displayIndex($temp_file);
	}  
	
	/**
	 * 重新上架（支持还原上架功能，需要更改行为验证）
	 * 对未分配的产品重新上架： 1. 扣减相应的可销售库存。 2. 清空未分配数量。
	 */
	public function backShelves(){
		$this->id	= (int)$_GET['id'];
		if ($this->id > 0) {
			$this->dealPicking(false);//再次分配拣货单
			D('PickingImport')->execTags(array('id' => $this->id));//更新可销售库存及未分配数量
			$this->success(L('_OPERATION_SUCCESS_'));
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}
	}
	
	/**
	 * 分配拣货单
	 * @author jph 20140630
	 */
	public function dealPicking($jump = true){
		$id	= $this->id > 0 ? $this->id : (int)$_GET['id'];
		if ($id > 0) {
			$module_name			= 'PickingImport';
			$undeal					= D($module_name)->field('id as file_id, relation_id as picking_id')->find($id);
			$undeal['method_name']	= 'dealPicking';
			B($module_name, $undeal);
			if ($jump === true) {
				$this->success(L('_OPERATION_SUCCESS_'));
			}
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}		
	}
}