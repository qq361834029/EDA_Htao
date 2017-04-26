<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'UnitOfMeasurementType.php';

/**
 *  
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/UnitOfMeasurementDetailsType.html
 *
 */
class UnitOfMeasurementDetailsType extends EbatNs_ComplexType
{
	/**
	 * @var UnitOfMeasurementType
	 */
	protected $UnitOfMeasurement;
	/**
	 * @var string
	 */
	protected $DetailVersion;
	/**
	 * @var dateTime
	 */
	protected $UpdateTime;

	/**
	 * @return UnitOfMeasurementType
	 * @param integer $index 
	 */
	function getUnitOfMeasurement($index = null)
	{
		if ($index !== null) {
			return $this->UnitOfMeasurement[$index];
		} else {
			return $this->UnitOfMeasurement;
		}
	}
	/**
	 * @return void
	 * @param UnitOfMeasurementType $value 
	 * @param  $index 
	 */
	function setUnitOfMeasurement($value, $index = null)
	{
		if ($index !== null) {
			$this->UnitOfMeasurement[$index] = $value;
		} else {
			$this->UnitOfMeasurement = $value;
		}
	}
	/**
	 * @return void
	 * @param UnitOfMeasurementType $value 
	 */
	function addUnitOfMeasurement($value)
	{
		$this->UnitOfMeasurement[] = $value;
	}
	/**
	 * @return string
	 */
	function getDetailVersion()
	{
		return $this->DetailVersion;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setDetailVersion($value)
	{
		$this->DetailVersion = $value;
	}
	/**
	 * @return dateTime
	 */
	function getUpdateTime()
	{
		return $this->UpdateTime;
	}
	/**
	 * @return void
	 * @param dateTime $value 
	 */
	function setUpdateTime($value)
	{
		$this->UpdateTime = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('UnitOfMeasurementDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'UnitOfMeasurement' =>
					array(
						'required' => false,
						'type' => 'UnitOfMeasurementType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => true,
						'cardinality' => '0..*'
					),
					'DetailVersion' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'UpdateTime' =>
					array(
						'required' => false,
						'type' => 'dateTime',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
