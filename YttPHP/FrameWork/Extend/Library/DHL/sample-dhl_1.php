<?php
/**
 * Test with DHL for 'var/wsdltophp.com/storage/wsdls/de5d93845b86cf893b52c336479a60f2/wsdl.xml'
 * @package DHL
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
ini_set('memory_limit','512M');
ini_set('display_errors',true);
error_reporting(-1);
 header('Content-Type:text/html; charset=utf-8');
/**
 * Load autoload
 */
require_once dirname(__FILE__) . '/DHLAutoload.php';
/**
 * Wsdl instanciation infos. By default, nothing has to be set.
 * If you wish to override the SoapClient's options, please refer to the sample below.
 *
 * This is an associative array as:
 * - the key must be a DHLWsdlClass constant beginning with WSDL_
 * - the value must be the corresponding key value
 * Each option matches the {@link http://www.php.net/manual/en/soapclient.soapclient.php} options
 *
 * Here is below an example of how you can set the array:
 * $wsdl = array();
 * $wsdl[DHLWsdlClass::WSDL_URL] = 'var/wsdltophp.com/storage/wsdls/de5d93845b86cf893b52c336479a60f2/wsdl.xml';
 * $wsdl[DHLWsdlClass::WSDL_CACHE_WSDL] = WSDL_CACHE_NONE;
 * $wsdl[DHLWsdlClass::WSDL_TRACE] = true;
 * $wsdl[DHLWsdlClass::WSDL_LOGIN] = 'myLogin';
 * $wsdl[DHLWsdlClass::WSDL_PASSWD] = '**********';
 * etc....
 * Then instantiate the Service class as:
 * - $wsdlObject = new DHLWsdlClass($wsdl);
 */
/**
 * Examples
 */

function outPutResult($method, $code, $msg, $requestTime, $returnTime, $status = 'Abnormal'){
	switch ($status) {
		case 'Success':
			$codeLabel		= '状态代码';
			$msgLabel		= '状态信息';
			$statusTitle	= '成功';
			break;
		case 'Failed':
			$codeLabel		= '异常代码';
			$msgLabel		= '异常信息';
			$statusTitle	= '失败';
			break;
		case 'Abnormal':
		default :
			$codeLabel		= '异常代码';
			$msgLabel		= '异常信息';
			$statusTitle	= '异常';
			break;
	}
	echo '请求方法: ' . $method . '<br />';
	echo '请求状态: ' . $status . '<br />';
	echo '请求时间: ' . @date('Y-m-d H:i:s', $requestTime) . '<br />';
	echo '返回时间: ' . @date('Y-m-d H:i:s', $returnTime) . '<br />';
	echo '请求耗时: ' . ($returnTime - $requestTime) . '<br />';
	echo $codeLabel . ': ' . $code . '<br />';
	echo $msgLabel . ': ' . (is_array($msg) ? implode('<br />', $msg) : $msg) . '<br />';
}
/******************************
 * Example for DHLServiceCreate
 */

$wsdl									= array();
$wsdl[DHLWsdlClass::WSDL_URL]			= 'geschaeftskundenversand-api-1.0-sandbox.wsdl';
$wsdl[DHLWsdlClass::WSDL_CACHE_WSDL]	= WSDL_CACHE_NONE;
$wsdl[DHLWsdlClass::WSDL_TRACE]			= true;
$wsdl[DHLWsdlClass::WSDL_LOGIN]			= 'eda01';
$wsdl[DHLWsdlClass::WSDL_PASSWD]		= 'Hamburg123#';
$_user									= 'geschaeftskunden_api';
$_signature								= 'Dhl_ep_test1';
$_accountNumber							= NULL;
$_type									= 0;
$_version								= array(
											'majorRelease'	=> 1,
											'minorRelease'	=> 0,
										);
$requestTypeClass						= array(
											'createShipmentTD'	=> 'DHLServiceCreate',
											'createShipmentDD'	=> 'DHLServiceCreate',//
											'deleteShipmentTD'	=> 'DHLServiceDelete',
											'deleteShipmentDD'	=> 'DHLServiceDelete',//
											'doManifestTD'		=> 'DHLServiceDo',
											'doManifestDD'		=> 'DHLServiceDo',
											'getLabelTD'		=> 'DHLServiceGet',
											'getLabelDD'		=> 'DHLServiceGet',//
											'getVersion'		=> 'DHLServiceGet',
											'getExportDocTD'	=> 'DHLServiceGet',
											'getExportDocDD'	=> 'DHLServiceGet',
											'getManifestDD'		=> 'DHLServiceGet',
											'bookPickup'		=> 'DHLServiceBook',
											'cancelPickup'		=> 'DHLServiceCancel',
											'updateShipmentDD'	=> 'DHLServiceUpdate',//

										);
$requestType							= 'createShipmentDD';
echo '<pre>';
switch ($requestType) {
	case 'createShipmentTD':// sample call for DHLServiceCreate::createShipmentTD()
		break;
	case 'createShipmentDD':// sample call for DHLServiceCreate::createShipmentDD()
		$_shipmentOrder	= array (
			'SequenceNumber'=> '1',//直接使用销售单id
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),//？？？发货日期
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',//？？？现场有合作伙伴ID。即从14位DHL帐户号码提取最后2位数字。 例如。如果DHL账号为“50000000087201”则取01。
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',//字段长度<=22
						'LengthInCM' => '50',//非必填
						'WidthInCM' => '30',//非必填
						'HeightInCM' => '15',//非必填
						'PackageType' => 'PK',//？？？包裹类型
					),
				),
				'Shipper'	=> array (
						'Company' => array (
							'Company' => array (
									'name1' => 'Muster Company',//？？？卖家公司名称 字段长度<=30
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',//街道 字段长度<=30
							'streetNumber'	=> '47',//门牌号 字段长度<=7
							'Zip'			=> array (
								'germany'	=> '10117',//德国 长度5位
//								'england'	=> '',//英国 字段长度<=8
//								'other'		=> '',//其他 字段长度<=10
							),
							'city'			=> 'Berlin',//城市 字段长度<=20
//							'district'?地区 长度<=50
							'Origin'		=> array (//可选
								'countryISOCode' => 'DE',//可选 国家代码 长度1-3位
//								'country'//可选 国家 长度<=30位
//								'state'//可选 省/州 长度<=9位
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',//联系人
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Person' => array (
							'firstname' => 'Markus',//？？？长度<=50
							'lastname' => 'Meier',//？？？长度<=50
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '1',
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
//						'district'?地区 长度<=50
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
//						phone ?//长度<=20
//						email ?//长度<=30
//						fax ?//长度<=50
//						mobile ?//长度<=20
//						internet ?//长度<=50 网址
//						contactPerson ?	//联系人 长度<=50
					),
				),
			),
		);
		$_tmp					= array (
			'SequenceNumber'=> '2',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		$_tmp3					= array (
			'SequenceNumber'=> '3',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		$_tmp4					= array (
			'SequenceNumber'=> '4',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		$_tmp5					= array (
			'SequenceNumber'=> '5',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		$_tmp6					= array (
			'SequenceNumber'=> '6',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		$_tmp7					= array (
			'SequenceNumber'=> '7',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		$_tmp8					= array (
			'SequenceNumber'=> '8',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		$_tmp9					= array (
			'SequenceNumber'=> '9',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		$_tmp10					= array (
			'SequenceNumber'=> '10',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (//仓库地址
						'Company' => array (
							'Company' => array (
								'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Company' => array (
							'name1' => 'Markus',
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'			=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
//		$_shipment		= $_tmp;
		$_shipment		= array();
		$_shipment[]	= $_shipmentOrder;
		$_shipment[]	= $_tmp;
		$_shipment[]	= $_tmp3;
		$_shipment[]	= $_tmp4;
		$_shipment[]	= $_tmp5;
		$_shipment[]	= $_tmp6;
		$_shipment[]	= $_tmp7;
		$_shipment[]	= $_tmp8;
		$_shipment[]	= $_tmp9;
		$_shipment[]	= $_tmp10;
		$property		= 'CreationState';
		break;
	case 'deleteShipmentTD':// sample call for DHLServiceDelete::deleteShipmentTD()
		break;
	case 'deleteShipmentDD':// sample call for DHLServiceDelete::deleteShipmentDD()
		$_shipmentOrder	= array(
							'shipmentNumber' => 'TEST412762565514'
						);
		$_tmp			= array(
							'shipmentNumber' => 'TEST412762488368'
						);
		//TEST412762488514,TEST412762488515
		$property		= 'DeletionState';
		$_shipment		= array();
		break;
	case 'doManifestTD':// sample call for DHLServiceDo::doManifestTD()
		break;
	case 'doManifestDD':// sample call for DHLServiceDo::doManifestDD()
		break;
	case 'getLabelTD':// sample call for DHLServiceGet::getLabelTD()
		break;
	case 'getLabelDD':// sample call for DHLServiceGet::getLabelDD()
		$_shipmentOrder	= array(
							'shipmentNumber' => 'TEST412762488367'
						);
		$_tmp			= array(
							'shipmentNumber' => 'TEST412762488368'
						);
//		$_shipment		= $_shipmentOrder;
		$_shipment		= array($_shipmentOrder, $_tmp);
		break;
	case 'getVersion':// sample call for DHLServiceGet::getVersion()
		break;
	case 'getExportDocTD':// sample call for DHLServiceGet::getExportDocTD()
		break;
	case 'getExportDocDD':// sample call for DHLServiceGet::getExportDocDD()
		$_shipment	= array(
			'shipmentNumber' => 'TEST412762413915',
		);
		break;
	case 'getManifestDD':// sample call for DHLServiceGet::getManifestDD()
		break;
	case 'bookPickup':// sample call for DHLServiceBook::bookPickup()
		break;
	case 'cancelPickup':// sample call for DHLServiceCancel::cancelPickup()
		break;
	case 'updateShipmentDD':// sample call for DHLServiceUpdate::updateShipmentDD()
		$_shipmentOrder	= array (
			'SequenceNumber'=> '2',
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> 'EPN',
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> '5000000000',
					'Attendance'	=> array (
						'partnerID' => '01',
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => 'PK',
					),
				),
				'Shipper'	=> array (
						'Company' => array (
							'Company' => array (
									'name1' => 'Muster Company',
							),
						),
						'Address' => array (
							'streetName'	=> 'Leipziger Straße',
							'streetNumber'	=> '47',
							'Zip'			=> array (
								'germany' => '10117',
							),
							'city'			=> 'Berlin',
							'Origin'		=> array (
								'countryISOCode' => 'DE',
							),
						),
						'Communication' => array (
							'email'			=> 'max@muster.de',
							'contactPerson' => 'Max Muster',
						),
				),
				'Receiver'		=> array (
					'Company' => array (
						'Person' => array (
							'firstname' => 'Markus',//？？？长度<=50
							'lastname' => ' ',//？？？长度<=50
						),
					),
					'Address' => array (
						'streetName'	=> 'Marktplatz',
						'streetNumber'	=> '0',//
						'Zip'			=> array (
							'other'		=> '70173',
						),
						'city'			=> 'Stuttgart',
						'Origin'		=> array (
							'countryISOCode' => 'DE',
						),
					),
					'Communication' => array (
						'phone'			=> '0049-30-763291',
						'contactPerson'	=> 'Contact Person',
					),
				),
			),
		);
		$shipmentNumber	= array (
							'shipmentNumber' => 'TEST412762488981',
						);
		break;
}
$requestTime					= time();
$DHLServiceName					= $requestTypeClass[$requestType];
$dHLService						= new $DHLServiceName($wsdl);
$dHLStructAuthentificationType	= new DHLStructAuthentificationType($_user, $_signature, $_accountNumber, $_type);
// sample call for $DHLServiceName::setSoapHeaderAuthentification() in order to initialize required SoapHeader
$method							= $DHLServiceName . '::' . $requestType;
try {
	$dHLService->setSoapHeaderAuthentification($dHLStructAuthentificationType);
	$requestClassName				= 'DHLStruct' . ($requestType	== 'getVersion' ? 'Version' : ucfirst($requestType) . 'Request');
	foreach ($_shipment as $_shipmentOrder) {
		$detail_requestTime			= time();
		if ($requestType == 'updateShipmentDD') {
			$requestClass					= new $requestClassName($_version, $shipmentNumber, $_shipmentOrder);
		} elseif ($requestType == 'getVersion') {
			$requestClass					= new $requestClassName();
		}else {
			$requestClass					= new $requestClassName($_version, $_shipmentOrder);
		}
		try {
			$request_status					= $dHLService->$requestType($requestClass);
			$returnTime						= time();
			if($request_status){
				$result		= (Object)$dHLService->getResult();
				$status		= property_exists($result, 'Status') ? (Object)$result->Status : (Object)$result->status;
				outPutResult($method, $status->StatusCode, $status->StatusMessage, $detail_requestTime, $returnTime, 'Success');
				$i			= 0;
				foreach ($result->$property as $val) {
					$i++;
					$j				= 0;
					$value			= (Object)$val;
					$shipmentNumber	= $value->ShipmentNumber ? $value->ShipmentNumber->shipmentNumber : '';
					$detail_status	= property_exists($value, 'Status') ? $value->Status : $value;
					if (property_exists($value, 'SequenceNumber')) {
						echo '[' . $i . '.' . (++$j) . ']序列号: ' . $value->SequenceNumber . '<br />';
					}
					echo '[' . $i . '.' . (++$j) . ']装运编号: ' . $shipmentNumber . '<br />';
					if (property_exists($value, 'Labelurl')) {
						echo '[' . $i . '.' . (++$j) . ']标签地址: ' . $value->Labelurl . '<br />';
					}
					echo '[' . $i . '.' . (++$j) . ']状态代码: ' . $detail_status->StatusCode . '<br />';
					$statusMessage	= $detail_status->StatusMessage;
					if(is_array($statusMessage)) {
						if (count($statusMessage) == 1) {
							echo '[' . $i . '.' . (++$j) . ']状态信息: ' . reset($statusMessage) . '<br />';
						} else {
							echo '[' . $i . '.' . (++$j) . ']状态信息: ' . '<br />';
							$k					= 0;
							foreach ($statusMessage as $msg) {
								echo '[' . $i . '.' . $j . '.' . (++$k) . ']' . $msg . '<br />';
							}
						}
					} else {
						echo '[' . $i . '.' . (++$j) . ']状态信息: ' . $statusMessage . '<br />';
					}
				}
//				echo '<br /><br /><br /><br />';
//				print_r($result);
			} else {
				$lastError	= (Object)$dHLService->getLastErrorForMethod($method);
	//			$lastError->faultcode//soapenv:Server 服务端报错（报文错误等）； Client 客户端报错（超时等）；HTTP
	//			$lastError->faultstring//org.apache.axis2.databinding.ADBException: Unexpected subelement Shipment；Maximum execution time of 30 seconds exceeded ； Could not connect to host
				outPutResult($method, $lastError->faultcode, $lastError->faultstring, $detail_requestTime, $returnTime, 'Failed');
//				echo '<br /><br /><br /><br />';
//				print_r($lastError);
			}
		} catch (Exception $ex) {
			$returnTime	= time();
			outPutResult($method, $ex->getCode(), $ex->getMessage(), $detail_requestTime, $returnTime);
			echo '<br /><br /><br /><br />';
			print_r($ex);
		}		
	}
	$returnTime	= time();
	echo '结束时间: ' . @date('Y-m-d H:i:s', $returnTime) . '<br />';
	echo '总耗时: ' . ($returnTime - $requestTime) . '<br />';
} catch (Exception $ex) {
	$returnTime	= time();
	outPutResult($method, $ex->getCode(), $ex->getMessage(), $requestTime, $returnTime);
	echo '<br /><br /><br /><br />';
	print_r($ex);
}
