{detail_table flow='loadcontainer' from=$rs.detail op_show=['add','edit'] id='detail_table' barcode=false
	thead=[$lang.order_no,$lang.factory_name,$lang.product_no,$lang.product_name,'flow_config',$lang.price,'flow_per_size','flow_per_capability',$lang.total_money,'flow_mantissa',$lang.order_qn,$lang.unload_qn]}
<tr index="{$index}" class="{$none}" style="{$mail_style}">
	{td id="span_order" style="text-align:left;" view="order_no" width="8%"}
		{$item.order_no}
	{/td}
	{td id="span_fac_name" style="text-align:left;" width="8%"} {$item.factory_name}{/td}
	{td id="span_product" class="t_left" view="product_no" width="8%"}
		{$item.product_no}
	{/td}
	{td id="span_product_name" style="text-align:left;"} {$item.product_name} {/td}
	{td type="flow_color" style="text-align:center;" view="color_name" width="5%"}
		{$item.color_name}
	{/td}
	{td type="flow_size" style="text-align:center;" view="size_name" width="5%"}
		{$item.size_name}
	{/td}
	{td type="flow_quantity" view="dml_quantity"  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot=[total_quantity=>""] width="4%" tfoot_id="total_quantity" style="text-align:right;"}
		{$item.edml_quantity}
	{/td}
	{td type="flow_capability" view="dml_capability" width="5%" style="text-align:right;"}
		{$item.edml_capability}
	{/td}
	{td type="flow_dozen" view="dml_dozen" id="dozen" width="5%" style="text-align:right;"}
		{$item.edml_dozen}
	{/td}
	{td type="flow_row_total" view="dml_sum_quantity"  width="8%" id="row_total"  tfoot_value="{$rs.detail_total.dml_sum_quantity}" tfoot=[total_col_qn=>"",id=>"total_row_total"]  total_row_qn="" style="text-align:right;"}
		{$item.dml_sum_quantity}
	{/td}
	{td view="dml_price" width="5%" style="text-align:right;"}
		{$item.edml_price}
	{/td}
	{td type='flow_per_size' view='dml_per_size' tfoot=[col_per_size=>""] width="5%" style="text-align:right;" tfoot_value=$rs.detail_total.dml_real_per_szie}
		{$item.edml_per_size}
	{/td}
	{td type="flow_per_capability" view='dml_per_capability' tfoot=[col_per_capability=>""] width="5%" style="text-align:right;" tfoot_value=$rs.detail_total.dml_real_per_capability}
		{$item.per_capability}
	{/td}
	{td class="t_center" id="total_money" tfoot_value="{$rs.detail_total.dml_money}" tfoot=[total_col_money=>"",id=>"total_total_money"] total_row_money="" width="8%" style="text-align:right;"}
		{$item.dml_money}
	{/td}
	{td type="flow_mantissa" view="dd_mantissa"  width="3%" style="text-align:center;"}
		{$item.dd_mantissa}
	{/td}
	{td id="order_qn" style="text-align:right;" width="5%"} {$item.dml_order_quantity}{/td}
	{td id="unload_qn" style="text-align:right;" width="5%" tfoot_value="{$rs.detail_total.dml_load_quantity}"}   {$item.dml_load_quantity}{/td}
</tr>
{/detail_table}
