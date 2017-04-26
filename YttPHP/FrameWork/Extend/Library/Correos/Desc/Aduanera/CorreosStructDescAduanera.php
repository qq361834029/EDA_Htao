<?php
/**
 * File for class CorreosStructDescAduanera
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDescAduanera originally named DescAduanera
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDescAduanera extends CorreosWsdlClass
{
    /**
     * The DATOSADUANA
     * Meta informations extracted from the WSDL
     * - maxOccurs : 3
     * @var CorreosStructDATOSADUANATYPE
     */
    public $DATOSADUANA;
    /**
     * Constructor method for DescAduanera
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosStructDATOSADUANATYPE $_dATOSADUANA
     * @return CorreosStructDescAduanera
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'DATOSADUANA'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get DATOSADUANA value
     * @return CorreosStructDATOSADUANATYPE|null
     */
    public function getDATOSADUANA()
    {
        return $this->DATOSADUANA;
    }
    /**
     * Set DATOSADUANA value
     * @param CorreosStructDATOSADUANATYPE $_dATOSADUANA the DATOSADUANA
     * @return CorreosStructDATOSADUANATYPE
     */
    public function setDATOSADUANA($_dATOSADUANA)
    {
        return ($this->DATOSADUANA = $_dATOSADUANA);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDescAduanera
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
