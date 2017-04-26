<?php
/**
 * File for class DHLStructExportDocumentDDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructExportDocumentDDType originally named ExportDocumentDDType
 * Documentation : The data of the export document for a DD shipment.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructExportDocumentDDType extends DHLWsdlClass
{
    /**
     * The InvoiceType
     * @var DHLEnumInvoiceType
     */
    public $InvoiceType;
    /**
     * The InvoiceDate
     * Meta informations extracted from the WSDL
     * - documentation : Invoice date in format yyyy-mm-dd.Mandatory if Export Document is provided. Field length must be = 8.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - maxLength : 10
     * - minLength : 10
     * @var string
     */
    public $InvoiceDate;
    /**
     * The InvoiceNumber
     * Meta informations extracted from the WSDL
     * - documentation : In case invoice has a number, client app can provide it in this field. Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $InvoiceNumber;
    /**
     * The ExportType
     * @var DHLEnumExportType
     */
    public $ExportType;
    /**
     * The ExportTypeDescription
     * Meta informations extracted from the WSDL
     * - documentation : Description mandatory if ExportType is 'other' (= 0). Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $ExportTypeDescription;
    /**
     * The CommodityCode
     * Meta informations extracted from the WSDL
     * - documentation : For trading internationally, the standardized international commodity code for shipped good is specified. Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $CommodityCode;
    /**
     * The TermsOfTrade
     * Meta informations extracted from the WSDL
     * - documentation : Element provides terms of trades, i.e. incoterms codes like DDU, CIP et al. Field length must be = 3.
     * @var string
     */
    public $TermsOfTrade;
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
     * The Description
     * Meta informations extracted from the WSDL
     * - documentation : Description text for the document.
     * @var string
     */
    public $Description;
    /**
     * The CountryCodeOrigin
     * Meta informations extracted from the WSDL
     * - documentation : Defines the ISO code of origin country. Field length must be = 2.
     * @var string
     */
    public $CountryCodeOrigin;
    /**
     * The AdditionalFee
     * Meta informations extracted from the WSDL
     * - documentation : Additional custom fees to be payed.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0.0
     * @var decimal
     */
    public $AdditionalFee;
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
     * - documentation : Sets the declared customs value currency of the shipment. Field length must be = 3.
     * @var string
     */
    public $CustomsCurrency;
    /**
     * The PermitNumber
     * Meta informations extracted from the WSDL
     * - documentation : The permit number. Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $PermitNumber;
    /**
     * The AttestationNumber
     * Meta informations extracted from the WSDL
     * - documentation : The attestation number. Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $AttestationNumber;
    /**
     * The WithElectronicExportNtfctn
     * Meta informations extracted from the WSDL
     * - documentation : Sets an electronic export notification.
     * - minOccurs : 0
     * @var boolean
     */
    public $WithElectronicExportNtfctn;
    /**
     * The MRNNumber
     * Meta informations extracted from the WSDL
     * - documentation : The MRN number. Field length must be equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $MRNNumber;
    /**
     * The ExportDocPosition
     * @var DHLStructExportDocPosition
     */
    public $ExportDocPosition;
    /**
     * Constructor method for ExportDocumentDDType
     * @see parent::__construct()
     * @param DHLEnumInvoiceType $_invoiceType
     * @param string $_invoiceDate
     * @param string $_invoiceNumber
     * @param DHLEnumExportType $_exportType
     * @param string $_exportTypeDescription
     * @param string $_commodityCode
     * @param string $_termsOfTrade
     * @param integer $_amount
     * @param string $_description
     * @param string $_countryCodeOrigin
     * @param decimal $_additionalFee
     * @param decimal $_customsValue
     * @param string $_customsCurrency
     * @param string $_permitNumber
     * @param string $_attestationNumber
     * @param boolean $_withElectronicExportNtfctn
     * @param string $_mRNNumber
     * @param DHLStructExportDocPosition $_exportDocPosition
     * @return DHLStructExportDocumentDDType
     */
    public function __construct($_invoiceType = NULL,$_invoiceDate = NULL,$_invoiceNumber = NULL,$_exportType = NULL,$_exportTypeDescription = NULL,$_commodityCode = NULL,$_termsOfTrade = NULL,$_amount = NULL,$_description = NULL,$_countryCodeOrigin = NULL,$_additionalFee = NULL,$_customsValue = NULL,$_customsCurrency = NULL,$_permitNumber = NULL,$_attestationNumber = NULL,$_withElectronicExportNtfctn = NULL,$_mRNNumber = NULL,$_exportDocPosition = NULL)
    {
        parent::__construct(array('InvoiceType'=>$_invoiceType,'InvoiceDate'=>$_invoiceDate,'InvoiceNumber'=>$_invoiceNumber,'ExportType'=>$_exportType,'ExportTypeDescription'=>$_exportTypeDescription,'CommodityCode'=>$_commodityCode,'TermsOfTrade'=>$_termsOfTrade,'Amount'=>$_amount,'Description'=>$_description,'CountryCodeOrigin'=>$_countryCodeOrigin,'AdditionalFee'=>$_additionalFee,'CustomsValue'=>$_customsValue,'CustomsCurrency'=>$_customsCurrency,'PermitNumber'=>$_permitNumber,'AttestationNumber'=>$_attestationNumber,'WithElectronicExportNtfctn'=>$_withElectronicExportNtfctn,'MRNNumber'=>$_mRNNumber,'ExportDocPosition'=>$_exportDocPosition),false);
    }
    /**
     * Get InvoiceType value
     * @return DHLEnumInvoiceType|null
     */
    public function getInvoiceType()
    {
        return $this->InvoiceType;
    }
    /**
     * Set InvoiceType value
     * @uses DHLEnumInvoiceType::valueIsValid()
     * @param DHLEnumInvoiceType $_invoiceType the InvoiceType
     * @return DHLEnumInvoiceType
     */
    public function setInvoiceType($_invoiceType)
    {
        if(!DHLEnumInvoiceType::valueIsValid($_invoiceType))
        {
            return false;
        }
        return ($this->InvoiceType = $_invoiceType);
    }
    /**
     * Get InvoiceDate value
     * @return string|null
     */
    public function getInvoiceDate()
    {
        return $this->InvoiceDate;
    }
    /**
     * Set InvoiceDate value
     * @param string $_invoiceDate the InvoiceDate
     * @return string
     */
    public function setInvoiceDate($_invoiceDate)
    {
        return ($this->InvoiceDate = $_invoiceDate);
    }
    /**
     * Get InvoiceNumber value
     * @return string|null
     */
    public function getInvoiceNumber()
    {
        return $this->InvoiceNumber;
    }
    /**
     * Set InvoiceNumber value
     * @param string $_invoiceNumber the InvoiceNumber
     * @return string
     */
    public function setInvoiceNumber($_invoiceNumber)
    {
        return ($this->InvoiceNumber = $_invoiceNumber);
    }
    /**
     * Get ExportType value
     * @return DHLEnumExportType|null
     */
    public function getExportType()
    {
        return $this->ExportType;
    }
    /**
     * Set ExportType value
     * @uses DHLEnumExportType::valueIsValid()
     * @param DHLEnumExportType $_exportType the ExportType
     * @return DHLEnumExportType
     */
    public function setExportType($_exportType)
    {
        if(!DHLEnumExportType::valueIsValid($_exportType))
        {
            return false;
        }
        return ($this->ExportType = $_exportType);
    }
    /**
     * Get ExportTypeDescription value
     * @return string|null
     */
    public function getExportTypeDescription()
    {
        return $this->ExportTypeDescription;
    }
    /**
     * Set ExportTypeDescription value
     * @param string $_exportTypeDescription the ExportTypeDescription
     * @return string
     */
    public function setExportTypeDescription($_exportTypeDescription)
    {
        return ($this->ExportTypeDescription = $_exportTypeDescription);
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
     * Get TermsOfTrade value
     * @return string|null
     */
    public function getTermsOfTrade()
    {
        return $this->TermsOfTrade;
    }
    /**
     * Set TermsOfTrade value
     * @param string $_termsOfTrade the TermsOfTrade
     * @return string
     */
    public function setTermsOfTrade($_termsOfTrade)
    {
        return ($this->TermsOfTrade = $_termsOfTrade);
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
     * Get AdditionalFee value
     * @return decimal|null
     */
    public function getAdditionalFee()
    {
        return $this->AdditionalFee;
    }
    /**
     * Set AdditionalFee value
     * @param decimal $_additionalFee the AdditionalFee
     * @return decimal
     */
    public function setAdditionalFee($_additionalFee)
    {
        return ($this->AdditionalFee = $_additionalFee);
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
     * Get PermitNumber value
     * @return string|null
     */
    public function getPermitNumber()
    {
        return $this->PermitNumber;
    }
    /**
     * Set PermitNumber value
     * @param string $_permitNumber the PermitNumber
     * @return string
     */
    public function setPermitNumber($_permitNumber)
    {
        return ($this->PermitNumber = $_permitNumber);
    }
    /**
     * Get AttestationNumber value
     * @return string|null
     */
    public function getAttestationNumber()
    {
        return $this->AttestationNumber;
    }
    /**
     * Set AttestationNumber value
     * @param string $_attestationNumber the AttestationNumber
     * @return string
     */
    public function setAttestationNumber($_attestationNumber)
    {
        return ($this->AttestationNumber = $_attestationNumber);
    }
    /**
     * Get WithElectronicExportNtfctn value
     * @return boolean|null
     */
    public function getWithElectronicExportNtfctn()
    {
        return $this->WithElectronicExportNtfctn;
    }
    /**
     * Set WithElectronicExportNtfctn value
     * @param boolean $_withElectronicExportNtfctn the WithElectronicExportNtfctn
     * @return boolean
     */
    public function setWithElectronicExportNtfctn($_withElectronicExportNtfctn)
    {
        return ($this->WithElectronicExportNtfctn = $_withElectronicExportNtfctn);
    }
    /**
     * Get MRNNumber value
     * @return string|null
     */
    public function getMRNNumber()
    {
        return $this->MRNNumber;
    }
    /**
     * Set MRNNumber value
     * @param string $_mRNNumber the MRNNumber
     * @return string
     */
    public function setMRNNumber($_mRNNumber)
    {
        return ($this->MRNNumber = $_mRNNumber);
    }
    /**
     * Get ExportDocPosition value
     * @return DHLStructExportDocPosition|null
     */
    public function getExportDocPosition()
    {
        return $this->ExportDocPosition;
    }
    /**
     * Set ExportDocPosition value
     * @param DHLStructExportDocPosition $_exportDocPosition the ExportDocPosition
     * @return DHLStructExportDocPosition
     */
    public function setExportDocPosition($_exportDocPosition)
    {
        return ($this->ExportDocPosition = $_exportDocPosition);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructExportDocumentDDType
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
