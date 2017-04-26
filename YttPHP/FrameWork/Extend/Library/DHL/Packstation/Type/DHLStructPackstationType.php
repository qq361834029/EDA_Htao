<?php
/**
 * File for class DHLStructPackstationType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructPackstationType originally named PackstationType
 * Documentation : Type of Packstation (Receiver is in Germany) includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructPackstationType extends DHLWsdlClass
{
    /**
     * The PackstationNumber
     * Meta informations extracted from the WSDL
     * - documentation : Number of the packstation
     * @var string
     */
    public $PackstationNumber;
    /**
     * The PostNumber
     * Meta informations extracted from the WSDL
     * - documentation : Post Nummer of the receiver
     * @var string
     */
    public $PostNumber;
    /**
     * The Zip
     * Meta informations extracted from the WSDL
     * - documentation : Element provides choice of zip code selection. Postcode
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 5
     * - minLength : 5
     * - pattern : [0-9]{5}
     * @var string
     */
    public $Zip;
    /**
     * The City
     * Meta informations extracted from the WSDL
     * - documentation : City name.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 50
     * @var string
     */
    public $City;
    /**
     * Constructor method for PackstationType
     * @see parent::__construct()
     * @param string $_packstationNumber
     * @param string $_postNumber
     * @param string $_zip
     * @param string $_city
     * @return DHLStructPackstationType
     */
    public function __construct($_packstationNumber = NULL,$_postNumber = NULL,$_zip = NULL,$_city = NULL)
    {
        parent::__construct(array('PackstationNumber'=>$_packstationNumber,'PostNumber'=>$_postNumber,'Zip'=>$_zip,'City'=>$_city),false);
    }
    /**
     * Get PackstationNumber value
     * @return string|null
     */
    public function getPackstationNumber()
    {
        return $this->PackstationNumber;
    }
    /**
     * Set PackstationNumber value
     * @param string $_packstationNumber the PackstationNumber
     * @return string
     */
    public function setPackstationNumber($_packstationNumber)
    {
        return ($this->PackstationNumber = $_packstationNumber);
    }
    /**
     * Get PostNumber value
     * @return string|null
     */
    public function getPostNumber()
    {
        return $this->PostNumber;
    }
    /**
     * Set PostNumber value
     * @param string $_postNumber the PostNumber
     * @return string
     */
    public function setPostNumber($_postNumber)
    {
        return ($this->PostNumber = $_postNumber);
    }
    /**
     * Get Zip value
     * @return string|null
     */
    public function getZip()
    {
        return $this->Zip;
    }
    /**
     * Set Zip value
     * @param string $_zip the Zip
     * @return string
     */
    public function setZip($_zip)
    {
        return ($this->Zip = $_zip);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructPackstationType
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
