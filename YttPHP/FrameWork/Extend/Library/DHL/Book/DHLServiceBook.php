<?php
/**
 * File for class DHLServiceBook
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLServiceBook originally named Book
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLServiceBook extends DHLWsdlClass
{
    /**
     * Sets the Authentification SoapHeader param
     * @uses DHLWsdlClass::setSoapHeader()
     * @param DHLStructAuthentificationType $_dHLStructAuthentificationType
     * @param string $_nameSpace http://dhl.de/webservice/cisbase
     * @param bool $_mustUnderstand
     * @param string $_actor
     * @return bool true|false
     */
    public function setSoapHeaderAuthentification(DHLStructAuthentificationType $_dHLStructAuthentificationType,$_nameSpace = 'http://dhl.de/webservice/cisbase',$_mustUnderstand = false,$_actor = null)
    {
        return $this->setSoapHeader($_nameSpace,'Authentification',$_dHLStructAuthentificationType,$_mustUnderstand,$_actor);
    }
    /**
     * Method to call the operation originally named bookPickup
     * Documentation : Books a pickup order. The data for a pickup order. The status of the book pickup operation and a confirmation number (if available). The authentication data and the order data for the pickup The status of the operation and the confirmation number (if available).
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructBookPickupRequest $_dHLStructBookPickupRequest
     * @return DHLStructBookPickupResponse
     */
    public function bookPickup(DHLStructBookPickupRequest $_dHLStructBookPickupRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->bookPickup($_dHLStructBookPickupRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see DHLWsdlClass::getResult()
     * @return DHLStructBookPickupResponse
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
