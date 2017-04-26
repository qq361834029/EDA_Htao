<?php
/**
 * File for class CorreosStructDATOSETIQUETAXMLTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDATOSETIQUETAXMLTYPE originally named DATOSETIQUETAXMLTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDATOSETIQUETAXMLTYPE extends CorreosWsdlClass
{
    /**
     * The RemitenteEtiqueta
     * @var CorreosStructDATOSREMITENTEETIQUETATYPE
     */
    public $RemitenteEtiqueta;
    /**
     * The DestinatarioEtiqueta
     * @var CorreosStructDATOSDESTINATARIOETIQUETATYPE
     */
    public $DestinatarioEtiqueta;
    /**
     * The Referencia
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 30
     * @var string
     */
    public $Referencia;
    /**
     * The PesoReal
     * @var string
     */
    public $PesoReal;
    /**
     * The PesoVol
     * @var string
     */
    public $PesoVol;
    /**
     * The Observaciones
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 90
     * @var string
     */
    public $Observaciones;
    /**
     * The FechaEtiquetado
     * @var string
     */
    public $FechaEtiquetado;
    /**
     * The CodigoBarras
     * @var CorreosStructFICHEROADJUNTOTYPE
     */
    public $CodigoBarras;
    /**
     * The InstruccionesDevolucion
     * @var CorreosEnumInstruccionesDevolucion
     */
    public $InstruccionesDevolucion;
    /**
     * The VA
     * @var CorreosStructVAETIQUETATYPE
     */
    public $VA;
    /**
     * Constructor method for DATOSETIQUETAXMLTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosStructDATOSREMITENTEETIQUETATYPE $_remitenteEtiqueta
     * CorreosStructDATOSDESTINATARIOETIQUETATYPE $_destinatarioEtiqueta
     * string $_referencia
     * string $_pesoReal
     * string $_pesoVol
     * string $_observaciones
     * string $_fechaEtiquetado
     * CorreosStructFICHEROADJUNTOTYPE $_codigoBarras
     * CorreosEnumInstruccionesDevolucion $_instruccionesDevolucion
     * CorreosStructVAETIQUETATYPE $_vA
     * @return CorreosStructDATOSETIQUETAXMLTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'RemitenteEtiqueta'			=> NULL,
			'DestinatarioEtiqueta'		=> NULL,
			'Referencia'				=> NULL,
			'PesoReal'					=> NULL,
			'PesoVol'					=> NULL,
			'Observaciones'				=> NULL,
			'FechaEtiquetado'			=> NULL,
			'CodigoBarras'				=> NULL,
			'InstruccionesDevolucion'	=> NULL,
			'VA'						=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get RemitenteEtiqueta value
     * @return CorreosStructDATOSREMITENTEETIQUETATYPE|null
     */
    public function getRemitenteEtiqueta()
    {
        return $this->RemitenteEtiqueta;
    }
    /**
     * Set RemitenteEtiqueta value
     * @param CorreosStructDATOSREMITENTEETIQUETATYPE $_remitenteEtiqueta the RemitenteEtiqueta
     * @return CorreosStructDATOSREMITENTEETIQUETATYPE
     */
    public function setRemitenteEtiqueta($_remitenteEtiqueta)
    {
        return ($this->RemitenteEtiqueta = $_remitenteEtiqueta);
    }
    /**
     * Get DestinatarioEtiqueta value
     * @return CorreosStructDATOSDESTINATARIOETIQUETATYPE|null
     */
    public function getDestinatarioEtiqueta()
    {
        return $this->DestinatarioEtiqueta;
    }
    /**
     * Set DestinatarioEtiqueta value
     * @param CorreosStructDATOSDESTINATARIOETIQUETATYPE $_destinatarioEtiqueta the DestinatarioEtiqueta
     * @return CorreosStructDATOSDESTINATARIOETIQUETATYPE
     */
    public function setDestinatarioEtiqueta($_destinatarioEtiqueta)
    {
        return ($this->DestinatarioEtiqueta = $_destinatarioEtiqueta);
    }
    /**
     * Get Referencia value
     * @return string|null
     */
    public function getReferencia()
    {
        return $this->Referencia;
    }
    /**
     * Set Referencia value
     * @param string $_referencia the Referencia
     * @return string
     */
    public function setReferencia($_referencia)
    {
        return ($this->Referencia = $_referencia);
    }
    /**
     * Get PesoReal value
     * @return string|null
     */
    public function getPesoReal()
    {
        return $this->PesoReal;
    }
    /**
     * Set PesoReal value
     * @param string $_pesoReal the PesoReal
     * @return string
     */
    public function setPesoReal($_pesoReal)
    {
        return ($this->PesoReal = $_pesoReal);
    }
    /**
     * Get PesoVol value
     * @return string|null
     */
    public function getPesoVol()
    {
        return $this->PesoVol;
    }
    /**
     * Set PesoVol value
     * @param string $_pesoVol the PesoVol
     * @return string
     */
    public function setPesoVol($_pesoVol)
    {
        return ($this->PesoVol = $_pesoVol);
    }
    /**
     * Get Observaciones value
     * @return string|null
     */
    public function getObservaciones()
    {
        return $this->Observaciones;
    }
    /**
     * Set Observaciones value
     * @param string $_observaciones the Observaciones
     * @return string
     */
    public function setObservaciones($_observaciones)
    {
        return ($this->Observaciones = $_observaciones);
    }
    /**
     * Get FechaEtiquetado value
     * @return string|null
     */
    public function getFechaEtiquetado()
    {
        return $this->FechaEtiquetado;
    }
    /**
     * Set FechaEtiquetado value
     * @param string $_fechaEtiquetado the FechaEtiquetado
     * @return string
     */
    public function setFechaEtiquetado($_fechaEtiquetado)
    {
        return ($this->FechaEtiquetado = $_fechaEtiquetado);
    }
    /**
     * Get CodigoBarras value
     * @return CorreosStructFICHEROADJUNTOTYPE|null
     */
    public function getCodigoBarras()
    {
        return $this->CodigoBarras;
    }
    /**
     * Set CodigoBarras value
     * @param CorreosStructFICHEROADJUNTOTYPE $_codigoBarras the CodigoBarras
     * @return CorreosStructFICHEROADJUNTOTYPE
     */
    public function setCodigoBarras($_codigoBarras)
    {
        return ($this->CodigoBarras = $_codigoBarras);
    }
    /**
     * Get InstruccionesDevolucion value
     * @return CorreosEnumInstruccionesDevolucion|null
     */
    public function getInstruccionesDevolucion()
    {
        return $this->InstruccionesDevolucion;
    }
    /**
     * Set InstruccionesDevolucion value
     * @uses CorreosEnumInstruccionesDevolucion::valueIsValid()
     * @param CorreosEnumInstruccionesDevolucion $_instruccionesDevolucion the InstruccionesDevolucion
     * @return CorreosEnumInstruccionesDevolucion
     */
    public function setInstruccionesDevolucion($_instruccionesDevolucion)
    {
        if(!CorreosEnumInstruccionesDevolucion::valueIsValid($_instruccionesDevolucion))
        {
            return false;
        }
        return ($this->InstruccionesDevolucion = $_instruccionesDevolucion);
    }
    /**
     * Get VA value
     * @return CorreosStructVAETIQUETATYPE|null
     */
    public function getVA()
    {
        return $this->VA;
    }
    /**
     * Set VA value
     * @param CorreosStructVAETIQUETATYPE $_vA the VA
     * @return CorreosStructVAETIQUETATYPE
     */
    public function setVA($_vA)
    {
        return ($this->VA = $_vA);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDATOSETIQUETAXMLTYPE
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
