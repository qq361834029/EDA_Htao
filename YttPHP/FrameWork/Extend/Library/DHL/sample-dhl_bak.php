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


/******************************
 * Example for DHLServiceCreate
 */
$dHLServiceCreate = new DHLServiceCreate();
// sample call for DHLServiceCreate::setSoapHeaderAuthentification() in order to initialize required SoapHeader
// sample call for DHLServiceCreate::createShipmentTD()

if($dHLServiceCreate->createShipmentTD(new DHLStructCreateShipmentTDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceCreate->getResult());
else
    print_r($dHLServiceCreate->getLastError());
	
// sample call for DHLServiceCreate::createShipmentDD()
if($dHLServiceCreate->createShipmentDD(new DHLStructCreateShipmentDDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceCreate->getResult());
else
    print_r($dHLServiceCreate->getLastError());

/******************************
 * Example for DHLServiceDelete
 */
$dHLServiceDelete = new DHLServiceDelete();
// sample call for DHLServiceDelete::setSoapHeaderAuthentification() in order to initialize required SoapHeader
$dHLServiceDelete->setSoapHeaderAuthentification(new DHLStructAuthentificationType(/*** update parameters list ***/));
// sample call for DHLServiceDelete::deleteShipmentTD()
if($dHLServiceDelete->deleteShipmentTD(new DHLStructDeleteShipmentTDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceDelete->getResult());
else
    print_r($dHLServiceDelete->getLastError());
// sample call for DHLServiceDelete::deleteShipmentDD()
if($dHLServiceDelete->deleteShipmentDD(new DHLStructDeleteShipmentDDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceDelete->getResult());
else
    print_r($dHLServiceDelete->getLastError());

/**************************
 * Example for DHLServiceDo
 */
$dHLServiceDo = new DHLServiceDo();
// sample call for DHLServiceDo::setSoapHeaderAuthentification() in order to initialize required SoapHeader
$dHLServiceDo->setSoapHeaderAuthentification(new DHLStructAuthentificationType(/*** update parameters list ***/));
// sample call for DHLServiceDo::doManifestTD()
if($dHLServiceDo->doManifestTD(new DHLStructDoManifestTDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceDo->getResult());
else
    print_r($dHLServiceDo->getLastError());
// sample call for DHLServiceDo::doManifestDD()
if($dHLServiceDo->doManifestDD(new DHLStructDoManifestDDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceDo->getResult());
else
    print_r($dHLServiceDo->getLastError());

/***************************
 * Example for DHLServiceGet
 */
$dHLServiceGet = new DHLServiceGet();
// sample call for DHLServiceGet::setSoapHeaderAuthentification() in order to initialize required SoapHeader
$dHLServiceGet->setSoapHeaderAuthentification(new DHLStructAuthentificationType(/*** update parameters list ***/));
// sample call for DHLServiceGet::getLabelTD()
if($dHLServiceGet->getLabelTD(new DHLStructGetLabelTDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceGet->getResult());
else
    print_r($dHLServiceGet->getLastError());
// sample call for DHLServiceGet::getLabelDD()
if($dHLServiceGet->getLabelDD(new DHLStructGetLabelDDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceGet->getResult());
else
    print_r($dHLServiceGet->getLastError());
// sample call for DHLServiceGet::getVersion()
if($dHLServiceGet->getVersion(new DHLStructVersion(/*** update parameters list ***/)))
    print_r($dHLServiceGet->getResult());
else
    print_r($dHLServiceGet->getLastError());
// sample call for DHLServiceGet::getExportDocTD()
if($dHLServiceGet->getExportDocTD(new DHLStructGetExportDocTDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceGet->getResult());
else
    print_r($dHLServiceGet->getLastError());
// sample call for DHLServiceGet::getExportDocDD()
if($dHLServiceGet->getExportDocDD(new DHLStructGetExportDocDDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceGet->getResult());
else
    print_r($dHLServiceGet->getLastError());
// sample call for DHLServiceGet::getManifestDD()
if($dHLServiceGet->getManifestDD(new DHLStructGetManifestDDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceGet->getResult());
else
    print_r($dHLServiceGet->getLastError());

/****************************
 * Example for DHLServiceBook
 */
$dHLServiceBook = new DHLServiceBook();
// sample call for DHLServiceBook::setSoapHeaderAuthentification() in order to initialize required SoapHeader
$dHLServiceBook->setSoapHeaderAuthentification(new DHLStructAuthentificationType(/*** update parameters list ***/));
// sample call for DHLServiceBook::bookPickup()
if($dHLServiceBook->bookPickup(new DHLStructBookPickupRequest(/*** update parameters list ***/)))
    print_r($dHLServiceBook->getResult());
else
    print_r($dHLServiceBook->getLastError());

/******************************
 * Example for DHLServiceCancel
 */
$dHLServiceCancel = new DHLServiceCancel();
// sample call for DHLServiceCancel::setSoapHeaderAuthentification() in order to initialize required SoapHeader
$dHLServiceCancel->setSoapHeaderAuthentification(new DHLStructAuthentificationType(/*** update parameters list ***/));
// sample call for DHLServiceCancel::cancelPickup()
if($dHLServiceCancel->cancelPickup(new DHLStructCancelPickupRequest(/*** update parameters list ***/)))
    print_r($dHLServiceCancel->getResult());
else
    print_r($dHLServiceCancel->getLastError());

/******************************
 * Example for DHLServiceUpdate
 */
$dHLServiceUpdate = new DHLServiceUpdate();
// sample call for DHLServiceUpdate::setSoapHeaderAuthentification() in order to initialize required SoapHeader
$dHLServiceUpdate->setSoapHeaderAuthentification(new DHLStructAuthentificationType(/*** update parameters list ***/));
// sample call for DHLServiceUpdate::updateShipmentDD()
if($dHLServiceUpdate->updateShipmentDD(new DHLStructUpdateShipmentDDRequest(/*** update parameters list ***/)))
    print_r($dHLServiceUpdate->getResult());
else
    print_r($dHLServiceUpdate->getLastError());
