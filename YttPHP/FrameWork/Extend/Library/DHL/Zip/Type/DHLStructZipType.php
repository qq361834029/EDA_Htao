<?php
/**
 * File for class DHLStructZipType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructZipType originally named ZipType
 * Documentation : Type of zip code can be
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructZipType extends DHLWsdlClass
{
    /**
     * The germany
     * Meta informations extracted from the WSDL
     * - documentation : To be used for providing zip code if address is in Germany.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 5
     * - minLength : 5
     * - pattern : [0-9]{5}
     * @var string
     */
    public $germany;
    /**
     * The england
     * Meta informations extracted from the WSDL
     * - documentation : To be used for providing zip code if address is in England.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 8
     * @var string
     */
    public $england;
    /**
     * The other
     * Meta informations extracted from the WSDL
     * - documentation : Zip code if address is neither in Germany nor in England.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * @var string
     */
    public $other;
    /**
     * Constructor method for ZipType
     * @see parent::__construct()
     * @param string $_germany
     * @param string $_england
     * @param string $_other
     * @return DHLStructZipType
     */
    public function __construct($_germany = NULL,$_england = NULL,$_other = NULL)
    {
        parent::__construct(array('germany'=>$_germany,'england'=>$_england,'other'=>$_other),false);
    }
    /**
     * Get germany value
     * @return string|null
     */
    public function getGermany()
    {
        return $this->germany;
    }
    /**
     * Set germany value
     * @param string $_germany the germany
     * @return string
     */
    public function setGermany($_germany)
    {
        return ($this->germany = $_germany);
    }
    /**
     * Get england value
     * @return string|null
     */
    public function getEngland()
    {
        return $this->england;
    }
    /**
     * Set england value
     * @param string $_england the england
     * @return string
     */
    public function setEngland($_england)
    {
        return ($this->england = $_england);
    }
    /**
     * Get other value
     * @return string|null
     */
    public function getOther()
    {
        return $this->other;
    }
    /**
     * Set other value
     * @param string $_other the other
     * @return string
     */
    public function setOther($_other)
    {
        return ($this->other = $_other);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructZipType
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
