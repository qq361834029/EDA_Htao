<?php
/**
 * File for class DHLStructIdent
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructIdent originally named Ident
 * Documentation : Service to validate identity of recipient. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructIdent extends DHLWsdlClass
{
    /**
     * The Name
     * Meta informations extracted from the WSDL
     * - documentation : Name (firstname + lastname). Mandatory if service Ident is chosen. Field length must be less than or equal to 55.
     * @var string
     */
    public $Name;
    /**
     * The DateOfBirth
     * Meta informations extracted from the WSDL
     * - documentation : Date of birth in format yyyy-mm-dd. Mandatory if service Ident is chosen. Date of birth in format yyyy-mm-dd. Field length must be less than or equal to 35.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $DateOfBirth;
    /**
     * The IdentityCardType
     * Meta informations extracted from the WSDL
     * - documentation : The type of the identity card (e.g. ID, Passport).Mandatory if service Ident is chosen.
     * @var string
     */
    public $IdentityCardType;
    /**
     * The IdentityCardNumber
     * Meta informations extracted from the WSDL
     * - documentation : The number of the identity card.Mandatory if service Ident is chosen.
     * @var string
     */
    public $IdentityCardNumber;
    /**
     * Constructor method for Ident
     * @see parent::__construct()
     * @param string $_name
     * @param string $_dateOfBirth
     * @param string $_identityCardType
     * @param string $_identityCardNumber
     * @return DHLStructIdent
     */
    public function __construct($_name = NULL,$_dateOfBirth = NULL,$_identityCardType = NULL,$_identityCardNumber = NULL)
    {
        parent::__construct(array('Name'=>$_name,'DateOfBirth'=>$_dateOfBirth,'IdentityCardType'=>$_identityCardType,'IdentityCardNumber'=>$_identityCardNumber),false);
    }
    /**
     * Get Name value
     * @return string|null
     */
    public function getName()
    {
        return $this->Name;
    }
    /**
     * Set Name value
     * @param string $_name the Name
     * @return string
     */
    public function setName($_name)
    {
        return ($this->Name = $_name);
    }
    /**
     * Get DateOfBirth value
     * @return string|null
     */
    public function getDateOfBirth()
    {
        return $this->DateOfBirth;
    }
    /**
     * Set DateOfBirth value
     * @param string $_dateOfBirth the DateOfBirth
     * @return string
     */
    public function setDateOfBirth($_dateOfBirth)
    {
        return ($this->DateOfBirth = $_dateOfBirth);
    }
    /**
     * Get IdentityCardType value
     * @return string|null
     */
    public function getIdentityCardType()
    {
        return $this->IdentityCardType;
    }
    /**
     * Set IdentityCardType value
     * @param string $_identityCardType the IdentityCardType
     * @return string
     */
    public function setIdentityCardType($_identityCardType)
    {
        return ($this->IdentityCardType = $_identityCardType);
    }
    /**
     * Get IdentityCardNumber value
     * @return string|null
     */
    public function getIdentityCardNumber()
    {
        return $this->IdentityCardNumber;
    }
    /**
     * Set IdentityCardNumber value
     * @param string $_identityCardNumber the IdentityCardNumber
     * @return string
     */
    public function setIdentityCardNumber($_identityCardNumber)
    {
        return ($this->IdentityCardNumber = $_identityCardNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructIdent
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
