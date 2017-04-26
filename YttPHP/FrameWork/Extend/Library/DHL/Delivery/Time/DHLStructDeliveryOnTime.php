<?php
/**
 * File for class DHLStructDeliveryOnTime
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDeliveryOnTime originally named DeliveryOnTime
 * Documentation : Service to deliver on particular time requires to specify desired time in child node. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDeliveryOnTime extends DHLWsdlClass
{
    /**
     * The time
     * Meta informations extracted from the WSDL
     * - documentation : Desired time of delivery, format is 'hh:mm'(mandatory if DeliveryOnTime is defined). Field length must be = 4.
     * @var string
     */
    public $time;
    /**
     * Constructor method for DeliveryOnTime
     * @see parent::__construct()
     * @param string $_time
     * @return DHLStructDeliveryOnTime
     */
    public function __construct($_time = NULL)
    {
        parent::__construct(array('time'=>$_time),false);
    }
    /**
     * Get time value
     * @return string|null
     */
    public function getTime()
    {
        return $this->time;
    }
    /**
     * Set time value
     * @param string $_time the time
     * @return string
     */
    public function setTime($_time)
    {
        return ($this->time = $_time);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDeliveryOnTime
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
