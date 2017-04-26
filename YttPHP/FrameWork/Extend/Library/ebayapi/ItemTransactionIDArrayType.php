<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'ItemTransactionIDType.php';
require_once 'EbatNs_ComplexType.php';

/**
 * Container of ItemTransactionIDs. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ItemTransactionIDArrayType.html
 *
 */
class ItemTransactionIDArrayType extends EbatNs_ComplexType
{
	/**
	 * @var ItemTransactionIDType
	 */
	protected $ItemTransactionID;

	/**
	 * @return ItemTransactionIDType
	 * @param integer $index 
	 */
	function getItemTransactionID($index = null)
	{
		if ($index !== null) {
			return $this->ItemTransactionID[$index];
		} else {
			return $this->ItemTransactionID;
		}
	}
	/**
	 * @return void
	 * @param ItemTransactionIDType $value 
	 * @param  $index 
	 */
	function setItemTransactionID($value, $index = null)
	{
		if ($index !== null) {
			$this->ItemTransactionID[$index] = $value;
		} else {
			$this->ItemTransactionID = $value;
		}
	}
	/**
	 * @return void
	 * @param ItemTransactionIDType $value 
	 */
	function addItemTransactionID($value)
	{
		$this->ItemTransactionID[] = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ItemTransactionIDArrayType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'ItemTransactionID' =>
					array(
						'required' => false,
						'type' => 'ItemTransactionIDType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => true,
						'cardinality' => '0..*'
					)
				));
	}
}
?>
