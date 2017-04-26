<?php
/**
 * Test with DHL for 'var/wsdltophp.com/storage/wsdls/de5d93845b86cf893b52c336479a60f2/wsdl.xml'
 * @package DHL
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
set_time_limit(0);
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

function outPutResult($method, $code, $message, $requestTime, $returnTime, $status = 'Abnormal'){
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
	echo '请求状态: ' . $statusTitle . '<br />';
	echo '请求时间: ' . @date('Y-m-d H:i:s', $requestTime) . '<br />';
	echo '返回时间: ' . @date('Y-m-d H:i:s', $returnTime) . '<br />';
	echo '请求耗时: ' . ($returnTime - $requestTime) . '<br />';
	echo $codeLabel . ': ' . $code . '<br />';
	if (is_array($message)) {
		$message	= array_unique($message);
	}
	if (!is_array($message) || count($message) == 1) {
		echo $msgLabel . ': ' . (is_array($message) ? reset($message) : $message) . '<br />';
	} else {
		echo $msgLabel . ': <br />';
		$i	= 0;
		foreach ($message as $msg) {
			echo (++$i) . '. ' . $msg . '<br />';
		}
	}
}
/******************************
 * Example for DHLServiceCreate
 */
$debug									= isset($_GET['debug']) && $_GET['debug'] == 1 ? true : false;
$sandbox								= isset($_GET['sandbox']) && $_GET['sandbox'] == 0 ? false : true;
$config									= include dirname(__FILE__) . '/config' . ($sandbox ? '-sandbox' : '') . '.php';
$wsdl									= array();
$wsdl[DHLWsdlClass::WSDL_URL]			= $config['WSDL_URL'];
$wsdl[DHLWsdlClass::WSDL_CACHE_WSDL]	= WSDL_CACHE_NONE;
$wsdl[DHLWsdlClass::WSDL_TRACE]			= true;
$wsdl[DHLWsdlClass::WSDL_LOGIN]			= $config['WSDL_LOGIN'];
$wsdl[DHLWsdlClass::WSDL_PASSWD]		= $config['WSDL_PASSWD'];
$_user									= $config['_user'];
$_signature								= $config['_signature'];
$_accountNumber							= NULL;
$_type									= 0;
$_version								= array(
											'majorRelease'	=> 1,
											'minorRelease'	=> 0,
										);
$EKP									= $config['EKP'];
$partnerID								= $config['partnerID'];
$ProductCode							= 'EPN';
$PackageType							= 'PK';
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
					'ProductCode'	=> $ProductCode,
					'ShipmentDate'	=> @date('Y-m-d'),//？？？发货日期
					'EKP'			=> $EKP,
					'Attendance'	=> array (
						'partnerID' => $partnerID,//？？？现场有合作伙伴ID。即从14位DHL帐户号码提取最后2位数字。 例如。如果DHL账号为“50000000087201”则取01。
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',//字段长度<=22
						'LengthInCM' => '50',//非必填
						'WidthInCM' => '30',//非必填
						'HeightInCM' => '15',//非必填
						'PackageType' => $PackageType,//？？？包裹类型
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
					'ProductCode'	=> $ProductCode,
					'ShipmentDate'	=> @date('Y-m-d'),
					'EKP'			=> $EKP,
					'Attendance'	=> array (
						'partnerID' => $partnerID,
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',
						'LengthInCM' => '50',
						'WidthInCM' => '30',
						'HeightInCM' => '15',
						'PackageType' => $PackageType,
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
//					'Address' => array (
//						'streetName'	=> 'Marktplatz',
//						'streetNumber'	=> '0',//
//						'Zip'			=> array (
//							'other'			=> '70173',
//						),
//						'city'			=> 'Stuttgart',
//						'Origin'		=> array (
//							'countryISOCode' => 'DE',
//						),
//					),
					'Packstation' => array (
						'PackstationNumber'	=> '110',
						'PostNumber'		=> '53111110',//
						'Zip'				=> '53111',
						'City'				=> 'Bonn',
					),
//					'Postfiliale' => array (
//						'PostfilialNumber'	=> '103',
//						'PostNumber'		=> '54232576',//
//						'Zip'				=> '10117',
//						'City'				=> 'Stuttgart',
//					),
					'Communication' => array (
						'phone' => '0049-30-763291',
						'contactPerson'=>'Contact Person',
					),
				),
			),
		);
		
		$_shipment		= array();
		$_shipment[]	= $_shipmentOrder;
		$_shipment[]	= $_tmp;
		$limit			= isset($_GET['limit']) && $_GET['limit'] > 0 ? intval($_GET['limit']) : $config['CREATE_LIMIT'];
		if ($limit > 0) {
			$_shipment	= array_splice($_shipment, 0, $limit);
		}
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
			'SequenceNumber'=> '1',//直接使用销售单id
			'Shipment'		=> array (
				'ShipmentDetails'	=> array (
					'ProductCode'	=> $ProductCode,
					'ShipmentDate'	=> @date('Y-m-d'),//？？？发货日期
					'EKP'			=> $EKP,
					'Attendance'	=> array (
						'partnerID' => $partnerID,//？？？现场有合作伙伴ID。即从14位DHL帐户号码提取最后2位数字。 例如。如果DHL账号为“50000000087201”则取01。
					),
					'ShipmentItem' => array (
						'WeightInKG' => '10',//字段长度<=22
						'LengthInCM' => '50',//非必填
						'WidthInCM' => '30',//非必填
						'HeightInCM' => '15',//非必填
						'PackageType' => $PackageType,//？？？包裹类型
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
		$shipmentNumber	= array(
			'shipmentNumber' => 'TEST412762834141',
		);
		$property		= 'CreationState';
		break;
}
$requestTime					= time();
$DHLServiceName					= $requestTypeClass[$requestType];
$method							= $DHLServiceName . '::' . $requestType;
try {
	$dHLService						= new $DHLServiceName($wsdl);
	$dHLStructAuthentificationType	= new DHLStructAuthentificationType($_user, $_signature, $_accountNumber, $_type);
	// sample call for $DHLServiceName::setSoapHeaderAuthentification() in order to initialize required SoapHeader
	$dHLService->setSoapHeaderAuthentification($dHLStructAuthentificationType);
	$requestClassName				= 'DHLStruct' . ($requestType	== 'getVersion' ? 'Version' : ucfirst($requestType) . 'Request');
	if ($requestType == 'updateShipmentDD') {
		$requestClass					= new $requestClassName($_version, $shipmentNumber, $_shipmentOrder);
	} elseif ($requestType == 'getVersion') {
		$requestClass					= new $requestClassName();
	}else {
		$requestClass					= new $requestClassName($_version, $_shipment);
	}
	try {
		$request_status					= $dHLService->$requestType($requestClass);
		$returnTime						= time();
		if($request_status){
			$result		= (Object)$dHLService->getResult();
			$status		= property_exists($result, 'Status') ? (Object)$result->Status : (Object)$result->status;
			outPutResult($method, $status->StatusCode, $status->StatusMessage, $requestTime, $returnTime, 'Success');
			$i			= 0;
			echo '明细状态:' . '<br />';
			if ($requestType == 'updateShipmentDD') {
				$result->$property	= array($result->$property);
			}
			if ($property && property_exists($result, $property) && is_array($result->$property) && !empty($result->$property)) {
				$result->$property	= array_reverse($result->$property);
				echo '<hr />';
				foreach ($result->$property as $val) {
					$i++;
					$j				= 0;
					$value			= (Object)$val;
					$shipmentNumber	= $value->ShipmentNumber ? $value->ShipmentNumber->shipmentNumber : '';
					$detail_status	= property_exists($value, 'Status') ? $value->Status : $value;
					echo $i . '<br />';
					if (property_exists($value, 'SequenceNumber')) {
						echo $i . '.' . (++$j) . ' 序列号: ' . $value->SequenceNumber . '<br />';
					}
					echo $i . '.' . (++$j) . ' 装运编号: ' . $shipmentNumber . '<br />';
					if (property_exists($value, 'Labelurl')) {
						echo $i . '.' . (++$j) . ' 标签地址: ' . $value->Labelurl . '<br />';
					}
					echo $i . '.' . (++$j) . ' 状态代码: ' . $detail_status->StatusCode . '<br />';
					$statusMessage	= $detail_status->StatusMessage;
					$is_array		= is_array($statusMessage);
					if ($is_array) {
						$statusMessage	= array_unique($statusMessage);
					}
					echo $i . '.' . (++$j) . ' 状态信息: ';
					if (!$is_array || count($statusMessage) == 1) {
						echo ($is_array ? reset($statusMessage) : $statusMessage) . '<br />';
					} else {
						echo '<br />';
						$k	= 0;
						foreach ($statusMessage as $msg) {
							echo $i . '.' . $j . '.' . (++$k) . ' ' . $msg . '<br />';
						}
					}
					echo '<hr />';
				}
			}
			if ($debug) {
				echo '<br /><br /><br /><br />';
				print_r($result);
			}
		} else {
			$lastError	= (Object)$dHLService->getLastErrorForMethod($method);
//			$lastError->faultcode//soapenv:Server 服务端报错（报文错误等）； Client 客户端报错（超时等）；HTTP
//			$lastError->faultstring//org.apache.axis2.databinding.ADBException: Unexpected subelement Shipment；Maximum execution time of 30 seconds exceeded ； Could not connect to host
			outPutResult($method, $lastError->faultcode, $lastError->faultstring, $requestTime, $returnTime, 'Failed');
			if ($debug) {
				echo '<br /><br /><br /><br />';
				print_r($lastError);
			}
		}
	} catch (Exception $ex) {
		$returnTime	= time();
		outPutResult($method, $ex->getCode(), $ex->getMessage(), $requestTime, $returnTime);
		if ($debug) {
			echo '<br /><br /><br /><br />';
			print_r($ex);
		}
	}
} catch (Exception $ex) {
	$returnTime	= time();
	outPutResult($method, $ex->getCode(), $ex->getMessage(), $requestTime, $returnTime);
	if ($debug) {
		echo '<br /><br /><br /><br />';
		print_r($ex);
	}
}
