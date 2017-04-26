<?php
/**
 * File for class CorreosStructPeticionReexpedicion
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructPeticionReexpedicion originally named PeticionReexpedicion
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructPeticionReexpedicion extends CorreosWsdlClass
{
    /**
     * The codCertificado
     * @var string
     */
    public $codCertificado;
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
     * The DestinatarioReexp
     * @var CorreosStructDATOSDESTINATARIOREEXPTYPE
     */
    public $DestinatarioReexp;
    /**
     * The ValoresAnadidos
     * @var CorreosStructVATYPE
     */
    public $ValoresAnadidos;
    /**
     * Constructor method for PeticionReexpedicion
     * @see parent::__construct()
     * @param string $_codCertificado
     * @param string $_codProducto
     * @param CorreosEnumModalidadEntrega $_modalidadEntrega
     * @param CorreosStructDATOSDESTINATARIOREEXPTYPE $_destinatarioReexp
     * @param CorreosStructVATYPE $_valoresAnadidos
     * @return CorreosStructPeticionReexpedicion
     */
    public function __construct($_codCertificado = NULL,$_codProducto = NULL,$_modalidadEntrega = NULL,$_destinatarioReexp = NULL,$_valoresAnadidos = NULL)
    {
        parent::__construct(array('codCertificado'=>$_codCertificado,'CodProducto'=>$_codProducto,'ModalidadEntrega'=>$_modalidadEntrega,'DestinatarioReexp'=>$_destinatarioReexp,'ValoresAnadidos'=>$_valoresAnadidos),false);
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
     * Get DestinatarioReexp value
     * @return CorreosStructDATOSDESTINATARIOREEXPTYPE|null
     */
    public function getDestinatarioReexp()
    {
        return $this->DestinatarioReexp;
    }
    /**
     * Set DestinatarioReexp value
     * @param CorreosStructDATOSDESTINATARIOREEXPTYPE $_destinatarioReexp the DestinatarioReexp
     * @return CorreosStructDATOSDESTINATARIOREEXPTYPE
     */
    public function setDestinatarioReexp($_destinatarioReexp)
    {
        return ($this->DestinatarioReexp = $_destinatarioReexp);
    }
    /**
     * Get ValoresAnadidos value
     * @return CorreosStructVATYPE|null
     */
    public function getValoresAnadidos()
    {
        return $this->ValoresAnadidos;
    }
    /**
     * Set ValoresAnadidos value
     * @param CorreosStructVATYPE $_valoresAnadidos the ValoresAnadidos
     * @return CorreosStructVATYPE
     */
    public function setValoresAnadidos($_valoresAnadidos)
    {
        return ($this->ValoresAnadidos = $_valoresAnadidos);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructPeticionReexpedicion
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
