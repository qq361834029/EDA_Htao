<?php
class WarehouseFeePublicBehavior extends Behavior {
	
	public function run(&$params){
		
	}

	public function delete($params){
		$count	= M('company_factory')->where('warehouse_fee_id='.$params['id'])->count();
		if($count>0){
			throw_json(L('WAREHOUSE_FEE_DELETE_ERROR'));
		}
	}
    
    public function insert($params){
//        $this->checkCoherence($params);
    }
    
    public function update($params){
//        $this->checkCoherence($params);
//        $this->checkIsWarehouseFee($params);
    }
    //验证是否仓储费是否连贯
    public function checkCoherence($params){
        //按仓库分组
        foreach($params['detail'] as $detail){
            if($detail['start_days'] > 0 || $detail['end_days'] > 0){//过滤空数据
                $warehouse_fee[$detail['warehouse_id']][]  = $detail;
            }
        }
        foreach($warehouse_fee as $warehouse_fee_detail){
            $start  = 0;
            foreach($warehouse_fee_detail as $value){
                if($value['end_days'] == 0){
                    $start++;
                }
            }
            if($start != 1){
                throw_json(a2bc($start,L('enter_coherent_days'),L('last_warehouse_fee_days')));
            }
        }
    }
    //是否已经对账
    public function checkIsWarehouseFee($params){
        $id = intval($params['company_id']);
        $count  = M('warehouse_account')->where('factory_id='.$id)->count();
        if($params['company_factory'][1]['is_warehouse_fee'] == 0){
            $is_warehouse_fee   = M('company_factory')->where('factory_id='.$id)->getField('is_warehouse_fee');
            if($is_warehouse_fee > 0){
                if($count > 0){
                    throw_json(L('accounted_can_not_operate'));
                }
            }
        }
        if($count > 0){
            $warehouse_fee  = M('warehouse_fee')->where('factory_id='.$id)->field('start_days,end_days,first_quarter,second_quarter,third_quarter,fourth_quarter')->select();
            $post_warehouse_fee = array_values($params['warehouse_fee']);
            unset($post_warehouse_fee[0]);
            foreach($warehouse_fee as $key=>$value){
                foreach($value as $k=>$v){
                    if(empty($post_warehouse_fee[$key+1][$k])){
                        $post_warehouse_fee[$key+1][$k] = 0;
                    }
                    if($v != $post_warehouse_fee[$key+1][$k]){
                        throw_json(L('accounted_can_not_operate'));
                    }
                }
            }
        }
    }
	
	
	
}