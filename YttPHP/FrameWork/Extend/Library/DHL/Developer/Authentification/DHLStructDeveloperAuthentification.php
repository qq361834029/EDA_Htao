<?php
/**
 * File for class DHLStructDeveloperAuthentification
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDeveloperAuthentification originally named DeveloperAuthentification
 * Documentation : The developer authentification.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDeveloperAuthentification extends DHLWsdlClass
{
    /**
     * The DEVID
     * Meta informations extracted from the WSDL
     * - documentation : The developer id.
     * @var string
     */
    public $DEVID;
    /**
     * The APPID
     * Meta informations extracted from the WSDL
     * - documentation : The application id.
     * @var string
     */
    public $APPID;
    /**
     * The CERTID
     * Meta informations extracted from the WSDL
     * - documentation : The certification id.
     * @var string
     */
    public $CERTID;
    /**
     * Constructor method for DeveloperAuthentification
     * @see parent::__construct()
     * @param string $_dEVID
     * @param string $_aPPID
     * @param string $_cERTID
     * @return DHLStructDeveloperAuthentification
     */
    public function __construct($_dEVID = NULL,$_aPPID = NULL,$_cERTID = NULL)
    {
        parent::__construct(array('DEVID'=>$_dEVID,'APPID'=>$_aPPID,'CERTID'=>$_cERTID),false);
    }
    /**
     * Get DEVID value
     * @return string|null
     */
    public function getDEVID()
    {
        return $this->DEVID;
    }
    /**
     * Set DEVID value
     * @param string $_dEVID the DEVID
     * @return string
     */
    public function setDEVID($_dEVID)
    {
        return ($this->DEVID = $_dEVID);
    }
    /**
     * Get APPID value
     * @return string|null
     */
    public function getAPPID()
    {
        return $this->APPID;
    }
    /**
     * Set APPID value
     * @param string $_aPPID the APPID
     * @return string
     */
    public function setAPPID($_aPPID)
    {
        return ($this->APPID = $_aPPID);
    }
    /**
     * Get CERTID value
     * @return string|null
     */
    public function getCERTID()
    {
        return $this->CERTID;
    }
    /**
     * Set CERTID value
     * @param string $_cERTID the CERTID
     * @return string
     */
    public function setCERTID($_cERTID)
    {
        return ($this->CERTID = $_cERTID);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDeveloperAuthentification
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
