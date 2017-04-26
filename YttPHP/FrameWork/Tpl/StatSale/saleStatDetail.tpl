{searchForm}
<div id="print">
{wz print=true printid=".add_box"}
{if $smarty.get.type>1}
	{assign var='rowspan' value='2'}
{else}
	{assign var='rowspan' value='1'}
{/if}
<div class="add_box">
<table class="list">
	<tr>
		<th rowspan="{$rowspan}" >{$lang.product_no}</th>
		<th rowspan="{$rowspan}">{$lang.product_name}</th>
		{if $client_currency!=1}
		<th rowspan="{$rowspan}">{$lang.currency_no}</th>
		{/if}
		{if $smarty.get.type==1}
		<th rowspan="{$rowspan}">{$lang.sale_quantity}</th>
		<th rowspan="{$rowspan}">{$lang.sale_money}</th>
		<th rowspan="{$rowspan}">{$lang.sale_no}</th>
		{else}
		<th >{$lang.return_quantity}</th>
		<th rowspan="{$rowspan}">{$lang.return_money}</th>
		<th rowspan="{$rowspan}">{$lang.return_sale_order_no}</th>
		{/if}
	</tr>
	{if $smarty.get.type==2}
	<tr>
		<th>{$lang.able}</th>
	</tr>
	{elseif $smarty.get.type==3}
	<tr>
		<th>{$lang.unable}</th>
	</tr>
	{/if}
	{tr from=$list.list}
		<td>{$item.product_no}</td>
		<td>{$item.product_name}</td>
		{if $client_currency!=1}
		<td>{$item.currency_no}</td>
		{/if}
		{if $smarty.get.type==1}
			<td class="t_right">{$item.dml_sale_quantity}</td>
			<td class="t_right">{$item.dml_sale_money}</td>
			<td class="t_center">
				<a href="javascript:;" onclick="addTab('{$item.view_url}','{"view"|title:"SaleOrder"}',1); ">{$item.sale_order_no}</a> 
			</td>
		{else}
			<td class="t_right">{$item.dml_quantity}</td>
			<td class="t_right">{$item.dml_return_money}</td>
			<td class="t_center">
				<a href="javascript:;" onclick="addTab('{$item.view_url}','{"view"|title:"ReturnSaleOrder"}',1); ">{$item.return_sale_order_no}</a>
			</td>
		{/if}
	{/tr}
	<tr class="red">
		<td colspan="{if $client_currency!=1}3{else}2{/if}" class="t_right">{$lang.total}</td>
		<td class="t_right">
		{if $smarty.get.type==1}
		{$list.total.dml_sale_quantity}
		{else}
		{$list.total.dml_quantity}
		{/if}
		</td>
		<td class="t_right">{$list.total.total_money}</td>
		<td></td>
	</tr>
</table>
</div>
</div>






