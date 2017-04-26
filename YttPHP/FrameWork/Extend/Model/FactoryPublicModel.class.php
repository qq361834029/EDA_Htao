<?php

/**
 * 厂家信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     jph
 * @version  2.1,2014-01-22
 */

class FactoryPublicModel extends RelationCommonModel {
	
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'company';
	public $_sortBy		 = 'id';
	/// 自动验证设置
	protected $_validate	 =	 array(
		//基本信息
//		array("comp_no",'require',"require",1),
//		array("comp_no",'is_no',"valid_error",1),  	
//		array("comp_no",'',"unique",1,'unique',3,array('comp_type'=>1)),//验证唯一
		array("warning_balance_rmb",'money',"double",2),
		array("warning_balance_euro",'money',"double",2),
		array("warning_balance_gbp",'money',"double",2),
		array("warning_balance_usd",'money',"double",2),
		array("warning_balance_hkd",'money',"double",2),
		array("warning_balance_aed",'money',"double",2),
		array("comp_name",'require',"require",1),
	    array("nick_name",'require',"require",1),//名称缩写    add by lxt 2015.06.16
//		array("comp_name",'',"unique",1,'unique',3,array('comp_type'=>1)),//验证唯一 
		array("email",'require',"require",1),
		array("email",'email',"valid_email",2),         
		array("warn_email",'email',"valid_email",2), 
		array("email",'',"unique",1,'unique',3,array('comp_type'=>1)),//验证唯一 		
		array("mobile",'require',"require",1),
		//array("mobile",'',"unique",1,'unique',3,array('comp_type'=>1)),//验证唯一 
		array("contact",'require',"require",1),
		array("",'validCountry','',1,'callbacks'), 
		array("express_discount",'discount',"valid_express_discount",2),//快递折扣
		array("express_discount",array(0,1),'between',2,'between'),
		array("package_discount",'discount',"valid_express_discount",2),//包装费用折扣
		array("package_discount",array(0,1),'between',2,'between'),
		array("process_discount",'discount',"valid_express_discount",2),//处理费用折扣
		array("process_discount",array(0,1),'between',2,'between'),		
		//账号信息
		array("email",array('alias'=>'user_name','model'=>'user','pk'=>'company_id','map'=>array('user_type'=>array('neq',2))),"unique",1,'uniqueotherfield',''),//验证唯一  //等于$_POST[email]
		array('','validRepeat','',1,'callbacks'),
        array("",'_validDetail','require',1,'validDetail'),
//        array("",'validWarehouseFee','require',1,'callbacks'),
//        array("",'validCustomBarUnique','require',1,'callbacks'),
        array("",'validCompanyFactory','require',1,'callbacks'),
//		array("comp_name",array('alias'=>'real_name','model'=>'user','pk'=>'company_id','map'=>array('user_type'=>array('neq',2))),"unique",1,'uniqueonothertable',''),//验证唯一  //等于$_POST[comp_name]		
	); 	
	//明细验证
	protected $_validDetail	 =	 array(
			array("express_discount",'discount',"valid_express_discount",2),//快递折扣
			array("express_discount",array(0,1),'between',2,'between'),
			array("process_discount",'discount',"valid_express_discount",2),//快递折扣
			array("process_discount",array(0,1),'between',2,'between'),
			//array("express_discount",'require','require',1),
			//array("w_name",'require','require',1),
		//array("return_fee",'ymoney',"money_error",1),
	);
//    protected $_validWarehouseFee   = array(
//        array("start_days",'z_integer',"z_integer",2),
//        array("end_days",'z_integer',"z_integer",2),
//        array("end_days",'start_days','end_days_egt_start_days',2,'egt'), 
//    );
    
    protected $_validCompanyFactory = array(
    );
	//自动完成
	protected $_auto = array ( 
		array('comp_name','trim',3,'function') , // 过滤前后空格
		array('contact','trim',3,'function') , 
		array('mobile','trim',3,'function') ,
		array('create_ip','get_client_ip',1,'function') ,
	);

    ///added by yyh 20140922 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'factory_id',
										'class_name'	=> 'ExpressDiscount',
									),
//                                  'warehouse_fee' =>
//                                    array(
//                                        'mapping_type'  => HAS_MANY,
//                                        'foreign_key'   => 'factory_id',
//                                        'class_name'    => 'warehouseFee'
//                                    ),
                                  'company_factory'=>
                                    array(
                                        'mapping_type'  => HAS_MANY,
                                        'foreign_key'   => 'factory_id',
                                        'class_name'    => 'CompanyFactory'
                                    )
								);	
    
//    public function validWarehouseFee($data){
//		$valid		= '_validWarehouseFee';
//		return $this->_moduleValidationDetail($this,$data,'warehouse_fee',$valid); 
//	}
    public function validCustomBarUnique($data){
        $custom_barcode_num = $data['company_factory'][1]['custom_barcode_num'];
        $custom_barcode_en  = $data['company_factory'][1]['custom_barcode_en'];
        $is_custom_barcode  = $data['company_factory'][1]['is_custom_barcode'];
        if(!($custom_barcode_num == 13 && empty($custom_barcode_en)) && $is_custom_barcode == 1){//不同卖家可设置为13位纯数字可用
            if(!empty($custom_barcode_num)){
                $where['custom_barcode_num']    = $custom_barcode_num;
            }else{
                $error['name']	= 'company_factory[1][custom_barcode_num]';
                $error['value']	= L('require');
                $this->error[]	= $error; 
            }
            $where['custom_barcode_en'] = $custom_barcode_en;
            
            if(!empty($data['id'])){
                $where['factory_id']    = array('NEQ',$data['id']);
            }
            $count  = M('company_factory')->where($where)->count();
            if($count > 0){
                $error['name']	= 'company_factory[1][custom_barcode_num]';
                $error['value']	= L('unique');
                $this->error[]	= $error; 
            }
        }
    }
    public function validCompanyFactory($data){
		$valid		= '_validCompanyFactory';
        if($_POST['company_factory'][1]['is_warehouse_fee']){
            $warehouse[]    = array("warehouse_percentage",'ymoney',"gteq_0_number",1);
            $warehouse[]    = array("warehouse_fee_id",'pst_integer',"require",1);
        }
        if($_POST['company_factory'][1]['is_return_process_fee']){
            $warehouse[]    = array("return_process_percentage",'ymoney',"gteq_0_number",1);
        }
        if($_POST['company_factory'][1]['is_domestic_freight']){
            $warehouse[]    = array("domestic_freight_percentage",'ymoney',"gteq_0_number",1);
        }
//		if($_POST['company_factory'][1]['warning_balance_gbp']){
//            $warehouse[]    = array("warning_balance_gbp",'ymoney',"double",2);
//        }
//		if($_POST['company_factory'][1]['warning_balance_rmb']){
//            $warehouse[]    = array("warning_balance_rmb",'ymoney',"double",2);
//        }
//		if($_POST['company_factory'][1]['warning_balance_euro']){
//            $warehouse[]    = array("warning_balance_euro",'ymoney',"double",2);
//        }
//        if($_POST['company_factory'][1]['is_custom_barcode'] == 1){
//            if($data['company_factory'][1]['custom_barcode_en']){
//                $warehouse[]    = array("custom_barcode_en",'english',"english",  self::EXISTS_VAILIDATE);
//            }
//            $warehouse[]    = array('','validCustomBarcodeRule','',  self::MUST_VALIDATE,'callbacks');
//        }
        $this->_validCompanyFactory = $warehouse;
		return $this->_moduleValidationDetail($this,$data,'company_factory',$valid); 
	}
//    public function validCustomBarcodeRule($data){
//        $custom_barcode_num = $data['custom_barcode_num'];
//        if(empty($custom_barcode_num) || $custom_barcode_num < C('CUSTOM_BARCODE_MIN') || $custom_barcode_num > C('CUSTOM_BARCODE_MAX')){//6-13
//            $error['name']	= 'company_factory[1][custom_barcode_num]';
//            $error['value']	= "请输入".C('CUSTOM_BARCODE_MIN').'到'.C('CUSTOM_BARCODE_MAX').'之间的数字';
//            $this->error[]	= $error;
//        }
//    }

    public function validRepeat($data){
			$spec	= array();
			foreach($data['detail'] as $key=>$val){
				$detail_spec = $val['w_name'];
				if(empty($val['w_name']) && empty($val['express_discount'])){
					Continue;
				}
				if(!empty($val['w_name']) && empty($val['express_discount'])){
					$error['name']	= 'detail['.$key.'][express_discount]';
					$error['value']	= L('require');
					$this->error[]	= $error;
				}else if(empty($val['w_name']) && (!empty($val['express_discount']) || !empty($val['process_discount']))){
					$error['name']	= 'detail['.$key.'][w_name]';
					$error['value']	= L('require');
					$this->error[]	= $error;
				}
				if(!empty($val['w_name']) && empty($val['process_discount'])){
					$error['name']	= 'detail['.$key.'][process_discount]';
					$error['value']	= L('require');
					$this->error[]	= $error;
				}
				if(in_array($detail_spec,$spec)){
					$error['name']	= 'detail['.$key.'][w_name]';
					$error['value']	= L('unique');
					$this->error[]	= $error;
				}else{
					$spec[]	= $detail_spec;
				}
			}
	}
	protected function validCountry($data){
		if (!empty($data['country_name'])) {
			$vasd = array(array("country_id",'pst_integer',"require",1));
		}
		return $this->_validSubmit($data,$vasd);
	}
	public function getInfo($id){
		$rs = $this->field('c.*,u.id as user_id,u.user_type,u.use_usbkey,u.usbkey,u.role_id,u.user_ip,u.comments as user_comments,min(u.create_time) as create_time')->table($this->tableName . ' as c')->join('user u on u.company_id=c.id and u.user_type=2')->where('c.id='.(int)$id)->find();
		$sql	=	'select ed.*,w.w_name from express_discount as ed join warehouse as w on ed.warehouse_id=w.id where ed.factory_id='.$id;  
		$rs['detail'] = $this->db->query($sql); 
//        $rs['warehouse_fee']        = M('warehouse_fee')->where('factory_id='.$id)->select();
        $rs['company_factory'][0]   = M('company_factory')->where('factory_id='.$id)->find();
		$rs = _formatListRelation($rs,array('detail','company_factory'));
        foreach($rs['company_factory'] as $val){
            $rs['company_factory']  = $val;
        }
        $rs['company_factory']['is_account']    = false;
        if($rs['company_factory']['is_warehouse_fee'] == 1){
            $count  = M('warehouse_account')->where('factory_id='.$id)->count();
            $count > 0 && $rs['company_factory']['is_account'] = true;
        }
		$model		=	D('Gallery');
		$rs['pics'] = $model->getAry($id,30);
        return $rs;
	}
	
	//格式化数组    add by lxt 2015.07.03
	public function setPost(){
	    //过滤两端空格
	    $_POST['basic_name_en']    =   trim($_POST['basic_name_en']);
	    $this->Mdate	=	$_POST;
	    return $_POST;
	}

	
    /**
     * 返回模型的错误信息
     * @access public
     * @return string
     */
    public function addError($error){
    	foreach ($error as $v){
    		$this->error[]	=	$v;
    	} 
    }
	public function relationUpdate(){		
		$info	=	$this->setPost();
		$this->_brf();
		$this->id	=	$info['id'];
		$this->_beforeModel($info);
 		$r = $this->relation(true)->save();
 		if (false === $r) {
 			$this->error_type	=	2;
 			return false;
 		}
 		$this->_afterModel($info); 
 		$this->execTags($info);   
	}

	public function relationInsert(){ 
		$info	= $this->setPost();  
		$this->_brf();
		if($this->_beforeModel($info) == false){
			$this->error_type	= 1;
			return false;
		}
		$id = $this->relation(true)->add();   
		if (false === $id) {
			$this->error_type	=	2;
			return false; 
		}	 
		$this->id	=	$id;  
		empty($info) ? $_POST['id'] = $id : $info['id'] = $id; 
		$this->_afterModel($info); 
		$this->execTags($info);   
		return $id;
	}
}