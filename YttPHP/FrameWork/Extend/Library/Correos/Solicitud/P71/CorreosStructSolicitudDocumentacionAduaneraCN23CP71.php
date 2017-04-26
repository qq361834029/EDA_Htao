<?php
/**
 * File for class CorreosStructSolicitudDocumentacionAduaneraCN23CP71
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructSolicitudDocumentacionAduaneraCN23CP71 originally named SolicitudDocumentacionAduaneraCN23CP71
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructSolicitudDocumentacionAduaneraCN23CP71 extends CorreosWsdlClass
{
    /**
     * The codCertificado
     * @var string
     */
    public $codCertificado;
    /**
     * Constructor method for SolicitudDocumentacionAduaneraCN23CP71
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * string $_codCertificado
     * @return CorreosStructSolicitudDocumentacionAduaneraCN23CP71
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'codCertificado'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructSolicitudDocumentacionAduaneraCN23CP71
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
