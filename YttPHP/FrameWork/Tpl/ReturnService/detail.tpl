{detail_table flow='return_service' from=$rs.detail action=['view','edit'] op_show=['add','edit']
	thead=[$lang.item_number,$lang.item_name,$lang.price_explanation,$lang.comment,$lang.is_return_service]}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	{td view="item_number" class="w120"}
		<input type="text" name="detail[{$index}][item_number]" value="{$item.item_number}" {$readonly} class="w120">
	{/td}	
	{td view="item_name" class="w120"}
		<input type="text" name="detail[{$index}][item_name]" value="{$item.item_name}" {$readonly} class="w120">
	{/td}
	{td view="price_explanation" class="w120"}
		<input type="text" name="detail[{$index}][price_explanation]" value="{$item.price_explanation}" {$readonly} class="w120">
	{/td}	
	{td view="comments" class="w120"}
		<input type="text" name="detail[{$index}][comments]" value="{$item.comments}" {$readonly} class="w120">
	{/td}	
	{td view="dd_is_return_service" width="16%"}
		{radio data=C('IS_ENABLE') name="detail[{$index}][is_return_service]" value="{$item.is_return_service}" initvalue=1}
	{/td}
	{detail_operation}
</tr>
{/detail_table}