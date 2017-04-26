<?php
/**
 * File for class CorreosStructPESOTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructPESOTYPE originally named PESOTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructPESOTYPE extends CorreosWsdlClass
{
    /**
     * The TipoPeso
     * @var CorreosEnumTipoPeso
     */
    public $TipoPeso;
    /**
     * The Valor
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $Valor;
    /**
     * Constructor method for PESOTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosEnumTipoPeso $_tipoPeso
     * string $_valor
     * @return CorreosStructPESOTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'TipoPeso'	=> NULL,
			'Valor'		=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get TipoPeso value
     * @return CorreosEnumTipoPeso|null
     */
    public function getTipoPeso()
    {
        return $this->TipoPeso;
    }
    /**
     * Set TipoPeso value
     * @uses CorreosEnumTipoPeso::valueIsValid()
     * @param CorreosEnumTipoPeso $_tipoPeso the TipoPeso
     * @return CorreosEnumTipoPeso
     */
    public function setTipoPeso($_tipoPeso)
    {
        if(!CorreosEnumTipoPeso::valueIsValid($_tipoPeso))
        {
            return false;
        }
        return ($this->TipoPeso = $_tipoPeso);
    }
    /**
     * Get Valor value
     * @return string|null
     */
    public function getValor()
    {
        return $this->Valor;
    }
    /**
     * Set Valor value
     * @param string $_valor the Valor
     * @return string
     */
    public function setValor($_valor)
    {
        return ($this->Valor = $_valor);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructPESOTYPE
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
