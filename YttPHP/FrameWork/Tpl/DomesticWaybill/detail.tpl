{if $smarty.const.ACTION_NAME == 'add'}
    {assign var=thead   value=[$lang.product_id,$lang.product_no,$lang.location_no,$lang.quantity,$lang.number_of_scans]}
{else}
    {assign var=thead   value=[$lang.product_id,$lang.product_no,$lang.location_no,$lang.number_of_scans]}
{/if}
{detail_table id='detail_table' flow='DomesticWaybill' from=$rs.detail action=['view','edit'] op_show=['add','edit'] 
	warehouse=true
	thead=$thead}
<tr index="{$index}" class="{$none}" class="t_left">
    <input type="hidden" name="detail[{$index}][warehouse_id]" id="warehouse_id" value="{$item.warehouse_id}" jqproc class="w100">
        
	{td type="product_id" id="span_product_id" view="product_id" width="" width="56" class="t_left"}
        <input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqproc class="w100">
        <input type="text" name="temp[{$index}][product_id]" value="{$item.product_id}" class="w100 disabled" row_total readonly>
	{/td}
	
	{td id="span_product_no" class="t_left" view="product_no" width="320" tfoot_id="total_product" tfoot_value="{$rs.detail_total.total_produc}"}
	<input type="hidden" name="detail[{$index}][product_no]" id="product_no" value="{$item.product_no}" jqproc class="w100">
        {$item.product_no}
           
	{/td}

	{td id="span_location_no" class="t_left" view="barcode_no" width="320" tfoot_id="total_barcode_no" tfoot_value="{$rs.detail_total.total_produc}"}
        <input type="hidden" onchange="getWarehouseIdById(this);return false;" name="detail[{$index}][location_id]" id="location_id" value="{$item.location_id}" class="w200">
        <input type="text" name="temp[{$index}][barcode_no]" value="{$item.barcode_no}" class="w200 disabled"  readonly>
	{/td}
    {if $smarty.const.ACTION_NAME == 'add'}
        {td view="dml_storage_quantity"  width="56" class="t_right"}
            <input type="text" name="detail[{$index}][storage_quantity]" class="w100 disabled" id="storage_quantity" value="{$item.edml_storage_quantity}"  readonly>
        {/td}
    {/if}
	{td view="dml_quantity"  width="56" class="t_right"}
        <input type="text" name="detail[{$index}][quantity]" class="w100" id="quantity" value="{$item.edml_quantity}" >
	{/td}
	
	{detail_operation}
</tr>
{/detail_table}