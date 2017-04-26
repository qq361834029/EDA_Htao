<?php
/**
 * File for class DHLStructErrorType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructErrorType originally named ErrorType
 * Documentation : Type of error includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructErrorType extends DHLWsdlClass
{
    /**
     * The priority
     * Meta informations extracted from the WSDL
     * - documentation : Priority (e.g. error, warnung, .....)
     * - minOccurs : 0
     * @var integer
     */
    public $priority;
    /**
     * The code
     * Meta informations extracted from the WSDL
     * - documentation : Code
     * @var integer
     */
    public $code;
    /**
     * The dateTime
     * Meta informations extracted from the WSDL
     * - documentation : Occurence
     * @var dateTime
     */
    public $dateTime;
    /**
     * The description
     * Meta informations extracted from the WSDL
     * - documentation : Short description
     * - minOccurs : 0
     * @var string
     */
    public $description;
    /**
     * The descriptionLong
     * Meta informations extracted from the WSDL
     * - documentation : Detailed description
     * - minOccurs : 0
     * @var string
     */
    public $descriptionLong;
    /**
     * The solution
     * Meta informations extracted from the WSDL
     * - documentation : Suggested solution
     * - minOccurs : 0
     * @var string
     */
    public $solution;
    /**
     * The application
     * Meta informations extracted from the WSDL
     * - documentation : Name of application
     * - minOccurs : 0
     * @var string
     */
    public $application;
    /**
     * The module
     * Meta informations extracted from the WSDL
     * - documentation : Module name
     * - minOccurs : 0
     * @var string
     */
    public $module;
    /**
     * Constructor method for ErrorType
     * @see parent::__construct()
     * @param integer $_priority
     * @param integer $_code
     * @param dateTime $_dateTime
     * @param string $_description
     * @param string $_descriptionLong
     * @param string $_solution
     * @param string $_application
     * @param string $_module
     * @return DHLStructErrorType
     */
    public function __construct($_priority = NULL,$_code = NULL,$_dateTime = NULL,$_description = NULL,$_descriptionLong = NULL,$_solution = NULL,$_application = NULL,$_module = NULL)
    {
        parent::__construct(array('priority'=>$_priority,'code'=>$_code,'dateTime'=>$_dateTime,'description'=>$_description,'descriptionLong'=>$_descriptionLong,'solution'=>$_solution,'application'=>$_application,'module'=>$_module),false);
    }
    /**
     * Get priority value
     * @return integer|null
     */
    public function getPriority()
    {
        return $this->priority;
    }
    /**
     * Set priority value
     * @param integer $_priority the priority
     * @return integer
     */
    public function setPriority($_priority)
    {
        return ($this->priority = $_priority);
    }
    /**
     * Get code value
     * @return integer|null
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Set code value
     * @param integer $_code the code
     * @return integer
     */
    public function setCode($_code)
    {
        return ($this->code = $_code);
    }
    /**
     * Get dateTime value
     * @return dateTime|null
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }
    /**
     * Set dateTime value
     * @param dateTime $_dateTime the dateTime
     * @return dateTime
     */
    public function setDateTime($_dateTime)
    {
        return ($this->dateTime = $_dateTime);
    }
    /**
     * Get description value
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Set description value
     * @param string $_description the description
     * @return string
     */
    public function setDescription($_description)
    {
        return ($this->description = $_description);
    }
    /**
     * Get descriptionLong value
     * @return string|null
     */
    public function getDescriptionLong()
    {
        return $this->descriptionLong;
    }
    /**
     * Set descriptionLong value
     * @param string $_descriptionLong the descriptionLong
     * @return string
     */
    public function setDescriptionLong($_descriptionLong)
    {
        return ($this->descriptionLong = $_descriptionLong);
    }
    /**
     * Get solution value
     * @return string|null
     */
    public function getSolution()
    {
        return $this->solution;
    }
    /**
     * Set solution value
     * @param string $_solution the solution
     * @return string
     */
    public function setSolution($_solution)
    {
        return ($this->solution = $_solution);
    }
    /**
     * Get application value
     * @return string|null
     */
    public function getApplication()
    {
        return $this->application;
    }
    /**
     * Set application value
     * @param string $_application the application
     * @return string
     */
    public function setApplication($_application)
    {
        return ($this->application = $_application);
    }
    /**
     * Get module value
     * @return string|null
     */
    public function getModule()
    {
        return $this->module;
    }
    /**
     * Set module value
     * @param string $_module the module
     * @return string
     */
    public function setModule($_module)
    {
        return ($this->module = $_module);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructErrorType
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
