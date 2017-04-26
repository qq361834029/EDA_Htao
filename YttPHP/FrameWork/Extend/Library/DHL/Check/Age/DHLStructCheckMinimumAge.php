<?php
/**
 * File for class DHLStructCheckMinimumAge
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCheckMinimumAge originally named CheckMinimumAge
 * Documentation : Service to validate minimum age of recipient. Field max length must be = 2.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCheckMinimumAge extends DHLWsdlClass
{
    /**
     * The MinimumAge
     * Meta informations extracted from the WSDL
     * - documentation : The minimum age.Mandatory if service CheckMinimumAge is chosen. Field length must be less than or equal to 2 characters.
     * @var string
     */
    public $MinimumAge;
    /**
     * Constructor method for CheckMinimumAge
     * @see parent::__construct()
     * @param string $_minimumAge
     * @return DHLStructCheckMinimumAge
     */
    public function __construct($_minimumAge = NULL)
    {
        parent::__construct(array('MinimumAge'=>$_minimumAge),false);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCheckMinimumAge
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
