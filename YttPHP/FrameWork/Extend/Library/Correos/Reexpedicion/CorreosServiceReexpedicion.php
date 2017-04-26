<?php
/**
 * File for class CorreosServiceReexpedicion
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosServiceReexpedicion originally named Reexpedicion
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosServiceReexpedicion extends CorreosWsdlClass
{
    /**
     * Method to call the operation originally named Reexpedicion
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructPeticionReexpedicion $_correosStructPeticionReexpedicion
     * @return CorreosStructRespuestaReexpedicion
     */
    public function Reexpedicion(CorreosStructPeticionReexpedicion $_correosStructPeticionReexpedicion)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->Reexpedicion($_correosStructPeticionReexpedicion));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see CorreosWsdlClass::getResult()
     * @return CorreosStructRespuestaReexpedicion
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
