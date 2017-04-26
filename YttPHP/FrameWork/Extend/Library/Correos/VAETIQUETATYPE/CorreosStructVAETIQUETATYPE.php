<?php
/**
 * File for class CorreosStructVAETIQUETATYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructVAETIQUETATYPE originally named VAETIQUETATYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructVAETIQUETATYPE extends CorreosWsdlClass
{
    /**
     * The ImporteReembolso
     * @var string
     */
    public $ImporteReembolso;
    /**
     * The DUA
     * @var CorreosEnumDUA
     */
    public $DUA;
    /**
     * The eAR
     * @var CorreosEnumEAR
     */
    public $eAR;
    /**
     * The EntregaExclusiva
     * @var CorreosEnumEntregaExclusiva
     */
    public $EntregaExclusiva;
    /**
     * The RepartoSabado
     * @var CorreosEnumRepartoSabado
     */
    public $RepartoSabado;
    /**
     * The EntregaConcertada
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * @var string
     */
    public $EntregaConcertada;
    /**
     * The FechaEntregaConcertada
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * @var string
     */
    public $FechaEntregaConcertada;
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
     * Constructor method for VAETIQUETATYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_importeReembolso
     * CorreosEnumDUA $_dUA
     * CorreosEnumEAR $_eAR
     * CorreosEnumEntregaExclusiva $_entregaExclusiva
     * CorreosEnumRepartoSabado $_repartoSabado
     * string $_entregaConcertada
     * string $_fechaEntregaConcertada
     * string $_franjaHorariaConcertada
     * string $_entregaconRecogida
     * string $_indImprimirEtiqueta
     * string $_textoAdicional
     * @return CorreosStructVAETIQUETATYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'ImporteReembolso'			=> NULL,
			'DUA'						=> NULL,
			'eAR'						=> NULL,
			'EntregaExclusiva'			=> NULL,
			'RepartoSabado'				=> NULL,
			'EntregaConcertada'			=> NULL,
			'FechaEntregaConcertada'	=> NULL,
			'FranjaHorariaConcertada'	=> NULL,
			'EntregaconRecogida'		=> NULL,
			'IndImprimirEtiqueta'		=> NULL,
			'TextoAdicional'			=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get ImporteReembolso value
     * @return string|null
     */
    public function getImporteReembolso()
    {
        return $this->ImporteReembolso;
    }
    /**
     * Set ImporteReembolso value
     * @param string $_importeReembolso the ImporteReembolso
     * @return string
     */
    public function setImporteReembolso($_importeReembolso)
    {
        return ($this->ImporteReembolso = $_importeReembolso);
    }
    /**
     * Get DUA value
     * @return CorreosEnumDUA|null
     */
    public function getDUA()
    {
        return $this->DUA;
    }
    /**
     * Set DUA value
     * @uses CorreosEnumDUA::valueIsValid()
     * @param CorreosEnumDUA $_dUA the DUA
     * @return CorreosEnumDUA
     */
    public function setDUA($_dUA)
    {
        if(!CorreosEnumDUA::valueIsValid($_dUA))
        {
            return false;
        }
        return ($this->DUA = $_dUA);
    }
    /**
     * Get eAR value
     * @return CorreosEnumEAR|null
     */
    public function getEAR()
    {
        return $this->eAR;
    }
    /**
     * Set eAR value
     * @uses CorreosEnumEAR::valueIsValid()
     * @param CorreosEnumEAR $_eAR the eAR
     * @return CorreosEnumEAR
     */
    public function setEAR($_eAR)
    {
        if(!CorreosEnumEAR::valueIsValid($_eAR))
        {
            return false;
        }
        return ($this->eAR = $_eAR);
    }
    /**
     * Get EntregaExclusiva value
     * @return CorreosEnumEntregaExclusiva|null
     */
    public function getEntregaExclusiva()
    {
        return $this->EntregaExclusiva;
    }
    /**
     * Set EntregaExclusiva value
     * @uses CorreosEnumEntregaExclusiva::valueIsValid()
     * @param CorreosEnumEntregaExclusiva $_entregaExclusiva the EntregaExclusiva
     * @return CorreosEnumEntregaExclusiva
     */
    public function setEntregaExclusiva($_entregaExclusiva)
    {
        if(!CorreosEnumEntregaExclusiva::valueIsValid($_entregaExclusiva))
        {
            return false;
        }
        return ($this->EntregaExclusiva = $_entregaExclusiva);
    }
    /**
     * Get RepartoSabado value
     * @return CorreosEnumRepartoSabado|null
     */
    public function getRepartoSabado()
    {
        return $this->RepartoSabado;
    }
    /**
     * Set RepartoSabado value
     * @uses CorreosEnumRepartoSabado::valueIsValid()
     * @param CorreosEnumRepartoSabado $_repartoSabado the RepartoSabado
     * @return CorreosEnumRepartoSabado
     */
    public function setRepartoSabado($_repartoSabado)
    {
        if(!CorreosEnumRepartoSabado::valueIsValid($_repartoSabado))
        {
            return false;
        }
        return ($this->RepartoSabado = $_repartoSabado);
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
     * Get FechaEntregaConcertada value
     * @return string|null
     */
    public function getFechaEntregaConcertada()
    {
        return $this->FechaEntregaConcertada;
    }
    /**
     * Set FechaEntregaConcertada value
     * @param string $_fechaEntregaConcertada the FechaEntregaConcertada
     * @return string
     */
    public function setFechaEntregaConcertada($_fechaEntregaConcertada)
    {
        return ($this->FechaEntregaConcertada = $_fechaEntregaConcertada);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructVAETIQUETATYPE
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
