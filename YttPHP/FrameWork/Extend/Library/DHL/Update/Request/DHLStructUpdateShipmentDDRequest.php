<?php
/**
 * File for class DHLStructUpdateShipmentDDRequest
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructUpdateShipmentDDRequest originally named UpdateShipmentDDRequest
 * Documentation : The shipmentdata for creating a DD shipment. The version of the webservice implementation for which the requesting client is developed.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructUpdateShipmentDDRequest extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The ShipmentNumber
     * Meta informations extracted from the WSDL
     * - documentation : The ShipmentNumber of the shipment, which sould be updated. ShipmentNumber is required. This parent element inherits from ShipmentNumberType, therefore all following subelements are valid according to schema, however the web service accepts shipmentNumber only.
     * @var DHLStructShipmentNumberType
     */
    public $ShipmentNumber;
    /**
     * The ShipmentOrder
     * Meta informations extracted from the WSDL
     * - documentation : ShipmentOrder contains an update of all data of the selected shipment order.
     * @var DHLStructShipmentOrderDDType
     */
    public $ShipmentOrder;
    /**
     * Constructor method for UpdateShipmentDDRequest
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructShipmentNumberType $_shipmentNumber
     * @param DHLStructShipmentOrderDDType $_shipmentOrder
     * @return DHLStructUpdateShipmentDDRequest
     */
    public function __construct($_version = NULL,$_shipmentNumber = NULL,$_shipmentOrder = NULL)
    {
        parent::__construct(array('Version'=>$_version,'ShipmentNumber'=>$_shipmentNumber,'ShipmentOrder'=>$_shipmentOrder),false);
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
     * Get ShipmentNumber value
     * @return DHLStructShipmentNumberType|null
     */
    public function getShipmentNumber()
    {
        return $this->ShipmentNumber;
    }
    /**
     * Set ShipmentNumber value
     * @param DHLStructShipmentNumberType $_shipmentNumber the ShipmentNumber
     * @return DHLStructShipmentNumberType
     */
    public function setShipmentNumber($_shipmentNumber)
    {
        return ($this->ShipmentNumber = $_shipmentNumber);
    }
    /**
     * Get ShipmentOrder value
     * @return DHLStructShipmentOrderDDType|null
     */
    public function getShipmentOrder()
    {
        return $this->ShipmentOrder;
    }
    /**
     * Set ShipmentOrder value
     * @param DHLStructShipmentOrderDDType $_shipmentOrder the ShipmentOrder
     * @return DHLStructShipmentOrderDDType
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
     * @return DHLStructUpdateShipmentDDRequest
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
