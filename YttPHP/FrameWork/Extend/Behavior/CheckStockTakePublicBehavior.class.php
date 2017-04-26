<?php
class CheckStockTakePublicBehavior extends Behavior {
	
	public function run(&$params){
		
	}
	
	public function brf($params){
		// 开启锁定仓库时才验证
		if (C('stocktake.lock')==1) {
			D('CheckStockTake')->run($params);
		}
		
	}
	
}