<?php
/**
 * File for class CorreosStructLISTAERRORESVALIDACIONTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructLISTAERRORESVALIDACIONTYPE originally named LISTAERRORESVALIDACIONTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructLISTAERRORESVALIDACIONTYPE extends CorreosWsdlClass
{
    /**
     * The ErrorVal
     * @var CorreosStructERRORVALTYPE
     */
    public $ErrorVal;
    /**
     * Constructor method for LISTAERRORESVALIDACIONTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosStructERRORVALTYPE $_errorVal
     * @return CorreosStructLISTAERRORESVALIDACIONTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'ErrorVal'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get ErrorVal value
     * @return CorreosStructERRORVALTYPE|null
     */
    public function getErrorVal()
    {
        return $this->ErrorVal;
    }
    /**
     * Set ErrorVal value
     * @param CorreosStructERRORVALTYPE $_errorVal the ErrorVal
     * @return CorreosStructERRORVALTYPE
     */
    public function setErrorVal($_errorVal)
    {
        return ($this->ErrorVal = $_errorVal);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructLISTAERRORESVALIDACIONTYPE
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
