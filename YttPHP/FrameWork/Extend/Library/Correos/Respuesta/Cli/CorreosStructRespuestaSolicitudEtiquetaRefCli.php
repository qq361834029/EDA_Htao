<?php
/**
 * File for class CorreosStructRespuestaSolicitudEtiquetaRefCli
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructRespuestaSolicitudEtiquetaRefCli originally named RespuestaSolicitudEtiquetaRefCli
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructRespuestaSolicitudEtiquetaRefCli extends CorreosWsdlClass
{
    /**
     * The CodExpedicion
     * Meta informations extracted from the WSDL
     * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
     * - maxLength : 16
     * @var string
     */
    public $CodExpedicion;
    /**
     * The FechaRespuesta
     * @var string
     */
    public $FechaRespuesta;
    /**
     * The Resultado
     * @var CorreosEnumResultado
     */
    public $Resultado;
    /**
     * The TotalBultos
     * @var integer
     */
    public $TotalBultos;
    /**
     * The Bulto
     * @var CorreosStructDATOSBULTOTYPE
     */
    public $Bulto;
    /**
     * The BultoError
     * @var CorreosStructDATOSBULTOERRORTYPE
     */
    public $BultoError;
    /**
     * Constructor method for RespuestaSolicitudEtiquetaRefCli
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_codExpedicion
     * string $_fechaRespuesta
     * CorreosEnumResultado $_resultado
     * integer $_totalBultos
     * CorreosStructDATOSBULTOTYPE $_bulto
     * CorreosStructDATOSBULTOERRORTYPE $_bultoError
     * @return CorreosStructRespuestaSolicitudEtiquetaRefCli
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'CodExpedicion'		=> NULL,
			'FechaRespuesta'	=> NULL,
			'Resultado'			=> NULL,
			'TotalBultos'		=> NULL,
			'Bulto'				=> NULL,
			'BultoError'		=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
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
     * Get FechaRespuesta value
     * @return string|null
     */
    public function getFechaRespuesta()
    {
        return $this->FechaRespuesta;
    }
    /**
     * Set FechaRespuesta value
     * @param string $_fechaRespuesta the FechaRespuesta
     * @return string
     */
    public function setFechaRespuesta($_fechaRespuesta)
    {
        return ($this->FechaRespuesta = $_fechaRespuesta);
    }
    /**
     * Get Resultado value
     * @return CorreosEnumResultado|null
     */
    public function getResultado()
    {
        return $this->Resultado;
    }
    /**
     * Set Resultado value
     * @uses CorreosEnumResultado::valueIsValid()
     * @param CorreosEnumResultado $_resultado the Resultado
     * @return CorreosEnumResultado
     */
    public function setResultado($_resultado)
    {
        if(!CorreosEnumResultado::valueIsValid($_resultado))
        {
            return false;
        }
        return ($this->Resultado = $_resultado);
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
     * Get Bulto value
     * @return CorreosStructDATOSBULTOTYPE|null
     */
    public function getBulto()
    {
        return $this->Bulto;
    }
    /**
     * Set Bulto value
     * @param CorreosStructDATOSBULTOTYPE $_bulto the Bulto
     * @return CorreosStructDATOSBULTOTYPE
     */
    public function setBulto($_bulto)
    {
        return ($this->Bulto = $_bulto);
    }
    /**
     * Get BultoError value
     * @return CorreosStructDATOSBULTOERRORTYPE|null
     */
    public function getBultoError()
    {
        return $this->BultoError;
    }
    /**
     * Set BultoError value
     * @param CorreosStructDATOSBULTOERRORTYPE $_bultoError the BultoError
     * @return CorreosStructDATOSBULTOERRORTYPE
     */
    public function setBultoError($_bultoError)
    {
        return ($this->BultoError = $_bultoError);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructRespuestaSolicitudEtiquetaRefCli
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
