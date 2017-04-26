{detail_table flow='preDelivery' from=$rs.detail action=['view'] op_show=['add','edit'] warehouse=true
	thead=[$lang.product_no,$lang.product_name,'flow_config','flow_mantissa','flow_multi_storage']}
<tr index="{$index}" class="{$none}">
<input type="hidden" name="detail[{$index}][id]" value="{$item.id}"> 
<input type="hidden" name="detail[{$index}][discount]" value="{$item.discount}">  
<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}"">
<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}">
<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}">
<input type="hidden" name="detail[{$index}][capability]" value="{$item.edml_capability}" row_total>
<input type="hidden" name="detail[{$index}][dozen]"  value="{$item.edml_dozen}" row_total>
<input type="hidden" name="detail[{$index}][price]" value="{$item.price}" row_total_money>
<input type="hidden" name="detail[{$index}][discount]" value="{$item.discount}" row_total_money>
<input type="hidden" name="detail[{$index}][sale_order_detail_id]" value="{$item.sale_order_detail_id}">
	{td id="span_product" class="t_left" view="product_no" width="180" viewaction=['add','edit','view']}
		<input type="text" value="{$item.product_no}" url="{'AutoComplete/Product'|U}" jqac class="t_left">
	{/td}
	{td id="span_product_name" view="product_name" width="180" class="t_left"}
		{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" width="90" viewaction=['add','edit','view'] }
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" jqac>
	{/td}
	{td type="flow_size" view="size_name" width="90" viewaction=['add','edit','view']}
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" jqac>
	{/td}
	{td type="flow_quantity" view="dml_quantity" tfoot=[total_quantity=>""]  width="75" class="t_right"}
		<input type="text" name="detail[{$index}][quantity]" value="{$item.edml_quantity}" row_total>
	{/td}
	{td type="flow_capability" view="dml_capability" width="90" class="t_right"}
		{$item.dml_capability}
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="90" viewaction=['add','edit','view'] class="t_right"}
		<input type="text" name="detail[{$index}][dozen]"  value="{$item.edml_dozen}" row_total>
	{/td}
	{td  type="flow_row_total" view="dml_sum_quantity" tfoot=['total_col_qn'=>''] total_row_qn="" class="t_right"}
		{$item.edml_sum_quantity}
	{/td}  
	{td type="flow_mantissa" view="dd_mantissa" width="85"}
		<input type="hidden" value="{$item.mantissa|default:1}" name="detail[{$index}][mantissa]">
		<input type="checkbox" type="checkbox" onclick="$.setQuantityState(this);" {if $item.mantissa==2}checked{/if}>
	{/td}
	{td type="flow_multi_storage" view='w_name'  width="125" class="t_left"}
		{warehouse   hidden=["name"=>"detail[$index][warehouse_id]",'value'=>$item.warehouse_id] value=$item.w_name  name="warehouse_name"  }
	{/td}
	{* td id="sum_money" class="t_center"   tfoot=['total_col_money'=>''] total_row_money=""}
		{$item.edml_money}
	{/td *}   
	{detail_operation show=['add','edit']
		span=[
			['class'=>'icon icon-add-plus','onclick'=>'$.copyRowWithoutClear(this)','title'=>$lang.copy],
			['class'=>'icon icon-del-plus','onclick'=>'$.delRow(this,0);','title'=>$lang.delete,'tfoot'=>false]

		]
	} 
	
</tr>
{/detail_table}
