<?php
/**
 * File for class DHLStructPickup
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructPickup originally named Pickup
 * Documentation : Specifies an additional pickup request to the shipment order.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructPickup extends DHLWsdlClass
{
    /**
     * The PickupDetails
     * Meta informations extracted from the WSDL
     * - documentation : Details about the pickup date, time, opening window.
     * @var DHLStructPickupDetailsType
     */
    public $PickupDetails;
    /**
     * The PickupAddress
     * Meta informations extracted from the WSDL
     * - documentation : Mandatory if pickup is booked along with shipment.
     * - minOccurs : 0
     * @var DHLStructPickupAddressType
     */
    public $PickupAddress;
    /**
     * Constructor method for Pickup
     * @see parent::__construct()
     * @param DHLStructPickupDetailsType $_pickupDetails
     * @param DHLStructPickupAddressType $_pickupAddress
     * @return DHLStructPickup
     */
    public function __construct($_pickupDetails = NULL,$_pickupAddress = NULL)
    {
        parent::__construct(array('PickupDetails'=>$_pickupDetails,'PickupAddress'=>$_pickupAddress),false);
    }
    /**
     * Get PickupDetails value
     * @return DHLStructPickupDetailsType|null
     */
    public function getPickupDetails()
    {
        return $this->PickupDetails;
    }
    /**
     * Set PickupDetails value
     * @param DHLStructPickupDetailsType $_pickupDetails the PickupDetails
     * @return DHLStructPickupDetailsType
     */
    public function setPickupDetails($_pickupDetails)
    {
        return ($this->PickupDetails = $_pickupDetails);
    }
    /**
     * Get PickupAddress value
     * @return DHLStructPickupAddressType|null
     */
    public function getPickupAddress()
    {
        return $this->PickupAddress;
    }
    /**
     * Set PickupAddress value
     * @param DHLStructPickupAddressType $_pickupAddress the PickupAddress
     * @return DHLStructPickupAddressType
     */
    public function setPickupAddress($_pickupAddress)
    {
        return ($this->PickupAddress = $_pickupAddress);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructPickup
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
