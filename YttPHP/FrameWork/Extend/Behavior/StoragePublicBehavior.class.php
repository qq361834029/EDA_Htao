<?php
class StoragePublicBehavior extends Behavior {
	
	public function run(&$params){
		D('Storage')->updateStorage($params,$params['method_name']);
	}
	
}