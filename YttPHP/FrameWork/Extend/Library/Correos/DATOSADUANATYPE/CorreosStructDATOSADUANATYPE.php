<?php
/**
 * File for class CorreosStructDATOSADUANATYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDATOSADUANATYPE originally named DATOSADUANATYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDATOSADUANATYPE extends CorreosWsdlClass
{
    /**
     * The Cantidad
     * @var integer
     */
    public $Cantidad;
    /**
     * The Descripcion
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 3
     * @var string
     */
    public $Descripcion;
    /**
     * The Pesoneto
     * @var integer
     */
    public $Pesoneto;
    /**
     * The Valorneto
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 6
     * @var string
     */
    public $Valorneto;
    /**
     * The NTarifario
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 10
     * @var string
     */
    public $NTarifario;
    /**
     * The PaisOrigen
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $PaisOrigen;
    /**
     * Constructor method for DATOSADUANATYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
	 * integer $_cantidad
	 * string $_descripcion
     * integer $_pesoneto
     * string $_valorneto
     * string $_nTarifario
     * string $_paisOrigen
     * @return CorreosStructDATOSADUANATYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Cantidad'		=> NULL,
			'Descripcion'	=> NULL,
			'Pesoneto'		=> NULL,
			'Valorneto'		=> NULL,
			'NTarifario'	=> NULL,
			'PaisOrigen'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get Cantidad value
     * @return integer|null
     */
    public function getCantidad()
    {
        return $this->Cantidad;
    }
    /**
     * Set Cantidad value
     * @param integer $_cantidad the Cantidad
     * @return integer
     */
    public function setCantidad($_cantidad)
    {
        return ($this->Cantidad = $_cantidad);
    }
    /**
     * Get Descripcion value
     * @return string|null
     */
    public function getDescripcion()
    {
        return $this->Descripcion;
    }
    /**
     * Set Descripcion value
     * @param string $_descripcion the Descripcion
     * @return string
     */
    public function setDescripcion($_descripcion)
    {
        return ($this->Descripcion = $_descripcion);
    }
    /**
     * Get Pesoneto value
     * @return integer|null
     */
    public function getPesoneto()
    {
        return $this->Pesoneto;
    }
    /**
     * Set Pesoneto value
     * @param integer $_pesoneto the Pesoneto
     * @return integer
     */
    public function setPesoneto($_pesoneto)
    {
        return ($this->Pesoneto = $_pesoneto);
    }
    /**
     * Get Valorneto value
     * @return string|null
     */
    public function getValorneto()
    {
        return $this->Valorneto;
    }
    /**
     * Set Valorneto value
     * @param string $_valorneto the Valorneto
     * @return string
     */
    public function setValorneto($_valorneto)
    {
        return ($this->Valorneto = $_valorneto);
    }
    /**
     * Get NTarifario value
     * @return string|null
     */
    public function getNTarifario()
    {
        return $this->NTarifario;
    }
    /**
     * Set NTarifario value
     * @param string $_nTarifario the NTarifario
     * @return string
     */
    public function setNTarifario($_nTarifario)
    {
        return ($this->NTarifario = $_nTarifario);
    }
    /**
     * Get PaisOrigen value
     * @return string|null
     */
    public function getPaisOrigen()
    {
        return $this->PaisOrigen;
    }
    /**
     * Set PaisOrigen value
     * @param string $_paisOrigen the PaisOrigen
     * @return string
     */
    public function setPaisOrigen($_paisOrigen)
    {
        return ($this->PaisOrigen = $_paisOrigen);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDATOSADUANATYPE
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
