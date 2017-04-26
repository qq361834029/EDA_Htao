<?php
/**
 * File for class CorreosStructERRORVALTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructERRORVALTYPE originally named ERRORVALTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructERRORVALTYPE extends CorreosWsdlClass
{
    /**
     * The Error
     * @var string
     */
    public $Error;
    /**
     * The DescError
     * @var string
     */
    public $DescError;
    /**
     * Constructor method for ERRORVALTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_error
     * string $_descError
     * @return CorreosStructERRORVALTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Error'		=> NULL,
			'DescError'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get Error value
     * @return string|null
     */
    public function getError()
    {
        return $this->Error;
    }
    /**
     * Set Error value
     * @param string $_error the Error
     * @return string
     */
    public function setError($_error)
    {
        return ($this->Error = $_error);
    }
    /**
     * Get DescError value
     * @return string|null
     */
    public function getDescError()
    {
        return $this->DescError;
    }
    /**
     * Set DescError value
     * @param string $_descError the DescError
     * @return string
     */
    public function setDescError($_descError)
    {
        return ($this->DescError = $_descError);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructERRORVALTYPE
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
