<?php
/**
 * File for class DHLStructContractSubmission
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructContractSubmission originally named ContractSubmission
 * Documentation : Invoke service contract submission. Field length = 1.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructContractSubmission extends DHLWsdlClass
{
    /**
     * The TotalPages
     * Meta informations extracted from the WSDL
     * - documentation : Total number of pages. Checksum for deliverer. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $TotalPages;
    /**
     * The TotalSignatures
     * Meta informations extracted from the WSDL
     * - documentation : Total number of signatures. Checksum for deliverer. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $TotalSignatures;
    /**
     * The TotalDocsSender
     * Meta informations extracted from the WSDL
     * - documentation : Total number of docs to be sent back to sender.Checksum for deliverer. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $TotalDocsSender;
    /**
     * The TotalDocsReceiver
     * Meta informations extracted from the WSDL
     * - documentation : Total number of docs to remain at receiver. Checksum for deliverer. Field length must be less than or equal to 22.
     * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
     * - minInclusive : 0
     * @var integer
     */
    public $TotalDocsReceiver;
    /**
     * Constructor method for ContractSubmission
     * @see parent::__construct()
     * @param integer $_totalPages
     * @param integer $_totalSignatures
     * @param integer $_totalDocsSender
     * @param integer $_totalDocsReceiver
     * @return DHLStructContractSubmission
     */
    public function __construct($_totalPages = NULL,$_totalSignatures = NULL,$_totalDocsSender = NULL,$_totalDocsReceiver = NULL)
    {
        parent::__construct(array('TotalPages'=>$_totalPages,'TotalSignatures'=>$_totalSignatures,'TotalDocsSender'=>$_totalDocsSender,'TotalDocsReceiver'=>$_totalDocsReceiver),false);
    }
    /**
     * Get TotalPages value
     * @return integer|null
     */
    public function getTotalPages()
    {
        return $this->TotalPages;
    }
    /**
     * Set TotalPages value
     * @param integer $_totalPages the TotalPages
     * @return integer
     */
    public function setTotalPages($_totalPages)
    {
        return ($this->TotalPages = $_totalPages);
    }
    /**
     * Get TotalSignatures value
     * @return integer|null
     */
    public function getTotalSignatures()
    {
        return $this->TotalSignatures;
    }
    /**
     * Set TotalSignatures value
     * @param integer $_totalSignatures the TotalSignatures
     * @return integer
     */
    public function setTotalSignatures($_totalSignatures)
    {
        return ($this->TotalSignatures = $_totalSignatures);
    }
    /**
     * Get TotalDocsSender value
     * @return integer|null
     */
    public function getTotalDocsSender()
    {
        return $this->TotalDocsSender;
    }
    /**
     * Set TotalDocsSender value
     * @param integer $_totalDocsSender the TotalDocsSender
     * @return integer
     */
    public function setTotalDocsSender($_totalDocsSender)
    {
        return ($this->TotalDocsSender = $_totalDocsSender);
    }
    /**
     * Get TotalDocsReceiver value
     * @return integer|null
     */
    public function getTotalDocsReceiver()
    {
        return $this->TotalDocsReceiver;
    }
    /**
     * Set TotalDocsReceiver value
     * @param integer $_totalDocsReceiver the TotalDocsReceiver
     * @return integer
     */
    public function setTotalDocsReceiver($_totalDocsReceiver)
    {
        return ($this->TotalDocsReceiver = $_totalDocsReceiver);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructContractSubmission
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
