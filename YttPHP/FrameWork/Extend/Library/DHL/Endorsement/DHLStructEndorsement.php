<?php
/**
 * File for class DHLStructEndorsement
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructEndorsement originally named Endorsement
 * Documentation : Service endorsement is used to specify handling if recipient not met. Field length must be = 1. Service "Vorausverfügung". Only valid for EPN.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructEndorsement extends DHLWsdlClass
{
    /**
     * The Ident
     * Meta informations extracted from the WSDL
     * - documentation : Obsolete field that is currently not in use.
     * @var string
     */
    public $Ident;
    /**
     * The Days
     * Meta informations extracted from the WSDL
     * - documentation : Specifies number of days that shipment will be held in business days before returned to sender.
     * @var integer
     */
    public $Days;
    /**
     * The UZN
     * Meta informations extracted from the WSDL
     * - documentation : Option Unzustellbarkeitsnachricht (UZN)
     * - minOccurs : 0
     * @var DHLStructEndorsementServiceconfiguration
     */
    public $UZN;
    /**
     * The KeNa
     * Meta informations extracted from the WSDL
     * - documentation : Option Keine Nachbarschaftszustellung (KeNa)
     * - minOccurs : 0
     * @var DHLStructEndorsementServiceconfiguration
     */
    public $KeNa;
    /**
     * The NSI
     * Meta informations extracted from the WSDL
     * - documentation : Option Nachsendeinformation (NSI)
     * - minOccurs : 0
     * @var DHLStructEndorsementServiceconfiguration
     */
    public $NSI;
    /**
     * The TeZu
     * Meta informations extracted from the WSDL
     * - documentation : Option Terminzustellung (TeZu)
     * - minOccurs : 0
     * @var DHLStructEndorsementServiceconfigurationTeZu
     */
    public $TeZu;
    /**
     * The SoZue
     * Meta informations extracted from the WSDL
     * - documentation : Option Sofort zurück (SoZue)
     * - minOccurs : 0
     * @var DHLStructEndorsementServiceconfiguration
     */
    public $SoZue;
    /**
     * Constructor method for Endorsement
     * @see parent::__construct()
     * @param string $_ident
     * @param integer $_days
     * @param DHLStructEndorsementServiceconfiguration $_uZN
     * @param DHLStructEndorsementServiceconfiguration $_keNa
     * @param DHLStructEndorsementServiceconfiguration $_nSI
     * @param DHLStructEndorsementServiceconfigurationTeZu $_teZu
     * @param DHLStructEndorsementServiceconfiguration $_soZue
     * @return DHLStructEndorsement
     */
    public function __construct($_ident = NULL,$_days = NULL,$_uZN = NULL,$_keNa = NULL,$_nSI = NULL,$_teZu = NULL,$_soZue = NULL)
    {
        parent::__construct(array('Ident'=>$_ident,'Days'=>$_days,'UZN'=>$_uZN,'KeNa'=>$_keNa,'NSI'=>$_nSI,'TeZu'=>$_teZu,'SoZue'=>$_soZue),false);
    }
    /**
     * Get Ident value
     * @return string|null
     */
    public function getIdent()
    {
        return $this->Ident;
    }
    /**
     * Set Ident value
     * @param string $_ident the Ident
     * @return string
     */
    public function setIdent($_ident)
    {
        return ($this->Ident = $_ident);
    }
    /**
     * Get Days value
     * @return integer|null
     */
    public function getDays()
    {
        return $this->Days;
    }
    /**
     * Set Days value
     * @param integer $_days the Days
     * @return integer
     */
    public function setDays($_days)
    {
        return ($this->Days = $_days);
    }
    /**
     * Get UZN value
     * @return DHLStructEndorsementServiceconfiguration|null
     */
    public function getUZN()
    {
        return $this->UZN;
    }
    /**
     * Set UZN value
     * @param DHLStructEndorsementServiceconfiguration $_uZN the UZN
     * @return DHLStructEndorsementServiceconfiguration
     */
    public function setUZN($_uZN)
    {
        return ($this->UZN = $_uZN);
    }
    /**
     * Get KeNa value
     * @return DHLStructEndorsementServiceconfiguration|null
     */
    public function getKeNa()
    {
        return $this->KeNa;
    }
    /**
     * Set KeNa value
     * @param DHLStructEndorsementServiceconfiguration $_keNa the KeNa
     * @return DHLStructEndorsementServiceconfiguration
     */
    public function setKeNa($_keNa)
    {
        return ($this->KeNa = $_keNa);
    }
    /**
     * Get NSI value
     * @return DHLStructEndorsementServiceconfiguration|null
     */
    public function getNSI()
    {
        return $this->NSI;
    }
    /**
     * Set NSI value
     * @param DHLStructEndorsementServiceconfiguration $_nSI the NSI
     * @return DHLStructEndorsementServiceconfiguration
     */
    public function setNSI($_nSI)
    {
        return ($this->NSI = $_nSI);
    }
    /**
     * Get TeZu value
     * @return DHLStructEndorsementServiceconfigurationTeZu|null
     */
    public function getTeZu()
    {
        return $this->TeZu;
    }
    /**
     * Set TeZu value
     * @param DHLStructEndorsementServiceconfigurationTeZu $_teZu the TeZu
     * @return DHLStructEndorsementServiceconfigurationTeZu
     */
    public function setTeZu($_teZu)
    {
        return ($this->TeZu = $_teZu);
    }
    /**
     * Get SoZue value
     * @return DHLStructEndorsementServiceconfiguration|null
     */
    public function getSoZue()
    {
        return $this->SoZue;
    }
    /**
     * Set SoZue value
     * @param DHLStructEndorsementServiceconfiguration $_soZue the SoZue
     * @return DHLStructEndorsementServiceconfiguration
     */
    public function setSoZue($_soZue)
    {
        return ($this->SoZue = $_soZue);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructEndorsement
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
