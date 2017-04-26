<?php
class TrackOrderPublicBehavior extends Behavior {
	
	public function run(&$params){
	}
    
    public function delete($params){
        $sale_order_id  = M('GalleryRelation')->where('gallery_id='.$params['id'])->getField('relation_id', true);
        if(!empty($sale_order_id)){
			$where	= array(
				'id'				=> array('in', $sale_order_id),
				'sale_order_state'	=> array('neq', C('SALE_ORDER_STATE_EXPORTING')),
			);
            $count  = M('sale_order')->where($where)->count();
            if($count!=0){
                throw_json(L('picked_no_delete'));
            }
        }
    }
	
	
	
}