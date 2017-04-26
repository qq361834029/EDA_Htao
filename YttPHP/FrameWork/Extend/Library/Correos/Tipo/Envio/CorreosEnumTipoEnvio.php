<?php
/**
 * File for class CorreosEnumTipoEnvio
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosEnumTipoEnvio originally named TipoEnvio
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * - maxLength : 1
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosEnumTipoEnvio extends CorreosWsdlClass
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
     * Constant for value 5
     * @return integer 5
     */
    const VALUE_5 = 5;
    /**
     * Constant for value 6
     * @return integer 6
     */
    const VALUE_6 = 6;
    /**
     * Constant for value 7
     * @return integer 7
     */
    const VALUE_7 = 7;
    /**
     * Return true if value is allowed
     * @uses CorreosEnumTipoEnvio::VALUE_1
     * @uses CorreosEnumTipoEnvio::VALUE_2
     * @uses CorreosEnumTipoEnvio::VALUE_3
     * @uses CorreosEnumTipoEnvio::VALUE_4
     * @uses CorreosEnumTipoEnvio::VALUE_5
     * @uses CorreosEnumTipoEnvio::VALUE_6
     * @uses CorreosEnumTipoEnvio::VALUE_7
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(CorreosEnumTipoEnvio::VALUE_1,CorreosEnumTipoEnvio::VALUE_2,CorreosEnumTipoEnvio::VALUE_3,CorreosEnumTipoEnvio::VALUE_4,CorreosEnumTipoEnvio::VALUE_5,CorreosEnumTipoEnvio::VALUE_6,CorreosEnumTipoEnvio::VALUE_7));
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
