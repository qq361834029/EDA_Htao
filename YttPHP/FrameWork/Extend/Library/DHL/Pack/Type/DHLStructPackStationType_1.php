<?php
/**
 * File for class DHLStructPackStationType_1
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructPackStationType_1 originally named PackStationType
 * Documentation : Type of packstation. includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructPackStationType_1 extends DHLWsdlClass
{
    /**
     * The number
     * Meta informations extracted from the WSDL
     * - documentation : ID of customer. Number of postoffice.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * - minLength : 1
     * - pattern : [0-9]{1,10}
     * @var string
     */
    public $number;
    /**
     * The stationID
     * Meta informations extracted from the WSDL
     * - documentation : ID of Packstation.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 3
     * - minLength : 3
     * @var string
     */
    public $stationID;
    /**
     * The Zip
     * @var DHLStructZipType
     */
    public $Zip;
    /**
     * The city
     * Meta informations extracted from the WSDL
     * - documentation : City name.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $city;
    /**
     * The Origin
     * @var DHLStructCountryType
     */
    public $Origin;
    /**
     * Constructor method for PackStationType
     * @see parent::__construct()
     * @param string $_number
     * @param string $_stationID
     * @param DHLStructZipType $_zip
     * @param string $_city
     * @param DHLStructCountryType $_origin
     * @return DHLStructPackStationType_1
     */
    public function __construct($_number = NULL,$_stationID = NULL,$_zip = NULL,$_city = NULL,$_origin = NULL)
    {
        parent::__construct(array('number'=>$_number,'stationID'=>$_stationID,'Zip_1'=>$_zip,'city_1'=>$_city,'Origin'=>$_origin),false);
    }
    /**
     * Get number value
     * @return string|null
     */
    public function getNumber()
    {
        return $this->number;
    }
    /**
     * Set number value
     * @param string $_number the number
     * @return string
     */
    public function setNumber($_number)
    {
        return ($this->number = $_number);
    }
    /**
     * Get stationID value
     * @return string|null
     */
    public function getStationID()
    {
        return $this->stationID;
    }
    /**
     * Set stationID value
     * @param string $_stationID the stationID
     * @return string
     */
    public function setStationID($_stationID)
    {
        return ($this->stationID = $_stationID);
    }
    /**
     * Get Zip value
     * @return DHLStructZipType|null
     */
    public function getZip_1()
    {
        return $this->Zip;
    }
    /**
     * Set Zip value
     * @param DHLStructZipType $_zip the Zip
     * @return DHLStructZipType
     */
    public function setZip_1($_zip)
    {
        return ($this->Zip = $_zip);
    }
    /**
     * Get city value
     * @return string|null
     */
    public function getCity_1()
    {
        return $this->city;
    }
    /**
     * Set city value
     * @param string $_city the city
     * @return string
     */
    public function setCity_1($_city)
    {
        return ($this->city = $_city);
    }
    /**
     * Get Origin value
     * @return DHLStructCountryType|null
     */
    public function getOrigin()
    {
        return $this->Origin;
    }
    /**
     * Set Origin value
     * @param DHLStructCountryType $_origin the Origin
     * @return DHLStructCountryType
     */
    public function setOrigin($_origin)
    {
        return ($this->Origin = $_origin);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructPackStationType_1
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
