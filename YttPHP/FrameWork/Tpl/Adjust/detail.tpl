{detail_table flow='adjust' from=$rs.detail action=['view','edit'] op_show=['add','edit']
	warehouse=true
	thead=[$lang.product_id,$lang.product_no,$lang.custom_barcode,$lang.location_no,$lang.quantity]}
<tr index="{$index}" class="{$none}" class="t_left">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	<input type="hidden" name="detail[{$index}][warehouse_id]" value="{$item.warehouse_id}" id="warehouse_id">

	{td type="product_id" id="span_product_id" view="product_id" width="" width="56" class="t_left"}
	<input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqpad class="w100">
	<input type="text" id="product_id_show" name="temp[{$index}][product_id]" value="{$item.product_id}" url="{'AutoComplete/productId'|U}" jqac class="w100" {$readonly}>
	{/td}

	{td id="span_product_no" class="t_left" view="product_no" width="320" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}"}
	<input type="hidden" name="detail[{$index}][product_id]" id="product_id_from_no" value="{$item.product_id}" jqpad class="w100">
	<input type="text"  id="product_no_show" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/productNo'|U}" jqac class="w100" {$readonly}>
	{/td}
	
	{td id="span_custom_barcode" view="custom_barcode" class="t_left span_custom_barcode"}
		{$item.custom_barcode}
	{/td}

	{td id="span_location_no" class="t_left" view="barcode_no" width="320" tfoot_id="total_barcode_no" tfoot_value="{$rs.detail_total.total_produc}"}
	<input type="hidden" onchange="getWarehouseIdById(this);return false;" name="detail[{$index}][location_id]" id="location_id" value="{$item.location_id}" class="w200">
	<input type="text" name="temp[{$index}][barcode_no]" value="{$item.barcode_no}" url="{'AutoComplete/adjustLocationNo'|U}" jqac class="w200" {$readonly}>
	{/td}

	{td type="flow_quantity" view="dml_quantity"  width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot_id="total_quantity" class="t_right"}
	<input type="text" name="detail[{$index}][quantity]" class="w100" id="quantity" value="{$item.edml_quantity}" row_total {$readonly}>
	{/td}

	{detail_operation}
</tr>
{/detail_table}