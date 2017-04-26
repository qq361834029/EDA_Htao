<?php
/**
 * File for class DHLStructAuthentificationType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructAuthentificationType originally named AuthentificationType
 * Documentation : Type of authentification includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructAuthentificationType extends DHLWsdlClass
{
    /**
     * The user
     * Meta informations extracted from the WSDL
     * - documentation : Username
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 20
     * @var string
     */
    public $user;
    /**
     * The signature
     * Meta informations extracted from the WSDL
     * - documentation : User-id / password (pref. MD5 encoded)
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 32
     * @var string
     */
    public $signature;
    /**
     * The accountNumber
     * Meta informations extracted from the WSDL
     * - documentation : DHL account number (14 digits).
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 14
     * - minLength : 14
     * @var string
     */
    public $accountNumber;
    /**
     * The type
     * Meta informations extracted from the WSDL
     * - documentation : Authentification mode
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * @var integer
     */
    public $type;
    /**
     * Constructor method for AuthentificationType
     * @see parent::__construct()
     * @param string $_user
     * @param string $_signature
     * @param string $_accountNumber
     * @param integer $_type
     * @return DHLStructAuthentificationType
     */
    public function __construct($_user = NULL,$_signature = NULL,$_accountNumber = NULL,$_type = NULL)
    {
        parent::__construct(array('user'=>$_user,'signature'=>$_signature,'accountNumber'=>$_accountNumber,'type'=>$_type),false);
    }
    /**
     * Get user value
     * @return string|null
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Set user value
     * @param string $_user the user
     * @return string
     */
    public function setUser($_user)
    {
        return ($this->user = $_user);
    }
    /**
     * Get signature value
     * @return string|null
     */
    public function getSignature()
    {
        return $this->signature;
    }
    /**
     * Set signature value
     * @param string $_signature the signature
     * @return string
     */
    public function setSignature($_signature)
    {
        return ($this->signature = $_signature);
    }
    /**
     * Get accountNumber value
     * @return string|null
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
    /**
     * Set accountNumber value
     * @param string $_accountNumber the accountNumber
     * @return string
     */
    public function setAccountNumber($_accountNumber)
    {
        return ($this->accountNumber = $_accountNumber);
    }
    /**
     * Get type value
     * @return integer|null
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set type value
     * @param integer $_type the type
     * @return integer
     */
    public function setType($_type)
    {
        return ($this->type = $_type);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructAuthentificationType
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
