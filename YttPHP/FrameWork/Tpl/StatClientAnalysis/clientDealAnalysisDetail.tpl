{searchForm}
<div id="print">
{wz print=true printid=".add_box"}
<div class="add_box">
<table class="list">
<tr>
	<td colspan="6" class="tbold">{$list.total.title}</td>
</tr>
<tr>
	<th rowspan="2">{$lang.client_name}</th>
	<th rowspan="2">{$lang.basic_name}</th>
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
	<a href="javascript:;" onclick="addTab('{$item.client_view_url}','{"clientDealAnalysisDetail"|title:"StatClientAnalysis"}',1)">
	{$item.client_name}
	</a>
	</td>
	<td>{$item.basic_name}</td>
	<td class="t_right">{$item.dml_sale_quantity}</td>
	<td class="t_right">{$item.dml_return_use_quantity}</td>
	<td class="t_right">{$item.dml_return_unuse_quantity}</td>
	<td class="t_right">{$item.dml_avg_price}</td>
{/tr}
<tr class="red">
	<td colspan="2" class="t_right">{$lang.page_total}</td>
	<td class="t_right">{$list.total.dml_sale_quantity}</td>
	<td class="t_right">{$list.total.dml_return_use_quantity}</td>
	<td class="t_right">{$list.total.dml_return_unuse_quantity}</td>
	<td></td>
</tr>
<tr class="red">
	<td colspan="2" class="t_right">{$lang.total}</td>
	<td class="t_right">{$list.total.all_sale_quantity}</td>
	<td class="t_right">{$list.total.all_use_quantity}</td>
	<td class="t_right">{$list.total.all_unuse_quantity}</td>
	<td></td>
</tr>
</table>
</div>
</div>
