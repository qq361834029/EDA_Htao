{detail_table flow='order' from=$rs.detail action=['view','edit'] op_show=['add','edit'] barcode=false
	thead=[$lang.product_no,$lang.product_name,'flow_config',$lang.orders_price,$lang.orders_allprice,'action_load_quantity','action_load_sum_quantity','action_quantity_diff','action_state']}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	
	{td id="span_product" class="t_left" view="product_no" width="8%" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}" viewstate=['detail_state'=>[2,3,4]]}
		<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}" onchange="{if C('product_color')==1}$.colorEnabled(this);{/if}{if C('product_size')==1}$.sizeEnabled(this);{/if}" jqproc class="pro">
		<input type="text" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/product'|U}" {if C('PRODUCT_FACTORY')==1 && $rs}where="{"factory_id={$rs.factory_id}"|urlencode}" jqac class="w100 t_left" {elseif C('PRODUCT_FACTORY')==1 }disabled class="disabled w100 t_left"{elseif C('PRODUCT_FACTORY')!=1}jqac{/if} {$readonly} >
	{/td}
	
	<td id="span_product_name" width="16%" class="t_left">
	{$item.product_name}
	</td>
	{td type="flow_color" view="color_name" width="6%" viewstate=['detail_state'=>[2,3,4]]}
		<span id="org_qn_data" class="none"></span>
		<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}">
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" {if C('product_color')==1 && $rs}where="{"id in(select color_id from product_color where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_color')==1}disabled class="disabled"{elseif C('product_color')!=1}jqac{/if} class="t_left" {$readonly} >
	{/td}
	{td type="flow_size" view="size_name" width="6%" viewstate=['detail_state'=>[2,3,4]]}
		<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}">
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" {if C('product_size')==1 && $rs}where="{"id in(select size_id from product_size where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_size')==1}disabled class="disabled"{elseif C('product_size')!=1}jqac{/if}  class="t_left"  {$readonly}>
	{/td}
	{td type="flow_quantity" view="dml_quantity" width="6%" class="t_right" tfoot=[total_quantity=>""] tfoot_value="{$rs.detail_total.dml_quantity}" viewstate=['detail_state'=>[3,4]]}
		<input type="hidden" name="detail[{$index}][sumlq]" value="{if $item.detail_state<=2}{$item.edml_load_quantity}{else}{$item.edml_sum_quantity-1}{/if}">
		<input type="hidden" name="detail[{$index}][sumq]" value="{$item.edml_sum_quantity}">
		<input type="text" name="detail[{$index}][quantity]" id="quantity" value="{if $item.edml_quantity|intval>0}{$item.edml_quantity|intval}{/if}"  row_total {$readonly}>
	{/td}
	{td type="flow_capability" view="dml_capability" width="6%" class="t_right" tfoot_id="total_capability" viewstate=['detail_state'=>[3,4]]}
		<input type="text" name="detail[{$index}][capability]" id="capability" class="t_right" value="{$item.edml_capability}"  row_total {$readonly}>
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="6%" class="t_right" tfoot_id="total_dozen" viewstate=['detail_state'=>[3,4]]}
		<input type="text" name="detail[{$index}][dozen]" id="dozen" value="{$item.edml_dozen}" row_total {$readonly}>
	{/td}
	{td  type="flow_row_total" class="t_right" view="dml_sum_quantity" width="10%" tfoot=['total_col_qn'=>''] tfoot_value="{$rs.detail_total.dml_sum_quantity}" total_row_qn=""}
		{$item.dml_sum_quantity}
	{/td}
	{td view="edml_price" width="6%" class="t_right" viewstate=['detail_state'=>[3,4]]}
		<input type="text" name="detail[{$index}][price]" id="price" value="{$item.edml_price}" row_total_money {$readonly} />
	{/td}
	{td tfoot_id="total_total_money" class="t_right" tfoot_value="{$rs.detail_total.dml_money}"  tfoot=['total_col_money'=>''] total_row_money=""}
		{$item.dml_money}
	{/td}
	{td action=['view','edit'] width="5%" class="t_right" type="flow_load_quantity"}
		{$item.dml_load_capability}
	{/td}
	{td action=['view','edit'] id="diff_quantity"  width="5%" class="t_right" tfoot_value="{$rs.detail_total.dml_load_quantity}"}
		{$item.dml_load_quantity}
	{/td}
	{td action=['view','edit'] width="5%" class="t_right" tfoot_value="{$rs.detail_total.dml_diff_quantity}"}
		{$item.dml_diff_quantity}
	{/td}
	{td action=['view','edit'] width="5%"}
		{$item.dd_detail_state}
	{/td}
	{detail_operation viewstate=['detail_state'=>[3,4]] del=['detail_state'=>[1]] }
</tr>
{/detail_table}
