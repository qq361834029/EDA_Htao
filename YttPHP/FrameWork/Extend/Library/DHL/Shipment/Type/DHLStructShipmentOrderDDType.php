<?php
/**
 * File for class DHLStructShipmentOrderDDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentOrderDDType originally named ShipmentOrderDDType
 * Documentation : Data for the creation of a DD shipment.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentOrderDDType extends DHLWsdlClass
{
    /**
     * The SequenceNumber
     * Meta informations extracted from the WSDL
     * - documentation : Free field to to tag multiple shipment orders individually by client. Essential for later mapping of response data returned by webservice upon createShipment operation. Allows client to assign the shipment information of the response to the correct shipment order of the request.
     * - documentation : A sequence number defined by the (soap-) client. The sequenceNumber is returned by the webservice within the result of the createShipment operation, so that the client is able to assign the shipment information of the response to the shipment data of the request.
     * - maxLength : 30
     * @var string
     */
    public $SequenceNumber;
    /**
     * The Shipment
     * @var DHLStructShipment
     */
    public $Shipment;
    /**
     * The Pickup
     * @var DHLStructPickup
     */
    public $Pickup;
    /**
     * The LabelResponseType
     * @var DHLEnumLabelResponseType
     */
    public $LabelResponseType;
    /**
     * The PRINTONLYIFCODEABLE
     * @var DHLEnumPRINTONLYIFCODEABLE
     */
    public $PRINTONLYIFCODEABLE;
    /**
     * Constructor method for ShipmentOrderDDType
     * @see parent::__construct()
     * @param string $_sequenceNumber
     * @param DHLStructShipment $_shipment
     * @param DHLStructPickup $_pickup
     * @param DHLEnumLabelResponseType $_labelResponseType
     * @param DHLEnumPRINTONLYIFCODEABLE $_pRINTONLYIFCODEABLE
     * @return DHLStructShipmentOrderDDType
     */
    public function __construct($_sequenceNumber = NULL,$_shipment = NULL,$_pickup = NULL,$_labelResponseType = NULL,$_pRINTONLYIFCODEABLE = NULL)
    {
        parent::__construct(array('SequenceNumber'=>$_sequenceNumber,'Shipment'=>$_shipment,'Pickup'=>$_pickup,'LabelResponseType'=>$_labelResponseType,'PRINTONLYIFCODEABLE'=>$_pRINTONLYIFCODEABLE),false);
    }
    /**
     * Get SequenceNumber value
     * @return string|null
     */
    public function getSequenceNumber()
    {
        return $this->SequenceNumber;
    }
    /**
     * Set SequenceNumber value
     * @param string $_sequenceNumber the SequenceNumber
     * @return string
     */
    public function setSequenceNumber($_sequenceNumber)
    {
        return ($this->SequenceNumber = $_sequenceNumber);
    }
    /**
     * Get Shipment value
     * @return DHLStructShipment|null
     */
    public function getShipment()
    {
        return $this->Shipment;
    }
    /**
     * Set Shipment value
     * @param DHLStructShipment $_shipment the Shipment
     * @return DHLStructShipment
     */
    public function setShipment($_shipment)
    {
        return ($this->Shipment = $_shipment);
    }
    /**
     * Get Pickup value
     * @return DHLStructPickup|null
     */
    public function getPickup()
    {
        return $this->Pickup;
    }
    /**
     * Set Pickup value
     * @param DHLStructPickup $_pickup the Pickup
     * @return DHLStructPickup
     */
    public function setPickup($_pickup)
    {
        return ($this->Pickup = $_pickup);
    }
    /**
     * Get LabelResponseType value
     * @return DHLEnumLabelResponseType|null
     */
    public function getLabelResponseType()
    {
        return $this->LabelResponseType;
    }
    /**
     * Set LabelResponseType value
     * @uses DHLEnumLabelResponseType::valueIsValid()
     * @param DHLEnumLabelResponseType $_labelResponseType the LabelResponseType
     * @return DHLEnumLabelResponseType
     */
    public function setLabelResponseType($_labelResponseType)
    {
        if(!DHLEnumLabelResponseType::valueIsValid($_labelResponseType))
        {
            return false;
        }
        return ($this->LabelResponseType = $_labelResponseType);
    }
    /**
     * Get PRINTONLYIFCODEABLE value
     * @return DHLEnumPRINTONLYIFCODEABLE|null
     */
    public function getPRINTONLYIFCODEABLE()
    {
        return $this->PRINTONLYIFCODEABLE;
    }
    /**
     * Set PRINTONLYIFCODEABLE value
     * @uses DHLEnumPRINTONLYIFCODEABLE::valueIsValid()
     * @param DHLEnumPRINTONLYIFCODEABLE $_pRINTONLYIFCODEABLE the PRINTONLYIFCODEABLE
     * @return DHLEnumPRINTONLYIFCODEABLE
     */
    public function setPRINTONLYIFCODEABLE($_pRINTONLYIFCODEABLE)
    {
        if(!DHLEnumPRINTONLYIFCODEABLE::valueIsValid($_pRINTONLYIFCODEABLE))
        {
            return false;
        }
        return ($this->PRINTONLYIFCODEABLE = $_pRINTONLYIFCODEABLE);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentOrderDDType
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
