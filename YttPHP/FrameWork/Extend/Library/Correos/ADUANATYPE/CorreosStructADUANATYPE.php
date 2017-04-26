<?php
/**
 * File for class CorreosStructADUANATYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructADUANATYPE originally named ADUANATYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructADUANATYPE extends CorreosWsdlClass
{
    /**
     * The TipoEnvio
     * @var CorreosEnumTipoEnvio
     */
    public $TipoEnvio;
    /**
     * The EnvioComercial
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $EnvioComercial;
    /**
     * The FacturaSuperiora500
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $FacturaSuperiora500;
    /**
     * The DUAConCorreos
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $DUAConCorreos;
    /**
     * The DescAduanera
     * @var CorreosStructDescAduanera
     */
    public $DescAduanera;
    /**
     * The Factura
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $Factura;
    /**
     * The Licencia
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $Licencia;
    /**
     * The Certificado
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 1
     * @var string
     */
    public $Certificado;
    /**
     * Constructor method for ADUANATYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosEnumTipoEnvio $_tipoEnvio
     * string $_envioComercial
     * string $_facturaSuperiora500
     * string $_dUAConCorreos
     * CorreosStructDescAduanera $_descAduanera
     * string $_factura
     * string $_licencia
     * string $_certificado
     * @return CorreosStructADUANATYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'TipoEnvio'				=> NULL,
			'EnvioComercial'		=> NULL,
			'FacturaSuperiora500'	=> NULL,
			'DUAConCorreos'			=> NULL,
			'DescAduanera'			=> NULL,
			'Factura'				=> NULL,
			'Licencia'				=> NULL,
			'Certificado'			=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get TipoEnvio value
     * @return CorreosEnumTipoEnvio|null
     */
    public function getTipoEnvio()
    {
        return $this->TipoEnvio;
    }
    /**
     * Set TipoEnvio value
     * @uses CorreosEnumTipoEnvio::valueIsValid()
     * @param CorreosEnumTipoEnvio $_tipoEnvio the TipoEnvio
     * @return CorreosEnumTipoEnvio
     */
    public function setTipoEnvio($_tipoEnvio)
    {
        if(!CorreosEnumTipoEnvio::valueIsValid($_tipoEnvio))
        {
            return false;
        }
        return ($this->TipoEnvio = $_tipoEnvio);
    }
    /**
     * Get EnvioComercial value
     * @return string|null
     */
    public function getEnvioComercial()
    {
        return $this->EnvioComercial;
    }
    /**
     * Set EnvioComercial value
     * @param string $_envioComercial the EnvioComercial
     * @return string
     */
    public function setEnvioComercial($_envioComercial)
    {
        return ($this->EnvioComercial = $_envioComercial);
    }
    /**
     * Get FacturaSuperiora500 value
     * @return string|null
     */
    public function getFacturaSuperiora500()
    {
        return $this->FacturaSuperiora500;
    }
    /**
     * Set FacturaSuperiora500 value
     * @param string $_facturaSuperiora500 the FacturaSuperiora500
     * @return string
     */
    public function setFacturaSuperiora500($_facturaSuperiora500)
    {
        return ($this->FacturaSuperiora500 = $_facturaSuperiora500);
    }
    /**
     * Get DUAConCorreos value
     * @return string|null
     */
    public function getDUAConCorreos()
    {
        return $this->DUAConCorreos;
    }
    /**
     * Set DUAConCorreos value
     * @param string $_dUAConCorreos the DUAConCorreos
     * @return string
     */
    public function setDUAConCorreos($_dUAConCorreos)
    {
        return ($this->DUAConCorreos = $_dUAConCorreos);
    }
    /**
     * Get DescAduanera value
     * @return CorreosStructDescAduanera|null
     */
    public function getDescAduanera()
    {
        return $this->DescAduanera;
    }
    /**
     * Set DescAduanera value
     * @param CorreosStructDescAduanera $_descAduanera the DescAduanera
     * @return CorreosStructDescAduanera
     */
    public function setDescAduanera($_descAduanera)
    {
        return ($this->DescAduanera = $_descAduanera);
    }
    /**
     * Get Factura value
     * @return string|null
     */
    public function getFactura()
    {
        return $this->Factura;
    }
    /**
     * Set Factura value
     * @param string $_factura the Factura
     * @return string
     */
    public function setFactura($_factura)
    {
        return ($this->Factura = $_factura);
    }
    /**
     * Get Licencia value
     * @return string|null
     */
    public function getLicencia()
    {
        return $this->Licencia;
    }
    /**
     * Set Licencia value
     * @param string $_licencia the Licencia
     * @return string
     */
    public function setLicencia($_licencia)
    {
        return ($this->Licencia = $_licencia);
    }
    /**
     * Get Certificado value
     * @return string|null
     */
    public function getCertificado()
    {
        return $this->Certificado;
    }
    /**
     * Set Certificado value
     * @param string $_certificado the Certificado
     * @return string
     */
    public function setCertificado($_certificado)
    {
        return ($this->Certificado = $_certificado);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructADUANATYPE
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
