<?php
class LogisticsInstockPublicBehavior extends Behavior {
	
	public function run(&$params){   
		$Model	= D('LogisticsInstock');   
		if (ACTION_NAME=='delete'){  
			$id			= $params['id']; 
			$info		= $Model->deleteOp($id); 
		}else{
			//销售单款项 
			$info		= $Model->_fund($params); 
		} 
	} 
	
}