<?php

/**
 * 导入管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	导入管理
 * @package  	Model
 * @author    	wqy
 * @version 	2.1,2012-07-22
*/

class ExcelPublicModel extends AbsExcelPublicModel  {
	
 	  protected $tableName 	= 'product';
	  public $excel_info	=	
	  array( 
	  			'District'			=>array(
			  							'main'				=>'district',//key
			  							'valid'				=>'Basic_addCountry',//验证规则 
			  							'befor_valid'		=>'beforValidDistrict',//前置验证
			  							'replace'	=>array(
			  										'city_name'=>array(
			  																'field'			=>'parent_id',
			  																'tables'		=>'district',
			  																'insert_name'	=>'district_name',
			  																'default'		=>array('to_hide'=>1), 
			  																'valid'			=>'require', 
			  																'after_insert'	=>true, 
			  																),
			  										), 
			  							'default'	=>array('to_hide'=>1,'parent_id'=>0), 
			  							'dd'		=>array(5,2), 
			  							),
			  	'Employee'			=>array(
			  							'main'		=>'employee',//key
			  							'dd'		=>array(7,9,12),//key
			  							'valid'		=>'Basic_addEmployee',//验证规则
			  							'befor_fn'	=>'beforEmployee',//验证规则
			  							'field'		=>array('country_name','district_name'),//插入字段的顺序 
			  							'auto_no'	=>'employee_no', 
			  							'action'	=>'Employee', 
			  							'replace'	=>array(
			  										//部门
			  										'department_name'=>array(
			  																'field'			=>'department_id',
			  																'tables'		=>'department',
			  																'insert_name'	=>'department_name',
			  																'default'		=>array('to_hide'=>1),
			  																'auto_no'		=>'department_no',
			  																'action'		=>'Department'
			  																),
			  										//职务						
			  										'position_name'=>array(
			  																'field'			=>'position_id',
			  																'tables'		=>'position',
			  																'insert_name'	=>'position_name',
			  																'default'		=>array('to_hide'=>1),
			  																'auto_no'		=>'position_no',
			  																'action'		=>'Position'
			  																),						
			  										), 
			  							'default'	=>array('to_hide'=>1), 
			  							),				  								 
	  			'Product'			=>array(
			  							'main'		=>'product',//key
			  							'dd'		=>array(13),//dd
			  							'auto_no'	=>'product_no', 
			  							'action'	=>'Product', 
			  							'befor_valid'	=>'beforValidProduct',//插入前的验证方法
			  							'valid'		=>'Basic_addProduct',//验证规则
			  							'field'		=>array('product_no','product_name','factory_name'),//插入字段的顺序
			  							//产品编号	产品名称	卖家名称	

			  							'after_fn'	=>'afterProduct',//插入后的执行的方法
			  							'explode'	=>array(), //需要切割的字段 
			  							'replace'	=>array( 
			  										'factory_name'=>array(
			  																'field'			=>'factory_id',
			  																'tables'		=>'company',
			  																'insert_name'	=>'comp_name',
			  																'select'		=>true,
			  																'default_value'	=>'',
//			  																'default'		=>array('comp_type'=>2,'to_hide'=>1),
//			  																'auto_no'		=>'comp_no',
//			  																'action'		=>'Factory'
			  																),									 									
			  										), 
			  							'max_row'	=>2999, 			
			  							'default'	=>array('to_hide'=>1,'orders_norms'=>1), 
			  							),
	  			'Client'			=>array(
			  							'main'		=>'client',//key
//                                        'dd'            =>array(14),//key //客户数据量太大，已改成读取数据库方式 仍可以用S('client')读取客户数据 by jph 20140911
			  							'valid'		=>'Basic_addClient',//验证规则 
			  							'auto_no'	=>'comp_no',
			  							'action'	=>'Client',
			  							'replace'	=>array( 
			  										'country_name'=>array(
			  																'field'			=>'country_id',
			  																'tables'		=>'district',
			  																'insert_name'	=>'district_name',   
			  																'select'		=>true,
			  																), 
			  										'city_name'=>array(
			  																'field'			=>'city_id',
			  																'tables'		=>'district',
			  																'insert_name'	=>'district_name',   
			  																'select'		=>true,
			  																), 							
			  										), 
			  							'befor_fn'	=>'beforClient',//验证规则
			  							'max_row'	=>2999, 	
			  							'default'	=>array('to_hide'=>1), 
			  							),
			  	'Factory'			=>array(
			  							'main'		=>'factory',//key
			  							'dd'		=>array(13),//key
			  							'valid'		=>'Basic_addFactory',//验证规则
			  							'auto_no'	=>'comp_no',
			  							'action'	=>'Factory',
			  							'befor_fn'	=>'beforFactory',//验证规则
			  							'replace'	=>array( 
			  										'currency_name'=>array(
			  																'field'			=>'currency_id',
			  																'tables'		=>'currency',
			  																'insert_name'	=>'currency_no',  
			  																'default_value'	=>-1,
			  																'select'		=>true,
			  																), 	
			  										'country_name'=>array(
			  																'field'			=>'country_id',
			  																'tables'		=>'district',
			  																'insert_name'	=>'district_name',   
			  																'select'		=>true,
			  																), 
			  										'city_name'=>array(
			  																'field'			=>'city_id',
			  																'tables'		=>'district',
			  																'insert_name'	=>'district_name',   
			  																'select'		=>true,
			  																), 									
			  																
			  										), 
			  							
			  							'default'	=>array('to_hide'=>1,'comp_type'=>2,), 
			  							),	
			  	'OtherCompany'		=>array(
			  							'main'		=>'other_company',//key
			  							'dd'		=>array(13),//key
			  							'valid'		=>'Basic_addOtherCompany',//验证规则
			  							'auto_no'	=>'comp_no',
			  							'action'	=>'OtherCompany',
			  							'befor_fn'	=>'beforOtherCompany',//验证规则
			  							'replace'	=>array( 
			  										'currency_name'=>array(
			  																'field'			=>'currency_id',
			  																'tables'		=>'currency',
			  																'insert_name'	=>'currency_no',  
			  																'default_value'	=>0,
			  																'select'		=>true,
			  																), 	
			  										'country_name'=>array(
			  																'field'			=>'country_id',
			  																'tables'		=>'district',
			  																'insert_name'	=>'district_name',   
			  																'select'		=>true,
			  																), 
			  										'city_name'=>array(
			  																'field'			=>'city_id',
			  																'tables'		=>'district',
			  																'insert_name'	=>'district_name',   
			  																'select'		=>true,
			  																), 									
			  																
			  										), 
			  							'default'		=>array('to_hide'=>1,'comp_type'=>4,),  
			  							),	  
	  			'InitStorage'		=>array(
			  							'main'			=>'initStorage',//key  
			  							'table_name'	=>'initStorageDetail',//表名
			  							'befor_fn'		=>'beforInistock',//插入前的执行的方法
//			  							'befor_valid'	=>'beforValidStock',//插入前的验证方法
			  							'max_row'	=>2999, 	
			  							'field'		=>array('product_no','quantity','capability','dozen','price','quantity_state'),//插入字段的顺序  
			  							'replace'	=>array(
			  										'product_no'=>array(
			  																'field'			=>'product_id',
			  																'tables'		=>'product',
			  																'insert_name'	=>'product_name', 
			  																'select'		=>true, 
			  																),	
			  										'size_name'=>array(
			  																'field'			=>'size_id',
			  																'tables'		=>'size',
			  																'insert_name'	=>'size_name', 
			  																'select'		=>true, 
			  																),	
			  										'color_name'=>array(
			  																'field'			=>'color_id',
			  																'tables'		=>'color',
			  																'insert_name'	=>'color_name', 
			  																'select'		=>true, 
			  																),															 
			  										), 
			  							//	产品号、箱数、每箱数量、每包数量、单价、是否尾箱【以上必填】
			  							),
			  							
			  	'Stocktake'		=>array(  
			  							'main'			=>'stocktake',//key  
			  							'table_name'	=>'stocktakeDetail',	//表名
			  							'max_row'		=>2999, 	
			  							'befor_fn'		=>'beforStocktake',		//插入前的执行的方法
//			  							'befor_valid'	=>'beforValidStock',	//插入前的执行的方法 
			  							'replace'		=>array(
			  										'product_no'=>array(
			  																'field'			=>'product_id',
			  																'tables'		=>'product',
			  																'insert_name'	=>'product_name', 
			  																'select'		=>true, 
			  																),	
			  										'size_name'=>array(
			  																'field'			=>'size_id',
			  																'tables'		=>'size',
			  																'insert_name'	=>'size_name', 
			  																'select'		=>true, 
			  																),	
			  										'color_name'=>array(
			  																'field'			=>'color_id',
			  																'tables'		=>'color',
			  																'insert_name'	=>'color_name', 
			  																'select'		=>true, 
			  																),															 
			  										), 
			  							'field'		=>array('country_name','district_name'),//插入字段的顺序  
			  							),		 
	  			//init_storage_detail
	  			'ClientIni'		=>array(
			  							'main'		=>'client_paid',//key
			  							'valid'		=>'Funds_addClientIni',//验证规则
			  							'max_row'	=>2999, 	
			  							'table_name'=>'paid_detail',//验证规则
			  							'field'		=>array('comp_name','basic_name','paid_date','currency_no','money','comments'),//插入字段的顺序
			  							'befor_fn'	=>'beforFundclient',//插入前的执行的方法
			  							'replace'	=>array(
			  										'client_name'=>array(
			  																'field'			=>'comp_id',
			  																'tables'		=>'company',
			  																'insert_name'	=>'comp_name', 
			  																'select'		=>true, 
			  																),			
			  										'company_name'=>array(
			  																'field'			=>'basic_id',
			  																'tables'		=>'basic',
			  																'insert_name'	=>'basic_name',
			  																'select'		=>true, 
			  																),	
			  										'currency_name'=>array(
			  																'field'			=>'currency_id',
			  																'tables'		=>'currency',
			  																'insert_name'	=>'currency_no',
			  																'select'		=>true, 
			  																),	 				
			  										),  
			  							'default'	=>array('to_hide'=>1,'paid_type'=>1,'object_type'=>101,'paid_income_type'=>'-1','comp_type'=>1,), 
			  							),	
			  	'FactoryIni'		=>array(
			  							'main'		=>'factory_paid',//key
			  							'valid'		=>'Funds_addClientIni',//验证规则 
			  							'max_row'	=>2999, 	
			  							'befor_fn'	=>'beforFundfactory',//插入前的执行的方法
			  							'replace'	=>array(
			  										'comp_name'=>array(
			  																'field'			=>'comp_id',
			  																'tables'		=>'company',
			  																'insert_name'	=>'comp_name', 
			  																'select'		=>true, 
			  																),		 
			  										'currency_name'=>array(
			  																'field'			=>'currency_id',
			  																'tables'		=>'currency',
			  																'insert_name'	=>'currency_no',
			  																'select'		=>true, 
			  																),	 				
			  										),  
			  							'default'	=>array('to_hide'=>1,'basic_id'=>1,'paid_type'=>1,'paid_income_type'=>'-1','object_type'=>201,'comp_type'=>2,), 
			  							),		 
	  			'InstockDetail'			=>array(//发货单导入
											'after_fn'	=>'afterInstockDetail',//插入后的执行的方法
											'after_default'	=> array('cube_long' => 0, 'cube_wide' => 0, 'cube_high' => 0, 'weight' =>0),//插入后处理的默认值
											'max_row'	=> 1500,
			  							),
	            'ShiftWarehouseDetail' =>  array(//移仓导入    add by lxt 2015.07.20
	                                           'after_fn'  =>  'afterShiftWarehouseDetail',
	            ),
	  			'InstockImport'			=>array(//入库单导入
											'after_fn'	=>'afterInstockImport',//插入后的执行的方法
			  							),			  
				'SaleOrderImport'		=>array(//订单导入
			  								'max_row'	=> 999, 	
			  							),
				'ProductImport'			=>array(//产品导入
			  								'max_row'	=> 999, 	
			  							),
				'AdjustDetail'			=>array(//产品导入
			  								'after_fn'	=>'afterAdjustDetail',//插入后的执行的方法
			  							),
		  		'AdjustInstockDetail'	=>array(//入库导入调整导入
			  								'after_fn'	=>'afterAdjustInstockDetail',//插入后的执行的方法
			  							),
                'InstockStorage'        =>array(
                                            'after_fn'  =>'afterInstockStorage',//插入后的执行的方法
                                        ),
                'ExpressPost'           =>array(
                                            'after_fn'  =>'afterExpressPost',//插入后的执行的方法
                                        ),
	  			'PickingImport'			=>array(//拣货导入
											'max_row'	=> 9999,
			  							),
                'ProductCheckImport'	=>array(//产品查验导入
			  								'max_row'	=> 999, 	
			  							),
	  );
	  
	  
	  /**
	   * 导出
	   *
	   */
	  public function getOutPut(){
        switch ($_GET['state']) {
            case 'locationStorage':
            case 'fifoStorage'://先进先出   add by lxt 2015.06.16
            case 'skuStorage':
                $info    = $_SESSION[$_GET['rand']];
                $info['query']['a.warehouse_id']  = $info['query']['warehouse_id'];
                unset($info['query']['warehouse_id']);
                $_SESSION[$_GET['rand']]    = $info;
                break;
        }
        $data = include(THINK_PATH.'Conf/outputExcel.php');
		$not_update_state = false;
        switch ($_GET['state']) {
            case 'ClientStat':
                $list	= $this->db->query($data[$_GET['state']]['sql']);
                $fields	= $data[$_GET['state']]['title'];        
                $value	= $data[$_GET['state']]['content'];
                break;
            case 'Storage':
                if(!empty($_SESSION[$_GET['rand']]['query']['location_id'])){
                    $list	= _formatList($this->db->query($data[$_GET['state']]['real_storage_sql']));
                }else{
                    if(getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')){
                        $info    = $_SESSION[$_GET['rand']];
                        if($info['query']['w.is_return_sold'] == C('NO_RETURN_SOLD')){
                            unset($info['query']['warehouse_id']);
                        }
                        $_SESSION[$_GET['rand']]    = $info;
                    }
                    $list	= _formatList($this->db->query($data[$_GET['state']]['sql']));
                }
                if(!empty($_SESSION[$_GET['rand']]['max_sale_quantity'])){
                    foreach ((array)$list['list'] as $key => $value) {
                        if($value['sale_quantity']>=$_SESSION[$_GET['rand']]['max_sale_quantity']){
                            unset($list['list'][$key]);
                        }
                    }
                }
                $list['fields']	= $data[$_GET['state']]['title'];
                $list['value']	= $data[$_GET['state']]['content'];
                break;
            case 'ReturnSaleOrderStorage':
                $model  = D($_GET['state']);
                $ids    = $model->getExcelListId($_SESSION[$_GET['rand']]);
                $list	= _formatList($this->db->query($model->getExcelListSql($ids)));
                $list['fields']	= $data[$_GET['state']]['title'];
                $list['value']	= $data[$_GET['state']]['content'];
                break;
            case 'Product':
                $return_info	=$this->db->query($data[$_GET['state']]['sql']);
                foreach($return_info as &$value){
                    if($value[check_status]==0){
                        $volume_cube=$value['cube'];              
                    }  else {
                        $volume_cube=$value['check_cube'];                                  
                    } 
                    $value['volume_weight']=volume_weight_calculate(false,$volume_cube,true);  
                }
                $list=_formatList($return_info);
                $list['fields']	= $data[$_GET['state']]['title'];
                $list['value']	= $data[$_GET['state']]['content'];
                break;
            default :
                $list	= _formatList($this->db->query($data[$_GET['state']]['sql']));
                $list['fields']	= $data[$_GET['state']]['title'];
                $list['value']	= $data[$_GET['state']]['content'];
				if($_GET['state'] == 'fixBug'){
					$not_update_state = true;
					$_GET['state'] = 'exportSaleOrder';
				}
                break;
        }
        if(in_array(intval($_GET['company_id']), array(C('EXPRESS_ROYAL_MAIL_ID'),C('EXPRESS_UK-DPD_ID'),C('EXPRESS_PARCEL_FORCE_ID'),C('EXPRESS_FEDEX_ID')))){
            foreach($list['list'] as &$list_val){//added by yyh 20150922
                $list_val['address']    = str_replace(',', ' ', $list_val['address']);
                $list_val['address2']   = str_replace(',', ' ', $list_val['address2']);
                $list_val['city_name']  = str_replace(',', ' ', $list_val['city_name']);
            }
        }
		switch($_GET['state']){
            case 'Product':
                if(isset($list['list'])){
                    _formatWeightCubeList($list['list']);
                    foreach($list['list'] as $val){
                        $product_id[$val['id']]   = $val['id'];
                    }
                    $count  = count($product_id);
                    if($count>0){
                        $product_detail = array();
                        for($i=0;$count>$i;$i+=100){
                            $detail         = M('product_detail')->where('product_id in ('.implode(',', array_slice($product_id,$i,$i+100)).') and properties_id in ('.C('MATERIAL_DESCRIPTION').','.C('HS_CODE').','.C('DECLARED_VALUE').','.C('SALE_PRICE').') and value!=\'\'')->group('product_id,properties_id')->getField('group_concat(product_id,\'-\',properties_id),value');
                            if(!empty($detail)){
                                $product_detail = array_merge($product_detail,$detail);
                            }
                        }
                    }
                    foreach($list['list'] as &$value){
                        $value['material_description']  = $product_detail[$value['id'].'-'.C('MATERIAL_DESCRIPTION')]['value'];
                        $value['hs_code']               = $product_detail[$value['id'].'-'.C('HS_CODE')]['value'];
                        $value['module_declaredvalue']  = $product_detail[$value['id'].'-'.C('DECLARED_VALUE')]['value'];
                        $value['selling_price']         = $product_detail[$value['id'].'-'.C('SALE_PRICE')]['value'];
                        $value['product_no']            = '="'.$value['product_no'].'"';
                        $value['custom_barcode']        = '="'.$value['custom_barcode'].'"';
                        $value['s_volume_weight'] = str_replace('.00','',$value['s_volume_weight']);
                    }
                    if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
                        $filters[]			= 'factory_id';
                    }
                    foreach ($filters as $field) {
                        $field_key          = array_search($field, $list['value']);
                        unset($list['value'][$field_key], $list['fields'][$field_key]);	
                    }
                }
                break;
            case 'QuestionOrder':
                if(isset($list['list'])){
					foreach($list['list'] as $val){
						$sale_order_id[$val['sale_order_id']] = $val['sale_order_id'];
					}
                    if($sale_order_id){
                        $sale_order_detail  = M('sale_order_detail');
                        $sql	 = 'SELECT sale_order_id,product_id,quantity
                                    FROM sale_order_detail
                                    WHERE sale_order_id in ('.implode(',',$sale_order_id).')';
                        $info	 = $sale_order_detail->query($sql);
                        $q_data	 = array();
                        foreach((array)$info as $q_v){
                            $q_data[$q_v['sale_order_id'].'_'.$q_v['product_id']] += $q_v['quantity'];
                        }
                    }
                    $max_count  = 0;
                    foreach ($list['list'] as &$val){
                        //当追踪单号为数字时 进行格式化 add by ljw 20150730
                        if(ctype_digit($val['track_no'])){
                            $val['track_no']    = "=\"".$val['track_no']."\"";
                        }
//                        $val['track_no']    = "\t".$val['track_no'];
                        if ($val['p_ids']) {
                            $tmp = explode(',', $val['p_ids']);
                            $num    =   0;
                            foreach ((array) $tmp as $v) {
                                $p_info	= SOnly('product',$v);
                                $tmp_p_key = $val['sale_order_id'].'_'.$v;
                                $val['product_id'.$num]         = $v;
                                $val['product_no'.$num]         = $p_info['product_no'];
                                $val['product_name'.$num]       = str_replace("\n",' ',$p_info['product_name']);//csv文件需去掉换行符
                                $val['quantity'.$num]           = $q_data[$tmp_p_key];
                                $num++;
                            }
                            if($max_count < count($tmp)){
                                $max_count  = count($tmp);
                            }
                        }
                    }
                    for($p_class=1;$p_class<$max_count;$p_class++){
                            $list['value'][]    = 'product_id'.$p_class;
                            $list['value'][]    = 'product_no'.$p_class;
                            $list['value'][]    = 'product_name'.$p_class;
                            $list['value'][]    = 'quantity'.$p_class;
                            $list['fields'][]   = '产品ID';
                            $list['fields'][]   = 'SKU';
                            $list['fields'][]   = '产品名称';
                            $list['fields'][]   = '退货数量';
                    }
                    if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
                        $filters[]			= 'factory_name';
                    }
                    if(getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')){
                        $filters[]			= 'w_name';
                    }
                    if(in_array(getUser('role_id'),explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))){
                        $filters			= array('proof_delivery_fee','compensation_fee');
                    }
                    foreach ($filters as $field) {
                        $field_key          = array_search($field, $list['value']);
                        unset($list['value'][$field_key], $list['fields'][$field_key]);	
                    }
                }
                break;
			case 'ReturnSaleOrder':
                if (isset($list['list'])) {
					$ids = array();
					foreach($list['list'] as $val){
						$return_sale_order_id[$val['id']] = $val['id'];
					}
                    if($return_sale_order_id){
                        $return_sale_order_detail = M('return_sale_order_detail');
                        $sql	 = 'SELECT rd.return_sale_order_id,rd.product_id,rd.quantity,rsd.location_id,r.return_sale_order_state,rsd.quantity as in_quantity
                                    FROM return_sale_order_detail rd 
                                    left join return_sale_order_storage_detail rsd on rd.return_sale_order_id=rsd.return_sale_order_id and rd.product_id=rsd.product_id
                                    left join return_sale_order r on rd.return_sale_order_id=r.id
                                    WHERE rd.return_sale_order_id in ('.implode(',',$return_sale_order_id).')';
                        $info	 = $return_sale_order_detail->query($sql);
                        $q_data	 = array();
                        foreach((array)$info as $q_v){
                            if(!in_array($q_v['return_sale_order_state'], explode(',', C('EXCEL_SHOW_LOCATION'))) || $q_v['in_quantity'] <=0 ){
                                $q_v['location_id'] = '';
                            }
                            $q_data[$q_v['return_sale_order_id'].'_'.$q_v['product_id']][$q_v['location_id']] += $q_v['quantity'];
                            if($q_v['location_id'] > 0){
                                $location_id[$q_v['location_id']]   = $q_v['location_id'];
                            }
                        }
                        $sys_pay_class      = C('SYS_PAY_CLASS');
                        $return_fee         = M('client_paid_detail')->where('pay_class_id in ('.$sys_pay_class['returnFee'].','.$sys_pay_class['outerPackFee'].','.$sys_pay_class['withinPackFee'].','.$sys_pay_class['returnAdditionalFee'].',' . $sys_pay_class['returnPostageFee']. ',' . $sys_pay_class['returnProcessFee']. ') and object_id in ('.implode(',',$return_sale_order_id).') and original_money>0 and object_type!=102')->group('object_id,pay_class_id')->getField('concat(object_id,"-",pay_class_id),original_money');
                    }
                    $max_count  = 0;
                    $location_no    = getBarcodeNoById($location_id);
                    foreach($list['list'] as &$val){
                        $val['return_service_price']    = $return_fee[$val['id'].'-'.$sys_pay_class['returnAdditionalFee']]['original_money'];
                        $val['return_fee']              = $return_fee[$val['id'].'-'.$sys_pay_class['returnFee']]['original_money'];
                        $val['outer_pack_fee']          = $return_fee[$val['id'].'-'.$sys_pay_class['outerPackFee']]['original_money'];
                        $val['within_pack_fee']         = $return_fee[$val['id'].'-'.$sys_pay_class['withinPackFee']]['original_money'];
                        $val['return_postage_fee']      = $return_fee[$val['id'].'-'.$sys_pay_class['returnPostageFee']]['original_money'];
                        $val['return_process_fee']      = $return_fee[$val['id'].'-'.$sys_pay_class['returnProcessFee']]['original_money'];
						$val['product_detail_info']     = '';
                        $val['order_no']                = '="'.$val['order_no'].'"';
						if($val['warehouse_id']>0){
							$ware_arr	= S('warehouse');
							$val['warehouse_name'] = $ware_arr[$val['warehouse_id']]['w_name'];
						}
                        if ($val['p_ids']) {
                            $tmp = explode(',', $val['p_ids']);
                            $num    =   0;
                            foreach ((array) $tmp as $v) {
                                $p_info	= SOnly('product',$v);
                                $tmp_p_key = $val['id'].'_'.$v;
                                foreach($q_data[$tmp_p_key] as $location_id=>$quantity){
                                    $val['product_id'.$num]         = $v;
                                    $val['product_no'.$num]         = $p_info['product_no'];
                                    $val['product_name'.$num]       = $p_info['product_name'];
                                    $val['location_no'.$num]        = $location_no[$location_id];
                                    $val['quantity'.$num]           = $quantity;
                                    $num++;
                                }
                            }
                            if($max_count < count($tmp)){
                                $max_count  = count($tmp);
                            }
                        }
                    }
                    for($p_class=1;$p_class<$max_count;$p_class++){
                        $list['value'][]    = 'product_id'.$p_class;
                        $list['value'][]    = 'product_no'.$p_class;
                        $list['value'][]    = 'product_name'.$p_class;
                        $list['value'][]    = 'quantity'.$p_class;
                        $list['value'][]    = 'location_no'.$p_class;
                        $list['fields'][]   = '产品ID';
                        $list['fields'][]   = 'SKU';
                        $list['fields'][]   = '产品名称';
                        $list['fields'][]   = '退货数量';
                        $list['fields'][]   = '库位';
                    }
                }
                //added by 20160714 海外仓操作导出EXCEL不显示费用	
                if (in_array($_SESSION["LOGIN_USER"]["role_id"],explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))) {
                    $filters			= array('return_service_price','return_fee','outer_pack_fee','within_pack_fee','return_postage_fee','return_process_fee');
                    foreach ($filters as $field) {
                        $field_key		= array_search($field, $list['value']);
                        unset($list['value'][$field_key], $list['fields'][$field_key]);					
                    }					     
                }
                break;
            case 'ReturnSaleOrderStorage':
                if (isset($list['list'])) {
                    if($ids){
                        $return_sale_order_detail = M('return_sale_order_detail');
                        $sql	 = 'SELECT rsd.return_sale_order_storage_id,rsd.product_id,rd.quantity,rsd.quantity as in_quantity,rsd.location_id
                                    FROM return_sale_order_storage_detail rsd 
                                    left join return_sale_order_detail rd on rsd.return_sale_order_id=rd.return_sale_order_id and rd.product_id=rsd.product_id
                                    left join return_sale_order r on rd.return_sale_order_id=r.id
                                    WHERE rsd.return_sale_order_storage_id in '.$ids.' and r.return_sale_order_state in ('.C('EXCEL_SHOW_LOCATION').')';
                        $info	 = $return_sale_order_detail->query($sql);
                        $q_data	 = array();
                        foreach((array)$info as $q_v){
                            $q_data[$q_v['return_sale_order_storage_id'].'_'.$q_v['product_id']][$q_v['location_id']]['quantity'] += $q_v['quantity'];
                            $q_data[$q_v['return_sale_order_storage_id'].'_'.$q_v['product_id']][$q_v['location_id']]['in_quantity'] += $q_v['in_quantity'];
                            if($q_v['location_id'] > 0){
                                $location_id[$q_v['location_id']]   = $q_v['location_id'];
                            }
                        }
                    }
                    $max_count  = 0;
                    $location_no    = getBarcodeNoById($location_id);
                    foreach($list['list'] as &$val){
                        $val['product_detail_info']     = '';
                        $val['order_no']                = '="'.$val['order_no'].'"';
                        if ($val['p_ids']) {
                            $tmp = explode(',', $val['p_ids']);
                            $num    =   0;
                            foreach ((array) $tmp as $v) {
                                $p_info	= SOnly('product',$v);
                                $tmp_p_key = $val['id'].'_'.$v;
                                foreach($q_data[$tmp_p_key] as $location_id=>$quantity){
                                    $val['product_id'.$num]         = $v;
                                    $val['product_no'.$num]         = $p_info['product_no'];
                                    $val['product_name'.$num]       = $p_info['product_name'];
                                    $val['location_no'.$num]        = $location_no[$location_id];
                                    $val['quantity'.$num]           = $quantity['quantity'];
                                    $val['in_quantity'.$num]        = $quantity['in_quantity'];
                                    $num++;
                                }
                            }
                            if($max_count < count($tmp)){
                                $max_count  = count($tmp);
                            }
                        }
                    }
                    for($p_class=1;$p_class<$max_count;$p_class++){
                        $list['value'][]    = 'product_id'.$p_class;
                        $list['value'][]    = 'product_no'.$p_class;
                        $list['value'][]    = 'product_name'.$p_class;
                        $list['value'][]    = 'quantity'.$p_class;
                        $list['value'][]    = 'in_quantity'.$p_class;
                        $list['value'][]    = 'location_no'.$p_class;
                        $list['fields'][]   = '产品ID';
                        $list['fields'][]   = 'SKU';
                        $list['fields'][]   = '产品名称';
                        $list['fields'][]   = '退货数量';
                        $list['fields'][]   = '退货入库数量';
                        $list['fields'][]   = '库位';
                    }
                }
                break;
			case 'ClientArrearages':
                if (isset($list['list'])) {
                    foreach ($list['list'] as &$v) {
                        $v['dd_billing_type']  = L($v['dd_billing_type']);
                    }
                    $total_money    = $list['total']['currency_id_sum'];
                    foreach ( $total_money as $key => $value){
                        $total_money[$key]['currency']  = SOnly('currency', $key,'currency_no');
                    }
                    $total_money    = _formatList($total_money);
                    foreach($total_money['list'] as &$val){
                        $val['fmd_paid_date']   = L('total');
                        $val['currency_no']     = $val['currency'];
                        unset($val['dml_quantity']);
                    }
                    $list['list']   = array_merge($list['list'],$total_money['list']);
                }
                break;
            case 'ClientOtherArrearages':
                if (isset($list['list'])) {
                    foreach ($list['list'] as &$v) {
                        $v['dd_billing_type']  = L($v['dd_billing_type']);
                    }
                    $total_money    = $list['total']['currency_id_sum'];
                    foreach ( $total_money as $key => $value){
                        $total_money[$key]['currency']  = SOnly('currency', $key,'currency_no');
                    }
                    $total_money    = _formatList($total_money);
                    foreach($total_money['list'] as &$val){
                        $val['fmd_paid_date']   = L('total');
                        $val['currency_no']     = $val['currency'];
                        unset($val['dml_quantity']);
                    }
                    $list['list']   = array_merge($list['list'],$total_money['list']);
                }
                break;
            case 'ClientFunds':
                if (isset($list['list'])) {                   
                    foreach($list['list'] as &$v){
                      $v['befor_currency_no']   = SOnly('currency', $v['befor_currency_id'],'currency_no');
                    }
                    $expand['sum_group_by']     = array('currency_id','befor_currency_id');
                    $new_list                   = _formatList($list['list'],'',1,'',$expand);
                    $total_money                = $new_list['total']['currency_id_sum'];
                    $total_befor_money          = $new_list['total']['befor_currency_id_sum']; 
                    
                    foreach (explode(',', C('factory_currency')) as $value){
                        $total_money[$value]['currency']        = SOnly('currency', $value,'currency_no'); 
                        $total_money[$value]['befor_money']     = $total_befor_money[$value]['befor_money'];
                        $total_money[$value]['account_money']   = $total_befor_money[$value]['account_money'];
                    }
                    
                    $total_money    = _formatList($total_money);                     
                    foreach($total_money['list'] as &$val){
                        $val['factory_name']          = L('total');                      
                        $val['befor_currency_no']     = $val['currency'];
                    }
                    $list['list']   = array_merge($list['list'],$total_money['list']); 
                }               
                break;
            case 'instockDetail':
                if (isset($list['list'])) {
                    _formatWeightCubeList($list['list']);
                    
                    foreach ($list['list'] as &$v) {
                        $v['overall_size']  = $v['check_status']==1 ? $v['s_check_cube'] : 0;
                        $v['weight']        = $v['check_status']==1 ? $v['s_check_weight'] : 0;
                        $v['country']       = SOnly('country',getWarehouseCountry($v['warehouse_id']),'abbr_district_name');
                    }
                }
                break;
            case 'locationStorage':
            case 'skuStorage':
            case 'fifoStorage':
                if (isset($list['list'])) {
                     _formatWeightCubeList($list['list']);
                    $fields      = array('product_no','product_name');
                    foreach ($list['list'] as &$v) {
                        $v['product_no']            = '="'.$v['product_no'].'"';
                        $v['custom_barcode']        = '="'.$v['custom_barcode'].'"';
                        foreach ($fields as $field) {
                            if (preg_match('/^0\d+$/', $v[$field])){
                                $v[$field]  = "\t".$v[$field];
                            }
                        }
                    }
                }
                break;
			case 'Storage':
				if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
					$filters[]			= 'factory_name';
				}
                if($_SESSION[$_GET['rand']]['query']['w.is_return_sold']==C('NO_RETURN_SOLD')){
                    $filters[]          = 'sale_quantity';
                }
                foreach ($filters as $field) {
					$field_key		= array_search($field, $list['value']);
					unset($list['value'][$field_key], $list['fields'][$field_key]);					
				}
                if(isset($list['list'])){
                    _formatWeightCubeList($list['list']);
                    foreach($list['list'] as &$value){
                        $value['product_no']            = '="'.$value['product_no'].'"';
                        $value['custom_barcode']        = '="'.$value['custom_barcode'].'"';
                    }
                }
				break;
			case 'exportSaleOrder':
				//added by jp 20140730 st	
				if (intval($_GET['company_id']) == C('EXPRESS_IT-GLS_ID')) {//IT-GLS 快递公司
					$is_it_gls			= true;
					$filters			= array('client_no','payment','address2','company_name');
				} else {
                    $is_it_gls			= false;
                    $filters			= array('anzahl_sendungen','mobile', 'province_name');                
				}   
                if(intval($_GET['company_id']) == C('EXPRESS_FR-GLS_ID')){
                    $list['value'][]            = 'client_mobile';
                    $list['value'][]            = 'num1';  
                }
				if(intval($_GET['company_id']) == C('EXPRESS_ES-GLS_ID')){
                    $list['value'][]            = 'mobile';
                }
                foreach ($filters as $field) {
					$field_key		= array_search($field, $list['value']);
					unset($list['value'][$field_key], $list['fields'][$field_key]);					
				}			
                if (in_array(intval($_GET['company_id']),array(C('EXPRESS_MRW_ID'),C('EXPRESS_ES_CORREOS_ID'),C('EXPRESS_ENVIELIA_ID'), C('EXPRESS_ES_SUER_ID'),C('EXPRESS_ES-ASM_ID')))) {//西班牙CORREOS 快递公司和ES-ASM快递公司
                    $list['value'][]   ='client_mobile';
                    $list['value'][]   ='state_code';
				}
                $is_address_error   = false;			
				//added by jp 20140730 ed
				if(isset($list['list'])){
                    $sale_details   = $this->getProductInfo($list['list']);
					$ids	= array();					
					foreach($list['list'] as &$v){
                        $ids[$v['sale_order_id']]	= $v['sale_order_id'];
                        if(intval($_GET['company_id']) == C('EXPRESS_DPD_ID') && intval($_GET['w_id']) == C('EXPRESS_DE_WAREHOUSE_ID')){
                            $v['consignor']     = C('EXPORT_DE_DPD_SALEORDER_CONSIGNOR');				 //发货人默认值
                        }else{
                            $v['consignor']	   = C('EXPORT_SALEORDER_CONSIGNOR');
                        }
                        if (in_array(intval($_GET['company_id']),array(C('EXPRESS_ES_CORREOS_ID'),C('EXPRESS_MRW_ID'),C('EXPRESS_ENVIELIA_ID'), C('EXPRESS_ES_SUER_ID'),C('EXPRESS_ES-ASM_ID')))) {//西班牙CORREOS 快递公司地址后加空格（乱码导致分号不见）
                            $v['address'] .= ' ';
                            $v['address2'] .= ' ';
                        }
                        $v['country_code'] = SOnly('country',$v['country_id'], 'abbr_district_name');    //国家代码
						$v['payment']	   = '';													 //支付方式默认空
//						$v['merge_address']= $v['address'];
//						if($v['address2']){
//							$v['merge_address'] .= '-'.$v['address2'];
//						}
                        if (intval($_GET['company_id']) == C('EXPRESS_FR-GLS_ID')) {//added by yyh 20141104
                            if (strlen($v['address']) > 35 || strlen($v['address2']) > 35) {
                                $v['ext_cols']      = '***';
                            }else{
                                $v['ext_cols']      = '';
                            }
                        }
                        if(in_array(intval($_GET['company_id']), array(C('EXPRESS_DE-GLS_ID'),C('EXPRESS_MRW_ID'),C('EXPRESS_UPS_ID'),C('EXPRESS_FR-UPS_ID')))){ 
                            if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                                $v['weight']        = WeightGtoKG($v['volume_weight'],1);
                            }else {
                                 $v['weight']       = WeightGtoKG($v['weight'],1);
                            }
                        }else{
                            if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                                $v['weight']        = WeightGtoKG($v['volume_weight']);
                            }else {
                                $v['weight']        = WeightGtoKG($v['weight']);
                            }
                        }
                        if (in_array(intval($_GET['company_id']),array(C('EXPRESS_MRW_ID'),C('EXPRESS_ES_CORREOS_ID'),C('EXPRESS_ENVIELIA_ID'), C('EXPRESS_ES_SUER_ID'),C('EXPRESS_ES-ASM_ID')))) {//西班牙CORREOS 快递公司和ES-ASM快递公司
                            if(empty($v['client_mobile'])){
                                $v['client_mobile'] = 0;
                            }
                            $v['state_code']			= substr($v['post_code'],0,2);
                        }
                        if ($is_it_gls == true) {//IT-GLS 快递公司 added by jp 20140730 st
                            $v['consignor']     = C('EXPORT_IT-GLS_CONSIGNOR');
//                            $v['client_name']   = $v['consignee'];
                            //$v['sale_order_no']		= ltrim($v['sale_order_no'], 'DD');
                            $v['weight']        = str_replace('.', ',', $v['weight']);
                            $v['anzahl_sendungen'] = '1';  //包裹（发货单数量）						   默认全部填1                           
                            $v['post_code']     = str_pad($v['post_code'], 5, '0', STR_PAD_LEFT);
							if($_GET['w_id']== C('EXPRESS_IT_WAREHOUSE_ID')){
			                    $v =$this->addStrReplace($v);
							}
							$v['province_name'] = $v['company_name'];
                            $v['address']       .= ((empty($v['address2'])) ? '' : '-') . $v['address2'];			
                            $v['mobile']        .= ((strlen($v['address']) < 30) ? '' : '-') . substr($v['address'], 30);
                            $v['address']       = substr($v['address'], 0, 30);
                            $v['mobile']        .= ($v['mobile'] != '' ? '-' : '') . $sale_details[$v['sale_order_id']];										
                        }
						if(intval($_GET['w_id'])== C('EXPRESS_IT_WAREHOUSE_ID') && $is_it_gls == false){ //意大利仓库
						    $v =$this->addStrReplace($v);
						}
                        if($_GET['company_id'] == C('EXPRESS_ES-DHL_ID')){
                            $list['value'][]   ='mobile';
                        }
                        if (in_array(intval($_GET['company_id']) ,array(C('EXPRESS_FR-GLS_ID')))) {
                            $v['num1']     = $v['weight'] ;
                            $v['weight']   =  $sale_details[$v['sale_order_id']];
                        }elseif($is_it_gls==FALSE){
                            $list['value'][]   ='priduct';
                            $v['priduct']   = $sale_details[$v['sale_order_id']];
                        }
                        if(in_array($_GET['company_id'],array(C('EXPRESS_MRW_ID'),C('EXPRESS_ES_CORREOS_ID'),C('EXPRESS_ENVIELIA_ID'), C('EXPRESS_ES_SUER_ID'),C('EXPRESS_ES-ASM_ID')))){
                            $v['order_cube']    = (int)ceil($v['cube_high']) * (int)ceil($v['cube_wide']) * (int)ceil($v['cube_long']);
                            $list['value'][]    = 'order_cube';
                        }
						if($_GET['company_id'] == C('EXPRESS_PL-DHL_ID')){
                            $list['value'][]   ='mobile';
                        }
                    }
					if(in_array($_GET['company_id'], C('GLS_API_EXPRESS_ID'))){
						$this->exportSaleOrderProcess($ids, $list);
					}else if($not_update_state!=true){
						$this->exportSaleOrderProcess($ids, $list['list']);
					}
				}
                $list['value'][]            = 'ext_cols';
				if(in_array(intval($_GET['company_id']), array(C('EXPRESS_UPS_ID'),C('EXPRESS_FR-UPS_ID')))){//UPS,法国UPS快递公司 电话号码
                    $list['value'][]            = 'mobile';
                }
				break;
			case 'exportDhlSaleOrder':
				if(isset($list['list'])){
                    $sale_details = $this->getProductInfo($list['list']);
					$ids	= array();
					foreach($list['list'] as &$v){
                        $ids[$v['sale_order_id']]	= $v['sale_order_id'];
						$v['verfahren']			= $v['abbr_district_name']=='DE'?'01':'54';
						$v['produkt_cn']		= $v['abbr_district_name']=='DE'?'101':'5401';
						
						$v['empf_hausnr']		= '';   //默认为空 门派号码
						$_address				= explode(' ', $v['address']);
						$_count				    = count($_address);
						if(intval($_count)>1){
							$v['empf_hausnr']	= $_address[$_count-1];   //默认为空 门派号码
							array_pop($_address);
							$v['address']		= implode(' ',$_address);		
						}
						$v['teilnahme']		    = '01';	//发货人代码（我公司）					   默认01
						$v['extraslst']		    = '';	//									   传空值
						$v['empf_ortteil']		= '';	//城市区份							   默认空值
						$v['anzahl_sendungen']  = '1';  //包裹（发货单数量）						   默认全部填1
						$v['v_zoll_warenliste'] = '';	//如果是发到需要报关的国家，相应报关支付方式  默认为空
						if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']        = WeightGtoKG($v['volume_weight']);
                        }else {
                            $v['weight']        = WeightGtoKG($v['weight']);
                        }
                        $v['mobile']            .= ($v['mobile']!=''?'-':'').$sale_details[$v['sale_order_id']]; 
					}
					$this->exportSaleOrderProcess($ids, $list);
				}
				break;
			case 'exportDeutscheSaleOrder':
				if(isset($list['list'])){
                    $sale_details = $this->getProductInfo($list['list']);
					$ids	= array();
                    $list_value = $list['value'];
					foreach($list['list'] as &$v){
                        $ids[$v['sale_order_id']] = $v['sale_order_id'];
                        if($v['shipping_type']!=C('SHIPPING_TYPE_SURFACE')){
                            if($_GET['company_id']==C('EXPRESS_FR_POST_ID')){
                                $v['product_id']    = $sale_details[$v['sale_order_id']];
                                $v['weight']        = WeightGtoKG($v['weight']);
                                $v['address2']    .= ' ';
                                $content    =   array('sale_order_no','consignee','address','address2','post_code','city_name','abbr_district_name','product_id','num0','mobile','num1','num2','client_email','weight','num3','num4','num5','num6','num7','num8','num9');
                                $arr = array();
                                if(count($list_value)>count($content)){
                                    foreach ($list_value as $key => $val) {
                                        $arr[$val]  = isset($content[$key]) ? $v[$content[$key]] : '';
                                    }
                                } else {
                                    foreach ($content as $key => $val) {
                                        if (isset($list_value[$key])) {
                                            $arr[$list_value[$key]] = $v[$val];
                                        } else {
                                            $arr['ext_cols'][] = $v[$val];
                                        }
                                    } 
                                    if (!in_array('ext_cols', $list['value'])) {
                                        $list['value'][]            = 'ext_cols';
                                    }
                                }
                                $v = $arr;     
                                $v['sign']  = ',';
                            }
                        }else{
//						$v['consignee']		     = $v['client_name'];//C('EXPORT_SALEORDER_CONSIGNOR');							 //发货人默认值
                            $v['abbr_district_name'] = SOnly('country', $v['country_id'], 'abbr_district_name');    //国家代码
                            $_address = explode(' ', $v['address']);
                            $_count = count($_address);
                            if (intval($_count) > 1) {
                                $v['number'] = $_address[$_count - 1];
                                array_pop($_address);
                                $v['address'] = implode(' ', $_address);
                            } else {
                                $v['number'] = '';
                            }
                            _mergeAddress($v, ' ', array('address', 'address2'));
                            if (checkStrIn(C('EXPRESS_WAY_DHL_DEUTSCHE_POST'), $v['merge_address'])) {
                                $v['adress_typ'] = C('EXPORT_DEUTSCHE_POST_ADRESS_TYP_OTHER');
                            } else {
                                $v['adress_typ'] = C('EXPORT_DEUTSCHE_POST_ADRESS_TYP_DEFAULT');
                            }
                        }
					}
					$this->exportSaleOrderProcess($ids, $list);
					//默认第一条数据				
                    if (intval($_GET['company_id']) == C('EXPRESS_FR_POST_ID')) {//added by yyh 20150107
                            $first_data = array(
							'consignee'				=> C('EXPORT_FR_POST_CONSIGNOR'),
							'address2'				=> '',
							'address'				=> '34av charles de gaulle',
							'number'				=> '(lot45/46)',
							'post_code'				=> '93240',
							'city_name'				=> 'stains',
							'abbr_district_name'	=> 'FR',
							'adress_typ'			=> 'HOUSE',
					);
                    }elseif(intval($_GET['company_id']) == C('EXPRESS_DEUTSCHE_POST_ID')&&intval($_GET['w_id'])==C('EXPRESS_PL_WAREHOUSE_ID')){
						 $first_data = array(
							'consignee'				=> C('EXPORT_DEUTSCHE_POST_CONSIGNOR'),
							'address2'				=> '',
							'address'				=> 'Logistics GmbH·Schubertstraße',
							'number'				=> '67',
							'post_code'				=> '15234',
							'city_name'				=> 'Frankfurt (Oder)',
							'abbr_district_name'	=> 'DE',
							'adress_typ'			=> 'HOUSE',
					);			
					}else{
                        	$first_data = array(
							'consignee'				=> C('EXPORT_DEUTSCHE_POST_CONSIGNOR'),
							'address2'				=> '',
							'address'				=> 'Industrie str. 114',
							'number'				=> '114',
							'post_code'				=> '21107',
							'city_name'				=> 'Hamburg',
							'abbr_district_name'	=> 'DE',
							'adress_typ'			=> 'HOUSE',
					);
                    }
					array_unshift($list['list'],$first_data);
				}
				break; 
            case 'expressFrPostSaleOrder':
				if(isset($list['list'])){
                    $sale_details = $this->getProductInfo($list['list']);
					$ids	= array();
                    $list_value = $list['value'];
                    for ($num = 0; $num < 12; $num++) {
                        $arr['num' . $num] = '';
                    }
                    foreach($list['list'] as &$v){
                        if($v['country_id']==C('FR_COUNTRY_ID')){
                            if($v['is_registered']==1){
                               $v['is_registered']='DOS';
                            }else{
                               $v['is_registered']='DOM'; 
                            }                            
                        }else{
                            $v['is_registered']='DOS';
                        }
                        $v['sale_order_no1']= $v['sale_order_no'];
                        $ids[$v['sale_order_id']] = $v['sale_order_id'];
                        $v['product_id'] = $sale_details[$v['sale_order_id']];
                        if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']        = WeightGtoKG($v['volume_weight']);
                        }else {
                            $v['weight']        = WeightGtoKG($v['weight']);
                        }
                        $v  = array_merge($v,$arr);
                    }
					$this->exportSaleOrderProcess($ids, $list);
				}
                break;
//			case 'exportFrGlsSaleOrder':
//                if(isset($list['list'])){
//                    $ids = array();
//					foreach($list['list'] as $val){
//						$ids[] = $val['sale_order_id'];
//					}
//					if($ids){
//						$details		= M('SaleOrderDetail')
//											->field('sod.sale_order_id as sale_id,if(sum(sod.quantity)>1,concat(sum(sod.quantity),"*",sod.product_id),sod.product_id) as product')
//											->join('sod left join product p on p.id=sod.product_id')
//											->where('sod.sale_order_id in (' . implode(',', $ids) . ')')
//											->group('sod.sale_order_id,sod.product_id')
//											->select();
//						$this->exportSaleOrderProcess($ids, $list]);
//						unset($ids);
//						$sale_details	= array();
//						foreach ($details as $detail) {
//							$sale_id	= $detail['sale_id'];
//							unset($detail['sale_id']);//不可少
//							if (!isset($sale_details[$sale_id])) {
//								$sale_details[$sale_id]	= $detail['product'];
//							} else {
//                                $sale_details[$sale_id] .= '-'.$detail['product'];
//                            }
//							}
//						}
//						unset($details);
//                    //$serial_no  = 0;
//					foreach ($list['list'] as $key => &$v) {
//                        $sale_order_key = $key;
//                        //$serial_no++;
//                        //$v['serial_no'] = $serial_no; //序列号自增
//                        $v['contract_no'] = ''; //合同代码
//                        $v['GLS_account'] = ''; //GLS帐号                            
//                        $v['consignor2'] = ''; //发货人2                            
//                        $v['address3'] = ''; //地址3
//                        $v['code_nuit'] = '';
//                        $v['weight']        = WeightGtoKG($v['weight']);
//                        $v['product_id'] = $sale_details[$v['sale_order_id']];
//                        $v['country_id'] = SOnly('country', $v['country_id'], 'abbr_district_name');
//                    }
//                }
//                break;
            case 'exportItBrtSaleOrder':
                if (intval($_GET['company_id']) == C('EXPRESS_IT-NEXIVE_ID')|| $_GET['w_id']!= C('EXPRESS_IT_WAREHOUSE_ID')) {//IT-NEXIVE快递
                    $filters			= array('brt_account_no','goods_cost','comment');
				}else{
                    $filters			= array('assicurazione_si_no','valore_merce');
                }       
                foreach ($filters as $field) {
                    $field_key  = array_search($field, $list['value']);
                    unset($list['value'][$field_key], $list['fields'][$field_key]);					
                }
                if(isset($list['list'])){			
                    $sale_details	= $this->getProductInfo($list['list']);			
					$ids			= array();
                    
                foreach($list['list'] as $key=>&$v){
                        $v =$this->addStrReplace($v);
                        $sale_order_key = $key;
                        $ids[$v['sale_order_id']]	= $v['sale_order_id'];
                        $v['warehouse_id'] = 'EDA ITALY S.R.L'; //发货仓库   默认EDA ITALY S.R.L
                        if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']        = WeightGtoKG($v['volume_weight']);
                        }else {
                            $v['weight']        = WeightGtoKG($v['weight']);
                        }	
                        //$v['weight'] = str_replace('.', ',', $v['weight']);
                        if ($v['quantity'] > 1) {
                            $quantity = $v['quantity'] . '*';
                        } else {
                            $quantity = '';
                        }
                        $v['consignee']             = $v['consignee'].'-' . $sale_details[$v['sale_order_id']];
                        $v['spedizione']            = '1'; //邮件数量                默认1
                        $v['assicurazione_si_no']   = ''; //保险                    默认为空
                        $v['valore_merce']          = ''; //价格                    默认为空
                        $v['country_id']            = SOnly('country', $v['country_id'], 'abbr_district_name');
                        $v['address']               = $v['address'].((empty($v['address2']))?'':'-').$v['address2'];
                        $v['goods_cost']            = ''; //货物价值                默认为空
                        $v['comment']               = ''; //备注                    默认为空
                }
				$this->exportSaleOrderProcess($ids, $list);
            }
            break;
			case 'exportUKDPDSaleOrder':
                if(isset($list['list'])){
                    
                    //获取产品详情
                    $sale_details	= $this->getProductInfo($list['list']);
                    
					$ids			= array();
					foreach($list['list'] as $key=>&$v){
                        
                            //更新状态销售单ID
							$ids[$v['sale_order_id']]	= $v['sale_order_id'];
                            
                            //格式化值
							$v['city_name']             = 'DPD+'.str_replace(';','-',$v['city_name']);
                            $v['country_id']            = SOnly('country', $v['country_id'], 'abbr_district_name');
                            $v['product_id']            = $sale_details[$v['sale_order_id']];
                            
                            //固定值
                            $v['fixed_value0']          = ' ';
                            $v['fixed_value1']          = 1;
                            $v['fixed_value2']          = 12;
                            $v['address3']              = ' ';
                            $v['address4']              = ' ';
					}
					$this->exportSaleOrderProcess($ids, $list);
                }
                array_unshift($list['list'],array_combine($list['value'],$list['fields']));
                break;
            case 'exportROYALMAILSaleOrder':
                if(isset($list['list'])){
                    //获取产品详情
                    $sale_details	= $this->getProductInfo($list['list']);
                    
					$ids			= array();
                    $royal_mail     = C('ROYAL_MAIL');
					foreach($list['list'] as $key=>&$v){
                        
                            //更新状态销售单ID
							$ids[$v['sale_order_id']]	= $v['sale_order_id'];
                            
                            //格式化值
                            $v['country_id']            = SOnly('country', $v['country_id'], 'abbr_district_name');
                            $v['express_letter0']       = $royal_mail[$v['express_id']][0];
                            if($v['express_id'] == C('UK-48')){
                                $area   = array();
                                preg_match_all('/^([a-z]{1})/i', $v['area'], $area);
                                $v['express_letter1']   = $area[1][0];
                            }else{
                                $v['express_letter1']       = $royal_mail[$v['express_id']][1];
                            }
                            $v['product_id']            = $sale_details[$v['sale_order_id']];
                            $v['is_registered']         = $v['is_registered']==1 ? 'Y': '';
                            $v['is_email']              = empty($v['email']) ? '' : 'EML';
//                            $v['weight']                = WeightGtoKG($v['weight']);
                            
                            //固定值
                            $v['SR1']       = 'SR1';
                            $v['SNE']       = 'SNE';
                            $v['address3']  = '';
                            $v['items']     = '1';
					}
					$this->exportSaleOrderProcess($ids, $list);
                }
                array_unshift($list['list'],array_combine($list['value'],$list['fields']));
                break;
            case 'exportYodelSaleOrder':
                if(isset($list['list'])){
                    //获取产品详情
                    $sale_details	= $this->getProductInfo($list['list']);
                    
					$ids			= array();
					foreach($list['list'] as $key=>&$v){
                            //更新状态销售单ID
							$ids[$v['sale_order_id']]	= $v['sale_order_id'];
                            
                            //格式化值
                            $v['country_id']            = SOnly('country', $v['country_id'], 'abbr_district_name');
                            $v['product_id']            = $sale_details[$v['sale_order_id']];
                            
                            if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                                $v['weight']        = WeightGtoKG($v['volume_weight']);
                            }else {
                                $v['weight']        = WeightGtoKG($v['weight']);
                            }
                            
                            //固定值
                            $v['account_id']    = "\t565469755896";
                            $v['pieces']        = '1';
                            $v['address3']      = '';
					}
					$this->exportSaleOrderProcess($ids, $list);
                }
                array_unshift($list['list'],array_combine($list['value'],$list['fields']));
                break;
            case 'exportFRDPDSaleOrder':
                if(isset($list['list'])){
                    //获取产品详情
                    $sale_details	= $this->getProductInfo($list['list']);
					$ids			= array();
					foreach($list['list'] as $key=>&$v){
                            //更新状态销售单ID
							$ids[$v['sale_order_id']]	= $v['sale_order_id'];
                            $v['country_code']          = SOnly('country', $v['country_id'], 'abbr_district_name');
							$v['product_id']            = $sale_details[$v['sale_order_id']];
                            if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                                $v['weight']        = WeightGtoKG($v['volume_weight']);
                            }else {
                                $v['weight']        = WeightGtoKG($v['weight']);
                            }	

							foreach ($list['value'] as $field) {
								if (!isset($v[$field]))	{
									$v[$field]	= '';
								}
								switch ($field) {
									case 'post_code'://邮政编码
										$length	= 5;
										break;
									case 'landline'://座机号码
									case 'mobile'://电话号码
										$length	= 20;
										break;
									case 'weight':
									case 'country_code':
										$length	= strlen($v[$field]);
										break;
									default :
										$length	= 35;
										break;
								}
								$v[$field]				= $v[$field] ? substr($v[$field], 0, $length) : $v[$field];
							}
					}
					unset($v);
					$this->exportSaleOrderProcess($ids, $list);
                }
                break;
            case 'exportFedexSaleorder':
                if(isset($list['list'])){
                    //获取产品详情
                    $sale_details	= $this->getProductInfo($list['list']);
                    
					$ids			= array();
                    $shipping  = C('FEDEX_SHIPPING');
					foreach($list['list'] as $key=>&$v){
                        
                        //更新状态销售单ID
                        $ids[$v['sale_order_id']]	= $v['sale_order_id'];

                        //格式化值
                        if(!in_array($v['country_id'], array(C('UK_COUNTRY_ID'),C('GB_COUNTRY_ID')))){
                            $v['country_id']        = SOnly('country', $v['country_id'], 'abbr_district_name');
                        }else{
                            $v['country_id']        = '';
                        }
                        $v['express_letter0']       = $shipping[$v['express_id']];
                        $v['product_id']            = $sale_details[$v['sale_order_id']];
                        //固定值
                        $v['address3']  = '';
                        $v['number']  = 1;
                        if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']= WeightGtoKG($v['volume_weight']);
                        } else {
                            $v['weight']= WeightGtoKG($v['weight']);
                        }                         
					}
					$this->exportSaleOrderProcess($ids, $list);
                }
                array_unshift($list['list'],array_combine($list['value'],$list['fields']));
                break;
            case 'exportParcelForceSaleorder':
                if(isset($list['list'])){
                    //获取产品详情
                    $sale_details	= $this->getProductInfo($list['list']);
                    
					$ids			= array();
                    $shipping  = C('PARCEL_FORCE_SHIPPING');
					foreach($list['list'] as $key=>&$v){                       
                        //更新状态销售单ID
                        $ids[$v['sale_order_id']]	= $v['sale_order_id'];
                        //格式化值
                        if(!in_array($v['country_id'], array(C('UK_COUNTRY_ID'),C('GB_COUNTRY_ID')))){
                            $v['country_id']        = SOnly('country', $v['country_id'], 'abbr_district_name');
                        }else{
                            $v['country_id']        = '';
                        }
                        $v['express_letter0']       = $shipping[$v['express_id']];
                        $v['product_id']            = $sale_details[$v['sale_order_id']];
                        //固定值
                        $v['address3']  = '';
					}
					$this->exportSaleOrderProcess($ids, $list);
                }
                array_unshift($list['list'],array_combine($list['value'],$list['fields']));
                break;
            case 'exportITUpsSaleOrder':
				if(isset($list['list'])){       
                    $this->getNewWeight($list['list']);
					$ids	= array();
					foreach($list['list'] as &$v){
                        $ids[$v['sale_order_id']]	  = $v['sale_order_id'];
                        $v['country_shorthand']       = SOnly('country', $v['country_id'], 'abbr_district_name');                     
                        //固定值
                        $v['address3']                = '';//地址3
                        $v['servizio']                = 'ST';//派递种类   
                        $v['tax']                     = '';//付关税方
                        $v['descrizione_merce']       = 'XX';//产品描述  
                        $v['freight']                 = 'SHP';//运费
                        $v['stato_prov']              = '';//州名称（美国与加拿大使用）
                        $v['packages_num']            = '1';//包裹数量
                        $v['tipo-pacco']             = 'CP';//包裹种类
                        $v['insure_price']            = '';//保险金额 
                        if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']= WeightGtoKG($v['volume_weight']);
                        } else {
                            $v['weight']= WeightGtoKG($v['weight']);
                        } 
                        if($v['is_insure']==1){
                            $v['is_insure']='Y';                           
                        }else{
                            $v['is_insure']='N';
                        }
                        if($v['email']!=''){
                            $v['is_email']='Y';                           
                        }else{
                            $v['is_email']='N';
                        }
                    }
                    $this->exportSaleOrderProcess($ids, $list);		
				}
				break;
            case 'exportInternationalFedexSaleOrder':				
				if(isset($list['list'])){ 
                    $this->getNewWeight($list['list']);
					$ids	= array();	
					foreach($list['list'] as &$v){
                        $ids[$v['sale_order_id']]	   = $v['sale_order_id'];
                        $v['country_shorthand']        = SOnly('country', $v['country_id'], 'abbr_district_name');
                        //固定值
                        $v['unit_value']          = '';//物品价值 
                        $v['boxes']               = '1';
                        $v['anzahl_sendungen']    ='1';//包裹数量
                        $v['description']         = '';//特殊描写或要求注意事项
                        if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']= WeightGtoKG($v['volume_weight']);
                        } else {
                            $v['weight']= WeightGtoKG($v['weight']);
                        } 
                        if($v['email']!=''){
                            $v['email_flag']='Y';                           
                        }else{
                            $v['email_flag']='N';
                        }   
                    }
					$this->exportSaleOrderProcess($ids, $list['list']);
				}		
				break;    
            case 'exportMyHemersSaleOrder':
                if(isset($list['list'])){
                    //获取产品详情
                    $sale_details	= $this->getProductInfo($list['list']);                    
					$ids			= array();
					foreach($list['list'] as $key=>&$v){                        
                        //更新状态销售单ID
                        $ids[$v['sale_order_id']]	= $v['sale_order_id'];

                        $v['product_id']            = $sale_details[$v['sale_order_id']];
                        //固定值
                        $v['address3']               = '';
                        $v['address4']               = '';
                        $v['last_name']              = '';
                        $v['compensation']           = '';
                        $v['parcel_value']           = '';
                        $v['delivery_safe_place']    = '';
                        $v['delivery_instructions']  = '';
                        $v['signature']              = ($v['is_registered']==1)?'Y':'N';
                        if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']= WeightGtoKG($v['volume_weight']);
                        } else {
                            $v['weight']= WeightGtoKG($v['weight']);
                        }                         
					}
					$this->exportSaleOrderProcess($ids, $list);
                }
                array_unshift($list['list'],array_combine($list['value'],$list['fields']));
                break;
            case 'exportMondialRelaySaleOrder':
                if(isset($list['list'])){
                    //获取产品详情
                    $sale_details	= $this->getProductData($list['list']);   
					$ids			= array();
					foreach($list['list'] as $key=>&$v){                        
                        //更新状态销售单ID
                        $ids[$v['sale_order_id']]	= $v['sale_order_id'];
                        for($i=0;$i<6;$i++){
                            if(isset($sale_details[$v['sale_order_id']][$i])){
                                $v['product_'.$i]=$sale_details[$v['sale_order_id']][$i];
                            }else{
                                $v['product_'.$i]="";
                            }    
                        }
                        $v['country_shorthand']      = SOnly('country', $v['country_id'], 'abbr_district_name');
                        //固定值
                        $v['mobile2']                      = '';
                        $v['type_livraison']               = 'D';
                        $v['anzahl_sendungen']             = '1';
                        if(in_array($v['express_id'], explode(',',C('EXPRESS_FR-FREIGHT-1_ID')))){
                            $v['mode_de_livraison']        = 'LD1';
                        }
                        if(in_array($v['express_id'], explode(',',C('EXPRESS_FR-FREIGHT-2_ID')))){
                            $v['mode_de_livraison']        = 'LD';
                        }
                        for($i=0;$i<19;$i++){
                            $v['num'.$i]="";
                        }
                        if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']= WeightGtoKG($v['volume_weight'],2,1);
                        } else {
                            $v['weight']= WeightGtoKG($v['weight'],2,1);
                        }                         
					}
					$this->exportSaleOrderProcess($ids, $list);
                }
             break;
			case 'exportGeodisSaleOrder':
				if(isset($list['list'])){
					//获取产品详情
                    $sale_details = $this->getProductInfo($list['list']);
					$ids	= array();
					foreach($list['list'] as &$v){
                        $ids[$v['sale_order_id']]	= $v['sale_order_id'];
						//固定值
						if($v['express_id']==C('EXPRESS_FR-GD-24_ID')){
							$v['factory_name']			= $v['factory_id'];
							$v['code_tiers']			= "492092";
							$v['code_produit_commercial']	= 'CXI';
						}else{
							$v['code_tiers']			= "001292";
							$v['code_produit_commercial']	= 'MES';
						}
                        $v['code_incoterm']				= 'P';
                        $v['type_destinataire']			= 'P';
                        $v['nombre_de_colis']			= '1';
                        $v['option_de_rendez-vous']		= 'W';
                        $v['destinataire']				= '2';
						for ($num = 0; $num < 5; $num++) {
							$v['num' . $num] = '';
						}
						if($v['calculation']==1&&$v['volume_weight']>$v['weight']){
                            $v['weight']        = WeightGtoKG($v['volume_weight']);
                        }else {
                            $v['weight']        = WeightGtoKG($v['weight']);
                        }
						$v['product_id']		= $sale_details[$v['sale_order_id']];
					}
					$this->exportSaleOrderProcess($ids, $list);
				}
				break;
			case 'SaleOrder':	
				if($list['list']){
					$ids = array();
					foreach($list['list'] as $val){
						$ids[] = $val['id'];
					}
					if($ids){
						//销售单列表
						$list			= $this->getOutBySql($_GET['state'],$ids);
						//excel标题及内容字段
						$list['fields']	= $data[$_GET['state']]['title'];
						$list['value']	= $data[$_GET['state']]['content'];
						//销售单明细
						$details		= M('SaleOrderDetail')
											->field('sod.sale_order_id as sale_id,sod.product_id,p.product_no,sum(sod.quantity) as quantity')
											->join('sod left join product p on p.id=sod.product_id')
											->where('sod.sale_order_id in (' . implode(',', $ids) . ')')
											->group('sod.sale_order_id,sod.product_id')
											->select();
						//其他费用明细
						$other_fee_detail	= D('ClientOtherArrearages')->getOtherFeeDetail($ids);
						unset($ids);
						$sale_details	= array();
						$max_count		= 1;//销售单最大产品数
						foreach ($details as $detail) {
							$sale_id	= $detail['sale_id'];
							unset($detail['sale_id']);//不可少
							if (!isset($sale_details[$sale_id])) {
								$sale_details[$sale_id]	= $detail;
							} else {
								$count	= count($sale_details[$sale_id])/count($detail) + 1;
								foreach ($detail as $key => $value) {
									$new_key							= $key . $count;
									$sale_details[$sale_id][$new_key]	= $value;
									if ($count > $max_count) {//扩展标题和字段
										$list['fields'][]	= L($key);
										$list['value'][]	= $new_key;
									}									
								}
								if ($count > $max_count) {//重新标记最大产品数
									$max_count	= $count;								
								}
							}
						}
						unset($details);
						//格式化及赋值产品信息
						foreach($list['list'] as &$val){
                            $val['order_no']        = '="'.$val['order_no'].'"';
                            $val['edml_weight']     = '="'.$val['edml_weight'].'"';
							$val['fmd_order_date']	= '="'.$val['fmd_order_date'].'"';
							$val['fmd_go_date']		= '="'.$val['fmd_go_date'].'"';
							$val['track_no']		= '="'.$val['track_no'].'"';
                            if($val['calculation']==1&&$val['volume_weight']>$val['weight']){
                                $val['edml_volume_weight']      = '="'.$val['edml_volume_weight'].'"';
                             }else {
                                $val['edml_volume_weight']      = " ";
                            }	
							if ($val['delivery_fee_paid_id'] <= 0) {
								$val['delivery_fee']		= $val['expected_delivery_costs'];
								$val['dml_delivery_fee']	=  moneyFormat($val['delivery_fee'],0, C('money_length'));
							}
                            //作废订单不显示款项
                            if($val['sale_order_state'] == C('SALEORDER_OBSOLETE')){
                                $val['dml_delivery_fee']    = 0;
                                $val['dml_insure_price']    = 0;
                            }
							//其他费用明细
							if (isset($other_fee_detail['list'][$val['id']])) {
								$val['other_fee_detail']	= array();
								$other_fee_total			= array();
								foreach ((array)$other_fee_detail['list'][$val['id']] as $other_fee) {
									$val['other_fee_detail'][]	= $other_fee['pay_class_name'] . '(' . $other_fee['currency_no'] . ') ' . $other_fee['dml_other_fee'];
									$other_fee_total[$other_fee['currency_no']]	+= $other_fee['other_fee'];
								}
								$val['other_fee_detail']	= implode(",", $val['other_fee_detail']);
								foreach ($other_fee_total as $currency_no=>$other_fee) {
									$val['other_fee_total'][]	= $currency_no . ':' . moneyFormat($other_fee,0, C('money_length'));
								}
								$val['other_fee_total']		= implode(",", $val['other_fee_total']);
							}
							$val					= array_merge($val, $sale_details[$val['id']]);
						}
						unset($sale_details);
					}
				}
                //added by 20140916 卖家导出EXCEL不显示所属卖家		
                if ($_SESSION["LOGIN_USER"]["role_type"]==C('SELLER_ROLE_TYPE')) {
                        $field_key		= array_search('factory_name', $list['value']);
                        unset($list['value'][$field_key], $list['fields'][$field_key]);				
                }
                //added by 20160714 海外仓操作导出EXCEL不显示费用	
                if (in_array($_SESSION["LOGIN_USER"]["role_id"],explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))) {
                    $filters			= array('dml_delivery_fee','dml_process_fee','dml_package_fee','dml_insure_price');
                    foreach ($filters as $field) {
                        $field_key		= array_search($field, $list['value']);
                        unset($list['value'][$field_key], $list['fields'][$field_key]);					
                    }					     
                }
				break;
            case 'SaleOrderReport':
                if(isset($list['list'])){
                    //获取订单产品总的销售价格:产品数据*销售价格
                    $sale_details	= $this->getProductPrice($list['list']);
					foreach($list['list'] as $key=>&$v){
						$v['codenummer']	= $sale_details[$v['sale_order_id']][$v['product_id']]['hs_code'];
						$v['ursp']			= 'DE';
						$v['country_code']  = SOnly('country', $v['country_id'], 'abbr_district_name');
						$v['post_code2']	= $v['post_code'];
						$v['weight']        = WeightGtoKG($v['weight']);
						$v['weight_unit']	= 'KG';
						$v['size_unit']		= 'MM';
						$v['size_unit2']	= 'MM';
						$v['weight2']		= $v['weight'];
						$v['weight_unit2']	= 'KG';
                        $v['product_price']	= $sale_details[$v['sale_order_id']][$v['product_id']]['sale_price'];
						foreach ($list['value'] as $field) {
							if (!isset($v[$field]))	{
								$v[$field]	= '';
							}
						}
					}
					unset($v);
                }
                break;
            case 'ClientStat':
                $all_total['paid_date']     = '总合计'; 
                foreach ($list as &$val){
					$val['pay_class']       = SOnly('pay_class', $val['pay_class_id'], 'pay_class_name');
					if ($val['income_type']>0) {
						//应付款列表
						if($val['object_type'] == 132){
							$sum_need_paid					-= $val['original_money'] ;
							$val['original_money']			= -$val['need_paid'];
						}else{
							$val['have_paid']			= $val['original_money'];
							$sum_need_paid				-= $val['need_paid'] ;
							$val['need_paid'] = $val['original_money'] = 0;
						}
					}else {
						$sum_need_paid				+= $val['need_paid'];
					}
					$val['sum_need_paid']		= $sum_need_paid;
					$all_total['original_money']    += $val['original_money'];
					$all_total['have_paid']         += $val['have_paid'];
					$all_total['discount_money']    += $val['discount_money'];
					/// 生成备注
					$val = D('AbsStat')->objectTypeCommentSubsidiary($val);
                }
                $list_end   = end($list);
                $all_total['sum_need_paid']         = $list_end['sum_need_paid'];
                $list[]     = $all_total;
                $list               = _formatList($list);
                $list['fields']	= $fields;        
                $list['value']	= $value;
                break;
            //退货入库单拣货单导出        add by lxt 2015.10.09
            case "pikingExport":
                if (isset($list['list'])){
                    foreach ($list['list'] as &$value){
                        if (!trim($value['return_logistics_no']) || is_null($value['return_logistics_no'])){
                            $value['return_logistics_no']   =   " ";
                        }
                        if (!trim($value['return_track_no']) || is_null($value['return_track_no'])){
                            $value['return_track_no']   =   " ";
                        }
                    }
                }
                break;
			default:
				break;
		}
	  	return $list;
	}
                               
	/**
	 * 获取产品数量和产品条码
	 * @author 20141110 yyh
	 * @param array $list
	 * @return array
	 */
	public function getProductInfo($list){ 
		$ids = array();
        foreach ($list as $val) {
            $ids[] = $val['sale_order_id'];
        }
        if ($ids) {
            $details = M('SaleOrderDetail')
                    ->field('sod.sale_order_id as sale_id,if(sum(sod.quantity)>1,concat(sum(sod.quantity),"*",p.custom_barcode),p.custom_barcode) as product')
                    ->join('sod left join product p on p.id=sod.product_id')
                    ->where('sod.sale_order_id in (' . implode(',', $ids) . ')')
                    ->group('sod.sale_order_id,sod.product_id')
                    ->select();
            unset($ids);
            $sale_details = array();
            foreach ($details as $detail) {
                $sale_id = $detail['sale_id'];
                unset($detail['sale_id']); //不可少
                if (!isset($sale_details[$sale_id])) {
                    $sale_details[$sale_id] = $detail['product'];
                } else {
                    $sale_details[$sale_id] .= '-' . $detail['product'];
                }
            }
        }
        unset($details);
        return $sale_details;
    }

	public function getOutBySql($module,$ids){
		$sql = '';
		if($module=='SaleOrder'){
			$funds_class		= array(
										'deliveryFee', //派送费用-应收款 (基本价格【+挂号费】【+订单总公斤数*每公斤增加价格】)【*卖家派送折扣(派送类型为快递)】
										'processFee', //处理费用-应收款 (处理费用【+(产品数-1)*增加数量费用】)【*卖家处理费用折扣】
										'packageFee', //包装费用-应收款 包装费用【*卖家包装费用折扣】
									);
			$sys_pay_class		= C('SYS_PAY_CLASS');
			$funds_left_join	= '';
			$funds_fields		= '';
			foreach ($funds_class as $class) {
				$funds_left_join	.= ' left join client_paid_detail ' . $class . ' on ' . $class . '.object_id=a.id and ' . $class . '.object_type=120 and ' . $class . '.pay_class_id=' . intval($sys_pay_class[$class]) . ' ';
				$field_name			 = strtolower(preg_replace('/([A-Z])/', '_\1', $class));
				$funds_fields		.= ', ' . $class . '.should_paid as ' . $field_name . ', ' . $class . '.paid_id as ' . $field_name . '_paid_id';
			}			
				$sql = 'select a.insure_price,a.express_id as ship_id,if(isnull(p.weight),a.weight,a.weight+p.weight) as weight,if(isnull(p.weight),a.volume_weight,a.volume_weight+p.weight) as volume_weight,a.factory_id,a.id,a.sale_order_no,a.order_no,a.package_id,a.client_id,b.comp_name as client_name,b.comp_no as client_no,b.email as comp_email,a.order_date,date(a.send_date) as go_date,a.sale_order_state,a.order_type,a.track_no,c.country_name,
					a.warehouse_id,c.consignee,c.post_code,d.calculation,(f.price+if(is_registered=1,1,0)*f.registration_fee+' . step_price_calculate(true) . ')*if(ed.express_discount>0 && d.shipping_type in (' . implode(',',C('SHIPPING_TYPE_EXPRESS')) . '),ed.express_discount,1) as expected_delivery_costs' . $funds_fields . '
					from sale_order a 
					left join client b on b.id=a.client_id
					INNER JOIN sale_order_addition c ON a.id = c.sale_order_id 
					left join company e on a.factory_id=e.id
					left join express_detail f on f.id=a.express_detail_id
					left join express d on d.id=f.express_id
					left join express_discount ed on ed.factory_id=a.factory_id and ed.warehouse_id=a.warehouse_id
					left join package p on p.id=a.package_id
					' .  $funds_left_join . '
					where a.id in ( '.implode(',',$ids).' ) 
					group by a.id order by a.id desc';
		}
		return _formatList($this->db->query($sql));	
	}

	public function addStrReplace($v){
		$v['address']	= str_replace('；','-',str_replace(';','-',str_replace('°', '', $v['address'])));
		$v['address2']	= str_replace('；','-',str_replace(';','-',str_replace('°', '', $v['address2'])));
		$find =array(';','；');
		$replace=' ';
		$v['city_name'] = str_replace($find,$replace,$v['city_name']);
		$v['company_name']	= str_replace($find,$replace,$v['company_name']);
		$v['consignee']	= str_replace($find,$replace,$v['consignee']);
		$v['client_email']	= str_replace($find,$replace,$v['client_email']);
		$v['post_code']	= str_replace($find,$replace,$v['post_code']);
		$v['mobile']	= str_replace($find,$replace,$v['mobile']);
		$v['email']     = str_replace($find,$replace,$v['email']);
		return $v;

	}

	/**
	* 订单导出后续处理
	* @param type $ids
	* @param type $list
	*/
	public function exportSaleOrderProcess(&$ids, &$list){
		$this->filterExpressApiSaleOrder($ids, $list);
		D('SaleOrder')->updateSaleOrderStateById($ids, C('SALE_ORDER_STATE_EXPORTING'),L('track_order'));
	}

	/**
	 * 过滤快递API订单
	 * @param array $ids
	 * @param array $list
	 */
	public function filterExpressApiSaleOrder(&$ids, &$list){
		$express_list	= array(
			'DHL',
			'CORREOS',
			'GLS',
		);
		foreach ($express_list as $express_type) {
			if (empty($ids)) break;
			$filter_ids	= express_api_sale_order_id($express_type, $ids);
			if($express_type == 'GLS'){// GLS 瑞士特殊处理
				$filter_gls_ids	= D('Gls')->filterGlsSaleOrder($ids);
				foreach ($filter_ids as $k=>$v){
					if(!in_array($v, $filter_gls_ids)){
						unset($filter_ids[$k]);
					}
				}
			}
			if (!empty($filter_ids)) {
				foreach ($list['list'] as $key => $val) {
					if ($val['sale_order_id'] > C($express_type . '_SALE_ORDER_ID_LOWER_LIMIT') && in_array($val['sale_order_id'], $filter_ids)) {
						unset($list['list'][$key], $ids[$val['sale_order_id']]);
					}
				}
			}
		}
	}

    /**
	 * 获取最新的订单重量和订单的产品总数量,产品条码
	 * @param array $ids
	 * @param array $list
	 */
	public function getNewWeight(&$list){
        $ids = array();
        foreach ($list as $val) {
            $ids[] = $val['sale_order_id'];
        }
        if ($ids) {
             //取订单明细产品数量
			$details				= M('SaleOrderDetail')
										->field('sod.sale_order_id as sale_id,sod.product_id,p.custom_barcode,sum(sod.quantity) as quantity')
										->join('sod left join product p on p.id=sod.product_id')
										->where('sod.sale_order_id in (' . implode(',', $ids) . ')')
										->group('sod.sale_order_id,sod.product_id')
										->select();
            foreach ($details as $detail) {
                $sale_details[$detail['sale_id']]['quantity']+=$detail['quantity'];
                $product_detail_info[$detail['product_id']]=array('product_id'=>$detail['product_id']);
                $product_id_arr[$detail['sale_id']]['detail'][] = array('product_id'=>$detail['product_id'],'quantity'=>$detail['quantity']);
                if (!isset($sale_product_id[$detail['sale_id']])) {
                    $sale_product_id[$detail['sale_id']] = $detail['custom_barcode'];
                } else {
                    $sale_product_id[$detail['sale_id']] .= '-' . $detail['custom_barcode'];
                }                     
            }
            $product_list   = D('SaleOrder')->getProductInfo($product_detail_info);
            foreach($product_id_arr as &$data){
				$data           = D('SaleOrder')->getTotalWeightCube($product_list,$data);
            }
            unset($details);
            //获取最新的订单重量和订单产品总数量,产品条码
            foreach($list as &$val){
                $val['weight']             = $product_id_arr[$val['sale_order_id']]['detail_total']['weight'];
                $val['volume_weight']      = $product_id_arr[$val['sale_order_id']]['volume_weight'];
                $val['unit_quantity']      = $sale_details[$val['sale_order_id']]['quantity'];
                $val['product_id']         = $sale_product_id[$val['sale_order_id']];
            }
        }
	}
    /**
	 * 获取产品产品条码*数量-产品名称
	 * @param array $list
	 * @return array
	 */
	public function getProductData($list){ 
		$ids = array();
        foreach ($list as $val) {
            $ids[] = $val['sale_order_id'];
        }
        if ($ids) {
            $details = M('SaleOrderDetail')
                    ->field('sod.sale_order_id as sale_id,concat(p.custom_barcode,"*",sum(sod.quantity),"-",p.product_name) as product')
                    ->join('sod left join product p on p.id=sod.product_id')
                    ->where('sod.sale_order_id in (' . implode(',', $ids) . ')')
                    ->group('sod.sale_order_id,sod.product_id')
                    ->select();
            unset($ids);
            $sale_details = array();
            foreach ($details as  $detail) {
                $sale_id = $detail['sale_id'];
                unset($detail['sale_id']); //不可少
                $sale_details[$sale_id][] = $detail['product'];
            }          
        }
        unset($details);
        return $sale_details;
    }
     /**
	 * 获取订单产品销售价格和HS_CODE
	 * @param array $list
	 * @return array
	 */
	public function getProductPrice($list){ 
		$ids = array();
        foreach ($list as $val) {
            $ids[] = $val['sale_order_id'];
        }
        if ($ids) {
            $details = M('SaleOrderDetail')
                    ->field('sod.sale_order_id as sale_id,sod.product_id,sod.quantity,d.properties_id,d.value')
                    ->join('sod left join product p on p.id=sod.product_id')
                    ->join('left join product_detail d on p.id=d.product_id')
                    ->where('sod.sale_order_id in (' . implode(',', $ids) . ')  and d.properties_id in('.C('SALE_PRICE').','.C('HS_CODE').')')
                    ->select();
            unset($ids);
            $sale_details = array();
            foreach ($details as $detail) {
                if(empty($detail['value'])&&$detail['properties_id']==C('SALE_PRICE')){
                    $detail['value']= 0;
                }
                if($detail['properties_id']==C('SALE_PRICE')){
                    $sale_details[$detail['sale_id']][$detail['product_id']]['sale_price'] +=$detail['quantity']*$detail['value'];
                }
                if($detail['properties_id']==C('HS_CODE')){
                    $sale_details[$detail['sale_id']][$detail['product_id']]['hs_code']     =$detail['value'];
                }  
            }
        }
        unset($details);
        return $sale_details;
    }
}
?>