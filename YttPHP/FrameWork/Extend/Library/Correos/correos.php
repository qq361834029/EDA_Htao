<?php
/**
 * Test with Correos for 'var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml'
 * @package Correos
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
set_time_limit(0);
ini_set('memory_limit','512M');
ini_set('display_errors',true);
error_reporting(-1);
header('Content-Type:text/html; charset=utf-8');
/**
 * Load autoload
 */
require_once dirname(__FILE__) . '/CorreosAutoload.php';
/**
 * Wsdl instanciation infos. By default, nothing has to be set.
 * If you wish to override the SoapClient's options, please refer to the sample below.
 * 
 * This is an associative array as:
 * - the key must be a CorreosWsdlClass constant beginning with WSDL_
 * - the value must be the corresponding key value
 * Each option matches the {@link http://www.php.net/manual/en/soapclient.soapclient.php} options
 * 
 * Here is below an example of how you can set the array:
 * $wsdl = array();
 * $wsdl[CorreosWsdlClass::WSDL_URL] = 'var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml';
 * $wsdl[CorreosWsdlClass::WSDL_CACHE_WSDL] = WSDL_CACHE_NONE;
 * $wsdl[CorreosWsdlClass::WSDL_TRACE] = true;
 * $wsdl[CorreosWsdlClass::WSDL_LOGIN] = 'myLogin';
 * $wsdl[CorreosWsdlClass::WSDL_PASSWD] = '**********';
 * etc....
 * Then instantiate the Service class as: 
 * - $wsdlObject = new CorreosWsdlClass($wsdl);
 */
/**
 * Examples
 */

/*******************************
 * Example for CorreosServicePre
 */
$debug										= isset($_GET['debug']) && $_GET['debug'] == 1 ? true : false;
$sandbox									= isset($_GET['sandbox']) && $_GET['sandbox'] == 0 ? false : true;
$config										= include dirname(__FILE__) . '/config' . ($sandbox ? '-sandbox' : '') . '.php';
$Location									= $config['Location'];
$wsdl										= array();
$wsdl[CorreosWsdlClass::WSDL_URL]			= 'correos.wsdl';
$wsdl[CorreosWsdlClass::WSDL_CACHE_WSDL]	= WSDL_CACHE_NONE;
$wsdl[CorreosWsdlClass::WSDL_EXCEPTIONS]	= true;
$wsdl[CorreosWsdlClass::WSDL_TRACE]			= true;
$wsdl[CorreosWsdlClass::WSDL_LOGIN]			= $config['WSDL_LOGIN'];
$wsdl[CorreosWsdlClass::WSDL_PASSWD]		= $config['WSDL_PASSWD'];
$CodEtiquetador								= $config['CodEtiquetador'];
$CorreosServiceName							= array(
	//创建
	'PreRegistro'						=> 'Pre',
	'PreRegistroCodEnvio'				=> 'Pre',//
	'PreRegistroCodExpedicion'			=> 'Pre',
	'PreRegistroIdaVuelta'				=> 'Pre',//
	'SolicitudEtiquetaRefCliOp'			=> 'Solicitud',
	'SolicitudEtiquetaExpOp'			=> 'Solicitud',
	//获取标签
	'SolicitudEtiquetaOp'				=> 'Solicitud',
	//数据验证
	'ValidarDatosOp'					=> 'Validar',//
	//取消
	'AnularOp'							=> 'Anular',
	//修改
	'ModificarOp'						=> 'Modificar',
	//获取海关文件
	'DocumentacionAduaneraOp'			=> 'Documentacion',
	'DocumentacionAduaneraCN23CP71Op'	=> 'Documentacion',
	'BajaOp'							=> 'Baja',
	'GenerarCodigoExpedicionOp'			=> 'Generar',
	//补发，重发
	'Reexpedicion'						=> 'Reexpedicion',//

);

$CorreosStructName							= array(
	'PreRegistro'						=> 'PreregistroEnvio',
	'PreRegistroCodEnvio'				=> 'PreregistroCodEnvio',//
	'PreRegistroCodExpedicion'			=> 'PreregistroCodExpedicion',
	'PreRegistroIdaVuelta'				=> 'PeticionPreRegistroIdaVta',//
	'SolicitudEtiquetaRefCliOp'			=> 'SolicitudEtiquetaRefCli',
	'SolicitudEtiquetaExpOp'			=> 'SolicitudEtiquetaExp',
	'SolicitudEtiquetaOp'				=> 'SolicitudEtiqueta',
	'ValidarDatosOp'					=> 'ValidarDatos',//
	'AnularOp'							=> 'PeticionAnular',
	'ModificarOp'						=> 'PeticionModificar',
	'DocumentacionAduaneraOp'			=> 'SolicitudDocumentacionAduanera',
	'DocumentacionAduaneraCN23CP71Op'	=> 'SolicitudDocumentacionAduaneraCN23CP71',
	'BajaOp'							=> 'PeticionBaja',
	'GenerarCodigoExpedicionOp'			=> 'PeticionGenerarCodigoExpedicion',
	'Reexpedicion'						=> 'PeticionReexpedicion',//

);
echo '<pre>';
$requestType							= 'PreRegistro';
switch ($requestType) {
	//创建发货
	case 'PreRegistro':
		$_arrayOfValues	= include dirname(__FILE__) . '/DataPreRegistro.php';
		$_arrayOfValues['CodEtiquetador']	= $CodEtiquetador;
		break;
	//修改发货
	case 'ModificarOp':
		$_arrayOfValues	= include dirname(__FILE__) . '/DataModificarOp.php';
		$_arrayOfValues['CodEtiquetador']	= $CodEtiquetador;
		break;
	//取消发货
	case 'AnularOp':
		$_arrayOfValues	= include dirname(__FILE__) . '/DataAnularOp.php';
		break;
	//获取标签
	case 'SolicitudEtiquetaOp':
		$_arrayOfValues	= include dirname(__FILE__) . '/DataSolicitudEtiquetaOp.php';
		break;
	//补发，重发
	case 'Reexpedicion':
		break;
}
$requestTime					= time();
$CorreosServiceClass			= 'CorreosService' . $CorreosServiceName[$requestType];
$method							= $CorreosServiceClass . '::' . $requestType;
try {
	$correosService					= new $CorreosServiceClass($wsdl);
	$correosService->setLocation($Location);
	$CorreosStructClass				= 'CorreosStruct' . $CorreosStructName[$requestType];
	$correosStruct					= new $CorreosStructClass($_arrayOfValues);
	//执行请求
	$request_status					= $correosService->$requestType($correosStruct);
	$returnTime						= time();
	if($request_status){
		$result		= (Object)$correosService->getResult();
		if ($result->Resultado == 0) {
			//保存面单
			if (property_exists($result, 'Bulto') && property_exists($result->Bulto, 'Etiqueta') && property_exists($result->Bulto->Etiqueta, 'Etiqueta_pdf')) {
//				file_put_contents('correos.pdf', $result->Bulto->Etiqueta->Etiqueta_pdf->Fichero);
				unset($result->Bulto->Etiqueta->Etiqueta_pdf->Fichero);
			}
			$code		= 0;
			$message	= '';
			$status		= 'Success';
		} else {
			if (property_exists($result, 'BultoError')) {
				$code		= $result->BultoError->Error;
				$message	= $result->BultoError->DescError;
			} elseif(property_exists($result, 'ErroresValidacion') && property_exists((Object)$result->ErroresValidacion, 'ErrorVal')) {
				$code		= $result->ErroresValidacion->ErrorVal->Error;
				$message	= $result->ErroresValidacion->ErrorVal->DescError;
			} else {
				$code		= 99999;
				$message	= '未知错误';
			}
			if (empty($message)) {
				$message	= $code;
				$code		= '未知代码';
			}
			$status		= 'Failed';
		}
		outPutResult($method, $code, $message, $requestTime, $returnTime, $status);
		if ($debug) {
			echo '<br /><br /><br /><br />';
			print_r($result);
		}
	} else {
		$lastError	= (Object)$correosService->getLastErrorForMethod($method);
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