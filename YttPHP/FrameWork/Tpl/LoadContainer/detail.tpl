{detail_table flow='loadcontainer' from=$rs.detail op_show=['add','edit'] id='detail_table' barcode=false
	thead=[$lang.order_no,$lang.factory_name,$lang.product_no,$lang.product_name,'flow_config',$lang.price,'flow_per_size','flow_per_capability',$lang.total_money,'flow_mantissa',$lang.order_qn,$lang.unload_qn]}
<tr index="{$index}" class="{$none}">
<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	{td id="span_order" class="t_left" view="order_no" width="8%"}
		<input type="hidden" id="currency_id" name="detail[{$index}][currency_id]" value="{$item.currency_id}">
		<input type="hidden" name="detail[{$index}][orders_id]" id="order_id" value="{$item.orders_id}" onchange="getDataByIds(this);"  class="w100">
		<input type="text" value="{$item.order_no}" id="order_no" name="order_no"  {if $rs}  url="{'AutoComplete/orderNoByProduct'|U}" where="{"product_id={$item.product_id} and order_details.detail_state<3"|urlencode}" {else}  url="{'AutoComplete/orderNo'|U}" where="{"order_state<3"|urlencode}" {/if}jqac  class="w100">
	{/td}
	<td id="span_fac_name" class="t_left" width="8%">{$item.factory_name}</td>
	{td id="span_product" class="t_left" view="product_no" width="8%"}
		<span id="org_qn_data" class="none"></span>
		<input type="hidden" id="factory_id" value="{$item.factory_id}">
		<input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" onchange="getDataByIds(this);" class="w80">
		<input type="text" value="{$item.product_no}"  name="temp[{$index}][product_no]"{if $rs}where="{"orders_id={$item.orders_id}"|urlencode}"  {/if} url="{'AutoComplete/orderProduct'|U}" jqac class="w80">
	{/td}
	<td id="span_product_name" class="t_left">{$item.product_name}</td>
	{td type="flow_color" view="color_name" width="5%"}
		<input type="hidden" name="detail[{$index}][color_id]" id="color" value="{$item.color_id}" onchange="getDataByIds(this);">
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" jqac>
	{/td}
	{td type="flow_size" view="size_name" width="5%"}
		<input type="hidden" name="detail[{$index}][size_id]" id="size" value="{$item.size_id}" onchange="getDataByIds(this);">
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" jqac class="w40">
	{/td}
	{td type="flow_quantity" view="dml_quantity"  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot=[total_quantity=>""] width="4%" tfoot_id="total_quantity" class="t_right"}
		<input type="text" name="detail[{$index}][quantity]"  id="quantity" value="{if $item.edml_quantity|intval>0}{$item.edml_quantity|intval}{/if}"  row_total class="w40">
	{/td}
	{td type="flow_capability" view="dml_capability" width="5%" class="t_right"}
		<input type="text" name="detail[{$index}][capability]" id="capability"  value="{$item.edml_capability}" row_total class="w40">
	{/td}
	{td type="flow_dozen" view="dml_dozen" id="dozen" width="5%" class="t_right"}
		<input type="text" name="detail[{$index}][dozen]"  value="{$item.edml_dozen}" row_total class="w40">
	{/td}
	{td type="flow_row_total" view="dml_sum_quantity"  width="8%" id="row_total"  tfoot_value="{$rs.detail_total.dml_sum_quantity}" tfoot=[total_col_qn=>"",id=>"total_row_total"]  total_row_qn="" class="t_right"}
		{$item.dml_sum_quantity}
	{/td}
	{td view="dml_price" width="5%" class="t_right"}
		<input type="text" name="detail[{$index}][price]" class="w50" id="price" value="{$item.edml_price}" row_total_money>
	{/td}
	{td type='flow_per_size' view='dml_per_size' tfoot=[col_per_size=>""] width="5%" class="t_right" tfoot_value=$rs.detail_total.dml_real_per_szie}
		<input type="text" name="detail[{$index}][per_size]" value="{$item.edml_per_size}" row_per class="w50">
	{/td}
	{td type="flow_per_capability" view='dml_per_capability' tfoot=[col_per_capability=>""] width="5%" class="t_right" tfoot_value=$rs.detail_total.dml_real_per_capability}
		<input type="text" name="detail[{$index}][per_capability]" value="{$item.per_capability}" row_per class="w50">
	{/td}
	{td class="t_center" id="total_money" tfoot_value="{$rs.detail_total.dml_money}" tfoot=[total_col_money=>"",id=>"total_total_money"] total_row_money="" width="8%" class="t_right"}
		{$item.dml_money}
	{/td}
	{td type="flow_mantissa" view="dd_mantissa"  width="3%"}
		<input type="hidden" value="{$item.mantissa|default:1}" name="detail[{$index}][mantissa]">
		<input type="checkbox" type="checkbox" onclick="$.setQuantityState(this);" {if $item.mantissa==2}checked{/if} >
	{/td}
	<td id="order_qn" class="t_right" width="5%">{$item.dml_order_quantity}</td>
	<td id="unload_qn" class="t_right" width="6%" tfoot_value="{$rs.detail_total.dml_load_quantity}">{$item.dml_load_quantity}</td>
	{detail_operation}
</tr>
{/detail_table}
