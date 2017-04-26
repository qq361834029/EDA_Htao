{detail_table flow='instock' from=$rs.detail action=['view','edit'] op_show=['add','edit'] barcode=false
	thead=[$lang.factory_name,'flow_factory_currency',$lang.product_no,$lang.product_name,'flow_config','flow_per_size','flow_per_capability','flow_mantissa','flow_instock_price_show','flow_show_instock_logistics_funds','flow_instock_total_money']}
<tr index="{$index}" class="{$none}" style="{$mail_style}">
	{td view="factory_name" width="10%" style="text-align:left;" viewstate=['fund_state'=>[1]]}
		{$item.factory_name}&nbsp;
	{/td}
	{td type="flow_factory_currency" view="currency_no" style="text-align:left;" width="6%" viewstate=['fund_state'=>[1]]}
		{$item.currency_no}
	{/td}
	{td id="span_product" style="text-align:left;"  view="product_no" width="8%" tfoot_value=$rs.detail_total.total_product viewstate=['fund_state'=>[1]]}
		{$item.product_no}
	{/td}
	{td id="span_product_name"  width="12%" style="text-align:left;"}
		{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" style="text-align:center;" width="6%" viewstate=['fund_state'=>[1]]}
		{$item.color_name}
	{/td}
	{td type="flow_size" view="size_name" style="text-align:center;" width="6%" viewstate=['fund_state'=>[1]]}
		{$item.size_name}
	{/td}
	{td type="flow_quantity" style="text-align:right;" view="dml_quantity"  tfoot=[total_quantity=>""]  width="6%" tfoot_value=$rs.detail_total.quantity viewstate=['fund_state'=>[1]]}
		{$item.edml_quantity}
	{/td}
	{td type="flow_capability" view="dml_capability" width="5%" style="text-align:right;" viewstate=['fund_state'=>[1]]}
		{$item.edml_capability}
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="5%" style="text-align:right;" viewstate=['fund_state'=>[1]]}
		{$item.edml_dozen}
	{/td}
	{td  type="flow_row_total" view="dml_sum_quantity" width="8%" total_row_qn="" tfoot=['total_col_qn'=>''] tfoot_value=$rs.detail_total.sum_quantity style="text-align:right;"}
		{$item.dml_sum_quantity}
	{/td}
	{td type='flow_per_size' view='dml_per_size'  tfoot=[col_per_size=>""] width="5%" style="text-align:right;" tfoot_value=$rs.detail_total.dml_real_per_szie viewstate=['fund_state'=>[1]]}
	{$item.edml_per_size}
	{/td}
	{td type="flow_per_capability" view='dml_per_capability' tfoot=[col_per_capability=>""] width="6%" style="text-align:right;" tfoot_value=$rs.detail_total.dml_real_per_capability viewstate=['fund_state'=>[1]]}
		{$item.edml_per_capability}
	{/td}
	{td type="flow_mantissa" view="dd_mantissa" style="text-align:center;" width="3%" viewstate=['fund_state'=>[1]]}
		{$item.dd_mantissa}
	{/td}
	{td view="dml_price" width="6%" type='flow_instock_price_show' style="text-align:right;" viewstate=['fund_state'=>[1]]}
		{$item.edml_price}
	{/td}
	{td view='dml_delivery_fee_detail' type='flow_show_instock_logistics_funds' style="text-align:right;" width="8%"}
	 	{$item.dml_delivery_fee_detail}
	{/td}
	{td id="total_money" type="flow_instock_total_money" total_row_money="" tfoot=['total_col_money'=>''] tfoot_value=$rs.detail_total.dml_money style="text-align:right;"}
		{$item.dml_money}
	{/td}
</tr>
{/detail_table}
