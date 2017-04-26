{detail_table flow='delivery' from=$rs.detail action=['view','edit'] op_show=['add','edit'] warehouse=true
thead=[$lang.product_no,$lang.product_name,'flow_config',$lang.un_delivery_qn,'flow_delivery_price','flow_mantissa','flow_multi_storage','flow_delivery_money','flow_delivery_discount','flow_delivery_after_discount']}
<tr index="{$index}" class="{$none}">
<input type="hidden" name="detail[{$index}][id]" value="{$item.id}"> 
<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}">
<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}">
<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}">
<input type="hidden" name="detail[{$index}][sale_order_id]" value="{$item.sale_order_id}">
<input type="hidden" name="detail[{$index}][sale_order_detail_id]" value="{$item.sale_order_detail_id}">
<input type="hidden" name="detail[{$index}][pre_delivery_detail_id]" value="{$item.pre_delivery_detail_id}">
	{td id="span_product" class="t_center" view="product_no" width="90" viewaction=['add','edit','view'] class="t_left"} 
		<input type="text" value="{$item.product_no}" url="{'AutoComplete/Product'|U}" jqac>
	{/td}
	{td id="span_product_name" view="product_name"  class="t_left"  width="120"}
	{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" width="66"  viewaction=['add','edit','view']} 
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" jqac>
	{/td}
	{td type="flow_size" view="size_name" width="46"  viewaction=['add','edit','view']}
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" jqac>
	{/td} 
	{td type="flow_quantity" view="dml_quantity" width="46" class="t_right" tfoot=[total_quantity=>""] tfoot_value="{$rs.detail_total.dml_quantity}"}
		<input type="text" name="detail[{$index}][quantity]" value="{$item.edml_quantity}" row_total class="w40">
	{/td}
	{td type="flow_capability" view="dml_capability" width="66" class="t_right"}
		<input type="text" name="detail[{$index}][capability]" value="{$item.edml_capability}" row_total>
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="66" class="t_right"}
		<input type="text" name="detail[{$index}][dozen]"  value="{$item.edml_dozen}" row_total>
	{/td}
	{td  type="flow_row_total" view="dml_sum_quantity" total_row_qn="" tfoot=[total_col_qn=>""] tfoot_value="{$rs.detail_total.dml_sum_quantity}" width="80" class="t_right"} 
		{$item.edml_sum_quantity}
	{/td}
	{td view="dml_un_delivery_qn" width="66"  class="t_right"}
		{$item.dml_un_delivery_qn} 
	{/td}
	{td view="dml_price" width="66"  type='flow_delivery_price' class="t_right"}
		<input type="text" name="detail[{$index}][price]" value="{$item.edml_price}" row_total_money>
	{/td}
	{td type="flow_mantissa" view="dd_mantissa" width="40"}
		<input type="hidden" value="{$item.mantissa|default:1}" name="detail[{$index}][mantissa]">
		<input type="checkbox" type="checkbox" onclick="$.setQuantityState(this);" {if $item.mantissa==2}checked{/if}>
	{/td}
	{td type="flow_multi_storage"  view='w_name' width="66" }
		{warehouse   hidden=["name"=>"detail[$index][warehouse_id]",'value'=>$item.warehouse_id] value=$item.w_name  name="warehouse_name"  }
	{/td}
	{td id="sum_money" class="t_center" type='flow_delivery_money' tfoot=[total_col_money=>""] total_row_money="" tfoot_value="{$rs.detail_total.dml_money}" class="t_right" width="100"}
		{$item.edml_money}
	{/td} 
	{td view="dml_discount" width="46"  type="flow_delivery_discount" class="t_right"}	
		<input type="text" name="detail[{$index}][discount]" value="{$item.edml_discount}" row_total_disount class="w40">
	{/td}
	{td  view="dml_discount_money"  type="flow_delivery_after_discount" tfoot=[total_col_dis_money=>""] total_row_dis_money="" tfoot_value="{$rs.detail_total.dml_discount_money}" class="t_right"}
		{$item.dml_discount_money}
	{/td} 
	{detail_operation show=['add','edit']
		span=[
			['class'=>'icon icon-add-plus','onclick'=>'$.copyRowWithoutClear(this)','title'=>$lang.copy],
			['class'=>'icon icon-del-plus','onclick'=>'$.delRow(this,0);','title'=>$lang.delete,'tfoot'=>false]

		]
	} 
</tr>
{/detail_table}
