<?php
/**
 * File for class CorreosEnumTipoFranqueo
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosEnumTipoFranqueo originally named TipoFranqueo
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * - maxLength : 2
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosEnumTipoFranqueo extends CorreosWsdlClass
{
    /**
     * Constant for value 'FP'
     * @return string 'FP'
     */
    const VALUE_FP = 'FP';
    /**
     * Constant for value 'FM'
     * @return string 'FM'
     */
    const VALUE_FM = 'FM';
    /**
     * Constant for value 'ES'
     * @return string 'ES'
     */
    const VALUE_ES = 'ES';
    /**
     * Constant for value 'ON'
     * @return string 'ON'
     */
    const VALUE_ON = 'ON';
    /**
     * Return true if value is allowed
     * @uses CorreosEnumTipoFranqueo::VALUE_FP
     * @uses CorreosEnumTipoFranqueo::VALUE_FM
     * @uses CorreosEnumTipoFranqueo::VALUE_ES
     * @uses CorreosEnumTipoFranqueo::VALUE_ON
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(CorreosEnumTipoFranqueo::VALUE_FP,CorreosEnumTipoFranqueo::VALUE_FM,CorreosEnumTipoFranqueo::VALUE_ES,CorreosEnumTipoFranqueo::VALUE_ON));
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
