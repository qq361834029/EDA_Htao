<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.return_sale_order_no}</th>
		<th >{$lang.return_sale_date}</th>
		{stat_product type='th' flow='storage_format' module='sale' value=$lang.quantity}
		<th>{$lang.in_quantity}</th>
		<th>{$lang.no_in_quantity}</th>
	</tr>
	
	{tr from=$list.list}
		{td link=['url'=>'ReturnSaleOrder/view','link_id'=>['id'=>'return_sale_order_id']]} {$item.return_sale_order_no} {/td}
		
		<td>{$item.fmd_return_order_date}</td>
		{stat_product type='td' flow='storage_format' module='sale' value=$item.dml_quantity class=t_right}
		<td class="t_right">{$item.storage_qn}</td>
		<td class="t_right">{$item.no_storage_qn}</td>
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='sale' value=$list.total.dml_sum_qn class=t_right}
		<td class="t_right">{$list.total.sum_storage_qn}</td>
		<td class="t_right">{$list.total.sum_no_storage_qn}</td>
	</tr>
	<tr class="red">
		<td class="t_right">{$lang.total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='sale' value=$list.total.all_sum_qn class=t_right}
		<td class="t_right">{$list.total.all_storage_qn}</td>
		<td class="t_right">{$list.total.all_no_storage_qn}</td>
	</tr>
</table>