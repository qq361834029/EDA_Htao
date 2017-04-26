<?php
class FiFoPublicBehavior extends Behavior {
	
	public function run(&$params){
		D('FiFo')->run($params);
	}
	
}