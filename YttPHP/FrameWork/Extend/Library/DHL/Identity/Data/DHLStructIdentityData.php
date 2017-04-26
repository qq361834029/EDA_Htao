<?php
/**
 * File for class DHLStructIdentityData
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructIdentityData originally named IdentityData
 * Documentation : Identity data (used e.g. for ident services)
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructIdentityData extends DHLWsdlClass
{
    /**
     * The DrivingLicense
     * @var DHLStructDrivingLicense
     */
    public $DrivingLicense;
    /**
     * The IdentityCard
     * @var DHLStructIdentityCard
     */
    public $IdentityCard;
    /**
     * The BankCard
     * @var DHLStructBankCard
     */
    public $BankCard;
    /**
     * Constructor method for IdentityData
     * @see parent::__construct()
     * @param DHLStructDrivingLicense $_drivingLicense
     * @param DHLStructIdentityCard $_identityCard
     * @param DHLStructBankCard $_bankCard
     * @return DHLStructIdentityData
     */
    public function __construct($_drivingLicense = NULL,$_identityCard = NULL,$_bankCard = NULL)
    {
        parent::__construct(array('DrivingLicense'=>$_drivingLicense,'IdentityCard'=>$_identityCard,'BankCard'=>$_bankCard),false);
    }
    /**
     * Get DrivingLicense value
     * @return DHLStructDrivingLicense|null
     */
    public function getDrivingLicense()
    {
        return $this->DrivingLicense;
    }
    /**
     * Set DrivingLicense value
     * @param DHLStructDrivingLicense $_drivingLicense the DrivingLicense
     * @return DHLStructDrivingLicense
     */
    public function setDrivingLicense($_drivingLicense)
    {
        return ($this->DrivingLicense = $_drivingLicense);
    }
    /**
     * Get IdentityCard value
     * @return DHLStructIdentityCard|null
     */
    public function getIdentityCard()
    {
        return $this->IdentityCard;
    }
    /**
     * Set IdentityCard value
     * @param DHLStructIdentityCard $_identityCard the IdentityCard
     * @return DHLStructIdentityCard
     */
    public function setIdentityCard($_identityCard)
    {
        return ($this->IdentityCard = $_identityCard);
    }
    /**
     * Get BankCard value
     * @return DHLStructBankCard|null
     */
    public function getBankCard()
    {
        return $this->BankCard;
    }
    /**
     * Set BankCard value
     * @param DHLStructBankCard $_bankCard the BankCard
     * @return DHLStructBankCard
     */
    public function setBankCard($_bankCard)
    {
        return ($this->BankCard = $_bankCard);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructIdentityData
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
