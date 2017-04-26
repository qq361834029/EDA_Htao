<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
require_once 'EbatNs_SimpleType.php';

/**
 * An identifier of a dispute. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/DisputeIDType.html
 *
 */
class DisputeIDType extends EbatNs_SimpleType
{

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('DisputeIDType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_DisputeIDType = new DisputeIDType();

?>
