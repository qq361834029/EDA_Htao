{detail_table flow='stocktake' from=$rs.detail action=['view','edit'] op_show=['add','edit'] 
	thead=[$lang.product_no,$lang.product_name,'flow_config','flow_mantissa']}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	{td id="span_product" class="t_left" view="product_no" width="150" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}" viewstate=['detail_state'=>[3,4]]}
		<input type="hidden" class="w120" name="detail[{$index}][product_id]" value="{$item.product_id}" onchange="{if C('product_color')==1}$.colorEnabled(this);{/if}{if C('product_size')==1}$.sizeEnabled(this);{/if}" jqproc>
		<input type="text" class="w120" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/product'|U}" jqac>
	{/td}
	<td id="span_product_name" class="t_left" width="180">
	{$item.product_name}
	</td>
	{td type="flow_color" view="color_name" width="80" viewstate=['detail_state'=>[3,4]]}
		<span id="org_qn_data" style="display:none;"></span>
		<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}">
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" {if C('product_color')==1 && $rs}where="{"id in(select color_id from product_color where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_color')==1}disabled class="disabled"{elseif C('product_color')!=1}jqac{/if}>
	{/td}
	{td type="flow_size" view="size_name" width="80" viewstate=['detail_state'=>[3,4]]}
		<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}">
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" {if C('product_size')==1 && $rs}where="{"id in(select size_id from product_size where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_size')==1}disabled class="disabled"{elseif C('product_size')!=1}jqac{/if}>
	{/td}
	{td type="flow_quantity" view="edml_quantity" width="70" class="t_right" tfoot=[total_quantity=>""] tfoot_value="{$rs.detail_total.dml_quantity}" viewstate=['detail_state'=>[3,4]]}
		<input type="text" name="detail[{$index}][quantity]" id="quantity" value="{$item.edml_quantity}"  row_total>
	{/td}
	{td type="flow_capability" class="t_right" view="edml_capability" width="70" tfoot_id="total_capability" viewstate=['detail_state'=>[3,4]]}
		<input type="text" name="detail[{$index}][capability]" id="capability" value="{$item.edml_capability}"  row_total>
	{/td}
	{td type="flow_dozen" class="t_right" view="edml_dozen" width="70" tfoot_id="total_dozen" viewstate=['detail_state'=>[3,4]]}
		<input type="text" name="detail[{$index}][dozen]" id="dozen" value="{$item.edml_dozen}" row_total>
	{/td}
	{td  type="flow_row_total" view="edml_sum_quantity" tfoot=['total_col_qn'=>''] tfoot_value="{$rs.detail_total.dml_sum_quantity}" total_row_qn=""  class="t_right"}
		{$item.edml_sum_quantity}
	{/td}
	{td type="flow_mantissa" view="dd_mantissa"  width="60"}
		<input type="hidden" value="{$item.mantissa|default:1}" name="detail[{$index}][mantissa]">
		<input type="checkbox" type="checkbox" onclick="$.setQuantityState(this);" {if $item.mantissa==2}checked{/if} >
	{/td}
	{detail_operation viewstate=['detail_state'=>[3,4]]}
</tr>
{/detail_table}
