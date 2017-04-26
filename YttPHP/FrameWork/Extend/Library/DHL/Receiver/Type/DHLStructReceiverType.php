<?php
/**
 * File for class DHLStructReceiverType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructReceiverType originally named ReceiverType
 * Documentation : The receiver data.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructReceiverType extends DHLWsdlClass
{
    /**
     * The Company
     * Meta informations extracted from the WSDL
     * - documentation : Receiver is company.
     * @var DHLStructNameType
     */
    public $Company;
    /**
     * The Address
     * Meta informations extracted from the WSDL
     * - documentation : The address data of the receiver.
     * @var DHLStructNativeAddressType
     */
    public $Address;
    /**
     * The Packstation
     * Meta informations extracted from the WSDL
     * - documentation : The address of the receiver is a german Packstation (only valid for DD shipments)
     * @var DHLStructPackstationType
     */
    public $Packstation;
    /**
     * The Postfiliale
     * Meta informations extracted from the WSDL
     * - documentation : The address of the receiver is a german Postfiliale (only valid for DD shipments)
     * @var DHLStructPostfilialeType
     */
    public $Postfiliale;
    /**
     * The Communication
     * Meta informations extracted from the WSDL
     * - documentation : Information about communication.
     * @var DHLStructCommunicationType
     */
    public $Communication;
    /**
     * The VAT
     * Meta informations extracted from the WSDL
     * - documentation : The VAT ID of the Receiver. Field length must be less than or equal to 20.
     * - minOccurs : 0
     * @var string
     */
    public $VAT;
    /**
     * Constructor method for ReceiverType
     * @see parent::__construct()
     * @param DHLStructNameType $_company
     * @param DHLStructNativeAddressType $_address
     * @param DHLStructPackstationType $_packstation
     * @param DHLStructPostfilialeType $_postfiliale
     * @param DHLStructCommunicationType $_communication
     * @param string $_vAT
     * @return DHLStructReceiverType
     */
    public function __construct($_company = NULL,$_address = NULL,$_packstation = NULL,$_postfiliale = NULL,$_communication = NULL,$_vAT = NULL)
    {
        parent::__construct(array('Company'=>$_company,'Address'=>$_address,'Packstation'=>$_packstation,'Postfiliale'=>$_postfiliale,'Communication'=>$_communication,'VAT'=>$_vAT),false);
    }
    /**
     * Get Company value
     * @return DHLStructNameType|null
     */
    public function getCompany()
    {
        return $this->Company;
    }
    /**
     * Set Company value
     * @param DHLStructNameType $_company the Company
     * @return DHLStructNameType
     */
    public function setCompany($_company)
    {
        return ($this->Company = $_company);
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
     * Get Packstation value
     * @return DHLStructPackstationType|null
     */
    public function getPackstation()
    {
        return $this->Packstation;
    }
    /**
     * Set Packstation value
     * @param DHLStructPackstationType $_packstation the Packstation
     * @return DHLStructPackstationType
     */
    public function setPackstation($_packstation)
    {
        return ($this->Packstation = $_packstation);
    }
    /**
     * Get Postfiliale value
     * @return DHLStructPostfilialeType|null
     */
    public function getPostfiliale()
    {
        return $this->Postfiliale;
    }
    /**
     * Set Postfiliale value
     * @param DHLStructPostfilialeType $_postfiliale the Postfiliale
     * @return DHLStructPostfilialeType
     */
    public function setPostfiliale($_postfiliale)
    {
        return ($this->Postfiliale = $_postfiliale);
    }
    /**
     * Get Communication value
     * @return DHLStructCommunicationType|null
     */
    public function getCommunication()
    {
        return $this->Communication;
    }
    /**
     * Set Communication value
     * @param DHLStructCommunicationType $_communication the Communication
     * @return DHLStructCommunicationType
     */
    public function setCommunication($_communication)
    {
        return ($this->Communication = $_communication);
    }
    /**
     * Get VAT value
     * @return string|null
     */
    public function getVAT()
    {
        return $this->VAT;
    }
    /**
     * Set VAT value
     * @param string $_vAT the VAT
     * @return string
     */
    public function setVAT($_vAT)
    {
        return ($this->VAT = $_vAT);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructReceiverType
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
