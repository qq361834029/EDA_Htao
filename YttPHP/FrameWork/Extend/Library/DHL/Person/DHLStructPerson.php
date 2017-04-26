<?php
/**
 * File for class DHLStructPerson
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructPerson originally named Person
 * Documentation : Name is a person. includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructPerson extends DHLWsdlClass
{
    /**
     * The salutation
     * Meta informations extracted from the WSDL
     * - documentation : Salutation of person (Mr./Mrs.).
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * @var string
     */
    public $salutation;
    /**
     * The title
     * Meta informations extracted from the WSDL
     * - documentation : Title of person (e.g. 'Dr.').
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 10
     * @var string
     */
    public $title;
    /**
     * The firstname
     * Meta informations extracted from the WSDL
     * - documentation : First name.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $firstname;
    /**
     * The middlename
     * Meta informations extracted from the WSDL
     * - documentation : Middle name.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $middlename;
    /**
     * The lastname
     * Meta informations extracted from the WSDL
     * - documentation : Last name of person.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $lastname;
    /**
     * Constructor method for Person
     * @see parent::__construct()
     * @param string $_salutation
     * @param string $_title
     * @param string $_firstname
     * @param string $_middlename
     * @param string $_lastname
     * @return DHLStructPerson
     */
    public function __construct($_salutation = NULL,$_title = NULL,$_firstname = NULL,$_middlename = NULL,$_lastname = NULL)
    {
        parent::__construct(array('salutation'=>$_salutation,'title'=>$_title,'firstname'=>$_firstname,'middlename'=>$_middlename,'lastname'=>$_lastname),false);
    }
    /**
     * Get salutation value
     * @return string|null
     */
    public function getSalutation()
    {
        return $this->salutation;
    }
    /**
     * Set salutation value
     * @param string $_salutation the salutation
     * @return string
     */
    public function setSalutation($_salutation)
    {
        return ($this->salutation = $_salutation);
    }
    /**
     * Get title value
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Set title value
     * @param string $_title the title
     * @return string
     */
    public function setTitle($_title)
    {
        return ($this->title = $_title);
    }
    /**
     * Get firstname value
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    /**
     * Set firstname value
     * @param string $_firstname the firstname
     * @return string
     */
    public function setFirstname($_firstname)
    {
        return ($this->firstname = $_firstname);
    }
    /**
     * Get middlename value
     * @return string|null
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }
    /**
     * Set middlename value
     * @param string $_middlename the middlename
     * @return string
     */
    public function setMiddlename($_middlename)
    {
        return ($this->middlename = $_middlename);
    }
    /**
     * Get lastname value
     * @return string|null
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    /**
     * Set lastname value
     * @param string $_lastname the lastname
     * @return string
     */
    public function setLastname($_lastname)
    {
        return ($this->lastname = $_lastname);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructPerson
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
