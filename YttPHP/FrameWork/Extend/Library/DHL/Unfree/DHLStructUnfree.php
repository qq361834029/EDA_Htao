<?php
/**
 * File for class DHLStructUnfree
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructUnfree originally named Unfree
 * Documentation : Service unfree, Receiver pays shipment fees. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructUnfree extends DHLWsdlClass
{
    /**
     * The PaymentType
     * @var DHLEnumPaymentType
     */
    public $PaymentType;
    /**
     * The CustomerNumber
     * Meta informations extracted from the WSDL
     * - documentation : Paid by third party, e.g. Receiver. DHL account number mandatory if PaymentType 1 = invoice is selected. Field length must be less than or equal to 10.
     * - minOccurs : 0
     * @var string
     */
    public $CustomerNumber;
    /**
     * Constructor method for Unfree
     * @see parent::__construct()
     * @param DHLEnumPaymentType $_paymentType
     * @param string $_customerNumber
     * @return DHLStructUnfree
     */
    public function __construct($_paymentType = NULL,$_customerNumber = NULL)
    {
        parent::__construct(array('PaymentType'=>$_paymentType,'CustomerNumber'=>$_customerNumber),false);
    }
    /**
     * Get PaymentType value
     * @return DHLEnumPaymentType|null
     */
    public function getPaymentType()
    {
        return $this->PaymentType;
    }
    /**
     * Set PaymentType value
     * @uses DHLEnumPaymentType::valueIsValid()
     * @param DHLEnumPaymentType $_paymentType the PaymentType
     * @return DHLEnumPaymentType
     */
    public function setPaymentType($_paymentType)
    {
        if(!DHLEnumPaymentType::valueIsValid($_paymentType))
        {
            return false;
        }
        return ($this->PaymentType = $_paymentType);
    }
    /**
     * Get CustomerNumber value
     * @return string|null
     */
    public function getCustomerNumber()
    {
        return $this->CustomerNumber;
    }
    /**
     * Set CustomerNumber value
     * @param string $_customerNumber the CustomerNumber
     * @return string
     */
    public function setCustomerNumber($_customerNumber)
    {
        return ($this->CustomerNumber = $_customerNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructUnfree
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
