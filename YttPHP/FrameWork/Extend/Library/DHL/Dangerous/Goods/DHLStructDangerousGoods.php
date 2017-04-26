<?php
/**
 * File for class DHLStructDangerousGoods
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDangerousGoods originally named DangerousGoods
 * Documentation : Service to ship hazardous goods. If selected dangerous goods class, packaging type and UN code must be specified. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDangerousGoods extends DHLWsdlClass
{
    /**
     * The DangerousGoodsClass
     * Meta informations extracted from the WSDL
     * - documentation : Dangerous goods classification. Field length must be = 1.
     * @var string
     */
    public $DangerousGoodsClass;
    /**
     * The DangerousGoodsPackagingType
     * Meta informations extracted from the WSDL
     * - documentation : Dangerous packaging type.
     * @var string
     */
    public $DangerousGoodsPackagingType;
    /**
     * The DangerousGoodsUNCode
     * Meta informations extracted from the WSDL
     * - documentation : Dangerous goods UN code.
     * @var string
     */
    public $DangerousGoodsUNCode;
    /**
     * Constructor method for DangerousGoods
     * @see parent::__construct()
     * @param string $_dangerousGoodsClass
     * @param string $_dangerousGoodsPackagingType
     * @param string $_dangerousGoodsUNCode
     * @return DHLStructDangerousGoods
     */
    public function __construct($_dangerousGoodsClass = NULL,$_dangerousGoodsPackagingType = NULL,$_dangerousGoodsUNCode = NULL)
    {
        parent::__construct(array('DangerousGoodsClass'=>$_dangerousGoodsClass,'DangerousGoodsPackagingType'=>$_dangerousGoodsPackagingType,'DangerousGoodsUNCode'=>$_dangerousGoodsUNCode),false);
    }
    /**
     * Get DangerousGoodsClass value
     * @return string|null
     */
    public function getDangerousGoodsClass()
    {
        return $this->DangerousGoodsClass;
    }
    /**
     * Set DangerousGoodsClass value
     * @param string $_dangerousGoodsClass the DangerousGoodsClass
     * @return string
     */
    public function setDangerousGoodsClass($_dangerousGoodsClass)
    {
        return ($this->DangerousGoodsClass = $_dangerousGoodsClass);
    }
    /**
     * Get DangerousGoodsPackagingType value
     * @return string|null
     */
    public function getDangerousGoodsPackagingType()
    {
        return $this->DangerousGoodsPackagingType;
    }
    /**
     * Set DangerousGoodsPackagingType value
     * @param string $_dangerousGoodsPackagingType the DangerousGoodsPackagingType
     * @return string
     */
    public function setDangerousGoodsPackagingType($_dangerousGoodsPackagingType)
    {
        return ($this->DangerousGoodsPackagingType = $_dangerousGoodsPackagingType);
    }
    /**
     * Get DangerousGoodsUNCode value
     * @return string|null
     */
    public function getDangerousGoodsUNCode()
    {
        return $this->DangerousGoodsUNCode;
    }
    /**
     * Set DangerousGoodsUNCode value
     * @param string $_dangerousGoodsUNCode the DangerousGoodsUNCode
     * @return string
     */
    public function setDangerousGoodsUNCode($_dangerousGoodsUNCode)
    {
        return ($this->DangerousGoodsUNCode = $_dangerousGoodsUNCode);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDangerousGoods
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
