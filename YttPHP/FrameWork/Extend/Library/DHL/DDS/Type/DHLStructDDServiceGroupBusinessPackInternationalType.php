<?php
/**
 * File for class DHLStructDDServiceGroupBusinessPackInternationalType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDDServiceGroupBusinessPackInternationalType originally named DDServiceGroupBusinessPackInternationalType
 * Documentation : Service Group BPI.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDDServiceGroupBusinessPackInternationalType extends DHLWsdlClass
{
    /**
     * The Economy
     * Meta informations extracted from the WSDL
     * - documentation : Service Economy.
     * @var boolean
     */
    public $Economy;
    /**
     * The Premium
     * Meta informations extracted from the WSDL
     * - documentation : Premium for fast and safe delivery of international shipments.
     * @var boolean
     */
    public $Premium;
    /**
     * The Seapacket
     * Meta informations extracted from the WSDL
     * - documentation : Seapacket.
     * @var boolean
     */
    public $Seapacket;
    /**
     * The CoilWithoutHelp
     * Meta informations extracted from the WSDL
     * - documentation : Coil without help.
     * @var boolean
     */
    public $CoilWithoutHelp;
    /**
     * The Endorsement
     * @var DHLStructEndorsement
     */
    public $Endorsement;
    /**
     * The AmountInternational
     * Meta informations extracted from the WSDL
     * - documentation : Service to utilize higher insurance amount up to 25.000 EUR depending on delivery country.
     * @var boolean
     */
    public $AmountInternational;
    /**
     * Constructor method for DDServiceGroupBusinessPackInternationalType
     * @see parent::__construct()
     * @param boolean $_economy
     * @param boolean $_premium
     * @param boolean $_seapacket
     * @param boolean $_coilWithoutHelp
     * @param DHLStructEndorsement $_endorsement
     * @param boolean $_amountInternational
     * @return DHLStructDDServiceGroupBusinessPackInternationalType
     */
    public function __construct($_economy = NULL,$_premium = NULL,$_seapacket = NULL,$_coilWithoutHelp = NULL,$_endorsement = NULL,$_amountInternational = NULL)
    {
        parent::__construct(array('Economy'=>$_economy,'Premium'=>$_premium,'Seapacket'=>$_seapacket,'CoilWithoutHelp'=>$_coilWithoutHelp,'Endorsement'=>$_endorsement,'AmountInternational'=>$_amountInternational),false);
    }
    /**
     * Get Economy value
     * @return boolean|null
     */
    public function getEconomy()
    {
        return $this->Economy;
    }
    /**
     * Set Economy value
     * @param boolean $_economy the Economy
     * @return boolean
     */
    public function setEconomy($_economy)
    {
        return ($this->Economy = $_economy);
    }
    /**
     * Get Premium value
     * @return boolean|null
     */
    public function getPremium()
    {
        return $this->Premium;
    }
    /**
     * Set Premium value
     * @param boolean $_premium the Premium
     * @return boolean
     */
    public function setPremium($_premium)
    {
        return ($this->Premium = $_premium);
    }
    /**
     * Get Seapacket value
     * @return boolean|null
     */
    public function getSeapacket()
    {
        return $this->Seapacket;
    }
    /**
     * Set Seapacket value
     * @param boolean $_seapacket the Seapacket
     * @return boolean
     */
    public function setSeapacket($_seapacket)
    {
        return ($this->Seapacket = $_seapacket);
    }
    /**
     * Get CoilWithoutHelp value
     * @return boolean|null
     */
    public function getCoilWithoutHelp()
    {
        return $this->CoilWithoutHelp;
    }
    /**
     * Set CoilWithoutHelp value
     * @param boolean $_coilWithoutHelp the CoilWithoutHelp
     * @return boolean
     */
    public function setCoilWithoutHelp($_coilWithoutHelp)
    {
        return ($this->CoilWithoutHelp = $_coilWithoutHelp);
    }
    /**
     * Get Endorsement value
     * @return DHLStructEndorsement|null
     */
    public function getEndorsement()
    {
        return $this->Endorsement;
    }
    /**
     * Set Endorsement value
     * @param DHLStructEndorsement $_endorsement the Endorsement
     * @return DHLStructEndorsement
     */
    public function setEndorsement($_endorsement)
    {
        return ($this->Endorsement = $_endorsement);
    }
    /**
     * Get AmountInternational value
     * @return boolean|null
     */
    public function getAmountInternational()
    {
        return $this->AmountInternational;
    }
    /**
     * Set AmountInternational value
     * @param boolean $_amountInternational the AmountInternational
     * @return boolean
     */
    public function setAmountInternational($_amountInternational)
    {
        return ($this->AmountInternational = $_amountInternational);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDDServiceGroupBusinessPackInternationalType
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
