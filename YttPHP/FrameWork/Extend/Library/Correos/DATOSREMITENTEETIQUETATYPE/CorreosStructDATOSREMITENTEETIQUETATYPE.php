<?php
/**
 * File for class CorreosStructDATOSREMITENTEETIQUETATYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDATOSREMITENTEETIQUETATYPE originally named DATOSREMITENTEETIQUETATYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDATOSREMITENTEETIQUETATYPE extends CorreosWsdlClass
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
     * The PersonaContacto
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 150
     * @var string
     */
    public $PersonaContacto;
    /**
     * The CP
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $CP;
    /**
     * Constructor method for DATOSREMITENTEETIQUETATYPE
     * @see parent::__construct()
     * array $_arrayOfValues
     * string $_nombre
     * string $_direccion
     * string $_localidad
     * string $_provincia
     * string $_personaContacto
     * string $_cP
     * @return CorreosStructDATOSREMITENTEETIQUETATYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Nombre'			=> NULL,
			'Direccion'			=> NULL,
			'Localidad'			=> NULL,
			'Provincia'			=> NULL,
			'PersonaContacto'	=> NULL,
			'CP'				=> NULL,
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDATOSREMITENTEETIQUETATYPE
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
