<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'AbstractResponseType.php';

/**
 * Response to SetTaxTableRequest. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/SetTaxTableResponseType.html
 *
 */
class SetTaxTableResponseType extends AbstractResponseType
{

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('SetTaxTableResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__])) {
			self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()], array());
		}
	}
}
?>
