<?php
class NonFactoryPublicBehavior extends Behavior {
	
	public function run(&$params){
		
	}

	public function add($params){
		$this->checkPermission();
	}

	public function edit($params){
		$this->checkPermission();
	}
	
	public function delete($params){
		$this->checkPermission();
	}

	public function checkPermission(){
		if (getUser('role_type') == C('SELLER_ROLE_TYPE')) {
			throw_json(L('_VALID_ACCESS_'));
			exit;
		}
	}
}