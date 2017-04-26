<?php
/**
 * File for class DHLEnumDocType
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLEnumDocType originally named DocType
 * Documentation : Type of the data within the GetExportDocResponse. Default: "PDF", allowed values: "PDF" returns the export document as base64 encoded string, "URL" returns an url from which the export document can be downloded Type of document that shall be rendered. Currently only "PDF" is enabled and will return the export document as base64 encoded string.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLEnumDocType extends DHLWsdlClass
{
    /**
     * Constant for value 'PDF'
     * @return string 'PDF'
     */
    const VALUE_PDF = 'PDF';
    /**
     * Constant for value 'URL'
     * @return string 'URL'
     */
    const VALUE_URL = 'URL';
    /**
     * Return true if value is allowed
     * @uses DHLEnumDocType::VALUE_PDF
     * @uses DHLEnumDocType::VALUE_URL
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(DHLEnumDocType::VALUE_PDF,DHLEnumDocType::VALUE_URL));
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
