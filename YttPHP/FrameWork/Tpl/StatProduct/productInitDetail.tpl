<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.init_storage_no}</th>
		<th>{$lang.document_date}</th>
		{stat_product type='th' flow='storage_format' module='initStorage' value=$lang.quantity}
		<th>{$lang.init_total_quantity}</th>
		{if $rights}
		<th>{$lang.money}</th>
		{/if}
	</tr>
	{tr from=$list.list}
		{td link=['url'=>'InitStorage/view','link_id'=>['id'=>'init_storage_id']]} {$item.init_storage_no} {/td}
		<td>{$item.fmd_init_storage_date}</td>
		{stat_product type='td' flow='storage_format' module='initStorage' value=$item.dml_sum_qn class=t_right}
		<td class="t_right">{$item.dml_quantity}</td>
		{if $rights}
		<td class="t_right">{$item.dml_money}</td>
		{/if}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='initStorage' value=$list.total.dml_sum_qn class=t_right}
		<td class="t_right">{$list.total.dml_quantity}</td>
		{if $rights}
		<td class="t_right">{$list.total.dml_money}</td>
		{/if}
	</tr>
</table>