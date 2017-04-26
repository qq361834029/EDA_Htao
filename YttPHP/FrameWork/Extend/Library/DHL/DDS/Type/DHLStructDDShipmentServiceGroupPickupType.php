<?php
/**
 * File for class DHLStructDDShipmentServiceGroupPickupType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDDShipmentServiceGroupPickupType originally named DDShipmentServiceGroupPickupType
 * Documentation : Pickup services. Service Group Pickup.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDDShipmentServiceGroupPickupType extends DHLWsdlClass
{
    /**
     * The PickupSaturday
     * Meta informations extracted from the WSDL
     * - documentation : Pickup on Saturday.
     * @var boolean
     */
    public $PickupSaturday;
    /**
     * The PickupLate
     * Meta informations extracted from the WSDL
     * - documentation : Pickup Late.
     * @var boolean
     */
    public $PickupLate;
    /**
     * Constructor method for DDShipmentServiceGroupPickupType
     * @see parent::__construct()
     * @param boolean $_pickupSaturday
     * @param boolean $_pickupLate
     * @return DHLStructDDShipmentServiceGroupPickupType
     */
    public function __construct($_pickupSaturday = NULL,$_pickupLate = NULL)
    {
        parent::__construct(array('PickupSaturday'=>$_pickupSaturday,'PickupLate'=>$_pickupLate),false);
    }
    /**
     * Get PickupSaturday value
     * @return boolean|null
     */
    public function getPickupSaturday()
    {
        return $this->PickupSaturday;
    }
    /**
     * Set PickupSaturday value
     * @param boolean $_pickupSaturday the PickupSaturday
     * @return boolean
     */
    public function setPickupSaturday($_pickupSaturday)
    {
        return ($this->PickupSaturday = $_pickupSaturday);
    }
    /**
     * Get PickupLate value
     * @return boolean|null
     */
    public function getPickupLate()
    {
        return $this->PickupLate;
    }
    /**
     * Set PickupLate value
     * @param boolean $_pickupLate the PickupLate
     * @return boolean
     */
    public function setPickupLate($_pickupLate)
    {
        return ($this->PickupLate = $_pickupLate);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDDShipmentServiceGroupPickupType
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
