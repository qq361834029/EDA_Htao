<?php
/**
 * File for class DHLStructShipmentServiceDD
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentServiceDD originally named ShipmentServiceDD
 * Documentation : DD shipment services. can be
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentServiceDD extends DHLWsdlClass
{
    /**
     * The ServiceGroupDateTimeOption
     * Meta informations extracted from the WSDL
     * - documentation : Bundles following services for domestic time-definite products offered by DHL Express. One of the services must be chosen, if this service bundle is invoked.
     * @var DHLStructDDServiceGroupDateTimeOptionType
     */
    public $ServiceGroupDateTimeOption;
    /**
     * The ShipmentServiceGroupIdent
     * Meta informations extracted from the WSDL
     * - documentation : Bundles following ident services.One of the services must be chosen, if this service bundle is invoked.
     * @var DHLStructDDShipmentServiceGroupIdentType
     */
    public $ShipmentServiceGroupIdent;
    /**
     * The ShipmentServiceGroupPickup
     * Meta informations extracted from the WSDL
     * - documentation : One of the services must be chosen, if this service bundle is invoked. Bundles following services.
     * @var DHLStructDDShipmentServiceGroupPickupType
     */
    public $ShipmentServiceGroupPickup;
    /**
     * The ServiceGroupBusinessPackInternational
     * Meta informations extracted from the WSDL
     * - documentation : Service group for Business Pack International (product code BPI). One of the services must be chosen, if this service bundle is invoked. Bundles following services.
     * @var DHLStructDDServiceGroupBusinessPackInternationalType
     */
    public $ServiceGroupBusinessPackInternational;
    /**
     * The ServiceGroupDHLPaket
     * Meta informations extracted from the WSDL
     * - documentation : Service group for DHL Paket (product code EPN and RPN). One of the services must be chosen, if this service bundle is invoked. Bundles following services.
     * @var DHLStructDDServiceGroupDHLPaketType
     */
    public $ServiceGroupDHLPaket;
    /**
     * The ServiceGroupOther
     * Meta informations extracted from the WSDL
     * - documentation : One of the services must be chosen, if this service bundle is invoked. Service group bundles following services.
     * @var DHLStructDDServiceGroupOtherType
     */
    public $ServiceGroupOther;
    /**
     * Constructor method for ShipmentServiceDD
     * @see parent::__construct()
     * @param DHLStructDDServiceGroupDateTimeOptionType $_serviceGroupDateTimeOption
     * @param DHLStructDDShipmentServiceGroupIdentType $_shipmentServiceGroupIdent
     * @param DHLStructDDShipmentServiceGroupPickupType $_shipmentServiceGroupPickup
     * @param DHLStructDDServiceGroupBusinessPackInternationalType $_serviceGroupBusinessPackInternational
     * @param DHLStructDDServiceGroupDHLPaketType $_serviceGroupDHLPaket
     * @param DHLStructDDServiceGroupOtherType $_serviceGroupOther
     * @return DHLStructShipmentServiceDD
     */
    public function __construct($_serviceGroupDateTimeOption = NULL,$_shipmentServiceGroupIdent = NULL,$_shipmentServiceGroupPickup = NULL,$_serviceGroupBusinessPackInternational = NULL,$_serviceGroupDHLPaket = NULL,$_serviceGroupOther = NULL)
    {
        parent::__construct(array('ServiceGroupDateTimeOption'=>$_serviceGroupDateTimeOption,'ShipmentServiceGroupIdent'=>$_shipmentServiceGroupIdent,'ShipmentServiceGroupPickup'=>$_shipmentServiceGroupPickup,'ServiceGroupBusinessPackInternational'=>$_serviceGroupBusinessPackInternational,'ServiceGroupDHLPaket'=>$_serviceGroupDHLPaket,'ServiceGroupOther'=>$_serviceGroupOther),false);
    }
    /**
     * Get ServiceGroupDateTimeOption value
     * @return DHLStructDDServiceGroupDateTimeOptionType|null
     */
    public function getServiceGroupDateTimeOption()
    {
        return $this->ServiceGroupDateTimeOption;
    }
    /**
     * Set ServiceGroupDateTimeOption value
     * @param DHLStructDDServiceGroupDateTimeOptionType $_serviceGroupDateTimeOption the ServiceGroupDateTimeOption
     * @return DHLStructDDServiceGroupDateTimeOptionType
     */
    public function setServiceGroupDateTimeOption($_serviceGroupDateTimeOption)
    {
        return ($this->ServiceGroupDateTimeOption = $_serviceGroupDateTimeOption);
    }
    /**
     * Get ShipmentServiceGroupIdent value
     * @return DHLStructDDShipmentServiceGroupIdentType|null
     */
    public function getShipmentServiceGroupIdent()
    {
        return $this->ShipmentServiceGroupIdent;
    }
    /**
     * Set ShipmentServiceGroupIdent value
     * @param DHLStructDDShipmentServiceGroupIdentType $_shipmentServiceGroupIdent the ShipmentServiceGroupIdent
     * @return DHLStructDDShipmentServiceGroupIdentType
     */
    public function setShipmentServiceGroupIdent($_shipmentServiceGroupIdent)
    {
        return ($this->ShipmentServiceGroupIdent = $_shipmentServiceGroupIdent);
    }
    /**
     * Get ShipmentServiceGroupPickup value
     * @return DHLStructDDShipmentServiceGroupPickupType|null
     */
    public function getShipmentServiceGroupPickup()
    {
        return $this->ShipmentServiceGroupPickup;
    }
    /**
     * Set ShipmentServiceGroupPickup value
     * @param DHLStructDDShipmentServiceGroupPickupType $_shipmentServiceGroupPickup the ShipmentServiceGroupPickup
     * @return DHLStructDDShipmentServiceGroupPickupType
     */
    public function setShipmentServiceGroupPickup($_shipmentServiceGroupPickup)
    {
        return ($this->ShipmentServiceGroupPickup = $_shipmentServiceGroupPickup);
    }
    /**
     * Get ServiceGroupBusinessPackInternational value
     * @return DHLStructDDServiceGroupBusinessPackInternationalType|null
     */
    public function getServiceGroupBusinessPackInternational()
    {
        return $this->ServiceGroupBusinessPackInternational;
    }
    /**
     * Set ServiceGroupBusinessPackInternational value
     * @param DHLStructDDServiceGroupBusinessPackInternationalType $_serviceGroupBusinessPackInternational the ServiceGroupBusinessPackInternational
     * @return DHLStructDDServiceGroupBusinessPackInternationalType
     */
    public function setServiceGroupBusinessPackInternational($_serviceGroupBusinessPackInternational)
    {
        return ($this->ServiceGroupBusinessPackInternational = $_serviceGroupBusinessPackInternational);
    }
    /**
     * Get ServiceGroupDHLPaket value
     * @return DHLStructDDServiceGroupDHLPaketType|null
     */
    public function getServiceGroupDHLPaket()
    {
        return $this->ServiceGroupDHLPaket;
    }
    /**
     * Set ServiceGroupDHLPaket value
     * @param DHLStructDDServiceGroupDHLPaketType $_serviceGroupDHLPaket the ServiceGroupDHLPaket
     * @return DHLStructDDServiceGroupDHLPaketType
     */
    public function setServiceGroupDHLPaket($_serviceGroupDHLPaket)
    {
        return ($this->ServiceGroupDHLPaket = $_serviceGroupDHLPaket);
    }
    /**
     * Get ServiceGroupOther value
     * @return DHLStructDDServiceGroupOtherType|null
     */
    public function getServiceGroupOther()
    {
        return $this->ServiceGroupOther;
    }
    /**
     * Set ServiceGroupOther value
     * @param DHLStructDDServiceGroupOtherType $_serviceGroupOther the ServiceGroupOther
     * @return DHLStructDDServiceGroupOtherType
     */
    public function setServiceGroupOther($_serviceGroupOther)
    {
        return ($this->ServiceGroupOther = $_serviceGroupOther);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentServiceDD
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
