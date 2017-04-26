<?php
/**
 * File for class DHLStructFurtherAddressesDDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructFurtherAddressesDDType originally named FurtherAddressesDDType
 * Documentation : Further address informationThe following data fields from the cis_base-types are processed/mandatory/optional:-------------------------------------------------------------------------------------------------------Salutation (optional) : cis:NameType->Person->salutationCompany Name 1 (mandatory): cis:NameType->Company->name1Company Name 2 (optional) : cis:NameType->Company->name2Contact Name (mandatory): cis:CommunicationType->contactPersonStreet Name (mandatory): cis:NativeAddressType->streetNameStreet Number (mandatory): cis:NativeAddressType->streetNumberAdd. Address (optional) : cis:NativeAddressType->careOfNamePostcode (mandatory): cis:NativeAddressType->zipCity Name (mandatory): cis:NativeAddressType->cityISO Country Code (mandatory): cis:NativeAddressType->Origin->CountryType->countryISOType Phone Number (mandatory): cis:CommunicationType->phoneEmail Address (mandatory): cis:CommunicationType->email
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructFurtherAddressesDDType extends DHLWsdlClass
{
    /**
     * The DeliveryAdress
     * @var DHLStructDeliveryAdress
     */
    public $DeliveryAdress;
    /**
     * Constructor method for FurtherAddressesDDType
     * @see parent::__construct()
     * @param DHLStructDeliveryAdress $_deliveryAdress
     * @return DHLStructFurtherAddressesDDType
     */
    public function __construct($_deliveryAdress = NULL)
    {
        parent::__construct(array('DeliveryAdress'=>$_deliveryAdress),false);
    }
    /**
     * Get DeliveryAdress value
     * @return DHLStructDeliveryAdress|null
     */
    public function getDeliveryAdress()
    {
        return $this->DeliveryAdress;
    }
    /**
     * Set DeliveryAdress value
     * @param DHLStructDeliveryAdress $_deliveryAdress the DeliveryAdress
     * @return DHLStructDeliveryAdress
     */
    public function setDeliveryAdress($_deliveryAdress)
    {
        return ($this->DeliveryAdress = $_deliveryAdress);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructFurtherAddressesDDType
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
