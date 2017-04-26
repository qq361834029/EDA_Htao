<?php
class CheckStoragePublicBehavior extends Behavior {
	
	public function run(&$params){
		
	}
	
	public function brf($params){
		if($params['from_type'] != 'import'){
			$_module	= $params['_module'] ? $params['_module'] : getTrueModule();
            if($_module == 'ShiftWarehouse'){
               $params['detail']    = D('CheckStorage')->setShiftWarehouseInfo($params['detail']);
            }
			D('CheckStorage')->run($params);
		}
	}
}