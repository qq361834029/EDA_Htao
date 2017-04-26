<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'AbstractRequestType.php';

/**
 * Returns a list of up to 10 categories that have the highest percentage of 
 * listingswhose titles or descriptions contain the keywords you specify. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetSuggestedCategoriesRequestType.html
 *
 */
class GetSuggestedCategoriesRequestType extends AbstractRequestType
{
	/**
	 * @var string
	 */
	protected $Query;

	/**
	 * @return string
	 */
	function getQuery()
	{
		return $this->Query;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setQuery($value)
	{
		$this->Query = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetSuggestedCategoriesRequestType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'Query' =>
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
