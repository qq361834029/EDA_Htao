<table id="copy_from" class="none">
<tr>
	{td id="span_product" class="t_center"}
		<input type="hidden" name="detail[0][product_id]" onchange="{if C('product_color')==1}$.colorEnabled(this);{/if}{if C('product_size')==1}$.sizeEnabled(this);{/if} ">
		<input type="text" name="product_name" value="{$item.product_name}" url="{'AutoComplete/product'|U}" {if C('PRODUCT_FACTORY')==1}disabled class="disabled"{else}jqac{/if}>
	{/td}
	{td id="span_product_name"}
	{$item.product_name}
	{/td}
	{td type="flow_color"}
		<input type="hidden" name="detail[0][color_id]" >
		<input type="text" name="color_name" value="{$item.product_name}" url="{'AutoComplete/color'|U}" {if C('product_color')==1}disabled class="disabled"{else}jqac{/if}>
	{/td}
	{td type="flow_size"}
		<input type="hidden" name="detail[0][size_id]">
		<input type="text" name="size_name" value="{$item.product_name}" url="{'AutoComplete/size'|U}" {if C('product_size')==1}disabled class="disabled"{else}jqac{/if}>
	{/td}
	{td type="flow_quantity"}
		<input type="text" name="detail[0][quantity]">
	{/td}
	{td type="flow_capability"}
		<input type="text" name="detail[0][capability]">
	{/td}
	{td type="flow_dozen"}
		<input type="text" name="detail[0][dozen]" >
	{/td}
	{td type="flow_row_total"}
		
	{/td}
	{td }
		<input type="text" name="detail[0][price]">
	{/td}
	{td item=$item}
		{$item.total_money}
	{/td}
	{detail_operation}
</tr>
</table>