<?php
/**
 * File for class DHLStructShipperDDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipperDDType originally named ShipperDDType
 * Documentation : The data of the shipper of a DD shipment. For the DD-Shipper the following data fields from is:Shipper are processed/mandatory/optional:----------------------------------------------------------------------------------------------Company Name (mandatory): cis:NameType->Company->name1 Company Name2 (optional) : cis:NameType->Company->name2 Contact Name (mandatory): cis:CommunicationType->contactPersonStreet Name (mandatory): cis:NativeAddressType->streetNameStreet Number (optional) : cis:NativeAddressType->streetNumberAdd. Address (optional) : cis:NativeAddressType->careOfNamePostcode (mandatory): cis:NativeAddressType->zipCity Name (mandatory): cis:NativeAddressType->cityISO Country Code (mandatory): cis:NativeAddressType->Origin->CountryType->countryISOType Phone Number (mandatory): cis:CommunicationType->phoneEmail Address (mandatory): cis:CommunicationType->emailMobile Phone No. (optional) : cis:CommunicationType->mobileFax Number (optional) : cis:CommunicationType->faxVAT Number (optional) : is:ShipperType->VAT
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipperDDType extends DHLStructShipperType
{
    /**
     * The Remark
     * Meta informations extracted from the WSDL
     * - documentation : Area for remarks. Only for internal purposes, does not appear on label. Field length must be less than or equal to 60.
     * - minOccurs : 0
     * @var string
     */
    public $Remark;
    /**
     * Constructor method for ShipperDDType
     * @see parent::__construct()
     * @param string $_remark
     * @return DHLStructShipperDDType
     */
    public function __construct($_remark = NULL)
    {
        DHLWsdlClass::__construct(array('Remark'=>$_remark),false);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipperDDType
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
