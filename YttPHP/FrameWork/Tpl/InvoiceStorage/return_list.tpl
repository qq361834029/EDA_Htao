{detail_table flow='invoice' from=$rs.return_detail.list barcode=false
	thead=['flow_invoice_company',$lang.client_name,$lang.invoice_no,$lang.invoice_date,$lang.sum_quantity,$lang.price,$lang.total_money,'flow_invoice_discount_money','flow_invoice_discount_after_money',$lang.iva_cost,$lang.total_cost]
	operation=false
	tbody_empty=true
}
<tr index="{$index}" class="{$none}">
	{td type='flow_invoice_company'}	
		{$item.basic_name}
	{/td}
	<td>
		{$item.client_name}
	</td>
	<td>
		<a href="javascript:;" onclick="parent.addTab('{"/InvoiceOut/view/id/`$item.invoice_out_id`"|U}','{"view"|title:"InvoiceOut"}',1)">{$item.invoice_no}</a>
	</td>
	<td>{$item.fmd_invoice_date}</td>
	{td tfoot_value=$rs.return_detail.total.dml_quantity class="t_right"}
		{$item.dml_quantity}
	{/td}
	<td class="t_right">{$item.dml_price}</td>
	{td tfoot_value=$rs.return_detail.total.dml_money class="t_right"}
		{$item.dml_money}
	{/td}
	{td type='flow_invoice_discount_money' class="t_right"}
		{$item.dml_discount}
	{/td}
	{td type='flow_invoice_discount_after_money' tfoot_value=$rs.return_detail.total.dml_after_discount_money class="t_right"}
		{$item.dml_after_discount_money}
	{/td}
	{td tfoot_value=$rs.return_detail.total.dml_iva_cost class="t_right"}
		{$item.dml_iva_cost}
	{/td}
	{td tfoot_value=$rs.return_detail.total.dml_total_money class="t_right"}
		{$item.dml_total_money}
	{/td}
</tr>
{/detail_table}