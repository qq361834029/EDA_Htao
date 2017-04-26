<?php
/**
 * File for class DHLStructCancelPickupRequest
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCancelPickupRequest originally named CancelPickupRequest
 * Documentation : The data for cancelling a pickup order. The version of the webservice implementation for which the requesting client is developed.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCancelPickupRequest extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The BookingConfirmationNumber
     * Meta informations extracted from the WSDL
     * - documentation : The confirmation number of the pickup order which should be cancelled. Use value from pickup response attribute 'ConfirmationNumber' to cancel respective pickup order.Note: only one pickup can be deleted at a time.
     * @var string
     */
    public $BookingConfirmationNumber;
    /**
     * Constructor method for CancelPickupRequest
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param string $_bookingConfirmationNumber
     * @return DHLStructCancelPickupRequest
     */
    public function __construct($_version = NULL,$_bookingConfirmationNumber = NULL)
    {
        parent::__construct(array('Version'=>$_version,'BookingConfirmationNumber'=>$_bookingConfirmationNumber),false);
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
     * Get BookingConfirmationNumber value
     * @return string|null
     */
    public function getBookingConfirmationNumber()
    {
        return $this->BookingConfirmationNumber;
    }
    /**
     * Set BookingConfirmationNumber value
     * @param string $_bookingConfirmationNumber the BookingConfirmationNumber
     * @return string
     */
    public function setBookingConfirmationNumber($_bookingConfirmationNumber)
    {
        return ($this->BookingConfirmationNumber = $_bookingConfirmationNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCancelPickupRequest
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
