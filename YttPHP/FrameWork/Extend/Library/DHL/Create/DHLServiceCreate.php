<?php
/**
 * File for class DHLServiceCreate
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLServiceCreate originally named Create
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLServiceCreate extends DHLWsdlClass
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
     * Method to call the operation originally named createShipmentTD
     * Documentation : Creates TD shipments. The shipment data. The status of the createShipment operation and the identifier for the shipment. The authentication data and the shipment data. The status of the operation and the shipment identifier.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructCreateShipmentTDRequest $_dHLStructCreateShipmentTDRequest
     * @return DHLStructCreateShipmentResponse
     */
    public function createShipmentTD(DHLStructCreateShipmentTDRequest $_dHLStructCreateShipmentTDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->createShipmentTD($_dHLStructCreateShipmentTDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named createShipmentDD
     * Documentation : Creates DD shipments. The shipment data. The status of the createShipment operation and the identifier for the shipment. The authentication data and the shipment data. The status of the operation and the shipment identifier.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructCreateShipmentDDRequest $_dHLStructCreateShipmentDDRequest
     * @return DHLStructCreateShipmentResponse
     */
    public function createShipmentDD(DHLStructCreateShipmentDDRequest $_dHLStructCreateShipmentDDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->createShipmentDD($_dHLStructCreateShipmentDDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see DHLWsdlClass::getResult()
     * @return DHLStructCreateShipmentResponse
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
