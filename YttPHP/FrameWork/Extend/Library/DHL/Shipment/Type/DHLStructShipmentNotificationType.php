<?php
/**
 * File for class DHLStructShipmentNotificationType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentNotificationType originally named ShipmentNotificationType
 * Documentation : Notification type
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentNotificationType extends DHLWsdlClass
{
    /**
     * The RecipientName
     * Meta informations extracted from the WSDL
     * - documentation : Name of the email recipient. Mandatory if Notification is set. Field length must be less than or equal to 45.
     * @var string
     */
    public $RecipientName;
    /**
     * The RecipientEmailAddress
     * Meta informations extracted from the WSDL
     * - documentation : Email address of the recipient. Mandatory if Notification is set. Field length must be less than or equal to 20.
     * @var string
     */
    public $RecipientEmailAddress;
    /**
     * Constructor method for ShipmentNotificationType
     * @see parent::__construct()
     * @param string $_recipientName
     * @param string $_recipientEmailAddress
     * @return DHLStructShipmentNotificationType
     */
    public function __construct($_recipientName = NULL,$_recipientEmailAddress = NULL)
    {
        parent::__construct(array('RecipientName'=>$_recipientName,'RecipientEmailAddress'=>$_recipientEmailAddress),false);
    }
    /**
     * Get RecipientName value
     * @return string|null
     */
    public function getRecipientName()
    {
        return $this->RecipientName;
    }
    /**
     * Set RecipientName value
     * @param string $_recipientName the RecipientName
     * @return string
     */
    public function setRecipientName($_recipientName)
    {
        return ($this->RecipientName = $_recipientName);
    }
    /**
     * Get RecipientEmailAddress value
     * @return string|null
     */
    public function getRecipientEmailAddress()
    {
        return $this->RecipientEmailAddress;
    }
    /**
     * Set RecipientEmailAddress value
     * @param string $_recipientEmailAddress the RecipientEmailAddress
     * @return string
     */
    public function setRecipientEmailAddress($_recipientEmailAddress)
    {
        return ($this->RecipientEmailAddress = $_recipientEmailAddress);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentNotificationType
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
