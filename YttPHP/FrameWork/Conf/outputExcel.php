<?php
return array(
 'Product' =>array(//产品
 		'sql'			=> 'SELECT a.custom_barcode,a.warning_quantity,a.id,a.product_no,a.product_name,a.factory_id,a.cube_high*a.cube_wide*a.cube_long as cube,a.weight,a.check_high*a.check_wide*a.check_long as check_cube,a.check_weight,a.check_status,a.comments,a.cube_high,a.cube_wide,a.cube_long,a.check_high,a.check_wide,a.check_long FROM product a 
 							left join gallery c on(a.id=c.relation_id and c.relation_type=1) 
							 WHERE '.getWhere($_SESSION[$_GET['rand']]['main']).getBelongsWhere('a').' GROUP BY a.id' . ($_SESSION[$_GET['rand']]['pics'] == 1 ? ' having count(c.id)>0 ' : '') . ' ORDER BY a.id desc',
 		'title'			=> array(
								'ID',
		 						'SKU',
                                '产品名称',
								'产品条码',
								'所属卖家',
								'尺寸',
								'重量',
                                '查验产品尺寸',
                                '查验重量',
                                '查验状态',
                                '库存预警',
                                '材质说明',
                                'Hs Code',
                                '体积重',
                                '申报价值($)',
                                '销售价格(€)',
						   ),
 		'content'		=> array(
                                //主表
								'id',
	 							'product_no',
								'product_name',
                                'custom_barcode',
	 							'factory_id',
	 							'cube',
	 							'weight',
                                's_check_cube',
                                's_check_weight',
                                'dd_check_status',
                                'warning_quantity',
                                //明细
                                'material_description',
                                'hs_code',
                                's_volume_weight',
                                'module_declaredvalue',
                                'selling_price',
	 						)
  	),
  	'Properties' =>array(//属性
		'sql'			=> 'SELECT properties_no,properties_name,properties_type  FROM `properties`  
							where '.getWhere($_SESSION[$_GET['rand']]).' and to_hide="1" ORDER BY id desc',
 		'title'			=> array(
		 						'属性编号',
								'属性名称',
								'属性类型',
						   ),
 		'content'		=> array(
	 							'properties_no',
	 							'properties_name',
	 							'dd_properties_type',
	 						)
  	),
  	'Client' =>array(//买家
		'sql'			=> 'SELECT * FROM `client`  
							where '.getWhere($_SESSION[$_GET['rand']]).' ORDER BY id desc',
 		'title'			=> array(
		 						'编号',
								'收货人',
								'税号',
								'所属国家',
								'所在城市',
								'街道一',
								'街道二',			
								'联系电话',
								'邮政编码',
								'传真号码',
								'E-mail',
						   ),
 		'content'		=> array(
	 							'comp_no',
	 							'comp_name',
	 							'tax_no',
	 							'country_name',
	 							'city_name',
								'address',
								'address2',
	 							'mobile',
	 							'post_code',
	 							'fax',
	 							'email',
	 						)
  	),
  	'Factory' =>array(//卖家
		'sql'			=> 'SELECT c.*,min(u.create_time) as create_time FROM `company`  c
                            left join user u on u.company_id=c.id and u.user_type=2
							where '.getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']],'c.')).' and  comp_type=1 group by c.id ORDER BY id desc',
 		'title'			=> array(
//		 						'编号',
								'E-mail',
								'卖家名称',
								'联系人',
								'联系电话',
                                '公司英文简称',
                                '与海外仓主要联系人的QQ号',
                                '注册时间',
								'所属国家',
								'所在城市',
								'街道一',
								'街道二',				
								'邮政编码',
								'传真号码',
								'备注说明',
						   ),
 		'content'		=> array(
//	 							'comp_no',
								'email',
	 							'comp_name',
								'contact',
								'mobile',
                                'basic_name_en',
                                'warehouse_connection_qq',
                                'create_time',
	 							'country_name',
	 							'city_name',
								'address',
								'address2',			
	 							'post_code',
	 							'fax',
	 							'comments',
	 						)
  	),
  	'Logistics' =>array(//快递公司
		'sql'			=> 'SELECT * FROM `company`  
							where '.getWhere($_SESSION[$_GET['rand']]).' and  comp_type=2 ORDER BY id desc',
 		'title'			=> array(
		 						'编号',
								'物流公司名称',
								'税号',
								'联系人',
								'联系电话',
								'所属国家',
								'所在城市',
								'街道一',
								'街道二',
								'邮政编码',
								'传真号码',
								'E-mail',
								'备注说明',
						   ),
 		'content'		=> array(
	 							'comp_no',
	 							'comp_name',
	 							'tax_no',
	 							'contact',
	 							'mobile',
	 							'country_name',
	 							'city_name',
								'address',
								'address2',	
	 							'post_code',
	 							'fax',
								'email',
	 							'comments',
	 						)
  	),
	'Express' =>array(//快递公司
		'sql'			=> 'SELECT * FROM `company`  
							where '.getWhere($_SESSION[$_GET['rand']]).' and  comp_type=3 ORDER BY id desc',
 		'title'			=> array(
		 						'编号',
								'快递公司名称',
								'税号',
								'联系人',
								'优先级',
								'联系电话',
								'所属国家',
								'所在城市',
								'街道一',
								'街道二',
								'邮政编码',
								'传真号码',
								'E-mail',
								'备注说明',
						   ),
 		'content'		=> array(
	 							'comp_no',
	 							'comp_name',
	 							'tax_no',
	 							'contact',
								'priority',
	 							'mobile',
	 							'country_name',
	 							'city_name',
								'address',
								'address2',	
	 							'post_code',
	 							'fax',
								'email',
	 							'comments',
	 						)
  	),
  	'OtherCompany' =>array(//其他来往单位
		'sql'			=> 'SELECT * FROM `company`  
							where '.getWhere($_SESSION[$_GET['rand']]).' and  comp_type=3 ORDER BY id desc',
 		'title'			=> array(
		 						'其他来往单位编号',
								'其他来往单位名称',
								'税号',
								'所在国家',
								'所在城市',
								'联系人',
								'联系电话',
								'联系地址',
								'邮政编码',
								'传真号码',
								'E-mail',
								'备注说明',
						   ),
 		'content'		=> array(
	 							'comp_no',
	 							'comp_name',
	 							'tax_no',
	 							'country_name',
	 							'city_name',
	 							'contact',
	 							'phone',
	 							'address',
	 							'post_code',
	 							'fax',
	 							'comments',
	 						)
  	),
  	'Basic' =>array(//公司列表
		'sql'			=> 'SELECT * FROM `basic`  
							where '.getWhere($_SESSION[$_GET['rand']]).' ORDER BY id desc',
 		'title'			=> array(
		 						'公司名称',
								'税号',
								'地址',
								'联系人',
								'联系电话',
								'传真',
								'E-mail',
								'通知单信息',
						   ),
 		'content'		=> array(
	 							'basic_name',
	 							'tax_no',
	 							'address',
	 							'contact',
	 							'phone',
	 							'fax',
	 							'email',
	 							'bank_account',
	 						)
  	),
  	'Warehouse' =>array(//仓库
		'sql'			=> 'SELECT * FROM `warehouse`  
							where '.getWhere($_SESSION[$_GET['rand']]).' ORDER BY id desc',
 		'title'			=> array(
		 						'仓库编号',
								'仓库名称',
								'是否可用',
                                '币种',
								'仓库地址',
								'仓库规格',
								'仓库面积',			
								'默认仓库',
								'房东',
								'联系人',
								'地址',
								'联系电话',
								'QQ',
								'E-mail',	
								'税号',
								'银行信息',
								'银行账号',
								'备注',
						   ),
 		'content'		=> array(
	 							'w_no',
	 							'w_name',
								'dd_is_use',
                                'currency_no',
	 							'w_address',
								'size',
	 							'area',			
	 							'dd_is_default',
								'landlord',
								'contact',
								'address',
								'phone',
								'fax',
								'email',	
								'tax_no',
								'bank_info',
								'bank_no',			
	 							'comments',
	 						)
  	),
  	'WarehouseLocation' =>array(//仓库
		'sql'			=> 'SELECT * FROM `warehouse_location`  
							where '.getWhere($_SESSION[$_GET['rand']]).' ORDER BY id desc',
 		'title'			=> array(
		 						'所属仓库',
								'库位类型',
								'库区编号',
								'货架列数',
								'货架层数',
								'每层单位数',
								'路径优先级',			
								'备注',
						   ),
 		'content'		=> array(
	 							'w_name',
	 							'dd_zone_type',
								'location_no',
	 							'col_number',
								'layer_number',
	 							'box_number',			
	 							'path_sort',		
	 							'comments',
	 						)
  	),	
  	'Location' =>array(//仓库
		'sql'			=> 'SELECT * FROM `location`  
							where warehouse_location_id='.$_GET['id'].' ORDER BY id asc',
 		'title'			=> array(
								'库位编号',
								'货架编号',
								'货层编号',
								'单位编号',
								'路径优先级',			
						   ),
 		'content'		=> array(
								'barcode_no',
	 							'col_no',
								'layer_no',
	 							'box_no',			
	 							'path_sort',		
	 						)
  	),		
  	'District' =>array(//国家
		'sql'			=> 'SELECT a.district_name,b.district_name as city_name FROM `district` as a 
							INNER join district as b on(a.id=b.parent_id and b.parent_id>0)
							where '.getWhere($_SESSION[$_GET['rand']]).'   ORDER BY a.id desc',
 		'title'			=> array(
		 						'国家名称',
								'城市名称',
						   ),
 		'content'		=> array(
	 							'district_name',
	 							'city_name',
	 						)
  	),
	'Package' =>array(//包装列表
		'sql'           => 'SELECT *,concat(weight,"'.L('WEIGHT_UNIT').'") as weight,
								concat("'.L('long').'",cube_long," '.L('SIZE_UNIT').' * '.L('wide').'",cube_wide," '.L('SIZE_UNIT').' * '.L('high').'",cube_high," '.L('SIZE_UNIT').'","=",round(cube_long*cube_wide*cube_high,4),"'.L('VOLUME_SIZE_UNIT').'") as cube
							FROM `package`
							WHERE '.getWhere($_SESSION[$_GET['rand']]).' ORDER BY id desc',
 		'title'			=> array(
								'包装名称',
		 						'包装规格',
								'重量',
								'费用',
								'备注',
						   ),
 		'content'		=> array(
								'package_name',
	 							'cube',
	 							'weight',
								'price',
								'comments',
	 						)
  	),	
  	'Employee' =>array(//员工
		'sql'			=> 'SELECT *,if(sex=1,"男","女") as sex_name FROM `employee`
							where '.getWhere($_SESSION[$_GET['rand']]).'   ORDER BY id desc',
 		'title'			=> array(
		 						'员工编号',
								'员工姓名',
								'性别',
								'联系电话',
								'E-mail',
								'注意事项',
						   ),
 		'content'		=> array(
	 							'employee_no',
	 							'employee_name',
								'sex_name',
	 							'phone',
	 							'email',
	 							'comments',
	 						)
  	),
  	'Bank' =>array(//银行
		'sql'			=> 'SELECT * FROM `bank`
							where '.getWhere($_SESSION[$_GET['rand']]).' ORDER BY bank_name desc',
 		'title'			=> array(
		 						'银行简称',
								'银行名称',
								'币种名称',
								'银行卡号',
								'联系人',
								'联系电话',
								'联系地址',
								'备注说明',
						   ),
 		'content'		=> array(
	 							'account_name',
	 							'bank_name',
	 							'currency_no',
	 							'account',
								'contact',
	 							'phone',
	 							'address',
	 							'comments',
	 						)
  	),
  	'PayClass' =>array(//其他收入/支出类型列表
		'sql'			=> 'SELECT * FROM `pay_class`
							where '.getWhere($_SESSION[$_GET['rand']]).' and relation_object=1  ORDER BY id desc',
 		'title'			=> array(
		 						'类型',
								'名称',
						   ),
 		'content'		=> array(
	 							'dd_pay_type',
	 							'pay_class_name',
	 						)
  	),
  	'FundsClass' =>array(//往来单位款项类别列表
		'sql'			=> 'SELECT * FROM `pay_class`
							where '.getWhere($_SESSION[$_GET['rand']]).' ORDER BY id desc',
 		'title'			=> array(
								'款项类别名称',
								'款项类别类型',
								'关联对象',
								'关联单据',
		 						'备注',
						   ),
 		'content'		=> array(
								'pay_class_name',
								'dd_pay_type',
								'dd_relation_object',
								'dd_relation_type',
	 							'edit_comments',
	 						)
  	),	
  	'Barcode' =>array(//条形码
		'sql'			=> 'SELECT * FROM `barcode`
							where '.getWhere($_SESSION[$_GET['rand']]).'   ORDER BY id desc',
 		'title'			=> array(
		 						'条形码号',
								'产品号',
								'产品名称',
						   ),
 		'content'		=> array(
	 							'barcode_no',
	 							'product_no',
	 							'product_name',
	 						)
  	),

	//追踪单号 取待处理
	'exportSaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.warehouse_id,a.factory_id,a.express_id,a.sale_order_no,a.weight,a.volume_weight,
					  b.company_name,b.transmit_name,b.country_name,b.city_name,b.country_id,b.address,b.address2,b.post_code,
					  c.id,c.comp_no as client_no,b.mobile as client_mobile,b.email as client_email,b.consignee,b.mobile,
					  d.company_id,d.calculation,a.cube_high,a.cube_wide,a.cube_long
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'Nr.',
					 'Kunden Nr.',
					 'Empf. TEL',//电话号码
					 'Empf. Name 1',
					 'Empf. Name 2',
					 'Empf. Name 3',
					 'Empf. Str. + Nr.',
					 'Empf. PLZ',
					 'Empf. Ort',
					 'Empf. Provinz',
					 'Empf. LKZ (ISO D-DE)',            
					 'Paket Quantität',//包裹数量
					 'Paket Gewicht',
					 'Alternativ Abs. Name 1',
					 'Frankatur KZ',
					 'Empf. Email',
		),
		'content' => array(
					 'sale_order_no',
					 'client_no',
//					 'client_name',
					 'consignee',
					 'mobile',//电话号码
					 /*
					 'company_name',
					 'transmit_name',
					 'merge_address',
					 */
					 'address2',
					 'company_name',
					 'address',
					 'post_code',
					 'city_name',     
					 'province_name',     
					 'country_code',  
					 'anzahl_sendungen',//包裹数量
					 'weight',
					 'consignor',
					 'payment',
					 'client_email',  
		),
	),
	'exportItBrtSaleOrder'  => array(
        'sql'     =>'SELECT b.email,c.brt_account_no,a.id as sale_order_id,a.sale_order_no,a.warehouse_id,a.weight,a.volume_weight,b.consignee,b.mobile,b.address,b.address2,b.city_name,b.post_code,b.company_name,b.country_id,b.email as client_email,d.calculation
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `express` d ON a.express_id=d.id
					  INNER JOIN company c ON c.id=a.factory_id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
        'title'   => array(
            'BDA',
            'DESTINATARIO',
            'N.TEL-prodotto_id',
            'email destinatario',	
            'via', 
            'c.postalelocalità',	
            'city',
            'sigla',	
            'italy',	
            'peso',
            'spedizione',	
            'mittente',
            'assicurazione_si/no',
            'valore_merce',
            'The seller BRT account',//卖家BRT帐号
            'Value of goods',//货物价值
            'note',//备注
        ),
        'content' => array(
            'sale_order_no',
            'consignee',
            'mobile',
            'email',
            'address',
            'post_code',
            'city_name',
            'company_name',
            'country_id',
            'weight',
            'spedizione',
            'warehouse_id',
            'assicurazione_si_no',
            'valore_merce',
            'brt_account_no',//卖家BRT帐号
            'goods_cost',//货物价值
            'comment',//备注
        ),
    ),
	//追踪单号 DHL
	'exportDhlSaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.warehouse_id,a.factory_id,a.express_id,a.sale_order_no,a.weight,a.volume_weight,
					  b.company_name,b.transmit_name,b.country_name,b.city_name,b.country_id,b.address,b.address2,b.post_code,b.mobile,b.email as client_email,b.consignee,
					  d.company_id,d.calculation
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'POOL_REFNR',
					 'POOL_VERFAHREN',
					 'POOL_TEILNAHME',
					 'POOL_PRODUKT_CN',
					 'POOL_EXTRASLST',
					 'POOL_EMPF_NAME1',
					 'POOL_EMPF_NAME2',
					 'POOL_EMPF_NAME3',
					 'POOL_EMPF_PLZ',
					 'POOL_EMPF_ORT',
					 'POOL_EMPF_ORTTEIL',
					 'POOL_EMPF_STRASSE',
					 'POOL_EMPF_HAUSNR',
					 'POOL_EMPF_TEL',
					 'POOL_EMPF_EMAIL',
					 'POOL_EMPF_LANDCODE',
					 'POOL_GEWICHT',
					 'POOL_ANZAHL_SENDUNGEN',
					 'POOL_V_ZOLL_WARENLISTE',
		),
		'content' => array(
					 'sale_order_no',
					 'verfahren',         //目前除了德国本地的填01外。其他国家全部填54
					 'teilnahme',
					 'produkt_cn',	      //目前除德国本地选择101外，其他国家全部填5401
					 'extraslst',
					 'consignee',
					 /*
					 'company_name',
					 'transmit_name',
					 */
					 'address2',
					 'company_name',
					 'post_code',
					 'city_name',
					 'empf_ortteil',
					 'address',
					 //'address2',
					 'empf_hausnr',
					 'mobile',
					 'client_email',
					 'abbr_district_name',
					 'weight',
					 'anzahl_sendungen',
					 'v_zoll_warenliste',
		),
	),
	
	//追踪单号 德国邮政
	'exportDeutscheSaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.warehouse_id,a.factory_id,a.express_id,a.sale_order_no,a.weight,
					  b.company_name,b.transmit_name,b.country_name,b.city_name,b.country_id,b.address,b.address2,b.post_code,
					  c.id,c.comp_no as client_no,b.email as client_email,b.consignee,d.shipping_type,b.mobile,
					  d.company_id
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'NAME',
					 'ZUSATZ',
					 'STRASSE',
					 'NUMMER',
					 'PLZ',
					 'STADT',
					 'LAND',
					 'ADRESS_TYP',
		),
		'content' => array(
					 'consignee',
					 'address2',
					 'address',
					 'number',
					 'post_code',
					 'city_name',
					 'abbr_district_name',
					 'adress_typ',
		),
	),
    'expressFrPostSaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.warehouse_id,a.factory_id,a.express_id,a.sale_order_no,a.weight,a.volume_weight,a.is_registered,
					  b.company_name,b.transmit_name,b.country_name,b.city_name,b.country_id,b.address,b.address2,b.post_code,
					  c.id,c.comp_no as client_no,b.email as client_email,b.consignee,d.shipping_type,b.mobile,d.calculation,
					  d.company_id
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'ORDER NO',
					 'CONSIGNEE',
					 'ADDRESS',
					 'ADDRESS2',
                     'NUM',
					 'POST CODE',
					 'CITY',
					 'COUNTRY',
					 'PRODUCT',
                     'NUM',
                     'MOBILE',
                     'NUM',
                     'NUM',
                     'EMAIL',
                     'NUM',
                     'NUM',
                     'NUM',
                     'IS REGISTERED',
                     'ORDER NO',
                     'WEIFHT',
                     'NUM',
                     'NUM',
		),
		'content' => array(
            'sale_order_no',
            'consignee',
            'address',
            'address2',
            'num10',
            'post_code',
            'city_name',
            'abbr_district_name',
            'product_id',
            'num0',
            'mobile',
            'num1',
            'num11',
            'client_email',
            'num3',
            'num4',
            'num5',
            'is_registered',
            'sale_order_no1',            
            'weight',
            'num8',
            'num9'
            ),             
	),
//    'exportFrGlsSaleOrder'    => array(
//        //处理单号   产品ID 数量  街道1 街道2 邮编  所在城市  客户电话 传真   重量 E-mail 
//        'sql'       => 'SELECT a.sale_order_no,a.id as sale_order_id,b.consignee,b.address,b.address2,b.post_code,b.city_name,b.country_id,b.mobile,b.fax,a.weight,b.email
//					  FROM `sale_order` a
//					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
//					  INNER JOIN `client` c ON a.client_id=c.id
//					  INNER JOIN `express` d ON a.express_id=d.id
//					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
//					  ORDER BY a.id desc',
//        'title'     => array(
//            //序号	处理单号	收货人	合同代码	产品编码	GLS账号	发货人 2	街道1	街道2	地址 3	邮编	所在城市	国家	客户电话	移动电话	重量	E-mail	Code NUIT
//
//        ),
//        'content'   => array(
//           // 'serial_no',//序号自增
//            'sale_order_no',//处理单号
//            'consignee',
//            'contract_no',//合同代码
//            'product_id',
//            'GLS_account',//GLS帐号
//            'consignor2',//发货人2
//            'address',
//            'address2',
//            'address3',//地址3
//            'post_code',
//            'city_name',
//            'country_id',//国家
//            'mobile',
//            'fax',
//            'weight',
//            'email',            
//            'code_nuit',
//        ),
//    ),
	
	'SaleOrder'	  => array(
					  'sql'     => 'SELECT distinct `id` FROM `sale_order` 
									WHERE EXISTS(select 1 from sale_order_detail inner join product on product.id=sale_order_detail.product_id where sale_order_id=sale_order.id 
									and '.getWhere($_SESSION[$_GET['rand']]['sale_order_detail']).' ) 
									and EXISTS(select 1 from sale_order_addition where sale_order_addition.sale_order_id=sale_order.id and '.getWhere($_SESSION[$_GET['rand']]['sale_order_addition']).' ) 
									and '.getWhere($_SESSION[$_GET['rand']]['sale_order']).' 
									ORDER BY order_no desc',
		'title'   => array(
					 L('deal_no'),
					 L('orderno'),
                     L('belongs_seller'),
					 L('clientname'),
                     L('country_destination'),
					 L('sale_date'),
					 L('out_stock_date'),
					 L('order_type'),
					 L('sale_order_state'),
                     L('sale_order_weight'),
                     L('volume_weight_detail'),
					 L('express_way'),
					 L('postcode'),
					 L('delivery_costs'),
					 L('process_fee'),
					 L('package_fee'),
					 L('insure_price'),
					 L('shipping_warehouse'),
					 L('track_no'),
					 L('product_id'),
					 L('product_no'),
					 L('quantity'),	
		),
		'content' => array(
					 'sale_order_no',
					 'order_no',
                     'factory_name',
					 'client_name',
                     'country_name',
					 'fmd_order_date',
					 'fmd_go_date',
					 'order_type_name',
					 'dd_sale_order_state',
                     'edml_weight',
                     'edml_volume_weight',//体积重
					 'ship_name',
					 'post_code',		//邮政编码
					 'dml_delivery_fee',//快递费用
					 'dml_process_fee',//处理费用
					 'dml_package_fee',//保证费用
					 'dml_insure_price',//投保金额
					 'w_name',
					 'track_no',
					 'product_id',
					 'product_no',
					 'quantity', 
		),
	),
	
  	'InstockImport' =>array(//入库列表
		'sql'			=> 'SELECT * FROM `file_list`
							where '.getWhere($_SESSION[$_GET['rand']]) . ' and file_type=' . array_search('InstockImport', C('CFG_FILE_TYPE')) . ' ORDER BY id desc',
 		'title'			=> array(
		 						'入库单号',
								'仓库名称',
								'制单时间',
		 						'制单人员',
								'商品ID个数',
								'商品总数量',
		 						'异常ID个数',
								'异常总数量',
								'注意事项',			
						   ),
 		'content'		=> array(
	 							'file_list_no',
	 							'w_name',
	 							'fmd_create_time',
	 							'add_real_name',
								"product_count",
								"quantity",
								"product_error_count",
								"error_quantity",
								"edit_comments",	
	 						)
  	),	
	
  	'Picking' =>array(//拣货导出列表
		'sql'			=> 'SELECT * FROM `file_list`
							where '.getWhere($_SESSION[$_GET['rand']]) . ' and file_type=' . array_search('Picking', C('CFG_FILE_TYPE')) . ' ORDER BY id desc',
 		'title'			=> array(
		 						'拣货单号',
								'仓库名称',
								'制单时间',
		 						'制单人员',
								'商品ID个数',
								'商品总数量',
								'注意事项',			
						   ),
 		'content'		=> array(
	 							'file_list_no',
	 							'w_name',
	 							'fmd_create_time',
	 							'add_real_name',
								"product_count",
								"quantity",
								"edit_comments",	
	 						)
  	),	
	
  	'PickingImport' =>array(//拣货导入列表
		'sql'			=> 'SELECT * FROM `file_list`
							where '.getWhere($_SESSION[$_GET['rand']]) . ' and file_type=' . array_search('PickingImport', C('CFG_FILE_TYPE')) . ' ORDER BY id desc',
 		'title'			=> array(
		 						'拣货导入单号',
								'仓库名称',
								'制单时间',
		 						'制单人员',
								'商品ID个数',
								'商品总数量',
		 						'异常ID个数',
								'异常总数量',
								'注意事项',			
						   ),
 		'content'		=> array(
	 							'file_list_no',
	 							'w_name',
	 							'fmd_create_time',
	 							'add_real_name',
								"product_count",
								"quantity",
								"product_error_count",
								"error_quantity",
								"edit_comments",	
	 						)
  	),		
	
  	'Storage' =>array(//库存列表
		'sql'			=> 'select *,
									sum(onroad_qn) as onroad_quantity,
									sum(sale_qn) as sale_quantity,
									sum(real_qn) as real_quantity,
									sum(real_qn)-sum(sale_qn) as reserve_quantity
						   from (
								select 
									p.*,p.cube_high*p.cube_wide*p.cube_long as cube,p.check_high*p.check_wide*p.check_long as check_cube,
                                    b.warehouse_id,a.product_id,a.quantity as onroad_qn,0 as sale_qn, 0 as real_qn, 0 as reserve_qn 
								from instock_detail a 
								left join instock b on b.id=a.instock_id 
								left join product p on p.id=a.product_id
                                left join warehouse w on w.id=b.warehouse_id 
								where ' . getWhere($_SESSION[$_GET['rand']]) . getBelongsWhere('p') .getAllWarehouseWhere('b'). ' and b.instock_type >= ' . C('CFG_INSTOCK_TYPE_UNEDIT') . ' and a.in_quantity <= 0
								union all
								select 
									p.*,p.cube_high*p.cube_wide*p.cube_long as cube,p.check_high*p.check_wide*p.check_long as check_cube,
                                    a.warehouse_id,a.product_id,0 as onroad_qn,a.quantity as sale_qn, 0 as real_qn, 0 as reserve_qn 
								from sale_storage a
								left join product p on p.id=a.product_id
                                left join warehouse w on w.id=a.warehouse_id 
								where ' . getWhere($_SESSION[$_GET['rand']]) . getBelongsWhere('p') .getAllWarehouseWhere('a'). '
								union all
								select 
									p.*,p.cube_high*p.cube_wide*p.cube_long as cube,p.check_high*p.check_wide*p.check_long as check_cube,
                                    a.warehouse_id,a.product_id,0 as onroad_qn,0 as sale_qn, a.quantity as real_qn, 0 as reserve_qn 
								from storage a
								left join product p on p.id=a.product_id
                                left join warehouse w on w.id=a.warehouse_id 
								where ' . getWhere($_SESSION[$_GET['rand']]) . getBelongsWhere('p') .getAllWarehouseWhere('a').'						   
							) as tmp group by product_id,warehouse_id order by warehouse_id desc',
        'real_storage_sql'=> 'select 
									p.*,p.cube_high*p.cube_wide*p.cube_long as cube,p.check_high*p.check_wide*p.check_long as check_cube,
                                    a.warehouse_id,a.product_id,0 as onroad_quantity,sum(a.quantity) as sale_quantity, sum(a.quantity) as real_quantity, 0 as reserve_quantity 
								from storage as a
								left join product p on p.id=a.product_id
                                left join warehouse w on w.id=a.warehouse_id 
								where ' . getWhere($_SESSION[$_GET['rand']]) . getBelongsWhere('p') .getAllWarehouseWhere('a').'						   
                                group by product_id,warehouse_id order by warehouse_id desc',
 		'title'			=> array(
                                L('warehouse_name'),
		 						L('product_id'),
								L('product_no'),
								L('product_name'),
                                L('custom_barcode'),                                //产品条码
                                L('product_size_detail'),                           //产品尺寸CM
                                L('weight_detail'),                                 //重量G
                                L('check_spec_detail'),                             //查验尺寸CM
                                L('check_weight_detail'),                           //查验重量G
                                L('check_status'),                                  //查验状态
                                L('belongs_seller'),								//所属卖家
								L('real_storage'),
								L('reserve_storage'),
		 						L('sale_storage'),
								L('onroad_storage'),
						   ),
 		'content'		=> array(
                                'w_name',
	 							'product_id',
	 							'product_no',
	 							'product_name',
                                'custom_barcode',//产品条码
                                'cube', //产品尺寸CM
                                'weight', //重量G
                                's_check_cube', //查验尺寸CM
                                's_check_weight', //查验重量G
                                'dd_check_status', //查验状态
								'factory_name',//所属卖家
								"real_quantity",
								"reserve_quantity",
								"sale_quantity",
								"onroad_quantity",
	 						)
  	),		
    'locationStorage' =>array(//库存列表
		'sql' => 'SELECT w.w_name AS w_name, l.barcode_no AS location_no,a.quantity AS quantity,
            p.id AS product_id,p.product_no AS product_no,p.product_name AS product_name,p.custom_barcode,p.cube_high*p.cube_wide*p.cube_long as cube, p.weight,
            p.check_high*p.check_wide*p.check_long as check_cube,p.check_weight,p.check_status,p.cube_high,p.cube_wide,p.cube_long,p.check_high,p.check_wide,p.check_long
            FROM storage AS a
            LEFT JOIN warehouse w ON a.warehouse_id = w.id
            LEFT JOIN location l ON a.location_id = l.id
            LEFT JOIN product p ON a.product_id = p.id
            WHERE ' . getWhere($_SESSION[$_GET['rand']]) .getAllWarehouseWhere('a').' ORDER BY location_no,w_name,product_no',
 		'title'			=> array(
                                L('warehouse_name'),
                                L('location_no'),
                                L('product_id'),
								L('product_no'),
								L('product_name'),
            				    L('custom_barcode'),                                //产品条码
                                L('product_size_detail'),                           //产品尺寸CM
                                L('weight_detail'),                                 //重量G
                                L('check_spec_detail'),                             //查验尺寸CM
                                L('check_weight_detail'),                           //查验重量G
                                L('check_status'),                                  //查验状态
                                //L('belongs_seller'),								//所属卖家
								L('real_storage'),
						   ),
 		'content'		=> array(           
                                'w_name',
                                'location_no',
                                'product_id',
	 							'product_no',
	 							'product_name', 
                                'custom_barcode',//产品条码
                                'cube', //产品尺寸CM
                                'weight', //重量G
                                's_check_cube', //查验尺寸CM
                                's_check_weight', //查验重量G
                                'dd_check_status', //查验状态
								//'factory_name',//所属卖家
								"quantity",
	 						)
  	),	
    'skuStorage' =>array(//库存列表
		'sql' => 'SELECT w.w_name AS w_name, l.barcode_no AS location_no,a.quantity AS quantity, 
                        p.id AS product_id,p.product_no AS product_no,p.product_name AS product_name,p.custom_barcode,p.cube_high*p.cube_wide*p.cube_long as cube, p.weight,
                        p.check_high*p.check_wide*p.check_long as check_cube,p.check_weight,p.check_status,p.cube_high,p.cube_wide,p.cube_long,p.check_high,p.check_wide,p.check_long
FROM storage AS a
LEFT JOIN warehouse w ON a.warehouse_id = w.id
LEFT JOIN location l ON a.location_id = l.id
LEFT JOIN product p ON a.product_id = p.id
WHERE ' . getWhere($_SESSION[$_GET['rand']]) .getAllWarehouseWhere('a') .' ORDER BY product_no,w_name, location_no ',
        'title'			=> array(
		 						L('product_id'),
								L('product_no'),
								L('product_name'),
            				    L('custom_barcode'),                                //产品条码
                                L('product_size_detail'),                           //产品尺寸CM
                                L('weight_detail'),                                 //重量G
                                L('check_spec_detail'),                             //查验尺寸CM
                                L('check_weight_detail'),                           //查验重量G
                                L('check_status'),                                  //查验状态
                                L('warehouse_name'),
                                L('location_no'),
                                //L('belongs_seller'),								//所属卖家
								L('real_storage'),
						   ),
 		'content'		=> array(
	 							'product_id',
	 							'product_no',
	 							'product_name',
                                'custom_barcode',//产品条码
                                'cube', //产品尺寸CM
                                'weight', //重量G
                                's_check_cube', //查验尺寸CM
                                's_check_weight', //查验重量G
                                'dd_check_status', //查验状态
                                'w_name',
                                'location_no',
								//'factory_name',//所属卖家
								"quantity",
	 						)
  	),	
    'instockDetail' =>array(
        'sql'       => 'SELECT  b.box_no, p . * , d.quantity, d.declared_value, i.delivery_date, i.instock_no,(p.check_long*p.check_high*p.check_wide) as check_cube,(p.cube_long*p.cube_high*p.cube_wide) as cube,i.warehouse_id,d.in_quantity as in_quantity,d.in_quantity-d.quantity as diff_quantity
            FROM instock_detail     as d
            LEFT JOIN instock_box   as b    ON  d.box_id        = b.id
            LEFT JOIN product       as p    ON  d.product_id    = p.id
            LEFT JOIN instock       as i    ON  d.instock_id    = i.id
            WHERE d.instock_id    = '.$_GET['id'],
        'title'     => array(
            '箱号',
            'SKU',
            '产品名称',
            '数量',
            '入库数量',
            '差异数量',
            '申报价值（$）',
            '查验重量(G)',
            '查验尺寸（长、宽、高）CM',
            '目的地国家',
            '发货日期',
            '发货单号',
            ),
        'content'   => array(
            'box_no',
            'product_no',
            'product_name',
            'quantity',
            'in_quantity',
            'diff_quantity',
            'declared_value',
            'weight',
            'overall_size',
            'country',
            'delivery_date',
            'instock_no',
            ),
        ),
    'ClientStat' =>array(
        'sql'       => 'SELECT `object_id` ,`warehouse_id`, `object_type` , `pay_class_id` , `relation_type` , `basic_id` , `paid_id` , `paid_date` , `paid_type` , `comp_id` , `income_type` , `billing_type` , `quantity` , `price` , if(object_type=132,-1*discount_money,discount_money) AS discount_money , `currency_id` , `prototype_currency_type` , `account_no` , round(`have_paid`, ' . C('MONEY_LENGTH') . ') as have_paid, round(`need_paid`, ' . C('MONEY_LENGTH') . ') as need_paid , `state` , `is_close` , `object_type_extend` , `operate_id` , `record_num` , `befor_rate` , `comments` , 1 AS tr_color, (
            round(original_money, ' . C('MONEY_LENGTH') . ') + if( object_type =102, round(discount_money, ' . C('MONEY_LENGTH') . '), 0 )
            ) AS original_money, (
            round(should_paid, ' . C('MONEY_LENGTH') . ') + if( object_type =102, round(discount_money, ' . C('MONEY_LENGTH') . '), 0 )
            ) AS should_paid
            FROM client_paid_detail
            WHERE '.'should_paid<>0 and need_paid<>0 and ' . (empty($_SESSION[$_GET['rand']]['where'])? 1 : $_SESSION[$_GET['rand']]['where']),
        'title'     => array(
            '款项日期',
            '款项类型',
            '仓库名称',
            '应收款',
            '已收款',
            '折扣',
            '欠款',
            '注意事项',
            ),
        'content'   => array(
            'paid_date',
            'pay_class',
            'w_name',
			'edml_original_money',
            'edml_have_paid',
            'edml_discount_money',
			'edml_sum_need_paid',
            'edit_comments',
            ),
        ),
	'ClientArrearages' =>array(
        'sql'       => 'SELECT * , comp_id AS factory_id, paid_id AS id, quantity * price AS owed_money, quantity AS cube, quantity AS weight
            FROM client_paid_detail'. (empty($_SESSION[$_GET['rand']]['where'])? 1 : $_SESSION[$_GET['rand']]['where']),
        'title'     => array(
            '款项日期',
            '卖家名称',
            '仓库名称',
            '款项币种',
			'款项类型',
            '关联单号',
            '计费方式',
            '单价',
            '欠款金额',
            '折扣金额',
            '应付款金额',
            '注意事项',
            ),
        'content'   => array(
            'fmd_paid_date',
            'factory_name',
            'w_name',
            'currency_no',
			'pay_class_name',
            'account_no',
            'dd_billing_type',
            'dml_price',
            'dml_owed_money',
            'dml_discount_money',
            'dml_original_money',
            'edit_comments',
            ),
        ),
    'ClientOtherArrearages' =>array(
        'sql'       => 'SELECT * , comp_id AS factory_id, paid_id AS id, quantity * price AS owed_money, quantity AS cube, quantity AS weight
            FROM client_paid_detail'. (empty($_SESSION[$_GET['rand']]['where'])? 1 : $_SESSION[$_GET['rand']]['where']),
        'title'     => array(
            '款项日期',
            '卖家名称',
            '仓库名称',
            '款项类型',
            '款项币种',
            '关联单号',
            '计费方式',
            '数量',
            '单价',
            '欠款金额',
            '折扣金额',
            '应收款金额',
            '注意事项',
            ),
        'content'   => array(
            'fmd_paid_date',
            'factory_name',
            'w_name',
            'pay_class_name',
            'currency_no',
            'account_no',
            'dd_billing_type',
            'dml_quantity',
            'dml_price',
            'dml_owed_money',
            'dml_discount_money',
            'dml_should_paid',
            'edit_comments',
            ),
        ),
    'ClientFunds' =>array(
        'sql'       =>'select * , comp_id as factory_id , (money/befor_rate) as befor_money from paid_detail '.$_SESSION[$_GET['rand']]['where'],
        'title'     => array(
            '卖家名称',
            '仓库名称',
            '支付类型',
            '日期',
            '原币种',
            '原币金额',
            '币种',
            '金额',
            '折扣金额',
            '注意事项',
             ),
        'content'   => array(
            'factory_name',
            'w_name',
            'dd_paid_type',
            'fmd_paid_date',
            'befor_currency_no',
            'dml_befor_money',
            'currency_no',
            'dml_money',
            'dml_account_money',
            'comments',
            ),
        ),
    'ReturnSaleOrder' =>array(
        'sql'       =>'select  c.express_id as ship_id,b.warehouse_id,a.return_logistics_no,a.returned_date,a.client_id,d.comp_name as client_name,d.comp_no as client_no,d.email as comp_email,a.order_no,c.order_type,f.consignee,
							group_concat(distinct b.product_id) as p_ids,a.add_user,
							a.id,a.return_sale_order_no,a.factory_id,a.sale_order_id,a.sale_order_no,a.return_sale_order_state,
							a.return_order_date,if(a.add_user='.  getUser('company_id').',1,0) as is_self,a.return_reason,
							count(distinct b.product_id) as product_qn,a.add_user from  return_sale_order a 
							left join return_sale_order_detail b on(a.id=b.return_sale_order_id)
							left join product e on(e.id=b.product_id)
							left join sale_order c on(a.sale_order_id=c.id) 
							left join return_sale_order_addition f on(f.return_sale_order_id=a.id)
                            left join user on user.id=a.add_user
							left join client d on d.id=a.client_id where '
                            .getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']]['main'],'a.'))
                            .' and '.str_replace('b.product_no', 'e.product_no', getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']]['return_sale_order_detail'],'b.')))
                            .' and '.getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']]['sale_order'],'c.'))
                            .' and '.getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']]['return_sale_order_addition'],'d.'))
                            .' and '.getWhere($_SESSION[$_GET['rand']]['user'])
                            .'group by a.id order by a.update_time desc',
        'title'     => array(
            '退货单号',
            '处理单号',
            '订单单号',
            '退货物流编号',
            '所属卖家',
			'所属仓库',
            '客户名称',
            '退货日期',
            '退货完成日期',
            '销售渠道',
            '退货状态',
            '退货原因',
            '制单人员',
            '额外费用',            
            '退货费用', 
            '外包装费用', 
            '内包装费用',
			'回邮费',
			'退货处理费',
            '制单人员',
            '派送方式',
            '产品ID',
            'SKU',
            '产品名称',
            '退货数量',
            '库位',
            ),
        'content'   => array(
            'return_sale_order_no',
            'sale_order_no',
            'order_no',
            'return_logistics_no',
            'factory_name',
			'warehouse_name',
            'client_name',
            'fmd_return_order_date',
            'fmd_returned_date',
            'order_type_name',
            'dd_return_sale_order_state',
            'dd_return_reason',
            'add_real_name',
            'return_service_price',
            'return_fee',
            'outer_pack_fee',
            'within_pack_fee',
            'return_postage_fee',
            'return_process_fee',
            'add_real_name',
            'ship_name',//派送方式   add by lxt 2015.06.26
            'product_id0',
            'product_no0',
            'product_name0',
            'quantity0',
            'location_no0',
            ),
        ),
    
    'ReturnSaleOrderStorage' =>array(
        'sql'       =>'',
        'title'     => array(
            '退货单号',
            '处理单号',
            '订单单号',
            '所属卖家',
            '客户名称',
            '退货日期',
//            '退货完成日期',
            '销售渠道',
            '退货状态',
            '退货原因',
            '产品ID',
            'SKU',
            '产品名称',
            '退货数量',
            '入库数量',
            '库位',
            ),
        'content'   => array(
            'return_sale_order_no',
            'sale_order_no',
            'order_no',
            'factory_name',
            'client_name',
            'fmd_return_order_date',
//            'fmd_returned_date',
            'order_type_name',
            'dd_return_sale_order_state',
            'dd_return_reason',
            'product_id0',
            'product_no0',
            'product_name0',
            'quantity0',
            'in_quantity0',
            'location_no0',
            ),
        ),
    
    'QuestionOrder' =>array(
        'sql'       => 'select  a.finish_date,a.client_id,d.comp_name as client_name,d.comp_no as client_no,d.email as comp_email,a.order_no,c.order_type,f.consignee,
							group_concat(distinct b.product_id) as p_ids,a.add_user,
							a.id,a.question_order_no,a.factory_id,a.sale_order_id,a.sale_order_no,a.question_order_state,
							a.add_order_date,if(a.add_user=1,1,0) as is_self,a.question_reason,e.express_name,
							count(distinct b.product_id) as product_qn,a.add_user,a.process_mode,proof_delivery_fee,compensation_fee,a.warehouse_id,c.track_no,
							if(e.calculation=1,if(isnull(p.weight),c.volume_weight,c.volume_weight+p.weight),if(isnull(p.weight),c.weight,c.weight+p.weight))as charge_weight
                            from  question_order a 
							left join sale_order_detail b on(a.sale_order_id=b.sale_order_id) 
							left join sale_order c on(a.sale_order_id=c.id) 
							left join sale_order_addition f on(f.sale_order_id=a.id)
							left join client d on d.id=a.client_id
							left join express e on e.id=a.express_id
                            left join user on a.add_user=user.id
							left join package p on c.package_id=p.id
                            where '.getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']]['main'],'a.'))
                            .' and '.getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']]['sale_order_detail'],'b.'))
                            .' and '.getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']]['sale_order'],'c.'))
                            .' and '.getWhere(sqlWhereKeyPrefix($_SESSION[$_GET['rand']]['sale_order_addition'],'d.'))
                            .' and '.getWhere($_SESSION[$_GET['rand']]['user']).getBelongsWhere('c').getWarehouseWhere('a')
							.' and EXISTS(select 1 from product where product.id=b.product_id and '.  getWhere($_SESSION[$_GET['rand']]['product']).')'
                            .' group by a.id order by a.update_time desc',
        'title'     => array(
            '问题订单单号',	
            '处理单号',	
            '订单单号',	
            '所属卖家',	
            '所属仓库',	
            '客户名称',	
            '建单日期',
            '完成日期',	
            '状态',	
            '处理方式',	
            '原因',
			'派送方式',
			'追踪单号',
            '签收证明费用',	
            '赔偿金额',
            '制单人员',
			'计费重量',
            '产品ID', 	
            'SKU', 	
            '产品名称', 	
            '数量',
            ),
        'content'   => array(
            'question_order_no',	
            'sale_order_no',	
            'order_no',	
            'factory_name',	
            'w_name',	
            'client_name',	
            'add_order_date',
            'finish_date',	
            'dd_question_order_state',	
            'dd_process_mode',	
            'dd_question_reason',
			'express_name',
			'track_no',
            'proof_delivery_fee',	
            'compensation_fee',
            'add_real_name',
			'charge_weight',
            'product_id0',
            'product_no0',
            'product_name0',
            'quantity0',
            ),
        ),
    
    //先进先出      add by lxt 2015.06.16
    'fifoStorage'  =>  array(
        'sql'       =>  'SELECT w.w_name AS w_name, l.barcode_no AS location_no,a.balance AS quantity,in_date,  
                        p.id AS product_id,p.product_no AS product_no,p.product_name AS product_name,p.custom_barcode,p.cube_high*p.cube_wide*p.cube_long as cube, p.weight,
                        p.check_high*p.check_wide*p.check_long as check_cube,p.check_weight,p.check_status,p.cube_high,p.cube_wide,p.cube_long,p.check_high,p.check_wide,p.check_long 
                        FROM stock_in AS a
                        LEFT JOIN warehouse w ON a.warehouse_id = w.id
                        LEFT JOIN location l ON a.location_id = l.id
                        LEFT JOIN product p ON a.product_id = p.id
                        WHERE ' . getWhere($_SESSION[$_GET['rand']]) .getAllWarehouseWhere('a') .' ORDER BY in_date ',
        'title'		=> array(
 						L('product_id'),
						L('product_no'),
						L('product_name'),
                        L('custom_barcode'),                                //产品条码
                        L('product_size_detail'),                           //产品尺寸CM
                        L('weight_detail'),                                 //重量G
                        L('check_spec_detail'),                             //查验尺寸CM
                        L('check_weight_detail'),                           //查验重量G
                        L('check_status'),                                  //查验状态
                        L('warehouse_name'),
                        L('location_no'),
						L('real_storage'),
                        L('storage_date'),
					   ),
 		'content'	=> array(
						'product_id',
						'product_no',
						'product_name', 
                        'custom_barcode',//产品条码
                        'cube', //产品尺寸CM
                        'weight', //重量G
                        's_check_cube', //查验尺寸CM
                        's_check_weight', //查验重量G
                        'dd_check_status', //查验状态
                        'w_name',
                        'location_no',
						"quantity",
 		                "in_date",
 						)
    ),
    
    //退货入库列表拣货单导出       add by lxt 2015.09.22
    'pikingExport'  =>  array(
        'sql'       =>  'select a.id,a.return_logistics_no,a.return_track_no,b.product_id,b.quantity,d.barcode_no as location_no from
                         return_sale_order a left join return_sale_order_detail b on a.id=b.return_sale_order_id
                         left join return_sale_order_storage_detail c on b.return_sale_order_id=c.return_sale_order_id and b.product_id=c.product_id
                         left join location d on d.id=c.location_id
                         where exists(select if(sum(quantity>0),1,0) from return_sale_order_storage_detail where return_sale_order_storage_detail.return_sale_order_id=a.id group by return_sale_order_storage_detail.return_sale_order_id) and
                         '.getWhere($_SESSION[$_GET['piking_rand']]).getWarehouseWhere('b').' group by a.id,b.product_id order by a.id',
        'title'     =>  array(
            L('return_logistics_no'),
            L('return_track_no'),
            L('product_id'),
            L('product_no'),
            L('quantity'),
            L('warehouse_location')
        ),
        'content'   =>  array(
            'return_logistics_no',
            'return_track_no',
            'product_id',
            'product_no',
            'quantity',
            'location_no'
        )
    ),
    'exportUKDPDSaleOrder'  => array(//英国DPD
        'sql'     =>'SELECT a.id as sale_order_id,a.sale_order_no,a.warehouse_id,a.weight,b.consignee,b.mobile,b.address,b.address2,b.city_name,b.post_code,b.company_name,b.country_id,b.email
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
        'title'   => array(
            'CustomerRef1',
            'Contact Name',
            'OrganisationName',
            'AddressLine1',
            'AddressLine2',
            'AddressLine3',
            'AddressLine4',
            'Postcode',
            'Additional info',
            'CountryCode',
            'Telephone',
            'NotificationSMS',
            'NotificationEmail',
            'NumberOfParcels',
            'Service'
        ),
        'content' => array(
            'sale_order_no',
            'consignee',
            'city_name',
            'address',
            'address2',
            'address3',
            'address4',
            'post_code',
            'fixed_value0',
            'country_id',
            'mobile',	
            'product_id',
            'email',
            'fixed_value1',
            'fixed_value2',
        ),
    ),
    
    'exportROYALMAILSaleOrder'  => array(//英国DPD
        'sql'     =>'SELECT a.id as sale_order_id,a.express_id,a.is_registered,a.sale_order_no,a.warehouse_id,a.weight,b.consignee,b.mobile,b.address,b.address2,b.city_name,b.post_code,b.company_name,b.country_id,b.email,c.comp_name,e.area
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `express` d ON a.express_id=d.id
                      INNER JOIN `client` c ON a.client_id=c.id
                      INNER JOIN `express_detail` e ON a.express_detail_id=e.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
        'title'   => array(
            'Reference',
            'Business Response/Recipient Complementary Name',
            'Business Response/Recipient',
            'Business Response/Recipient Address line 1',
            'Business Response/Recipient Address line 2',
            'Business Response/Recipient Address line 3',
            'Business Response/Recipient Post Town',
            'Business Response/Recipient Postcode',
            'Business Response/Recipient Country Code',
            'Recipient Tel #',
            'Recipient Email Address',
            'Service Reference',
            'Service',
            'Service Enhancement',
            'Service Format',
            'Signature',
            'Items',
            'Weight',

        ),
        'content' => array(
            'sale_order_no',
            'product_id',//'comp_name',
            'consignee',
            'address',
            'address2',
            'address3',
            'city_name',
            'post_code',
            'country_id',//
            'mobile',
            'email',
            'SR1',
            'express_letter0',//
            'is_email',
            'express_letter1',//
            'is_registered',//
            'items',//'product_id',//
            'weight',//
        ),
    ),
    'exportFedexSaleorder'  => array(//FEDEX
        'sql'     =>'SELECT c.comp_name as client_name,a.id as sale_order_id,a.factory_id,a.express_id,a.is_registered,a.sale_order_no,a.warehouse_id,a.weight,b.consignee,b.mobile,b.address,b.address2,b.city_name,b.post_code,b.company_name,b.country_id,b.email,c.comp_name,e.area,a.weight,a.volume_weight,d.calculation
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `express` d ON a.express_id=d.id
                      INNER JOIN `client` c ON a.client_id=c.id
                      INNER JOIN `express_detail` e ON a.express_detail_id=e.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
        'title'   => array(
            'Reference',
            'Business Response/Recipient Complementary Name',
            'Business Response/Recipient',
            'Business Response/Recipient Address line 1',
            'Business Response/Recipient Address line 2',
            'Business Response/Recipient Address line 3',
            'Business Response/Recipient Post Town',
            'Business Response/Recipient Postcode',
            'Business Response/Recipient Country Code',
            'Recipient Tel #',
            'Recipient Email Address',
            'Service Reference',
            'Items',
            'Weight',
        ),
        'content' => array(
            'sale_order_no',
            'product_id',//'client_name','comp_name',
            'consignee',
            'address',
            'address2',
            'address3',
            'city_name',
            'post_code',
            'country_id',//
            'mobile',
            'email',
            'express_letter0',
            'number',
            'weight',
        ),
    ),    
    'exportParcelForceSaleorder'  => array(//PARCEL FORCE
        'sql'     =>'SELECT c.comp_name as client_name,a.id as sale_order_id,a.factory_id,a.express_id,a.is_registered,a.sale_order_no,a.warehouse_id,a.weight,b.consignee,b.mobile,b.address,b.address2,b.city_name,b.post_code,b.company_name,b.country_id,b.email,c.comp_name,e.area
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `express` d ON a.express_id=d.id
                      INNER JOIN `client` c ON a.client_id=c.id
                      INNER JOIN `express_detail` e ON a.express_detail_id=e.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
        'title'   => array(
            'Reference',
            'Business Response/Recipient Complementary Name',
            'Business Response/Recipient',
            'Business Response/Recipient Address line 1',
            'Business Response/Recipient Address line 2',
            'Business Response/Recipient Address line 3',
            'Business Response/Recipient Post Town',
            'Business Response/Recipient Postcode',
            'Business Response/Recipient Country Code',
            'Recipient Tel #',
            'Recipient Email Address',
            'Service Reference',

        ),
        'content' => array(
            'sale_order_no',
            'product_id',//'client_name','comp_name',
            'consignee',
            'address',
            'address2',
            'address3',
            'city_name',
            'post_code',
            'country_id',//
            'mobile',
            'email',
            'express_letter0',
        ),
    ),
    
    
    'OrderType'  => array(//PARCEL FORCE
        'sql'     =>'SELECT * FROM order_type where '.getWhere($_SESSION[$_GET['rand']]).' order by id',
        'title'   => array(
            '编号',
            '销售渠道',
            '备注',
        ),
        'content' => array(
            'id',
            'order_type_name',//'client_name','comp_name',
            'comments',
        ),
    ),
    'exportYodelSaleOrder'  => array(//Yodel
        'sql'     =>'SELECT a.id as sale_order_id,a.express_id,a.is_registered,a.sale_order_no,a.warehouse_id,a.weight,a.volume_weight,b.consignee,b.mobile,b.address,b.address2,b.city_name,b.post_code,b.company_name,b.country_id,b.email,c.comp_name,e.area,d.express_no as shipping_no,d.calculation,c.comp_name as client_name
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `express` d ON a.express_id=d.id
                      INNER JOIN `client` c ON a.client_id=c.id
                      INNER JOIN `express_detail` e ON a.express_detail_id=e.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
        'title'   => array(
            'Account ID',           //565469755896
            'Tariff Code',          //根据派送方式名称配置
            'Your Reference	Del.',  //处理单号
            'Company	Del.',      //客户名称
            'Address 1 	Del.',      //街道1
            'Address 2	Del.',      //街道2
            'Address 3 	Del.',      //街道3
            'Town	Del.',          //所在城市
            'County	Del.',          //所属国家
            'PostCode	Del.',      //邮编
            'Contact (1)	Del.',  //收货人
            'Phone	Del.',          //客户电话
            'Email',                //邮件
            'Pieces',               //件数（默认为1）
            'Weight',               //重量
            'item ID',              //产品ID*数量
        ),
        'content' => array(
            'account_id',
            'shipping_no',//tariff_code//express_no在缓存中已经被使用格式化时会覆盖,故用别名
            'sale_order_no',
            'client_name',
            'address',
            'address2',
            'address3',
            'city_name',
            'country_id',
            'post_code',
            'consignee',
            'mobile',
            'email',
            'pieces',
            'weight',
            'product_id',
        ),
    ),
    'exportFRDPDSaleOrder'  => array(//FR-DPD
        'sql'     =>'SELECT a.id as sale_order_id,a.sale_order_no,a.weight,a.volume_weight,b.consignee,b.mobile,b.address,b.address2,b.city_name,b.post_code,b.company_name,b.country_id,b.email,d.calculation
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
        'title'   => array(
            '处理单号',           
            '收货人',//收货人
			'空值1',
			'空值2',
			'空值3',
			'街道二',
			'空值4',
			'街道一',
			'邮编',
			'城市',
			'产品id*数量',
			'空值5',
			'空值6',
			'空值7',
			'电话',
			'邮件地址',
			'空值8',
			'重量',
			'空值9',
			'国家代码',
        ),
        'content' => array(
            'sale_order_no',
            'consignee',
			'empty1',
			'empty2',
			'empty3',
			'address2',
			'empty4',
			'address',
			'post_code',
			'city_name',
            'product_id',
			'empty5',
			'empty6',
			'empty7',
            'mobile',
			'email',
            'empty8',
			'weight',
			'empty9',
			'country_code',
        ),
    ),
	'SaleOrderReport'	=> array(
	  'sql'     => 'SELECT c.sale_order_id,sale_order.sale_order_no, sale_order.order_no,sale_order.track_no,sale_order.factory_id,
					b.consignee,b.mobile,b.address,b.address2,b.city_name,b.post_code,b.company_name,b.country_id,b.email,c.product_id, 
					p.product_no, p.product_name,	
					sum(c.quantity) as quantity,
					sum(if(p.check_status=1, p.check_weight, p.weight) * c.quantity) as weight
					FROM `sale_order` 
					inner join sale_order_detail c on c.sale_order_id=sale_order.id
					INNER JOIN `sale_order_addition` b ON sale_order.id=b.sale_order_id
					inner join product p on p.id=c.product_id
					WHERE EXISTS(select 1 from sale_order_detail inner join product on product.id=sale_order_detail.product_id where sale_order_id=sale_order.id and '.getWhere($_SESSION[$_GET['rand']]['sale_order_detail']).' )
					and EXISTS(select 1 from sale_order_addition where sale_order_addition.sale_order_id=sale_order.id and '.getWhere($_SESSION[$_GET['rand']]['sale_order_addition']).' )
					and '.getWhere($_SESSION[$_GET['rand']]['sale_order']).'
					group by sale_order.id, c.product_id 
					ORDER BY order_no desc',
        'title'   => array(
            'Marke',//所属卖家
			'HAWB Nr. von SF',//追踪单号
			'Palette Nr.',//放空
			'Kundenartikelnummer',//产品编号
			'Bezeichnung',//产品名称
			'Codenummer',//HS code
			'Ursp',//产地
			'Name',//收货人
			'Name 2',//街道二
			'Name 3',//放空
			'Name 4',//放空
			'PLZ',//邮编
			'Hausnummer',//门牌号码 放空
			'Straße',//街道一
			'Straße 2',//放空
			'Straße 3',//放空
			'Straße 4',//放空
			'Ort',//城市
			'Lnd',//国家代码
			'Packmittel',//邮编
			'Bruttowert',//产品销售价格*数量
			'Währg',//币种 人民币 放空
			'GrenzübergWert',//总销售价格 放空
			'Währg',//币种 欧元 放空
			'Gesamtgewicht',//总重量 单行产品总重量
			'Eh',//重量单位 固定KG
			'Gesamtvolumen',//总体积 放空
			'VEH',//放空
			'Länge',//放空
			'Abmessungseinheit',//MM
			'Breite',//放空
			'Abmessungseinheit',//MM
			'Höhe',//放空
			'Liefermenge',//单行产品数量
			'Nettogewicht',//单行产品总重量
			'Eh',//重量单位 固定KG
        ),
        'content' => array(
            'factory_name',
			'track_no',
			'empty0',//放空
			'product_no',
			'product_name',
			'codenummer',
			'ursp',
			'consignee',
			'address2',
			'empty1',
			'empty2',
			'post_code',
			'empty3',
			'address',
			'empty4',
			'empty5',
			'empty6',
			'city_name',
			'country_code',
			'post_code2',
			'product_price',
			'empty7',
			'empty8',
			'empty9',
			'weight',
			'weight_unit',
			'empty10',
			'empty11',
			'empty12',
			'size_unit',
			'empty13',
			'size_unit2',
			'empty14',
			'quantity',
			'weight2',
			'weight_unit2',
        ),
	),
    //IT-USP
    'exportITUpsSaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.warehouse_id,a.factory_id,a.express_id,a.sale_order_no,a.weight,
                      a.volume_weight,a.is_insure,b.country_name,b.city_name,b.country_id,b.address,
                      b.address2,b.post_code,b.consignee,b.mobile,b.email,c.id,c.comp_no as client_no,c.comp_name as client_name,
                      d.company_id,d.calculation
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'RIFERIMENTO2',//处理单号
					 'RIFERIMENTO1',//卖家名称
					 'SOCIETA',//收件公司
					 'ATTENZIONE',//收件人
					 'TELEFONO',//电话号码
					 'QVM_OPZIONE',//启动EMAIL通知
					 'QVM_MAIL',//电邮
					 'INDIRIZZO1',//地址1（最长35字数）
					 'INDIRIZZO2',//地址2
					 'INDIRIZZO3',//地址3
					 'CAP',//邮政编码            
                     'CITTA',//城市
					 'STATO_PROV',//州名称（美国与加拿大使用）
					 'PAESE',//国家简写
					 'SERVIZIO',//派递种类
					 'DESCRIZIONE_MERCE',//产品描述
					 'NOLO',//运费
                     'TAX',//付关税方
					 'PESO',//包裹重量
					 'NUMERO_COLLI',//包裹数量
                     'TIPO_PACCO',//包裹种类
					 'OPZIONE_ASSICURAZIONE',//保险
					 'VALORE_ASSICURAZIONE',//保险金额
                     'EMAIL MITTENTE',//卖家EMAIL地址
                     'EMAIL MITTENTE',//产品ID
            
		),
		'content' => array(
					 'sale_order_no',//处理单号
					 'factory_name',//卖家名称
					 'client_name',//收件公司
					 'consignee',//收件人
					 'mobile',//电话号码
                     'is_email',//启动EMAIL通知
					 'email',//电邮
					 'address',//地址1（最长35字数）
					 'address2',//地址2
                     'address3',//地址3
					 'post_code',//邮政编码 
					 'city_name',//城市
					 'stato_prov',//州名称（美国与加拿大使用）
					 'country_shorthand',//国家简写
					 'servizio',//派递种类     
					 'descrizione_merce',//产品描述     
					 'freight',  //运费
					 'tax',//付关税方
					 'weight',//包裹重量
					 'packages_num',//包裹数量,默认为1
                      'tipo-pacco',//包裹种类
					 'is_insure',//保险
					 'insure_price', //保险金额 
                     'comp_email', //卖家EMAIL地址
                     'product_id', ///产品ID
		),
	),
    //国际Fedex
    'exportInternationalFedexSaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.warehouse_id,a.factory_id,a.express_id,a.sale_order_no,a.weight,
                      a.volume_weight,b.country_name,b.city_name,b.country_id,b.address,b.address2,b.post_code,b.consignee,
                      b.mobile,b.email,c.id,c.comp_name as client_name,d.company_id,d.calculation
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'Reference',//处理单号
					 'Recip Company Name',//收件公司
					 'Recip Contact Name',//收件人
					 'Address 1',//地址1（最长35字数）
					 'Address2',//地址2
					 'City',//城市
					 'Country',//国家简写        
                     'Postcode',//邮编
					 'Recip Phone',//电话号码
					 'Packaging',//包裹数量
					 'Unit Weight',//重量
					 'Unit Value',//物品价值（留空）
					 'Unit Quantity',//物品数量
                     'Number of Boxes',
					 'Description',//特殊描写或要求注意事项
					 'Email Address',//邮件
                     'Email Flag',//邮件提醒 
		),
		'content' => array(
					 'sale_order_no',//处理单号
					 'client_name',//收件公司
					 'consignee',//收件人
					 'address',//地址1（最长35字数）
					 'address2',//地址2  
                     'city_name',//城市
					 'country_shorthand',//国家简写        
                     'post_code',//邮编
					 'mobile',//电话号码
					 'anzahl_sendungen',//包裹数量
					 'weight',//重量
					 'unit_value',//物品价值（留空）
					 'unit_quantity',//物品数量
                     'boxes',
					 'description',//特殊描写或要求注意事项
					 'email',//邮件
                     'email_flag',//邮件提醒       
		),
	),
    //myHemers
    'exportMyHemersSaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.express_id,a.sale_order_no,a.weight,
                      a.volume_weight,b.address,b.address2,b.post_code,b.consignee,
                      b.mobile,b.email,d.calculation,a.is_registered
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'Address_line_1',//街道一
					 'Address_line_2',//街道二
					 'Address_line_3',
					 'Address_line_4',
					 'Postcode',//邮编
					 'First_name',//收货人名称
					 'Last_name',   
                     'Email',//邮箱
					 'Weight(Kg)',//订单重量
					 'Compensation(£)',
					 'Signature(y/n)',
					 'Reference',//处理单号
					 'Contents',//产品ID*数量
                     'Parcel_value(£)',
					 'Delivery_phone',//联系电话
					 'Delivery_safe_place',
                     'Delivery_instructions',
		),
		'content' => array(
                     'address',//街道一
					 'address2',//街道二 
                     'address3',//放空 
                     'address4',//放空
                     'post_code',//邮编
                     'consignee',//收货人名称
                     'last_name',//放空
                     'email',//邮箱
                     'weight',//订单重量
                     'compensation',//放空
                     'signature',//默认N
					 'sale_order_no',//处理单号
					 'product_id',//产品ID*数量
					 'parcel_value',//放空
                     'mobile',//联系电话
					 'delivery_safe_place',//放空
					 'delivery_instructions',//放空     
		),
	),
    //Mondial Relays
    'exportMondialRelaySaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.express_id,a.sale_order_no,a.weight,
                      a.volume_weight,b.country_id,b.city_name,b.address,b.address2,b.post_code,b.consignee,
                      b.mobile,b.email,c.comp_no,d.calculation
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
                      INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'N Client',//客户编号
					 'ref dexpedition',//处理单号
					 'nom',//姓名
                     'Num0',//放空1
					 'Adresse du destinataire',//街道一
					 'Adresse du destinataire(Complement dadresse)',//街道二
					 'Ville du destinataire',//城市 
					 'Code Postal', //邮编  
                     'Pays du  destinataire',//国家代码
					 'Telephone1',//电话号码1
					 'Telephone2',//电话号码2（放空）
					 'Adresse email',//邮箱地址
					 'Num1',//放空1
                     'Num2',//放空2
                     'Num3',//放空3
					 'Type Livraison',//默认代码D
                     'Num4',//放空1
                     'Num5',//放空2
                     'Mode de Livraison',//默认代码LD1
                     'Num6',//放空1
					 'Nombre de colis',//包裹数量
					 'Poids Poids en grammes',//重量单位克
            		 'Num7',//放空1
                     'Num8',//放空2
                     'Num9',//放空3
            		 'Num10',//放空4
                     'Num11',//放空5
                     'Num12',//放空6
            		 'Num13',//放空7
                     'Num14',//放空8
                     'Num15',//放空9
                     'Num16',//放空10
                     'Num17',//放空11
                     'Num18',//放空12
                     'Article 01',//第一件产品条码，产品名称及数量
                     'Article 02',//第二件产品条码，产品名称及数量
                     'Article 03',//第三件产品条码，产品名称及数量
                     'Article 04',//第四件产品条码，产品名称及数量
                     'Article 05',//第五件产品条码，产品名称及数量
                     'Article 06',//第六件产品条码，产品名称及数量           
		),
		'content' => array(
                     'comp_no',//客户编号
                     'sale_order_no',//处理单号
                     'consignee',//收货人名称
                     'num0',//放空1
                     'address',//街道一
                     'address2',//街道二 
                     'city_name',//城市
                     'post_code',//邮编
					 'country_shorthand',//国家简写        
                     'mobile',//电话号码1
                     'mobile2',//电话号码2,放空
                     'email',//邮箱
                     'num1',//放空1
                     'num2',//放空2
                     'num3',//放空3
					 'type_livraison',//默认代码D
                     'num4',//放空1
                     'num5',//放空2
                     'mode_de_livraison',//默认代码LD1
                     'num6',//放空1
                     'anzahl_sendungen',//包裹数量,默认为1
					 'weight',//重量
                     'num7',//放空1
                     'num8',//放空2
                     'num9',//放空3
            		 'num10',//放空4
                     'num11',//放空5
                     'num12',//放空6
            		 'num13',//放空7
                     'num14',//放空8
                     'num15',//放空9
                     'num16',//放空10
                     'num17',//放空11
                     'num18',//放空12
                    'product_0',//第一件产品条码，产品名称及数量
                    'product_1',//第二件产品条码，产品名称及数量
                    'product_2',//第三件产品条码，产品名称及数量
                    'product_3',//第四件产品条码，产品名称及数量
                    'product_4',//第五件产品条码，产品名称及数量
                    'product_5',//第六件产品条码，产品名称及数量          
		),
	),
	//GEODIS
    'exportGeodisSaleOrder'  => array(
		'sql'     => 'SELECT a.id as sale_order_id,a.express_id,a.sale_order_no,a.factory_id,a.weight,
                      a.volume_weight,b.address,b.address2,b.post_code,b.consignee,b.country_id,b.company_name,b.city_name,
                      b.mobile,b.email,d.calculation
					  FROM `sale_order` a
					  INNER JOIN `sale_order_addition` b ON a.id=b.sale_order_id
					  INNER JOIN `client` c ON a.client_id=c.id
					  INNER JOIN `express` d ON a.express_id=d.id
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' and sale_order_state='.C('SALE_ORDER_STATE_PENDING').'
					  ORDER BY a.id desc',
		'title'   => array(
					 'Référence 1 client',//处理单号
					 'Date de départ',//
					 'Code expéditeur',//
					 'Code tiers',//固定值001292
					 'Code produit commercial',//48小时派送服务代码 固定值 MES
					 'Code facturation client',//卖家名称缩写 比如zhou
					 'Code incoterm',//发件人付款代码 固定值 P
					 'Nom Destinataire',//收件人姓名
					 'Adresse volet 1 du destinataire',//街道一
					 'Adresse 2',//街道二
					 'Code pays du destinataire',//国家代码
					 'Code département du destinataire',//省份
					 'Code postal du destinataire',   //邮编
                     'localité du destinataire',//城市
					 'Type destinataire',//客户类型代码 固定值 P
					 '',
					 'Nombre de colis',//订单包裹数量固定值1
					 'Poids total（KG）',//重量KG
					 '',
					 'N° Portable destinataire',//电话号码
					 '',
					 'reference produit',//产品条码
                     'Option de rendez-vous',//预约服务固定值 W
					 'Pré-info du destinataire',//派送提醒  固定值 2
		),
		'content' => array(
					 'sale_order_no',//处理单号
					 'num0',// 放空
                     'num1',//放空
                     'code_tiers',//固定值001292
                     'code_produit_commercial',//固定值 MES
                     'factory_name',//卖家名称缩写
                     'code_incoterm',//发件人付款代码 固定值 P
					 'consignee',//收件人姓名
                     'address',//街道一
                     'address2',//街道二
                     'abbr_district_name',//国家代码
                     'company_name',//省份
                     'post_code',//邮编
                     'city_name',//城市
                     'type_destinataire',//固定值 P
					 'num2',//放空
                     'nombre_de_colis',//固定值1
                     'weight',//
					 'num3',//放空
					 'mobile',//
					 'num4',//放空
					 'product_id',//产品条码 多个产品条形码则用-连接
					 'option_de_rendez-vous',//固定值 W
                     'destinataire',//固定值 2
		),
	),
	//warehouseAccount
    'WarehouseAccount'  => array(
		'sql'     => 'SELECT *,(quarter_warehouse_fee*quarter_stock_cube*warehouse_percentage) as quarter_warehouse_account,
							(year_warehouse_fee*year_stock_cube*warehouse_percentage) as year_warehouse_account,
							(free_stock_quantity+quarter_stock_quantity+year_stock_quantity) as stock_quantity,
							(free_stock_cube+quarter_stock_cube+year_stock_cube) as stock_cube,
							(quarter_warehouse_fee*quarter_stock_cube+year_warehouse_fee*year_stock_cube)*warehouse_percentage as warehouse_account_fee
					  FROM `warehouse_account`
					  WHERE '.getWhere($_SESSION[$_GET['rand']]).' ORDER BY account_date desc',
		'title'   => array(
					 '日期',//街道一
					 '所属卖家',//街道二
					 '所属仓库',
					 '免租期库存数',
					 '免租期库存体积(m³)',//邮编
					 '季度',//收货人名称
					 '1年内库存数',
                     '1年内库存体积(m³)',//邮箱
					 '1年内仓储费',//订单重量
					 '超1年库存数',
					 '超1年库存体积(m³)',
					 '超1年仓储费',//处理单号
					 '总库存数量',//产品ID*数量
                     '总库存体积(m³)',
					 '仓储费',//联系电话
		),
		'content' => array(
                     'account_date',//街道一
					 'factory_name',//街道二
                     'w_name',//放空
                     'dml_free_stock_quantity',//放空
                     'free_stock_cube',//邮编
                     'quarter',//收货人名称
                     'dml_quarter_stock_quantity',//放空
                     'quarter_stock_cube',//邮箱
                     'dml_quarter_warehouse_account',//订单重量
                     'dml_year_stock_quantity',//放空
                     'year_stock_cube',//默认N
					 'dml_year_warehouse_account',//处理单号
					 'dml_stock_quantity',//产品ID*数量
					 'stock_cube',//放空
                     'dml_warehouse_account_fee',//联系电话
		),
	),
)
?>