<?php
/**
 * File for class DHLStructBulkfreight
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructBulkfreight originally named Bulkfreight
 * Documentation : Service to ship bulkfreight items. Bulkfreight type can be selected optionally. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructBulkfreight extends DHLWsdlClass
{
    /**
     * The BulkfreightType
     * @var DHLEnumBulkfreightType
     */
    public $BulkfreightType;
    /**
     * Constructor method for Bulkfreight
     * @see parent::__construct()
     * @param DHLEnumBulkfreightType $_bulkfreightType
     * @return DHLStructBulkfreight
     */
    public function __construct($_bulkfreightType = NULL)
    {
        parent::__construct(array('BulkfreightType'=>$_bulkfreightType),false);
    }
    /**
     * Get BulkfreightType value
     * @return DHLEnumBulkfreightType|null
     */
    public function getBulkfreightType()
    {
        return $this->BulkfreightType;
    }
    /**
     * Set BulkfreightType value
     * @uses DHLEnumBulkfreightType::valueIsValid()
     * @param DHLEnumBulkfreightType $_bulkfreightType the BulkfreightType
     * @return DHLEnumBulkfreightType
     */
    public function setBulkfreightType($_bulkfreightType)
    {
        if(!DHLEnumBulkfreightType::valueIsValid($_bulkfreightType))
        {
            return false;
        }
        return ($this->BulkfreightType = $_bulkfreightType);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructBulkfreight
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
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
