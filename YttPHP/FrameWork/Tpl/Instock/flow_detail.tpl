{detail_table flow='instock' from=$rs.detail action=['view','edit']  barcode=false
	thead=[$lang.order_no,'flow_factory_currency',$lang.product_no,$lang.product_name,'flow_config','flow_per_size','flow_per_capability','flow_mantissa','flow_instock_price_show','flow_show_instock_logistics_funds','flow_instock_total_money']}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	<input type="hidden" name="detail[{$index}][factory_id]" value="{$item.factory_id}" >
	<input type="hidden" name="detail[{$index}][order_details_id]" value="{$item.order_details_id}" >
	<input type="hidden" name="detail[{$index}][orders_id]" value="{$item.orders_id}" >
	<input type="hidden" name="detail[{$index}][delivery_fee_detail]" value="{$item.delivery_fee_detail}">
	<td class="t_left" width="10%">
	{$item.order_no}
	</td>
	{td type="flow_factory_currency" class="t_left"  width="10%"}
	<input type="hidden" name="detail[{$index}][currency_id]" value="{$item.currency_id}" >
	{$item.currency_no}
	{/td}
	{td id="span_product" class="t_center" view="product_no" width="8%" tfoot_value=$rs.detail_total.total_product class="t_left"}
		<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}" onchange="{if C('product_color')==1}$.colorEnabled(this);{/if}{if C('product_size')==1}$.sizeEnabled(this);{/if} ">	
		{$item.product_no}
	{/td}
	<td id="span_product_name" class="t_left">
	{$item.product_name}
	</td>
	{td type="flow_color" view="color_name" width="6%"}
		<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}">
		{$item.color_name}
	{/td}
	{td type="flow_size" view="size_name" width="6%"}
		<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}">
		{$item.size_name}
	{/td}
	{td type="flow_quantity" view="dml_quantity" width="6%" tfoot=[total_quantity=>""] tfoot_value=$rs.detail_total.quantity viewstate=['fund_state'=>[1]] class="t_right"}
		<input type="text" name="detail[{$index}][quantity]" value="{$item.edml_quantity|intval}" row_total {$readonly}>
	{/td}
	{td type="flow_capability" view="dml_capability" width="6%" class="t_right" viewstate=['fund_state'=>[1]]}
		<input type="text" name="detail[{$index}][capability]" value="{$item.edml_capability}" row_total {$readonly}>
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="6%" class="t_right" viewstate=['fund_state'=>[1]]}
		<input type="text" name="detail[{$index}][dozen]"  value="{$item.edml_dozen}" row_total {$readonly}>
	{/td}
	{td  type="flow_row_total" view="dml_sum_quantity" tfoot_value=$rs.detail_total.sum_quantity total_row_qn="" tfoot=[total_col_qn=>""]  width="10%" class="t_right"}
		{$item.edml_sum_quantity}
	{/td}
	{td type="flow_per_size" view="dml_per_size"  tfoot=[col_per_size=>""] tfoot_value=$rs.detail_total.dml_real_per_size viewstate=['fund_state'=>[1]] width="7%" class="t_right"}
		{if $rs.funds.logistics}
			<input type="text" name="detail[{$index}][per_size]" value="{$item.edml_per_size}" row_per readonly class="disabled">
		{else}
			<input type="text" name="detail[{$index}][per_size]" value="{$item.edml_per_size}" row_per {$readonly}>
		{/if}
	{/td}
	{td type="flow_per_capability" view="dml_per_capability" tfoot=[col_per_capability=>""] tfoot_value=$rs.detail_total.dml_real_per_capability viewstate=['fund_state'=>[1]] width="7%" class="t_right"}
		<input type="text" name="detail[{$index}][per_capability]" value="{$item.edml_per_capability}" row_per {$readonly}>
	{/td}
	{td type="flow_mantissa" view="dd_mantissa" width="4%"}
		<input type="hidden" name="detail[{$index}][mantissa]" value="{$item.mantissa|default:1}"/>
		<input id="quantity_state" type="checkbox"  {if $item.mantissa==2}checked{/if} onclick="$.setQuantityState(this);" {if $item.fund_state==1}disabled{/if}>	
	{/td}
	{td view="dml_price" width="6%" type='flow_instock_price_show' class="t_right" viewstate=['fund_state'=>[1]]}
		<input type="text" name="detail[{$index}][price]" value="{$item.edml_price}" row_total_money {$readonly}>
	{/td}
	{td view='dml_delivery_fee_detail'  type="flow_show_instock_logistics_funds" width="6%" class="t_right"}
	 	{$item.dml_delivery_fee_detail}
	{/td}
	{td id="total_money" type="flow_instock_total_money" tfoot_value=$rs.detail_total.dml_money   total_row_money="" tfoot=[total_col_money=>""] width="12%" class="t_right"}
		{$item.dml_money}
	{/td}
</tr>
{/detail_table}