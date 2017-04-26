<?php
/**
 * File for class DHLStructTDServiceGroupDateTimeOptionType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructTDServiceGroupDateTimeOptionType originally named TDServiceGroupDateTimeOptionType
 * Documentation : Service Group Date / Time Option.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructTDServiceGroupDateTimeOptionType extends DHLWsdlClass
{
    /**
     * The ExpressSaturday
     * @var DHLStructExpressSaturday
     */
    public $ExpressSaturday;
    /**
     * Constructor method for TDServiceGroupDateTimeOptionType
     * @see parent::__construct()
     * @param DHLStructExpressSaturday $_expressSaturday
     * @return DHLStructTDServiceGroupDateTimeOptionType
     */
    public function __construct($_expressSaturday = NULL)
    {
        parent::__construct(array('ExpressSaturday'=>$_expressSaturday),false);
    }
    /**
     * Get ExpressSaturday value
     * @return DHLStructExpressSaturday|null
     */
    public function getExpressSaturday()
    {
        return $this->ExpressSaturday;
    }
    /**
     * Set ExpressSaturday value
     * @param DHLStructExpressSaturday $_expressSaturday the ExpressSaturday
     * @return DHLStructExpressSaturday
     */
    public function setExpressSaturday($_expressSaturday)
    {
        return ($this->ExpressSaturday = $_expressSaturday);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructTDServiceGroupDateTimeOptionType
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
