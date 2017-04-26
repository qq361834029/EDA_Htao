<?php

class ProcessDataPublicAction extends CommonAction {
	public $each_quantity			= 500;//默认每次处理数量
	public $_allowActionList		= array(
										'generateSaleOrderFundsForUnrecorded', 
										'dealPickingImport', 
										'regenerateProductBarcode', 
										'regenerateInstockBarcode',
										'regenerateInstockBoxBarcode',
										'regenerateSaleOrderBarcode',
                                        'instockImport',
                                        'instockStorage',
                                        'returnSaleOrderStorage',
                                        'adjustAdd',
                                        'adjustSub',
                                        'pickingImport',
										'stockOutError',
										'saveApiXml',
                                        'regenerateProcessFee',//批量生成销售单处理费
										'regenerateDomesticShippingFee',//批量重新生成出库国内运费
										'regenerateReturnProcessFee',//批量生成退货单处理费
										'galleryRelation',//批量生成相册关联表 针对一个相册对应多个关联id的情况（例：订单导出）
										'batchExportProductList',
                                        'fixedFiFo',
									);
	//设置每次处理数量
	public $_eachQuantityByAction	= array(
										'regenerateInstockBarcode'			=> 10,
                                        'instockImport'						=> 100,
                                        'instockStorage'					=> 100,
                                        'returnSaleOrderStorage'			=> 100,
                                        'adjustAdd'							=> 100,
                                        'adjustSub'							=> 100,
                                        'pickingImport'						=> 100,
										'stockOutError'						=> 100,
										'saveApiXml'						=> 10000,
                                        'regenerateProcessFee'				=> 100,
										'regenerateDomesticShippingFee'		=> 100,
										'regenerateReturnProcessFee'		=> 100,
                                        'fixedFiFo'                         => 20,
									);	
	public $_whereFieldsByAction	= array(
										'regenerateProductBarcode'	=> array(
																			'id'		=>array('int', 'p'), 
																			'factory_id'=>array('int', 'p'), 
																		),
										'regenerateInstockBarcode' => array(
																			'id'		=>'int', 
																			'factory_id'=>'int',
																			'instock_no',
																		),
										'regenerateInstockBoxBarcode' => array(
																			'id'		=>array('int', 'i'),
																			'factory_id'=>array('int', 'i'),
																			'instock_no'=>array('string', 'i'),
																		),		
										'regenerateSaleOrderBarcode' => array(
																			'id'		=>'int', 
																			'factory_id'=>'int',
																			'sale_order_no',
																		),		
        
                                        'pickingImport'             => array(
                                                                            'warehouse_id'  =>'int',
                                        ),
                                        'regenerateProcessFee'      => array(
                                                                            'warehouse_id'  =>array('int','s'),
                                        ),
                                        'domesticShippingFee'      => array(
                                                                            'warehouse_id'  =>array('int','s'),
                                        ),
                                        'regenerateReturnProcessFee'    => array(
                                                                            'factory_id'  =>array('int','b'),
                                        ),
									);	

	public function _initialize() {
		parent::_initialize();
		C('SHOW_PAGE_TRACE',false);
		set_time_limit(0);
		ini_set('memory_limit', '512M');
	}
	
	public function __call($method, $args) {
		if (in_array($method, $this->_allowActionList)) {
			if ($this->_eachQuantityByAction[$method] > 0) {
				$this->each_quantity	= (int)$this->_eachQuantityByAction[$method];
			}
			$this->processData();
		} else {
			redirect(__APP__);
		}
	}

	/**
	 * 
	 * @param string $name
	 * @param string $key
	 * @return mixed
	 */
	private function S($name, $key, $value = null) {
		$val	= S($name);
		if (is_null($value)) {
			return $val[$key];
		} else {
			$val[$key]	= $value;
			S($name, $val);
		}
	}

	/**
	 * 统一处理函数
	 */
	public function processData(){
		$key			= md5(session_id() . serialize($this->getWhere()));
		$prefix			= MODULE_NAME . '_' . ACTION_NAME . '_';
		$begin_time		= time();
		if (!$this->S($prefix . 'process_begin_mark', $key)) {
			$this->S($prefix . 'process_begin_time', $key, $begin_time);				//处理开始时间
			$this->S($prefix . 'process_end_time', $key, $begin_time);					//上次处理结束时间
			$getData		= ACTION_NAME . 'Data';
			$undeal_list	= $this->$getData($this->getWhere());
			$this->S($prefix . 'process_begin_mark', $key, true);						//处理开始标记
			$this->S($prefix . 'processed_total', $key, 0);								//已处理的数据条数
			$this->S($prefix . 'undeal_list', $key, $undeal_list);						//需要处理的数据列表
			$this->S($prefix . 'process_total', $key, count($undeal_list));				//需要处理的数据总数
			unset($undeal_list);
		}
		$all_undeal_list	= $this->S($prefix . 'undeal_list', $key);
		$to_process_list	= array_splice($all_undeal_list, 0, $this->each_quantity);//最多取出$this->each_quantity条记录进行处理
		$this->S($prefix . 'undeal_list', $key, $all_undeal_list);						//更新需要处理总数
		$unrecorded_total	= count($all_undeal_list);	//未处理总数
		if (!empty($to_process_list)) {
			try {
				$processData		= ACTION_NAME . 'Process';
				$to_process_count	= $this->$processData($to_process_list);
				unset($to_process_list);				
			} catch (Exception $ex) {
				//恢复本次处理数据，刷新时重新处理
				$this->S($prefix . 'undeal_list', $key, array_merge($to_process_list, $all_undeal_list));
				throw_json($ex->getMessage());
				exit;
			}
			unset($all_undeal_list);
			$this->S($prefix . 'processed_total', $key, $this->S($prefix . 'processed_total', $key) + $to_process_count);//更新已处理总数
			$end_time			= time();
			$all_process_time	= getDiffTime($this->S($prefix . 'process_begin_time', $key), $end_time);
			if ($unrecorded_total > 0) {//通过刷新方式逐步生成旧销售单款项，防止运行超时
				$process_time	= getDiffTime($this->S($prefix . 'process_end_time', $key), $end_time);		//本次处理耗时
				$also_need_time	= getDiffTime($end_time, $end_time + ($end_time - $this->S($prefix . 'process_begin_time', $key)) * $unrecorded_total / $this->S($prefix . 'processed_total', $key));//预计还需耗时
				$message		= '本次处理' . $to_process_count . '条数据，' .
									'耗时' . $process_time . '。<br />' . 
									'已处理' . $this->S($prefix . 'processed_total', $key) . '条数据，' .
									'共耗时' . $all_process_time . '。<br />' . 
									'还有' . $unrecorded_total . '条数据需要处理，' . 
									'预计还需要' . $also_need_time . '。';		
				$jumpUrl		= U($_SERVER['PATH_INFO']);//跳转到本页面继续处理
				if ($this->S($prefix . 'process_begin_mark', $key)) {
					$this->S($prefix . 'process_end_time', $key, $end_time);//上次处理结束时间
				}
			} else {
				$message	= '数据已全部处理，共处理' . $this->S($prefix . 'processed_total', $key) . '条数据，耗时' . $all_process_time . '，接下来将为你跳转到首页！';
				$jumpUrl	= __APP__;//处理完成，跳转到首页
				$this->clearSessionData($prefix);
			}
			$this->success("<br />" . $message, $jumpUrl);
		} else {
			$this->clearSessionData($prefix);		
			$this->error('数据已全部处理，接下来将为你跳转到首页！',0, __APP__);
		}
	}
	
	/**
	 * 获取GET条件
	 * @return array
	 */
	public function getWhere(){
		$where			= array();
		foreach ((array)$this->_whereFieldsByAction[ACTION_NAME] as $field => $val) {
			$prefix	= '';
			if (is_int($field)) {
				$field	= $val;
				$type	= 'string';
			}
			if (isset($_GET[$field])) {
				if (is_array($val)) {
					$type	= $val[0];
					$prefix	= $val[1];
				} else {
					$type	= $val;
				}
				$where_field	= ($prefix ? $prefix . '.' : '') . $field;
				switch ($type) {
					case 'int':
						$where[$where_field]	= (int)$_GET[$field];
						break;
					case 'float':
						$where[$where_field]	= (float)$_GET[$field];
						break;					
					default :
						$where[$where_field]	= (string)$_GET[$field];
						break;
				}
			}
		}	
		return $where;
	}

	/**
	 * 清空缓存数据
	 * @param string $prefix
	 */
	public function clearSessionData($prefix) {
		if (empty($prefix) && empty($_GET['action'])) {
			$_allowActionList	= $this->_allowActionList;
			foreach ($_allowActionList as $action) {
				$prefix	= MODULE_NAME . '_' . $action . '_';
				S($prefix . 'process_begin_time', null);
				S($prefix . 'process_begin_mark', null);
				S($prefix . 'process_end_time', null);
				S($prefix . 'undeal_list', null);
				S($prefix . 'processed_total', null);
				S($prefix . 'process_total', null);
			}
		} else {
			if (empty($prefix)) {
				$prefix	= MODULE_NAME . '_' . $_GET['action'] . '_';
			}
			S($prefix . 'process_begin_time', null);
			S($prefix . 'process_begin_mark', null);
			S($prefix . 'process_end_time', null);
			S($prefix . 'undeal_list', null);
			S($prefix . 'processed_total', null);
			S($prefix . 'process_total', null);
		}
	}
	
	/*********************** 有过发货状态且未生成款项的销售单自动生成款项 st ***********************************/	
	/**
	 * 获取未生成款项的销售单列表
	 * @return array
	 */
	public function generateSaleOrderFundsForUnrecordedData($where	= array()){
		$clientSaleModel		= D('ClientSale');
		//已记录款项的销售单id
		$where['sl.object_type']	= (int)array_search('SaleOrder',C('STATE_OBJECT_TYPE'));
		$where['sl.state_id']		= (int)C('SHIPPED');
		$logged_ids				= $clientSaleModel->table($clientSaleModel->object_type_table)->where('object_type=' . $clientSaleModel->object_type)->group('object_id')->getField('object_id', true);
		if (count($logged_ids)) {
			$where['sl.object_id']			= array('not in', $logged_ids);
		}
		//通过状态日志查找有过发货状态且未生成款项的销售单id
		$undeal_list			= M('StateLog')->alias('sl')->join(' inner join __SALE_ORDER__ so on so.id=sl.object_id')->where($where)->group('object_id')->getField('object_id', true);		
		return $undeal_list;
	}
	
	/**
	 * 自动生成销售单款项
	 * @param array $to_process_list
	 * @return int
	 */
	public function generateSaleOrderFundsForUnrecordedProcess($to_process_list){
		$clientSaleModel	= D('ClientSale');
		//有过发货且未生成款项的销售单列表
		$to_process_list	= M('SaleOrder')->select(implode(',', $to_process_list));
		$to_process_count	= count($to_process_list);
		//生成款项
		foreach ($to_process_list as $to_process_data) {
			$to_process_data['paid_date']	= $to_process_data['order_date'];//款项日期为销售单日期
			$clientSaleModel->_fund($to_process_data);
		}
		return $to_process_count;
	}		
	
	/*********************** 有过发货状态且未生成款项的销售单自动生成款项 ed ***********************************/
	
	/*********************** 对不含待处理且未分配数量大于0的拣货导入单重新分配 st ***********************************/
	/**
	 * 获取不含待处理且未分配数量大于0的拣货导入单列表
	 * @return array
	 */
	public function dealPickingImportData($where = array()){
		$module_name				= 'PickingImport';
		$field						= 'pd.file_id, p.relation_id as picking_id';
		$join						= 'right join __FILE_DETAIL__ pd on p.id=pd.file_id';
		$having						= 'sum(pd.state=' . C('CFG_IMPORT_FAILED_STATE') . ')=0 and sum((pd.state!=' . C('CFG_IMPORT_FAILED_STATE') . ')*pd.undeal_quantity)>0';
		$where['p.error_quantity']	= 0;
		$where['p.relation_id']		= array('gt', 0);
		$where['p.file_type']		= (int)array_search($module_name, C('CFG_FILE_TYPE'));
		//有可能需要重新分配的拣货导入单
		$undeal_list	= D($module_name)->field($field)->alias('p')->join($join)->where($where)->group('pd.file_id')->having($having)->select();
		return $undeal_list;
	}
	
	/**
	 * 重新分配不含待处理且未分配数量大于0的拣货导入单
	 * @param array $to_process_list
	 * @return int
	 */
	public function dealPickingImportProcess($to_process_list){
		$module_name			= 'PickingImport';
		$to_process_count		= count($to_process_list);
		//进行分配
		foreach ($to_process_list as $to_process_data) {
			$to_process_data['method_name']	= 'dealPicking';
			B($module_name, $to_process_data);
		}
		return $to_process_count;
	}	
	
	/*********************** 对不含待处理且未分配数量大于0的拣货导入单重新分配 ed ***********************************/
	
	/*********************** 重新生成产品条形码 st ***********************************/
	/**
	 * 获取产品列表
	 * @return array
	 */
	public function regenerateProductBarcodeData($where = array()){
		$field	= 'p.custom_barcode,p.id,p.product_no,p.product_name,c.product_barcode_config';
		$join	= '__COMPANY__ c on c.id=p.factory_id';
		return M('Product')->alias('p')->field($field)->join($join)->where($where)->select();
	}
	
	/**
	 * 生成产品条形码
	 * @param array $to_process_list
	 * @return int
	 */
	public function regenerateProductBarcodeProcess($to_process_list){
		$Action				= A('Product');
		$to_process_count	= count($to_process_list);
		foreach ($to_process_list as $product) {
			$Action->id	= $product['id'];
			$Action->generateBarcode($product['custom_barcode'], $product['product_no'], $product['product_name'], $product['product_barcode_config']);
		}		
		return $to_process_count;
	}	
	
	/*********************** 重新生成产品条形码 ed ***********************************/
	
	/*********************** 重新生成头程发货条形码 st ***********************************/
	/**
	 * 获取发货列表
	 * @return array
	 */
	public function regenerateInstockBarcodeData($where = array()){
		return M('Instock')->where($where)->getField('id', true);
	}
	
	/**
	 * 生成头程发货条形码
	 * @param array $to_process_list
	 * @return int
	 */
	public function regenerateInstockBarcodeProcess($to_process_list){
		$Action				= A('Instock');
		$to_process_count	= count($to_process_list);
		foreach ($to_process_list as $id) {
			$Action->generateBarcode($id);
		}		
		return $to_process_count;
	}	
	
/*********************** 重新生成头程发货条形码 ed ***********************************/	
	
/*********************** 重新生成头程发货箱号条形码 st ***********************************/
	/**
	 * 获取发货箱号列表
	 * @return array
	 */
	public function regenerateInstockBoxBarcodeData($where = array()){
		$join	= '__INSTOCK__ i on i.id=ib.instock_id';
		return M('InstockBox')->field('ib.id as id')->alias('ib')->join($join)->where($where)->getField('id', true);
	}
	
	/**
	 * 生成头程发货箱号条形码
	 * @param array $to_process_list
	 * @return int
	 */
	public function regenerateInstockBoxBarcodeProcess($to_process_list){
		$Action				= A('Instock');
		$to_process_count	= count($to_process_list);
		foreach ($to_process_list as $id) {
			$Action->generateBoxBarcode($id);
		}		
		return $to_process_count;
	}	
	
/*********************** 重新生成头程发货箱号条形码 ed ***********************************/	
	
/*********************** 重新生成处理单号条形码 st ***********************************/
	/**
	 * 获取销售单列表
	 * @return array
	 */
	public function regenerateSaleOrderBarcodeData($where = array()){
		return M('SaleOrder')->where($where)->getField('id', true);
	}
	
	/**
	 * 生成处理单号条形码
	 * @param array $to_process_list
	 * @return int
	 */
	public function regenerateSaleOrderBarcodeProcess($to_process_list){
		$Action				= A('SaleOrder');
		$to_process_count	= count($to_process_list);
		foreach ($to_process_list as $id) {
			$Action->generateBarcode($id);
		}		
		return $to_process_count;
	}	
	
/*********************** 先进先出旧数据处理 ed ***********************************/	
    //发货入库
    public function InstockStorageData($where = array()){
		return M('instock_storage')->getField('id', true);
	}
    
	public function InstockStorageProcess($to_process_list){
		$to_process_count	= count($to_process_list);
        $params['_module']  = 'InstockStorage';
		foreach ($to_process_list as $id) {
            $params['id']       = $id;
            D('FiFo')->run($params);
		}
		return $to_process_count;
	}

    //退货入库
    public function ReturnSaleOrderStorageData(){
        $return_storage_id  = M('return_sale_order_storage')->field('a.id')->join('as a left join return_sale_order_storage_detail as b on a.id=b.return_sale_order_storage_id')->where('b.quantity>0')->select();
        foreach ($return_storage_id as $value){
            $id[]   = $value['id'];
        }
        return $id;
	}

	public function ReturnSaleOrderStorageProcess($to_process_list){
		$to_process_count	= count($to_process_list);
        $params['_module']  = 'ReturnSaleOrderStorage';
		foreach ($to_process_list as $id) {
            $params['id']       = $id;
            D('FiFo')->run($params);
		}
		return $to_process_count;
	}

    //入库导入
    public function instockImportData($where = array()){
        $where      = 'file_type='.  array_search('InstockImport',C('CFG_FILE_TYPE'));
//        $main_id    = M('file_list')->where($where)->getField('id', true);
//		return M('file_detail')->where('file_id in ('. implode(',', $main_id).')')->getField('id', true);   
        return M('file_list')->where($where)->getField('id', true);
	}

	public function instockImportProcess($to_process_list){
		$to_process_count	= count($to_process_list);
        $params['_module']  = 'instockImport';
		foreach ($to_process_list as $id) {
            $params['id']       = $id;
            D('FiFo')->run($params);
		}
		return $to_process_count;
	}

    public function AdjustAddData($where = array()){
        $detail_id  = M('adjust')->field('a.id')->join(' as a left join adjust_detail as b on a.id=b.adjust_id')->where('b.quantity>0')->group('a.id')->select();
        foreach ($detail_id as $value){
            $id[]   = $value['id'];
        }
        return $id;
//		return M('adjust')->getField('id', true);
	}

	public function AdjustAddProcess($to_process_list){
		$to_process_count       = count($to_process_list);
        $params['_module']      = 'Adjust';
        $params['adjust_type']  = 'AdjustAdd';
		foreach ($to_process_list as $id) {
            $params['id']       = $id;
            D('FiFo')->run($params);
		}
		return $to_process_count;
	}
	
    public function AdjustSubData($where = array()){
        $detail_id  = M('adjust')->field('a.id')->join(' as a left join adjust_detail as b on a.id=b.adjust_id')->where('b.quantity<0')->group('a.id')->select();
        foreach ($detail_id as $value){
            $id[]   = $value['id'];
        }
        return $id;
//		return M('adjust')->getField('id', true);
	}

	public function AdjustSubProcess($to_process_list){
		$to_process_count       = count($to_process_list);
        $params['_module']      = 'Adjust';
        $params['adjust_type']  = 'AdjustSub';
		foreach ($to_process_list as $id) {
            $params['id']       = $id;
            D('FiFo')->run($params);
		}
		return $to_process_count;
	}

    public function pickingImportData($where = array()){
        $where['file_type']      = array_search('Picking', C('CFG_FILE_TYPE'));
        return  M('file_list')->where($where)->getField('id', true);
	}

	public function pickingImportProcess($to_process_list){
		$to_process_count	= count($to_process_list);
        $params['_module']  = 'pickingImport';
		foreach ($to_process_list as $id) {
            $params['id']       = $id;
            D('FiFo')->run($params);
		}
		return $to_process_count;
	}

    public function stockOutErrorData($where = array()){
        return M('StockOut')->where('`in_location_id` <> `out_location_id`')->getField('id', true);
	}

	public function stockOutErrorProcess($to_process_list){
		$to_process_count	= count($to_process_list);
        $params['_module']  = 'stockOutError';
		foreach ($to_process_list as $id) {
            $params['id']       = $id;
            D('FiFo')->run($params);
		}
		return $to_process_count;
	}

	/**
	 * 
	 * @param array $where
	 * @return type
	 */
    public function saveApiXmlData($where = array()){
		$model	= M('ApiLog');
		$fields	= $model->getDbFields();
		if (in_array('request_xml', $fields) && in_array('return_xml', $fields)) {
			$where['_string']	= 'request_xml !="" or return_xml != ""';
			return $model->where($where)->limit(200000)->getField('id', true);
		}
		return array();
	}

	/**
	 *
	 * @param array $to_process_list
	 * @return int
	 */
	public function saveApiXmlProcess($to_process_list){
		$model	= M('ApiLog');
		$list	= $model->where(array('id' => array('in', $to_process_list)))->getField('id, request_xml, return_xml, request_time');
		foreach ($list as $id => $val) {
			if ($val['request_xml']) {
				saveApiXml($id, stringCompress($val['request_xml'], 'decode'), $val['request_time']);
			}
			if ($val['return_xml']) {
				saveApiXml($id, stringCompress($val['return_xml'], 'decode'), $val['request_time'], false);
			}
		}
		$model->where(array('id' => array('in', $to_process_list)))->setField(array('request_xml' => '', 'return_xml' => ''));
		return count($to_process_list);
	}
    
    
    /*********************** 重新销售单处理费 st ***********************************/
	/**
	 * 获取销售单列表
	 * @return array
	 */
	public function regenerateProcessFeeData($where = array()){
		$field	= 's.id,s.factory_id as comp_id,s.id as object_id,s.warehouse_id,s.sale_order_no as reserve_id,s.express_id,s.express_detail_id,s.is_registered,s.package_id,s.weight,date(s.send_date) as paid_date';
        $sys_pay_class  = C('SYS_PAY_CLASS');
        $join           = ' left join __PAID_DETAIL__ p on s.id=p.object_id and p.object_type=120 and p.comp_type=1 and p.pay_class_id='.$sys_pay_class['processFee'];
        $where['p.id']  = array('exp','is NULL');
        $where['s.sale_order_state']    = array('in','5,6,7,8,11,9,12');
        return M('SaleOrder')->alias('s')->join($join)->field($field)->where($where)->select();
	}

    public function setProcessFeeInfo($info){
		$model      = D('ClientSale');
		///获取销售单主表信息,组合付款的信息
		$info['funds']                  = $info;
		unset($info['funds']['id']);
		///获取客户名称
        $info['funds']['warehouse_id']  = $info['warehouse_id']>0 ? $info['warehouse_id'] : $info['funds']['warehouse_id'];
        $info['currency_id']            = $info['currency_id']>0 ? $info['currency_id'] : SOnly('warehouse', $info['funds']['warehouse_id'],'w_currency_id');
		$info['funds']['comp_name']		= $model->getCompName($info['funds']);	
		$info['funds']['basic_id']		= $info['basic_id'] > 0 ? $info['basic_id'] : C('MAIN_BASIC_ID');
		$info['funds']['paid_date']		= !empty($info['paid_date']) ? $info['paid_date'] : date('Y-m-d');
		$info['funds']['comp_type']		= $model->comp_type;
		$info['funds']['currency_id']	= $info['currency_id']>0 ? $info['currency_id'] :C('SYS_EURO_ID');
		$info['funds']['account_money']	= 0;
		$info['funds']['comments']		= '';
		$info['funds']['object_type']	= $model->object_type;
		$info['funds']['relation_type']	= array_search('SaleOrder', C('FUNDS_RELATED_DOC_MODULE'));//关联单据类型
		$info['package']				= M('Package')->find($info['package_id']);
		$info['express_detail']			= M('ExpressDetail')->field('main.shipping_type, main.warehouse_id, main.company_id, detail.id as express_detail_id, detail.*')->join(' as detail left join __EXPRESS__ as main on main.id=detail.express_id')->where('detail.id=' . $info['express_detail_id'])->find();
        $where['c.id']					= $info['funds']['comp_id'];
        $where['e.warehouse_id']		= $info['funds']['warehouse_id'];
		$info['factory_info']			= M('Company')->alias('c')->join(' __EXPRESS_DISCOUNT__  e on e.factory_id=c.id')->field('c.id,c.package_discount,e.process_discount')->where($where)->find();//卖家信息，用于折扣计算
		$sys_pay_class					= C('SYS_PAY_CLASS');
		$vo['sale_id']					= $info['id']; ///销售单ID 
        $info['funds']['pay_class_id']	= $sys_pay_class['processFee'];
        $vo['funds']['processFee']      = $model->processFee($info);
		unset($info);
		return $vo;
	}

	/**
	 * 生成销售单处理费
	 * @param array $to_process_list
	 * @return int
	 */
	public function regenerateProcessFeeProcess($to_process_list){
		$to_process_count	= count($to_process_list);
		foreach ($to_process_list as $info) {
			$this->setProcessFeeInfo($info);
		}
		return $to_process_count;
	}	
	
	/*********************** 重新销售单处理费 ed ***********************************/

    /*********************** 重新生成出库国内运费 st ***********************************/
	/**
	 * 获取已交接出库批次装箱列表
	 * @return array
	 */
	public function regenerateDomesticShippingFeeData($where = array()){
		$where['ob.is_associate_with']  = array('neq', C('NO_ASSOCIATE_WITH'));
        $return		= M('OutBatch')->alias('ob')
							->join('left join __OUT_BATCH_DETAIL__ obd on ob.id=obd.out_batch_id')
							->join('left join __PACK_BOX__ pb on pb.id=obd.pack_box_id')
							->join('inner join __PAID_DETAIL__ p on p.object_id=pb.id and p.object_type=131 and p.pay_class_id=' . C('OUT_BATCH_SYS_PAY_CLASS.domesticShippingFee'))
							->where($where)
							->field('ob.transport_type, pb.factory_id as comp_id,pb.id as object_id,pb.pack_box_no as reserve_id,pb.warehouse_id,pb.package_id,if(ob.transport_type='.C('SEA_TRANSPORT').',obd.review_cube,obd.review_weight) as review, p.paid_date, p.currency_id')
							->select();
		return $return;
	}

	/**
	 * 重新生成出库国内运费
	 * @param array $to_process_list
	 * @return int
	 */
	public function regenerateDomesticShippingFeeProcess($to_process_list){
		$to_process_count	= count($to_process_list);
		D('ClientOutBatch')->saveFunds($to_process_list);
		return $to_process_count;
	}

	/*********************** 重新生成出库国内运费 ed ***********************************/

    /*********************** 重新生成退货单处理费 st ***********************************/
	/**
	 * 获取退货单列表
	 * @return array
	 */
	public function regenerateReturnProcessFeeData($where = array()){
		$field								= 'b.factory_id as comp_id,a.return_sale_order_id as object_id,b.return_sale_order_no as reserve_id,b.returned_date as paid_date,a.outer_pack,a.outer_pack_id,a.outer_pack_quantity,a.within_pack,a.within_pack_id,a.within_pack_quantity,c.warehouse_id,b.sale_order_id';
        $pay_class_id						= C('SYS_PAY_CLASS.returnProcessFee');
        $join								= 'inner join __RETURN_SALE_ORDER__ as b on a.return_sale_order_id=b.id '
											. 'inner join __RETURN_SALE_ORDER_DETAIL__ c on b.id=c.return_sale_order_id '
											. 'inner join __COMPANY_FACTORY__ cf on cf.factory_id=b.factory_id '
											. 'left join __PAID_DETAIL__ p on b.id=p.object_id and p.object_type=123 and p.comp_type=1 and p.pay_class_id='.$pay_class_id;
        $where['p.id']						= array('exp','is NULL');
		$where['cf.is_return_process_fee']	= 1;
        $where['b.return_sale_order_state']	= array('in', array(C('DROPPED'),C('PROCESS_COMPLETE')));
        $list								= M('ReturnSaleOrderStorage')->alias('a')->field($field)->join($join)->where($where)->group('a.return_sale_order_id')->select();
		return $list;
	}

    public function setReturnProcessFeeInfo($funds){
		$model							= D('ClientReturnSaleStorage');
		$info['funds']                  = $funds;
		unset($info['funds']['id']);
		$info['currency_id']            = SOnly('warehouse', $info['funds']['warehouse_id'],'w_currency_id');
		$info['funds']['comp_name']		= $model->getCompName($info['funds']);
		$info['funds']['basic_id']		= $info['funds']['basic_id'] > 0 ? $info['funds']['basic_id'] : C('MAIN_BASIC_ID');
		$info['funds']['paid_date']		= !empty($info['funds']['paid_date']) && $info['funds']['paid_date'] != '0000-00-00' ? $info['funds']['paid_date'] : date('Y-m-d');
		$info['funds']['comp_type']		= $model->comp_type;
		$info['funds']['currency_id']	= C('SYS_EURO_ID');
		$info['funds']['account_money']	= 0;
		$info['funds']['comments']		= '';
		$info['funds']['object_type']	= $model->object_type;
		$info['funds']['relation_type']	= array_search('ReturnSaleOrder', C('FUNDS_RELATED_DOC_MODULE'));//关联单据类型
		$info['factory_info']			= M('Company')->find($info['funds']['comp_id']);//卖家信息，用于折扣计算
        $info['funds']['pay_class_id']	= C('SYS_PAY_CLASS.returnProcessFee');
		$info['return_process_fee']		= $model->getProcessFee($info['funds']);
		if ($info['return_process_fee']) {
			$model->returnProcessFee($info);
		}
	}

	/**
	 * 生成退货单处理费
	 * @param array $to_process_list
	 * @return int
	 */
	public function regenerateReturnProcessFeeProcess($to_process_list){
		$to_process_count	= count($to_process_list);
		foreach ($to_process_list as $funds) {
			$this->setReturnProcessFeeInfo($funds);
		}
		return $to_process_count;
	}

	/*********************** 重新生成退货单处理费 ed ***********************************/

    /*********************** 生成相册关联表 st ***********************************/
	/**
	 * 获取相册关联列表
	 * @return array
	 */
	public function galleryRelationData($where = array()){
		$field								= 'id';
        $where['relevance_id']				= array('neq','');
        $list								= M('Gallery')->field($field)->where($where)->getField('id', true);
		return $list;
	}

	/**
	 * 生成相册关联信息
	 * @param array $to_process_list
	 * @return int
	 */
	public function galleryRelationProcess($to_process_list){
		$to_process_count	= count($to_process_list);
		$dataList			= array();
		$gallery_id			= array();
		$gallery			= M('Gallery');
		foreach ($to_process_list as $id) {
			$gallery_id[]	= $id;
			$relevance_id	= explode(',', $gallery->where(array('id' => $id))->getField('relevance_id'));
			foreach ($relevance_id as $relation_id) {
				if ($relation_id > 0) {
					$dataList[]		= array(
						'gallery_id'	=> $id,
						'relation_id'	=> $relation_id,
					);
				}
			}
		}
		M('GalleryRelation')->where(array('gallery_id' => array('in', $gallery_id)))->delete();
		M('GalleryRelation')->addAll($dataList);
		return $to_process_count;
	}

	/*********************** 生成相册关联表 ed ***********************************/

	public function batchExportProductList(){
		addLang('Product');
		$title		= array("\xEF\xBB\xBF" . L('id'), L('product_no'), L('custom_barcode'), L('product_name'), L('belongs_seller'), L('product_size_detail'), L('weight_detail'), L('check_product_size_detail'), L('check_weight_detail'), L('check_status'), L('volume_weight_detail'));
		$fields		= array('id', 'product_no', 'product_name', 'custom_barcode', 'factory_name', 's_cube', 's_weight', 's_check_cube', 's_check_weight', 'dd_check_status','s_volume_weight');
		$where		= getWhere($_GET);
		ob_end_clean();
		ob_start();
		header ( "Content-type:text/csv" );
		header ( "Content-Disposition:filename=product.csv" );
		// 打开PHP文件句柄，php://output 表示直接输出到浏览器
		$fp			= fopen('php://output', 'a');
		fputcsv($fp, $title);

		$model		= M('Product');
		$count		= $model->where($where)->count();
		$listRows	= 1000;
		$totalPages	= ceil($count/$listRows);
		for ($i = 0; $i < $totalPages; $i++){
			$rs = $model->where($where)->limit($i * $listRows . ', ' . $listRows)->field('id, product_no, product_name, custom_barcode, factory_id, cube_high*cube_wide*cube_long as cube, weight, check_high*check_wide*check_long as check_cube, check_weight, check_status, cube_high, cube_wide, cube_long, check_high, check_wide, check_long')->order('id desc')->select();
			foreach ($rs as &$value ) {
				$volume_cube			= $value['check_status'] == 0 ? $value['cube'] : $value['check_cube'];
				$value['volume_weight']	= volume_weight_calculate(false, $volume_cube, true);
			}
			$list	= _formatList($rs, null, 0);
			_formatWeightCubeList($list['list']);
			foreach ($list['list'] as $value ) {
				$rows	= array();
				foreach ( $fields as $field){
					$rows[] = is_numeric($value[$field]) && strlen($value[$field]) > 8 ? '="' . $value[$field] . '"' : $value[$field];
				}
				fputcsv($fp, $rows);
			}
		   unset($list);
		   ob_flush();
		   flush();
		}
		exit ();
	}
    
    /*********************** 修复先进先出异常数据 st ***********************************/
	/**
	 * @return array
	 */
	public function fixedFiFoData(){
        $sql    = 'select stock_in_id, warehouse_id, location_id, product_id, sum(balance) as lave, 
                sum(i_quantity) as in_quantity, sum(o_quantity) as out_quantity
                from (
                select stock_in_id, quantity as o_quantity, 0 as i_quantity, 0 as balance, 
                in_warehouse_id as warehouse_id, in_location_id as location_id, product_id
                from stock_out 
                union all
                select id as stock_in_id, 0 as o_quantity, quantity as i_quantity, balance, 
                warehouse_id, location_id, product_id 
                from stock_in  
                ) tmp group by stock_in_id
                having in_quantity-lave-out_quantity<>0';
        $rs     = M()->query($sql);
		return $rs;
	}

	/**
	 * @param array $to_process_list
	 * @return int
	 */
	public function fixedFiFoProcess($to_process_list){
		$to_process_count	= 0;
        $StockOut           = M('StockOut');
        $StockIn            = M('StockIn');
        foreach ($to_process_list as $val) {
            $diff_quantity  = $val['out_quantity'] - $val['in_quantity'] + $val['lave'];
			if ($diff_quantity <= 0) {
				dump('diff_quantity<0:');
				dump($val);
				continue;
			}
			$so_where		= array(
				'product_id'        => $val['product_id'],
				'out_location_id'   => $val['location_id'],
				'stock_in_id'       => $val['stock_in_id'],
				'quantity'          => array('egt', $diff_quantity),
			);
			$stock_out		= $StockOut->where($so_where)->order('id desc')->find();
			if (empty($stock_out)) {
				dump('stock out not found:');
				dump($val);
				continue;
			}
			$stock_out_id   = $stock_out['id'];
			$si_where		= array(
				'product_id'    => $val['product_id'],
				'location_id'   => $val['location_id'],
				'balance'       => array('egt', $diff_quantity),
			);
			$stock_in_id	= $StockIn->where($si_where)->getField('id');
			if ($stock_in_id <= 0) {
				dump('stock in not found:');
				dump($val);
				continue;
			}
			$StockIn->where(array('id' => $stock_in_id))->setDec('balance', $diff_quantity);
			if ($diff_quantity == $stock_out['quantity']) {
				$StockOut->where(array('id' => $stock_out_id))->setField('stock_in_id', $stock_in_id);
			} else {
				$StockOut->where(array('id' => $stock_out_id))->setDec('quantity', $diff_quantity);
				$stock_out['stock_in_id']   = $stock_in_id;
				$stock_out['quantity']      = $diff_quantity;
				unset($stock_out['id']);
				$stock_out_id               = $StockOut->add($stock_out);
			}
			M()->execute('update stock_out o inner join stock_in i on i.id=o.stock_in_id 
							set o.in_main_id=i.main_id, o.in_detail_id=i.detail_id, 
							o.in_warehouse_id=i.warehouse_id, o.in_location_id=i.location_id, 
							o.in_date=i.in_date, o.in_currency_id=i.currency_id, o.in_price=i.price, 
							o.in_base_price=i.base_price,o.in_relation_type=i.relation_type,
							o.base_delivery_price=i.base_delivery_price 
							where o.id =' . $stock_out_id);
			$to_process_count++;
			if($this->_trans == true){
				commit();
				$this->_trans_commit = true;
			}
			dump('process success:');
			dump($val);
        }
		return $to_process_count;
	}

	/*********************** 修复先进先出异常数据 ed ***********************************/    
}