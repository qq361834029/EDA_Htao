<?php
class OrderTypePublicBehavior extends Behavior {
	
	public function run(&$params){
		
	}
    public function delete($paramms){
        //已被使用的不能作废
        $id = intval($paramms['id']);
        if($id > 0){
            $is_use = M('OrderType')->where('id='.$id)->getField('to_hide');
            if($is_use == 1){
                $count  = M('SaleOrder')->where('order_type='.$id)->count();
                if($count>0){
                    throw_json(L('order_type_no_tohide'));
                }
            }
        }
    }
	
	
	
}