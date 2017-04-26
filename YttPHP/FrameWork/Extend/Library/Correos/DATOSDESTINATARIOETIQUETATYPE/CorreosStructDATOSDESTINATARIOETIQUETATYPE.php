<?php
/**
 * File for class CorreosStructDATOSDESTINATARIOETIQUETATYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDATOSDESTINATARIOETIQUETATYPE originally named DATOSDESTINATARIOETIQUETATYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDATOSDESTINATARIOETIQUETATYPE extends CorreosWsdlClass
{
    /**
     * The Nombre
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 300
     * @var string
     */
    public $Nombre;
    /**
     * The Direccion
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $Direccion;
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
     * The CP
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $CP;
    /**
     * The ZIP
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 10
     * @var string
     */
    public $ZIP;
    /**
     * The Pais
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $Pais;
    /**
     * The PersonaContacto
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 150
     * @var string
     */
    public $PersonaContacto;
    /**
     * The Telefono
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 15
     * @var string
     */
    public $Telefono;
    /**
     * Constructor method for DATOSDESTINATARIOETIQUETATYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
	 * string $_nombre
     * string $_direccion
     * string $_localidad
     * string $_provincia
     * string $_cP
     * string $_zIP
     * string $_pais
     * string $_personaContacto
     * string $_telefono
     * @return CorreosStructDATOSDESTINATARIOETIQUETATYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Nombre'			=> NULL,
			'Direccion'			=> NULL,
			'NumContrato'		=> NULL,
			'Localidad'			=> NULL,
			'Provincia'			=> NULL,
			'CP'				=> NULL,
			'ZIP'				=> NULL,
			'Pais'				=> NULL,
			'PersonaContacto'	=> NULL,
			'Telefono'			=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get Nombre value
     * @return string|null
     */
    public function getNombre()
    {
        return $this->Nombre;
    }
    /**
     * Set Nombre value
     * @param string $_nombre the Nombre
     * @return string
     */
    public function setNombre($_nombre)
    {
        return ($this->Nombre = $_nombre);
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
     * Get CP value
     * @return string|null
     */
    public function getCP()
    {
        return $this->CP;
    }
    /**
     * Set CP value
     * @param string $_cP the CP
     * @return string
     */
    public function setCP($_cP)
    {
        return ($this->CP = $_cP);
    }
    /**
     * Get ZIP value
     * @return string|null
     */
    public function getZIP()
    {
        return $this->ZIP;
    }
    /**
     * Set ZIP value
     * @param string $_zIP the ZIP
     * @return string
     */
    public function setZIP($_zIP)
    {
        return ($this->ZIP = $_zIP);
    }
    /**
     * Get Pais value
     * @return string|null
     */
    public function getPais()
    {
        return $this->Pais;
    }
    /**
     * Set Pais value
     * @param string $_pais the Pais
     * @return string
     */
    public function setPais($_pais)
    {
        return ($this->Pais = $_pais);
    }
    /**
     * Get PersonaContacto value
     * @return string|null
     */
    public function getPersonaContacto()
    {
        return $this->PersonaContacto;
    }
    /**
     * Set PersonaContacto value
     * @param string $_personaContacto the PersonaContacto
     * @return string
     */
    public function setPersonaContacto($_personaContacto)
    {
        return ($this->PersonaContacto = $_personaContacto);
    }
    /**
     * Get Telefono value
     * @return string|null
     */
    public function getTelefono()
    {
        return $this->Telefono;
    }
    /**
     * Set Telefono value
     * @param string $_telefono the Telefono
     * @return string
     */
    public function setTelefono($_telefono)
    {
        return ($this->Telefono = $_telefono);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDATOSDESTINATARIOETIQUETATYPE
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
