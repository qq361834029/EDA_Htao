<?php
/**
 * File for class DHLStructDeliveryAdress
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDeliveryAdress originally named DeliveryAdress
 * Documentation : Mandatory if further address is to be specified.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDeliveryAdress extends DHLWsdlClass
{
    /**
     * The Company
     * Meta informations extracted from the WSDL
     * - documentation : Determines whether further address is one of the following types.
     * @var DHLStructNameType
     */
    public $Company;
    /**
     * The Name3
     * Meta informations extracted from the WSDL
     * - documentation : Extra data for name extension.
     * - minOccurs : 0
     * @var string
     */
    public $Name3;
    /**
     * The Address
     * Meta informations extracted from the WSDL
     * - documentation : Contains address data.
     * @var DHLStructNativeAddressType
     */
    public $Address;
    /**
     * The Communication
     * Meta informations extracted from the WSDL
     * - documentation : Info about communication.
     * @var DHLStructCommunicationType
     */
    public $Communication;
    /**
     * Constructor method for DeliveryAdress
     * @see parent::__construct()
     * @param DHLStructNameType $_company
     * @param string $_name3
     * @param DHLStructNativeAddressType $_address
     * @param DHLStructCommunicationType $_communication
     * @return DHLStructDeliveryAdress
     */
    public function __construct($_company = NULL,$_name3 = NULL,$_address = NULL,$_communication = NULL)
    {
        parent::__construct(array('Company'=>$_company,'Name3'=>$_name3,'Address'=>$_address,'Communication'=>$_communication),false);
    }
    /**
     * Get Company value
     * @return DHLStructNameType|null
     */
    public function getCompany()
    {
        return $this->Company;
    }
    /**
     * Set Company value
     * @param DHLStructNameType $_company the Company
     * @return DHLStructNameType
     */
    public function setCompany($_company)
    {
        return ($this->Company = $_company);
    }
    /**
     * Get Name3 value
     * @return string|null
     */
    public function getName3()
    {
        return $this->Name3;
    }
    /**
     * Set Name3 value
     * @param string $_name3 the Name3
     * @return string
     */
    public function setName3($_name3)
    {
        return ($this->Name3 = $_name3);
    }
    /**
     * Get Address value
     * @return DHLStructNativeAddressType|null
     */
    public function getAddress()
    {
        return $this->Address;
    }
    /**
     * Set Address value
     * @param DHLStructNativeAddressType $_address the Address
     * @return DHLStructNativeAddressType
     */
    public function setAddress($_address)
    {
        return ($this->Address = $_address);
    }
    /**
     * Get Communication value
     * @return DHLStructCommunicationType|null
     */
    public function getCommunication()
    {
        return $this->Communication;
    }
    /**
     * Set Communication value
     * @param DHLStructCommunicationType $_communication the Communication
     * @return DHLStructCommunicationType
     */
    public function setCommunication($_communication)
    {
        return ($this->Communication = $_communication);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDeliveryAdress
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
