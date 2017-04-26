<?php
/**
 * File for class CorreosStructRespuestaGenerarCodigoExpedicion
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructRespuestaGenerarCodigoExpedicion originally named RespuestaGenerarCodigoExpedicion
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructRespuestaGenerarCodigoExpedicion extends CorreosWsdlClass
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
     * The ErroresValidacion
     * @var CorreosStructLISTAERRORESVALIDACIONTYPE
     */
    public $ErroresValidacion;
    /**
     * Constructor method for RespuestaGenerarCodigoExpedicion
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_codExpedicion
     * string $_fechaRespuesta
     * CorreosEnumResultado $_resultado
     * CorreosStructLISTAERRORESVALIDACIONTYPE $_erroresValidacion
     * @return CorreosStructRespuestaGenerarCodigoExpedicion
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'CodExpedicion'		=> NULL,
			'FechaRespuesta'	=> NULL,
			'Resultado'			=> NULL,
			'ErroresValidacion'	=> NULL,
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
     * Get ErroresValidacion value
     * @return CorreosStructLISTAERRORESVALIDACIONTYPE|null
     */
    public function getErroresValidacion()
    {
        return $this->ErroresValidacion;
    }
    /**
     * Set ErroresValidacion value
     * @param CorreosStructLISTAERRORESVALIDACIONTYPE $_erroresValidacion the ErroresValidacion
     * @return CorreosStructLISTAERRORESVALIDACIONTYPE
     */
    public function setErroresValidacion($_erroresValidacion)
    {
        return ($this->ErroresValidacion = $_erroresValidacion);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructRespuestaGenerarCodigoExpedicion
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
