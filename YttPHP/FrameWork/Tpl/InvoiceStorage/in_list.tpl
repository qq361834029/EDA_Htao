{detail_table flow='invoice' from=$rs.in_detail.list barcode=false
	thead=['flow_invoice_company',$lang.supplier,$lang.invoice_no,$lang.invoice_date,$lang.sum_quantity,$lang.price,$lang.total_money,$lang.iva_cost,$lang.total_cost]
	operation=false
	tbody_empty=true
}
<tr index="{$index}" class="{$none}">
	{td type='flow_invoice_company'}	
		{$item.basic_name}
	{/td}
	<td>
		{$item.factory_name}
	</td>
	<td>
		<a href="javascript:;" onclick="parent.addTab('{"/InvoiceIn/view/id/`$item.invoice_in_id`"|U}','{"view"|title:"InvoiceIn"}',1)">{$item.invoice_no}</a>
	</td>
	<td>{$item.fmd_invoice_date}</td>
	{td tfoot_value=$rs.in_detail.total.dml_quantity class="t_right"}
		{$item.dml_quantity}
	{/td}
	<td class="t_right">{$item.dml_price}</td>
	{td tfoot_value=$rs.in_detail.total.dml_money class="t_right"}
		{$item.dml_money}
	{/td}
	{td tfoot_value=$rs.in_detail.total.dml_iva_cost class="t_right"}
		{$item.dml_iva_cost}
	{/td}
	{td tfoot_value=$rs.in_detail.total.dml_total_money class="t_right"}
		{$item.dml_total_money}
	{/td}
</tr>
{/detail_table}