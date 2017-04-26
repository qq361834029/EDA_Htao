{detail_table flow='stocktake' from=$rs.detail action=['view'] barcode=false
	thead=[$lang.instock_no,$lang.instock_date,$lang.instock_quantity]}
<tr index="{$index}" class="{$none}">
	<td><a href="javascript:;" onclick="addTab('{"/Instock/view/id/`$item.main_id`"|U}','{"view"|title:"Instock"}',1)">{$item.instock_no}</td>
	<td>{$item.real_arrive_date}</td>
	{td tfoot_value="{$rs.detail_total.dml_quantity}" class="t_right"}
		{$item.dml_quantity}
	{/td}
</tr>
{/detail_table}
