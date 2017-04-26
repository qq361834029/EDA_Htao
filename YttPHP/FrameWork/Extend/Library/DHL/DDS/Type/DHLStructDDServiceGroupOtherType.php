<?php
/**
 * File for class DHLStructDDServiceGroupOtherType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructDDServiceGroupOtherType originally named DDServiceGroupOtherType
 * Documentation : Other DD Services.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructDDServiceGroupOtherType extends DHLWsdlClass
{
    /**
     * The HigherInsurance
     * @var DHLStructHigherInsurance
     */
    public $HigherInsurance;
    /**
     * The COD
     * @var DHLStructCOD
     */
    public $COD;
    /**
     * The Unfree
     * @var DHLStructUnfree
     */
    public $Unfree;
    /**
     * The DangerousGoods
     * @var DHLStructDangerousGoods
     */
    public $DangerousGoods;
    /**
     * The Bulkfreight
     * @var DHLStructBulkfreight
     */
    public $Bulkfreight;
    /**
     * The DirectInjection
     * Meta informations extracted from the WSDL
     * - documentation : Direct Injection Service.
     * @var boolean
     */
    public $DirectInjection;
    /**
     * The Bypass
     * Meta informations extracted from the WSDL
     * - documentation : Bypass Service.
     * @var boolean
     */
    public $Bypass;
    /**
     * Constructor method for DDServiceGroupOtherType
     * @see parent::__construct()
     * @param DHLStructHigherInsurance $_higherInsurance
     * @param DHLStructCOD $_cOD
     * @param DHLStructUnfree $_unfree
     * @param DHLStructDangerousGoods $_dangerousGoods
     * @param DHLStructBulkfreight $_bulkfreight
     * @param boolean $_directInjection
     * @param boolean $_bypass
     * @return DHLStructDDServiceGroupOtherType
     */
    public function __construct($_higherInsurance = NULL,$_cOD = NULL,$_unfree = NULL,$_dangerousGoods = NULL,$_bulkfreight = NULL,$_directInjection = NULL,$_bypass = NULL)
    {
        parent::__construct(array('HigherInsurance'=>$_higherInsurance,'COD'=>$_cOD,'Unfree'=>$_unfree,'DangerousGoods'=>$_dangerousGoods,'Bulkfreight'=>$_bulkfreight,'DirectInjection'=>$_directInjection,'Bypass'=>$_bypass),false);
    }
    /**
     * Get HigherInsurance value
     * @return DHLStructHigherInsurance|null
     */
    public function getHigherInsurance()
    {
        return $this->HigherInsurance;
    }
    /**
     * Set HigherInsurance value
     * @param DHLStructHigherInsurance $_higherInsurance the HigherInsurance
     * @return DHLStructHigherInsurance
     */
    public function setHigherInsurance($_higherInsurance)
    {
        return ($this->HigherInsurance = $_higherInsurance);
    }
    /**
     * Get COD value
     * @return DHLStructCOD|null
     */
    public function getCOD()
    {
        return $this->COD;
    }
    /**
     * Set COD value
     * @param DHLStructCOD $_cOD the COD
     * @return DHLStructCOD
     */
    public function setCOD($_cOD)
    {
        return ($this->COD = $_cOD);
    }
    /**
     * Get Unfree value
     * @return DHLStructUnfree|null
     */
    public function getUnfree()
    {
        return $this->Unfree;
    }
    /**
     * Set Unfree value
     * @param DHLStructUnfree $_unfree the Unfree
     * @return DHLStructUnfree
     */
    public function setUnfree($_unfree)
    {
        return ($this->Unfree = $_unfree);
    }
    /**
     * Get DangerousGoods value
     * @return DHLStructDangerousGoods|null
     */
    public function getDangerousGoods()
    {
        return $this->DangerousGoods;
    }
    /**
     * Set DangerousGoods value
     * @param DHLStructDangerousGoods $_dangerousGoods the DangerousGoods
     * @return DHLStructDangerousGoods
     */
    public function setDangerousGoods($_dangerousGoods)
    {
        return ($this->DangerousGoods = $_dangerousGoods);
    }
    /**
     * Get Bulkfreight value
     * @return DHLStructBulkfreight|null
     */
    public function getBulkfreight()
    {
        return $this->Bulkfreight;
    }
    /**
     * Set Bulkfreight value
     * @param DHLStructBulkfreight $_bulkfreight the Bulkfreight
     * @return DHLStructBulkfreight
     */
    public function setBulkfreight($_bulkfreight)
    {
        return ($this->Bulkfreight = $_bulkfreight);
    }
    /**
     * Get DirectInjection value
     * @return boolean|null
     */
    public function getDirectInjection()
    {
        return $this->DirectInjection;
    }
    /**
     * Set DirectInjection value
     * @param boolean $_directInjection the DirectInjection
     * @return boolean
     */
    public function setDirectInjection($_directInjection)
    {
        return ($this->DirectInjection = $_directInjection);
    }
    /**
     * Get Bypass value
     * @return boolean|null
     */
    public function getBypass()
    {
        return $this->Bypass;
    }
    /**
     * Set Bypass value
     * @param boolean $_bypass the Bypass
     * @return boolean
     */
    public function setBypass($_bypass)
    {
        return ($this->Bypass = $_bypass);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructDDServiceGroupOtherType
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
