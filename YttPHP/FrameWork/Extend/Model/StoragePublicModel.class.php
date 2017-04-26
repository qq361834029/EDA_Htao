<?php

/**
 *  库存更新管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	库存信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class StoragePublicModel extends Model {
	/// 定义表名
	protected $tableName		= 'storage';
	/// 参数包括$_POST $_GET
	protected $params 			= array();
	/// 流程的库存规格，属性
	protected $storage_attr 		= array();
	/// 系统库存的规格，属性
	protected $sys_storage_attr 	= array();
	/// 定义各流程对应有type值
	protected $relation_type	= array(
						'loadContainer'		=> 1,
						'instock'			=> 2,
						'saleOrder'			=> 3,
						'adjust'			=> 4,
						'returnSaleOrderStorage' 	=> 5,
						'transfer' 			=> 6,
						'delivery'			=> 7,
						'initStorage'		=> 8,
						'profitandloss'		=> 9,
						'instockImport'		=> 10,//入库导入
						'picking'			=> 11,//拣货导出更新实际库存中的picking_quantity，并记录其库存日志	
						'pickingImport'		=> 12,//拣货导入
						'pickingOut'		=> 13,//拣货导入更新实际库存中的picking_quantity，并记录其库存日志
						'oldBackShelves'	=> 14,//拣货导入重新上架
                        'instockStorage'    => 15,//发货入库
                        'domesticWaybill'   => 16,//国内运单
                        'shiftWarehouse'    => 17,//移仓
                        'backShelves'       => 18,//新重新上架
//                        'packBox'           => 22,//装箱
                        'outBatch'          => 22,//装箱
						'instockImportAdjust'          => 23, //入库导入调整
	);
	/// 当前库存更新的流程名称
	protected $module_name = '';
    public $storage_warn    = array();
    public $warn_product    = array();
    public $count           = array();

    /**
	 * 更新库存公共接口
	 *
	 * @param  参数 $params
	 * @param  方法名称，默认取模块名称，首字母转小写
	 * @return  null
	 */
	public function updateStorage($params,$method_name=null){
		$this->_module = $params['_module'];
		$this->_action = $params['_action'];
		$this->params = $params;	
		switch ($this->_module){
			case 'InstockAbnormal':
				$method_name		= 'instockImport';
				$this->params['id']	= M('FileDetail')->where('id=' . $this->params['id'])->getField('file_id');
				break;
			case 'PickingAbnormal':
				$method_name		= 'pickingImport';
				$this->params['id']	= M('FileDetail')->where('id=' . $this->params['id'])->getField('file_id');
				break;
			default :
				break;
		}			
		empty($method_name) && $method_name = ucwords_first($this->_module);
		$this->module_name = $method_name;
		$this->getSpec();
		$this->$method_name();
        if (!empty($this->warn_product)) {
                M('email_list')->addAll($this->warn_product);
        }
	}
	
	/**
	 * 根据配置信息获取库存更新属性
	 *
	 * @return  null
	 */
	private function getSpec(){
		//$storage_attr = array('location_id','product_id');
		$storage_attr = array('warehouse_id','product_id');
		$this->storage_attr = $storage_attr;
	}

	private function getSysSpec(){
		// 声明固定项，仓库,产品，可销售库存是不存在仓库对应代码会出现 0 as warehouse_id 务必不可修改$storage_attr中warehouse_id索引顺序
		$storage_attr = array('warehouse_id', 'location_id', 'product_id');
		$this->sys_storage_attr = $storage_attr;
	}
	
	/**
	 * 根据规格生成查询条件
	 * @param  array
	 * @param  int  1实际库存 2可销售库存
	 * @return  string
	 */
	private function getSpecWhere($value,$type = 1){
		$this->getSysSpec();
		foreach ($this->sys_storage_attr as $spec_field) {
			if($type==2 && in_array($spec_field,array('location_id'))){continue;}
			$where[] = $spec_field.'='.$value[$spec_field];
		}
		return implode(' and ',$where);
	}
	
	
	/**
	 * 装柜更新库存
	 *
	 * @return  bool
	 */
	private function loadContainer(){
		if (C('loadContainer.sale_storage')!=1) return true;
		$ary_field = $this->storage_attr;
		$str_field = implode(',',$ary_field);
		// 暂存集装箱或已入库时直接删除旧库存
		if ($this->params['load_state']>=2) {
			$sql = 'select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=1 and main_id='.$this->params['id'];
		}else {
			$sql = 'select quantity,id as detail_id,0 as '.$str_field.' from load_container_details where load_container_id='.$this->params['id'].'  
					union all 
					select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=1 and main_id='.$this->params['id'];
		}
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$storage_log_var = $value;
			$storage_log_var['main_id'] 		= $this->params['id'];
			$storage_log_var['relation_type'] 	= $this->relation_type[$this->module_name];
			M('StorageLog')->add($storage_log_var);
			$value = $this->dataTransform($value);
			$this->execSaleStorage($value);
		}
		return true;
	}
    /**
	 * 装箱更新库存
	 * 
	 * @return  bool
	 */
	private function outBatch(){
        $this->getSysSpec();
        $ary_field = $this->sys_storage_attr;
        $str_field = implode(',',$ary_field);
        
//        $sql = 'select quantity as quantity,pbd.id as detail_id,rsd.'.$str_field.' from pack_box_detail pbd 
//                left join return_sale_order_storage_detail rsd on pbd.return_sale_order_id=rsd.return_sale_order_id
//                left join pack_box_detail pb on pbd.pack_box_id=pb.id
//                where pbd.pack_box_id='.$this->params['id'].'  
//                union all 
//                select quantity,detail_id,'.$str_field.' from storage_log 
//                where relation_type=22 and main_id='.$this->params['id'];
        
        $sql = 'select quantity-drop_quantity as quantity,rsd.id as detail_id,rsd.'.$str_field.'
			from out_batch_detail obd
            left join pack_box_detail pbd on pbd.pack_box_id=obd.pack_box_id 
            left join return_sale_order_storage_detail rsd on pbd.return_sale_order_id=rsd.return_sale_order_id
            where obd.out_batch_id='.$this->params['id'].' and rsd.quantity>rsd.drop_quantity
            union all 
            select quantity,detail_id,'.$str_field.' from storage_log 
            where relation_type=22 and main_id='.$this->params['id'];
        $sql = 'select sum(quantity*-1) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
        $var = $this->db->query($sql);
        foreach ((array)$var as $value) {
            $value = $this->dataTransform($value);
            $this->execStorageLog($value);
            $this->execSaleStorage($value);
            $this->execRealStorage($value);
        }
        return true;
	}
	
	/**
	 * 入库更新库存
	 * 
	 * @return  bool
	 */
	private function instock(){
		if ($this->params['step'] == 2) {//第二步输入产品明细时才验证
			$ary_field = $this->storage_attr;
			$str_field = implode(',',$ary_field);
			$sql = 'select quantity,id as detail_id,'.$str_field.' from instock_detail where instock_id='.$this->params['id'].'  
					union all 
					select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=2 and main_id='.$this->params['id'];
			$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
			$var = $this->db->query($sql);
			foreach ((array)$var as $value) {
				$value = $this->dataTransform($value);
				$this->execStorageLog($value);
				$this->execSaleStorage($value);
				$this->execRealStorage($value);
			}
			return true;
		}
	}

    private function InstockStorage(){
		$ary_field = $this->storage_attr;
		$ary_field[] = 'location_id';
		$str_field = implode(',',$ary_field);
		$sql = 'select in_quantity as quantity,id as detail_id,'.$str_field.' from instock_storage_detail where instock_storage_id='.$this->params['id'].'  
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=15 and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
			$this->execRealStorage($value);
			
		}
		return true;
    }

    /**
	 * 导入/导出更新库存
	 * 
	 * @param int $type 1更新可销售库存，2更新实际库存，3更新可销售库存及实际库存，4更新实际库存中的picking_quantity
	 * @param boolean $add_stock 加/减库存
	 * @return boolean
	 */
	private function import($type, $add_stock = true){
		$relation_type 	= (int)$this->relation_type[$this->module_name];
		$ary_field		= $this->storage_attr;
		$ary_field[]	= 'location_id';
		$str_field		= implode(',',$ary_field);
		$field			= $this->_action == 'backShelves' ? 'undeal_quantity*-1' : 'quantity';
		$quantity_field	= $add_stock ? 'a.' . $field : 'a.' . $field . '*-1 as quantity';
		$sql = 'select ' . $quantity_field . ',a.id as detail_id,'.$str_field.' from file_detail a left join file_list b on a.file_id=b.id where a.file_id='.$this->params['id'].' and a.state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ', ' . C('CFG_IMPORT_PROCESSED_STATE') . ')';
		if ($this->_action != 'backShelves') {//重新上架时不能累加库存日志数据(否则如下操作会有问题，一直存在未分配数量 1. 重新上架，2. 作废订单，3. 重新上架) added by jp 20150319
			$sql	.= 'union all
						select a.quantity*-1 as quantity,a.detail_id,'.$str_field.' from storage_log a where a.relation_type=' . $relation_type . ' and a.main_id='.$this->params['id'];
		}
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			if (($type & 1) == 1) {
				$this->execSaleStorage($value);
			}
			if (($type & 2) == 2) {
				$this->execRealStorage($value);
			}
			if (($type & 4) == 4) {
				$this->execPickingQuantity($value);
			}
			if (($type & 8) == 8) {
				$this->execUndealQuantity($value);
			}
		}
		return true;
	}
	
	/**
	 * 入库更新库存
	 * 
	 * @return  bool
	 */
	private function instockImport(){
		return $this->import(3);//增加可销售库存及实际库存
	}	
	
	/**
	 * 拣货导出更新picking_quantity
	 * 
	 * @return  bool
	 */
	private function picking(){
		return $this->import(4);//只记录日志不扣库存，增加picking_quantity
	}	
	
	/**
	 * 拣货导入更新库存
	 * 
	 * @return  bool
	 */
	private function pickingImport(){
		if ($this->_action == 'backShelves') {//重新上架
			$this->module_name = $this->_action;
			return $this->import(10, false);//扣减可销售库存,更新未分配数量
		}
		$result	= $this->import(2, false);//扣减实际库存
		if($result){//更新picking_quantity数量及记录相应库存日志
			$this->module_name	= 'pickingOut';
			$relation_type		= (int)$this->relation_type[$this->module_name];
			$ary_field			= $this->storage_attr;
			$ary_field[]		= 'location_id';
			$str_field			= implode(', ', $ary_field);
			$str_field2			= str_replace(array('product_id', 'location_id'), array('a.product_id', 'a.location_id'), $str_field);
			$model_name			= ACTION_NAME == 'delete' ? 'FileListDel' : 'FileList';
			$picking_id			= M($model_name)->where('id=' . $this->params['id'])->getField('relation_id');//拣货导出单id
			//查找拣货导入绑定的拣货导出明细id
			//查找拣货导入绑定的拣货导出库存日志更新信息
			$sql = 'select a.quantity*-1 as quantity, a.id as detail_id,'. $str_field2 .' from file_detail d inner join file_detail a on a.id=d.relation_id left join file_list b on a.file_id=b.id where d.file_id=' . $this->params['id'] . ' and d.state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ', ' . C('CFG_IMPORT_PROCESSED_STATE') . ')
					union all 
					select a.quantity*-1 as quantity, a.detail_id,'.$str_field.' from storage_log a where a.relation_type=' . $relation_type . ' and a.main_id=' . $picking_id;
			$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
            $var = $this->db->query($sql);
            $this->replyUndealQuantity($this->params['id']);//删除拣货导入恢复重新上架数量
			$this->params['id']	= $picking_id;//重置此id为拣货导出id
			foreach ((array)$var as $value) {
				$value = $this->dataTransform($value);
				$this->execStorageLog($value);
				$this->execPickingQuantity($value);
			}
			return true;
		} else {			
			return false;
		}
	}
	
	/**
	 * 销售更新库存
	 * 
	 * @return  bool
	 */
	private function saleOrder(){
		$ary_field = $this->storage_attr;
		$str_field = implode(',',$ary_field);
		$sql = 'select quantity*-1 as quantity,a.id as detail_id,a.warehouse_id,product_id from sale_order_detail a
				LEFT JOIN sale_order b ON a.sale_order_id=b.id
				where b.sale_order_state not in ('.C('SALEORDER_OBSOLETE').','.C('SALE_ORDER_DELETED').') and sale_order_id='.$this->params['id'].'  
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=3 and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
		}
		return true;
	}
	
	
	/**
	 * 发货更新库存
	 * 
	 * @return  bool
	 */
	private function delivery(){
		$ary_field = $this->storage_attr;
		$str_field = implode(',',$ary_field);
		$sql = 'select quantity*-1 as quantity,id as detail_id,'.$str_field.' from delivery_detail where delivery_id='.$this->params['id'].'  
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=7 and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$this->execStorageLog($value);
			$this->execRealStorage($value);
		}
		/// 销售单完成时由于实际发货与销售可能出现不一致情况，此处还原销售单扣除的可销售库存，按实际发货扣除。
		if ((C('delivery.multi_delivery')==2 || (C('delivery.multi_delivery')==1 && $this->params['sale_finish']==1)) && ACTION_NAME!='delete') {
			$temp = M('delivery_detail')->field('sale_order_id')->where('delivery_id='.$this->params['id'])->find();
			$sale_order_id = $temp['sale_order_id'];
			if($sale_order_id<=0){
				$temp = M('delivery_detail_del')->field('sale_order_id')->where('delivery_id='.$this->params['id'])->find();
				$sale_order_id = $temp['sale_order_id'];
			}
			/// 先还原上次扣除的不一致库存，再根据发货单与销售单差异更新可销售库存
			$sql = 'select quantity*-1 as quantity,relation_type,detail_id,'.$str_field.' from storage_log where relation_type=10 and main_id='.$sale_order_id.' 
				union all select quantity as quantity,3 as realtion_type,id as detail_id,0 as '.$str_field.' from sale_order_detail where sale_order_id='.$sale_order_id.'  
				union all select quantity*-1 as quantity,7 as realtion_type,id as detail_id,0 as '.$str_field.' from delivery_detail where sale_order_id='.$sale_order_id;
		$sql = 'select sum(quantity) as quantity,10 as relation_type,'.$sale_order_id.' as main_id,detail_id,'.$str_field.' from ('.$sql.') as tmp group by '.$str_field.' having sum(quantity)!=0 order by quantity desc';
			$var = $this->db->query($sql);
			foreach ((array)$var as $value) {
				$value = $this->dataTransform($value);
				$this->execStorageLog($value,true);
				unset($value['main_id'],$value['relation_type']);
				$this->execSaleStorage($value);
			}
		}else {
			$temp = M('delivery_detail')->field('sale_order_id')->where('delivery_id='.$this->params['id'])->find();
			$sale_order_id = $temp['sale_order_id'];
			if($sale_order_id<=0){
				$temp = M('delivery_detail_del')->field('sale_order_id')->where('delivery_id='.$this->params['id'])->find();
				$sale_order_id = $temp['sale_order_id'];
			}
			$sql = 'select sum(quantity*-1) as quantity,relation_type,main_id,detail_id,'.$str_field.' from storage_log where relation_type=10 and main_id='.$sale_order_id.' group by main_id,relation_type,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
			$var = $this->db->query($sql);
			foreach ((array)$var as $value) {
				$value = $this->dataTransform($value);
				$this->execStorageLog($value,true);
				unset($value['main_id'],$value['relation_type']);
				$this->execSaleStorage($value);
			}
		}
		return true;
	}
	
	
	/**
	 * 退换货更新库存
	 * 
	 * @return  bool
	 */
	private function returnSaleOrderStorage(){
        $this->getSysSpec();
		$ary_field = $this->sys_storage_attr;
		$str_field = implode(',',$ary_field);
		//入库数量-丢弃数量=实际入库数量        edit by lxt 2015.09.02
		$sql = 'select (quantity-drop_quantity) as quantity,id as detail_id,'.$str_field.' from return_sale_order_storage_detail where return_sale_order_storage_id='.$this->params['id'].' and quantity>drop_quantity 
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=5 and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		/// 查询是否存在对应换货单
//		$temp = M('return_sale_order')->field('sale_order_id')->find($this->params['id']);
		if(is_array($var) && !empty($var) ) {
            foreach($var as $val){
                $location_id[$val['location_id']]      = $val['location_id'];
            }
            //按实际库位存入不可再销售仓库
            $location           = M('location')->where('id in ('.  implode(',',$location_id).')')->getField('id,warehouse_id');
            foreach ($var as $value) {
                //按实际库位存入不可再销售仓库
                $value['warehouse_id']    = empty($location[$value['location_id']])?0:$location[$value['location_id']];
                $value = $this->dataTransform($value);
				$this->execStorageLog($value);
				$this->execSaleStorage($value);
				$this->execRealStorage($value);
			}
		}
		return true;
	}
	
	/**
	 * 调整更新库存
	 * 
	 * @return  bool
	 */
	private function adjust(){
		$ary_field = $this->storage_attr;
		$ary_field[] = 'location_id';
		$str_field = implode(',',$ary_field);
		$sql = 'select quantity,id as detail_id,'.$str_field.' from adjust_detail where adjust_id='.$this->params['id'].'  
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=4 and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
			$this->execRealStorage($value);
		}
		return true;
	}

	/**
	 * 入库导入调整更新库存
	 *
	 * @return  bool
	 */
	private function instockImportAdjust(){
		$ary_field = $this->storage_attr;
		$ary_field[] = 'location_id';
		$str_field = implode(',',$ary_field);
		$sql = 'select quantity,id as detail_id,'.$str_field.' from instock_adjust_detail where adjust_id='.$this->params['id'].'
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type='.$this->relation_type['instockImportAdjust'].' and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execInstockQuantity($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
			$this->execRealStorage($value);
		}
		return true;
	}
	
	/**
	 * 入库导入调整更新发货单入库数量
	 */
	private function execInstockQuantity($value){
		$sql = 'select instock_detail_id  from instock_adjust_detail where id='.$value['detail_id'].'
				union all 
				select instock_detail_id  from instock_adjust_detail_del where id='.$value['detail_id'];		
		$instockDetailInfo = $this->db->query($sql);
		
		$map['id'] = $instockDetailInfo[0]['instock_detail_id'];
		if($value['quantity'] < 0){
			$map['in_quantity'] = array('egt',abs($value['quantity']));
		}
		if(!M('instock_detail')->where($map)->setInc('in_quantity',$value['quantity'])){
			throw_json(L('oper_error'));
		}
	}
	
	
	private function domesticWaybill(){
		$ary_field = $this->storage_attr;
		$ary_field[] = 'location_id';
		$str_field = implode(',',$ary_field);
		$sql = 'select quantity*-1 as quantity,id as detail_id,'.$str_field.' from domestic_waybill_detail where waybill_id='.$this->params['id'].'  
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type='.$this->relation_type['domesticWaybill'].' and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
			$this->execRealStorage($value);
		}
		return true;
	}
    
    /**
	 * 移仓更新库存
	 * 
	 * @return  bool
	 */
	private function shiftWarehouse(){
		$str_detail_field  = 'product_id,out_warehouse_id,out_location_id,in_warehouse_id,in_location_id';
        $ary_field = $this->storage_attr;
		$ary_field[] = 'location_id';
		$str_field = implode(',',$ary_field);
        $var_detail     = M('shift_warehouse_detail')->field('quantity,id as detail_id,'.$str_detail_field)->where('shift_warehouse_id='.$this->params['id'])->select();
        $var_detail     = $this->setShiftWarehouseDetail($var_detail);
        $var_log        = M('storage_log')->where('relation_type='.$this->relation_type['shiftWarehouse'].' and main_id='.$this->params['id'])->group('product_id,location_id,detail_id')->getField('concat(product_id,"_",location_id,"_",detail_id),-1*sum(quantity) as quantity,detail_id,'.$str_field);
        foreach($var_detail as $val){
			$key	= $val['product_id'].'_'.$val['location_id'].'_'.$val['detail_id'];
            $val['quantity']   += $var_log[$key]['quantity'];
            unset($var_log[$key]);
            if($val['quantity'] != 0){
                $var[]  = $val;
            }
        }
        $var    = array_merge((array)$var,(array)$var_log);
		foreach ($var as $k => $v) {
			$sort_array[$k]	= $v['quantity'];
		}
		array_multisort($sort_array,SORT_DESC, $var);
        foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
			$this->execRealStorage($value);
		}
		return true;
	}
    
    public function setShiftWarehouseDetail($info){
        foreach ($info as $value){
			$out_key			= $value['product_id'].'_'.$value['out_location_id'].'_'.$value['detail_id'];
            $detail[$out_key]   = array(//出库数量为负
                'detail_id'     => $value['detail_id'],
                'location_id'   => $value['out_location_id'],
                'warehouse_id'  => $value['out_warehouse_id'],
                'product_id'    => $value['product_id'],
                'quantity'      => -1*$value['quantity']+$detail[$out_key]['quantity']
            );
			$in_key				= $value['product_id'].'_'.$value['in_location_id'].'_'.$value['detail_id'];
            $detail[$in_key]	= array(
                'detail_id'     => $value['detail_id'],
                'location_id'   => $value['in_location_id'],
                'warehouse_id'  => $value['in_warehouse_id'],
                'product_id'    => $value['product_id'],
                'quantity'      => $value['quantity']+$detail[$in_key]['quantity']
            );
        }
        return $detail;
    }

 
     /**
	 * 盈亏更新库存
	 * 
	 * @return  bool
	 */
	private function profitandloss(){
		// 盈亏只在过帐才更新且不可执行其它操作
		if (ACTION_NAME!='update') {return true;}
		$ary_field = $this->storage_attr;
		$str_field = implode(',',$ary_field);
		$sql = 'select (stocktake_quantity-storage_quantity) as quantity,a.id as detail_id,'.$str_field.' from profitandloss_detail a left join profitandloss b on(a.profitandloss_id=b.id) where a.profitandloss_id='.$this->params['id'].'  
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=9 and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
			$this->execRealStorage($value);
		}
		return true;
	}
	
	/**
	 * 调拨更新库存
	 * 
	 * @return  bool
	 */
	private function transfer(){
		$ary_field = $this->storage_attr;
		$str_field = implode(',',$ary_field);
		$sql = 'select quantity*-1 as quantity,id as detail_id,'.$str_field.' from transfer_detail where transfer_id='.$this->params['id'].'  
				union all 
				select quantity,id as detail_id,in_warehouse_id as '.$str_field.' from transfer_detail where transfer_id='.$this->params['id'].' 
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=6 and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
			$this->execRealStorage($value);
		}
		return true;
	}
	
	/**
	 * 期初更新库存
	 * 
	 * @return  bool
	 */
	private function initStorage(){
		$ary_field = $this->storage_attr;
		$str_field = implode(',',$ary_field);
		$sql = 'select quantity,b.id as detail_id,'.$str_field.' from init_storage_detail a left join init_storage b on(a.init_storage_id=b.id) where init_storage_id='.$this->params['id'].'  
				union all 
				select quantity*-1 as quantity,detail_id,'.$str_field.' from storage_log where relation_type=8 and main_id='.$this->params['id'];
		$sql = 'select sum(quantity) as quantity,detail_id,'.$str_field.' from ('.$sql.') as tmp group by detail_id,'.$str_field.' having sum(quantity)!=0 order by quantity desc';
		$var = $this->db->query($sql);
		foreach ((array)$var as $value) {
			$value = $this->dataTransform($value);
			$this->execStorageLog($value);
			$this->execSaleStorage($value);
			$this->execRealStorage($value);
			
		}
		return true;
	}
	
	/**
	 * 添加库存日志
	 *
	 * @param  array $value
	 * @param  bool $flag true 直接入库  false 补充日志信息
	 * @return gbool
	 */
	protected function execStorageLog($value,$flag=false){
		if ($flag===false) {
			$value['main_id'] 		= $this->params['id'];
			$value['relation_type'] = $this->relation_type[$this->module_name];
		}
        $value['insert_time']       = date('Y-m-d H:i:s',time());
		if(!M('StorageLog')->add($value)){
			rollback();
			throw_json($this->getTipsTable($value, 'Log') . '库存更新失败，库存日志异常，请立即联系客服人员！');
		}
	}

	/**
	 * 根据系统的库存规格把流程的进行转换
	 *
	 * @param  array $value
	 * @return  bool
	 */
	protected function dataTransform($value){
		///判断系统的库存跟流程的库存规格是否一致，如果不一致则需要转换
		if(count(array_diff($this->storage_attr,$this->sys_storage_attr))>0){
			if(C('storage_format')==1){
				if($this->storage_attr['capability']){
					$value['quantity']		= $value['quantity'] * $value['capability'];
					$value['capability']	= 1;
				}
				if($this->storage_attr['dozen']){
					$value['quantity']		= $value['quantity'] * $value['dozen'];
					$value['dozen']			= 1;
				}
			}
		}
		return $value;
	}
	
	/**
	 * 更新可销售库存
	 *
	 * @param  array $value
	 * @return  bool
	 */
	protected function execSaleStorage($value){
		$rs = '';
		$sale_storage = M('SaleStorage');
		unset($value['detail_id']);
		$where = $this->getSpecWhere($value,2);
		$count = $sale_storage->where($where)->count();
		if ($count==0) {
			$sale_storage->add($value);
		}elseif ($count==1){
			$rs		= $sale_storage->where($where)->find();
			if ($value['quantity'] < 0 && $rs['quantity'] + $value['quantity'] < 0) {
				rollback();
				throw_json($this->getTipsTable($value, 'Sale') . '库存不足，不能操作！');
			}
			$setFun	= $value['quantity'] < 0 ? 'setDec' : 'setInc';
			$sale_storage->where($where)->$setFun('quantity', abs($value['quantity']));
            if ($value['quantity'] < 0 && !isset( $this->warn_product[$rs['product_id']])) {//       
                if(!isset($this->count[$rs['product_id']])){
                    $this->count[$rs['product_id']] = M('email_list')->where('object_id=' . $value['product_id'].' and email_type='.C('STORAGE_REMIND_EMAIL_TYPE') . ' and warehouse_id=' . $value['warehouse_id'] . ' and date(insert_time)=\'' . date('Y-m-d', time()) . '\'')->count();
                }
                if ($this->count[$rs['product_id']]==0) {
                    if(!isset($this->storage_warn[$rs['product_id']])){
                        $this->storage_warn[$rs['product_id']]  = M('product')->where('id=' . $rs['product_id'])->field('warning_quantity,factory_id')->find();
                    }
                    if ($rs['quantity'] <= $this->storage_warn[$rs['product_id']]['warning_quantity']) {
                        $this->warn_product[]  = array(
                            'email_type'    => C('STORAGE_REMIND_EMAIL_TYPE'),
                            'warehouse_id'  => $value['warehouse_id'],
                            'insert_time'   => date('Y-m-d H:i:s', time()),
                            'comp_id'       => $this->storage_warn[$rs['product_id']]['factory_id'],
                            'object_id'     => $value['product_id']
                        );
                    }
                }
            }
		}elseif($count>1){
			rollback();
			throw_json($this->getTipsTable($value, 'Sale') . '库存更新失败，同规格存在多条记录，请立即联系客服人员！');
		}
	}
	
	/**
	 * 更新实际库存
	 *
	 * @param  array $value
	 * @return  bool
	 */
	protected function execRealStorage($value){
		unset($value['detail_id']);
		$where = $this->getSpecWhere($value,1);
		$count = $this->where($where)->count();
		if ($count==0) {
			$this->add($value);
		}elseif ($count==1){
			if ($value['quantity'] < 0) {
				$rs		= $this->where($where)->find();
				if ($value['quantity'] + $rs['quantity'] < 0) {
					rollback();
					throw_json($this->getTipsTable($value) . '库存不足，不能操作！');
				}
				$setFun	= 'setDec';
			} else {
				$setFun	= 'setInc';
			}
			$this->where($where)->$setFun('quantity', abs($value['quantity']));
		}elseif($count>1){
			rollback();
			throw_json($this->getTipsTable($value) . '库存更新失败，同规格存在多条记录，请立即联系客服人员！');
		}
	}

	/**
	 * 更新实际库存中的picking_quantity
	 *
	 * @param  array $value
	 * @return  bool
	 */
	protected function execPickingQuantity($value){
		unset($value['detail_id']);
		$where			= $this->getSpecWhere($value,1);
		$rs				= $this->where($where)->find();
		if(empty($rs)){
			rollback();
			throw_json($this->getTipsTable($value, 'Pick') . '拣货导出数量更新失败，库存记录不存在，请立即联系客服人员！');
		} elseif ($value['quantity'] > 0 && $rs['quantity'] < $rs['picking_quantity'] + $value['quantity']) {
			rollback();
			throw_json($this->getTipsTable($value, 'Pick') . '库存不足，拣货导出数量更新失败，请立即联系客服人员！');
		}
		$setFun	= $value['quantity'] < 0 ? 'setDec' : 'setInc';
		$this->where($where)->$setFun('picking_quantity', abs($value['quantity']));
	}		
	
	/**
	 * 更新拣货导入的未分配数量
	 *
	 * @param  array $value
	 * @return  bool
	 */
	protected function execUndealQuantity($value){
		$where	= array('id' => $value['detail_id']);
		$setFun	= $value['quantity'] < 0 ? 'setInc' : 'setDec';
		M('fileDetail')->where($where)->$setFun('undeal_quantity', abs($value['quantity']));
	}
    
    /**
     * 删除导入单恢复未分配数量
     * 
     * @param array $value
     * @return bool
     */
    protected function replyUndealQuantity($id){
		if ($this->_action == 'delete') {
			$storageLog		= M('storage_log');
			$where          = array(
							'main_id'       => $id,
							'relation_type' => C('STORAGE_LOG_UNDEAL_QUANTITY_TYPE'),
							);
			//重新上架数量
			$rs             = $storageLog->where($where)->field('main_id, detail_id, relation_type, warehouse_id, location_id, -1*quantity as quantity,product_id')->select();
			if(!empty($rs)){
				foreach($rs as $val){
					$this->execStorageLog($val, true);//更新库存日志
					$this->execRealStorage($val);
				}
			}
		}
    }

	private function getTipsTable($data, $type = 'Real'){
		static $barcode_no_list	= array();
		$w_name		= SOnly('warehouse', $data['warehouse_id'], 'w_name');
		$label		= '[' . $type . ']' . L('warehouse') . '[' . $w_name . ']>';
		if ($type != 'Sale') {
			if (!isset($barcode_no_list[$data['location_id']])) {
				$barcode_no_list[$data['location_id']]		= M('Location')->where(array('id' => $data['location_id']))->getField('barcode_no');
			}
			$barcode_no	= $barcode_no_list[$data['location_id']];
			$label		.= L('warehouse_location') . '[' . $barcode_no . ']>';
		}
		$product_no	= SOnly('product', $data['product_id'], 'product_no');
		$label		.= L('product_id') .'[' . $data['product_id'] . ']' . L('product_no') .'[' . $product_no . ']: ';
		return $label;
	}
}