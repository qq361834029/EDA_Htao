<?php
/**
 * File for class DHLStructDDServiceGroupDHLPaketType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDDServiceGroupDHLPaketType originally named DDServiceGroupDHLPaketType
 * Documentation : Service Group DHL Paket.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDDServiceGroupDHLPaketType extends DHLWsdlClass
{
    /**
     * The Multipack
     * Meta informations extracted from the WSDL
     * - documentation : Must be set to create EPN shipments with more than one shipment item. Special customer clearance required.
     * @var boolean
     */
    public $Multipack;
    /**
     * The RegioPacket
     * Meta informations extracted from the WSDL
     * - documentation : Service MUST be set with product code RPN regio paket to AT.
     * @var boolean
     */
    public $RegioPacket;
    /**
     * The ParticularDelivery
     * Meta informations extracted from the WSDL
     * - documentation : For EPN shipments with multiple items, this flag determines whether items will be delivered alltogether (=FALSE) or whether items can be delivery partially (=TRUE). Note: if COD is chosen as service, flag must be FALSE.
     * @var boolean
     */
    public $ParticularDelivery;
    /**
     * The ShipmentAdvisory
     * @var DHLStructShipmentAdvisory
     */
    public $ShipmentAdvisory;
    /**
     * The Endorsement
     * @var DHLStructEndorsement
     */
    public $Endorsement;
    /**
     * Constructor method for DDServiceGroupDHLPaketType
     * @see parent::__construct()
     * @param boolean $_multipack
     * @param boolean $_regioPacket
     * @param boolean $_particularDelivery
     * @param DHLStructShipmentAdvisory $_shipmentAdvisory
     * @param DHLStructEndorsement $_endorsement
     * @return DHLStructDDServiceGroupDHLPaketType
     */
    public function __construct($_multipack = NULL,$_regioPacket = NULL,$_particularDelivery = NULL,$_shipmentAdvisory = NULL,$_endorsement = NULL)
    {
        parent::__construct(array('Multipack'=>$_multipack,'RegioPacket'=>$_regioPacket,'ParticularDelivery'=>$_particularDelivery,'ShipmentAdvisory'=>$_shipmentAdvisory,'Endorsement'=>$_endorsement),false);
    }
    /**
     * Get Multipack value
     * @return boolean|null
     */
    public function getMultipack()
    {
        return $this->Multipack;
    }
    /**
     * Set Multipack value
     * @param boolean $_multipack the Multipack
     * @return boolean
     */
    public function setMultipack($_multipack)
    {
        return ($this->Multipack = $_multipack);
    }
    /**
     * Get RegioPacket value
     * @return boolean|null
     */
    public function getRegioPacket()
    {
        return $this->RegioPacket;
    }
    /**
     * Set RegioPacket value
     * @param boolean $_regioPacket the RegioPacket
     * @return boolean
     */
    public function setRegioPacket($_regioPacket)
    {
        return ($this->RegioPacket = $_regioPacket);
    }
    /**
     * Get ParticularDelivery value
     * @return boolean|null
     */
    public function getParticularDelivery()
    {
        return $this->ParticularDelivery;
    }
    /**
     * Set ParticularDelivery value
     * @param boolean $_particularDelivery the ParticularDelivery
     * @return boolean
     */
    public function setParticularDelivery($_particularDelivery)
    {
        return ($this->ParticularDelivery = $_particularDelivery);
    }
    /**
     * Get ShipmentAdvisory value
     * @return DHLStructShipmentAdvisory|null
     */
    public function getShipmentAdvisory()
    {
        return $this->ShipmentAdvisory;
    }
    /**
     * Set ShipmentAdvisory value
     * @param DHLStructShipmentAdvisory $_shipmentAdvisory the ShipmentAdvisory
     * @return DHLStructShipmentAdvisory
     */
    public function setShipmentAdvisory($_shipmentAdvisory)
    {
        return ($this->ShipmentAdvisory = $_shipmentAdvisory);
    }
    /**
     * Get Endorsement value
     * @return DHLStructEndorsement|null
     */
    public function getEndorsement()
    {
        return $this->Endorsement;
    }
    /**
     * Set Endorsement value
     * @param DHLStructEndorsement $_endorsement the Endorsement
     * @return DHLStructEndorsement
     */
    public function setEndorsement($_endorsement)
    {
        return ($this->Endorsement = $_endorsement);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDDServiceGroupDHLPaketType
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
