{detail_table flow='invoice' from=$rs.detail op_show=['add','edit'] barcode=false
	thead=['flow_invoice_product_no',$lang.product_name,'flow_invoice_ingredient',$lang.sum_quantity,$lang.price,$lang.total_money]
}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	{td view='product_no' type='flow_invoice_product_no' class="t_left" width="12%"}	
		<input type="hidden" name="detail[{$index}][product_id]" class="w120" value="{$item.product_id}" {if 'invoice.product_from'|C==1}jqproc{else}jqip{/if}/>
		<input type="text" name="product_no" url="{'AutoComplete/invoiceProduct'|U}" class="w120" value="{$item.product_no}"  jqac />
	{/td}
	{if 'invoice.product'|C==2}
	{td view='product_name' class="t_left" width="20%" }
		<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}" {if 'invoice.product_from'|C==1}jqproc{else}jqip{/if}>
		<input type="text" name="product_name" url="{'AutoComplete/invoiceProduct'|U}" style="width:150px"  value="{$item.product_name}" jqac >
	{/td}
	{else}
	{td id="span_product_name" class="t_left"}
		{$item.product_name}
	{/td}
	{/if}
	{td type="flow_invoice_ingredient" id="span_invoice_ingredient" class="t_right"  width="10%"}
		{$item.ingredient}
	{/td}
	{td tfoot=[total_quantity=>""] view='dml_quantity' tfoot_value=$rs.detail_total.dml_quantity width="10%"  class="t_right"}
		<input type="text" name="detail[{$index}][quantity]" value="{$item.edml_quantity}" class="w80" row_total id="quantity"  row_tax/>
	{/td}
	{td view='dml_price' class="t_right"  width="10%"  class="t_right"}
		<input type="text" name="detail[{$index}][price]" value="{$item.edml_price}" class="w80" row_total_money row_tax>
	{/td}
	{td id="total_money" total_row_money='' tfoot=['total_col_money'=>''] tfoot_value=$rs.detail_total.dml_money class="t_right"}
		{$item.dml_money}
	{/td}
	{detail_operation}
</tr>
{/detail_table}