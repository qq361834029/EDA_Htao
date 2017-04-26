<?php
/**
 * File for class DHLStructGetExportDocTDRequest
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructGetExportDocTDRequest originally named GetExportDocTDRequest
 * Documentation : The identifier for the TD shipment for which the export document url is requested. The version of the webservice implementation for which the requesting client is developed.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructGetExportDocTDRequest extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The ShipmentNumber
     * Meta informations extracted from the WSDL
     * - documentation : To request TD export documents, ShipmentNumber. AirwayBill is required. This parent element inherits from ShipmentNumberType, therefore all following subelements are valid according to schema, however the web service accepts airwayBill only.
     * - maxOccurs : 999
     * @var DHLStructShipmentNumberType
     */
    public $ShipmentNumber;
    /**
     * The DocType
     * @var DHLEnumDocType
     */
    public $DocType;
    /**
     * Constructor method for GetExportDocTDRequest
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructShipmentNumberType $_shipmentNumber
     * @param DHLEnumDocType $_docType
     * @return DHLStructGetExportDocTDRequest
     */
    public function __construct($_version = NULL,$_shipmentNumber = NULL,$_docType = NULL)
    {
        parent::__construct(array('Version'=>$_version,'ShipmentNumber'=>$_shipmentNumber,'DocType'=>$_docType),false);
    }
    /**
     * Get Version value
     * @return DHLStructVersion|null
     */
    public function getVersion()
    {
        return $this->Version;
    }
    /**
     * Set Version value
     * @param DHLStructVersion $_version the Version
     * @return DHLStructVersion
     */
    public function setVersion($_version)
    {
        return ($this->Version = $_version);
    }
    /**
     * Get ShipmentNumber value
     * @return DHLStructShipmentNumberType|null
     */
    public function getShipmentNumber()
    {
        return $this->ShipmentNumber;
    }
    /**
     * Set ShipmentNumber value
     * @param DHLStructShipmentNumberType $_shipmentNumber the ShipmentNumber
     * @return DHLStructShipmentNumberType
     */
    public function setShipmentNumber($_shipmentNumber)
    {
        return ($this->ShipmentNumber = $_shipmentNumber);
    }
    /**
     * Get DocType value
     * @return DHLEnumDocType|null
     */
    public function getDocType()
    {
        return $this->DocType;
    }
    /**
     * Set DocType value
     * @uses DHLEnumDocType::valueIsValid()
     * @param DHLEnumDocType $_docType the DocType
     * @return DHLEnumDocType
     */
    public function setDocType($_docType)
    {
        if(!DHLEnumDocType::valueIsValid($_docType))
        {
            return false;
        }
        return ($this->DocType = $_docType);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructGetExportDocTDRequest
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
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
