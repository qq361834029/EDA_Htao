<?php
/**
 * File for class DHLEnumLabelResponseType
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLEnumLabelResponseType originally named LabelResponseType
 * Documentation : Dial to determine label ouput format. It is possible to request an URL for receiving the label as PDF stream, or to request the XML label directly. If not defined by client, web service defaults to 'PDF'. Dial to determine label ouput format. Must be either 'URL' or 'XML': it is possible to request an URL for receiving the label as PDF stream, or to request the XML label directly. If not defined by client, web service defaults to 'PDF'.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLEnumLabelResponseType extends DHLWsdlClass
{
    /**
     * Constant for value 'URL'
     * @return string 'URL'
     */
    const VALUE_URL = 'URL';
    /**
     * Constant for value 'XML'
     * @return string 'XML'
     */
    const VALUE_XML = 'XML';
    /**
     * Return true if value is allowed
     * @uses DHLEnumLabelResponseType::VALUE_URL
     * @uses DHLEnumLabelResponseType::VALUE_XML
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(DHLEnumLabelResponseType::VALUE_URL,DHLEnumLabelResponseType::VALUE_XML));
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
