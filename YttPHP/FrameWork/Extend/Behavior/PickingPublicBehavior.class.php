<?php

/**
 * 拣货导出
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    拣货
 * @package   Behavior
 * @author     jph
 * @version  2.1,2014-04-03
 */

class PickingPublicBehavior extends FileListPublicBehavior {
	
	public $import_key	= 'Picking';
	
	public function insertFollowProcess(&$params) {
		D('SaleOrder')->updateSaleOrderStateById($params['sale_order_list']);//更新销售单状态为拣货中
	}	
	
	/// 删除时检验
	protected function delete(&$params){
		$relation_id	= M('FileList')->where('id='.intval($params['id']))->getField('relation_id');
		if($relation_id > 0){//已有拣货导入，不可删除
			throw_json(L('error_is_imported_cant_delete'));
		}	
		//已发货状态销售单数量
		$count	= M('FileRelationDetail')->join('a left join sale_order b on b.id=a.relation_id')->where('a.object_id=' . $params['id'] . ' and a.file_type=' . $this->_file_type . ' and b.sale_order_state=' . C('SHIPPED'))->count();
		if ($count > 0) {//导入产品所属销售单单已发货，则不可删除
			throw_json(L('error_sale_order_shipped_cant_del'));
		}		
	}
	
	public function deleteFollowProcess(&$params) {
		//还原订单状态至“导出中”(已删除或已作废的不还原)
        $sale_order_list	= M('FileRelationDetailDel')->join('as a left join sale_order as b on b.id=a.relation_id')->where('a.file_type=' . $this->_file_type . ' and a.object_id=' . $params['id'].' and b.sale_order_state not in ('.C('DELETED_CAN_EDIT_STATE').')')->getField('relation_id', true);
        D('SaleOrder')->updateSaleOrderStateById($sale_order_list, C('SALE_ORDER_STATE_EXPORTING'), title(ACTION_NAME, MODULE_NAME));
	}	
		
}