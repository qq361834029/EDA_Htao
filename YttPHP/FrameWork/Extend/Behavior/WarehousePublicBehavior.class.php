<?php
class WarehousePublicBehavior extends Behavior {
	
	public function run(&$params){
	}
	
    protected function delete(&$params){
        $where  = 'warehouse_id='.$params['id'];
        $sql    = 'select sum(onroad_qn) as onroad_quantity,
						   sum(sale_qn) as sale_quantity,
						   sum(real_qn) as real_quantity,
						   sum(real_qn)-sum(sale_qn) as reserve_quantity from (
                        select p.*,w.is_return_sold,b.warehouse_id,a.product_id,if(a.quantity>a.in_quantity,a.quantity-a.in_quantity,0) as onroad_qn,0 as sale_qn, 0 as real_qn, 0 as reserve_qn 
						from instock_detail a 
						left join instock b on b.id=a.instock_id 
						left join product p on p.id=a.product_id
                        left join warehouse w on w.id=b.warehouse_id 
						where  '.$where.'  and b.instock_type not in (' . C('NO_ONROAD_STATE') . ')
						union all
						select 
							p.*,w.is_return_sold,a.warehouse_id,a.product_id,0 as onroad_qn,a.quantity as sale_qn, 0 as real_qn, 0 as reserve_qn 
						from sale_storage a
						left join product p on p.id=a.product_id
                        left join warehouse w on w.id=a.warehouse_id 
						where  '.$where.'
						union all
						select 
							p.*,w.is_return_sold,a.warehouse_id,a.product_id,0 as onroad_qn,0 as sale_qn, a.quantity as real_qn, 0 as reserve_qn 
						from storage a
						left join product p on p.id=a.product_id
                        left join warehouse w on w.id=a.warehouse_id 
						where  '.$where.') as tmp';
        $rs 	= M()->query($sql);
        if($rs[0]['onroad_quantity'] != 0 || $rs[0]['sale_quantity'] != 0 || $rs[0]['real_quantity'] != 0 || $rs[0]['reserve_quantity'] != 0){
            throw_json(L('warehouse_no_delete'));
        }
	}
	
    protected function update(&$params){
        $warehouse_info     = M('warehouse')->field('relation_warehouse_id,is_return_sold')->where('id='.$params['id'])->find();
        $relation_warehouse_id  = $warehouse_info['relation_warehouse_id'];
        if($relation_warehouse_id != $params['relation_warehouse_id']){
            $return_detail  = M('return_sale_order_storage_detail')->where('warehouse_id='.$params['id'])->find();
            $storage        = M('storage')->where('warehouse_id='.$params['id'])->find();
            if(!empty($return_detail) && !empty($storage)){
                throw_json(L('used_relation_warehouse'));
            }elseif($warehouse_info['is_return_sold']==C('CAN_RETURN_SOLD')){
                $instock        = M('instock')->where('warehouse_id='.$params['id'].' and instock_type<>'.C('CFG_INSTOCK_TYPE_UNEDIT'))->find();
                if(!empty($instock)){
                    throw_json(L('used_relation_warehouse'));
                }
            }
        }
    }
	
	
}