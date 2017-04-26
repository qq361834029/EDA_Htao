<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'ItemType.php';

/**
 * Container for a list of items. Can contain zero, one, or multipleItemType 
 * objects, each of which conveys the data for one item listing. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ItemArrayType.html
 *
 */
class ItemArrayType extends EbatNs_ComplexType
{
	/**
	 * @var ItemType
	 */
	protected $Item;

	/**
	 * @return ItemType
	 * @param integer $index 
	 */
	function getItem($index = null)
	{
		if ($index !== null) {
			return $this->Item[$index];
		} else {
			return $this->Item;
		}
	}
	/**
	 * @return void
	 * @param ItemType $value 
	 * @param  $index 
	 */
	function setItem($value, $index = null)
	{
		if ($index !== null) {
			$this->Item[$index] = $value;
		} else {
			$this->Item = $value;
		}
	}
	/**
	 * @return void
	 * @param ItemType $value 
	 */
	function addItem($value)
	{
		$this->Item[] = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ItemArrayType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'Item' =>
					array(
						'required' => false,
						'type' => 'ItemType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => true,
						'cardinality' => '0..*'
					)
				));
	}
}
?>