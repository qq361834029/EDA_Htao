<?php 
/**
 * 拣货管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	拣货信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-04-15
 */

class PickingPublicModel extends FileListPublicModel {

	/// 自动验证设置
	protected $_validate	 =	 array(
			array("warehouse_id",'require',"require",1),//仓库
		);		
	/// 缓存数据
	private $_cacheData;
	
	/**
	 * 前置操作
	 *
	 * @param array $info
	 * @return array
	 */
	public function _beforeModel(&$info){	  
		if (ACTION_NAME == 'insert') {
			$info['sale']['query']['s.warehouse_id']	= $info['warehouse_id'];

			if ($info['sale']['query']['out_stock_type'] == 2) {//复合订单查询
				$info['sale']['morethan']['out_stock_type']	= $info['sale']['query']['out_stock_type'];
				unset($info['sale']['query']['out_stock_type']);
			}			 
            //新拣货 非选择订单类型为“转仓”时，过滤销售渠道为“转仓”的订单
            $change_warehouse   = '';
            if($info['sale']['query']['out_stock_type'] != C('OUT_STOCK_CHANGE_WAREHOUSE')){
                $change_warehouse   = " and order_type<>".C('ORDER_TYPE_CHANGE_WAREHOUSE');
            }else{
                $info['sale']['query']['out_stock_type']   = '';
                $change_warehouse   = " and order_type=".C('ORDER_TYPE_CHANGE_WAREHOUSE');
            }
            //新拣货导出  派送方式	     		
		    if($info['express_id']>0){				 
				$shipping_type=" and e.id=".$info['express_id'];
		    }
            //新拣货导出  快递公司
            if($info['company_id']>0){
                $shipping_type .=" and e.company_id =".$info['company_id'];
            }
            //新拣货导出  是否仓库自提
		    if(empty($info['express_id'])&&empty($info['company_id'])){
                if($info['sale']['is_warehouse_pickup'] == 'on'){
					$shipping_type .= " and e.company_id =".(int)C('ONESELF_TAKE');
				}else{
					$shipping_type .= " and e.company_id <>".(int)C('ONESELF_TAKE');
				}
            }	 	      	    	    	    
			$sale_where		= getWhere($info['sale']) . ' and sale_order_state=' . C('SALE_ORDER_STATE_EXPORTING').$change_warehouse;	
			//查找所有符合的“导出中”状态的销售单产品明细
			$sale_detail_list	= M('SaleOrder')->field('product_id,sum(quantity) as quantity, sale_order_id')
											->join(' s right join sale_order_detail sd on sd.sale_order_id=s.id left join express e on e.id=s.express_id')
											->where($sale_where.$shipping_type)
											->group('sale_order_id,product_id')
											->select();		
			//找不到符合要求的销售单
			if (empty($sale_detail_list)) {			
				$this->error		= L('no_record_for_search');
				$this->errorStatus	= 0;
				return false; 				
			}
			$this->_cacheData = $sale_detail_list;	
			$product_list	= array();
			foreach($sale_detail_list as $sale_detail){
				//关联明细
				$this->data['relation_detail'][$sale_detail['sale_order_id']]	 = array('relation_id'=>$sale_detail['sale_order_id'], 'file_type' => $this->_file_type);
				//产品明细
				$product_list[$sale_detail['product_id']]						+= $sale_detail['quantity'];
			}
			$info['sale_order_list']	= array_keys($this->data['relation_detail']);//后面更新销售单状态会用到
			//查询库存
			$info['storage']['query']['s.warehouse_id']	= $info['warehouse_id'];
            $data                       = array();
            $stock_out_id               = array();
            $data['out_warehouse_id']   = $info['warehouse_id'];
            $data['main_id'] 			= 0;
            $data['detail_id'] 			= 0;
            $data['out_currency_id']    = C('currency');
            $data['out_date']           = date("Y-m-d");
            $data['base_currency_id']   = C('currency');
            $data['out_relation_type'] 	= C('FIFO_PICKING');
            foreach($product_list as $product_id=>$quantity){
                $data['product_id'] = $product_id;
                $data['quantity']   = $quantity;
                $stock_out_id       = array_merge($stock_out_id, $this->addStockOut($data));
            }
			//分配拣货
            $sql    = 'SELECT s.product_id,s.out_location_id as location_id,sum(s.quantity) as quantity,l.barcode_no FROM `stock_out` as s left join location as l on s.out_location_id=l.id WHERE s.id in ('.  implode(',', $stock_out_id).') group by s.product_id,s.out_location_id';
			$detail = $this->db->query($sql);
			$count	= count($detail);
			$picking_max_row	= C('picking_max_row') > 0 ? C('picking_max_row') : 9999;
			if ($count > $picking_max_row) {
				rollback();
				throw_json(emoji_unified_to_html("\xF0\x9F\x98\xA8").sprintf(L("picking_rows_over_limit"), $count, $picking_max_row));
			}
			$out	= M('StockOut')->where(array('id' => array('in', $stock_out_id)))->field('id, product_id, out_location_id as location_id')->select();
			$out_id	= array();
			foreach($out as $val) {
				$out_id[$val['product_id'] . '_' . $val['location_id']][]	= $val['id'];
			}
			foreach ($detail as &$val) {
				$val['state']		= C('CFG_IMPORT_SUCCESS_STATE');
				$val['stock_out_id']	= implode(',', $out_id[$val['product_id'] . '_' . $val['location_id']]);
			}
			$this->data['detail']	= $detail;
			unset($detail, $stock_out_id, $out, $out_id);
		}
		return true;
	} 		
    //先进先出筛选
    public function addStockOut($data){
		$out_quantity = abs($data['quantity']);
		while ($out_quantity>0) {
			// 根据入库日期降序，先入库的先出库，每次只取一条记录
			$sql = 'select s.* from stock_in s 
                    left join location as l on s.location_id=l.id 
                    left join warehouse as w on s.warehouse_id=w.id
                    where s.product_id='.$data['product_id'] . ' and s.warehouse_id=' . $data['out_warehouse_id'] . ' and s.balance>0 and w.is_return_sold='.C('CAN_RETURN_SOLD').' order by l.path_sort,s.in_date,s.id asc limit 0,1';
            $temp 	= $this->db->query($sql);
			$rs 	= $temp[0];
			if (empty($rs)) {
				rollback();
				throw_json( L('product_no').'“'.SOnly('product', $data['product_id'], 'product_no').'”'.L('storage_no_enough'));
			}
            $data['out_location_id']        = $rs['location_id'];
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
				$out_id[]     = M('StockOut')->add($data);
				break;
			}else {
				$data['quantity'] 	= $rs['balance'];
				$result	= $this->db->execute('update stock_in set balance=balance-'.$rs['balance'].' where id='.$rs['id'] . ' and balance>=' . $rs['balance']);
				if ($result === 0) {
					rollback();
					throw_json('程序执行异常，请稍后重试！');
				}
				$out_id[]     = M('StockOut')->add($data);
				$out_quantity -= $rs['balance'];
			}
		}
        return $out_id;
    }

    public function setIndexList(&$list) {
		$ids	= array_keys($list);
//		$relation_details	= M('FileRelationDetail')->field('object_id as file_id,b.id as sale_order_id, b.sale_order_no')->join('a left join sale_order b on b.id=a.relation_id')->where('object_id in (' . implode(',', $ids)  . ') and file_type=' . $this->_file_type)->order('b.sale_order_no desc')->select();
//        if ($relation_details) {
//			foreach ($relation_details as $detail) {
//				$sale_order_list	= isset($list[$detail['file_id']]['sale_order_list']) ? explode('<br />', $list[$detail['file_id']]['sale_order_list']) : array();
//				$sale_order_list[]	= '<a href="javascript:;" onclick="addTab(\'' . U('/SaleOrder/view/id/' . $detail['sale_order_id']) .  '\',\'' . title('view', 'SaleOrder') .  '\'); ">' . $detail['sale_order_no'] . '</a>';
//				$list[$detail['file_id']]['sale_order_list']	= implode('<br />', $sale_order_list);
//			}
//		}
//        unset($relation_details);
		$relation_list	= M('FileList')->field('a.id as file_id,group_concat(b.file_list_no SEPARATOR ",") as relation_no')->join('a left join file_list b on a.id=b.relation_id')->where('a.id in (' . implode(',', $ids) . ')')->group('a.id')->select();
		if ($relation_list) {
			foreach ($relation_list as $detail) {
				$list[$detail['file_id']]['relation_no']	= str_replace(',' ,'<br/>',$detail['relation_no']);
			}
		}		
		return $list;
	}
    //获取拣货先出记录
    public function getStockOut($picking_import_id){
        if($picking_import_id > 0){
            $relation_picking_id    = M('FileList')->where('relation_id=' . $picking_import_id . ' and file_type=' . array_search('Picking', C('CFG_FILE_TYPE')))->getField('id');
            if($relation_picking_id > 0){
                $stock_out      = M('StockOut')->alias('s')
                                ->field('s.out_location_id as location_id,s.in_date,s.product_id,sum(quantity) as quantity')
                                ->join('left join __LOCATION__ as l on s.out_location_id=l.id ')
                                ->where('s.out_relation_type=11 and s.main_id='.$relation_picking_id)
                                ->order('l.path_sort,s.in_date')
                                ->group('s.out_location_id,s.in_date,s.product_id')
                                ->select();
                foreach($stock_out as $value){
                    $stock_out_product[$value['product_id']][]  = $value;
                }
            }
        }
        return $stock_out_product;
    }
        
    public function detailAfterInsert($detail){
        $sql    = 'update stock_out set main_id='.$detail['file_id'].',detail_id='.$detail['id'].' where id in ('.$detail['stock_out_id'].')';
        $this->db->query($sql);
    }
	
	
	public function _afterModel($info){
		$this->makePickingCache($info);
	}
	
	/**	
	 * 生成拣货导出缓存（销售缓存、产品缓存）
	 * @return array|boolean|null
	 */
    public function makePickingCache($info){
		if (ACTION_NAME == 'insert') {
			$saleOrderCache  = array();		//销售缓存
			$productCache    = array();		//产品缓存
			foreach ($this->_cacheData as $key=>$value){
				$saleOrderCache[$value['sale_order_id']][$value['product_id']] += $value['quantity'];
				$productCache[$value['product_id']][$value['sale_order_id']]   += $value['quantity'];
			}
			$picking_no = M('file_list')->where(array('id'=>$this->id))->getField('file_list_no');
			S('picking:saleOrder:'.$picking_no,$saleOrderCache);
			S('picking:product:'.$picking_no,$productCache);
		}elseif(ACTION_NAME == 'delete'){
			$picking_no = M('file_list_del')->where(array('id'=>$this->id))->getField('file_list_no');
			S('picking:saleOrder:'.$picking_no,null);
			S('picking:product:'.$picking_no,null);
		}
	}
}