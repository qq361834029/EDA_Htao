<?php
/**
 * File for class DHLStructCancelPickupResponse
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCancelPickupResponse originally named CancelPickupResponse
 * Documentation : The status of the cancel pickup operation. The version of the webservice implementation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCancelPickupResponse extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The Status
     * Meta informations extracted from the WSDL
     * - documentation : Success status after processing the request.
     * @var DHLStructStatusinformation
     */
    public $Status;
    /**
     * Constructor method for CancelPickupResponse
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructStatusinformation $_status
     * @return DHLStructCancelPickupResponse
     */
    public function __construct($_version = NULL,$_status = NULL)
    {
        parent::__construct(array('Version'=>$_version,'Status'=>$_status),false);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCancelPickupResponse
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
