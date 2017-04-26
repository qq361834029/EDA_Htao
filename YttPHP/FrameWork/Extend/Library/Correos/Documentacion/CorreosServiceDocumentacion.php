<?php
/**
 * File for class CorreosServiceDocumentacion
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosServiceDocumentacion originally named Documentacion
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosServiceDocumentacion extends CorreosWsdlClass
{
    /**
     * Method to call the operation originally named DocumentacionAduaneraOp
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructSolicitudDocumentacionAduanera $_correosStructSolicitudDocumentacionAduanera
     * @return CorreosStructRespuestaSolicitudDocumentacionAduanera
     */
    public function DocumentacionAduaneraOp(CorreosStructSolicitudDocumentacionAduanera $_correosStructSolicitudDocumentacionAduanera)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->DocumentacionAduaneraOp($_correosStructSolicitudDocumentacionAduanera));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named DocumentacionAduaneraCN23CP71Op
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructSolicitudDocumentacionAduaneraCN23CP71 $_correosStructSolicitudDocumentacionAduaneraCN23CP71
     * @return CorreosStructRespuestaSolicitudDocumentacionAduaneraCN23CP71
     */
    public function DocumentacionAduaneraCN23CP71Op(CorreosStructSolicitudDocumentacionAduaneraCN23CP71 $_correosStructSolicitudDocumentacionAduaneraCN23CP71)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->DocumentacionAduaneraCN23CP71Op($_correosStructSolicitudDocumentacionAduaneraCN23CP71));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see CorreosWsdlClass::getResult()
     * @return CorreosStructRespuestaSolicitudDocumentacionAduanera|CorreosStructRespuestaSolicitudDocumentacionAduaneraCN23CP71
     */
    public function getResult()
    {
        return parent::getResult();
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
