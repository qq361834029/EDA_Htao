{detail_table flow='transfer' from=$rs.detail view_action=['edit'] action=['view','edit'] op_show=['add','edit'] 
	thead=[$lang.product_no,$lang.product_name,$lang.in_warehouse,$lang.out_warehouse,'flow_config','flow_mantissa']}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	{td id="span_product" class="t_left" view="product_no" width="150" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}" viewstate=['detail_state'=>[1]]}
		<input type="hidden" class="w120" name="detail[{$index}][product_id]" value="{$item.product_id}" onchange="{if C('product_color')==1}$.colorEnabled(this);{/if}{if C('product_size')==1}$.sizeEnabled(this);{/if}" jqproc>
		<input type="text" class="w120" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/product'|U}" jqac class="t_left" {$readonly}>
	{/td}
	<td id="span_product_name"  width="150" class="t_left">
	{$item.product_name} 
	</td>
	{td view="dd_in_w_name" viewstate=['detail_state'=>[1]] width="114" class="t_left"}
	{warehouse hidden=["name"=>"detail[$index][in_warehouse_id]",'value'=>$item.in_warehouse_id] value=$item.dd_in_w_name empty="true" name="warehouse_name" eval=$readonly}
	{/td}
	{td view="w_name" viewstate=['detail_state'=>[1]] width="114" class="t_left"}
	{warehouse hidden=["name"=>"detail[$index][warehouse_id]",'value'=>$item.warehouse_id] value=$item.w_name  empty="true" name="warehouse_name" eval=$readonly}
	{/td}
	{td type="flow_color" view="color_name" viewstate=['detail_state'=>[1]] width="80"}
		<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}">
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" {if C('product_color')==1 && $rs}where="{"id in(select color_id from product_color where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_color')==1}disabled class="disabled"{elseif C('PRODUCT_FACTORY')!=10}jqac{/if} class="t_left" {$readonly}>
	{/td}
	{td type="flow_size" view="size_name" viewstate=['detail_state'=>[1]] width="80"}
		<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}">
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" {if C('product_size')==1 && $rs}where="{"id in(select size_id from product_size where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_size')==1}disabled class="disabled"{elseif C('PRODUCT_FACTORY')!=1}jqac{/if} class="t_left" {$readonly}>
	{/td}
	{td type="flow_quantity" view="edml_quantity"  viewstate=['detail_state'=>[1]] tfoot=[total_quantity=>""] tfoot_value="{$rs.detail_total.dml_quantity}"  width="70" class="t_right"}
		<input type="text" name="detail[{$index}][quantity]" id="quantity" value="{$item.edml_quantity}"  {$readonly} row_total>
	{/td}
	{td type="flow_capability" view="edml_capability"  viewstate=['detail_state'=>[1]] tfoot_id="total_capability" class="t_right" width="70" class="t_right"}
		<input type="text" name="detail[{$index}][capability]" id="capability" value="{$item.edml_capability}"  {$readonly} row_total>
	{/td}
	{td type="flow_dozen" view="edml_dozen"  viewstate=['detail_state'=>[1]] tfoot_id="total_dozen" width="100"}
		<input type="text" name="detail[{$index}][dozen]" id="dozen" value="{$item.edml_dozen}" {$readonly} row_total>
	{/td}
	{td  type="flow_row_total" view="dml_sum_quantity" tfoot=['total_col_qn'=>''] tfoot_value="{$rs.detail_total.dml_sum_quantity}" total_row_qn="" class="t_right"}
		{$item.dml_sum_quantity}
	{/td}
	{td type="flow_mantissa" view="dd_mantissa" viewstate=['detail_state'=>[1]]  width="50"}
		<input type="hidden" value="{$item.mantissa|default:1}" name="detail[{$index}][mantissa]">
		{if $item.detail_state==1}
		{$item.dd_mantissa}
		{else}
		<input type="checkbox" type="checkbox" onclick="$.setQuantityState(this);" {if $item.mantissa==2}checked{/if}  {$readonly}>
		{/if}
	{/td}
	{detail_operation}
</tr>
{/detail_table}
