{assign var=thead value=[$lang.product_id,$lang.product_no,$lang.product_name,'flow_quantity']}
{detail_table flow='sale' from=$rs.detail action=$action op_show=false 
	thead=$thead}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">    
    {td id="span_product_id" class="t_left" viewstate=$deal_state span_product="{$item.product_id}" view="product_id" width="100" }
        <input type="hidden" id="product_no" value="{$item.product_id}" jqpinfo flow="sale_return">
        <input type="text" id="product_id_show" name="detail[{$index}][product_id]" url="{'AutoComplete/productId'|U}" class="w100 disabled" readonly value="{$item.product_id}">
    {/td}
	{td id="span_product" class="t_left" viewstate=$deal_state span_product="{$item.product_id}" view="product_no" width="150"}
        <input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqpinfo  flow="sale_return">
		<input type="text" name="temp[{$index}][product_no]" id="product_no_show" url="{'AutoComplete/product'|U}" class="w100 disabled" readonly value="{$item.product_no}">
	{/td}
	<td id="span_product_name" class="t_left">
		{$item.product_name}
	</td>
	{td id="total_row_qn" view="dml_quantity"  tfoot=[total_return_quantity=>""]  width="80" tfoot_value=$rs.detail_total.dml_quantity  class="t_right"}
		<input type="text" name="detail[{$index}][quantity]" class="w80 disabled" readonly value="{$item.edml_quantity}" row_return_total>
	{/td}
</tr>
{/detail_table}