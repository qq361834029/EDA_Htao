{searchForm}
<div id="print">
{wz print=true printid=".add_box"}
<div class="add_box">
<table class="list">
	<tr>
		<th>{$lang.product_no}</th>
		<th>{$lang.product_name}</th>
		<th>{$lang.sum_quantity}</th>
		<th>{$lang.doc_order_detail}</th>
	</tr>
	{tr from=$list.list}
		<td>{$item.product_no}</td>
		<tD>{$item.product_name}</tD>
		<td class="t_right">{$item.dml_sum_quantity}</td>
		<td class="t_center"><a href="javascript:;" onclick="addTab('{$item.detail_url}','{$item.detail_title}',1); ">{$item.link_no}</a></td>
	{/tr}
	<tr class="red">
		<td></td>
		<td class="t_right">{$lang.total}：</td>
		<td class="t_right">{$list.total.dml_sum_quantity}</td>
		<td></td>
	</tr>
</table>
</div>
</div>