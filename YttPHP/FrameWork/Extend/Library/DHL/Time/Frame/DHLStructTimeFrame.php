<?php
/**
 * File for class DHLStructTimeFrame
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructTimeFrame originally named TimeFrame
 * Documentation : Time Frame in which actions should affect includes
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/cis_base.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructTimeFrame extends DHLWsdlClass
{
    /**
     * The from
     * Meta informations extracted from the WSDL
     * - documentation : begin of timeframe
     * @var time
     */
    public $from;
    /**
     * The until
     * Meta informations extracted from the WSDL
     * - documentation : end of timeframe
     * @var time
     */
    public $until;
    /**
     * Constructor method for TimeFrame
     * @see parent::__construct()
     * @param time $_from
     * @param time $_until
     * @return DHLStructTimeFrame
     */
    public function __construct($_from = NULL,$_until = NULL)
    {
        parent::__construct(array('from'=>$_from,'until'=>$_until),false);
    }
    /**
     * Get from value
     * @return time|null
     */
    public function getFrom()
    {
        return $this->from;
    }
    /**
     * Set from value
     * @param time $_from the from
     * @return time
     */
    public function setFrom($_from)
    {
        return ($this->from = $_from);
    }
    /**
     * Get until value
     * @return time|null
     */
    public function getUntil()
    {
        return $this->until;
    }
    /**
     * Set until value
     * @param time $_until the until
     * @return time
     */
    public function setUntil($_until)
    {
        return ($this->until = $_until);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructTimeFrame
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
