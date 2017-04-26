<?php
/**
 * File for class CorreosEnumFormato
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosEnumFormato originally named Formato
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosEnumFormato extends CorreosWsdlClass
{
    /**
     * Constant for value 0
     * @return integer 0
     */
    const VALUE_0 = 0;
    /**
     * Constant for value 1
     * @return integer 1
     */
    const VALUE_1 = 1;
    /**
     * Constant for value 2
     * @return integer 2
     */
    const VALUE_2 = 2;
    /**
     * Constant for value 3
     * @return integer 3
     */
    const VALUE_3 = 3;
    /**
     * Constant for value 4
     * @return integer 4
     */
    const VALUE_4 = 4;
    /**
     * Constant for value 5
     * @return integer 5
     */
    const VALUE_5 = 5;
    /**
     * Return true if value is allowed
     * @uses CorreosEnumFormato::VALUE_0
     * @uses CorreosEnumFormato::VALUE_1
     * @uses CorreosEnumFormato::VALUE_2
     * @uses CorreosEnumFormato::VALUE_3
     * @uses CorreosEnumFormato::VALUE_4
     * @uses CorreosEnumFormato::VALUE_5
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(CorreosEnumFormato::VALUE_0,CorreosEnumFormato::VALUE_1,CorreosEnumFormato::VALUE_2,CorreosEnumFormato::VALUE_3,CorreosEnumFormato::VALUE_4,CorreosEnumFormato::VALUE_5));
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
