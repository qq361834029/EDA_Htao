<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'BestOfferArrayType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'TradingRoleCodeType.php';
require_once 'ItemType.php';

/**
 * All best offers for the item according to the filter or best offerid (or both) 
 * used in the input.For the notification client usage, this response includes 
 * asingle Best Offer. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ItemBestOffersType.html
 *
 */
class ItemBestOffersType extends EbatNs_ComplexType
{
	/**
	 * @var TradingRoleCodeType
	 */
	protected $Role;
	/**
	 * @var BestOfferArrayType
	 */
	protected $BestOfferArray;
	/**
	 * @var ItemType
	 */
	protected $Item;

	/**
	 * @return TradingRoleCodeType
	 */
	function getRole()
	{
		return $this->Role;
	}
	/**
	 * @return void
	 * @param TradingRoleCodeType $value 
	 */
	function setRole($value)
	{
		$this->Role = $value;
	}
	/**
	 * @return BestOfferArrayType
	 */
	function getBestOfferArray()
	{
		return $this->BestOfferArray;
	}
	/**
	 * @return void
	 * @param BestOfferArrayType $value 
	 */
	function setBestOfferArray($value)
	{
		$this->BestOfferArray = $value;
	}
	/**
	 * @return ItemType
	 */
	function getItem()
	{
		return $this->Item;
	}
	/**
	 * @return void
	 * @param ItemType $value 
	 */
	function setItem($value)
	{
		$this->Item = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ItemBestOffersType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'Role' =>
					array(
						'required' => false,
						'type' => 'TradingRoleCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'BestOfferArray' =>
					array(
						'required' => false,
						'type' => 'BestOfferArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'Item' =>
					array(
						'required' => false,
						'type' => 'ItemType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>