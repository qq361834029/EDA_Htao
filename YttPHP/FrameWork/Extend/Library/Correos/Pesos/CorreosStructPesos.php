<?php
/**
 * File for class CorreosStructPesos
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructPesos originally named Pesos
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructPesos extends CorreosWsdlClass
{
    /**
     * The Peso
     * Meta informations extracted from the WSDL
     * - maxOccurs : 2
     * @var CorreosStructPESOTYPE
     */
    public $Peso;
    /**
     * Constructor method for Pesos
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosStructPESOTYPE $_peso
     * @return CorreosStructPesos
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Peso'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get Peso value
     * @return CorreosStructPESOTYPE|null
     */
    public function getPeso()
    {
        return $this->Peso;
    }
    /**
     * Set Peso value
     * @param CorreosStructPESOTYPE $_peso the Peso
     * @return CorreosStructPESOTYPE
     */
    public function setPeso($_peso)
    {
        return ($this->Peso = $_peso);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructPesos
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
