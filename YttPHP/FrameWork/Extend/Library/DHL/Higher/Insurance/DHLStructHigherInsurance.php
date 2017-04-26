<?php
/**
 * File for class DHLStructHigherInsurance
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructHigherInsurance originally named HigherInsurance
 * Documentation : Insure shipment with higher than standard amount. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructHigherInsurance extends DHLWsdlClass
{
    /**
     * The InsuranceAmount
     * Meta informations extracted from the WSDL
     * - documentation : If Insurance is set, insurance amount must be passed. Field length must be less than or equal to 22. To book either one of the two insurance options field must contain either "2500" or "25000" exactly.Mandatory if HigherInsurance is chosen.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $InsuranceAmount;
    /**
     * The InsuranceCurrency
     * Meta informations extracted from the WSDL
     * - documentation : Currency of insurance.Mandatory if HigherInsurance is chosen.
     * @var string
     */
    public $InsuranceCurrency;
    /**
     * Constructor method for HigherInsurance
     * @see parent::__construct()
     * @param decimal $_insuranceAmount
     * @param string $_insuranceCurrency
     * @return DHLStructHigherInsurance
     */
    public function __construct($_insuranceAmount = NULL,$_insuranceCurrency = NULL)
    {
        parent::__construct(array('InsuranceAmount'=>$_insuranceAmount,'InsuranceCurrency'=>$_insuranceCurrency),false);
    }
    /**
     * Get InsuranceAmount value
     * @return decimal|null
     */
    public function getInsuranceAmount()
    {
        return $this->InsuranceAmount;
    }
    /**
     * Set InsuranceAmount value
     * @param decimal $_insuranceAmount the InsuranceAmount
     * @return decimal
     */
    public function setInsuranceAmount($_insuranceAmount)
    {
        return ($this->InsuranceAmount = $_insuranceAmount);
    }
    /**
     * Get InsuranceCurrency value
     * @return string|null
     */
    public function getInsuranceCurrency()
    {
        return $this->InsuranceCurrency;
    }
    /**
     * Set InsuranceCurrency value
     * @param string $_insuranceCurrency the InsuranceCurrency
     * @return string
     */
    public function setInsuranceCurrency($_insuranceCurrency)
    {
        return ($this->InsuranceCurrency = $_insuranceCurrency);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructHigherInsurance
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
