<?php
class LoadContainerPublicStatus extends Status {
	/**
	 * 入库后更新装柜状态
	 *
	 * @param array $params
	 */
	public function instock($params){
		//开启新入库 不关联装柜
		if(C('instock.add')==1 || ACTION_NAME=='update'){
			return ;
		}
		if(ACTION_NAME=='delete'){
			$var	= M('instock_del')->find(intval($params['id']));
			$load_state	= 1;
		}else{
			$var	= M('instock')->find(intval($params['id']));
			$load_state = 3;
		}
		if(intval($var['load_container_id'])>0){
			M('LoadContainer')->where('id='.intval($var['load_container_id']))->setField('load_state',$load_state); 
			if(C('loadContainer.sale_storage')==1) {	// 装柜状态更新时更新 在途可销售库存
				D('Storage')->updateStorage(array('id'=>intval($var['load_container_id']),'load_state'=>$load_state),'loadContainer');
			}
		}
	}
}