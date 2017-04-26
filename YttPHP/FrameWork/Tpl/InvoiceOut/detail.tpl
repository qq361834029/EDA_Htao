{detail_table flow='invoice' from=$rs.detail op_show=['add','edit'] barcode=false
	thead=['flow_invoice_product_no',$lang.product_name,'flow_invoice_ingredient',$lang.sum_quantity,$lang.price,$lang.total_money,'flow_invoice_discount_money','flow_invoice_discount_after_money']
}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	{td view='product_no' type='flow_invoice_product_no' width="12%" class="t_left"}	
		<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}" class="w120" {if 'invoice.product_from'|C==1}jqproc{else}jqip{/if}/>
		<input type="text" name="temp[{$index}][product_no]" url="{'AutoComplete/invoiceProduct'|U}" value="{$item.product_no}" class="w120" jqac />
	{/td}
	{if 'invoice.product'|C==2}
	{td view='product_name' width="12%" class="t_left"}
		<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}" class="w120" {if 'invoice.product_from'|C==1}jqproc{else}jqip{/if}>
		<input type="text" name="temp[{$index}][product_name]" url="{'AutoComplete/invoiceProduct'|U}" class="w120" value="{$item.product_name}" jqac >
	{/td}
	{else}
	{td id="span_product_name" width="20%" class="t_left"}
		{$item.product_name}
	{/td}
	{/if}
	{td type="flow_invoice_ingredient" id="span_invoice_ingredient" width="10%"}
		{$item.ingredient}
	{/td}
	{td tfoot=[total_quantity=>""] view='dml_quantity' tfoot_value=$rs.detail_total.dml_quantity width="6%" class="t_right"}
		<input type="text" name="detail[{$index}][quantity]" value="{$item.edml_quantity}" row_total id="quantity"  row_tax/>
	{/td}
	{td view='dml_price' width="6%" class="t_right"}
		<input type="text" name="detail[{$index}][price]" value="{$item.edml_price}" row_total_money row_tax>
	{/td}
	{td id="total_money" total_row_money='' tfoot=['total_col_money'=>''] tfoot_value=$rs.detail_total.dml_money width="18%" class="t_right"}
		{$item.dml_money}
	{/td}
	{td type='flow_invoice_discount_money' view='dml_discount' width="6%" class="t_right"}
		<input type="text" name="detail[{$index}][discount]" value="{$item.edml_discount}" row_total_disount row_tax>%
	{/td}
	{td type='flow_invoice_discount_after_money' view='dml_discount_money' total_row_dis_money='' tfoot=['total_col_dis_money'=>''] tfoot_value=$rs.detail_total.dml_discount_money  class="t_right"}
		{$item.dml_discount_money}
	{/td}
	{detail_operation}
</tr>
{/detail_table}