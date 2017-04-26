<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'SiteWideCharacteristicsType.php';
require_once 'AbstractResponseType.php';
require_once 'CategoryArrayType.php';

/**
 * Returns data that indicates the categories that are mapped to characteristics 
 * sets,for the eBay site to which the call was routed.Retrieves all mappings or 
 * just the one that matches the category ID passed as input.The data is returned 
 * in a CategoryArrayType object, which can contain multiple mappings.The response 
 * also contains information about categories for which the mappings have 
 * changed.<br><br><span class="tablenote"><b>Note:</b> The Pre-filled Item 
 * Information feature depends on the Item Specifics feature.This means the set of 
 * catalog-enabled categories is a subset of the categoriesthat are mapped to 
 * characteristic sets. That is, there are no catalog-enabled categoriesthat are 
 * not mapped to characteristic sets.</span> 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetCategory2CSResponseType.html
 *
 */
class GetCategory2CSResponseType extends AbstractResponseType
{
	/**
	 * @var CategoryArrayType
	 */
	protected $MappedCategoryArray;
	/**
	 * @var CategoryArrayType
	 */
	protected $UnmappedCategoryArray;
	/**
	 * @var string
	 */
	protected $AttributeSystemVersion;
	/**
	 * @var SiteWideCharacteristicsType
	 */
	protected $SiteWideCharacteristicSets;

	/**
	 * @return CategoryArrayType
	 */
	function getMappedCategoryArray()
	{
		return $this->MappedCategoryArray;
	}
	/**
	 * @return void
	 * @param CategoryArrayType $value 
	 */
	function setMappedCategoryArray($value)
	{
		$this->MappedCategoryArray = $value;
	}
	/**
	 * @return CategoryArrayType
	 */
	function getUnmappedCategoryArray()
	{
		return $this->UnmappedCategoryArray;
	}
	/**
	 * @return void
	 * @param CategoryArrayType $value 
	 */
	function setUnmappedCategoryArray($value)
	{
		$this->UnmappedCategoryArray = $value;
	}
	/**
	 * @return string
	 */
	function getAttributeSystemVersion()
	{
		return $this->AttributeSystemVersion;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setAttributeSystemVersion($value)
	{
		$this->AttributeSystemVersion = $value;
	}
	/**
	 * @return SiteWideCharacteristicsType
	 * @param integer $index 
	 */
	function getSiteWideCharacteristicSets($index = null)
	{
		if ($index !== null) {
			return $this->SiteWideCharacteristicSets[$index];
		} else {
			return $this->SiteWideCharacteristicSets;
		}
	}
	/**
	 * @return void
	 * @param SiteWideCharacteristicsType $value 
	 * @param  $index 
	 */
	function setSiteWideCharacteristicSets($value, $index = null)
	{
		if ($index !== null) {
			$this->SiteWideCharacteristicSets[$index] = $value;
		} else {
			$this->SiteWideCharacteristicSets = $value;
		}
	}
	/**
	 * @return void
	 * @param SiteWideCharacteristicsType $value 
	 */
	function addSiteWideCharacteristicSets($value)
	{
		$this->SiteWideCharacteristicSets[] = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetCategory2CSResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'MappedCategoryArray' =>
					array(
						'required' => false,
						'type' => 'CategoryArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'UnmappedCategoryArray' =>
					array(
						'required' => false,
						'type' => 'CategoryArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'AttributeSystemVersion' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'SiteWideCharacteristicSets' =>
					array(
						'required' => false,
						'type' => 'SiteWideCharacteristicsType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => true,
						'cardinality' => '0..*'
					)
				));
	}
}
?>
