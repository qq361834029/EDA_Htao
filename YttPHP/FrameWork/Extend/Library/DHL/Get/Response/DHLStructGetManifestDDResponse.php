<?php
/**
 * File for class DHLStructGetManifestDDResponse
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructGetManifestDDResponse originally named GetManifestDDResponse
 * Documentation : The status of the operation and requested export document. The version of the webservice implementation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructGetManifestDDResponse extends DHLWsdlClass
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
     * The ManifestPDFData
     * Meta informations extracted from the WSDL
     * - documentation : The Base64 encoded pdf data for receiving the manifest.
     * - minOccurs : 0
     * @var string
     */
    public $ManifestPDFData;
    /**
     * Constructor method for GetManifestDDResponse
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructStatusinformation $_status
     * @param string $_manifestPDFData
     * @return DHLStructGetManifestDDResponse
     */
    public function __construct($_version = NULL,$_status = NULL,$_manifestPDFData = NULL)
    {
        parent::__construct(array('Version'=>$_version,'status'=>$_status,'ManifestPDFData'=>$_manifestPDFData),false);
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
     * Get ManifestPDFData value
     * @return string|null
     */
    public function getManifestPDFData()
    {
        return $this->ManifestPDFData;
    }
    /**
     * Set ManifestPDFData value
     * @param string $_manifestPDFData the ManifestPDFData
     * @return string
     */
    public function setManifestPDFData($_manifestPDFData)
    {
        return ($this->ManifestPDFData = $_manifestPDFData);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructGetManifestDDResponse
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
