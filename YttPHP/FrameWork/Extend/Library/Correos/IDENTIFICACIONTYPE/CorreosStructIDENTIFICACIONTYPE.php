<?php
/**
 * File for class CorreosStructIDENTIFICACIONTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructIDENTIFICACIONTYPE originally named IDENTIFICACIONTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructIDENTIFICACIONTYPE extends CorreosWsdlClass
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
     * The Apellido1
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 50
     * @var string
     */
    public $Apellido1;
    /**
     * The Apellido2
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 50
     * @var string
     */
    public $Apellido2;
    /**
     * The Nif
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 15
     * @var string
     */
    public $Nif;
    /**
     * The Empresa
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 150
     * @var string
     */
    public $Empresa;
    /**
     * The PersonaContacto
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 150
     * @var string
     */
    public $PersonaContacto;
    /**
     * Constructor method for IDENTIFICACIONTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_nombre
     * string $_apellido1
     * string $_apellido2
     * string $_nif
     * string $_empresa
     * string $_personaContacto
     * @return CorreosStructIDENTIFICACIONTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Nombre'			=> NULL,
			'Apellido1'			=> NULL,
			'Apellido2'			=> NULL,
			'Nif'				=> NULL,
			'Empresa'			=> NULL,
			'PersonaContacto'	=> NULL,
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
     * Get Apellido1 value
     * @return string|null
     */
    public function getApellido1()
    {
        return $this->Apellido1;
    }
    /**
     * Set Apellido1 value
     * @param string $_apellido1 the Apellido1
     * @return string
     */
    public function setApellido1($_apellido1)
    {
        return ($this->Apellido1 = $_apellido1);
    }
    /**
     * Get Apellido2 value
     * @return string|null
     */
    public function getApellido2()
    {
        return $this->Apellido2;
    }
    /**
     * Set Apellido2 value
     * @param string $_apellido2 the Apellido2
     * @return string
     */
    public function setApellido2($_apellido2)
    {
        return ($this->Apellido2 = $_apellido2);
    }
    /**
     * Get Nif value
     * @return string|null
     */
    public function getNif()
    {
        return $this->Nif;
    }
    /**
     * Set Nif value
     * @param string $_nif the Nif
     * @return string
     */
    public function setNif($_nif)
    {
        return ($this->Nif = $_nif);
    }
    /**
     * Get Empresa value
     * @return string|null
     */
    public function getEmpresa()
    {
        return $this->Empresa;
    }
    /**
     * Set Empresa value
     * @param string $_empresa the Empresa
     * @return string
     */
    public function setEmpresa($_empresa)
    {
        return ($this->Empresa = $_empresa);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructIDENTIFICACIONTYPE
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
