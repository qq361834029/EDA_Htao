<?php
/**
 * File for class DHLStructSMSAviso
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructSMSAviso originally named SMSAviso
 * Documentation : Invoke service SMSAviso to inform customers about date and time of delivery via SMS. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructSMSAviso extends DHLWsdlClass
{
    /**
     * The MobilePhoneNumberSender
     * Meta informations extracted from the WSDL
     * - documentation : The mobile phone number of the sender. Mandatory if service SMSAviso is chosen. Note: must not contain any special characters! Field length must be less than or equal to 20.
     * @var string
     */
    public $MobilePhoneNumberSender;
    /**
     * The MobilePhoneNumberReceiver
     * Meta informations extracted from the WSDL
     * - documentation : The mobile phone number of the receiver. Mandatory if service SMSAviso is chosen. Note: must not contain any special characters! Field length must be less than or equal to 20.
     * @var string
     */
    public $MobilePhoneNumberReceiver;
    /**
     * The AvisoIdent
     * Meta informations extracted from the WSDL
     * - documentation : The self generated aviso ident code that is sent to receiver along with SMS for authentication and shipment association purpose. Field length must be less than or equal to 11.
     * @var string
     */
    public $AvisoIdent;
    /**
     * Constructor method for SMSAviso
     * @see parent::__construct()
     * @param string $_mobilePhoneNumberSender
     * @param string $_mobilePhoneNumberReceiver
     * @param string $_avisoIdent
     * @return DHLStructSMSAviso
     */
    public function __construct($_mobilePhoneNumberSender = NULL,$_mobilePhoneNumberReceiver = NULL,$_avisoIdent = NULL)
    {
        parent::__construct(array('MobilePhoneNumberSender'=>$_mobilePhoneNumberSender,'MobilePhoneNumberReceiver'=>$_mobilePhoneNumberReceiver,'AvisoIdent'=>$_avisoIdent),false);
    }
    /**
     * Get MobilePhoneNumberSender value
     * @return string|null
     */
    public function getMobilePhoneNumberSender()
    {
        return $this->MobilePhoneNumberSender;
    }
    /**
     * Set MobilePhoneNumberSender value
     * @param string $_mobilePhoneNumberSender the MobilePhoneNumberSender
     * @return string
     */
    public function setMobilePhoneNumberSender($_mobilePhoneNumberSender)
    {
        return ($this->MobilePhoneNumberSender = $_mobilePhoneNumberSender);
    }
    /**
     * Get MobilePhoneNumberReceiver value
     * @return string|null
     */
    public function getMobilePhoneNumberReceiver()
    {
        return $this->MobilePhoneNumberReceiver;
    }
    /**
     * Set MobilePhoneNumberReceiver value
     * @param string $_mobilePhoneNumberReceiver the MobilePhoneNumberReceiver
     * @return string
     */
    public function setMobilePhoneNumberReceiver($_mobilePhoneNumberReceiver)
    {
        return ($this->MobilePhoneNumberReceiver = $_mobilePhoneNumberReceiver);
    }
    /**
     * Get AvisoIdent value
     * @return string|null
     */
    public function getAvisoIdent()
    {
        return $this->AvisoIdent;
    }
    /**
     * Set AvisoIdent value
     * @param string $_avisoIdent the AvisoIdent
     * @return string
     */
    public function setAvisoIdent($_avisoIdent)
    {
        return ($this->AvisoIdent = $_avisoIdent);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructSMSAviso
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
