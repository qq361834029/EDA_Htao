<?php
/**
 * File for class CorreosServiceSolicitud
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosServiceSolicitud originally named Solicitud
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosServiceSolicitud extends CorreosWsdlClass
{
    /**
     * Method to call the operation originally named SolicitudEtiquetaRefCliOp
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructSolicitudEtiquetaRefCli $_correosStructSolicitudEtiquetaRefCli
     * @return CorreosStructRespuestaSolicitudEtiquetaRefCli
     */
    public function SolicitudEtiquetaRefCliOp(CorreosStructSolicitudEtiquetaRefCli $_correosStructSolicitudEtiquetaRefCli)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->SolicitudEtiquetaRefCliOp($_correosStructSolicitudEtiquetaRefCli));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named SolicitudEtiquetaExpOp
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructSolicitudEtiquetaExp $_correosStructSolicitudEtiquetaExp
     * @return CorreosStructRespuestaSolicitudEtiquetaExp
     */
    public function SolicitudEtiquetaExpOp(CorreosStructSolicitudEtiquetaExp $_correosStructSolicitudEtiquetaExp)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->SolicitudEtiquetaExpOp($_correosStructSolicitudEtiquetaExp));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named SolicitudEtiquetaOp
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructSolicitudEtiqueta $_correosStructSolicitudEtiqueta
     * @return CorreosStructRespuestaSolicitudEtiqueta
     */
    public function SolicitudEtiquetaOp(CorreosStructSolicitudEtiqueta $_correosStructSolicitudEtiqueta)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->SolicitudEtiquetaOp($_correosStructSolicitudEtiqueta));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see CorreosWsdlClass::getResult()
     * @return CorreosStructRespuestaSolicitudEtiqueta|CorreosStructRespuestaSolicitudEtiquetaExp|CorreosStructRespuestaSolicitudEtiquetaRefCli
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
