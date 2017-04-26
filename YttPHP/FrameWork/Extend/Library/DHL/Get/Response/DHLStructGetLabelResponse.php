<?php
/**
 * File for class DHLStructGetLabelResponse
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
/**
 * This class stands for DHLStructGetLabelResponse originally named GetLabelResponse
 * Documentation : The status of the operation and requested urls for getting the label. The version of the webservice implementation.
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://www.intraship.de/ws/1_0/ISService/DE/is_base_de.xsd}
 * @package DHL
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-03-21
 */
class DHLStructGetLabelResponse extends DHLWsdlClass
{
    /**
     * The Version
     * @var DHLStructVersion
     */
    public $Version;
    /**
     * The status
     * Meta informations extracted from the WSDL
     * - documentation : Success status after processing the overall request.
     * @var DHLStructStatusinformation
     */
    public $status;
    /**
     * The LabelData
     * Meta informations extracted from the WSDL
     * - documentation : For every ShipmentNumber requested, one LabelData node is returned that contains the status of the label retrieval operation and the URL for the label (if available).
     * - maxOccurs : 999
     * - minOccurs : 0
     * @var DHLStructLabelData
     */
    public $LabelData;
    /**
     * Constructor method for GetLabelResponse
     * @see parent::__construct()
     * @param DHLStructVersion $_version
     * @param DHLStructStatusinformation $_status
     * @param DHLStructLabelData $_labelData
     * @return DHLStructGetLabelResponse
     */
    public function __construct($_version = NULL,$_status = NULL,$_labelData = NULL)
    {
        parent::__construct(array('Version'=>$_version,'status'=>$_status,'LabelData'=>$_labelData),false);
    }
    /**
     * Get Version value
     * @return DHLStructVersion|null
     */
    public function getVersion()
    {
        return $this->Version;
    }
    /**
     * Set Version value
     * @param DHLStructVersion $_version the Version
     * @return DHLStructVersion
     */
    public function setVersion($_version)
    {
        return ($this->Version = $_version);
    }
    /**
     * Get status value
     * @return DHLStructStatusinformation|null
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Set status value
     * @param DHLStructStatusinformation $_status the status
     * @return DHLStructStatusinformation
     */
    public function setStatus($_status)
    {
        return ($this->status = $_status);
    }
    /**
     * Get LabelData value
     * @return DHLStructLabelData|null
     */
    public function getLabelData()
    {
        return $this->LabelData;
    }
    /**
     * Set LabelData value
     * @param DHLStructLabelData $_labelData the LabelData
     * @return DHLStructLabelData
     */
    public function setLabelData($_labelData)
    {
        return ($this->LabelData = $_labelData);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see DHLWsdlClass::__set_state()
     * @uses DHLWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return DHLStructGetLabelResponse
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
