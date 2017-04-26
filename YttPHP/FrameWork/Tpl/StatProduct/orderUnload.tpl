<table class="detail_list"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.order_no}</th>
		<th>{$lang.factory_name}</th>
		{stat_product type='th' value=$lang.order_quantity flow='storage_format' module='order'}
		<th>{$lang.total_order_quantity}</th>
		{stat_product type='th' value=$lang.load_quantity flow='storage_format' module='loadContainer'}
		<th>{$lang.total_load_quantity}</th>
		<th>{$lang.total_unload_quantity}</th>
		{if $rights}
		<th>{$lang.total_money}</th>
		{/if}
	</tr>
	{tr from=$list.list}
		{td link=['url'=>'Orders/view','link_id'=>['id'=>'orders_id']]} {$item.order_no}  {/td}
		<td>{$item.factory_name}</td>
		{stat_product type='td' value=$item.dml_quantity flow='storage_format' module='order' class="t_right"}
		
		<td class="t_right">{$item.dml_sum_qn}</td>
		{stat_product type='td' value=$item.dml_load_capability flow='storage_format' module='loadContainer' class="t_right"}
		
		<td class="t_right">{$item.dml_load_quantity}</td>
		<td class="t_right">{$item.dml_unload_quantity}</td>
		{if $rights}
		<td class="t_right">{$item.dml_money}</td>
		{/if}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='order' value=$list.total.dml_quantity class="t_right"}
		<td class="t_right">{$list.total.dml_sum_qn}</td>
		{stat_product type='td' flow='storage_format' module='loadContainer' value=$list.total.dml_load_capability class="t_right"}
		<td class="t_right">{$list.total.dml_load_quantity}</td>
		<td class="t_right">{$list.total.dml_unload_quantity}</td>
		{if $rights}
		<td class="t_right">{$list.total.dml_money}</td>
		{/if}
	</tr>
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='order' value=$list.total.all_sum_qn class=t_right}
		<td class="t_right">{$list.total.all_quantity}</td>
		{stat_product type='td' flow='storage_format' module='loadContainer' value=$list.total.all_load_capability class=t_right}
		<td class="t_right">{$list.total.all_load_quantity}</td>
		<td class="t_right">{$list.total.all_unload_quantity}</td>
		{if $rights}
		<td class="t_right">{$list.total.all_money}</td>
		{/if}
	</tr>
</table>