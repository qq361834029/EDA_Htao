<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th >{$lang.return_sale_order_no}</th>
		<th >{$lang.returned_date}</th>
		{stat_product type='th' flow='storage_format' module='return_sale_order' value=$lang.quantity}
	</tr>
	
	{tr from=$list.list}
		{td link=['url'=>'ReturnSaleOrder/view','link_id'=>['id'=>'m_id']]} {$item.return_sale_order_no} {/td}
		<td>{$item.returned_date}</td>
		{stat_product type='td' flow='storage_format' module='return_sale_order' value=$item.dml_quantity class=t_right}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='return_sale_order' value=$list.total.dml_sum_qn class=t_right}
	</tr>
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='return_sale_order' value=$list.total.all_sum_qn class=t_right}
	</tr>
</table>