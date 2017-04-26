<?php
class ClientReturnSaleStoragePublicBehavior extends Behavior {
	
	public function run(&$params){ 
		$_module		= $params['_module'] ? $params['_module'] : getTrueModule();
		$_action		= $params['_action'] ? $params['_action'] : getTrueAction();
		$Model			= D('ClientReturnSaleStorage');
        if($_module =='OutBatch'){
            if($_action == 'update' && $params['associate_with']){
                $return_sale_order_info = M('out_batch_detail')
                        ->join(' obd left join pack_box_detail pbd on obd.pack_box_id=pbd.pack_box_id
                                left join return_sale_order_storage rsos on pbd.return_sale_order_id=rsos.return_sale_order_id')
                        ->where('out_batch_id='.$params['id'])
                        ->field('rsos.*')
                        ->select();
                foreach($return_sale_order_info as $return_sale_order){
                    $info = $Model->_fund($return_sale_order);
                }
            }
        }elseif($_module =='ReturnSaleOrder'){
            if($_action == 'update' && in_array($params['return_sale_order_state'],array(C('DROPPED'),C('PROCESS_COMPLETE')))){
				$where				= array(
					'return_sale_order_id'	=> $params['id'],
				);
                $return_sale_order	= M('ReturnSaleOrderStorage')->where($where)->find();
                $info				= $Model->_fund($return_sale_order);
            }
        }else{
            $id				= $params['id'];
            $return_id      =   M('ReturnSaleOrderStorage')->where('id='.$id)->getField('return_sale_order_id');
            $sys_pay_class  = C('SYS_PAY_CLASS');
           $_action			= $params['_action'] ? $params['_action'] : getTrueAction();
            if ($_action == 'delete') {
                $info = $Model->deleteOp($id,$sys_pay_class['outerPackFee'].','.$sys_pay_class['withinPackFee'].','.$sys_pay_class['returnProcessFee']);
            }elseif($_action=='deleteDeal'){//删除处理操作        add by lxt 2015.09.07
                $count  =   $Model->where('object_id='.$return_id.' and object_type=123 and comp_type=1 and to_hide=1 and pay_class_id in('.$sys_pay_class['returnProcessFee'].','.$sys_pay_class['returnFee'].','.$sys_pay_class['returnAdditionalFee'].','.$sys_pay_class['returnPostageFee'].','.$sys_pay_class['outerPackFee'].','.$sys_pay_class['withinPackFee'].')')->count();
                if ($count){
                    $info   =   $Model->deleteOp($id,$sys_pay_class['returnProcessFee'].','.$sys_pay_class['returnFee'].','.$sys_pay_class['returnAdditionalFee'].','.$sys_pay_class['returnPostageFee'].','.$sys_pay_class['outerPackFee'].','.$sys_pay_class['withinPackFee']);
                }
            }else {
                if($_action == 'update'){
                    if(empty($params['outer_pack_id'])){
                        $info = $Model->deleteOp($id, $sys_pay_class['outerPackFee']);
                    }
                    if(empty($params['within_pack_id'])){
                        $info = $Model->deleteOp($id, $sys_pay_class['withinPackFee']);
                    }
                }
                $info = $Model->_fund($params);
            }
        }
    }
	
}