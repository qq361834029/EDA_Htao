<?php
/**
 * File for class DHLStructExpressSaturday
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructExpressSaturday originally named ExpressSaturday
 * Documentation : Container element must be set to provide exact shipping date that must be a Saturday.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructExpressSaturday extends DHLWsdlClass
{
    /**
     * The ShippingDate
     * Meta informations extracted from the WSDL
     * - documentation : If ExpressSaturday is set, shipping date must be passed in format yyyy-mm-dd to provide exact date (Saturday) where delivery shall occur.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $ShippingDate;
    /**
     * Constructor method for ExpressSaturday
     * @see parent::__construct()
     * @param string $_shippingDate
     * @return DHLStructExpressSaturday
     */
    public function __construct($_shippingDate = NULL)
    {
        parent::__construct(array('ShippingDate'=>$_shippingDate),false);
    }
    /**
     * Get ShippingDate value
     * @return string|null
     */
    public function getShippingDate()
    {
        return $this->ShippingDate;
    }
    /**
     * Set ShippingDate value
     * @param string $_shippingDate the ShippingDate
     * @return string
     */
    public function setShippingDate($_shippingDate)
    {
        return ($this->ShippingDate = $_shippingDate);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructExpressSaturday
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
