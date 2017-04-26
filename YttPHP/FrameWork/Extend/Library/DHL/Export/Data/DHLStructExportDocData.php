<?php
/**
 * File for class DHLStructExportDocData
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructExportDocData originally named ExportDocData
 * Documentation : The status of the getLabel operation and the url for requesting the label (if available)
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructExportDocData extends DHLWsdlClass
{
    /**
     * The ShipmentNumber
     * Meta informations extracted from the WSDL
     * - documentation : ShipmentNumber
     * @var DHLStructShipmentNumberType
     */
    public $ShipmentNumber;
    /**
     * The Status
     * Meta informations extracted from the WSDL
     * - documentation : Status of the request (value of zero means, the request was processed without error; value greater than zero indicates that an error occurred).
     * @var DHLStructStatusinformation
     */
    public $Status;
    /**
     * The ExportDocPDFData
     * Meta informations extracted from the WSDL
     * - documentation : Export doc as base64 encoded pdf data
     * - minOccurs : 0
     * @var string
     */
    public $ExportDocPDFData;
    /**
     * The ExportDocURL
     * Meta informations extracted from the WSDL
     * - documentation : URL for downloading the Export doc as pdf
     * - minOccurs : 0
     * @var string
     */
    public $ExportDocURL;
    /**
     * Constructor method for ExportDocData
     * @see parent::__construct()
     * @param DHLStructShipmentNumberType $_shipmentNumber
     * @param DHLStructStatusinformation $_status
     * @param string $_exportDocPDFData
     * @param string $_exportDocURL
     * @return DHLStructExportDocData
     */
    public function __construct($_shipmentNumber = NULL,$_status = NULL,$_exportDocPDFData = NULL,$_exportDocURL = NULL)
    {
        parent::__construct(array('ShipmentNumber'=>$_shipmentNumber,'Status'=>$_status,'ExportDocPDFData'=>$_exportDocPDFData,'ExportDocURL'=>$_exportDocURL),false);
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
     * Get Status value
     * @return DHLStructStatusinformation|null
     */
    public function getStatus()
    {
        return $this->Status;
    }
    /**
     * Set Status value
     * @param DHLStructStatusinformation $_status the Status
     * @return DHLStructStatusinformation
     */
    public function setStatus($_status)
    {
        return ($this->Status = $_status);
    }
    /**
     * Get ExportDocPDFData value
     * @return string|null
     */
    public function getExportDocPDFData()
    {
        return $this->ExportDocPDFData;
    }
    /**
     * Set ExportDocPDFData value
     * @param string $_exportDocPDFData the ExportDocPDFData
     * @return string
     */
    public function setExportDocPDFData($_exportDocPDFData)
    {
        return ($this->ExportDocPDFData = $_exportDocPDFData);
    }
    /**
     * Get ExportDocURL value
     * @return string|null
     */
    public function getExportDocURL()
    {
        return $this->ExportDocURL;
    }
    /**
     * Set ExportDocURL value
     * @param string $_exportDocURL the ExportDocURL
     * @return string
     */
    public function setExportDocURL($_exportDocURL)
    {
        return ($this->ExportDocURL = $_exportDocURL);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructExportDocData
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
