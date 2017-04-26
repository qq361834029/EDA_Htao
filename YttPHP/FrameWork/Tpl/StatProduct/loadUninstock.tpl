<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.load_container_no}</th>
		<th>{$lang.container_no}</th>
		<th>{$lang.load_date}</th>
		{stat_product type='th' flow='storage_format' module='loadContainer' value=$lang.load_quantity}
		<th>{$lang.total_load_quantity}</th>
		{if $rights}
		<th>{$lang.money}</th>
		{/if}
	</tr>
	{tr from=$list.list}
		{td link=['url'=>'LoadContainer/view','link_id'=>['id'=>'load_container_id']]} {$item.load_container_no}  {/td}
		<td>{$item.container_no}</td>
		<td>{$item.fmd_load_date}</td>
		{stat_product type='td' flow='storage_format' module='loadContainer' value=$item.dml_sum_qn class="t_right"}
		<td class="t_right">{$item.dml_quantity}</td>
		{if $rights}
		<td class="t_right">{$item.dml_money}</td>
		{/if}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
		<td></td>
		<td></td>
		{stat_product type='td' flow="storage_format" module='loadContainer' value=$list.total.dml_sum_qn class="t_right"}
		<td class="t_right">{$list.total.dml_quantity}</td>
		{if $rights}
		<td class="t_right">{$list.total.dml_money}</td>
		{/if}
	</tr>
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		<td></td>
		<td></td>
		{stat_product type='td' flow="storage_format" module='loadContainer' value=$list.total.all_sum_qn class="t_right"}
		<td class="t_right">{$list.total.all_quantity}</td>
		{if $rights}
		<td class="t_right">{$list.total.all_money}</td>
		{/if}
	</tr>
</table>