<?php
/**
 * File for class CorreosEnumIdioma
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosEnumIdioma originally named Idioma
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * - maxLength : 1
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosEnumIdioma extends CorreosWsdlClass
{
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
     * Return true if value is allowed
     * @uses CorreosEnumIdioma::VALUE_1
     * @uses CorreosEnumIdioma::VALUE_2
     * @uses CorreosEnumIdioma::VALUE_3
     * @uses CorreosEnumIdioma::VALUE_4
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(CorreosEnumIdioma::VALUE_1,CorreosEnumIdioma::VALUE_2,CorreosEnumIdioma::VALUE_3,CorreosEnumIdioma::VALUE_4));
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
