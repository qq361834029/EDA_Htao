<?php
/**
 * File for class DHLStructEndorsementServiceconfigurationTeZu
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructEndorsementServiceconfigurationTeZu originally named EndorsementServiceconfigurationTeZu
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructEndorsementServiceconfigurationTeZu extends DHLWsdlClass
{
    /**
     * The active
     * @var anonymous172
     */
    public $active;
    /**
     * The tezuDate
     * @var anonymous173
     */
    public $tezuDate;
    /**
     * Constructor method for EndorsementServiceconfigurationTeZu
     * @see parent::__construct()
     * @param anonymous172 $_active
     * @param anonymous173 $_tezuDate
     * @return DHLStructEndorsementServiceconfigurationTeZu
     */
    public function __construct($_active = NULL,$_tezuDate = NULL)
    {
        parent::__construct(array('active'=>$_active,'tezuDate'=>$_tezuDate),false);
    }
    /**
     * Get active value
     * @return anonymous172|null
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * Set active value
     * @param anonymous172 $_active the active
     * @return anonymous172
     */
    public function setActive($_active)
    {
        return ($this->active = $_active);
    }
    /**
     * Get tezuDate value
     * @return anonymous173|null
     */
    public function getTezuDate()
    {
        return $this->tezuDate;
    }
    /**
     * Set tezuDate value
     * @param anonymous173 $_tezuDate the tezuDate
     * @return anonymous173
     */
    public function setTezuDate($_tezuDate)
    {
        return ($this->tezuDate = $_tezuDate);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructEndorsementServiceconfigurationTeZu
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
