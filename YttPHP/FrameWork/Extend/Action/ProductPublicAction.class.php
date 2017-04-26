<?php
/**
 * 产品信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-01-14
 */

class ProductPublicAction extends RelationCommonAction {

	protected $_default_post	=  array('query'=>array('to_hide'=>1));  ///默认post值处理
    public $_view_dir 			= 'Basic';	/// 定义模板显示路径
    public $_sortBy				= 'product_no';
    protected $_cacheDd 		= array(7);//对应dd表中的id
	protected $_sku				= '';
	protected $_name			= '';


	///自动编号
	public $_setauto_cache		= 'setauto_product_no';	///编号对应超管配置中的值
	public $_auto_no_name		= 'product_no';		 	///编号no

	 public function __construct() {
    	parent::__construct();
    	if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {//角色类型为卖家类型
			$this->_default_post['query']['factory_id'] = intval(getUser('company_id'));
		}
    }

	///新增
	public function add() {
	 	///产品自动编号
		$this->_autoMaxNo();
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		$userInfo	=	getUser();
		if ($userInfo['company_id'] > 0) {
			$this->assign("fac_id", $userInfo['company_id']);
			$this->assign("fac_name", SOnly('factory',$userInfo['company_id'], 'factory_name'));
		}
		$role_type	= (int)$userInfo['role_type'];
		$role_type_where = ($role_type ==1||$_SESSION[C('ADMIN_AUTH_KEY')]==true) ? " " : " and role_type in (1,".$role_type.")";
		$properties = M('Properties')->where('to_hide=1'.$role_type_where)->select();/// 取产品属性信息
        $user_info  = getUser();
        if($user_info['role_type'] == C('SELLER_ROLE_TYPE')){
            $this->assign('custom_barcode',isCustomBarcode($user_info['company_id']));
        }
		$this->assign('properties',$properties);
	}

    /// 新增
	public function insert($type='') {
		///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);
		///重新组合POST来的信息
		$info	= $model->setPost($_POST);
		///模型验证
		if ($model->create($info)) {
			$id = $model->relation(true)->add();
			if (false === $id) {
				if($type){
					return L('_ADD_FAILED');
				}else{
					$this->error (L('_ADD_FAILED'));
				}
			}
			$this->id	=	$id;
		} else {
			if($type){
				return $model->getError();
			}else{
				$this->error ( $model->getError(),2);
			}
		}
///		$this->success('OK');
	}

	public function _after_insert($type=''){
		$info['id']	=	$this->id;
		if(!empty($_POST['file_tocken'])){
			D('Gallery')->update($this->id,$_POST['file_tocken']);//更新产品图片关联信息
		}
		$info['_action']	= 'insert';
		tag('Product',$info); // 添加action_init 标签
		$this->checkCacheDd($this->id);
		$this->generateBarcode();
		if($type){
			if($this->_trans == true){
				commit();
				$this->_trans_commit = true;
			}
			return true;
		}else{
			parent::_after_insert();
		}
	}

    /// 修改产品
    public function edit() {
    	///产品自动编号
		//$this->_autoMaxNo();
    	$this->id = $id = intval($_GET['id']);
		if ($id>0) {
			///获取当前Action名称
			$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);
			$this->assign('sid',session_id());
			$this->assign('file_tocken',md5(time()));
			$this->assign('class_level',C('PRODUCT_CLASS_LEVEL'));
			$vo = $model->getInfo($id);
			$model->cacheLockVersion($vo);
			$vo['_action']	= 'edit';
			tag('Product',$vo); /// 添加action_init 标签
			$rate = $model->getRate();
			$role = $model->getRole();
			$this->assign ('rs',$vo);
			$this->assign ('rate',$rate);
			$this->assign ('role',$role);
		}else {
			$this->error(L('_ERROR_'));
		}
    }

    /// 查看产品明细
    public function view(){
    	$id = intval($_GET['id']);
		if ($id>0) {
			///获取当前Action名称
			$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);
			$vo 	= $model->getInfo($id,'view');
			$role = $model->getRole();
			$this->assign ('rs',$vo);
			$this->assign ('role',$role);
		}else {
			$this->error(L('_ERROR_'));
		}
    }

	public function _before_update(){
		$this->_sku		= SOnly('product', $_POST['id'], 'product_no');
		$this->_name	= SOnly('product', $_POST['id'], 'product_name');
	}

    public function update($type='') {
		///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);
		$info	= $model->setPost($info);
		if ($model->create($info)) {
			$r = $model->relation(true)->save();
			if (false === $r) {
				$this->error (L('EDIT_FAILED'));
			}
			$this->checkCacheDd($info['id']);
			$this->id	=	$info['id'];
			$info['_action']	= 'update';
			tag('Product',$info); /// 添加action_init 标签
		} else {
		    if($type){
		        return $model->getError();
		    }else{
		        $this->error ( $model->getError() ,$model->errorStatus);
		    }
		}
	}

	public function _after_update($type='') {
		$this->generateBarcode();//
		if($type){
		    return true;
		}else{
		    parent::_after_update();
		}
	}

	public function index(){
		//点击查询后才显示
		if($_POST){
			if (!empty($this->_default_post)) {
				foreach ((array)$this->_default_post as $key => $value) {
					if (!isset($_POST['main'][$key])) {
						$_POST['main'][$key]	= $value;
					} //else {
						//$_POST['main'][$key]  = array_merge((array)$_POST['main'][$key], (array)$value);
					//}
				}
			}
			/// 设置查询条件
			if (isset($_POST['pics'])) {
				if($_POST['pics']==1){
					$_POST['gallery']['query']['id'] = 'is not null';
				}elseif ($_POST['pics']==0){
					$_POST['gallery']['query']['id'] = 'is null';
				}
			}
			///获取当前Action名称
			$name = $this->getActionName();
			///获取当前模型
			$model 	= D($name);
			//$this->list = $model->getIndexList();
			$result = $model->getIndexList();
//			^(-)?\d+(\.\d*([1-9]))?$
		    foreach($result['list'] as &$val){
					$val['s_weight'] = str_replace('.00','',$val['s_weight']);
					$val['s_check_weight'] = str_replace('.00','',$val['s_check_weight']);
                    $val['s_volume_weight'] = str_replace('.00','',$val['s_volume_weight']);
				}
//				 $pattern ='^\.[0]{2}$';
//				 $replacement = '';
//				= preg_replace($pattern,$replacement,$val['s_weight'])
			unset($val);
			$this->list=$result;
		}
		$this->_admin	= dump($this->admin, false);
		getOutPutRand();
		if ($_POST['search_form']) {
			$this->display ('list');
		}else {
			$this->display ();
		}
    }

    public function delete() {
    	///还原特殊处理 mingxing
    	if ($_GET['restore']==1){
    		$this->restore();
    	}else{
			///获取当前Action名称
			$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);
			$pk		= $model->getPk ();
	    	$id 	= intval($_REQUEST[$pk]);
	    	$condition	=	'id='.$id;
	    	$this->id = $id;
	    	$list	=	$model->where($condition)->setField('to_hide',2);
			if (false === $list) {
				$this->error ( L('DELETE_FAILED') );
			}
		}
	}

	///还原
    public function restore($id=null){
    	///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);
		///当前主键
		$pk		=	$model->getPk();
		$id 	= 	$id ? intval($id) : intval($_REQUEST[$pk]);
		$this->id = $id;
		if ($id>0) {
			///更新条件
			$condition 	= $pk.'='.$id;
			///执行条件语句
			$list		= $model->where( $condition )->setField('to_hide',1);
			///如果产品还原失败提示失败
			if ($list==false) {
				$this->error(L('_ERROR_'));
			}
		}else{
			$this->error(L('_ERROR_'));
		}
    }

	/**
	 * 创建条形码
	 * @author jph 20140227
	 * @param type $code 产品id
	 * @param type $sku  产品编号
	 * @param type $product_name 产品名称
	 * @param type $product_barcode_config 配置
	 */
	public function generateBarcode($code = null, $sku = null, $product_name = null, $product_barcode_config = null){
		$module_name 	= 'Product';
		if (is_null($code)) {
            $code   = M($module_name)->where('id='.$this->id)->getField('custom_barcode');
		}
        //分离文字和条码 edit yyh 20151201
//		if (is_null($product_barcode_config)) {
//			$product				= M($module_name)->alias('p')->field('p.product_no,p.product_name,c.product_barcode_config')->join('__COMPANY__ c on c.id=p.factory_id')->where('p.id='.$this->id)->find();
//			$sku					= $product['product_no'];
//			$product_name			= $product['product_name'];
//			$product_barcode_config	= $product['product_barcode_config'] ? explode(',', $product['product_barcode_config']) : array();
//		} elseif (!is_array($product_barcode_config)) {
//			$product_barcode_config	= $product_barcode_config ? explode(',', $product_barcode_config) : array();
//		}
		if (is_null($sku)) {
			$sku			= SOnly('product', $this->id, 'product_no');
		}
		if (is_null($product_name)) {
			$product_name	= SOnly('product', $this->id, 'product_name');
		}

		$path			= BARCODE_PATH . ucfirst($module_name);
//		$filename		= $path . '/' . $this->id . '.' . C('BARCODE_PC_TYPE');
//		$barcode_config	= array('file_name'=>$this->id);
//		if ($sku != $this->_sku || $product_name != $this->_name || !file_exists($filename)) {
			$hri	= array(
//              'code'          => $code,
//				'product_name'	=> '   ' . $product_name,
//				'sku'			=> $sku,
			);
			$wrap	= true;
            //分离文字和条码 edit yyh 20151201
//			if ($product_barcode_config) {
//				$product_barcode_config_filter	= array();
//				if (in_array('product_name', $product_barcode_config)) {
//					$wrap	= false;
//					$product_barcode_config_filter[]	= 'product_name';
//				} else {
//					unset($hri['product_name']);
//				}
//				if (isset($hri['sku']) && in_array('made_in_china', $product_barcode_config)) {
//					$hri['sku']	.= '   ' . L('made_in_china');
//					$product_barcode_config_filter[]	= 'made_in_china';
//				}
//				foreach ($product_barcode_config as $config) {
//					if (!in_array($config, $product_barcode_config_filter)) {
//						$hri[$config]	= isset($product[$config]) ? $product[$config] : L($config);
//					}
//				}
//			} else {
//				unset($hri['product_name']);
//			}
//			generateBarcode($code, $path, $hri, $barcode_config, $wrap);
//            $barcode_config = array(
//                            'pc_height'	=> 100,
//							'pc_width'	=> 300,
//							'y'			=> 35,	// barcode center
//							'height'	=> 50,	// 高度
//							'width'		=> 2,	// 宽度
//							'angle'		=> 0,	//旋转角度.
//							'fontSize'	=> 8,   // 标签字体大小 GD1 in px ; GD2 in point
//                            );
            $barcode_config	= array(
                        'w'            => 100,     //画布宽度
                        'h'            => 43,      //画布高度
                        'thickness'    => 30,      //条形码高度
            );
            $name   = array('name'=>  $this->id,'code'=>$code);
            createBarcodeImg($name,$path,$barcode_config,$hri);
//		}
	}
}