<?php
class FundsClassPublicBehavior extends Behavior {
	
	public function run(&$params){  
	} 
	
	public function edit($params){
		$this->checkOperate($params);
	}
	
	public function delete($params){
		$this->checkOperate($params);
	}
	
	public function checkOperate($params){
		$sys_pay_class	= !is_array(C('SYS_PAY_CLASS')) ? explode(',', C('SYS_PAY_CLASS')) : C('SYS_PAY_CLASS');
		if (in_array($params['id'], $sys_pay_class)) {
			throw_json(L('error_system_data_can_operate'));
		}	
//		if (M('PaidDetail')->where('pay_class_id=' . $params['id'])->count() > 0) {
//			throw_json(L('record_is_used_cant_edit_or_del'));
//		}
	}
}