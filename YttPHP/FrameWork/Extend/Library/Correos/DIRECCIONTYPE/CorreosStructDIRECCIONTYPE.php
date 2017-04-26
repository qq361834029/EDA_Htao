<?php
/**
 * File for class CorreosStructDIRECCIONTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDIRECCIONTYPE originally named DIRECCIONTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDIRECCIONTYPE extends CorreosWsdlClass
{
    /**
     * The TipoDireccion
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 3
     * @var string
     */
    public $TipoDireccion;
    /**
     * The Direccion
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $Direccion;
    /**
     * The Numero
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $Numero;
    /**
     * The Portal
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $Portal;
    /**
     * The Bloque
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $Bloque;
    /**
     * The Escalera
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $Escalera;
    /**
     * The Piso
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $Piso;
    /**
     * The Puerta
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $Puerta;
    /**
     * The Localidad
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $Localidad;
    /**
     * The Provincia
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 40
     * @var string
     */
    public $Provincia;
    /**
     * Constructor method for DIRECCIONTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_tipoDireccion
     * string $_direccion
     * string $_numero
     * string $_portal
     * string $_bloque
     * string $_escalera
     * string $_piso
     * string $_puerta
     * string $_localidad
     * string $_provincia
     * @return CorreosStructDIRECCIONTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'TipoDireccion'	=> NULL,
			'Direccion'		=> NULL,
			'Numero'		=> NULL,
			'Portal'		=> NULL,
			'Bloque'		=> NULL,
			'Escalera'		=> NULL,
			'Piso'			=> NULL,
			'Puerta'		=> NULL,
			'Localidad'		=> NULL,
			'Provincia'		=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get TipoDireccion value
     * @return string|null
     */
    public function getTipoDireccion()
    {
        return $this->TipoDireccion;
    }
    /**
     * Set TipoDireccion value
     * @param string $_tipoDireccion the TipoDireccion
     * @return string
     */
    public function setTipoDireccion($_tipoDireccion)
    {
        return ($this->TipoDireccion = $_tipoDireccion);
    }
    /**
     * Get Direccion value
     * @return string|null
     */
    public function getDireccion()
    {
        return $this->Direccion;
    }
    /**
     * Set Direccion value
     * @param string $_direccion the Direccion
     * @return string
     */
    public function setDireccion($_direccion)
    {
        return ($this->Direccion = $_direccion);
    }
    /**
     * Get Numero value
     * @return string|null
     */
    public function getNumero()
    {
        return $this->Numero;
    }
    /**
     * Set Numero value
     * @param string $_numero the Numero
     * @return string
     */
    public function setNumero($_numero)
    {
        return ($this->Numero = $_numero);
    }
    /**
     * Get Portal value
     * @return string|null
     */
    public function getPortal()
    {
        return $this->Portal;
    }
    /**
     * Set Portal value
     * @param string $_portal the Portal
     * @return string
     */
    public function setPortal($_portal)
    {
        return ($this->Portal = $_portal);
    }
    /**
     * Get Bloque value
     * @return string|null
     */
    public function getBloque()
    {
        return $this->Bloque;
    }
    /**
     * Set Bloque value
     * @param string $_bloque the Bloque
     * @return string
     */
    public function setBloque($_bloque)
    {
        return ($this->Bloque = $_bloque);
    }
    /**
     * Get Escalera value
     * @return string|null
     */
    public function getEscalera()
    {
        return $this->Escalera;
    }
    /**
     * Set Escalera value
     * @param string $_escalera the Escalera
     * @return string
     */
    public function setEscalera($_escalera)
    {
        return ($this->Escalera = $_escalera);
    }
    /**
     * Get Piso value
     * @return string|null
     */
    public function getPiso()
    {
        return $this->Piso;
    }
    /**
     * Set Piso value
     * @param string $_piso the Piso
     * @return string
     */
    public function setPiso($_piso)
    {
        return ($this->Piso = $_piso);
    }
    /**
     * Get Puerta value
     * @return string|null
     */
    public function getPuerta()
    {
        return $this->Puerta;
    }
    /**
     * Set Puerta value
     * @param string $_puerta the Puerta
     * @return string
     */
    public function setPuerta($_puerta)
    {
        return ($this->Puerta = $_puerta);
    }
    /**
     * Get Localidad value
     * @return string|null
     */
    public function getLocalidad()
    {
        return $this->Localidad;
    }
    /**
     * Set Localidad value
     * @param string $_localidad the Localidad
     * @return string
     */
    public function setLocalidad($_localidad)
    {
        return ($this->Localidad = $_localidad);
    }
    /**
     * Get Provincia value
     * @return string|null
     */
    public function getProvincia()
    {
        return $this->Provincia;
    }
    /**
     * Set Provincia value
     * @param string $_provincia the Provincia
     * @return string
     */
    public function setProvincia($_provincia)
    {
        return ($this->Provincia = $_provincia);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDIRECCIONTYPE
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
