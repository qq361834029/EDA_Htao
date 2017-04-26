<?php
/**
 * File for class DHLStructCustomerType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCustomerType originally named CustomerType
 * Documentation : Type of customer includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCustomerType extends DHLWsdlClass
{
    /**
     * The Name
     * Meta informations extracted from the WSDL
     * - documentation : Name of customer.
     * @var DHLStructNameType
     */
    public $Name;
    /**
     * The vatID
     * Meta informations extracted from the WSDL
     * - documentation : VAT id.
     * - minOccurs : 0
     * @var string
     */
    public $vatID;
    /**
     * The EKP
     * Meta informations extracted from the WSDL
     * - documentation : First 10 digit number extract from the 14 digit DHL Account Number. E.g. if DHL Account Number is "5000000008 72 01" then EKP is equal to 5000000008.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $EKP;
    /**
     * The Address
     * Meta informations extracted from the WSDL
     * - documentation : Address of customer
     * @var DHLStructNativeAddressType
     */
    public $Address;
    /**
     * The Contact
     * Meta informations extracted from the WSDL
     * - documentation : Contact information
     * @var DHLStructContactType
     */
    public $Contact;
    /**
     * The Bank
     * Meta informations extracted from the WSDL
     * - documentation : Bank information
     * - minOccurs : 0
     * @var DHLStructBankType
     */
    public $Bank;
    /**
     * The note
     * @var anyType
     */
    public $note;
    /**
     * Constructor method for CustomerType
     * @see parent::__construct()
     * @param DHLStructNameType $_name
     * @param string $_vatID
     * @param string $_eKP
     * @param DHLStructNativeAddressType $_address
     * @param DHLStructContactType $_contact
     * @param DHLStructBankType $_bank
     * @param anyType $_note
     * @return DHLStructCustomerType
     */
    public function __construct($_name = NULL,$_vatID = NULL,$_eKP = NULL,$_address = NULL,$_contact = NULL,$_bank = NULL,$_note = NULL)
    {
        parent::__construct(array('Name'=>$_name,'vatID'=>$_vatID,'EKP'=>$_eKP,'Address'=>$_address,'Contact'=>$_contact,'Bank'=>$_bank,'note'=>$_note),false);
    }
    /**
     * Get Name value
     * @return DHLStructNameType|null
     */
    public function getName()
    {
        return $this->Name;
    }
    /**
     * Set Name value
     * @param DHLStructNameType $_name the Name
     * @return DHLStructNameType
     */
    public function setName($_name)
    {
        return ($this->Name = $_name);
    }
    /**
     * Get vatID value
     * @return string|null
     */
    public function getVatID()
    {
        return $this->vatID;
    }
    /**
     * Set vatID value
     * @param string $_vatID the vatID
     * @return string
     */
    public function setVatID($_vatID)
    {
        return ($this->vatID = $_vatID);
    }
    /**
     * Get EKP value
     * @return string|null
     */
    public function getEKP()
    {
        return $this->EKP;
    }
    /**
     * Set EKP value
     * @param string $_eKP the EKP
     * @return string
     */
    public function setEKP($_eKP)
    {
        return ($this->EKP = $_eKP);
    }
    /**
     * Get Address value
     * @return DHLStructNativeAddressType|null
     */
    public function getAddress()
    {
        return $this->Address;
    }
    /**
     * Set Address value
     * @param DHLStructNativeAddressType $_address the Address
     * @return DHLStructNativeAddressType
     */
    public function setAddress($_address)
    {
        return ($this->Address = $_address);
    }
    /**
     * Get Contact value
     * @return DHLStructContactType|null
     */
    public function getContact()
    {
        return $this->Contact;
    }
    /**
     * Set Contact value
     * @param DHLStructContactType $_contact the Contact
     * @return DHLStructContactType
     */
    public function setContact($_contact)
    {
        return ($this->Contact = $_contact);
    }
    /**
     * Get Bank value
     * @return DHLStructBankType|null
     */
    public function getBank()
    {
        return $this->Bank;
    }
    /**
     * Set Bank value
     * @param DHLStructBankType $_bank the Bank
     * @return DHLStructBankType
     */
    public function setBank($_bank)
    {
        return ($this->Bank = $_bank);
    }
    /**
     * Get note value
     * @return anyType|null
     */
    public function getNote()
    {
        return $this->note;
    }
    /**
     * Set note value
     * @param anyType $_note the note
     * @return anyType
     */
    public function setNote($_note)
    {
        return ($this->note = $_note);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCustomerType
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
