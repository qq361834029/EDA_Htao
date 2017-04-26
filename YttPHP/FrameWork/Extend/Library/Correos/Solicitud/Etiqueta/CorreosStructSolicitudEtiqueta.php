<?php
/**
 * File for class CorreosStructSolicitudEtiqueta
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructSolicitudEtiqueta originally named SolicitudEtiqueta
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructSolicitudEtiqueta extends CorreosWsdlClass
{
    /**
     * The FechaOperacion
     * @var string
     */
    public $FechaOperacion;
    /**
     * The CodEtiquetador
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 4
     * @var string
     */
    public $CodEtiquetador;
    /**
     * The NumContrato
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 8
     * @var string
     */
    public $NumContrato;
    /**
     * The NumCliente
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 8
     * @var string
     */
    public $NumCliente;
    /**
     * The CodEnvio
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 23
     * @var string
     */
    public $CodEnvio;
    /**
     * The Care
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 6
     * @var string
     */
    public $Care;
    /**
     * The ModDevEtiqueta
     * @var CorreosEnumModDevEtiqueta
     */
    public $ModDevEtiqueta;
    /**
     * Constructor method for SolicitudEtiqueta
     * @see parent::__construct()
     * @param string $_fechaOperacion
     * @param string $_codEtiquetador
     * @param string $_numContrato
     * @param string $_numCliente
     * @param string $_codEnvio
     * @param string $_care
     * @param CorreosEnumModDevEtiqueta $_modDevEtiqueta
     * @return CorreosStructSolicitudEtiqueta
     */
    public function __construct($_arrayOfValues)
    {
		$defaultValues	= array(
			'FechaOperacion'	=> NULL,
			'CodEtiquetador'	=> NULL,
			'NumContrato'		=> NULL,
			'NumCliente'		=> NULL,
			'CodEnvio'			=> NULL,
			'Care'				=> NULL,
			'ModDevEtiqueta'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get FechaOperacion value
     * @return string|null
     */
    public function getFechaOperacion()
    {
        return $this->FechaOperacion;
    }
    /**
     * Set FechaOperacion value
     * @param string $_fechaOperacion the FechaOperacion
     * @return string
     */
    public function setFechaOperacion($_fechaOperacion)
    {
        return ($this->FechaOperacion = $_fechaOperacion);
    }
    /**
     * Get CodEtiquetador value
     * @return string|null
     */
    public function getCodEtiquetador()
    {
        return $this->CodEtiquetador;
    }
    /**
     * Set CodEtiquetador value
     * @param string $_codEtiquetador the CodEtiquetador
     * @return string
     */
    public function setCodEtiquetador($_codEtiquetador)
    {
        return ($this->CodEtiquetador = $_codEtiquetador);
    }
    /**
     * Get NumContrato value
     * @return string|null
     */
    public function getNumContrato()
    {
        return $this->NumContrato;
    }
    /**
     * Set NumContrato value
     * @param string $_numContrato the NumContrato
     * @return string
     */
    public function setNumContrato($_numContrato)
    {
        return ($this->NumContrato = $_numContrato);
    }
    /**
     * Get NumCliente value
     * @return string|null
     */
    public function getNumCliente()
    {
        return $this->NumCliente;
    }
    /**
     * Set NumCliente value
     * @param string $_numCliente the NumCliente
     * @return string
     */
    public function setNumCliente($_numCliente)
    {
        return ($this->NumCliente = $_numCliente);
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
     * Get Care value
     * @return string|null
     */
    public function getCare()
    {
        return $this->Care;
    }
    /**
     * Set Care value
     * @param string $_care the Care
     * @return string
     */
    public function setCare($_care)
    {
        return ($this->Care = $_care);
    }
    /**
     * Get ModDevEtiqueta value
     * @return CorreosEnumModDevEtiqueta|null
     */
    public function getModDevEtiqueta()
    {
        return $this->ModDevEtiqueta;
    }
    /**
     * Set ModDevEtiqueta value
     * @uses CorreosEnumModDevEtiqueta::valueIsValid()
     * @param CorreosEnumModDevEtiqueta $_modDevEtiqueta the ModDevEtiqueta
     * @return CorreosEnumModDevEtiqueta
     */
    public function setModDevEtiqueta($_modDevEtiqueta)
    {
        if(!CorreosEnumModDevEtiqueta::valueIsValid($_modDevEtiqueta))
        {
            return false;
        }
        return ($this->ModDevEtiqueta = $_modDevEtiqueta);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructSolicitudEtiqueta
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
