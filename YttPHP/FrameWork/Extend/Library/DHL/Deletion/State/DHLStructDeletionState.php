<?php
/**
 * File for class DHLStructDeletionState
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDeletionState originally named DeletionState
 * Documentation : The status of a deleteShipment operation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDeletionState extends DHLWsdlClass
{
    /**
     * The ShipmentNumber
     * Meta informations extracted from the WSDL
     * - documentation : For successful and unsuccessful operations, the requested ShipmentNumber to be deleted is returned. This is no matter if the operation could be performed or not. Depending on the invoked product (TD or DD).
     * @var DHLStructShipmentNumberType
     */
    public $ShipmentNumber;
    /**
     * The Status
     * Meta informations extracted from the WSDL
     * - documentation : Success status of processing the deletion of particular shipment.
     * @var DHLStructStatusinformation
     */
    public $Status;
    /**
     * Constructor method for DeletionState
     * @see parent::__construct()
     * @param DHLStructShipmentNumberType $_shipmentNumber
     * @param DHLStructStatusinformation $_status
     * @return DHLStructDeletionState
     */
    public function __construct($_shipmentNumber = NULL,$_status = NULL)
    {
        parent::__construct(array('ShipmentNumber'=>$_shipmentNumber,'Status'=>$_status),false);
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
     * Get Status value
     * @return DHLStructStatusinformation|null
     */
    public function getStatus()
    {
        return $this->Status;
    }
    /**
     * Set Status value
     * @param DHLStructStatusinformation $_status the Status
     * @return DHLStructStatusinformation
     */
    public function setStatus($_status)
    {
        return ($this->Status = $_status);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDeletionState
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
