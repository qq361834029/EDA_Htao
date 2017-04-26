<?php
/**
 * File for class DHLServiceDelete
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLServiceDelete originally named Delete
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLServiceDelete extends DHLWsdlClass
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
     * Method to call the operation originally named deleteShipmentTD
     * Documentation : Deletes the requested TD shipments. The identifier for the shipment which should be deleted. The status of the deletion operation. The authentication data and the shipment identifier. The status of the operation.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructDeleteShipmentTDRequest $_dHLStructDeleteShipmentTDRequest
     * @return DHLStructDeleteShipmentResponse
     */
    public function deleteShipmentTD(DHLStructDeleteShipmentTDRequest $_dHLStructDeleteShipmentTDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->deleteShipmentTD($_dHLStructDeleteShipmentTDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named deleteShipmentDD
     * Documentation : Deletes the requested DD shipments. The identifier for the shipment which should be deleted. The status of the deletion operation. The authentication data and the shipment identifier. The status of the operation.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructDeleteShipmentDDRequest $_dHLStructDeleteShipmentDDRequest
     * @return DHLStructDeleteShipmentResponse
     */
    public function deleteShipmentDD(DHLStructDeleteShipmentDDRequest $_dHLStructDeleteShipmentDDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->deleteShipmentDD($_dHLStructDeleteShipmentDDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see DHLWsdlClass::getResult()
     * @return DHLStructDeleteShipmentResponse
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
