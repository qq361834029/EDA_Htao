<?php
/**
 * File for class DHLStructCompany
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructCompany originally named Company
 * Documentation : Name is a company. includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructCompany extends DHLWsdlClass
{
    /**
     * The name1
     * Meta informations extracted from the WSDL
     * - documentation : Name of company (first part).
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $name1;
    /**
     * The name2
     * Meta informations extracted from the WSDL
     * - documentation : Name of company (second part).
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 50
     * @var string
     */
    public $name2;
    /**
     * Constructor method for Company
     * @see parent::__construct()
     * @param string $_name1
     * @param string $_name2
     * @return DHLStructCompany
     */
    public function __construct($_name1 = NULL,$_name2 = NULL)
    {
        parent::__construct(array('name1'=>$_name1,'name2'=>$_name2),false);
    }
    /**
     * Get name1 value
     * @return string|null
     */
    public function getName1()
    {
        return $this->name1;
    }
    /**
     * Set name1 value
     * @param string $_name1 the name1
     * @return string
     */
    public function setName1($_name1)
    {
        return ($this->name1 = $_name1);
    }
    /**
     * Get name2 value
     * @return string|null
     */
    public function getName2()
    {
        return $this->name2;
    }
    /**
     * Set name2 value
     * @param string $_name2 the name2
     * @return string
     */
    public function setName2($_name2)
    {
        return ($this->name2 = $_name2);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructCompany
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
