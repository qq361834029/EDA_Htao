<?php
/**
 * File for class CorreosEnumEntregaExclusiva
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosEnumEntregaExclusiva originally named EntregaExclusiva
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * - maxLength : 1
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosEnumEntregaExclusiva extends CorreosWsdlClass
{
    /**
     * Constant for value 'S'
     * @return string 'S'
     */
    const VALUE_S = 'S';
    /**
     * Constant for value 'N'
     * @return string 'N'
     */
    const VALUE_N = 'N';
    /**
     * Return true if value is allowed
     * @uses CorreosEnumEntregaExclusiva::VALUE_S
     * @uses CorreosEnumEntregaExclusiva::VALUE_N
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(CorreosEnumEntregaExclusiva::VALUE_S,CorreosEnumEntregaExclusiva::VALUE_N));
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
