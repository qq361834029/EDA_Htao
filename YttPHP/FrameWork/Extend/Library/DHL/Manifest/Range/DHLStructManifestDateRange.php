<?php
/**
 * File for class DHLStructManifestDateRange
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructManifestDateRange originally named manifestDateRange
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructManifestDateRange extends DHLWsdlClass
{
    /**
     * The fromDate
     * Meta informations extracted from the WSDL
     * - documentation : Date in format yyyy-mm-dd
     * @var string
     */
    public $fromDate;
    /**
     * The toDate
     * Meta informations extracted from the WSDL
     * - documentation : Date in format yyyy-mm-dd
     * @var string
     */
    public $toDate;
    /**
     * Constructor method for manifestDateRange
     * @see parent::__construct()
     * @param string $_fromDate
     * @param string $_toDate
     * @return DHLStructManifestDateRange
     */
    public function __construct($_fromDate = NULL,$_toDate = NULL)
    {
        parent::__construct(array('fromDate'=>$_fromDate,'toDate'=>$_toDate),false);
    }
    /**
     * Get fromDate value
     * @return string|null
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }
    /**
     * Set fromDate value
     * @param string $_fromDate the fromDate
     * @return string
     */
    public function setFromDate($_fromDate)
    {
        return ($this->fromDate = $_fromDate);
    }
    /**
     * Get toDate value
     * @return string|null
     */
    public function getToDate()
    {
        return $this->toDate;
    }
    /**
     * Set toDate value
     * @param string $_toDate the toDate
     * @return string
     */
    public function setToDate($_toDate)
    {
        return ($this->toDate = $_toDate);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructManifestDateRange
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
