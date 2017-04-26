<?php
/**
 * File for class DHLStructTDServiceGroupOtherType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructTDServiceGroupOtherType originally named TDServiceGroupOtherType
 * Documentation : Other TD Services.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructTDServiceGroupOtherType extends DHLWsdlClass
{
    /**
     * The Insurance
     * @var DHLStructInsurance
     */
    public $Insurance;
    /**
     * The GoGreen
     * Meta informations extracted from the WSDL
     * - documentation : GoGreen Service.
     * @var boolean
     */
    public $GoGreen;
    /**
     * Constructor method for TDServiceGroupOtherType
     * @see parent::__construct()
     * @param DHLStructInsurance $_insurance
     * @param boolean $_goGreen
     * @return DHLStructTDServiceGroupOtherType
     */
    public function __construct($_insurance = NULL,$_goGreen = NULL)
    {
        parent::__construct(array('Insurance'=>$_insurance,'GoGreen'=>$_goGreen),false);
    }
    /**
     * Get Insurance value
     * @return DHLStructInsurance|null
     */
    public function getInsurance()
    {
        return $this->Insurance;
    }
    /**
     * Set Insurance value
     * @param DHLStructInsurance $_insurance the Insurance
     * @return DHLStructInsurance
     */
    public function setInsurance($_insurance)
    {
        return ($this->Insurance = $_insurance);
    }
    /**
     * Get GoGreen value
     * @return boolean|null
     */
    public function getGoGreen()
    {
        return $this->GoGreen;
    }
    /**
     * Set GoGreen value
     * @param boolean $_goGreen the GoGreen
     * @return boolean
     */
    public function setGoGreen($_goGreen)
    {
        return ($this->GoGreen = $_goGreen);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructTDServiceGroupOtherType
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
