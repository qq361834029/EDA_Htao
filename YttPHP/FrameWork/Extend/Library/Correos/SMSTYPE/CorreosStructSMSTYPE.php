<?php
/**
 * File for class CorreosStructSMSTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructSMSTYPE originally named SMSTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructSMSTYPE extends CorreosWsdlClass
{
    /**
     * The NumeroSMS
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 12
     * @var string
     */
    public $NumeroSMS;
    /**
     * The Idioma
     * @var CorreosEnumIdioma
     */
    public $Idioma;
    /**
     * Constructor method for SMSTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_numeroSMS
     * CorreosEnumIdioma $_idioma
     * @return CorreosStructSMSTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'NumeroSMS'	=> NULL,
			'Idioma'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get NumeroSMS value
     * @return string|null
     */
    public function getNumeroSMS()
    {
        return $this->NumeroSMS;
    }
    /**
     * Set NumeroSMS value
     * @param string $_numeroSMS the NumeroSMS
     * @return string
     */
    public function setNumeroSMS($_numeroSMS)
    {
        return ($this->NumeroSMS = $_numeroSMS);
    }
    /**
     * Get Idioma value
     * @return CorreosEnumIdioma|null
     */
    public function getIdioma()
    {
        return $this->Idioma;
    }
    /**
     * Set Idioma value
     * @uses CorreosEnumIdioma::valueIsValid()
     * @param CorreosEnumIdioma $_idioma the Idioma
     * @return CorreosEnumIdioma
     */
    public function setIdioma($_idioma)
    {
        if(!CorreosEnumIdioma::valueIsValid($_idioma))
        {
            return false;
        }
        return ($this->Idioma = $_idioma);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructSMSTYPE
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
