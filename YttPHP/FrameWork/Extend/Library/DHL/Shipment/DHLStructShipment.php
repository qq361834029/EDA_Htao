<?php
/**
 * File for class DHLStructShipment
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipment originally named Shipment
 * Documentation : Is the core element of a TD ShipmentOrder. It has only one sister element Pickup and contains all relevant information of the shipment. Is the core element of a DD ShipmentOrder. It has only one sister element Pickup and contains all relevant information of the shipment.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipment extends DHLWsdlClass
{
    /**
     * The ShipmentDetails
     * Meta informations extracted from the WSDL
     * - documentation : Contains the information of the shipment product code, value, terms of trade, weight and size characteristics and services to be used. Contains the information of the shipment product code, weight and size characteristics and services to be used.
     * @var DHLStructShipmentDetailsDDType
     */
    public $ShipmentDetails;
    /**
     * The Shipper
     * Meta informations extracted from the WSDL
     * - documentation : Contains relevant information about consignor.
     * @var DHLStructShipperDDType
     */
    public $Shipper;
    /**
     * The Receiver
     * Meta informations extracted from the WSDL
     * - documentation : Contains relevant information about Receiver.
     * @var DHLStructReceiverDDType
     */
    public $Receiver;
    /**
     * The ExportDocument
     * Meta informations extracted from the WSDL
     * - documentation : This section contains information about the exported goods relevant for type, date, and number of invoice, export type, international commodity code, and others. The commercial invoice is included in label PDF. For international shipments, this section contains information about the exported goods relevant for customs. For BPI shipments: commercial invoice, dispatch note (CP71) and customs declaration (CN23) are printed into returned PDF label. Data is also transferred as electronic declaration to customs. For EUPs: the proforma invoice is included in label PDF.For BPI, ExportDocument can contain one or more positions in child element.
     * - minOccurs : 0
     * @var DHLStructExportDocumentDDType
     */
    public $ExportDocument;
    /**
     * The Identity
     * Meta informations extracted from the WSDL
     * - documentation : Identity data to be verified with Express Ident shipment. Fields must be filled in when product code is EXI! Note: usually and for other products, ident services are booked via ShipmentServiceGroupIdent!
     * - minOccurs : 0
     * @var DHLStructIdentityType
     */
    public $Identity;
    /**
     * The FurtherAddresses
     * Meta informations extracted from the WSDL
     * - documentation : To be used if a further address shall be specified. Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var DHLStructFurtherAddressesDDType
     */
    public $FurtherAddresses;
    /**
     * Constructor method for Shipment
     * @see parent::__construct()
     * @param DHLStructShipmentDetailsDDType $_shipmentDetails
     * @param DHLStructShipperDDType $_shipper
     * @param DHLStructReceiverDDType $_receiver
     * @param DHLStructExportDocumentDDType $_exportDocument
     * @param DHLStructIdentityType $_identity
     * @param DHLStructFurtherAddressesDDType $_furtherAddresses
     * @return DHLStructShipment
     */
    public function __construct($_shipmentDetails = NULL,$_shipper = NULL,$_receiver = NULL,$_exportDocument = NULL,$_identity = NULL,$_furtherAddresses = NULL)
    {
        parent::__construct(array('ShipmentDetails'=>$_shipmentDetails,'Shipper'=>$_shipper,'Receiver'=>$_receiver,'ExportDocument'=>$_exportDocument,'Identity'=>$_identity,'FurtherAddresses'=>$_furtherAddresses),false);
    }
    /**
     * Get ShipmentDetails value
     * @return DHLStructShipmentDetailsDDType|null
     */
    public function getShipmentDetails()
    {
        return $this->ShipmentDetails;
    }
    /**
     * Set ShipmentDetails value
     * @param DHLStructShipmentDetailsDDType $_shipmentDetails the ShipmentDetails
     * @return DHLStructShipmentDetailsDDType
     */
    public function setShipmentDetails($_shipmentDetails)
    {
        return ($this->ShipmentDetails = $_shipmentDetails);
    }
    /**
     * Get Shipper value
     * @return DHLStructShipperDDType|null
     */
    public function getShipper()
    {
        return $this->Shipper;
    }
    /**
     * Set Shipper value
     * @param DHLStructShipperDDType $_shipper the Shipper
     * @return DHLStructShipperDDType
     */
    public function setShipper($_shipper)
    {
        return ($this->Shipper = $_shipper);
    }
    /**
     * Get Receiver value
     * @return DHLStructReceiverDDType|null
     */
    public function getReceiver()
    {
        return $this->Receiver;
    }
    /**
     * Set Receiver value
     * @param DHLStructReceiverDDType $_receiver the Receiver
     * @return DHLStructReceiverDDType
     */
    public function setReceiver($_receiver)
    {
        return ($this->Receiver = $_receiver);
    }
    /**
     * Get ExportDocument value
     * @return DHLStructExportDocumentDDType|null
     */
    public function getExportDocument()
    {
        return $this->ExportDocument;
    }
    /**
     * Set ExportDocument value
     * @param DHLStructExportDocumentDDType $_exportDocument the ExportDocument
     * @return DHLStructExportDocumentDDType
     */
    public function setExportDocument($_exportDocument)
    {
        return ($this->ExportDocument = $_exportDocument);
    }
    /**
     * Get Identity value
     * @return DHLStructIdentityType|null
     */
    public function getIdentity()
    {
        return $this->Identity;
    }
    /**
     * Set Identity value
     * @param DHLStructIdentityType $_identity the Identity
     * @return DHLStructIdentityType
     */
    public function setIdentity($_identity)
    {
        return ($this->Identity = $_identity);
    }
    /**
     * Get FurtherAddresses value
     * @return DHLStructFurtherAddressesDDType|null
     */
    public function getFurtherAddresses()
    {
        return $this->FurtherAddresses;
    }
    /**
     * Set FurtherAddresses value
     * @param DHLStructFurtherAddressesDDType $_furtherAddresses the FurtherAddresses
     * @return DHLStructFurtherAddressesDDType
     */
    public function setFurtherAddresses($_furtherAddresses)
    {
        return ($this->FurtherAddresses = $_furtherAddresses);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipment
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
