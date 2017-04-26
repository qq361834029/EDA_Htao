<table class="list">
	<tr>
		<th rowspan="2">{$lang.product_no}</th>
		<th rowspan="2">{$lang.product_name}</th>
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
	{tr from=$list.list}
		<td>{$item.product_no}</td>
		<td>{$item.product_name}</td>
		<td class="t_right">{$item.dml_init_quantity}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_stock}','{"storageDetail"|title:"StatStorage"}',1); ">{$item.dml_stock_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_sale}','{"storageDetail"|title:"StatStorage"}',1); ">{$item.dml_sale_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_return_use}','{"storageDetail"|title:"StatStorage"}',1); ">{$item.dml_back_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_return_no_use}','{"storageDetail"|title:"StatStorage"}',1); ">{$item.dml_no_use_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_adjust}','{"storageDetail"|title:"StatStorage"}',1); ">{$item.dml_adjust_quantity}</a></td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{$item.url_stocktake}','{"storageDetail"|title:"StatStorage"}',1); ">{$item.dml_stocktake_quantity}</a></td>
		<td class="t_right">{$item.dml_real_quantity}</td>
	{/tr}
	<tr class="red" >
		<td>{$lang.total}：</td>
		<td class="t_right"></td>
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