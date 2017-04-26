<?php
/**
 * File for class DHLServiceGet
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLServiceGet originally named Get
 * @package DHL
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLServiceGet extends DHLWsdlClass
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
     * Method to call the operation originally named getLabelTD
     * Documentation : Returns the request-url for getting a TD label. The identifier for the TD shipment for which the label url is requested. The status of the operation and the label url (if available). The authentication data and the shipment identifier. The status of the operation and the url for requesting the label.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructGetLabelTDRequest $_dHLStructGetLabelTDRequest
     * @return DHLStructGetLabelResponse
     */
    public function getLabelTD(DHLStructGetLabelTDRequest $_dHLStructGetLabelTDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->getLabelTD($_dHLStructGetLabelTDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named getLabelDD
     * Documentation : Returns the request-url for getting a DD label. The identifier for the DD shipment for which the label url is requested. The status of the operation and the label url (if available). The authentication data and the shipment identifier. The status of the operation and the url for requesting the label.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructGetLabelDDRequest $_dHLStructGetLabelDDRequest
     * @return DHLStructGetLabelResponse
     */
    public function getLabelDD(DHLStructGetLabelDDRequest $_dHLStructGetLabelDDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->getLabelDD($_dHLStructGetLabelDDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named getVersion
     * Documentation : Returns the actual version of the implementation of the whole ISService webservice. The version of webservice implementation. The version of the implementation.
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructVersion $_dHLStructVersion
     * @return DHLStructGetVersionResponse
     */
    public function getVersion(DHLStructVersion $_dHLStructVersion)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->getVersion($_dHLStructVersion));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named getExportDocTD
     * Documentation : Returns the request-url for getting a TD export document. The identifier for the TD shipment for which the export document url is requested. The status of the operation and the export document url (if available). The authentication data and the shipment identifier. The status of the operation and the url for requesting the export document.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructGetExportDocTDRequest $_dHLStructGetExportDocTDRequest
     * @return DHLStructGetExportDocResponse
     */
    public function getExportDocTD(DHLStructGetExportDocTDRequest $_dHLStructGetExportDocTDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->getExportDocTD($_dHLStructGetExportDocTDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named getExportDocDD
     * Documentation : Returns the request-url for getting a DD export document. The identifier for the DD shipment for which the export document url is requested. The status of the operation and the export document url (if available). The authentication data and the shipment identifier. The status of the operation and the url for requesting the export document.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructGetExportDocDDRequest $_dHLStructGetExportDocDDRequest
     * @return DHLStructGetExportDocResponse
     */
    public function getExportDocDD(DHLStructGetExportDocDDRequest $_dHLStructGetExportDocDDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->getExportDocDD($_dHLStructGetExportDocDDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named getManifestDD
     * Documentation : Request the manifest. The request data. The status of the getManifest operation and the manifest url. Requests the manifest. The authentication data and the shipment data. The status of the operation and the manifest url. Returns the request-url for getting a DD manifest document. The authentication data and the manifest data. The status of the operation and the url for requesting the manifest document.
     * Meta informations extracted from the WSDL
     * - SOAPHeaderNames : Authentification,Authentification
     * - SOAPHeaderNamespaces : http://dhl.de/webservice/cisbase,http://dhl.de/webservice/cisbase
     * - SOAPHeaderTypes : {@link DHLStructAuthentificationType},{@link DHLStructAuthentificationType}
     * - SOAPHeaders : required,required
     * @uses DHLWsdlClass::getSoapClient()
     * @uses DHLWsdlClass::setResult()
     * @uses DHLWsdlClass::saveLastError()
     * @param DHLStructGetManifestDDRequest $_dHLStructGetManifestDDRequest
     * @return DHLStructGetManifestDDResponse
     */
    public function getManifestDD(DHLStructGetManifestDDRequest $_dHLStructGetManifestDDRequest)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->getManifestDD($_dHLStructGetManifestDDRequest));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see DHLWsdlClass::getResult()
     * @return DHLStructGetExportDocResponse|DHLStructGetLabelResponse|DHLStructGetManifestDDResponse|DHLStructGetVersionResponse
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
