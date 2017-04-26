<?php
/**
 * File for class DHLStructShipmentDetailsType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructShipmentDetailsType originally named ShipmentDetailsType
 * Documentation : Details of a shipment.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructShipmentDetailsType extends DHLWsdlClass
{
    /**
     * The ProductCode
     * Meta informations extracted from the WSDL
     * - documentation : <context id="CreateShipmentDDRequest"> Determines the DHL Paket or domestic DHL Express product to be ordered. Field length must be less than or equal to 6. <values> <value> <name>BPI</name> <description>Weltpaket</description> </value> <value> <name>EPI</name> <description>DHL Europaket</description> </value> <value> <name>EPN</name> <description>DHL Paket</description> </value> <value> <name>EUP</name> <description>DHL Europlus</description> </value> <value> <name>EXI</name> <description>DHL Express Ident â€“ requires Identity and insurance!</description> </value> <value> <name>EXP</name> <description>DHL Domestic Express â€“ requires higher insurance!</description> </value> <value> <name>OFP</name> <description>Officepack â€“ requires higher insurance!</description> </value> <value> <name>RPN</name> <description>Regional Paket AT - requires RegioPacket to be set!</description> </value> <value> <name>TAS</name> <description>DHL Retoure - not offered via Intraship Web Service yet!</description> </value> </values> </context> <context id="CreateShipmentTDRequest"> Determines the mostly international DHL Express product to be ordered. Field length must be less than or equal to 6. <values> <value> <name>ECX</name> <description>EXPRESS WORLDWIDE EU</description> </value> <value> <name>TDK</name> <description>STARTDAY EXPRESS 9:00</description> </value> <value> <name>TDT</name> <description>MIDDAY EXPRESS 12:00</description> </value> <value> <name>TDE</name> <description>STARTDAY EXPRESS 9:00</description> </value> <value> <name>TDY</name> <description>MIDDAY EXPRESS 12:00</description> </value> <value> <name>DOX</name> <description>EXPRESS WORLDWIDE (DOC) </description> </value> <value> <name>WPX</name> <description>EXPRESS WORLDWIDE (NON-DOC), dutiable must be â€˜1â€™.</description> </value> <value> <name>EUL</name> <description>EXPRESS ENVELOPE (LETTER 300) </description> </value> <value> <name>LET</name> <description>EXPRESS ENVELOPE (LETTER 300) </description> </value> <value> <name>DK1</name> <description>US NEXT DAY 10:30 (DOC) </description> </value> <value> <name>DT1</name> <description>US NEXT DAY 12:00 (DOC) </description> </value> <value> <name>DE1</name> <description>US NEXT DAY 10:30 (NON-DOC) </description> </value> <value> <name>DY1</name> <description>US NEXT DAY 12:00 (NON-DOC) </description> </value> <value> <name>DON</name> <description>US NEXT DAY (DOC) </description> </value> <value> <name>WPN</name> <description>US NEXT DAY (NON-DOC) </description> </value> <value> <name>DOM</name> <description>DOMESTIC EXPRESS 12:00</description> </value> <value> <name>ESI</name> <description>ECONOMY SELECT INTERNATIONAL</description> </value> <value> <name>GMB</name> <description>GLOBALMAIL BUSINESS</description> </value> <value> <name>DXM</name> <description>DOMESTIC EXPRESS 9:00</description> </value> </values> </context>
     * @var string
     */
    public $ProductCode;
    /**
     * The ShipmentDate
     * Meta informations extracted from the WSDL
     * - documentation : Date of shipment should be close to current date and must not be in the past. Iso format required: yyyy-mm-dd. Field length must be = 8.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $ShipmentDate;
    /**
     * The DeclaredValueOfGoods
     * Meta informations extracted from the WSDL
     * - documentation : Declared value Of goods. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var float
     */
    public $DeclaredValueOfGoods;
    /**
     * The DeclaredValueOfGoodsCurrency
     * Meta informations extracted from the WSDL
     * - documentation : Declared value of goods currency (mandatory if DeclaredValueOfGoods is defined). Field length must be = 3.
     * - minOccurs : 0
     * @var string
     */
    public $DeclaredValueOfGoodsCurrency;
    /**
     * Constructor method for ShipmentDetailsType
     * @see parent::__construct()
     * @param string $_productCode
     * @param string $_shipmentDate
     * @param float $_declaredValueOfGoods
     * @param string $_declaredValueOfGoodsCurrency
     * @return DHLStructShipmentDetailsType
     */
    public function __construct($_productCode = NULL,$_shipmentDate = NULL,$_declaredValueOfGoods = NULL,$_declaredValueOfGoodsCurrency = NULL)
    {
        parent::__construct(array('ProductCode'=>$_productCode,'ShipmentDate'=>$_shipmentDate,'DeclaredValueOfGoods'=>$_declaredValueOfGoods,'DeclaredValueOfGoodsCurrency'=>$_declaredValueOfGoodsCurrency),false);
    }
    /**
     * Get ProductCode value
     * @return string|null
     */
    public function getProductCode()
    {
        return $this->ProductCode;
    }
    /**
     * Set ProductCode value
     * @param string $_productCode the ProductCode
     * @return string
     */
    public function setProductCode($_productCode)
    {
        return ($this->ProductCode = $_productCode);
    }
    /**
     * Get ShipmentDate value
     * @return string|null
     */
    public function getShipmentDate()
    {
        return $this->ShipmentDate;
    }
    /**
     * Set ShipmentDate value
     * @param string $_shipmentDate the ShipmentDate
     * @return string
     */
    public function setShipmentDate($_shipmentDate)
    {
        return ($this->ShipmentDate = $_shipmentDate);
    }
    /**
     * Get DeclaredValueOfGoods value
     * @return float|null
     */
    public function getDeclaredValueOfGoods()
    {
        return $this->DeclaredValueOfGoods;
    }
    /**
     * Set DeclaredValueOfGoods value
     * @param float $_declaredValueOfGoods the DeclaredValueOfGoods
     * @return float
     */
    public function setDeclaredValueOfGoods($_declaredValueOfGoods)
    {
        return ($this->DeclaredValueOfGoods = $_declaredValueOfGoods);
    }
    /**
     * Get DeclaredValueOfGoodsCurrency value
     * @return string|null
     */
    public function getDeclaredValueOfGoodsCurrency()
    {
        return $this->DeclaredValueOfGoodsCurrency;
    }
    /**
     * Set DeclaredValueOfGoodsCurrency value
     * @param string $_declaredValueOfGoodsCurrency the DeclaredValueOfGoodsCurrency
     * @return string
     */
    public function setDeclaredValueOfGoodsCurrency($_declaredValueOfGoodsCurrency)
    {
        return ($this->DeclaredValueOfGoodsCurrency = $_declaredValueOfGoodsCurrency);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructShipmentDetailsType
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
