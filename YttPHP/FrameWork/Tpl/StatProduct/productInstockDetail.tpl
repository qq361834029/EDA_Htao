<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.instock_no}</th>
		<th>{$lang.box_no}</th>
		<th>{$lang.real_arrive_date}</th>
		{stat_product type='th' flow='storage_format' module='instock' value=$lang.quantity}
	</tr>
	{tr from=$list.list}
		{td link=['url'=>'Instock/view','link_id'=>['id'=>'instock_id']]} {$item.instock_no} {/td}
		<td>{$item.box_no}</td>
		<td>{$item.fmd_real_arrive_date}</td>
		{stat_product type='td' flow='storage_format' module='instock' value=$item.dml_quantity class=t_right}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
		<td></td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='instock' value=$list.total.dml_sum_qn class="t_right"}
	</tr>
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		<td></td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='instock' value=$list.total.all_quantity class=t_right}
	</tr>
</table>