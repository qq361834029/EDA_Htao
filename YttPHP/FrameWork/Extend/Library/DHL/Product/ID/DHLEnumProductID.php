<?php
/**
 * File for class DHLEnumProductID
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLEnumProductID originally named ProductID
 * Documentation : Information about the shipment to be picked up. ("TDN" = time-definite national / "TDI" = time-definite international / "DDN" = day-definite national / "DDI" = day-definite international).
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLEnumProductID extends DHLWsdlClass
{
    /**
     * Constant for value 'TDI'
     * @return string 'TDI'
     */
    const VALUE_TDI = 'TDI';
    /**
     * Constant for value 'TDN'
     * @return string 'TDN'
     */
    const VALUE_TDN = 'TDN';
    /**
     * Constant for value 'DDI'
     * @return string 'DDI'
     */
    const VALUE_DDI = 'DDI';
    /**
     * Constant for value 'DDN'
     * @return string 'DDN'
     */
    const VALUE_DDN = 'DDN';
    /**
     * Return true if value is allowed
     * @uses DHLEnumProductID::VALUE_TDI
     * @uses DHLEnumProductID::VALUE_TDN
     * @uses DHLEnumProductID::VALUE_DDI
     * @uses DHLEnumProductID::VALUE_DDN
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(DHLEnumProductID::VALUE_TDI,DHLEnumProductID::VALUE_TDN,DHLEnumProductID::VALUE_DDI,DHLEnumProductID::VALUE_DDN));
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
