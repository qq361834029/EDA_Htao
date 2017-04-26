<?php
/**
 * File for class DHLStructNameType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructNameType originally named NameType
 * Documentation : Type of name can be
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructNameType extends DHLWsdlClass
{
    /**
     * The Person
     * @var DHLStructPerson
     */
    public $Person;
    /**
     * The Company
     * @var DHLStructCompany
     */
    public $Company;
    /**
     * Constructor method for NameType
     * @see parent::__construct()
     * @param DHLStructPerson $_person
     * @param DHLStructCompany $_company
     * @return DHLStructNameType
     */
    public function __construct($_person = NULL,$_company = NULL)
    {
        parent::__construct(array('Person'=>$_person,'Company'=>$_company),false);
    }
    /**
     * Get Person value
     * @return DHLStructPerson|null
     */
    public function getPerson()
    {
        return $this->Person;
    }
    /**
     * Set Person value
     * @param DHLStructPerson $_person the Person
     * @return DHLStructPerson
     */
    public function setPerson($_person)
    {
        return ($this->Person = $_person);
    }
    /**
     * Get Company value
     * @return DHLStructCompany|null
     */
    public function getCompany()
    {
        return $this->Company;
    }
    /**
     * Set Company value
     * @param DHLStructCompany $_company the Company
     * @return DHLStructCompany
     */
    public function setCompany($_company)
    {
        return ($this->Company = $_company);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructNameType
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
