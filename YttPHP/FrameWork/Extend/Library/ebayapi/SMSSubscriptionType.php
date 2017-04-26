<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'SMSSubscriptionUserStatusCodeType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'WirelessCarrierIDCodeType.php';
require_once 'SMSSubscriptionErrorCodeCodeType.php';
require_once 'ItemIDType.php';

/**
 * User data related to notifications. Note that SMS is currently reserved for 
 * future use. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/SMSSubscriptionType.html
 *
 */
class SMSSubscriptionType extends EbatNs_ComplexType
{
	/**
	 * @var string
	 */
	protected $SMSPhone;
	/**
	 * @var SMSSubscriptionUserStatusCodeType
	 */
	protected $UserStatus;
	/**
	 * @var WirelessCarrierIDCodeType
	 */
	protected $CarrierID;
	/**
	 * @var SMSSubscriptionErrorCodeCodeType
	 */
	protected $ErrorCode;
	/**
	 * @var ItemIDType
	 */
	protected $ItemToUnsubscribe;

	/**
	 * @return string
	 */
	function getSMSPhone()
	{
		return $this->SMSPhone;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setSMSPhone($value)
	{
		$this->SMSPhone = $value;
	}
	/**
	 * @return SMSSubscriptionUserStatusCodeType
	 */
	function getUserStatus()
	{
		return $this->UserStatus;
	}
	/**
	 * @return void
	 * @param SMSSubscriptionUserStatusCodeType $value 
	 */
	function setUserStatus($value)
	{
		$this->UserStatus = $value;
	}
	/**
	 * @return WirelessCarrierIDCodeType
	 */
	function getCarrierID()
	{
		return $this->CarrierID;
	}
	/**
	 * @return void
	 * @param WirelessCarrierIDCodeType $value 
	 */
	function setCarrierID($value)
	{
		$this->CarrierID = $value;
	}
	/**
	 * @return SMSSubscriptionErrorCodeCodeType
	 */
	function getErrorCode()
	{
		return $this->ErrorCode;
	}
	/**
	 * @return void
	 * @param SMSSubscriptionErrorCodeCodeType $value 
	 */
	function setErrorCode($value)
	{
		$this->ErrorCode = $value;
	}
	/**
	 * @return ItemIDType
	 */
	function getItemToUnsubscribe()
	{
		return $this->ItemToUnsubscribe;
	}
	/**
	 * @return void
	 * @param ItemIDType $value 
	 */
	function setItemToUnsubscribe($value)
	{
		$this->ItemToUnsubscribe = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('SMSSubscriptionType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'SMSPhone' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'UserStatus' =>
					array(
						'required' => false,
						'type' => 'SMSSubscriptionUserStatusCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'CarrierID' =>
					array(
						'required' => false,
						'type' => 'WirelessCarrierIDCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'ErrorCode' =>
					array(
						'required' => false,
						'type' => 'SMSSubscriptionErrorCodeCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'ItemToUnsubscribe' =>
					array(
						'required' => false,
						'type' => 'ItemIDType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
