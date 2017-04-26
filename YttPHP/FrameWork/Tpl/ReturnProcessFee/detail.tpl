{detail_table flow='sale' from=$rs.detail action=['view'] op_show=['add','edit']
	thead=[$lang.weight_interval,$lang.process_fee,$lang.step_price_by_weight]}
<tr index="{$index}" class="{$none}" >
	{td}
		<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
		<input type="text" name="detail[{$index}][weight_begin]" value="{$item.edml_weight_begin}" class="spc_input" /> {$lang.to} <input type="text" name="detail[{$index}][weight_end]" value="{$item.edml_weight_end}" class="spc_input" /> {C('WEIGHT_UNIT')}
	{/td}
	{td}
		<input type="text" name="detail[{$index}][price]" id="price" value="{$item.edml_price}" class="spc_input"/>
	{/td}
	{td}
		<input type="text" name="detail[{$index}][step_price]" value="{$item.edml_step_price}" style="float: left;" class="spc_input"/><span style="float: right;" id="show_w_currency">{$currency_no}{$rs.currency_no}</span>
	{/td}
	{detail_operation}
</tr>
{/detail_table}