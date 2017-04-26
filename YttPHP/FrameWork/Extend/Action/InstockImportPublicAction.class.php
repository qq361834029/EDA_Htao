<?php 
/**
 * 入库单导入管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	入库
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-03-31
 */

class InstockImportPublicAction extends FileListPublicAction {
    public function checkRepeat() {//add by yyh 20141119 验证入库导入是否有重复数据
        $after_default	= array('warehouse_id' => $_GET['warehouse_id']);
        $rs				= D('Excel')->readExcel($_GET['import_key'], $_GET['import_key'], $_GET['file_name'], $_GET['sheet'], $after_default);
        $key			= md5(time() . getUser('id'));
        S($key, $rs);
        $instock_no		= array();
        foreach ($rs['detail'] as $value) {
			if($value['state'] == C('CFG_IMPORT_SUCCESS_STATE')){
				$box_id[$value['box_id']]			= $value['box_id'];
				$product_id[$value['product_id']]	= $value['product_id'];
				$location_id[$value['location_id']]	= $value['location_id'];
            }
        }
		if (count($box_id) > 0) {
			$unique_fields		= array('box_id', 'product_id', 'location_id', 'quantity');
			//查找可能重复的明细
			$alias				= 'fd';
			$filed				= implodeExtend($unique_fields, ',', $alias . '.');
			$join				= 'INNER JOIN __FILE_LIST__ f on f.id=fd.file_id';
			$where				= array(
									'f.file_type'		=> array_search(MODULE_NAME, C('CFG_FILE_TYPE')), //入库导入类型
									'fd.state'			=> array('in', array(C('CFG_IMPORT_SUCCESS_STATE'), C('CFG_IMPORT_PROCESSED_STATE'))), //只检测正常数据(导入成功或异常已处理)
									'fd.box_id'			=> array('in', $box_id),
									'fd.product_id'		=> array('in', $product_id),
									'fd.location_id'	=> array('in', $location_id),
								);
			$file_detail		= M('file_detail')->field($filed)->alias($alias)->join($join)->where($where)->select();
			//构造
			$file_detail_unique	= array();
			foreach ((array)$file_detail as $value) {
				$file_detail_unique[implodeByFields($value, $unique_fields)]	= true;
			}
			if (count($file_detail_unique) > 0) {
				foreach ($rs['detail'] as $value) {
					if($value['state'] == C('CFG_IMPORT_SUCCESS_STATE')){
						if ($file_detail_unique[implodeByFields($value, $unique_fields)] === true) {
							$repeat_box_id[$value['box_id']]	= $value['box_id'];
						}
					}
				}
				if (count($repeat_box_id) > 0) {
					$instock_no = M('instock')->field('a.instock_no as instock_no')->alias('a')->join('INNER JOIN __INSTOCK_BOX__ b on a.id=b.instock_id')->where('b.id in (' . implode(',', $repeat_box_id) . ')')->group('a.id')->getField('instock_no', true);
				}
			}
		}
        echo json_encode(array('status' => empty($instock_no)?0:1, 'key' => $key, 'info' =>L('is_repeated') . '<br />' . implode('<br />', $instock_no), 'detail'=>$rs['detail']));
    }
}