<?php
/**
 * File for class CorreosStructRespuestaSolicitudDocumentacionAduaneraCN23CP71
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructRespuestaSolicitudDocumentacionAduaneraCN23CP71 originally named RespuestaSolicitudDocumentacionAduaneraCN23CP71
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructRespuestaSolicitudDocumentacionAduaneraCN23CP71 extends CorreosWsdlClass
{
    /**
     * The Fichero
     * @var base64Binary
     */
    public $Fichero;
    /**
     * The Resultado
     * @var CorreosEnumResultado
     */
    public $Resultado;
    /**
     * The MotivoError
     * @var string
     */
    public $MotivoError;
    /**
     * Constructor method for RespuestaSolicitudDocumentacionAduaneraCN23CP71
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * base64Binary $_fichero
     * CorreosEnumResultado $_resultado
     * string $_motivoError
     * @return CorreosStructRespuestaSolicitudDocumentacionAduaneraCN23CP71
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Fichero'		=> NULL,
			'Resultado'		=> NULL,
			'MotivoError'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get Fichero value
     * @return base64Binary|null
     */
    public function getFichero()
    {
        return $this->Fichero;
    }
    /**
     * Set Fichero value
     * @param base64Binary $_fichero the Fichero
     * @return base64Binary
     */
    public function setFichero($_fichero)
    {
        return ($this->Fichero = $_fichero);
    }
    /**
     * Get Resultado value
     * @return CorreosEnumResultado|null
     */
    public function getResultado()
    {
        return $this->Resultado;
    }
    /**
     * Set Resultado value
     * @uses CorreosEnumResultado::valueIsValid()
     * @param CorreosEnumResultado $_resultado the Resultado
     * @return CorreosEnumResultado
     */
    public function setResultado($_resultado)
    {
        if(!CorreosEnumResultado::valueIsValid($_resultado))
        {
            return false;
        }
        return ($this->Resultado = $_resultado);
    }
    /**
     * Get MotivoError value
     * @return string|null
     */
    public function getMotivoError()
    {
        return $this->MotivoError;
    }
    /**
     * Set MotivoError value
     * @param string $_motivoError the MotivoError
     * @return string
     */
    public function setMotivoError($_motivoError)
    {
        return ($this->MotivoError = $_motivoError);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructRespuestaSolicitudDocumentacionAduaneraCN23CP71
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
