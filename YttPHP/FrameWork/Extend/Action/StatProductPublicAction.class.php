<?php

/**
 * 产品详细信息
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category    统计
 * @package		Action
 * @author      何剑波
 * @version  2.1,2013-07-22
 */

class StatProductPublicAction extends RelationCommonAction  {
    public function __construct() {
        parent::__construct();
        if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
            $_POST['factory_id']   = getUser('company_id');
        }
    }

	public function index(){
			$this->display();
	}
	
	/// 产品详细信息(明细)
	public function view() {
		$model			= D($this->getActionName());
		$product_id		= intval($_GET['product_id'] > 0 ? $_GET['product_id'] : M('Product')->where(getWhere($_POST))->getField('id'));
		/// 基本信息
		$basic_info		= $model->getBasicInfo($product_id);
		/// 经营异动信息
		$run_info		= $model->getRunInfo($product_id);	
		///　库存信息	
		$storage_info	= $model->getStorageInfo($product_id);	
		/// 权限处理
		$rights			= array(
            'onroad' => 1,          //在途
            'instock' => 1,         //发货
            'return' => 1 ,         //退货
            'returnStorage' => 1,   //退货入库
            'adjust' => 1,          //库存调整
			'shiftwarehouse' => 1,  //移仓调整
            'sale' => 1,            //销售
            'outStock'=>1,          //发货数量
            'undeal'=>1,            //未分配数量
            'Backshelves'=>1,       //重新上架数量
            );
		if (C('rights_level') == 3) { /// 普能用户
			$all_rights  = RBAC::getModuleAccessList(USER_ID,'StatProduct');	
			$all_rights	 = array_keys($all_rights['STATPRODUCT']);
			if (!empty($all_rights)) {				
				if (!in_array('PRODUCTINSTOCK',$all_rights)) {	/// 进货数量				
					$rights['instock'] = 0;
				}
				if (!in_array('PRODUCTADJUST', $all_rights)) {  /// 调速数量
					$rights['adjust'] = 0;
				}
				if (!in_array('PRODUCTSHIFTWAREHOUSE', $all_rights)) {  /// 移仓数量
					$rights['shiftwarehouse'] = 0;
				}
				if (!in_array('PRODUCTSALE', $all_rights)) {  /// 销售数量
					$rights['sale'] = 0;
				}
				
				if (!in_array('PRODUCTSTORAGE', $all_rights)) { /// 查看库存
					$rights['storage'] = 0;
				}
				if(!in_array('PRODUCTSTORAGEINI',$all_rights)){
					$rights['inistorage']=0;
				}
				if(!in_array('PRODUCTRETURN',$all_rights)){
					$rights['return']=0;
				}
				if(!in_array('PRODUCTDELIVERY',$all_rights)){
					$rights['delivery']=0;
				}
			} else {
				$rights		= array('instock' => 0, 'sale' => 0, 'adjust' => 0, 'shiftwarehouse' => 0, 'sale_price' => 0, 'instock_price' => 0, 'storage' => 0,'inistorage'=>0,'return'=>0,'delivery'=>0);
			}
		}
		$this->assign ("basic_info", $basic_info);
		$this->assign ("run_info", $run_info);
		$this->assign ("storage_info", $storage_info);
		$this->assign ("id", $product_id);
		$this->assign ("rights", $rights);
		$this->display('list');
	}
	
	///查看进货数量
	public function Detail(){
		$list		=  D('StatProduct')->getDetail();
		$this->assign('list', $list);
		$this->assign('page', $list['page']);
		$this->display('productDetail');
	}
    
	public function productDetail(){
//        $fun    = 'product'.$_GET['type'];
//        $this->$fun();
        $this->Detail();
	}

//    ///在途库存
//    public function productOnroad(){
//		$this->Detail();
//    }    
}