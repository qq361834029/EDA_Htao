<?php
/**
 * File for class CorreosStructPeticionModificar
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructPeticionModificar originally named PeticionModificar
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructPeticionModificar extends CorreosWsdlClass
{
    /**
     * The FechaOperacion
     * @var string
     */
    public $FechaOperacion;
    /**
     * The codCertificado
     * @var string
     */
    public $codCertificado;
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
     * The Care
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 6
     * @var string
     */
    public $Care;
    /**
     * The TotalBultos
     * @var integer
     */
    public $TotalBultos;
    /**
     * The ModDevEtiqueta
     * @var CorreosEnumModDevEtiqueta
     */
    public $ModDevEtiqueta;
    /**
     * The RemitenteModif
     * @var CorreosStructDATOSREMITENTEMODIFTYPE
     */
    public $RemitenteModif;
    /**
     * The DestinatarioModif
     * @var CorreosStructDATOSDESTINATARIOMODIFTYPE
     */
    public $DestinatarioModif;
    /**
     * The EnvioModif
     * @var CorreosStructDATOSENVIOMODIFTYPE
     */
    public $EnvioModif;
    /**
     * Constructor method for PeticionModificar
     * @see parent::__construct()
	 * @param array $_arrayOfValues
     *  string $_fechaOperacion
     *  string $_codCertificado
     *  string $_codEtiquetador
     *  string $_numContrato
     *  string $_numCliente
     *  string $_care
     *  integer $_totalBultos
     *  CorreosEnumModDevEtiqueta $_modDevEtiqueta
     *  CorreosStructDATOSREMITENTEMODIFTYPE $_remitenteModif
     *  CorreosStructDATOSDESTINATARIOMODIFTYPE $_destinatarioModif
     *  CorreosStructDATOSENVIOMODIFTYPE $_envioModif
     * @return CorreosStructPeticionModificar
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'FechaOperacion'	=> NULL,
			'codCertificado'	=> NULL,
			'CodEtiquetador'	=> NULL,
			'NumContrato'		=> NULL,
			'NumCliente'		=> NULL,
			'Care'				=> NULL,
			'TotalBultos'		=> NULL,
			'ModDevEtiqueta'	=> NULL,
			'RemitenteModif'	=> NULL,
			'DestinatarioModif'	=> NULL,
			'EnvioModif'		=> NULL,
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
     * Get codCertificado value
     * @return string|null
     */
    public function getCodCertificado()
    {
        return $this->codCertificado;
    }
    /**
     * Set codCertificado value
     * @param string $_codCertificado the codCertificado
     * @return string
     */
    public function setCodCertificado($_codCertificado)
    {
        return ($this->codCertificado = $_codCertificado);
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
     * Get TotalBultos value
     * @return integer|null
     */
    public function getTotalBultos()
    {
        return $this->TotalBultos;
    }
    /**
     * Set TotalBultos value
     * @param integer $_totalBultos the TotalBultos
     * @return integer
     */
    public function setTotalBultos($_totalBultos)
    {
        return ($this->TotalBultos = $_totalBultos);
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
     * Get RemitenteModif value
     * @return CorreosStructDATOSREMITENTEMODIFTYPE|null
     */
    public function getRemitenteModif()
    {
        return $this->RemitenteModif;
    }
    /**
     * Set RemitenteModif value
     * @param CorreosStructDATOSREMITENTEMODIFTYPE $_remitenteModif the RemitenteModif
     * @return CorreosStructDATOSREMITENTEMODIFTYPE
     */
    public function setRemitenteModif($_remitenteModif)
    {
        return ($this->RemitenteModif = $_remitenteModif);
    }
    /**
     * Get DestinatarioModif value
     * @return CorreosStructDATOSDESTINATARIOMODIFTYPE|null
     */
    public function getDestinatarioModif()
    {
        return $this->DestinatarioModif;
    }
    /**
     * Set DestinatarioModif value
     * @param CorreosStructDATOSDESTINATARIOMODIFTYPE $_destinatarioModif the DestinatarioModif
     * @return CorreosStructDATOSDESTINATARIOMODIFTYPE
     */
    public function setDestinatarioModif($_destinatarioModif)
    {
        return ($this->DestinatarioModif = $_destinatarioModif);
    }
    /**
     * Get EnvioModif value
     * @return CorreosStructDATOSENVIOMODIFTYPE|null
     */
    public function getEnvioModif()
    {
        return $this->EnvioModif;
    }
    /**
     * Set EnvioModif value
     * @param CorreosStructDATOSENVIOMODIFTYPE $_envioModif the EnvioModif
     * @return CorreosStructDATOSENVIOMODIFTYPE
     */
    public function setEnvioModif($_envioModif)
    {
        return ($this->EnvioModif = $_envioModif);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructPeticionModificar
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
