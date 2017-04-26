<?php 
/**
 * 修复数据
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	修复
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2016-09-30
 */

class FixDataPublicAction extends RelationCommonAction {
	//修复移仓事务问题导致的先进先出问题
	public function ShiftWarehouseFifo(){
		$sql = 'select id,shift_warehouse_no from shift_warehouse d where not exists(select 1 from stock_in s where s.main_id=d.id and s.relation_type=17)';
		$error_ids = M()->query($sql);
		$i = 0;
		$fi = 0;
		$note = array();
		echo '开始修复移仓:<br>';
		foreach($error_ids as $value){
			$params['_module']	= 'ShiftWarehouse';
			$params['_action']	= 'update';
			$params['id']		= $value['id'];
			startTrans();
			D('FiFo')->run($params);
			commit();
			$i++;
			$note[] = $value['shift_warehouse_no'];
		}
		echo '共有'.$fi.'条数据，修复 '.$i.' 条数据,具体移仓号如下:'.implode('<br>',$note);
		exit;
	}
}