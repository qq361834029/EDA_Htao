<?php
/**
 * File for class DHLStructDeleteShipmentResponse
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDeleteShipmentResponse originally named DeleteShipmentResponse
 * Documentation : The status of the operation. The version of the webservice implementation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDeleteShipmentResponse extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The Status
     * Meta informations extracted from the WSDL
     * - documentation : Success status after processing the overall request.
     * @var DHLStructStatusinformation
     */
    public $Status;
    /**
     * The DeletionState
     * Meta informations extracted from the WSDL
     * - documentation : For every ShipmentNumber requested, one DeletionState node is returned that contains the status of the respective deletion operation.
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructDeletionState
     */
    public $DeletionState;
    /**
     * Constructor method for DeleteShipmentResponse
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructStatusinformation $_status
     * @param DHLStructDeletionState $_deletionState
     * @return DHLStructDeleteShipmentResponse
     */
    public function __construct($_version = NULL,$_status = NULL,$_deletionState = NULL)
    {
        parent::__construct(array('Version'=>$_version,'Status'=>$_status,'DeletionState'=>$_deletionState),false);
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
     * Get DeletionState value
     * @return DHLStructDeletionState|null
     */
    public function getDeletionState()
    {
        return $this->DeletionState;
    }
    /**
     * Set DeletionState value
     * @param DHLStructDeletionState $_deletionState the DeletionState
     * @return DHLStructDeletionState
     */
    public function setDeletionState($_deletionState)
    {
        return ($this->DeletionState = $_deletionState);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDeleteShipmentResponse
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
