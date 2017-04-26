<?php
class FactoryOnRoadPublicBehavior extends Behavior {
	
	public function run(&$params){   
		if (MODULE_NAME=='LoadContainer'){
			$Model	= D('FactoryOnRoad');    
			if (ACTION_NAME=='delete'){
				$id			= $params['id']; 
				$info		= $Model->deleteOp($id); 
			}else{ 
				//销售单款项 
				$info		= $Model->_fund($params); 
			} 
		}elseif (MODULE_NAME=='Instock' && C('instock.add')>=2 && $params['id']>0) {  
					if (ACTION_NAME=='delete'){
						//入库单ID
						$id					=	intval($params['id']);
						$instock			=	M('instock_del')->field('load_container_id')->find($id); 
						$load_container_id	=	$instock['load_container_id'];
						if ($load_container_id>0){ 
							$Model	= D('FactoryOnRoad');   
							//销售单款项 
							$info		= $Model->_fund(array('id'=>$load_container_id)); 
						}
					}elseif (ACTION_NAME=='insert'){
						//入库单ID
						$id					=	intval($params['id']);
						$instock			=	M('instock')->field('load_container_id')->find($id);  
						$load_container_id	=	$instock['load_container_id'];
						if ($load_container_id>0){ 
							$Model	= D('FactoryOnRoad');     
							//删除在路上款项 
							$info		= $Model->deleteOp($load_container_id);  
						}
					}  
					
			} 
		} 
	
}