<?php
/**
 * File for class DHLStructStatusinformation
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructStatusinformation originally named Statusinformation
 * Documentation : The status information used in different situations.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructStatusinformation extends DHLWsdlClass
{
    /**
     * The StatusCode
     * Meta informations extracted from the WSDL
     * - documentation : Overall status of the entire request: A value of zero means, the request was processed without error. A value greater than zero indicates that an error occurred. The detailed mapping and explanation of returned status codes is contained in the list.
     * @var integer
     */
    public $StatusCode;
    /**
     * The StatusMessage
     * Meta informations extracted from the WSDL
     * - documentation : Explanation of the statuscode and potential errors.
     * @var string
     */
    public $StatusMessage;
    /**
     * Constructor method for Statusinformation
     * @see parent::__construct()
     * @param integer $_statusCode
     * @param string $_statusMessage
     * @return DHLStructStatusinformation
     */
    public function __construct($_statusCode = NULL,$_statusMessage = NULL)
    {
        parent::__construct(array('StatusCode'=>$_statusCode,'StatusMessage'=>$_statusMessage),false);
    }
    /**
     * Get StatusCode value
     * @return integer|null
     */
    public function getStatusCode()
    {
        return $this->StatusCode;
    }
    /**
     * Set StatusCode value
     * @param integer $_statusCode the StatusCode
     * @return integer
     */
    public function setStatusCode($_statusCode)
    {
        return ($this->StatusCode = $_statusCode);
    }
    /**
     * Get StatusMessage value
     * @return string|null
     */
    public function getStatusMessage()
    {
        return $this->StatusMessage;
    }
    /**
     * Set StatusMessage value
     * @param string $_statusMessage the StatusMessage
     * @return string
     */
    public function setStatusMessage($_statusMessage)
    {
        return ($this->StatusMessage = $_statusMessage);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructStatusinformation
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
