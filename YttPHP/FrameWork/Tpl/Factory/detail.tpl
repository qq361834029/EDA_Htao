{detail_table flow='sale' from=$rs.detail action=['view'] op_show=['add','edit']
	thead=[$lang.warehouse_name,$lang.express_discount,$lang.process_discount]}
<tr index="{$index}" class="{$none}" >
	{td view='w_name'}
		<input type="hidden" name="detail[{$index}][id]" id="express_discount_id" value="{$item.id}" jqproc class="w320">
		<input type="hidden" name="detail[{$index}][warehouse_id]" id="warehouse_id" value="{$item.warehouse_id}" jqproc class="w320">
		<input type="text" name="detail[{$index}][w_name]" value="{$item.w_name}" url="{'AutoComplete/warehouse'|U}" jqac class="w320">
	{/td}
	{td view='express_discount'}
		<input type="text" name="detail[{$index}][express_discount]" class="w50" id="express_discount" value="{$item.edml_express_discount}">
	{/td}
	{td view='process_discount'}
		<input type="text" name="detail[{$index}][process_discount]" class="w50" id="process_discount" value="{$item.edml_process_discount}">
	{/td}
	{detail_operation}
</tr>
{/detail_table}