<?php
/**
 * File for class CorreosServiceModificar
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosServiceModificar originally named Modificar
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosServiceModificar extends CorreosWsdlClass
{
    /**
     * Method to call the operation originally named ModificarOp
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructPeticionModificar $_correosStructPeticionModificar
     * @return CorreosStructRespuestaModificar
     */
    public function ModificarOp(CorreosStructPeticionModificar $_correosStructPeticionModificar)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->ModificarOp($_correosStructPeticionModificar));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see CorreosWsdlClass::getResult()
     * @return CorreosStructRespuestaModificar
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
