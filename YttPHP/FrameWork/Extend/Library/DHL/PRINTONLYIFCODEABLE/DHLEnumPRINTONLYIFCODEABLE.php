<?php
/**
 * File for class DHLEnumPRINTONLYIFCODEABLE
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLEnumPRINTONLYIFCODEABLE originally named PRINTONLYIFCODEABLE
 * Documentation : If set to true (=1), the label will be only be printable, if the receiver address is valid.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLEnumPRINTONLYIFCODEABLE extends DHLWsdlClass
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
     * Return true if value is allowed
     * @uses DHLEnumPRINTONLYIFCODEABLE::VALUE_0
     * @uses DHLEnumPRINTONLYIFCODEABLE::VALUE_1
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(DHLEnumPRINTONLYIFCODEABLE::VALUE_0,DHLEnumPRINTONLYIFCODEABLE::VALUE_1));
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
