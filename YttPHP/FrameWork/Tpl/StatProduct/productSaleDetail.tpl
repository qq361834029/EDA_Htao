<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.sale_qn}</th>
		<th>{$lang.order_date}</th>
		<th>{$lang.client_name}</th>
		{stat_product type='th' flow='storage_format' module='sale' value=$lang.quantity}
	</tr>
	{tr from=$list.list}
		{td link=['url'=>'SaleOrder/view','link_id'=>['id'=>'sale_order_id']]} {$item.sale_order_no} {/td}
		<td>{$item.fmd_order_date}</td>
		<td class="t_right">{$item.comp_name}</td>
		{stat_product type='td' flow='storage_format' module='sale' value=$item.dml_quantity class=t_right}
	{/tr}
	<tr class="red">
		<td colspan="3" class="t_right">{$lang.page_total}：</td>
		{stat_product type='td' flow='storage_format' module='sale' value=$list.total.dml_sum_qn class=t_right}
	</tr>
	<tr class="red">
		<td class="t_right" colspan="3">{$lang.total}：</td>
		{stat_product type='td' flow='storage_format' module='sale' value=$list.total.all_sum_qn class=t_right}
	</tr>
</table>