<?php
/**
 * File for class DHLStructPickupAddressType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructPickupAddressType originally named PickupAddressType
 * Documentation : Type of pickup address includes can be The pickup address. In the PickupType the following data fields are processed/mandatory/optional:----------------------------------------------------------------------------------------------Company Name 1 (mandatory): cis:NameType->Company->name1Contact Name (mandatory): cis:CommunicationType->contactPersonStreet Name (mandatory): cis:NativeAddressType->streetNameStreet Number (mandatory): cis:NativeAddressType->streetNumberAdd. Address (optional) : cis:NativeAddressType->careOfNamePostcode (mandatory): cis:NativeAddressType->zipCity Name (mandatory): cis:NativeAddressType->cityISO Country Code (mandatory): cis:NativeAddressType->Origin->CountryType->countryISOType Phone Number (mandatory): cis:CommunicationType->phoneEmail Address (mandatory): cis:CommunicationType->email
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructPickupAddressType extends DHLWsdlClass
{
    /**
     * The NativeAddress
     * Meta informations extracted from the WSDL
     * - documentation : Default address
     * @var DHLStructNativeAddressType
     */
    public $NativeAddress;
    /**
     * The PackStation
     * Meta informations extracted from the WSDL
     * - documentation : Packstation address
     * @var DHLStructPackStationType_1
     */
    public $PackStation;
    /**
     * The streetNameCode
     * Meta informations extracted from the WSDL
     * - documentation : Code for street name (part of routecode).
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 3
     * - minLength : 3
     * @var string
     */
    public $streetNameCode;
    /**
     * The streetNumberCode
     * Meta informations extracted from the WSDL
     * - documentation : Code for street number (part of routecode).
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 3
     * - minLength : 3
     * @var string
     */
    public $streetNumberCode;
    /**
     * The Company
     * Meta informations extracted from the WSDL
     * - documentation : Determines whether pickup address is one of the following types.
     * @var DHLStructNameType
     */
    public $Company;
    /**
     * The Address
     * Meta informations extracted from the WSDL
     * - documentation : Data fields for pickup address.
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
     * Constructor method for PickupAddressType
     * @see parent::__construct()
     * @param DHLStructNativeAddressType $_nativeAddress
     * @param DHLStructPackStationType_1 $_packStation
     * @param string $_streetNameCode
     * @param string $_streetNumberCode
     * @param DHLStructNameType $_company
     * @param DHLStructNativeAddressType $_address
     * @param DHLStructCommunicationType $_communication
     * @return DHLStructPickupAddressType
     */
    public function __construct($_nativeAddress = NULL,$_packStation = NULL,$_streetNameCode = NULL,$_streetNumberCode = NULL,$_company = NULL,$_address = NULL,$_communication = NULL)
    {
        parent::__construct(array('NativeAddress'=>$_nativeAddress,'PackStation'=>$_packStation,'streetNameCode'=>$_streetNameCode,'streetNumberCode'=>$_streetNumberCode,'Company'=>$_company,'Address'=>$_address,'Communication'=>$_communication),false);
    }
    /**
     * Get NativeAddress value
     * @return DHLStructNativeAddressType|null
     */
    public function getNativeAddress()
    {
        return $this->NativeAddress;
    }
    /**
     * Set NativeAddress value
     * @param DHLStructNativeAddressType $_nativeAddress the NativeAddress
     * @return DHLStructNativeAddressType
     */
    public function setNativeAddress($_nativeAddress)
    {
        return ($this->NativeAddress = $_nativeAddress);
    }
    /**
     * Get PackStation value
     * @return DHLStructPackStationType_1|null
     */
    public function getPackStation()
    {
        return $this->PackStation;
    }
    /**
     * Set PackStation value
     * @param DHLStructPackStationType_1 $_packStation the PackStation
     * @return DHLStructPackStationType_1
     */
    public function setPackStation($_packStation)
    {
        return ($this->PackStation = $_packStation);
    }
    /**
     * Get streetNameCode value
     * @return string|null
     */
    public function getStreetNameCode()
    {
        return $this->streetNameCode;
    }
    /**
     * Set streetNameCode value
     * @param string $_streetNameCode the streetNameCode
     * @return string
     */
    public function setStreetNameCode($_streetNameCode)
    {
        return ($this->streetNameCode = $_streetNameCode);
    }
    /**
     * Get streetNumberCode value
     * @return string|null
     */
    public function getStreetNumberCode()
    {
        return $this->streetNumberCode;
    }
    /**
     * Set streetNumberCode value
     * @param string $_streetNumberCode the streetNumberCode
     * @return string
     */
    public function setStreetNumberCode($_streetNumberCode)
    {
        return ($this->streetNumberCode = $_streetNumberCode);
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
     * @return DHLStructPickupAddressType
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
