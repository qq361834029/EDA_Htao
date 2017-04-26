<?php

/**
 * 先进先出
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	先进先出
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class FiFoPublicModel extends Model {
	protected $tableName = 'stock_in';
	protected $params 		= array();
	protected $storage_attr 	= array();
	protected $all_relation_type	= array(
						'loadContainer'		=> 1,
//						'instock'			=> 2,
						'saleOrder'			=> 3,
						'adjust'			=> 4,
                        'returnSaleOrderStorage' 	=> 5,//退货入库
						'transfer' 			=> 6,
						'delivery'			=> 7,
						'initStorage'		=> 8,
						'profitandloss'		=> 9,
						'instockImport'		=> 10,//入库导入
						'picking'			=> 11,//拣货导出更新实际库存中的picking_quantity，并记录其库存日志	
//						'pickingImport'		=> 11,//拣货导入 //改做处理旧数据
//						'pickingOut'		=> 13,//拣货导入更新实际库存中的picking_quantity，并记录其库存日志	
        				'oldbackShelves'		=> 14,//拣货导入重新上架
                        'instockStorage'    => 15,//发货入库
                        'domesticWaybill'   => 16,//国内运单
                        'shiftWarehouse'    => 17,//移仓
                        'pickingImport'     => 18,//新重新上架
//                        'packBox'           => 22,//装箱
                        'outBatch'          => 22,//装箱
						'instockImportAdjust'          => 23, //入库导入调整
	);
    protected $relation_type = '';
	/**
	 * 更新库存公共接口
	 *
	 * @param  参数 $params
	 * @param  方法名称，默认取模块名称，首字母转小写
	 */
	public function run($params){
		$this->_module = $params['_module'];
		$this->_action = $params['_action'];
		$this->params = $params;
        $is_fifo    = TRUE;
		switch ($this->_module){
			case 'InstockAbnormal':
				$method_name		= 'instockImport';
				$this->params['id']	= M('FileDetail')->where('id=' . $this->params['id'])->getField('file_id');
				break;
			case 'PickingAbnormal':
                $is_fifo    = FALSE;
				break;
            case 'PickingImport':
                if($this->_action == 'insert'){
                    $is_fifo    = FALSE;
                }
			default :
				$method_name = ucwords_first($this->_module);
				break;
		}
        if($is_fifo){
            $this->relation_type = $this->all_relation_type[$method_name];
            $this->$method_name();
        }
	}
    
    /*
     * 退回国内装箱
     * 
     */
    public function outBatch(){
        // 删除在流程中删除的记录
        $this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
        $this->restoreStockOut();
		$main 	= M('OutBatch')->find($this->params['id']);
        $sql    = 'select rsd.id, rsd.warehouse_id, rsd.location_id, rsd.product_id, rsd.quantity-rsd.drop_quantity as quantity from out_batch_detail obd
            left join pack_box_detail pbd on pbd.pack_box_id=obd.pack_box_id
            left join return_sale_order_storage_detail rsd on pbd.return_sale_order_id=rsd.return_sale_order_id 
            where obd.out_batch_id='.$this->params['id'].' and rsd.quantity>rsd.drop_quantity order by rsd.id asc';
		$detail = $this->db->query($sql);
        $main['out_date']   = empty($main['out_date']) ? date("Y-m-d H:i:s") : $main['out_date'];
		foreach ((array)$detail as $value) {
            //主id取自OutBatch 明细ID取自return_sale_order_storage_detail
            $this->setStockOutData($value,$main,'out_date');
		}
		$this->synchronismStockOut();
    }

    public function shiftWarehouse(){
        // 删除在流程中删除的记录
        $this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
        $this->restoreStockOut();
		$main 	= M('ShiftWarehouse')->find($this->params['id']);
		$sql 	= 'select * from shift_warehouse_detail where shift_warehouse_id='.$this->params['id'].' order by id asc';
		$detail = $this->db->query($sql);
        foreach ($detail as $value){
            $data = $rate = $rs = '';
            $this->setShiftWarehouseData($value,$main);
        }
		$this->synchronismStockOut();
    }
    
    public function domesticWaybill(){
        // 删除在流程中删除的记录
        $this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
        $this->restoreStockOut();
		$main 	= M('DomesticWaybill')->find($this->params['id']);
		$sql 	= 'select * from domestic_waybill_detail where waybill_id='.$this->params['id'].$where.' order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$data = $rate = $rs = '';
            $this->setStockOutData($value,$main,'waybill_date');
		}
		$this->synchronismStockOut();
    }

    /**
	 * 入库更新stock_in记录
	 *
	 */
	private function instock(){
		if ($this->params['step'] == 2){
			// 删除在流程中删除的记录
			$this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
			$main 	= M('Instock')->find($this->params['id']);
			$sql 	= 'select * from instock_detail where instock_id='.$this->params['id'].' order by id asc';
			$detail = $this->db->query($sql);
			foreach ((array)$detail as $value) {
				$this->setStockInData($value,$main,'delivery_date');
			}
			$this->synchronismStockOut();
		}
	}
    	/**
	 * 入库更新stock_in记录
	 *
	 */
	private function instockStorage($id=NULL){
        !empty($id) && $this->params['id']=$id;
        // 删除在流程中删除的记录
        $this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
        $main 	= M('InstockStorage')->find($this->params['id']);
        $sql 	= 'select *,in_quantity as quantity from instock_storage_detail where instock_storage_id='.$this->params['id'].' order by id asc';
        $detail = $this->db->query($sql);
        foreach ((array)$detail as $value) {
            $this->setStockInData($value,$main,'storage_date');
        }
        $this->synchronismStockOut();
	}
	
	/**
	 * 导入更新stock_in记录
	 *
	 */
	private function importStockIn(){
		// 删除在流程中删除的记录
		$this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
		$main 	= M('FileList')->find($this->params['id']);
		$sql 	= 'select * from file_detail where file_id='.$this->params['id'].' and state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ', ' . C('CFG_IMPORT_PROCESSED_STATE') . ') order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$this->setStockInData($value,$main,'file_list_date');
		}
		$this->synchronismStockOut();
	}		
	
    /**
	 * 重新上架更新stock_in记录
	 *
	 */
	private function backShelves(){
		// 删除在流程中删除的记录
		$this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
        $log_info       = M('storage_log')->where('relation_type='.$this->relation_type.' and main_id='.$this->params['id'])->group('location_id, product_id')->field('location_id, product_id, sum(quantity) as quantity')->select();
        if(!empty($log_info)){
            $where  = 'id='.$this->params['id'];
            $relation_id    = M('file_list')->where($where)->getField('relation_id');
            $stock_out      = M('stock_out')->field('s.*')->join('s left join location l on s.in_location_id=l.id')->where('s.main_id='.(int)$relation_id.' and s.out_relation_type='.$this->all_relation_type['picking'])->order('l.path_sort DESC,s.in_date DESC,s.id DESC')->select();
            foreach($log_info as $value){
                $log_quantity   = $value['quantity'];
                foreach($stock_out as $key=>$val){
                    if($value['location_id'] == $val['out_location_id'] && $value['product_id'] == $val['product_id']){
                        if($log_quantity > $val['quantity']){
                            $data[] = $val;
                            $log_quantity   -= $val['quantity'];
                            unset($stock_out[$key]);
                        }else{
                            $val['quantity']    = $log_quantity;
                            $data[] = $val;
                            $stock_out[$key]['quantity']    -= $log_quantity;
                            break;
                        }
                    }
                }
            }
            //main_id为拣货导入IDdetail_id是stock_out id add by yyh 20150720
            foreach($data as $out_info){
                $info['in_date']        = $out_info['in_date'];
                $info['quantity']       = $out_info['quantity'];
                $info['product_id']     = $out_info['product_id'];
                $info['location_id']    = $out_info['in_location_id'];
                $info['warehouse_id']   = $out_info['in_warehouse_id'];
                $info['id']             = $out_info['id'];
                $detail[]   = $info;
            }
            foreach ((array)$detail as $value) {
                $this->setStockInData($value,$this->params,'in_date');
            }
            $this->synchronismStockOut();
        }
	}
	
	/**
	 * 导出更新stock_out记录
	 *
	 */
	private function importStockOut(){
        $this->restoreStockOut();		// 还原出库记录
		$main 	= M('FileList')->find($this->params['id']);
		$sql 	= 'select * from file_detail where file_id='.$this->params['id'].' and state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ', ' . C('CFG_IMPORT_PROCESSED_STATE') . ') order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$this->setStockOutData($value,$main,'file_list_date');
		}
	}


	/**
	 * 导出更新stock_out记录
	 *
	 */
	private function StockOut(){
        if(ACTION_NAME=='delete'){
            $this->restoreStockOut();	
        }
//        else{
//            $main 	= M('FileList')->find($this->params['id']);
//            $sql 	= 'select * from file_detail where file_id='.$this->params['id'].' and state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ', ' . C('CFG_IMPORT_PROCESSED_STATE') . ') order by id asc';
//            $detail = $this->db->query($sql);
//            foreach ((array)$detail as $value) {
//                $data['rate']       = $this->getRate(C('currency'), $main['file_list_date']);
//                $data['main_id']    = $this->params['id'];
//                $data['detail_id']  = $value['id'];
//                $where              = 'id in ('.$value['stock_out_id'].')';
//                M('stock_out')->where($where)->save($data);
//            }
//        }
	}

        /**
	 * 入库导入更新stock_in记录
	 *
	 */
	private function instockImport(){
		$this->importStockIn();
	}	
		
	/**
	 * 拣货导入更新stock_out记录
	 *
	 */
//	private function pickingImport(){
//		$this->importStockOut();
//	}	
    
	/**
	 * 重新上架更新stock_out记录
	 * @author yyh 20150720
	 */
	private function pickingImport(){
		$this->backShelves();
	}	
    
    /**
	 * 拣货导出更新stock_out记录
	 *
	 */
	private function picking(){
		$this->StockOut();
	}

        /**
	 * 期初库存更新stock_in记录
	 *
	 */
	private function initStorage(){
		// 删除在流程中删除的记录
		$this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
		$main 	= M('InitStorage')->find($this->params['id']);
		$sql 	= 'select * from init_storage_detail where init_storage_id='.$this->params['id'].' order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$this->setStockInData($value,$main,'init_storage_date');
		}
		$this->synchronismStockOut();
	}
	
	/**
	 * 退货库存更新stock_in记录
	 *
	 */
// 	private function returnSaleOrder(){
// 		// 删除在流程中删除的记录
// 		$this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
// 		$main 	= M('ReturnSaleOrder')->find($this->params['id']);
// 		$sql 	= 'select * from return_sale_order_detail where return_sale_order_id='.$this->params['id'].' order by id asc';
// 		$detail = $this->db->query($sql);
// 		foreach ((array)$detail as $value) {
// 			if ($value['is_use']==1) {
// 				$this->setStockInData($value,$main,'return_order_date');
// 			}else {
// 				// 修改记录从可用改为不可用删除明细记录
// 				$value['id'] > 0 && $this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type.' and detail_id='.$value['id']);
// 			}
// 		}
// 		$this->synchronismStockOut();
// 	}
    /**
	 * 退货库存更新stock_in记录
	 *
	 */
	private function returnSaleOrderStorage(){
		// 删除在流程中删除的记录
		$this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
		$main 	= M('ReturnSaleOrderStorage')->find($this->params['id']);
		//入库数量-丢弃数量=实际入库数量        edit by lxt 2015.09.02
		$sql 	= ' select id,product_id,warehouse_id,location_id,(quantity-drop_quantity) as quantity from return_sale_order_storage_detail 
                    where return_sale_order_storage_id='.$this->params['id'].' and quantity>drop_quantity order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
				$this->setStockInData($value,$main,'update_time');
		}
		$this->synchronismStockOut();
	}
	
	
	/**
	 * 盈亏库存更新stock_in记录
	 *
	 */
	private function profitandloss(){
		// 盈亏单不可修改，删除，无需处理历史数据
		if (ACTION_NAME!='update') {return true;}
		$main 	= M('Profitandloss')->find($this->params['id']);
		$sql 	= 'select * from profitandloss_detail where profitandloss_id='.$this->params['id'].' order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$value['quantity'] = $value['stocktake_quantity']-$value['storage_quantity'];
			if ($value['quantity']>0) {
				$this->setStockInData($value,$main,'profitandloss_date');
				$this->synchronismStockOut();
			}else {
				$this->setStockOutData($value,$main,'profitandloss_date');
			}
		}
	}
	
	
	/**
	 * 销售更新stock_out记录
	 *
	 */
	private function saleOrder(){
		// 配置有发货流程时不记录先进先出
		if (C('sale.relation_sale_follow_up')==1) {return true;}
		$this->restoreStockOut();		// 还原出库记录
		$main 	= M('SaleOrder')->find($this->params['id']);
		$sql 	= 'select * from sale_order_detail where sale_order_id='.$this->params['id'].' order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$this->setStockOutData($value,$main,'order_date');
		}
	}
	
	
	/**
	 * 发货stock_out记录
	 *
	 */
	private function delivery(){
		$this->restoreStockOut();		// 还原出库记录
		$main 	= M('Delivery')->find($this->params['id']);
		$sql 	= 'select * from delivery_detail where delivery_id='.$this->params['id'].' order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			// 发货表没有记录币种ID，需要去销售表获取
			$temp	= M('SaleOrder')->field('currency_id')->find($value['sale_order_id']);
			$value['currency_id'] = $temp['currency_id'];
			$this->setStockOutData($value,$main,'delivery_date');
		}
	}
	
	/**
	 * 库存调整stock_in  stock_out 记录
	 */
	
	private function adjust(){
        if(empty($this->params['adjust_type'])){
            // 删除在流程中删除的记录
            $this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
            $this->restoreStockOut();		// 还原出库记录
        } else {
            $where  = $this->params['adjust_type'] == 'AdjustSub' ? ' and quantity<0 ' : ' and quantity>0 ';
        }
		$main 	= M('Adjust')->find($this->params['id']);
		$sql 	= 'select * from adjust_detail where adjust_id='.$this->params['id'].$where.' order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$data = $rate = $rs = '';
			if ($value['quantity']>0) {
				$this->setStockInData($value,$main,'adjust_date');
			}else {
				$this->setStockOutData($value,$main,'adjust_date');
			}
		}
		$this->synchronismStockOut();
	}
	
	
	/**
	 * 入库导入调整stock_in  stock_out 记录
	 */
	
	private function instockImportAdjust(){
		// 删除在流程中删除的记录
		$this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
		$this->restoreStockOut();		// 还原出库记录
		$main 	= M('instockAdjust')->find($this->params['id']);
		$sql 	= 'select * from instock_adjust_detail where adjust_id='.$this->params['id'].' order by id asc';
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			if ($value['quantity']>0) {
				$this->setStockInData($value,$main,'adjust_date');
			}else {
				$this->setStockOutData($value,$main,'adjust_date');
			}
		}
		$this->synchronismStockOut();
	}
	
	/**
	 *调拨更新stock_in，stock_out记录
	 *
	 */
	private function transfer(){
		// 删除在流程中删除的记录
		$this->db->execute('delete from stock_in where main_id='.$this->params['id'].' and relation_type='.$this->relation_type);
		$this->restoreStockOut();		// 还原出库记录
		$main 	= M('Transfer')->find($this->params['id']);
		$sql 	= 'select * from transfer_detail where transfer_id='.$this->params['id'].' order by id asc';
		$detail = $this->db->query($sql);
		// 调拨需要特殊处理，先出库再入库，出库的金额取对应入库单金额，入库金额取对应出库单金额
		foreach ((array)$detail as $value) {
			$in_warehouse_id 	= $value['in_warehouse_id'];
			$out_warehouse_id	= $value['warehouse_id'];
			$this->transferStockOutData($value,$main);
		}
		$this->synchronismStockOut();
	}

	/**
	 * 调拨添加stock_out，stock_in记录
	 *
	 * @param  array $value 明细数据
	 * @param  array $main 主表数据
	 * @param  string $date_field 日期字段名称
	 */
	private function transferStockOutData($value,$main){
		$data 						= array();
		$data['main_id'] 			= $main['id'];
		$data['detail_id'] 			= $value['id'];
		$data['out_relation_type'] 	= $this->relation_type;
		$data['out_warehouse_id'] 	= $value['warehouse_id'];
		$data['out_date'] 			= $main['transfer_date'];
		$data['product_id'] 		= $value['product_id'];
		$data['color_id'] 			= C('storage_color') ? $value['color_id'] : 0;
		$data['size_id'] 			= C('storage_size') ? $value['size_id'] : 0;
		$data['capability'] 		= C('storage_format')>=2 ? $value['capability'] : 1;
		$data['dozen'] 				= C('storage_format')>=3 ? $value['dozen'] : 1;
		$data['mantissa'] 			= C('storage_mantissa') ? $value['mantissa'] : 1;
		$out_quantity = $rs = '';
		$out_quantity = abs($value['quantity']);
		while ($out_quantity>0) {
			// 根据入库日期降序，先入库的先出库，每次只取一条记录
			$sql = 'select * from stock_in where product_id='.$data['product_id'].' and color_id='.$data['color_id'].' and size_id='.$data['size_id'].' and capability='.$data['capability'].' and dozen='.$data['dozen'].' and mantissa='.$data['mantissa'].' and balance>0 order by in_date asc,id asc limit 0,1';
			$temp 	= $this->db->query($sql);
			$rs 	= $temp[0];
			if (empty($rs)) {
				throw_json($this->getTipsTable($data) . '库存不足，不能操作！');
			}
			$data['stock_in_id'] 			= $rs['id'];
			$data['in_warehouse_id'] 		= $rs['warehouse_id'];
			$data['in_date'] 				= $rs['in_date'];
			$data['in_currency_id'] 		= $rs['currency_id'];
			$data['in_price'] 				= $rs['price'];
			$data['in_base_price'] 			= $rs['base_price'];
			$data['in_relation_type'] 		= $rs['relation_type'];
			$data['base_delivery_price'] 	= $rs['base_delivery_price'];
			// 计算本位币单价
			$data['base_currency_id'] 	= $rs['base_currency_id'];
			$data['rate'] 				= $rs['rate'];
			$data['out_base_price'] 	= $rs['base_price'];
			$data['out_currency_id'] 	= $rs['currency_id'];
			$data['out_price'] 			= $rs['price'];
		
			// 判断本次入库数量是否足够出库
			if ($out_quantity<=$rs['balance']) {
				$data['quantity'] 	= $out_quantity;
				$result	= $this->db->execute('update stock_in set balance=balance-'.$out_quantity.' where id='.$rs['id'] . ' and balance>=' . $out_quantity);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				M('StockOut')->add($data);
				// 出库添加成功同时添加一笔入库记录
				unset($rs['id']);
				$rs['quantity']			= $rs['balance'] = $out_quantity;
				$rs['in_date']			= $main['transfer_date'];
				$rs['main_id'] 			= $main['id'];
				$rs['detail_id'] 		= $value['id'];
				$rs['warehouse_id'] 		= $value['in_warehouse_id'];
				$rs['relation_type'] = $this->relation_type;
				$this->add($rs);
				break;
			}else {
				$data['quantity'] 	= $rs['balance'];
				$result	= $this->db->execute('update stock_in set balance=balance-' . $rs['balance'] . ' where id='.$rs['id'] . ' and balance>=' . $rs['balance']);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				M('StockOut')->add($data);
				$out_quantity -= $rs['balance'];
				// 出库添加成功同时添加一笔入库记录
				unset($rs['id']);
				$rs['quantity']			= $rs['balance'];
				$rs['in_date']			= $main['transfer_date'];
				$rs['main_id'] 			= $main['id'];
				$rs['detail_id'] 		= $value['id'];
				$rs['warehouse_id'] 	= $value['in_warehouse_id'];
				$rs['relation_type'] = $this->relation_type;
				$this->add($rs);
			}
		}
		
	}

	/**
	 * 根据配置生成quantity字段数据
	 *
	 * @param  array $value 明细数据
	 * @param  array $main 主表数据
	 * @param  string $date_field 日期字段名称
	 */
	protected function getQuantity(&$value){
		return $value['quantity'];
	}
	
	
	/**
	 * 添加stock_in记录
	 *
	 * @param  array $value 明细数据
	 * @param  array $main 主表数据
	 * @param  string $date_field 日期字段名称
	 */
	private function setStockInData($value,$main,$date_field){
		$data						= array();
		$data['main_id'] 			= $main['id'];
		$data['detail_id'] 			= $value['id'];
		$data['relation_type'] 		= $this->relation_type;
		$data['warehouse_id'] 		= $value['warehouse_id'] ? $value['warehouse_id'] : $main['warehouse_id'];
		$data['location_id'] 		= $value['location_id'];
		$data['product_id'] 		= $value['product_id'];
		$data['color_id'] 			= C('storage_color') ? $value['color_id'] : 0;
		$data['size_id'] 			= C('storage_size') ? $value['size_id'] : 0;
		$data['quantity'] 			= $this->getQuantity($value);
		if ($data['quantity'] < 0) {
			throw_json($this->getTipsTable($data) . '数据异常，先进数量不能为负数！');
		}
		$data['capability'] 		= C('storage_format')>=2 ? $value['capability'] : 1;
		$data['dozen'] 				= C('storage_format')>=3 ? $value['dozen'] : 1;
		$data['mantissa'] 			= C('storage_mantissa') ? $value['mantissa'] : 1;
		$data['currency_id'] 		= $value['currency_id'] ? $value['currency_id'] : $value['currency_id'] ? $main['currency_id'] : C('currency');
		$data['price'] 				= $value['price']+0;
		$data['in_date'] 			= isset($value[$date_field]) ? $value[$date_field] : $main[$date_field];
		$data['discount'] 			= $value['discount']+0;
		// 计算本位币单价
		$rate = $this->getRate($data['currency_id'],$data['in_date']);
		$data['base_currency_id'] 	= C('currency');
		$data['rate'] 				= $rate;
		$data['base_price'] 		= $value['price']*$rate;
		if (in_array($this->_module, array('instockStorage','instockImport'))) {
			$data['factory_id'] 			= $main['factory_id']?$main['factory_id']:0;
			// 计算运费本位币单价
			if (C('instock.instock_logistics_funds')==1) {
				$data['delivery_price'] 		= $value['delivery_fee_detail'];
				$data['delivery_currency_id'] 	= $main['currency_id'];
				$rate = $this->getRate($main['currency_id'],$data['in_date']);
				$data['delivery_rate'] 			= $rate;
				$data['base_delivery_price'] 	= $value['delivery_fee_detail']*$rate;
			}
		}
		if ($this->_module=='ReturnSaleOrderStorage') {
			$data['price']				= $value['return_base_price']?$value['return_base_price']:0;
			$data['base_price'] 		= $value['return_base_price']*$rate;
			$data['flow_price'] 		= $value['price']?$value['price']:0;
			$data['base_flow_price'] 	= $value['price']*$rate;
		}
		if ($this->_module == 'ShiftWarehouse'){
            $data['warehouse_id'] 		= $value['in_warehouse_id'];
            $data['location_id'] 		= $value['in_location_id'];
            $where  = ' and in_date='.$value['out_date'];
		}
        if($this->_module == 'pickingImport'){
            $where  = ' and in_date='.$value['in_date'];
        }
        $rs = $this->field('id,quantity,balance')->where('relation_type='.$this->relation_type.' and main_id='.$main['id'].' and detail_id='.$value['id'].$where)->find();
		if ($rs['id']>0) {
			$data['id'] = $rs['id'];
			$data['balance'] = $value['quantity']-($rs['quantity']-$rs['balance']);
			$this->save($data);
		}else {
			$data['balance'] = $value['quantity'];
			$this->add($data);
		}
	}

	public function stockOutError(){
        $main					= M('StockOut')->find($this->params['id']);
		$this->relation_type	= $main['out_relation_type'];
		$this->restoreStockOut($this->params['id']);
		$main['id']				= $main['main_id'];
		$detail					= array(
									'id'			=> $main['detail_id'],
									'warehouse_id'	=> $main['out_warehouse_id'],
									'location_id'	=> $main['out_location_id'],
									'currency_id'	=> $main['out_currency_id'],
									'product_id'	=> $main['product_id'],
									'price'			=> $main['out_price'],
									'discount'		=> $main['discount'],
									'quantity'		=> $main['quantity'],
									'out_date'		=> $main['out_date'],
								);
        $this->setStockOutData($detail, $main, 'out_date');
	}
	
	/**
	 * 添加stock_out记录
	 *
	 * @param  array $value 明细数据
	 * @param  array $main 主表数据
	 * @param  string $date_field 日期字段名称
	 */
	private function setStockOutData($value,$main,$date_field){
		$data 						= array();
		$data['main_id'] 			= $main['id'];
		$data['detail_id'] 			= $value['id'];
		$data['out_relation_type'] 	= $this->relation_type;
		$data['out_warehouse_id'] 	= $value['warehouse_id'] ? $value['warehouse_id'] : $main['warehouse_id'];
		$data['out_location_id'] 	= $value['location_id'] ? $value['location_id'] : 0;
		$data['out_date'] 			= isset($value[$date_field]) ? $value[$date_field] : $main[$date_field];
		$data['out_currency_id'] 	= $value['currency_id'] ? $value['currency_id'] : 2;
		$data['product_id'] 		= $value['product_id'];
		$data['out_price'] 			= $value['price'] ? $value['price'] : 0;
		$value['discount'] && $data['discount'] = $value['discount'];
		// 计算本位币单价
		$rate = $this->getRate($data['out_currency_id'],$data['out_date']);
		$data['base_currency_id'] 	= C('currency');
		$data['rate'] 				= $rate;
		$data['out_base_price'] 	= $value['price']*$rate;
		
		$out_quantity = $rs = '';
		$value['quantity']  = $this->getQuantity($value);
		$out_quantity = abs($value['quantity']);
		while ($out_quantity>0) {
			// 根据入库日期降序，先入库的先出库，每次只取一条记录
			$sql = 'select s.* from stock_in s left join location as l on s.location_id=l.id where s.product_id='.$data['product_id'] . ' and s.warehouse_id=' . $data['out_warehouse_id'] . ' and s.location_id=' . $data['out_location_id'] . ' and s.balance>0 order by l.path_sort,s.in_date asc limit 0,1';
			$temp 	= $this->db->query($sql);
			$rs 	= $temp[0];
			if (empty($rs)) {
				throw_json($this->getTipsTable($data) . '库存不足，不能操作！');
			}
			$data['stock_in_id'] 			= $rs['id'];
			$data['in_main_id'] 			= $rs['main_id'];
			$data['in_detail_id'] 			= $rs['detail_id'];			
			$data['in_relation_type'] 		= $rs['relation_type'];
			$data['in_warehouse_id'] 		= $rs['warehouse_id'];
			$data['in_location_id'] 		= $rs['location_id'];
			$data['in_date'] 				= $rs['in_date'];
			$data['in_currency_id'] 		= $rs['currency_id'];
			$data['in_price'] 				= $rs['price'];
			$data['in_base_price'] 			= $rs['base_price'];
			// 判断本次入库数量是否足够出库
			if ($out_quantity<=$rs['balance']) {
				$data['quantity'] 	= $out_quantity;
				$result	= $this->db->execute('update stock_in set balance=balance-'.$out_quantity.' where id='.$rs['id'] . ' and balance>=' . $out_quantity);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				M('StockOut')->add($data);
//				echo M('StockOut')->getLastSql();
				break;
			}else {
				$data['quantity'] 	= $rs['balance'];
				$result	= $this->db->execute('update stock_in set balance=balance-' . $rs['balance'] . ' where id='.$rs['id'] . ' and balance>=' . $rs['balance']);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				M('StockOut')->add($data);
				$out_quantity -= $rs['balance'];
			}
		}
	}
    
    
    /**
	 * 添加stock_out记录由于关联记录需要修改
	 *
	 * @param  array $value 明细数据
	 * @param  string  $restore  是否还原对应入库记录
	 */
	private function setStockOutDataForRelation($value,$restore=true){
		// 所有信息都不改直接删除自身出库后重新分配
		$this->restoreStockOut($value['id'],$restore);
		$out_quantity = $value['quantity'];
		while ($out_quantity>0) {
			// 根据入库日期降序，先入库的先出库，每次只取一条记录
			$sql	= 'select s.* from stock_in as s
                    left join location as l on s.location_id=l.id 
                    where s.product_id='.$value['product_id'].' and s.warehouse_id='.$value['out_warehouse_id'].' and s.location_id='.$value['out_location_id'].' and balance>0 order by l.path_sort,s.in_date,s.id asc limit 0,1';
			$temp 	= $this->db->query($sql);
			$rs 	= $temp[0];
			if (empty($rs)) {
				throw_json($this->getTipsTable($value) . '库存不足，不能操作！');
			}
			$value['stock_in_id'] 			= $rs['id'];
			$value['in_main_id'] 			= $rs['main_id'];
			$value['in_detail_id'] 			= $rs['detail_id'];
			$value['in_relation_type'] 		= $rs['relation_type'];
			$value['in_warehouse_id'] 		= $rs['warehouse_id'];
			$value['in_location_id'] 		= $rs['location_id'];
			$value['in_date'] 				= $rs['in_date'];
			$value['in_currency_id'] 		= $rs['currency_id'];
			$value['in_price'] 				= $rs['price'];
			$value['in_base_price'] 		= $rs['base_price'];
			$value['base_delivery_price'] 	= $rs['base_delivery_price'];
			// 判断本次入库数量是否足够出库
			unset($value['id']);
			if ($out_quantity<=$rs['balance']) {
				$value['quantity'] 	= $out_quantity;
				$result	= $this->db->execute('update stock_in set balance=balance-'.$out_quantity.' where id='.$rs['id'] . ' and balance>=' . $out_quantity);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				M('StockOut')->add($value);
//				echo M('StockOut')->getLastSql();
				break;
			}else {
				$value['quantity'] 	= $rs['balance'];
				$result	= $this->db->execute('update stock_in set balance=balance-' . $rs['balance'] . ' where id='.$rs['id'] . ' and balance>=' . $rs['balance']);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				M('StockOut')->add($value);
				$out_quantity -= $rs['balance'];
			}
		}
		
	}
    
    /**
	 * 添加移仓先进先出记录
	 *
	 * @param  array $value 明细数据
	 * @param  array $main 主表数据
	 */
	private function setShiftWarehouseData($value,$main){
		$data 						= array();
		$data['main_id'] 			= $main['id'];
		$data['detail_id'] 			= $value['id'];
		$data['out_relation_type'] 	= $this->relation_type;
		$data['out_warehouse_id'] 	= $value['out_warehouse_id'];
		$data['out_location_id'] 	= $value['out_location_id'];
//		$data['out_date'] 			= isset($value[$date_field]) ? $value[$date_field] : $main[$date_field];
		$data['out_currency_id'] 	= $value['currency_id'] ? $value['currency_id'] : 2;
		$data['product_id'] 		= $value['product_id'];
		$data['out_price'] 			= $value['price'] ? $value['price'] : 0;
		$value['discount'] && $data['discount'] = $value['discount'];
		// 计算本位币单价
		$rate = $this->getRate($data['out_currency_id'],$data['out_date']);
		$data['base_currency_id'] 	= C('currency');
		$data['rate'] 				= $rate;
		$data['out_base_price'] 	= $value['price']*$rate;
		
		$out_quantity = $rs = '';
		$value['quantity']  = $this->getQuantity($value);
		$out_quantity   = abs($value['quantity']);
		while ($out_quantity>0) {
			// 根据入库日期降序，先入库的先出库，每次只取一条记录
			$sql = 'select s.* from stock_in s left join location as l on s.location_id=l.id where s.product_id='.$data['product_id'] . ' and s.warehouse_id=' . $data['out_warehouse_id'] . ' and s.location_id=' . $data['out_location_id'] . ' and s.balance>0 order by l.path_sort,s.in_date asc limit 0,1';
			$temp 	= $this->db->query($sql);
			$rs 	= $temp[0];
			if (empty($rs)) {
				throw_json($this->getTipsTable($data) . '库存不足，不能操作！');
			}
			$data['stock_in_id'] 			= $rs['id'];
			$data['in_main_id'] 			= $rs['main_id'];
			$data['in_detail_id'] 			= $rs['detail_id'];			
			$data['in_relation_type'] 		= $rs['relation_type'];
			$data['in_warehouse_id'] 		= $rs['warehouse_id'];
			$data['in_location_id'] 		= $rs['location_id'];
			$data['in_date'] 				= $rs['in_date'];
			$data['in_currency_id'] 		= $rs['currency_id'];
			$data['in_price'] 				= $rs['price'];
			$data['in_base_price'] 			= $rs['base_price'];
            //移仓出库时间等于先进表入库时间
            $data['out_date']               = $rs['in_date'];
            //构造入库信息
            $value['out_date']              = $data['out_date'];
			// 判断本次入库数量是否足够出库
			if ($out_quantity <= $rs['balance']) {
				$data['quantity'] 	= $out_quantity;
				$result	= $this->db->execute('update stock_in set balance=balance-'.$out_quantity.' where id='.$rs['id'] . ' and balance>=' . $out_quantity);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				M('StockOut')->add($data);
                $key                = $data['detail_id'].'_'.$data['out_date'];
                $value['quantity']  = $in_data[$key]['quantity']+$data['quantity'];
                $in_data[$key]      = $value;
				break;
			}else {
				$data['quantity'] 	= $rs['balance'];
				$result	= $this->db->execute('update stock_in set balance=balance-' . $rs['balance'] . ' where id='.$rs['id'] . ' and balance>=' . $rs['balance']);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				M('StockOut')->add($data);
                $out_quantity -= $rs['balance'];
			}
            $key                = $data['detail_id'].'_'.$data['out_date'];
            $value['quantity']  = $in_data[$key]['quantity']+$data['quantity'];
            $in_data[$key]      = $value;
		}
        foreach ($in_data as $val){
            $this->setStockInData($val,$main,'out_date');
        }
	}
    
    /**
	 * 修改入库记录时同步对应的出库信息
	 *
	 */
	private function synchronismStockOut(){
		// 获取删除的记录更新对应出库记录信息
		$sql = 'select * from stock_out where stock_in_id=0 and in_main_id='.$this->params['id'].' and in_relation_type='.$this->relation_type;
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$this->setStockOutDataForRelation($value);
		}
		// 获取指定出库数量大于入库数量的记录更新对应出库记录信息
		$sql = 'select id,quantity from stock_in where balance<0 and main_id='.$this->params['id'].' and relation_type='.$this->relation_type;
		$detail = $this->db->query($sql);
		foreach ((array)$detail as $value) {
			$this->setStockOutDataForStockIn($value['id'],$value['quantity']);
		}
	}
	
	/**
	 * 修改入库导致指定出库数据发生变化时更新超出部分的出库信息
	 *
	 * @param int $stock_in_id  入库ID
	 * @param int $exceed_quantity	 入库数量
	 */
	private function setStockOutDataForStockIn($stock_in_id,$quantity){
		// 更新超出入库数量部分的出库记录
		$sql 			= 'select * from stock_out where stock_in_id='.$stock_in_id.' order by out_date asc,id asc';
		$detail 		= $this->db->query($sql);
		$out_quantity 	= 0;
		$flag			= false;
		foreach ((array)$detail as $value) {
			$out_quantity+=$value['quantity'];
			if ($out_quantity>=$quantity || $flag==true) {
				if ($flag==true) {
					$this->setStockOutDataForRelation($value);
				}else {
					$unfinish_quantity 	= $out_quantity-$quantity;
					$finish_quantity 	= $value['quantity']-$unfinish_quantity;
					$ary = array('id'=>$value['id'],'quantity'=>$finish_quantity);
					M('StockOut')->save($ary);
					$value['quantity']	= $unfinish_quantity;
					$this->setStockOutDataForRelation($value,false);
					$flag = true;
				}
			}
		}
	}
	
	
	/**
	 * 根据当前币种获取与本位币的汇率
	 *
	 * @param  $from_currency 币种ID
	 * @param   $date 转换日期
	 */
	private function getRate($from_currency,$rate_date){
		$rate_type 		= C('set_rate_type');
		$to_currency 	= C('currency');
		if($from_currency==$to_currency) return 1;
		import('ORG.Util.Date');
		$date = new Date($rate_date);
		switch ($rate_type) {
			case 1:
				$rate_info = M('FixedRate')->field('rate')->where('from_currency_id='.$from_currency.' and to_currency_id='.$to_currency)->find();
				break;
			case 2:
				$rate_info = M('RateInfo')->field('opened_y as rate')->where('from_currency_id='.$from_currency.' and to_currency_id='.$to_currency.' and rate_date=\''.$date->format('%Y-%m').'-01\'')->find();
				break;
			default:
				$rate_info = M('RateInfo')->field('opened_y as rate')->where('from_currency_id='.$from_currency.' and to_currency_id='.$to_currency.' and rate_date=\''.$date->format('%Y-%m-%d').'\'')->find();
				break;
		}
		// 找不到对应汇率时取固定汇率记录汇率错误日志，一天只记录一次
		if ($rate_info['rate']<=0) {
			$count = M('RateError')->where('error_date=\''.$date->format('%Y-%m-%d').'\' and from_currency_id='.$from_currency.' and to_currency_id='.$to_currency)->count();
			if ($count<=0) {
				M('RateError')->add(array('from_currency_id'=>$from_currency,'to_currency_id'=>$to_currency,'error_date'=>$rate_date));
			}
			$rate_info = M('FixedRate')->field('rate')->where('from_currency_id='.$from_currency.' and to_currency_id='.$to_currency)->find();
		}
		return $rate_info['rate'];
	}

	/**
	 * 还原出库记录
	 *
	 * @param int $out_id
	 * @param  string  $restore  是否还原对应入库记录
	 */
	protected function restoreStockOut($out_id=null,$restore=true){
		if ($restore==false) {
			$del_data = M('StockOut')->find($out_id);
			return $this->execute('update stock_in set balance=0 where id='.$del_data['stock_in_id']); 
		}
		if ($out_id) {
			$del_data = M('StockOut')->where('id='.$out_id)->select();	
		}else {
			$del_data = M('StockOut')->where('main_id='.$this->params['id'].' and out_relation_type='.$this->relation_type)->select();	
		}
		foreach ((array)$del_data as $del_value) {
			$this->execute('update stock_in set balance=balance+'.$del_value['quantity'].' where id='.$del_value['stock_in_id']); 
		}
		if ($out_id) {
			M('StockOut')->where('id='.$out_id)->delete();
		}else {
			M('StockOut')->where('main_id='.$this->params['id'].' and out_relation_type='.$this->relation_type)->delete();
		}
	}

	private function getTipsTable($data){
		static $barcode_no_list	= array();
		$w_name		= SOnly('warehouse', $data['out_warehouse_id'], 'w_name');
		$label		= '[FiFo]' . L('warehouse') . '[' . $w_name . ']>';
		if (!isset($barcode_no_list[$data['out_location_id']])) {
			$barcode_no_list[$data['out_location_id']]		= M('Location')->where(array('id' => $data['out_location_id']))->getField('barcode_no');
		}
		$barcode_no	= $barcode_no_list[$data['out_location_id']];
		$label		.= L('warehouse_location') . '[' . $barcode_no . ']>';
		$product_no	= SOnly('product', $data['product_id'], 'product_no');
		$label		.= L('product_id') .'[' . $data['product_id'] . ']' . L('product_no') .'[' . $product_no . ']: ';
		return $label;
	}
}