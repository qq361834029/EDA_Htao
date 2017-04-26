<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * Specifies the type of auto relist that will be performed. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/SellingManagerAutoRelistTypeCodeType.html
 *
 * @property string RelistOnceIfNotSold
 * @property string RelistContinuouslyUntilSold
 * @property string RelistContinuously
 * @property string CustomCode
 */
class SellingManagerAutoRelistTypeCodeType extends EbatNs_FacetType
{
	const CodeType_RelistOnceIfNotSold = 'RelistOnceIfNotSold';
	const CodeType_RelistContinuouslyUntilSold = 'RelistContinuouslyUntilSold';
	const CodeType_RelistContinuously = 'RelistContinuously';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('SellingManagerAutoRelistTypeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_SellingManagerAutoRelistTypeCodeType = new SellingManagerAutoRelistTypeCodeType();

?>