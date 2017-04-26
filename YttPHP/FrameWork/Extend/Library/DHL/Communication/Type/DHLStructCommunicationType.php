<?php
/**
 * File for class DHLStructCommunicationType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCommunicationType originally named CommunicationType
 * Documentation : Type of communication. includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCommunicationType extends DHLWsdlClass
{
    /**
     * The phone
     * Meta informations extracted from the WSDL
     * - documentation : Phone number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 20
     * @var string
     */
    public $phone;
    /**
     * The email
     * Meta informations extracted from the WSDL
     * - documentation : Emailaddress.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $email;
    /**
     * The fax
     * Meta informations extracted from the WSDL
     * - documentation : Fax number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $fax;
    /**
     * The mobile
     * Meta informations extracted from the WSDL
     * - documentation : Mobile number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $mobile;
    /**
     * The internet
     * Meta informations extracted from the WSDL
     * - documentation : Web address.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $internet;
    /**
     * The contactPerson
     * Meta informations extracted from the WSDL
     * - documentation : First name and last name of contact person.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $contactPerson;
    /**
     * Constructor method for CommunicationType
     * @see parent::__construct()
     * @param string $_phone
     * @param string $_email
     * @param string $_fax
     * @param string $_mobile
     * @param string $_internet
     * @param string $_contactPerson
     * @return DHLStructCommunicationType
     */
    public function __construct($_phone = NULL,$_email = NULL,$_fax = NULL,$_mobile = NULL,$_internet = NULL,$_contactPerson = NULL)
    {
        parent::__construct(array('phone'=>$_phone,'email'=>$_email,'fax'=>$_fax,'mobile'=>$_mobile,'internet'=>$_internet,'contactPerson'=>$_contactPerson),false);
    }
    /**
     * Get phone value
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Set phone value
     * @param string $_phone the phone
     * @return string
     */
    public function setPhone($_phone)
    {
        return ($this->phone = $_phone);
    }
    /**
     * Get email value
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set email value
     * @param string $_email the email
     * @return string
     */
    public function setEmail($_email)
    {
        return ($this->email = $_email);
    }
    /**
     * Get fax value
     * @return string|null
     */
    public function getFax()
    {
        return $this->fax;
    }
    /**
     * Set fax value
     * @param string $_fax the fax
     * @return string
     */
    public function setFax($_fax)
    {
        return ($this->fax = $_fax);
    }
    /**
     * Get mobile value
     * @return string|null
     */
    public function getMobile()
    {
        return $this->mobile;
    }
    /**
     * Set mobile value
     * @param string $_mobile the mobile
     * @return string
     */
    public function setMobile($_mobile)
    {
        return ($this->mobile = $_mobile);
    }
    /**
     * Get internet value
     * @return string|null
     */
    public function getInternet()
    {
        return $this->internet;
    }
    /**
     * Set internet value
     * @param string $_internet the internet
     * @return string
     */
    public function setInternet($_internet)
    {
        return ($this->internet = $_internet);
    }
    /**
     * Get contactPerson value
     * @return string|null
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }
    /**
     * Set contactPerson value
     * @param string $_contactPerson the contactPerson
     * @return string
     */
    public function setContactPerson($_contactPerson)
    {
        return ($this->contactPerson = $_contactPerson);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCommunicationType
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
