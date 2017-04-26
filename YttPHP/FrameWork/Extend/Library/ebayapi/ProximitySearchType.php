<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Contains data for filtering a search by proximity. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ProximitySearchType.html
 *
 */
class ProximitySearchType extends EbatNs_ComplexType
{
	/**
	 * @var int
	 */
	protected $MaxDistance;
	/**
	 * @var string
	 */
	protected $PostalCode;

	/**
	 * @return int
	 */
	function getMaxDistance()
	{
		return $this->MaxDistance;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setMaxDistance($value)
	{
		$this->MaxDistance = $value;
	}
	/**
	 * @return string
	 */
	function getPostalCode()
	{
		return $this->PostalCode;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setPostalCode($value)
	{
		$this->PostalCode = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ProximitySearchType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'MaxDistance' =>
					array(
						'required' => true,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '1..1'
					),
					'PostalCode' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
