<table  class="list" border="1">
	<tr>
		<th>{$lang.factory}</th>
		<th>{$lang.product_no}</th>
		<th>{$lang.product_name}</th>
		<th>{$lang.intock_total}</th>
	</tr>
	{tr from=$list.list }
		<td>{$item.factory_name}</td>
		<td>{$item.product_no}</td>
		<td>{$item.product_name}</td>
		{td link=['url'=>'StatInstock/view','link_id'=>['id'=>'factory_id','sp_query_factory_id'=>'factory_id','sp_query_product_id'=>'product_id','sp_date_from_real_arrive_date'=>"`$smarty.post.date.from_real_arrive_date|default:0`",'sp_date_to_real_arrive_date'=>"`$smarty.post.date.to_real_arrive_date|default:0`"]] class="t_right"}
			{$item.dml_quantity}
		{/td}
	{/tr}
	<tr>
		<td colspan="3" class="red t_right">本页合计：</td>
		<td class="red t_right">{$list.total.dml_quantity}</td>
	</tr>
	<tr>
		<td colspan="3" class="red t_right">总合计：</td>
		<td class="red t_right">{$total.total.dml_quantity}</td>
	</tr>
</table>
<br><br>