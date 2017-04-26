<table class="list">
	<tr>
		{if C('PRODUCT_CLASS_LEVEL')>=1}
		<th rowspan="2">{$lang.class_name}</th>
		{else}
		<th rowspan="2">&nbsp;</th>
		{/if}
		<th rowspan="2">{$lang.init_quantity}</th>
		<th rowspan="2">{$lang.instock_quantity}</th>
		<th rowspan="2">{$lang.sale_quantity}</th>
		<th colspan="2">{$lang.return_quantity}</th>
		<th rowspan="2">{$lang.adjust_quantity}</th>
		<th rowspan="2">{$lang.stocktake_quantity}</th>
		<th rowspan="2">{$lang.real_quantity}</th>
	</tr>
	<tr>
		<th>{$lang.use_quantity}</th>
		<th>{$lang.unuse_quantity}</th>
	</tr>
	{foreach item=item from=$list.list}
	<tr>
		<td>{$item.class_name}</td>
		<td class="t_right">{$item.dml_init_quantity}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_stock}','{$lang.stat_instock_detail_2}',1); ">{$item.dml_stock_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_sale}','{$lang.stat_sale_detail}',1); ">{$item.dml_sale_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_return_use}','{$lang.stat_return_detail}',1); ">{$item.dml_back_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_return_no_use}','{$lang.stat_return_detail}',1); ">{$item.dml_no_use_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_adjust}','{$lang.stat_adjust_detail}',1); ">{$item.dml_adjust_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_stocktake}','{$lang.stat_stocktake_detail}',1); ">{$item.dml_stocktake_quantity}</a></td>
		<td class="t_right">{$item.dml_real_quantity}</td>
	</tr>
	{if $item.parent_id>0&&$item.show_total==1}
	<tr class="red" >
		<td class="t_right">{$item.parent_name}</td>
		<td class="t_right">{$item.dml_sum_init_quantity}</td>
		<td class="t_right">{$item.dml_sum_stock_quantity}</td>
		<td class="t_right">{$item.dml_sum_sale_quantity}</td>
		<td class="t_right">{$item.dml_sum_back_quantity}</td>
		<td class="t_right">{$item.dml_sum_no_use_quantity}</td>
		<td class="t_right">{$item.dml_sum_adjust_quantity}</td>
		<td class="t_right">{$item.dml_sum_stocktake_quantity}</td>
		<td class="t_right">{$item.dml_sum_real_quantity}</td>
	</tr>
	{/if}
	{/foreach}
	<tr class="red" >
		<td class="t_right">{$lang.total}：</td>
		<td class="t_right">{$list.total.dml_init_quantity}</td>
		<td class="t_right">{$list.total.dml_stock_quantity}</td>
		<td class="t_right">{$list.total.dml_sale_quantity}</td>
		<td class="t_right">{$list.total.dml_back_quantity}</td>
		<td class="t_right">{$list.total.dml_no_use_quantity}</td>
		<td class="t_right">{$list.total.dml_adjust_quantity}</td>
		<td class="t_right">{$list.total.dml_stocktake_quantity}</td>
		<td class="t_right">{$list.total.dml_real_quantity}</td>
	</tr>
</table>