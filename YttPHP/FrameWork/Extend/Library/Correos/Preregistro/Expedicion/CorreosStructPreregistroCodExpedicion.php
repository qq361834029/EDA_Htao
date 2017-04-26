<?php
/**
 * File for class CorreosStructPreregistroCodExpedicion
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructPreregistroCodExpedicion originally named PreregistroCodExpedicion
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructPreregistroCodExpedicion extends CorreosWsdlClass
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
     * The Remitente
     * @var CorreosStructDATOSREMITENTETYPE
     */
    public $Remitente;
    /**
     * The Destinatario
     * @var CorreosStructDATOSDESTINATARIOTYPE
     */
    public $Destinatario;
    /**
     * The Envio
     * @var CorreosStructDATOSENVIOTYPE
     */
    public $Envio;
    /**
     * The EntregaParcial
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $EntregaParcial;
    /**
     * The CodExpedicion
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 16
     * @var string
     */
    public $CodExpedicion;
    /**
     * Constructor method for PreregistroCodExpedicion
     * @see parent::__construct()
     * @param string $_fechaOperacion
     * @param string $_codEtiquetador
     * @param string $_numContrato
     * @param string $_numCliente
     * @param string $_care
     * @param integer $_totalBultos
     * @param CorreosEnumModDevEtiqueta $_modDevEtiqueta
     * @param CorreosStructDATOSREMITENTETYPE $_remitente
     * @param CorreosStructDATOSDESTINATARIOTYPE $_destinatario
     * @param CorreosStructDATOSENVIOTYPE $_envio
     * @param string $_entregaParcial
     * @param string $_codExpedicion
     * @return CorreosStructPreregistroCodExpedicion
     */
    public function __construct($_fechaOperacion = NULL,$_codEtiquetador = NULL,$_numContrato = NULL,$_numCliente = NULL,$_care = NULL,$_totalBultos = NULL,$_modDevEtiqueta = NULL,$_remitente = NULL,$_destinatario = NULL,$_envio = NULL,$_entregaParcial = NULL,$_codExpedicion = NULL)
    {
        parent::__construct(array('FechaOperacion'=>$_fechaOperacion,'CodEtiquetador'=>$_codEtiquetador,'NumContrato'=>$_numContrato,'NumCliente'=>$_numCliente,'Care'=>$_care,'TotalBultos'=>$_totalBultos,'ModDevEtiqueta'=>$_modDevEtiqueta,'Remitente'=>$_remitente,'Destinatario'=>$_destinatario,'Envio'=>$_envio,'EntregaParcial'=>$_entregaParcial,'CodExpedicion'=>$_codExpedicion),false);
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
     * Get Remitente value
     * @return CorreosStructDATOSREMITENTETYPE|null
     */
    public function getRemitente()
    {
        return $this->Remitente;
    }
    /**
     * Set Remitente value
     * @param CorreosStructDATOSREMITENTETYPE $_remitente the Remitente
     * @return CorreosStructDATOSREMITENTETYPE
     */
    public function setRemitente($_remitente)
    {
        return ($this->Remitente = $_remitente);
    }
    /**
     * Get Destinatario value
     * @return CorreosStructDATOSDESTINATARIOTYPE|null
     */
    public function getDestinatario()
    {
        return $this->Destinatario;
    }
    /**
     * Set Destinatario value
     * @param CorreosStructDATOSDESTINATARIOTYPE $_destinatario the Destinatario
     * @return CorreosStructDATOSDESTINATARIOTYPE
     */
    public function setDestinatario($_destinatario)
    {
        return ($this->Destinatario = $_destinatario);
    }
    /**
     * Get Envio value
     * @return CorreosStructDATOSENVIOTYPE|null
     */
    public function getEnvio()
    {
        return $this->Envio;
    }
    /**
     * Set Envio value
     * @param CorreosStructDATOSENVIOTYPE $_envio the Envio
     * @return CorreosStructDATOSENVIOTYPE
     */
    public function setEnvio($_envio)
    {
        return ($this->Envio = $_envio);
    }
    /**
     * Get EntregaParcial value
     * @return string|null
     */
    public function getEntregaParcial()
    {
        return $this->EntregaParcial;
    }
    /**
     * Set EntregaParcial value
     * @param string $_entregaParcial the EntregaParcial
     * @return string
     */
    public function setEntregaParcial($_entregaParcial)
    {
        return ($this->EntregaParcial = $_entregaParcial);
    }
    /**
     * Get CodExpedicion value
     * @return string|null
     */
    public function getCodExpedicion()
    {
        return $this->CodExpedicion;
    }
    /**
     * Set CodExpedicion value
     * @param string $_codExpedicion the CodExpedicion
     * @return string
     */
    public function setCodExpedicion($_codExpedicion)
    {
        return ($this->CodExpedicion = $_codExpedicion);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructPreregistroCodExpedicion
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
