<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'ItemArrayType.php';
require_once 'BuyingGuideDetailsType.php';
require_once 'CharacteristicsSetProductHistogramType.php';
require_once 'AbstractResponseType.php';
require_once 'CatalogProductType.php';

/**
 * Returns stock product information in eBay catalogs, such asinformation about a 
 * particular DVD or camera. Optionally,also returns product reviews, buying 
 * guides, and items thatmatch the product. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetProductsResponseType.html
 *
 */
class GetProductsResponseType extends AbstractResponseType
{
	/**
	 * @var CharacteristicsSetProductHistogramType
	 */
	protected $CharacteristicsSetProductHistogram;
	/**
	 * @var int
	 */
	protected $PageNumber;
	/**
	 * @var int
	 */
	protected $ApproximatePages;
	/**
	 * @var boolean
	 */
	protected $HasMore;
	/**
	 * @var int
	 */
	protected $TotalProducts;
	/**
	 * @var CatalogProductType
	 */
	protected $Product;
	/**
	 * @var ItemArrayType
	 */
	protected $ItemArray;
	/**
	 * @var BuyingGuideDetailsType
	 */
	protected $BuyingGuideDetails;
	/**
	 * @var boolean
	 */
	protected $DuplicateItems;

	/**
	 * @return CharacteristicsSetProductHistogramType
	 */
	function getCharacteristicsSetProductHistogram()
	{
		return $this->CharacteristicsSetProductHistogram;
	}
	/**
	 * @return void
	 * @param CharacteristicsSetProductHistogramType $value 
	 */
	function setCharacteristicsSetProductHistogram($value)
	{
		$this->CharacteristicsSetProductHistogram = $value;
	}
	/**
	 * @return int
	 */
	function getPageNumber()
	{
		return $this->PageNumber;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setPageNumber($value)
	{
		$this->PageNumber = $value;
	}
	/**
	 * @return int
	 */
	function getApproximatePages()
	{
		return $this->ApproximatePages;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setApproximatePages($value)
	{
		$this->ApproximatePages = $value;
	}
	/**
	 * @return boolean
	 */
	function getHasMore()
	{
		return $this->HasMore;
	}
	/**
	 * @return void
	 * @param boolean $value 
	 */
	function setHasMore($value)
	{
		$this->HasMore = $value;
	}
	/**
	 * @return int
	 */
	function getTotalProducts()
	{
		return $this->TotalProducts;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setTotalProducts($value)
	{
		$this->TotalProducts = $value;
	}
	/**
	 * @return CatalogProductType
	 * @param integer $index 
	 */
	function getProduct($index = null)
	{
		if ($index !== null) {
			return $this->Product[$index];
		} else {
			return $this->Product;
		}
	}
	/**
	 * @return void
	 * @param CatalogProductType $value 
	 * @param  $index 
	 */
	function setProduct($value, $index = null)
	{
		if ($index !== null) {
			$this->Product[$index] = $value;
		} else {
			$this->Product = $value;
		}
	}
	/**
	 * @return void
	 * @param CatalogProductType $value 
	 */
	function addProduct($value)
	{
		$this->Product[] = $value;
	}
	/**
	 * @return ItemArrayType
	 */
	function getItemArray()
	{
		return $this->ItemArray;
	}
	/**
	 * @return void
	 * @param ItemArrayType $value 
	 */
	function setItemArray($value)
	{
		$this->ItemArray = $value;
	}
	/**
	 * @return BuyingGuideDetailsType
	 */
	function getBuyingGuideDetails()
	{
		return $this->BuyingGuideDetails;
	}
	/**
	 * @return void
	 * @param BuyingGuideDetailsType $value 
	 */
	function setBuyingGuideDetails($value)
	{
		$this->BuyingGuideDetails = $value;
	}
	/**
	 * @return boolean
	 */
	function getDuplicateItems()
	{
		return $this->DuplicateItems;
	}
	/**
	 * @return void
	 * @param boolean $value 
	 */
	function setDuplicateItems($value)
	{
		$this->DuplicateItems = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetProductsResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'CharacteristicsSetProductHistogram' =>
					array(
						'required' => false,
						'type' => 'CharacteristicsSetProductHistogramType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'PageNumber' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'ApproximatePages' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'HasMore' =>
					array(
						'required' => false,
						'type' => 'boolean',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'TotalProducts' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'Product' =>
					array(
						'required' => false,
						'type' => 'CatalogProductType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => true,
						'cardinality' => '0..*'
					),
					'ItemArray' =>
					array(
						'required' => false,
						'type' => 'ItemArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'BuyingGuideDetails' =>
					array(
						'required' => false,
						'type' => 'BuyingGuideDetailsType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'DuplicateItems' =>
					array(
						'required' => false,
						'type' => 'boolean',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
