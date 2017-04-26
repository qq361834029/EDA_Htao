{detail_table flow='DeclaredValue' from=$rs.detail action=['view','edit'] op_show=['add','edit'] 
	thead=[$lang.product_no,$lang.product_name,$lang.declared_value]}
<tr index="{$index}" class="{$none}" class="t_left">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">

	{td type="product_id" id="span_product_id" view="product_id" width="" width="56" class="t_left"}
	<input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqproc class="w100">
	<input type="text" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/product'|U}" jqac class="w100" {$readonly}>
	{/td}
	
	{td id="span_product_name" class="t_left" view="product_name" width="320" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}"}
	{$item.product_name}
	{/td}

	{td type="declared_value" view="declared_value"  width="56" class="t_right"}
	<input type="text" name="detail[{$index}][declared_value]" class="w200" id="declared_value" value="{$item.declared_value}" row_total {$readonly}>
	{/td}
	
	{detail_operation}
</tr>
{/detail_table}