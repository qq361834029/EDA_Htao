<?php
/**
 * File for class DHLStructExportDocPosition
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructExportDocPosition originally named ExportDocPosition
 * Documentation : More than one position only possible for international TD shipments. One or more child elements for every position to be defined within the Export Document. One or more child elements for every position to be defined within the Export Document. Each one contains description, amount, value, net and gross weight, country code of origin et al. Multiple positions only possible for BPI, but not for EUP and EPI.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructExportDocPosition extends DHLWsdlClass
{
    /**
     * The Description
     * Meta informations extracted from the WSDL
     * - documentation : Description of the single position. Field length must be less than or equal to 40. Description of the respective position. Field length must be less than or equal to 40.
     * @var string
     */
    public $Description;
    /**
     * The Amount
     * Meta informations extracted from the WSDL
     * - documentation : Defines the amount of pieces of that respective position. Field length must be less than or equal to 22. Amount of shipment positions. Multiple positions not allowed for EUP and EPI, only BPI allows amount > 1. Field length must be less than or equal to 22. Defines the amount of pieces of that respective position. Minimum amount is 1. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 1
     * @var integer
     */
    public $Amount;
    /**
     * The ValuePerPiece
     * Meta informations extracted from the WSDL
     * - documentation : Defines the value of every piece of the position. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $ValuePerPiece;
    /**
     * The NetWeightInKG
     * Meta informations extracted from the WSDL
     * - documentation : Net weight of the shipment. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $NetWeightInKG;
    /**
     * The GrossWeightInKG
     * Meta informations extracted from the WSDL
     * - documentation : Gross weight of the shipment. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $GrossWeightInKG;
    /**
     * The ISOCountryCodeOfOrigin
     * Meta informations extracted from the WSDL
     * - documentation : Defines the ISO code of origin country. Field length must be = 2.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 2
     * @var string
     */
    public $ISOCountryCodeOfOrigin;
    /**
     * The CommodityCode
     * Meta informations extracted from the WSDL
     * - documentation : For trading internationally, the standardized international commodity codes for shipped goods are specified. Field length must be less than or equal to 30. Standardized international commodity code for respective position is specified. Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $CommodityCode;
    /**
     * The CountryCodeOrigin
     * Meta informations extracted from the WSDL
     * - documentation : Defines the ISO code of origin country.
     * @var string
     */
    public $CountryCodeOrigin;
    /**
     * The CustomsValue
     * Meta informations extracted from the WSDL
     * - documentation : Defines the declared customs value amount of the shipment. Field length must be less than or equal to 11. Defines the declared customs value amount of respective position. Field length must be less than or equal to 11.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $CustomsValue;
    /**
     * The CustomsCurrency
     * Meta informations extracted from the WSDL
     * - documentation : Sets the declared customs value currency of respective position.
     * @var string
     */
    public $CustomsCurrency;
    /**
     * Constructor method for ExportDocPosition
     * @see parent::__construct()
     * @param string $_description
     * @param integer $_amount
     * @param decimal $_valuePerPiece
     * @param decimal $_netWeightInKG
     * @param decimal $_grossWeightInKG
     * @param string $_iSOCountryCodeOfOrigin
     * @param string $_commodityCode
     * @param string $_countryCodeOrigin
     * @param decimal $_customsValue
     * @param string $_customsCurrency
     * @return DHLStructExportDocPosition
     */
    public function __construct($_description = NULL,$_amount = NULL,$_valuePerPiece = NULL,$_netWeightInKG = NULL,$_grossWeightInKG = NULL,$_iSOCountryCodeOfOrigin = NULL,$_commodityCode = NULL,$_countryCodeOrigin = NULL,$_customsValue = NULL,$_customsCurrency = NULL)
    {
        parent::__construct(array('Description'=>$_description,'Amount'=>$_amount,'ValuePerPiece'=>$_valuePerPiece,'NetWeightInKG'=>$_netWeightInKG,'GrossWeightInKG'=>$_grossWeightInKG,'ISOCountryCodeOfOrigin'=>$_iSOCountryCodeOfOrigin,'CommodityCode'=>$_commodityCode,'CountryCodeOrigin'=>$_countryCodeOrigin,'CustomsValue'=>$_customsValue,'CustomsCurrency'=>$_customsCurrency),false);
    }
    /**
     * Get Description value
     * @return string|null
     */
    public function getDescription()
    {
        return $this->Description;
    }
    /**
     * Set Description value
     * @param string $_description the Description
     * @return string
     */
    public function setDescription($_description)
    {
        return ($this->Description = $_description);
    }
    /**
     * Get Amount value
     * @return integer|null
     */
    public function getAmount()
    {
        return $this->Amount;
    }
    /**
     * Set Amount value
     * @param integer $_amount the Amount
     * @return integer
     */
    public function setAmount($_amount)
    {
        return ($this->Amount = $_amount);
    }
    /**
     * Get ValuePerPiece value
     * @return decimal|null
     */
    public function getValuePerPiece()
    {
        return $this->ValuePerPiece;
    }
    /**
     * Set ValuePerPiece value
     * @param decimal $_valuePerPiece the ValuePerPiece
     * @return decimal
     */
    public function setValuePerPiece($_valuePerPiece)
    {
        return ($this->ValuePerPiece = $_valuePerPiece);
    }
    /**
     * Get NetWeightInKG value
     * @return decimal|null
     */
    public function getNetWeightInKG()
    {
        return $this->NetWeightInKG;
    }
    /**
     * Set NetWeightInKG value
     * @param decimal $_netWeightInKG the NetWeightInKG
     * @return decimal
     */
    public function setNetWeightInKG($_netWeightInKG)
    {
        return ($this->NetWeightInKG = $_netWeightInKG);
    }
    /**
     * Get GrossWeightInKG value
     * @return decimal|null
     */
    public function getGrossWeightInKG()
    {
        return $this->GrossWeightInKG;
    }
    /**
     * Set GrossWeightInKG value
     * @param decimal $_grossWeightInKG the GrossWeightInKG
     * @return decimal
     */
    public function setGrossWeightInKG($_grossWeightInKG)
    {
        return ($this->GrossWeightInKG = $_grossWeightInKG);
    }
    /**
     * Get ISOCountryCodeOfOrigin value
     * @return string|null
     */
    public function getISOCountryCodeOfOrigin()
    {
        return $this->ISOCountryCodeOfOrigin;
    }
    /**
     * Set ISOCountryCodeOfOrigin value
     * @param string $_iSOCountryCodeOfOrigin the ISOCountryCodeOfOrigin
     * @return string
     */
    public function setISOCountryCodeOfOrigin($_iSOCountryCodeOfOrigin)
    {
        return ($this->ISOCountryCodeOfOrigin = $_iSOCountryCodeOfOrigin);
    }
    /**
     * Get CommodityCode value
     * @return string|null
     */
    public function getCommodityCode()
    {
        return $this->CommodityCode;
    }
    /**
     * Set CommodityCode value
     * @param string $_commodityCode the CommodityCode
     * @return string
     */
    public function setCommodityCode($_commodityCode)
    {
        return ($this->CommodityCode = $_commodityCode);
    }
    /**
     * Get CountryCodeOrigin value
     * @return string|null
     */
    public function getCountryCodeOrigin()
    {
        return $this->CountryCodeOrigin;
    }
    /**
     * Set CountryCodeOrigin value
     * @param string $_countryCodeOrigin the CountryCodeOrigin
     * @return string
     */
    public function setCountryCodeOrigin($_countryCodeOrigin)
    {
        return ($this->CountryCodeOrigin = $_countryCodeOrigin);
    }
    /**
     * Get CustomsValue value
     * @return decimal|null
     */
    public function getCustomsValue()
    {
        return $this->CustomsValue;
    }
    /**
     * Set CustomsValue value
     * @param decimal $_customsValue the CustomsValue
     * @return decimal
     */
    public function setCustomsValue($_customsValue)
    {
        return ($this->CustomsValue = $_customsValue);
    }
    /**
     * Get CustomsCurrency value
     * @return string|null
     */
    public function getCustomsCurrency()
    {
        return $this->CustomsCurrency;
    }
    /**
     * Set CustomsCurrency value
     * @param string $_customsCurrency the CustomsCurrency
     * @return string
     */
    public function setCustomsCurrency($_customsCurrency)
    {
        return ($this->CustomsCurrency = $_customsCurrency);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructExportDocPosition
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
