{if $rs.import}
<script>
$(document).ready(function(){
	$dom.find(".detail_list tr:visible").each(function(){
		$(this).find("#autoshow_img").attr("onclick","$.autoShow(this,'ShiftWarehouse')");
	    var out_location_id    =   $(this).find("#out_location_id").val();
	    if(!out_location_id){
	        $(this).find("#product_id").trigger("change");
	    }	   
	});
});
</script>
{/if}
{detail_table flow='ShiftWarehouse' from=$rs.detail action=['view','edit'] op_show=['add','edit'] 
	warehouse=true
	thead=[$lang.product_barcode,$lang.product_no,$lang.out_location_no,$lang.in_location_no,$lang.quantity]}
<tr index="{$index}" class="{$none}" class="t_left">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	<input type="hidden" name="detail[{$index}][out_warehouse_id]" id="out_warehouse_id" value="{$item.out_warehouse_id}">
	<input type="hidden" name="detail[{$index}][in_warehouse_id]" id="in_warehouse_id" value="{$item.in_warehouse_id}">
    
	{td type="product_barcode" id="span_product_barcode" view="custom_barcode" width="" width="56" class="t_left"}
	<input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" onchange="shiftOutLocation(this,'{$smarty.const.ACTION_NAME}');" jqproc class="w100">
	<input type="text" name="temp[{$index}][product_barcode]" value="{$item.custom_barcode}" url="{'AutoComplete/productBarcode'|U}" jqac class="w100" {$readonly}>
	{/td}
	
	{td id="span_product_no" class="t_left" view="product_no" width="320" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}"}
	{$item.product_no}
	{/td}


	{td id="span_location_no" class="t_left" view="out_barcode_no" width="320" tfoot_id="total_barcode_no" tfoot_value="{$rs.detail_total.total_produc}"}
	<input type="hidden" name="detail[{$index}][out_location_id]" onchange="getWarehouseIdByLocation(this,'out_warehouse_id');shiftInLocation(this);" id="out_location_id" value="{$item.out_location_id}" class="w200">
	<input type="text" name="temp[{$index}][out_barcode_no]" value="{$item.out_barcode_no}" {if $item.out_warehouse_id>0}where='product_id={$item.product_id}'{/if} url="{'AutoComplete/ShiftWarehouseLocation'|U}" jqac class="w200" {$readonly}>
	{/td}
    
    {td id="span_location_no" class="t_left" view="in_barcode_no" width="320" tfoot_id="total_barcode_no" tfoot_value="{$rs.detail_total.total_produc}"}
        <input type="hidden" name="detail[{$index}][in_location_id]" onchange="getWarehouseIdByLocation(this,'in_warehouse_id')" id="in_location_id" value="{$item.in_location_id}" class="w200">
        <input type="text" name="temp[{$index}][in_barcode_no]" value="{$item.in_barcode_no}" {if $item.out_warehouse_id>0}where='warehouse_id in({$item.out_warehouse_id}_warehouse_id)'{/if} url="{'AutoComplete/shiftWarehouseInLocationNo'|U}" jqac class="w200" {$readonly}>
	{/td}

	{td type="flow_quantity" view="dml_quantity"  width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot_id="total_quantity" class="t_right"}
	<input type="text" name="detail[{$index}][quantity]" class="w100" id="quantity" value="{$item.edml_quantity}" row_total {$readonly}>
	{/td}
	
	{detail_operation}
</tr>
{/detail_table}