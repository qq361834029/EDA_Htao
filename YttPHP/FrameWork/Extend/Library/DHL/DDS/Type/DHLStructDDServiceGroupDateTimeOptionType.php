<?php
/**
 * File for class DHLStructDDServiceGroupDateTimeOptionType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDDServiceGroupDateTimeOptionType originally named DDServiceGroupDateTimeOptionType
 * Documentation : Service Group Date Time Option.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDDServiceGroupDateTimeOptionType extends DHLWsdlClass
{
    /**
     * The DeliveryOnTime
     * @var DHLStructDeliveryOnTime
     */
    public $DeliveryOnTime;
    /**
     * The DeliveryEarly
     * Meta informations extracted from the WSDL
     * - documentation : Early delivery.
     * @var boolean
     */
    public $DeliveryEarly;
    /**
     * The Express0900
     * Meta informations extracted from the WSDL
     * - documentation : Express 09:00
     * @var boolean
     */
    public $Express0900;
    /**
     * The Express1000
     * Meta informations extracted from the WSDL
     * - documentation : Express 10:00
     * @var boolean
     */
    public $Express1000;
    /**
     * The Express1200
     * Meta informations extracted from the WSDL
     * - documentation : Express 12:00
     * @var boolean
     */
    public $Express1200;
    /**
     * The DeliveryAfternoon
     * Meta informations extracted from the WSDL
     * - documentation : Afternoon delivery.
     * @var boolean
     */
    public $DeliveryAfternoon;
    /**
     * The DeliveryEvening
     * Meta informations extracted from the WSDL
     * - documentation : Evening delivery.
     * @var boolean
     */
    public $DeliveryEvening;
    /**
     * The ExpressSaturday
     * Meta informations extracted from the WSDL
     * - documentation : Express Saturday.
     * @var boolean
     */
    public $ExpressSaturday;
    /**
     * The ExpressSunday
     * Meta informations extracted from the WSDL
     * - documentation : Express Sunday.
     * @var boolean
     */
    public $ExpressSunday;
    /**
     * Constructor method for DDServiceGroupDateTimeOptionType
     * @see parent::__construct()
     * @param DHLStructDeliveryOnTime $_deliveryOnTime
     * @param boolean $_deliveryEarly
     * @param boolean $_express0900
     * @param boolean $_express1000
     * @param boolean $_express1200
     * @param boolean $_deliveryAfternoon
     * @param boolean $_deliveryEvening
     * @param boolean $_expressSaturday
     * @param boolean $_expressSunday
     * @return DHLStructDDServiceGroupDateTimeOptionType
     */
    public function __construct($_deliveryOnTime = NULL,$_deliveryEarly = NULL,$_express0900 = NULL,$_express1000 = NULL,$_express1200 = NULL,$_deliveryAfternoon = NULL,$_deliveryEvening = NULL,$_expressSaturday = NULL,$_expressSunday = NULL)
    {
        parent::__construct(array('DeliveryOnTime'=>$_deliveryOnTime,'DeliveryEarly'=>$_deliveryEarly,'Express0900'=>$_express0900,'Express1000'=>$_express1000,'Express1200'=>$_express1200,'DeliveryAfternoon'=>$_deliveryAfternoon,'DeliveryEvening'=>$_deliveryEvening,'ExpressSaturday'=>$_expressSaturday,'ExpressSunday'=>$_expressSunday),false);
    }
    /**
     * Get DeliveryOnTime value
     * @return DHLStructDeliveryOnTime|null
     */
    public function getDeliveryOnTime()
    {
        return $this->DeliveryOnTime;
    }
    /**
     * Set DeliveryOnTime value
     * @param DHLStructDeliveryOnTime $_deliveryOnTime the DeliveryOnTime
     * @return DHLStructDeliveryOnTime
     */
    public function setDeliveryOnTime($_deliveryOnTime)
    {
        return ($this->DeliveryOnTime = $_deliveryOnTime);
    }
    /**
     * Get DeliveryEarly value
     * @return boolean|null
     */
    public function getDeliveryEarly()
    {
        return $this->DeliveryEarly;
    }
    /**
     * Set DeliveryEarly value
     * @param boolean $_deliveryEarly the DeliveryEarly
     * @return boolean
     */
    public function setDeliveryEarly($_deliveryEarly)
    {
        return ($this->DeliveryEarly = $_deliveryEarly);
    }
    /**
     * Get Express0900 value
     * @return boolean|null
     */
    public function getExpress0900()
    {
        return $this->Express0900;
    }
    /**
     * Set Express0900 value
     * @param boolean $_express0900 the Express0900
     * @return boolean
     */
    public function setExpress0900($_express0900)
    {
        return ($this->Express0900 = $_express0900);
    }
    /**
     * Get Express1000 value
     * @return boolean|null
     */
    public function getExpress1000()
    {
        return $this->Express1000;
    }
    /**
     * Set Express1000 value
     * @param boolean $_express1000 the Express1000
     * @return boolean
     */
    public function setExpress1000($_express1000)
    {
        return ($this->Express1000 = $_express1000);
    }
    /**
     * Get Express1200 value
     * @return boolean|null
     */
    public function getExpress1200()
    {
        return $this->Express1200;
    }
    /**
     * Set Express1200 value
     * @param boolean $_express1200 the Express1200
     * @return boolean
     */
    public function setExpress1200($_express1200)
    {
        return ($this->Express1200 = $_express1200);
    }
    /**
     * Get DeliveryAfternoon value
     * @return boolean|null
     */
    public function getDeliveryAfternoon()
    {
        return $this->DeliveryAfternoon;
    }
    /**
     * Set DeliveryAfternoon value
     * @param boolean $_deliveryAfternoon the DeliveryAfternoon
     * @return boolean
     */
    public function setDeliveryAfternoon($_deliveryAfternoon)
    {
        return ($this->DeliveryAfternoon = $_deliveryAfternoon);
    }
    /**
     * Get DeliveryEvening value
     * @return boolean|null
     */
    public function getDeliveryEvening()
    {
        return $this->DeliveryEvening;
    }
    /**
     * Set DeliveryEvening value
     * @param boolean $_deliveryEvening the DeliveryEvening
     * @return boolean
     */
    public function setDeliveryEvening($_deliveryEvening)
    {
        return ($this->DeliveryEvening = $_deliveryEvening);
    }
    /**
     * Get ExpressSaturday value
     * @return boolean|null
     */
    public function getExpressSaturday()
    {
        return $this->ExpressSaturday;
    }
    /**
     * Set ExpressSaturday value
     * @param boolean $_expressSaturday the ExpressSaturday
     * @return boolean
     */
    public function setExpressSaturday($_expressSaturday)
    {
        return ($this->ExpressSaturday = $_expressSaturday);
    }
    /**
     * Get ExpressSunday value
     * @return boolean|null
     */
    public function getExpressSunday()
    {
        return $this->ExpressSunday;
    }
    /**
     * Set ExpressSunday value
     * @param boolean $_expressSunday the ExpressSunday
     * @return boolean
     */
    public function setExpressSunday($_expressSunday)
    {
        return ($this->ExpressSunday = $_expressSunday);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDDServiceGroupDateTimeOptionType
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
