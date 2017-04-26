<?php
/**
 * File for class DHLStructAttendance
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructAttendance originally named Attendance
 * Documentation : A DHL customer can have attendances = subIDs added to one account number for better management. Field length must be = 2.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructAttendance extends DHLWsdlClass
{
    /**
     * The partnerID
     * Meta informations extracted from the WSDL
     * - documentation : Field has the partner id. I.e. the last 2 digit number extract from the 14 digit DHL Account Number. E.g. if DHL Account Number is "5000000008 72 01" then Attendance is 01.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
     * - maxLength : 2
     * - minLength : 2
     * @var string
     */
    public $partnerID;
    /**
     * Constructor method for Attendance
     * @see parent::__construct()
     * @param string $_partnerID
     * @return DHLStructAttendance
     */
    public function __construct($_partnerID = NULL)
    {
        parent::__construct(array('partnerID'=>$_partnerID),false);
    }
    /**
     * Get partnerID value
     * @return string|null
     */
    public function getPartnerID()
    {
        return $this->partnerID;
    }
    /**
     * Set partnerID value
     * @param string $_partnerID the partnerID
     * @return string
     */
    public function setPartnerID($_partnerID)
    {
        return ($this->partnerID = $_partnerID);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructAttendance
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
