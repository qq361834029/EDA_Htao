{searchForm}
<div id="print" class="width100">
{wz}
{note}
<table  class="list" border="1">
	<tr>
		<th rowspan="2">{$lang.product_no}</th>
		<th rowspan="2">{$lang.product_name}</th>
		<th rowspan="2">{$lang.sale_quantity}</th>
		<th colspan="2">{$lang.return_quantity}</th>
		{if $client_currency!=1}
		<th rowspan="2">{$lang.currency_no}</th>
		{/if}
		<th rowspan="2">{$lang.sale_money}</th>
		<th rowspan="2">{$lang.return_money}</th>
	</tr>
	<tr>
		<th>{$lang.able}</th>
		<th>{$lang.unable}</th>
	</tr>
	{include file='StatSale/productList.tpl'}
</table>
</div>
