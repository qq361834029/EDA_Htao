<?php
/**
 * File for class DHLStructExportDocumentTDType
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructExportDocumentTDType originally named ExportDocumentTDType
 * Documentation : The data of the export document for a TD shipment.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructExportDocumentTDType extends DHLWsdlClass
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
     * The SignerTitle
     * Meta informations extracted from the WSDL
     * - documentation : The title of the Signer.
     * - minOccurs : 0
     * @var string
     */
    public $SignerTitle;
    /**
     * The Remark
     * Meta informations extracted from the WSDL
     * - documentation : Freely editable field to leave a remark.
     * - minOccurs : 0
     * @var string
     */
    public $Remark;
    /**
     * The CommodityCode
     * Meta informations extracted from the WSDL
     * - documentation : For trading internationally, the standardized international commodity codes for shipped goods are specified. Field length must be less than or equal to 30.
     * - minOccurs : 0
     * @var string
     */
    public $CommodityCode;
    /**
     * The ExportReason
     * Meta informations extracted from the WSDL
     * - documentation : Reason for exporting goods.
     * - minOccurs : 0
     * @var string
     */
    public $ExportReason;
    /**
     * The ExportDocPosition
     * @var DHLStructExportDocPosition
     */
    public $ExportDocPosition;
    /**
     * Constructor method for ExportDocumentTDType
     * @see parent::__construct()
     * @param DHLEnumInvoiceType $_invoiceType
     * @param string $_invoiceDate
     * @param string $_invoiceNumber
     * @param DHLEnumExportType $_exportType
     * @param string $_signerTitle
     * @param string $_remark
     * @param string $_commodityCode
     * @param string $_exportReason
     * @param DHLStructExportDocPosition $_exportDocPosition
     * @return DHLStructExportDocumentTDType
     */
    public function __construct($_invoiceType = NULL,$_invoiceDate = NULL,$_invoiceNumber = NULL,$_exportType = NULL,$_signerTitle = NULL,$_remark = NULL,$_commodityCode = NULL,$_exportReason = NULL,$_exportDocPosition = NULL)
    {
        parent::__construct(array('InvoiceType'=>$_invoiceType,'InvoiceDate'=>$_invoiceDate,'InvoiceNumber'=>$_invoiceNumber,'ExportType'=>$_exportType,'SignerTitle'=>$_signerTitle,'Remark'=>$_remark,'CommodityCode'=>$_commodityCode,'ExportReason'=>$_exportReason,'ExportDocPosition'=>$_exportDocPosition),false);
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
     * Get SignerTitle value
     * @return string|null
     */
    public function getSignerTitle()
    {
        return $this->SignerTitle;
    }
    /**
     * Set SignerTitle value
     * @param string $_signerTitle the SignerTitle
     * @return string
     */
    public function setSignerTitle($_signerTitle)
    {
        return ($this->SignerTitle = $_signerTitle);
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
     * Get ExportReason value
     * @return string|null
     */
    public function getExportReason()
    {
        return $this->ExportReason;
    }
    /**
     * Set ExportReason value
     * @param string $_exportReason the ExportReason
     * @return string
     */
    public function setExportReason($_exportReason)
    {
        return ($this->ExportReason = $_exportReason);
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
     * @return DHLStructExportDocumentTDType
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
