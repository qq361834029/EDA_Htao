<?php
/**
 * File for class CorreosStructETIQUETATYPE
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * This class stands for CorreosStructETIQUETATYPE originally named ETIQUETATYPE
 * Meta informations extracted from the WSDL
 * - from schema : var/wsdltophp.com/storage/wsdls/5b3b2a7cf5ba55358da1651b1211f84d/wsdl.xml
 * @package Correos
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosStructETIQUETATYPE extends CorreosWsdlClass
{
    /**
     * The Modo
     * @var CorreosEnumModo
     */
    public $Modo;
    /**
     * The Etiqueta_xml
     * @var CorreosStructDATOSETIQUETAXMLTYPE
     */
    public $Etiqueta_xml;
    /**
     * The Etiqueta_pdf
     * @var CorreosStructFICHEROADJUNTOTYPE
     */
    public $Etiqueta_pdf;
    /**
     * Constructor method for ETIQUETATYPE
     * @see parent::__construct()
     * @param array $_arrayOfValues
     * CorreosEnumModo $_modo
     * CorreosStructDATOSETIQUETAXMLTYPE $_etiqueta_xml
     * CorreosStructFICHEROADJUNTOTYPE $_etiqueta_pdf
     * @return CorreosStructETIQUETATYPE
     */
    public function __construct($_arrayOfValues = array())
    {
		$defaultValues	= array(
			'Modo'			=> NULL,
			'Etiqueta_xml'	=> NULL,
			'Etiqueta_pdf'	=> NULL,
		);
		foreach ($defaultValues as $key => $value) {
			$defaultValues[$key]	= array_key_exists($key, (array)$_arrayOfValues) ? $_arrayOfValues[$key] : $value;
		}
        parent::__construct($defaultValues,false);
    }
    /**
     * Get Modo value
     * @return CorreosEnumModo|null
     */
    public function getModo()
    {
        return $this->Modo;
    }
    /**
     * Set Modo value
     * @uses CorreosEnumModo::valueIsValid()
     * @param CorreosEnumModo $_modo the Modo
     * @return CorreosEnumModo
     */
    public function setModo($_modo)
    {
        if(!CorreosEnumModo::valueIsValid($_modo))
        {
            return false;
        }
        return ($this->Modo = $_modo);
    }
    /**
     * Get Etiqueta_xml value
     * @return CorreosStructDATOSETIQUETAXMLTYPE|null
     */
    public function getEtiqueta_xml()
    {
        return $this->Etiqueta_xml;
    }
    /**
     * Set Etiqueta_xml value
     * @param CorreosStructDATOSETIQUETAXMLTYPE $_etiqueta_xml the Etiqueta_xml
     * @return CorreosStructDATOSETIQUETAXMLTYPE
     */
    public function setEtiqueta_xml($_etiqueta_xml)
    {
        return ($this->Etiqueta_xml = $_etiqueta_xml);
    }
    /**
     * Get Etiqueta_pdf value
     * @return CorreosStructFICHEROADJUNTOTYPE|null
     */
    public function getEtiqueta_pdf()
    {
        return $this->Etiqueta_pdf;
    }
    /**
     * Set Etiqueta_pdf value
     * @param CorreosStructFICHEROADJUNTOTYPE $_etiqueta_pdf the Etiqueta_pdf
     * @return CorreosStructFICHEROADJUNTOTYPE
     */
    public function setEtiqueta_pdf($_etiqueta_pdf)
    {
        return ($this->Etiqueta_pdf = $_etiqueta_pdf);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see CorreosWsdlClass::__set_state()
     * @uses CorreosWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return CorreosStructETIQUETATYPE
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
