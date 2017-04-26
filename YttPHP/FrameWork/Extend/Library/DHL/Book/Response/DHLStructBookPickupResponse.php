<?php
/**
 * File for class DHLStructBookPickupResponse
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructBookPickupResponse originally named BookPickupResponse
 * Documentation : The data for a pickup order. The version of the webservice implementation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructBookPickupResponse extends DHLWsdlClass
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
     * The ConfirmationNumber
     * Meta informations extracted from the WSDL
     * - documentation : The confirmation number of the successfully created pickup order. It can later be used for cancelling a pickup order. Confirmation number is not available for each pickup type.
     * - minOccurs : 0
     * @var string
     */
    public $ConfirmationNumber;
    /**
     * The ShipmentNumber
     * Meta informations extracted from the WSDL
     * - documentation : If available, a shipment number is returned.
     * - minOccurs : 0
     * @var string
     */
    public $ShipmentNumber;
    /**
     * Constructor method for BookPickupResponse
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructStatusinformation $_status
     * @param string $_confirmationNumber
     * @param string $_shipmentNumber
     * @return DHLStructBookPickupResponse
     */
    public function __construct($_version = NULL,$_status = NULL,$_confirmationNumber = NULL,$_shipmentNumber = NULL)
    {
        parent::__construct(array('Version'=>$_version,'Status'=>$_status,'ConfirmationNumber'=>$_confirmationNumber,'ShipmentNumber'=>$_shipmentNumber),false);
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
     * Get ConfirmationNumber value
     * @return string|null
     */
    public function getConfirmationNumber()
    {
        return $this->ConfirmationNumber;
    }
    /**
     * Set ConfirmationNumber value
     * @param string $_confirmationNumber the ConfirmationNumber
     * @return string
     */
    public function setConfirmationNumber($_confirmationNumber)
    {
        return ($this->ConfirmationNumber = $_confirmationNumber);
    }
    /**
     * Get ShipmentNumber value
     * @return string|null
     */
    public function getShipmentNumber()
    {
        return $this->ShipmentNumber;
    }
    /**
     * Set ShipmentNumber value
     * @param string $_shipmentNumber the ShipmentNumber
     * @return string
     */
    public function setShipmentNumber($_shipmentNumber)
    {
        return ($this->ShipmentNumber = $_shipmentNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructBookPickupResponse
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
