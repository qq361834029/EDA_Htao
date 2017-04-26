<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Data associated with payment (payment durations). 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/PaymentDetailsType.html
 *
 */
class PaymentDetailsType extends EbatNs_ComplexType
{
	/**
	 * @var int
	 */
	protected $HoursToDeposit;
	/**
	 * @var int
	 */
	protected $DaysToFullPayment;

	/**
	 * @return int
	 */
	function getHoursToDeposit()
	{
		return $this->HoursToDeposit;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setHoursToDeposit($value)
	{
		$this->HoursToDeposit = $value;
	}
	/**
	 * @return int
	 */
	function getDaysToFullPayment()
	{
		return $this->DaysToFullPayment;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setDaysToFullPayment($value)
	{
		$this->DaysToFullPayment = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('PaymentDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'HoursToDeposit' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'DaysToFullPayment' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
