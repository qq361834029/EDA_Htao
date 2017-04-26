<?php
/**
 * File for class DHLStructNativeAddressType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructNativeAddressType originally named NativeAddressType
 * Documentation : Type of native address includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructNativeAddressType extends DHLWsdlClass
{
    /**
     * The streetName
     * Meta informations extracted from the WSDL
     * - documentation : Name of street.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $streetName;
    /**
     * The streetNumber
     * Meta informations extracted from the WSDL
     * - documentation : House number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 7
     * @var string
     */
    public $streetNumber;
    /**
     * The careOfName
     * Meta informations extracted from the WSDL
     * - documentation : Address addon - care of c/o name.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $careOfName;
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
     * The district
     * Meta informations extracted from the WSDL
     * - documentation : District of the city.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $district;
    /**
     * The Origin
     * @var DHLStructCountryType
     */
    public $Origin;
    /**
     * The floorNumber
     * Meta informations extracted from the WSDL
     * - documentation : Floor number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * @var string
     */
    public $floorNumber;
    /**
     * The roomNumber
     * Meta informations extracted from the WSDL
     * - documentation : Room number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * @var string
     */
    public $roomNumber;
    /**
     * The languageCodeISO
     * Meta informations extracted from the WSDL
     * - documentation : ISO code for the language.
     * - minOccurs : 0
     * - documentation : Country specific ISO code.
     * - maxLength : 3
     * - minLength : 1
     * @var string
     */
    public $languageCodeISO;
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
     * Constructor method for NativeAddressType
     * @see parent::__construct()
     * @param string $_streetName
     * @param string $_streetNumber
     * @param string $_careOfName
     * @param DHLStructZipType $_zip
     * @param string $_city
     * @param string $_district
     * @param DHLStructCountryType $_origin
     * @param string $_floorNumber
     * @param string $_roomNumber
     * @param string $_languageCodeISO
     * @param string $_note
     * @return DHLStructNativeAddressType
     */
    public function __construct($_streetName = NULL,$_streetNumber = NULL,$_careOfName = NULL,$_zip = NULL,$_city = NULL,$_district = NULL,$_origin = NULL,$_floorNumber = NULL,$_roomNumber = NULL,$_languageCodeISO = NULL,$_note = NULL)
    {
        parent::__construct(array('streetName'=>$_streetName,'streetNumber'=>$_streetNumber,'careOfName'=>$_careOfName,'Zip'=>$_zip,'city'=>$_city,'district'=>$_district,'Origin'=>$_origin,'floorNumber'=>$_floorNumber,'roomNumber'=>$_roomNumber,'languageCodeISO'=>$_languageCodeISO,'note'=>$_note),false);
    }
    /**
     * Get streetName value
     * @return string|null
     */
    public function getStreetName()
    {
        return $this->streetName;
    }
    /**
     * Set streetName value
     * @param string $_streetName the streetName
     * @return string
     */
    public function setStreetName($_streetName)
    {
        return ($this->streetName = $_streetName);
    }
    /**
     * Get streetNumber value
     * @return string|null
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }
    /**
     * Set streetNumber value
     * @param string $_streetNumber the streetNumber
     * @return string
     */
    public function setStreetNumber($_streetNumber)
    {
        return ($this->streetNumber = $_streetNumber);
    }
    /**
     * Get careOfName value
     * @return string|null
     */
    public function getCareOfName()
    {
        return $this->careOfName;
    }
    /**
     * Set careOfName value
     * @param string $_careOfName the careOfName
     * @return string
     */
    public function setCareOfName($_careOfName)
    {
        return ($this->careOfName = $_careOfName);
    }
    /**
     * Get Zip value
     * @return DHLStructZipType|null
     */
    public function getZip()
    {
        return $this->Zip;
    }
    /**
     * Set Zip value
     * @param DHLStructZipType $_zip the Zip
     * @return DHLStructZipType
     */
    public function setZip($_zip)
    {
        return ($this->Zip = $_zip);
    }
    /**
     * Get city value
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Set city value
     * @param string $_city the city
     * @return string
     */
    public function setCity($_city)
    {
        return ($this->city = $_city);
    }
    /**
     * Get district value
     * @return string|null
     */
    public function getDistrict()
    {
        return $this->district;
    }
    /**
     * Set district value
     * @param string $_district the district
     * @return string
     */
    public function setDistrict($_district)
    {
        return ($this->district = $_district);
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
     * Get floorNumber value
     * @return string|null
     */
    public function getFloorNumber()
    {
        return $this->floorNumber;
    }
    /**
     * Set floorNumber value
     * @param string $_floorNumber the floorNumber
     * @return string
     */
    public function setFloorNumber($_floorNumber)
    {
        return ($this->floorNumber = $_floorNumber);
    }
    /**
     * Get roomNumber value
     * @return string|null
     */
    public function getRoomNumber()
    {
        return $this->roomNumber;
    }
    /**
     * Set roomNumber value
     * @param string $_roomNumber the roomNumber
     * @return string
     */
    public function setRoomNumber($_roomNumber)
    {
        return ($this->roomNumber = $_roomNumber);
    }
    /**
     * Get languageCodeISO value
     * @return string|null
     */
    public function getLanguageCodeISO()
    {
        return $this->languageCodeISO;
    }
    /**
     * Set languageCodeISO value
     * @param string $_languageCodeISO the languageCodeISO
     * @return string
     */
    public function setLanguageCodeISO($_languageCodeISO)
    {
        return ($this->languageCodeISO = $_languageCodeISO);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructNativeAddressType
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
