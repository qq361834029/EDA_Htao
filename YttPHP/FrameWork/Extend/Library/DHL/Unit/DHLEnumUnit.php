<?php
/**
 * File for class DHLEnumUnit
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLEnumUnit originally named unit
 * Documentation : unit for all measures
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * - maxLength : 15
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLEnumUnit extends DHLWsdlClass
{
    /**
     * Constant for value 'mm'
     * @return string 'mm'
     */
    const VALUE_MM = 'mm';
    /**
     * Constant for value 'inch'
     * @return string 'inch'
     */
    const VALUE_INCH = 'inch';
    /**
     * Return true if value is allowed
     * @uses DHLEnumUnit::VALUE_MM
     * @uses DHLEnumUnit::VALUE_INCH
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(DHLEnumUnit::VALUE_MM,DHLEnumUnit::VALUE_INCH));
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
