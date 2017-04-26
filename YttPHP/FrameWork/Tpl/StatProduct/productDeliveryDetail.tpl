<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.delivery_no}</th>
		<th>{$lang.sale_no}</th>
		<th>{$lang.delivery_date}</th>
		<th>{$lang.client_name}</th>
		{stat_product type='th' flow='storage_format' module='delivery' value=$lang.quantity}
		<th>{$lang.delivery_qn}</th>
		{if $rights}
		<th>{$lang.money}</th>
		{/if}
	</tr>
	{tr from=$list.list}
		{td link=['url'=>'Delivery/view','link_id'=>['id'=>'delivery_id']]} {$item.delivery_no} {/td}
		{td link=['url'=>'SaleOrder/view','link_id'=>['id'=>'sale_order_id']]} {$item.orders_no} {/td}
		<td>{$item.fmd_delivery_date}</td>
		<td>{$item.client_name}</td>
		{stat_product type='td' flow='storage_format' module='delivery' value=$item.dml_sum_qn class=t_right}
		<td class="t_right">{$item.dml_quantity}</td>
		{if $rights}
		<td class="t_right">{$item.dml_money}</td>
		{/if}
	{/tr}
	<tr class="red">
		<td class="t_right" >{$lang.page_total}：</td>
		<td></td>
		<td></td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='delivery' value=$list.total.dml_sum_qn class=t_right}
		<td class="t_right">{$list.total.dml_quantity}</td>
		{if $rights}
		<td class="t_right">{$list.total.total_money}</td>
		{/if}
	</tr>
	<tr class="red">
		<td class="t_right" >{$lang.total}：</td>
		<td></td>
		<td></td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='delivery' value=$list.total.all_sum_qn class=t_right}
		<td class="t_right">{$list.total.all_quantity}</td>
		{if $rights}
		<td class="t_right">{$list.total.all_money}</td>
		{/if}
	</tr>
</table>