<?php
/**
 * File for class DHLStructContactType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructContactType originally named ContactType
 * Documentation : Type of contact. includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructContactType extends DHLWsdlClass
{
    /**
     * The Communication
     * Meta informations extracted from the WSDL
     * - documentation : Contact communication information.
     * - minOccurs : 0
     * @var DHLStructCommunicationType
     */
    public $Communication;
    /**
     * The Address
     * Meta informations extracted from the WSDL
     * - documentation : Contact address.
     * - minOccurs : 0
     * @var DHLStructNativeAddressType
     */
    public $Address;
    /**
     * The Name
     * Meta informations extracted from the WSDL
     * - documentation : Contact name.
     * - minOccurs : 0
     * @var DHLStructNameType
     */
    public $Name;
    /**
     * Constructor method for ContactType
     * @see parent::__construct()
     * @param DHLStructCommunicationType $_communication
     * @param DHLStructNativeAddressType $_address
     * @param DHLStructNameType $_name
     * @return DHLStructContactType
     */
    public function __construct($_communication = NULL,$_address = NULL,$_name = NULL)
    {
        parent::__construct(array('Communication'=>$_communication,'Address'=>$_address,'Name'=>$_name),false);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructContactType
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
