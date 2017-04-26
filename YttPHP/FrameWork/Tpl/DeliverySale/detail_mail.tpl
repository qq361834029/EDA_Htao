{detail_table flow='delivery' from=$rs.detail action=['view','edit'] op_show=['add','edit'] warehouse=true
	thead=[$lang.product_no,$lang.product_name,'flow_config',$lang.un_delivery_qn,'flow_delivery_price','flow_mantissa','flow_multi_storage','flow_delivery_money','flow_delivery_discount','flow_delivery_after_discount']}
<tr index="{$index}" class="{$none}">
	{td id="span_product" class="t_center" view="product_no" width="90" class="t_left" viewaction=['add','edit','view'] } 
		{$item.product_no}
	{/td}
	{td id="span_product_name" view="product_name" class="t_left"}
	{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" width="66"  viewaction=['add','edit','view']} 
		{$item.color_name}
	{/td}
	{td type="flow_size" view="size_name" width="46"  viewaction=['add','edit','view']}
		{$item.size_name}
	{/td} 
	{td type="flow_quantity" view="dml_quantity" width="46"   tfoot=[total_quantity=>""] tfoot_value="{$rs.detail_total.dml_quantity}"}
		{$item.edml_quantity}
	{/td}
	{td type="flow_capability" view="dml_capability" width="66"}
		{$item.edml_capability}
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="66"  }
		{$item.edml_dozen}
	{/td}
	{td  type="flow_row_total" view="dml_sum_quantity" total_row_qn="" tfoot=[total_col_qn=>""] tfoot_value="{$rs.detail_total.dml_sum_quantity}" width="80"  class="t_right"}
		{$item.edml_sum_quantity}
	{/td}
	{td view="un_delivery_qn" width="66"  class="t_right"}
		{$item.un_delivery_qn} 
	{/td}
	{td view="dml_price" width="66"  type='flow_delivery_price' class="t_right"}
		{$item.edml_price}
	{/td}
	{td type="flow_mantissa" view="dd_mantissa" width="40"}
		{$item.dd_mantissa}
	{/td}
	{td type="flow_multi_storage"  view='w_name' width="66" }
		{$item.w_name}
	{/td}
	{td id="sum_money" class="t_center" type='flow_delivery_money' width="100" tfoot=[total_col_money=>""] total_row_money="" tfoot_value="{$rs.detail_total.dml_money}" class="t_right"}
		{$item.edml_money}
	{/td} 
	{td view="dml_discount" width="6%" type="flow_delivery_discount" width="46"  class="t_right"}	
		{$item.edml_discount}
	{/td}
	{td  view="dml_discount_money" type="flow_delivery_after_discount"  tfoot=[total_col_dis_money=>""] total_row_dis_money="" tfoot_value="{$rs.detail_total.dml_discount_money}" width="121" class="t_right"}
		{$item.dml_discount_money}
	{/td} 
	 
</tr>
{/detail_table}
