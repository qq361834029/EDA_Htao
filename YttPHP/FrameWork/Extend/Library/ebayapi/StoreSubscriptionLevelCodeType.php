<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * User's eBay Store subscription level. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/StoreSubscriptionLevelCodeType.html
 *
 * @property string Close
 * @property string Basic
 * @property string Featured
 * @property string Anchor
 * @property string CustomCode
 */
class StoreSubscriptionLevelCodeType extends EbatNs_FacetType
{
	const CodeType_Close = 'Close';
	const CodeType_Basic = 'Basic';
	const CodeType_Featured = 'Featured';
	const CodeType_Anchor = 'Anchor';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('StoreSubscriptionLevelCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_StoreSubscriptionLevelCodeType = new StoreSubscriptionLevelCodeType();

?>
