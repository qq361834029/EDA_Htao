<?php
/**
 * File for class DHLStructLabelData
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructLabelData originally named LabelData
 * Documentation : The status of the getLabel operation and the url for requesting the label (if available).
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructLabelData extends DHLWsdlClass
{
    /**
     * The ShipmentNumber
     * Meta informations extracted from the WSDL
     * - documentation : For successful and unsuccessful operations, the requested ShipmentNumber of the label to be retrieved is returned. This is no matter if it the operation could be performed or not. Depending on the invoked product (TD or DD)
     * @var DHLStructShipmentNumberType
     */
    public $ShipmentNumber;
    /**
     * The Status
     * Meta informations extracted from the WSDL
     * - documentation : Success status of processing retrieval of particular shipment label.
     * @var DHLStructStatusinformation
     */
    public $Status;
    /**
     * The Labelurl
     * Meta informations extracted from the WSDL
     * - documentation : If label output format was requested to be 'URL' in initial ShipmentOrder of the CreateShipment call, Labelurl will be returned and include the label as URL pointing to a PDF label.Note that the output format (URL or XML) is determined by the initial ShipmentOrder and cannot be set in GetLabel request.
     * - minOccurs : 0
     * @var string
     */
    public $Labelurl;
    /**
     * The XMLLabel
     * Meta informations extracted from the WSDL
     * - documentation : If label output format was requested to be 'XML' in initial ShipmentOrder of the CreateShipment call, XMLLabel will be returned and include the label as XML data in a CDATA-stream. Note that the output format (URL vs XML) is determined by the initial ShipmentOrder call and cannot be set in GetLabel request.
     * - minOccurs : 0
     * @var string
     */
    public $XMLLabel;
    /**
     * Constructor method for LabelData
     * @see parent::__construct()
     * @param DHLStructShipmentNumberType $_shipmentNumber
     * @param DHLStructStatusinformation $_status
     * @param string $_labelurl
     * @param string $_xMLLabel
     * @return DHLStructLabelData
     */
    public function __construct($_shipmentNumber = NULL,$_status = NULL,$_labelurl = NULL,$_xMLLabel = NULL)
    {
        parent::__construct(array('ShipmentNumber'=>$_shipmentNumber,'Status'=>$_status,'Labelurl'=>$_labelurl,'XMLLabel'=>$_xMLLabel),false);
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
     * Get Labelurl value
     * @return string|null
     */
    public function getLabelurl()
    {
        return $this->Labelurl;
    }
    /**
     * Set Labelurl value
     * @param string $_labelurl the Labelurl
     * @return string
     */
    public function setLabelurl($_labelurl)
    {
        return ($this->Labelurl = $_labelurl);
    }
    /**
     * Get XMLLabel value
     * @return string|null
     */
    public function getXMLLabel()
    {
        return $this->XMLLabel;
    }
    /**
     * Set XMLLabel value
     * @param string $_xMLLabel the XMLLabel
     * @return string
     */
    public function setXMLLabel($_xMLLabel)
    {
        return ($this->XMLLabel = $_xMLLabel);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructLabelData
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
