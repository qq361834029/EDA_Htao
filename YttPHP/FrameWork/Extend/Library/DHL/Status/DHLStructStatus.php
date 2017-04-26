<?php
/**
 * File for class DHLStructStatus
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructStatus originally named Status
 * Documentation : part of webservice response includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructStatus extends DHLWsdlClass
{
    /**
     * The statuscode
     * Meta informations extracted from the WSDL
     * - documentation : statuscode value.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * @var string
     */
    public $statuscode;
    /**
     * The statusDescription
     * Meta informations extracted from the WSDL
     * - documentation : description corresponding to the statuscode
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 500
     * @var string
     */
    public $statusDescription;
    /**
     * Constructor method for Status
     * @see parent::__construct()
     * @param string $_statuscode
     * @param string $_statusDescription
     * @return DHLStructStatus
     */
    public function __construct($_statuscode = NULL,$_statusDescription = NULL)
    {
        parent::__construct(array('statuscode'=>$_statuscode,'statusDescription'=>$_statusDescription),false);
    }
    /**
     * Get statuscode value
     * @return string|null
     */
    public function getStatuscode()
    {
        return $this->statuscode;
    }
    /**
     * Set statuscode value
     * @param string $_statuscode the statuscode
     * @return string
     */
    public function setStatuscode($_statuscode)
    {
        return ($this->statuscode = $_statuscode);
    }
    /**
     * Get statusDescription value
     * @return string|null
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }
    /**
     * Set statusDescription value
     * @param string $_statusDescription the statusDescription
     * @return string
     */
    public function setStatusDescription($_statusDescription)
    {
        return ($this->statusDescription = $_statusDescription);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructStatus
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
