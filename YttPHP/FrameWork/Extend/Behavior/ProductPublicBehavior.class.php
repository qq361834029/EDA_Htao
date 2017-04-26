<?php
/**
 * 外部SKU
 * @copyright   Copyright (c) 2006 - 2014 Top Union 展联软件友拓通
 * @category    外部SKU
 * @package		Behavior
 * @author		hjb
 * @version		2.1,2014-09-29
 */

class ProductPublicBehavior extends Behavior {
	public function run(&$params){
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        $id			= intval($params['id']);
        if($id > 0){
//            D('SaleOrder')->updateSaleCubeWeight($id);
        }
		if ($_action == 'insert') {//新增产品时未定义外部条码则自动生成条码
			$is_custom_barcode  = M('Product')->alias('p')->join('__COMPANY_FACTORY__ c on c.factory_id = p.factory_id')->where(array('p.id' => $params['id']))->getField('is_custom_barcode');
			if($is_custom_barcode != 1){
				M('Product')->save(array('id'=> $params['id'], 'custom_barcode'=>C('CUSTOM_BARCODE_PREFIX') . $params['id']));
			}
		}
	}
}