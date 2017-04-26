<?php
/**
 * File for class DHLStructBookPickupRequest
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructBookPickupRequest originally named BookPickupRequest
 * Documentation : The data for a pickup order. The version of the webservice implementation for which the requesting client is developed.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructBookPickupRequest extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The BookingInformation
     * Meta informations extracted from the WSDL
     * - documentation : Contains information in further leaf elements about product, DHL account, pickup date and time, pickup location, amount of pieces, pallets, and shipments, moreover weight and volume weight, size.
     * @var DHLStructPickupBookingInformationType
     */
    public $BookingInformation;
    /**
     * The PickupAddress
     * Meta informations extracted from the WSDL
     * - documentation : The pickup address.
     * @var DHLStructPickupAddressType
     */
    public $PickupAddress;
    /**
     * The ContactOrderer
     * Meta informations extracted from the WSDL
     * - documentation : The address and contact information of the orderer.
     * - minOccurs : 0
     * @var DHLStructPickupOrdererType
     */
    public $ContactOrderer;
    /**
     * Constructor method for BookPickupRequest
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructPickupBookingInformationType $_bookingInformation
     * @param DHLStructPickupAddressType $_pickupAddress
     * @param DHLStructPickupOrdererType $_contactOrderer
     * @return DHLStructBookPickupRequest
     */
    public function __construct($_version = NULL,$_bookingInformation = NULL,$_pickupAddress = NULL,$_contactOrderer = NULL)
    {
        parent::__construct(array('Version'=>$_version,'BookingInformation'=>$_bookingInformation,'PickupAddress'=>$_pickupAddress,'ContactOrderer'=>$_contactOrderer),false);
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
     * Get BookingInformation value
     * @return DHLStructPickupBookingInformationType|null
     */
    public function getBookingInformation()
    {
        return $this->BookingInformation;
    }
    /**
     * Set BookingInformation value
     * @param DHLStructPickupBookingInformationType $_bookingInformation the BookingInformation
     * @return DHLStructPickupBookingInformationType
     */
    public function setBookingInformation($_bookingInformation)
    {
        return ($this->BookingInformation = $_bookingInformation);
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
     * Get ContactOrderer value
     * @return DHLStructPickupOrdererType|null
     */
    public function getContactOrderer()
    {
        return $this->ContactOrderer;
    }
    /**
     * Set ContactOrderer value
     * @param DHLStructPickupOrdererType $_contactOrderer the ContactOrderer
     * @return DHLStructPickupOrdererType
     */
    public function setContactOrderer($_contactOrderer)
    {
        return ($this->ContactOrderer = $_contactOrderer);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructBookPickupRequest
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
