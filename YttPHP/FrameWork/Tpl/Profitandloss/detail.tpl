{detail_table flow='stocktake' from=$rs.detail tbody_empty=true
	thead=[$lang.product_no,$lang.product_name,'flow_color','flow_size',$lang.profitandloss_quantity,$lang.stocktake_quantity,$lang.storage_quantity,'flow_capability','flow_dozen','flow_mantissa',$lang.profitandloss_price,$lang.profitandloss_money]}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}">
	{td id="span_product" class="t_left"}
		{$item.product_no}
	{/td}
	<td id="span_product_name" width="10%" class="t_left">{$item.product_name}</td>
	{td type="flow_color" view="color_name" width="6%"}
		{$item.color_name}
	{/td}
	{td type="flow_size" view="size_name" width="6%" class="t_left"}
		{$item.size_name}
	{/td}
	{td tfoot_value="{$rs.detail_total.dml_profitandloss_quantity}"}
		{$item.profitandloss_quantity}
	{/td}
	<td width="6%" class="t_right">{$item.stocktake_quantity}</td>
	<td width="6%" class="t_right">{$item.storage_quantity}</td>
	{td type="flow_capability"  width="6%" class="t_right"}
		<input type="hidden" name="detail[{$index}][capability]" value="{$item.edml_capability}"  row_total>
		{$item.dml_capability}
	{/td}
	{td type="flow_dozen" width="6%" class="t_right"}
		<input type="hidden" name="detail[{$index}][dozen]" id="dozen" value="{$item.edml_dozen}" row_total>
		{$item.dml_dozen}
	{/td}
	{td width="6%" type="flow_mantissa" view='dd_mantissa'}
		{$item.dd_mantissa}
	{/td}
	{td width="6%" class="t_right" view="dml_price"}
		<input type="hidden" name="temp[stocktake_quantity]"  value="{$item.profitandloss_quantity}"  row_total>
		<input id="price" type="text" row_total_money=""  name="detail[{$index}][price]" autocomplete="off" value="{$item.dml_price}">
	{/td}
	{td class="t_right"  tfoot_value="{$rs.detail_total.dml_money}"  tfoot=['total_col_money'=>''] total_row_money=""}
		{$item.dml_money}
	{/td}
</tr>
{/detail_table}
