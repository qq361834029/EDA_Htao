<?php
/**
 * File for class CorreosStructSolicitudEtiquetaRefCli
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructSolicitudEtiquetaRefCli originally named SolicitudEtiquetaRefCli
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructSolicitudEtiquetaRefCli extends CorreosWsdlClass
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
     * The ReferenciaCliente
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $ReferenciaCliente;
    /**
     * The ReferenciaCliente2
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $ReferenciaCliente2;
    /**
     * The ReferenciaCliente3
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $ReferenciaCliente3;
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
     * Constructor method for SolicitudEtiquetaRefCli
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_fechaOperacion
     * string $_codEtiquetador
     * string $_numContrato
     * string $_numCliente
     * string $_referenciaCliente
     * string $_referenciaCliente2
     * string $_referenciaCliente3
     * string $_care
     * CorreosEnumModDevEtiqueta $_modDevEtiqueta
     * @return CorreosStructSolicitudEtiquetaRefCli
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'FechaOperacion'		=> NULL,
			'CodEtiquetador'		=> NULL,
			'NumContrato'			=> NULL,
			'NumCliente'			=> NULL,
			'ReferenciaCliente'		=> NULL,
			'ReferenciaCliente2'	=> NULL,
			'ReferenciaCliente3'	=> NULL,
			'Care'					=> NULL,
			'ModDevEtiqueta'		=> NULL,
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
     * Get ReferenciaCliente value
     * @return string|null
     */
    public function getReferenciaCliente()
    {
        return $this->ReferenciaCliente;
    }
    /**
     * Set ReferenciaCliente value
     * @param string $_referenciaCliente the ReferenciaCliente
     * @return string
     */
    public function setReferenciaCliente($_referenciaCliente)
    {
        return ($this->ReferenciaCliente = $_referenciaCliente);
    }
    /**
     * Get ReferenciaCliente2 value
     * @return string|null
     */
    public function getReferenciaCliente2()
    {
        return $this->ReferenciaCliente2;
    }
    /**
     * Set ReferenciaCliente2 value
     * @param string $_referenciaCliente2 the ReferenciaCliente2
     * @return string
     */
    public function setReferenciaCliente2($_referenciaCliente2)
    {
        return ($this->ReferenciaCliente2 = $_referenciaCliente2);
    }
    /**
     * Get ReferenciaCliente3 value
     * @return string|null
     */
    public function getReferenciaCliente3()
    {
        return $this->ReferenciaCliente3;
    }
    /**
     * Set ReferenciaCliente3 value
     * @param string $_referenciaCliente3 the ReferenciaCliente3
     * @return string
     */
    public function setReferenciaCliente3($_referenciaCliente3)
    {
        return ($this->ReferenciaCliente3 = $_referenciaCliente3);
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
     * @return CorreosStructSolicitudEtiquetaRefCli
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
