{detail_table flow='sale' from=$rs.detail action=['view','edit'] op_show=['add','edit'] 
	thead=[$lang.product_no,$lang.custom_barcode,$lang.product_name,'flow_color','flow_size','flow_quantity','flow_capability','flow_dozen','flow_mantissa','flow_row_total','flow_return_sale_warehouse',$lang.price,$lang.money,'flow_sale_discount','flow_sale_after_discount']}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="sale[{$index}][id]" value="{$item.id}">

	{td id="span_product" class="t_left" view="product_no" width="110px"}
		<input type="hidden" name="sale[{$index}][product_id]" value="{$item.product_id}" onchange="{if C('product_color')==1}$.colorEnabled(this);{/if}{if C('product_size')==1}$.sizeEnabled(this);{/if} " jqproc return_sale=1 class="w80">
		<input type="text" name="temp2[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/productSale'|U}"  jqac class="w80">
	{/td}
	<td id="span_custom_barcode" class="t_left"  width="110">
	{$item.custom_barcode}
	</td>
	<td id="span_product_name" class="t_left"  width="110">
	{$item.product_name}
	</td>
	{td type="flow_color" view="color_name" width="46"}
		<input type="hidden" name="sale[{$index}][color_id]" value="{$item.color_id}">
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" {if C('product_color')==1 && $rs}where="{"id in(select color_id from product_color where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_color')==1}disabled class="disabled w50"{elseif C('PRODUCT_FACTORY')!=10}jqac{/if}>
	{/td}
	{td type="flow_size" view="size_no" width="46"}
		<input type="hidden" name="sale[{$index}][size_id]" value="{$item.size_id}">
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" class="w40"{if C('product_size')==1 && $rs}where="{"id in(select size_id from product_size where product_id={$item.product_id})"|urlencode}" class="w40" jqac {elseif C('product_size')==1}disabled class="disabled"{elseif C('PRODUCT_FACTORY')!=1}jqac{/if}>
	{/td}
	{td type="flow_quantity" view="edml_quantity"  tfoot=[total_quantity=>""] width="46" class="t_right"}
		<input type="text" name="sale[{$index}][quantity]" class="w40"  value="{$item.edml_quantity}" row_total>
	{/td}
	{td type="flow_capability" view="edml_capability" width="55" class="t_right"}
		<input type="text" name="sale[{$index}][capability]" class="w40"  value="{$item.edml_capability}" row_total>
	{/td}
	{td type="flow_dozen" view="edml_dozen" width="40"}
		<input type="text" name="sale[{$index}][dozen]"  class="w40"  value="{$item.edml_dozen}" row_total>
	{/td}
	{td type="flow_mantissa" view="mantissa" width="40"}
		<input type="hidden" value="{$item.mantissa|default:1}" id="mantissa" name="sale[{$index}][mantissa]" >
		<input type="checkbox" name="quantity_state" {if $item.mantissa==2}checked{/if} onclick="$.setQuantityState(this);$.getLastQuantity(this,'sale_return');" >
	{/td}
	{td  type="flow_row_total" width="180" class="t_right" view="edml_sum_quantity"  tfoot=['total_col_qn'=>''] total_row_qn="" }
		{$item.edml_sum_quantity}
	{/td}
	{td type="flow_return_sale_warehouse" view="w_name" width="120" w_id="sale[{$index}][warehouse_id]"}
		{warehouse   hidden=["name"=>"sale[$index][warehouse_id]",'value'=>$item.warehouse_id] value=$item.w_name  name="warehouse_name"  }
	{/td}
	{td view="edml_price" width="60" class="t_right"}
		<input type="text" name="sale[{$index}][price]" class="w40" value="{$item.edml_price}" row_total_money>
	{/td}
	{td  tfoot=['total_col_money'=>''] total_row_money="" width="90" class="t_right"}
		{$item.edml_money}
	{/td}
	{td type='flow_sale_discount' width="50" class="t_right"}
		<input type="text" name="sale[{$index}][discount]" value="{$item.discount}" class="w40" row_total_disount>%
	{/td}
	{td type='flow_sale_after_discount' total_row_dis_money="" tfoot=[total_col_dis_money=>""] class="t_right"}
	{$item.account_money}
	{/td}
	
	{detail_operation}
</tr>
{/detail_table}
