{searchForm}
{wz}
<div id="print" class="width98">
<table class="list">
<tr>
	<td colspan="6" class="tbold">{$list.total.title}</td>
</tr>
<tr>
	<th rowspan="2">{$lang.product_no}</th>
	<th rowspan="2">{$lang.product_name}</th>
	<th rowspan="2">{$lang.sale_quantity}</th>
	<th colspan="2">{$lang.return_quantity}</th>
	<th rowspan="2">{$lang.price}</th>
</tr>
<tr>
	<th>{$lang.able}</th>
	<th>{$lang.unable}</th>
</tr>
{tr from=$list.list}
	<td>
		{$item.product_no}
	</td>
	<td>{$item.product_name}</td>
	<td class="t_right">{$item.dml_sale_quantity}</td>
	<td class="t_right">{$item.dml_return_use_quantity}</td>
	<td class="t_right">{$item.dml_return_unuse_quantity}</td>
	<td class="t_right">{$item.dml_avg_price}</td>
{/tr}
<tr class="red">
	<td colspan="2" class="t_right">{$lang.page_total}:</td>
	<td class="t_right">{$list.total.dml_sale_quantity}</td>
	<td class="t_right">{$list.total.dml_return_use_quantity}</td>
	<td class="t_right">{$list.total.dml_return_unuse_quantity}</td>
	<td></td>
</tr>
<tr class="red">
	<td colspan="2" class="t_right">{$lang.total}:</td>
	<td class="t_right">{$list.total.all_sale_quantity}</td>
	<td class="t_right">{$list.total.all_use_quantity}</td>
	<td class="t_right">{$list.total.all_unuse_quantity}</td>
	<td></td>
</tr>
</table>
</div>