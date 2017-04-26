<?php
/**
 * File for class DHLStructDDShipmentServiceGroupIdentType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDDShipmentServiceGroupIdentType originally named DDShipmentServiceGroupIdentType
 * Documentation : Service Group Ident.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDDShipmentServiceGroupIdentType extends DHLWsdlClass
{
    /**
     * The Ident
     * @var DHLStructIdent
     */
    public $Ident;
    /**
     * The IdentExtra
     * @var DHLStructIdentExtra
     */
    public $IdentExtra;
    /**
     * The IdentPremium
     * @var DHLStructIdentPremium
     */
    public $IdentPremium;
    /**
     * The Personally
     * Meta informations extracted from the WSDL
     * - documentation : Invoke service personal handover.
     * @var boolean
     */
    public $Personally;
    /**
     * The ReturnReceipt
     * Meta informations extracted from the WSDL
     * - documentation : Invoke service return receipt.
     * @var boolean
     */
    public $ReturnReceipt;
    /**
     * The ProofOfDelivery
     * Meta informations extracted from the WSDL
     * - documentation : Invoke service proof of delivery.
     * @var boolean
     */
    public $ProofOfDelivery;
    /**
     * The ContractSubmission
     * @var DHLStructContractSubmission
     */
    public $ContractSubmission;
    /**
     * The SMSAviso
     * @var DHLStructSMSAviso
     */
    public $SMSAviso;
    /**
     * The CheckMinimumAge
     * @var DHLStructCheckMinimumAge
     */
    public $CheckMinimumAge;
    /**
     * Constructor method for DDShipmentServiceGroupIdentType
     * @see parent::__construct()
     * @param DHLStructIdent $_ident
     * @param DHLStructIdentExtra $_identExtra
     * @param DHLStructIdentPremium $_identPremium
     * @param boolean $_personally
     * @param boolean $_returnReceipt
     * @param boolean $_proofOfDelivery
     * @param DHLStructContractSubmission $_contractSubmission
     * @param DHLStructSMSAviso $_sMSAviso
     * @param DHLStructCheckMinimumAge $_checkMinimumAge
     * @return DHLStructDDShipmentServiceGroupIdentType
     */
    public function __construct($_ident = NULL,$_identExtra = NULL,$_identPremium = NULL,$_personally = NULL,$_returnReceipt = NULL,$_proofOfDelivery = NULL,$_contractSubmission = NULL,$_sMSAviso = NULL,$_checkMinimumAge = NULL)
    {
        parent::__construct(array('Ident'=>$_ident,'IdentExtra'=>$_identExtra,'IdentPremium'=>$_identPremium,'Personally'=>$_personally,'ReturnReceipt'=>$_returnReceipt,'ProofOfDelivery'=>$_proofOfDelivery,'ContractSubmission'=>$_contractSubmission,'SMSAviso'=>$_sMSAviso,'CheckMinimumAge'=>$_checkMinimumAge),false);
    }
    /**
     * Get Ident value
     * @return DHLStructIdent|null
     */
    public function getIdent()
    {
        return $this->Ident;
    }
    /**
     * Set Ident value
     * @param DHLStructIdent $_ident the Ident
     * @return DHLStructIdent
     */
    public function setIdent($_ident)
    {
        return ($this->Ident = $_ident);
    }
    /**
     * Get IdentExtra value
     * @return DHLStructIdentExtra|null
     */
    public function getIdentExtra()
    {
        return $this->IdentExtra;
    }
    /**
     * Set IdentExtra value
     * @param DHLStructIdentExtra $_identExtra the IdentExtra
     * @return DHLStructIdentExtra
     */
    public function setIdentExtra($_identExtra)
    {
        return ($this->IdentExtra = $_identExtra);
    }
    /**
     * Get IdentPremium value
     * @return DHLStructIdentPremium|null
     */
    public function getIdentPremium()
    {
        return $this->IdentPremium;
    }
    /**
     * Set IdentPremium value
     * @param DHLStructIdentPremium $_identPremium the IdentPremium
     * @return DHLStructIdentPremium
     */
    public function setIdentPremium($_identPremium)
    {
        return ($this->IdentPremium = $_identPremium);
    }
    /**
     * Get Personally value
     * @return boolean|null
     */
    public function getPersonally()
    {
        return $this->Personally;
    }
    /**
     * Set Personally value
     * @param boolean $_personally the Personally
     * @return boolean
     */
    public function setPersonally($_personally)
    {
        return ($this->Personally = $_personally);
    }
    /**
     * Get ReturnReceipt value
     * @return boolean|null
     */
    public function getReturnReceipt()
    {
        return $this->ReturnReceipt;
    }
    /**
     * Set ReturnReceipt value
     * @param boolean $_returnReceipt the ReturnReceipt
     * @return boolean
     */
    public function setReturnReceipt($_returnReceipt)
    {
        return ($this->ReturnReceipt = $_returnReceipt);
    }
    /**
     * Get ProofOfDelivery value
     * @return boolean|null
     */
    public function getProofOfDelivery()
    {
        return $this->ProofOfDelivery;
    }
    /**
     * Set ProofOfDelivery value
     * @param boolean $_proofOfDelivery the ProofOfDelivery
     * @return boolean
     */
    public function setProofOfDelivery($_proofOfDelivery)
    {
        return ($this->ProofOfDelivery = $_proofOfDelivery);
    }
    /**
     * Get ContractSubmission value
     * @return DHLStructContractSubmission|null
     */
    public function getContractSubmission()
    {
        return $this->ContractSubmission;
    }
    /**
     * Set ContractSubmission value
     * @param DHLStructContractSubmission $_contractSubmission the ContractSubmission
     * @return DHLStructContractSubmission
     */
    public function setContractSubmission($_contractSubmission)
    {
        return ($this->ContractSubmission = $_contractSubmission);
    }
    /**
     * Get SMSAviso value
     * @return DHLStructSMSAviso|null
     */
    public function getSMSAviso()
    {
        return $this->SMSAviso;
    }
    /**
     * Set SMSAviso value
     * @param DHLStructSMSAviso $_sMSAviso the SMSAviso
     * @return DHLStructSMSAviso
     */
    public function setSMSAviso($_sMSAviso)
    {
        return ($this->SMSAviso = $_sMSAviso);
    }
    /**
     * Get CheckMinimumAge value
     * @return DHLStructCheckMinimumAge|null
     */
    public function getCheckMinimumAge()
    {
        return $this->CheckMinimumAge;
    }
    /**
     * Set CheckMinimumAge value
     * @param DHLStructCheckMinimumAge $_checkMinimumAge the CheckMinimumAge
     * @return DHLStructCheckMinimumAge
     */
    public function setCheckMinimumAge($_checkMinimumAge)
    {
        return ($this->CheckMinimumAge = $_checkMinimumAge);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDDShipmentServiceGroupIdentType
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
