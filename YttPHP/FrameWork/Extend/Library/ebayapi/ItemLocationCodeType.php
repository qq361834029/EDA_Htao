<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * ItemLocationCodeType - Type declaration to be used by other schema.Use with 
 * Country Code argument in GetSearchResults. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ItemLocationCodeType.html
 *
 * @property string ItemAvailableIn
 * @property string ItemLocatedIn
 * @property string CustomCode
 */
class ItemLocationCodeType extends EbatNs_FacetType
{
	const CodeType_ItemAvailableIn = 'ItemAvailableIn';
	const CodeType_ItemLocatedIn = 'ItemLocatedIn';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ItemLocationCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ItemLocationCodeType = new ItemLocationCodeType();

?>
