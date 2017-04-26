<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.instock_no}</th>
		<th>{$lang.number_of_scans}</th>
		<th>{$lang.in_quantity}</th>
		{stat_product type='th' flow='storage_format' module='instock' value=$lang.no_in_quantity}
	</tr>
	{tr from=$list.list}
		{td link=['url'=>'Instock/view','link_id'=>['id'=>'instock_id']]} {$item.instock_no} {/td}
		{stat_product type='td' flow='storage_format' module='instock' value=$item.deliver_qn class=t_right}
		{stat_product type='td' flow='storage_format' module='instock' value=$item.storage_qn class=t_right}
		{stat_product type='td' flow='storage_format' module='instock' value=$item.no_storage_qn class=t_right}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
        {stat_product type='td' flow='storage_format' module='instock' value=$list.total.dml_sum_deliver_qn class="t_right"}
        {stat_product type='td' flow='storage_format' module='instock' value=$list.total.dml_sum_storage_qn class="t_right"}
		{stat_product type='td' flow='storage_format' module='instock' value=$list.total.dml_sum_no_storage_qn class="t_right"}
	</tr>
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		{stat_product type='td' flow='storage_format' module='instock' value=$list.total.all_deliver_qn class=t_right}
		{stat_product type='td' flow='storage_format' module='instock' value=$list.total.all_storage_qn class=t_right}
		{stat_product type='td' flow='storage_format' module='instock' value=$list.total.all_no_storage_qn class=t_right}
	</tr>
</table>