<?php
class FactoryInstockPublicBehavior extends Behavior {
	
	public function run(&$params){  
		$Model	= D('FactoryInstock');     
		if (ACTION_NAME=='delete'){
			$id			= $params['id']; 
			$info		= $Model->deleteOp($id); 
		}else{
			//厂家款项 
			$info		= $Model->_fund($params); 
		} 
	} 
	
}