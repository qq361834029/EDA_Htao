<?php
/**
 * File for class DHLStructShipperTDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipperTDType originally named ShipperTDType
 * Documentation : The data of the shipper of a TD shipment. For the TD-Shipper the following data fields from is:Shipper are processed/mandatory/optional:----------------------------------------------------------------------------------------------Company Name 1 (mandatory): cis:NameType->Company->name1Company Name 2 (optional) : cis:NameType->Company->name2Contact Name (mandatory): cis:CommunicationType->contactPersonStreet Name (mandatory): cis:NativeAddressType->streetNameStreet Number (mandatory): cis:NativeAddressType->streetNumberAdd. Address 1 (optional) : cis:NativeAddressType->careOfNamePostcode (mandatory): cis:NativeAddressType->zipCity Name (mandatory): cis:NativeAddressType->cityISO Country Code (mandatory): cis:NativeAddressType->Origin->CountryType->countryISOType Phone Number (mandatory): cis:CommunicationType->phoneFax Number (optional) : cis:CommunicationType->faxEmail Address (mandatory): cis:CommunicationType->emailVAT Number (optional) : is:ShipperType->VAT
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipperTDType extends DHLStructShipperType
{
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
