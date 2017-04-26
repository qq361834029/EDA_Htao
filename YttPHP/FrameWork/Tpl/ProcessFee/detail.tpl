{if $rs.accord_type==2}
{detail_table flow='sale' from=$rs.detail action=['view'] op_show=['add','edit']
	thead=[$lang.weight_interval,$lang.process_fee]}
<tr index="{$index}" class="{$none}" >
	{td}
		<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
		<input type="text" name="detail[{$index}][weight_begin]" value="{$item.edml_weight_begin}" class="spc_input" /> {$lang.to} <input type="text" name="detail[{$index}][weight_end]" value="{$item.edml_weight_end}" class="spc_input" /> {C('WEIGHT_UNIT')}
	{/td}
	{td}
		<input type="text" name="detail[{$index}][price]" id="price" value="{$item.edml_price}" class="spc_input" style="float: left;" /><span style="float: right;" id="show_w_currency">{$rs.currency_no}</span>
	{/td}
	{detail_operation}
</tr>
{/detail_table}
{else}
{detail_table flow='sale' from=$rs.detail action=['view'] op_show=['add','edit']
	thead=[$lang.weight_interval,$lang.process_fee]}
<tr index="{$index}" class="{$none}" >
	{td}
		<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
		<input type="text" name="detail[{$index}][weight_begin]" class="spc_input" /> {$lang.to} <input type="text" name="detail[{$index}][weight_end]" class="spc_input" /> {C('WEIGHT_UNIT')}
	{/td}
	{td}
    <input type="text" name="detail[{$index}][price]" id="price" class="spc_input" style="float: left;" /><span style="float: right;" id="show_w_currency">{$rs.currency_no}</span>
	{/td}
	{detail_operation}
</tr>
{/detail_table}
{/if}