<?php
return array(
   'DB_NAME'							=> 'EDA_HTao',
    'DB_USER'							=> 'root',
    'DB_PWD'							=> '123456',
    'USER_AUTH_KEY'                     => '16hrtj7835751962525dd1dddd57535s16a1wfg61g6',	// 用户认证SESSION标记
    'ADMIN_AUTH_KEY'                    => '16w16gf3vsv3355.04275ddddd061574532e61w6guyy',// 系统管理认证SESSION标记
    'SUPER_ADMIN_AUTH_KEY'              => '11w6537837s5357v04ddddd344352816516919sd1ge',	// 超管认证SESSION标记
    'SHOW_PAGE_TRACE'                   => true,
    //DHL快递id
    'EXPRESS_DHL_ID'                    => '9',
    //派送方式 DPW 的 ID
    'EXPRESS_DPW_ID'                    => '19',
    //德国邮政快递id
    'EXPRESS_DEUTSCHE_POST_ID'          => '10',
    //法国邮政id
    'EXPRESS_FR_POST_ID'                => '37',
    //法国邮政快递id
    'EXPRESS_FR_POST_EXPRESS_ID'        => '61',
    //IT-BRT快递id
    'EXPRESS_BRT_ID'                    => '47',
    //IT-GLS快递id
    'EXPRESS_IT-GLS_ID'                 => '43',
    //frGLS快递公司id
    'EXPRESS_FR-GLS_ID'                 => '38',
    //Yodel快递公司id
    'EXPRESS_YODEL_ID'                  => '135',
    //FR-DPD快递公司id
    'EXPRESS_FR-DPD_ID'                 => '158',
    //德国GLS快递公司ID
    'EXPRESS_DE-GLS_ID'                 => '16',
    //UK-TNT快递公司id
    'EXPRESS_UK-TNT_ID'                 => '108',
    //UPS快递公司ID
    'EXPRESS_UPS_ID'                    => '33',
    //DPD快递公司id
    'EXPRESS_DPD_ID'                    => '32',
    //UK-DPD快递公司id
    'EXPRESS_UK-DPD_ID'                 => '107',
    //ES-DHL快递公司id
    'EXPRESS_ES-DHL_ID'                 => '40',
    //意大利邮政ID
    'EXPRESS_IT-POST_ID'                => '42',
    //国际FEDEX
    'EXPRESS_ITFEDEX_ID'                => '166',
   //IT-UPS
    'EXPRESS_IT-UPS_ID'                =>  '167',
   //ES-GLS快递公司id
    'EXPRESS_ES-GLS_ID'                 => '41',
   //ES-ASM快递公司id
    'EXPRESS_ES-ASM_ID'                 => '62',
   //法国UPS快递公司ID
    'EXPRESS_FR-UPS_ID'                 => '169',
  //PL-DHL快递公司ID
   'EXPRESS_PL-DHL_ID'			=> '170',
  //myHemers快递公司ID
   'EXPRESS_MYHEMERS_ID'               => '171',
  //Mondial Relay快递公司ID
   'EXPRESS_MONDIAL_RELAY_ID'          => '172',
  	//虚拟托盘派送快递id
    'EXPRESS_VIRTUAL_TRAY_ID'           => '188',
'EXPRESS_FR-GD-24_ID'			=> '152',
  //GEODIS快递公司ID
  'EXPRESS_GEODIS_ID'					=> '196',
  //MRW快递公司ID
  'EXPRESS_MRW_ID'					=> '195',
  'GLS_API_EXPRESS_ID'	=> array(16,41),

  //IT虚拟托盘派送派送方式id（需要对应实际数据库派送方式ID）
'EXPRESS_IT_VIRTUAL_TRAY_ID'		=> '145',

'ORDER_TYPE_VIRTUAL_TRAY'   => '11',//销售渠道-虚拟托盘
'ORDER_TYPE_TRAY_EXPRESS'    => '7',//销售渠道-托盘派送
//虚拟2派送方式id
'EXPRESS_IT-01_ID'					=> '145',
//FR虚拟托盘派送方式id
'EXPRESS_FR-01_ID'					=> '1588',
//UK-Pallet派送方式id
'EXPRESS_UK-P2_ID'				    => '1544',
//UK-Pallet-ABC派送方式id
'EXPRESS_UK-P1_ID'					=> '155',
//PL-Pallet派送方式id
'EXPRESS_PL-P1_ID'					=> '154',
//PL-Pallet-CAB派送方式id
 'EXPRESS_PL-P2_ID'					=> '1577',


   
   //快递公司为法国邮政-快递下需要默认挂号的派送方式的ID
    'EXPRESS_FR_REGISTERED_ID'             =>'131,132,133',
  //角色ID
'FINANCIAL_MANAGER_ROLE_ID'			=> '17',//财务经理角色ID
'OVERSEAS_MANAGER_ROLE_ID'			=> '14',//海外仓经理角色ID


  'WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID' =>  '16,22,23',//海外仓操作

'GLS_EU_COUNTRIES'	=> array('AT','BE','BG','CY','HR','CZ','DK','EE','FI','FR','DE','GR','HU',
		'IE','IT','LV','LT','LU','MT','NL','PL','PT','RO','SK','SI','ES','SE','GB'),
'GLS_NOT_USE_COUNTRIES'	=> array('"CH"','"GB"','"NO"','"NL"'),


    /*****************Mondial Relay打印模版************/
    //FR-freight-1派送方式id
    'EXPRESS_FR-FREIGHT-1_ID'			=> '138,140',
    //FR-freight-2派送方式id
    'EXPRESS_FR-FREIGHT-2_ID'			=> '139,141',
    /************************************************/

    /*****************西班牙邮政打印模版******************************/
    //西班牙邮政快递公司ID
    'EXPRESS_ES_CORREOS_ID'             => '39',
    //Envielia快递公司ID
    'EXPRESS_ENVIELIA_ID'               => '94',
    //西班牙ES-SUER快递公司ID
    'EXPRESS_ES_SUER_ID'				=> '161',
    /************************************************/
	//DE-KR派送方式id
    'EXPRESS_DE-KR_ID'					=> '58',
	//ES-CD派送方式id
    'EXPRESS_ES-CD_ID'					=> '67',
    //西班牙邮政-平邮快递公司ID
    'MAIL_ES_CORREOS_ID'                => '67',
    //IT-NEXIVE快递ID
    'EXPRESS_IT-NEXIVE_ID'              => '68',
    //派送方式PL-DPW 的 ID
    'EXPRESS_PL-DPW_ID'                 => '96',
    //快递公司名为‘仓库自提’的id
    'ONESELF_TAKE'                      =>  '31',
    //派送费用特殊处理
    'STEP_PRICE_CALCULATE'              => array(
						16,//德国GLS快递公司ID
						108,//UK-TNT快递公司ID
						61,//法国邮政快递公司ID
                                                94,//Envialia快递公司ID
						47,//IT-BRT
						161,//西班牙ES-SUER快递公司ID
                                                38,//FR-GLS
                                                62,//ES-ASM
                                                138,//UK-DHL
										),
	//IT-BRT-Oversea派送方式id
	'SHIPPING_IT-BRT-OVERSEA_ID'		=> '45',
    //意大利仓库ID
    'EXPRESS_IT_WAREHOUSE_ID'           => '4',
    //德国仓库ID
    'EXPRESS_DE_WAREHOUSE_ID'           => '2',
	//西班牙仓库ID added by jp 20150901 菜鸟对接默认仓库
	'EXPRESS_ES_WAREHOUSE_ID'			=> 3,
    //波兰仓ID
    'EXPRESS_PL_WAREHOUSE_ID'           => 11,

    /******************英国皇家邮政派送方式******************************/
    // added 20151104
    'EXPRESS_ROYAL_MAIL_ID'             => '106',//英国皇家邮政快递公司ID
    'UK-48'								=> '76',// UK-48派送方式ID
    'ROYAL_MAIL'						=> array(
											'71'=>array('STL2','L'),//UK-L-48
											'72'=>array('CRL2','F'),//UK-LL-48
											'73'=>array('STL1','L'),//UK-L-24
											'74'=>array('CRL1','F'),//UK-LL-24
											'75'=>array('CRL1','P'),//UK-P-24
											'76'=>array('TPS'),//UK-48 （0-100g  & MAX 240*165*5（mm））
//UK-48 （0-750g  &MAX 353*250*25（mm））
//UK-48   （0-15000g  & 1.包裹尺寸不小于102*75*15(mm)2.MAX 460 x 460 x 610 (mm)    3.卷轴形最长：900mm，直径最大：70mm）
											'77'=>array('TPN','P'),//UK-24
											'78'=>array('SD1','N'),//UK-S-24
											'80'=>array('OLA','IL'),//UK-L-EU
											'81'=>array('OLA','IF'),//UK-LL-EU
											'82'=>array('OLA','IP')//UK-P-EU
										),
    /************************************************/
    //意大利国家ID
    'IT_COUNTRY_ID'                     => '78',
    //德国国家ID
    'DE_COUNTRY_ID'                     => '57',
    'FR_COUNTRY_ID'                     => '52',//国家ID_FR
    //配置后台管理员隐藏的菜单id
    'ADMIN_NOT_SHOW_MENU_ID'            => '213,216,289,290',
    //材质说明properties表ID
    'MATERIAL_DESCRIPTION'              => 1,
    //hs code
    'HS_CODE'                           => 2,
    //申报价值
    'DECLARED_VALUE'                    => 4,
    //销售价格
    'SALE_PRICE'                        => 5,

    'SYS_PAY_CLASS'						=> array(//款项类别ID
											'deliveryFee'		=> 8,//派送费用ID
											'processFee'		=> 9,//处理费用
											'packageFee'		=> 10,//包装费用
											'deliveryCost'		=> 11,//派送成本
											'returnFee'         => 30,//退货费用
											'returnAdditionalFee'=>31,//额外费用
											'outerPackFee'      => 32,//外包装费用
											'withinPackFee'     => 33,//内包装费用
											//退货处理相关费用      add by lxt 2015.08.14
											'returnProcessFee'  => 41,//退货处理费用
											'returnPostageFee'  => 42,//回邮费用
                                            'insurePrice'       => 49,//投保金额
										),
    //问题订单
    'QUESTION_SYS_PAY_CLASS'			=> array(
											'proofDeliveryFee'      => 34,//签收证明费用
											'compensationFee'       => 35,//赔偿金
										),
    //仓储费
    'WAREHOUSE_ACCOUNT_SYS_PAY_CLASS'   => array(
											'warehouseAccoutnFee'    => 55,//仓储费
										),
    //国内运费
    'OUT_BATCH_SYS_PAY_CLASS'   => array(
											'domesticShippingFee'    => 47,//往来单位款项类别ID
										),

    //退货服务
    'RETURN_HOME'						=> 4,
    //销毁        add by lxt 2015.08.28
    'DOWN_AND_DESTORY'					=> 3,	//退货服务：销毁
    //送回中国      add by lxt 2015.08.28
    'BACK_TO_DOMESTIC'					=> 4,	//退货服务：退回国内
    //图片服务      add by lxt 2015.08.28
    'PICTURE'							=> 5,	//退货服务：拍照
	'PICTURE_GENERAL'					=> 13,	//退货服务：拍照->普通拍照
	'PICTURE_3C'						=> 15,	//退货服务：拍照->3C类产品拍照

    'OLD_FORMAT_RETURN_SALE_ORDER_NO_MAX_ID'	=> 14852,//老格式退货单号最大id

	'LOCAL_DIR'							=> '/home/www/Lucky_WMS/trunk/', //项目绝对路径
	'CFG_URL'							=> 'http://202.amoydream.com/Lucky_WMS/trunk/warehousing/',//外网仓储的地址

    /******************PARCEL_FORCE派送方式******************************/
    'EXPRESS_PARCEL_FORCE_ID'           => '127',
    'UK_COUNTRY_ID'                     => '61',//国家ID_UK
    'GB_COUNTRY_ID'                     => '162',//国家ID_GB
    'PARCEL_FORCE_SHIPPING'             => array(//PARCEL_FORCE的派送方式
        97  => 'PF24',//UK-PF-24 则显示 PF24
        98  => 'PF48',//UK-PF-48 则显示 PF48
        99  => 'EPH',//UK-PF-EU 则显示 EPH
    ),
    /************************************************/

  /******************FEDEX派送方式******************************/
   'EXPRESS_FEDEX_ID'                  => '164',
   'FEDEX_SHIPPING'             => array(//FEDEX的派送方式
        125  => 'A',//UK-FEDEX-A 则显示 PF24
        126  => 'B',//UK-FEDEX-B 则显示 PF48       
    ),
  /************************************************/

	/****************************************************
	 * 菜鸟系统对接参数 st
	 ****************************************************/

	//菜鸟系统速卖通卖家id
	//菜鸟测试环境地址（菜鸟的测试环境有白名单，请提前提供cp的外网IP）
	'CAINIAO_TEST_URL'						=> 'http://pac.partner.taobao.net/gateway/pac_message_receiver.do',
	//菜鸟生产环境地址
	'CAINIAO_URL'							=> 'http://pac.partner.taobao.com/gateway/pac_message_receiver.do',
	//菜鸟系统速卖通卖家id（系统新建卖家）
	'CAINIAO_FACTORY_ID'					=> 104,
	//菜鸟系统消息签名密钥（由菜鸟提供）
	'CAINIAO_SIGN_KEY'						=> 'AE1648952EDA',
	//4px系统消息签名密钥（由4px提供）
	'4PX_SIGN_KEY'							=> 'COEAE20150917',
	//菜鸟code
	'CAINIAO_NO'							=> 'CAINIAO',
	//仓库资源编码
	'CAINIAO_CP'							=> '5000000006772',
	'TRUNK_CODE'							=> 'TRUNK_1648952',
	'TRAN_STORE_CODE'						=> 'Tran_Store_1643484',
	//重量单位
	'CAINIAO_WEIGHT_UNIT'					=> 'g',
	//菜鸟请求api返回方式
	'CAINIAO_RESPONSE_TYPE'					=> 0,		//-1：模拟返回失败报文 0：模拟返回成功报文 1：发送至测试环境地址 2：发送到生成环境地址
	'CAINIAO_RESPONSE_REASON'				=> 'S01',
	'CAINIAO_RESPONSE_DESC'					=> 'test',
	'COE_EMAIL'								=> '179861748@qq.com,1220397479@qq.com',//COE邮箱
	'CAINIAO_REQUEST_ABNORMAL_SEND_EMAIL'	=> true,
	'CAINIAO_REQUEST_ABNORMAL_EMAIL'		=> '815576575@qq.com,179861748@qq.com',
	'CAINIAO_REQUEST_ABNORMAL_LIMIT'		=> 20,//错误次数限制
	/****************************************************
	 * 菜鸟系统对接参数 ed
	 ****************************************************/

        /****************************************************
	 * DHL对接参数 st
	 ****************************************************/
	'DHL_SANDBOX'						=> true,
	'DHL_CONFIG'						=> array(
											'WSDL_URL'			=> 'geschaeftskundenversand-api-1.0.wsdl',
											'WSDL_CACHE_WSDL'	=> 'WSDL_CACHE_NONE',
											'WSDL_TRACE'		=> true,
											'WSDL_LOGIN'		=> 'App1_1',
											'WSDL_PASSWD'		=> 'FwTYgI9AoE2Pfnc9Ri30ef9BM0qMJ3',
											'_USER'				=> 'edaug',
											'_SIGNATURE'		=> 'Hamburg123#',
											'_ACCOUNTNUMBER'	=> NULL,
											'_TYPE'				=> 0,
											'_VERSION'			=> array(
																	'majorRelease'	=> 1,
																	'minorRelease'	=> 0,
																),
											'EKP'				=> '6278528109',
											'PARTNER_ID'		=> array(
												'germany'	=> '02',
												'england'	=> '02',
												'other'		=> '02',
											),
											'PRODUCT_CODE'		=> array(
												'germany'	=> 'EPN',
												'england'	=> 'BPI',
												'other'		=> 'BPI',
											),
											'PACKAGE_TYPE'		=> 'PK',
											'CREATE_LIMIT'		=> 50,//创建发货单允许的最大数量
											'DELETE_LIMIT'		=> 50,//删除发货单允许的最大数量
											'UPDATE_LIMIT'		=> 1,//更新发货单允许的最大数量
	),
	'DHL_SANDBOX_CONFIG'				=> array(
								       		'WSDL_URL'			=> 'geschaeftskundenversand-api-1.0-sandbox.wsdl',
											'WSDL_CACHE_WSDL'	=> 'WSDL_CACHE_NONE',
											'WSDL_TRACE'		=> true,
											'WSDL_LOGIN'		=> 'eda01',
											'WSDL_PASSWD'		=> 'Hamburg123#',
											'_USER'				=> 'geschaeftskunden_api',
											'_SIGNATURE'		=> 'Dhl_ep_test1',
											'_ACCOUNTNUMBER'	=> NULL,
											'_TYPE'				=> 0,
											'_VERSION'			=> array(
																	'majorRelease'	=> 1,
																	'minorRelease'	=> 0,
																),
											'EKP'				=> '5000000000',
											'PARTNER_ID'		=> array(
												'germany'	=> '01',
												'england'	=> '01',
												'other'		=> '01',
											),
											'PRODUCT_CODE'		=> array(
												'germany'	=> 'EPN',
												'england'	=> 'EPN',
												'other'		=> 'EPN',
											),
											'PACKAGE_TYPE'		=> 'PK',
											'CREATE_LIMIT'		=> 10,//创建发货单允许的最大数量
											'DELETE_LIMIT'		=> 120,//删除发货单允许的最大数量
											'UPDATE_LIMIT'		=> 1,//更新发货单允许的最大数量
	),
        'DHL_SALE_ORDER_ID_LOWER_LIMIT'			=> 1,//DHL API订单下限id
	/****************************************************
	 * DHL对接参数 ed
	 ****************************************************/

/****************************************************
 * CORREOS对接参数 st
 ****************************************************/
	'CORREOS_SANDBOX'						=> true,
	//生产环境配置
	'CORREOS_CONFIG'						=> array(
											'WSDL_URL'			=> 'correos.wsdl',
											'WSDL_CACHE_WSDL'	=> 'WSDL_CACHE_NONE',
											'WSDL_TRACE'		=> true,
											'WSDL_LOGIN'		=> 'w0017261',
											'WSDL_PASSWD'		=> 'sY7UWEjF#',
											'_Location'			=> 'https://preregistroenvios.correos.es/preregistroenvios',
											'_CodEtiquetador'	=> '28XG',
											'CodProducto'		=> 'S0132',
	),
	//沙盒环境配置
	'CORREOS_SANDBOX_CONFIG'				=> array(
											'WSDL_URL'			=> 'correos.wsdl',
											'WSDL_CACHE_WSDL'	=> 'WSDL_CACHE_NONE',
											'WSDL_TRACE'		=> true,
											'WSDL_LOGIN'		=> 'w0017261',
											'WSDL_PASSWD'		=> 'fulIeLNv',
											'_Location'			=> 'https://preregistroenviospre.correos.es/preregistroenvios',
											'_CodEtiquetador'	=> 'XXX1',
											'CodProducto'		=> 'S0132',
	),
	'CORREOS_SALE_ORDER_ID_LOWER_LIMIT'			=> 0,//CORREOS API订单下限id

/****************************************************
 * CORREOS对接参数 ed
 ****************************************************/


);
?>
