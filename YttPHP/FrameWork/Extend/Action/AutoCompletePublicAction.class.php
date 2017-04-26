<?php
/**
 * 表单中autosearch类  特别说明：所有带name或no为基本信息使用，不需要过滤已删除记录
 * @copyright   2011 展联软件友拓通
 * @category   	通用
 * @package  	Action 
 * @version 	2011-03-25
 * @author 		何剑波
 */
class AutoCompletePublicAction extends Action {
	
	protected $where 	= ' 1 ';
	protected $term  	= '';
	protected $limit 	= '0,20';
	protected $result 	= array();
	
	/// 构造函数
	public function __construct() {
		$this->term 	= trim($_POST['term']); 
		$where 			= urldecode(trim($_POST['where']));
        if(ACTION_NAME=='bank'){
            C('CFG_OPEN_ESCAPE',true);
        }
        if (C('CFG_OPEN_ESCAPE')) {//added by jp 20140519
			$where	= stripslashes_deep($where);
		}
		if ($where && $where!='undefined') $this->where .= ' and '.$where;
	}
	
	protected function getWhere($field, $like = true){
		if($this->term){
			is_string($field) && $field	= explode('|', $field);
			$condition	= $like === false ? array('`', 'value', "` = '", $this->term, "'") : array('`', 'value', "` like '%", $this->term, "%'");
			$where		= getStrFromArr($field,' or ', $condition);
			$this->where .= ' and (' . $where . ')';
		}
		return $this->where;
	}
	
	/// 析构函数
	public function __destruct() {
		foreach ($this->result as &$value) {
			foreach ($value as &$value2) {
				$value2 = htmlspecialchars_decode($value2);
			}
		}
		echo json_encode($this->result);
	}
	
	/// 语言包模块
	public function langModule(){
		$this->result	= M('Lang')->where($this->getWhere('module'))->order('module')->group('module')->limit($this->limit)->field('id as id,module as value')->select();
	}
	public function langModuleForClient(){
		$where			= $this->getWhere('lang_value_'.LANG_SET);
		$module			= M('Lang')->field('module')->group('module')->select();
		foreach($module as $val){
			$arr[]		= 'module_'.$val['module'];
		}
		$where			.=" and lang_key in ('".@implode("','",$arr)."')"; 
		$this->result	= M('Lang')->field('substr(lang_key,8) as id,lang_value_'.LANG_SET.' as value')->where($where)->order('lang_value_'.LANG_SET.' desc')->select();

	}
	
	///国家名称--国家列表
	public function countryName(){
		$where			= $this->getWhere('abbr_district_name|district_name').' and parent_id=0';
		$this->result	= M('District')->where($where)->order('district_name ')->limit($this->limit)->field('id as id,CONCAT(abbr_district_name,"—",district_name) as value')->select();
	}
	
	///国家代码
	public function abbrDistrictName(){
		$where			= $this->getWhere('abbr_district_name').' and parent_id=0 and abbr_district_name is not null';
		$this->result	= M('District')->where($where)->order('abbr_district_name ')->limit($this->limit)->field('id as id,abbr_district_name as value')->select();
	}
	
	///城市名称--国家列表
	public function cityName(){
		$where			= $this->getWhere('district_name').' and parent_id>0';
		$this->result	= M('District')->where($where)->order('district_name ')->limit($this->limit)->field('id as id,district_name as value')->select();
	}
	///公司名称
	public function companyName(){
		$this->result	= M('Basic')->where($this->getWhere('basic_name'))->order('basic_name desc')->limit($this->limit)->field('id as id,basic_name as value')->select();
	}
	///仓库编号
	public function warehouseNo(){
		$this->result	= M('Warehouse')->where($this->getWhere('w_no'))->order('w_no desc')->limit($this->limit)->field('id as id,w_no as value')->select();
	}
	///仓库名称
	public function warehouseName(){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $this->result	= M('Warehouse')->where($this->getWhere('w_name').'  and id='.getUser('company_id'). ' and to_hide=1')->field('id as id,w_name as value')->select();
        }else{
            $this->result	= M('Warehouse')->where($this->getWhere('w_name'). ' and to_hide=1')->order('w_name desc')->limit($this->limit)->field('id as id,w_name as value')->select();
        }
	}
	///已启用仓库名称
	public function warehouseNameUse(){
		$where			= $this->getWhere('w_name').' and is_use=1 and to_hide=1';
		$this->result	= M('Warehouse')->where($where)->order('w_name desc')->limit($this->limit)->field('id as id,w_name as value')->select();
	}
    public function saleWarehouse(){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $where			= $this->getWhere('w_name').' and id='.getUser('company_id').' and is_use=1 and to_hide=1 and is_return_sold='.C('CAN_RETURN_SOLD');
        }else{
            $where			= $this->getWhere('w_name').' and is_use=1 and to_hide=1 and is_return_sold='.C('CAN_RETURN_SOLD');
        }
		$this->result	= M('Warehouse')->where($where)->order('w_name desc')->limit($this->limit)->field('id as id,w_name as value')->select();
    }
	///员工编号
	public function employeeNo(){
		$this->result	= M('Employee')->where($this->getWhere('employee_no'))->order('employee_no desc')->limit($this->limit)->field('id as id,employee_no as value')->select();
	}
	///员工名称
	public function employeeName(){
		$this->result	= M('Employee')->where($this->getWhere('employee_name'))->order('employee_name desc')->limit($this->limit)->field('id as id,employee_name as value')->select();
	}
	///银行简称
	public function accountName(){
		$this->result	= M('Bank')->where($this->getWhere('account_name').' and to_hide=1 ')->order('account_name desc')->limit($this->limit)->field('id as id,account_name as value')->select();
	}
	///银行名称
	public function bankName(){
		$this->result	= M('Bank')->where($this->getWhere('bank_name'))->order('bank_name desc')->limit($this->limit)->field('id as id,bank_name as value')->select();
	}
	///银行名称
	public function bank(){ 
		$this->result	= M('Bank')->where($this->getWhere('bank_name').' and to_hide=1 ')->order('bank_name desc')->limit($this->limit)->field('id as id,bank_name as value')->select();
	}
	/// 银行帐号
	public function accountFundStat() {	 
		$array[-1]	=	array( 
								'id'=>-1,
								'value'=>'现金',
								);
		$array[-2]	=	array( 
								'id'=>-2,
								'value'=>'支票',
								);
		$data	= M('Bank')->where(' 1 and to_hide=1 ')->limit($this->limit)->field('id as id,bank_name as value')->select(); 
		$rs		= array_merge($array,$data); 
		$this->result	=	$rs;
	}
	
	
	///支出类型名称 公司
	public function payClassName($pay_type = 0){
		if ($pay_type > 0) {
			$this->where	.= ' and pay_type=' . $pay_type;
		}
		$this->result	= M('PayClass')->where($this->getWhere('pay_class_name').' and relation_object=1')->order('pay_class_name desc')->limit($this->limit)->field('id as id,pay_class_name as value')->select();
	}
	///支出类型 公司
	public function OutLay(){
		$this->payClassName(1);
	}
	///收入类型 公司
	public function IncomeLay(){
		$this->payClassName(2);
	}
	
	///往来单位款项类型名称
	public function fundsClassName(){
		$this->result	= M('PayClass')->where($this->getWhere('pay_class_name'))->order('pay_class_name desc')->limit($this->limit)->field('id as id,pay_class_name as value')->select();
	}
	
	/**
	 * 卖家应收款关联单号
	 */
	public function fundsRelationDocNo(){
		switch ($_GET['relation_type']) {
			case 1://发货单号
				$this->instockNo();
				break;
			case 2://处理单号
				$this->saleDealNo();
				break;
			case 3://退货单号
				$this->returnSaleOrderNo();
				break;
			case 4://产品id
				$this->productId();
				break;
		}
	}

	///用户名称
	public function userName(){
		$this->result	= M('User')->where($this->getWhere('user_name'))->order('user_name desc')->limit($this->limit)->field('id as id,user_name as value')->select();
	}
	/// 菜单名称
	public function node(){
		$this->result	= M('Node')->where($this->getWhere('title'))->limit($this->limit)->field('id as id,title as value')->select();
	}
	///产品属性名称
	public function propertiesName(){
		$table	=	'properties';
		$field	=	'properties_name';
		$where	=	$this->getWhere($field);
		$this->getList($table,$field,$where); 
	}
	///产品属性编号
	public function propertiesNo(){
		$table	=	'properties';
		$field	=	'properties_no';
		$where	=	$this->getWhere($field);
		$this->getList($table,$field,$where); 
	}
	///产品属性值名称
	public function pvName(){
		$table	=	'properties_value';
		$field	=	'pv_name';
		$where	=	$this->getWhere($field);
		$this->getList($table,$field,$where); 
	}
	
///	public function pv(){
///		$table	=	'properties_value';
///		$field	=	'pv_name';
///		$where	=	$this->getWhere($field); 
///		$this->getList($table,$field,$where); 
///	}
	///产品属性值编号
	public function pvNo(){
		$table	=	'properties_value';
		$field	=	'pv_no';
		$where	=	$this->getWhere($field); 
		$this->getList($table,$field,$where); 
	}
	///产品编号
	public function barcode(){
		$table	=	'barcode';
		$field	=	'barcode_no';
		$where	=	$this->getWhere($field); 
		$this->getList($table,$field,$where); 
	} 
	///产品ID
	public function productId(){
		$table	=	'product';
		$field	=	'id';
		$where	=	$this->getWhere($field); 
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->getList($table,$field,$where,'id','productId'); 
	} 	
	///产品ID
	public function productId2(){
		$table	=	'product';
		$field	=	'id';
		$where	=	$this->getWhere($field); 
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->getList($table,$field,$where, 'product_no'); 
	} 	
        ///获取不可售卖的产品ID
        public function noSoldProductId(){                        
		$field	=	'product_id';
		$where	=	$this->getWhere($field); 
               
                $userInfo	=	getUser(); 
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$is_sold    = M('warehouse')->where('id='.$userInfo['company_id'])->getField('is_return_sold');
			if($is_sold != C('NO_RETURN_SOLD')){
                $warehouse_id   = M('warehouse')->where('is_use=1 and to_hide=1 and relation_warehouse_id='.$userInfo['company_id'].' and is_return_sold='.C('NO_RETURN_SOLD'))->getField('id',TRUE);
            }else{
                $warehouse_id   = $userInfo['company_id'];
			}
		}else{
            $warehouse_id   = M('warehouse')->where('is_return_sold='.C('NO_RETURN_SOLD').' and to_hide=1 and is_use=1 ')->getField('id',true);
        }
        $where          .= ' and warehouse_id in ('.implode(',', $warehouse_id).') and quantity>0';
        $this->result   = M('storage')->where($where)->limit($this->limit)->order($field . ' asc')->field('product_id as id,' . $field . ' as value')->group($field)->select();		                                        
	} 	
	///产品编号
	public function productNo(){
		$table	=	'product';
		$field	=	'product_no';
		$where	=	$this->getWhere($field); 
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->getList($table,$field,$where); 
	} 
    ///产品条形码
	public function productBarcode(){
		$table	=	'product';
		$field	=	'custom_barcode';
		$where	=	$this->getWhere($field); 
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->getList($table,$field,$where); 
	}
	///产品名称 
	public function productName(){
		$field	=	'product_name';
		$where	=	$this->getWhere($field); 
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('Product')->where($where)->order('product_no desc ')->limit($this->limit)->field('id as id ,product_name as value')->group('product_name')->select();
	}
    ///SKU关键词
    //added  yyh 20140911
    public function skuKeywords(){
        $table	=	'sku_keywords';
		$field	=	'product_no';
		$where	=	$this->getWhere($field); 
		$this->getList($table,$field,$where); 
    }    
	///客户编号 
	public function allCompany(){
		$where		  = $this->getWhere('comp_name').' and comp_type in (1,2)';
		$this->result = M('Company')->where($where)->limit($this->limit)->field('id as id,comp_name as value')->select();
	}
	///卖家ID
	public function factoryId(){
		$table	=	'company';
		$field	=	'id';
		$where	=	$this->getWhere($field); 
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			//$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->getList($table,$field,$where); 
	}

	///卖家编号
	public function factoryNo(){
		$where		= $this->getWhere('comp_no').' and comp_type=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and id='.intval(getUser('company_id'));
		}
		$this->result = M('Company')->where($where)->limit($this->limit)->field('id as id ,comp_no as value')->select();
	}
	///卖家名称 
	public function factoryName(){
		$where		  = $this->getWhere('comp_name').' and comp_type=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and id='.intval(getUser('company_id'));
		}
		$this->result = M('Company')->where($where)->limit($this->limit)->field('id as id ,comp_name as value')->group('comp_name')->select();
	}
	///卖家邮箱 
	public function factoryEmail(){
		$where		  = $this->getWhere('comp_name|email') .' and comp_type=1 and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and id='.intval(getUser('company_id'));
		}
		$this->result = M('Company')->where($where)->limit($this->limit)->field('id as id ,concat(comp_name,",",email) as value')->select();
	}	
	
	///卖家邮箱 
	public function factoryNameEmail(){
		$where		  = $this->getWhere('comp_name|email') .' and comp_type=1 and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and id='.intval(getUser('company_id'));
		}
		$this->result = M('Company')->where($where)->limit($this->limit)->field('email as id ,concat(comp_name,",",email) as value')->select();
	}
	
	///卖家联系电话
	public function factoryMobile(){
		$where		  = $this->getWhere('mobile').' and comp_type=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and id='.intval(getUser('company_id'));
		}
		$this->result = M('Company')->where($where)->limit($this->limit)->field('id as id ,mobile as value')->select();
	}		
	///物流公司编号
	public function logisticsNo(){
		$where			= $this->getWhere('comp_no').' and comp_type=2';
		$this->result	= M('Company')->where($where)->limit($this->limit)->field('id as id,comp_no as value')->select();
	}
	///物流公司名称
	public function logisticsName(){
		$where			= $this->getWhere('comp_name').' and comp_type=2';
		$this->result	= M('Company')->where($where)->limit($this->limit)->field('id as id,comp_name as value')->select();
	}
	///快递公司名称
	public function expressName(){
		$where			= $this->getWhere('comp_name').' and comp_type=3';
		$this->result	= M('Company')->where($where.' and to_hide=1')->limit($this->limit)->field('id as id,comp_name as value')->select();
	}
	///其他往来单位编号
	public function otherCompanyNo(){
		$where			= $this->getWhere('comp_no').' and comp_type=3';
		$this->result	= M('Company')->where($where)->limit($this->limit)->field('id as id,comp_no as value')->select();
	}
	///其他往来单位名称
	public function otherCompanyName(){
		$where			= $this->getWhere('comp_name').' and comp_type=3';
		$this->result	= M('Company')->where($where)->limit($this->limit)->field('id as id,comp_name as value')->select();
	}
	///派送方式名称
	public function shipping(){
		$where			= $this->getWhere('express_name');
		$this->result	= M('Express')->where($where)->limit($this->limit)->field('id as id,express_name as value')->select();
	}	
	
	///根据问题订单条件获取派送方式列表
	public function questionOrderShipping(){
		$where			= $this->getWhere('express_name');
		$this->result	= M('Express')->alias('e')->join('LEFT JOIN question_order o ON o.express_id=e.id')->where($where)->limit($this->limit)->field('DISTINCT e.id as id,express_name as value')->select();
	}	
	
	///派送方式名称-开启
	public function shippingUse(){
		$where			= $this->getWhere('express_name').' and status=1';
		$this->result	= M('Express')->where($where)->limit($this->limit)->field('id as id,express_name as value')->select();
	}
    ///快递公司名称—开启
	public function companyUse(){
		$where			= $this->getWhere('express_name');
        if (getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')) {
			$where .=' and e.warehouse_id='.intval(getUser('company_id'));
		}
		$this->result	= M('Company')->join('as c left join express as e on e.company_id=c.id')->where($where .' and comp_type=3')->field('c.id as id,c.comp_name as value')->group('id')->select();
	}
	///派送方式编号
	public function shippingNo(){
		$where			= $this->getWhere('express_no');
		$this->result	= M('Express')->where($where)->limit($this->limit)->field('id as id,express_no as value')->order('express_no asc')->select();
	}	
	
	///处理费用名称
	public function processFee(){
		$where			= $this->getWhere('process_fee_name');
		$this->result	= M('ProcessFee')->where($where)->limit($this->limit)->field('id as id,process_fee_name as value')->select();
	}	

	///处理费用编号
	public function processFeeNo(){
		$where			= $this->getWhere('process_fee_no');
		$this->result	= M('ProcessFee')->where($where)->limit($this->limit)->field('id as id,process_fee_no as value')->order('process_fee_no asc')->select();
	}		

	///退货服务编号
	public function returnServiceNo(){
		$where			= $this->getWhere('return_service_no');
		$this->result	= M('return_service')->where($where)->limit($this->limit)->field('id as id,return_service_no as value')->order('return_service_no asc')->select();
	}	
	///退货服务名称
	public function returnServiceName(){
		$where			= $this->getWhere('return_service_name');
		$this->result	= M('return_service')->where($where)->limit($this->limit)->field('id as id,return_service_name as value')->select();
	}	
	
	/**
	 * 公用函数返回列表信息并且json化
	 *
	 * @param string $table
	 * @param string $field
	 * @return array
	 */
	public function getList($table,$field,$where, $id='id',$type){
		$order = 'desc';
		if($type=='productId'){
			$order = 'asc';
		}
    	$this->result = M($table)->where($where)->order($field.' '.$order)->limit('0,20')->field($id . ' as id ,'.$field.' as value')->group($field)->select();  
	}
	
	
	/**
	 * 以下所有方法为基本信息外调用，必须增加to_hide=1状态
	 *
	 */ 
	
	/// 币种
	public function currency(){
    	$this->result = M('Currency')->where($this->getWhere('currency_no').' and to_hide=1')->order('currency_no desc')->limit($this->limit)->field('id as id ,currency_no as value')->select();
	} 
	/// 仓库角色
	public function warehouseRole(){
		$where = $this->getWhere('role_name').' and to_hide=1 and role_type=3';
    	$this->result = M('Role')->where($where)->order('role_name desc')->limit($this->limit)->field('id as id ,role_name as value')->select();
	}
	/// 合作伙伴角色
	public function partnerRole(){
		$where = $this->getWhere('role_name').' and to_hide=1 and role_type=4';
    	$this->result = M('Role')->where($where)->order('role_name desc')->limit($this->limit)->field('id as id ,role_name as value')->select();
	}

	/// 卖家角色
	public function sellerRole(){
		$where = $this->getWhere('role_name').' and to_hide=1 and role_type=2';
    	$this->result = M('Role')->where($where)->order('role_name desc')->limit($this->limit)->field('id as id ,role_name as value')->select();
	}

	///公司角色
	public function companyRole(){
		$where = $this->getWhere('role_name').' and to_hide=1 and role_type not in(2,3,4)';
        if(!$_SESSION[C('ADMIN_AUTH_KEY')]){
            $where .= ' and is_admin=0';
        }
    	$this->result = M('Role')->where($where)->order('role_name desc')->limit($this->limit)->field('id as id ,role_name as value')->select();
	}	

	/// 所有角色
	public function role(){
    	$this->result = M('Role')->where($this->getWhere('role_name').' and to_hide=1')->order('role_name desc')->limit($this->limit)->field('id as id ,role_name as value')->select();
	}
	
	/// 用户--卖家
	public function userSeller(){
		$where		  = $this->getWhere('comp_name').' and comp_type=1 and to_hide=1';
    	if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and company_id='.intval(getUser('company_id'));
		}
		$this->result = M('company')->where($where)->order('comp_name desc')->limit($this->limit)->field('id as id ,comp_name as value')->select();
	}

	/// 用户--卖家员工姓名
	public function userSellerStaff(){
		$where		  = $this->getWhere('real_name').' and real_name!="" and super_admin=0 and user_type=3 and to_hide=1';
    	if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and company_id='.intval(getUser('company_id'));
		}
    	$this->result = M('User')->where($where)->order('user_name desc')->limit($this->limit)->field('id as id ,real_name as value')->select();
	}
	/// 用户--卖家员工姓名
	public function userSellerStaffEmail(){
		$where		  = $this->getWhere('user_name').' and super_admin=0 and user_type=3 and to_hide=1';
    	if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and company_id='.intval(getUser('company_id'));
		}
		$this->result = M('User')->where($where)->order('user_name asc')->limit($this->limit)->field('id as id ,user_name as value')->select();
	}

	/// 用户
	public function user(){
    	$this->result = M('User')->where($this->getWhere('user_name').' and super_admin=0 and to_hide=1')->order('user_name desc')->limit($this->limit)->field('id as id ,user_name as value')->select();
	}
	/// 颜色名称
	public function epass(){
		$this->result = M('Epass')->where($this->getWhere('epass_serial').' and to_hide=1')->order('epass_serial')->limit($this->limit)->field('id as id,epass_serial as value')->select();
	}
	///员工名称
	public function employee(){
		$this->result	= M('Employee')->where($this->getWhere('employee_name').' and to_hide=1')->order('employee_name desc')->limit($this->limit)->field('id as id,employee_name as value')->select();
	}
	///城市名称
	public function city(){
		$where			= $this->getWhere('district_name').' and parent_id>0 and to_hide=1';
		$this->result	= M('District')->where($where)->order('district_name')->limit($this->limit)->field('id as id,district_name as value')->select();
	}
	
	///国家名称
	public function country(){
		$where			= $this->getWhere('abbr_district_name|district_name').' and parent_id=0 and to_hide=1';
		$this->result	= M('District')->where($where)->order('district_name')->limit($this->limit)->field('id as id,CONCAT(abbr_district_name,"—",district_name) as value')->select();
	}
	
	///公司名称
	public function company(){
		$where			= $this->getWhere('basic_name').' and to_hide=1';
		$this->result	= M('Basic')->where($where)->limit($this->limit)->field('id as id,basic_name as value')->select();
	}
	
	/// 产品属性
	public function properties(){
		$table	=	'properties';
		$field	=	'properties_name';
		$where	=	$this->getWhere($field).' and to_hide=1 ';  
		$this->getList($table,$field,$where); 
	}
	/// 产品
	public function product(){
		$where		  = $this->getWhere('product_no').' and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('Product')->where($where)->order('product_no desc')->limit($this->limit)->field('id as id ,product_no as value')->group('product_no desc')->select(); 
	}
	/// 产品可销售库存不为0
	public function productSale(){
		$where		  	= $this->getWhere('product_no').' and a.quantity>0 and b.to_hide=1'; 
		$info 			= M('sale_storage')->join(' as a left join product as b on a.product_id =b.id ')->group('b.product_no')->where($where)->order('b.product_no desc')->limit($this->limit)->field('a.product_id as id,b.product_no as value')->select();  
///		echo M('sale_storage')->getLastSql();
		$this->result	=	$info;
	}
	/// 产品实际库存不为0
	public function productReal(){
		$where		  	= $this->getWhere('product_no').' and a.quantity>0 and b.to_hide=1'; 
		$info 			= M('Storage')->join(' as a left join product as b on a.product_id =b.id ')->order('b.product_no desc')->group('b.product_no')->where($where)->limit($this->limit)->field('a.product_id as id,b.product_no as value')->select();  
///		echo M('sale_storage')->getLastSql();
		$this->result	=	$info;
	}
	/// 已订货未装柜完成产品
	public function orderProduct(){
		$where		  = $this->getWhere('product_no').' and detail_state<3 and product.id IS NOT NULL ';
		$this->result = M('OrderDetails')->join('product on(order_details.product_id=product.id)')->order('product.product_no desc')->where($where)->limit($this->limit)->field('product.id as id ,product.product_no as value')->group('product.product_no')->select();
	}

	///卖家名称 
	public function factory(){
		$where		  = $this->getWhere('comp_name|email') .' and comp_type=1 and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and id='.intval(getUser('company_id'));
		}
		$this->result = M('Company')->where($where)->order('email desc')->limit($this->limit)->field('id as id ,concat(comp_name,",",email) as value')->select();
	}
	///厂家名称--合作伙伴(物流公司)
	public function client(){
		$where		  = $this->getWhere('comp_name').' and comp_type=2 and to_hide=1';
		if (getUser('role_type')==4) {
			$where .=' and id='.intval(getUser('company_id'));
		}
		$this->result = M('Company')->where($where)->order('comp_name desc')->limit($this->limit)->field('id as id ,comp_name as value')->select();
	}
	///物流公司
	public function logistics(){
		$where			= $this->getWhere('comp_name').' and comp_type=2 and to_hide=1';
		$this->result	= M('Company')->where($where)->order('comp_name desc')->limit($this->limit)->field('id as id,comp_name as value')->select();
	}
	/// 订单号
	public function orderNo(){
		$where		  = $this->getWhere('order_no', false);
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('Orders')->where($where)->limit($this->limit)->order('order_no desc')->field('id as id ,order_no as value')->select();
	}
	/// 装柜单号
	public function loadContainerNo(){
		$where		  = $this->getWhere('load_container_no');
		$this->result = M('LoadContainer')->where($where)->limit($this->limit)->order('load_container_no desc')->field('id as id ,load_container_no as value')->select();
	} 
	
	/// 集装箱号
	public function containerNo(){
		$where		  = $this->getWhere('container_no');
		$this->result = M('LoadContainer')->where($where)->limit($this->limit)->order('container_no desc')->field('id as id,container_no as value')->group('container_no')->select();
	}
	
	/// 销售 订单单号
	public function saleOrderNo(){
		$where		  = $this->getWhere('order_no', false).' ';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('sale_order')->where($where)->limit($this->limit)->order('order_no desc')->field('id as id ,order_no as value')->group('order_no')->select();
	}
    public function returnOrderNo(){
       $where		  = $this->getWhere('order_no', false).' ';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('return_sale_order')->where($where)->limit($this->limit)->order('order_no desc')->field('id as id ,order_no as value')->group('order_no')->select();
	}
	

        /// 订单卖家
	public function saleOrderFactory($default_where = ''){
		$where		  = $this->getWhere('comp_name|email') . $default_where;
		if (getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and o.warehouser_id='.intval(getUser('company_id'));
		}
		$this->result = M('sale_order')->join('o left join company c on c.id=o.factory_id')->where($where)->limit($this->limit)->field('factory_id as id ,concat(comp_name,",",email) as value')->group('factory_id')->select();
	}
	
	/// 订单买家
	public function saleOrderClient($default_where = ''){
		$where		  = $this->getWhere('comp_name') . $default_where;
		$user_info	= getUser();
		if ($user_info['role_type']==C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and o.warehouser_id='.intval($user_info['company_id']);
		} elseif ($user_info['role_type']==C('SELLER_ROLE_TYPE')) {
			$where .= ' and o.factory_id='.intval($user_info['company_id']);
		}
		$this->result = M('sale_order')->join('o left join client c on c.id=o.client_id')->where($where)->limit($this->limit)->field('client_id as id ,comp_name as value')->group('client_id')->select();
	}	
	
	
	/// 待处理订单卖家
	public function saleOrderPendingFactory(){
		$this->saleOrderFactory(' and sale_order_state=' . C('SALE_ORDER_STATE_PENDING'));
	}
	
	/// 待处理订单买家
	public function saleOrderPendingClient(){
		$this->saleOrderClient(' and sale_order_state=' . C('SALE_ORDER_STATE_PENDING'));
	}		
	
	/// 销售 处理单号
	public function saleDealNoExpress(){
		$where		  = $this->getWhere('sale_order_no', false).' ';
        $where      = str_replace(' warehouse_id=',' a.warehouse_id=',$where);
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}elseif ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and a.warehouse_id='.intval($userInfo['company_id']);
		}			
		$this->result = M('sale_order')->join(' a left join express as b on a.express_id=b.id')->where($where)->limit($this->limit)->order('sale_order_no desc')->field('a.id as id ,sale_order_no as value')->group('sale_order_no')->select();
	}
	/// 销售 处理单号
	public function saleDealNo(){
		$where		  = $this->getWhere('sale_order_no', false);
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}elseif ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}			
		$this->result = M('sale_order')->where($where)->limit($this->limit)->order('sale_order_no desc')->field('id as id ,sale_order_no as value')->group('sale_order_no')->select();
	}
	
	/// 已发货销售 处理单号
	public function saleDealNoShipped(){
		$where          = $this->getWhere('sale_order_no', false).' and sale_order_state in ('.C('SHIPPED').')';
        $userInfo       = getUser();
		if ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval($userInfo['company_id']);
		}elseif ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}	
		$this->result = M('sale_order')->where($where)->limit($this->limit)->order('sale_order_no desc')->field('id as id ,sale_order_no as value')->group('sale_order_no')->select();
	}
	/// 发货
	public function deliveryNo(){
		$where		  = $this->getWhere('delivery_no').'  ';
		$this->result = M('delivery')->where($where)->limit($this->limit)->order('delivery_no desc')->field('id as id ,delivery_no as value')->select();
	}
	///入库单号
	public function instockNo(){
		$where		= $this->getWhere('instock_no');
		$userInfo	=	getUser(); 
		if ($userInfo['role_type'] == C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval($userInfo['company_id']);
		} elseif ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}		
		$this->result= M('Instock')->where($where)->limit($this->limit)->order('instock_no desc')->field('id as id,instock_no as value')->select();
	}
	///仓库
	public function warehouse(){
		$where		  = $this->getWhere('w_name').' and to_hide=1 and is_use=1';
		$this->result = M('Warehouse')->where($where)->limit($this->limit)->field('id as id,w_name as value')->select();
	}
	
	///箱号ID
	public function boxId(){
		$where		    = $this->getWhere('id');
		$this->result	= M('InstockBox')->where($where)->limit($this->limit)->field('id as id,id as value')->select();
	} 
	
	///发货箱号
	public function instockBoxNo(){
		$where		    = $this->getWhere('box_no');
		$this->result	= M('InstockBox')->join('detail left join instock main on main.id=detail.instock_id')->where($where)->limit($this->limit)->field('detail.id as id,box_no as value')->group('box_no')->select();
	} 

	///发货箱号ID
	public function instockBoxId(){
		$where		    = $this->getWhere('box_id');
		$this->result	= M('InstockBox')->join('detail left join instock main on main.id=detail.instock_id')->where($where)->limit($this->limit)->field('box_no as id,detail.id as value')->select();
	} 

	///发货产品箱号ID
	public function instockDetailBoxId(){
		$where		    = $this->getWhere('box_id');
		$this->result	= M('InstockDetail')->join('detail left join instock main on main.id=detail.instock_id left join instock_box box on box.id=detail.box_id')->where($where)->limit($this->limit)->field('box_no as id,box_id as value')->group('box_id')->order('box_id desc')->select();
	} 
	
	///发货产品号
	public function instockProductNo(){
		$where		 = $this->getWhere('product_no');
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}		
		$this->result= M('InstockDetail')->join('detail left join product p on detail.product_id=p.id')->where($where)->limit($this->limit)->order('product_no desc')->field('product_id as id,product_no as value')->group('product_no')->select();
	}	
	
	///发货产品ID
	public function instockProductId(){
		$where		 = $this->getWhere('product_id');
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}		
		$this->result= M('InstockDetail')->join('detail left join product p on detail.product_id=p.id')->where($where)->limit($this->limit)->order('product_no desc')->group('product_id')->field('product_no as id,product_id as value')->order('product_id desc')->select();
	}		
	
	///退货单号
	public function returnSaleOrderNo(){
		$where			= $this->getWhere('return_sale_order_no');
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}elseif ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}
		$this->result	= M('ReturnSaleOrder')->join('left join return_sale_order_detail on return_sale_order.id=return_sale_order_detail.return_sale_order_id ')->where($where)->limit($this->limit)->group('return_sale_order.id')->order('return_sale_order_no desc')->field('return_sale_order.id as id,return_sale_order.return_sale_order_no as value')->select();
	}
	/// 调整单号
	public function adjustNo(){
		$where			= $this->getWhere('adjust_no');
		$this->result	= M('Adjust')->where($where)->limit($this->limit)->order('adjust_no desc')->field('id as id,adjust_no as value')->select();
	}
	/// 入库调整单号
	public function instockAdjustNo(){
		$where			= $this->getWhere('adjust_no');
		///仓库角色
		if (getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')) {
			$where .=  ' and warehouse_id='.getUser('company_id');
		} 
		$this->result	= M('InstockAdjust')->alias('a')->join('LEFT JOIN instock b ON a.instock_id=b.id')->where($where)->limit($this->limit)->order('adjust_no desc')->field('a.id as id,adjust_no as value')->select();
	}
	/// 调拨单号
	public function transferNo(){
		$where			= $this->getWhere('transfer_no');
		$this->result	= M('Transfer')->where($where)->limit($this->limit)->order('transfer_no desc')->field('id as id,transfer_no as value')->select();
	}
	/// 期初库存单号
	public function initStorageNo(){
		$where			= $this->getWhere('init_storage_no');
		$this->result	= M('InitStorage')->where($where)->limit($this->limit)->order('init_storage_no desc')->field('id as id,init_storage_no as value')->select();
	}
	///退货产品
	public function returnProduct(){
		$where		  = $this->getWhere('product_no');
		$this->result = M('SaleOrderDetail')->join('product on(sale_order_detail.product_id=product.id)')->join('sale_order on (sale_order.id=sale_order_detail.sale_order_id)')->where($where)->limit($this->limit)->field('product.id as id ,product.product_no as value')->group('product.id')->select();
	}
	///根据产品获得订货单
	public function orderNoByProduct(){
		$this->result	= M('Orders')->join('order_details on orders.id=order_details.orders_id')->where($this->getWhere('order_no', false))->field('orders.id,orders.order_no as value')->group('id')->select();
	}
	/// 盘点单号
	public function stockTakeNo(){
		$where		  = $this->getWhere('stocktake_no');
		$this->result = M('Stocktake')->where($where)->limit($this->limit)->order('stocktake_no desc')->field('id as id ,stocktake_no as value')->select();
	}
	/// 盈亏单号
	public function profitandlossNo(){
		$where		  = $this->getWhere('profitandloss_no');
		$this->result = M('Profitandloss')->where($where)->limit($this->limit)->order('profitandloss_no desc')->field('id as id ,profitandloss_no as value')->select();
	}
	/// 单据号
	public function flowNo(){
		$where		  = $this->getWhere('object_no');
		$this->result = M('EmailList')->where($where)->limit($this->limit)->order('object_no desc')->field('object_id as id ,object_no as value')->group('object_no')->select();
	}

	///产品颜色
	public function productColor(){
		$where		  = $this->getWhere('color_name');
		$this->result = M('ProductColor')->join('color on(product_color.color_id=color.id)')->where($where)->limit($this->limit)->field('color.id as id ,color.color_name as value')->select();
	}
	///产品尺码
	public function productSize(){
		$where		  = $this->getWhere('color_name');
		$this->result = M('ProductSize')->join('size on(product_size.size_id=size.id)')->where($where)->limit($this->limit)->field('size.id as id ,size.size_name as value')->select();
	}
	/*******************************仓储新增************************************/
	///包装名称
	public function packageName(){
		$this->result = M('Package')->where($this->getWhere('package_name'))->order('package_name asc')->limit($this->limit)->field('id as id,package_name as value')->select();
	}

	public function packageNameUse(){
		$where		  = $this->getWhere('package_name').' and to_hide=1';
		$this->result = M('Package')->where($where)->order('package_name asc')->limit($this->limit)->field('id as id,package_name as value')->select();
	}

	///Ebay主要销售站点
	public function ebaySiteId(){
		$SiteDetails = S('SiteDetails');
		if(empty($SiteDetails)){
			import("ORG.Util.EbayToken"); 
			$EbayToken   = new ModelEbayToken('dev',77);
			$SiteDetails = $EbayToken->getSiteDetail();
		}
		if(is_array($SiteDetails)&&$SiteDetails){
			if($this->term){
				foreach($SiteDetails as $key=>$val){
					if(stripos($val, $this->term)!==false){
						$this->result[] = array('id'=>$key,'value'=>$val); 
					}
				}
			}else{
				foreach($SiteDetails as $key=>$val){
					$this->result[] = array('id'=>$key,'value'=>$val); 
				}
			}
		}
	}
	///Amazon主要销售站点
	public function amazonSiteId(){
		$SiteDetails = C('AMAZON_COUNTRY');
		if(is_array($SiteDetails)&&$SiteDetails){
			if($this->term){
				foreach($SiteDetails as $key=>$val){
					if(stripos($val, $this->term)!==false){
						$this->result[] = array('id'=>$val['MarketplaceID'],'value'=>$key); 
					}
				}
			}else{
				foreach($SiteDetails as $key=>$val){
					$this->result[] = array('id'=>$val['MarketplaceID'],'value'=>$key); 
				}
			}
		}
	}

	///Ebay账号
	public function ebayUser(){
		$where = $this->getWhere('user_id').' and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('ebay_site')->where($where)->order('user_id asc')->limit($this->limit)->field('id as id,user_id as value')->select();
	}

	///Ebay账号\站点
	public function ebaySite(){
		$where = $this->getWhere('user_id').' and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('ebay_site')->where($where)->order('user_id asc')->limit($this->limit)->field('site_id as id,user_id as value')->select();
	}

	///Amazon账号
	public function amazonUser(){
		$where = $this->getWhere('user_id').' and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('amazon_site')->where($where)->order('user_id asc')->limit($this->limit)->field('id as id,user_id as value')->select();
	}
	///买家名称
	public function buyer(){
		$where		= $this->getWhere('comp_name', false).' and to_hide=1';
		if(getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and factory_id ='.intval(getUser('company_id'));
		} 
		$field      = 'id as id,if(email="", comp_name, CONCAT(comp_name,"—",email)) as value';
		$this->result = M('Client')->where($where)->order('comp_name desc')->limit($this->limit)->field($field)->select();
	}
	///收货人
	public function consignee(){
		$where		  = $this->getWhere('consignee', false).' and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('Client')->where($where)->order('consignee desc')->limit($this->limit)->field('id as id ,consignee as value')->group('consignee')->select();
	}
	///追踪单号
	public function trackNo(){
		$where		  = $this->getWhere('track_no', false).' and track_no!=""';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('sale_order')->where($where)->order('track_no desc')->limit($this->limit)->field('id as id ,track_no as value')->group('track_no')->select();
	}
	public function trackInstockNo(){
		$where		  = $this->getWhere('track_no').' and track_no!=""';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .=' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('instock')->where($where)->order('track_no desc')->limit($this->limit)->field('id as id ,track_no as value')->group('track_no')->select();
	}

	public function addUserRealName(){
		$where		  = $this->getWhere('real_name').' and real_name!=""  and super_admin=0 and to_hide=1';  
		$this->result = M('User')->where($where)->order('real_name desc')->limit($this->limit)->field('id as id,real_name as value')->group('real_name')->select();
	}
	
	public function addUserRealNameCommon(){
		$where		  = $this->getWhere('real_name').' and real_name!=""  and to_hide=1';  
		$this->result = M('User')->where($where)->order('real_name desc')->limit($this->limit)->field('id as id,real_name as value')->select();
	}
    public function BelongsaddUserRealName() {
        $where = $this->getWhere('real_name') . ' and real_name!="" and company_id='.  getUser('company_id');
        $this->result = M('User')->where($where)->order('real_name desc')->limit($this->limit)->field('id as id,real_name as value')->select();
    }
    //退货不可再销售仓库
    public function noReturnSoldWarehouse(){
        $where			= $this->getWhere('w_name').' and is_use=1 and to_hide=1 and is_return_sold='.C('NO_RETURN_SOLD');        
        $userInfo       = getUser();
        if($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')){        
            $is_return_sold = M('warehouse')->where('id='.  $userInfo['company_id'])->getField('is_return_sold');
            if($is_return_sold!=C('NO_RETURN_SOLD')){
                $where  .= ' and relation_warehouse_id='.$userInfo['company_id'];
            }else{
                $where  .= ' and warehouse_id='.$userInfo['company_id'];
            }
        }
		$this->result	= M('Warehouse')->where($where)->order('w_name desc')->limit($this->limit)->field('id as id,w_name as value')->select();
    }
    //关联对应仓库的
    public function relationReturnWarehouse(){
        $where			= $this->getWhere('w_name').' and is_use=1 and to_hide=1 and is_return_sold='.C('NO_RETURN_SOLD');
        $where          .= getWarehouseWhere('', 'relation_warehouse_id');
		$this->result	= M('Warehouse')->where($where)->order('w_name desc')->limit($this->limit)->field('id as id,w_name as value')->select();
    }

    //
	/*******************************仓储新增************************************/
	
	/// 属性名称+条形码(增加条形码的时候使用,设置规则)
	public function addBarcode() {
		///$data = M('Properties')->where($this->extend.$this->default_where)->findAllNotLtd(); 
///		$this->result['country']		= L('country_no');
///		$this->result['size_no']		= L('size_no');
///		$this->result['color_no']		= L('color_no');
///		$this->result['class_no']		= L('class_no');
///		$this->result['product_no']		= L('product_no');
///		$this->result['comp_no']		= L('fac_no');
///		$this->result['serial_no']		= L('water_no');
		$this->result	= array(
							array(
								'id'=>'country',
								'value'=> '国家编号'
							),
							array(
								'id'=>'size_no',
								'value'=> '尺码编号'
							),
							array(
								'id'=>'color_no',
								'value'=> '颜色编号'
							),
							array(
								'id'=>'class_no',
								'value'=> '类别编号'
							),
							array(
								'id'=>'product_no',
								'value'=> '产品编号'
							),
							array(
								'id'=>'comp_no',
								'value'=> '公司'
							),
							array(
								'id'=>'serial_no',
								'value'=> '流水号'
							)
							
		);
	}
	/// 入库导入发货单号
	public function instockImportInstockNo(){
		$where		  = $this->getWhere('instock_no');
		$where .= ' AND file_type=1';
		///仓库角色
		if (getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')) {
			$where .=  ' and warehouse_id='.getUser('company_id');
		} 
		$this->result= M('FileRelationDetail')->alias('a')->join("LEFT JOIN instock b ON b.id=a.relation_id")->where($where)->limit($this->limit)->order('b.instock_no desc')->field('b.id as id,b.instock_no as value')->select();
	}
	
	/// 入库单号
	public function instockImportNo(){
		$this->fileListNo(array_search('InstockImport',C('CFG_FILE_TYPE')));
	}	
	
	/// 拣货导出单号
	public function pickingNo(){
		$this->fileListNo(array_search('Picking',C('CFG_FILE_TYPE')));
	}		
	
	/// 拣货导出单号
	public function unImportPickingNo(){
		$this->where	.= ' and relation_id=0 ';
		$this->fileListNo(array_search('Picking',C('CFG_FILE_TYPE')));
	}		
	
	/// 拣货导入单号
	public function pickingImportNo(){
		$this->fileListNo(array_search('PickingImport',C('CFG_FILE_TYPE')));
	}	
	
	/// 单号
	public function fileListNo($file_type=0){
		$where		  = $this->getWhere('file_list_no');
		if ($file_type > 0) {
			$where .= ' and file_type=' . (int)$file_type;
		}
		$userInfo	=	getUser(); 
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}			
		$this->result = M('FileList')->where($where)->limit($this->limit)->order('file_list_no desc')->field('id as id,file_list_no as value')->group('file_list_no')->select();
	}	
	
	/// 入库导入库位列表
	public function instockImportBarcode(){
		$this->fileDetailField('barcode_no', array_search('InstockImport',C('CFG_FILE_TYPE')));
	}	
	
	/// 入库导入产品ID
	public function instockImportProduct(){
		$this->fileDetailField('product_id', array_search('InstockImport',C('CFG_FILE_TYPE')));
	}		
	
	/// 入库导入产品ID
	public function instockImportProductNo(){
		$this->fileDetailField('product_no', array_search('InstockImport',C('CFG_FILE_TYPE')));
	}	
	
	/// 拣货导入库位列表
	public function pickingImportBarcode(){
		$this->fileDetailField('barcode_no', array_search('PickingImport',C('CFG_FILE_TYPE')));
	}	
	
	/// 拣货导入产品ID
	public function pickingImportProduct(){
		$this->fileDetailField('product_id', array_search('PickingImport',C('CFG_FILE_TYPE')));
	}		
	
	/// 拣货导入产品ID
	public function pickingImportProductNo(){
		$this->fileDetailField('product_no', array_search('PickingImport',C('CFG_FILE_TYPE')));
	}		
	
	public function fileDetailField($field, $file_type = 0, $id_field = 'id'){
		$field		= 'detail.' . $field;
		$id_field	= 'detail.' . $id_field;
		$where		  = $this->getWhere($field);
		if ($file_type > 0) {
			$where .= ' and main.file_type=' . (int)$file_type;
		}
		$userInfo	=	getUser(); 
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and main.warehouse_id='.intval($userInfo['company_id']);
		}			
		$this->result = M('FileDetail')->join('detail left join file_list main on main.id=detail.file_id')->where($where)->limit($this->limit)->order($field . ' desc')->field($id_field . ' as id,' . $field . ' as value')->group($field)->select();		
	}
	
	public function locationNo(){
		$field	= 'barcode_no';
		$where	= $this->getWhere($field);
		
		$userInfo	=	getUser(); 
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}
		$this->result = M('Location')->where($where)->limit($this->limit)->order($field . ' desc')->field('id as id,' . $field . ' as value')->group($field)->select();		
	}
    //相关仓库和退货不可再销售仓库
    public function returnLocationNo(){
        $field              = 'barcode_no';
        $userInfo           = getUser();
        //获取主仓库ID
        $where      = $this->getWhere($field);
        preg_match('/([0-9]*)_warehouse_id/', $where, $matches);
        $relation_warehouse_id  = (int)$matches[1];
        
        //获取关联子仓库ID
        $no_sold_warehouse_id   = M('warehouse')->where('is_use=1 and to_hide=1 and is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id='.$relation_warehouse_id)->getField('id',TRUE);
        $no_sold_warehouse_id[] = 0;
        $where      = str_replace('_warehouse_id', ','.implode(',', $no_sold_warehouse_id), $where);
		$this->result = M('Location')->where($where)->limit($this->limit)->order($field . ' desc')->field('id as id,' . $field . ' as value')->group($field)->select();		
	}

    ///发货入库单号
    public function instockStorageNo(){
		$where			= $this->getWhere('storage_no');
		$this->result	= M('instock_storage')->where($where)->limit($this->limit)->order('storage_no desc')->field('id as id,storage_no as value')->select();
	}
    //地址错误流程可选状态
    public function saleOrderState(){
        $userInfo   = getUser();        
        $sale_order_state_arr   = M('state_log')->field('object_id, state_id')->where('object_type=2 and '.$this->where)->order('id desc')->select();
        foreach($sale_order_state_arr as $val){
            if(!in_array($val['state_id'], C('EDIT_ADDRESS_SALE_ORDER_STATE'))){
                $old_sale_order_state   = $val['state_id'];//地址错误前的状态
                break;
            }
        }
        $new_sale_order_state   = $sale_order_state_arr[0]['state_id'];//当前状态
		if ($old_sale_order_state == C('SALE_ORDER_STATE_PICKING') 
				&& in_array($new_sale_order_state, array(C('ERROR_ADDRESS'), C('ADDRESS_CHANGED')))
				&& M('FileRelationDetail')->where(array('file_type' => array_search('PickingImport', C('CFG_FILE_TYPE')), 'relation_id' => $sale_order_state_arr[0]['object_id']))->count() > 0) {
			//前一个状态为拣货中，现状态为地址错误或地址已改且订单已完成拣货导入，则订单状态只能选择为拣货完成不能选择为拣货中
			$old_sale_order_state	= C('SALE_ORDER_STATE_PICKED');
		}
        $result     = C('SELECT_SALE_ORDER_STATE');//卖家可编辑状态
        if ($userInfo['role_type'] != C('SELLER_ROLE_TYPE')) {//非卖家可编辑状态
            if ($new_sale_order_state != C('ADDRESS_CHANGED')) {//当前状态非地址已改，则过滤地址已改
                $filter = C('ADDRESS_CHANGED');
            }else{
                $filter     = '';
            }
            $result[]   =array('id'=>$old_sale_order_state,'value'=>C('SALE_ORDER_STATE.'.$old_sale_order_state));
        }
        natsort($result);
        foreach($result as $val){
            if ($val['id'] != $filter) {
                $this->result[] = $val;
            }
        }
    }
//银行开户人姓名
    public function contact(){   
		$this->result	= M('Bank')->where($this->getWhere('contact'))->order('contact desc')->limit($this->limit)->field('contact as id,contact as value')->group('contact')->select();
    }
    public function returnTrackNo(){
        $where		  = $this->getWhere('return_track_no');
        $userInfo       = getUser();
		if ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {
			$where .= ' and a.factory_id='.intval($userInfo['company_id']);
		}
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and b.warehouse_id='.intval($userInfo['company_id']);
		}
        $this->result   = M('return_sale_order')->join(' a left join return_sale_order_detail as b on a.id=b.return_sale_order_id ')->field('a.id as id,a.return_track_no as value')->where($where)->order('a.return_track_no desc')->group('a.return_track_no')->select();
    }
    
    //问题订单处理方式
    public function processMode(){
        $where  = trim($_POST['where']);
        switch ($where){
                case 20:
                    $data   = C('QUESTION_ORDER_UNFINISHED_TREATMENT');
                    break;
                case 30:
                    $data   = C('QUESTION_ORDER_FINISHED_TREATMENT');
                    break;
                case 10:
                default:
                    $data   = '';
                    break;
        }
        if(!empty($data)){
            foreach($data as $key=>$val){
                $result['id']       = $key;
                $result['value']    = $val;
                $this->result[]     = $result;
            }
        }else{
            $this->result   ='';
        }
    }
    //卖家角色问题订单处理方式
    public function sellerProcessMode(){ 
        $data   = C('QUESTION_ORDER_SALLER_UNFINISHED_TREATMENT');
        if(!empty($data)){
            foreach($data as $key=>$val){
                $result['id']       = $key;
                $result['value']    = $val;
                $this->result[]     = $result;
            }
        }else{
            $this->result   ='';
        }        
    }
    
    public function noQuestionOrder(){
        $where		  = $this->getWhere('sale_order_no', false);
        $this->result   = M('sale_order')->field('id as id,sale_order_no as value')->where($where.getBelongsWhere().' and sale_order_state in ('.C('ADD_QUESTION_ORDER_AUTOSEARCH').') and is_question=0')->limit($this->limit)->select();
    }
    //问题订单查询->问题订单单号
    public function questionOrder(){
        $where		  = $this->getWhere('question_order_no');
        $userInfo       = getUser();
        if ($userInfo['role_type'] == C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval($userInfo['company_id']);
		}
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}
        $this->result   = M('question_order')->where($where)->field('id as id,question_order_no as value')->limit($this->limit)->select();
    }
    //问题订单查询->处理单号
    public function questionSaleOrderNo(){
        $where		  = $this->getWhere('sale_order_no', false);
        $userInfo       = getUser();
        if ($userInfo['role_type'] == C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval($userInfo['company_id']);
		}
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}
        $this->result   = M('question_order')->where($where)->field('sale_order_id as id,sale_order_no as value')->limit($this->limit)->select();
    }
    //问题订单查询->订单号
    public function questionOrderNo(){
        $where		  = $this->getWhere('order_no', false);
        $userInfo       = getUser();
        if ($userInfo['role_type'] == C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval($userInfo['company_id']);
		}
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}
        $this->result   = M('question_order')->where($where)->field('order_no as id,order_no as value')->limit($this->limit)->select();
    }
    //问题订单查询->追踪号
    public function questionTrackNo(){
        $where		  = $this->getWhere('track_no', false);
        $userInfo       = getUser();
        if ($userInfo['role_type'] == C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval($userInfo['company_id']);
		}
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$where .= ' and warehouse_id='.intval($userInfo['company_id']);
		}
        $where  .= ' and is_question=1 and track_no <>"" ';
        $this->result   = M('sale_order')->where($where)->field('id as id,track_no as value')->group('track_no')->limit($this->limit)->select();
    }
    
    public function warehouseListLocationNo(){
		$field	= 'barcode_no';
		$where	= $this->getWhere($field);
		$userInfo	=	getUser();
//		if (strpos($where,'warehouse_id') === FALSE && $userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
        if($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')){
            if(strpos($where,'warehouse_id') === FALSE){
                $is_sold    = M('warehouse')->where('id='.$userInfo['company_id'])->getField('is_return_sold');
                if(strpos($where,'w.is_return_sold='.C('NO_RETURN_SOLD')) === FALSE ||$is_sold  == C('NO_RETURN_SOLD')){
                    $field_name = 'warehouse_id';
                }else{
                    $field_name = 'relation_warehouse_id';
                }
                $where .= ' and '.$field_name.'='.intval($userInfo['company_id']);
            }
		}
		$this->result = M('Location')->join(' as l left join warehouse as w on l.warehouse_id=w.id')->where($where)->limit($this->limit)->order($field . ' desc')->field('l.id as id,' . $field . ' as value')->group($field)->select();
	}
    //选择仓库用户可选择自身和关联仓库的库位 added yyh 20150527
    public function adjustLocationNo(){
        $field	= 'barcode_no';
		$where	= $this->getWhere($field);
		$userInfo	=	getUser(); 
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
            $is_sold    = M('warehouse')->where('id='.$userInfo['company_id'])->getField('is_return_sold');
            $warehouse_where    = 'warehouse_id='.$userInfo['company_id'];
            if($is_sold  != C('NO_RETURN_SOLD')){
                $warehouse_where  .= ' or (is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id='.$userInfo['company_id'].')';
            }
            $where  .= ' and ('.$warehouse_where.')';
            $this->result = M('Location')->join(' as l left join warehouse as w on l.warehouse_id=w.id')->where($where)->limit($this->limit)->order($field . ' desc')->field('l.id as id,' . $field . ' as value')->group($field)->select();
		}else{
            $warehouse_id   = M('warehouse')->where('is_use=1 and to_hide=1')->getField('id',true);
            $where          .= ' and warehouse_id in ('.implode(',', $warehouse_id).')';
            $this->result   = M('Location')->where($where)->limit($this->limit)->order($field . ' desc')->field('id as id,' . $field . ' as value')->group($field)->select();
        }
    }
    
    //国内运单 added yyh 20150528
    public function waybillNo(){
        $field = 'waybill_no';
        $where = $this->getWhere($field);
        $userInfo	=	getUser();                 
        if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) { 
              $data['id']= $userInfo['company_id']; 
              $is_return_sold  = M('Warehouse')->where($data)->getField('is_return_sold',true);  
              if($is_return_sold>1){
                  $where .= ' and warehouse_id='.$userInfo['company_id'];                  
                }else{                  
                $res['relation_warehouse_id']=$userInfo['company_id'];                
                $w_id  = M('Warehouse')->where($res)->getField('id',true);                
                $where          .= ' and warehouse_id in ('.implode(',', $w_id).')';                  
               // $this->result = M('DomesticWaybill')->join('as a left join domestic_waybill_detail  b on b.waybill_id=a.id')->where($where)->limit($this->limit)->order('waybill_no desc')->field('a.id as id ,waybill_no as value')->group('waybill_no')->select();                		
                }                
        }$this->result = M('DomesticWaybill')->join('as a left join domestic_waybill_detail  b on b.waybill_id=a.id')->where($where)->limit($this->limit)->order('waybill_no desc')->field('a.id as id ,waybill_no as value')->group('waybill_no')->select();                                             
    }
    //退货不可再销售库位 
    public function noSoldLocation(){
		$field	= 'barcode_no';
		$where	= $this->getWhere($field);
		$userInfo	=	getUser(); 
               /// dump($userInfo);
		if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
            $is_sold    = M('warehouse')->where('id='.$userInfo['company_id'])->getField('is_return_sold');
            if($is_sold != C('NO_RETURN_SOLD')){
                $warehouse_id   = M('warehouse')->where('is_use=1 and to_hide=1 and relation_warehouse_id='.$userInfo['company_id'].' and is_return_sold='.C('NO_RETURN_SOLD'))->getField('id',TRUE);
            }else{
				$warehouse_id   = $userInfo['company_id'];
			}
		}else{
            $warehouse_id   = M('warehouse')->where('is_return_sold='.C('NO_RETURN_SOLD').' and to_hide=1 and is_use=1')->getField('id',true);                
        }
        $where          .= ' and warehouse_id in ('.implode(',', $warehouse_id).')';
        $this->result   = M('Location')->where($where)->limit($this->limit)->order($field . ' desc')->field('id as id,' . $field . ' as value')->group($field)->select();		
        }
    //退货单用户名称为空时使用登录名
    public function returnAddUserName() {
        $where = $this->getWhere('__real_name') ;
        $where = str_replace('`__real_name`', 'if(real_name="",user_name,real_name)', $where);
        if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$add_user_where = ' a.factory_id='.intval(getUser('company_id'));
		}
        if (getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')) {
			$add_user_where = ' b.warehouse_id='.intval(getUser('company_id'));
		}
        $add_user_arr   = M('ReturnSaleOrder')->join('as a left join return_sale_order_detail as b on a.id=b.return_sale_order_id')->where($add_user_where)->limit($this->limit)->group('a.add_user')->field('a.add_user')->getField('add_user',true);
        if(!empty($add_user_arr)){
            $this->result   = M('User')->where($where.' and id in ('.implode(',', $add_user_arr).')')->group('if(real_name="",user_name,real_name)')->order('real_name desc')->limit($this->limit)->field('if(real_name="",user_name,real_name) as id,if(real_name="",user_name,real_name) as value')->select();
        }else{
            $this->result   = null;
        }
    }
    //问题订单用户名称为空时使用登录名
    public function questionAddUserName() {
        $where = $this->getWhere('__real_name') ;
        $where = str_replace('`__real_name`', 'if(real_name="",user_name,real_name)', $where);
        if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$add_user_where = ' factory_id='.intval(getUser('company_id'));
		}
        if (getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')) {
			$add_user_where =' warehouse_id='.intval(getUser('company_id'));
		}
        $add_user_arr   = M('QuestionOrder')->where($add_user_where)->group('add_user')->limit($this->limit)->getField('add_user',true);
        if(!empty($add_user_arr)){
            $this->result   = M('User')->where($where.' and id in ('.implode(',', $add_user_arr).')')->order('real_name desc')->limit($this->limit)->field('if(real_name="",user_name,real_name) as id,if(real_name="",user_name,real_name) as value')->select();
        }else{
            $this->result   = null;
        }
    }
    public function shiftWarehouseNo(){
        $where			= $this->getWhere('shift_warehouse_no');
		$this->result	= M('ShiftWarehouse')->join(' a left join shift_warehouse_detail b on a.id=b.shift_warehouse_id')->where($where.  getAllWarehouseWhere('b','out_warehouse_id'))->limit($this->limit)->group('shift_warehouse_no')->order('shift_warehouse_no desc')->field('a.id as id,shift_warehouse_no as value')->select();
    }
    
    //退货处理单号added yyh 20150701
    public function getReturnOrderNo(){
        $where			= $this->getWhere('return_order_no');
		$this->result	= M('ReturnSaleOrder')->join(' a left join return_sale_order_detail b on a.id=b.return_sale_order_id')->where($where.  getAllWarehouseWhere('b','warehouse_id').getBelongsWhere())->limit($this->limit)->group('return_order_no')->order('return_order_no desc')->field('a.id as id,return_order_no as value')->select();
    }
    //发货产品ID   add by lxt 2015.06.04
	public function instockProductId2(){
		$where		 = $this->getWhere('product_id');
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}		
		$this->result= M('InstockDetail')->join('detail left join product p on detail.product_id=p.id')->where($where)->limit($this->limit)->order('product_no desc')->group('product_id')->field('product_id as id,product_id as value')->order('product_id desc')->select();
	}
	
	//发货产品号        add by lxt 2015.06.04
	public function instockProductNo2(){
	    $where		 = $this->getWhere('product_no');
	    if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
	        $where .= ' and factory_id='.intval(getUser('company_id'));
	    }
	    $this->result= M('InstockDetail')->join('detail left join product p on detail.product_id=p.id')->where($where)->limit($this->limit)->order('product_no desc')->field('product_no as id,product_no as value')->group('product_no')->select();
	}
	
	//入库产品ID   add by lxt 2015.06.04
	public function InstockStorageId(){
	    $where		 = $this->getWhere('product_id');
	    if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
	        $where .= ' and factory_id='.intval(getUser('company_id'));
	    }
	    $this->result= M('InstockStorageDetail')->join('detail left join product p on detail.product_id=p.id')->where($where)->limit($this->limit)->order('product_no desc')->group('product_id')->field('product_id as id,product_id as value')->order('product_id desc')->select();
	}
	
	//处理费用名称       add by lxt 2015.06.12
	public function returnProcessFee(){
	    $where			= $this->getWhere('return_process_fee_name');
	    $this->result	= M('ReturnProcessFee')->where($where)->limit($this->limit)->field('id as id,return_process_fee_name as value')->select();
	}
	
	//退货处理费用编号     add by lxt 2015.06.12
	public function returnProcessFeeNo(){
	    $where			= $this->getWhere('return_process_fee_no');
	    $this->result	= M('ReturnProcessFee')->where($where)->limit($this->limit)->field('id as id,return_process_fee_no as value')->order('return_process_fee_no asc')->select();
	}
	
	//退货按出库时间排序        add by lxt 2015.07.06
	public function returnLocationNoInstock(){
	    $field              = 'barcode_no';
	    //获取主仓库ID
	    $where      = $this->getWhere($field);
		preg_match('/([0-9]*)_warehouse_id/', $where, $matches);
	    $relation_warehouse_id  = (int)$matches[1];
	    
	    //用于关联stock_out的product_id  add by lxt 2015.07.02
	    preg_match('/([0-9]*)_product_id/', $where,$product_id);
	    $where      =   str_replace($product_id[0], "", $where);
	    $product_id =   (int)$product_id[1];
	    
	    //获取关联子仓库ID
	    $no_sold_warehouse_id   = M('warehouse')->where('is_use=1 and to_hide=1 and is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id='.$relation_warehouse_id)->getField('id',TRUE);
	    $no_sold_warehouse_id[] = 0;
	    $where      = str_replace('_warehouse_id', ','.implode(',', $no_sold_warehouse_id), $where);
	    
	    //关联stock_out先出库的优先排序       edit by lxt 2015.07.02
	    $this->result = M('Location')->alias("a")->join("left join stock_out b on a.id=b.in_location_id and product_id=".$product_id)->where($where)->limit($this->limit)->order('out_date is null,barcode_no desc')->field('a.id as id,' . $field . ' as value')->group($field)->select();
	}
    public function ShiftWarehouseLocation(){
        $field          = 'barcode_no';
		$where          = $this->getWhere($field);
//        $where          .= getWarehouseWhere('s');
		$where          .= getAllWarehouseWhere('s');
        $where          .= ' and s.quantity>0';
        $this->result   = M('storage')->join(' s inner join location l on s.location_id=l.id')->limit($this->limit)->where($where)->order('l.barcode_no desc')->group('s.location_id')->field('l.id as id,l.barcode_no as value')->select();
    }

    public function warehouseFeeCode(){
        $field          = 'warehouse_fee_no';
		$where          = $this->getWhere($field);
        $this->result   = M('warehouse_fee')->limit($this->limit)->where($where)->field('id,warehouse_fee_no as value')->select();
    }
    
    //退货物流单号            add by lxt 2015.09.09
    public function returnLogisticsNo(){
        $where  =   $this->getWhere('return_logistics_no');
        $this->result   =   M('ReturnSaleOrder')->where($where)->limit($this->limit)->field('id as id,return_logistics_no as value')->order('return_logistics_no desc')->select();
    }
//     //退货运单号         add by lxt 2015.09.09
//     public function returnWaybillNo(){
//         $where  =   $this->getWhere('waybill_no');
//         $this->result   =   M('ReturnSaleOrder')->where($where)->limit($this->limit)->field('id as id,waybill_no as value')->order('waybill_no desc')->select();
//     }
    public function packBoxNo(){
        $field          = 'pack_box_no';
		$where          = $this->getWhere($field);
        $this->result   = M('pack_box')->limit($this->limit)->where($where)->field('id,pack_box_no as value')->select();
    }
    public function outBatchNo(){
        $field          = 'out_batch_no';
        $where          = $this->getWhere($field);
        $this->result   = M('out_batch')->limit($this->limit)->where($where)->field('id,out_batch_no as value')->select();
    }
    public function customsClearanceState(){
        $customs_clearance_state    = C('CUSTOMS_CLEARANCE_STATE');
        foreach($customs_clearance_state as $key=>$value){
            $state['id']    = $key;
            $state['value'] = $value;
            $result[]   = $state;
        }
        $this->result   = $result;
    }
    
    public function associateWithState(){
        $associate_with_state   = C('ASSOCIATE_WITH_STATE');
        foreach($associate_with_state as $key=>$value){
            $state['id']    = $key;
            $state['value'] = $value;
            $result[]   = $state;
        }
        $this->result   = $result;
    }
    
    
    public function shippingName(){
        $field	= 'express_name';
        $where	= $this->getWhere($field);
	$userInfo	=	getUser();                  
	if ($userInfo['role_type'] == C('WAREHOUSE_ROLE_TYPE')) { 
            if(strpos($where,'warehouse_id') === FALSE){
                $where .= ' and warehouse_id='.intval($userInfo['company_id']);
            } 
        }  		
	$this->result	= M('Express')->where($where)->limit($this->limit)->field('id as id,express_name as value')->select();		
	}

	///获取产品条码
	public function productCustomBarcode(){
		$where		  = $this->getWhere('custom_barcode').' and to_hide=1';
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and factory_id='.intval(getUser('company_id'));
		}
		$this->result = M('Product')->where($where)->order('custom_barcode desc')->limit($this->limit)->field('id as id ,custom_barcode as value')->select();
	}

	//国内运费名称
	public function domesticShippingFee(){
	    $where			= $this->getWhere('domestic_shipping_fee_name');
	    $this->result	= M('DomesticShippingFee')->where($where)->limit($this->limit)->field('id as id,domestic_shipping_fee_name as value')->select();
	}

	//国内运费编号
	public function domesticShippingFeeNo(){
	    $where			= $this->getWhere('domestic_shipping_fee_no');
	    $this->result	= M('DomesticShippingFee')->where($where)->limit($this->limit)->field('id as id,domestic_shipping_fee_no as value')->order('domestic_shipping_fee_no asc')->select();
	}
    ///销售渠道名称
	public function orderTypeName(){
		$this->result = M('OrderType')->where($this->getWhere('order_type_name').' and to_hide=1')->order('order_type_name asc')->limit($this->limit)->field('id as id,order_type_name as value')->select();
        array_unshift($this->result,array('id'=>0,'value'=>L('all')));
	}   
   ///销售渠道名称
	public function orderTypeTag(){
		$this->result = M('OrderType')->where($this->getWhere('order_type_name').' and to_hide=1')->order('order_type_name asc')->limit($this->limit)->field('id as id,order_type_name as value')->select();
        array_unshift($this->result,array('id'=>-2,'value'=>L('all')));
	}
    ///销售渠道名称
	public function orderType(){
		$this->result = M('OrderType')->where($this->getWhere('order_type_name').' and to_hide=1')->order('order_type_name asc')->limit($this->limit)->field('id as id,order_type_name as value')->select();
	}

	///信息类型编号
	public function  categoryName(){
		$table	=	'message_category';
		$field	=	'category_name';
		$where	=	$this->getWhere($field);
		$this->getList($table,$field,$where);
	}
	///信息类型名称
	public function categoryNo(){
		$table	=	'message_category';
		$field	=	'category_no';
		$where	=	$this->getWhere($field);
		$this->getList($table,$field,$where);
	}
	///信息标题
	public function messageTitle(){
		$table	=	'message';
		$field	=	'message_title';
		$where	=	$this->getWhere($field);
		$this->getList($table,$field,$where);
	}
	///信息类型ID
	public function  categoryId(){
        $field          = 'category_name';
        $where          = $this->getWhere($field);
        $where         .= ' and to_hide=1';
        $this->result    = M('message_category')->limit($this->limit)->where($where)->order('id desc')->group('id')->field('id,category_name as value')->select();    
	}

	public function dhlObjectNo(){
		$table	=	'dhl_list';
		$field	=	'object_no';
		$where	=	$this->getWhere($field);
		$this->getList($table, $field, $where, 'object_id');
	}

	public function correosObjectNo(){
		$table	=	'correos_list';
		$field	=	'object_no';
		$where	=	$this->getWhere($field);
		$this->getList($table, $field, $where, 'object_id');
	}

	//移仓 相关仓库和退货不可再销售仓库
    public function shiftWarehouseInLocationNo(){
        $field              = 'barcode_no';
        //获取主仓库ID
        $where      = $this->getWhere($field);
        preg_match('/([0-9]*)_warehouse_id/', $where, $matches);
        $relation_warehouse_id  = (int)$matches[1];
        $warehouse	= M('warehouse')->where('id='.$relation_warehouse_id)->getField('relation_warehouse_id');
		if($warehouse>0){
			$relation_warehouse_id	= $warehouse;
		}
        //获取关联子仓库ID
        $no_sold_warehouse_id   = M('warehouse')->where('is_use=1 and to_hide=1 and is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id='.$relation_warehouse_id)->getField('id',TRUE);
        $no_sold_warehouse_id[] = 0;
        $where      = str_replace('_warehouse_id', ','.$relation_warehouse_id.','.implode(',', $no_sold_warehouse_id), $where);
		$this->result = M('Location')->where($where)->limit($this->limit)->order($field . ' desc')->field('id as id,' . $field . ' as value')->group($field)->select();
	}
	//退货单用户名称为空时使用登录名
    public function saleOrderConsigner() {
		$where = $this->getWhere('__real_name') ;
        $where = str_replace('`__real_name`', 'if(real_name="",user_name,real_name)', $where);
		if(getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')){
			$where	.= ' and company_id='.getUser('company_id');
		}
		//超管,管理,仓库
		$result   = M('User')->where($where.' and to_hide=1 and user_type=5')->group('if(real_name="",user_name,real_name)')->order('real_name desc')->limit($this->limit)->field('id as id,if(real_name="",user_name,real_name) as value')->select();
		$this->result	= $result;
    }

	//macAddress
	public function glsPrinterMacAddress(){
		$table	=	'gls_printer_name';
		$field	=	'mac_address';
		$where	=	$this->getWhere($field);
		$this->getList($table,$field,$where);
	}
	//printerName
	public function glsPrinterName(){
		$table	=	'gls_printer_name';
		$field	=	'printer_name';
		$where	=	$this->getWhere($field);
		$this->getList($table,$field,$where);
	}
}
