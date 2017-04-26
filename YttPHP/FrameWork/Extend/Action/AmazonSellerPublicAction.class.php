<?php
/**
 * 亚马逊类控制器
 *
 * @copyright   Copyright (c) 2006 - 2016 Union Top 展联软件友拓通
 * @category    基本信息
 * @package		Model
 * @author		何剑波
 * @version		2.1,2014-09-04
 */

class AmazonSellerPublicAction extends BasicCommonAction {

	public function __construct(){	
		parent::__construct();
		import("ORG.Util.AmazonSeller"); 
		if($_GET['user_id'] || $_POST['user_id']){
			$user_id	 = $_GET['user_id'] ? $_GET['user_id'] : $_POST['user_id'];
			$this->AmazonSeller = new AmazonSeller($user_id);
		}else{
			$this->AmazonSeller = new AmazonSeller();
		}
	}

	// 抓取订单列表
	public function getOrders() {
		set_time_limit(0);
		if($_REQUEST['user_id']){
			$ItemID		  = trim($_REQUEST['ItemID']);
			if($ItemID!=''){
				$this->getOrdersByOrderNo();
			}
			$this->AmazonSeller->getOrdersListNew();
			$return_note = $this->AmazonSeller->getReturnNote();
		}else{
			$return_note = '请输入正确的参数!';
		}
		echo $return_note;
		exit;
	}

	//根据订单号抓取订单
	public function getOrdersByOrderNo(){
		set_time_limit(0);
		if($_REQUEST['user_id']){
			$ItemID		  = trim(specConvertStr($_POST['ItemID'],';'));
			$ItemID		  = array_values(array_unique(explode(';',$ItemID)));
			$ItemID_count = count($ItemID);
			if ($ItemID_count>=1 && $ItemID_count<=50) {
				$this->AmazonSeller->getOrderNew($_POST,$ItemID);
				$return_note = $this->AmazonSeller->getReturnNote();
			}elseif($ItemID_count>50){
				$return_note = '一次只能抓取50条的订单号!';
			}
		}else{
			$return_note = '请输入正确的参数!';
		}
		echo $return_note;
		exit;
	}
}
?>