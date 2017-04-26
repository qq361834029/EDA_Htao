<?php
/**
 * File for class DHLStructShipmentNumberType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentNumberType originally named ShipmentNumberType
 * Documentation : Type of shipment number (IDC, LP) can be Airway Bill Number
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentNumberType extends DHLWsdlClass
{
    /**
     * The identCode
     * Meta informations extracted from the WSDL
     * - documentation : Ident code number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 12
     * - minLength : 12
     * - pattern : [0-9]{12}
     * @var string
     */
    public $identCode;
    /**
     * The licensePlate
     * Meta informations extracted from the WSDL
     * - documentation : License plate number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 39
     * @var string
     */
    public $licensePlate;
    /**
     * The airwayBill
     * Meta informations extracted from the WSDL
     * - documentation : Airway bill number.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $airwayBill;
    /**
     * The shipmentNumber
     * Meta informations extracted from the WSDL
     * - documentation : Can contain any DHL shipmentnumber.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 39
     * @var string
     */
    public $shipmentNumber;
    /**
     * Constructor method for ShipmentNumberType
     * @see parent::__construct()
     * @param string $_identCode
     * @param string $_licensePlate
     * @param string $_airwayBill
     * @param string $_shipmentNumber
     * @return DHLStructShipmentNumberType
     */
    public function __construct($_identCode = NULL,$_licensePlate = NULL,$_airwayBill = NULL,$_shipmentNumber = NULL)
    {
        parent::__construct(array('identCode'=>$_identCode,'licensePlate'=>$_licensePlate,'airwayBill'=>$_airwayBill,'shipmentNumber'=>$_shipmentNumber),false);
    }
    /**
     * Get identCode value
     * @return string|null
     */
    public function getIdentCode()
    {
        return $this->identCode;
    }
    /**
     * Set identCode value
     * @param string $_identCode the identCode
     * @return string
     */
    public function setIdentCode($_identCode)
    {
        return ($this->identCode = $_identCode);
    }
    /**
     * Get licensePlate value
     * @return string|null
     */
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }
    /**
     * Set licensePlate value
     * @param string $_licensePlate the licensePlate
     * @return string
     */
    public function setLicensePlate($_licensePlate)
    {
        return ($this->licensePlate = $_licensePlate);
    }
    /**
     * Get airwayBill value
     * @return string|null
     */
    public function getAirwayBill()
    {
        return $this->airwayBill;
    }
    /**
     * Set airwayBill value
     * @param string $_airwayBill the airwayBill
     * @return string
     */
    public function setAirwayBill($_airwayBill)
    {
        return ($this->airwayBill = $_airwayBill);
    }
    /**
     * Get shipmentNumber value
     * @return string|null
     */
    public function getShipmentNumber()
    {
        return $this->shipmentNumber;
    }
    /**
     * Set shipmentNumber value
     * @param string $_shipmentNumber the shipmentNumber
     * @return string
     */
    public function setShipmentNumber($_shipmentNumber)
    {
        return ($this->shipmentNumber = $_shipmentNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentNumberType
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
