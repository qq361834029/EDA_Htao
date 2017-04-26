<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * Specifies that you want to display items based on selling format, such as Buy It 
 * Now or Store items. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ItemFormatSortFilterCodeType.html
 *
 * @property string ShowAnyItems
 * @property string ShowItemsWithBINFirst
 * @property string ShowOnlyItemsWithBIN
 * @property string ShowOnlyStoreItems
 * @property string CustomCode
 */
class ItemFormatSortFilterCodeType extends EbatNs_FacetType
{
	const CodeType_ShowAnyItems = 'ShowAnyItems';
	const CodeType_ShowItemsWithBINFirst = 'ShowItemsWithBINFirst';
	const CodeType_ShowOnlyItemsWithBIN = 'ShowOnlyItemsWithBIN';
	const CodeType_ShowOnlyStoreItems = 'ShowOnlyStoreItems';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ItemFormatSortFilterCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ItemFormatSortFilterCodeType = new ItemFormatSortFilterCodeType();

?>
