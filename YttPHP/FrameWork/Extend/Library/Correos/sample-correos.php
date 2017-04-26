<?php
/**
 * Test with Correos for 'var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml'
 * @package Correos
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
ini_set('memory_limit','512M');
ini_set('display_errors',true);
error_reporting(-1);
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
$correosServicePre = new CorreosServicePre();
// sample call for CorreosServicePre::PreRegistro()
if($correosServicePre->PreRegistro(new CorreosStructPreregistroEnvio(/*** update parameters list ***/)))
    print_r($correosServicePre->getResult());
else
    print_r($correosServicePre->getLastError());
// sample call for CorreosServicePre::PreRegistroCodEnvio()
if($correosServicePre->PreRegistroCodEnvio(new CorreosStructPreregistroCodEnvio(/*** update parameters list ***/)))
    print_r($correosServicePre->getResult());
else
    print_r($correosServicePre->getLastError());
// sample call for CorreosServicePre::PreRegistroCodExpedicion()
if($correosServicePre->PreRegistroCodExpedicion(new CorreosStructPreregistroCodExpedicion(/*** update parameters list ***/)))
    print_r($correosServicePre->getResult());
else
    print_r($correosServicePre->getLastError());
// sample call for CorreosServicePre::PreRegistroIdaVuelta()
if($correosServicePre->PreRegistroIdaVuelta(new CorreosStructPeticionPreRegistroIdaVta(/*** update parameters list ***/)))
    print_r($correosServicePre->getResult());
else
    print_r($correosServicePre->getLastError());

/*************************************
 * Example for CorreosServiceSolicitud
 */
$correosServiceSolicitud = new CorreosServiceSolicitud();
// sample call for CorreosServiceSolicitud::SolicitudEtiquetaRefCliOp()
if($correosServiceSolicitud->SolicitudEtiquetaRefCliOp(new CorreosStructSolicitudEtiquetaRefCli(/*** update parameters list ***/)))
    print_r($correosServiceSolicitud->getResult());
else
    print_r($correosServiceSolicitud->getLastError());
// sample call for CorreosServiceSolicitud::SolicitudEtiquetaExpOp()
if($correosServiceSolicitud->SolicitudEtiquetaExpOp(new CorreosStructSolicitudEtiquetaExp(/*** update parameters list ***/)))
    print_r($correosServiceSolicitud->getResult());
else
    print_r($correosServiceSolicitud->getLastError());
// sample call for CorreosServiceSolicitud::SolicitudEtiquetaOp()
if($correosServiceSolicitud->SolicitudEtiquetaOp(new CorreosStructSolicitudEtiqueta(/*** update parameters list ***/)))
    print_r($correosServiceSolicitud->getResult());
else
    print_r($correosServiceSolicitud->getLastError());

/***********************************
 * Example for CorreosServiceValidar
 */
$correosServiceValidar = new CorreosServiceValidar();
// sample call for CorreosServiceValidar::ValidarDatosOp()
if($correosServiceValidar->ValidarDatosOp(new CorreosStructValidarDatos(/*** update parameters list ***/)))
    print_r($correosServiceValidar->getResult());
else
    print_r($correosServiceValidar->getLastError());

/**********************************
 * Example for CorreosServiceAnular
 */
$correosServiceAnular = new CorreosServiceAnular();
// sample call for CorreosServiceAnular::AnularOp()
if($correosServiceAnular->AnularOp(new CorreosStructPeticionAnular(/*** update parameters list ***/)))
    print_r($correosServiceAnular->getResult());
else
    print_r($correosServiceAnular->getLastError());

/*************************************
 * Example for CorreosServiceModificar
 */
$correosServiceModificar = new CorreosServiceModificar();
// sample call for CorreosServiceModificar::ModificarOp()
if($correosServiceModificar->ModificarOp(new CorreosStructPeticionModificar(/*** update parameters list ***/)))
    print_r($correosServiceModificar->getResult());
else
    print_r($correosServiceModificar->getLastError());

/*****************************************
 * Example for CorreosServiceDocumentacion
 */
$correosServiceDocumentacion = new CorreosServiceDocumentacion();
// sample call for CorreosServiceDocumentacion::DocumentacionAduaneraOp()
if($correosServiceDocumentacion->DocumentacionAduaneraOp(new CorreosStructSolicitudDocumentacionAduanera(/*** update parameters list ***/)))
    print_r($correosServiceDocumentacion->getResult());
else
    print_r($correosServiceDocumentacion->getLastError());
// sample call for CorreosServiceDocumentacion::DocumentacionAduaneraCN23CP71Op()
if($correosServiceDocumentacion->DocumentacionAduaneraCN23CP71Op(new CorreosStructSolicitudDocumentacionAduaneraCN23CP71(/*** update parameters list ***/)))
    print_r($correosServiceDocumentacion->getResult());
else
    print_r($correosServiceDocumentacion->getLastError());

/********************************
 * Example for CorreosServiceBaja
 */
$correosServiceBaja = new CorreosServiceBaja();
// sample call for CorreosServiceBaja::BajaOp()
if($correosServiceBaja->BajaOp(new CorreosStructPeticionBaja(/*** update parameters list ***/)))
    print_r($correosServiceBaja->getResult());
else
    print_r($correosServiceBaja->getLastError());

/***********************************
 * Example for CorreosServiceGenerar
 */
$correosServiceGenerar = new CorreosServiceGenerar();
// sample call for CorreosServiceGenerar::GenerarCodigoExpedicionOp()
if($correosServiceGenerar->GenerarCodigoExpedicionOp(new CorreosStructPeticionGenerarCodigoExpedicion(/*** update parameters list ***/)))
    print_r($correosServiceGenerar->getResult());
else
    print_r($correosServiceGenerar->getLastError());

/****************************************
 * Example for CorreosServiceReexpedicion
 */
$correosServiceReexpedicion = new CorreosServiceReexpedicion();
// sample call for CorreosServiceReexpedicion::Reexpedicion()
if($correosServiceReexpedicion->Reexpedicion(new CorreosStructPeticionReexpedicion(/*** update parameters list ***/)))
    print_r($correosServiceReexpedicion->getResult());
else
    print_r($correosServiceReexpedicion->getLastError());
