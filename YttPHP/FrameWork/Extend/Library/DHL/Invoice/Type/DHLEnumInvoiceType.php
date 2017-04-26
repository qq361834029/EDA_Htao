<?php
/**
 * File for class DHLEnumInvoiceType
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLEnumInvoiceType originally named InvoiceType
 * Documentation : Type of invoice. Field length must be less than or equal to 30. Invoice type (only mandatory for BPI). Field length must be less than or equal to 30.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLEnumInvoiceType extends DHLWsdlClass
{
    /**
     * Constant for value 'proforma'
     * @return string 'proforma'
     */
    const VALUE_PROFORMA = 'proforma';
    /**
     * Constant for value 'commercial'
     * @return string 'commercial'
     */
    const VALUE_COMMERCIAL = 'commercial';
    /**
     * Return true if value is allowed
     * @uses DHLEnumInvoiceType::VALUE_PROFORMA
     * @uses DHLEnumInvoiceType::VALUE_COMMERCIAL
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(DHLEnumInvoiceType::VALUE_PROFORMA,DHLEnumInvoiceType::VALUE_COMMERCIAL));
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
