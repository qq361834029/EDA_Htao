<?php
/**
 * File for class DHLStructCOD
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCOD originally named COD
 * Documentation : Cash on delivery service. Field length must be = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCOD extends DHLWsdlClass
{
    /**
     * The CODAmount
     * Meta informations extracted from the WSDL
     * - documentation : Money amount to be collected.Mandatory if COD is chosen. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $CODAmount;
    /**
     * The CODCurrency
     * Meta informations extracted from the WSDL
     * - documentation : Currency of cod amount.Mandatory if COD is chosen. Field length must be = 3.
     * @var string
     */
    public $CODCurrency;
    /**
     * Constructor method for COD
     * @see parent::__construct()
     * @param decimal $_cODAmount
     * @param string $_cODCurrency
     * @return DHLStructCOD
     */
    public function __construct($_cODAmount = NULL,$_cODCurrency = NULL)
    {
        parent::__construct(array('CODAmount'=>$_cODAmount,'CODCurrency'=>$_cODCurrency),false);
    }
    /**
     * Get CODAmount value
     * @return decimal|null
     */
    public function getCODAmount()
    {
        return $this->CODAmount;
    }
    /**
     * Set CODAmount value
     * @param decimal $_cODAmount the CODAmount
     * @return decimal
     */
    public function setCODAmount($_cODAmount)
    {
        return ($this->CODAmount = $_cODAmount);
    }
    /**
     * Get CODCurrency value
     * @return string|null
     */
    public function getCODCurrency()
    {
        return $this->CODCurrency;
    }
    /**
     * Set CODCurrency value
     * @param string $_cODCurrency the CODCurrency
     * @return string
     */
    public function setCODCurrency($_cODCurrency)
    {
        return ($this->CODCurrency = $_cODCurrency);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCOD
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
