<?php
/**
 * File for class CorreosEnumModDevEtiqueta
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosEnumModDevEtiqueta originally named ModDevEtiqueta
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * - maxLength : 1
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosEnumModDevEtiqueta extends CorreosWsdlClass
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
     * Return true if value is allowed
     * @uses CorreosEnumModDevEtiqueta::VALUE_1
     * @uses CorreosEnumModDevEtiqueta::VALUE_2
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(CorreosEnumModDevEtiqueta::VALUE_1,CorreosEnumModDevEtiqueta::VALUE_2));
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
