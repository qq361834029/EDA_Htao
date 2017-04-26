<?php
/**
 * File for class DHLStructIdentityCard
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructIdentityCard originally named IdentityCard
 * Documentation : If identity card shall be used for verifying identity.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructIdentityCard extends DHLWsdlClass
{
    /**
     * The CardNumber
     * Meta informations extracted from the WSDL
     * - documentation : Number of the identity card.Mandatory if IdentityCard is chosen as identity instrument. Field length must be less than or equal to 20.
     * @var string
     */
    public $CardNumber;
    /**
     * The CardAuthority
     * Meta informations extracted from the WSDL
     * - documentation : Name of certifying card authority. Mandatory if IdentityCard is chosen as identity instrument. Field length must be less than or equal to 30.
     * @var string
     */
    public $CardAuthority;
    /**
     * Constructor method for IdentityCard
     * @see parent::__construct()
     * @param string $_cardNumber
     * @param string $_cardAuthority
     * @return DHLStructIdentityCard
     */
    public function __construct($_cardNumber = NULL,$_cardAuthority = NULL)
    {
        parent::__construct(array('CardNumber'=>$_cardNumber,'CardAuthority'=>$_cardAuthority),false);
    }
    /**
     * Get CardNumber value
     * @return string|null
     */
    public function getCardNumber()
    {
        return $this->CardNumber;
    }
    /**
     * Set CardNumber value
     * @param string $_cardNumber the CardNumber
     * @return string
     */
    public function setCardNumber($_cardNumber)
    {
        return ($this->CardNumber = $_cardNumber);
    }
    /**
     * Get CardAuthority value
     * @return string|null
     */
    public function getCardAuthority()
    {
        return $this->CardAuthority;
    }
    /**
     * Set CardAuthority value
     * @param string $_cardAuthority the CardAuthority
     * @return string
     */
    public function setCardAuthority($_cardAuthority)
    {
        return ($this->CardAuthority = $_cardAuthority);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructIdentityCard
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
