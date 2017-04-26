<?php
class FactoryPublicBehavior extends Behavior {
	
	public function run(&$params){
		
	}
    
    public function insert($params){
//        $this->checkCoherence($params);
    }
    
    public function update($params){
//        $this->checkCoherence($params);
        $this->checkIsWarehouseFee($params);
        $custom_barcode = isCustomBarcode($params['company_id']);
        if($custom_barcode['is_custom_barcode'] == 1 && $params['company_factory'][1]['is_custom_barcode'] != 1){
            $count  = M('product')->where("factory_id=".$params['company_id'])->field("sum(`custom_barcode` REGEXP '^EDA[0-9]+$') as ctn0,sum(length(`custom_barcode`)>5) as ctn1")->find();
            if($count['ctn0'] < $count['ctn1']){
                throw_json(L('custom_barcode_no_edit'));
            }
        }
    }
    public function updateSetting($params){
        $this->update($params);
    }

    //验证是否仓储费是否连贯
    public function checkCoherence($params){
        $start  = 0;
        foreach($params['warehouse_fee'] as $value){
            if(!empty($value['end_days']) && ( empty($value['start_days']) || $value['end_days'] <= 0)){
                $start++;
            }
            if($start>1){
                throw_json(L('enter_coherent_days'));
            }
        }
    }
//    public function checkIsWarehouseFee($params){
//        $id = intval($params['company_id']);
//        $count  = M('warehouse_account')->where('factory_id='.$id)->count();
//        if($params['company_factory'][1]['is_warehouse_fee'] == 0){
//            $is_warehouse_fee   = M('company_factory')->where('factory_id='.$id)->getField('is_warehouse_fee');
//            if($is_warehouse_fee > 0){
//                if($count > 0){
//                    throw_json(L('accounted_can_not_operate'));
//                }
//            }
//        }
//        if($count > 0){
//            $warehouse_fee  = M('warehouse_fee')->where('factory_id='.$id)->field('start_days,end_days,first_quarter,second_quarter,third_quarter,fourth_quarter')->select();
//            $post_warehouse_fee = array_values($params['warehouse_fee']);
//            unset($post_warehouse_fee[0]);
//            foreach($warehouse_fee as $key=>$value){
//                foreach($value as $k=>$v){
//                    if(empty($post_warehouse_fee[$key+1][$k])){
//                        $post_warehouse_fee[$key+1][$k] = 0;
//                    }
//                    if($v != $post_warehouse_fee[$key+1][$k]){
//                        throw_json(L('accounted_can_not_operate'));
//                    }
//                }
//            }
//        }
//    }
    public function checkIsWarehouseFee($params){
        $id     = intval($params['company_id']);
        if(isset($params['company_factory'][1]['is_warehouse_fee']) && $params['company_factory'][1]['is_warehouse_fee'] == 0){//是否已存在对账
            $is_warehouse_fee   = M('company_factory')->where('factory_id='.$id)->getField('is_warehouse_fee');
            if($is_warehouse_fee > 0){
                $count  = M('warehouse_account')->where('factory_id='.$id)->count();
                if($count > 0){
                    throw_json(L('accounted_can_not_operate'));
                }
            }
        }
    }
	
	
	
}