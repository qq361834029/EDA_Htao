<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Details the recoupment policy on this site. There are two sites involved in 
 * recoupment - the listing siteand the user registration site, each of which must 
 * agree before eBay enforces recoupment for a seller and listing. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/RecoupmentPolicyDetailsType.html
 *
 */
class RecoupmentPolicyDetailsType extends EbatNs_ComplexType
{
	/**
	 * @var boolean
	 */
	protected $EnforcedOnListingSite;
	/**
	 * @var boolean
	 */
	protected $EnforcedOnRegistrationSite;
	/**
	 * @var string
	 */
	protected $DetailVersion;
	/**
	 * @var dateTime
	 */
	protected $UpdateTime;

	/**
	 * @return boolean
	 */
	function getEnforcedOnListingSite()
	{
		return $this->EnforcedOnListingSite;
	}
	/**
	 * @return void
	 * @param boolean $value 
	 */
	function setEnforcedOnListingSite($value)
	{
		$this->EnforcedOnListingSite = $value;
	}
	/**
	 * @return boolean
	 */
	function getEnforcedOnRegistrationSite()
	{
		return $this->EnforcedOnRegistrationSite;
	}
	/**
	 * @return void
	 * @param boolean $value 
	 */
	function setEnforcedOnRegistrationSite($value)
	{
		$this->EnforcedOnRegistrationSite = $value;
	}
	/**
	 * @return string
	 */
	function getDetailVersion()
	{
		return $this->DetailVersion;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setDetailVersion($value)
	{
		$this->DetailVersion = $value;
	}
	/**
	 * @return dateTime
	 */
	function getUpdateTime()
	{
		return $this->UpdateTime;
	}
	/**
	 * @return void
	 * @param dateTime $value 
	 */
	function setUpdateTime($value)
	{
		$this->UpdateTime = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('RecoupmentPolicyDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'EnforcedOnListingSite' =>
					array(
						'required' => false,
						'type' => 'boolean',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'EnforcedOnRegistrationSite' =>
					array(
						'required' => false,
						'type' => 'boolean',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'DetailVersion' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'UpdateTime' =>
					array(
						'required' => false,
						'type' => 'dateTime',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>