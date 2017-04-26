<?php
/**
 +------------------------------------------------------------------------------
 * 库存检查
 +------------------------------------------------------------------------------
 * @copyright   2011 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 +------------------------------------------------------------------------------
 */
class CheckStoragePublicModel extends Model {
	protected $tableName = 'storage';
	protected $tables	 = array();
	protected $params 		= array();
	protected $checkData		= array();
	protected $storage_attr 	= array();
	protected $module_name = '';
	protected $reduce = false;
	protected $error	= array();


	/**
	 * 库存检查公共接口
	 *
	 * @param  参数 $params
	 * @param  方法名称，默认取模块名称，首字母转小写
	 */
	public function run($params,$module_name=null){
		$this->_module	= getTrueModule();
		$this->_action	= getTrueAction();
        if($this->_module  == 'ReturnSaleOrder'){
            $params['id']   = M('ReturnSaleOrderStorage')->where('return_sale_order_id='.$params['id'])->getField('id');
            if($params['id'] <= 0){
                return;
            }
            $this->_module  = 'ReturnSaleOrderStorage';
        }
		if($params['_module']=='SaleOrder'){
			$this->_module	   = $params['_module'];
			$this->_action	   = $params['_action'];
		}
		$this->module_name = ucwords_first($this->_module);
		$this->params = $params;

		// 销售关联配货，退货新增，拣货导入重新上架时验证可销售库存，其它验证实际库存
		if (($this->_module=='SaleOrder') || ($this->_module=='ReturnSaleOrderStorage' && $this->_action=='delete') || ($this->_module=='PickingImport' && $this->_action=='backShelves')){
			$this->tableName = 'saleStorage';
			$this->reduce = true;
		}
		// 合并修改后的数据（页面传递）的同规格数据（以库存规格为标准合并）
		// 设置数据中的下标名称
		$detail_key = ($this->_module=='ReturnSaleOrderStorage' && $this->_action=='delete') ? 'sale' : 'detail';
		//定义库存调整验证表
		$this->tables  = in_array($this->module_name, array('shiftWarehouse','adjust','instockImport','instockImportAdjust','instockStorage','returnSaleOrderStorage','outBatch')) ? array('storage','saleStorage') : (array)$this->tableName;
		foreach ($this->tables as $table) {
			$this->tableName	= $table;
			$this->setSpec();
			$post_data = $this->postMerge($detail_key);
	//		 检查是否指定出库
	//		$this->checkFiFo(intval($this->params['id']),$post_data);
			// 获取修改前的数据（取DB数据）
			///自动抓取的首次修改不需要取原来的值。原因是因为在第一次保存的时候并没有扣减可销售库存

			if(!($this->params['transaction_id'] != '' && $this->params['lock_version'] == 1)){
				$db_data = $this->dbMerge();
			}
			// 计算本次操作最终修改量
			$this->setCheckData($post_data,$db_data);
			// 验证库存数量是否足够
			$this->execCheckStorage();
		}
		if (!empty($this->error)) {
			$errorProductNo	= M('Product')->where(array('id' => array('in', array_keys($this->error))))->getField('id, product_no');
			foreach ($this->error as $product_id => &$error) {
				$error	= implodeExtend($error, '<br />', L('product_no').'“'.$errorProductNo[$product_id].'”');;
			}
			unset($errorProductNo);
			throw_json($this->error);
		}
	}

	/**
	 * 根据配置信息获取库存更新属性
	 *
	 */
	protected function setSpec(){
		$this->storage_attr = array('warehouse_id'=>'warehouse_id','location_id'=>'location_id','product_id'=>'product_id');
		if ($this->tableName == 'saleStorage') {
			unset($this->storage_attr['location_id']);
		}
		if ($this->_module == 'InstockImportAdjust') {
			$this->storage_attr['instock_detail_id'] = 'instock_detail_id';	//发货单详情ID
		}
	}

	/**
	 * 根据规格生成查询条件
	 * @param  array
	 * @param  int  1实际库存 2可销售库存
	 */
	protected function getSpecWhere($value,$type){
		$where = array();
		foreach ($this->storage_attr as $spec_field) {
			if($type==2 && $spec_field=='location_id'){continue;}
			$where[] = $spec_field.'='.$value[$spec_field];
		}
		return implode(' and ',$where);
	}

	/**
	 * 根据规格生成查询条件
	 * @param  array
	 * @param  int  1实际库存 2可销售库存
	 */
	protected function getListSpecWhere($list,$type){
		$storage_attr	= $this->storage_attr;
		if($type==2){
			unset($storage_attr['location_id']);
		}
		$where	= $data	= array();
		foreach ($list as $value) {
			foreach ($storage_attr as $spec_field) {
				$data[$spec_field][$value[$spec_field]] = $value[$spec_field];
			}
		}
		foreach ($storage_attr as $spec_field) {
			$where[$spec_field] = array('in', $data[$spec_field]);
		}
		return $where;
	}

	/**
	 * 根据规格生成查询条件
	 * @param  array
	 * @param  int  1实际库存 2可销售库存
	 */
	protected function getSpecKey($value,$type){
		$storage_attr	= $this->storage_attr;
		if($type==2){
			unset($storage_attr['location_id']);
		}
		if ($this->_module == 'InstockImportAdjust') {
			unset($storage_attr['instock_detail_id']);	//发货单详情ID
		}
		$fields = array();
		foreach ($storage_attr as $spec_field) {
			$fields[] = $value[$spec_field];
		}
		return implode('_',$fields);
	}

	/**
	 * 合并数据中库存规格完全一致的数据
	 * @param  明细数据下标
	 * @return array
	 */
	protected function postMerge($params_key='detail'){
        if($this->_module == 'OutBatch'){
            foreach($this->params[$params_key] as $value){
                if($value['pack_box_id'] > 0){
                    $pack_box_id[$value['pack_box_id']] = $value['pack_box_id'];
                }
            }
            if(!empty($pack_box_id)){
                $return_id  = M('pack_box_detail')->where('pack_box_id in ('.implode(',', $pack_box_id).')')->getField('return_sale_order_id',true);
            }
            if(!empty($return_id)){
                $this->params[$params_key] = M('return_sale_order_storage_detail')->where('return_sale_order_id in ('.implode(',', $return_id).')')->select();
            }
        }
		if(empty($this->params[$params_key]) || ($this->_module=='SaleOrder' && $this->params['sale_order_state'] == C('SALEORDER_OBSOLETE'))){return false;}
		$new_params = array();
		// 定义流程数据为扣减库存的模块
		$reduce = array('SaleOrder','Delivery','Transfer','PickingImport','DomesticWaybill','OutBatch');
		foreach ($this->params[$params_key] as $value){
			if(empty($value['product_id']) || ($this->_module=='Transfer' && $value['id']>0) || ($this->_module=='ReturnSaleOrderSaleOrder' && isset($value['is_use']) && $value['is_use']!=1)) continue;
			if ($this->_module=='PickingImport' && !in_array($value['state'], array(C('CFG_IMPORT_SUCCESS_STATE'), C('CFG_IMPORT_PROCESSED_STATE')))) {
				continue;
			}
            if($this->_module=='InstockStorage' && empty($value['in_quantity'])){continue;}
			($this->reduce===true || in_array($this->_module,$reduce)) && $value['quantity'] *=-1;
            if($this->_module  == 'InstockStorage'){
                    $value['quantity'] = $value['in_quantity'];
            }
            //退货入库单，入库数量-丢弃数量=实际入库数量        add by lxt 2015.09.02
            if ($this->_module=='ReturnSaleOrderStorage' && $this->_action!='delete'){
                $value['quantity']  =   $value['quantity']-$value['drop_quantity'];
            }
			$key = $this->getAttrKey($value);
			if (isset($new_params[$key])) {
				$new_params[$key]['quantity'] += $value['quantity'];
			}else {
				$new_params[$key] = $value;
			}
		}
		return $new_params;
	}

	/**
	 * 合并数据库中的库存规格完全一致的数据
	 * @return array
	 */
	protected function dbMerge(){
		$method_name =  $this->module_name.ucwords($this->_action);
		if (method_exists($this,$method_name)) {
			$id = intval($this->params['id']);
			if ($id<=0) { return false;}
			$db_data	= $this->$method_name($id);
			$new_params = array();
			foreach ($db_data as $value){
				if(empty($value['product_id'])) continue;
				if ($this->_module=='PickingImport' && !in_array($value['state'], array(C('CFG_IMPORT_SUCCESS_STATE'), C('CFG_IMPORT_PROCESSED_STATE')))) {
					continue;
				}
				$key = $this->getAttrKey($value);
				if (isset($new_params[$key])) {
					$new_params[$key]['quantity'] += $value['quantity'];
				}else {
					$new_params[$key] = $value;
				}
			}
			return $new_params;
		}else {
			throw_json('库存检查方法不存在，无法进行库存验证！');
		}
	}

	function getAttrKey(&$value){
		$key = array();
		foreach ($this->storage_attr as $field){
			if(!isset($value[$field]) && !isset($this->params[$field])){throw_json($this->module_name.' '.$field.'不存在库存规格数据，无法进行库存验证！');}
			$key[] = $value[$field] ? $value[$field] : $value[$field] = $this->params[$field];
		}
		return implode('_', $key);
	}

	/**
	 * 设置最终库存需要检查的数据
	 *
	 * @param uarray$post_data 页面传递的数据
	 * @param uarray $db_data 数据库中数据
	 */
	protected function setCheckData($post_data,$db_data){
		$has_change		= false;
		$cant_change	= false;
		switch ($this->_module) {
			case 'SaleOrder':
				if (getUser('role_type') == C('SELLER_ROLE_TYPE') && !in_array($this->params['sale_order_state'], explode(',',C('SALE_CAN_ADD_STATE')))) {
					$cant_change	= true;
				}
			break;
		}
		if (empty($post_data)) {
			$this->checkData = $db_data;
		}elseif (empty($db_data)){
			$this->checkData = $post_data;
		}else {
			foreach ($db_data as $key => &$value){
				$value['quantity'] += $post_data[$key]['quantity'];
				unset($post_data[$key]);
				if ($value['quantity']>=0) {
					$value['quantity']>0 && $has_change	= true;
					unset($db_data[$key]);
				}
			}
			if (empty($post_data) && empty($db_data)) {
				$new_data = array();
			}else {
				$has_change	= true;
				if (empty($post_data)){
					$new_data = $db_data;
				}elseif (empty($db_data)){
					$new_data = $post_data;
				}else {
					$new_data = array_merge($db_data,$post_data);
				}
			}
			$this->checkData = $new_data;
		}
		if ($cant_change && $has_change) {
			throw_json(L('detail_info') . ': ' . L('cant_change'));
		}
	}

	/**
	 * 执行库存检查
	 *
	 * @return ubool
	 */
	protected function execCheckStorage(){
		if (empty($this->checkData)) {
			return true;
		}
		$table_count	= count($this->tables);
		$table			= $this->tableName;
		//判断验证的是可销售库存还是实际库存
		$where_type		= $table=='saleStorage' ? 2 : 1;
		$where			= $this->getListSpecWhere($this->checkData,$where_type);
		$storage_attr	= $this->storage_attr;
		if($where_type==2){
			unset($storage_attr['location_id']);
        }
		$storage		= resetArrayIndex(M($table)->where($where)->select(), $storage_attr);
//        if($where_type==2 && $this->_action!='backShelves'){
//            $undeal_where['a.warehouse_id'] = $where['warehouse_id'];
//            $undeal_where['a.file_type']    = array_search('PickingImport', C('CFG_FILE_TYPE'));
//            $undeal_where['b.product_id']   = $where['product_id'];
//            $undeal_quantity    = M('file_list')->join(' as a left join file_detail as b on a.id=b.file_id')->where($undeal_where)->group('b.product_id')->getField('product_id,sum(b.undeal_quantity) as undeal_quantity');
//            if(!empty($undeal_quantity)){
//                foreach($storage as &$val){
//                    $val['quantity']    -= $undeal_quantity[$val['product_id']];
//                }
//            }
//		}
		foreach ($this->checkData as $value) {
			$add_error			= '';
			$specKey			= $this->getSpecKey($value, $where_type);
			$storage_quantity	= $storage[$specKey]['quantity'];
			$picking_quantity	= $storage[$specKey]['picking_quantity'];
			if ($storage_quantity+$value['quantity']<0) {
				if($table_count > 1){
					$add_error .= $where_type==1?L('real_storage_no_enough'):L('sale_storage_no_enough');
				}else{
					$add_error .= L('storage_no_enough');
				}
			} elseif (in_array($this->_module, array('InstockImport','InstockImportAdjust','Adjust','ShiftWarehouse')) && $where_type==1 && $storage_quantity-$picking_quantity+$value['quantity']<0) {
                if(in_array(ACTION_NAME, array('update','insert'))){
                    $add_error	.= L('error_product_in_picking_cant_update');
                }else{
                    $add_error	.= L('error_product_in_picking_cant_del');
                }
			} elseif(in_array($this->_module, array('InstockImportAdjust')) && ($value['quantity'] < 0)){	//验证发货单入库数量
				$map['id'] = $value['instock_detail_id'];
				$map['in_quantity'] = array('egt',abs($value['quantity']));
				if(!M('instock_detail')->where($map)->count('id')){
					throw_json(L('old_in_quantity').L('not_less_than_zero'));
				}
			}
			if (!empty($add_error)) {
				if (!isset($this->error[$value['product_id']]) || $this->tableName == 'saleStorage') {
					$this->error[$value['product_id']][] = $add_error;
				}
				continue;
			}
		}
		unset($storage);
	}

	/**
	 * 入库导入库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function instockImportDelete($id){
		$info = M('FileDetail')->field('sum(a.quantity*-1) as quantity,'.implode(',',$this->storage_attr))->join('a left join file_list b on a.file_id=b.id')->where('file_id=' . $id . ' and a.state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ',' . C('CFG_IMPORT_PROCESSED_STATE') . ')')->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	/**
	 * 拣货导入库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function pickingImportInsert($id){
		return false;
	}

	protected function pickingImportbackShelves($id){
		$info = M('FileDetail')->field('sum(a.undeal_quantity*-1) as quantity,'.implode(',',$this->storage_attr))->join('a left join file_list b on a.file_id=b.id')->where('file_id=' . $id . ' and a.state in (' . C('CFG_IMPORT_SUCCESS_STATE') . ',' . C('CFG_IMPORT_PROCESSED_STATE') . ')')->group(implode(',',$this->storage_attr))->having('quantity<>0')->select();
		return $info;
	}

	/**
	 * 调整库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function adjustInsert($id){
		return false;
	}

	protected function adjustUpdate($id){
		$info = M('AdjustDetail')->field('sum(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('adjust_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	protected function adjustDeleteDetail($id){
		$info = M('AdjustDetail')->field('quantity*-1 as quantity,'.implode(',',$this->storage_attr))->where('id='.$id)->select();
		return $info;
	}

	protected function adjustDelete($id){
		$info = M('AdjustDetail')->field('sum(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('adjust_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}
	/**
	 * 入库导入调整验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function instockImportAdjustInsert($id){
		return false;
	}

	protected function instockImportAdjustUpdate($id){
		$info = M('InstockAdjustDetail')->field('sum(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('adjust_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	protected function instockImportAdjustDeleteDetail($id){
		$info = M('InstockAdjustDetail')->field('quantity*-1 as quantity,'.implode(',',$this->storage_attr))->where('id='.$id)->select();
		return $info;
	}

	protected function instockImportAdjustDelete($id){
		$info = M('InstockAdjustDetail')->field('sum(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('adjust_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

    /**
	 * 装箱库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function outBatchInsert($id){
		return false;
	}

	protected function outBatchUpdate($id){
		$info = M('OutBatchDetail')
                ->join(' obd left join pack_box_detail as pbd on obd.pack_box_id=pbd.pack_box_id
                         left join return_sale_order_storage_detail rsd on pbd.return_sale_order_id=rsd.return_sale_order_id')
                ->field('sum(quantity) as quantity,'.implode(',',$this->storage_attr))->where('obd.out_batch_id='.$id)
                ->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

    /**
     * 国内运单库存验证
     * @param  int $id 主表ID
     * @return array
     */
	protected function domesticWaybillInsert($id){
		return false;
	}

	protected function domesticWaybillUpdate($id){
		$info = M('DomesticWaybillDetail')->field('sum(quantity) as quantity,'.implode(',',$this->storage_attr))->where('waybill_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	protected function domesticWaybillDeleteDetail($id){
		$info = M('DomesticWaybillDetail')->field('quantity as quantity,'.implode(',',$this->storage_attr))->where('id='.$id)->select();
		return $info;
	}

	protected function domesticWaybillDelete($id){
		$info = M('DomesticWaybillDetail')->field('sum(quantity) as quantity,'.implode(',',$this->storage_attr))->where('waybill_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	/**
	 * 发货入库验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function instockStorageInsert($id){
		return false;
	}

	protected function instockStorageUpdate($id){
		$info = M('InstockStorageDetail')->field('sum(in_quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('instock_storage_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	protected function instockStorageDeleteDetail($id){
		$info = M('InstockStorageDetail')->field('in_quantity*-1 as quantity,'.implode(',',$this->storage_attr))->where('id='.$id)->select();
		return $info;
	}

	protected function instockStorageDelete($id){
		$info = M('InstockStorageDetail')->field('sum(in_quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('instock_storage_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	/**
	 * 销售库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function saleOrderInsert($id){
		return false;
	}

	protected function saleOrderUpdate($id){
		$info = M('SaleOrderDetail')->join('sale_order on(sale_order_detail.sale_order_id=sale_order.id)')->field('sum(quantity) as quantity,' . implodeExtend($this->storage_attr, ',', 'sale_order_detail.'))->where('sale_order_id='.$id.' and sale_order_state!='.C('SALEORDER_OBSOLETE'))->group(implodeExtend($this->storage_attr, ',', 'sale_order_detail.'))->select();
		return $info;
	}

	protected function saleOrderDeleteDetail($id){
		$info = M('SaleOrderDetail')->field('quantity,'.implode(',',$this->storage_attr))->where('id='.$id)->select();
		return $info;
	}

	/**
	 * 退货中的换货库存检查
	 */
	protected function returnSaleOrderStoregeInsert($id){
		return false;
	}

	protected function returnSaleOrderStorageUpdate($id){
		$info = M('ReturnSaleOrderStorageDetail')->field('sum(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('return_sale_order_storage_id='.$id.'')->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	protected function returnSaleOrderStorageDelete($id){
		$info = M('ReturnSaleOrderStorageDetail')->field('sum(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('return_sale_order_storage_id='.$id.'')->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	protected function returnSaleOrderStorageDetailDelete($id){
		$info = M('ReturnSaleOrderStorageDetail')->field('(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('id='.$id)->select();
        return $info;
	}
	//处理               add by lxt 2015.09.07
	protected function returnSaleOrderStorageUpdateDeal($id){
	    //合并上丢弃数量做库存验证        add drop_quantity by lxt 2015.09.02
	    $info = M('ReturnSaleOrderStorageDetail')->field('sum(drop_quantity+quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('return_sale_order_storage_id='.$id.'')->group(implode(',',$this->storage_attr))->select();
	    return $info;
	}


	/**
	 * 发货库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function deliveryInsert($id){
		return false;
	}

	protected function deliveryUpdate($id){
		$info = M('DeliveryDetail')->field('sum(quantity) as quantity,'.implode(',',$this->storage_attr))->where('delivery_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	/**
	 * 期初库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function initStorageInsert($id){
		return false;
	}

	protected function initStorageUpdate($id){
		$info = M('InitStorageDetail')->join('init_storage on(init_storage_detail.init_storage_id=init_storage.id)')->field('sum(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('init_storage_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	protected function initStorageDelete($id){
		$info = M('InitStorageDetail')->join('init_storage on(init_storage_detail.init_storage_id=init_storage.id)')->field('sum(quantity*-1) as quantity,'.implode(',',$this->storage_attr))->where('init_storage_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}

	protected function initStorageDeleteDetail($id){
		$info = M('InitStorageDetail')->join('init_storage on(init_storage_detail.init_storage_id=init_storage.id)')->field('quantity*-1 as quantity,'.implode(',',$this->storage_attr))->where('init_storage_detail.id='.$id)->select();
		return $info;
	}

	/**
	 * 调拨库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function transferInsert($id){
		return false;
	}

	protected function transferUpdate($id){
		return false;
	}
	protected function transferDelete($id){
		$info = M('TransferDetail')->field('sum(quantity*-1) as quantity,in_warehouse_id as '.implode(',',$this->storage_attr))->where('transfer_id='.$id)->group(implode(',',$this->storage_attr))->select();
		return $info;
	}
	protected function transferDeleteDetail($id){
		$info = M('TransferDetail')->field('quantity*-1 as quantity,in_warehouse_id as '.implode(',',$this->storage_attr))->where('id='.$id)->select();
		return $info;
	}

    /**
	 * 移仓库存验证开始
	 *
	 * @param  int $id 主表ID
	 * @return  array
	 */
	protected function shiftWarehouseInsert($id){
		return false;
	}

	protected function shiftWarehouseUpdate($id){
        $field  = $this->setShiftWarehouseField();
		$info   = M('ShiftWarehouseDetail')->field('-1*sum(quantity) as quantity,out_warehouse_id,in_warehouse_id,product_id'.$field)->where('shift_warehouse_id='.$id)->group('out_warehouse_id,in_warehouse_id,product_id'.$field)->select();
        $info   = $this->setShiftWarehouseInfo($info);
        return $info;
	}

	protected function shiftWarehouseDeleteDetail($id){
        $field  = $this->setShiftWarehouseField();
		$info = M('ShiftWarehouseDetail')->field('quantity*-1 as quantity,out_warehouse_id,in_warehouse_id,product_id'.$field)->where('id='.$id)->select();
        $info   = $this->setShiftWarehouseInfo($info);
        return $info;
	}

	protected function shiftWarehouseDelete($id){
        $field  = $this->setShiftWarehouseField();
		$info   = M('ShiftWarehouseDetail')->field('-1*sum(quantity) as quantity,out_warehouse_id,in_warehouse_id,product_id'.$field)->where('shift_warehouse_id='.$id)->group('out_warehouse_id,in_warehouse_id,product_id'.$field)->select();
        $info   = $this->setShiftWarehouseInfo($info);
        return $info;
	}

    protected function setShiftWarehouseField(){
        if(array_search('location_id',$this->storage_attr)){
            $field  = ',out_location_id,in_location_id';
        }
        return $field;
    }

    public function setShiftWarehouseInfo($info){
        foreach($info as &$value){
            if($value['quantity']!=0){
                $detail[$value['out_location_id'].'_'.$value['product_id']]   = array(//出库数量为负
                    'id'            => $value['id'],
                    'location_id'   => $value['out_location_id'],
                    'warehouse_id'  => $value['out_warehouse_id'],
                    'product_id'    => $value['product_id'],
                    'quantity'      => -1*$value['quantity']+$detail[$value['out_location_id'].'_'.$value['product_id']]['quantity']
                );
                $detail[$value['in_location_id'].'_'.$value['product_id']]   = array(
                    'id'            => $value['id'],
                    'location_id'   => $value['in_location_id'],
                    'warehouse_id'  => $value['in_warehouse_id'],
                    'product_id'    => $value['product_id'],
                    'quantity'      => $value['quantity']+$detail[$value['in_location_id'].'_'.$value['product_id']]['quantity']
                );
            }
        }
        foreach($detail as $key=>$val){
            if($val['quantity']==0){
                unset($detail[$key]);
            }
        }
        return $detail;
    }

    /**
	 * 添加库存的模块需要执行先进先出验证
	 *
	 * @param  int $id
	 * @param  array $post_data
	 * @return unknown
	 */
	protected function checkFiFo($id,$post_data){
		$fifo_module = array('Instock','Adjust','InitStorage','ReturnSaleOrderStorage','ShiftWarehouse');
		$fifo_action = array('update','delete','deleteDetail');
		$module_id	 = array('Instock'=>'instock_id','Adjust'=>'adjust_id','InitStorage'=>'init_storage_id','ReturnSaleOrderStorage'=>'return_sale_order_id','ShiftWarehouse'=>'shift_warehosue_id');
		if (!in_array($this->_module,$fifo_module) || !in_array($this->_action,$fifo_action)) {
			return true;
		}
		$error = array();
		switch ($this->_action){
			case 'delete':
				$data = M($this->_module.'Detail')->where($module_id[$this->_module].'='.$id)->select();
				foreach ((array)$data as $value) {$this->checkFiFoDetail($value['id'],$error);}
				break;
			case 'deleteDetail':
				$this->checkFiFoDetail($id,$error);
				break;
			case 'update':
				// 新明细记录为增加库存时不验证
				$data = $this->resetFiFoData();
				foreach ((array)$data as $value) {$this->checkFiFoDetail($value['id'],$error,$value);}
				break;
		}
		if (!empty($error)) {
			throw_json($error);
		}
	}

	/**
	 * 合并数据中库存规格完全一致的数据
	 * @param  明细数据下标
	 * @return array
	 */
	protected function resetFiFoData($params_key='detail'){
		if(empty($this->params[$params_key])){return false;}
		$new_params = array();
		foreach ($this->params[$params_key]  as $key=>$value){
			if(empty($value['id'])) continue;
			if (!isset($value['warehouse_id'])) {
				$value['warehouse_id'] = $this->params['warehouse_id'];
			}
			$new_params[$key] = $value;
		}
		return $new_params;
	}

	/**
	 * 检查是否先进先出，已删除先进先出验证，不用该方法。
	 */
	protected function checkFiFoDetail($detail_id,&$error,$value=null){
		$color_str = $size_str = '';
		$relation = $module_realtion[$this->_module];
		$var = M('StockIn')->field('quantity-balance as use_quantity,product_id,color_id,size_id,balance,warehouse_id,capability,dozen,mantissa')->where('relation_type='.$relation.' and detail_id='.$detail_id)->find();
		if (empty($var)) {
			return true;
		}
		C('storage_color') && $color_str = '，'.SOnly('color', $var['color_id'], 'color_name');
		C('storage_size') && $size_str = '，'.SOnly('size', $var['size_id'], 'size_name');
		$product_no	= SOnly('product', $var['product_id'], 'product_no');
		if ($value) {
			// 产品未做任何出库可任意修改
			if($var['use_quantity']==0) { return true;}
			// 修改规格时只要有任何出库记录修改失败
			$flag = true;
			foreach ($this->storage_attr as $field) {
				if ($var[$field]!=$value[$field] && $var['use_quantity']!=0) {
					$error[] = L('product_no').'“'.$product_no.$color_str.$size_str.'”'.L('storage_error_2').'“'.$var['use_quantity'].'”，'.L('oper_error');
					$flag = false;
					break;
				}
			}
			// 只在规格一致且存在指定出库时再验证数量
			if ($flag==true && $var['use_quantity']>$value['quantity']) {
				$error[] = L('product_no').'“'.$product_no.$color_str.$size_str.'”'.L('storage_error_2').'“'.$var['use_quantity'].'”，'.L('oper_error');
			}
		}else {
			if ($var['use_quantity']>0) {
				$error[] = L('product_no').'“'.$product_no.$color_str.$size_str.'”'.L('storage_error_2').'“'.$var['use_quantity'].'”，'.L('oper_error');
			}
		}
	}
    public function getReturnSaleOrderParams($params){
        if(in_array($params['return_sale_order_state'], C('STORAGE_RETURN_SALE_ORDER_STATE'))){
            return D('ReturnSaleOrderStorage')->getPostInfo($params);
        }else{
            $info['id']   = M('return_sale_order_storage')->where('return_sale_order_id='.$params['id'])->getField('id');
            return $info;
        }
    }

}