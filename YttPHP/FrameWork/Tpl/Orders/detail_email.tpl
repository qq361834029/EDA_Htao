{detail_table flow='order' from=$rs.detail action=['view','edit'] op_show=['add','edit'] barcode=false
	thead=[$lang.product_no,$lang.product_name,'flow_config',$lang.orders_price,$lang.orders_allprice,'action_load_quantity','action_load_sum_quantity','action_quantity_diff','action_state']}
<tr index="{$index}" class="{$none}" style="{$mail_style}">
	{td id="span_product" style="text-align:left;" view="product_no" width="8%" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}" viewstate=['detail_state'=>[2,3,4]]}
		{$item.product_no}
	{/td}
	
	{td id="span_product_name" width="16%" style="text-align:left;"}
	{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" width="6%" style="text-align:center;" viewstate=['detail_state'=>[2,3,4]]}
		{$item.color_name}
	{/td}
	{td type="flow_size" view="size_name" width="6%" style="text-align:center;" viewstate=['detail_state'=>[2,3,4]]}
		{$item.size_name}
	{/td}
	{td type="flow_quantity" view="dml_quantity" width="6%" style="text-align:right;" tfoot=[total_quantity=>""] tfoot_value="{$rs.detail_total.dml_quantity}" viewstate=['detail_state'=>[3,4]]}
		{$item.edml_quantity}
	{/td}
	{td type="flow_capability" view="dml_capability" width="6%" style="text-align:right;" tfoot_id="total_capability" viewstate=['detail_state'=>[3,4]]}
		{$item.edml_capability}
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="6%" style="text-align:right;" tfoot_id="total_dozen" viewstate=['detail_state'=>[3,4]]}
		{$item.edml_dozen}
	{/td}
	{td  type="flow_row_total" style="text-align:right;" view="dml_sum_quantity" width="10%" tfoot=['total_col_qn'=>''] tfoot_value="{$rs.detail_total.dml_sum_quantity}" total_row_qn=""}
		{$item.dml_sum_quantity}
	{/td}
	{td view="edml_price" width="6%" style="text-align:right;" viewstate=['detail_state'=>[3,4]]}
		{$item.edml_price}
	{/td}
	{td tfoot_id="total_total_money" style="text-align:right;" tfoot_value="{$rs.detail_total.dml_money}"  tfoot=['total_col_money'=>''] total_row_money=""}
		{$item.dml_money}
	{/td}
	{td action=['view','edit'] width="5%" style="text-align:right;" type="flow_load_quantity"}
		{$item.dml_load_capability|default:0}
	{/td}
	{td action=['view','edit'] width="5%" style="text-align:right;" tfoot_value="{$rs.detail_total.dml_load_quantity}"}
		{$item.dml_load_quantity|default:0}
	{/td}
	{td action=['view','edit'] width="5%" style="text-align:right;" tfoot_value="{$rs.detail_total.dml_diff_quantity}"}
		{$item.dml_diff_quantity}
	{/td} 
	{td action=['view','edit'] width="5%"}
		{$item.dd_detail_state}
	{/td}
</tr>
{/detail_table}
