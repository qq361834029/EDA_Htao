<?php
/**
 * File for class DHLStructDrivingLicense
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDrivingLicense originally named DrivingLicense
 * Documentation : If driving license shall be used for verifying identity.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDrivingLicense extends DHLWsdlClass
{
    /**
     * The LicenseNumber
     * Meta informations extracted from the WSDL
     * - documentation : ID number of the driving license. Mandatory if DrivingLicense is chosen as identity instrument.
     * @var string
     */
    public $LicenseNumber;
    /**
     * The Authority
     * Meta informations extracted from the WSDL
     * - documentation : Name of certifying authority of the driving license. Mandatory if DrivingLicense is chosen as identity instrument.
     * @var string
     */
    public $Authority;
    /**
     * Constructor method for DrivingLicense
     * @see parent::__construct()
     * @param string $_licenseNumber
     * @param string $_authority
     * @return DHLStructDrivingLicense
     */
    public function __construct($_licenseNumber = NULL,$_authority = NULL)
    {
        parent::__construct(array('LicenseNumber'=>$_licenseNumber,'Authority'=>$_authority),false);
    }
    /**
     * Get LicenseNumber value
     * @return string|null
     */
    public function getLicenseNumber()
    {
        return $this->LicenseNumber;
    }
    /**
     * Set LicenseNumber value
     * @param string $_licenseNumber the LicenseNumber
     * @return string
     */
    public function setLicenseNumber($_licenseNumber)
    {
        return ($this->LicenseNumber = $_licenseNumber);
    }
    /**
     * Get Authority value
     * @return string|null
     */
    public function getAuthority()
    {
        return $this->Authority;
    }
    /**
     * Set Authority value
     * @param string $_authority the Authority
     * @return string
     */
    public function setAuthority($_authority)
    {
        return ($this->Authority = $_authority);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDrivingLicense
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
