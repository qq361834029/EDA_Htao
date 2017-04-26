<?php
/**
 +------------------------------------------------------------------------------
 * 仓储费对账检查
 +------------------------------------------------------------------------------
 * @copyright   20150729 展联软件友拓通
 * @category   	基本信息
 * @package  	Model 
 +------------------------------------------------------------------------------
 */
class CheckWarehouseAccountPublicModel extends Model {
	protected $tableName = 'warehouse_account';
	protected $all_relation_type	= array(
						'LoadContainer'		=> 1,
//						'instock'			=> 2,
						'SaleOrder'			=> 3,
						'Adjust'			=> 4,
                        'ReturnSaleOrderStorage' 	=> 5,//退货入库
						'Transfer' 			=> 6,
						'Delivery'			=> 7,
						'InitStorage'		=> 8,
						'Profitandloss'		=> 9,
						'InstockImport'		=> 10,//入库导入
						'Picking'			=> 11,//拣货导出更新实际库存中的picking_quantity，并记录其库存日志	
//						'pickingImport'		=> 11,//拣货导入 //改做处理旧数据
//						'pickingOut'		=> 13,//拣货导入更新实际库存中的picking_quantity，并记录其库存日志	
        				'OldbackShelves'		=> 14,//拣货导入重新上架
                        'InstockStorage'    => 15,//发货入库
                        'DomesticWaybill'   => 16,//国内运单
                        'ShiftWarehouse'    => 17,//移仓
                        'PickingImport'     => 18,//新重新上架
//                        'PackBox'           => 22,//装箱
                        'OutBatch'          => 22,//装箱
	);
    protected $storage_date_field   = array(
                'ReturnSaleOrderStorage'    => 'storage_date',
                'InstockStorage'            => 'storage_date',
                'InstockImport'             => 'create_time',
                'DomesticWaybill'           => 'waybill_date',
                'Adjust'                    => 'adjust_date',
                'Picking'                   => '',//当前时间 
    );
    protected $tpl_action_name  = '';
    protected $tpl_module_name  = '';
    protected $storage_field    = '';
    protected $relation_type    = '';
    protected $fw_arr           = array();


    /**
	 * 仓储费对账检查公共接口
	 *
	 * @param  参数 $params
	 * @param  方法名称，默认取模块名称，首字母转小写
	 */
	public function run($params){
		$this->tpl_module_name	= getTrueModule();
		$this->tpl_action_name	= getTrueAction();
        $is_fifo    = TRUE;
        if($this->tpl_module_name == 'ReturnSaleOrder'){
            $params['id']   = M('ReturnSaleOrderStorage')->where('return_sale_order_id='.$params['id'])->getField('id');
            if($params['id'] <= 0){
                return;
            }
            $this->tpl_module_name  = 'ReturnSaleOrderStorage';
        }
        $method_name = $this->tpl_module_name;
        if(in_array($this->tpl_module_name, array('InstockImport')) && in_array($this->tpl_action_name, array('insert'))){//excel导入特殊处理
            $this->params = D('Excel')->readExcel($this->tpl_module_name,$this->tpl_module_name, $params['file_name'], $params['sheet'], array('warehouse_id'=>$params['warehouse_id']));
        }elseif($this->tpl_module_name == 'PickingImport'){
            $id             = M('file_list')->where('id='.$params['id'])->getField('relation_id');
            $method_name    = 'Picking';
            $this->params   = array('id'=>$id);
        }else{
            $this->params = $params;
        }
        if($this->tpl_module_name == 'Picking' && $this->tpl_action_name == 'insert'){
            if($this->params['warehouse_id'] <= 0){
                throw_json(L('w_id_require'));
            }
            $factory_where  = $this->params['sale']['query']['factory_id'] > 0 ? ' and factory_id='.$this->params['sale']['query']['factory_id'] : '';
            $count  = M('warehouse_account')->where('warehouse_id='.$this->params['warehouse_id'].$factory_where.' and account_end_date>"'.date('Y-m-d',time()).'"')->count();
            if($count > 0){
                throw_json(L('accounted_can_not_operate'));
            }
        }else{
            if($is_fifo){
                $this->relation_type = $this->all_relation_type[$method_name];
                $this->storage_field = empty($this->storage_date_field[$method_name]) ? 'storage_date' : $this->storage_date_field[$method_name];
                $post_info           = $this->postInfo();
                $stock_info          = $this->stockInfo();
                $diff_info           = $this->setCheckData($post_info, $stock_info);
                $last_account        = M('warehouse_account')
                                ->having('fw in ("'.implode('","',$this->fw_arr).'")')
                                ->group('factory_id,warehouse_id')
                                ->field('concat(factory_id,"_",warehouse_id) as fw,max(account_end_date) as account_end_date')
                                ->getField('fw,account_end_date');
                foreach($last_account as $key=>$account){
                    if(strtotime($account) > strtotime($diff_info[$key])){
                        throw_json(L('accounted_can_not_operate'));
                    }
                }
            }
        }
	}
    
    public function setCheckData($post_info,$stock_info){
            if(empty($post_info)){
                $each_info = $stock_info;
                $info      = $post_info;
            }else{
                $each_info = $post_info;
                $info      = $stock_info;
            }
            $diff_info  = array();
            foreach($each_info as $key=>$value){
                $quantity = $info[$key]-$value;
                if($quantity != 0){
                    $key_arr    = explode('_', $key);
                    $factory_id = SOnly('product', $key_arr[2], 'factory_id');
                    $fw         = $factory_id.'_'.$key_arr[1];
                    $this->fw_arr[$fw] = $fw;
                    if(empty($diff_info[$fw])){
                        $date = $key_arr[0];
                    }else{
                        $date = date('Y-m-d',min(strtotime($key_arr[0]),strtotime($diff_info[$fw])));
                    }
                    $diff_info[$fw] = $date;
                }
                unset($info[$key]);
            }
            //部分可改变入库时间
            foreach($info as $key=>$value){
                if($value != 0){
                    $key_arr    = explode('_', $key);
                    $factory_id = SOnly('product', $key_arr[2], 'factory_id');
                    $fw         = $factory_id.'_'.$key_arr[1];
                    $this->fw_arr[$fw] = $fw;
                    if(empty($diff_info[$fw])){
                        $date = $key_arr[0];
                    }else{
                        $date = date('Y-m-d',min(strtotime($key_arr[0]),strtotime($diff_info[$fw])));
                    }
                    $diff_info[$fw] = $date;
                }
            }
        return $diff_info;
    }

    //验证对账(卖家,仓库,时间)
    public function checkWarehouseAccount($info){
        $where['factory_id']        = $info['factory_id'];
        $where['warehouse_id']      = $info['warehouse_id'];
        $where['account_end_date']  = array('gt',$info['in_date']);
        $count  = M('WarehouseAccount')->where($where)->count();
        if($count>0){
            throw_json(L('sale_order_account_not_delete'));
        }
    }

    /**
     * 获取POST数据
     * @return array
     */
    public function postInfo(){
        $post_info = array();
        foreach($this->params['detail'] as $detail){
            $product_id = intval($detail['product_id']);
            if($product_id > 0){
                switch ($this->tpl_module_name){
                    case 'InstockImport':
                        $storage_date = date('Y-m-d',  strtotime($detail[$this->storage_field]));
                        break;
                    case 'ReturnSaleOrderStorage':
                        $storage_date = M($this->tpl_module_name)->where('id='.$this->params['id'])->getField('Storage_date');
                        break;
                    default :
                        $storage_date = $this->params[$this->storage_field];
                        break;
                }
                $key = array($storage_date,$detail['warehouse_id'],$product_id);
                if(MODULE_NAME == 'InstockStorage'){
                    $quantity   = intval($detail['in_quantity']);
                }else{
                    $quantity   = intval($detail['quantity']);
                }
                $post_info[implode('_', $key)] += $quantity;
            }
            //装箱单
            if($this->tpl_module_name == 'OutBatch'){
                if(intval($detail['pack_box_id']) > 0){
                    $pack_box_id[$detail['pack_box_id']] = $detail['pack_box_id'];
                }
            }
        }
        //装箱单
        if($this->tpl_module_name == 'OutBatch'){
            if(!empty($pack_box_id)){
                $return_sale_order_id   = M('pack_box_detail')->where('pack_box_id in ('.implode(',', $pack_box_id).')')->getField('return_sale_order_id',true);
            }
            if(!empty($return_sale_order_id)){
                switch ($this->tpl_module_name){
                    case 'InstockImport':
                        $storage_date = date('Y-m-d',  strtotime($detail[$this->storage_field]));
                        break;
                    case 'ReturnSaleOrderStorage':
                        $storage_date = M($this->tpl_module_name)->where('id='.$this->params['id'])->getField('Storage_date');
                        break;
                    default :
                        $storage_date = $this->params[$this->storage_field];
                        break;
                }
                //edit by yyh 20150923
                $storage_date   =  date("Y-m-d H:i:s");
//                if(empty($storage_date) && $this->params['id'] > 0){
//                    $storage_date   = M($this->tpl_module_name)->where('id='.$this->params['id'])->getField('pack_date');
//                }
                $return_detail  = M('return_sale_order_detail')->where('return_sale_order_id in ('.implode(',', $return_sale_order_id).')')->group('product_id')->getField('product_id,product_id,warehouse_id,sum(quantity) as quantity');
                foreach($return_detail as $value){
                    $key = array($storage_date,$value['warehouse_id'],$value['product_id']);
                    $post_info[implode('_', $key)]  += $value['quantity'];
                }
            }
        }
        return $post_info;
    }
    
    /**
     * 获取先进先出数据
     * @return array
     */
    public function stockInfo(){
        $stock_info = array();
        $id         = $this->params['id'];
        if($id > 0){
            $sql    = 'select in_date as storage_date,warehouse_id,product_id,quantity from stock_in
                       where main_id='.$id.' and relation_type='.$this->relation_type.'
                       union all
                       select out_date as storage_date,out_warehouse_id,product_id,quantity from stock_out
                       where main_id='.$id.' and out_relation_type='.$this->relation_type;
            $info = $this->db->query($sql);
            foreach($info as $detail){
                $quantity   = intval($detail['quantity']);
                unset($detail['quantity']);
                $stock_info[implode('_', $detail)] += $quantity;
            }
        }
        return $stock_info;
    }
}