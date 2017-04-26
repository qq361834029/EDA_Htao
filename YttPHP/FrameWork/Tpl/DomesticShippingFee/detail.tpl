{detail_table flow='air_transport' id='air_transport' from=$rs.detail action=['view'] op_show=['add','edit']
	thead=[$lang.weight_interval,$lang.delivery_fee]}
<tr index="{$index}" class="{$none}" >
	{td}
		<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
		<input type="text" name="detail[{$index}][weight_begin]" value="{$item.edml_weight_begin}" class="spc_input" /> {$lang.to} <input type="text" name="detail[{$index}][weight_end]" value="{$item.edml_weight_end}" class="spc_input" /> {C('WEIGHT_UNIT')}
	{/td}
	{td}
		<input type="text" name="detail[{$index}][price]" id="price" value="{$item.edml_price}" style="float: left;" class="spc_input"/><span style="float: right;" id="show_w_currency">{$currency_no}{$rs.currency_no}</span>
	{/td}
	{detail_operation}
</tr>
{/detail_table}
{detail_table flow='sea_transport' id='sea_transport' from=$rs.detail item='value' action=['view'] op_show=['add','edit']
	thead=[$lang.volume_interval,$lang.delivery_fee]}
<tr index="{$index}" class="{$none}" >
	{td}
		<input type="hidden" name="detail[{$index}][id]" value="{$value.id}">
		<input type="text" name="detail[{$index}][weight_begin]" value="{$value.edml_weight_begin}" class="spc_input" /> {$lang.to} <input type="text" name="detail[{$index}][weight_end]" value="{$value.edml_weight_end}" class="spc_input" /> {C('VOLUME_SIZE_UNIT')}
	{/td}
	{td}
		<input type="text" name="detail[{$index}][price]" id="price" value="{$value.edml_price}" style="float: left;" class="spc_input"/><span style="float: right;" id="show_w_currency">{$currency_no}{$rs.currency_no}</span>
	{/td}
	{detail_operation}
</tr>
{/detail_table}
<script>
$(document).ready(function(){
	changeTransportType({$rs.transport_type});
});
</script>
