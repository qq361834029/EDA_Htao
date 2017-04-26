<?php
/**
 * File for class CorreosStructPRUEBAENTREGATYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructPRUEBAENTREGATYPE originally named PRUEBAENTREGATYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructPRUEBAENTREGATYPE extends CorreosWsdlClass
{
    /**
     * The Formato
     * @var CorreosEnumFormato
     */
    public $Formato;
    /**
     * The ReferenciaeAR
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 55
     * @var string
     */
    public $ReferenciaeAR;
    /**
     * The InfRemitenteEAr
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 350
     * @var string
     */
    public $InfRemitenteEAr;
    /**
     * Constructor method for PRUEBAENTREGATYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosEnumFormato $_formato
     * string $_referenciaeAR
     * string $_infRemitenteEAr
     * @return CorreosStructPRUEBAENTREGATYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Formato'			=> NULL,
			'ReferenciaeAR'		=> NULL,
			'InfRemitenteEAr'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get Formato value
     * @return CorreosEnumFormato|null
     */
    public function getFormato()
    {
        return $this->Formato;
    }
    /**
     * Set Formato value
     * @uses CorreosEnumFormato::valueIsValid()
     * @param CorreosEnumFormato $_formato the Formato
     * @return CorreosEnumFormato
     */
    public function setFormato($_formato)
    {
        if(!CorreosEnumFormato::valueIsValid($_formato))
        {
            return false;
        }
        return ($this->Formato = $_formato);
    }
    /**
     * Get ReferenciaeAR value
     * @return string|null
     */
    public function getReferenciaeAR()
    {
        return $this->ReferenciaeAR;
    }
    /**
     * Set ReferenciaeAR value
     * @param string $_referenciaeAR the ReferenciaeAR
     * @return string
     */
    public function setReferenciaeAR($_referenciaeAR)
    {
        return ($this->ReferenciaeAR = $_referenciaeAR);
    }
    /**
     * Get InfRemitenteEAr value
     * @return string|null
     */
    public function getInfRemitenteEAr()
    {
        return $this->InfRemitenteEAr;
    }
    /**
     * Set InfRemitenteEAr value
     * @param string $_infRemitenteEAr the InfRemitenteEAr
     * @return string
     */
    public function setInfRemitenteEAr($_infRemitenteEAr)
    {
        return ($this->InfRemitenteEAr = $_infRemitenteEAr);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructPRUEBAENTREGATYPE
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
