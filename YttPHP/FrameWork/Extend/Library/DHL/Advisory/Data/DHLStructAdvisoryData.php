<?php
/**
 * File for class DHLStructAdvisoryData
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructAdvisoryData originally named AdvisoryData
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructAdvisoryData extends DHLWsdlClass
{
    /**
     * The ModuleType
     * Meta informations extracted from the WSDL
     * - documentation : The module type. Valid values are A1, A2, B1.
     * - minOccurs : 0
     * @var string
     */
    public $ModuleType;
    /**
     * The MobilePhoneNumber
     * Meta informations extracted from the WSDL
     * - documentation : The mobile phone number of the receiver.
     * - minOccurs : 0
     * @var string
     */
    public $MobilePhoneNumber;
    /**
     * The EmailAddress
     * Meta informations extracted from the WSDL
     * - documentation : The email address of the receiver.
     * - minOccurs : 0
     * @var string
     */
    public $EmailAddress;
    /**
     * The Reference
     * Meta informations extracted from the WSDL
     * - documentation : Reference.
     * - minOccurs : 0
     * @var string
     */
    public $Reference;
    /**
     * The Language
     * Meta informations extracted from the WSDL
     * - documentation : ISO CountryCode of the language. Valid values are "EN", "DE".
     * - minOccurs : 0
     * @var string
     */
    public $Language;
    /**
     * Constructor method for AdvisoryData
     * @see parent::__construct()
     * @param string $_moduleType
     * @param string $_mobilePhoneNumber
     * @param string $_emailAddress
     * @param string $_reference
     * @param string $_language
     * @return DHLStructAdvisoryData
     */
    public function __construct($_moduleType = NULL,$_mobilePhoneNumber = NULL,$_emailAddress = NULL,$_reference = NULL,$_language = NULL)
    {
        parent::__construct(array('ModuleType'=>$_moduleType,'MobilePhoneNumber'=>$_mobilePhoneNumber,'EmailAddress'=>$_emailAddress,'Reference'=>$_reference,'Language'=>$_language),false);
    }
    /**
     * Get ModuleType value
     * @return string|null
     */
    public function getModuleType()
    {
        return $this->ModuleType;
    }
    /**
     * Set ModuleType value
     * @param string $_moduleType the ModuleType
     * @return string
     */
    public function setModuleType($_moduleType)
    {
        return ($this->ModuleType = $_moduleType);
    }
    /**
     * Get MobilePhoneNumber value
     * @return string|null
     */
    public function getMobilePhoneNumber()
    {
        return $this->MobilePhoneNumber;
    }
    /**
     * Set MobilePhoneNumber value
     * @param string $_mobilePhoneNumber the MobilePhoneNumber
     * @return string
     */
    public function setMobilePhoneNumber($_mobilePhoneNumber)
    {
        return ($this->MobilePhoneNumber = $_mobilePhoneNumber);
    }
    /**
     * Get EmailAddress value
     * @return string|null
     */
    public function getEmailAddress()
    {
        return $this->EmailAddress;
    }
    /**
     * Set EmailAddress value
     * @param string $_emailAddress the EmailAddress
     * @return string
     */
    public function setEmailAddress($_emailAddress)
    {
        return ($this->EmailAddress = $_emailAddress);
    }
    /**
     * Get Reference value
     * @return string|null
     */
    public function getReference()
    {
        return $this->Reference;
    }
    /**
     * Set Reference value
     * @param string $_reference the Reference
     * @return string
     */
    public function setReference($_reference)
    {
        return ($this->Reference = $_reference);
    }
    /**
     * Get Language value
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->Language;
    }
    /**
     * Set Language value
     * @param string $_language the Language
     * @return string
     */
    public function setLanguage($_language)
    {
        return ($this->Language = $_language);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructAdvisoryData
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
