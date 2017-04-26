<?php
/**
 * File for class DHLStructShipmentDetailsTDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentDetailsTDType originally named ShipmentDetailsTDType
 * Documentation : Details of a TD shipment. extends the ShipmentDetailsType
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentDetailsTDType extends DHLStructShipmentDetailsType
{
    /**
     * The Account
     * @var DHLStructAccount
     */
    public $Account;
    /**
     * The Dutiable
     * @var DHLEnumDutiable
     */
    public $Dutiable;
    /**
     * The DescriptionOfContent
     * Meta informations extracted from the WSDL
     * - documentation : The description of the content that appears on label.
     * @var string
     */
    public $DescriptionOfContent;
    /**
     * The AccountPaidBy
     * @var DHLStructAccountPaidBy
     */
    public $AccountPaidBy;
    /**
     * The ShipmentReference
     * Meta informations extracted from the WSDL
     * - documentation : Shipment reference can be provided by shipper to appear on label. Field length must be less than or equal to 35.
     * - minOccurs : 0
     * @var string
     */
    public $ShipmentReference;
    /**
     * The TermsOfTrade
     * Meta informations extracted from the WSDL
     * - documentation : Terms of trade (incoterms) can be provided, e.g. DDP, DDU, CIP, CIF et al. Field length must be = 3.
     * - minOccurs : 0
     * @var string
     */
    public $TermsOfTrade;
    /**
     * The ShipmentItem
     * Meta informations extracted from the WSDL
     * - documentation : For every parcel specified, contains weight in KG, length in CM, width in CM and height in CM. Last PackageType must ne Not every product allows multiple parcels. For using >1 parcels from product code EPN there is an extra service ServiceGroupDHLPaket. Multipack that needs to be set (only for cleared customers).
     * - maxOccurs : 999
     * @var DHLStructShipmentItemTDType
     */
    public $ShipmentItem;
    /**
     * The Service
     * Meta informations extracted from the WSDL
     * - documentation : Use one dedicated Service node for each service to be booked with the shipment product. Add another Service node for booking a further service and so on. Successful booking of a particular service depends on account permissions and product's service combinatorics. I.e. not every service is allowed for every product, or can be combined with all other allowed services. For TD shipments, only Express Saturday and Insurance can be booked by configuring and passing the following containers.
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructShipmentServiceTD
     */
    public $Service;
    /**
     * The Notification
     * Meta informations extracted from the WSDL
     * - documentation : Mechanism to send notifications by email after shipment has been manifested.
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
     * Constructor method for ShipmentDetailsTDType
     * @see parent::__construct()
     * @param DHLStructAccount $_account
     * @param DHLEnumDutiable $_dutiable
     * @param string $_descriptionOfContent
     * @param DHLStructAccountPaidBy $_accountPaidBy
     * @param string $_shipmentReference
     * @param string $_termsOfTrade
     * @param DHLStructShipmentItemTDType $_shipmentItem
     * @param DHLStructShipmentServiceTD $_service
     * @param DHLStructShipmentNotificationType $_notification
     * @param string $_notificationEmailText
     * @return DHLStructShipmentDetailsTDType
     */
    public function __construct($_account = NULL,$_dutiable = NULL,$_descriptionOfContent = NULL,$_accountPaidBy = NULL,$_shipmentReference = NULL,$_termsOfTrade = NULL,$_shipmentItem = NULL,$_service = NULL,$_notification = NULL,$_notificationEmailText = NULL)
    {
        DHLWsdlClass::__construct(array('Account'=>$_account,'Dutiable'=>$_dutiable,'DescriptionOfContent'=>$_descriptionOfContent,'AccountPaidBy'=>$_accountPaidBy,'ShipmentReference'=>$_shipmentReference,'TermsOfTrade'=>$_termsOfTrade,'ShipmentItem'=>$_shipmentItem,'Service'=>$_service,'Notification'=>$_notification,'NotificationEmailText'=>$_notificationEmailText),false);
    }
    /**
     * Get Account value
     * @return DHLStructAccount|null
     */
    public function getAccount()
    {
        return $this->Account;
    }
    /**
     * Set Account value
     * @param DHLStructAccount $_account the Account
     * @return DHLStructAccount
     */
    public function setAccount($_account)
    {
        return ($this->Account = $_account);
    }
    /**
     * Get Dutiable value
     * @return DHLEnumDutiable|null
     */
    public function getDutiable()
    {
        return $this->Dutiable;
    }
    /**
     * Set Dutiable value
     * @uses DHLEnumDutiable::valueIsValid()
     * @param DHLEnumDutiable $_dutiable the Dutiable
     * @return DHLEnumDutiable
     */
    public function setDutiable($_dutiable)
    {
        if(!DHLEnumDutiable::valueIsValid($_dutiable))
        {
            return false;
        }
        return ($this->Dutiable = $_dutiable);
    }
    /**
     * Get DescriptionOfContent value
     * @return string|null
     */
    public function getDescriptionOfContent()
    {
        return $this->DescriptionOfContent;
    }
    /**
     * Set DescriptionOfContent value
     * @param string $_descriptionOfContent the DescriptionOfContent
     * @return string
     */
    public function setDescriptionOfContent($_descriptionOfContent)
    {
        return ($this->DescriptionOfContent = $_descriptionOfContent);
    }
    /**
     * Get AccountPaidBy value
     * @return DHLStructAccountPaidBy|null
     */
    public function getAccountPaidBy()
    {
        return $this->AccountPaidBy;
    }
    /**
     * Set AccountPaidBy value
     * @param DHLStructAccountPaidBy $_accountPaidBy the AccountPaidBy
     * @return DHLStructAccountPaidBy
     */
    public function setAccountPaidBy($_accountPaidBy)
    {
        return ($this->AccountPaidBy = $_accountPaidBy);
    }
    /**
     * Get ShipmentReference value
     * @return string|null
     */
    public function getShipmentReference()
    {
        return $this->ShipmentReference;
    }
    /**
     * Set ShipmentReference value
     * @param string $_shipmentReference the ShipmentReference
     * @return string
     */
    public function setShipmentReference($_shipmentReference)
    {
        return ($this->ShipmentReference = $_shipmentReference);
    }
    /**
     * Get TermsOfTrade value
     * @return string|null
     */
    public function getTermsOfTrade()
    {
        return $this->TermsOfTrade;
    }
    /**
     * Set TermsOfTrade value
     * @param string $_termsOfTrade the TermsOfTrade
     * @return string
     */
    public function setTermsOfTrade($_termsOfTrade)
    {
        return ($this->TermsOfTrade = $_termsOfTrade);
    }
    /**
     * Get ShipmentItem value
     * @return DHLStructShipmentItemTDType|null
     */
    public function getShipmentItem()
    {
        return $this->ShipmentItem;
    }
    /**
     * Set ShipmentItem value
     * @param DHLStructShipmentItemTDType $_shipmentItem the ShipmentItem
     * @return DHLStructShipmentItemTDType
     */
    public function setShipmentItem($_shipmentItem)
    {
        return ($this->ShipmentItem = $_shipmentItem);
    }
    /**
     * Get Service value
     * @return DHLStructShipmentServiceTD|null
     */
    public function getService()
    {
        return $this->Service;
    }
    /**
     * Set Service value
     * @param DHLStructShipmentServiceTD $_service the Service
     * @return DHLStructShipmentServiceTD
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentDetailsTDType
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
