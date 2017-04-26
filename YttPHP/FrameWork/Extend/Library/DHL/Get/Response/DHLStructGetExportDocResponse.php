<?php
/**
 * File for class DHLStructGetExportDocResponse
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructGetExportDocResponse originally named GetExportDocResponse
 * Documentation : The status of the operation and requested export document. The version of the webservice implementation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructGetExportDocResponse extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The status
     * Meta informations extracted from the WSDL
     * - documentation : Status of the request (value of zero means, the request was processed without error; value greater than zero indicates that an error occurred).
     * @var DHLStructStatusinformation
     */
    public $status;
    /**
     * The ExportDocData
     * Meta informations extracted from the WSDL
     * - documentation : Contains the result of the document processing: in case of no errors, a base64 encoded PDF is contained; also, the status of this particular document generation and the passed shipment number are returned.
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructExportDocData
     */
    public $ExportDocData;
    /**
     * Constructor method for GetExportDocResponse
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructStatusinformation $_status
     * @param DHLStructExportDocData $_exportDocData
     * @return DHLStructGetExportDocResponse
     */
    public function __construct($_version = NULL,$_status = NULL,$_exportDocData = NULL)
    {
        parent::__construct(array('Version'=>$_version,'status'=>$_status,'ExportDocData'=>$_exportDocData),false);
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
     * Get status value
     * @return DHLStructStatusinformation|null
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Set status value
     * @param DHLStructStatusinformation $_status the status
     * @return DHLStructStatusinformation
     */
    public function setStatus($_status)
    {
        return ($this->status = $_status);
    }
    /**
     * Get ExportDocData value
     * @return DHLStructExportDocData|null
     */
    public function getExportDocData()
    {
        return $this->ExportDocData;
    }
    /**
     * Set ExportDocData value
     * @param DHLStructExportDocData $_exportDocData the ExportDocData
     * @return DHLStructExportDocData
     */
    public function setExportDocData($_exportDocData)
    {
        return ($this->ExportDocData = $_exportDocData);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructGetExportDocResponse
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
