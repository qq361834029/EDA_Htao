<?php
/**
 * File for class DHLStructShipmentItemDDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentItemDDType originally named ShipmentItemDDType
 * Documentation : Item/Piece data of a DD shipment. extends the ShipmentItemType
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentItemDDType extends DHLStructShipmentItemType
{
    /**
     * The PackageType
     * Meta informations extracted from the WSDL
     * - documentation : <context id="CreateShipmentDDRequest"> PackageType is always "PK"! It might be varied only for product code EUP. Field length must be less than or equal to 5. <values> <value> <name>CO</name> <description>Palett</description> </value> <value> <name>PK</name> <description>Paket</description> </value> </values> </context>
     * @var string
     */
    public $PackageType;
    /**
     * Constructor method for ShipmentItemDDType
     * @see parent::__construct()
     * @param string $_packageType
     * @return DHLStructShipmentItemDDType
     */
    public function __construct($_packageType = NULL)
    {
        DHLWsdlClass::__construct(array('PackageType'=>$_packageType),false);
    }
    /**
     * Get PackageType value
     * @return string|null
     */
    public function getPackageType()
    {
        return $this->PackageType;
    }
    /**
     * Set PackageType value
     * @param string $_packageType the PackageType
     * @return string
     */
    public function setPackageType($_packageType)
    {
        return ($this->PackageType = $_packageType);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentItemDDType
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
