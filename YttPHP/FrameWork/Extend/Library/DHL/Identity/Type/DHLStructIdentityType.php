<?php
/**
 * File for class DHLStructIdentityType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructIdentityType originally named IdentityType
 * Documentation : Identity data (used for ident services).
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructIdentityType extends DHLWsdlClass
{
    /**
     * The FirstName
     * Meta informations extracted from the WSDL
     * - documentation : First name of the person to be verified. Field length must be less than or equal to 30.
     * @var string
     */
    public $FirstName;
    /**
     * The LastName
     * Meta informations extracted from the WSDL
     * - documentation : Last name of the person to be verified. Field length must be less than or equal to 30.
     * @var string
     */
    public $LastName;
    /**
     * The Street
     * Meta informations extracted from the WSDL
     * - documentation : Name of the street of registered address. Field length must be less than or equal to 30.
     * @var string
     */
    public $Street;
    /**
     * The HouseNumber
     * Meta informations extracted from the WSDL
     * - documentation : House number of registered address. Field length must be less than or equal to 10.
     * @var string
     */
    public $HouseNumber;
    /**
     * The Postcode
     * Meta informations extracted from the WSDL
     * - documentation : Postcode of registered address. Field length must be less than or equal to 15.
     * @var string
     */
    public $Postcode;
    /**
     * The City
     * Meta informations extracted from the WSDL
     * - documentation : City of registered address. Field length must be less than or equal to 30.
     * @var string
     */
    public $City;
    /**
     * The DateOfBirth
     * Meta informations extracted from the WSDL
     * - documentation : Person's date of birth.Format must be yyyy-mm-dd.
     * @var string
     */
    public $DateOfBirth;
    /**
     * The Nationality
     * Meta informations extracted from the WSDL
     * - documentation : Person's nationality. Field length must be less than or equal to 30.
     * @var string
     */
    public $Nationality;
    /**
     * Constructor method for IdentityType
     * @see parent::__construct()
     * @param string $_firstName
     * @param string $_lastName
     * @param string $_street
     * @param string $_houseNumber
     * @param string $_postcode
     * @param string $_city
     * @param string $_dateOfBirth
     * @param string $_nationality
     * @return DHLStructIdentityType
     */
    public function __construct($_firstName = NULL,$_lastName = NULL,$_street = NULL,$_houseNumber = NULL,$_postcode = NULL,$_city = NULL,$_dateOfBirth = NULL,$_nationality = NULL)
    {
        parent::__construct(array('FirstName'=>$_firstName,'LastName'=>$_lastName,'Street'=>$_street,'HouseNumber'=>$_houseNumber,'Postcode'=>$_postcode,'City'=>$_city,'DateOfBirth'=>$_dateOfBirth,'Nationality'=>$_nationality),false);
    }
    /**
     * Get FirstName value
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }
    /**
     * Set FirstName value
     * @param string $_firstName the FirstName
     * @return string
     */
    public function setFirstName($_firstName)
    {
        return ($this->FirstName = $_firstName);
    }
    /**
     * Get LastName value
     * @return string|null
     */
    public function getLastName()
    {
        return $this->LastName;
    }
    /**
     * Set LastName value
     * @param string $_lastName the LastName
     * @return string
     */
    public function setLastName($_lastName)
    {
        return ($this->LastName = $_lastName);
    }
    /**
     * Get Street value
     * @return string|null
     */
    public function getStreet()
    {
        return $this->Street;
    }
    /**
     * Set Street value
     * @param string $_street the Street
     * @return string
     */
    public function setStreet($_street)
    {
        return ($this->Street = $_street);
    }
    /**
     * Get HouseNumber value
     * @return string|null
     */
    public function getHouseNumber()
    {
        return $this->HouseNumber;
    }
    /**
     * Set HouseNumber value
     * @param string $_houseNumber the HouseNumber
     * @return string
     */
    public function setHouseNumber($_houseNumber)
    {
        return ($this->HouseNumber = $_houseNumber);
    }
    /**
     * Get Postcode value
     * @return string|null
     */
    public function getPostcode()
    {
        return $this->Postcode;
    }
    /**
     * Set Postcode value
     * @param string $_postcode the Postcode
     * @return string
     */
    public function setPostcode($_postcode)
    {
        return ($this->Postcode = $_postcode);
    }
    /**
     * Get City value
     * @return string|null
     */
    public function getCity()
    {
        return $this->City;
    }
    /**
     * Set City value
     * @param string $_city the City
     * @return string
     */
    public function setCity($_city)
    {
        return ($this->City = $_city);
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
     * Get Nationality value
     * @return string|null
     */
    public function getNationality()
    {
        return $this->Nationality;
    }
    /**
     * Set Nationality value
     * @param string $_nationality the Nationality
     * @return string
     */
    public function setNationality($_nationality)
    {
        return ($this->Nationality = $_nationality);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructIdentityType
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
