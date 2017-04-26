<?php
/**
 * File for class CorreosServiceGenerar
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosServiceGenerar originally named Generar
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosServiceGenerar extends CorreosWsdlClass
{
    /**
     * Method to call the operation originally named GenerarCodigoExpedicionOp
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructPeticionGenerarCodigoExpedicion $_correosStructPeticionGenerarCodigoExpedicion
     * @return CorreosStructRespuestaGenerarCodigoExpedicion
     */
    public function GenerarCodigoExpedicionOp(CorreosStructPeticionGenerarCodigoExpedicion $_correosStructPeticionGenerarCodigoExpedicion)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->GenerarCodigoExpedicionOp($_correosStructPeticionGenerarCodigoExpedicion));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see CorreosWsdlClass::getResult()
     * @return CorreosStructRespuestaGenerarCodigoExpedicion
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
