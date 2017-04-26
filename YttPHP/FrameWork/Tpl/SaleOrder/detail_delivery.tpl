{detail_table flow='sale' from=$rs.delivery.list action=['view'] op_show=['add','edit']
	thead=[$lang.product_no,$lang.product_name,'flow_config',$lang.price,'flow_mantissa','flow_multi_storage',$lang.total_money,'flow_sale_discount','flow_sale_after_discount']}
<tr index="{$index}" class="{$none}">
<input type="hidden" name="detail[{$index}][id]" value="{$item.id}"> 
	{td id="span_product" class="t_center" view="product_no" width="115" class="t_left"}
		<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}" class="w80">
		<input type="text"name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/Product'|U}" jqac class="w80">
	{/td}
	{td id="span_product_name" view="product_name" width="100" class="t_left"}
	{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" width="66"}
		<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}">
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" jqac>
	{/td}
	{td type="flow_size" view="size_name" width="66"}
		<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}">
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" jqac>
	{/td}
	{td type="flow_quantity" view="dml_quantity" width="56" class="t_right" tfoot_value="{$rs.delivery.total.dml_quantity}" }
		<input type="text" name="detail[{$index}][quantity]" value="{$item.edml_quantity}" class="w50">
	{/td}
	{td type="flow_capability" view="dml_capability" width="56" class="t_right"}
		<input type="text" name="detail[{$index}][capability]" value="{$item.edml_capability}" class="w50">
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="56" class="t_right"}
		<input type="text" name="detail[{$index}][dozen]"  value="{$item.edml_dozen}" class="w50">
	{/td}
	{td  type="flow_row_total" width="90" class="t_right" view="dml_sum_quantity" tfoot_value="{$rs.delivery.total.dml_sum_quantity}"}
		{$item.edml_sum_quantity}
	{/td}
	{td view="dml_price" width="56" class="t_right"}
		<input type="text" name="detail[{$index}][price]" value="{$item.edml_price}" class="w50">
	{/td}
	{td type="flow_mantissa" view="dd_mantissa" width="40"}
		<input type="hidden" value="{$item.mantissa|default:1}" name="detail[{$index}][mantissa]">
		<input type="checkbox" type="checkbox" onclick="$.setQuantityState(this);" {if $item.mantissa==2}checked{/if}>
	{/td}
	{td type="flow_multi_storage" view='w_name' width="66"}
		{warehouse   hidden=["name"=>"detail[$index][warehouse_id]",'value'=>$item.warehouse] value=$item.w_name  name="warehouse_name"  }
	{/td}
	{td id="sum_money" class="t_right" tfoot_value="{$rs.delivery.total.dml_money}" }
		{$item.edml_money}
	{/td} 
	{td view="dml_discount" width="46" class="t_right" type="flow_sale_discount"}	
		<input type="text" name="detail[{$index}][discount]" value="{$item.edml_discount}" class="w40">
	{/td}
	{td  view="dml_discount_money" width="121" class="t_right" type="flow_sale_after_discount" tfoot_value="{$rs.delivery.total.dml_discount_money}"}}
		{$item.dml_discount_money}
	{/td}
	{detail_operation}
</tr>
{/detail_table}
