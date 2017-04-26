<?php

/**
 * DHL API
 * @copyright   Copyright (c) 2014 - 2015 Union Top 展联软件友拓通
 * @category    Ebay
 * @package   Model
 * @author     jph
 * @version  2.1,2016-04-21
 */
class GlsPublicModel extends RelationModel {
	protected $tableName	= 'sale_order';
	public $express_type	= 'GLS';
	public $StatusMessage;

	public function __construct($name='', $tablePrefix='', $connection='') {
		parent::__construct($name, $tablePrefix, $connection);
		addLang('Gls');
		ini_set('memory_limit','512M');
		ini_set('display_errors',true);
		set_time_limit(120);
		error_reporting(-1);
//		load('DHL.DHLAutoload', LIBRARY_PATH);
//		$this->setConfig();
	}

	public function __destruct() {
	}

	/**
	* @param type $sale_order_id
	* @param type $printer_name
	* @return type
	* 	|T100	收货人国家代码
	* 	|T330	收货人邮编
	* 	|T400	包裹号码+1位验证数
	* 	|T530	包裹重量
	* 	|T800	（固定字符， 无需修改）
	* 	|T805	GLS用户账号
	* 	|T810	发件人1
	* 	|T811	发件人2
	* 	|T812	发件人3
	* 	|T820	发件人地址
	* 	|T821	发件人国家代码
	* 	|T822	发件人邮编
	* 	|T823	发件人城市
	* 	|T854	ID-Nummer （DD号码）
	* 	|T860	收件人收件人 1
	* 	|T861	收件人地址 2
	* 	|T862	收件人地址 3
	* 	|T863	收件人地址1 + 门牌号
	* 	|T864	收件人城市
	* 	|T8960	（固定字符， 无需修改）
	* 	|T921	产品条码
	* 	|T8700	GLS收货站代码
	* 	|T8914	GLS Contact ID
	* 	|T8915	GLS Customer ID
	* 	|T545	发货日期
	* 	|T1229	收货人邮件地址（如果客人填写邮件地址则增加此字段）
	*
	*/
	public function getRequestData($sale_order_id){
		$mac_address	= trim($_GET['mac_address']);
		$printer_name	= M('GlsPrinterName')->where('mac_address="'.$mac_address.'"')->getField('printer_name');
		$sale	= express_api_get_sale_order_info($this->express_type, $sale_order_id);
		$check_data		= $this->getShipmentOrderBasic($sale);
//		$this->api_checksum		= md5(serialize($check_data));//生成数据校验码
//		$sale_order_addition	= M('SaleOrderAddition')->where('sale_order_id='.$sale_order_id)->find();
		$in	= '\\\\\\\\\\GLS\\\\\\\\\\|T020:LPR, lpr -r -P'.$printer_name.'|T021:zebrazpl200';
//		if($sale['is_print']==1){//重新打印
//			$in	.= '|T010:'.$sale['Labelurl'].':'.$sale['track_no'];
//		}
		$in	.= '|T100:'.$check_data['Receiver']['country_code'];
		if(!in_array($check_data['Receiver']['country_code'], C('GLS_EU_COUNTRIES'))){
			$in	.= '|T210:30';
		}
		$in	.= '|T330:'.$check_data['Receiver']['post_code'];
		$in	.= '|T400:'.$sale['track_no'];
//		$in	.= '|T400:'.$this->getVerification($sale['track_no'], !in_array($check_data['Receiver']['country_code'], C('GLS_EU_COUNTRIES')));
		$in	.= '|T530:'.$check_data['ShipmentDetails']['weight'];
		$in	.= '|T800:Absender';
		$in	.= '|T854:'.$sale['sale_order_no'];
		$in	.= '|T860:'.$check_data['Receiver']['consignee'].'|T861:|T862:|T863:'.$check_data['Receiver']['address'].'|T864:'.$check_data['Receiver']['city_name'];
		$in	.= '|T8960:Note';
		$in	.= '|T921:';
		$in	.= '|T545:'.  date('d.m.Y',  strtotime($sale['send_date']));
		$shipper_params	= $check_data['Shipper'];//发货人参数
		foreach ($shipper_params as $key=>$value){
			$in	.= '|'.$key.':'.$value;
		}
		$in	.= (empty($check_data['Receiver']['email']))?'':'|T1229:'.$check_data['Receiver']['email'];
		$in	.= '/////GLS/////';
		return $in;
	}
	/**
	 * 包裹号码+1位验证数
	 * @param type $package_no
	 */
	public function getTrackNo($w_id){
//		$package_no	= '10279268413';
		$package_no	= $this->getMaxPackageNo($w_id);
		$ratio	= array('0'=>3,'1'=>1);
		$strs	= str_split($package_no);
		foreach ($strs as $k=>$v){
			$total	+= $v*$ratio[$k%2];
		}
		$vertify_number	= 9-intval(end(str_split($total)));
		$track_no= $package_no.$vertify_number;
		return $track_no;
	}

	/**
	 * 包裹号码+1位验证数
	 * @param type $track_no
	 */
	public function getVerification($track_no,$non_eu=false){
		if($non_eu){
			$track_no	.= '1';
		}
		$ratio	= array('0'=>3,'1'=>1);
		$strs	= str_split($track_no);
		foreach ($strs as $k=>$v){
			$total	+= $v*$ratio[$k%2];
		}
		$vertify_number	= 9-intval(end(str_split($total)));
		$track_no= $track_no.$vertify_number;
		return $track_no;
	}

	/**
	 * 可用最大包裹号
	 */
	public function getMaxPackageNo($w_id){
//		S('GLS_MAX_PACKAGE_NO_'.$w_id,  floor(S('GLS_MAX_PACKAGE_NO_'.$w_id)/10));
		if(S('GLS_MAX_PACKAGE_NO_'.$w_id)){
			$max_package_no	= S('GLS_MAX_PACKAGE_NO_'.$w_id);
		}else{
			$current_max_package_no	= M('SaleOrder')->where('warehouse_id='.$w_id.' and EXISTS(select 1 from express e where e.id=sale_order.express_id and e.company_id in('.implode(',',C('GLS_API_EXPRESS_ID')).') )')->max('track_no');
			$current_max_package_no	= floor($current_max_package_no/10);
			if(empty($current_max_package_no)){
				$max_package_no	= C('GLS_PACKAGE_NO_START_'.$w_id)-1;
			}
		}
		if($max_package_no>=C('GLS_PACKAGE_NO_END_'.$w_id)){
			return false;
		}else{
			return $max_package_no+1;
		}
	}

	/**
	 * 设置已用最大包裹号
	 */
	public function setMaxPackageNo($track_no,$w_id){
		S('GLS_MAX_PACKAGE_NO_'.$w_id, floor($track_no/10));
	}

//	/**
//	 * 判断是否还有可用的追踪单号
//	 */
//	public function checkMaxPackageNo($w_id){
//		if(S('GLS_MAX_PACKAGE_NO_'.$w_id)>=C('GLS_PACKAGE_NO_END_'.$w_id)){
//			return false;
//		}else{
//			return true;
//		}
//	}

	/**
	 * 更新订单状态和追踪单号
	 */
	public function updateSaleOrder($sale_order_id,$data,$sale_order_state=false){
		$sale	= express_api_get_sale_order_info($this->express_type, $sale_order_id);
		if(!isset($data['api_checksum'])){
			$check_data		= $this->getShipmentOrderBasic($sale);
			$data['api_checksum']		= md5(serialize($check_data));//生成数据校验码
		}
		$sale_order	= D('SaleOrder');
		$r	= $sale_order->where('id='.$sale_order_id)->save($data);
		if($r !== false){
			if($sale_order_state){
				$sale_order->updateSaleOrderStateById($sale_order_id, C('SALE_ORDER_STATE_EXPORTING'), 'gls api exporting');
			}
			if($data['track_no']){
				$this->setMaxPackageNo($data['track_no'],$sale['warehouse_id']);
			}
		}
		return $r;
	}
	/**
	 * 运单基本信息
	 * @param type $sale
	 * @return array
	 */
	public function getShipmentOrderBasic($sale){
		$order	= array(
			'Receiver'			=> $this->getShipmentOrderReceiver($sale),
			'ShipmentDetails'	=> $this->getShipmentOrderShipmentDetails($sale),
			'Shipper'			=> $this->getShipperConfig($sale['warehouse_id']),
		);
		return $order;
	}

	/**
	 * 获取收货人信息
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderReceiver($sale){
		//Data should be ISO 8859-1 coded
		$data		= array(
			'consignee'		=> iconv('utf-8', 'iso-8859-1', mb_strcut($sale['consignee'], 0, 40)),//收货人
			'country_no'	=> iconv('utf-8', 'iso-8859-1', mb_strcut(SOnly('country', $sale['country_id'],'abbr_district_name'), 0, 3)),//国家代码
			'city_name'		=> iconv('utf-8', 'iso-8859-1', mb_strcut($sale['city_name'], 0, 30)),//城市
			'post_code'		=> iconv('utf-8', 'iso-8859-1', mb_strcut($sale['post_code'], 0, 10)),//邮编
			'street_name'	=> iconv('utf-8', 'iso-8859-1', mb_strcut($sale['address'] . ($sale['address2'] ? ' ' . $sale['address2'] : ''), 0, 50)),//收件人地址1 + 门牌号
		);
		//验证数据 st
		$error		= array();
		foreach ($data as $field => $value) {
			if (empty($value)) {
				$error[]	= L($field) . ': ' . L('require');
			}
		}
		$this->setStatusMessage($error, L('consignee'));
		//验证数据 ed
		$receiver					= array (
			'consignee'		=> $data['consignee'],//收货人
			'country_code'	=> $data['country_no'],// 	国家
			'city_name'		=> $data['city_name'],
			'post_code'		=> $data['post_code'],
			'address'		=> $data['street_name'],//街道名称
		);
		if ($sale['email']) {//email
			$receiver['email']	= iconv('utf-8', 'iso-8859-1', mb_strcut($sale['email'], 0, 150));
		}
		return $receiver;
	}

	/**
	 * 获取订单信息
	 * @param array $sale
	 * @return array
	 */
	protected function getShipmentOrderShipmentDetails($sale){
		$shipmentDetails	= array (
			'weight'	=> str_replace('.',',',ceil($sale['weight']/1000*10)/10),
			'shipper_date'	=> $sale['send_date'],
			'track_no'	=> $sale['track_no'],
		);
		return $shipmentDetails;
	}

	/**
	 * 获取发货人信息
	 * @return array
	 */
	public function getShipperConfig($w_id){
		$fields	= array(
			'T810'	=> array('field'=>'shipper_name','lang'=>'consigner'),
			'T820'	=> array('field'=>'shipper_address','lang'=>'address'),
			'T821'	=> array('field'=>'shipper_country_code','lang'=>'country_no'),
			'T822'	=> array('field'=>'shipper_postcode','lang'=>'postcode'),
			'T823'	=> array('field'=>'shipper_city','lang'=>'city_name'),
			'T805'	=> array('field'=>'user_account','lang'=>'gls_user_account'),//GLS用户账号
			'T8700'	=> array('field'=>'receive_station_code','lang'=>'gls_receive_station_code'),//GLS收货站代码
			'T8914'	=> array('field'=>'contact_id','lang'=>'gls_contact_id'),//GLS Contact ID
			'T8915'	=> array('field'=>'customer_id','lang'=>'gls_customer_id'),//GLS Customer ID
		);
		//验证数据 st
		$error		= array();
		foreach ($fields as $key=>$v) {
			if(C('gls_' . $v['field'].'_'.$w_id)){
				$shipper_config[$key]	= iconv('utf-8','iso-8859-1',C('gls_'.$v['field'].'_'.$w_id));
			}else{
				$error[]	= L($v['lang']) . ': ' . L('require');
			}
		}
		$this->setStatusMessage($error, L('consignee'));
		//验证数据 ed
		$o_fields	= array(
			'T811'	=> 'shipper_name2',//
			'T812'	=> 'shipper_name3',//
		);
		foreach ($o_fields as $key=>$field) {
			$shipper_config[$key]	= (C('gls_'.$field.'_'.$w_id))?iconv('utf-8','iso-8859-1', C('gls_'.$field.'_'.$w_id)):'';
		}
		return $shipper_config;
	}

	/**
	 * 解析请求结果
	 * @param object $result
	 */
    public function parseRequestResult($sale_order_id,$result,$sale_order_no) {
//		dump($result);
		$result	= split('\|RESULT:', $result);
		$result	= split('\|PRINT0:', $result[1]);
		$info	= $result[0];

		$error	= explode(':', $result[0],2);
		if($error[0]=='E000'){
			$info	= "<div style='text-align:center'>打印成功!</div>";
		}else{
//			$errorInfo	= $this->getSatusError();
			$info	= "<div style='text-align:center'>打印失败!</div>错误代码：".$error[0]."<br>".L('deal_no').'：'.$sale_order_no.'<br>';
			$error_detail	= explode('|', $error[1]);
			foreach ($error_detail as $k=>$v){
				$e		= explode(':', $v);
				if($this->tagToField($e[0])){
					$e[0]	= $this->tagToField($e[0]);
				}
				$info	.= implode(':', $e);
			}
		}
		$data	= array(
			'track_no_update_tips'	=> ($error[0]=='E000')?0:1,
			'is_print'		=> ($error[0]=='E000')?1:2
		);
//		$this->updateSaleOrder($sale_order_id, $data);
		return	$info;
	}

	/**
     * Set StatusMessage value
     * @param string $_statusMessage the StatusMessage
     * @return string
     */
    public function setStatusMessage($_statusMessage){
        return ($this->StatusMessage = $_statusMessage);
    }

	/**
	 * 获取错误信息
	 * @staticvar int $serial_no
	 * @param string $status_code
	 * @param mixed $status_message
	 * @param string $label
	 * @param boolean $is_detail
	 */
	public function getSatusError($status_code, $status_message, $label, $is_detail = true){
		$error	= array(
			'E000'	=> 'OK.',
			'E001'	=> 'Mandatory field is missing in the data stream.',
			'E002'	=> 'Wrong format is transmitted in a TAG.',
			'E003'	=> 'TAG T330 is not available in the routing tables.',
			'E004'	=> 'No free parcel number is available within the NDI-parcel number ranges.',
			'E005'	=> 'A parameter is missing within the configuration file of the UNI-BOX.',
			'E006'	=> 'The application is not able to make the routing.',
			'E007'	=> 'a needed template-file cannot be found or opened.',
			'E008'	=> 'The interface which cannot be opened is transmitted within the data segment.',
			'E009'	=> 'The scale is activated and the calculated weight exceeds the tolerance (IBSCALETOL) or if the weight is unequal to the weight transmitted in T530.',
			'E010'	=> 'T205 is transmitted and 2 kg are exceeded.',
			'E011'	=> 'The transaction data cannot be stored after a label print.',
			'E012'	=> 'The check digit of the parcel number transmitted in T400 is wrong.',
			'E013'	=> 'Product code which is not permitted in the consignee’s country.',
			'E014'	=> 'The shipping date of an express parcel in T545 is not equal to the current date.',
			'E015'	=> 'All express parcels have to be processed until 15:25 PM, as the data transfer for the notification is affected at 15:30 PM.',
			'E016'	=> 'E016 is generated if for example T8 is transmitted as a product/service code, but no 8 o’clock delivery is possible for the transmitted zip code.',
			'E017'	=> 'If S1 or SE is transmitted as product code and the current day is not a Friday or if there are working days between the current day and the next possible Saturda.',
			'E018'	=> ' A parcel number may only once be transmitted to the system.',
			'E019'	=> 'a wrong parcel number of a product/service or a parcel number with a wrong depot has been transmitted.',
			'E999'	=> 'General central system error.',
			'E570'	=> '<Tag> is missing.',
			'E805'	=> 'Invalid field value.',
			'E998'	=> 'No record found.',
			'E028'	=> 'Invalid tag stream.',
		);
		return	$error;
	}

	/**
	 * 获取错误信息
	 * @staticvar int $serial_no
	 * @param string $status_code
	 * @param mixed $status_message
	 * @param string $label
	 * @param boolean $is_detail
	 */
	public function tagToField($tag){
		$tags	= array(
			'T100'	=> L('consignee').L('country_no'),
			'T330'	=> L('consignee').L('post_code'),
			'T400'	=> L('consignee').L('track_no'),
			'T530'	=> L('package_bg').L('weight'),
			'T805'	=> 'GLS Account',
			'T810'	=> L('consigner').'1',
			'T811'	=> L('consigner').'2',
			'T812'	=> L('consigner').'3',
			'T820'	=> L('consigner').L('address'),
			'T821'	=> L('consigner').L('country_no'),
			'T822'	=> L('consigner').L('post_code'),
			'T823'	=> L('consigner').L('city'),
			'T854'	=> L('deal_no'),
			'T860'	=> L('consignee').'1',
			'T861'	=> L('consignee').'2',
			'T862'	=> L('consignee').'3',
			'T863'	=> L('consignee').L('address').'1+'.L('address').'2',
			'T864'	=> L('consignee').L('city'),
			'T921'	=> L('custom_barcode'),
			'T8700'	=> 'GLS Receiving Station code',
			'T8914'	=> 'GLS ContactID',
			'T8915'	=> 'GLS CustomerID',
			'T545'	=> L('go_date'),
			'T1229'	=> L('consignee').'Email',
		);
		return	$tags[$tag];
	}

	//gls允许手动删除发货订单
	public function getAllowManualDeleteSale($sale_order_id){
		$where	.= 's.id in('.implode(',', (array)$sale_order_id).')';
		$where	.= ' and s.sale_order_state='.C('SALE_ORDER_STATE_EXPORTING');
		$where	.= ' and EXISTS(select 1 from express e where s.express_id=e.id and e.enable_api=1 and e.company_id in('.implode(',',C('GLS_API_EXPRESS_ID')).') )';
		$where	.= ' and d.abbr_district_name not in('.  implode(',', C('GLS_NOT_USE_COUNTRIES')).')';
		$ids	= M('SaleOrder')->alias('s')->join('left join sale_order_addition b on s.id=b.sale_order_id inner join district d on b.country_id=d.id')
				->where($where)->getField('s.id',true);
		return $ids;
	}

	//删除导出中GLS订单
	public function deleteGlsShip($sale_order_id){
		$sale_order	= D('SaleOrder');
		$data['track_no']	= '';
		$data['track_no_update_tips']	= 1;
		$sale_order->where('id='.$sale_order_id)->save($data);
		$sale_order->updateSaleOrderStateById($sale_order_id, C('SALE_ORDER_STATE_PENDING'), 'gls api delete exporting');
	}

	//是否需要清空追踪单号
	public function needClearGlsTrackNo($data){
		$sale_order_id	= $data['id'];
		$sale	= M('SaleOrder')->field('sale_order.id,sale_order_state')
			->join('left join sale_order_addition b on sale_order.id=b.sale_order_id inner join district d on b.country_id=d.id')
			->where('sale_order.id='.$sale_order_id.' and EXISTS(select 1 from express e where sale_order.express_id=e.id and e.enable_api=1 and e.company_id in('.implode(',',C('GLS_API_EXPRESS_ID')).') )
				and d.abbr_district_name not in('.  implode(',', C('GLS_NOT_USE_COUNTRIES')).')')->find();
		$need_state	= explode(',', C('AFTER_SHIPPED_STATE'));
		$need_state[]	= C('SALE_ORDER_STATE_PICKING');
		if($sale && in_array($sale['sale_order_state'], $need_state) ){
			$now	= M('Express')->where('id='.$data['express_id'].' and enable_api=1 and company_id in('.implode(',',C('GLS_API_EXPRESS_ID')).') ')->count();
			$cur_country	= '"'.SOnly('country', $data['addition'][1]['country_id'],'abbr_district_name').'"';
			if($now==0 || ($now>0&&  in_array($cur_country, C('GLS_NOT_USE_COUNTRIES'))) || ($now>0&&$sale['track_no']!=$data['track_no'])){
				$this->addDeleteTrackNo($sale_order_id);
				return true;
			}
		}
		return false;
	}

	//清空追踪单号
	public function clearGlsTrackNo($sale_order_id){
		$this->addDeleteTrackNo($sale_order_id);
		M('SaleOrder')->where('id='.$sale_order_id)->setField('track_no',NULL);
	}

	//新增GLS删除单号记录
	public function addDeleteTrackNo($sale_order_id){
		$sql	= 'insert into gls_track_no_list(track_no,warehouse_id) select track_no,warehouse_id from sale_order where is_print>0 and track_no is not null and track_no<>"" and id='.$sale_order_id;
		$this->db->query($sql);
	}

	//
	public function isUseGlsApi($sale_order_id){
		$is_use	= M('SaleOrderAddition')->where('sale_order_id='.$sale_order_id.' and EXISTS(select 1 from district d where country_id=d.id and abbr_district_name not in('.implode(',', C('GLS_NOT_USE_COUNTRIES')).'))')->count();
		return $is_use;
	}
	//导出过滤订单,瑞士不过滤
	public function filterGlsSaleOrder($sale_order_ids){
		$filter_gls_ids	= M('SaleOrderAddition')->where('sale_order_id in('.implode(',', $sale_order_ids).') and EXISTS(select 1 from district d where country_id=d.id and abbr_district_name not in('.implode(',', C('GLS_NOT_USE_COUNTRIES')).'))')->getField('sale_order_id',true);
		return $filter_gls_ids;
	}
}