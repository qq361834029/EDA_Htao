<?php
/**
 * File for class CorreosServicePre
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosServicePre originally named Pre
 * @package Correos
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosServicePre extends CorreosWsdlClass
{
    /**
     * Method to call the operation originally named PreRegistro
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructPreregistroEnvio $_correosStructPreregistroEnvio
     * @return CorreosStructRespuestaPreregistroEnvio
     */
    public function PreRegistro(CorreosStructPreregistroEnvio $_correosStructPreregistroEnvio)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->PreRegistro($_correosStructPreregistroEnvio));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named PreRegistroCodEnvio
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructPreregistroCodEnvio $_correosStructPreregistroCodEnvio
     * @return CorreosStructRespuestaPreregistroCodEnvio
     */
    public function PreRegistroCodEnvio(CorreosStructPreregistroCodEnvio $_correosStructPreregistroCodEnvio)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->PreRegistroCodEnvio($_correosStructPreregistroCodEnvio));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named PreRegistroCodExpedicion
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructPreregistroCodExpedicion $_correosStructPreregistroCodExpedicion
     * @return CorreosStructRespuestaPreregistroCodExpedicion
     */
    public function PreRegistroCodExpedicion(CorreosStructPreregistroCodExpedicion $_correosStructPreregistroCodExpedicion)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->PreRegistroCodExpedicion($_correosStructPreregistroCodExpedicion));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named PreRegistroIdaVuelta
     * @uses CorreosWsdlClass::getSoapClient()
     * @uses CorreosWsdlClass::setResult()
     * @uses CorreosWsdlClass::saveLastError()
     * @param CorreosStructPeticionPreRegistroIdaVta $_correosStructPeticionPreRegistroIdaVta
     * @return CorreosStructRespuestaPreRegistroIdaVta
     */
    public function PreRegistroIdaVuelta(CorreosStructPeticionPreRegistroIdaVta $_correosStructPeticionPreRegistroIdaVta)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->PreRegistroIdaVuelta($_correosStructPeticionPreRegistroIdaVta));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see CorreosWsdlClass::getResult()
     * @return CorreosStructRespuestaPreregistroCodEnvio|CorreosStructRespuestaPreregistroCodExpedicion|CorreosStructRespuestaPreregistroEnvio|CorreosStructRespuestaPreRegistroIdaVta
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
