<?php
/**
 * File for class DHLStructCountryType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCountryType originally named CountryType
 * Documentation : Type of country includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCountryType extends DHLWsdlClass
{
    /**
     * The country
     * Meta informations extracted from the WSDL
     * - documentation : Name of country.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 30
     * @var string
     */
    public $country;
    /**
     * The countryISOCode
     * Meta informations extracted from the WSDL
     * - documentation : Country's ISO-Code.
     * - minOccurs : 0
     * - documentation : Country specific ISO code.
     * - maxLength : 3
     * - minLength : 1
     * @var string
     */
    public $countryISOCode;
    /**
     * The state
     * Meta informations extracted from the WSDL
     * - documentation : Name of state.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 30
     * @var string
     */
    public $state;
    /**
     * Constructor method for CountryType
     * @see parent::__construct()
     * @param string $_country
     * @param string $_countryISOCode
     * @param string $_state
     * @return DHLStructCountryType
     */
    public function __construct($_country = NULL,$_countryISOCode = NULL,$_state = NULL)
    {
        parent::__construct(array('country'=>$_country,'countryISOCode'=>$_countryISOCode,'state'=>$_state),false);
    }
    /**
     * Get country value
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * Set country value
     * @param string $_country the country
     * @return string
     */
    public function setCountry($_country)
    {
        return ($this->country = $_country);
    }
    /**
     * Get countryISOCode value
     * @return string|null
     */
    public function getCountryISOCode()
    {
        return $this->countryISOCode;
    }
    /**
     * Set countryISOCode value
     * @param string $_countryISOCode the countryISOCode
     * @return string
     */
    public function setCountryISOCode($_countryISOCode)
    {
        return ($this->countryISOCode = $_countryISOCode);
    }
    /**
     * Get state value
     * @return string|null
     */
    public function getState()
    {
        return $this->state;
    }
    /**
     * Set state value
     * @param string $_state the state
     * @return string
     */
    public function setState($_state)
    {
        return ($this->state = $_state);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCountryType
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
