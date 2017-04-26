<?php
/**
 * File for class DHLStructVersion
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructVersion originally named Version
 * Documentation : Version numbers containing major/minor release and an optional build id. includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructVersion extends DHLWsdlClass
{
    /**
     * The majorRelease
     * Meta informations extracted from the WSDL
     * - documentation : The number of the major release. E.g. the '2' in version "2.1.".
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 2
     * @var string
     */
    public $majorRelease;
    /**
     * The minorRelease
     * Meta informations extracted from the WSDL
     * - documentation : The number of the minor release. E.g. the '1' in version "2.1.".
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 2
     * @var string
     */
    public $minorRelease;
    /**
     * The build
     * Meta informations extracted from the WSDL
     * - documentation : Optional build id to be addressed.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 5
     * @var string
     */
    public $build;
    /**
     * Constructor method for Version
     * @see parent::__construct()
     * @param string $_majorRelease
     * @param string $_minorRelease
     * @param string $_build
     * @return DHLStructVersion
     */
    public function __construct($_majorRelease = NULL,$_minorRelease = NULL,$_build = NULL)
    {
        parent::__construct(array('majorRelease'=>$_majorRelease,'minorRelease'=>$_minorRelease,'build'=>$_build),false);
    }
    /**
     * Get majorRelease value
     * @return string|null
     */
    public function getMajorRelease()
    {
        return $this->majorRelease;
    }
    /**
     * Set majorRelease value
     * @param string $_majorRelease the majorRelease
     * @return string
     */
    public function setMajorRelease($_majorRelease)
    {
        return ($this->majorRelease = $_majorRelease);
    }
    /**
     * Get minorRelease value
     * @return string|null
     */
    public function getMinorRelease()
    {
        return $this->minorRelease;
    }
    /**
     * Set minorRelease value
     * @param string $_minorRelease the minorRelease
     * @return string
     */
    public function setMinorRelease($_minorRelease)
    {
        return ($this->minorRelease = $_minorRelease);
    }
    /**
     * Get build value
     * @return string|null
     */
    public function getBuild()
    {
        return $this->build;
    }
    /**
     * Set build value
     * @param string $_build the build
     * @return string
     */
    public function setBuild($_build)
    {
        return ($this->build = $_build);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructVersion
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
