<?php
/**
 * File for class CorreosStructPeticionGenerarCodigoExpedicion
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructPeticionGenerarCodigoExpedicion originally named PeticionGenerarCodigoExpedicion
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructPeticionGenerarCodigoExpedicion extends CorreosWsdlClass
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
     * The TotalBultos
     * @var integer
     */
    public $TotalBultos;
    /**
     * The CodProducto
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $CodProducto;
    /**
     * The ModalidadEntrega
     * @var CorreosEnumModalidadEntrega
     */
    public $ModalidadEntrega;
    /**
     * The TipoFranqueo
     * @var CorreosEnumTipoFranqueo
     */
    public $TipoFranqueo;
    /**
     * Constructor method for PeticionGenerarCodigoExpedicion
     * @see parent::__construct()
     * @param string $_fechaOperacion
     * @param string $_codEtiquetador
     * @param string $_numContrato
     * @param string $_numCliente
     * @param integer $_totalBultos
     * @param string $_codProducto
     * @param CorreosEnumModalidadEntrega $_modalidadEntrega
     * @param CorreosEnumTipoFranqueo $_tipoFranqueo
     * @return CorreosStructPeticionGenerarCodigoExpedicion
     */
    public function __construct($_fechaOperacion = NULL,$_codEtiquetador = NULL,$_numContrato = NULL,$_numCliente = NULL,$_totalBultos = NULL,$_codProducto = NULL,$_modalidadEntrega = NULL,$_tipoFranqueo = NULL)
    {
        parent::__construct(array('FechaOperacion'=>$_fechaOperacion,'CodEtiquetador'=>$_codEtiquetador,'NumContrato'=>$_numContrato,'NumCliente'=>$_numCliente,'TotalBultos'=>$_totalBultos,'CodProducto'=>$_codProducto,'ModalidadEntrega'=>$_modalidadEntrega,'TipoFranqueo'=>$_tipoFranqueo),false);
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
     * Get CodProducto value
     * @return string|null
     */
    public function getCodProducto()
    {
        return $this->CodProducto;
    }
    /**
     * Set CodProducto value
     * @param string $_codProducto the CodProducto
     * @return string
     */
    public function setCodProducto($_codProducto)
    {
        return ($this->CodProducto = $_codProducto);
    }
    /**
     * Get ModalidadEntrega value
     * @return CorreosEnumModalidadEntrega|null
     */
    public function getModalidadEntrega()
    {
        return $this->ModalidadEntrega;
    }
    /**
     * Set ModalidadEntrega value
     * @uses CorreosEnumModalidadEntrega::valueIsValid()
     * @param CorreosEnumModalidadEntrega $_modalidadEntrega the ModalidadEntrega
     * @return CorreosEnumModalidadEntrega
     */
    public function setModalidadEntrega($_modalidadEntrega)
    {
        if(!CorreosEnumModalidadEntrega::valueIsValid($_modalidadEntrega))
        {
            return false;
        }
        return ($this->ModalidadEntrega = $_modalidadEntrega);
    }
    /**
     * Get TipoFranqueo value
     * @return CorreosEnumTipoFranqueo|null
     */
    public function getTipoFranqueo()
    {
        return $this->TipoFranqueo;
    }
    /**
     * Set TipoFranqueo value
     * @uses CorreosEnumTipoFranqueo::valueIsValid()
     * @param CorreosEnumTipoFranqueo $_tipoFranqueo the TipoFranqueo
     * @return CorreosEnumTipoFranqueo
     */
    public function setTipoFranqueo($_tipoFranqueo)
    {
        if(!CorreosEnumTipoFranqueo::valueIsValid($_tipoFranqueo))
        {
            return false;
        }
        return ($this->TipoFranqueo = $_tipoFranqueo);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructPeticionGenerarCodigoExpedicion
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
