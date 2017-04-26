<?php
/**
 * File for class DHLStructPickupBookingInformationType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructPickupBookingInformationType originally named PickupBookingInformationType
 * Documentation : The data of the pickup order.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructPickupBookingInformationType extends DHLWsdlClass
{
    /**
     * The ProductID
     * @var DHLEnumProductID
     */
    public $ProductID;
    /**
     * The Account
     * Meta informations extracted from the WSDL
     * - documentation : Depending on whether a DD pickup or TD pickup is invoked, this field contains either the 10-digit EKP number (DD pickups) or the 9-digit accountNumberExpress (TD pickups).
     * @var string
     */
    public $Account;
    /**
     * The Attendance
     * Meta informations extracted from the WSDL
     * - documentation : Field has the partner id. I.e. the last 2 digit number extract from the 14 digit DHL Account Number. E.g. if DHL Account Number is "5000000008 72 01" then Attendance is 01. Field length must be = 2.
     * - minOccurs : 0
     * @var string
     */
    public $Attendance;
    /**
     * The PickupDate
     * Meta informations extracted from the WSDL
     * - documentation : Pickup date in format yyyy-mm-dd.Mandatory if pickup is booked along with shipment order. Pickup date in format yyyy-mm-dd.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $PickupDate;
    /**
     * The ReadyByTime
     * Meta informations extracted from the WSDL
     * - documentation : Earliest time for pickup. Format is hh:mm.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 5
     * - minLength : 5
     * @var string
     */
    public $ReadyByTime;
    /**
     * The ClosingTime
     * Meta informations extracted from the WSDL
     * - documentation : Lates time for pickup. Format is hh:mm.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 5
     * - minLength : 5
     * @var string
     */
    public $ClosingTime;
    /**
     * The Remark
     * Meta informations extracted from the WSDL
     * - documentation : Remarks to be considered when pickup is done.Mandatory if 'TDI' is selected.
     * - minOccurs : 0
     * @var string
     */
    public $Remark;
    /**
     * The PickupLocation
     * Meta informations extracted from the WSDL
     * - documentation : Area to further detail pickup location beyond address. Mandatory for TDN and TDI, optional for DDN and DDI.
     * - minOccurs : 0
     * @var string
     */
    public $PickupLocation;
    /**
     * The AmountOfPieces
     * Meta informations extracted from the WSDL
     * - documentation : Number of pieces to be picked up.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $AmountOfPieces;
    /**
     * The AmountOfPallets
     * Meta informations extracted from the WSDL
     * - documentation : Number of pallets to be picked up.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $AmountOfPallets;
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
     * The CountOfShipments
     * Meta informations extracted from the WSDL
     * - documentation : Number of shipments to be picked up.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $CountOfShipments;
    /**
     * The TotalVolumeWeight
     * Meta informations extracted from the WSDL
     * - documentation : The total volumetric weight of all pieces in kg. Calculated by piece =length x width x height in centimetres / 5000. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $TotalVolumeWeight;
    /**
     * The MaxLengthInCM
     * Meta informations extracted from the WSDL
     * - documentation : The maximum length in cm.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $MaxLengthInCM;
    /**
     * The MaxWidthInCM
     * Meta informations extracted from the WSDL
     * - documentation : The maximum width in cm.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $MaxWidthInCM;
    /**
     * The MaxHeightInCM
     * Meta informations extracted from the WSDL
     * - documentation : The maximum height in cm.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $MaxHeightInCM;
    /**
     * Constructor method for PickupBookingInformationType
     * @see parent::__construct()
     * @param DHLEnumProductID $_productID
     * @param string $_account
     * @param string $_attendance
     * @param string $_pickupDate
     * @param string $_readyByTime
     * @param string $_closingTime
     * @param string $_remark
     * @param string $_pickupLocation
     * @param integer $_amountOfPieces
     * @param integer $_amountOfPallets
     * @param decimal $_weightInKG
     * @param integer $_countOfShipments
     * @param decimal $_totalVolumeWeight
     * @param decimal $_maxLengthInCM
     * @param decimal $_maxWidthInCM
     * @param decimal $_maxHeightInCM
     * @return DHLStructPickupBookingInformationType
     */
    public function __construct($_productID = NULL,$_account = NULL,$_attendance = NULL,$_pickupDate = NULL,$_readyByTime = NULL,$_closingTime = NULL,$_remark = NULL,$_pickupLocation = NULL,$_amountOfPieces = NULL,$_amountOfPallets = NULL,$_weightInKG = NULL,$_countOfShipments = NULL,$_totalVolumeWeight = NULL,$_maxLengthInCM = NULL,$_maxWidthInCM = NULL,$_maxHeightInCM = NULL)
    {
        parent::__construct(array('ProductID'=>$_productID,'Account'=>$_account,'Attendance'=>$_attendance,'PickupDate'=>$_pickupDate,'ReadyByTime'=>$_readyByTime,'ClosingTime'=>$_closingTime,'Remark'=>$_remark,'PickupLocation'=>$_pickupLocation,'AmountOfPieces'=>$_amountOfPieces,'AmountOfPallets'=>$_amountOfPallets,'WeightInKG'=>$_weightInKG,'CountOfShipments'=>$_countOfShipments,'TotalVolumeWeight'=>$_totalVolumeWeight,'MaxLengthInCM'=>$_maxLengthInCM,'MaxWidthInCM'=>$_maxWidthInCM,'MaxHeightInCM'=>$_maxHeightInCM),false);
    }
    /**
     * Get ProductID value
     * @return DHLEnumProductID|null
     */
    public function getProductID()
    {
        return $this->ProductID;
    }
    /**
     * Set ProductID value
     * @uses DHLEnumProductID::valueIsValid()
     * @param DHLEnumProductID $_productID the ProductID
     * @return DHLEnumProductID
     */
    public function setProductID($_productID)
    {
        if(!DHLEnumProductID::valueIsValid($_productID))
        {
            return false;
        }
        return ($this->ProductID = $_productID);
    }
    /**
     * Get Account value
     * @return string|null
     */
    public function getAccount()
    {
        return $this->Account;
    }
    /**
     * Set Account value
     * @param string $_account the Account
     * @return string
     */
    public function setAccount($_account)
    {
        return ($this->Account = $_account);
    }
    /**
     * Get Attendance value
     * @return string|null
     */
    public function getAttendance()
    {
        return $this->Attendance;
    }
    /**
     * Set Attendance value
     * @param string $_attendance the Attendance
     * @return string
     */
    public function setAttendance($_attendance)
    {
        return ($this->Attendance = $_attendance);
    }
    /**
     * Get PickupDate value
     * @return string|null
     */
    public function getPickupDate()
    {
        return $this->PickupDate;
    }
    /**
     * Set PickupDate value
     * @param string $_pickupDate the PickupDate
     * @return string
     */
    public function setPickupDate($_pickupDate)
    {
        return ($this->PickupDate = $_pickupDate);
    }
    /**
     * Get ReadyByTime value
     * @return string|null
     */
    public function getReadyByTime()
    {
        return $this->ReadyByTime;
    }
    /**
     * Set ReadyByTime value
     * @param string $_readyByTime the ReadyByTime
     * @return string
     */
    public function setReadyByTime($_readyByTime)
    {
        return ($this->ReadyByTime = $_readyByTime);
    }
    /**
     * Get ClosingTime value
     * @return string|null
     */
    public function getClosingTime()
    {
        return $this->ClosingTime;
    }
    /**
     * Set ClosingTime value
     * @param string $_closingTime the ClosingTime
     * @return string
     */
    public function setClosingTime($_closingTime)
    {
        return ($this->ClosingTime = $_closingTime);
    }
    /**
     * Get Remark value
     * @return string|null
     */
    public function getRemark()
    {
        return $this->Remark;
    }
    /**
     * Set Remark value
     * @param string $_remark the Remark
     * @return string
     */
    public function setRemark($_remark)
    {
        return ($this->Remark = $_remark);
    }
    /**
     * Get PickupLocation value
     * @return string|null
     */
    public function getPickupLocation()
    {
        return $this->PickupLocation;
    }
    /**
     * Set PickupLocation value
     * @param string $_pickupLocation the PickupLocation
     * @return string
     */
    public function setPickupLocation($_pickupLocation)
    {
        return ($this->PickupLocation = $_pickupLocation);
    }
    /**
     * Get AmountOfPieces value
     * @return integer|null
     */
    public function getAmountOfPieces()
    {
        return $this->AmountOfPieces;
    }
    /**
     * Set AmountOfPieces value
     * @param integer $_amountOfPieces the AmountOfPieces
     * @return integer
     */
    public function setAmountOfPieces($_amountOfPieces)
    {
        return ($this->AmountOfPieces = $_amountOfPieces);
    }
    /**
     * Get AmountOfPallets value
     * @return integer|null
     */
    public function getAmountOfPallets()
    {
        return $this->AmountOfPallets;
    }
    /**
     * Set AmountOfPallets value
     * @param integer $_amountOfPallets the AmountOfPallets
     * @return integer
     */
    public function setAmountOfPallets($_amountOfPallets)
    {
        return ($this->AmountOfPallets = $_amountOfPallets);
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
     * Get CountOfShipments value
     * @return integer|null
     */
    public function getCountOfShipments()
    {
        return $this->CountOfShipments;
    }
    /**
     * Set CountOfShipments value
     * @param integer $_countOfShipments the CountOfShipments
     * @return integer
     */
    public function setCountOfShipments($_countOfShipments)
    {
        return ($this->CountOfShipments = $_countOfShipments);
    }
    /**
     * Get TotalVolumeWeight value
     * @return decimal|null
     */
    public function getTotalVolumeWeight()
    {
        return $this->TotalVolumeWeight;
    }
    /**
     * Set TotalVolumeWeight value
     * @param decimal $_totalVolumeWeight the TotalVolumeWeight
     * @return decimal
     */
    public function setTotalVolumeWeight($_totalVolumeWeight)
    {
        return ($this->TotalVolumeWeight = $_totalVolumeWeight);
    }
    /**
     * Get MaxLengthInCM value
     * @return decimal|null
     */
    public function getMaxLengthInCM()
    {
        return $this->MaxLengthInCM;
    }
    /**
     * Set MaxLengthInCM value
     * @param decimal $_maxLengthInCM the MaxLengthInCM
     * @return decimal
     */
    public function setMaxLengthInCM($_maxLengthInCM)
    {
        return ($this->MaxLengthInCM = $_maxLengthInCM);
    }
    /**
     * Get MaxWidthInCM value
     * @return decimal|null
     */
    public function getMaxWidthInCM()
    {
        return $this->MaxWidthInCM;
    }
    /**
     * Set MaxWidthInCM value
     * @param decimal $_maxWidthInCM the MaxWidthInCM
     * @return decimal
     */
    public function setMaxWidthInCM($_maxWidthInCM)
    {
        return ($this->MaxWidthInCM = $_maxWidthInCM);
    }
    /**
     * Get MaxHeightInCM value
     * @return decimal|null
     */
    public function getMaxHeightInCM()
    {
        return $this->MaxHeightInCM;
    }
    /**
     * Set MaxHeightInCM value
     * @param decimal $_maxHeightInCM the MaxHeightInCM
     * @return decimal
     */
    public function setMaxHeightInCM($_maxHeightInCM)
    {
        return ($this->MaxHeightInCM = $_maxHeightInCM);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructPickupBookingInformationType
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
