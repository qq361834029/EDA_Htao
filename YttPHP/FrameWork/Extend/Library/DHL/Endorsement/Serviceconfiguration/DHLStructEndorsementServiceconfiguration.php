<?php
/**
 * File for class DHLStructEndorsementServiceconfiguration
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructEndorsementServiceconfiguration originally named EndorsementServiceconfiguration
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructEndorsementServiceconfiguration extends DHLWsdlClass
{
    /**
     * The active
     * @var anonymous170
     */
    public $active;
    /**
     * Constructor method for EndorsementServiceconfiguration
     * @see parent::__construct()
     * @param anonymous170 $_active
     * @return DHLStructEndorsementServiceconfiguration
     */
    public function __construct($_active = NULL)
    {
        parent::__construct(array('active'=>$_active),false);
    }
    /**
     * Get active value
     * @return anonymous170|null
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * Set active value
     * @param anonymous170 $_active the active
     * @return anonymous170
     */
    public function setActive($_active)
    {
        return ($this->active = $_active);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructEndorsementServiceconfiguration
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
