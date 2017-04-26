<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th >{$lang.out_batch_no}</th>
		<th >{$lang.transport_start_date}</th>
		{stat_product type='th' flow='storage_format' module='out_batch' value=$lang.quantity}
	</tr>
	
	{tr from=$list.list}
		{td link=['url'=>'OutBatch/view','link_id'=>['id'=>'m_id']]} {$item.out_batch_no} {/td}
		<td>{$item.transport_start_date}</td>
		{stat_product type='td' flow='storage_format' module='out_batch' value=$item.dml_quantity class=t_right}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='out_batch' value=$list.total.dml_sum_qn class=t_right}
	</tr>
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='out_batch' value=$list.total.all_sum_qn class=t_right}
	</tr>
</table>