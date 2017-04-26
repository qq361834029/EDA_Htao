<?php
/**
 * File for class DHLStructPieceInformation
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructPieceInformation originally named PieceInformation
 * Documentation : Information about each piece (e.g. the generated licence plate). For every piece, a PieceInformation container holds the license plate number.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructPieceInformation extends DHLWsdlClass
{
    /**
     * The PieceNumber
     * Meta informations extracted from the WSDL
     * - documentation : For every piece a piece number is created that is of one of the following types (mostly licensePlate).
     * - minOccurs : 0
     * @var DHLStructShipmentNumberType
     */
    public $PieceNumber;
    /**
     * Constructor method for PieceInformation
     * @see parent::__construct()
     * @param DHLStructShipmentNumberType $_pieceNumber
     * @return DHLStructPieceInformation
     */
    public function __construct($_pieceNumber = NULL)
    {
        parent::__construct(array('PieceNumber'=>$_pieceNumber),false);
    }
    /**
     * Get PieceNumber value
     * @return DHLStructShipmentNumberType|null
     */
    public function getPieceNumber()
    {
        return $this->PieceNumber;
    }
    /**
     * Set PieceNumber value
     * @param DHLStructShipmentNumberType $_pieceNumber the PieceNumber
     * @return DHLStructShipmentNumberType
     */
    public function setPieceNumber($_pieceNumber)
    {
        return ($this->PieceNumber = $_pieceNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructPieceInformation
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
