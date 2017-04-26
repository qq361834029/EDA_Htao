<?php

require_once 'config.php';
class AmazonSeller { 
	public $report_url; // 取库存报告的URL
	public $order_url;  // 取订单的URL	
	public $amazon_token_path;
	public $amazon_tasks_path;
	public $user_id;
	public $factory_id;
	public $AWS_ACCESS_KEY_ID;
	public $AWS_SECRET_ACCESS_KEY;
	public $APPLICATION_NAME;
	public $APPLICATION_VERSION;
	public $MERCHANT_ID;
	public $MARKETPLACE_ID;
	protected $return_note     = array();

	public $config = array ( 
	   'ServiceURL'    => '',
	   'ProxyHost'     => null,
	   'ProxyPort'     => -1,
	   'MaxErrorRetry' => 3,
 	); 	
	
	public function __construct($user_id=''){
		$this->amazon_token_path = dirname($_SERVER['SCRIPT_FILENAME']).'/Conf/data/amazon/';
		$this->amazon_tasks_path = dirname($_SERVER['SCRIPT_FILENAME']).'/Conf/timer/amazon/';
		if($user_id!=''){
			$this->user_id	     = $user_id;
			$this->factory_id    = M('amazon_site')->where('user_id=\''.$this->user_id.'\'')->getField('factory_id');
			if(intval($this->factory_id)>0&&is_file($this->amazon_token_path.$this->user_id.'.php')){
				require_once $this->amazon_token_path.$this->user_id.'.php';
				$this->report_url				= $report_url;
				$this->order_url				= $order_url;
				$this->AWS_ACCESS_KEY_ID		= $AWS_ACCESS_KEY_ID;
				$this->AWS_SECRET_ACCESS_KEY	= $AWS_SECRET_ACCESS_KEY;
				$this->APPLICATION_NAME			= $APPLICATION_NAME;
				$this->APPLICATION_VERSION		= $APPLICATION_VERSION;
				$this->MERCHANT_ID				= $MERCHANT_ID;
				$this->MARKETPLACE_ID			= $MARKETPLACE_ID;
				$this->MWS_ENDPOINT_URL			= $MWS_ENDPOINT_URL;
			}else{
				echo $user_id.' 的认证文件不存在。';
				exit;
			}
		}
	}

	// 获取单个订单的数据
	function getOrder($info,$ItemID){
		ini_set('max_execution_time','60');
		__autoload2('MarketplaceWebServiceOrders_Client');
		__autoload2('MarketplaceWebServiceOrders_Model_GetOrderRequest');	
		__autoload2('MarketplaceWebServiceOrders_Model_OrderIdList');	
		__autoload2('MarketplaceWebServiceOrders_Model_ListOrderItemsRequest');			
		$this->config['ServiceURL']		= $this->order_url;
		$service = new MarketplaceWebServiceOrders_Client(
        $this->AWS_ACCESS_KEY_ID,
        $this->AWS_SECRET_ACCESS_KEY,
        $this->APPLICATION_NAME,
        $this->APPLICATION_VERSION,
        $this->config);		
         //$this->getOrderServiceStatus($service);
        $request = new MarketplaceWebServiceOrders_Model_GetOrderRequest();
 		$request->setSellerId($this->MERCHANT_ID);
 		$orderIds = new MarketplaceWebServiceOrders_Model_OrderIdList();
		//对item_id进行处理，剔除已存在
		foreach($ItemID as $key=>$value){
			// 检查单号是否己存在重复
			$chk_result	= $this->checkExist($value);
			// 存在则不重复写入                        	
			if(intval($chk_result)>0){
				$return_result[$value] = $value;
			}else{
				$setId[]               = $value;
			}   
		}
		if(empty($setId)){
			return $return_result;
		}
 		$orderIds->setId($setId);
 		$request->setAmazonOrderId($orderIds); 		 		
 		try {
              $response = $service->getOrder($request);
                if ($response->isSetGetOrderResult()) {                  
                   $getOrderResult = $response->getGetOrderResult();                                    
                    if ($getOrderResult->isSetOrders()) {
						//实例化产品类及客户类
						$SaleOrder		  = D('SaleOrder');
						$Client		      = D('Client');
						$tmp_abbr_country = S('country');
						if(is_array($tmp_abbr_country)&&$tmp_abbr_country){
							foreach($tmp_abbr_country as $country_key=>$country_val){
								$abbr_country[$country_val['abbr_district_name']]	 = $country_val['district_name'];
								$abbr_country_id[$country_val['abbr_district_name']] = $country_key;
							}
						}

						$ListOrderItemsRequest = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
 						$ListOrderItemsRequest->setSellerId($this->MERCHANT_ID);

                        $orders = $getOrderResult->getOrders();
                        $orderList = $orders->getOrder();
                         foreach ($orderList as $order) {    
                        	$order_no							= $order->getAmazonOrderId();
                        	// 检查单号是否己存在重复
                        	$chk_result						    = $this->checkExist($order_no);
                        	if (intval($chk_result)>0){
								continue;
							}
							$data[$order_no]['factory_id']		= $this->factory_id;
                        	$data[$order_no]['order_no']		= $order_no;
                           	$data[$order_no]['order_date']		= $order->getPurchaseDate();
							$data[$order_no]['order_type']		= 3;
							$data[$order_no]['warehouse_id']    = 0;
							$data[$order_no]['sale_order_state']= 2;
							$data[$order_no]['transaction_id']	= $order_no;
							///标示数据来源为自动抓取
							$data[$order_no]['from_type']			= 'automatisch';
							//收货地址相关
                            if ($order->isSetShippingAddress()) {                                
                                $shippingAddress	= $order->getShippingAddress();
								$address			= ($shippingAddress->isSetAddressLine1() ? ($shippingAddress->getAddressLine1().' ') : '').$shippingAddress->getAddressLine2();
								$address2			= $shippingAddress->getAddressLine3()?$shippingAddress->getAddressLine3():'';
								$post_code			= $shippingAddress->getPostalCode();
								$city_name			= $shippingAddress->getCity();
								$StateOrProvince	= $shippingAddress->getStateOrRegion();
								$country_name		= $abbr_country[trim($shippingAddress->getCountryCode())];
                                $country_id			= $abbr_country_id[trim($shippingAddress->getCountryCode())];
								$phone				= $shippingAddress->getPhone();
								$consignee			= $shippingAddress->getName();
                            }
							//客户信息
							$client_name								  = trim($order->getBuyerName());
							$data[$order_no]['addition'][1]['comp_name']  = $client_name;
							$data[$order_no]['addition'][1]['factory_id'] = $this->factory_id;
							$data[$order_no]['addition'][1]['comp_type']  = 3;//亚马逊客户
							$data[$order_no]['addition'][1]['address']    = $address;
							$data[$order_no]['addition'][1]['address2']   = $address2;
							$data[$order_no]['addition'][1]['post_code']  = $post_code;
							$data[$order_no]['addition'][1]['city_name']  = $city_name;
							$data[$order_no]['addition'][1]['country_name']= $country_name;
							$data[$order_no]['addition'][1]['company_name'] = $StateOrProvince;
							$data[$order_no]['addition'][1]['country_id'] = $country_id; 
							$data[$order_no]['addition'][1]['email']	  = $order->getBuyerEmail(); 
							$data[$order_no]['addition'][1]['mobile']	  = $phone; 
							$data[$order_no]['addition'][1]['consignee']  = $consignee;
                            // 取明细		
 							$ListOrderItemsRequest->setAmazonOrderId($order_no);
  							$response = $service->listOrderItems($ListOrderItemsRequest); 
							
							//pr($response, '$response');
                 			if ($response->isSetListOrderItemsResult()) {                    
                   				$listOrderItemsResult = $response->getListOrderItemsResult();                    			                   
                    			if ($listOrderItemsResult->isSetOrderItems()) {                        
                        			$orderItems     = $listOrderItemsResult->getOrderItems();
                        			$orderItemList  = $orderItems->getOrderItem();
									foreach ($orderItemList as $ok=>$orderItem) {
										$sku		= $orderItem->getSellerSKU();
                        				$product_id = $this->getProductId(array("sku" => $sku,'factory_id' => $data[$order_no]['factory_id']));
										$data[$order_no]['detail'][$ok+1]['quantity']	    = $orderItem->getQuantityOrdered();
										$data[$order_no]['detail'][$ok+1]['product_id']		= $product_id;
										$data[$order_no]['detail'][$ok+1]['warehouse_id']	= 0;
										$data[$order_no]['detail'][$ok+1]['import_sku']		= $sku;
										$data[$order_no]['detail'][$ok+1]['transaction_id']	= $orderItem->getASIN();
                        			}
                    			}
                			}
                			//保存销售单
                			if(count($data[$order_no]['detail'])>0) {
								$data[$order_no]['client_id'] = $Client->externalSaveClient($data[$order_no]['addition'][1]);
								$check_info				      = $SaleOrder->create($data[$order_no]); 
								//echo 'check_info:';pr($check_info);
								if(false!==$check_info) {  
									// 保存销售单        
									//$SaleOrder->setModuleInfo('SaleOrder','insert');
									$result = $SaleOrder->relation(true)->add();
									if($result>0){
										$this->setReturnNote('订单号:'.$order_no.'<br>','Sale');
										$order_count++;
									}
								}
                			}
                        }
                    }                  
         	}
			return $return_result;   
     	} catch (MarketplaceWebServiceOrders_Exception $ex) {
        	if($ex->getStatusCode() == 403){
				$this->setReturnNote('亚马逊授权资料错误，请确定输入的授权资料是完全正确的！','Order');
			}else{
				$type		= '订单列表';
				$msg		= "Caught Exception: " . $ex->getMessage() . "\nResponse Status Code: " . $ex->getStatusCode() . "\nError Code: " . $ex->getErrorCode(). "\n" . "Error Type: " . $ex->getErrorType() . "\nRequest ID: " . $ex->getRequestId() . "\nXML: " . $ex->getXML();
				//echo $msg;
				//exit;
				$error_date = date('Y-m-d H:i:s', time());
				$this->setReturnNote('所选时间没有数据,或者网络可能有问题请重试。','Order');
				//M()->execute("INSERT INTO `amazon_error_log` (`type`, `msg`, `error_date`) VALUES ('".$type."', '".$msg."', '".$error_date."');");
			}
			return false;
     	}
	}
	
	// 获取订单列表
	public function getOrdersList() {		
		ini_set('max_execution_time','60');
		__autoload2('MarketplaceWebServiceOrders_Client');
		__autoload2('MarketplaceWebServiceOrders_Model_ListOrdersRequest');	
		__autoload2('MarketplaceWebServiceOrders_Model_MarketplaceIdList');	
		__autoload2('MarketplaceWebServiceOrders_Model_ListOrderItemsRequest');	
		__autoload2('MarketplaceWebServiceOrders_Model_OrderStatusList');			
		$this->config['ServiceURL']	= $this->order_url;
		$service = new MarketplaceWebServiceOrders_Client($this->AWS_ACCESS_KEY_ID,$this->AWS_SECRET_ACCESS_KEY,$this->APPLICATION_NAME,
        $this->APPLICATION_VERSION,$this->config);		
		$request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
 		$request->setSellerId($this->MERCHANT_ID);
 		if($_GET['from']) {
			$request->setCreatedAfter(new DateTime($_POST['date_from'])); 
 			$request->setCreatedBefore(new DateTime($_POST['date_to'])); 
 			// 设置每次返回的记录数
			$request->setMaxResultsPerPage(100);			
		} elseif ($_GET['date']) {
			$after_time = date('Y-m-d H:i:s',strtotime($_GET['date']));
			$request->setCreatedAfter(new DateTime($after_time)); 
 			$request->setCreatedBefore(new DateTime(date('Y-m-d H:i:s',$after_time))); 
			$request->setMaxResultsPerPage(100);	
 		} else {
			$request->setCreatedAfter(new DateTime(date('Y-m-d H:i:s', strtotime("-3 hours"))));
			$request->setMaxResultsPerPage(50);									
 		}
		
 		$marketplaceIdList = new MarketplaceWebServiceOrders_Model_MarketplaceIdList();
		$orderStatuses     = new MarketplaceWebServiceOrders_Model_OrderStatusList();
	 	$marketplaceIdList->setId(array($this->MARKETPLACE_ID));
 		$request->setMarketplaceId($marketplaceIdList);
	 	$orderStatuses->setStatus(array('Unshipped','PartiallyShipped'));
  		$request->setOrderStatus($orderStatuses);
		try {
              $response = $service->listOrders($request);
                if ($response->isSetListOrdersResult()) {                  
                    $listOrdersResult = $response->getListOrdersResult();
                    if ($listOrdersResult->isSetOrders()) {
						$SaleOrder		  = D('SaleOrder');
						$Client		      = D('Client');
						$tmp_abbr_country = S('country');
						if(is_array($tmp_abbr_country)&&$tmp_abbr_country){
							foreach($tmp_abbr_country as $country_key=>$country_val){
								$abbr_country[$country_val['abbr_district_name']]	 = $country_val['district_name'];
								$abbr_country_id[$country_val['abbr_district_name']] = $country_key;
							}
						}

						$ListOrderItemsRequest = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
						$ListOrderItemsRequest->setSellerId($this->MERCHANT_ID);
						$orders				   = $listOrdersResult->getOrders();                         
                        $orderList			   = $orders->getOrder();
						//pr($orderList,'$orderList');
						$order_count = 0;
                        foreach ($orderList as $order) {    
                        	$order_no							= $order->getAmazonOrderId();
                        	// 检查单号是否己存在重复
                        	$chk_result						    = $this->checkExist($order_no);
                        	if (intval($chk_result)>0){
								continue;
							}
							$data[$order_no]['factory_id']		= $this->factory_id;
							$data[$order_no]['other_type_user_id'] = $this->user_id;
                        	$data[$order_no]['order_no']		= $order_no;
                           	$data[$order_no]['order_date']		= $order->getPurchaseDate();
							$data[$order_no]['order_type']		= 3;
							$data[$order_no]['warehouse_id']    = 0;
							$data[$order_no]['sale_order_state']= 2;
							$data[$order_no]['transaction_id']	= $order_no;
							///标示数据来源为自动抓取
							$data[$order_no]['from_type']			= 'automatisch';
							//收货地址相关
                            if ($order->isSetShippingAddress()) {                                
                                $shippingAddress						  = $order->getShippingAddress();
								$address								  = ($shippingAddress->isSetAddressLine1() ? ($shippingAddress->getAddressLine1().' ') : '').$shippingAddress->getAddressLine2();
								$address2								  = $shippingAddress->getAddressLine3()?$shippingAddress->getAddressLine3():'';
								$post_code								  = $shippingAddress->getPostalCode();
								$city_name							      = $shippingAddress->getCity();
								$StateOrProvince	= $shippingAddress->getStateOrRegion();
								$country_name		= $abbr_country[trim($shippingAddress->getCountryCode())];
                                $country_id			= $abbr_country_id[trim($shippingAddress->getCountryCode())];
								$phone				= $shippingAddress->getPhone();
								$consignee			= $shippingAddress->getName();
                            }
							//客户信息
							$client_name								  = trim($order->getBuyerName());
							$data[$order_no]['addition'][1]['comp_name']  = $client_name; 
							$data[$order_no]['addition'][1]['factory_id'] = $this->factory_id;
							$data[$order_no]['addition'][1]['comp_type']  = 3;//亚马逊客户
							$data[$order_no]['addition'][1]['address']    = $address; 
							$data[$order_no]['addition'][1]['address2']   = $address2; 
							$data[$order_no]['addition'][1]['post_code']  = $post_code; 
							$data[$order_no]['addition'][1]['city_name']  = $city_name; 
							$data[$order_no]['addition'][1]['company_name'] = $StateOrProvince;
							$data[$order_no]['addition'][1]['country_name']= $country_name; 
							$data[$order_no]['addition'][1]['country_id'] = $country_id; 
							$data[$order_no]['addition'][1]['email']	  = $order->getBuyerEmail(); 
							$data[$order_no]['addition'][1]['mobile']	  = $phone; 
							$data[$order_no]['addition'][1]['consignee']  = $consignee; 
                            // 取明细		
 							$ListOrderItemsRequest->setAmazonOrderId($order_no);
  							$response = $service->listOrderItems($ListOrderItemsRequest); 
							
							//pr($response, '$response');
                 			if ($response->isSetListOrderItemsResult()) {                    
                   				$listOrderItemsResult = $response->getListOrderItemsResult();                    			                   
                    			if ($listOrderItemsResult->isSetOrderItems()) {                        
                        			$orderItems     = $listOrderItemsResult->getOrderItems();
                        			$orderItemList  = $orderItems->getOrderItem();
									foreach ($orderItemList as $ok=>$orderItem) {
										$sku		= $orderItem->getSellerSKU();
                        				$product_id = $this->getProductId(array("sku" => $sku,'factory_id' => $data[$order_no]['factory_id']));
										$data[$order_no]['detail'][$ok+1]['quantity']	    = $orderItem->getQuantityOrdered();
										$data[$order_no]['detail'][$ok+1]['product_id']		= $product_id;
										$data[$order_no]['detail'][$ok+1]['warehouse_id']	= 0;
										$data[$order_no]['detail'][$ok+1]['import_sku']		= $sku;
										/*
                        				if(intval($product_id)>0) { 
											$data[$order_no]['detail'][$ok]['quantity']	    = $orderItem->getQuantityOrdered();
                        					$data[$order_no]['detail'][$ok]['product_id']   = $product_id;
											$data[$order_no]['detail'][$ok]['warehouse_id']	= 0;
                            				$this->setDifferProducts(array('item_id'=>$order_no,'title' =>$sku));
                        				} else {
											$differ_product = array (
												'item_id' 		=> $order_no,													
												'title' 		=> $sku,
												'sku'			=> $sku,
												'user_id' 		=> $this->user_id,
												'to_hide'		=> 1,
											);										        
											$this->saveDifferProducts($differ_product, 4);					
                        				}
										*/
                        			}
                    			}
                			}
                			//保存销售单
                			if(count($data[$order_no]['detail'])>0) {
								$data[$order_no]['client_id'] = $Client->externalSaveClient($data[$order_no]['addition'][1]);
								$check_info				      = $SaleOrder->create($data[$order_no]); 
								//echo 'check_info:';pr($check_info);
								if(false!==$check_info) {  
									// 保存销售单        
									//$SaleOrder->setModuleInfo('SaleOrder','insert');
									$result = $SaleOrder->relation(true)->add();
									if($result>0){
										$this->setReturnNote('订单号:'.$order_no.'<br>','Sale');
										A('SaleOrder')->generateBarcode($result);
										$order_count++;
									}
								}
                			}
                        }
                    }
			}
			if($order_count>0){
				$this->setReturnNote('成功导入'.$order_count.'条记录<br>','Order');
			}
			return true;
     	}catch(MarketplaceWebServiceOrders_Exception $ex) {
			if($ex->getStatusCode() == 403){
				$this->setReturnNote('亚马逊授权资料错误，请确定输入的授权资料是完全正确的！','Order');
			}else{
				$type		= '订单列表';
				$msg		= "Caught Exception: " . $ex->getMessage() . "\nResponse Status Code: " . $ex->getStatusCode() . "\nError Code: " . $ex->getErrorCode(). "\n" . "Error Type: " . $ex->getErrorType() . "\nRequest ID: " . $ex->getRequestId() . "\nXML: " . $ex->getXML();
				//echo $msg;
				//exit;
				$error_date = date('Y-m-d H:i:s', time());
				$this->setReturnNote('所选时间没有数据,或者网络可能有问题请重试。','Order');
				//M()->execute("INSERT INTO `amazon_error_log` (`type`, `msg`, `error_date`) VALUES ('".$type."', '".$msg."', '".$error_date."');");
			}
			return false;
     	}
	}

	public function checkExist($order_no) {
		$id = M('sale_order')->where('order_type=3 and order_no= "'.$order_no.'"')->getField('id');
		if($id <= 0){
			$id = M('sale_order_del')->where('order_type=3 and order_no= "'.$order_no.'"')->getField('id');
		}
		return $id;
	}

	// 获取产品ID
	public function getProductId($info) {
		$product_no	= trim($info['sku']);
		$factory_id = intval($info['factory_id']);
		///先跟本身的型号对比，然后再跟外部SKU对比
		$p_id	    = M('product')->where('factory_id='.$factory_id.' and product_no=\''.$product_no.'\'')->getField('id');
		if(!$p_id > 0){
			$p_id	= M('ProductSku')->where('factory_id='.$factory_id.' and sku=\''.$product_no.'\'')->getField('product_id');
		}
		return $p_id > 0 ? $p_id : false;
	}
	
	// 删除不正常销售里的数据
	public function setDifferProducts($info) {
		extract($info);		
		$update_sql = 'update sale_order_differ_product 
					   set `to_hide`=2 
					   where object_type=4 and title=\''.$title.'\' and item_id=\''.$item_id.'\'';
		return M('sale_order_differ_product')->execute($update_sql); 
	}

	//保存在EBAY上架的产品但是在系统的产品列表中找不到的产品
    public function saveDifferProducts($info, $type=4){
		$sale_order_differ_product = M('sale_order_differ_product');
		$id = $sale_order_differ_product->where('item_id=\''.$info['item_id'].'\' and object_type='.$type)->getField('id');
		if(intval($id)>0)
			return false;
		$insert_array	  = array(
							    'item_id' 	  => $info['item_id'],													
								'title' 	  => $info['title'],
								'sku'		  => $info['sku'],
								'user_id' 	  => $info['user_id'],
								'object_type' => $type,
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

	// 获取单个订单的数据
	function getOrderNew($info,$ItemID){
		ini_set('max_execution_time','60');
		__autoload2('MarketplaceWebServiceOrders_Client');
		__autoload2('MarketplaceWebServiceOrders_Model_GetOrderRequest');	
		__autoload2('MarketplaceWebServiceOrders_Model_OrderIdList');	
		__autoload2('MarketplaceWebServiceOrders_Model_ListOrderItemsRequest');			
		$this->config['ServiceURL']		= $this->order_url;
		$service = new MarketplaceWebServiceOrders_Client(
        $this->AWS_ACCESS_KEY_ID,
        $this->AWS_SECRET_ACCESS_KEY,
        $this->APPLICATION_NAME,
        $this->APPLICATION_VERSION,
        $this->config);		
         //$this->getOrderServiceStatus($service);
        $request = new MarketplaceWebServiceOrders_Model_GetOrderRequest();
 		$request->setSellerId($this->MERCHANT_ID);
 		//$orderIds = new MarketplaceWebServiceOrders_Model_OrderIdList();
		//对item_id进行处理，剔除已存在
		foreach($ItemID as $key=>$value){
			// 检查单号是否己存在重复
			$chk_result	= $this->checkExist($value);
			// 存在则不重复写入                        	
			if(intval($chk_result)>0){
				$this->setReturnNote($value.' '.L('order_no_repeat').'<br>','Order');
				$return_result[$value] = $value;
			}else{
				$setId[]               = $value;
			}
		}
		if(empty($setId)){
			$this->setReturnNote(L('all').L('order_no').L('order_no_repeat'),'Order');
			return true;
		}
 		//$orderIds->setId($setId);
 		$request->setAmazonOrderId($setId); 		 		
 		try {
              $response = $service->getOrder($request);
			  $order_count = 0;
			  	//pr($response,'$response');
                if ($response->isSetGetOrderResult()) {                  
                   $getOrderResult = $response->getGetOrderResult();                                    
                    if ($getOrderResult->isSetOrders()) {
						//实例化产品类及客户类
						$SaleOrder		  = D('SaleOrder');
						$Client		      = D('Client');
						$tmp_abbr_country = S('country');
						if(is_array($tmp_abbr_country)&&$tmp_abbr_country){
							foreach($tmp_abbr_country as $country_key=>$country_val){
								$abbr_country[$country_val['abbr_district_name']]	 = $country_val['district_name'];
								$abbr_country_id[$country_val['abbr_district_name']] = $country_key;
							}
						}

						$ListOrderItemsRequest = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
 						$ListOrderItemsRequest->setSellerId($this->MERCHANT_ID);

                        $orders = $getOrderResult->getOrders();
                        //$orderList = $orders->getOrder();
                        foreach ($orders as $order) {
							//pr($order,'$order');
                        	$order_no							= $order->getAmazonOrderId();
							$data[$order_no]['factory_id']		= $this->factory_id;
                        	$data[$order_no]['order_no']		= $order_no;
                           	$data[$order_no]['order_date']		= $order->getPurchaseDate();
							$data[$order_no]['order_type']		= 3;
							$data[$order_no]['warehouse_id']    = 0;
							$data[$order_no]['sale_order_state']= 2;
							$data[$order_no]['transaction_id']	= $order_no;
							///标示数据来源为自动抓取
							$data[$order_no]['from_type']			= 'automatisch';
							//收货地址相关
                            if ($order->isSetShippingAddress()) {                                
                                $shippingAddress	= $order->getShippingAddress();
								$address			= ($shippingAddress->isSetAddressLine1() ? ($shippingAddress->getAddressLine1().' ') : '').$shippingAddress->getAddressLine2();
								$address2			= $shippingAddress->getAddressLine3()?$shippingAddress->getAddressLine3():'';
								$post_code			= $shippingAddress->getPostalCode();
								$city_name			= $shippingAddress->getCity();
								$StateOrProvince	= $shippingAddress->getStateOrRegion();
								$country_name		= $abbr_country[trim($shippingAddress->getCountryCode())];
                                $country_id			= $abbr_country_id[trim($shippingAddress->getCountryCode())];
								$phone				= $shippingAddress->getPhone();
								$consignee			= $shippingAddress->getName();
                            }
							//客户信息
							$client_name								  = trim($order->getBuyerName());
							$data[$order_no]['addition'][1]['comp_name']  = $client_name;
							$data[$order_no]['addition'][1]['factory_id'] = $this->factory_id;
							$data[$order_no]['addition'][1]['comp_type']  = 3;//亚马逊客户
							$data[$order_no]['addition'][1]['address']    = $address;
							$data[$order_no]['addition'][1]['address2']   = $address2;
							$data[$order_no]['addition'][1]['post_code']  = $post_code;
							$data[$order_no]['addition'][1]['city_name']  = $city_name;
							$data[$order_no]['addition'][1]['country_name']= $country_name;
							$data[$order_no]['addition'][1]['company_name'] = $StateOrProvince;
							$data[$order_no]['addition'][1]['country_id'] = $country_id; 
							$data[$order_no]['addition'][1]['email']	  = $order->getBuyerEmail(); 
							$data[$order_no]['addition'][1]['mobile']	  = $phone; 
							$data[$order_no]['addition'][1]['consignee']  = $consignee;
                            // 取明细		
 							$ListOrderItemsRequest->setAmazonOrderId($order_no);
  							$response = $service->listOrderItems($ListOrderItemsRequest); 
							
							//pr($response, '$response');
                 			if ($response->isSetListOrderItemsResult()) {                    
                   				$listOrderItemsResult = $response->getListOrderItemsResult();                    			                   
                    			if ($listOrderItemsResult->isSetOrderItems()) {                        
                        			$orderItems     = $listOrderItemsResult->getOrderItems();
                        			//$orderItemList  = $orderItems->getOrderItem();
									foreach ($orderItems as $ok=>$orderItem) {
										$sku		= $orderItem->getSellerSKU();
                        				$product_id = $this->getProductId(array("sku" => $sku,'factory_id' => $data[$order_no]['factory_id']));
										$data[$order_no]['detail'][$ok+1]['quantity']	    = $orderItem->getQuantityOrdered();
										$data[$order_no]['detail'][$ok+1]['product_id']		= $product_id;
										$data[$order_no]['detail'][$ok+1]['warehouse_id']	= 0;
										$data[$order_no]['detail'][$ok+1]['import_sku']		= $sku;
                        			}
                    			}
                			}
                			//保存销售单
                			if(count($data[$order_no]['detail'])>0) {
								$data[$order_no]['client_id'] = $Client->externalSaveClient($data[$order_no]['addition'][1]);
								$check_info				      = $SaleOrder->create($data[$order_no]); 
								//echo 'check_info:';pr($check_info);
								if(false!==$check_info) {  
									// 保存销售单        
									//$SaleOrder->setModuleInfo('SaleOrder','insert');
									startTrans();
									$result = $SaleOrder->relation(true)->add();
									if($result>0){
										commit();
										$this->setReturnNote($order_no.' '.L('get_success').'<br>','Sale');
										$order_count++;
									}else{
+                                       rollback();
                                    }
								}
                			}
                        }
                    }                
         	}
			if($order_count>0){
				$this->setReturnNote('成功导入'.$order_count.'条记录<br>','Order');
			}else{
				$this->setReturnNote('没有导入任何记录。<br>','Order');
			}
			return true;   
     	} catch (MarketplaceWebServiceOrders_Exception $ex) {
        	if($ex->getStatusCode() == 403){
				$this->setReturnNote('亚马逊授权资料错误，请确定输入的授权资料是完全正确的！','Order');
			}else{
				$type		= '订单列表';
				$msg		= "Caught Exception: " . $ex->getMessage() . "\nResponse Status Code: " . $ex->getStatusCode() . "\nError Code: " . $ex->getErrorCode(). "\n" . "Error Type: " . $ex->getErrorType() . "\nRequest ID: " . $ex->getRequestId() . "\nXML: " . $ex->getXML();
				//echo $msg;
				//exit;
				$error_date = date('Y-m-d H:i:s', time());
				$this->setReturnNote($ex->getMessage(),'Order');
				//M()->execute("INSERT INTO `amazon_error_log` (`type`, `msg`, `error_date`) VALUES ('".$type."', '".$msg."', '".$error_date."');");
			}
			return false;
     	}
	}
	
	// 获取订单列表
	public function getOrdersListNew() {
		//ini_set('max_execution_time','60');
		__autoload2('MarketplaceWebServiceOrders_Client');
		__autoload2('MarketplaceWebServiceOrders_Model_ListOrdersRequest');	
		__autoload2('MarketplaceWebServiceOrders_Model_MarketplaceIdList');	
		__autoload2('MarketplaceWebServiceOrders_Model_ListOrderItemsRequest');	
		__autoload2('MarketplaceWebServiceOrders_Model_OrderStatusList');			
		$this->config['ServiceURL']	= $this->order_url;
		$service = new MarketplaceWebServiceOrders_Client($this->AWS_ACCESS_KEY_ID,$this->AWS_SECRET_ACCESS_KEY,$this->APPLICATION_NAME,
        $this->APPLICATION_VERSION,$this->config);
		$request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
 		$request->setSellerId($this->MERCHANT_ID);
		//exit;
 		if($_POST['date_from'] && $_POST['date_to']) {
			$request->setCreatedAfter(date(c,strtotime($_POST['date_from'])));
 			$request->setCreatedBefore(date(c,strtotime($_POST['date_to'])));
 			// 设置每次返回的记录数
			$request->setMaxResultsPerPage(100);
		} elseif ($_GET['date']) {
			$after_time = date(c,strtotime($_GET['date']));
			$request->setCreatedAfter(date(c,strtotime($after_time))); 
 			$request->setCreatedBefore($after_time); 
			$request->setMaxResultsPerPage(100);	
 		} else {
			$request->setCreatedAfter(date(c,strtotime("-3 hours")));
			$request->setMaxResultsPerPage(50);									
 		}
 		$request->setMarketplaceId(array($this->MARKETPLACE_ID));
  		$request->setOrderStatus(array('Shipped','Unshipped','PartiallyShipped'));
		try { 
              $response = $service->listOrders($request);
			  //pr($response,'$response');
                if ($response->isSetListOrdersResult()) {             
                    $listOrdersResult = $response->getListOrdersResult();
					//pr($listOrdersResult,'$listOrdersResult',1);
                    if ($listOrdersResult->isSetOrders()) {
						$SaleOrder		  = D('SaleOrder');
						$Client		      = D('Client');
						$tmp_abbr_country = S('country');
						if(is_array($tmp_abbr_country)&&$tmp_abbr_country){
							foreach($tmp_abbr_country as $country_key=>$country_val){
								$abbr_country[$country_val['abbr_district_name']]	 = $country_val['district_name'];
								$abbr_country_id[$country_val['abbr_district_name']] = $country_key;
							}
						}

						$orders				   = $listOrdersResult->getOrders();                         
                        //$orderList			   = $orders->getOrder();
						$order_count = 0;
                        foreach ($orders as $order) {    
                        	$order_no							= $order->getAmazonOrderId();
                        	// 检查单号是否己存在重复
                        	$chk_result						    = $this->checkExist($order_no);
                        	if (intval($chk_result)>0){
								continue;
							}
							$data[$order_no]['factory_id']		= $this->factory_id;
                        	$data[$order_no]['order_no']		= $order_no;
                           	$data[$order_no]['order_date']		= $order->getPurchaseDate();
							$data[$order_no]['order_type']		= 3;
							$data[$order_no]['warehouse_id']    = 0;
							$data[$order_no]['sale_order_state']= 2;
							$data[$order_no]['transaction_id']	= $order_no;
							///标示数据来源为自动抓取
							$data[$order_no]['from_type']			= 'automatisch';
							//收货地址相关
                            if ($order->isSetShippingAddress()) {                                
                                $shippingAddress	= $order->getShippingAddress();
								$address			= ($shippingAddress->isSetAddressLine1() ? ($shippingAddress->getAddressLine1().' ') : '').$shippingAddress->getAddressLine2();
								$address2			= $shippingAddress->getAddressLine3()?$shippingAddress->getAddressLine3():'';
								$post_code			= $shippingAddress->getPostalCode();
								$city_name			= $shippingAddress->getCity();
								$StateOrProvince	= $shippingAddress->getStateOrRegion();
								$country_name		= $abbr_country[trim($shippingAddress->getCountryCode())];
                                $country_id			= $abbr_country_id[trim($shippingAddress->getCountryCode())];
								$phone				= $shippingAddress->getPhone();
								$consignee			= $shippingAddress->getName();
                            }
							//客户信息
							$client_name								  = trim($order->getBuyerName());
							$data[$order_no]['addition'][1]['comp_name']  = $client_name;
							$data[$order_no]['addition'][1]['factory_id'] = $this->factory_id;
							$data[$order_no]['addition'][1]['comp_type']  = 3;//亚马逊客户
							$data[$order_no]['addition'][1]['address']    = $address;
							$data[$order_no]['addition'][1]['address2']   = $address2;
							$data[$order_no]['addition'][1]['post_code']  = $post_code;
							$data[$order_no]['addition'][1]['city_name']  = $city_name;
							$data[$order_no]['addition'][1]['country_name']= $country_name;
							$data[$order_no]['addition'][1]['company_name'] = $StateOrProvince;
							$data[$order_no]['addition'][1]['country_id'] = $country_id; 
							$data[$order_no]['addition'][1]['email']	  = $order->getBuyerEmail(); 
							$data[$order_no]['addition'][1]['mobile']	  = $phone; 
							$data[$order_no]['addition'][1]['consignee']  = $consignee;
                            // 取明细
							$ListOrderItemsRequest = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
							$ListOrderItemsRequest->setSellerId($this->MERCHANT_ID);
 							$ListOrderItemsRequest->setAmazonOrderId($order_no);
  							$response = $service->listOrderItems($ListOrderItemsRequest); 
							
							//pr($response, '$response');
                 			if ($response->isSetListOrderItemsResult()) {                    
                   				$listOrderItemsResult = $response->getListOrderItemsResult();                    			                   
                    			if ($listOrderItemsResult->isSetOrderItems()) {                        
                        			$orderItems     = $listOrderItemsResult->getOrderItems();
                        			//$orderItemList  = $orderItems->getOrderItem();
									foreach ($orderItems as $ok=>$orderItem) {
										$sku		= $orderItem->getSellerSKU();
                        				$product_id = $this->getProductId(array("sku" => $sku,'factory_id' => $data[$order_no]['factory_id']));
										$data[$order_no]['detail'][$ok+1]['quantity']	    = $orderItem->getQuantityOrdered();
										$data[$order_no]['detail'][$ok+1]['product_id']		= $product_id;
										$data[$order_no]['detail'][$ok+1]['warehouse_id']	= 0;
										$data[$order_no]['detail'][$ok+1]['import_sku']		= $sku;
                        			}
                    			}
                			}
                			//保存销售单
                			if(count($data[$order_no]['detail'])>0) {
								$data[$order_no]['client_id'] = $Client->externalSaveClient($data[$order_no]['addition'][1]);
								$check_info				      = $SaleOrder->create($data[$order_no]); 
								//echo 'check_info:';pr($check_info);
								if(false!==$check_info) {  
									// 保存销售单        
									//$SaleOrder->setModuleInfo('SaleOrder','insert');
									$result = $SaleOrder->relation(true)->add();
									if($result>0){
										$this->setReturnNote('订单号:'.$order_no.'<br>','Sale');
										$order_count++;
									}
								}
                			}
                        }
                    }
			}
			if($order_count>0){
				$this->setReturnNote('成功导入'.$order_count.'条记录<br>','Order');
			}else{
				$this->setReturnNote('所选择的日期没有订单。<br>','Order');
			}
			return true;
		
     	}catch(MarketplaceWebServiceOrders_Exception $ex) {
			if($ex->getStatusCode() == 403){
				$this->setReturnNote('亚马逊授权资料错误，请确定输入的授权资料是完全正确的！','Order');
			}elseif($ex->getStatusCode() == 400){
				$this->setReturnNote('只能查询2分钟之前的订单，请重新选择日期！','Order');
			}else{
				$type		= '订单列表';
				$msg		= "Caught Exception: " . $ex->getMessage() . "\nResponse Status Code: " . $ex->getStatusCode() . "\nError Code: " . $ex->getErrorCode(). "\n" . "Error Type: " . $ex->getErrorType() . "\nRequest ID: " . $ex->getRequestId() . "\nXML: " . $ex->getXML();
				$error_date = date('Y-m-d H:i:s', time());
				$this->setReturnNote($ex->getMessage(),'Order');
				//M()->execute("INSERT INTO `amazon_error_log` (`type`, `msg`, `error_date`) VALUES ('".$type."', '".$msg."', '".$error_date."');");
			}
			return false;
     	}
		
	}
}
?>