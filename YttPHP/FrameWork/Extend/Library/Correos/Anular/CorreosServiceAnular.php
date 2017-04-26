<?php
/**
 * File for class CorreosServiceAnular
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosServiceAnular originally named Anular
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosServiceAnular extends CorreosWsdlClass
{
    /**
     * Method to call the operation originally named AnularOp
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructPeticionAnular $_correosStructPeticionAnular
     * @return CorreosStructRespuestaAnular
     */
    public function AnularOp(CorreosStructPeticionAnular $_correosStructPeticionAnular)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->AnularOp($_correosStructPeticionAnular));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see CorreosWsdlClass::getResult()
     * @return CorreosStructRespuestaAnular
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
