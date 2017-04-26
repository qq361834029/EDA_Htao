<?php
/**
 * File for class DHLStructDimension
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDimension originally named Dimension
 * Documentation : Package dimensions (length, width, height) includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDimension extends DHLWsdlClass
{
    /**
     * The length
     * Meta informations extracted from the WSDL
     * - documentation : length of package
     * @var int
     */
    public $length;
    /**
     * The width
     * Meta informations extracted from the WSDL
     * - documentation : width of package
     * @var int
     */
    public $width;
    /**
     * The height
     * Meta informations extracted from the WSDL
     * - documentation : height of package
     * @var int
     */
    public $height;
    /**
     * The unit
     * @var DHLEnumUnit
     */
    public $unit;
    /**
     * Constructor method for Dimension
     * @see parent::__construct()
     * @param int $_length
     * @param int $_width
     * @param int $_height
     * @param DHLEnumUnit $_unit
     * @return DHLStructDimension
     */
    public function __construct($_length = NULL,$_width = NULL,$_height = NULL,$_unit = NULL)
    {
        parent::__construct(array('length'=>$_length,'width'=>$_width,'height'=>$_height,'unit'=>$_unit),false);
    }
    /**
     * Get length value
     * @return int|null
     */
    public function getLength()
    {
        return $this->length;
    }
    /**
     * Set length value
     * @param int $_length the length
     * @return int
     */
    public function setLength($_length)
    {
        return ($this->length = $_length);
    }
    /**
     * Get width value
     * @return int|null
     */
    public function getWidth()
    {
        return $this->width;
    }
    /**
     * Set width value
     * @param int $_width the width
     * @return int
     */
    public function setWidth($_width)
    {
        return ($this->width = $_width);
    }
    /**
     * Get height value
     * @return int|null
     */
    public function getHeight()
    {
        return $this->height;
    }
    /**
     * Set height value
     * @param int $_height the height
     * @return int
     */
    public function setHeight($_height)
    {
        return ($this->height = $_height);
    }
    /**
     * Get unit value
     * @return DHLEnumUnit|null
     */
    public function getUnit()
    {
        return $this->unit;
    }
    /**
     * Set unit value
     * @uses DHLEnumUnit::valueIsValid()
     * @param DHLEnumUnit $_unit the unit
     * @return DHLEnumUnit
     */
    public function setUnit($_unit)
    {
        if(!DHLEnumUnit::valueIsValid($_unit))
        {
            return false;
        }
        return ($this->unit = $_unit);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDimension
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
