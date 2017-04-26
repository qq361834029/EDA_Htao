<?php
/**
 * File for class DHLStructGetManifestDDRequest
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructGetManifestDDRequest originally named GetManifestDDRequest
 * Documentation : The request data for the manifest document The version of the webservice implementation for which the requesting client is developed.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructGetManifestDDRequest extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The manifestDate
     * Meta informations extracted from the WSDL
     * - documentation : Date in format yyyy-mm-dd
     * @var string
     */
    public $manifestDate;
    /**
     * The manifestDateRange
     * @var DHLStructManifestDateRange
     */
    public $manifestDateRange;
    /**
     * Constructor method for GetManifestDDRequest
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param string $_manifestDate
     * @param DHLStructManifestDateRange $_manifestDateRange
     * @return DHLStructGetManifestDDRequest
     */
    public function __construct($_version = NULL,$_manifestDate = NULL,$_manifestDateRange = NULL)
    {
        parent::__construct(array('Version'=>$_version,'manifestDate'=>$_manifestDate,'manifestDateRange'=>$_manifestDateRange),false);
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
     * Get manifestDate value
     * @return string|null
     */
    public function getManifestDate()
    {
        return $this->manifestDate;
    }
    /**
     * Set manifestDate value
     * @param string $_manifestDate the manifestDate
     * @return string
     */
    public function setManifestDate($_manifestDate)
    {
        return ($this->manifestDate = $_manifestDate);
    }
    /**
     * Get manifestDateRange value
     * @return DHLStructManifestDateRange|null
     */
    public function getManifestDateRange()
    {
        return $this->manifestDateRange;
    }
    /**
     * Set manifestDateRange value
     * @param DHLStructManifestDateRange $_manifestDateRange the manifestDateRange
     * @return DHLStructManifestDateRange
     */
    public function setManifestDateRange($_manifestDateRange)
    {
        return ($this->manifestDateRange = $_manifestDateRange);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructGetManifestDDRequest
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
