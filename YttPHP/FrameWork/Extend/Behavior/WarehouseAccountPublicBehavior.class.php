<?php
class WarehouseAccountPublicBehavior extends Behavior {
	
	public function run(&$params){
		
	}
    

    
    public function insert($params){
        //对账时间是否大于上次对账时间
        $this->gtAccountEndStart($params);
        //卖家是否设置仓储费
        $this->issetWarehouseFee($params);
        //是否存在产品
        $this->existProduct($params);
        //是否存在重新上架
        $this->existBackShelves($params);
        //是否存在入库导入异常
//        $this->existInstockAbnormal($params);
        //是否存在拣货导入异常
        $this->existPickingAbnormal($params);
        //是否存在拣货导出且未导入
        $this->existPickingImport($params);
    }
    public function existPickingImport($params){
        $where['f.warehouse_id']	= $params['warehouse_id'];
        $where['p.factory_id']		= $params['factory_id'];
        $where['f.create_time']		= array('lt',$params['account_end_date']);
        $where['f.relation_id']		= 0;
        $where['f.file_type']		= 2;
		$where['f.id']				= array('not in', array(21,23,25,27,29,31,33,36));//过滤早期的拣货导出单（当时设计并没有关联拣货导入） //拣货导出单号：JC1404190001,JC1404210001,JC1404220001,JC1404230001,JC1404230002,JC1404240001,JC1404250001,JC1404250002
        $count						= M('file_detail')
									->join('fd left join file_list f on f.id=fd.file_id left join product p on fd.product_id=p.id')
									->where($where)
									->count();
        if($count > 0){
            throw_json(L('存在拣货单未导入不能对账!'));
        }
    }

    public function existPickingAbnormal($params){
        $where['fd.state']              = 102;
        $where['f.warehouse_id']        = $params['warehouse_id'];
        $where['f.create_time']         = array('lt',$params['account_end_date']);
        $where['f.relation_id']         = array('gt',0);
        $id = M('file_detail')
                ->join('fd left join file_list f on f.id=fd.file_id')
                ->where($where)
                ->field('f.relation_id as r_id')
                ->getField('r_id',TRUE);
        if(!empty($id)){
            $count  =M('file_detail')->join('fd left join product p on fd.product_id=p.id')->where('file_id in ('.implode(',', $id).') and p.factory_id='.$params['factory_id'])->count();
        }
        if($count > 0){
            throw_json(L('存在拣货导入异常不能对账!'));
        }
    }

    public function existInstockAbnormal($params){
        $where['fd.state']              = 102;
        $where['f.warehouse_id']        = $params['warehouse_id'];
        $where['f.create_time']         = array('lt',$params['account_end_date']);
        $count  = M('file_detail')
                ->join('fd left join file_list f on f.id=fd.file_id')
                ->where($where)
                ->count();
        if($count > 0){
            throw_json(L('存在入库导入异常不能对账!'));
        }
    }

    

    public function existBackShelves($params){
        $where['fd.undeal_quantity']    = array('gt',0);
        $where['fd.state']              = array('in','101,103');
        $where['f.warehouse_id']        = $params['warehouse_id'];
        $where['p.factory_id']          = $params['factory_id'];
        $where['f.create_time']         = array('lt',$params['account_end_date']);
        $count  = M('file_detail')
                ->join('fd left join product p on fd.product_id=p.id
                        left join file_list f on f.id=fd.file_id')
                ->where($where)
                ->count();
        if($count > 0){
            throw_json(L('存在未重新上架数量不能对账!'));
        }
    }
    


    public function delete($params){
        $id = intval($params['id']);
        if($id > 0){
            $info = M('WarehouseAccount')->find($id);
            if(empty($info)){
                throw_json(L('not_exist_warehouse_account'));
            }
            $count = M('WarehouseAccount')->where('warehouse_id='.$info['warehouse_id'].' and factory_id='.$info['factory_id'].' and account_end_date>"'.$info['account_end_date'].'"')->count();
            if($count>0){
                throw_json(L('exist_after_wawrehouse_account'));
            }
        }else{
            throw_json(L('not_exist_warehouse_account'));
        }
    }

        /**
     * 对账时间是否大于上次对账时间
     * @author add yyh 20150724
     * @param array $params
     */
    private function gtAccountEndStart($params){
        $where['warehouse_id'] = $params['warehouse_id'];
        $where['factory_id']   = $params['factory_id'];
        $where['account_end_date'] = array('gt',$params['account_end_date']);
        $count = M('warehouse_account')->where($where)->count();
        if($count > 0){//上次对账时间是否大于等于本次对账时间
            throw_json(L('account_gt_last_account'));
        }
    }

    /**
     * 是否设置仓储费
     * @author add yyh 20150724
     * @param array $params
     */
    private function issetWarehouseFee($params){
        $is_werehouse   = M('company_factory')->where('factory_id='.$params['factory_id'])->getField('is_warehouse_fee');
        if($is_werehouse <= 0 ){
            throw_json(L('unset_warehouse_account'));
        }
    }

    /**
     * 是否存在需要对账的信息
     * @author add yyh 20150724
     * @param array $params 
     */
    private function existProduct($params){
        $where  = 'p.factory_id='.$params['factory_id'];
        $where  .= ' and s.in_date<"'.$params['account_end_date'].'"';
        $stock_in   = M('stock_in')
                ->join(' s left join product p on s.product_id=p.id')
                ->where($where.' and s.warehouse_id='.$params['warehouse_id'])
                ->field('sum(s.balance) as quantity,s.in_date,s.product_id,(p.cube_high*p.cube_wide*p.cube_long) as cube')
                ->group('s.in_date,s.product_id')
                ->select();
        $where  .= ' and s.out_date>="'.$account_start_date.'" and s.out_date<"'.$params['account_end_date'].'"';
        $stock_out  = M('stock_out')
                ->join(' s left join product p on s.product_id=p.id')
                ->where($where.' and s.out_warehouse_id='.$params['warehouse_id'])
                ->group('s.out_date,s.product_id')
                ->field('s.in_date,s.product_id,sum(s.quantity) as quantity,s.out_date,(p.cube_high*p.cube_wide*p.cube_long) as cube')
                ->select();
        //构造仓储费每季度天数明细
        $billing_start_date = empty($account_start_date) ? $value['in_date'] : $account_start_date;
        foreach($stock_in as $value){
            $billing_start_date = empty($account_start_date) ? $value['in_date'] : $account_start_date;
            if($value['quantity'] > 0){
                $info[$value['in_date']][$value['product_id']][]    = array(
                    'billing_start_date'    => $billing_start_date,
                    'billing_end_date'      => $rs['account_end_date'],
                    'cube'                  => $value['cube'],
                    'quantity'              => $value['quantity'],
                );
            }
            foreach($stock_out as $val){
                if($val['in_date'] == $value['in_date']){
                    $info[$value['in_date']][$value['product_id']][]    = array(
                        'billing_start_date'    => $billing_start_date,
                        'billing_end_date'      => min($val['out_date'],$rs['account_end_date']),
                        'cube'                  => $val['cube'],
                        'quantity'              => $val['quantity'],
                    );
                }
            }
        }
        if(empty($info)){
            throw_json('不存在需要对账的信息!');
        }
    }
	
	
	
}