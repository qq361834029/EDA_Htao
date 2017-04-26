<?php
/**
 * File for class DHLStructShipmentAdvisory
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentAdvisory originally named ShipmentAdvisory
 * Documentation : Service "SendungsAvise".
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentAdvisory extends DHLWsdlClass
{
    /**
     * The AdvisoryData
     * @var DHLStructAdvisoryData
     */
    public $AdvisoryData;
    /**
     * Constructor method for ShipmentAdvisory
     * @see parent::__construct()
     * @param DHLStructAdvisoryData $_advisoryData
     * @return DHLStructShipmentAdvisory
     */
    public function __construct($_advisoryData = NULL)
    {
        parent::__construct(array('AdvisoryData'=>$_advisoryData),false);
    }
    /**
     * Get AdvisoryData value
     * @return DHLStructAdvisoryData|null
     */
    public function getAdvisoryData()
    {
        return $this->AdvisoryData;
    }
    /**
     * Set AdvisoryData value
     * @param DHLStructAdvisoryData $_advisoryData the AdvisoryData
     * @return DHLStructAdvisoryData
     */
    public function setAdvisoryData($_advisoryData)
    {
        return ($this->AdvisoryData = $_advisoryData);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentAdvisory
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
