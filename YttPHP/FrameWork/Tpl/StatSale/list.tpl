<table  class="list" border="1">
	<tr>
	{if $smarty.post.query['b.product_id']}
		{assign var="group" value="product_id"}
		<th rowspan="2">{$lang.product_no}</th>
		<th rowspan="2">{$lang.product_name}</th>
	{elseif $smarty.post.class_level==5}
		{assign var="group" value="client_id"}
		<th rowspan="2">{$lang.client_name}</th>
		<th rowspan="2">{$lang.basic_name}</th>
	{else}
		{assign var="group" value="class_name"}
		<th rowspan="2">{$lang.class_name}</th>
	{/if}
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
	{if $smarty.post.query['b.product_id']}
		{include file='StatSale/productList.tpl'}
	{elseif $smarty.post.class_level==5}
		{include file='StatSale/clientList.tpl'}	
	{elseif 'product_class_level'|C>=1}
		{include file='StatSale/classList.tpl'}
	{/if}
</table>