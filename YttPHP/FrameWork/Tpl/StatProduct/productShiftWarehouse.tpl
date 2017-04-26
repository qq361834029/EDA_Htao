<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th >{$lang.shift_warehouse_no}</th>
		<th >{$lang.shift_warehouse_date}</th>
		{stat_product type='th' flow='storage_format' module='adjust' value=$lang.quantity}
	</tr>
	
	{tr from=$list.list}
		{td link=['url'=>'ShiftWarehouse/view','link_id'=>['id'=>'m_id']]} {$item.shift_warehouse_no} {/td}
		<td>{$item.fmd_shift_warehouse_date}</td>
		{stat_product type='td' flow='storage_format' module='adjust' value=$item.dml_quantity class=t_right}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='adjust' value=$list.total.dml_sum_qn class=t_right}
	</tr>
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='adjust' value=$list.total.all_sum_qn class=t_right}
	</tr>
</table>