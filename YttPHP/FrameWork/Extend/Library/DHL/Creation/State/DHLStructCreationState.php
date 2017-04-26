<?php
/**
 * File for class DHLStructCreationState
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCreationState originally named CreationState
 * Documentation : The operation's success status for every single ShipmentOrder will be returned by one CreationState element. It is identifiable via SequenceNumber.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCreationState extends DHLWsdlClass
{
    /**
     * The StatusCode
     * Meta informations extracted from the WSDL
     * - documentation : Status for this particular ShipmentOrder.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * @var string
     */
    public $StatusCode;
    /**
     * The StatusMessage
     * Meta informations extracted from the WSDL
     * - documentation : Dedicated status and error messages at the level of the particular ShipmentOrder.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * @var string
     */
    public $StatusMessage;
    /**
     * The SequenceNumber
     * Meta informations extracted from the WSDL
     * - documentation : Identifier for ShipmentOrder set by client application in CreateShipment request. The defined value is looped through and returned unchanged by the web service within the response of createShipment. The client can therefore assign the status information of the response to the correct ShipmentOrder of the request.
     * - documentation : A sequence number defined by the (soap-) client. The sequenceNumber is returned by the webservice within the result of the createShipment operation, so that the client is able to assign the shipment information of the response to the shipment data of the request.
     * - maxLength : 30
     * @var string
     */
    public $SequenceNumber;
    /**
     * The ShipmentNumber
     * Meta informations extracted from the WSDL
     * - documentation : For successful operations, a shipment number is created and returned. Depending on the invoked product (TD or DD).
     * - minOccurs : 0
     * @var DHLStructShipmentNumberType
     */
    public $ShipmentNumber;
    /**
     * The PieceInformation
     * Meta informations extracted from the WSDL
     * - documentation : Information about each piece (e.g. the generated licence plate). For every piece, a PieceInformation container holds the license plate number.
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructPieceInformation
     */
    public $PieceInformation;
    /**
     * The Labelurl
     * Meta informations extracted from the WSDL
     * - documentation : If label output format was requested as 'URL' via LabelResponseType, this element will be returned. It contains the URL to access the PDF label. This is default output format if not specified other by client in LabelResponseType.
     * - minOccurs : 0
     * @var string
     */
    public $Labelurl;
    /**
     * The XMLLabel
     * Meta informations extracted from the WSDL
     * - documentation : If label output format was requested as 'XML' via LabelResponseType, this element will be returned and include the label as XML data in a CDATA-stream. Allows client to parse data and render shipping label on ist own.
     * - minOccurs : 0
     * @var string
     */
    public $XMLLabel;
    /**
     * The PickupConfirmationNumber
     * Meta informations extracted from the WSDL
     * - documentation : If a pickup was ordered along with the CreateShipment request, the pickup confirmation number is returned.
     * - minOccurs : 0
     * @var string
     */
    public $PickupConfirmationNumber;
    /**
     * Constructor method for CreationState
     * @see parent::__construct()
     * @param string $_statusCode
     * @param string $_statusMessage
     * @param string $_sequenceNumber
     * @param DHLStructShipmentNumberType $_shipmentNumber
     * @param DHLStructPieceInformation $_pieceInformation
     * @param string $_labelurl
     * @param string $_xMLLabel
     * @param string $_pickupConfirmationNumber
     * @return DHLStructCreationState
     */
    public function __construct($_statusCode = NULL,$_statusMessage = NULL,$_sequenceNumber = NULL,$_shipmentNumber = NULL,$_pieceInformation = NULL,$_labelurl = NULL,$_xMLLabel = NULL,$_pickupConfirmationNumber = NULL)
    {
        parent::__construct(array('StatusCode'=>$_statusCode,'StatusMessage'=>$_statusMessage,'SequenceNumber'=>$_sequenceNumber,'ShipmentNumber'=>$_shipmentNumber,'PieceInformation'=>$_pieceInformation,'Labelurl'=>$_labelurl,'XMLLabel'=>$_xMLLabel,'PickupConfirmationNumber'=>$_pickupConfirmationNumber),false);
    }
    /**
     * Get StatusCode value
     * @return string|null
     */
    public function getStatusCode()
    {
        return $this->StatusCode;
    }
    /**
     * Set StatusCode value
     * @param string $_statusCode the StatusCode
     * @return string
     */
    public function setStatusCode($_statusCode)
    {
        return ($this->StatusCode = $_statusCode);
    }
    /**
     * Get StatusMessage value
     * @return string|null
     */
    public function getStatusMessage()
    {
        return $this->StatusMessage;
    }
    /**
     * Set StatusMessage value
     * @param string $_statusMessage the StatusMessage
     * @return string
     */
    public function setStatusMessage($_statusMessage)
    {
        return ($this->StatusMessage = $_statusMessage);
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
     * Get PieceInformation value
     * @return DHLStructPieceInformation|null
     */
    public function getPieceInformation()
    {
        return $this->PieceInformation;
    }
    /**
     * Set PieceInformation value
     * @param DHLStructPieceInformation $_pieceInformation the PieceInformation
     * @return DHLStructPieceInformation
     */
    public function setPieceInformation($_pieceInformation)
    {
        return ($this->PieceInformation = $_pieceInformation);
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
     * Get PickupConfirmationNumber value
     * @return string|null
     */
    public function getPickupConfirmationNumber()
    {
        return $this->PickupConfirmationNumber;
    }
    /**
     * Set PickupConfirmationNumber value
     * @param string $_pickupConfirmationNumber the PickupConfirmationNumber
     * @return string
     */
    public function setPickupConfirmationNumber($_pickupConfirmationNumber)
    {
        return ($this->PickupConfirmationNumber = $_pickupConfirmationNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCreationState
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
