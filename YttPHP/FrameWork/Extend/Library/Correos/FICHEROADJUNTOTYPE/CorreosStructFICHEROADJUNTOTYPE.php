<?php
/**
 * File for class CorreosStructFICHEROADJUNTOTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructFICHEROADJUNTOTYPE originally named FICHEROADJUNTOTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructFICHEROADJUNTOTYPE extends CorreosWsdlClass
{
    /**
     * The NombreF
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $NombreF;
    /**
     * The Tipo_Doc
     * @var CorreosEnumTipo_Doc
     */
    public $Tipo_Doc;
    /**
     * The Fichero
     * @var base64Binary
     */
    public $Fichero;
    /**
     * Constructor method for FICHEROADJUNTOTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_nombreF
     * CorreosEnumTipo_Doc $_tipo_Doc
     * base64Binary $_fichero
     * @return CorreosStructFICHEROADJUNTOTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'NombreF'	=> NULL,
			'Tipo_Doc'	=> NULL,
			'Fichero'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get NombreF value
     * @return string|null
     */
    public function getNombreF()
    {
        return $this->NombreF;
    }
    /**
     * Set NombreF value
     * @param string $_nombreF the NombreF
     * @return string
     */
    public function setNombreF($_nombreF)
    {
        return ($this->NombreF = $_nombreF);
    }
    /**
     * Get Tipo_Doc value
     * @return CorreosEnumTipo_Doc|null
     */
    public function getTipo_Doc()
    {
        return $this->Tipo_Doc;
    }
    /**
     * Set Tipo_Doc value
     * @uses CorreosEnumTipo_Doc::valueIsValid()
     * @param CorreosEnumTipo_Doc $_tipo_Doc the Tipo_Doc
     * @return CorreosEnumTipo_Doc
     */
    public function setTipo_Doc($_tipo_Doc)
    {
        if(!CorreosEnumTipo_Doc::valueIsValid($_tipo_Doc))
        {
            return false;
        }
        return ($this->Tipo_Doc = $_tipo_Doc);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructFICHEROADJUNTOTYPE
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
