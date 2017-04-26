{detail_table flow='invoice' from=$rs.init_detail.list barcode=false
	thead=[$lang.invoice_no,$lang.invoice_date,$lang.sum_quantity,$lang.price,$lang.total_money]
	operation=false
	tbody_empty=true
}
<tr index="{$index}" class="{$none}">
	<td>
		<a href="javascript:;" onclick="parent.addTab('{"/InvoiceInitStorage/view/id/`$item.init_id`"|U}','{"view"|title:"InvoiceInitStorage"}',1)">{$item.init_no}</a>
	</td>
	<td>{$item.fmd_init_date}</td>
	{td tfoot_value=$rs.init_detail.total.dml_quantity class="t_right"}
		{$item.dml_quantity}
	{/td}
	<td class="t_right">{$item.dml_price}</td>
	{td tfoot_value=$rs.init_detail.total.dml_money class="t_right"}
		{$item.dml_money}
	{/td}
</tr>
{/detail_table}