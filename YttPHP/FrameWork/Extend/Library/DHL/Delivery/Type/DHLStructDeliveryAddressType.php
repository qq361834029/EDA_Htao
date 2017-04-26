<?php
/**
 * File for class DHLStructDeliveryAddressType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDeliveryAddressType originally named DeliveryAddressType
 * Documentation : Type of delivery address includes can be
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDeliveryAddressType extends DHLWsdlClass
{
    /**
     * The NativeAddress
     * Meta informations extracted from the WSDL
     * - documentation : Default address
     * @var DHLStructNativeAddressType
     */
    public $NativeAddress;
    /**
     * The PostOffice
     * Meta informations extracted from the WSDL
     * - documentation : Postoffice address
     * @var DHLStructPostOfficeType
     */
    public $PostOffice;
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
     * Constructor method for DeliveryAddressType
     * @see parent::__construct()
     * @param DHLStructNativeAddressType $_nativeAddress
     * @param DHLStructPostOfficeType $_postOffice
     * @param DHLStructPackStationType_1 $_packStation
     * @param string $_streetNameCode
     * @param string $_streetNumberCode
     * @return DHLStructDeliveryAddressType
     */
    public function __construct($_nativeAddress = NULL,$_postOffice = NULL,$_packStation = NULL,$_streetNameCode = NULL,$_streetNumberCode = NULL)
    {
        parent::__construct(array('NativeAddress'=>$_nativeAddress,'PostOffice'=>$_postOffice,'PackStation'=>$_packStation,'streetNameCode'=>$_streetNameCode,'streetNumberCode'=>$_streetNumberCode),false);
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
     * Get PostOffice value
     * @return DHLStructPostOfficeType|null
     */
    public function getPostOffice()
    {
        return $this->PostOffice;
    }
    /**
     * Set PostOffice value
     * @param DHLStructPostOfficeType $_postOffice the PostOffice
     * @return DHLStructPostOfficeType
     */
    public function setPostOffice($_postOffice)
    {
        return ($this->PostOffice = $_postOffice);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDeliveryAddressType
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
