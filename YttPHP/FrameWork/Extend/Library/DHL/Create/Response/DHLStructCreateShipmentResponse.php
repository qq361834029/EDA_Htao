<?php
/**
 * File for class DHLStructCreateShipmentResponse
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCreateShipmentResponse originally named CreateShipmentResponse
 * Documentation : The status of the operation and the shipment identifier (if available). The version of the webservice implementation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCreateShipmentResponse extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The status
     * Meta informations extracted from the WSDL
     * - documentation : Success status after processing the overall request.
     * @var DHLStructStatusinformation
     */
    public $status;
    /**
     * The CreationState
     * Meta informations extracted from the WSDL
     * - documentation : The operation's success status for every single ShipmentOrder will be returned by one CreationState element. It is identifiable via SequenceNumber.
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructCreationState
     */
    public $CreationState;
    /**
     * Constructor method for CreateShipmentResponse
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructStatusinformation $_status
     * @param DHLStructCreationState $_creationState
     * @return DHLStructCreateShipmentResponse
     */
    public function __construct($_version = NULL,$_status = NULL,$_creationState = NULL)
    {
        parent::__construct(array('Version'=>$_version,'status'=>$_status,'CreationState'=>$_creationState),false);
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
     * Get CreationState value
     * @return DHLStructCreationState|null
     */
    public function getCreationState()
    {
        return $this->CreationState;
    }
    /**
     * Set CreationState value
     * @param DHLStructCreationState $_creationState the CreationState
     * @return DHLStructCreationState
     */
    public function setCreationState($_creationState)
    {
        return ($this->CreationState = $_creationState);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCreateShipmentResponse
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
