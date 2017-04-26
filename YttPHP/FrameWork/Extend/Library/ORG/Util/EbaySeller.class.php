<?php
require_once 'setincludepath.php';
require_once 'EbatNs_Environment.php';

class EbaySeller extends EbatNs_Environment
{
    protected $user_id		   = '';
    protected $site_id		   = '';
	protected $ebayToken	   = '';
	protected $factory_id      = '';
	protected $abbr_country    = array();
	protected $abbr_country_id = array();
	protected $return_note     = array();
	protected $country_range   = 1;
	protected $country_select  = array();

	function __construct($user_id='dev',$site_id=77){
		$this->user_id = $user_id;
		$this->site_id = $site_id;
		//date_default_timezone_set('Europe/London'); //把时区设置成标准时间
		import("ORG.Util.EbayToken"); 
		$this->ebayToken = $ebayToken = new ModelEbayToken($this->user_id);
		parent::__construct(0,$this->user_id.'-'.$this->site_id);
		
		$ebay_info = M('ebay_site')->where('user_id=\''.$this->user_id.'\'')->field('factory_id,id,country_range')->find();
		$this->factory_id		= $ebay_info['factory_id'];
		$this->country_range	= $ebay_info['country_range'];
		if(intval($this->factory_id)>0){
			$tmp_abbr_country = S('country');
			if($ebay_info['country_range'] == 2){
				$this->country_select = M('ebay_country')->where('ebay_site_id=\''.$ebay_info['id'].'\'')->getField('abbr_district_name',true);
			}
			if(is_array($tmp_abbr_country)&&$tmp_abbr_country){
				foreach($tmp_abbr_country as $country_key=>$country_val){
					$abbr_country[$country_val['abbr_district_name']]	 = $country_val['district_name'];
					$abbr_country_id[$country_val['abbr_district_name']] = $country_key;
				}
				$this->abbr_country	   = $abbr_country;
				$this->abbr_country_id = $abbr_country_id;
			}
		}
	}

	//获取销售单
	public function getOldSaleList($info){
		$param	= $this->getSellerTransactions($info);
		if($param==17470){
			return 17470;
		}
		//返回数据成功
		if($param->TransactionArray){
			$PageNumber				= $param->PageNumber;
			$ItemsPerPage			= $param->TransactionsPerPage;
			$ReturnedItemCountActual= $param->ReturnedTransactionCountActual;
			$TotalNumberOfPages		= $param->PaginationResult->TotalNumberOfPages;
			$TotalNumberOfEntries	= $param->PaginationResult->TotalNumberOfEntries;
			$this->setReturnNote('共抓到有'.$TotalNumberOfPages.'页记录,每页'.$ItemsPerPage.'条记录，共'.$TotalNumberOfEntries.'条记录。目前在抓取第'.$PageNumber.'页数量。本页共有'.$ReturnedItemCountActual.'条记录<br>','Sale');
			foreach ($param->TransactionArray as &$value){
				$this->saveClientOrder($value);
			}
			unset($param);
			$PageNumber++;
			if($PageNumber <= $TotalNumberOfPages){
				$info['pageno'] = $PageNumber;
				$this->getOldSaleList($info);
			}
			return true;
		}else{
			return false;
		}
	}
    
	//获取交易数据
    public function getSellerTransactions($info){
    	require_once 'GetSellerTransactionsRequestType.php';
        $req = new GetSellerTransactionsRequestType();
		date_default_timezone_set('Europe/London');
        $from_date	= date("Y-m-d H:i:s",strtotime('-'.$info['from_time'].$info['time_type']));
		$to_date	= date("Y-m-d H:i:s");
		date_default_timezone_set(C('SALE_TIMEZONE'));
        $req->setModTimeFrom($from_date);
		$req->setModTimeto($to_date);
		$pagination = new PaginationType();
        $pagination->setEntriesPerPage(C('EBAY_ENTRIES_PRE_PAGE'));
        if(empty($info['pageno'])){
        	$info['pageno'] = 1;
        }
		$req->setDetailLevel("ReturnAll");
        $pagination->setPageNumber($info['pageno']);
        $req->setPagination($pagination);
    
        $res = $this->proxy->GetSellerTransactions($req);
        if ($this->testValid($res)){
            return $res;
        }else{
        	$content = $this->proxy->getErrorsToString($res, true);
            if($res->Errors[0]->ErrorCode == 17470){
				$this->auth_fail();
				return 17470;
			}
			return false;
        }
    }

	/**
     * 获取交易数据
     *
     * @param array $info
     * @return array | boolean
     */
    public function getOrders($info)
    {
    	require_once 'GetOrdersRequestType.php';
        $req = new GetOrdersRequestType();
		//下单日期
		date_default_timezone_set('Europe/London');
        $from_date	= date("Y-m-d H:i:s",strtotime('-'.$info['from_time'].$info['time_type']));
		$to_date	= date("Y-m-d H:i:s");
		date_default_timezone_set(C('SALE_TIMEZONE'));
        $req->setCreateTimeFrom($from_date);
		$req->setCreateTimeTo($to_date);
		$pagination = new PaginationType();
        $pagination->setEntriesPerPage(C('EBAY_ENTRIES_PRE_PAGE'));
        if(empty($info['pageno'])){
        	$info['pageno'] = 1;
        }
        $pagination->setPageNumber($info['pageno']);
        $req->setPagination($pagination);
        $res = $this->proxy->GetOrders($req);
		//pr($res,'$res');
        if ($this->testValid($res))
        {
            return $res;
        }
        else 
        {
        	$content = $this->proxy->getErrorsToString($res, true);
            if(APP_DEBUG){
				pr($res,'$res');			
				echo $content;
			}
            if($res->Errors[0]->ErrorCode == 17470){
				$this->auth_fail();
			}
			return false;
        }
    }

	/**
     * 获取销售单
     *
     * @param array $info
     * @return boolean
     */
	public function getOldOrderList($info){
		$param	= $this->getOrders($info);
		//返回数据成功
		if($param->OrderArray){
			$order_count = 0;
			$error_count = 0;
			if(APP_DEBUG){
				pr($param,'$param');
			}
                        //构建列表数组
			foreach ($param->OrderArray as $key => $value){
				$return_id = $this->saveClientOrder($value);
				if($return_id>0){
					$order_count++;
				}else{
					$error_count++;
				}
			}
			
			$PageNumber				= $param->PageNumber;
			$ItemsPerPage			= $param->OrdersPerPage;
			$ReturnedItemCountActual= $param->ReturnedOrderCountActual;
			$TotalNumberOfPages		= $param->PaginationResult->TotalNumberOfPages;
			$TotalNumberOfEntries	= $param->PaginationResult->TotalNumberOfEntries;
			$this->setReturnNote('共抓到有'.$TotalNumberOfPages.'页记录,每页'.$ItemsPerPage.'条记录，共'.$TotalNumberOfEntries.'条记录。目前在抓取第'.$PageNumber.'页数量。本页共有'.$ReturnedItemCountActual.'条记录,成功导入'.$order_count.'条记录,导入失败'.$error_count.'条记录<br>','Order');

			unset($param);
			$PageNumber++;
			if($PageNumber <= $TotalNumberOfPages){
				$info['pageno'] = $PageNumber;
				$this->getOldOrderList($info);
			}
			return true;
		}else{
			return false;
		}
	}

	/**
     * 获取单个ITEM的交易数据
     *
     * @param array $info
     * @return array | boolean
     */
    public function getItemTransactions($info){
    	require_once 'GetItemTransactionsRequestType.php';
    	$req = new GetItemTransactionsRequestType();
		$req->setItemID($info['ItemID']);
		
		// 交易数据可能大于100条，取最后100条
		$pagination = new PaginationType();
        $pagination->setEntriesPerPage(C('EBAY_ENTRIES_PRE_PAGE'));
        if(empty($info['pageno'])){
        	$info['pageno'] = 1;
        }
        $pagination->setPageNumber($info['pageno']);
        $req->setPagination($pagination);
		//取最近的3周内修改的数据
	 	$old_date = date("Y-m-d H:i:s",strtotime("-15 days"));
	 	$to_date  = date('Y-m-d H:i:s',strtotime("+5 minutes"));
        $req->setModTimeFrom($old_date);
		$req->setModTimeto($to_date);
		
		// 交易ID
		if($info['TransactionID']){
			 $req->setTransactionID($info['TransactionID']);
		}
        $res = $this->proxy->GetItemTransactions($req);
        if ($this->testValid($res)){
            return $res;
        }else{
			if(APP_DEBUG){
				$content = $this->proxy->getErrorsToString($res, true);
				pr($res,'$res');			
				echo $content;
			}
            if($res->Errors[0]->ErrorCode == 17470){
				$this->auth_fail();
				return 17470;
			}
			return false;
        }
    }

	/**
     * //获取销售情况
     *
     * @param array $info
     * @return boolean
     */
    public function getTransactionsByItem($info){
		$param_sale	= $this->getItemTransactions($info);
		if($param_sale==17470){
			return 17470;
		}
		if(APP_DEBUG){
			Pr($param_sale,'$param_sale');
		}
		if($param_sale->TransactionArray){
			$PageNumber				= $param_sale->PageNumber;
			$ItemsPerPage			= $param_sale->TransactionsPerPage;
			$ReturnedItemCountActual= $param_sale->ReturnedTransactionCountActual;
			$TotalNumberOfPages		= $param_sale->PaginationResult->TotalNumberOfPages;
			$TotalNumberOfEntries	= $param_sale->PaginationResult->TotalNumberOfEntries;
			$this->setReturnNote('共抓到有'.$TotalNumberOfPages.'页记录,每页'.$ItemsPerPage.'条记录，共'.$TotalNumberOfEntries.'条记录。目前在抓取第'.$PageNumber.'页数量。本页共有'.$ReturnedItemCountActual.'条记录<br>','TransactionsByItem');
			//构建列表数组
			foreach ($param_sale->TransactionArray as $key => $value){
				//保存销售单数据
				$this->saveClientOrder($value,$param_sale->Item);
			}
			unset($param_sale);
			$PageNumber++;
			if($PageNumber <= $TotalNumberOfPages){
				$info['pageno'] = $PageNumber;
				$this->getTransactionsByItem($info);
			}
			return true;
		}
		return false;
	}

	 //构建并保存EBAY客户数据
	 public function saveClientOrder(&$order,$item_id_object=null){
		if($item_id_object){
			$TransactionArray	= array();
			$TransactionArray[0]= $order;
			$order_no			= $order->OrderLineItemID;
			$transaction_id		= $TransactionArray[0]->TransactionID;
			if($transaction_id == 0){
				$transaction_id = $TransactionArray[0]->Item->ItemID;
			}
			$Buyer				= $TransactionArray[0]->Buyer;
			$ShippingAddress	= $Buyer->BuyerInfo->ShippingAddress;
			$comp_name			= $Buyer->UserID;
			$status				= $order->Status->CompleteStatus;
			$order_date			= date("Y-m-d",strtotime($order->CreatedDate));
		}else{
			$order_no = $order->OrderID;
			$TransactionArray	= $order->TransactionArray;
			$transaction_id		= $TransactionArray[0]->TransactionID;
			if($transaction_id == 0){
				$transaction_id = $TransactionArray[0]->Item->ItemID;
			}
			$Buyer				= $TransactionArray[0]->Buyer;
			$ShippingAddress	= $order->ShippingAddress;
			$comp_name			= $order->BuyerUserID;
			$status				= $order->CheckoutStatus->Status;
			$order_date			= date("Y-m-d",strtotime($order->CreatedTime));
		}
		$attr_district		= $ShippingAddress->Country;
		///满足以下条件的订单才继续处理 1.订单付款状态已经完成、2.账号如果有国家限制，则必须在国家所选择的范围之内、3订单还没有保存到系统中
		if($this->checkExist(array('transaction_id'=>$order_no))>0 || $status !='Complete' || ($this->country_range == 2  && !in_array($attr_district,$this->country_select))){
			return false;
		}else{
			//客户信息
			$data[$order_no]['addition'][1]['comp_name']  = $comp_name; 
			$data[$order_no]['addition'][1]['factory_id'] = $this->factory_id;
			$data[$order_no]['addition'][1]['comp_type']  = 2;//Ebay客户
			$data[$order_no]['addition'][1]['address']    = $ShippingAddress->Street1; 
			$data[$order_no]['addition'][1]['address2']   = $ShippingAddress->Street2; 
			$data[$order_no]['addition'][1]['post_code']  = $ShippingAddress->PostalCode; 
			$data[$order_no]['addition'][1]['city_name']  = $ShippingAddress->CityName; 
			$data[$order_no]['addition'][1]['company_name'] = $ShippingAddress->StateOrProvince; 
			$data[$order_no]['addition'][1]['country_name']= $ShippingAddress->CountryName;//$this->abbr_country[$attr_district]; 
			$data[$order_no]['addition'][1]['country_id'] = $this->abbr_country_id[$attr_district]; 
			$data[$order_no]['addition'][1]['email']	  = $Buyer->Email=='Invalid Request' ? '' : $Buyer->Email; 
			$data[$order_no]['addition'][1]['mobile']	  = $ShippingAddress->Phone <> 'Invalid Request' ? $ShippingAddress->Phone : ''; 
			$data[$order_no]['addition'][1]['consignee']  = $ShippingAddress->Name;
			//保存EBAY销售
			$Client						  = D('Client');
			$data[$order_no]['client_id'] = $Client->externalSaveClient($data[$order_no]['addition'][1]);
			unset($Client);
		}
		//主表
		$data[$order_no]['factory_id']			= $this->factory_id;
		$data[$order_no]['other_type_user_id']  = $this->user_id;
		$data[$order_no]['transaction_id']		= $order_no;
		$data[$order_no]['order_no']			= $transaction_id;
		$data[$order_no]['order_date']			= $order_date;
		$data[$order_no]['order_type']			= 2;
		$data[$order_no]['warehouse_id']		= 0;
		$data[$order_no]['sale_order_state']	= 2;
		///标示数据来源为自动抓取
		$data[$order_no]['from_type']			= 'automatisch';
		foreach($TransactionArray as $key => &$transation){
			//获取产品ID
			if(is_array($transation->Variation->VariationSpecifics)){
				$sku		= $transation->Variation->SKU;
			}else{
				$sku		= $transation->Item->SKU;
			}
			$sku	= ($sku==NULL)? '':$sku;
			$product_id = $this->getProductId(array("sku" => $sku,'factory_id' => $this->factory_id));
			//明细表
			$data[$order_no]['detail'][$key+1]['quantity']			= $transation->QuantityPurchased;
			$data[$order_no]['detail'][$key+1]['product_id']		= $product_id;
			$data[$order_no]['detail'][$key+1]['import_sku']		= $sku;
			$data[$order_no]['detail'][$key+1]['warehouse_id']		= 0;
			$data[$order_no]['detail'][$key+1]['transaction_id']	= $transation->TransactionID;
		}
		$SaleOrder	  = D('SaleOrder');
		$check_info	  = $SaleOrder->create($data[$order_no]);
		unset($data,$order);
		if(false!==$check_info) {          
			startTrans();
			$result = $SaleOrder->relation(true)->add();
			if ($result > 0) {
				commit();
				A('SaleOrder')->generateBarcode($result);
				return true;
			}else{
				rollback();
				return false;
			}
		}
	 }

	//获取API授权规则
    public function getApiAccessRules()
    {
    	require_once 'GetApiAccessRulesRequestType.php';
        $req = new GetApiAccessRulesRequestType();
        $res = $this->proxy->GetApiAccessRules($req);
		Pr($res);
        if ($this->testValid($res)) {
            return $res;
        }else{
        	//如果该ITEM_ID超出90天则不能抓取。隐藏不正常数据
        	if($res->Errors[0]->ErrorCode == 17){
        		//$this->updateEbayDiffer($info['ItemID']);
        		return 17;
        	}else{
        		$content = $this->proxy->getErrorsToString($res, true);
        		if($res->Errors[0]->ErrorCode == 17470){
					$this->auth_fail();
				}
			}
            return false;
        }
    }
 	
	public function checkExist($array) {
		extract($array);
		$id = M('sale_order')->where('order_type=2 and transaction_id=\''.$transaction_id.'\'')->getField('id');
		if($id <= 0){
			$id = M('sale_order_del')->where('order_type=2 and transaction_id=\''.$transaction_id.'\'')->getField('id');
		}
		return $id;
	}
	
	// 获取产品ID
	public function getProductId($info) {
		$product_no	= trim($info['sku']);
		$factory_id = intval($info['factory_id']);
		$p_id	    = M('product')->where('factory_id='.$factory_id.' and product_no=\''.$product_no.'\'')->getField('id');
		if(!$p_id > 0){
			$p_id	= M('ProductSku')->where('factory_id='.$factory_id.' and sku=\''.$product_no.'\'')->getField('product_id');
		}
		return $p_id > 0 ? $p_id : false;
	}

	public function setDifferProducts($info) {
		extract($info);		
		$update_sql = 'update sale_order_differ_product 
					   set `to_hide`=2 
					   where object_type=2 and item_id=\''.$item_id.'\'';
		return M('sale_order_differ_product')->execute($update_sql); 
	}
	
	public function saveDifferProducts($info, $type=2){
		$sale_order_differ_product = M('sale_order_differ_product');
		$id = $sale_order_differ_product->where('item_id=\''.$info['item_id'].'\' and object_type='.$type)->getField('id');
		if(intval($id)>0)
			return false;
		$insert_array	  = array(
							    'item_id' 	  => $info['item_id'],													
								'title' 	  => $info['title'],
								'user_id' 	  => $info['user_id'],
								'site_id'	  => $info['site_id'],
								'object_type' => $type,
								'sku'		  => $info['sku'],
								'to_hide'	  => $info['to_hide'],
		);
		$rs = $sale_order_differ_product->add($insert_array); 
		unset($insert_array);
		return $rs;
    }

	function setReturnNote($note,$return_key,$is_new = 0){
		if($is_new == 1){
			$this->return_note[$return_key] = '';
		}
		$this->return_note[$return_key][] = $note;
	}

	function getReturnNote($return_key = ''){
		if($key){
			return implode('',$this->return_note[$return_key]);
		}else{
			foreach($this->return_note as $value){
				$result_info .= implode('',$value);
			}
			return $result_info;
		}
	}

	//删除当前授权文件及自动抓取的文件，并提示用户重新授权
	public function auth_fail(){
		$this->ebayToken->deleteFile(); 
	}
}
?>
