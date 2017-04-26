<?php
/**
 * File for class DHLStructIdentExtra
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructIdentExtra originally named IdentExtra
 * Documentation : Service to validate identity by means of two documents that can be of either DrivingLicense, IdentityCard, BankCard. The element ShipmentOrder.Shipment.Identity is mandatory, if IdentExtra is used. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructIdentExtra extends DHLWsdlClass
{
    /**
     * The Group1
     * Meta informations extracted from the WSDL
     * - documentation : The first one of two potential identity documents is selected in Group1.
     * @var DHLStructIdentityData
     */
    public $Group1;
    /**
     * The Group2
     * Meta informations extracted from the WSDL
     * - documentation : The second of two potential identity proofs is selected in Group2. Note: it cannot be the same instrument as the one chosen in Group1.Mandatory if service IdentExtra is chosen.
     * @var DHLStructIdentityData
     */
    public $Group2;
    /**
     * Constructor method for IdentExtra
     * @see parent::__construct()
     * @param DHLStructIdentityData $_group1
     * @param DHLStructIdentityData $_group2
     * @return DHLStructIdentExtra
     */
    public function __construct($_group1 = NULL,$_group2 = NULL)
    {
        parent::__construct(array('Group1'=>$_group1,'Group2'=>$_group2),false);
    }
    /**
     * Get Group1 value
     * @return DHLStructIdentityData|null
     */
    public function getGroup1()
    {
        return $this->Group1;
    }
    /**
     * Set Group1 value
     * @param DHLStructIdentityData $_group1 the Group1
     * @return DHLStructIdentityData
     */
    public function setGroup1($_group1)
    {
        return ($this->Group1 = $_group1);
    }
    /**
     * Get Group2 value
     * @return DHLStructIdentityData|null
     */
    public function getGroup2()
    {
        return $this->Group2;
    }
    /**
     * Set Group2 value
     * @param DHLStructIdentityData $_group2 the Group2
     * @return DHLStructIdentityData
     */
    public function setGroup2($_group2)
    {
        return ($this->Group2 = $_group2);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructIdentExtra
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
