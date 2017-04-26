<?php
/**
 +------------------------------------------------------------------------------
 * 后台信息管理
 +------------------------------------------------------------------------------
 * @copyright   2012 展联软件友拓通
 * @category  	 基本信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2012-07-10
 +------------------------------------------------------------------------------
 */

class AdminModel extends Model {
	// 指定表名
	protected $tableName = 'config';
	
	public $lang		 = array();
		
	/**
	 * 获取所有节点信息，用于模块开启，关闭
	 *
	 * @return uarray
	 */
	public function getNode(){
        $list =   M(C('RBAC_NODE_TABLE'))->where('level=1 and is_user=1 and group_id=0')->select();
        $menu	=	array();
        foreach($list as $key=>$value) {
        	if (in_array($value['id'], array(2,3,4,5,6))) {//1公共配置/2设置/3仓储/4入库/5拣货/6出库
        		$list2 =   M(C('RBAC_NODE_TABLE'))->where('is_user=1 and group_id>0 and parent_id='. $value['id'])->select();
        		foreach ($list2 as $value2) {
        			$menu[$value2['id']] = $value2;
        			$sql = 'select * from node where is_user=1 and level=2 and group_id>0 and parent_id =\''.$value2['id'].'\' order by sort asc';
	        		$list3 =   $this->query($sql);
	        		$menu[$value2['id']]['sub'] = $list3;
        		}
        	}else {
        		$menu[$value['id']] = $value;
	        	$sql = 'select * from node where is_user=1 and level=2 and group_id>0 and (parent_id in (select id from node where parent_id=\''.$value['id'].'\') or parent_id=\''.$value['id'].'\') order by sort asc';
	        	$list2 =   $this->query($sql);
	        	$menu[$value['id']]['sub'] = $list2;
        	}
        	
        }
        return $menu;
	}
	
	/**
	 * 保存模块信息信息
	 *
	 * @return  bool
	 */
	public function saveNode(){
		// 设置所有菜单为不可用
		$this->query('update '.C('RBAC_NODE_TABLE').' set status=0');
		// 设置已选菜单可用
		foreach ($_POST['flow'] as $id => $value) {
			$this->query('update '.C('RBAC_NODE_TABLE').' set status=1 where id='.$id);
		}
		// 设置可用菜单的关联菜单可用(上级和下级)
		$list = $this->query('select * from '.C('RBAC_NODE_TABLE').' where status=1');
		foreach ((array)$list as $value) {
			$this->query('update '.C('RBAC_NODE_TABLE').' set status=1 where parent_id='.$value['id'].' or id='.$value['parent_id']);
		}
		// 重复执行一次确保一级菜单勾选（只更新上级）
		$list = $this->query('select * from '.C('RBAC_NODE_TABLE').' where status=1');
		foreach ((array)$list as $value) {
			$this->query('update '.C('RBAC_NODE_TABLE').' set status=1 where id='.$value['parent_id']);
		}
		// 设置公共菜单可用
		$this->query('update '.C('RBAC_NODE_TABLE').' set status=1 where module=\'Public\'');
		$list = $this->query('select id from '.C('RBAC_NODE_TABLE').' where module=\'Public\'');
		$this->query('update '.C('RBAC_NODE_TABLE').' set status=1 where parent_id='.$list[0]['id']);
		return true;
	}
	
	/**
	 * 保存配置信息
	 *
	 * @return bool
	 */
	public function saveConfig(){
		$config_type = $_POST['config_type'];
    	$type_key = intval($_POST['type_key']);
    	if(empty($config_type)) halt('无法获取配置类型，请检查type值是否正确。');
    	unset($_POST['config_type'],$_POST['type_key'],$_POST['__hash__']);
    	$this->where('config_type=\''.$config_type.'\'')->delete();
    	foreach ($_POST as $key => $value) {
    		if (is_array($value) && !empty($value)) {
    			$value = implode(',',$value);
    		}
    		$this->add(array('config_key'=>$key,'config_value'=>$value,'config_type'=>$config_type,'type_key'=>$type_key));
    	}
    	$this->updateConfig();
    	return true;
	}
	
	
	public function updateConfig(){
		$list = $this->select();
		$config = array();
		foreach ($list as $key => $value) {
			if ($value['type_key']==1) {
				$config[$value['config_type']][$value['config_key']] = $value['config_value'];
			}else {
				$config[$value['config_key']] = $value['config_value'];
			}
		}
		/// 删除缓存的runtime文件
		@unlink(RUNTIME_FILE);
		file_put_contents(CONFIG_FILE,'<?php return '.var_export($config,true).';?>');
	}
	
	public function updateCurrency($data){
		$temp_currendy = array();
        $data['client_currency'] && $temp_currendy = array_merge($temp_currendy,$data['client_currency']);
        $data['factory_currency'] &&  $temp_currendy = array_merge($temp_currendy,$data['factory_currency']);
        $data['logistics_currency'] && $temp_currendy = array_merge($temp_currendy,$data['logistics_currency']);
        $data['company_currency'] && $temp_currendy = array_merge($temp_currendy,$data['company_currency']);
        $temp_currendy = array_unique($temp_currendy); 
        $_POST['client_currency_count']		=	count($_POST['client_currency']);
        $_POST['factory_currency_count']	=	count($_POST['factory_currency']);
        $_POST['logistics_currency_count']	=	count($_POST['logistics_currency']);
        $_POST['company_currency_count']	=	count($_POST['company_currency']);  
        
        if (!empty($temp_currendy)) {
        	M('Currency')->execute('update __TABLE__ set is_delete = 2');
        	M('Currency')->execute('update __TABLE__ set is_delete = 1 where id in('.implode(',',$temp_currendy).')');
        }
        return true;
	}
	
	public function saveTemplete($info,$filename) {
		ini_set('memory_limit', '512M');
		@unlink(ADMIN_RUNTIME_PATH.'Data/Excel/'.$filename.'.xls');
		addLang('product,common');
	  	vendor('PhpExcel.PHPExcel','','.php');
	  	$objPHPExcel = new PHPExcel();
	  	// 设置excel文件信息
	  	$objPHPExcel->getProperties()->setCreator("ytt")->setTitle("Excel模板");
	  	$objPHPExcel->createSheet(0);
	  	$qt = 'A';
	  	$objActSheet = $objPHPExcel->setActiveSheetIndex(0);
	  	foreach ($info as $key => $value) {
	  		if($filename=='InitStorage' || $filename=='Stocktake' || $filename=='Product'){
		  		switch ($value[0]) {
		  			case 'color_name':
		  				if ($filename=='Product') {
		  					$title = '颜色';
		  				}else {
			  				if(C($filename.'.color')==1){
			  					$title	= L('color_name');
			  				}else{
			  					$title =  '1';
			  				}
		  				}
		  				break;
		  			case 'size_name':
		  				if ($filename=='Product') {
		  					$title = '尺码';
		  				}else {
			  				if(C($filename.'.size')==1){
			  					$title	= L('size_name');
			  				}else{
			  					$title =  '1';
			  				}
		  				}
		  				break;
		  			case 'quantity':
		  				if(C($filename.'.storage_format')==1){
		  					$title = '数量';
		  				}else{
		  					$title = '箱数';
		  				}
		  				break;
		  			case 'capability':
		  				if ($filename=='Product') {
		  					$title = '每箱数量';
		  				}else {
		  					if(C($filename.'.storage_format')==2)
		  						$title = '每箱数量';
		  					else 
		  						$title =  '1';
		  				}
		  				break;
		  			case 'dozen':
		  				if ($filename=='Product') {
		  					$title = '每包数量';
		  				}else {
			  				if(C($filename.'.storage_format')==3)
			  					$title = '每包数量';
			  				else 
			  					$title =  '1';
		  				}
		  				break;	
		  			case 'quantity_state':
		  				if(C($filename.'.mantissa')==1)
		  					$title = '尾箱';
		  				else 
		  					$title =  '1';
		  				break;	
		  			default:
		  				$title = L($value[0]);
		  				break;
		  		}
			}elseif($filename=='InstockDetail'){
				switch ($value[0]) {
					case 'box_no':
						$title	= '箱号';
						break;
					case 'cube_long':
						$title	= '长(CM)';
						break;
					case 'cube_wide':
						$title	= '宽(CM)';
						break;	
		  			case 'cube_high':
						$title = '高(CM)';
		  				break;	
		  			case 'weight':
						$title = '重量(G)';
		  				break;						
					case 'product_no':
						$title	= '产品SKU';
						break;	
		  			case 'quantity':
						$title = '产品数量';
		  				break;	
                    case 'declared_value':
                        $title ='申报价值$';
                        break;
		  			default:
		  				$title = L($value[0]);
		  				break;					
				}
			}elseif($filename=='InstockImport'){
				switch ($value[0]) {
					case 'product_id':
						$title	= 'ID';
						break;
		  			case 'quantity':
						$title = 'Quantity';
		  				break;		
					case 'box_id':
						$title	= 'Box_ID';
						break;	
					case 'barcode_no':
						$title	= 'Location';
						break;
					case 'factory_id':
						$title	= 'Client';
						break;
					case 'create_time':
						$title	= 'DateTime';
						break;
		  			default:
		  				$title = L($value[0]);
		  				break;					
				}
			}elseif($filename=='PickingImport'){
				switch ($value[0]) {
					case 'product_id':
						$title	= 'P_ID';
						break;
		  			case 'product_no':
						$title = 'SKU';
		  				break;		
					case 'quantity':
						$title	= 'Quantity';
						break;	
					case 'barcode_no':
						$title	= 'Location';
						break;
					case 'real_quantity':
						$title	= 'Plan_Q';
						break;
					case 'create_time':
						$title	= 'DateTime';
						break;
		  			default:
		  				$title = L($value[0]);
		  				break;					
				}
			}else{
	  			$title = L($value[0]);
	  		}
	  		if($title!=1){
		  		$objActSheet->setCellValue($qt.'1', $title);
		  		$objActSheet->getColumnDimension($qt)->setWidth(strlen($title)+2);
		  		$objStyle = $objActSheet->getStyle($qt.'1');
		  		
	
		  		$objStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		  		$objStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
		  		if($value[1]==1) {
		  			$objStyle->getFont()->getColor()->setARGB('FFff0000'); 
		  		}
		  		$objPHPExcel->getActiveSheet()->getStyle($qt)->getNumberFormat()->setFormatCode("@");
		  		$qt++;
	  		}
	  		$title	= '';
	  	}
	  	// 设置文件格式为Excel5
	  	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save(ADMIN_RUNTIME_PATH.'Data/Excel/'.$filename.'.xls');
	}
	
	 public  function saveExcelAry($data) {
    	$ary = array();
    	// 国家、城市
    	$ary['District'][1] = array('country_name',1,'district_name');
    	$ary['District'][2] = array('city_name',0);
    	// 员工
    	$ary['Employee'][1] = C('SETAUTO_EMPLOYEE_NO') ? array('employee_no',0) : array('employee_no',1);
    	$ary['Employee'][2] = array('employee_name',1);
    	$ary['Employee'][3] = array('sex',0);
    	$ary['Employee'][4] = array('department_name',0);
    	$ary['Employee'][5] = array('position_name',0);
    	$ary['Employee'][6] = array('phone',0);
    	$ary['Employee'][7] = array('email',0);
    	$ary['Employee'][8] = array('entry_date',1);
    	$ary['Employee'][9] = array('leave_date',0);
    	$ary['Employee'][10] = array('comments',0);
    	// 颜色
    	$ary['Color'][1] =  C('SETAUTO_COLOR_NO') ? array('color_no',0) : array('color_no',1);
    	$ary['Color'][2] = array('color_name',1);
    	// 尺码
    	$ary['Size'][1] = C('SETAUTO_SIZE_NO') ? array('size_no',0) : array('size_no',1);
    	$ary['Size'][2] = array('size_name',1);
    	// 产品
    	$ary['Product'][1] = C('SETAUTO_PROPERTIES_NO') ? array('product_no',0) : array('product_no',1);
    	$ary['Product'][2] = array('product_name',1);
    	$ary['Product'][3] = array('class_name',1);
    	if (C('PRODUCT_FACTORY')==1) {
    		$ary['Product'][4] = array('factory_name',1);
    	}
 		$ary['Product'][5] = array('instock_price',0);
 		$ary['Product'][6] = array('wholesale_price',0);
 		$ary['Product'][7] = array('retail_price',0);
 		$ary['Product'][8] = array('sale_price',0);
 		if (C('product_color')==1) {
    		$ary['Product'][9] = C('PRODUCT_COLOR') ? array('color_name',1) : array('color_name');
    	}
 		if (C('product_size')==1) {
    		$ary['Product'][10] = C('PRODUCT_SIZE') ? array('size_name',1) : array('size_name');
    	}
    	if (C('storage_format')==2){
    		$ary['Product'][11] = array('capability',1);
    	}
    	
    	if (C('storage_format')==3) {
    			$ary['product'][12] = array('dozen',1);
    	}
    	// 客户
    	$ary['Client'][1] = C('SETAUTO_CLIENT_NO') ? array('comp_no',0) : array('comp_no',1,'comp_no');
    	$ary['Client'][2] = array('client_name',1,'comp_name');
    	$ary['Client'][3] = array('tax_no',0);
    	$ary['Client'][4] = array('country_name',0);
    	$ary['Client'][5] = array('city_name',0);
    	$ary['Client'][6] = array('remind_day',0);
    	$ary['Client'][7] = array('credit',0);
    	$ary['Client'][8] = array('contact',0);
    	$ary['Client'][9] = array('mobile',0);
    	$ary['Client'][10] = array('phone',0);
    	$ary['Client'][11] = array('address',0);
    	$ary['Client'][12] = array('post_code',0);
    	$ary['Client'][13] = array('fax',0);
    	$ary['Client'][14] = array('email',0);
    	$ary['Client'][15] = array('comments',0);
		// 厂家
    	$ary['Factory'][1] = C('SETAUTO_FACTORY_NO') ? array('comp_no',0) : array('comp_no',1,'comp_no');
    	$ary['Factory'][2] = array('factory_name',1,'comp_name');
    	$ary['Factory'][3] = array('currency_name',1);
    	$ary['Factory'][4] = array('country_name',0);
    	$ary['Factory'][5] = array('city_name',0);
    	$ary['Factory'][6] = array('remind_day',0);
    	$ary['Factory'][7] = array('contact',0);
    	$ary['Factory'][8] = array('mobile',0);
    	$ary['Factory'][9] = array('phone',0);
    	$ary['Factory'][10] = array('address',0);
    	$ary['Factory'][11] = array('post_code',0);
    	$ary['Factory'][12] = array('fax',0);
    	$ary['Factory'][13] = array('email',0);
    	$ary['Factory'][14] = array('comments',0);
		// 其它往来单位
    	$ary['OtherCompany'][1] = C('SETAUTO_OTHERCOMPANY_NO') ? array('comp_no',0) : array('comp_no',1,'comp_no');
    	$ary['OtherCompany'][2] = array('other_company_name',1,'comp_name');
    	$ary['OtherCompany'][3] = array('country_name',0);
    	$ary['OtherCompany'][4] = array('city_name',0);
    	$ary['OtherCompany'][5] = array('remind_day',0);
    	$ary['OtherCompany'][6] = array('contact',0);
    	$ary['OtherCompany'][7] = array('mobile',0);
    	$ary['OtherCompany'][8] = array('phone',0);
    	$ary['OtherCompany'][9] = array('address',0);
    	$ary['OtherCompany'][10] = array('post_code',0);
    	$ary['OtherCompany'][11] = array('fax',0);
    	$ary['OtherCompany'][12] = array('email',0);
    	$ary['OtherCompany'][13] = array('comments',0);
		// 期初库存
    	$ary['InitStorage'][1] = array('product_name',1,'product_no');
    	if (C('initStorage.color')==1) {
    		$ary['InitStorage'][2] = array('color_name',1);
    	}
    	if (C('initStorage.size')==1) {
    		$ary['InitStorage'][3] = array('size_name',1);
    	}
    	$ary['InitStorage'][4] = array('quantity',1);
    	$ary['InitStorage'][5] = array('capability',1);
    	if (C('initStorage.storage_format')==3) {
    		$ary['InitStorage'][6] = array('dozen',1);
    	}
    	$ary['InitStorage'][7] = array('price',1);
    	if (C('initStorage.mantissa')==1) {
    		$ary['InitStorage'][8] = array('quantity_state',1);
    	}
    	// 库存盘点
    	$ary['Stocktake'][1] = array('product_name',1,'product_no');
    	if (C('stocktake.color')==1) {
    		$ary['Stocktake'][2] = array('color_name',1);
    	}
    	if (C('stocktake.size')==1) {
    		$ary['Stocktake'][3] = array('size_name',1);
    	}
    	$ary['Stocktake'][4] = array('quantity',1);
    	$ary['Stocktake'][5] = array('capability',1);
    	if (C('stocktake.storage_format')==3) {
    		$ary['Stocktake'][6] = array('dozen',1);
    	}
    	$ary['Stocktake'][7] = array('price',1);
    	if (C('Stocktake.mantissa')==1) {
    		$ary['Stocktake'][8] = array('quantity_state',1);
    	}
    	// 厂家期初欠款
		$ary['FactoryIni'][1] = array('factory_name',1,'comp_name'); 
		$ary['FactoryIni'][3] = array('paid_date',1);
		$ary['FactoryIni'][4] = array('currency_name',1);
		$ary['FactoryIni'][5] = array('money',1,);
		$ary['FactoryIni'][6] = array('comments',0);
		// 客户期初欠款
		$ary['ClientIni'][1] = array('client_name',1);
		$ary['ClientIni'][2] = array('company_name',1);
		$ary['ClientIni'][3] = array('paid_date',1);
		$ary['ClientIni'][4] = array('currency_name',1);
		$ary['ClientIni'][5] = array('money',1);
		$ary['ClientIni'][6] = array('comments',0);
		
		//发货单导入 added by jp 20140329
		$ary['InstockDetail'][1]	=     array ('box_no',1);
		$ary['InstockDetail'][2]	=     array ('cube_long',0);
		$ary['InstockDetail'][3]	=     array ('cube_wide',0);
		$ary['InstockDetail'][4]	=     array ('cube_high',0);
		$ary['InstockDetail'][5]	=     array ('weight',0);
		$ary['InstockDetail'][6]	=     array ('product_no',1);
		$ary['InstockDetail'][7]	=     array ('quantity',1);
        $ary['InstockDetail'][8]    =     array ('declared_value',0);
        
        //移仓导入  add by lxt 2015.07.20
        $ary['ShiftWarehouseDetail'][1] =   array('product_id',1);
        $ary['ShiftWarehouseDetail'][2] =   array('product_no',1);
        $ary['ShiftWarehouseDetail'][3] =   array('out_barcode_no',1);
        $ary['ShiftWarehouseDetail'][4] =   array('in_barcode_no',1);
        $ary['ShiftWarehouseDetail'][5] =   array('quantity',1);
        
        //派送方式  add by yyh 20151102
        $ary['ExpressPost'][1] =   array('english',1);
        $ary['ExpressPost'][2] =   array('post_begin',1);
        $ary['ExpressPost'][3] =   array('post_end',1);
        
        //速卖通订单导入   add by lxt 2015.07.22
        $ary['PayPalSaleOrderImport'][1]    =   array('order_no',1);//订单单号
        $ary['PayPalSaleOrderImport'][2]    =   array('product_info',0);//产品信息，不存入系统
        $ary['PayPalSaleOrderImport'][3]    =   array('address',1);//街道一
        $ary['PayPalSaleOrderImport'][4]    =   array('consignee',1);//收货人
        $ary['PayPalSaleOrderImport'][5]    =   array('country_name',1);//所属国家
        $ary['PayPalSaleOrderImport'][6]    =   array('company_name',1);//所在省份
        $ary['PayPalSaleOrderImport'][7]    =   array('city_name',1);//所在城市
        $ary['PayPalSaleOrderImport'][8]    =   array('address_useless',0);//地址，不记录到系统中
        $ary['PayPalSaleOrderImport'][9]    =   array('post_code',1);//邮编
        $ary['PayPalSaleOrderImport'][10]   =   array('mobile',0);//客户电话
        $ary['PayPalSaleOrderImport'][11]   =   array('cellphone',0);//手机，不存入系统
        $ary['PayPalSaleOrderImport'][12]   =   array('order_date',1);//订单日期
        $ary['PayPalSaleOrderImport'][13]   =   array('comp_name',1);//客户名称
        $ary['PayPalSaleOrderImport'][14]   =   array('order_type',1);//销售渠道
        $ary['PayPalSaleOrderImport'][15]   =   array('warehouse_id',1);//仓库名称
        $ary['PayPalSaleOrderImport'][16]   =   array('express_id',1);//派送方式
        $ary['PayPalSaleOrderImport'][17]   =   array('is_registered',1);//是否挂号
        $ary['PayPalSaleOrderImport'][18]   =   array('country_id',1);//国家编号
        $ary['PayPalSaleOrderImport'][19]   =   array('email',0);//邮箱
        $ary['PayPalSaleOrderImport'][20]   =   array('tax_no',0);//税号
        $ary['PayPalSaleOrderImport'][21]   =   array('aliexpress_token',1);//验证码
        $ary['PayPalSaleOrderImport'][22]   =   array('is_insure',1);//是否投保
        $ary['PayPalSaleOrderImport'][23]   =   array('product_no',1);//产品1
        $ary['PayPalSaleOrderImport'][24]   =   array('quantity',1);//产品1数量
        $ary['PayPalSaleOrderImport'][25]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][26]   =   array('quantity',0);
        $ary['PayPalSaleOrderImport'][27]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][28]   =   array('quantity',0);
        $ary['PayPalSaleOrderImport'][29]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][30]   =   array('quantity',0);
        $ary['PayPalSaleOrderImport'][31]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][32]   =   array('quantity',0);
        $ary['PayPalSaleOrderImport'][33]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][34]   =   array('quantity',0);
        $ary['PayPalSaleOrderImport'][35]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][36]   =   array('quantity',0);
        $ary['PayPalSaleOrderImport'][37]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][38]   =   array('quantity',0);
        $ary['PayPalSaleOrderImport'][39]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][40]   =   array('quantity',0);
        $ary['PayPalSaleOrderImport'][41]   =   array('product_no',0);
        $ary['PayPalSaleOrderImport'][42]   =   array('quantity',0);
        
		//入库单导入 added by jp 20140329
		$ary['InstockImport'][1]	=     array ('product_id',1);
		$ary['InstockImport'][2]	=     array ('quantity',1);
		$ary['InstockImport'][3]	=     array ('box_id',1);		
		$ary['InstockImport'][4]	=     array ('barcode_no',1);
		$ary['InstockImport'][5]	=     array ('factory_id',0);
		$ary['InstockImport'][6]	=     array ('create_time',1);
		
		//订单导入 added by jp 20140329
		$ary['SaleOrderImport'][1]	=     array ('order_no',1);
		$ary['SaleOrderImport'][2]	=     array ('comp_name',1);
		$ary['SaleOrderImport'][3]	=     array ('order_date',1);		
		$ary['SaleOrderImport'][4]	=     array ('order_type',1);
		$ary['SaleOrderImport'][5]	=     array ('warehouse_id',1);
		$ary['SaleOrderImport'][6]	=     array ('express_id',1);
		$ary['SaleOrderImport'][7]	=     array ('is_registered',1);

		$ary['SaleOrderImport'][8]	=     array ('consignee',1);
		$ary['SaleOrderImport'][9]	=     array ('address',1);
		$ary['SaleOrderImport'][10]	=     array ('address2',0);
		$ary['SaleOrderImport'][11]	=     array ('company_name',0);
		$ary['SaleOrderImport'][12]	=     array ('city_name',1);
		$ary['SaleOrderImport'][13]	=     array ('post_code',1);
		$ary['SaleOrderImport'][14]	=     array ('country_name',1);
		$ary['SaleOrderImport'][15]	=     array ('country_id',1);
		$ary['SaleOrderImport'][16]	=     array ('email',0);
		$ary['SaleOrderImport'][17]	=     array ('mobile',0);
		$ary['SaleOrderImport'][18]	=     array ('tax_no',0);
		$ary['SaleOrderImport'][19]	=     array ('is_insure',1);

		$ary['SaleOrderImport'][20]	=     array ('product_no',1);
		$ary['SaleOrderImport'][21]	=     array ('quantity',1);
		$ary['SaleOrderImport'][22]	=     array ('product_no',0);
		$ary['SaleOrderImport'][23]	=     array ('quantity',0);
		$ary['SaleOrderImport'][24]	=     array ('product_no',0);
		$ary['SaleOrderImport'][25]	=     array ('quantity',0);
		$ary['SaleOrderImport'][26]	=     array ('product_no',0);
		$ary['SaleOrderImport'][27]	=     array ('quantity',0);
		$ary['SaleOrderImport'][28]	=     array ('product_no',0);
		$ary['SaleOrderImport'][29]	=     array ('quantity',0);
		$ary['SaleOrderImport'][30]	=     array ('product_no',0);
		$ary['SaleOrderImport'][31]	=     array ('quantity',0);
		$ary['SaleOrderImport'][32]	=     array ('product_no',0);
		$ary['SaleOrderImport'][33]	=     array ('quantity',0);
		$ary['SaleOrderImport'][34]	=     array ('product_no',0);
		$ary['SaleOrderImport'][35]	=     array ('quantity',0);
		$ary['SaleOrderImport'][36]	=     array ('product_no',0);
		$ary['SaleOrderImport'][37]	=     array ('quantity',0);
		$ary['SaleOrderImport'][38]	=     array ('product_no',0);
		$ary['SaleOrderImport'][39]	=     array ('quantity',0);
        
		//ECPP订单导入 added by yyh 20141024
        
        $ary['ECPPSaleOrderImport'][0] = array('account', 0);
        $ary['ECPPSaleOrderImport'][1] = array('order_date', 1);
        $ary['ECPPSaleOrderImport'][2] = array('order_no', 1);
        $ary['ECPPSaleOrderImport'][3] = array('product_no', 1);
        $ary['ECPPSaleOrderImport'][4] = array('quantity', 1);
        $ary['ECPPSaleOrderImport'][5] = array('product_name', 0);
        $ary['ECPPSaleOrderImport'][6] = array('sale_price', 0);
        $ary['ECPPSaleOrderImport'][7] = array('sale_freight', 0);
        $ary['ECPPSaleOrderImport'][8] = array('total', 0);
        $ary['ECPPSaleOrderImport'][9] = array('currency', 0);
        $ary['ECPPSaleOrderImport'][10] = array('comments', 0);
        $ary['ECPPSaleOrderImport'][11] = array('ebay_item_No', 0);
        $ary['ECPPSaleOrderImport'][12] = array('payment_way', 0);
        $ary['ECPPSaleOrderImport'][13] = array('Transaction_no', 0);
        $ary['ECPPSaleOrderImport'][14] = array('comp_id', 0);
        $ary['ECPPSaleOrderImport'][15] = array('consignee', 1);
        $ary['ECPPSaleOrderImport'][16] = array('address', 1);
        $ary['ECPPSaleOrderImport'][17] = array('address2', 0);
        $ary['ECPPSaleOrderImport'][18] = array('company_name', 0);
        $ary['ECPPSaleOrderImport'][19] = array('city_name', 1);
        $ary['ECPPSaleOrderImport'][20] = array('post_code', 1);
        $ary['ECPPSaleOrderImport'][21] = array('country_name', 1);
        $ary['ECPPSaleOrderImport'][22] = array('country_id', 1);
        $ary['ECPPSaleOrderImport'][23] = array('mobile', 0);
        $ary['ECPPSaleOrderImport'][24] = array('email', 0);
        $ary['ECPPSaleOrderImport'][25] = array('express_id', 1);
        $ary['ECPPSaleOrderImport'][26] = array('Courier_no', 0);
        $ary['ECPPSaleOrderImport'][27] = array('delivery_time', 0);
        $ary['ECPPSaleOrderImport'][28] = array('weigh', 0);
        $ary['ECPPSaleOrderImport'][29] = array('real_freight', 0);
        $ary['ECPPSaleOrderImport'][30] = array('product_cost', 0);
        $ary['ECPPSaleOrderImport'][31] = array('poundage', 0);
        $ary['ECPPSaleOrderImport'][32] = array('pay_fee', 0);
        $ary['ECPPSaleOrderImport'][33] = array('Sellerrecord', 0);
        $ary['ECPPSaleOrderImport'][34] = array('order_state', 0);
        $ary['ECPPSaleOrderImport'][35] = array('goods_location', 0);
        $ary['ECPPSaleOrderImport'][36] = array('product_name', 0);
        $ary['ECPPSaleOrderImport'][37] = array('outStock_no', 0);
        $ary['ECPPSaleOrderImport'][38] = array('order_type', 1);
        $ary['ECPPSaleOrderImport'][39] = array('warehouse_id', 1);
        $ary['ECPPSaleOrderImport'][40] = array('is_registered', 1);
        $ary['ECPPSaleOrderImport'][41] = array('is_insure', 1);



        //拣货导入 added by jp 20140419
		$ary['PickingImport'][1]	=     array ('product_id',1);
		$ary['PickingImport'][2]	=     array ('product_no',1);
		$ary['PickingImport'][3]	=     array ('quantity',1);		
		$ary['PickingImport'][4]	=     array ('barcode_no',1);
		$ary['PickingImport'][5]	=     array ('real_quantity',1);
		$ary['PickingImport'][6]	=     array ('create_time',1);		

		//产品导入 added by jp 20140419
		$ary['ProductImport'][1]	=     array ('product_name',1);
		$ary['ProductImport'][2]	=     array ('product_no',1);
		$ary['ProductImport'][3]	=     array ('cube_long',1);		
		$ary['ProductImport'][4]	=     array ('cube_wide',1);
		$ary['ProductImport'][5]	=     array ('cube_high',1);
		$ary['ProductImport'][6]	=     array ('weight',1);		
		$ary['ProductImport'][7]	=     array ('warning_quantity',0);		
		$ary['ProductImport'][8]	=     array ('product_detail',1);		
		$ary['ProductImport'][9]	=     array ('product_detail',1);
        $ary['ProductImport'][10]	=     array ('product_detail',1);		
		$ary['ProductImport'][11]	=     array ('product_detail',1);
		$ary['ProductImport'][12]	=     array ('custom_barcode',0);
        
        //产品查验导入 
		$ary['ProductCheckImport'][1]	=     array ('id',1);
		$ary['ProductCheckImport'][2]	=     array ('check_weight',1);
		$ary['ProductCheckImport'][3]	=     array ('check_long',1);		
		$ary['ProductCheckImport'][4]	=     array ('check_wide',1);
		$ary['ProductCheckImport'][5]	=     array ('check_high',1);
		$ary['ProductCheckImport'][6]	=     array ('check_status',1);		
        

		//库存导入 added by jp 20140329
		$ary['AdjustDetail'][1]	=     array ('product_id',1);
		$ary['AdjustDetail'][2]	=     array ('product_no',1);
		$ary['AdjustDetail'][3]	=     array ('barcode_no',1);
		$ary['AdjustDetail'][4]	=     array ('quantity',1);
		
		//入库导入调整导入 wsl 20170222
		$ary['AdjustInstockDetail'][1]	=     array ('box_id',1);
		$ary['AdjustInstockDetail'][2]	=     array ('product_id',1);
		$ary['AdjustInstockDetail'][3]	=     array ('barcode_no',1);
		$ary['AdjustInstockDetail'][4]	=     array ('adjust_quantity',1);
        
        
        //发货入库 added by yyh 20141113
		$ary['InstockStorage'][1]	=     array ('product_id',1);
		$ary['InstockStorage'][3]	=     array ('quantity',1);
		$ary['InstockStorage'][4]	=     array ('warehouse_location',1);

		file_put_contents(ADMIN_RUNTIME_PATH.'~ExcelTemplete.php',"<?php\nreturn ".var_export($ary,true)."\n?>");
    }
    
    public function importLang($path){
    	if(empty($path)){
    		return ;
    	}
    	$lang	= getAllFile($path,true);

    	foreach ($lang as $key=>$val){
			if(strpos($val,'.php')){
				$temp	= include($path.$val);
				$arr	= array_filter(explode('/',$path));
				if(count($arr)>6){
					$type	= end($arr);
				}else{
					$type	= str_replace('.php','',$val);
				}
				$this->addLangToDb($temp,str_replace('.php','',$val),$type);
			}else{
				$this->importLang($path.$val.'/');
			}
		}
    }
    /**
     * 语言包加入DB
     *
     * @param unknown_type $lang
     */
    public function addLangToDb($lang,$module,$type){
    	foreach($lang as $k=>$v){
			$data['module']		= $module;
			$data['lang_key']	= $k;
			$data['lang_value_'.$type]=$v;
			$data['is_public']	= 1;
			M('lang')->data($data)->add();
			unset($data);
		}
    }
    
    /**
     * 根据配置模块获取相应配置值  一维数据
     * @param  string  $module
     * @return  array 
     */
    public function getModuleConf($module){
    	$temp = $this->where('config_type=\''.$module.'\'')->select();
    	$list = array();
    	foreach ($temp as $value) {
    		$list[$value['config_key']] = $value['config_value'];
    	}
    	return $list;
    }
    
}