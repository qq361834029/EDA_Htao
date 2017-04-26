<?php
/**
 * File for class DHLStructShipmentDetailsDDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentDetailsDDType originally named ShipmentDetailsDDType
 * Documentation : Details of a DD shipment. extends the ShipmentDetailsType EKP (mandatory)
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentDetailsDDType extends DHLStructShipmentDetailsType
{
    /**
     * The EKP
     * Meta informations extracted from the WSDL
     * - documentation : First 10 digit number extract from the 14 digit DHL Account Number. E.g. if DHL Account Number is "5000000008 72 01" then EKP is equal to 5000000008.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $EKP;
    /**
     * The Attendance
     * @var DHLStructAttendance
     */
    public $Attendance;
    /**
     * The CustomerReference
     * Meta informations extracted from the WSDL
     * - documentation : A reference number that the client can assign for better association purposes. Appears on shipment label.
     * - minOccurs : 0
     * @var string
     */
    public $CustomerReference;
    /**
     * The Description
     * Meta informations extracted from the WSDL
     * - documentation : A description text that the client can assign. Does not appear on shipment label.
     * - minOccurs : 0
     * @var string
     */
    public $Description;
    /**
     * The DeliveryRemarks
     * Meta informations extracted from the WSDL
     * - documentation : Delivery remarks. Do not appear on shipment label.
     * - minOccurs : 0
     * @var string
     */
    public $DeliveryRemarks;
    /**
     * The ShipmentItem
     * Meta informations extracted from the WSDL
     * - documentation : For every parcel specified, contains weight in KG, length in CM, width in CM and height in CM. Last PackageType must ne Not every product allows multiple parcels. For using >1 parcels for product code EPN there is an extra service ServiceGroupDHLPaket.Multipack that needs to be set (only for cleared customers).
     * - maxOccurs : 999
     * @var DHLStructShipmentItemDDType
     */
    public $ShipmentItem;
    /**
     * The Service
     * Meta informations extracted from the WSDL
     * - documentation : Use one dedicated Service node for each service to be booked with the shipment product. Add another Service node for booking a further service and so on. Successful booking of a particular service depends on account permissions and product's service combinatorics. I.e. not every service is allowed for every product, or can be combined with all other allowed services. The service bundles that contain all DD services are the following.
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructShipmentServiceDD
     */
    public $Service;
    /**
     * The Notification
     * Meta informations extracted from the WSDL
     * - documentation : Mechanism to send notifications by email after successful manifesting of shipment.
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructShipmentNotificationType
     */
    public $Notification;
    /**
     * The NotificationEmailText
     * Meta informations extracted from the WSDL
     * - documentation : Email text for the notification email.
     * - minOccurs : 0
     * @var string
     */
    public $NotificationEmailText;
    /**
     * The BankData
     * Meta informations extracted from the WSDL
     * - documentation : Bank data can be provided here for different purposes. E.g. if COD is booked as service, bank data must be provided by DHL customer (mandatory server logic). The collected money will be transferred to specified bank account.
     * - minOccurs : 0
     * @var DHLStructBankType
     */
    public $BankData;
    /**
     * Constructor method for ShipmentDetailsDDType
     * @see parent::__construct()
     * @param string $_eKP
     * @param DHLStructAttendance $_attendance
     * @param string $_customerReference
     * @param string $_description
     * @param string $_deliveryRemarks
     * @param DHLStructShipmentItemDDType $_shipmentItem
     * @param DHLStructShipmentServiceDD $_service
     * @param DHLStructShipmentNotificationType $_notification
     * @param string $_notificationEmailText
     * @param DHLStructBankType $_bankData
     * @return DHLStructShipmentDetailsDDType
     */
    public function __construct($_eKP = NULL,$_attendance = NULL,$_customerReference = NULL,$_description = NULL,$_deliveryRemarks = NULL,$_shipmentItem = NULL,$_service = NULL,$_notification = NULL,$_notificationEmailText = NULL,$_bankData = NULL)
    {
        DHLWsdlClass::__construct(array('EKP'=>$_eKP,'Attendance'=>$_attendance,'CustomerReference'=>$_customerReference,'Description'=>$_description,'DeliveryRemarks'=>$_deliveryRemarks,'ShipmentItem'=>$_shipmentItem,'Service'=>$_service,'Notification'=>$_notification,'NotificationEmailText'=>$_notificationEmailText,'BankData'=>$_bankData),false);
    }
    /**
     * Get EKP value
     * @return string|null
     */
    public function getEKP()
    {
        return $this->EKP;
    }
    /**
     * Set EKP value
     * @param string $_eKP the EKP
     * @return string
     */
    public function setEKP($_eKP)
    {
        return ($this->EKP = $_eKP);
    }
    /**
     * Get Attendance value
     * @return DHLStructAttendance|null
     */
    public function getAttendance()
    {
        return $this->Attendance;
    }
    /**
     * Set Attendance value
     * @param DHLStructAttendance $_attendance the Attendance
     * @return DHLStructAttendance
     */
    public function setAttendance($_attendance)
    {
        return ($this->Attendance = $_attendance);
    }
    /**
     * Get CustomerReference value
     * @return string|null
     */
    public function getCustomerReference()
    {
        return $this->CustomerReference;
    }
    /**
     * Set CustomerReference value
     * @param string $_customerReference the CustomerReference
     * @return string
     */
    public function setCustomerReference($_customerReference)
    {
        return ($this->CustomerReference = $_customerReference);
    }
    /**
     * Get Description value
     * @return string|null
     */
    public function getDescription()
    {
        return $this->Description;
    }
    /**
     * Set Description value
     * @param string $_description the Description
     * @return string
     */
    public function setDescription($_description)
    {
        return ($this->Description = $_description);
    }
    /**
     * Get DeliveryRemarks value
     * @return string|null
     */
    public function getDeliveryRemarks()
    {
        return $this->DeliveryRemarks;
    }
    /**
     * Set DeliveryRemarks value
     * @param string $_deliveryRemarks the DeliveryRemarks
     * @return string
     */
    public function setDeliveryRemarks($_deliveryRemarks)
    {
        return ($this->DeliveryRemarks = $_deliveryRemarks);
    }
    /**
     * Get ShipmentItem value
     * @return DHLStructShipmentItemDDType|null
     */
    public function getShipmentItem()
    {
        return $this->ShipmentItem;
    }
    /**
     * Set ShipmentItem value
     * @param DHLStructShipmentItemDDType $_shipmentItem the ShipmentItem
     * @return DHLStructShipmentItemDDType
     */
    public function setShipmentItem($_shipmentItem)
    {
        return ($this->ShipmentItem = $_shipmentItem);
    }
    /**
     * Get Service value
     * @return DHLStructShipmentServiceDD|null
     */
    public function getService()
    {
        return $this->Service;
    }
    /**
     * Set Service value
     * @param DHLStructShipmentServiceDD $_service the Service
     * @return DHLStructShipmentServiceDD
     */
    public function setService($_service)
    {
        return ($this->Service = $_service);
    }
    /**
     * Get Notification value
     * @return DHLStructShipmentNotificationType|null
     */
    public function getNotification()
    {
        return $this->Notification;
    }
    /**
     * Set Notification value
     * @param DHLStructShipmentNotificationType $_notification the Notification
     * @return DHLStructShipmentNotificationType
     */
    public function setNotification($_notification)
    {
        return ($this->Notification = $_notification);
    }
    /**
     * Get NotificationEmailText value
     * @return string|null
     */
    public function getNotificationEmailText()
    {
        return $this->NotificationEmailText;
    }
    /**
     * Set NotificationEmailText value
     * @param string $_notificationEmailText the NotificationEmailText
     * @return string
     */
    public function setNotificationEmailText($_notificationEmailText)
    {
        return ($this->NotificationEmailText = $_notificationEmailText);
    }
    /**
     * Get BankData value
     * @return DHLStructBankType|null
     */
    public function getBankData()
    {
        return $this->BankData;
    }
    /**
     * Set BankData value
     * @param DHLStructBankType $_bankData the BankData
     * @return DHLStructBankType
     */
    public function setBankData($_bankData)
    {
        return ($this->BankData = $_bankData);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentDetailsDDType
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
