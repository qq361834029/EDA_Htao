<?php
/**
 * File for class DHLEnumExportType
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLEnumExportType originally named ExportType
 * Documentation : Type of export. ("P"=permanent / "T"=temporary / "R"=repair and return). Field length must be less than or equal to 40. Export type ("0"="other", "1"="gift", "2"="sample", "3"="documents", "4"="goods return") (depends on chosen product -> only mandatory for BPI). Field length must be less than or equal to 40.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLEnumExportType extends DHLWsdlClass
{
    /**
     * Constant for value 'P'
     * @return string 'P'
     */
    const VALUE_P = 'P';
    /**
     * Constant for value 'T'
     * @return string 'T'
     */
    const VALUE_T = 'T';
    /**
     * Constant for value 'R'
     * @return string 'R'
     */
    const VALUE_R = 'R';
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
     * Return true if value is allowed
     * @uses DHLEnumExportType::VALUE_P
     * @uses DHLEnumExportType::VALUE_T
     * @uses DHLEnumExportType::VALUE_R
     * @uses DHLEnumExportType::VALUE_0
     * @uses DHLEnumExportType::VALUE_1
     * @uses DHLEnumExportType::VALUE_2
     * @uses DHLEnumExportType::VALUE_3
     * @uses DHLEnumExportType::VALUE_4
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(DHLEnumExportType::VALUE_P,DHLEnumExportType::VALUE_T,DHLEnumExportType::VALUE_R,DHLEnumExportType::VALUE_0,DHLEnumExportType::VALUE_1,DHLEnumExportType::VALUE_2,DHLEnumExportType::VALUE_3,DHLEnumExportType::VALUE_4));
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
