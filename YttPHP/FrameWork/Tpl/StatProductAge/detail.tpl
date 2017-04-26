{detail_table flow='stocktake' from=$rs.detail action=['view']
	thead=[$lang.instock_no,$lang.instock_date,$lang.instock_quantity]}
<tr index="{$index}" class="{$none}">
	<td class="t_center">{$item.instock_no}</td>
	<td>{$item.real_arrive_date}</td>
	{td tfoot_value="{$rs.detail_total.dml_quantity}"}
		{$item.dml_quantity}
	{/td}
</tr>
{/detail_table}
