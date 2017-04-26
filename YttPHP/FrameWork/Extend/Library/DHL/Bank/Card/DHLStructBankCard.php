<?php
/**
 * File for class DHLStructBankCard
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructBankCard originally named BankCard
 * Documentation : If a bank card shall be used for verifying identity.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructBankCard extends DHLWsdlClass
{
    /**
     * The CardType
     * Meta informations extracted from the WSDL
     * - documentation : Type of bank card. Mandatory if BankCard is chosen as identity instrument.
     * @var string
     */
    public $CardType;
    /**
     * The CardNumber
     * Meta informations extracted from the WSDL
     * - documentation : Number of bank card. Mandatory if BankCard is chosen as identity instrument.
     * @var string
     */
    public $CardNumber;
    /**
     * The BankName
     * Meta informations extracted from the WSDL
     * - documentation : Name of bank. Mandatory if BankCard is chosen as identity instrument.
     * @var string
     */
    public $BankName;
    /**
     * The BankCode
     * Meta informations extracted from the WSDL
     * - documentation : Bank code. Mandatory if BankCard is chosen as identity instrument.
     * @var string
     */
    public $BankCode;
    /**
     * Constructor method for BankCard
     * @see parent::__construct()
     * @param string $_cardType
     * @param string $_cardNumber
     * @param string $_bankName
     * @param string $_bankCode
     * @return DHLStructBankCard
     */
    public function __construct($_cardType = NULL,$_cardNumber = NULL,$_bankName = NULL,$_bankCode = NULL)
    {
        parent::__construct(array('CardType'=>$_cardType,'CardNumber'=>$_cardNumber,'BankName'=>$_bankName,'BankCode'=>$_bankCode),false);
    }
    /**
     * Get CardType value
     * @return string|null
     */
    public function getCardType()
    {
        return $this->CardType;
    }
    /**
     * Set CardType value
     * @param string $_cardType the CardType
     * @return string
     */
    public function setCardType($_cardType)
    {
        return ($this->CardType = $_cardType);
    }
    /**
     * Get CardNumber value
     * @return string|null
     */
    public function getCardNumber()
    {
        return $this->CardNumber;
    }
    /**
     * Set CardNumber value
     * @param string $_cardNumber the CardNumber
     * @return string
     */
    public function setCardNumber($_cardNumber)
    {
        return ($this->CardNumber = $_cardNumber);
    }
    /**
     * Get BankName value
     * @return string|null
     */
    public function getBankName()
    {
        return $this->BankName;
    }
    /**
     * Set BankName value
     * @param string $_bankName the BankName
     * @return string
     */
    public function setBankName($_bankName)
    {
        return ($this->BankName = $_bankName);
    }
    /**
     * Get BankCode value
     * @return string|null
     */
    public function getBankCode()
    {
        return $this->BankCode;
    }
    /**
     * Set BankCode value
     * @param string $_bankCode the BankCode
     * @return string
     */
    public function setBankCode($_bankCode)
    {
        return ($this->BankCode = $_bankCode);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructBankCard
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
