{detail_table flow='DomesticWaybill' from=$list
	thead=[$lang.product_id,$lang.product_no,$lang.product_name,$lang.quantity]}
<tr index="{$index}" class="{$none}" class="t_left">
    
	{td type="product_id" id="span_product_id" view="product_id" width="" width="56" class="t_left"}
        <input type="hidden"  id="product_id" value="{$item.product_id}" jqproc class="w100">
        <input type="text" value="{$item.product_id}" class="w100 disabled"  readonly>
	{/td}
	
	{td id="span_product_no" class="t_left" view="product_no" width="160" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}"}
	{$item.product_no}
	{/td}
        
       {td id="product_name" class="t_left" view="product_name" width="160"}
	{$item.product_name}
	{/td}

	{td type="flow_quantity" view="dml_quantity"  width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot_id="total_quantity" class="t_right"}
        <input type="text" class="w100 disabled" id="quantity" value="{$item.quantity}" row_total readonly>
	{/td}
	
	{detail_operation}
</tr>
{/detail_table}