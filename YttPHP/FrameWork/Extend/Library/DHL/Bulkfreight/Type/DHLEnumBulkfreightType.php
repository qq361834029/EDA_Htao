<?php
/**
 * File for class DHLEnumBulkfreightType
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLEnumBulkfreightType originally named BulkfreightType
 * Documentation : Bulkfreight type. Mandatory if bulkfreight is selected. Field length must be less than or equal to 20.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLEnumBulkfreightType extends DHLWsdlClass
{
    /**
     * Constant for value 'Lang'
     * @return string 'Lang'
     */
    const VALUE_LANG = 'Lang';
    /**
     * Constant for value 'L'
     * @return string 'L'
     */
    const VALUE_L = 'L';
    /**
     * Constant for value 'XL'
     * @return string 'XL'
     */
    const VALUE_XL = 'XL';
    /**
     * Constant for value 'XXL'
     * @return string 'XXL'
     */
    const VALUE_XXL = 'XXL';
    /**
     * Return true if value is allowed
     * @uses DHLEnumBulkfreightType::VALUE_LANG
     * @uses DHLEnumBulkfreightType::VALUE_L
     * @uses DHLEnumBulkfreightType::VALUE_XL
     * @uses DHLEnumBulkfreightType::VALUE_XXL
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(DHLEnumBulkfreightType::VALUE_LANG,DHLEnumBulkfreightType::VALUE_L,DHLEnumBulkfreightType::VALUE_XL,DHLEnumBulkfreightType::VALUE_XXL));
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
