<?php
/**
 * File for class CorreosStructSolicitudDocumentacionAduanera
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructSolicitudDocumentacionAduanera originally named SolicitudDocumentacionAduanera
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructSolicitudDocumentacionAduanera extends CorreosWsdlClass
{
    /**
     * The TipoESAD
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 4
     * @var string
     */
    public $TipoESAD;
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
     * The CodEtiquetador
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 4
     * @var string
     */
    public $CodEtiquetador;
    /**
     * The Provincia
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 40
     * @var string
     */
    public $Provincia;
    /**
     * The PaisDestino
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $PaisDestino;
    /**
     * The NombreDestinatario
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 300
     * @var string
     */
    public $NombreDestinatario;
    /**
     * The NumeroEnvios
     * @var string
     */
    public $NumeroEnvios;
    /**
     * The LocalidadFirma
     * @var string
     */
    public $LocalidadFirma;
    /**
     * The FechaFirma
     * @var string
     */
    public $FechaFirma;
    /**
     * The NifFirma
     * @var string
     */
    public $NifFirma;
    /**
     * The NombreFirma
     * @var string
     */
    public $NombreFirma;
    /**
     * Constructor method for SolicitudDocumentacionAduanera
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_tipoESAD
     * string $_numContrato
     * string $_numCliente
     * string $_codEtiquetador
     * string $_provincia
     * string $_paisDestino
     * string $_nombreDestinatario
     * string $_numeroEnvios
     * string $_localidadFirma
     * string $_fechaFirma
     * string $_nifFirma
     * string $_nombreFirma
     * @return CorreosStructSolicitudDocumentacionAduanera
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'TipoESAD'	=> NULL,
			'NumContrato'	=> NULL,
			'NumCliente'	=> NULL,
			'CodEtiquetador'	=> NULL,
			'Provincia'	=> NULL,
			'PaisDestino'	=> NULL,
			'NombreDestinatario'	=> NULL,
			'NumeroEnvios'	=> NULL,
			'LocalidadFirma'	=> NULL,
			'FechaFirma'	=> NULL,
			'NifFirma'	=> NULL,
			'NombreFirma'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get TipoESAD value
     * @return string|null
     */
    public function getTipoESAD()
    {
        return $this->TipoESAD;
    }
    /**
     * Set TipoESAD value
     * @param string $_tipoESAD the TipoESAD
     * @return string
     */
    public function setTipoESAD($_tipoESAD)
    {
        return ($this->TipoESAD = $_tipoESAD);
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
     * Get PaisDestino value
     * @return string|null
     */
    public function getPaisDestino()
    {
        return $this->PaisDestino;
    }
    /**
     * Set PaisDestino value
     * @param string $_paisDestino the PaisDestino
     * @return string
     */
    public function setPaisDestino($_paisDestino)
    {
        return ($this->PaisDestino = $_paisDestino);
    }
    /**
     * Get NombreDestinatario value
     * @return string|null
     */
    public function getNombreDestinatario()
    {
        return $this->NombreDestinatario;
    }
    /**
     * Set NombreDestinatario value
     * @param string $_nombreDestinatario the NombreDestinatario
     * @return string
     */
    public function setNombreDestinatario($_nombreDestinatario)
    {
        return ($this->NombreDestinatario = $_nombreDestinatario);
    }
    /**
     * Get NumeroEnvios value
     * @return string|null
     */
    public function getNumeroEnvios()
    {
        return $this->NumeroEnvios;
    }
    /**
     * Set NumeroEnvios value
     * @param string $_numeroEnvios the NumeroEnvios
     * @return string
     */
    public function setNumeroEnvios($_numeroEnvios)
    {
        return ($this->NumeroEnvios = $_numeroEnvios);
    }
    /**
     * Get LocalidadFirma value
     * @return string|null
     */
    public function getLocalidadFirma()
    {
        return $this->LocalidadFirma;
    }
    /**
     * Set LocalidadFirma value
     * @param string $_localidadFirma the LocalidadFirma
     * @return string
     */
    public function setLocalidadFirma($_localidadFirma)
    {
        return ($this->LocalidadFirma = $_localidadFirma);
    }
    /**
     * Get FechaFirma value
     * @return string|null
     */
    public function getFechaFirma()
    {
        return $this->FechaFirma;
    }
    /**
     * Set FechaFirma value
     * @param string $_fechaFirma the FechaFirma
     * @return string
     */
    public function setFechaFirma($_fechaFirma)
    {
        return ($this->FechaFirma = $_fechaFirma);
    }
    /**
     * Get NifFirma value
     * @return string|null
     */
    public function getNifFirma()
    {
        return $this->NifFirma;
    }
    /**
     * Set NifFirma value
     * @param string $_nifFirma the NifFirma
     * @return string
     */
    public function setNifFirma($_nifFirma)
    {
        return ($this->NifFirma = $_nifFirma);
    }
    /**
     * Get NombreFirma value
     * @return string|null
     */
    public function getNombreFirma()
    {
        return $this->NombreFirma;
    }
    /**
     * Set NombreFirma value
     * @param string $_nombreFirma the NombreFirma
     * @return string
     */
    public function setNombreFirma($_nombreFirma)
    {
        return ($this->NombreFirma = $_nombreFirma);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructSolicitudDocumentacionAduanera
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
