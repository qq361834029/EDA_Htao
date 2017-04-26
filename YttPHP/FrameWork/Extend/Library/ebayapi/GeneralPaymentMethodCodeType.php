<?php
// autogenerated file 18.03.2011 12:48
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * GeneralPaymentMethodCodeType - Type declaration to be used by otherschema. This 
 * code identifies the general types of payment means,e.g., used by payment service 
 * provider applications. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GeneralPaymentMethodCodeType.html
 *
 * @property string Other
 * @property string Echeck
 * @property string ACH
 * @property string Creditcard
 * @property string PayPalBalance
 * @property string CustomCode
 */
class GeneralPaymentMethodCodeType extends EbatNs_FacetType
{
	const CodeType_Other = 'Other';
	const CodeType_Echeck = 'Echeck';
	const CodeType_ACH = 'ACH';
	const CodeType_Creditcard = 'Creditcard';
	const CodeType_PayPalBalance = 'PayPalBalance';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GeneralPaymentMethodCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_GeneralPaymentMethodCodeType = new GeneralPaymentMethodCodeType();

?>