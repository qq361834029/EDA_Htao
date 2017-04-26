<?php
/**
 * File for class DHLStructIdentPremium
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructIdentPremium originally named IdentPremium
 * Documentation : Ident Premium
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructIdentPremium extends DHLWsdlClass
{
    /**
     * The Firstname
     * Meta informations extracted from the WSDL
     * - documentation : The firstname.
     * - minOccurs : 0
     * @var string
     */
    public $Firstname;
    /**
     * The Name
     * Meta informations extracted from the WSDL
     * - documentation : The surname.
     * - minOccurs : 0
     * @var string
     */
    public $Name;
    /**
     * The IdentityCardType
     * Meta informations extracted from the WSDL
     * - documentation : The type of the identity card: valid values are "01"=(Identitycard/Personalausweis), "02"=Passport.
     * - minOccurs : 0
     * @var string
     */
    public $IdentityCardType;
    /**
     * The IdentityCardNumber
     * Meta informations extracted from the WSDL
     * - documentation : The number of the identity card. Field length must be less than or equal to 20.
     * - minOccurs : 0
     * @var string
     */
    public $IdentityCardNumber;
    /**
     * The MinimumAge
     * Meta informations extracted from the WSDL
     * - documentation : Minimum age (16 or 18). Field length must be less than or equal to 22.
     * - minOccurs : 0
     * @var string
     */
    public $MinimumAge;
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
     * The StreetAndHouseNumber
     * Meta informations extracted from the WSDL
     * - documentation : Streetname as printed on the identity card.
     * @var string
     */
    public $StreetAndHouseNumber;
    /**
     * The PostcodeAndCity
     * Meta informations extracted from the WSDL
     * - documentation : Postcode and city as printed on the identity card.
     * - minOccurs : 0
     * @var string
     */
    public $PostcodeAndCity;
    /**
     * The District
     * Meta informations extracted from the WSDL
     * - documentation : District of the city.
     * - minOccurs : 0
     * @var string
     */
    public $District;
    /**
     * The WithIDPContract
     * Meta informations extracted from the WSDL
     * - documentation : With IDP Contract.
     * - minOccurs : 0
     * @var boolean
     */
    public $WithIDPContract;
    /**
     * The ContractID
     * Meta informations extracted from the WSDL
     * - documentation : Constract ID.
     * - minOccurs : 0
     * @var string
     */
    public $ContractID;
    /**
     * The Nationality
     * Meta informations extracted from the WSDL
     * - documentation : iso contrycode (e.g. DE, NL, US)
     * - minOccurs : 0
     * @var string
     */
    public $Nationality;
    /**
     * The FreeText1
     * Meta informations extracted from the WSDL
     * - documentation : Freetext 1
     * - minOccurs : 0
     * @var string
     */
    public $FreeText1;
    /**
     * The FreeText2
     * Meta informations extracted from the WSDL
     * - documentation : Freetext 2
     * - minOccurs : 0
     * @var string
     */
    public $FreeText2;
    /**
     * The CorrOfNameAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of name is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfNameAllowed;
    /**
     * The CorrOfFirstNameAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of first name is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfFirstNameAllowed;
    /**
     * The CorrOfDayOfBirthAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of day of birth is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfDayOfBirthAllowed;
    /**
     * The CorrOfMinimumAgeAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of minimum age is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfMinimumAgeAllowed;
    /**
     * The CorrOfIdentityCardTypeAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of the identity card type is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfIdentityCardTypeAllowed;
    /**
     * The CorrOfIdentityCardNumberAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of the identity card number is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfIdentityCardNumberAllowed;
    /**
     * The CorrOfAddressAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of the address is allowed (postcode, city, district, streetname, housenumber)
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfAddressAllowed;
    /**
     * The CorrOfContractAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of the contract is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfContractAllowed;
    /**
     * The CorrOfContractIdAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of the IDP contract ID is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfContractIdAllowed;
    /**
     * The CorrOfNationalityAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of the nationality is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfNationalityAllowed;
    /**
     * The CorrOfFreetextsAllowed
     * Meta informations extracted from the WSDL
     * - documentation : Flag, if the correction of the freetexts is allowed
     * - minOccurs : 0
     * @var boolean
     */
    public $CorrOfFreetextsAllowed;
    /**
     * Constructor method for IdentPremium
     * @see parent::__construct()
     * @param string $_firstname
     * @param string $_name
     * @param string $_identityCardType
     * @param string $_identityCardNumber
     * @param string $_minimumAge
     * @param string $_dateOfBirth
     * @param string $_streetAndHouseNumber
     * @param string $_postcodeAndCity
     * @param string $_district
     * @param boolean $_withIDPContract
     * @param string $_contractID
     * @param string $_nationality
     * @param string $_freeText1
     * @param string $_freeText2
     * @param boolean $_corrOfNameAllowed
     * @param boolean $_corrOfFirstNameAllowed
     * @param boolean $_corrOfDayOfBirthAllowed
     * @param boolean $_corrOfMinimumAgeAllowed
     * @param boolean $_corrOfIdentityCardTypeAllowed
     * @param boolean $_corrOfIdentityCardNumberAllowed
     * @param boolean $_corrOfAddressAllowed
     * @param boolean $_corrOfContractAllowed
     * @param boolean $_corrOfContractIdAllowed
     * @param boolean $_corrOfNationalityAllowed
     * @param boolean $_corrOfFreetextsAllowed
     * @return DHLStructIdentPremium
     */
    public function __construct($_firstname = NULL,$_name = NULL,$_identityCardType = NULL,$_identityCardNumber = NULL,$_minimumAge = NULL,$_dateOfBirth = NULL,$_streetAndHouseNumber = NULL,$_postcodeAndCity = NULL,$_district = NULL,$_withIDPContract = NULL,$_contractID = NULL,$_nationality = NULL,$_freeText1 = NULL,$_freeText2 = NULL,$_corrOfNameAllowed = NULL,$_corrOfFirstNameAllowed = NULL,$_corrOfDayOfBirthAllowed = NULL,$_corrOfMinimumAgeAllowed = NULL,$_corrOfIdentityCardTypeAllowed = NULL,$_corrOfIdentityCardNumberAllowed = NULL,$_corrOfAddressAllowed = NULL,$_corrOfContractAllowed = NULL,$_corrOfContractIdAllowed = NULL,$_corrOfNationalityAllowed = NULL,$_corrOfFreetextsAllowed = NULL)
    {
        parent::__construct(array('Firstname'=>$_firstname,'Name'=>$_name,'IdentityCardType'=>$_identityCardType,'IdentityCardNumber'=>$_identityCardNumber,'MinimumAge'=>$_minimumAge,'DateOfBirth'=>$_dateOfBirth,'StreetAndHouseNumber'=>$_streetAndHouseNumber,'PostcodeAndCity'=>$_postcodeAndCity,'District'=>$_district,'WithIDPContract'=>$_withIDPContract,'ContractID'=>$_contractID,'Nationality'=>$_nationality,'FreeText1'=>$_freeText1,'FreeText2'=>$_freeText2,'CorrOfNameAllowed'=>$_corrOfNameAllowed,'CorrOfFirstNameAllowed'=>$_corrOfFirstNameAllowed,'CorrOfDayOfBirthAllowed'=>$_corrOfDayOfBirthAllowed,'CorrOfMinimumAgeAllowed'=>$_corrOfMinimumAgeAllowed,'CorrOfIdentityCardTypeAllowed'=>$_corrOfIdentityCardTypeAllowed,'CorrOfIdentityCardNumberAllowed'=>$_corrOfIdentityCardNumberAllowed,'CorrOfAddressAllowed'=>$_corrOfAddressAllowed,'CorrOfContractAllowed'=>$_corrOfContractAllowed,'CorrOfContractIdAllowed'=>$_corrOfContractIdAllowed,'CorrOfNationalityAllowed'=>$_corrOfNationalityAllowed,'CorrOfFreetextsAllowed'=>$_corrOfFreetextsAllowed),false);
    }
    /**
     * Get Firstname value
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->Firstname;
    }
    /**
     * Set Firstname value
     * @param string $_firstname the Firstname
     * @return string
     */
    public function setFirstname($_firstname)
    {
        return ($this->Firstname = $_firstname);
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
     * Get MinimumAge value
     * @return string|null
     */
    public function getMinimumAge()
    {
        return $this->MinimumAge;
    }
    /**
     * Set MinimumAge value
     * @param string $_minimumAge the MinimumAge
     * @return string
     */
    public function setMinimumAge($_minimumAge)
    {
        return ($this->MinimumAge = $_minimumAge);
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
     * Get StreetAndHouseNumber value
     * @return string|null
     */
    public function getStreetAndHouseNumber()
    {
        return $this->StreetAndHouseNumber;
    }
    /**
     * Set StreetAndHouseNumber value
     * @param string $_streetAndHouseNumber the StreetAndHouseNumber
     * @return string
     */
    public function setStreetAndHouseNumber($_streetAndHouseNumber)
    {
        return ($this->StreetAndHouseNumber = $_streetAndHouseNumber);
    }
    /**
     * Get PostcodeAndCity value
     * @return string|null
     */
    public function getPostcodeAndCity()
    {
        return $this->PostcodeAndCity;
    }
    /**
     * Set PostcodeAndCity value
     * @param string $_postcodeAndCity the PostcodeAndCity
     * @return string
     */
    public function setPostcodeAndCity($_postcodeAndCity)
    {
        return ($this->PostcodeAndCity = $_postcodeAndCity);
    }
    /**
     * Get District value
     * @return string|null
     */
    public function getDistrict()
    {
        return $this->District;
    }
    /**
     * Set District value
     * @param string $_district the District
     * @return string
     */
    public function setDistrict($_district)
    {
        return ($this->District = $_district);
    }
    /**
     * Get WithIDPContract value
     * @return boolean|null
     */
    public function getWithIDPContract()
    {
        return $this->WithIDPContract;
    }
    /**
     * Set WithIDPContract value
     * @param boolean $_withIDPContract the WithIDPContract
     * @return boolean
     */
    public function setWithIDPContract($_withIDPContract)
    {
        return ($this->WithIDPContract = $_withIDPContract);
    }
    /**
     * Get ContractID value
     * @return string|null
     */
    public function getContractID()
    {
        return $this->ContractID;
    }
    /**
     * Set ContractID value
     * @param string $_contractID the ContractID
     * @return string
     */
    public function setContractID($_contractID)
    {
        return ($this->ContractID = $_contractID);
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
     * Get FreeText1 value
     * @return string|null
     */
    public function getFreeText1()
    {
        return $this->FreeText1;
    }
    /**
     * Set FreeText1 value
     * @param string $_freeText1 the FreeText1
     * @return string
     */
    public function setFreeText1($_freeText1)
    {
        return ($this->FreeText1 = $_freeText1);
    }
    /**
     * Get FreeText2 value
     * @return string|null
     */
    public function getFreeText2()
    {
        return $this->FreeText2;
    }
    /**
     * Set FreeText2 value
     * @param string $_freeText2 the FreeText2
     * @return string
     */
    public function setFreeText2($_freeText2)
    {
        return ($this->FreeText2 = $_freeText2);
    }
    /**
     * Get CorrOfNameAllowed value
     * @return boolean|null
     */
    public function getCorrOfNameAllowed()
    {
        return $this->CorrOfNameAllowed;
    }
    /**
     * Set CorrOfNameAllowed value
     * @param boolean $_corrOfNameAllowed the CorrOfNameAllowed
     * @return boolean
     */
    public function setCorrOfNameAllowed($_corrOfNameAllowed)
    {
        return ($this->CorrOfNameAllowed = $_corrOfNameAllowed);
    }
    /**
     * Get CorrOfFirstNameAllowed value
     * @return boolean|null
     */
    public function getCorrOfFirstNameAllowed()
    {
        return $this->CorrOfFirstNameAllowed;
    }
    /**
     * Set CorrOfFirstNameAllowed value
     * @param boolean $_corrOfFirstNameAllowed the CorrOfFirstNameAllowed
     * @return boolean
     */
    public function setCorrOfFirstNameAllowed($_corrOfFirstNameAllowed)
    {
        return ($this->CorrOfFirstNameAllowed = $_corrOfFirstNameAllowed);
    }
    /**
     * Get CorrOfDayOfBirthAllowed value
     * @return boolean|null
     */
    public function getCorrOfDayOfBirthAllowed()
    {
        return $this->CorrOfDayOfBirthAllowed;
    }
    /**
     * Set CorrOfDayOfBirthAllowed value
     * @param boolean $_corrOfDayOfBirthAllowed the CorrOfDayOfBirthAllowed
     * @return boolean
     */
    public function setCorrOfDayOfBirthAllowed($_corrOfDayOfBirthAllowed)
    {
        return ($this->CorrOfDayOfBirthAllowed = $_corrOfDayOfBirthAllowed);
    }
    /**
     * Get CorrOfMinimumAgeAllowed value
     * @return boolean|null
     */
    public function getCorrOfMinimumAgeAllowed()
    {
        return $this->CorrOfMinimumAgeAllowed;
    }
    /**
     * Set CorrOfMinimumAgeAllowed value
     * @param boolean $_corrOfMinimumAgeAllowed the CorrOfMinimumAgeAllowed
     * @return boolean
     */
    public function setCorrOfMinimumAgeAllowed($_corrOfMinimumAgeAllowed)
    {
        return ($this->CorrOfMinimumAgeAllowed = $_corrOfMinimumAgeAllowed);
    }
    /**
     * Get CorrOfIdentityCardTypeAllowed value
     * @return boolean|null
     */
    public function getCorrOfIdentityCardTypeAllowed()
    {
        return $this->CorrOfIdentityCardTypeAllowed;
    }
    /**
     * Set CorrOfIdentityCardTypeAllowed value
     * @param boolean $_corrOfIdentityCardTypeAllowed the CorrOfIdentityCardTypeAllowed
     * @return boolean
     */
    public function setCorrOfIdentityCardTypeAllowed($_corrOfIdentityCardTypeAllowed)
    {
        return ($this->CorrOfIdentityCardTypeAllowed = $_corrOfIdentityCardTypeAllowed);
    }
    /**
     * Get CorrOfIdentityCardNumberAllowed value
     * @return boolean|null
     */
    public function getCorrOfIdentityCardNumberAllowed()
    {
        return $this->CorrOfIdentityCardNumberAllowed;
    }
    /**
     * Set CorrOfIdentityCardNumberAllowed value
     * @param boolean $_corrOfIdentityCardNumberAllowed the CorrOfIdentityCardNumberAllowed
     * @return boolean
     */
    public function setCorrOfIdentityCardNumberAllowed($_corrOfIdentityCardNumberAllowed)
    {
        return ($this->CorrOfIdentityCardNumberAllowed = $_corrOfIdentityCardNumberAllowed);
    }
    /**
     * Get CorrOfAddressAllowed value
     * @return boolean|null
     */
    public function getCorrOfAddressAllowed()
    {
        return $this->CorrOfAddressAllowed;
    }
    /**
     * Set CorrOfAddressAllowed value
     * @param boolean $_corrOfAddressAllowed the CorrOfAddressAllowed
     * @return boolean
     */
    public function setCorrOfAddressAllowed($_corrOfAddressAllowed)
    {
        return ($this->CorrOfAddressAllowed = $_corrOfAddressAllowed);
    }
    /**
     * Get CorrOfContractAllowed value
     * @return boolean|null
     */
    public function getCorrOfContractAllowed()
    {
        return $this->CorrOfContractAllowed;
    }
    /**
     * Set CorrOfContractAllowed value
     * @param boolean $_corrOfContractAllowed the CorrOfContractAllowed
     * @return boolean
     */
    public function setCorrOfContractAllowed($_corrOfContractAllowed)
    {
        return ($this->CorrOfContractAllowed = $_corrOfContractAllowed);
    }
    /**
     * Get CorrOfContractIdAllowed value
     * @return boolean|null
     */
    public function getCorrOfContractIdAllowed()
    {
        return $this->CorrOfContractIdAllowed;
    }
    /**
     * Set CorrOfContractIdAllowed value
     * @param boolean $_corrOfContractIdAllowed the CorrOfContractIdAllowed
     * @return boolean
     */
    public function setCorrOfContractIdAllowed($_corrOfContractIdAllowed)
    {
        return ($this->CorrOfContractIdAllowed = $_corrOfContractIdAllowed);
    }
    /**
     * Get CorrOfNationalityAllowed value
     * @return boolean|null
     */
    public function getCorrOfNationalityAllowed()
    {
        return $this->CorrOfNationalityAllowed;
    }
    /**
     * Set CorrOfNationalityAllowed value
     * @param boolean $_corrOfNationalityAllowed the CorrOfNationalityAllowed
     * @return boolean
     */
    public function setCorrOfNationalityAllowed($_corrOfNationalityAllowed)
    {
        return ($this->CorrOfNationalityAllowed = $_corrOfNationalityAllowed);
    }
    /**
     * Get CorrOfFreetextsAllowed value
     * @return boolean|null
     */
    public function getCorrOfFreetextsAllowed()
    {
        return $this->CorrOfFreetextsAllowed;
    }
    /**
     * Set CorrOfFreetextsAllowed value
     * @param boolean $_corrOfFreetextsAllowed the CorrOfFreetextsAllowed
     * @return boolean
     */
    public function setCorrOfFreetextsAllowed($_corrOfFreetextsAllowed)
    {
        return ($this->CorrOfFreetextsAllowed = $_corrOfFreetextsAllowed);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructIdentPremium
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
