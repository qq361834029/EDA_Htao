<?php
/**
 * 入库管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category    采购信息
 * @package		Action
 * @author		jph
 * @version		2.1,2014-03-07
 */

class InstockPublicAction extends RelationCommonAction {
	
	public $_email_object_id 	=	'factory_id';//默认客户 其余 factory_id
	
	public function _initialize() {
		parent::_initialize(); 
		$userInfo	=	getUser(); 
		if ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {//卖家
			$_POST['main']['query']['factory_id'] = intval($userInfo['company_id']);
			if ($userInfo['company_id'] > 0) {
				$this->assign("fac_id", $userInfo['company_id']);
				$this->assign("fac_name", SOnly('factory',$userInfo['company_id'], 'factory_name'));		
			}				
		} elseif ($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){//仓储
			$_POST['main']['query']['warehouse_id'] = intval($userInfo['company_id']);
			if ($userInfo['company_id'] > 0) {
				$this->assign("w_id", $userInfo['company_id']);
				$this->assign("w_name", SOnly('warehouse',$userInfo['company_id'], 'w_name'));		
			}				
		}
		if ($userInfo['role_type']!=C('SELLER_ROLE_TYPE') && !isset($_POST['search_form'])){
			$default_instock_type	= 1;
			$_POST['main']['query']['instock_type'] = $default_instock_type;
			$this->assign('default_instock_type',$default_instock_type);
		}	
         if(ACTION_NAME  =='update' || ACTION_NAME   =='editStateUpdate'){
            $_POST['old_instock_type']  = M('Instock')->where('id=' . (int)$_POST['id'])->getField('instock_type');
        }  
	}
	public function add(){
		$id	=	intval($_GET['id']);
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		if ($id > 0) {// 第二步时获取主表信息
			$name 		= $this->getActionName();
			$model 		= D($name);  
			$model->setId($id);
			$detail			= S('import_instock_detail_' . $id);
			$this->detail	= $detail;
			if (is_array($detail) && !empty($detail)) {//存在excel导入的数据
				$info	= $model->getMainInfo(false);
				$box_no	= $model->getBoxNo();
				foreach ($detail as &$val){
					$val['box_id']	= array_search($val['box_no'], $box_no);
				}
				unset($box_no);
			    $model->getProductInfo($detail,'product_no',$info['factory_id']);
                $info['product']	= $detail; 				              
				$rs	= _formatListRelation($info, array('product')); 
                 _formatWeightCubeList($rs['product']);
				unset($info);
			} else {
				$rs	= $model->getMainInfo();
			}
			$this->rs	= $rs;
		}
	}

	 ///更新
	public function update() {
		foreach($_POST['product'] as &$val){
			$val['accepting_quantity']=$val['quantity'];
		}
		unset($val);
		parent::update();
	}

	public function _after_insert(){  
		if(!empty($_POST['tocken'])){
			D('Gallery')->update($this->id,$_POST['tocken']);//更新产品图片关联信息
		}		
        $this->addTimer($this->id);
		if ($_POST['step'] != 2) {//下一步，输入产品明细信息
			if (isset($_POST['ser_detail'])){//excel导入的数据
				S('import_instock_detail_' . $this->id, unserialize(stripslashes(trim($_POST['ser_detail']))));
			}
			$url	= U(MODULE_NAME.'/add','id=' . $this->id);
			$ajax = array('status'=>2,'href'=>$url,'title'=>title('add',MODULE_NAME) , 'detail' => S('import_instock_detail_' . $this->id),'module_action'=>MODULE_NAME.'_'.ACTION_NAME);
			$this->success(L('_OPERATION_SUCCESS_'), $url, $ajax); 
		} else {
			$this->success(L('_OPERATION_SUCCESS_')); 
		}
	}	
	
	public function _after_edit() {
		if (!isset($_GET['step'])) {
			$this->step	= 1;
		} else {
			$this->step	= $_GET['step'];
		}		
		if (getUser('role_type') != C('SELLER_ROLE_TYPE')) {
			$this->_Member	= 'restricted_';
		}	
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));	
		parent::_after_edit();
	}
	
	public function _after_update(){  
		S('ser_instock_detail_' . $id, null);
		if(!empty($_POST['tocken'])){
			D('Gallery')->update($this->id,$_POST['tocken']);//更新产品图片关联信息
		}
		if ($_POST['step'] == 2) {//输入产品明细信息保存时跳转	
			$url	= U(MODULE_NAME.'/edit','id=' . $this->id);		
		} else {
			$url	= U(MODULE_NAME.'/edit','id=' . $this->id . '&step=2');
		}
		$ajax = array('status'=>2,'href'=>$url,'title'=>title('edit',MODULE_NAME),'module_action'=>MODULE_NAME.'_'.ACTION_NAME);
		$this->addTimer($this->id);
        $this->success(L('_OPERATION_SUCCESS_'), $url, $ajax); 
	}	
    public function sentEmail($module_name, $info) {
        //国外上架后向卖家发送邮件
        $instock_info			= M($module_name)->field('instock_type,factory_id,instock_no')->find($info['object_id']);
		$to_email				= M('company')->where('id='.$instock_info['factory_id'])->getField('warn_email');
		$_GET['state']          = 'instockDetail';
		$_GET['id']             = $info['object_id'];
		$_GET['module_name']    = 'instock';
		$list					= D('Excel')->getOutPut();
		$content				= '<style type="text/css">
						table,tr,td
						{
							border:1px solid #080808;
							width: 100%;
							text-align: center;
						}
						td
						{
							width:8%;
							height:50pt;
						}
						div
						{
							font-family:Arial,sans-serif;
							float: initial;
							color: #000;
							font-size:11pt;
							font-weight:bolder;
							line-height: 20pt;
							margin:auto;
							width:99%;
						}
					</style>
					<div><table><tr>';
		foreach($list['fields'] as $field){
			$content    .= '<td>'.$field.'</td>';
		}
		$content    .= '</th>';
		foreach($list['list'] as $value){
			$content    .= '<tr>';
			foreach($list['value'] as $key){
				$content    .= '<td>'.$value[$key].'</td>';
			}
			$content    .= '</tr>';
		}
		$content    .= '</tr></table></div>';
		return postEmail($to_email,$instock_info['instock_no'],$content);
    }

    public function addTimer($id){
        $timer_type     = C('TIMER_TYPE');
        $is_complete    = C('IS_COMPLETE');
        $detail_id_arr  = M('InstockBox')->where('instock_id='.$id)->select();
        foreach($detail_id_arr as $value){
            $timer  = M('timer')->where('type='.$timer_type['InstockBox'].' and object_id='.$value['id'])->find();
            if(empty($timer)){
                $data['object_id']      = $value['id'];
                $data['type']           = $timer_type['InstockBox'];
                $data['is_complete']    = $is_complete['pending'];
                $data['insert_time']    = date('Y-m-d H:i:s', time());
                $add_timer_data[]       = $data;
            }else{
                if($timer['is_complete'] != $is_complete['pending']){
                    $update_timer_id[]    = $value['id'];
                }
            }
        }
        
        if(!empty($add_timer_data)){
            M('timer')->addAll($add_timer_data);
        }
        
        if(!empty($update_timer_id)){
            M('timer')->where('type='.$timer_type['InstockBox'].' and object_id in ('.  implode(',', $update_timer_id).')')->save(array('is_complete'=>$is_complete['pending'],'insert_time'=>date('Y-m-d H:i:s', time())));
        }
    }

        /**
	 * 创建条形码
	 * @author jph 20140318
	 */
	public function generateBarcode($id = null){	
		if (is_null($id)) {
			$id	= $this->id;
		}
		$name 	= 'Instock';
		$path	= BARCODE_PATH . ucfirst($name) . '/' . $id;
		$model 	= D($name);  
		$model->setId($id);
		$rs		= $model->view();
		foreach ($rs['box'] as $box_id=>$box_info) {
			$box_info['instock_no']		= $rs['instock_no'];
			$box_info['factory_id']		= $rs['factory_id'];
			$box_info['warehouse_id']	= $rs['warehouse_id'];
			$this->generateBoxBarcode($box_id, $box_info);
		}
	}
	
	public function xxy(){
        $box_id = $_GET['box_id'];
        $this->generateBoxBarcode($box_id);
    }

    /**
	 * 创建箱号条形码
	 * @author jph 20141010
	 */
	public function generateBoxBarcode($box_id, $box_info = array()){			
		$name 	= 'Instock';
		if (empty($box_info)) {
			$rs 	= _formatWeightCube(_formatArray(M('InstockBox')->field('*,detail.cube_long*detail.cube_wide*detail.cube_high as cube,detail.check_long*detail.check_wide*detail.check_high as check_cube')->alias('detail')->join('__INSTOCK__ main on main.id=detail.instock_id')->where('detail.id=' . $box_id)->find()));
		} else {
			$rs		= $box_info;
		}
		$path	= BARCODE_PATH . ucfirst($name) . '/' . $rs['instock_id'];
//		$hri	= array(
//			'instock_no'	=> $rs['instock_no'],
//			'box_no'		=> 'BOX_NO: ' . $rs['box_no'],
//			'client_id'		=> 'CLIENT_ID: ' . $rs['factory_id'],
//			'weight'		=> 'WEIGHT: ' . $rs['s_unit_weight'],
//			'spec'			=> array_shift(explode('=', $rs['s_cube'] . L('volume_size_unit'))),
//			'abbr_district_name'    => SOnly('country', getWarehouseCountry($rs['warehouse_id']),'abbr_district_name'),
//		);
        $pc_type        = C('BARCODE_PC_TYPE') ? C('BARCODE_PC_TYPE') : 'gif';//图片格式	
        $barcode_config	= array(
            'h'            => 40,      //画布高度
            'w'            => 100,     //画布宽度
            'thickness'    => 30,      //条形码高度
        );
		$filename       = $path . '/' . (isset($barcode_config['file_name']) ? $barcode_config['file_name'] : $box_id) . '.' . $pc_type;
//        $barcode_token  = md5(implode('', $hri));
        if(!file_exists($filename)){
            createBarcodeImg($box_id,$path,$barcode_config);
//            M('InstockBox')->where('id='.$box_id)->save(array('barcode_token'=>$barcode_token));
        }
	}	
}