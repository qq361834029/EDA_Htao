<?php
/**
 * File for class DHLStructShipmentItemType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentItemType originally named ShipmentItemType
 * Documentation : Item/Piece data.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentItemType extends DHLWsdlClass
{
    /**
     * The WeightInKG
     * Meta informations extracted from the WSDL
     * - documentation : The weight of the piece in kg (mandatory). Field length must be less than or equal to 22. The weight of all shipment's pieces in kg. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $WeightInKG;
    /**
     * The LengthInCM
     * Meta informations extracted from the WSDL
     * - documentation : The length of the piece in cm. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $LengthInCM;
    /**
     * The WidthInCM
     * Meta informations extracted from the WSDL
     * - documentation : The width of the piece in cm. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $WidthInCM;
    /**
     * The HeightInCM
     * Meta informations extracted from the WSDL
     * - documentation : The height of the piece in cm. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $HeightInCM;
    /**
     * Constructor method for ShipmentItemType
     * @see parent::__construct()
     * @param decimal $_weightInKG
     * @param integer $_lengthInCM
     * @param integer $_widthInCM
     * @param integer $_heightInCM
     * @return DHLStructShipmentItemType
     */
    public function __construct($_weightInKG = NULL,$_lengthInCM = NULL,$_widthInCM = NULL,$_heightInCM = NULL)
    {
        parent::__construct(array('WeightInKG'=>$_weightInKG,'LengthInCM'=>$_lengthInCM,'WidthInCM'=>$_widthInCM,'HeightInCM'=>$_heightInCM),false);
    }
    /**
     * Get WeightInKG value
     * @return decimal|null
     */
    public function getWeightInKG()
    {
        return $this->WeightInKG;
    }
    /**
     * Set WeightInKG value
     * @param decimal $_weightInKG the WeightInKG
     * @return decimal
     */
    public function setWeightInKG($_weightInKG)
    {
        return ($this->WeightInKG = $_weightInKG);
    }
    /**
     * Get LengthInCM value
     * @return integer|null
     */
    public function getLengthInCM()
    {
        return $this->LengthInCM;
    }
    /**
     * Set LengthInCM value
     * @param integer $_lengthInCM the LengthInCM
     * @return integer
     */
    public function setLengthInCM($_lengthInCM)
    {
        return ($this->LengthInCM = $_lengthInCM);
    }
    /**
     * Get WidthInCM value
     * @return integer|null
     */
    public function getWidthInCM()
    {
        return $this->WidthInCM;
    }
    /**
     * Set WidthInCM value
     * @param integer $_widthInCM the WidthInCM
     * @return integer
     */
    public function setWidthInCM($_widthInCM)
    {
        return ($this->WidthInCM = $_widthInCM);
    }
    /**
     * Get HeightInCM value
     * @return integer|null
     */
    public function getHeightInCM()
    {
        return $this->HeightInCM;
    }
    /**
     * Set HeightInCM value
     * @param integer $_heightInCM the HeightInCM
     * @return integer
     */
    public function setHeightInCM($_heightInCM)
    {
        return ($this->HeightInCM = $_heightInCM);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentItemType
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
