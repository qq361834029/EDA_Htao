<?php
/**
 * File for class DHLStructCreateShipmentTDRequest
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCreateShipmentTDRequest originally named CreateShipmentTDRequest
 * Documentation : The shipmentdata for creating a TD shipment. The version of the webservice implementation for which the requesting client is developed.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCreateShipmentTDRequest extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The ShipmentOrder
     * Meta informations extracted from the WSDL
     * - documentation : Shipment order is the highest parent element that contains all data with respect to one shipment order.
     * - maxOccurs : 999
     * @var DHLStructShipmentOrderTDType
     */
    public $ShipmentOrder;
    /**
     * Constructor method for CreateShipmentTDRequest
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructShipmentOrderTDType $_shipmentOrder
     * @return DHLStructCreateShipmentTDRequest
     */
    public function __construct($_version = NULL,$_shipmentOrder = NULL)
    {
        parent::__construct(array('Version'=>$_version,'ShipmentOrder'=>$_shipmentOrder),false);
    }
    /**
     * Get Version value
     * @return DHLStructVersion|null
     */
    public function getVersion()
    {
        return $this->Version;
    }
    /**
     * Set Version value
     * @param DHLStructVersion $_version the Version
     * @return DHLStructVersion
     */
    public function setVersion($_version)
    {
        return ($this->Version = $_version);
    }
    /**
     * Get ShipmentOrder value
     * @return DHLStructShipmentOrderTDType|null
     */
    public function getShipmentOrder()
    {
        return $this->ShipmentOrder;
    }
    /**
     * Set ShipmentOrder value
     * @param DHLStructShipmentOrderTDType $_shipmentOrder the ShipmentOrder
     * @return DHLStructShipmentOrderTDType
     */
    public function setShipmentOrder($_shipmentOrder)
    {
        return ($this->ShipmentOrder = $_shipmentOrder);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCreateShipmentTDRequest
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
