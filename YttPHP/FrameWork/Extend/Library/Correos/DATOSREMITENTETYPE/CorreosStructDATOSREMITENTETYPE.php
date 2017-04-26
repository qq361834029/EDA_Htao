<?php
/**
 * File for class CorreosStructDATOSREMITENTETYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDATOSREMITENTETYPE originally named DATOSREMITENTETYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDATOSREMITENTETYPE extends CorreosWsdlClass
{
    /**
     * The Identificacion
     * @var CorreosStructIDENTIFICACIONTYPE
     */
    public $Identificacion;
    /**
     * The DatosDireccion
     * @var CorreosStructDIRECCIONTYPE
     */
    public $DatosDireccion;
    /**
     * The CP
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $CP;
    /**
     * The Telefonocontacto
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 15
     * @var string
     */
    public $Telefonocontacto;
    /**
     * The Email
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 50
     * @var string
     */
    public $Email;
    /**
     * The DatosSMS
     * @var CorreosStructSMSTYPE
     */
    public $DatosSMS;
    /**
     * Constructor method for DATOSREMITENTETYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosStructIDENTIFICACIONTYPE $_identificacion
     * CorreosStructDIRECCIONTYPE $_datosDireccion
     * string $_cP
     * string $_telefonocontacto
     * string $_email
     * CorreosStructSMSTYPE $_datosSMS
     * @return CorreosStructDATOSREMITENTETYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Identificacion'	=> NULL,
			'DatosDireccion'	=> NULL,
			'CP'				=> NULL,
			'Telefonocontacto'	=> NULL,
			'Email'				=> NULL,
			'DatosSMS'			=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get Identificacion value
     * @return CorreosStructIDENTIFICACIONTYPE|null
     */
    public function getIdentificacion()
    {
        return $this->Identificacion;
    }
    /**
     * Set Identificacion value
     * @param CorreosStructIDENTIFICACIONTYPE $_identificacion the Identificacion
     * @return CorreosStructIDENTIFICACIONTYPE
     */
    public function setIdentificacion($_identificacion)
    {
        return ($this->Identificacion = $_identificacion);
    }
    /**
     * Get DatosDireccion value
     * @return CorreosStructDIRECCIONTYPE|null
     */
    public function getDatosDireccion()
    {
        return $this->DatosDireccion;
    }
    /**
     * Set DatosDireccion value
     * @param CorreosStructDIRECCIONTYPE $_datosDireccion the DatosDireccion
     * @return CorreosStructDIRECCIONTYPE
     */
    public function setDatosDireccion($_datosDireccion)
    {
        return ($this->DatosDireccion = $_datosDireccion);
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
     * Get Telefonocontacto value
     * @return string|null
     */
    public function getTelefonocontacto()
    {
        return $this->Telefonocontacto;
    }
    /**
     * Set Telefonocontacto value
     * @param string $_telefonocontacto the Telefonocontacto
     * @return string
     */
    public function setTelefonocontacto($_telefonocontacto)
    {
        return ($this->Telefonocontacto = $_telefonocontacto);
    }
    /**
     * Get Email value
     * @return string|null
     */
    public function getEmail()
    {
        return $this->Email;
    }
    /**
     * Set Email value
     * @param string $_email the Email
     * @return string
     */
    public function setEmail($_email)
    {
        return ($this->Email = $_email);
    }
    /**
     * Get DatosSMS value
     * @return CorreosStructSMSTYPE|null
     */
    public function getDatosSMS()
    {
        return $this->DatosSMS;
    }
    /**
     * Set DatosSMS value
     * @param CorreosStructSMSTYPE $_datosSMS the DatosSMS
     * @return CorreosStructSMSTYPE
     */
    public function setDatosSMS($_datosSMS)
    {
        return ($this->DatosSMS = $_datosSMS);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDATOSREMITENTETYPE
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
