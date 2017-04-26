<table  class="list" border="1">
	<tr>
		<th>{$lang.product_no}</th>
		<th>{$lang.product_name}</th>
		<th>{$lang.in_quantity}</th>
		<th>{$lang.in_price}</th>
		<th>{$lang.instock_no}</th>
	</tr>
	{tr from=$list.list }
		<td>{$item.product_no}</td>
		<td>{$item.product_name}</td>
		<td>{$item.dml_quantity}</td>
		<td>{$item.dml_avg_price}</td>
		{td link=['url'=>'Instock/view/','link_id'=>['id'=>'id']]}
			{$item.instock_no}	
		{/td}
	{/tr}
	<tr>
		<td colspan="2" class="red t_right">本页合计:</td>
		<td class="red">{$list.total.dml_quantity}</td>
		<td class="red"></td>
		<td class="red"></td>
	</tr>
	<tr>
		<td colspan="2" class="red t_right">总合计:</td>
		<td class="red">{$list.total.all_quantity}</td>
		<td class="red"></td>
		<td class="red"></td>
	</tr>
</table>
