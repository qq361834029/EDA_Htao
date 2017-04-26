<?php
/**
 * File for class DHLStructPickupDetailsType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructPickupDetailsType originally named PickupDetailsType
 * Documentation : The details of a pickup order.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructPickupDetailsType extends DHLWsdlClass
{
    /**
     * The PickupDate
     * Meta informations extracted from the WSDL
     * - documentation : Pickup date in format yyyy-mm-dd.Mandatory if pickup is booked along with shipment order. Pickup date in format yyyy-mm-dd.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $PickupDate;
    /**
     * The ReadyByTime
     * Meta informations extracted from the WSDL
     * - documentation : Earliest time for pickup. Format is hh:mm.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 5
     * - minLength : 5
     * @var string
     */
    public $ReadyByTime;
    /**
     * The ClosingTime
     * Meta informations extracted from the WSDL
     * - documentation : Lates time for pickup. Format is hh:mm.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 5
     * - minLength : 5
     * @var string
     */
    public $ClosingTime;
    /**
     * The Remark
     * Meta informations extracted from the WSDL
     * - documentation : Remarks to be considered when pickup is done.
     * - minOccurs : 0
     * @var string
     */
    public $Remark;
    /**
     * The PickupLocation
     * Meta informations extracted from the WSDL
     * - documentation : Area to further detail pickup location beyond address.
     * @var string
     */
    public $PickupLocation;
    /**
     * Constructor method for PickupDetailsType
     * @see parent::__construct()
     * @param string $_pickupDate
     * @param string $_readyByTime
     * @param string $_closingTime
     * @param string $_remark
     * @param string $_pickupLocation
     * @return DHLStructPickupDetailsType
     */
    public function __construct($_pickupDate = NULL,$_readyByTime = NULL,$_closingTime = NULL,$_remark = NULL,$_pickupLocation = NULL)
    {
        parent::__construct(array('PickupDate'=>$_pickupDate,'ReadyByTime'=>$_readyByTime,'ClosingTime'=>$_closingTime,'Remark'=>$_remark,'PickupLocation'=>$_pickupLocation),false);
    }
    /**
     * Get PickupDate value
     * @return string|null
     */
    public function getPickupDate()
    {
        return $this->PickupDate;
    }
    /**
     * Set PickupDate value
     * @param string $_pickupDate the PickupDate
     * @return string
     */
    public function setPickupDate($_pickupDate)
    {
        return ($this->PickupDate = $_pickupDate);
    }
    /**
     * Get ReadyByTime value
     * @return string|null
     */
    public function getReadyByTime()
    {
        return $this->ReadyByTime;
    }
    /**
     * Set ReadyByTime value
     * @param string $_readyByTime the ReadyByTime
     * @return string
     */
    public function setReadyByTime($_readyByTime)
    {
        return ($this->ReadyByTime = $_readyByTime);
    }
    /**
     * Get ClosingTime value
     * @return string|null
     */
    public function getClosingTime()
    {
        return $this->ClosingTime;
    }
    /**
     * Set ClosingTime value
     * @param string $_closingTime the ClosingTime
     * @return string
     */
    public function setClosingTime($_closingTime)
    {
        return ($this->ClosingTime = $_closingTime);
    }
    /**
     * Get Remark value
     * @return string|null
     */
    public function getRemark()
    {
        return $this->Remark;
    }
    /**
     * Set Remark value
     * @param string $_remark the Remark
     * @return string
     */
    public function setRemark($_remark)
    {
        return ($this->Remark = $_remark);
    }
    /**
     * Get PickupLocation value
     * @return string|null
     */
    public function getPickupLocation()
    {
        return $this->PickupLocation;
    }
    /**
     * Set PickupLocation value
     * @param string $_pickupLocation the PickupLocation
     * @return string
     */
    public function setPickupLocation($_pickupLocation)
    {
        return ($this->PickupLocation = $_pickupLocation);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructPickupDetailsType
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
