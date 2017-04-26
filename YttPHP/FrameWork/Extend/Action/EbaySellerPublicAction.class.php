<?php

class EbaySellerPublicAction extends BasicCommonAction {
	function __construct(){
		parent::__construct();
		import("ORG.Util.EbaySeller"); 
		if($_GET['user_id'] || $_POST['user_id']){
			$user_id = $_GET['user_id'] ? $_GET['user_id'] : $_POST['user_id'];
			$site_id = $_GET['site_id'] ? $_GET['site_id'] : $_POST['site_id'];
			$this->EbaySeller = new EbaySeller($user_id,$site_id);
		}else{
			$this->EbaySeller = new EbaySeller();
		}
	}	

	//查看Ebay调用次数限制
	function getApiAccessRules(){
		$this->EbaySeller->getApiAccessRules();
	}

	//AJAX获取交易数据
	function ajaxOldSale(){
		set_time_limit(0);
		if($_REQUEST['user_id'] && $_REQUEST['site_id']){
			if($_REQUEST['ItemID']){
				$return_bool = $this->EbaySeller->getTransactionsByItem($_REQUEST);
			}else{
				$return_bool = $this->EbaySeller->getOldOrderList($_REQUEST);
			}
			if($return_bool===17470){
				$this->notice();
			}
			if ($return_bool){
				$return_note = $this->EbaySeller->getReturnNote();
			}else{
				$return_note = L('no_data_please_expand_time');
			}
		}else{
			$return_note = L('please_enter_the_correct_parameters');
		}
		echo $return_note;
		exit;
	}
	
	function notice(){
		$return_note = 'Ebay Token过期';
		echo $return_note;
		exit;
	}
}
?>