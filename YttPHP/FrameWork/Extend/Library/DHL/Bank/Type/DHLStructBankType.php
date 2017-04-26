<?php
/**
 * File for class DHLStructBankType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructBankType originally named BankType
 * Documentation : Type of bank information includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructBankType extends DHLWsdlClass
{
    /**
     * The accountOwner
     * Meta informations extracted from the WSDL
     * - documentation : Name of bank account owner.
     * @var string
     */
    public $accountOwner;
    /**
     * The accountNumber
     * Meta informations extracted from the WSDL
     * - documentation : Bank account number.
     * - minOccurs : 0
     * @var string
     */
    public $accountNumber;
    /**
     * The bankCode
     * Meta informations extracted from the WSDL
     * - documentation : Bank code number.
     * - minOccurs : 0
     * @var string
     */
    public $bankCode;
    /**
     * The bankName
     * Meta informations extracted from the WSDL
     * - documentation : Name of bank.
     * - minOccurs : 0
     * @var string
     */
    public $bankName;
    /**
     * The iban
     * Meta informations extracted from the WSDL
     * - documentation : IBAN code of bank account.
     * - minOccurs : 0
     * @var string
     */
    public $iban;
    /**
     * The note
     * Meta informations extracted from the WSDL
     * - documentation : Particular notes e.g. for pickup or delivery. Purpose of bank information. Additional notes
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 100
     * @var string
     */
    public $note;
    /**
     * The bic
     * Meta informations extracted from the WSDL
     * - documentation : Bank-Information-Code (BankCCL) of bank account.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 11
     * @var string
     */
    public $bic;
    /**
     * Constructor method for BankType
     * @see parent::__construct()
     * @param string $_accountOwner
     * @param string $_accountNumber
     * @param string $_bankCode
     * @param string $_bankName
     * @param string $_iban
     * @param string $_note
     * @param string $_bic
     * @return DHLStructBankType
     */
    public function __construct($_accountOwner = NULL,$_accountNumber = NULL,$_bankCode = NULL,$_bankName = NULL,$_iban = NULL,$_note = NULL,$_bic = NULL)
    {
        parent::__construct(array('accountOwner'=>$_accountOwner,'accountNumber'=>$_accountNumber,'bankCode'=>$_bankCode,'bankName'=>$_bankName,'iban'=>$_iban,'note'=>$_note,'bic'=>$_bic),false);
    }
    /**
     * Get accountOwner value
     * @return string|null
     */
    public function getAccountOwner()
    {
        return $this->accountOwner;
    }
    /**
     * Set accountOwner value
     * @param string $_accountOwner the accountOwner
     * @return string
     */
    public function setAccountOwner($_accountOwner)
    {
        return ($this->accountOwner = $_accountOwner);
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
     * Get bankCode value
     * @return string|null
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }
    /**
     * Set bankCode value
     * @param string $_bankCode the bankCode
     * @return string
     */
    public function setBankCode($_bankCode)
    {
        return ($this->bankCode = $_bankCode);
    }
    /**
     * Get bankName value
     * @return string|null
     */
    public function getBankName()
    {
        return $this->bankName;
    }
    /**
     * Set bankName value
     * @param string $_bankName the bankName
     * @return string
     */
    public function setBankName($_bankName)
    {
        return ($this->bankName = $_bankName);
    }
    /**
     * Get iban value
     * @return string|null
     */
    public function getIban()
    {
        return $this->iban;
    }
    /**
     * Set iban value
     * @param string $_iban the iban
     * @return string
     */
    public function setIban($_iban)
    {
        return ($this->iban = $_iban);
    }
    /**
     * Get note value
     * @return string|null
     */
    public function getNote()
    {
        return $this->note;
    }
    /**
     * Set note value
     * @param string $_note the note
     * @return string
     */
    public function setNote($_note)
    {
        return ($this->note = $_note);
    }
    /**
     * Get bic value
     * @return string|null
     */
    public function getBic()
    {
        return $this->bic;
    }
    /**
     * Set bic value
     * @param string $_bic the bic
     * @return string
     */
    public function setBic($_bic)
    {
        return ($this->bic = $_bic);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructBankType
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
