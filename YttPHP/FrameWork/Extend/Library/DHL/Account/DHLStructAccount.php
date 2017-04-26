<?php
/**
 * File for class DHLStructAccount
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructAccount originally named Account
 * Documentation : Container element to provide DHL Express Account Number that is needed to invoke Express shipments.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructAccount extends DHLWsdlClass
{
    /**
     * The accountNumberExpress
     * Meta informations extracted from the WSDL
     * - documentation : Express AccountNumber (9 digits).
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 9
     * - minLength : 9
     * @var string
     */
    public $accountNumberExpress;
    /**
     * Constructor method for Account
     * @see parent::__construct()
     * @param string $_accountNumberExpress
     * @return DHLStructAccount
     */
    public function __construct($_accountNumberExpress = NULL)
    {
        parent::__construct(array('accountNumberExpress'=>$_accountNumberExpress),false);
    }
    /**
     * Get accountNumberExpress value
     * @return string|null
     */
    public function getAccountNumberExpress()
    {
        return $this->accountNumberExpress;
    }
    /**
     * Set accountNumberExpress value
     * @param string $_accountNumberExpress the accountNumberExpress
     * @return string
     */
    public function setAccountNumberExpress($_accountNumberExpress)
    {
        return ($this->accountNumberExpress = $_accountNumberExpress);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructAccount
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
