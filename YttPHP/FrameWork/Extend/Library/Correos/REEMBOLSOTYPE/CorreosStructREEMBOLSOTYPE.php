<?php
/**
 * File for class CorreosStructREEMBOLSOTYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructREEMBOLSOTYPE originally named REEMBOLSOTYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructREEMBOLSOTYPE extends CorreosWsdlClass
{
    /**
     * The TipoReembolso
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 2
     * @var string
     */
    public $TipoReembolso;
    /**
     * The Importe
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 6
     * @var string
     */
    public $Importe;
    /**
     * The NumeroCuenta
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 20
     * @var string
     */
    public $NumeroCuenta;
    /**
     * The Transferagrupada
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $Transferagrupada;
    /**
     * Constructor method for REEMBOLSOTYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_tipoReembolso
     * string $_importe
     * string $_numeroCuenta
     * string $_transferagrupada
     * @return CorreosStructREEMBOLSOTYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'TipoReembolso'		=> NULL,
			'Importe'			=> NULL,
			'NumeroCuenta'		=> NULL,
			'Transferagrupada'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get TipoReembolso value
     * @return string|null
     */
    public function getTipoReembolso()
    {
        return $this->TipoReembolso;
    }
    /**
     * Set TipoReembolso value
     * @param string $_tipoReembolso the TipoReembolso
     * @return string
     */
    public function setTipoReembolso($_tipoReembolso)
    {
        return ($this->TipoReembolso = $_tipoReembolso);
    }
    /**
     * Get Importe value
     * @return string|null
     */
    public function getImporte()
    {
        return $this->Importe;
    }
    /**
     * Set Importe value
     * @param string $_importe the Importe
     * @return string
     */
    public function setImporte($_importe)
    {
        return ($this->Importe = $_importe);
    }
    /**
     * Get NumeroCuenta value
     * @return string|null
     */
    public function getNumeroCuenta()
    {
        return $this->NumeroCuenta;
    }
    /**
     * Set NumeroCuenta value
     * @param string $_numeroCuenta the NumeroCuenta
     * @return string
     */
    public function setNumeroCuenta($_numeroCuenta)
    {
        return ($this->NumeroCuenta = $_numeroCuenta);
    }
    /**
     * Get Transferagrupada value
     * @return string|null
     */
    public function getTransferagrupada()
    {
        return $this->Transferagrupada;
    }
    /**
     * Set Transferagrupada value
     * @param string $_transferagrupada the Transferagrupada
     * @return string
     */
    public function setTransferagrupada($_transferagrupada)
    {
        return ($this->Transferagrupada = $_transferagrupada);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructREEMBOLSOTYPE
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
