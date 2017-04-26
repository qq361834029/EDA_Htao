<?php
/**
 * File for class DHLServiceCancel
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLServiceCancel originally named Cancel
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLServiceCancel extends DHLWsdlClass
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
     * Method to call the operation originally named cancelPickup
     * Documentation : Cancels a pickup order. The confirmation number of the pickup order which should be canceled. The status of cancel pickup operation. The authentication data and the confirmation number of the pickuporder, which should be canceled The status of the operation.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructCancelPickupRequest $_dHLStructCancelPickupRequest
     * @return DHLStructCancelPickupResponse
     */
    public function cancelPickup(DHLStructCancelPickupRequest $_dHLStructCancelPickupRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->cancelPickup($_dHLStructCancelPickupRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see DHLWsdlClass::getResult()
     * @return DHLStructCancelPickupResponse
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
