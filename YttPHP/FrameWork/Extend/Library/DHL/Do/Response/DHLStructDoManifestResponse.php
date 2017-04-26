<?php
/**
 * File for class DHLStructDoManifestResponse
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDoManifestResponse originally named DoManifestResponse
 * Documentation : The status of the operation The version of the webservice implementation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDoManifestResponse extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The Status
     * Meta informations extracted from the WSDL
     * - documentation : Status of the request (value of zero means, the request was processed without error; value greater than zero indicates that an error occurred).
     * @var DHLStructStatusinformation
     */
    public $Status;
    /**
     * The ManifestState
     * Meta informations extracted from the WSDL
     * - documentation : The status of the operation for the corresponding shipment.
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructManifestState
     */
    public $ManifestState;
    /**
     * Constructor method for DoManifestResponse
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructStatusinformation $_status
     * @param DHLStructManifestState $_manifestState
     * @return DHLStructDoManifestResponse
     */
    public function __construct($_version = NULL,$_status = NULL,$_manifestState = NULL)
    {
        parent::__construct(array('Version'=>$_version,'Status'=>$_status,'ManifestState'=>$_manifestState),false);
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
     * Get ManifestState value
     * @return DHLStructManifestState|null
     */
    public function getManifestState()
    {
        return $this->ManifestState;
    }
    /**
     * Set ManifestState value
     * @param DHLStructManifestState $_manifestState the ManifestState
     * @return DHLStructManifestState
     */
    public function setManifestState($_manifestState)
    {
        return ($this->ManifestState = $_manifestState);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDoManifestResponse
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
