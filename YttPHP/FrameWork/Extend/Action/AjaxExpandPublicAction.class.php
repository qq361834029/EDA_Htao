<?php
/**
 * 列表展开类
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	列表展开类
 * @package  	Action
 * @version 	2013-09-23
 * @author    	何剑波
 */
class AjaxExpandPublicAction extends CommonAction {
	/// 取产品类别
	public function getProductClassList() { 
		$id	= $_POST['id'];
		$model	= D('ProductClassView');
		$info	= $model->find($id); 
		$class_id 	= intval($id);
		$class_level	= intval($info['class_level']);
		$show_id 		= trim($_POST['show_id']);
		if ($class_id>0) {
///			$this->module_access = $_SESSION['_MODULE_ACCESS_'] = RBAC::getModuleAccessList(USER_ID,'ProductClass');
	  		$list = $model->getExpandProductClassList($class_id,$class_level);
			/// 构造列表展开所需的数据
			$show	= array(
				array('value'=>'class_no','title'=>L('class_no'),'width'=>'40%'),
				array('value'=>'class_name','title'=>L('class_name'),'width'=>'40%')
			);
			$info	= array(
				'show'=>$show,
				'from'=>$list,
			); 
			if (($class_level+1)<C('PRODUCT_CLASS_LEVEL')) {
				$this->assign('expand',true);
				$this->assign('expandAction','getProductClassList');
			}
			$this->assign('table_attr','id="index_expand_'.($class_level+1).'" class="list" border=1');
			$this->assign('tr_attr',array('id'=>'expand_'.($class_level+1)));  
			$this->assign('list',$list['list']);
			$this->display();
		}
	}
	///获取展开城市
	public function getDistrictList(){
		$id 	 = intval($_POST['id']);///国家ID
		$to_hide = intval($_POST['query']['b.to_hide']);
		if ($id > 0 ) {	
///			$this->module_access = $_SESSION['_MODULE_ACCESS_'] = RBAC::getModuleAccessList(USER_ID,'District');	 
			$where	=	'parent_id='.intval($id);
		 	if (!empty($_POST['like']['b.district_name'])) {
		 		$where	.=' and district_name like "%'.$_POST['like']['b.district_name'].'%" ';	
		 	}
		 	if ($to_hide>0) {	
		 		$where	.=' and to_hide='.$to_hide.' '; 	
		 	}
		 	$list	= M('District')->where($where)->group('id')->select();
		 	$list 	= _formatList($list);
		 	$this->assign('list',$list);
		 	$class_level	= 0;
		 	$this->assign('table_attr','id="index_expand_'.($class_level+1).'" class="list" border=1');
			$this->assign('tr_attr',array('id'=>'expand_'.($class_level+1))); 
		 	$this->display();
		}
	}

	/// 取实际库存按类别查看产品信息
	public function getRealStorageByProducts() { 
		$_POST['query']['class_1']	= $_POST['id'];
		if ($_POST['query']['class_1']>0) {
			$model	= D('StorageShow');
	  		$list = $model->getRealStorage();
			$this->assign('list',$list);
			$this->display();
		}
	}

	/// 取可销售库存按类别查看产品信息
	public function getSaleStorageByProducts() { 
		$_POST['query']['class_1']	= $_POST['id'];
		if ($_POST['query']['class_1']>0) {
			$model	= D('StorageShow');
	  		$list = $model->getSaleStorage();
			$this->assign('list',$list);
			$this->display();
		}
	}
	public function getClientStatSaleDetail(){
            $id     = intval($_POST['id']);
            $list   = M('sale_order_detail')
                    ->join('left join delivery_detail on sale_order_detail.id=delivery_detail.sale_order_detail_id')
                    ->join('sale_order on sale_order.id=sale_order_detail.sale_order_id')
                    ->field('
                        sale_order_detail.product_id,sale_order_detail.color_id,sale_order_detail.size_id,sale_order_detail.warehouse_id,sale_order_detail.sale_order_id,ifnull(delivery_detail.id,0) as delivery_detail_id,
                        if(delivery_detail.id>0,delivery_detail.quantity,sale_order_detail.quantity) as quantity,
                        if(delivery_detail.id>0,delivery_detail.capability,sale_order_detail.capability) as capability,
                        if(delivery_detail.id>0,delivery_detail.dozen,sale_order_detail.dozen) as dozen,
                        if(delivery_detail.id>0,delivery_detail.price,sale_order_detail.price) as price,
                        if(delivery_detail.id>0,delivery_detail.discount,sale_order_detail.discount) as discount,
                        sale_order.currency_id')
                    ->where('sale_order_detail.sale_order_id='.$id)->order('delivery_detail.id desc')->select();
			
			foreach($list as $key=>$val){
				///判断是否有发货，只要有发货记录则只显示发货的销售明细，不显示销售单的销售明细
				if(!isset($delivery_sale_order_list['sale_order_id']) && $val['delivery_detail_id']>0){
					$delivery_sale_order_list[$val['sale_order_id']] = true;
				}
				if($val['quantity']==0 || ($delivery_sale_order_list[$val['sale_order_id']] && $val['delivery_detail_id'] == 0)){
					unset($list[$key]);
					continue;
				}
				$list[$key]['sum_qua']  = $val['quantity'];
				$list[$key]['sum_cap']  = $val['sum_cap'];
				$list[$key]['sum_quantity']		= $val['quantity']*$val['capability']*$val['dozen'];
				$list[$key]['money']			= $val['quantity']*$val['capability']*$val['dozen']*$val['price'];
				$list[$key]['discount_money']	= $val['quantity']*$val['capability']*$val['dozen']*$val['price']*$val['discount'];
				$list[$key]['discount']			= (1-$val['discount'])*100;
			}
			$list   = _formatList($list);
			$list['main']   = M('sale_order')->find($id);
			$list['main']['account_money']  = $list['total']['discount_money']-$list['main']['pr_money'];
			$list['main']   = _formatArray($list['main']);
			$this->assign('list',$list);
			$this->display();
        }
}