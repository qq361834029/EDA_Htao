<?php
/**
 * File for class CorreosStructVATYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructVATYPE originally named VATYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructVATYPE extends CorreosWsdlClass
{
    /**
     * The ImporteSeguro
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 6
     * @var string
     */
    public $ImporteSeguro;
    /**
     * The Reembolso
     * @var CorreosStructREEMBOLSOTYPE
     */
    public $Reembolso;
    /**
     * The EntregaExclusivaDestinatario
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $EntregaExclusivaDestinatario;
    /**
     * The PruebaEntrega
     * @var CorreosStructPRUEBAENTREGATYPE
     */
    public $PruebaEntrega;
    /**
     * The Recogidaadomicilio
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $Recogidaadomicilio;
    /**
     * The DevolucionAlbaran
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $DevolucionAlbaran;
    /**
     * The RepartoenSabado
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $RepartoenSabado;
    /**
     * The EntregaConcertada
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * @var string
     */
    public $EntregaConcertada;
    /**
     * The FranjaHorariaConcertada
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * @var string
     */
    public $FranjaHorariaConcertada;
    /**
     * The EntregaconRecogida
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $EntregaconRecogida;
    /**
     * The IndImprimirEtiqueta
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $IndImprimirEtiqueta;
    /**
     * The TextoAdicional
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 100
     * @var string
     */
    public $TextoAdicional;
    /**
     * The TiempoEnLista
     * @var integer
     */
    public $TiempoEnLista;
    /**
     * The IntentosDeEntrega
     * @var integer
     */
    public $IntentosDeEntrega;
    /**
     * Constructor method for VATYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_importeSeguro
     * CorreosStructREEMBOLSOTYPE $_reembolso
     * string $_entregaExclusivaDestinatario
     * CorreosStructPRUEBAENTREGATYPE $_pruebaEntrega
     * string $_recogidaadomicilio
     * string $_devolucionAlbaran
     * string $_repartoenSabado
     * string $_entregaConcertada
     * string $_franjaHorariaConcertada
     * string $_entregaconRecogida
     * string $_indImprimirEtiqueta
     * string $_textoAdicional
     * integer $_tiempoEnLista
     * integer $_intentosDeEntrega
     * @return CorreosStructVATYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'ImporteSeguro'					=> NULL,
			'Reembolso'						=> NULL,
			'EntregaExclusivaDestinatario'	=> NULL,
			'PruebaEntrega'					=> NULL,
			'Recogidaadomicilio'			=> NULL,
			'DevolucionAlbaran'				=> NULL,
			'RepartoenSabado'				=> NULL,
			'EntregaConcertada'				=> NULL,
			'FranjaHorariaConcertada'		=> NULL,
			'EntregaconRecogida'			=> NULL,
			'IndImprimirEtiqueta'			=> NULL,
			'TextoAdicional'				=> NULL,
			'TiempoEnLista'					=> NULL,
			'IntentosDeEntrega'				=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get ImporteSeguro value
     * @return string|null
     */
    public function getImporteSeguro()
    {
        return $this->ImporteSeguro;
    }
    /**
     * Set ImporteSeguro value
     * @param string $_importeSeguro the ImporteSeguro
     * @return string
     */
    public function setImporteSeguro($_importeSeguro)
    {
        return ($this->ImporteSeguro = $_importeSeguro);
    }
    /**
     * Get Reembolso value
     * @return CorreosStructREEMBOLSOTYPE|null
     */
    public function getReembolso()
    {
        return $this->Reembolso;
    }
    /**
     * Set Reembolso value
     * @param CorreosStructREEMBOLSOTYPE $_reembolso the Reembolso
     * @return CorreosStructREEMBOLSOTYPE
     */
    public function setReembolso($_reembolso)
    {
        return ($this->Reembolso = $_reembolso);
    }
    /**
     * Get EntregaExclusivaDestinatario value
     * @return string|null
     */
    public function getEntregaExclusivaDestinatario()
    {
        return $this->EntregaExclusivaDestinatario;
    }
    /**
     * Set EntregaExclusivaDestinatario value
     * @param string $_entregaExclusivaDestinatario the EntregaExclusivaDestinatario
     * @return string
     */
    public function setEntregaExclusivaDestinatario($_entregaExclusivaDestinatario)
    {
        return ($this->EntregaExclusivaDestinatario = $_entregaExclusivaDestinatario);
    }
    /**
     * Get PruebaEntrega value
     * @return CorreosStructPRUEBAENTREGATYPE|null
     */
    public function getPruebaEntrega()
    {
        return $this->PruebaEntrega;
    }
    /**
     * Set PruebaEntrega value
     * @param CorreosStructPRUEBAENTREGATYPE $_pruebaEntrega the PruebaEntrega
     * @return CorreosStructPRUEBAENTREGATYPE
     */
    public function setPruebaEntrega($_pruebaEntrega)
    {
        return ($this->PruebaEntrega = $_pruebaEntrega);
    }
    /**
     * Get Recogidaadomicilio value
     * @return string|null
     */
    public function getRecogidaadomicilio()
    {
        return $this->Recogidaadomicilio;
    }
    /**
     * Set Recogidaadomicilio value
     * @param string $_recogidaadomicilio the Recogidaadomicilio
     * @return string
     */
    public function setRecogidaadomicilio($_recogidaadomicilio)
    {
        return ($this->Recogidaadomicilio = $_recogidaadomicilio);
    }
    /**
     * Get DevolucionAlbaran value
     * @return string|null
     */
    public function getDevolucionAlbaran()
    {
        return $this->DevolucionAlbaran;
    }
    /**
     * Set DevolucionAlbaran value
     * @param string $_devolucionAlbaran the DevolucionAlbaran
     * @return string
     */
    public function setDevolucionAlbaran($_devolucionAlbaran)
    {
        return ($this->DevolucionAlbaran = $_devolucionAlbaran);
    }
    /**
     * Get RepartoenSabado value
     * @return string|null
     */
    public function getRepartoenSabado()
    {
        return $this->RepartoenSabado;
    }
    /**
     * Set RepartoenSabado value
     * @param string $_repartoenSabado the RepartoenSabado
     * @return string
     */
    public function setRepartoenSabado($_repartoenSabado)
    {
        return ($this->RepartoenSabado = $_repartoenSabado);
    }
    /**
     * Get EntregaConcertada value
     * @return string|null
     */
    public function getEntregaConcertada()
    {
        return $this->EntregaConcertada;
    }
    /**
     * Set EntregaConcertada value
     * @param string $_entregaConcertada the EntregaConcertada
     * @return string
     */
    public function setEntregaConcertada($_entregaConcertada)
    {
        return ($this->EntregaConcertada = $_entregaConcertada);
    }
    /**
     * Get FranjaHorariaConcertada value
     * @return string|null
     */
    public function getFranjaHorariaConcertada()
    {
        return $this->FranjaHorariaConcertada;
    }
    /**
     * Set FranjaHorariaConcertada value
     * @param string $_franjaHorariaConcertada the FranjaHorariaConcertada
     * @return string
     */
    public function setFranjaHorariaConcertada($_franjaHorariaConcertada)
    {
        return ($this->FranjaHorariaConcertada = $_franjaHorariaConcertada);
    }
    /**
     * Get EntregaconRecogida value
     * @return string|null
     */
    public function getEntregaconRecogida()
    {
        return $this->EntregaconRecogida;
    }
    /**
     * Set EntregaconRecogida value
     * @param string $_entregaconRecogida the EntregaconRecogida
     * @return string
     */
    public function setEntregaconRecogida($_entregaconRecogida)
    {
        return ($this->EntregaconRecogida = $_entregaconRecogida);
    }
    /**
     * Get IndImprimirEtiqueta value
     * @return string|null
     */
    public function getIndImprimirEtiqueta()
    {
        return $this->IndImprimirEtiqueta;
    }
    /**
     * Set IndImprimirEtiqueta value
     * @param string $_indImprimirEtiqueta the IndImprimirEtiqueta
     * @return string
     */
    public function setIndImprimirEtiqueta($_indImprimirEtiqueta)
    {
        return ($this->IndImprimirEtiqueta = $_indImprimirEtiqueta);
    }
    /**
     * Get TextoAdicional value
     * @return string|null
     */
    public function getTextoAdicional()
    {
        return $this->TextoAdicional;
    }
    /**
     * Set TextoAdicional value
     * @param string $_textoAdicional the TextoAdicional
     * @return string
     */
    public function setTextoAdicional($_textoAdicional)
    {
        return ($this->TextoAdicional = $_textoAdicional);
    }
    /**
     * Get TiempoEnLista value
     * @return integer|null
     */
    public function getTiempoEnLista()
    {
        return $this->TiempoEnLista;
    }
    /**
     * Set TiempoEnLista value
     * @param integer $_tiempoEnLista the TiempoEnLista
     * @return integer
     */
    public function setTiempoEnLista($_tiempoEnLista)
    {
        return ($this->TiempoEnLista = $_tiempoEnLista);
    }
    /**
     * Get IntentosDeEntrega value
     * @return integer|null
     */
    public function getIntentosDeEntrega()
    {
        return $this->IntentosDeEntrega;
    }
    /**
     * Set IntentosDeEntrega value
     * @param integer $_intentosDeEntrega the IntentosDeEntrega
     * @return integer
     */
    public function setIntentosDeEntrega($_intentosDeEntrega)
    {
        return ($this->IntentosDeEntrega = $_intentosDeEntrega);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructVATYPE
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
