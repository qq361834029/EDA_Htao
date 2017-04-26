<?php
/**
 * File for class DHLStructShipmentServiceTD
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentServiceTD originally named ShipmentServiceTD
 * Documentation : TD shipment services. can be
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentServiceTD extends DHLWsdlClass
{
    /**
     * The ServiceGroupDateTimeOption
     * Meta informations extracted from the WSDL
     * - documentation : Service bundle that only contains one service. Follwing service must be chosen, if the service bundle is invoked.
     * @var DHLStructTDServiceGroupDateTimeOptionType
     */
    public $ServiceGroupDateTimeOption;
    /**
     * The ServiceGroupOther
     * Meta informations extracted from the WSDL
     * - documentation : Service bundle that only contains one service to be booked. Following service must be chosen, if the service bundle is invoked.
     * @var DHLStructTDServiceGroupOtherType
     */
    public $ServiceGroupOther;
    /**
     * Constructor method for ShipmentServiceTD
     * @see parent::__construct()
     * @param DHLStructTDServiceGroupDateTimeOptionType $_serviceGroupDateTimeOption
     * @param DHLStructTDServiceGroupOtherType $_serviceGroupOther
     * @return DHLStructShipmentServiceTD
     */
    public function __construct($_serviceGroupDateTimeOption = NULL,$_serviceGroupOther = NULL)
    {
        parent::__construct(array('ServiceGroupDateTimeOption'=>$_serviceGroupDateTimeOption,'ServiceGroupOther'=>$_serviceGroupOther),false);
    }
    /**
     * Get ServiceGroupDateTimeOption value
     * @return DHLStructTDServiceGroupDateTimeOptionType|null
     */
    public function getServiceGroupDateTimeOption()
    {
        return $this->ServiceGroupDateTimeOption;
    }
    /**
     * Set ServiceGroupDateTimeOption value
     * @param DHLStructTDServiceGroupDateTimeOptionType $_serviceGroupDateTimeOption the ServiceGroupDateTimeOption
     * @return DHLStructTDServiceGroupDateTimeOptionType
     */
    public function setServiceGroupDateTimeOption($_serviceGroupDateTimeOption)
    {
        return ($this->ServiceGroupDateTimeOption = $_serviceGroupDateTimeOption);
    }
    /**
     * Get ServiceGroupOther value
     * @return DHLStructTDServiceGroupOtherType|null
     */
    public function getServiceGroupOther()
    {
        return $this->ServiceGroupOther;
    }
    /**
     * Set ServiceGroupOther value
     * @param DHLStructTDServiceGroupOtherType $_serviceGroupOther the ServiceGroupOther
     * @return DHLStructTDServiceGroupOtherType
     */
    public function setServiceGroupOther($_serviceGroupOther)
    {
        return ($this->ServiceGroupOther = $_serviceGroupOther);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentServiceTD
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
