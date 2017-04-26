<?php
/**
 * File for class CorreosStructDATOSENVIOTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructDATOSENVIOTYPE originally named DATOSENVIOTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructDATOSENVIOTYPE extends CorreosWsdlClass
{
    /**
     * The NumBulto
     * @var integer
     */
    public $NumBulto;
    /**
     * The CodProducto
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 5
     * @var string
     */
    public $CodProducto;
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
     * The TipoFranqueo
     * @var CorreosEnumTipoFranqueo
     */
    public $TipoFranqueo;
    /**
     * The NumMaquinaFranquear
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 8
     * @var string
     */
    public $NumMaquinaFranquear;
    /**
     * The ImporteFranqueado
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 10
     * @var string
     */
    public $ImporteFranqueado;
    /**
     * The CodPromocion
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 10
     * @var string
     */
    public $CodPromocion;
    /**
     * The ModalidadEntrega
     * @var CorreosEnumModalidadEntrega
     */
    public $ModalidadEntrega;
    /**
     * The OficinaElegida
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 7
     * @var string
     */
    public $OficinaElegida;
    /**
     * The Pesos
     * @var CorreosStructPesos
     */
    public $Pesos;
    /**
     * The Largo
     * @var integer
     */
    public $Largo;
    /**
     * The Alto
     * @var integer
     */
    public $Alto;
    /**
     * The Ancho
     * @var integer
     */
    public $Ancho;
    /**
     * The ValoresAnadidos
     * @var CorreosStructVATYPE
     */
    public $ValoresAnadidos;
    /**
     * The CodigoEmbalajePrepago
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 23
     * @var string
     */
    public $CodigoEmbalajePrepago;
    /**
     * The CodigoPuntoAdmision
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 7
     * @var string
     */
    public $CodigoPuntoAdmision;
    /**
     * The FechaDepositoPrevista
     * @var string
     */
    public $FechaDepositoPrevista;
    /**
     * The Observaciones1
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 45
     * @var string
     */
    public $Observaciones1;
    /**
     * The Observaciones2
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 45
     * @var string
     */
    public $Observaciones2;
    /**
     * The InstruccionesDevolucion
     * @var CorreosEnumInstruccionesDevolucion
     */
    public $InstruccionesDevolucion;
    /**
     * The Aduana
     * @var CorreosStructADUANATYPE
     */
    public $Aduana;
    /**
     * The CodigoIda
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 23
     * @var string
     */
    public $CodigoIda;
    /**
     * The PermiteEmbalaje
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $PermiteEmbalaje;
    /**
     * The FechaCaducidad
     * @var string
     */
    public $FechaCaducidad;
    /**
     * The ReferenciaExpedicion
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 30
     * @var string
     */
    public $ReferenciaExpedicion;
    /**
     * The CodigoHomepaq
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 9
     * @var string
     */
    public $CodigoHomepaq;
    /**
     * The ToquenIdCorPaq
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 50
     * @var string
     */
    public $ToquenIdCorPaq;
    /**
     * The AdmisionHomepaq
     * @var CorreosEnumAdmisionHomepaq
     */
    public $AdmisionHomepaq;
    /**
     * The Documento1
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $Documento1;
    /**
     * The AccDocumento1
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $AccDocumento1;
    /**
     * The ObsDocumento1
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $ObsDocumento1;
    /**
     * The Documento2
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $Documento2;
    /**
     * The AccDocumento2
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $AccDocumento2;
    /**
     * The ObsDocumento2
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $ObsDocumento2;
    /**
     * The Documento3
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $Documento3;
    /**
     * The AccDocumento3
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $AccDocumento3;
    /**
     * The ObsDocumento3
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $ObsDocumento3;
    /**
     * The OperadorPostal
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $OperadorPostal;
    /**
     * The CodigoEnvioOriginal
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 50
     * @var string
     */
    public $CodigoEnvioOriginal;
    /**
     * The ExisteEnvioVueltaLI
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $ExisteEnvioVueltaLI;
    /**
     * The SeguroLI
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $SeguroLI;
    /**
     * The ImporteSeguroLI
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 10
     * @var string
     */
    public $ImporteSeguroLI;
    /**
     * The ReembolsoLI
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $ReembolsoLI;
    /**
     * The ImporteReembolsoLI
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 10
     * @var string
     */
    public $ImporteReembolsoLI;
    /**
     * The TipoReembolsoLI
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $TipoReembolsoLI;
    /**
     * The NumeroCuentaLI
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 20
     * @var string
     */
    public $NumeroCuentaLI;
    /**
     * The CodEnvio
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 23
     * @var string
     */
    public $CodEnvio;
    /**
     * Constructor method for DATOSENVIOTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * integer $_numBulto
     * string $_codProducto
     * string $_referenciaCliente
     * string $_referenciaCliente2
     * string $_referenciaCliente3
     * CorreosEnumTipoFranqueo $_tipoFranqueo
     * string $_numMaquinaFranquear
     * string $_importeFranqueado
     * string $_codPromocion
     * CorreosEnumModalidadEntrega $_modalidadEntrega
     * string $_oficinaElegida
     * CorreosStructPesos $_pesos
     * integer $_largo
     * integer $_alto
     * integer $_ancho
     * CorreosStructVATYPE $_valoresAnadidos
     * string $_codigoEmbalajePrepago
     * string $_codigoPuntoAdmision
     * string $_fechaDepositoPrevista
     * string $_observaciones1
     * string $_observaciones2
     * CorreosEnumInstruccionesDevolucion $_instruccionesDevolucion
     * CorreosStructADUANATYPE $_aduana
     * string $_codigoIda
     * string $_permiteEmbalaje
     * string $_fechaCaducidad
     * string $_referenciaExpedicion
     * string $_codigoHomepaq
     * string $_toquenIdCorPaq
     * CorreosEnumAdmisionHomepaq $_admisionHomepaq
     * string $_documento1
     * string $_accDocumento1
     * string $_obsDocumento1
     * string $_documento2
     * string $_accDocumento2
     * string $_obsDocumento2
     * string $_documento3
     * string $_accDocumento3
     * string $_obsDocumento3
     * string $_operadorPostal
     * string $_codigoEnvioOriginal
     * string $_existeEnvioVueltaLI
     * string $_seguroLI
     * string $_importeSeguroLI
     * string $_reembolsoLI
     * string $_importeReembolsoLI
     * string $_tipoReembolsoLI
     * string $_numeroCuentaLI
     * string $_codEnvio
     * @return CorreosStructDATOSENVIOTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'NumBulto'					=> NULL,
			'CodProducto'				=> NULL,
			'ReferenciaCliente'			=> NULL,
			'ReferenciaCliente2'		=> NULL,
			'ReferenciaCliente3'		=> NULL,
			'TipoFranqueo'				=> NULL,
			'NumMaquinaFranquear'		=> NULL,
			'ImporteFranqueado'			=> NULL,
			'CodPromocion'				=> NULL,
			'ModalidadEntrega'			=> NULL,
			'OficinaElegida'			=> NULL,
			'Pesos'						=> NULL,
			'Largo'						=> NULL,
			'Alto'						=> NULL,
			'Ancho'						=> NULL,
			'ValoresAnadidos'			=> NULL,
			'CodigoEmbalajePrepago'		=> NULL,
			'CodigoPuntoAdmision'		=> NULL,
			'FechaDepositoPrevista'		=> NULL,
			'Observaciones1'			=> NULL,
			'Observaciones2'			=> NULL,
			'InstruccionesDevolucion'	=> NULL,
			'Aduana'					=> NULL,
			'CodigoIda'					=> NULL,
			'PermiteEmbalaje'			=> NULL,
			'FechaCaducidad'			=> NULL,
			'ReferenciaExpedicion'		=> NULL,
			'CodigoHomepaq'				=> NULL,
			'ToquenIdCorPaq'			=> NULL,
			'AdmisionHomepaq'			=> NULL,
			'Documento1'				=> NULL,
			'AccDocumento1'				=> NULL,
			'ObsDocumento1'				=> NULL,
			'Documento2'				=> NULL,
			'AccDocumento2'				=> NULL,
			'ObsDocumento2'				=> NULL,
			'Documento3'				=> NULL,
			'AccDocumento3'				=> NULL,
			'ObsDocumento3'				=> NULL,
			'OperadorPostal'			=> NULL,
			'CodigoEnvioOriginal'		=> NULL,
			'ExisteEnvioVueltaLI'		=> NULL,
			'SeguroLI'					=> NULL,
			'ImporteSeguroLI'			=> NULL,
			'ReembolsoLI'				=> NULL,
			'ImporteReembolsoLI'		=> NULL,
			'TipoReembolsoLI'			=> NULL,
			'NumeroCuentaLI'			=> NULL,
			'CodEnvio'					=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get NumBulto value
     * @return integer|null
     */
    public function getNumBulto()
    {
        return $this->NumBulto;
    }
    /**
     * Set NumBulto value
     * @param integer $_numBulto the NumBulto
     * @return integer
     */
    public function setNumBulto($_numBulto)
    {
        return ($this->NumBulto = $_numBulto);
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
     * Get NumMaquinaFranquear value
     * @return string|null
     */
    public function getNumMaquinaFranquear()
    {
        return $this->NumMaquinaFranquear;
    }
    /**
     * Set NumMaquinaFranquear value
     * @param string $_numMaquinaFranquear the NumMaquinaFranquear
     * @return string
     */
    public function setNumMaquinaFranquear($_numMaquinaFranquear)
    {
        return ($this->NumMaquinaFranquear = $_numMaquinaFranquear);
    }
    /**
     * Get ImporteFranqueado value
     * @return string|null
     */
    public function getImporteFranqueado()
    {
        return $this->ImporteFranqueado;
    }
    /**
     * Set ImporteFranqueado value
     * @param string $_importeFranqueado the ImporteFranqueado
     * @return string
     */
    public function setImporteFranqueado($_importeFranqueado)
    {
        return ($this->ImporteFranqueado = $_importeFranqueado);
    }
    /**
     * Get CodPromocion value
     * @return string|null
     */
    public function getCodPromocion()
    {
        return $this->CodPromocion;
    }
    /**
     * Set CodPromocion value
     * @param string $_codPromocion the CodPromocion
     * @return string
     */
    public function setCodPromocion($_codPromocion)
    {
        return ($this->CodPromocion = $_codPromocion);
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
     * Get OficinaElegida value
     * @return string|null
     */
    public function getOficinaElegida()
    {
        return $this->OficinaElegida;
    }
    /**
     * Set OficinaElegida value
     * @param string $_oficinaElegida the OficinaElegida
     * @return string
     */
    public function setOficinaElegida($_oficinaElegida)
    {
        return ($this->OficinaElegida = $_oficinaElegida);
    }
    /**
     * Get Pesos value
     * @return CorreosStructPesos|null
     */
    public function getPesos()
    {
        return $this->Pesos;
    }
    /**
     * Set Pesos value
     * @param CorreosStructPesos $_pesos the Pesos
     * @return CorreosStructPesos
     */
    public function setPesos($_pesos)
    {
        return ($this->Pesos = $_pesos);
    }
    /**
     * Get Largo value
     * @return integer|null
     */
    public function getLargo()
    {
        return $this->Largo;
    }
    /**
     * Set Largo value
     * @param integer $_largo the Largo
     * @return integer
     */
    public function setLargo($_largo)
    {
        return ($this->Largo = $_largo);
    }
    /**
     * Get Alto value
     * @return integer|null
     */
    public function getAlto()
    {
        return $this->Alto;
    }
    /**
     * Set Alto value
     * @param integer $_alto the Alto
     * @return integer
     */
    public function setAlto($_alto)
    {
        return ($this->Alto = $_alto);
    }
    /**
     * Get Ancho value
     * @return integer|null
     */
    public function getAncho()
    {
        return $this->Ancho;
    }
    /**
     * Set Ancho value
     * @param integer $_ancho the Ancho
     * @return integer
     */
    public function setAncho($_ancho)
    {
        return ($this->Ancho = $_ancho);
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
     * Get CodigoEmbalajePrepago value
     * @return string|null
     */
    public function getCodigoEmbalajePrepago()
    {
        return $this->CodigoEmbalajePrepago;
    }
    /**
     * Set CodigoEmbalajePrepago value
     * @param string $_codigoEmbalajePrepago the CodigoEmbalajePrepago
     * @return string
     */
    public function setCodigoEmbalajePrepago($_codigoEmbalajePrepago)
    {
        return ($this->CodigoEmbalajePrepago = $_codigoEmbalajePrepago);
    }
    /**
     * Get CodigoPuntoAdmision value
     * @return string|null
     */
    public function getCodigoPuntoAdmision()
    {
        return $this->CodigoPuntoAdmision;
    }
    /**
     * Set CodigoPuntoAdmision value
     * @param string $_codigoPuntoAdmision the CodigoPuntoAdmision
     * @return string
     */
    public function setCodigoPuntoAdmision($_codigoPuntoAdmision)
    {
        return ($this->CodigoPuntoAdmision = $_codigoPuntoAdmision);
    }
    /**
     * Get FechaDepositoPrevista value
     * @return string|null
     */
    public function getFechaDepositoPrevista()
    {
        return $this->FechaDepositoPrevista;
    }
    /**
     * Set FechaDepositoPrevista value
     * @param string $_fechaDepositoPrevista the FechaDepositoPrevista
     * @return string
     */
    public function setFechaDepositoPrevista($_fechaDepositoPrevista)
    {
        return ($this->FechaDepositoPrevista = $_fechaDepositoPrevista);
    }
    /**
     * Get Observaciones1 value
     * @return string|null
     */
    public function getObservaciones1()
    {
        return $this->Observaciones1;
    }
    /**
     * Set Observaciones1 value
     * @param string $_observaciones1 the Observaciones1
     * @return string
     */
    public function setObservaciones1($_observaciones1)
    {
        return ($this->Observaciones1 = $_observaciones1);
    }
    /**
     * Get Observaciones2 value
     * @return string|null
     */
    public function getObservaciones2()
    {
        return $this->Observaciones2;
    }
    /**
     * Set Observaciones2 value
     * @param string $_observaciones2 the Observaciones2
     * @return string
     */
    public function setObservaciones2($_observaciones2)
    {
        return ($this->Observaciones2 = $_observaciones2);
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
     * Get Aduana value
     * @return CorreosStructADUANATYPE|null
     */
    public function getAduana()
    {
        return $this->Aduana;
    }
    /**
     * Set Aduana value
     * @param CorreosStructADUANATYPE $_aduana the Aduana
     * @return CorreosStructADUANATYPE
     */
    public function setAduana($_aduana)
    {
        return ($this->Aduana = $_aduana);
    }
    /**
     * Get CodigoIda value
     * @return string|null
     */
    public function getCodigoIda()
    {
        return $this->CodigoIda;
    }
    /**
     * Set CodigoIda value
     * @param string $_codigoIda the CodigoIda
     * @return string
     */
    public function setCodigoIda($_codigoIda)
    {
        return ($this->CodigoIda = $_codigoIda);
    }
    /**
     * Get PermiteEmbalaje value
     * @return string|null
     */
    public function getPermiteEmbalaje()
    {
        return $this->PermiteEmbalaje;
    }
    /**
     * Set PermiteEmbalaje value
     * @param string $_permiteEmbalaje the PermiteEmbalaje
     * @return string
     */
    public function setPermiteEmbalaje($_permiteEmbalaje)
    {
        return ($this->PermiteEmbalaje = $_permiteEmbalaje);
    }
    /**
     * Get FechaCaducidad value
     * @return string|null
     */
    public function getFechaCaducidad()
    {
        return $this->FechaCaducidad;
    }
    /**
     * Set FechaCaducidad value
     * @param string $_fechaCaducidad the FechaCaducidad
     * @return string
     */
    public function setFechaCaducidad($_fechaCaducidad)
    {
        return ($this->FechaCaducidad = $_fechaCaducidad);
    }
    /**
     * Get ReferenciaExpedicion value
     * @return string|null
     */
    public function getReferenciaExpedicion()
    {
        return $this->ReferenciaExpedicion;
    }
    /**
     * Set ReferenciaExpedicion value
     * @param string $_referenciaExpedicion the ReferenciaExpedicion
     * @return string
     */
    public function setReferenciaExpedicion($_referenciaExpedicion)
    {
        return ($this->ReferenciaExpedicion = $_referenciaExpedicion);
    }
    /**
     * Get CodigoHomepaq value
     * @return string|null
     */
    public function getCodigoHomepaq()
    {
        return $this->CodigoHomepaq;
    }
    /**
     * Set CodigoHomepaq value
     * @param string $_codigoHomepaq the CodigoHomepaq
     * @return string
     */
    public function setCodigoHomepaq($_codigoHomepaq)
    {
        return ($this->CodigoHomepaq = $_codigoHomepaq);
    }
    /**
     * Get ToquenIdCorPaq value
     * @return string|null
     */
    public function getToquenIdCorPaq()
    {
        return $this->ToquenIdCorPaq;
    }
    /**
     * Set ToquenIdCorPaq value
     * @param string $_toquenIdCorPaq the ToquenIdCorPaq
     * @return string
     */
    public function setToquenIdCorPaq($_toquenIdCorPaq)
    {
        return ($this->ToquenIdCorPaq = $_toquenIdCorPaq);
    }
    /**
     * Get AdmisionHomepaq value
     * @return CorreosEnumAdmisionHomepaq|null
     */
    public function getAdmisionHomepaq()
    {
        return $this->AdmisionHomepaq;
    }
    /**
     * Set AdmisionHomepaq value
     * @uses CorreosEnumAdmisionHomepaq::valueIsValid()
     * @param CorreosEnumAdmisionHomepaq $_admisionHomepaq the AdmisionHomepaq
     * @return CorreosEnumAdmisionHomepaq
     */
    public function setAdmisionHomepaq($_admisionHomepaq)
    {
        if(!CorreosEnumAdmisionHomepaq::valueIsValid($_admisionHomepaq))
        {
            return false;
        }
        return ($this->AdmisionHomepaq = $_admisionHomepaq);
    }
    /**
     * Get Documento1 value
     * @return string|null
     */
    public function getDocumento1()
    {
        return $this->Documento1;
    }
    /**
     * Set Documento1 value
     * @param string $_documento1 the Documento1
     * @return string
     */
    public function setDocumento1($_documento1)
    {
        return ($this->Documento1 = $_documento1);
    }
    /**
     * Get AccDocumento1 value
     * @return string|null
     */
    public function getAccDocumento1()
    {
        return $this->AccDocumento1;
    }
    /**
     * Set AccDocumento1 value
     * @param string $_accDocumento1 the AccDocumento1
     * @return string
     */
    public function setAccDocumento1($_accDocumento1)
    {
        return ($this->AccDocumento1 = $_accDocumento1);
    }
    /**
     * Get ObsDocumento1 value
     * @return string|null
     */
    public function getObsDocumento1()
    {
        return $this->ObsDocumento1;
    }
    /**
     * Set ObsDocumento1 value
     * @param string $_obsDocumento1 the ObsDocumento1
     * @return string
     */
    public function setObsDocumento1($_obsDocumento1)
    {
        return ($this->ObsDocumento1 = $_obsDocumento1);
    }
    /**
     * Get Documento2 value
     * @return string|null
     */
    public function getDocumento2()
    {
        return $this->Documento2;
    }
    /**
     * Set Documento2 value
     * @param string $_documento2 the Documento2
     * @return string
     */
    public function setDocumento2($_documento2)
    {
        return ($this->Documento2 = $_documento2);
    }
    /**
     * Get AccDocumento2 value
     * @return string|null
     */
    public function getAccDocumento2()
    {
        return $this->AccDocumento2;
    }
    /**
     * Set AccDocumento2 value
     * @param string $_accDocumento2 the AccDocumento2
     * @return string
     */
    public function setAccDocumento2($_accDocumento2)
    {
        return ($this->AccDocumento2 = $_accDocumento2);
    }
    /**
     * Get ObsDocumento2 value
     * @return string|null
     */
    public function getObsDocumento2()
    {
        return $this->ObsDocumento2;
    }
    /**
     * Set ObsDocumento2 value
     * @param string $_obsDocumento2 the ObsDocumento2
     * @return string
     */
    public function setObsDocumento2($_obsDocumento2)
    {
        return ($this->ObsDocumento2 = $_obsDocumento2);
    }
    /**
     * Get Documento3 value
     * @return string|null
     */
    public function getDocumento3()
    {
        return $this->Documento3;
    }
    /**
     * Set Documento3 value
     * @param string $_documento3 the Documento3
     * @return string
     */
    public function setDocumento3($_documento3)
    {
        return ($this->Documento3 = $_documento3);
    }
    /**
     * Get AccDocumento3 value
     * @return string|null
     */
    public function getAccDocumento3()
    {
        return $this->AccDocumento3;
    }
    /**
     * Set AccDocumento3 value
     * @param string $_accDocumento3 the AccDocumento3
     * @return string
     */
    public function setAccDocumento3($_accDocumento3)
    {
        return ($this->AccDocumento3 = $_accDocumento3);
    }
    /**
     * Get ObsDocumento3 value
     * @return string|null
     */
    public function getObsDocumento3()
    {
        return $this->ObsDocumento3;
    }
    /**
     * Set ObsDocumento3 value
     * @param string $_obsDocumento3 the ObsDocumento3
     * @return string
     */
    public function setObsDocumento3($_obsDocumento3)
    {
        return ($this->ObsDocumento3 = $_obsDocumento3);
    }
    /**
     * Get OperadorPostal value
     * @return string|null
     */
    public function getOperadorPostal()
    {
        return $this->OperadorPostal;
    }
    /**
     * Set OperadorPostal value
     * @param string $_operadorPostal the OperadorPostal
     * @return string
     */
    public function setOperadorPostal($_operadorPostal)
    {
        return ($this->OperadorPostal = $_operadorPostal);
    }
    /**
     * Get CodigoEnvioOriginal value
     * @return string|null
     */
    public function getCodigoEnvioOriginal()
    {
        return $this->CodigoEnvioOriginal;
    }
    /**
     * Set CodigoEnvioOriginal value
     * @param string $_codigoEnvioOriginal the CodigoEnvioOriginal
     * @return string
     */
    public function setCodigoEnvioOriginal($_codigoEnvioOriginal)
    {
        return ($this->CodigoEnvioOriginal = $_codigoEnvioOriginal);
    }
    /**
     * Get ExisteEnvioVueltaLI value
     * @return string|null
     */
    public function getExisteEnvioVueltaLI()
    {
        return $this->ExisteEnvioVueltaLI;
    }
    /**
     * Set ExisteEnvioVueltaLI value
     * @param string $_existeEnvioVueltaLI the ExisteEnvioVueltaLI
     * @return string
     */
    public function setExisteEnvioVueltaLI($_existeEnvioVueltaLI)
    {
        return ($this->ExisteEnvioVueltaLI = $_existeEnvioVueltaLI);
    }
    /**
     * Get SeguroLI value
     * @return string|null
     */
    public function getSeguroLI()
    {
        return $this->SeguroLI;
    }
    /**
     * Set SeguroLI value
     * @param string $_seguroLI the SeguroLI
     * @return string
     */
    public function setSeguroLI($_seguroLI)
    {
        return ($this->SeguroLI = $_seguroLI);
    }
    /**
     * Get ImporteSeguroLI value
     * @return string|null
     */
    public function getImporteSeguroLI()
    {
        return $this->ImporteSeguroLI;
    }
    /**
     * Set ImporteSeguroLI value
     * @param string $_importeSeguroLI the ImporteSeguroLI
     * @return string
     */
    public function setImporteSeguroLI($_importeSeguroLI)
    {
        return ($this->ImporteSeguroLI = $_importeSeguroLI);
    }
    /**
     * Get ReembolsoLI value
     * @return string|null
     */
    public function getReembolsoLI()
    {
        return $this->ReembolsoLI;
    }
    /**
     * Set ReembolsoLI value
     * @param string $_reembolsoLI the ReembolsoLI
     * @return string
     */
    public function setReembolsoLI($_reembolsoLI)
    {
        return ($this->ReembolsoLI = $_reembolsoLI);
    }
    /**
     * Get ImporteReembolsoLI value
     * @return string|null
     */
    public function getImporteReembolsoLI()
    {
        return $this->ImporteReembolsoLI;
    }
    /**
     * Set ImporteReembolsoLI value
     * @param string $_importeReembolsoLI the ImporteReembolsoLI
     * @return string
     */
    public function setImporteReembolsoLI($_importeReembolsoLI)
    {
        return ($this->ImporteReembolsoLI = $_importeReembolsoLI);
    }
    /**
     * Get TipoReembolsoLI value
     * @return string|null
     */
    public function getTipoReembolsoLI()
    {
        return $this->TipoReembolsoLI;
    }
    /**
     * Set TipoReembolsoLI value
     * @param string $_tipoReembolsoLI the TipoReembolsoLI
     * @return string
     */
    public function setTipoReembolsoLI($_tipoReembolsoLI)
    {
        return ($this->TipoReembolsoLI = $_tipoReembolsoLI);
    }
    /**
     * Get NumeroCuentaLI value
     * @return string|null
     */
    public function getNumeroCuentaLI()
    {
        return $this->NumeroCuentaLI;
    }
    /**
     * Set NumeroCuentaLI value
     * @param string $_numeroCuentaLI the NumeroCuentaLI
     * @return string
     */
    public function setNumeroCuentaLI($_numeroCuentaLI)
    {
        return ($this->NumeroCuentaLI = $_numeroCuentaLI);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructDATOSENVIOTYPE
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
