<?php
/**
 * File for class CorreosEnumModalidadEntrega
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosEnumModalidadEntrega originally named ModalidadEntrega
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * - maxLength : 2
 * @package Correos
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosEnumModalidadEntrega extends CorreosWsdlClass
{
    /**
     * Constant for value 'ST'
     * @return string 'ST'
     */
    const VALUE_ST = 'ST';
    /**
     * Constant for value 'LS'
     * @return string 'LS'
     */
    const VALUE_LS = 'LS';
    /**
     * Constant for value 'OR'
     * @return string 'OR'
     */
    const VALUE_OR = 'OR';
    /**
     * Constant for value 'HP'
     * @return string 'HP'
     */
    const VALUE_HP = 'HP';
    /**
     * Constant for value 'CP'
     * @return string 'CP'
     */
    const VALUE_CP = 'CP';
    /**
     * Return true if value is allowed
     * @uses CorreosEnumModalidadEntrega::VALUE_ST
     * @uses CorreosEnumModalidadEntrega::VALUE_LS
     * @uses CorreosEnumModalidadEntrega::VALUE_OR
     * @uses CorreosEnumModalidadEntrega::VALUE_HP
     * @uses CorreosEnumModalidadEntrega::VALUE_CP
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(CorreosEnumModalidadEntrega::VALUE_ST,CorreosEnumModalidadEntrega::VALUE_LS,CorreosEnumModalidadEntrega::VALUE_OR,CorreosEnumModalidadEntrega::VALUE_HP,CorreosEnumModalidadEntrega::VALUE_CP));
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
