<?php
/**
 * Excel导入处理类
 * @copyright   2012 展联软件友拓通
 * @category   	Excel导入处理类
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1
 */
class AbsExcelPublicModel extends RelationCommonModel  {

	public $function_model	=	array();
	public $newModel		=	array();
	public $excel_max_row	=	1001;
	public $insert_type		=	1;
	
    //条码错误的产品ID
    public $error_product   = array();
    // 默认列表每页显示行数
    public $listRows		= 50;
    // 起始行数
    public $firstRow	;
    public $sameRow;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    //导入订单数据
    protected $execlSaleOrder = array(
        'sale_order' => array(
            'order_no',
            'order_date',
            'order_type',
            'comments',
            'warehouse_id',
            'express_id',
            'is_registered',
            'aliexpress_token',
            'is_insure',
        ),
        'sale_order_addition'   => array(
            'comp_name',
            'factory_id',
            'comp_type',
            'consignee',
            'address',
            'address2',
            'company_name',
            'city_name',
            'post_code',
            'country_name',
            'country_id',
            'email',
            'mobile',
            'tax_no',
        ),
        'sale_order_detail' => array(
            'product_id',
            'quantity',
            'warehouse_id',
        )
    );
    //导入模版
	protected $execlField    =   array(
        'SaleOrderImport'       =>array(
            'order_no'      => array('column'=>0,'type'=>'excel_import_filter'),
            'comp_name'     => array('column'=>1,'type'=>'excel_import_filter'),
            'order_date'    => array('column'=>2,'type'=>'excel_import_filter'),
            'order_type'    => array('column'=>3,'type'=>'intval'),
            'warehouse_id'  => array('column'=>4,'type'=>'excel_import_filter'),
            'express_id'    => array('column'=>5,'type'=>'excel_import_filter'),
            'is_registered' => array('column'=>6,'type'=>'intval'),
            'consignee'     => array('column'=>7,'type'=>'excel_import_filter'),
            'address'       => array('column'=>8,'type'=>'excel_import_filter'),
            'address2'      => array('column'=>9,'type'=>'excel_import_filter'),
            'company_name'  => array('column'=>10,'type'=>'excel_import_filter'),
            'city_name'     => array('column'=>11,'type'=>'excel_import_filter'),
            'post_code'     => array('column'=>12,'type'=>'excel_import_filter'),
            'country_name'  => array('column'=>13,'type'=>'excel_import_filter'),
            'country_id'    => array('column'=>14,'type'=>'excel_import_filter'),
            'email'         => array('column'=>15,'type'=>'excel_import_filter'),
            'mobile'        => array('column'=>16,'type'=>'excel_import_filter'),
            'tax_no'        => array('column'=>17,'type'=>'excel_import_filter'),
            'is_insure'     => array('column'=>18,'type'=>'intval'),
        ),
        'ECPPSaleOrderImport'   =>array(            
            'order_no'      => array('column'=>2,'type'=>'excel_import_filter'),
            'comp_name'     => array('column'=>14,'type'=>'excel_import_filter'),
            'order_date'    => array('column'=>1,'type'=>'excel_import_filter'),
            'product_no'    => array('column'=>3,'type'=>'excel_import_filter'),
            'quantity'      => array('column'=>4,'type'=>'intval'),
            'order_type'    => array('column'=>38,'type'=>'excel_import_filter'),
            'warehouse_id'  => array('column'=>39,'type'=>'excel_import_filter'),
            'express_id'    => array('column'=>25,'type'=>'excel_import_filter'),
            'is_registered' => array('column'=>40,'type'=>'intval'),
            'consignee'     => array('column'=>15,'type'=>'excel_import_filter'),
            'address'       => array('column'=>16,'type'=>'excel_import_filter'),
            'address2'      => array('column'=>17,'type'=>'excel_import_filter'),
            'company_name'  => array('column'=>18,'type'=>'excel_import_filter'),
            'city_name'     => array('column'=>19,'type'=>'excel_import_filter'),
            'post_code'     => array('column'=>20,'type'=>'excel_import_filter'),
            'country_name'  => array('column'=>21,'type'=>'excel_import_filter'),
            'country_id'    => array('column'=>22,'type'=>'excel_import_filter'),
            'email'         => array('column'=>24,'type'=>'excel_import_filter'),
            'mobile'        => array('column'=>23,'type'=>'excel_import_filter'),
            'comments'      => array('column'=>10,'type'=>'excel_import_filter'),
            'is_insure'     => array('column'=>41,'type'=>'intval'),
        ),
	    //速卖通      add by lxt 2015.07.22
	    'PayPalSaleOrderImport'    =>  array(
	        'order_no'         =>  array('column'=>0,'type'=>'excel_import_filter'),
	        'product_info'     =>  array('column'=>1,'type'=>'excel_import_filter'),
	        'address'          =>  array('column'=>2,'type'=>'excel_import_filter'),
	        'consignee'        =>  array('column'=>3,'type'=>'excel_import_filter'),
	        'country_name'     =>  array('column'=>4,'type'=>'excel_import_filter'),
	        'company_name'     =>  array('column'=>5,'type'=>'excel_import_filter'),
	        'city_name'        =>  array('column'=>6,'type'=>'excel_import_filter'),
	        'address_useless'  =>  array('column'=>7,'type'=>'excel_import_filter'),
	        'post_code'        =>  array('column'=>8,'type'=>'excel_import_filter'),
	        'mobile'           =>  array('column'=>9,'type'=>'excel_import_filter'),
	        'cellphone'        =>  array('column'=>10,'type'=>'excel_import_filter'),
	        'order_date'       =>  array('column'=>11,'type'=>'excel_import_filter'),
	        'comp_name'        =>  array('column'=>12,'type'=>'excel_import_filter'),
	        'order_type'       =>  array('column'=>13,'type'=>'intval'),
	        'warehouse_id'     =>  array('column'=>14,'type'=>'excel_import_filter'),
	        'express_id'       =>  array('column'=>15,'type'=>'excel_import_filter'),
	        'is_registered'    =>  array('column'=>16,'type'=>'intval'),
	        'country_id'       =>  array('column'=>17,'type'=>'excel_import_filter'),
	        'email'            =>  array('column'=>18,'type'=>'excel_import_filter'),
	        'tax_no'           =>  array('column'=>19,'type'=>'excel_import_filter'),
            'aliexpress_token' =>  array('column'=>20,'type'=>'excel_import_filter'),
            'is_insure'         => array('column'=>21,'type'=>'intval'),
	        'product_no'       =>  array('column'=>22,'type'=>'excel_import_filter'),
	        'quantity'         =>  array('column'=>23,'type'=>'intval'),
	    ),
        
    );

	public function __construct($name = '', $tablePrefix = '', $connection = '') {
		parent::__construct($name, $tablePrefix, $connection);
		set_time_limit(0);
		ini_set('memory_limit', '512M');
	}

    /**
	 * 国家插入前的规则验证
	 *
	 * @param array $date
	 * @return bool
	 */
	public function beforValidDistrict(&$date,&$replace,&$excel){
		if (!is_array($date)){  return $this->setExcelErrorMsg(0,'没有数据,请重新操作');}  
		foreach((array)$date as $key=>$value){ if (empty($value[0])){   return $this->setExcelErrorMsg(0,'国家名称必填,请重新操作'); }		} 
		return true;
	} 
	 
	
	/**
	 * 产品库存验证
	 *
	 * @param  array $date
	 * @param  array $replace
	 * @return string
	 */
	public function validStockProduct(&$date,&$replace){ 
		if (!is_array($date)){
			return $this->setExcelErrorMsg(0,'没有数据,请重新操作'); 
		}   
		$model	=	M('Product');
		$modelC	=	M('product_color');
		$modelS	=	M('product_size');   
		foreach((array)$date as $key=>$value){    
//				echo $model->getLastSql(); 
				if ($value['product_id']<=0){ 
					$msg	=	'第'.$key.'行,产品"'.$value['product_no'].'"不存在,请重新操作';
					return $this->setExcelErrorMsg(0,$msg);  
				} 
				if (array_key_exists('color_id',$value)){
					$modelCValue	=	$modelC->where('product_id='.$value['product_id'].' and color_id='.$value['color_id'].'')->find();
					if (!is_array($modelCValue)){ 
						$msg			=	'第'.$key.'行,颜色"'.$value['color_name'].'"不存在于产品"'.$value['product_no'].'"中,请重新操作';
						return $this->setExcelErrorMsg(0,$msg);  
					} 
				} 
				if (array_key_exists('size_id',$value)){
					$modelSValue	=	$modelS->where('product_id='.$value['product_id'].' and size_id='.$value['size_id'])->find(); 
					if (!is_array($modelSValue)){ 
						$msg			=	'第'.$key.'行,尺码"'.$value['size_name'].'"不存在于产品"'.$value['product_no'].'"中,请重新操作';
						return $this->setExcelErrorMsg(0,$msg);   
					}
				}
				unset($modelSValue);
				unset($modelCValue);  
		}  
		return NULL;
	}
	
	 
	/**
	 * 导入产品预先验证规则
	 *
	 * @param array $date
	 * @param array $replace
	 * @param array $excel
	 * @return string
	 */
	public function beforValidProduct(&$date,&$replace,&$excel){
 
		///获取当前系统类别
		$findClassNameFieldNumber	=	array_search('class_name',$excel['field']); /// $key = 2; 
		$product_class_level		=	C('product_class_level');///当前系统产品级别
		$product_class				=	M('product_class');
		foreach((array)$date as $key=>$value){    
			$class_array	=	explode(',',$value[$findClassNameFieldNumber]);
			$class_array 	= 	array_diff($class_array, array(null));   ///过滤掉数组为空的数据
			if (count($class_array)!=$product_class_level){ 
				return $this->setExcelErrorMsg(0,'第'.$key.'行,数据错误请修改'); 
			}  
			///判断产品类别上下之间的关系是否正确
			if ($product_class_level>1){
				$top_class_id	=	0;	 
				///验证所有类别是否都是历史存在的还是需要新插入的
				foreach((array)$class_array as $keyc=>$valuec){  
					///判断当前类别是否已存在 
					$where			=	' class_name=\''.$valuec.'\' ';
					$info			=	$product_class->where($where)->find(); 
					///判断本级的上一级的ID是否与历史中的相符！ 如果不相同报错！
					if ($top_class_id>0 && is_array($info)){ 
						if ($info['parent_id']!=$top_class_id){
							return $this->setExcelErrorMsg(0,'第'.$key.'行,产品类别级别有误,数据错误请修改');  
						}
					} 
					if (is_array($info)){
						$top_class_id	=	$info['id']; 
					}else {
						$top_class_id	=	0; 
					} 
				}  
			}
		}
		return null; 
	}
	
	/**
	 * 员工
	 *
	 * @param array $insert_list
	 * @param object $validModel
	 */
	public function beforEmployee(&$insert_list,&$validModel){ 
		foreach((array)$insert_list as $key=>$value){    
			$insert_list[$key]['sex']			=	$value['sex']=='男'?1:2;
			$insert_list[$key]['department_id']	=	empty($value['department_name'])?0:$value['department_id']; 
			$insert_list[$key]['position_id']	=	empty($value['position_name'])?0:$value['position_id']; 
		}	 
	}
	
	/**
	 * 客户
	 *
	 * @param array $insert_list
	 * @param object $validModel
	 */
	public function beforClient(&$insert_list,&$validModel){
		foreach((array)$insert_list as $key=>$value){    
			$insert_list[$key]['remind_day']	=	empty($value['remind_day'])?0:$value['remind_day'];
			$insert_list[$key]['credit']		=	empty($value['credit'])?0:$value['credit'];
			$insert_list[$key]['contact']		=	empty($value['contact'])?'':$value['contact'];
			$insert_list[$key]['mobile']		=	empty($value['mobile'])?'':$value['mobile']; 
			$insert_list[$key]['address']		=	empty($value['address'])?'':$value['address']; 
		}
	}
	
	/**
	 * 厂家
	 *
	 * @param array $insert_list
	 * @param object $validModel
	 */
	public function beforFactory(&$insert_list,&$validModel){
		foreach((array)$insert_list as $key=>$value){    
			$insert_list[$key]['remind_day']	=	empty($value['remind_day'])?0:$value['remind_day'];
			$insert_list[$key]['credit']		=	empty($value['credit'])?0:$value['credit'];
			$insert_list[$key]['contact']		=	empty($value['contact'])?'':$value['contact'];
			$insert_list[$key]['mobile']		=	empty($value['mobile'])?'':$value['mobile']; 
			$insert_list[$key]['address']		=	empty($value['address'])?'':$value['address']; 
		}
	}
	
	/**
	 * 其他公司
	 *
	 * @param array $insert_list
	 * @param object $validModel
	 */
	public function beforOtherCompany(&$insert_list,&$validModel){
		foreach((array)$insert_list as $key=>$value){    
			$insert_list[$key]['remind_day']	=	empty($value['remind_day'])?0:$value['remind_day'];
			$insert_list[$key]['credit']		=	empty($value['credit'])?0:$value['credit'];
			$insert_list[$key]['contact']		=	empty($value['contact'])?'':$value['contact'];
			$insert_list[$key]['mobile']		=	empty($value['mobile'])?'':$value['mobile']; 
			$insert_list[$key]['address']		=	empty($value['address'])?'':$value['address']; 
		}
	} 
	
	/**
	 * 初始化库存主表信息
	 *
	 * @return unknown
	 */
	public function beforInistock(&$insert_list,&$class_form_validate){
		$model			=	M('InitStorage');
		///仓库ID
		$wInfo			=	M('warehouse')->where('is_default=1')->field('id')->find();  
		$default_w_id	=	$wInfo['id'];  
		if ($default_w_id<=0){ 
			return $this->setExcelErrorMsg(0,'请设置默认仓库,在重新导入数据');
		} 
		///验证产品规格是否符合要求 
		$copy	=	$insert_list; 
		$fruit  = 	array_shift($copy); 
		unset($copy);  
		if (array_key_exists('size_id',$fruit) || array_key_exists('color_id',$fruit)){ 
			$rinfo					=	$this->validStockProduct($insert_list);      
			if (is_array($rinfo) && $rinfo['type']==false){	return $this->setExcelErrorMsg(0,$rinfo['msg']);}
		} 
		$insert	=	array(
							'init_storage_no'		=>'',
							'init_storage_date'		=>date("Y-m-d"),
							'warehouse_id'			=>$default_w_id,
							'currency_id'			=>C('currency'),
							'create_time'			=>date("Y-m-d H:i:s"),
		);  
		$id	=	$model->add($insert); 
		 if ($id==false){ 
	  				return $this->setExcelErrorMsg(0,'主表插入错误,请重新导入'); 
		 }  
		foreach((array)$insert_list as $key=>$value){   
		 	$insert_list[$key]['init_storage_id']	=	$id;
		 	$insert_list[$key]['mantissa']			=	$value['quantity_state']=='是'?2:1;
		} 
		///验证
		$validInfo['detail']	=	$insert_list;
		$validInfo				=	array_merge($insert,$validInfo);  
		$r						= 	$class_form_validate->create($validInfo);				/// 调用验证方法   
		if (!$r) {     
			/// 验证失败      
			return $class_form_validate->error; 
		} else {     
			///验证业务规则 
			$info=	$this->excelBrf('InitStorage','insert',$validInfo); 
			///验证成功	  
			return $insert;
		} 
	}
	
	/**
	 * 盘点导入主表信息
	 *
	 * @return unknown
	 */
	public function beforStocktake(&$insert_list,&$class_form_validate){ 
		$model 			= M('stocktake');
		///仓库ID
		$wInfo			= M('warehouse')->where('is_default=1')->field('id')->find();
		$default_w_id	= $wInfo['id'];   
		if ($default_w_id<=0){ return $this->setExcelErrorMsg(0,'请设置默认仓库,在重新导入数据'); } 
		///验证产品规格是否符合要求 
		$copy	=	$insert_list; 
		$fruit  = 	array_shift($copy); 
		unset($copy);  
		if (array_key_exists('size_id',$fruit) || array_key_exists('color_id',$fruit)){ 
			$rinfo					=	$this->validStockProduct($insert_list);   
			if (is_array($rinfo) && $rinfo['type']==false){	return $this->setExcelErrorMsg(0,$rinfo['msg']);}  
		}   
		$insert	= array( 		'stocktake_no'			=>'',
								'stocktake_date'		=> date("Y-m-d"),
								'warehouse_id'			=> $default_w_id,
								'currency_id'			=> C('currency'),
								'employee_id'			=> 0,
								'state'					=> 1,
								'create_time'			=> date("Y-m-d H:i:s"), );
		$id	=	$model->add($insert); 
		if ($id==false){ 
	  		return $this->setExcelErrorMsg(0,'主表插入错误,请重新导入'); 
		}  
		foreach((array)$insert_list as $key=>$value){   
		 	$insert_list[$key]['stocktake_id']	=	$id;
		 	$insert_list[$key]['mantissa']			=	$value['quantity_state']=='是'?2:1;
		} 
		///验证
		$validInfo['detail']	=	$insert_list;
		$validInfo				=	array_merge($insert,$validInfo);  
		$r						= 	$class_form_validate->create($validInfo);				/// 调用验证方法   
		if (!$r) {     
			/// 验证失败      
			return $class_form_validate->error; 
		} else {     
			///验证业务规则 
			$info=	$this->excelBrf('Stocktake','insert',$validInfo); 
			///验证成功	  
			return $insert;
		} 
	} 
	
	/**
	 * 业务规则验证
	 *
	 * @param object $m model
	 * @param object $a action
	 * @param array $insert insert info
	 */
	public function excelBrf($m,$a,&$insert){ 
		/// 业务规则检查
        $all_tags 	 	= C('extends');
        $action_tag_name = $m.'^'.$a;   
        if (isset($all_tags[$action_tag_name])) {
        	/// 添加关联类的模块信息
			$insert['_module'] = $m;
			$insert['_action'] = $a;
        	tag($action_tag_name,$insert);
        } 
	}
	
	
	/**
	 * 客户期初款项
	 *
	 * @param array $insert_list
	 * @param object $validModel
	 */
	public function beforFundclient(&$insert_list,&$validModel){  
		$valid	=	array();
		$model	=	M('client_paid_detail');  
		foreach((array)$insert_list as $key=>$value){   
			if ($value['comp_id']>0 && $value['currency_id']>0){  
				if (isset($valid[$value['comp_id']][$value['currency_id']])){  
	       			$msg	=	'第'.$key.'行,'.$value['client_name'].' 币种 '.$value['currency_name'].'重复,请重新操作';
	       			return $this->setExcelErrorMsg(0,$msg); 
				}	
				$where	=	array(
									'comp_id'=>' comp_id= '.$value['comp_id'], 
									'currency_id'=>' currency_id= '.$value['currency_id'], 
				);
				$historyInfo	=		$model->where('object_type=101 and '.join(' and ',$where))->find(); 
				if (is_array($historyInfo)){
					$msg = '第'.$key.'行,'.$value['client_name'].' '.$value['currency_name'].'已存在历史记录,请重新操作';
					return $this->setExcelErrorMsg(0,$msg);  
				} 			
			}
			$valid[$value['comp_id']][$value['currency_id']]	=	true; 
		 	$insert_list[$key]['befor_currency_id']	=	$value['currency_id'];
		 	$insert_list[$key]['base_money']		=	$value['money'];
		}   
	}
	
	
	
	/**
	 * 客户期初款项
	 *
	 * @param array $insert_list
	 */
	public function beforFundfactory(&$insert_list){ 
		$basic_info	=	M('basic')->where('is_basic=1')->find(); 
		$basic_id	=	$basic_info['id']; 
		$valid	=	array();
		$model	=	M('factory_paid_detail');
		foreach((array)$insert_list as $key=>$value){   
			if ($value['comp_id']>0 && $value['currency_id']>0){ 
				if (isset($valid[$value['comp_id']][$value['currency_id']])){  
		       			$msg	=	'第'.$key.'行,'.$value['comp_name'].' 币种 '.$value['currency_name'].'重复,请重新操作';
		       			return $this->setExcelErrorMsg(0,$msg);   
				}	
				$where	=	array( 	'comp_id'=>' comp_id= '.$value['comp_id'], 
									'currency_id'=>' currency_id= '.$value['currency_id'],);
				$historyInfo	= $model->where('object_type=201 and '.join(' and ',$where))->find(); 
				if (is_array($historyInfo)){ 
		       			$msg	=	'第'.$key.'行,'.$value['comp_name'].' '.$value['currency_name'].'已存在历史记录,请重新操作';
		       			return $this->setExcelErrorMsg(0,$msg);  
				} 			
			} 
		 	$insert_list[$key]['befor_currency_id']	=	$value['currency_id'];
		 	$insert_list[$key]['base_money']		=	$value['money'];
		 	$insert_list[$key]['basic_id']			=	$basic_id;
		 	$valid[$value['comp_id']][$value['currency_id']]	=	true;
		} 
	} 
	
	/**
	 * 导入产品后关联操作after
	 *
	 * @param array $info
	 */
	public function afterProduct(&$info){
		///插入颜色
		$modelProductColor	=	M('ProductColor'); 
		$modelProductSize	=	M('ProductSize');   
		$modelProductPrice	=	M('product_price');
		$modelProductFit	=	M('product_fit');
		$modelProductDetail	=	M('product_detail');   
		$modelProduct		=	M('product');   
		$modelProductClassInfo		=	M('product_class_info');  
		$barcode			=	D('Barcode');
		foreach((array)$info['insert'] as $key=>$value){    
			$modelProductColor->where('product_id='.$value)->delete(); 
			$modelProductSize->where('product_id='.$value)->delete(); 
			$modelProductPrice->where('product_id='.$value)->delete();
			$modelProductFit->where('product_id='.$value)->delete();
			$modelProductDetail->where('product_id='.$value)->delete();    
			$modelProductClassInfo->where('product_id='.$value)->delete();    
			///类别
			$class_id	=	$modelProduct->where('id='.$value)->getField('product_class_id');    
			if ($class_id>0){ 
				///类别  
				$product_class_info	=	array('product_id'=>$value);
				$product_class_info	=	array_merge($product_class_info,$this->getProductClassInfo($class_id)); 
				$modelProductClassInfo->add($product_class_info);  
				unset($product_class_info);
			} 
			///插入颜色
			foreach((array)$info['detail']['color_name'][$key] as $kc=>$vc){   
				$colorInsert	=	array(	'product_id'=>$value,
											'color_id'=>$vc['id'], );  
				$modelProductColor->add($colorInsert); 
				unset($colorInsert);
			}
			///product_size 
			foreach((array)$info['detail']['size_name'][$key] as $ks=>$vs){   
				$sizeInsert	=	array( 		'product_id'=>$value,
											'size_id'=>$vs['id'],); 
				$modelProductSize->add($sizeInsert); 
				unset($sizeInsert);
			}
			//product_price
			$priceInsert	=	array( 	'product_id'=>$value,);
			$modelProductPrice->add($priceInsert); 
			unset($priceInsert);
			
			//product_detail
			$detailInsert	=	array( 	'product_id'=>$value,
										'properties_id'=>1,);
			$modelProductDetail->add($detailInsert); 
			unset($detailInsert);
			
			//product_fit
			$fitInsert	=	array(  'product_id'=>$value,
									'fit'=>'{&quot;1&quot;:{&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&quot;,&quot;6&quot;:&quot;&quot;,&quot;7&quot;:&quot;&quot;,&quot;8&quot;:&quot;&quot;},&quot;2&quot;:{&quot;1&quot;:&quot;&quot;,&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&quot;,&quot;6&quot;:&quot;&quot;,&quot;7&quot;:&quot;&quot;,&quot;8&quot;:&quot;&quot;},&quot;3&quot;:{&quot;1&quot;:&quot;&quot;,&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&quot;,&quot;6&quot;:&quot;&quot;,&quot;7&quot;:&quot;&quot;,&quot;8&quot;:&quot;&quot;},&quot;4&quot;:{&quot;1&quot;:&quot;&quot;,&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&quot;,&quot;6&quot;:&quot;&quot;,&quot;7&quot;:&quot;&quot;,&quot;8&quot;:&quot;&quot;},&quot;5&quot;:{&quot;1&quot;:&quot;&quot;,&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&quot;,&quot;6&quot;:&quot;&quot;,&quot;7&quot;:&quot;&quot;,&quot;8&quot;:&quot;&quot;},&quot;6&quot;:{&quot;1&quot;:&quot;&quot;,&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&quot;,&quot;6&quot;:&quot;&quot;,&quot;7&quot;:&quot;&quot;,&quot;8&quot;:&quot;&quot;},&quot;7&quot;:{&quot;1&quot;:&quot;&quot;,&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&quot;,&quot;6&quot;:&quot;&quot;,&quot;7&quot;:&quot;&quot;,&quot;8&quot;:&quot;&quot;}}',
			); 
			$modelProductFit->add($fitInsert); 
			unset($fitInsert);
			///条形码
			$barcode->addBarcode($value);//生成条形码 
		}
		
	} 
	
	public  function getProductClassInfo($product_class_id) {
		$info = array();
		if (C('PRODUCT_CLASS_LEVEL')==1) {
			$info['class_1'] = $product_class_id;
		}elseif (C('PRODUCT_CLASS_LEVEL')==2) {
			$info['class_2'] = $product_class_id;
			$temp = M('ProductClass')->field('parent_id')->where($product_class_id)->find(); 
			$info['class_1'] = $temp['parent_id'];
		}elseif (C('PRODUCT_CLASS_LEVEL')==3) {
			$info['class_3'] = $product_class_id;
			$temp = M('ProductClass')->field('parent_id')->where($product_class_id)->find();
			$info['class_2'] = $temp['parent_id'];
			$temp = M('ProductClass')->field('parent_id')->where($temp['parent_id'])->find();
			$info['class_1'] = $temp['parent_id'];
		}elseif (C('PRODUCT_CLASS_LEVEL')==4) {
			$info['class_4'] = $product_class_id;
			$temp = M('ProductClass')->field('parent_id')->where($product_class_id)->find();
			$info['class_3'] = $temp['parent_id'];
			$temp = M('ProductClass')->field('parent_id')->where($temp['parent_id'])->find();
			$info['class_2'] = $temp['parent_id'];
			$temp = M('ProductClass')->field('parent_id')->where($temp['parent_id'])->find();
			$info['class_1'] = $temp['parent_id'];
		}
		return $info;
	}
	
	/**
	 * 返回类型对应的字段
	 *
	 * @param int $type 导入类型
	 * @return array
	 */
	public function getExcelFields($type){ 
		$ExcelTemplete	=	include(RUNTIME_PATH.'~ExcelTemplete.php'); 
		foreach((array)$ExcelTemplete[$type] as $k=>$v){   $field[]	=	isset($v[2])?$v[2]:$v[0]; }
		return $field; 
	} 
	
	/**
	 * 导出EXCEL表格
	 *
	 * @param string $main 导入路径	
	 * @param string $type	模板名称
	 * @param int $insert_type	//1替换 2跳过 
	 * @return string
	 */
	public function readExcel($main,$type,$file_name, $sheet = 0, $default = array()){
		$sheet	= intval($sheet);
		$this->insert_type	=	3;
		
		//基本验证 st
 		if (empty($main) || empty($type)){ return $this->setExcelErrorMsg(1);}  
		///虚拟化数据 
		$relation_type	=10;//Excel
		$path	= getUploadPath($relation_type);
		$file_name	.= '.xls';
		if (file_exists($path . $type . '/' . $file_name)) {
			$path .= $type . '/';
		}
		$file	=	$path . $file_name;
		Vendor('PhpExcel.PHPExcel');
		$result	=	$this->Import_Execl($file); 

		///载入字段
		$field	=	$this->getExcelFields($type); 
		///验证导入字段列数量与实际模板列数是否相同 
		if (count($field)<$result['data'][$sheet]['Cols']){   return $this->setExcelErrorMsg(2); } 
		///判断字段模板是否存在！
		if (!is_array($field)){  return $this->setExcelErrorMsg(3);	} 
		$excel_info	=	$this->excel_info;  
		$excel		=	$excel_info[$main];

		//去除末尾空行 st
		$excel_content	= array_reverse($result["data"][$sheet]["Content"], true);
		foreach ($excel_content as $key => $row) {
			$is_empty	= true;
			foreach ($row as $val) {
				if ($val != '') {
					$is_empty	= false;
					break;
				}
			}
			if ($is_empty) {
				unset($excel_content[$key]);
			} else {
				break;
			}
		}
		$result["data"][$sheet]["Content"]	= array_reverse($excel_content, true);
		$result["data"][$sheet]['Rows']		= count($result["data"][$sheet]["Content"]);
		//去除末尾空行 ed
		
		$this->excel_max_row	=	$excel['max_row']>0?$excel['max_row']:999; 
		if ($result["data"][$sheet]['Rows']>$this->excel_max_row){ return $this->setExcelErrorMsg(4,$this->excel_max_row); }
		//基本验证 ed
		
		//数据基本构造 st
		$excel['field']	=	$field;   
		$execl_data 	= $result["data"][$sheet]["Content"]; 
        unset($execl_data[1]); //删除标题行 
		$default_merge	=	is_array($default) && !empty($default) ? true : false;
		$array_merge	=	is_array($excel['default']) ? true : false;
		$count			= 0;
        //add yyh 20151022 用条码获取产品ID
        if(in_array($type,array('InstockStorage','InstockImport','AdjustDetail','ShiftWarehouseDetail','PickingImport'))){
            switch ($type){//条码所在的列
                default :
                    $row    = 0;
                    break;
            }
            foreach((array)$execl_data as $key=>$value){
                $product_barcode[$value[$row]] = $value[$row];
            }
            $product_id = M('product')->where('custom_barcode in ("'.implode('","', $product_barcode).'")')->getField('custom_barcode,id');
            foreach ($execl_data as $key=>$val){
                if(empty($product_id[$val[$row]]) && !empty($val[$row])){
                    $this->error_product[$key]    = intval($val[$row]);
                }
                $execl_data[$key][$row] = empty($product_id[$val[$row]])?0:$product_id[$val[$row]];//product_id=null
            }
        }
        foreach((array)$execl_data as $k=>$v){
			$row_data	= array();
			$is_empty	= true;
			foreach((array)$excel['field'] as $key=>$value){
				$row_data[$value] 	= trim($v[$key]);
				if ($row_data[$value] != '') {
					$is_empty	= false;
				}
			}
			if ($is_empty) {//过滤空数据
				continue;
			}
			if ($array_merge){ ///是否有默认值补充   
				$row_data	= array_merge($excel['default'], $row_data);
			}
			if ($default_merge){ ///是否有默认值补充   
				$row_data	= array_merge($default, $row_data);
			}			
			$count++;
			$info['detail'][$k]	=	$row_data; 
			unset($row_data); 
		}
		if (!isset($info['detail']) || empty($info['detail'])) {
			return $this->setErrorMsg(5);
		}
		//数据基本构造 ed
		
		//返回数据构造 st
		if (isset($excel['after_fn'])){
			$info['excel']	=	$excel;     
			$this->$excel['after_fn']($info);
			unset($info['excel']);
		}
		$info['ser_detail']	= serialize($info['detail']);
		//返回数据构造 ed
		
        return $this->setErrorMsg(3, $count, $info);
	}

	/**
	 * 发货导入返回箱号列表
	 * @author jph 20140328
	 * @param array $info
	 */
	public function afterInstockDetail(&$info){
		$id	= intval($_GET['id']);
		if ($id > 0) {
			$info['id']	= $id;
			$this->afterInstockProductDetail($info);
		} else {
			$array_merge	=	is_array($info['excel']['after_default']) ? true : false;
			foreach ((array)$info['detail'] as $row){
				if (!empty($row['box_no']) && !isset($info['data'][$row['box_no']])) {
					$box				= &$info['data'][$row['box_no']];
					$box['box_no']		= $row['box_no'];
					$box['cube_long']	= floatval($row['cube_long']);
					$box['cube_wide']	= floatval($row['cube_wide']);
					$box['cube_high']	= floatval($row['cube_high']);
					$box['weight']		= floatval($row['weight']);
					if ($array_merge === true) {
						$box	= array_merge($info['excel']['after_default'], $box);
					}
					$box['cube']	= $box['cube_long'] * $box['cube_wide'] * $box['cube_high'];
				}
			}
			$view       = Think::instance('View');
			$box_info	= _formatList($info['data']);
			$rs['box']			= $box_info['list'];
			$rs['box_total']	= $box_info['total'];
			$view->assign ('rs', $rs);
			$view->assign ('tpl_module_name', 'Instock');
			$view->assign ('tpl_action_name', 'add');
			$info['html']	= $view->display('Instock:box_detail','','',true);
		}
	}
	
	/**
	 * 发货明细导入返回产品列表
	 * @author jph 20140703
	 * @param array $info
	 */
	public function afterInstockProductDetail(&$info){
		$instock_id		= $info['id'];
		if ($instock_id <= 0) {
			return false;
		}
		//系统已有箱号
		$model			= D('Instock');
		$sys_box		= $model->getBoxNo($instock_id);
		//导入明细中的箱号/产品号
		$import_box		= array();
		$import_product	= array();
		foreach ((array)$info['detail'] as $row){
			if (!empty($row['box_no'])) {
				$import_box[$row['box_no']]	= $row['box_no'];
			}
			if (!empty($row['product_no'])) {
				$import_product[$row['product_no']]	= $row['product_no'];
			}			
		}
		//对比箱号信息，系统中没有的箱号信息自动插入系统
		if (count($import_box) > 0) {
			$diff_box	= array_diff($import_box, $sys_box);
			if (count($diff_box) > 0) {
				$array_merge	= is_array($info['excel']['after_default']) ? true : false;
				$new_box		= array();
				foreach ($diff_box as $box_no){
						$box['instock_id']	= $instock_id;
						$box['box_no']		= $box_no;
						if ($array_merge === true) {
							$box	= array_merge($info['excel']['after_default'], $box);
						}
						$new_box[]			= $box;
				}
				M('InstockBox')->addAll($new_box);
				//重新获取系统箱号信息
				$sys_box	= $model->getBoxNo($instock_id);
			}
		}
		//获取导入产品号在系统中的id
		if (count($import_product) > 0) {
			$factory_id	= D('Instock')->where('id=' . $instock_id)->getField('factory_id');
			$product_no	= M('Product')->where('factory_id=' . $factory_id . " and product_no in ('" . implode("', '", $import_product) . "')")->getField('id,product_no');
		}
		//构造返回信息
		$array_merge	= is_array($info['excel']['after_product_default']) ? true : false;
		foreach ((array)$info['detail'] as $row){
			if (!empty($row['box_no'])) {
				$row['box_id']	= array_search($row['box_no'], $sys_box);
			}			
			if (!empty($row['product_no'])) {
				$row['product_id']	= array_search($row['product_no'], $product_no);
			}
			if ($array_merge === true) {
				$row	= array_merge($info['excel']['after_product_default'], $row);
			}
			$info['data'][]		= $row;
		}
		$view					= Think::instance('View');
		$product_info			= _formatList($info['data']);
		$rs['product']			= $product_info['list'];
		$rs['product_total']	= $product_info['total'];
		$view->assign ('rs', $rs);
		$view->assign ('tpl_module_name', 'Instock');
		$view->assign ('tpl_action_name', 'edit');
		$info['html']	= $view->display('Instock:product_detail','','',true);
	}
    
    /**
     * 导入发货单明细后返回明细信息
     * @author 20141113  add by yyh
     * @param type $info
     */
    public function afterInstockStorage(&$info){
		$id	= intval($_GET['instock_id']);
        $product_id_arr = array(); 
        if(!empty($info['detail'])){
            foreach ($info['detail'] as $val) {
                if(intval($val['quantity'])>0 &&intval($val['product_id'])>0 && !empty($val['warehouse_location'])){
                    $product_id_arr[$val['product_id']][$val['warehouse_location']]   += intval($val['quantity']);
                }
            }
            $box_diff_quantity  = M('instock_detail')->field('*,(quantity-in_quantity) as diff_quantity')->where('instock_id=' . $id.' and (quantity-in_quantity)>0')->order('box_id')->select();
            $detail_arr = array();
            foreach ($box_diff_quantity as $val){
                 $detail_arr[$val['product_id']][]   = $val;
            }
            $warehouse_id   = M('instock')->where('id='.$id)->getField('warehouse_id');
            $box_quantity   = array();
            foreach ($product_id_arr as $key => $value) {//$key产品ID
                foreach ($value as $ke => $val) {//$ke=>库位 $val=>数量
                    foreach ($detail_arr[$key] as $k => $v) {//$v=>该产品ID明细表信息
                            if ($val > $v['diff_quantity']) {
                                $box_quantity[$ke . $v['id']] = $v;
                                $box_quantity[$ke . $v['id']]['new_quantity'] = (count($detail_arr[$key]) == 1)?$val:$v['diff_quantity'];
                                $box_quantity[$ke . $v['id']]['location_no'] = $ke;
                                $val -= $v['diff_quantity'];
                                $detail_arr[$key][$k]['diff_quantity']  = 0;
                            } else {
                                $box_quantity[$ke . $v['id']] = $v;
                                $box_quantity[$ke . $v['id']]['new_quantity'] = $val;
                                $box_quantity[$ke . $v['id']]['location_no'] = $ke;
                                $detail_arr[$key][$k]['diff_quantity'] -= $val;                                
                                $val    = 0;
                            }
                            if($detail_arr[$key][$k]['diff_quantity']<= 0){
                                unset($detail_arr[$key][$k]);
                            }
                            if ($val <= 0) {
                                unset($product_id_arr[$key]);
                                break;
                            }
                    }
                }
            }
            $index=0;
            foreach ($detail_arr as $key => $value) {
                foreach ($value as $k => $v) {
                    if ($v['quantity'] == ($v['in_quantity'] + $v['diff_quantity'])) {
                        $box_quantity[$ke . $v['id'] . $index] = $v;
                        $box_quantity[$ke . $v['id'] . $index]['new_quantity'] = '';
                        $box_quantity[$ke . $v['id'] . $index]['location_no'] = '';
                        $index++;
                    }
                }
            }
            $model = D('Instock');
            $model->setId($id);
            $rs = $model->getInfoInstock($id);
            $list     = array();
            $num    =0;
            foreach ((array) $box_quantity as $row) {
                $list[$num]     = $rs['product'][$row['id']];
                $list[$num]['instock_detail_id']    = $list[$num]['id'];
                unset($list[$num]['id']);
                $list[$num]['new_quantity'] =$row['new_quantity'];
                $location_id    = getLocatioinId($row['location_no'],$warehouse_id);
                if ($location_id > 0) {
                    $list[$num]['location_no'] = $row['location_no'];
                    $list[$num]['location_id'] = $location_id;
                }else{
                    $list[$num]['location_no'] = $row['location_no'];
                }
                $list[$num]['warehouse_id']    = $warehouse_id;
                $num++;
            }
            $rs['product']  = $list;
            $rs['action']   = 'add';
            $view = Think::instance('View');
            $view->assign('rs', $rs);
            $info['html'] = $view->display('InstockStorage:product_detail', '', '', true);
        }
    }

	/**
	 * 发货导入返回箱号列表
	 * @author jph 20140328
	 * @param array $info
	 */
	public function afterAdjustDetail(&$info){
		$view			    = Think::instance('View');
		$adjust_info        = _formatList($info['detail']);
		$rs['detail']	    = $adjust_info['list'];
		$rs['detail_total'] = $adjust_info['total'];
		foreach ((array)$rs['detail'] as $row){
			if (!empty($row['barcode_no'])&&(strstr($row['barcode_no'],',')===false)) {
				$barcode_no.= '"'.trim($row['barcode_no']).'",';
			}
		}
		if(is_string($barcode_no)&&$barcode_no){
			$location		= M('location');
			$sql		    = 'SELECT id,barcode_no,warehouse_id
							   FROM location
							   WHERE barcode_no in ('.rtrim($barcode_no,',').')';
			$data		    = $location->query($sql);
			foreach ((array)$data as $val){
				$barcode_no_data[$val['barcode_no']] = $val['id'];
				$warehouse_data[$val['barcode_no']]  = $val['warehouse_id'];
			}
			foreach ((array)$rs['detail'] as $k=>$v){
				if(array_key_exists($v['barcode_no'],$barcode_no_data)){
					$rs['detail'][$k]['location_id']  = $barcode_no_data[$v['barcode_no']];
					$rs['detail'][$k]['warehouse_id'] = $warehouse_data[$v['barcode_no']];
				}else{
					$rs['detail'][$k]['location_id']  = '';
					$rs['detail'][$k]['warehouse_id'] = '';
				}
			}
		}
		//pr($rs,'',1);
		$view->assign ('rs', $rs);
		$view->assign ('tpl_module_name', 'Adjust');
		$view->assign ('tpl_action_name', 'add');
		$info['html'] = $view->display('Adjust:detail','','',true);
	}
	
    /**
	 * 入库导入调整返回产品列表
	 * @author 
	 * @param array $info
	 */
	public function afterAdjustInstockDetail(&$info){
		$view			    = Think::instance('View');
		$adjust_info        = _formatList($info['detail']);
		$rs['detail']	    = $adjust_info['list'];
		$rs['detail_total'] = $adjust_info['total'];
		
		//获取发货单ID
		$map['box_id'] = $rs['detail'][0]['box_id'];
		$map['product_id'] = $rs['detail'][0]['product_id'];
		$instock_id = M('instock_detail')->where($map)->getField('instock_id');
		if(empty($instock_id)) exit(json_encode(array('type'=>4,'msg'=>'第2行 数据错误，请修正 ')));
		//获取入库导入单号ID
		$file_id = M('file_relation_detail')->where(array('relation_id'=>$instock_id,'file_type'=>1))->getField('object_id');
		if(empty($file_id)) exit(json_encode(array('type'=>4,'msg'=>'第2行 数据错误，请修正 ')));
		//获取发货单详情
		$instockDetailList = M('instock_detail')->where(array('instock_id'=>$instock_id))->field('id,box_id,product_id,quantity,in_quantity')->select();
		//获取发货单信息
		$instockInfo = M('instock')->where(array('id'=>$instock_id))->field('instock_no,warehouse_id')->find();
		//验证
		foreach ((array)$rs['detail'] as $excel_key=>$excel_value){
			//调整数量是否合法
			if(!preg_match('/^-?[1-9]\d*$/', $excel_value['adjust_quantity'])){
				$excel_key += 2;
				exit(json_encode(array('type'=>4,'msg'=>'第'.$excel_key.'行 数据错误，请修正 ')));
			}
			//库位是否填写
			if (!empty($excel_value['barcode_no'])&&(strstr($excel_value['barcode_no'],',')===false)) {
				$barcode_no.= '"'.trim($excel_value['barcode_no']).'",';
			}else{
				$excel_key += 2;
				exit(json_encode(array('type'=>4,'msg'=>'第'.$excel_key.'行 数据错误，请修正 ')));
			}
			//箱号，产品是否属于该入库单号
			foreach ($instockDetailList as $detail_key=>$detail_value){
				if(($detail_value['box_id'] == $excel_value['box_id']) && ($detail_value['product_id'] == $excel_value['product_id'])){
					//调整后的入库数量验证
					$diff_value = $detail_value['in_quantity'] + $excel_value['adjust_quantity'];
					if($diff_value < 0) {
						$excel_key += 2;
						exit(json_encode(array('type'=>4,'msg'=>'第'.$excel_key.'行 数据错误，请修正 ')));
					}
					//赋值需要返回的数据
					$rs['detail'][$excel_key]['instock_detail_id'] = $detail_value['id'];
					$rs['detail'][$excel_key]['edml_quantity'] = $detail_value['quantity'];
					$rs['detail'][$excel_key]['edml_in_quantity'] = $rs['detail'][$excel_key]['in_quantity'] = $detail_value['in_quantity'];
					break;
				}
				if($detail_key == count($instockDetailList)-1){
					$excel_key += 2;
					exit(json_encode(array('type'=>4,'msg'=>'第'.$excel_key.'行 数据错误，请修正 ')));
				}		
			}
		}
		$location		= M('location');
		$sql		    = 'SELECT id,barcode_no,warehouse_id
							FROM location
							WHERE warehouse_id = '.$instockInfo['warehouse_id'].' and barcode_no in ('.rtrim($barcode_no,',').')';
		$locationArr	= $location->query($sql);
		foreach ((array)$locationArr as $val){
			$barcode_no_data[$val['barcode_no']] = $val['id'];
		}
		foreach ((array)$rs['detail'] as $k=>$v){
			if(array_key_exists($v['barcode_no'],$barcode_no_data)){
				$rs['detail'][$k]['location_id']  = $barcode_no_data[$v['barcode_no']];
			}else{
				$k += 2;
				exit(json_encode(array('type'=>4,'msg'=>'第'.$k.'行 数据错误，请修正 ')));
			}
		}
		$info['html_input']['instock_id']  = $rs['instock_id'] = $instock_id;
		$info['html_input']['instock_no']  = $rs['instock_no'] =  $instockInfo['instock_no'];
		$info['html_input']['warehouse_id']  = $rs['warehouse_id'] =  $instockInfo['warehouse_id'];
		$view->assign ('rs', $rs);
		$view->assign ('tpl_module_name', 'InstockImportAdjust');
		$view->assign ('tpl_action_name', 'add');
		$info['html'] = $view->display('InstockImportAdjust:detail','','',true);
	}
	
    /**
	 * 派送方式邮编
	 * @author jph 20121102
	 * @param array $info
	 */
	public function afterExpressPost(&$info){
		$view			    = Think::instance('View');
        $rs['detail']   = $info['detail'];
		$view->assign ('rs', $rs);
		$view->assign ('tpl_module_name', 'QuicklyOperate');
		$view->assign ('tpl_action_name', 'setPostSection');
		$info['html'] = $view->display('QuicklyOperate:PostDetail','','',true);
	}
	
	/**
	 * 入库导入返回明细列表
	 * @author jph 20140328
	 * @param array $info
	 */
	public function afterInstockImport(&$info){
		$array_merge	=	is_array($info['excel']['after_default']) ? true : false;
        if (is_array($info['detail'])) {
			foreach ($info['detail'] as &$row){
				if ($array_merge === true) {//合并默认值
					$row	= array_merge($info['excel']['after_default'], $row);
				}
				$row['product_id']	= intval($row['product_id']);
				$row['box_id']		= intval($row['box_id']);
				$row['quantity']	= intval($row['quantity']);
				$row['barcode_no']	= trim($row['barcode_no']);
				if (!empty($row['barcode_no'])) {
					$barcode_no[$row['barcode_no']]	= $row['barcode_no'];
				}
			}
			$warehouse_id	= intval($_GET['warehouse_id']);
			if ($warehouse_id > 0 && count($barcode_no) > 0) {
				$where	= array(
					'warehouse_id'	=> $warehouse_id,
					'barcode_no'	=> array('in', $barcode_no),
				);
				$location_id	= M('Location')->where($where)->getField('lower(barcode_no), id');
			} else {
				$location_id	= array();
			}
			if (count($location_id) > 0) {
				foreach ($info['detail'] as &$row){
					if ($location_id[strtolower($row['barcode_no'])] > 0) {
						$row['location_id']	= $location_id[strtolower($row['barcode_no'])];
					}
				}				
			}
			D('InstockAbnormal')->importValidDetail($info['detail'], $warehouse_id,$this->error_product);
		}
	}		
	
	/// 产品导入
	public function productExcel($main,$type,$file_name,$insert_type=1,$sheet=0){
		$sheet			   = intval($sheet); 
 		if (empty($main) || empty($type)){ return $this->setExcelErrorMsg(1);}  
 		$this->insert_type = $insert_type;  
		///虚拟化数据 
		$relation_type	   = 10;//Excel
		$path			   = getUploadPath($relation_type);
		$file_name		  .= '.xls';
		if (file_exists($path . $type . '/' . $file_name)) {
			$path		  .= $type . '/';
		}
		$file			   = $path . $file_name;
		Vendor('PhpExcel.PHPExcel');
		$result			   = $this->Import_Execl($file);    
		///载入字段
		$field			   = $this->getExcelFields($type);
		//pr($field,'');pr($result,'',1);

		///验证导入字段列数量与实际模板列数是否相同 
		if (count($field) != $result['data'][$sheet]['Cols']){ return $this->setExcelErrorMsg(2); } 
		///判断字段模板是否存在！
		if (!is_array($field)){  return $this->setExcelErrorMsg(3);	} 

		$excel_info		   = $this->excel_info;  
		$excel			   = $excel_info[$main];
		$this->excel_max_row = $excel['max_row']>0?$excel['max_row']:999; 
		if ($result["data"][$sheet]['Rows']<=1){ return $this->setErrorMsg(5); }   
		if ($result["data"][$sheet]['Rows']>$this->excel_max_row){ return $this->setExcelErrorMsg(4,$this->excel_max_row); }   
		
		$excel['field']	   = $field;  
		$execl_data 	   = $result["data"][$sheet]["Content"]; 
        unset($execl_data[1]);
		$factory_id		   = intval(getUser('company_id'));
		//$factory_id		   = 14;
		if ($factory_id<=0){ return $this->setErrorMsg(4,0,'所属卖家不能为空,请按格式填写数据！');}  

		$model 			   = D('Product');
		$action			   = A('Product');
		$model->isAjax	   = true; 
		if($insert_type==1){$model->valid_excel_unique_state = false;}
		$tips			   = C('PRODUCT_IMPORT_TIPS');
		$count = 0;
		$success_count    =   0;//更新数量    add by lxt 2015.06.10
		$exists_count     =   0;//系统中已存在数量    add by lxt 2015.06.10
		//pr($execl_data,'',1);
		
		//查找已存在的产品信息 st      add by lxt 2015.06.10
		foreach ((array)$execl_data as $value){
		    $product_no[] =   trim($value[1]);
		}
		
		$where['product_no']  =   array("in",$product_no);
		$where['factory_id']  =   $factory_id;
		$where['to_hide']     =   1;
		$exists               =   $model->field("check_long,check_wide,check_high,check_weight",true)->where($where)->relation(true)->select();
		
		//重组数据
		if (count($exists) > 0){
		    foreach ($exists as $value){
		        $original[$value['product_no']]   =   $value;
		    }
		}
		//查找已存在的产品信息 ed
		
		foreach((array)$execl_data as $k=>$v){  
			$field_data	= array();
			$is_empty	= true;
			foreach((array)$excel['field'] as $key=>$value){
				$field_data[$value] 	= $v[$key];
				if (trim($field_data[$value]) != '') {
					$is_empty	= false;
				}
			}
			if ($is_empty) {//过滤空数据
				continue;
			}
			$row_data = $return_error  = array();
			
			$row_data['factory_id']       = $factory_id;
			$row_data['product_name']     = trim($v[0]);
			$row_data['product_no']       = trim($v[1]);
			$row_data['cube_long']	      = trim($v[2]);
			$row_data['cube_wide']	      = trim($v[3]);
			$row_data['cube_high']	      = trim($v[4]);
			$row_data['weight']		  	  = trim($v[5]);
			$row_data['warning_quantity'] = trim($v[6]);
			$row_data['custom_barcode']   = trim($v[11]);
			
			$material_description		  = trim($v[8]);
			$hs_code		     		  = trim($v[7]);
            $declared_value               = trim($v[9]);
            $sale_price                   = trim($v[10]);

			$row_data['product_detail'][0]['properties_id'] = C('MATERIAL_DESCRIPTION');	//材质说明
			$row_data['product_detail'][0]['value'] = $material_description;    
			$row_data['product_detail'][1]['properties_id'] = C('HS_CODE');	//hs code
			$row_data['product_detail'][1]['value'] = $hs_code;
            $row_data['product_detail'][2]['properties_id'] = C('DECLARED_VALUE');//申报价值
			$row_data['product_detail'][2]['value'] = $declared_value;
            $row_data['product_detail'][3]['properties_id'] = C('SALE_PRICE');//销售价格
			$row_data['product_detail'][3]['value'] = $sale_price;
            
			
			$row_data['tocken'] = $row_data['file_tocken'] = md5(time());
			$row_data['sid']		   = session_id();

			$row_data['referer']	   = 'js';
			$row_data['error_message'] = '第'.$k.'行,数据错误请修改.';
			
			//需要更新字段     add by lxt 2015.06.10
			if (isset($original[$row_data['product_no']])){
			    
			    //用于判断是否有更新
			    $tag =   0;
			    
			    //如果系统中值为空，并且本次有数据输入，才用本次数据更新
			    if (empty($original[$row_data['product_no']]['warning_quantity']) && $row_data['warning_quantity']){
			        $original[$row_data['product_no']]['warning_quantity']   =   $row_data['warning_quantity'];
			        $tag++;
			    }
			    if (empty($original[$row_data['product_no']]['product_detail'][0]['value']) && $material_description){
			        $original[$row_data['product_no']]['product_detail'][0]['value'] =   $material_description;
			        $tag++;
			    }
			    if (empty($original[$row_data['product_no']]['product_detail'][1]['value']) && $hs_code){
			        $original[$row_data['product_no']]['product_detail'][1]['value'] =   $hs_code;
			        $tag++;
			    }
			    if (empty($original[$row_data['product_no']]['product_detail'][2]['value']) && $declared_value){
			        $original[$row_data['product_no']]['product_detail'][2]['value'] =   $declared_value;
			        $tag++;
			    }
			    if (empty($original[$row_data['product_no']]['product_detail'][3]['value']) && $sale_price){
			        $original[$row_data['product_no']]['product_detail'][3]['value'] =   $sale_price;
			        $tag++;
			    }
			    
			    $original[$row_data['product_no']]['tocken']                     =   $row_data['tocken'];
			    $original[$row_data['product_no']]['file_tocken']                =   $row_data['file_tocken'];
			    $original[$row_data['product_no']]['sid']                        =   $row_data['sid'];
			    $original[$row_data['product_no']]['referer']                    =   $row_data['referer'];
			    $original[$row_data['product_no']]['error_message']              =   $row_data['error_message'];
			    
			    //如果没有更新，则跳过本次循环
			    if (!$tag){
			        $exists_count++;
			        continue;
			    }
			}
			
			//使用新增数据，或更新数据   edit by lxt 2015.06.10
			$_POST   =   $original[$row_data['product_no']]?$original[$row_data['product_no']]:$row_data;
			//判断更新还是新增   edit by lxt 2015.06.10
			$action_type =   $original[$row_data['product_no']]?'update':'insert';
			$model->setModuleInfo('Product',$action_type);
			$action->setName('Product'); 
			$rs = $action->$action_type('ProductImport');  
// 			pr($_POST,'',1);
			if(is_array($rs)&&$rs){
				foreach($rs as $val){
					if(array_key_exists($val['name'],$return_error)===false){
						$return_error[$val['name']] = $tips[$val['name']].'：'.$val['value'];
					}
				}
				/*
				if(empty($hs_code)){
					$return_error['hs_code']		      = L('hs_code').'：'.L('require');
				}
				if(empty($material_description)){
					$return_error['material_description'] = L('material_description').'：'.L('require');
				}
				*/
			}
			if(is_array($return_error)&&$return_error){
				return $this->setErrorMsg(1,$k,'<br/><br/>'.implode('<br/>',$return_error).'<br/><br>');
			}
			//根据数据决定是新增还是更新操作    add by lxt 2015.06.10
			if($rs!==false){
				if ($action_type=='insert'){
				    $action->_after_insert('ProductImport');
				}else{
				    $action->_after_update('ProductImport');
				}
			}
			//新增或更新记录数   edit by lxt 2015.06.10
			if ($action_type=='insert'){
			    $count++;
			}else{
			    $success_count++;
			}
			unset($row_data,$return_error); 
		}    
		return $this->setErrorMsg(3,$count,null,$success_count,$exists_count);
	}

	/// 订单导入
	public function saleOrderExcel($main,$type,$file_name,$insert_type=1,$sheet=0){
		$sheet			   = intval($sheet); 
        $sale_order_field   = $this->execlField[$type];
 		if (empty($main) || empty($type)){ return $this->setExcelErrorMsg(1);}  
 		$this->insert_type = $insert_type;
		$session_key_prefix= $file_name . '_';
		if (S($session_key_prefix . 'saleOrderImportExcelData')) {
			$excel			= S($session_key_prefix . 'saleOrderImportExcel');
			$execl_data 	= S($session_key_prefix . 'saleOrderImportExcelData');
		} else {		
			///虚拟化数据 
			$relation_type	   = 10;//Excel
			$path			   = getUploadPath($relation_type);
            if($type=='ECPPSaleOrderImport'){
                $file_name		  .= '.xlsx';
            }else{
                $file_name		  .= '.xls';
            }
            if($type=='ECPPSaleOrderImport'||$type=='PayPalSaleOrderImport'){//新增速卖通    add by lxt 2015.07.22
                $path_type  ='SaleOrderImport';
            }else{
                $path_type  =$type;
            }
			if (file_exists($path . $path_type. '/' . $file_name)) {
				$path		  .= $path_type . '/';
			}
			$file			   = $path . $file_name;
			Vendor('PhpExcel.PHPExcel');
			$result			   = $this->Import_Execl($file,$type);
			///载入字段
			$field			   = $this->getExcelFields($type);
			///验证导入字段列数量与实际模板列数是否相同 
			if (count($field) != $result['data'][$sheet]['Cols']){
				return $this->setExcelErrorMsg(2);
			} 
			///判断字段模板是否存在！
			if (!is_array($field)){
				return $this->setExcelErrorMsg(3);
			} 

			$excel_info		   = $this->excel_info;  
			$excel			   = $excel_info[$main];
			$this->excel_max_row = $excel['max_row']>0?$excel['max_row']:999; 
			if ($result["data"][$sheet]['Rows']<=1){ 
				return $this->setErrorMsg(5);
			}   
			if ($result["data"][$sheet]['Rows']>$this->excel_max_row){ 
				return $this->setExcelErrorMsg(4,$this->excel_max_row);
			}   

			$excel['field']	   = $field;  
			$execl_data 	   = $result["data"][$sheet]["Content"];
			unset($execl_data[1]);
			S($session_key_prefix . 'saleOrderImportExcel', $excel);
			S($session_key_prefix . 'saleOrderImportExcelData', $execl_data);
		}
        
            //分页处理
		if($type=='ECPPSaleOrderImport'){
            $this->sameRow      = empty($_REQUEST['sameRow'])? 0 : intval($_REQUEST['sameRow']); 
            $this->totalRows	= count($execl_data)+$this->sameRow;//总行数
            $this->totalPages	= ceil($this->totalRows/$this->listRows);     //总页数
            $this->nowPage		= !empty($_REQUEST['nowPage']) && intval($_REQUEST['nowPage']) > 0 ? intval($_REQUEST['nowPage']):1; 
            if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
                $this->nowPage = $this->totalPages;
            }
            $this->firstRow		= $this->listRows*($this->nowPage-1)-$this->sameRow;
            $execl_data			= array_slice($execl_data, $this->firstRow, $this->listRows, true);
            krsort($execl_data);
            $order      = '';
            $row        = 0;
            if(count($execl_data) >= $this->listRows){
                foreach($execl_data as $value){
                    if(!empty($order)){
                        if($order!=$value[2]){
                            break;
                        }
                    }else{
                        $order  = $value[2];
                    }
                    $row++;
                }
                $this->sameRow  += $row;
                for($row;$row>0;$row--){
                    //ECPP导入的excel第二行为第一个有效行
                    unset($execl_data[2+$this->firstRow+$this->listRows-$row]);
                }
            }
            ksort($execl_data);
        }else{
            $this->totalRows	= count($execl_data);//总行数
            $this->totalPages	= ceil($this->totalRows/$this->listRows);     //总页数
            $this->nowPage		= !empty($_REQUEST['nowPage']) && intval($_REQUEST['nowPage']) > 0 ? intval($_REQUEST['nowPage']):1; 
            if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
                $this->nowPage = $this->totalPages;
            }
            $this->firstRow		= $this->listRows*($this->nowPage-1);
            $execl_data			= array_slice($execl_data, $this->firstRow, $this->listRows, true);
        
        }
		$factory_id		   = intval(getUser('company_id'));
		if ($factory_id<=0){ 
			return $this->setErrorMsg(4,0,'所属卖家不能为空,请按格式填写数据！');
		}
		
		$tips = C('SALE_ORDER_IMPORT_TIPS');
		$count = 0;
		if ($this->nowPage == 1) {
			S($session_key_prefix.'saleOrderImportErrorMsg', null);
		}
		if (S($session_key_prefix.'saleOrderImportErrorMsg')) {
			$has_error	= true;
			$errorMsg	= S($session_key_prefix.'saleOrderImportErrorMsg');
		} else {
			$has_error	= false;
			$errorMsg	= array();
		}
		$row_data = array();
		$success_count  = 0;
        $data           = array();
        if ($type == 'ECPPSaleOrderImport') {
            $product_arr    =   array();
			foreach ((array) $execl_data as $key => $val) {
				$product_no = $val[$sale_order_field['product_no']['column']];
				$product_quantity = $val[$sale_order_field['quantity']['column']];
				$order_no = $val[$sale_order_field['order_no']['column']];
				if (in_array($product_no, $product_arr[$order_no])) {
					$product_key = array_search($product_no, $product_arr[$order_no]);
					$product_arr[$order_no][$product_key + 1] += $product_quantity;
				} else {
					$product_arr[$order_no][] = $product_no;
					$product_arr[$order_no][] = $product_quantity;
				}
			}

            $order_arr      =   array();
			foreach ((array) $execl_data as $key => $val) {
				$order_no = $val[$sale_order_field['order_no']['column']];
				if (!in_array($order_no, $order_arr)) {
					$order_arr[]    = $order_no;
					$data[$key]     = $val;                    
					foreach($product_arr[$order_no] as $va){
						$data[$key][]   = $va;
					}
				}
			}
        }else{
            $data   = $execl_data;
        }
		$product_storage	= array();
		$product_ids		= array();
        foreach((array)$data as $k=>$v){
            $this->execl_data   = $v;
			$field_data	= array();
			$is_empty	= true;
			foreach((array)$excel['field'] as $key=>$value){
				$field_data[$value] 	= $v[$key];
				if (trim($field_data[$value]) != '') {
					$is_empty	= false;
					break;
				}
			}
			if ($is_empty) {//过滤空数据
				continue;
			}
			
            foreach ($this->execlSaleOrder as $key => $val) {
                foreach ($val as $va) {
					$value = '';
                    if (isset($sale_order_field[$va])) {
                        $fun		= $sale_order_field[$va]['type'];
                        $value		= $fun($v[$sale_order_field[$va]['column']]);
						$sp_fields	= array('warehouse_id'=>'warehouse','express_id'=>'shipping','country_id'=>'country',);
						if (isset($sp_fields[$va])) {
							$value = DdToId($sp_fields[$va], strtoupper($value));
						}
                    }
                    switch ($key) {
                        case 'sale_order':
                            $row_data[$k][$va]  = $value;
                            break;;
                        case 'sale_order_addition':
                            $row_data[$k]['addition'][1][$va]  = $value;
                            break;
                    }
                }
            }
            if(in_array($row_data[$k]["express_id"],explode(',',C('EXPRESS_FR_REGISTERED_ID')))){
                $row_data[$k]["is_registered"]=1;
            }
			///同一个卖家相同的单号不能重复导入
			$model			= D('SaleOrder');
			$where			= array(
				'order_no'		=> $row_data[$k]['order_no'],
				'factory_id'	=> $factory_id,
			);
			$sale_order_id	= $model->where($where)->getField('id');
			if($sale_order_id>0){
				$success_count++;
				unset($row_data[$k]);
				continue;
			}
            $row_data[$k]['factory_id'] = $factory_id;
			$row_data[$k]['from_type']	= 'import';///用来减少不必要的判断
			$return_error  = array();
			$row_data[$k]['addition'][1]['factory_id']   = $factory_id;
			$row_data[$k]['addition'][1]['comp_type']    = 1; 
			$row_data[$k]['addition'][1]['from_type']	 = 'import';///用来减少不必要的判断
			//明细处理
			$ok		= 1;
			$p_flag = false;
			$row_data[$k]['detail'][1]['quantity']   = '';
			$row_data[$k]['detail'][1]['product_id'] = '';
            switch ($type) {
                case 'ECPPSaleOrderImport':
                    $star   = 42;
                    $end    = count($data[$k]);
                    break;
                case 'PayPalSaleOrderImport'://速卖通订单产品      add by lxt 2015.07.23
                    $star   =   22;
                    $end    =   $star+10*2;
                    break;
                case 'SaleOrderImport':
                default :
                    $star = 19;
                    $end = 19 + 10 * 2; //每个销售单最多导入10个产品
                    break;
            }

			///新建本行的产品库存数组，如果是已经导入的则去掉本行的库存验证
			$product_no_list	= array();
			for($i = $star; $i < $end; $i += 2){
				if (!empty($v[$i])) {
					$v[$i]						= excel_import_filter($v[$i]);
					$product_no_list[$v[$i]]	= $v[$i];
				}
			}
			if ($product_no_list) {
				$product	= getProductIdByFactory($product_no_list, $factory_id);
			}
			for($i = $star; $i < $end; $i += 2){
				$sku = $v[$i];
				if($sku){
					$product_id = $product[$sku];
					if(intval($product_id)>0) {  
							$p_flag = true;
							$row_data[$k]['detail'][$ok]['quantity']     = $v[$i+1];
							$row_data[$k]['detail'][$ok]['product_id']	 = $product_id;
							$row_data[$k]['detail'][$ok]['warehouse_id'] = $row_data[$k]['warehouse_id'];
							$ok++;
							///构建按仓库的产品数量。用来下面的库存批量验证
							$product_storage[$row_data[$k]['warehouse_id'].'-'.$product_id]['quantity'] += $v[$i+1];
							$product_storage[$row_data[$k]['warehouse_id'].'-'.$product_id]['sku'] = $sku;
							$product_storage[$row_data[$k]['warehouse_id'].'-'.$product_id]['warehouse_id'] = $row_data[$k]['warehouse_id'];
							///构建按仓库的产品数量。用来下面的库存批量验证
							$product_ids[$product_id] = $product_id;
							///构建按仓库的产品数量。用来下面的VAT批量验证
							$w_ids[]	= empty($row_data[$k]['warehouse_id'])?0:$row_data[$k]['warehouse_id'];//20170203 warehouse_id为空
					} else {
						///验证产品是否有错误信息 
						$return_error[$i] = '产品：'.$sku.'不存在';
					}  
				}
			}
			$Client	= D('Client');
			$row_data[$k]['addition'][1] = $Client->create($row_data[$k]['addition'][1]);
			if($row_data[$k]['addition'][1]===false){
				$client_error_data = $Client->getError();
				foreach($client_error_data as $c_v){
					if($c_v['name']!='comp_type'){
						$return_error[$c_v['name']] = $tips[$c_v['name']].'：'.$c_v['value'];
					}
				}
			}
			
			//派送方式限制对应销售渠道验证
			if(in_array($row_data[$k]['express_id'],C('VIRTUAL_ORDERTYPE_EXPRESS')) && $row_data[$k]['order_type'] !=  C('ORDER_TYPE_VIRTUAL_TRAY')){
				$return_error[L('order_type')] = L('EXPRESS_BIND_ORDER_TYPE').'：'.SOnly('order_type', C('ORDER_TYPE_VIRTUAL_TRAY'),'order_type_name');
			}
			if(in_array($row_data[$k]['express_id'],C('TRAY_ORDERTYPE_EXPRESS')) && $row_data[$k]['order_type'] !=  C('ORDER_TYPE_TRAY_EXPRESS')){
				$return_error[L('order_type')] = L('EXPRESS_BIND_ORDER_TYPE').'：'.SOnly('order_type', C('ORDER_TYPE_TRAY_EXPRESS'),'order_type_name');
			}		

			//订单导入库存信息提示的特殊处理
			$model->isAjax	= true;
			$row_data[$k]	= $model->setPost($row_data[$k]);
			$row_data[$k]	= $model->create($row_data[$k]);
			if($row_data[$k]===false){
				$error_data = $model->getError();//清空并返回清空前错误信息
				foreach($error_data as $val){
				    //当产品和数量都没有填写的情况下，防止错误提示为空      edit by lxt 2015.07.24
				    if (strpos($val['name'], 'detail')!==false){
				        //获取detail组数下标
				        preg_match('/[0-9][0-9]*/', $val['name'],$number);
				        //产品或者数量错误提示
				        if (strpos($val['name'], 'product_id')){
				            $name   =   L('product_no').$number[0];
				        }elseif (strpos($val['name'], 'quantity')){
				            $name   =   L('product_no').$number[0].L('quantity');
				        }else{
				            $name   =   $tips[$val['name']];
				        }
				        $return_error[$val['name']] = $name.':'.$val['value'];
				    }if (strpos($val['name'], '[')!==false){
				        preg_match('/\[([^]]+)\]$/', $val['name'],$name);
						 $return_error[$val['name']] = $tips[$name[1]].'：'.$val['value'];
					}else{
				        $return_error[$val['name']] = $tips[$val['name']].'：'.$val['value'];
				    }
				}
			}
            
			///验证主表是否有错误信息 
			if(is_array($return_error) && $return_error){
				$this->addErrorMsg($errorMsg, $this->setErrorMsg(1,$k,'<br/>'.implode('<br/>',$return_error)));
				$has_error	= true;
			}
		}
		
		///库存批量验证
		///根据P_ID查询所有仓库的数量，然后一个个对比
		if(count($product_ids)>0){
			$rs    = M('saleStorage')->field('concat(warehouse_id,\'-\',product_id) as id,quantity')->where('product_id in ('.implode(',',$product_ids).')')->formatFindAll(array('key'=>'id','v_key'=>'quantity'));
			$warehouse_cache	= S('warehouse');
			foreach($product_storage as $pk => $pv){
				if($pv['quantity'] > $rs[$pk]){
					$sale_storage = $rs[$pk] ? $rs[$pk] : 0;
					$storage_error = '产品：'.$pv['sku'].' 库存不足，本次导入数量 '.$warehouse_cache[$pv['warehouse_id']]['w_name'].'：'.$pv['quantity'].',可销售库存为：'.$sale_storage;
					$this->addErrorMsg($errorMsg, $this->setErrorMsg(4,$pk,$storage_error));
					$has_error	= true;
				}
			}
		}

		//VAT批量验证
		if(is_array($w_ids) && $w_ids){
			$result	= D('Vat')->warehouseDebtVat($factory_id,$w_ids);
			if($result){
				$this->addErrorMsg($errorMsg, $this->setErrorMsg(4,0,$result));
				$has_error	= true;
			}
		}

		///验证主表是否有错误信息,完全没有错误以后开始插入
		if($has_error == false){
			foreach($row_data as $key => $vlaue){
				$vlaue['addition'][1]['comp_no'] =  getModuleMaxNo('Client');
				$Client	= D('Client');
				$Client->data = $vlaue['addition'][1];
				$vlaue['client_id'] = $Client->add();
				$model	= D('SaleOrder');
				$model->isAjax		= true;
				$model->setModuleInfo('SaleOrder','insert');
				$vlaue['referer']	   = 'js';
				$vlaue['error_message'] = '第'.$key.'行,数据错误请修改.';
				$model->data = $vlaue;
				$_POST		 = $model->data;
				$order_id = $model->importInsert();
				if($order_id>0){
					A('SaleOrder')->generateBarcode($order_id);
					$count++;
				}
			}
		}else{
			$processCount	= intval($_REQUEST['processCount']);
			if (!$has_error && $processCount > 0) {
				$errorMsg['msg']	= '本次成功导入' . $processCount . '条，还有'.intval($_REQUEST['successCount'])+$success_count.'条记录已经在系统中。修正以下错误后请重新上传及导入！' . "<br /><br />" . $errorMsg['msg'];
			}
		}
		unset($row_data,$return_error);
		if ($errorMsg) {
			if ($this->nowPage < $this->totalPages) {
				S($session_key_prefix.'saleOrderImportErrorMsg', $errorMsg);
				return $this->setErrorMsg(7, intval($_REQUEST['processCount']), $errorMsg,intval($_REQUEST['successCount'])+$success_count);
			} else {
				S($session_key_prefix.'saleOrderImportErrorMsg', null);
				return $errorMsg;
			}
		} else {
			$type	= $this->nowPage < $this->totalPages ? 6 : 3;
			return $this->setErrorMsg($type, intval($_REQUEST['processCount']) + $count,'',intval($_REQUEST['successCount'])+$success_count);
		}
	}   

	public function setDifferProducts($info) {
		extract($info);		
		$update_sql = 'update sale_order_differ_product 
					   set `to_hide`=2 
					   where factory_id='.$factory_id.' and object_type=6 and title=\''.$title.'\' and item_id=\''.$item_id.'\'';
		return M('sale_order_differ_product')->execute($update_sql); 
	}

	public function saveDifferProducts($info, $type=6){
		$sale_order_differ_product = M('sale_order_differ_product');
		$id = $sale_order_differ_product->where('item_id=\''.$info['item_id'].'\' and factory_id='.$info['factory_id'].' and object_type='.$type)->getField('id');
		if(intval($id)>0)
			return false;
		$insert_array	  = array(
							    'item_id' 	  => $info['item_id'],													
								'title' 	  => $info['title'],
								'sku'		  => $info['sku'],
								'user_id' 	  => $info['user_id'],
								'factory_id'  => $info['factory_id'],
								'object_type' => $type,
								'to_hide'	  => $info['to_hide'],
		);
		$rs = $sale_order_differ_product->add($insert_array); 
		unset($insert_array);
		return $rs;
    }

		/**
	 * 导出EXCEL表格
	 *
	 * @param string $main 导入路径	
	 * @param string $type	模板名称
	 * @param int $insert_type	//1替换 2跳过 
	 * @return string
	 */
	public function derivedExcel($main,$type,$file_name,$insert_type=1, $sheet	= 0){
		$sheet	= intval($sheet);
		$return_error['type']	=	1;  
 		if (empty($main) || empty($type)){ return $this->setExcelErrorMsg(1);}  
 		$this->insert_type	=	$insert_type;  
		///虚拟化数据 
		$relation_type	=10;//Excel
		$path	= getUploadPath($relation_type);
		$file_name	.= '.xls';
		if (file_exists($path . $type . '/' . $file_name)) {
			$path .= $type . '/';
		}
		$file	=	$path . $file_name;
		Vendor('PhpExcel.PHPExcel');
		$result	=	$this->Import_Execl($file);    
		///载入字段
		$field	=	$this->getExcelFields($type); 
		///验证导入字段列数量与实际模板列数是否相同 
		if (count($field)!=$result['data'][$sheet]['Cols']){   return $this->setExcelErrorMsg(2); } 
		///判断字段模板是否存在！
		if (!is_array($field)){  return $this->setExcelErrorMsg(3);	} 
		$excel_info	=	$this->excel_info;  
		$excel		=	$excel_info[$main];
		$this->excel_max_row	=	$excel['max_row']>0?$excel['max_row']:999; 
		if ($result["data"][$sheet]['Rows']>$this->excel_max_row){ return $this->setExcelErrorMsg(4,$this->excel_max_row); }   
		
		$excel['field']	=	$field;   
		$state			=	1; 
		$execl_data 	= $result["data"][$sheet]["Content"]; 
        unset($execl_data[1]);  
//        $_validate		=	$class_form_validate->getValidate($excel['valid']); //表单验证  
        $model 			= 	D($type);    
        $model_detail	=   D($excel['table_name']);
        $model->isAjax	=	true; 
        $add_auto_no	=	false;
		if (isset($excel) && isset($excel['auto_no']) && isset($excel['action'])){ 
			$max_no			=	$actionModel = A($excel['action'])->getMaxNo($type);
			$max_leng		=	strlen($max_no);
			$add_auto_no	=	$max_leng>0?true:false;
		}
		///预先的动作 
       if (isset($excel['befor_valid'])){     
       		$befor_valid	=	$this->$excel['befor_valid']($execl_data,$excel['replace'],$excel); 
       		if (is_array($befor_valid) && $befor_valid['type']==false){  return $this->setErrorMsg(4,0,$befor_valid['msg']); } 
       }
		///需要格式化的日期
		$option			= C('_dd_config_'); ///获取格式化基础信息  	
		$define_date	= $option['format_date'];///读取需要 日期格式化的字段 
	   $is_date	=	1;
	   ///验证是否有需要插入日期格式的字段
	   foreach((array)$excel['field'] as $k=>$v){  if (in_array($v,$define_date)){	$format_date[]	=	$v;	$is_date	=	2;	}	   }
		$array_merge	=	false;
		if (is_array($excel['default'])){ $array_merge	=	true; }
		///表单中唯一的验证
		$insertUnique	=	array();   
		///验证+补充信息 ;
        foreach((array)$execl_data as $k=>$v){  
        		foreach((array)$excel['field'] as $key=>$value){    
     		  		$d[$value] 	= $v[$key]; 
     		  		if (isset($excel['replace'][$value]['field'])){   
     		  			if ($excel['replace'][$value]['select']==true){ 
     		  				$defValue	=	$this->getReplaceId($v[$key],$excel['replace'][$value]); 
     		  				$d[$excel['replace'][$value]['field']]	=	empty($defValue)?$excel['replace'][$value]['default_value']:$defValue; 
     		  			}else{
     		  				$d[$excel['replace'][$value]['field']]	=	empty($d[$value])?$excel['replace'][$value]['default_value']:0;
     		  			}  
     		  		}
     		  		///判断是否是日期 如果是=》格式化 
     		  		if ($is_date==2 && in_array($value,$format_date)){ 
     		  			if (!empty($v[$key])){
//     		  				$d[$value]	=	gmdate("Y-m-d",PHPExcel_Shared_Date::ExcelToPHP($v[$key]));  
     		  				$d[$value]	=	$v[$key];  
     		  			}else {
     		  				$d[$value]	=	'';
     		  			}  
     		  		}
     		  		///切割数据 
     		  		if (isset($excel['explode']) && in_array($value,$excel['explode'])){  
     		  			$exploded[]	=	$value;
     		  			$d[$value]	=	explode(',',$v[$key]);
     		  		} 
     		  }
     		   
     		  if ($array_merge){ ///是否有默认值补充   
 		  			$jiaoji	=	array_intersect_key($d,$excel['default']); ///交集
 		  			foreach((array)$jiaoji as $keyJ=>$valueJ){  unset($excel['default'][$keyJ]); }    ///过滤交集的默认值
 		  			$d	=	array_merge($d,$excel['default']);
     		  } 
     		  ///自动补充值
     		  if ($add_auto_no && empty($d[$excel['auto_no']])){ 
					$max_no					= $max_no+1;
					$d[$excel['auto_no']]	= str_pad($max_no,$max_leng,'0',STR_PAD_LEFT); 
					$d['system_auto']		= true;  
			  }else{  
			  		$d['system_auto']		= false;
			  }     
			  ///验证数据
			  $_validdate	= $model->getValidDate();
				if (isset($_validdate)){  
					///客户输入的编号验证是否重复
					if ($d['system_auto']==true){
						$updateInfo	=	$model->where($excel['auto_no'].'=\''.$d[$excel['auto_no']].'\'')->find();
						if ($updateInfo['id']>0){$d['id']	=	$updateInfo['id'];}  
					}  
					///如果表单唯一没有被提取验证过，则获取表验证中唯一字段的值 
					if (!isset($insertUnique[$model->name])){ 
						$validArray = $model->getValidDate(); /// 获取验证规则
						foreach((array)$validArray as $validKey=>$validValue){  
							if (is_array($validValue) && isset($validValue[4]) && $validValue[4]=='unique'){ 
								$insertUnique[$model->name][]	=	 $validValue[0];
							}  
						}
						if (!is_array($insertUnique[$model->name])){ $insertUnique[$model->name]	=	false;} 
					} 
					if($insert_type==1){$model->valid_excel_unique_state	= false;}
					if($type=='Stocktake' || $type=='InitStorage'){
						$wInfo			= M('warehouse')->where('is_default=1')->field('id')->find();
						$default_w_id	= $wInfo['id'];   
						if ($default_w_id<=0){ return $this->setExcelErrorMsg(0,'请设置默认仓库,在重新导入数据'); } 
						if($type=='Stocktake'){
							$d	= array( 	
								'stocktake_no'			=>'',
								'stocktake_date'		=> date("Y-m-d"),
								'warehouse_id'			=>$default_w_id,
								'currency_id'			=>C('currency'),
								'employee_id'			=>0,
								'state'					=>1,
								'create_time'			=>date("Y-m-d H:i:s"),
								'detail'				=> array($d) );   
						}elseif ($type=='InitStorage'){
							$d	= array( 	
									'init_storage_no'		=>'',
									'init_storage_date'		=>date("Y-m-d"),
									'warehouse_id'			=>$default_w_id,
									'currency_id'			=>C('currency'),
									'create_time'			=>date("Y-m-d H:i:s"),
									'detail'				=> array($d)  );   
						}
					}
					$r	= $model->create($d);				/// 调用验证方法 
					if (!$r) { /// 验证失败   
						$error[$k] 	= $model->error;
						if($type=='Stocktake' || $type=='InitStorage'){
							foreach ($d['detail'] as $kk=>&$vv){
								$d	= $vv;
							}
						}
						$insert[$k]	=	$d;
						$state 		=	2;
						break ;		 								/// 验证失败
					} else {    				
						if($type=='Stocktake' || $type=='InitStorage'){
							foreach ($d['detail'] as $kk=>&$vv){
								$d	= $vv;
							}
						}
						/// 验证成功 
						$id	= $model->excel_ids; 
						if ($id['id']>0 && $d['id']<=0){ 
							if ($this->insert_type==2){ continue ;}
							$d['id']	=	$id['id']; 
						}  
						unset($d['system_auto']);
						$insert[$k]	=	$d; 
					} 					
				}else{ 
						unset($d['system_auto']);
						$insert[$k]	=	$d; 
				}
				unset($d); 
       }   
       ///预先的动作   
       if (isset($excel['befor_fn'])){
   	 		if($type == 'InitStorage'){
				addLang('InitStorage');
				$behavior	= new InitStoragePublicBehavior();
				$init_Info	=	array(
							'init_storage_no'		=>'',
							'init_storage_date'		=>date("Y-m-d"),
							'warehouse_id'			=>$default_w_id,
							'currency_id'			=>C('currency'),
							'create_time'			=>date("Y-m-d H:i:s"),
				);  
				$error_info	= $behavior->checkSam(@array_merge($init_Info,array('detail'=>$insert)),true);	
				if(isset($error_info)) return $this->setErrorMsg(4,0,'不能重复添加期初库存,请重试!');
				else $main_info	= $this->$excel['befor_fn']($insert,$model);
			}else{
       			$main_info	= $this->$excel['befor_fn']($insert,$model);   
			}
//       		if (is_array($beforError)){   $error[][]['show'] = $beforError['msg']; }
       }    
       ///验证表单是否有错误信息   
       if (is_array($error)){ return $this->setErrorArray($error);} 
       $insertCount	=	0;  ///处理总数量
       ///切割数组
        if (is_array($exploded)){              		 		
        		///特殊处理
 		 		$autoNo	=	array(
			 		 		'class_no'=>'productclass_no',
			 		 		'color_no'=>'color_no',
			 		 		'size_no'=>'size_no',
 		 		); 
         		 foreach((array)$insert as $key=>$value){   
         		 	foreach((array)$value as $key2=>$value2){     
             		 	if (is_array($value2)){ 
							if (is_array($autoNo)){  
								if (in_array($autoNo[$excel['replace'][$key2]['auto_no']],array('color_no','size_no','productclass_no'))){ 
             		 			if (C('setauto_'.$autoNo[$excel['replace'][$key2]['auto_no']])==2){ return $this->setErrorMsg(1,$key,L($excel['replace'][$key2]['auto_no']).',未开启自动编号,请与客服联系');}  
             		 				unset($autoNo[$excel['replace'][$key2]['auto_no']]);
	             		 		}  
							} 
             		 		$detail_insert[$key2][$key]							= $this->explodeInsert($value2,$excel['replace'][$key2]); 
             		 		$end												= end($detail_insert[$key2][$key]); 
             		 		isset($excel['replace'][$key2]['field'])	&&	$insert[$key][$excel['replace'][$key2]['field']]	= $end['id']; 
             		 		if (!isset($del_replace[$key2])){ $delReplace[$key2]	=	$key2;}  
             		 		unset($insert[$key][$key2]);
             		 	}
         		 	}
         		 }
         		///删除使用过的插入信息
				foreach((array)$delReplace as $key=>$value){ unset($excel['replace'][$value]);}   
         }
         if (isset($excel['replace'])){ 
			foreach((array)$excel['replace'] as $key=>$value){    
				///初始化实例化对象 
				$$value['tables']							=	$value['tables']; 
				if (isset($value['action'])){
					$excel['replace'][$key]['max_no']		=	A($value['action'])->_autoMaxNo(0,$$value['tables']);
					$excel['replace'][$key]['leng']			=	strlen($excel['replace'][$key]['max_no']); 
				} 
			} 
			$afterInsert	=	false;   
			foreach((array)$insert as $k=>$v){   
				 foreach((array)$excel['replace'] as $kr=>$vr){  
				 	///判断是否有后续操作
				 	if ($vr['after_insert']==true && $afterInsert==false){ $afterInsert	=	true;}
				 	///判断补充的信息是否有值如果有获取信息 
				 	if (!empty($v[$kr]) && !isset($vr['after_insert'])){ 
			  			$replace_model	=	D($$vr['tables']);   
			  			///如果是查询补充就过滤 
			  			if (!isset($excel['replace'][$kr]['select'])){ 
				  			$v_id	=	$this->getReplaceIdWithExcel($replace_model,$v[$kr],$excel['replace'][$kr]);    
				  			unset($replace_model);
				  			if ($v_id>0){
				  				$v[$vr['field']]	=	$v_id;
				  			}else{  
				  				$msg	=	 $v[$kr].'不存在,';
				  				return $this->setErrorMsg(2,$k,$msg); 
				  			}
			  			}   
				 	}  
				 }
//				 if($type == 'InitStorage'){
//					addLang('InitStorage');
//					$behavior	= new InitStoragePublicBehavior();
//					$error_info	= $behavior->checkSam(@array_merge($main_info,array('detail'=>$insert)),true);	
//				}
//				if(isset($error_info)) return $this->setErrorMsg(4,0,'不能重复添加期初库存,请重试!');
				 $id	=	$this->excelInsert($model,$v,$insertUnique,$main_info,$model_detail);  
				 if ($id==false){  return $this->setErrorMsg(2,$k); } 
				 $insertCount++;
				 $id>0	&& $insert[$k]	=	$id;
				 ///执行后插入
				 if ($afterInsert==true){
					 foreach((array)$excel['replace'] as $kr=>$vr){   
					 	///判断补充的信息是否有值如果有获取信息  
					 	if (!empty($v[$kr]) && $vr['after_insert']==true){  
						 	$excel['replace'][$kr]['default'][$excel['replace'][$kr]['field']]	=	$id;  
				  			$replace_model	=	D($$vr['tables']);   
				  			///如果是查询补充就过滤 
				  			if (!isset($excel['replace'][$kr]['select'])){   
					  			$v_id	=	$this->getReplaceIdWithExcel($replace_model,$v[$kr],$excel['replace'][$kr]);     
				  			}   
					 	}  
					 }				 	
				 } 
				 unset($id);
			} 
         }else{   
              foreach((array)$insert as $k=>$v){    
              	$id	=	$this->excelInsert($model,$v,$insertUnique);
              	if ($id==false){   return $this->setErrorMsg(2,$k); }    
              	$insertCount++;
              	$id>0	&& $insert[$k]	=	$id;
              	unset($id);
              }                        	
         }
       
		///预先的动作 
		if (isset($excel['after_fn'])){
			$info['insert']	=	$insert;
			$info['detail']	=	$detail_insert;
			$info['excel']	=	$excel;     
			$this->$excel['after_fn']($info);
		}  
		///生成缓存		
		if (isset($excel['dd']) && is_array($excel['dd'])){ foreach((array)$excel['dd'] as $k=>$v){cacheDd($v);} } 
        return $this->setErrorMsg(3,$insertCount);
	}   
	
	/**
	 * 返回错误提示数组信息
	 *
	 * @param array $error
	 * @return array
	 */
	public function setErrorArray($error){
		foreach((array)$error as $key=>$value){  
       			foreach((array)$value as $key2=>$value2){   
					if (isset($value2['show'])){ 
						$errorInfo	=	$this->setErrorMsg(1,$key,$value2['show']); 
						break 2;
					}else{
						$errorInfo	=	$this->setErrorMsg(1,$key); 
						break 2;
					}
//					$errorInfo	=	$this->setErrorMsg(1,$key,L($value2['name']).$value2['value']);  
       			} 
       	}
       	return $errorInfo;
	}
	
	/**
	 * 返回错误提示信息
	 *
	 * @param int $type
	 * @param string $key
	 * @param string $msg
	 * @return array
	 */
	public function setErrorMsg($type=1,$key=0,$msg=null,$success_count,$exists_count=-1){
		switch ($type){
			case 0:///处理操作验证
				$errorInfo['type']	=	false;
				$errorInfo['msg']	=	'第'.$key.'行,数据错误请修改!'.$msg;
				break;
			case 1:///返回行数的错误信息
				$errorInfo['msg']	=	'第'.$key.'行,数据错误请修改.'.$msg;
				break;
			case 2:///返回msg的错误信息
				$errorInfo['msg']	=	'第'.$key.'行,'.$msg.'插入有误,请重新导入,'.$msg; 
				break;
			case 3:///返回msg的错误信息 
			    //导入，更新，系统中已存在并且没有更新的数据      edit by lxt 2015.06.26
                if($success_count<0){//产品查验导入
                    $errorInfo['msg']	=	'成功导入'.$key.'条数据';
                }else{
                    if ($exists_count>=0){
                        $errorInfo['msg']   =   '成功导入'.$key.'条,成功更新'.$success_count.'条记录,其中'.$exists_count.'条记录已在系统中！';
                    }else{
                        $errorInfo['msg']	=	'成功导入'.$key.'条,还有'.$success_count.'条记录已经在系统中';
                    }
                    if (is_array($msg) && !empty($msg)) {
                        $errorInfo		= array_merge($errorInfo, $msg);
                    }      
                }			    
				break;		 
			case 4:
				$errorInfo['msg']	=	$msg;
				break;		
			case 5:
				$errorInfo['msg']	=	'数据不为空，请按格式填写数据！';
				break;	
			case 6://成功分页处理
			case 7://错误分页处理
				$errorInfo	= array(
						'firstRow'		=> $this->firstRow,
                        'sameRow'		=> $this->sameRow,
						'listRows'		=> $this->listRows,
						'totalRows'		=> $this->totalRows,
						'nowPage'		=> $this->nowPage,
						'nextPage'		=> $this->nowPage + 1,
						'totalPages'	=> $this->totalPages,
						'processCount'	=> $key,//成功处理记录数量
						'successCount'	=> $success_count,//成功处理记录数量
						'msg'			=> $msg,
				);
				break;
		}
		$errorInfo['type']	=	$type;
		return $errorInfo; 
	}
	
	
	/**
	 * 返回错误提示信息
	 *
	 * @param array $errorInfo
	 * @param mixed $msg
	 * @return array
	 */
	public function addErrorMsg(&$errorInfo,$msg=null){
		if (empty($errorInfo)) {
			$errorInfo	= $msg;
		} elseif (!empty($msg)) {
			$errorInfo['msg']	.= '<br /><br />' . (is_array($msg) ? $msg['msg'] : $msg);
		}
		return $errorInfo;
	}	
	
	/**
	 * Exl解析的错误信息
	 *
	 */
	public function setExcelErrorMsg($type,$message=null){
		$msgType	=	1;
		switch ($type){
			case 0:
				$msgType	=	0;
				$msg		=	$message;	
				break;
			case 1:
				$msgType	=	4;
				$msg		=	'异常错误,请重新导入';	
				break;
			case 2:
				$msgType	=	4;
				$msg		=	'导入模板格式错误,请重新导入';	
				break;
			case 3:
				$msgType	=	4;
				$msg		=	'模板文件出错,请联系客服';	
				break;	
			case 4:
				$msg		=	'太长了,超过'.$message.'个';   
				break;	 
			default:
				$msgType	=	4;
				$msg		=	'未知错误,请联系客服';	
		}
		//pr($this->setErrorMsg($msgType,0,$msg),'',1);
		return $this->setErrorMsg($msgType,0,$msg);
	}
	
	
	/**
	 * 返回相应需要查询的ID号码
	 *
	 * @param string $name
	 * @param array $replace
	 * @return int
	 */
	public function getReplaceId(&$name,&$replace){ 
		if (!is_object($this->newModel[$replace['tables']])){
			$this->newModel[$replace['tables']]	=	M($replace['tables']);
		} 
		$id = $this->newModel[$replace['tables']]->where($replace['insert_name'].'=\''.$name.'\'')->getField('id'); 
//		echo $this->newModel[$replace['tables']]->getLastSql();
//		exit;
		return $id; 
	}
	
	/**
	 * exl插入信息
	 *
	 * @param object $model
	 * @param array $insert
	 * @return int
	 */
	public function excelInsert(&$model,&$insert,&$insertUnique=array(),$main_info=null,$model_detail){ 
		///过滤掉数组中空值的部分
		$insert = array_diff($insert, array(null));  
		if ($insert['id']>0){ 
		 	///插入信息 或者 update
		 	if ($this->insert_type<>2){ 
		 		if(is_array($main_info)){
					$main_info['detail']	= array($insert);
					if($model->create($main_info)){
						$id	= $model_detail->save($insert); 
					}
				}else{ 
			 		if ($model->create($insert)) {	
			 			$model->save();   
			 		}
				}
		 		$id = $insert['id'];
		 	} 
		}else{    
			///插入前再一次判断唯一值是否已存在~！如果存在直接跳过 
			if (is_array($insertUnique[$model->name])){  
				$validName	=	$insertUnique[$model->name];
				$insertUniqueWhere	=	'';
				foreach((array)$validName as $key=>$value){  if (isset($insert[$value])){ $insertUniqueWhere[]=$value.'=\''.$insert[$value].'\'  '; } }  
				$info		=	$model->where(join(' or ',$insertUniqueWhere))->find();
				if (is_array($info)){ return $info['id']; }  
			}
			if(is_array($main_info)){
				$main_info['detail']	= array($insert);
				if($model->create($main_info)){
					unset($insert['product_no'],$insert['color_no'],$insert['size_no']);
					$id	= $model_detail->add($insert); 
				}
			}else{  
				if ($model->create($insert)) {	  
				 	///插入信息 或者 update  
				 	$id	= $model->add(); 
				}
			}
		}
		return $id; 
	}
 
	
	/**
	 * 关联插入
	 *
	 * @param array $info
	 * @param array $replace
	 * @return array
	 */
	public function explodeInsert($info,$replace){   
		if (!is_array($info)){ return ;}  
		$model	=	M($replace['tables']);   
		if (isset($replace['action'])){
			$replace['max_no']			=	A($replace['action'])->_autoMaxNo(0,$replace['tables']);  
			$replace['leng']			=	strlen($replace['max_no']);   			
		} 
		$pareant_id	=	0;
		foreach((array)$info as $key=>$value){ 
			///类别临时特殊处理
			if ($replace['tables']=='product_class'){  $replace['default']	=	array_merge($replace['default'],array('class_level'=>$key+1,'parent_id'=>$pareant_id));}
			$insert[$key]['name']	=	$value;
			$pareant_id	=	$insert[$key]['id']		=	$this->getReplaceIdWithExcel($model,$value,$replace);
		}    
		  
		return $insert; 
	}
	
	/**
	 * 返回关联ID
	 *
	 * @param object $model
	 * @param string $value
	 * @param array $array
	 * @return int
	 */
	public function getReplaceIdWithExcel($model,$value,&$array){ 
		$where	=	$array['insert_name'].'=\''.$value.'\'';
		$info	=	$model->where($where)->find();    
//		echo $model->getLastSql();  
//		echo '<br>';
		///如果已经存在返回ID 
		if (is_array($info) || $array['select']==true){ 
			$id	=	$info['id'];
		}else { 
			isset($array['insert_name'])	&&	$insert[$array['insert_name']]	=	$value; 
			if (isset($array['auto_no'])){
				$array['max_no']	=	$max_no	=	str_pad($array['max_no']+1,$array['leng'],'0',STR_PAD_LEFT);
				$insert[$array['auto_no']]	=	$max_no;
			}  
			if (isset($array['default']) && is_array($array)){	$insert =	array_merge($insert,$array['default']);}  
			is_array($insert)	&&	$id	=	$model->add($insert);
		}
		return $id;
	}
    
	function Import_Execl($file,$module=''){
		if(!file_exists($file)){
			return array("error"=>1);
		}
		Vendor("PHPExcel.PHPExcel");
		$PHPReader = new PHPExcel_Reader_Excel2007();                    
		if(!$PHPReader->canRead($file)){      
			$PHPReader = new PHPExcel_Reader_Excel5(); 
			if(!$PHPReader->canRead($file)){      
					return array("error"=>2);
			}
		}
		$PHPExcel = $PHPReader->load($file);
		$SheetCount = $PHPExcel->getSheetCount();
		$array	= array();
		for($i=0;$i<$SheetCount;$i++){
			$currentSheet = $PHPExcel->getSheet($i);
			$allColumn = $this->ExcelChange($currentSheet->getHighestColumn());   
			$allRow = $currentSheet->getHighestRow();  
			$array[$i]["Title"] =  $currentSheet->getTitle();
			$array[$i]["Cols"] = $allColumn;
			$array[$i]["Rows"] = $allRow;
			$arr = array();
			for($currentRow = 1 ;$currentRow<=$allRow;$currentRow++){
				$row = array();
				for($currentColumn=0;$currentColumn<$allColumn;$currentColumn++){ 
					$cell 				 = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow); 
                    switch ($module){
                    case 'SaleOrderImport':
                        $column = array(2);
                        break;
                    case 'ECPPSaleOrderImport':
                        $column = array(1,27);
                        break;
                    case 'PayPalSaleOrderImport':
                        $column =   array(11);
                        break;
                    }
					if(in_array($module, array('SaleOrderImport','ECPPSaleOrderImport','PayPalSaleOrderImport'))){
						//订单导入时间特殊处理
						if(in_array($currentColumn,$column)){
							$row[$currentColumn] = $this->excelTime(excel_import_filter($cell->getValue()));
						}else{
                            $row[$currentColumn] = $cell->getValue(); 
                            if(is_object($row[$currentColumn])){
                                $row[$currentColumn] = $cell->getFormattedValue(); 
                            }
						}
					}else{
						$row[$currentColumn] = $cell->getFormattedValue(); 
					}
//					if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){   
////					   $cellstyleformat=$cell->getParent()->getStyle( $cell->getCoordinate() )->getNumberFormat();  
////					   $formatcode=$cellstyleformat->getFormatCode();  
//					   $formatcode='yyyy-mm-dd';   
//					   if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode)) {    
//							 $row[$currentColumn]=gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($row[$currentColumn]));  
//					   }else{   
//							 $row[$currentColumn]=PHPExcel_Style_NumberFormat::toFormattedString($row[$currentColumn],$formatcode);  
//					   }  
//					}  
				} 
				$arr[$currentRow] = $row;
			} 
			$array[$i]["Content"] = $arr;
		}
		spl_autoload_register(array('Think','autoload'));///必须的，不然ThinkPHP和PHPExcel会冲突
		unset($currentSheet);
		unset($PHPReader);
		unset($PHPExcel);                
		//                unlink($file);   //删除上传的文件     
		return array("error"=>0,"data"=>$array);
	}

	function excelTime($date, $time = false) {  
		if(function_exists('GregorianToJD') && is_numeric( $date )){
			$jd = GregorianToJD( 1, 1, 1970 );
			$gregorian = JDToGregorian( $jd + intval ( $date ) - 25569 );
			$date = explode( '/', $gregorian );
			$date_str = str_pad( $date [2], 4, '0', STR_PAD_LEFT )
			."-". str_pad( $date [0], 2, '0', STR_PAD_LEFT )
			."-". str_pad( $date [1], 2, '0', STR_PAD_LEFT )
			. ($time ? " 00:00:00" : '');
			return $date_str;
		}else{
            if($date){
                if ($date>25568) {
                    $ofs=(70 * 365 + 17+2) * 86400;  
                    $date = date("Y-m-d",($date * 86400) - $ofs).($time ? " 00:00:00" : ''); 
                } else {
                    if (strpos($date,'/')) {//带斜杠的格式日期，判断第二个数字是否<=12,是则认为是日/月/年格式，否则为月/日/年格式
						list($day, $month, $year)	= explode('/', $date);
						if ($month <= 12 && valid_date($month . '/' . $day . '/' . $year)) {//优先支持日/月/年
							$date	=  $month . '/' . $day . '/' . $year;
						}
						if (valid_date($date) === false) {
							$date= str_replace('/', '-', $date);
						}
                    }
                    if (preg_match('/\d+-\d+-\d+/', $date) && valid_date($date)) {
                        $date   = date("Y-m-d H:i:s", strtotime($date));
					}
                }
            }
		}  
        if (date("Y-m-d", strtotime($date)) == '1970-01-01') {
            $date   = '';
        }
		return $date;  
	}  

	 public function ExcelChange($str){///配合Execl批量导入的函数
                $len = strlen($str)-1;
                $num = 0;
                for($i=$len;$i>=0;$i--){
                        $num += (ord($str[$i]) - 64)*pow(26,$len-$i);
                }
                return $num;
      }
        
     public function import(){
                if(isset($_FILES["import"]) && ($_FILES["import"]["error"] == 0)){
                        $result = $this->Import_Execl($_FILES["import"]["tmp_name"]);
                        if($this->Execl_Error[$result["error"]] == 0){
                                $execl_data = $result["data"][0]["Content"];
                                unset($execl_data[1]);
                                $data = D("Data");
                                foreach($execl_data as $k=>$v){
                                        $d["serial_no"] 	= $v[0];
                                        $d["check_no"] 		= $v[1];
                                        $d["work_no"] 		= $v[2];
                                        $d["class_name"] 	= $v[3];
                                        $d["user_name"] 	= $v[4];
                                        $d["new_class"] 	= $v[5];
                                        $d["error_level"] 	= $v[6];
                                        $data->data($d)->add();
                                }                                
                                $this->success($this->Execl_Error[$result["error"]]);
                        }else{
                                $this->error($this->Execl_Error[$result["error"]]);
                        }
                }else{
                        $this->error("上传文件失败");
                }
        }   
        public function ExcelData($val){//added by yyh 不存在字段处理
            if($val == null){
                return  '';
            }            
            return $this->execl_data[$val];
        }
        
        //移仓导入成功后向页面导入数据        add by lxt 2015.07.20
        public function afterShiftWarehouseDetail(&$info){
            
            //查询库位 
            foreach ($info['detail'] as $value){
                !empty($value['out_barcode_no']) && $location[] =   trim($value['out_barcode_no']);
                !empty($value['in_barcode_no'])  && $location[] =   trim($value['in_barcode_no']);
                !empty($value['product_no'])     && $product[]  =   trim($value['product_no']);
            }
            
            if (count($location) > 0){
                $where['barcode_no']    =   array("in",$location);   
                $location_id    =   M("Location")->where($where)->getField("barcode_no,id,warehouse_id");
				foreach ($location_id as $v){
					$w_ids[$v['warehouse_id']]	= $v['warehouse_id'];
				}
            }
			//仓库关联不可销售仓
			if(count($w_ids) > 0){
				//不可销售仓关联主仓
				$no_sale_warehouse	= M('warehouse')->where('relation_warehouse_id>0 and id in('.implode(',', $w_ids).')')->getField('id,relation_warehouse_id');
				foreach($no_sale_warehouse as $k=>$v){
					$w_ids[$k]	= $v;
				}
				$no_sold_warehouse_id	= M('warehouse')->where('is_use=1 and to_hide=1 and is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id in('.implode(',', $w_ids).')')
						->group('relation_warehouse_id')->getField("relation_warehouse_id,group_concat(id) as relation_warehouse");

			}
            //用于过滤不存在的sku
            if (count($product) > 0){
                $where['product_no']    =   array("in",$product);
                $sku    =   M("Product")->where($where)->getField("product_no",true);
            }
            $user	= getUser();	//
            //重组数据，如果输入的数据不存在的话，则过滤
            foreach ($info['detail'] as &$row){
                if (isset($location_id[$row['out_barcode_no']])){
                    $row['out_location_id']     =   $location_id[$row['out_barcode_no']]['id'];
                    $row['out_warehouse_id']    =   $location_id[$row['out_barcode_no']]['warehouse_id'];   
                }else {
                    unset($row['out_barcode_no']);
                }
				//仓库账号只能移动所属仓库的库位
				if($user['role_type']==C('WAREHOUSE_ROLE_TYPE') && $user['company_id']!=$w_ids[$row['out_warehouse_id']]){
					 unset($row['out_barcode_no']);
				}
                if (isset($location_id[$row['in_barcode_no']])){
                    $row['in_location_id']      =   $location_id[$row['in_barcode_no']]['id'];
                    $row['in_warehouse_id']     =   $location_id[$row['in_barcode_no']]['warehouse_id'];
                }else {
                    unset($row['in_barcode_no']);
                }
                //过滤不存在的sku
                if (!in_array($row['product_no'], $sku)){
                    unset($row['product_no']);
                }
				$current_main_warehouse_id	= $w_ids[$row['out_warehouse_id']];	//当前出库仓关联的主仓
				$no_sold_warehouse	= explode(',', $no_sold_warehouse_id[$current_main_warehouse_id]);
                //如果用户输入的移入库位和移出库位的所属仓库不一致，则删除移入库位
                if (isset($row['out_warehouse_id']) && ($current_main_warehouse_id!=$row['in_warehouse_id']) && (!in_array($row['in_warehouse_id'], $no_sold_warehouse))){
                    $row['in_warehouse_id']     =   $row['out_warehouse_id'];
                    unset($row['in_barcode_no'],$row['in_location_id']);
                }
            }
            
            $info               =   _formatList($info['detail']);
            $rs['detail']       =   $info['list'];
            $rs['detail_total'] =   $info['total']; 
            //用于判断数据来源，如果输入的库位都不存在，则通过这个变量重新触发页面的ShiftOutLocation函数更新autosearch条件
            $rs['import']       =   true;  
            
            //定义视图
            $view           =   Think::instance('View');
            $view->assign('rs', $rs);
            $view->assign('tpl_module_name', 'ShiftWarehouse');
            $view->assign('tpl_action_name', 'add');
            $info['html']	= $view->display('ShiftWarehouse:detail','','',true);
        }
        
        /// 产品查验导入
	    public function productCheckExcel($main,$type,$file_name,$insert_type=1,$sheet=0){
            $sheet			   = intval($sheet); 
            if (empty($main) || empty($type)){ return $this->setExcelErrorMsg(1);}  
            $this->insert_type = $insert_type;  
            ///虚拟化数据 
            $relation_type	   = 10;//Excel
            $path			   = getUploadPath($relation_type);
            $file_name		  .= '.xls';
            if (file_exists($path . $type . '/' . $file_name)) {
                $path		  .= $type . '/';
            }
            $file			   = $path . $file_name;
            Vendor('PhpExcel.PHPExcel');
            $result			   = $this->Import_Execl($file);    
            ///载入字段
            $field			   = $this->getExcelFields($type);
            //pr($field,'');pr($result,'',1)    
            ///验证导入字段列数量与实际模板列数是否相同 
            if (count($field) != $result['data'][$sheet]['Cols']){ return $this->setExcelErrorMsg(2); } 
            ///判断字段模板是否存在！
            if (!is_array($field)){  return $this->setExcelErrorMsg(3);	} 

            $excel_info		   = $this->excel_info;  
            $excel			   = $excel_info[$main];
            $this->excel_max_row = $excel['max_row']>0?$excel['max_row']:999; 
            if ($result["data"][$sheet]['Rows']<=1){ return $this->setErrorMsg(5); }   
            if ($result["data"][$sheet]['Rows']>$this->excel_max_row){ return $this->setExcelErrorMsg(4,$this->excel_max_row); }   

            $excel['field']	   = $field;  
            $execl_data 	   = $result["data"][$sheet]["Content"]; 
            $product_file      = $execl_data[1];
            unset($execl_data[1]); 
            $tips			   = C('PRODUCT_CHECK_IMPORT_TIPS');
            $success_count     =  0;//更新数量     
            $check_array       =  array();        
            //查找已存在的产品信息 st      
            foreach ((array)$execl_data as $value){
                $product_id[] =   trim($value[0]);
            }
            $where['id']          =   array("in",$product_id);
            $where['to_hide']     =   1;
            $exists               =   M('Product')->field("id")->where($where)->select();
            $edit_user		      =   intval(getUser('user_id')); 
            if (count($exists) > 0){
                foreach ($exists as $key=>$value){
                    $check_array[] = $value['id'];
                }
                $never_existed     =  array_diff($product_id,$check_array);//在数据库里不存在的产品ID
            }
		   //查找已存在的产品信息 ed
		
            foreach((array)$execl_data as $k=>$v){  
                $field_data	= array();
                $is_empty	= true;
                $row_data = $return_error  = array();
                foreach((array)$excel['field'] as $key=>$value){
                    $field_data[$value] 	= $v[$key];
                    if (trim($field_data[$value]) != '') {
                        $is_empty	= false;
                    }
                }
                if ($is_empty) {//过滤空数据
                    continue;
                }
               if(trim($v[5])){
                    if(trim($v[5])=='通过'){
                        $check_status  = 1;
                    }elseif (trim($v[5])=='未通过'){
                        $check_status  = 2;
                    }else{
                        $check_status  = 99;
                        $return_error['check_status'] = $tips['check_status'].'：'.'填写错误';
                    }
                }                
                $row_data['id']            = trim($v[0]);
                $row_data['check_weight']  = trim($v[1]);
                $row_data['check_long']    = trim($v[2]);
                $row_data['check_wide']    = trim($v[3]);
                $row_data['check_high']    = trim($v[4]);
                $row_data['check_status']  = $check_status?$check_status:trim($v[5]);
                foreach ($row_data as $key => $value) {
                    if(empty($value)){
                        $return_error[$key] = $tips[$key].'：'.'不能为空';
                    }else{
                        if(!preg_match("/^([1-9](\d*)((\.\d+)?|(\,\d+)?)|(0{1}(\.|\,)(\d*[1-9]{1}\d*)))$/",$value)){
                            $return_error[$key] = $tips[$key].'：'.'数字格式错误';
                        }                        
                    }                   
                }
                if(isset($never_existed)){
                    if(in_array($row_data['id'],$never_existed)){
                        $return_error['id'] = $tips['id'].'：'.'不存在';
                    }
                }
                if(is_array($return_error)&&$return_error){
                    return $this->setErrorMsg(1,$k,'<br/><br/>'.implode('<br/>',$return_error).'<br/><br>');
                }
                $original[$row_data['id']]['check_weight']    =   $row_data['check_weight'];
                $original[$row_data['id']]['check_long']      =   $row_data['check_long'];
                $original[$row_data['id']]['check_wide']      =   $row_data['check_wide'];
                $original[$row_data['id']]['check_high']      =   $row_data['check_high'];
                $original[$row_data['id']]['check_status']    =   $row_data['check_status'];
                $original[$row_data['id']]['edit_user']       =   $edit_user;
                $original[$row_data['id']]['lock_version']    =   array('exp', C('LOCK_NAME') . '+1'); 
                unset($row_data,$return_error,$check_status); 
            }
            
            if($original){
                foreach ($original as $row => $main) {
                    $data	= array(
                               'check_weight'  =>$main['check_weight'],
                               'check_long'    =>$main['check_long'],
                               'check_wide'    =>$main['check_wide'],
                               'check_high'    =>$main['check_high'],
                               'check_status'  =>$main['check_status'],
                               'edit_user'     =>$main['edit_user'],
                               'lock_version'  =>$main['lock_version'],
                            );
                    $list    = M('Product')->where('id='.$row)->setField($data); 
                    $log     = '产品查验导入，ID: '.$row;
                    $log_ary []= array('module'=>'Product','action'=>'productCheckExcel','user_id'=>getUser('id'),'content'=>$log,'ip'=>get_client_ip(),'insert_time'=>date("Y-m-d H:i:s"));
		            
                    if($list == false){
                        return $this->setErrorMsg(4,0,'导入失败!!');
                    }
                    //更新记录数   
                    $success_count++;               
                }
                $log_list  = M('Log')->addAll($log_ary);
                if($log_list == false){
                   return $this->setErrorMsg(4,0,'导入失败!!');
                }
            } 
		    return $this->setErrorMsg(3,$success_count,null,-1);
        }
}
?>