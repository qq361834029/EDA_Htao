{detail_table flow='sale' from=$rs.detail action=['view'] op_show=['add','edit']
	thead=[$lang.product_no,$lang.product_name,'flow_config',$lang.price,'flow_mantissa','flow_multi_storage',$lang.total_money,'flow_sale_discount','flow_sale_after_discount']}
<tr index="{$index}" class="{$none}" style="{$mail_style}"> 
	{td id="span_product"  view="product_no" width="115"} 
		{$item.product_no}
	{/td}
	{td id="span_product_name" view="product_name" width="100" style="text-align:left!important;"}
		{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" width="66"  style="text-align:center;"}  
		{$item.color_name}
	{/td}
	{td type="flow_size" view="size_name" width="66"  style="text-align:center;"} 
		{$item.size_name}
	{/td}
	{td type="flow_quantity" view="dml_quantity" width="56"   tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot_id="total_quantity" style="text-align:right!important;"}
		{$item.edml_quantity}
	{/td}
	{td type="flow_capability" view="dml_capability" width="56" style="text-align:right;"}
		{$item.edml_capability}
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="56" style="text-align:right;"}
		{$item.edml_dozen}
	{/td}
	{td width="90" type="flow_row_total" view="dml_sum_quantity" tfoot=[total_col_qn=>""] tfoot_value="{$rs.detail_total.dml_sum_quantity}"  total_row_qn="" style="text-align:right!important;"}
		{$item.edml_sum_quantity}
	{/td}
	{td view="dml_price" width="56" style="text-align:right!important;"}
		{$item.edml_price}
	{/td}
	{td type="flow_mantissa" view="dd_mantissa" width="40" style="text-align:center;"} 
		{$item.dd_mantissa}
	{/td}
	{td type="flow_multi_storage" view='w_name' width="66" style="text-align:center;"}
		{$item.w_name}
	{/td}
	{td id="sum_money" style="text-align:right!important;" tfoot=[total_col_money=>""] total_row_money="" tfoot_value="{$rs.detail_total.dml_money}" style="text-align:right!important;"}
		{$item.edml_money}
	{/td} 
	{td width="66" view="dml_discount" type="flow_sale_discount" style="text-align:right!important;"}	
		{$item.edml_discount}
	{/td}
	{td  width="121" style="text-align:right!important;" view="dml_discount_money" type="flow_sale_after_discount" tfoot_id="total_after_discount_money" total_row_dis_money="" tfoot_value="{$rs.detail_total.dml_discount_money}" tfoot=[total_col_dis_money=>""]}
		{$item.dml_discount_money}
	{/td} 
</tr>
{/detail_table}
