<?php
/**
 * File for class CorreosServiceValidar
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosServiceValidar originally named Validar
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosServiceValidar extends CorreosWsdlClass
{
    /**
     * Method to call the operation originally named ValidarDatosOp
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructValidarDatos $_correosStructValidarDatos
     * @return CorreosStructRespuestaValidarDatos
     */
    public function ValidarDatosOp(CorreosStructValidarDatos $_correosStructValidarDatos)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->ValidarDatosOp($_correosStructValidarDatos));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see CorreosWsdlClass::getResult()
     * @return CorreosStructRespuestaValidarDatos
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
