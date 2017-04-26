<?php
/**
 * File for class CorreosStructDATOSBULTOTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDATOSBULTOTYPE originally named DATOSBULTOTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDATOSBULTOTYPE extends CorreosWsdlClass
{
    /**
     * The NumBulto
     * @var integer
     */
    public $NumBulto;
    /**
     * The CodEnvio
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 23
     * @var string
     */
    public $CodEnvio;
    /**
     * The CodManifiesto
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 24
     * @var string
     */
    public $CodManifiesto;
    /**
     * The Etiqueta
     * @var CorreosStructETIQUETATYPE
     */
    public $Etiqueta;
    /**
     * Constructor method for DATOSBULTOTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * integer $_numBulto
     * string $_codEnvio
     * string $_codManifiesto
     * CorreosStructETIQUETATYPE $_etiqueta
     * @return CorreosStructDATOSBULTOTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'NumBulto'		=> NULL,
			'CodEnvio'		=> NULL,
			'CodManifiesto'	=> NULL,
			'Etiqueta'		=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get NumBulto value
     * @return integer|null
     */
    public function getNumBulto()
    {
        return $this->NumBulto;
    }
    /**
     * Set NumBulto value
     * @param integer $_numBulto the NumBulto
     * @return integer
     */
    public function setNumBulto($_numBulto)
    {
        return ($this->NumBulto = $_numBulto);
    }
    /**
     * Get CodEnvio value
     * @return string|null
     */
    public function getCodEnvio()
    {
        return $this->CodEnvio;
    }
    /**
     * Set CodEnvio value
     * @param string $_codEnvio the CodEnvio
     * @return string
     */
    public function setCodEnvio($_codEnvio)
    {
        return ($this->CodEnvio = $_codEnvio);
    }
    /**
     * Get CodManifiesto value
     * @return string|null
     */
    public function getCodManifiesto()
    {
        return $this->CodManifiesto;
    }
    /**
     * Set CodManifiesto value
     * @param string $_codManifiesto the CodManifiesto
     * @return string
     */
    public function setCodManifiesto($_codManifiesto)
    {
        return ($this->CodManifiesto = $_codManifiesto);
    }
    /**
     * Get Etiqueta value
     * @return CorreosStructETIQUETATYPE|null
     */
    public function getEtiqueta()
    {
        return $this->Etiqueta;
    }
    /**
     * Set Etiqueta value
     * @param CorreosStructETIQUETATYPE $_etiqueta the Etiqueta
     * @return CorreosStructETIQUETATYPE
     */
    public function setEtiqueta($_etiqueta)
    {
        return ($this->Etiqueta = $_etiqueta);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDATOSBULTOTYPE
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
