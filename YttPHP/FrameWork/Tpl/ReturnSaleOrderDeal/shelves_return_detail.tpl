{if $tpl_action_name}
{assign var="op_action" value=$tpl_action_name}
{else}
{assign var="op_action" value={$smarty.const.ACTION_NAME}}
{/if}
{if $rs and $rs.is_related_sale_order != C('IS_RELATED_SALE_ORDER')}
    {assign var=op_show value=['']}
	{assign var=thead value=[$lang.product_id,$lang.product_no,$lang.product_name,$lang.return_quantity,$lang.treatment,$lang.storage_quantity,$lang.warehouse_location]}
{else}
    {assign var=op_show value=['']}
	{assign var=thead value=[$lang.product_id,$lang.product_no,$lang.product_name,'flow_quantity',$lang.return_quantity,$lang.treatment,$lang.storage_quantity,$lang.warehouse_location]}
{/if}
{detail_table flow='sale' from=$rs.detail action=$action op_show=$op_show 
	thead=$thead}
<tr index="{$index}" class="{$none}">
    <input type="hidden" name="detail[{$index}][id]" value='{$item.id}'>
    <input type="hidden" name="detail[{$index}][return_sale_order_id]" value='{$item.return_sale_order_id}'>
    <input type="hidden" name="detail[{$index}][product_id]" value='{$item.product_id}'>
    <input type="hidden" name="detail[{$index}][warehouse_id]" value='{$item.warehouse_id}'>
    <input type="hidden" name="detail[{$index}][sale_order_id]" value='{$item.sale_order_id}'>
    <td id="span_product_id" width="80" class="t_left">
		{$item.product_id}
	</td>
	{td id="span_product" class="t_left" viewstate=$deal_state span_product="{$item.product_id}" view="product_no" width="150" }
		<input type="hidden" name="temp[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqproc class="w150" flow="sale_return">
        {$item.product_no}
	{/td}
	<td id="span_product_name" width="320" class="t_left">
		{$item.product_name}
	</td>
	{if !$rs or $rs.is_related_sale_order == C('IS_RELATED_SALE_ORDER')}
	{td view="edml_sale_order_number" tfoot=[total_sale_order_number=>""]  width="80" tfoot_value=$rs.detail_total.dml_sale_order_number  class="t_right"}
		<input type="hidden" name="detail[{$index}][sale_order_number]" class="w80 disabled" readonly value="{$item.edml_sale_order_number}">
        {$item.edml_sale_order_number}
	{/td}
	{/if}
	{td class="w50 t_right"}
		{$item.edml_quantity}
	{/td}
	{td class="w50 t_right"} 
		<input type="hidden" id="return_service" name="detail[{$index}][return_service]" value='{$item.return_service}' {$readonly}>
		<input type="hidden" name="detail[{$index}][relation_id]" value="{$item.relation_id}">
		<a id="icon" class="icon icon-list-view" title="{L('treatment')}" onclick="$.quicklyShowReturnService({$index}, this,'view', '{$item.is_factory}');"></a>
	{/td}
    {td id="span_in_quantity" span_quantity="{$item.edml_in_quantity}" viewstate=$deal_state type="flow_in_quantity" view="edml_in_quantity" tfoot=['total_quantity'=>''] width="80" tfoot_value=$rs.detail_total.dml_in_quantity class="t_right"}
	    <input type="hidden" name="detail[{$index}][return_sale_order_number]" value='{$item.quantity}'>
		<input type="text" id="in_quantity" name="detail[{$index}][quantity]" class="w80" value="{$item.in_quantity}" row_total {$readonly}>
	{/td}
    {td id="span_location_no" class="t_left" view="location_no" width="240" tfoot_id="total_barcode_no" tfoot_value="{$rs.detail_total.total_produc}"}
        <input type="hidden" name="detail[{$index}][location_id]" id="location_id" value="{$item.location_id}" class="w200">
        <input type="text" name="temp[{$index}][location_no]" value="{$item.location_no}" url="{'AutoComplete/returnLocationNo'|U}" where ="warehouse_id in ({$item.warehouse_id}_warehouse_id)" jqac class="w200" {$readonly}>
	{/td}  
	{detail_operation}
</tr>
{/detail_table}