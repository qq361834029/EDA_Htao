<?php
/**
 * File for class DHLStructReceiverDDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructReceiverDDType originally named ReceiverDDType
 * Documentation : The receiver data of a DD shipment. For the DD-Receiver the following data fields from is:Receiver are processed/mandatory/optional:----------------------------------------------------------------------------------------------Salutation (optional) : cis:NameType->Person->salutationCompany Name 1 (mandatory): cis:NameType->Company->name1Company Name 2 (optional) : cis:NameType->Company->name2Contact Name (mandatory): cis:CommunicationType->contactPersonStreet Name (mandatory): cis:NativeAddressType->streetNameStreet Number (mandatory): cis:NativeAddressType->streetNumberAdd. Address (optional) : cis:NativeAddressType->careOfNamePostcode (mandatory): cis:NativeAddressType->zipCity Name (mandatory): cis:NativeAddressType->cityISO Country Code (mandatory): cis:NativeAddressType->Origin->CountryType->countryISOType ISO State or county (optional): cis:NativeAddressType->Origin->CountryType->statePhone Number (mandatory): cis:CommunicationType->phoneEmail Address (mandatory): cis:CommunicationType->emailMobile Phone No. (optional) : cis:CommunicationType->mobileVAT Number (optional) : is:Receiver->VAT
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructReceiverDDType extends DHLStructReceiverType
{
    /**
     * The CompanyName3
     * Meta informations extracted from the WSDL
     * - documentation : Optional company name complement. Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $CompanyName3;
    /**
     * Constructor method for ReceiverDDType
     * @see parent::__construct()
     * @param string $_companyName3
     * @return DHLStructReceiverDDType
     */
    public function __construct($_companyName3 = NULL)
    {
        DHLWsdlClass::__construct(array('CompanyName3'=>$_companyName3),false);
    }
    /**
     * Get CompanyName3 value
     * @return string|null
     */
    public function getCompanyName3()
    {
        return $this->CompanyName3;
    }
    /**
     * Set CompanyName3 value
     * @param string $_companyName3 the CompanyName3
     * @return string
     */
    public function setCompanyName3($_companyName3)
    {
        return ($this->CompanyName3 = $_companyName3);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructReceiverDDType
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
